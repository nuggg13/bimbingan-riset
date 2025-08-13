@extends('peserta.layout')

@section('title', 'Dashboard Peserta')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="status-diterima text-white py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold">Selamat Datang, {{ $peserta->nama }}</h1>
                    <p class="text-green-100 mt-2">Dashboard Bimbingan Riset</p>
                </div>
                <form method="POST" action="{{ route('peserta.logout') }}">
                    @csrf
                    <button type="submit" class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-4 py-2 rounded-lg transition duration-200">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Welcome Message -->
        <div class="bg-gradient-to-r from-green-400 to-green-600 text-white rounded-2xl p-6 mb-8">
            <div class="flex items-center">
                <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-check text-2xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold mb-2">Selamat! Pendaftaran Anda Diterima</h2>
                    <p class="text-green-100">Anda sekarang dapat mengakses semua fitur bimbingan riset</p>
                </div>
            </div>
        </div>

        <!-- Dashboard Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <!-- Research Info Card -->
            <div class="bg-white shadow-xl rounded-2xl p-6">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-lightbulb text-blue-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Riset Saya</h3>
                </div>
                <p class="text-gray-600 text-sm mb-3">{{ $pendaftaran->judul_riset }}</p>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Minat Keilmuan:</span>
                        <span class="font-semibold">{{ $pendaftaran->minat_keilmuan }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Basis Sistem:</span>
                        <span class="font-semibold">{{ $pendaftaran->basis_sistem }}</span>
                    </div>
                </div>
            </div>

            <!-- Mentor Card -->
            <div class="bg-white shadow-xl rounded-2xl p-6">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-user-tie text-purple-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Mentor</h3>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-gray-200 rounded-full mx-auto mb-3 flex items-center justify-center">
                        <i class="fas fa-user text-gray-400 text-xl"></i>
                    </div>
                    <p class="text-gray-600 text-sm">Mentor akan segera ditentukan</p>
                    <button class="mt-3 text-blue-600 hover:text-blue-800 text-sm font-semibold">
                        Lihat Detail
                    </button>
                </div>
            </div>

            <!-- Schedule Card -->
            <div class="bg-white shadow-xl rounded-2xl p-6">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-calendar text-green-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Jadwal</h3>
                </div>
                <div class="text-center">
                    <p class="text-gray-600 text-sm mb-3">Belum ada jadwal bimbingan</p>
                    <button class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-green-700 transition duration-200">
                        Atur Jadwal
                    </button>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Recent Activity -->
                <div class="bg-white shadow-xl rounded-2xl p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Aktivitas Terbaru</h3>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-check text-green-600"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">Pendaftaran Diterima</p>
                                <p class="text-gray-600 text-sm">{{ $pendaftaran->updated_at->format('d F Y, H:i') }}</p>
                                <p class="text-gray-500 text-sm mt-1">Selamat! Pendaftaran riset Anda telah diterima dan disetujui.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-file-alt text-blue-600"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">Proposal Disubmit</p>
                                <p class="text-gray-600 text-sm">{{ $pendaftaran->created_at->format('d F Y, H:i') }}</p>
                                <p class="text-gray-500 text-sm mt-1">Proposal riset "{{ $pendaftaran->judul_riset }}" berhasil disubmit.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Research Progress -->
                <div class="bg-white shadow-xl rounded-2xl p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Progress Riset</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-700">Proposal</span>
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">Selesai</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-600 h-2 rounded-full" style="width: 100%"></div>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-gray-700">Penentuan Mentor</span>
                            <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-semibold">Proses</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-yellow-500 h-2 rounded-full" style="width: 50%"></div>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-gray-700">Bimbingan</span>
                            <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm font-semibold">Menunggu</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-gray-400 h-2 rounded-full" style="width: 0%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-6">
                <!-- Profile Card -->
                <div class="bg-white shadow-xl rounded-2xl p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Profil Saya</h3>
                    <div class="text-center mb-4">
                        <div class="w-20 h-20 bg-gray-200 rounded-full mx-auto mb-3 flex items-center justify-center">
                            <i class="fas fa-user text-gray-400 text-2xl"></i>
                        </div>
                        <h4 class="font-semibold text-gray-900">{{ $peserta->nama }}</h4>
                        <p class="text-gray-600 text-sm">{{ $peserta->email }}</p>
                    </div>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Instansi:</span>
                            <span class="font-semibold">{{ $peserta->instansi }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Fakultas:</span>
                            <span class="font-semibold">{{ $peserta->fakultas }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">WhatsApp:</span>
                            <span class="font-semibold">{{ $peserta->nomor_wa }}</span>
                        </div>
                    </div>
                    <button class="w-full mt-4 bg-blue-600 text-white py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition duration-200">
                        Edit Profil
                    </button>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white shadow-xl rounded-2xl p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Aksi Cepat</h3>
                    <div class="space-y-3">
                        <button class="w-full bg-purple-600 text-white py-3 rounded-lg font-semibold hover:bg-purple-700 transition duration-200 flex items-center justify-center">
                            <i class="fas fa-comments mr-2"></i>
                            Hubungi Mentor
                        </button>
                        <button class="w-full bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition duration-200 flex items-center justify-center">
                            <i class="fas fa-calendar-plus mr-2"></i>
                            Jadwalkan Bimbingan
                        </button>
                        <button class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-200 flex items-center justify-center">
                            <i class="fas fa-file-upload mr-2"></i>
                            Upload Dokumen
                        </button>
                    </div>
                </div>

                <!-- Help & Support -->
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-blue-800 mb-3">Bantuan & Dukungan</h3>
                    <p class="text-blue-700 text-sm mb-4">Butuh bantuan dengan riset Anda?</p>
                    <div class="space-y-2 text-sm">
                        <a href="#" class="flex items-center text-blue-600 hover:text-blue-800">
                            <i class="fas fa-book mr-2"></i>
                            Panduan Bimbingan
                        </a>
                        <a href="#" class="flex items-center text-blue-600 hover:text-blue-800">
                            <i class="fas fa-question-circle mr-2"></i>
                            FAQ
                        </a>
                        <a href="mailto:admin@bimbinganriset.com" class="flex items-center text-blue-600 hover:text-blue-800">
                            <i class="fas fa-envelope mr-2"></i>
                            Hubungi Admin
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection