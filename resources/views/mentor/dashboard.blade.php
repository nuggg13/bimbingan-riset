@extends('mentor.layout')

@section('title', 'Dashboard Mentor')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Dashboard Mentor</h1>
                <p class="text-gray-600 mt-1">Selamat datang, {{ $mentor->nama }}!</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500">Keahlian</p>
                <p class="font-semibold text-green-600">{{ $mentor->keahlian }}</p>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Participants -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Total Peserta</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalParticipants }}</p>
                </div>
            </div>
        </div>

        <!-- Active Schedules -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-full">
                    <i class="fas fa-calendar-check text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Jadwal Aktif</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $activeSchedules }}</p>
                </div>
            </div>
        </div>

        <!-- Completed Schedules -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 bg-gray-100 rounded-full">
                    <i class="fas fa-check-circle text-gray-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Selesai</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $completedSchedules }}</p>
                </div>
            </div>
        </div>

        <!-- Pending Registrations -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-full">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Pending</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $pendingRegistrations }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Participants -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-800">Peserta Bimbingan</h2>
                <a href="{{ route('mentor.participants') }}" class="text-green-600 hover:text-green-700 text-sm font-medium">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
        <div class="p-6">
            @if($participants->count() > 0)
                <div class="space-y-4">
                    @foreach($participants->take(5) as $participant)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-green-600"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="font-medium text-gray-800">{{ $participant->nama }}</h3>
                                    <p class="text-sm text-gray-600">{{ $participant->instansi }}</p>
                                    <p class="text-sm text-gray-500">{{ $participant->pendaftaran->judul_riset }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($participant->jadwal->status == 'scheduled') bg-blue-100 text-blue-800
                                    @elseif($participant->jadwal->status == 'ongoing') bg-green-100 text-green-800
                                    @elseif($participant->jadwal->status == 'completed') bg-gray-100 text-gray-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ $participant->jadwal->status_label }}
                                </span>
                                <p class="text-xs text-gray-500 mt-1">{{ $participant->jadwal->schedule_description }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-users text-gray-400 text-4xl mb-4"></i>
                    <p class="text-gray-500">Belum ada peserta yang dibimbing</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Recent Schedules -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-800">Jadwal Terbaru</h2>
                <a href="{{ route('mentor.schedules') }}" class="text-green-600 hover:text-green-700 text-sm font-medium">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
        <div class="p-6">
            @if($jadwals->count() > 0)
                <div class="space-y-4">
                    @foreach($jadwals->take(5) as $jadwal)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-calendar text-blue-600"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="font-medium text-gray-800">{{ $jadwal->pendaftaran->peserta->nama }}</h3>
                                    <p class="text-sm text-gray-600">{{ $jadwal->pendaftaran->judul_riset }}</p>
                                    <p class="text-sm text-gray-500">{{ $jadwal->schedule_description }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($jadwal->status == 'scheduled') bg-blue-100 text-blue-800
                                    @elseif($jadwal->status == 'ongoing') bg-green-100 text-green-800
                                    @elseif($jadwal->status == 'completed') bg-gray-100 text-gray-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ $jadwal->status_label }}
                                </span>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $jadwal->tanggal_mulai->format('d M Y') }} - {{ $jadwal->tanggal_akhir->format('d M Y') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-calendar text-gray-400 text-4xl mb-4"></i>
                    <p class="text-gray-500">Belum ada jadwal bimbingan</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection