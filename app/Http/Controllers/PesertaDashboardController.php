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
                return view('peserta.dashboard', compact('peserta', 'pendaftaran'));
            default:
                return view('peserta.status', compact('peserta', 'pendaftaran'));
        }
    }
}