<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PesertaDashboardController extends Controller
{
    public function dashboard()
    {
        $peserta = Auth::guard('peserta')->user();
        $pendaftaran = $peserta->pendaftaran;

        if (!$pendaftaran) {
            return redirect('/peserta/login')->with('error', 'Data pendaftaran tidak ditemukan.');
        }

        // Route based on status
        switch($pendaftaran->status) {
            case 'pending':
            case 'review': 
            case 'konsultasi':
            case 'ditolak':
                return view('peserta.status', compact('peserta', 'pendaftaran'));
            case 'diterima':
                // Load additional data for accepted participants
                $jadwals = $pendaftaran->jadwals()->with('mentor')->orderBy('tanggal_mulai', 'desc')->get();
                $activeJadwal = $pendaftaran->activeJadwal;
                $mentor = null;
                
                // Get mentor from active schedule or latest schedule
                if ($activeJadwal && $activeJadwal->mentor) {
                    $mentor = $activeJadwal->mentor;
                } elseif ($jadwals->isNotEmpty() && $jadwals->first()->mentor) {
                    $mentor = $jadwals->first()->mentor;
                }
                
                return view('peserta.dashboard', compact('peserta', 'pendaftaran', 'jadwals', 'activeJadwal', 'mentor'));
            default:
                return view('peserta.status', compact('peserta', 'pendaftaran'));
        }
    }

    public function editProfile()
    {
        $peserta = Auth::guard('peserta')->user();
        return view('peserta.edit-profile', compact('peserta'));
    }

    public function updateProfile(Request $request)
    {
        $peserta = Auth::guard('peserta')->user();

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('peserta', 'email')->ignore($peserta->id_peserta, 'id_peserta')
            ],
            'nomor_wa' => 'required|string|max:20',
            'instansi' => 'required|string|max:255',
            'fakultas' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh peserta lain.',
            'nomor_wa.required' => 'Nomor WhatsApp wajib diisi.',
            'instansi.required' => 'Instansi wajib diisi.',
            'fakultas.required' => 'Fakultas wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $updateData = [
            'nama' => $request->nama,
            'email' => $request->email,
            'nomor_wa' => $request->nomor_wa,
            'instansi' => $request->instansi,
            'fakultas' => $request->fakultas,
        ];

        // Only update password if provided
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $peserta->update($updateData);

        return redirect()->route('peserta.dashboard')->with('success', 'Profil berhasil diperbarui!');
    }
}