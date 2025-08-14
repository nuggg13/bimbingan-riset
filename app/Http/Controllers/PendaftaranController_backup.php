<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Jadwal;
use App\Models\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PendaftaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pendaftaran::with(['peserta', 'jadwal.mentor'])->orderByDesc('created_at');
        
        // Filter berdasarkan status
        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }
        
        // Pencarian berdasarkan nama peserta atau judul riset
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul_riset', 'like', "%{$search}%")
                  ->orWhereHas('peserta', function($subQ) use ($search) {
                      $subQ->where('nama', 'like', "%{$search}%");
                  });
            });
        }
        
        $pendaftaran = $query->paginate(10)->withQueryString();
        
        // Data untuk dropdown filter
        $statusOptions = [
            'semua' => 'Semua Status',
            'diterima' => 'Diterima',
            'ditolak' => 'Ditolak',
            'pending' => 'Pending',
            'review' => 'Review',
            'konsultasi' => 'Konsultasi'
        ];
        
        // Cache statistik untuk performa yang lebih baik
        $statistics = Cache::remember('pendaftaran_statistics', 300, function () {
            return [
                'total' => Pendaftaran::count(),
                'pending' => Pendaftaran::where('status', 'pending')->count(),
                'review' => Pendaftaran::where('status', 'review')->count(),
                'konsultasi' => Pendaftaran::where('status', 'konsultasi')->count(),
                'diterima' => Pendaftaran::where('status', 'diterima')->count(),
                'ditolak' => Pendaftaran::where('status', 'ditolak')->count(),
                'with_wa' => Pendaftaran::whereHas('peserta', function($q) {
                    $q->whereNotNull('nomor_wa')->where('nomor_wa', '!=', '');
                })->count(),
            ];
        });
        
        return view('admin.pendaftaran.index', compact('pendaftaran', 'statusOptions', 'statistics'));
    }

    public function updateStatus(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'status' => 'required|in:diterima,ditolak,pending,review,konsultasi',
        ]);

        try {
            // Find the pendaftaran record
            $pendaftaran = Pendaftaran::where('id_pendaftaran', $id)->first();
            
            if (!$pendaftaran) {
                return response()->json(['error' => 'Data pendaftaran tidak ditemukan.'], 404);
            }

            // Store old status for comparison
            $oldStatus = $pendaftaran->status;
            
            // Jika status diubah menjadi "diterima" dan sebelumnya bukan "diterima"
            if ($request->status === 'diterima' && $oldStatus !== 'diterima') {
                // Cek apakah sudah ada jadwal
                $existingSchedule = Jadwal::where('id_pendaftaran', $pendaftaran->id_pendaftaran)->first();
                
                if (!$existingSchedule) {
                    // Jika belum ada jadwal, return dengan flag untuk menampilkan modal
                    $mentors = Mentor::orderBy('nama')->get();
                    return response()->json([
                        'show_schedule_modal' => true,
                        'pendaftaran' => $pendaftaran,
                        'mentors' => $mentors,
                        'peserta_nama' => $pendaftaran->peserta->nama ?? 'Peserta'
                    ]);
                }
            }
            
            // Update the status
            $pendaftaran->status = $request->status;
            $pendaftaran->save();

            // Clear cache
            Cache::forget('pendaftaran_statistics');

            $statusLabels = [
                'diterima' => 'Diterima',
                'ditolak' => 'Ditolak', 
                'pending' => 'Pending',
                'review' => 'Review',
                'konsultasi' => 'Konsultasi'
            ];
            
            $namaPeserta = $pendaftaran->peserta->nama ?? 'Peserta';
            $statusLabel = $statusLabels[$request->status] ?? $request->status;
            
            $successMessage = "Status pendaftaran {$namaPeserta} berhasil diubah dari {$oldStatus} menjadi {$statusLabel}.";
            
            return response()->json([
                'success' => true,
                'message' => $successMessage,
                'reload' => true
            ]);
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan saat mengubah status: ' . $e->getMessage()], 500);
        }
    }

    public function createSchedule(Request $request, $id)
    {
        $request->validate([
            'id_mentor' => 'required|exists:mentor,id_mentor',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_akhir' => 'required|date|after:tanggal_mulai',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_akhir' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        try {
            DB::beginTransaction();

            // Find the pendaftaran record
            $pendaftaran = Pendaftaran::where('id_pendaftaran', $id)->first();
            
            if (!$pendaftaran) {
                return response()->json(['error' => 'Data pendaftaran tidak ditemukan.'], 404);
            }

            // Update status to diterima
            $pendaftaran->status = 'diterima';
            $pendaftaran->save();

            // Determine schedule status based on dates
            $tanggalMulai = \Carbon\Carbon::parse($request->tanggal_mulai);
            $tanggalAkhir = \Carbon\Carbon::parse($request->tanggal_akhir);
            $today = \Carbon\Carbon::today();
            
            $scheduleStatus = $this->determineScheduleStatus($tanggalMulai, $tanggalAkhir, $today);

            // Create schedule
            Jadwal::create([
                'id_pendaftaran' => $pendaftaran->id_pendaftaran,
                'id_mentor' => $request->id_mentor,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_akhir' => $request->tanggal_akhir,
                'jam_mulai' => $request->jam_mulai,
                'jam_akhir' => $request->jam_akhir,
                'status' => $scheduleStatus
            ]);

            // Clear cache
            Cache::forget('pendaftaran_statistics');

            DB::commit();

            $mentor = Mentor::find($request->id_mentor);
            $namaPeserta = $pendaftaran->peserta->nama ?? 'Peserta';
            
            return response()->json([
                'success' => true,
                'message' => "Status pendaftaran {$namaPeserta} berhasil diubah menjadi Diterima dan jadwal bimbingan dengan mentor {$mentor->nama} telah dibuat dengan status {$scheduleStatus}."
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Terjadi kesalahan saat membuat jadwal: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Determine schedule status based on dates
     */
    private function determineScheduleStatus($tanggalMulai, $tanggalAkhir, $today)
    {
        // completed: tanggal_akhir sudah kelewat
        if ($tanggalAkhir->lt($today)) {
            return 'completed';
        }
        
        // ongoing: sudah tanggal_mulai tapi belum tanggal_akhir
        if ($tanggalMulai->lte($today) && $tanggalAkhir->gte($today)) {
            return 'ongoing';
        }
        
        // scheduled: tanggal_mulai masih di masa depan
        if ($tanggalMulai->gt($today)) {
            return 'scheduled';
        }
        
        // default fallback
        return 'scheduled';
    }

    /**
     * Create schedule for accepted registration
     */
    private function createScheduleForAcceptedRegistration($pendaftaran)
    {
        // Cek apakah sudah ada jadwal untuk pendaftaran ini
        $existingSchedule = Jadwal::where('id_pendaftaran', $pendaftaran->id_pendaftaran)->first();
        
        if ($existingSchedule) {
            // Jika sudah ada jadwal, update statusnya berdasarkan tanggal
            $tanggalMulai = \Carbon\Carbon::parse($existingSchedule->tanggal_mulai);
            $tanggalAkhir = \Carbon\Carbon::parse($existingSchedule->tanggal_akhir);
            $today = \Carbon\Carbon::today();
            
            $existingSchedule->status = $this->determineScheduleStatus($tanggalMulai, $tanggalAkhir, $today);
            $existingSchedule->save();
            return;
        }

        // Cari mentor yang tersedia berdasarkan keahlian atau random
        $mentor = $this->findAvailableMentor($pendaftaran);
        
        if (!$mentor) {
            throw new \Exception('Tidak ada mentor yang tersedia saat ini.');
        }

        // Set tanggal mulai (hari ini + 3 hari kerja)
        $tanggalMulai = now()->addWeekdays(3);
        
        // Set tanggal akhir (1 bulan dari tanggal mulai)
        $tanggalAkhir = $tanggalMulai->copy()->addMonth();
        
        // Set jam default (09:00 - 17:00)
        $jamMulai = '09:00';
        $jamAkhir = '17:00';

        // Determine status
        $scheduleStatus = $this->determineScheduleStatus($tanggalMulai, $tanggalAkhir, \Carbon\Carbon::today());

        // Buat jadwal baru
        Jadwal::create([
            'id_pendaftaran' => $pendaftaran->id_pendaftaran,
            'id_mentor' => $mentor->id_mentor,
            'tanggal_mulai' => $tanggalMulai->format('Y-m-d'),
            'tanggal_akhir' => $tanggalAkhir->format('Y-m-d'),
            'jam_mulai' => $jamMulai,
            'jam_akhir' => $jamAkhir,
            // 'hari' => $,
            'status' => $scheduleStatus
        ]);
    }

    /**
     * Find available mentor for the registration
     */
    private function findAvailableMentor($pendaftaran)
    {
        // Strategi 1: Cari mentor berdasarkan keahlian yang sesuai dengan minat keilmuan
        $minatKeilmuan = strtolower($pendaftaran->minat_keilmuan);
        
        $mentor = Mentor::where(function($query) use ($minatKeilmuan) {
            $query->whereRaw('LOWER(keahlian) LIKE ?', ["%{$minatKeilmuan}%"]);
        })
        ->whereDoesntHave('jadwal', function($query) {
            // Cari mentor yang tidak memiliki terlalu banyak jadwal aktif (maksimal 5)
            $query->whereIn('status', ['ongoing', 'scheduled'])
                  ->havingRaw('COUNT(*) >= 5');
        })
        ->first();

        // Strategi 2: Jika tidak ada mentor yang sesuai, cari mentor dengan beban kerja paling sedikit
        if (!$mentor) {
            $mentor = Mentor::withCount(['jadwal' => function($query) {
                $query->whereIn('status', ['ongoing', 'scheduled']);
            }])
            ->orderBy('jadwal_count', 'asc')
            ->first();
        }

        return $mentor;
    }

    public function export(Request $request)
    {
        $query = Pendaftaran::with('peserta')->orderByDesc('created_at');
        
        // Filter berdasarkan status
        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }
        
        // Pencarian berdasarkan nama peserta atau judul riset
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul_riset', 'like', "%{$search}%")
                  ->orWhereHas('peserta', function($subQ) use ($search) {
                      $subQ->where('nama', 'like', "%{$search}%");
                  });
            });
        }
        
        $pendaftaran = $query->get();
        
        $filename = 'pendaftaran_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($pendaftaran) {
            $file = fopen('php://output', 'w');
            
            // Header CSV
            fputcsv($file, [
                'ID Pendaftaran',
                'Nama Peserta',
                'Fakultas',
                'Instansi',
                'WhatsApp',
                'Judul Riset',
                'Minat Keilmuan',
                'Berbasis',
                'Status',
                'Tanggal Dibuat',
                'Tanggal Diubah'
            ]);
            
            // Data
            foreach ($pendaftaran as $row) {
                fputcsv($file, [
                    $row->id_pendaftaran,
                    $row->peserta->nama ?? 'N/A',
                    $row->peserta->fakultas ?? 'N/A',
                    $row->peserta->instansi ?? 'N/A',
                    $row->peserta->nomor_wa ?? 'N/A',
                    $row->judul_riset,
                    $row->minat_keilmuan,
                    $row->basis_sistem ?? 'N/A',
                    $row->status ?? 'pending',
                    $row->created_at ? $row->created_at->format('d/m/Y H:i') : 'N/A',
                    $row->updated_at ? $row->updated_at->format('d/m/Y H:i') : 'N/A'
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}