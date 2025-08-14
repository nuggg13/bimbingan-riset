@extends('peserta.layout')

@section('title', 'Status Pendaftaran')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="gradient-bg text-white py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold">Selamat Datang, {{ $peserta->nama }}</h1>
                    <p class="text-blue-100 mt-2">Status Pendaftaran Bimbingan Riset</p>
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

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Status Card -->
        <div class="bg-white shadow-2xl rounded-2xl overflow-hidden mb-8">
            <!-- Status Header -->
            <div class="status-{{ $pendaftaran->status }} text-white p-6">
                <div class="flex items-center justify-center mb-4">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        @if($pendaftaran->status == 'pending')
                            <i class="fas fa-clock text-2xl"></i>
                        @elseif($pendaftaran->status == 'review')
                            <i class="fas fa-search text-2xl"></i>
                        @elseif($pendaftaran->status == 'konsultasi')
                            <i class="fas fa-comments text-2xl"></i>
                        @elseif($pendaftaran->status == 'ditolak')
                            <i class="fas fa-times text-2xl"></i>
                        @else
                            <i class="fas fa-check text-2xl"></i>
                        @endif
                    </div>
                </div>
                <h2 class="text-2xl font-bold text-center mb-2">{{ $pendaftaran->status_label }}</h2>
                <p class="text-center text-lg opacity-90">{{ $pendaftaran->status_message }}</p>
            </div>

            <!-- Status Content -->
            <div class="p-6">
                @if($pendaftaran->status == 'pending')
                    <div class="text-center space-y-4">
                        <div class="flex justify-center space-x-8 text-sm text-gray-600">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                <span>Pendaftaran Diterima</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-clock text-yellow-500 mr-2"></i>
                                <span>Menunggu Review</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-circle text-gray-300 mr-2"></i>
                                <span>Hasil Review</span>
                            </div>
                        </div>
                        
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <h3 class="font-semibold text-yellow-800 mb-2">Yang Sedang Terjadi:</h3>
                            <ul class="text-yellow-700 space-y-1 text-sm">
                                <li>��� Tim kami sedang mereview proposal riset Anda</li>
                                <li>• Proses review memakan waktu 1-3 hari kerja</li>
                                <li>• Anda akan mendapat notifikasi via email dan WhatsApp</li>
                            </ul>
                        </div>
                    </div>

                @elseif($pendaftaran->status == 'review')
                    <div class="text-center space-y-4">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <h3 class="font-semibold text-blue-800 mb-2">Sedang Dalam Review:</h3>
                            <ul class="text-blue-700 space-y-1 text-sm">
                                <li>• Tim ahli sedang mengevaluasi proposal Anda</li>
                                <li>• Kami akan mencocokkan dengan mentor yang sesuai</li>
                                <li>• Hasil review akan segera diinformasikan</li>
                            </ul>
                        </div>
                    </div>

                @elseif($pendaftaran->status == 'konsultasi')
                    <div class="text-center space-y-4">
                        <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                            <h3 class="font-semibold text-purple-800 mb-2">Perlu Konsultasi:</h3>
                            <ul class="text-purple-700 space-y-1 text-sm">
                                <li>• Proposal Anda menarik namun perlu diskusi lebih lanjut</li>
                                <li>• Tim kami akan menghubungi Anda segera</li>
                                <li>• Siapkan pertanyaan dan klarifikasi yang diperlukan</li>
                            </ul>
                        </div>
                    </div>

                @elseif($pendaftaran->status == 'ditolak')
                    <div class="text-center space-y-4">
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <h3 class="font-semibold text-red-800 mb-2">Informasi Penolakan:</h3>
                            <ul class="text-red-700 space-y-1 text-sm">
                                <li>• Proposal belum memenuhi kriteria saat ini</li>
                                <li>• Anda dapat mendaftar kembali dengan proposal yang diperbaiki</li>
                                <li>• Hubungi admin untuk feedback lebih detail</li>
                            </ul>
                        </div>
                        
                        <a href="{{ route('register.step1') }}" 
                            class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-200">
                            <i class="fas fa-plus mr-2"></i>Daftar Riset Baru
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Registration Details -->
        <div class="bg-white shadow-xl rounded-2xl p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-6">Detail Pendaftaran</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Nama Lengkap</label>
                        <p class="text-gray-900 font-semibold">{{ $peserta->nama }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Email</label>
                        <p class="text-gray-900 font-semibold">{{ $peserta->email }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Nomor WhatsApp</label>
                        <p class="text-gray-900 font-semibold">{{ $peserta->nomor_wa }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Instansi</label>
                        <p class="text-gray-900 font-semibold">{{ $peserta->instansi }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Fakultas</label>
                        <p class="text-gray-900 font-semibold">{{ $peserta->fakultas }}</p>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Judul Riset</label>
                        <p class="text-gray-900 font-semibold">{{ $pendaftaran->judul_riset }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Minat Keilmuan</label>
                        <p class="text-gray-900 font-semibold">{{ $pendaftaran->minat_keilmuan }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Basis Sistem</label>
                        <p class="text-gray-900 font-semibold">{{ $pendaftaran->basis_sistem }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Tanggal Pendaftaran</label>
                        <p class="text-gray-900 font-semibold">{{ $pendaftaran->created_at->format('d F Y, H:i') }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Penjelasan Riset</label>
                        <p class="text-gray-900">{{ $pendaftaran->penjelasan }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mt-8">
            <h3 class="text-lg font-semibold text-blue-800 mb-4">Butuh Bantuan?</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-blue-700">
                <div class="flex items-center">
                    <i class="fas fa-envelope text-blue-500 mr-3"></i>
                    <div>
                        <p class="font-semibold">Email</p>
                        <p class="text-sm">admin@bimbinganriset.com</p>
                    </div>
                </div>
                <div class="flex items-center">
                    <i class="fab fa-whatsapp text-blue-500 mr-3"></i>
                    <div>
                        <p class="font-semibold">WhatsApp</p>
                        <p class="text-sm">+62 812-3456-7890</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection