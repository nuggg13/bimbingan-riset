<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CatatanBimbingan;
use App\Models\UpdateProgress;
use App\Models\Peserta;
use Illuminate\Support\Facades\DB;

class CatatanBimbinganController extends Controller
{
    public function index()
    {
        $catatanBimbingan = CatatanBimbingan::with(['peserta', 'updateProgress'])
            ->orderBy('tanggal_bimbingan', 'desc')
            ->paginate(10);

        return view('admin.catatan-bimbingan.index', compact('catatanBimbingan'));
    }

    public function create()
    {
        $peserta = Peserta::with('pendaftaran')->get();
        return view('admin.catatan-bimbingan.create', compact('peserta'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_peserta' => 'required|exists:peserta,id_peserta',
            'tanggal_bimbingan' => 'required|date',
            'hasil_bimbingan' => 'required|string',
            'tugas_perbaikan' => 'required|string',
            'catatan_tambahan' => 'nullable|string',
            'status' => 'required|in:draft,published,reviewed,completed',
        ]);

        $catatan = CatatanBimbingan::create($request->all());

        return redirect()->route('admin.catatan-bimbingan.show', $catatan->id_catatan)
            ->with('success', 'Catatan bimbingan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $catatan = CatatanBimbingan::with(['peserta.pendaftaran', 'updateProgress'])
            ->findOrFail($id);

        return view('admin.catatan-bimbingan.show', compact('catatan'));
    }

    public function edit($id)
    {
        $catatan = CatatanBimbingan::findOrFail($id);
        $peserta = Peserta::with('pendaftaran')->get();
        
        return view('admin.catatan-bimbingan.edit', compact('catatan', 'peserta'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_peserta' => 'required|exists:peserta,id_peserta',
            'tanggal_bimbingan' => 'required|date',
            'hasil_bimbingan' => 'required|string',
            'tugas_perbaikan' => 'required|string',
            'catatan_tambahan' => 'nullable|string',
            'status' => 'required|in:draft,published,reviewed,completed',
        ]);

        $catatan = CatatanBimbingan::findOrFail($id);
        $catatan->update($request->all());

        return redirect()->route('admin.catatan-bimbingan.show', $catatan->id_catatan)
            ->with('success', 'Catatan bimbingan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $catatan = CatatanBimbingan::findOrFail($id);
        
        // Delete related progress updates first
        $catatan->updateProgress()->delete();
        
        $catatan->delete();

        return redirect()->route('admin.catatan-bimbingan.index')
            ->with('success', 'Catatan bimbingan berhasil dihapus.');
    }

    public function addProgress(Request $request, $id)
    {
        $request->validate([
            'tanggal_update' => 'required|date',
            'deskripsi_progress' => 'required|string',
            'persentase' => 'required|numeric|min:0|max:100',
        ]);

        $catatan = CatatanBimbingan::findOrFail($id);

        UpdateProgress::create([
            'id_catatan' => $catatan->id_catatan,
            'tanggal_update' => $request->tanggal_update,
            'deskripsi_progress' => $request->deskripsi_progress,
            'persentase' => $request->persentase,
            'created_at' => now(),
        ]);

        return redirect()->route('admin.catatan-bimbingan.show', $catatan->id_catatan)
            ->with('success', 'Progress berhasil ditambahkan.');
    }

    public function updateProgress(Request $request, $catatanId, $progressId)
    {
        $request->validate([
            'tanggal_update' => 'required|date',
            'deskripsi_progress' => 'required|string',
            'persentase' => 'required|numeric|min:0|max:100',
        ]);

        $progress = UpdateProgress::where('id_progress', $progressId)
            ->where('id_catatan', $catatanId)
            ->firstOrFail();

        $progress->update([
            'tanggal_update' => $request->tanggal_update,
            'deskripsi_progress' => $request->deskripsi_progress,
            'persentase' => $request->persentase,
        ]);

        return redirect()->route('admin.catatan-bimbingan.show', $catatanId)
            ->with('success', 'Progress berhasil diperbarui.');
    }

    public function deleteProgress($catatanId, $progressId)
    {
        $progress = UpdateProgress::where('id_progress', $progressId)
            ->where('id_catatan', $catatanId)
            ->firstOrFail();

        $progress->delete();

        return redirect()->route('admin.catatan-bimbingan.show', $catatanId)
            ->with('success', 'Progress berhasil dihapus.');
    }

    public function export()
    {
        $catatanBimbingan = CatatanBimbingan::with(['peserta', 'updateProgress'])->get();

        $filename = 'catatan_bimbingan_' . date('Y-m-d_H-i-s') . '.csv';
        
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