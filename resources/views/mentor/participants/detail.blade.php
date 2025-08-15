@extends('mentor.layout')

@section('title', 'Detail Peserta - ' . $participant->nama)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('mentor.participants') }}" class="text-green-600 hover:text-green-700 mr-4">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Detail Peserta</h1>
                    <p class="text-gray-600 mt-1">Informasi lengkap peserta bimbingan</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Participant Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Personal Information -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-user text-green-600 mr-2"></i>Informasi Pribadi
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Nama Lengkap</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $participant->nama }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Email</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $participant->email }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Nomor WhatsApp</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $participant->nomor_wa }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Instansi</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $participant->instansi }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-500">Fakultas</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $participant->fakultas }}</p>
                    </div>
                </div>
            </div>

            <!-- Research Information -->
            @if($participant->pendaftaran)
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-flask text-blue-600 mr-2"></i>Informasi Riset
                </h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Judul Riset</label>
                        <p class="mt-1 text-sm text-gray-900 font-medium">{{ $participant->pendaftaran->judul_riset }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Penjelasan</label>
                        <p class="mt-1 text-sm text-gray-900 leading-relaxed">{{ $participant->pendaftaran->penjelasan }}</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Minat Keilmuan</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $participant->pendaftaran->minat_keilmuan }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Basis Sistem</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $participant->pendaftaran->basis_sistem }}</p>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Status Pendaftaran</label>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium mt-1
                            @if($participant->pendaftaran->status == 'diterima') bg-green-100 text-green-800
                            @elseif($participant->pendaftaran->status == 'pending') bg-yellow-100 text-yellow-800
                            @elseif($participant->pendaftaran->status == 'review') bg-blue-100 text-blue-800
                            @elseif($participant->pendaftaran->status == 'konsultasi') bg-purple-100 text-purple-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ $participant->pendaftaran->status_label }}
                        </span>
                    </div>
                </div>
            </div>
            @endif

            <!-- Schedule Information -->
            @if($participant->pendaftaran && $participant->pendaftaran->jadwals->count() > 0)
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-calendar-alt text-purple-600 mr-2"></i>Jadwal Bimbingan
                </h2>
                @foreach($participant->pendaftaran->jadwals as $jadwal)
                <div class="border border-gray-200 rounded-lg p-4 mb-4 last:mb-0">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-medium text-gray-900">Jadwal Bimbingan</h3>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($jadwal->status == 'scheduled') bg-blue-100 text-blue-800
                            @elseif($jadwal->status == 'ongoing') bg-green-100 text-green-800
                            @elseif($jadwal->status == 'completed') bg-gray-100 text-gray-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ $jadwal->status_label }}
                        </span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <label class="block text-gray-500">Periode</label>
                            <p class="text-gray-900">{{ $jadwal->tanggal_mulai->format('d M Y') }} - {{ $jadwal->tanggal_akhir->format('d M Y') }}</p>
                        </div>
                        <div>
                            <label class="block text-gray-500">Waktu</label>
                            <p class="text-gray-900">{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_akhir)->format('H:i') }}</p>
                        </div>
                        @if($jadwal->hari)
                        <div class="md:col-span-2">
                            <label class="block text-gray-500">Hari</label>
                            <p class="text-gray-900">{{ $jadwal->formatted_hari }}</p>
                        </div>
                        @endif
                        <div class="md:col-span-2">
                            <label class="block text-gray-500">Deskripsi Jadwal</label>
                            <p class="text-gray-900">{{ $jadwal->schedule_description }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-bolt text-yellow-600 mr-2"></i>Aksi Cepat
                </h3>
                <div class="space-y-3">
                    <a href="https://wa.me/{{ str_replace(['+', '-', ' '], '', $participant->nomor_wa) }}" 
                       target="_blank"
                       class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200 flex items-center justify-center">
                        <i class="fab fa-whatsapp mr-2"></i>Chat WhatsApp
                    </a>
                    <a href="mailto:{{ $participant->email }}" 
                       class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200 flex items-center justify-center">
                        <i class="fas fa-envelope mr-2"></i>Kirim Email
                    </a>
                </div>
            </div>

            <!-- Registration Timeline -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-clock text-gray-600 mr-2"></i>Timeline
                </h3>
                <div class="space-y-3">
                    <div class="flex items-center text-sm">
                        <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                        <div>
                            <p class="text-gray-900">Pendaftaran</p>
                            <p class="text-gray-500">{{ $participant->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                    @if($participant->pendaftaran)
                    <div class="flex items-center text-sm">
                        <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                        <div>
                            <p class="text-gray-900">Riset Diajukan</p>
                            <p class="text-gray-500">{{ $participant->pendaftaran->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                    @endif
                    @if($participant->pendaftaran && $participant->pendaftaran->jadwals->count() > 0)
                    <div class="flex items-center text-sm">
                        <div class="w-2 h-2 bg-purple-500 rounded-full mr-3"></div>
                        <div>
                            <p class="text-gray-900">Jadwal Dibuat</p>
                            <p class="text-gray-500">{{ $participant->pendaftaran->jadwals->first()->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection