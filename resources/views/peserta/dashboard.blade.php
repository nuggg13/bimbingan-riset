@extends('peserta.layout')

@section('title', 'Dashboard Peserta')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50">
    <!-- Hero Header -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold mb-2">Selamat Datang, {{ $peserta->nama }}</h1>
                    <p class="text-blue-100 text-lg">Mari lanjutkan perjalanan riset Anda!</p>
                </div>
                <form method="POST" action="{{ route('peserta.logout') }}" class="mt-4 md:mt-0">
                    @csrf
                    <button type="submit" class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-6 py-3 rounded-full font-medium transition duration-300 flex items-center">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 -mt-8">
        <!-- Key Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Progress Card -->
            <div class="bg-white rounded-2xl shadow-lg p-6 transform hover:scale-105 transition duration-300">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-chart-line text-blue-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Progress Riset</h3>
                </div>
                @php
                    $overallProgress = $catatanBimbingan->avg('total_progress_percentage') ?? 0;
                @endphp
                <div class="text-center">
                    <div class="relative">
                        <svg class="w-32 h-32 mx-auto" viewBox="0 0 36 36">
                            <path class="text-gray-200" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3" stroke-dasharray="100, 100" />
                            <path class="text-blue-500" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3" stroke-dasharray="{{ $overallProgress }}, 100" />
                        </svg>
                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-2xl font-bold text-blue-600">
                            {{ number_format($overallProgress, 0) }}%
                        </div>
                    </div>
                    <p class="mt-2 text-sm text-gray-600">Progress keseluruhan riset</p>
                </div>
            </div>

            <!-- Catatan Card -->
            <div class="bg-white rounded-2xl shadow-lg p-6 transform hover:scale-105 transition duration-300">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-clipboard-list text-purple-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Catatan Bimbingan</h3>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-bold text-purple-600 mb-1">{{ $catatanBimbingan->count() }}</p>
                    <p class="text-sm text-gray-600">Catatan tersedia</p>
                    @if($catatanBimbingan->isNotEmpty())
                    <p class="text-xs text-gray-500 mt-2">Terakhir: {{ $catatanBimbingan->first()->tanggal_bimbingan->format('d M Y') }}</p>
                    @endif
                </div>
            </div>

            <!-- Jadwal Card -->
            <div class="bg-white rounded-2xl shadow-lg p-6 transform hover:scale-105 transition duration-300">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-calendar-check text-green-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Jadwal Bimbingan</h3>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-bold text-green-600 mb-1">{{ $jadwals->count() }}</p>
                    <p class="text-sm text-gray-600">Jadwal tersedia</p>
                    @if($activeJadwal)
                    <p class="text-xs text-gray-500 mt-2">Selanjutnya: {{ $activeJadwal->tanggal_mulai->format('d M Y') }}</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Main Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column (span 2) -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Catatan Bimbingan -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Catatan Bimbingan</h2>
                        <a href="#" class="text-blue-600 hover:text-blue-700 text-sm font-medium">Lihat Semua <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                    <div class="space-y-4">
                        @forelse($catatanBimbingan->take(3) as $catatan)
                        <div class="border border-gray-200 rounded-xl p-4 hover:shadow-md transition duration-300">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-note-sticky text-blue-600"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900">{{ $catatan->tanggal_bimbingan->format('d F Y') }}</h3>
                                        <p class="text-sm text-gray-500">{{ $catatan->status_label }}</p>
                                    </div>
                                </div>
                                @if($catatan->latest_progress)
                                <div class="text-right">
                                    <span class="block text-sm font-medium text-gray-700">Progress</span>
                                    <span class="text-lg font-bold" style="color: {{ $catatan->latest_progress->progress_color }}-600">
                                        {{ number_format($catatan->latest_progress->persentase, 0) }}%
                                    </span>
                                </div>
                                @endif
                            </div>
                            <div class="prose prose-sm max-w-none text-gray-700 mb-3">
                                {!! Str::limit($catatan->hasil_bimbingan, 150) !!}
                            </div>
                            <div class="flex justify-end space-x-2">
                                <button class="text-blue-600 hover:text-blue-700 text-sm">Lihat Detail</button>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8">
                            <i class="fas fa-clipboard-list text-gray-300 text-5xl mb-4"></i>
                            <p class="text-gray-600 font-medium">Belum ada catatan bimbingan</p>
                            <p class="text-sm text-gray-500 mt-1">Catatan akan muncul setelah sesi bimbingan pertama</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Jadwal Bimbingan -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Jadwal Bimbingan</h2>
                        <a href="#" class="text-green-600 hover:text-green-700 text-sm font-medium">Lihat Semua <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                    <div class="space-y-4">
                        @forelse($jadwals->take(3) as $jadwal)
                        <div class="border border-gray-200 rounded-xl p-4 hover:shadow-md transition duration-300 flex items-center justify-between">
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ $jadwal->tanggal_mulai->format('d F Y') }}</h3>
                                <p class="text-sm text-gray-500">{{ $jadwal->jam_mulai->format('H:i') }} - {{ $jadwal->jam_akhir->format('H:i') }}</p>
                                <p class="text-sm text-gray-600 mt-1">{{ $jadwal->hari ? 'Hari: ' . $jadwal->hari : '' }}</p>
                            </div>
                            <span class="bg-{{ $jadwal->status_color }}-100 text-{{ $jadwal->status_color }}-800 px-3 py-1 rounded-full text-sm font-medium">
                                {{ $jadwal->status }}
                            </span>
                        </div>
                        @empty
                        <div class="text-center py-8">
                            <i class="fas fa-calendar-alt text-gray-300 text-5xl mb-4"></i>
                            <p class="text-gray-600 font-medium">Belum ada jadwal</p>
                            <p class="text-sm text-gray-500 mt-1">Jadwal akan ditambahkan oleh mentor Anda</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-6">
                <!-- Profile Card -->
                <div class="bg-white rounded-2xl shadow-lg p-6 sticky top-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Profil Saya</h2>
                    <div class="text-center mb-6">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($peserta->nama) }}&background=0D8ABC&color=fff&size=128" class="w-24 h-24 rounded-full mx-auto mb-3 shadow-md">
                        <h3 class="font-semibold text-gray-900 text-lg">{{ $peserta->nama }}</h3>
                        <p class="text-gray-600">{{ $peserta->email }}</p>
                    </div>
                    <div class="space-y-4 text-sm">
                        <div class="flex items-center">
                            <i class="fas fa-university w-5 text-gray-400 mr-3"></i>
                            <span>{{ $peserta->instansi }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-graduation-cap w-5 text-gray-400 mr-3"></i>
                            <span>{{ $peserta->fakultas }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fab fa-whatsapp w-5 text-gray-400 mr-3"></i>
                            <span>{{ $peserta->nomor_wa }}</span>
                        </div>
                    </div>
                    <a href="{{ route('peserta.profile.edit') }}" class="mt-6 block bg-blue-600 text-white py-3 rounded-xl text-center font-medium hover:bg-blue-700 transition duration-300">
                        Edit Profil
                    </a>
                </div>

                <!-- Mentor Card -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Mentor Saya</h2>
                    @if($mentor)
                    <div class="text-center mb-4">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($mentor->nama) }}&background=6366f1&color=fff&size=96" class="w-20 h-20 rounded-full mx-auto mb-3 shadow">
                        <h3 class="font-semibold text-gray-900">{{ $mentor->nama }}</h3>
                        <p class="text-gray-600 text-sm">{{ $mentor->keahlian }}</p>
                    </div>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $mentor->nomor_wa) }}" target="_blank" class="block bg-green-500 text-white py-3 rounded-xl text-center font-medium hover:bg-green-600 transition duration-300">
                        <i class="fab fa-whatsapp mr-2"></i> Chat dengan Mentor
                    </a>
                    @else
                    <div class="text-center py-4">
                        <i class="fas fa-user-tie text-gray-300 text-5xl mb-4"></i>
                        <p class="text-gray-600 font-medium">Mentor Belum Ditugaskan</p>
                        <p class="text-sm text-gray-500 mt-2">Admin akan segera menugaskan mentor untuk Anda</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection