<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CatatanBimbingan;
use App\Models\UpdateProgress;
use App\Models\Peserta;
use App\Models\Jadwal;

class MentorCatatanBimbinganController extends Controller
{
    public function index()
    {
        $mentor = Auth::guard('mentor')->user();
        
        // Get participants being mentored by this mentor
        $participantIds = Peserta::whereHas('pendaftaran.jadwals', function($query) use ($mentor) {
            $query->where('id_mentor', $mentor->id_mentor);
        })->pluck('id_peserta');

        // Get only the latest note per participant
        $catatanBimbingan = CatatanBimbingan::with(['peserta', 'updateProgress'])
            ->whereIn('id_peserta', $participantIds)
            ->whereIn('id_catatan', function($query) use ($participantIds) {
                $query->select(\DB::raw('MAX(id_catatan)'))
                    ->from('catatan_bimbingan')
                    ->whereIn('id_peserta', $participantIds)
                    ->groupBy('id_peserta');
            })
            ->orderBy('tanggal_bimbingan', 'desc')
            ->paginate(10);

        return view('mentor.catatan-bimbingan.index', compact('catatanBimbingan', 'mentor'));
    }

    public function create()
    {
        $mentor = Auth::guard('mentor')->user();
        
        // Get only participants being mentored by this mentor
        $peserta = Peserta::whereHas('pendaftaran.jadwals', function($query) use ($mentor) {
            $query->where('id_mentor', $mentor->id_mentor);
        })
        ->with('pendaftaran')
        ->get();

        return view('mentor.catatan-bimbingan.create', compact('peserta', 'mentor'));
    }

