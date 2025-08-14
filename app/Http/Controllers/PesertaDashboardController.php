<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}