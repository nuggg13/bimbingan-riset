<?php

namespace App\Http\Controllers;

use App\Models\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;

class MentorController extends Controller
{
    public function index(Request $request)
    {
        $query = Mentor::orderBy('nama');
        
        // Pencarian berdasarkan nama atau email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('keahlian', 'like', "%{$search}%");
            });
        }
        
        $mentor = $query->paginate(10)->withQueryString();
        
        // Cache statistik untuk performa yang lebih baik
        $statistics = Cache::remember('mentor_statistics', 300, function () {
            return [
                'total' => Mentor::count(),
                'with_wa' => Mentor::whereNotNull('nomor_wa')->where('nomor_wa', '!=', '')->count(),
            ];
        });
        
        return view('admin.mentor.index', compact('mentor', 'statistics'));
    }

    public function create()
    {
        return view('admin.mentor.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:mentor,email',
            'password' => 'required|string|min:6',
            'nomor_wa' => 'nullable|string|max:20',
            'keahlian' => 'required|string|max:500',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        Mentor::create($validated);

        // Clear cache
        Cache::forget('mentor_statistics');

        return redirect()->route('admin.mentor.index')->with('success', 'Mentor berhasil ditambahkan.');
    }

    public function show(Mentor $mentor)
    {
        return view('admin.mentor.show', compact('mentor'));
    }

    public function edit(Mentor $mentor)
    {
        return view('admin.mentor.edit', compact('mentor'));
    }

    public function update(Request $request, Mentor $mentor)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:mentor,email,' . $mentor->id_mentor . ',id_mentor',
            'password' => 'nullable|string|min:6',
            'nomor_wa' => 'nullable|string|max:20',
            'keahlian' => 'required|string|max:500',
        ]);

        // Jika password diisi, hash password
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $mentor->update($validated);

        // Clear cache
        Cache::forget('mentor_statistics');

        return redirect()->route('admin.mentor.index')->with('success', 'Data mentor berhasil diperbarui.');
    }

    public function destroy(Mentor $mentor)
    {
        $nama = $mentor->nama;
        $mentor->delete();

        // Clear cache
        Cache::forget('mentor_statistics');

        return redirect()->route('admin.mentor.index')->with('success', "Mentor {$nama} berhasil dihapus.");
    }

    public function export(Request $request)
    {
        $query = Mentor::orderBy('nama');
        
        // Pencarian berdasarkan nama atau email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('keahlian', 'like', "%{$search}%");
            });
        }
        
        $mentor = $query->get();
        
        $filename = 'mentor_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($mentor) {
            $file = fopen('php://output', 'w');
            
            // Header CSV
            fputcsv($file, [
                'ID Mentor',
                'Nama',
                'Email',
                'WhatsApp',
                'Keahlian',
                'Tanggal Dibuat',
                'Tanggal Diubah'
            ]);
            
            // Data
            foreach ($mentor as $row) {
                fputcsv($file, [
                    $row->id_mentor,
                    $row->nama,
                    $row->email,
                    $row->nomor_wa ?? 'N/A',
                    $row->keahlian,
                    $row->created_at ? $row->created_at->format('d/m/Y H:i') : 'N/A',
                    $row->updated_at ? $row->updated_at->format('d/m/Y H:i') : 'N/A'
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}
