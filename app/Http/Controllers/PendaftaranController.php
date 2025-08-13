<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PendaftaranController extends Controller
{
    public function index(Request $request)
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

    public function updateStatus(Request $request, Pendaftaran $pendaftaran)
    {
        $validated = $request->validate([
            'status' => 'required|in:diterima,ditolak,pending,review,konsultasi',
        ]);

        $pendaftaran->status = $validated['status'];
        $pendaftaran->save();

        // Clear cache setelah update status
        Cache::forget('pendaftaran_statistics');

        $statusLabels = [
            'diterima' => 'Diterima',
            'ditolak' => 'Ditolak', 
            'pending' => 'Pending',
            'review' => 'Review',
            'konsultasi' => 'Konsultasi'
        ];
        
        $namaPeserta = $pendaftaran->peserta->nama ?? 'Peserta';
        $statusLabel = $statusLabels[$validated['status']] ?? $validated['status'];
        
        return redirect()->back()->with('success', "Status pendaftaran {$namaPeserta} berhasil diubah menjadi {$statusLabel}.");
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


