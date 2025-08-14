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
                    @if($mentor)
                        <div class="w-16 h-16 bg-purple-100 rounded-full mx-auto mb-3 flex items-center justify-center">
                            <i class="fas fa-user text-purple-600 text-xl"></i>
                        </div>
                        <h4 class="font-semibold text-gray-900">{{ $mentor->nama }}</h4>
                        <p class="text-gray-600 text-sm mb-2">{{ $mentor->keahlian }}</p>
                        <p class="text-gray-500 text-xs mb-3">{{ $mentor->email }}</p>
                        <a href="{{ \App\Helpers\WhatsAppHelper::generateWhatsAppUrl($mentor->nomor_wa, \App\Helpers\WhatsAppHelper::generateMentorContactMessage($peserta->nama, $pendaftaran->judul_riset)) }}" 
                           target="_blank"
                           class="bg-purple-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-purple-700 transition duration-200 inline-block">
                            <i class="fab fa-whatsapp mr-1"></i>
                            Hubungi Mentor
                        </a>
                    @else
                        <div class="w-16 h-16 bg-gray-200 rounded-full mx-auto mb-3 flex items-center justify-center">
                            <i class="fas fa-user text-gray-400 text-xl"></i>
                        </div>
                        <p class="text-gray-600 text-sm">Mentor akan segera ditentukan</p>
                        <p class="text-gray-500 text-xs mt-2">Tim kami sedang mencarikan mentor yang sesuai dengan riset Anda</p>
                    @endif
                </div>
            </div>

            <!-- Schedule Card -->
            <div class="bg-white shadow-xl rounded-2xl p-6">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-calendar text-green-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Jadwal Terbaru</h3>
                </div>
                <div class="text-center">
                    @if($activeJadwal)
                        <div class="bg-{{ $activeJadwal->status_color }}-50 border border-{{ $activeJadwal->status_color }}-200 rounded-lg p-3 mb-3">
                            <div class="flex items-center justify-center mb-2">
                                <span class="bg-{{ $activeJadwal->status_color }}-100 text-{{ $activeJadwal->status_color }}-800 px-2 py-1 rounded-full text-xs font-semibold">
                                    {{ $activeJadwal->status_label }}
                                </span>
                            </div>
                            <p class="text-sm font-semibold text-gray-900">{{ $activeJadwal->formatted_date_time }}</p>
                            @if($activeJadwal->mentor)
                                <p class="text-xs text-gray-600 mt-1">dengan {{ $activeJadwal->mentor->nama }}</p>
                            @endif
                        </div>
                        @if($activeJadwal->mentor)
                            <a href="{{ \App\Helpers\WhatsAppHelper::generateWhatsAppUrl($activeJadwal->mentor->nomor_wa, \App\Helpers\WhatsAppHelper::generateScheduleDiscussionMessage($peserta->nama, $pendaftaran->judul_riset, $activeJadwal->schedule_description)) }}" 
                               target="_blank"
                               class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-green-700 transition duration-200 inline-block">
                                <i class="fab fa-whatsapp mr-1"></i>
                                Diskusi Jadwal
                            </a>
                        @else
                            <button class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-green-700 transition duration-200">
                                <i class="fas fa-eye mr-1"></i>
                                Lihat Detail
                            </button>
                        @endif
                    @elseif($jadwals->isNotEmpty())
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 mb-3">
                            <p class="text-sm font-semibold text-gray-900">Jadwal Terakhir:</p>
                            <p class="text-sm text-gray-600">{{ $jadwals->first()->formatted_date_time }}</p>
                            <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-xs font-semibold">
                                {{ $jadwals->first()->status_label }}
                            </span>
                        </div>
                        <button class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-green-700 transition duration-200">
                            <i class="fas fa-calendar-plus mr-1"></i>
                            Jadwalkan Bimbingan
                        </button>
                    @else
                        <div class="w-16 h-16 bg-gray-100 rounded-full mx-auto mb-3 flex items-center justify-center">
                            <i class="fas fa-calendar-plus text-gray-400 text-xl"></i>
                        </div>
                        <p class="text-gray-600 text-sm mb-3">Belum ada jadwal bimbingan</p>
                        <button class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-green-700 transition duration-200">
                            <i class="fas fa-calendar-plus mr-1"></i>
                            Atur Jadwal
                        </button>
                    @endif
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

                <!-- Schedule History -->
                @if($jadwals->isNotEmpty())
                <div class="bg-white shadow-xl rounded-2xl p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Riwayat Jadwal Bimbingan</h3>
                    <div class="space-y-4">
                        @foreach($jadwals->take(5) as $jadwal)
                        <div class="flex items-start border-l-4 border-{{ $jadwal->status_color }}-400 pl-4 py-2">
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-1">
                                    <p class="font-semibold text-gray-900">
                                        @if($jadwal->hari)
                                            {{ $jadwal->schedule_description }}
                                        @else
                                            {{ $jadwal->formatted_date_time }}
                                        @endif
                                    </p>
                                    <span class="bg-{{ $jadwal->status_color }}-100 text-{{ $jadwal->status_color }}-800 px-2 py-1 rounded-full text-xs font-semibold">
                                        {{ $jadwal->status_label }}
                                    </span>
                                </div>
                                @if($jadwal->hari)
                                    <p class="text-gray-500 text-xs mb-1">
                                        <i class="fas fa-calendar-week mr-1"></i>
                                        Jadwal Rutin: {{ $jadwal->formatted_hari }}
                                    </p>
                                @endif
                                @if($jadwal->mentor)
                                    <p class="text-gray-600 text-sm">Mentor: {{ $jadwal->mentor->nama }}</p>
                                    <p class="text-gray-500 text-xs">{{ $jadwal->mentor->keahlian }}</p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                        
                        @if($jadwals->count() > 5)
                        <div class="text-center pt-4">
                            <button class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                                Lihat Semua Jadwal ({{ $jadwals->count() }})
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

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
                            @if($mentor)
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">Selesai</span>
                            @else
                                <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-semibold">Proses</span>
                            @endif
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-{{ $mentor ? 'green' : 'yellow' }}-500 h-2 rounded-full" style="width: {{ $mentor ? '100' : '50' }}%"></div>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-gray-700">Bimbingan</span>
                            @if($activeJadwal)
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">Aktif</span>
                            @elseif($jadwals->isNotEmpty())
                                <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm font-semibold">Tersedia</span>
                            @else
                                <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm font-semibold">Menunggu</span>
                            @endif
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            @if($activeJadwal)
                                <div class="bg-blue-500 h-2 rounded-full" style="width: 75%"></div>
                            @elseif($jadwals->isNotEmpty())
                                <div class="bg-gray-400 h-2 rounded-full" style="width: 25%"></div>
                            @else
                                <div class="bg-gray-400 h-2 rounded-full" style="width: 0%"></div>
                            @endif
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
                        @if($mentor)
                            <a href="{{ \App\Helpers\WhatsAppHelper::generateWhatsAppUrl($mentor->nomor_wa, \App\Helpers\WhatsAppHelper::generateMentorContactMessage($peserta->nama, $pendaftaran->judul_riset)) }}" 
                               target="_blank"
                               class="w-full bg-purple-600 text-white py-3 rounded-lg font-semibold hover:bg-purple-700 transition duration-200 flex items-center justify-center">
                                <i class="fab fa-whatsapp mr-2"></i>
                                Hubungi Mentor
                            </a>
                            <a href="{{ \App\Helpers\WhatsAppHelper::generateWhatsAppUrl($mentor->nomor_wa, \App\Helpers\WhatsAppHelper::generateScheduleDiscussionMessage($peserta->nama, $pendaftaran->judul_riset, $activeJadwal ? $activeJadwal->schedule_description : null)) }}" 
                               target="_blank"
                               class="w-full bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition duration-200 flex items-center justify-center">
                                <i class="fab fa-whatsapp mr-2"></i>
                                Diskusi Jadwal
                            </a>
                        @else
                            <button class="w-full bg-gray-400 text-white py-3 rounded-lg font-semibold cursor-not-allowed flex items-center justify-center" disabled>
                                <i class="fas fa-user-times mr-2"></i>
                                Mentor Belum Ditentukan
                            </button>
                            <button class="w-full bg-gray-400 text-white py-3 rounded-lg font-semibold cursor-not-allowed flex items-center justify-center" disabled>
                                <i class="fas fa-calendar-times mr-2"></i>
                                Jadwal Belum Tersedia
                            </button>
                        @endif
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