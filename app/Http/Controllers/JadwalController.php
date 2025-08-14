<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Pendaftaran;
use App\Models\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $query = Jadwal::with(['pendaftaran.peserta', 'mentor'])->orderByDesc('created_at');
        
        // Filter berdasarkan status
        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }
        
        // Filter berdasarkan mentor
        if ($request->filled('mentor') && $request->mentor !== 'semua') {
            $query->where('id_mentor', $request->mentor);
        }
        
        // Pencarian berdasarkan nama peserta atau mentor
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('pendaftaran.peserta', function($subQ) use ($search) {
                    $subQ->where('nama', 'like', "%{$search}%");
                })
                ->orWhereHas('mentor', function($subQ) use ($search) {
                    $subQ->where('nama', 'like', "%{$search}%");
                });
            });
        }
        
        $jadwal = $query->paginate(10)->withQueryString();
        
        // Data untuk dropdown filter
        $statusOptions = [
            'semua' => 'Semua Status',
            'scheduled' => 'Terjadwal',
            'ongoing' => 'Berlangsung',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan'
        ];
        
        $mentorOptions = ['semua' => 'Semua Mentor'] + Mentor::orderBy('nama')->pluck('nama', 'id_mentor')->toArray();
        
        // Cache statistik untuk performa yang lebih baik
        $statistics = Cache::remember('jadwal_statistics', 300, function () {
            return [
                'total' => Jadwal::count(),
                'scheduled' => Jadwal::where('status', 'scheduled')->count(),
                'ongoing' => Jadwal::where('status', 'ongoing')->count(),
                'completed' => Jadwal::where('status', 'completed')->count(),
                'cancelled' => Jadwal::where('status', 'cancelled')->count(),
                'today' => Jadwal::whereDate('tanggal_mulai', '<=', today())
                    ->whereDate('tanggal_akhir', '>=', today())
                    ->where('status', 'ongoing')
                    ->count(),
            ];
        });
        
        return view('admin.jadwal.index', compact('jadwal', 'statusOptions', 'mentorOptions', 'statistics'));
    }

    public function create()
    {
        $pendaftaran = Pendaftaran::with('peserta')
            ->where('status', 'diterima')
            ->whereDoesntHave('jadwal')
            ->orderBy('created_at', 'desc')
            ->get();
            
        $mentors = Mentor::orderBy('nama')->get();
        
        return view('admin.jadwal.create', compact('pendaftaran', 'mentors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pendaftaran' => 'required|exists:pendaftaran,id_pendaftaran',
            'id_mentor' => 'required|exists:mentor,id_mentor',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_akhir' => 'required|date|after:tanggal_mulai',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_akhir' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        try {
            DB::beginTransaction();

            // Cek apakah sudah ada jadwal untuk pendaftaran ini
            $existingSchedule = Jadwal::where('id_pendaftaran', $request->id_pendaftaran)->first();
            if ($existingSchedule) {
                return back()->withErrors(['id_pendaftaran' => 'Pendaftaran ini sudah memiliki jadwal.']);
            }

            // Determine schedule status based on dates
            $tanggalMulai = Carbon::parse($request->tanggal_mulai);
            $tanggalAkhir = Carbon::parse($request->tanggal_akhir);
            $today = Carbon::today();
            
            $scheduleStatus = $this->determineScheduleStatus($tanggalMulai, $tanggalAkhir, $today);

            // Create schedule
            Jadwal::create([
                'id_pendaftaran' => $request->id_pendaftaran,
                'id_mentor' => $request->id_mentor,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_akhir' => $request->tanggal_akhir,
                'jam_mulai' => $request->jam_mulai,
                'jam_akhir' => $request->jam_akhir,
                'status' => $scheduleStatus
            ]);

            // Clear cache
            Cache::forget('jadwal_statistics');

            DB::commit();

            return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil dibuat.');
            
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Terjadi kesalahan saat membuat jadwal: ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $jadwal = Jadwal::with(['pendaftaran.peserta', 'mentor'])->where('id_jadwal', $id)->firstOrFail();
        
        return view('admin.jadwal.show', compact('jadwal'));
    }

    public function edit($id)
    {
        $jadwal = Jadwal::with(['pendaftaran.peserta', 'mentor'])->where('id_jadwal', $id)->firstOrFail();
        $mentors = Mentor::orderBy('nama')->get();
        
        return view('admin.jadwal.edit', compact('jadwal', 'mentors'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_mentor' => 'required|exists:mentor,id_mentor',
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after:tanggal_mulai',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_akhir' => 'required|date_format:H:i|after:jam_mulai',
            'status' => 'required|in:scheduled,ongoing,completed,cancelled'
        ]);

        try {
            DB::beginTransaction();

            $jadwal = Jadwal::where('id_jadwal', $id)->firstOrFail();
            
            // Update jadwal
            $jadwal->update([
                'id_mentor' => $request->id_mentor,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_akhir' => $request->tanggal_akhir,
                'jam_mulai' => $request->jam_mulai,
                'jam_akhir' => $request->jam_akhir,
                'status' => $request->status
            ]);

            // Clear cache
            Cache::forget('jadwal_statistics');

            DB::commit();

            return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil diperbarui.');
            
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui jadwal: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $jadwal = Jadwal::where('id_jadwal', $id)->firstOrFail();
            $jadwal->delete();

            // Clear cache
            Cache::forget('jadwal_statistics');

            DB::commit();

            return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil dihapus.');
            
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menghapus jadwal: ' . $e->getMessage()]);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:scheduled,ongoing,completed,cancelled',
        ]);

        try {
            $jadwal = Jadwal::where('id_jadwal', $id)->firstOrFail();
            
            $oldStatus = $jadwal->status;
            $jadwal->status = $request->status;
            $jadwal->save();

            // Clear cache
            Cache::forget('jadwal_statistics');

            $statusLabels = [
                'scheduled' => 'Terjadwal',
                'ongoing' => 'Berlangsung',
                'completed' => 'Selesai',
                'cancelled' => 'Dibatalkan'
            ];
            
            $namaPeserta = $jadwal->pendaftaran->peserta->nama ?? 'Peserta';
            $statusLabel = $statusLabels[$request->status] ?? $request->status;
            
            $successMessage = "Status jadwal {$namaPeserta} berhasil diubah menjadi {$statusLabel}.";
            
            return response()->json([
                'success' => true,
                'message' => $successMessage,
                'reload' => true
            ]);
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan saat mengubah status: ' . $e->getMessage()], 500);
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

    public function export(Request $request)
    {
        $query = Jadwal::with(['pendaftaran.peserta', 'mentor'])->orderByDesc('created_at');
        
        // Filter berdasarkan status
        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }
        
        // Filter berdasarkan mentor
        if ($request->filled('mentor') && $request->mentor !== 'semua') {
            $query->where('id_mentor', $request->mentor);
        }
        
        // Pencarian berdasarkan nama peserta atau mentor
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('pendaftaran.peserta', function($subQ) use ($search) {
                    $subQ->where('nama', 'like', "%{$search}%");
                })
                ->orWhereHas('mentor', function($subQ) use ($search) {
                    $subQ->where('nama', 'like', "%{$search}%");
                });
            });
        }
        
        $jadwal = $query->get();
        
        $filename = 'jadwal_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($jadwal) {
            $file = fopen('php://output', 'w');
            
            // Header CSV
            fputcsv($file, [
                'ID Jadwal',
                'Nama Peserta',
                'Judul Riset',
                'Nama Mentor',
                'Tanggal Mulai',
                'Tanggal Akhir',
                'Jam Mulai',
                'Jam Akhir',
                'Status',
                'Tanggal Dibuat',
                'Tanggal Diubah'
            ]);
            
            // Data
            foreach ($jadwal as $row) {
                fputcsv($file, [
                    $row->id_jadwal,
                    $row->pendaftaran->peserta->nama ?? 'N/A',
                    $row->pendaftaran->judul_riset ?? 'N/A',
                    $row->mentor->nama ?? 'N/A',
                    $row->tanggal_mulai ? Carbon::parse($row->tanggal_mulai)->format('d/m/Y') : 'N/A',
                    $row->tanggal_akhir ? Carbon::parse($row->tanggal_akhir)->format('d/m/Y') : 'N/A',
                    $row->jam_mulai ?? 'N/A',
                    $row->jam_akhir ?? 'N/A',
                    $row->status ?? 'scheduled',
                    $row->created_at ? $row->created_at->format('d/m/Y H:i') : 'N/A',
                    $row->updated_at ? $row->updated_at->format('d/m/Y H:i') : 'N/A'
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}