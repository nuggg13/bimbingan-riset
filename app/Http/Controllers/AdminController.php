<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Peserta;
use App\Models\Pendaftaran;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/admin/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/admin/login');
    }

    public function dashboard()
    {
        $admin = Auth::guard('admin')->user();
        
        // Ambil data real dari database
        $totalMahasiswa = Peserta::count();
        $totalPendaftaran = Pendaftaran::count();
        $totalPending = Pendaftaran::where('status', 'pending')->count();
        $totalMentor = 0; // Belum ada tabel mentor, jadi tetap 0
        
        return view('admin.dashboard', compact('admin', 'totalMahasiswa', 'totalPendaftaran', 'totalPending', 'totalMentor'));
    }
}