    public function store(Request $request)
    {
        $mentor = Auth::guard('mentor')->user();
        
        $request->validate([
            'id_peserta' => 'required|exists:peserta,id_peserta',
            'tanggal_bimbingan' => 'required|date',
            'hasil_bimbingan' => 'required|string',
            'tugas_perbaikan' => 'required|string',
            'catatan_tambahan' => 'nullable|string',
            'status' => 'required|in:draft,published,reviewed,completed',
        ]);

        // Verify mentor has access to this participant
        $hasAccess = Peserta::whereHas('pendaftaran.jadwals', function($query) use ($mentor) {
            $query->where('id_mentor', $mentor->id_mentor);
        })->where('id_peserta', $request->id_peserta)->exists();

        if (!$hasAccess) {
            abort(403, 'Anda tidak memiliki akses ke peserta ini.');
        }

        $catatan = CatatanBimbingan::create($request->all());

        return redirect()->route('mentor.catatan-bimbingan.show', $catatan->id_catatan)
            ->with('success', 'Catatan bimbingan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $mentor = Auth::guard('mentor')->user();
        
        $catatan = CatatanBimbingan::with(['peserta.pendaftaran', 'updateProgress'])
            ->findOrFail($id);

        // Verify mentor has access to this participant
        $hasAccess = Peserta::whereHas('pendaftaran.jadwals', function($query) use ($mentor) {
            $query->where('id_mentor', $mentor->id_mentor);
        })->where('id_peserta', $catatan->id_peserta)->exists();

        if (!$hasAccess) {
            abort(403, 'Anda tidak memiliki akses ke catatan ini.');
        }

        return view('mentor.catatan-bimbingan.show', compact('catatan', 'mentor'));
    }

    public function edit($id)
    {
        $mentor = Auth::guard('mentor')->user();
        
        $catatan = CatatanBimbingan::findOrFail($id);
        
        // Verify mentor has access to this participant
        $hasAccess = Peserta::whereHas('pendaftaran.jadwals', function($query) use ($mentor) {
            $query->where('id_mentor', $mentor->id_mentor);
        })->where('id_peserta', $catatan->id_peserta)->exists();

        if (!$hasAccess) {
            abort(403, 'Anda tidak memiliki akses ke catatan ini.');
        }

        $peserta = Peserta::whereHas('pendaftaran.jadwals', function($query) use ($mentor) {
            $query->where('id_mentor', $mentor->id_mentor);
        })
        ->with('pendaftaran')
        ->get();
        
        return view('mentor.catatan-bimbingan.edit', compact('catatan', 'peserta', 'mentor'));
    }

    public function update(Request $request, $id)
    {
        $mentor = Auth::guard('mentor')->user();
        
        $request->validate([
            'id_peserta' => 'required|exists:peserta,id_peserta',
            'tanggal_bimbingan' => 'required|date',
            'hasil_bimbingan' => 'required|string',
            'tugas_perbaikan' => 'required|string',
            'catatan_tambahan' => 'nullable|string',
            'status' => 'required|in:draft,published,reviewed,completed',
        ]);

        $catatan = CatatanBimbingan::findOrFail($id);
        
        // Verify mentor has access to this participant
        $hasAccess = Peserta::whereHas('pendaftaran.jadwals', function($query) use ($mentor) {
            $query->where('id_mentor', $mentor->id_mentor);
        })->where('id_peserta', $catatan->id_peserta)->exists();

        if (!$hasAccess) {
            abort(403, 'Anda tidak memiliki akses ke catatan ini.');
        }

        $catatan->update($request->all());

        return redirect()->route('mentor.catatan-bimbingan.show', $catatan->id_catatan)
            ->with('success', 'Catatan bimbingan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $mentor = Auth::guard('mentor')->user();
        
        $catatan = CatatanBimbingan::findOrFail($id);
        
        // Verify mentor has access to this participant
        $hasAccess = Peserta::whereHas('pendaftaran.jadwals', function($query) use ($mentor) {
            $query->where('id_mentor', $mentor->id_mentor);
        })->where('id_peserta', $catatan->id_peserta)->exists();

        if (!$hasAccess) {
            abort(403, 'Anda tidak memiliki akses ke catatan ini.');
        }
        
        // Delete related progress updates first
        $catatan->updateProgress()->delete();
        
        $catatan->delete();

        return redirect()->route('mentor.catatan-bimbingan.index')
            ->with('success', 'Catatan bimbingan berhasil dihapus.');
    }

    public function addProgress(Request $request, $id)
    {
        $mentor = Auth::guard('mentor')->user();
        
        $request->validate([
            'deskripsi_progress' => 'required|string',
            'persentase' => 'required|numeric|min:0|max:100',
        ]);

        $catatan = CatatanBimbingan::findOrFail($id);
        
        // Verify mentor has access to this participant
        $hasAccess = Peserta::whereHas('pendaftaran.jadwals', function($query) use ($mentor) {
            $query->where('id_mentor', $mentor->id_mentor);
        })->where('id_peserta', $catatan->id_peserta)->exists();

        if (!$hasAccess) {
            abort(403, 'Anda tidak memiliki akses ke catatan ini.');
        }

        UpdateProgress::create([
            'id_catatan' => $catatan->id_catatan,
            'tanggal_update' => now()->toDateString(), // Automatically set to today
            'deskripsi_progress' => $request->deskripsi_progress,
            'persentase' => $request->persentase,
            'created_at' => now(),
        ]);

        return redirect()->route('mentor.catatan-bimbingan.show', $catatan->id_catatan)
            ->with('success', 'Progress berhasil ditambahkan.');
    }

    
    public function export()
    {
        $mentor = Auth::guard('mentor')->user();
        
        // Get participants being mentored by this mentor
        $participantIds = Peserta::whereHas('pendaftaran.jadwals', function($query) use ($mentor) {
            $query->where('id_mentor', $mentor->id_mentor);
        })->pluck('id_peserta');

        $catatanBimbingan = CatatanBimbingan::with(['peserta', 'updateProgress'])
            ->whereIn('id_peserta', $participantIds)
            ->get();

        $filename = 'catatan_bimbingan_mentor_' . $mentor->nama . '_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($catatanBimbingan) {
            $file = fopen('php://output', 'w');
            
            // CSV Headers
            fputcsv($file, [
                'ID Catatan',
                'Nama Peserta',
                'Tanggal Bimbingan',
                'Hasil Bimbingan',
                'Tugas Perbaikan',
                'Catatan Tambahan',
                'Status',
                'Progress Terakhir (%)',
                'Dibuat Pada'
            ]);

            foreach ($catatanBimbingan as $catatan) {
                fputcsv($file, [
                    $catatan->id_catatan,
                    $catatan->peserta->nama,
                    $catatan->tanggal_bimbingan->format('d/m/Y'),
                    $catatan->hasil_bimbingan,
                    $catatan->tugas_perbaikan,
                    $catatan->catatan_tambahan,
                    $catatan->status_label,
                    $catatan->total_progress_percentage,
                    $catatan->created_at->format('d/m/Y H:i')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}