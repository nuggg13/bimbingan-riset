<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegistrationController extends Controller
{
    public function showStep1()
    {
        return view('registration.step1');
    }

    public function processStep1(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:peserta,email',
            'password' => 'required|min:8|confirmed',
            'nomor_wa' => 'required|string|regex:/^\+62[0-9]{9,13}$/',
            'instansi' => 'required|string|max:255',
            'fakultas' => 'required|string|max:255'
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'nomor_wa.required' => 'Nomor WhatsApp wajib diisi.',
            'nomor_wa.regex' => 'Format nomor WhatsApp harus dimulai dengan +62 dan diikuti 9-13 digit angka.',
            'instansi.required' => 'Instansi wajib diisi.',
            'fakultas.required' => 'Fakultas wajib diisi.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Store step 1 data in session
        session([
            'registration_step1' => [
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => $request->password,
                'nomor_wa' => $request->nomor_wa,
                'instansi' => $request->instansi,
                'fakultas' => $request->fakultas,
            ]
        ]);

        return redirect()->route('register.step2');
    }

    public function showStep2()
    {
        if (!session('registration_step1')) {
            return redirect()->route('register.step1');
        }

        return view('registration.step2');
    }

    public function processStep2(Request $request)
    {
        if (!session('registration_step1')) {
            return redirect()->route('register.step1');
        }

        $validator = Validator::make($request->all(), [
            'judul_riset' => 'required|string|max:255',
            'penjelasan' => 'required|string',
            'minat_keilmuan' => 'required|string|max:255',
            'basis_sistem' => 'required|string|max:255'
        ], [
            'judul_riset.required' => 'Judul riset wajib diisi.',
            'penjelasan.required' => 'Penjelasan wajib diisi.',
            'minat_keilmuan.required' => 'Minat keilmuan wajib diisi.',
            'basis_sistem.required' => 'Basis sistem wajib diisi.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $step1Data = session('registration_step1');

        // Handle custom fields
        $minatKeilmuan = $request->minat_keilmuan;
        if ($minatKeilmuan === 'Lainnya' && $request->custom_minat_keilmuan) {
            $minatKeilmuan = $request->custom_minat_keilmuan;
        }

        $basisSistem = $request->basis_sistem;
        if ($basisSistem === 'Lainnya' && $request->custom_basis_sistem) {
            $basisSistem = $request->custom_basis_sistem;
        }

        try {
            // Create peserta
            $peserta = Peserta::create([
                'nama' => $step1Data['nama'],
                'email' => $step1Data['email'],
                'password' => Hash::make($step1Data['password']),
                'nomor_wa' => $step1Data['nomor_wa'],
                'instansi' => $step1Data['instansi'],
                'fakultas' => $step1Data['fakultas'],
            ]);

            // Create pendaftaran
            $pendaftaran = Pendaftaran::create([
                'id_peserta' => $peserta->id_peserta,
                'judul_riset' => $request->judul_riset,
                'penjelasan' => $request->penjelasan,
                'minat_keilmuan' => $minatKeilmuan,
                'basis_sistem' => $basisSistem,
                'status' => 'pending'
            ]);

            // Store registration data for success page
            session([
                'registration_success' => [
                    'peserta' => $peserta,
                    'pendaftaran' => $pendaftaran
                ]
            ]);

            // Clear step 1 data
            session()->forget('registration_step1');

            return redirect()->route('register.success');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.')
                ->withInput();
        }
    }

    public function showStep3()
    {
        if (!session('registration_success')) {
            return redirect()->route('register.step1');
        }

        $data = session('registration_success');
        
        return view('registration.step3', [
            'peserta' => $data['peserta'],
            'pendaftaran' => $data['pendaftaran']
        ]);
    }
}