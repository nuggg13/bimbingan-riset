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
                        <button onclick="showAllNotes()" class="text-blue-600 hover:text-blue-700 text-sm font-medium">Lihat Semua <i class="fas fa-arrow-right ml-1"></i></button>
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
                                <button onclick="showNoteDetail({{ $catatan->id_catatan }})" class="text-blue-600 hover:text-blue-700 text-sm">Lihat Detail</button>
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
                        <button onclick="showScheduleCalendar()" class="text-green-600 hover:text-green-700 text-sm font-medium">Lihat Semua <i class="fas fa-arrow-right ml-1"></i></button>
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

<!-- Modal for All Notes -->
<div id="allNotesModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-4xl shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">Roadmap Catatan Bimbingan</h3>
                <button onclick="closeAllNotes()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <div class="max-h-96 overflow-y-auto">
                <!-- Roadmap Timeline -->
                <div class="relative">
                    <div class="absolute left-8 top-0 bottom-0 w-0.5 bg-blue-200"></div>
                    
                    @forelse($catatanBimbingan as $index => $catatan)
                    <div class="relative flex items-start mb-8">
                        <!-- Timeline dot -->
                        <div class="flex-shrink-0 w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center border-4 border-white shadow-lg z-10">
                            <div class="text-center">
                                <div class="text-xs font-bold text-blue-600">{{ $catatan->tanggal_bimbingan->format('d') }}</div>
                                <div class="text-xs text-blue-500">{{ $catatan->tanggal_bimbingan->format('M') }}</div>
                            </div>
                        </div>
                        
                        <!-- Content -->
                        <div class="ml-6 flex-1 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-semibold text-gray-900">{{ $catatan->tanggal_bimbingan->format('d F Y') }}</h4>
                                <div class="flex items-center space-x-2">
                                    @php
                                        $statusClass = $catatan->status == 'completed' ? 'bg-green-100 text-green-800' :
                                            ($catatan->status == 'published' ? 'bg-blue-100 text-blue-800' :
                                            ($catatan->status == 'reviewed' ? 'bg-yellow-100 text-yellow-800' :
                                            'bg-gray-100 text-gray-800'));
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClass }}">
                                        {{ $catatan->status_label }}
                                    </span>
                                    @if($catatan->latest_progress)
                                    <span class="text-sm font-bold text-green-600">{{ $catatan->latest_progress->persentase }}%</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="space-y-3">
                                <div>
                                    <h5 class="text-sm font-medium text-gray-700 mb-1">Hasil Bimbingan:</h5>
                                    <p class="text-sm text-gray-600 leading-relaxed">{!! Str::limit($catatan->hasil_bimbingan, 200) !!}</p>
                                </div>
                                
                                @if($catatan->tugas_perbaikan)
                                <div>
                                    <h5 class="text-sm font-medium text-gray-700 mb-1">Tugas Perbaikan:</h5>
                                    <p class="text-sm text-gray-600 leading-relaxed">{!! Str::limit($catatan->tugas_perbaikan, 150) !!}</p>
                                </div>
                                @endif
                                
                                @if($catatan->latest_progress)
                                <div>
                                    <h5 class="text-sm font-medium text-gray-700 mb-1">Progress:</h5>
                                    <div class="flex items-center">
                                        <div class="w-24 bg-gray-200 rounded-full h-2 mr-3">
                                            <div class="bg-green-600 h-2 rounded-full" style="width: {{ $catatan->latest_progress->persentase }}%"></div>
                                        </div>
                                        <span class="text-sm font-medium text-green-600">{{ $catatan->latest_progress->persentase }}%</span>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">{{ $catatan->latest_progress->deskripsi_progress }}</p>
                                </div>
                                @endif
                            </div>
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
        </div>
    </div>
</div>

<!-- Modal for Note Detail -->
<div id="noteDetailModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-2xl shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">Detail Catatan Bimbingan</h3>
                <button onclick="closeNoteDetail()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <div id="noteDetailContent" class="space-y-4">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<!-- Modal for Schedule Calendar -->
<div id="scheduleCalendarModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-10 mx-auto p-5 border w-11/12 max-w-6xl shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">Kalender Jadwal Bimbingan</h3>
                <button onclick="closeScheduleCalendar()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <!-- Calendar Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
                <div class="flex items-center gap-2">
                    <button id="prevMonthPeserta" class="px-3 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200"><i class="fas fa-chevron-left"></i></button>
                    <div id="currentMonthPeserta" class="text-lg font-semibold text-gray-800"></div>
                    <button id="nextMonthPeserta" class="px-3 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200"><i class="fas fa-chevron-right"></i></button>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Terjadwal</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Berlangsung</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Selesai</span>
                </div>
            </div>

            <div class="grid grid-cols-7 gap-2 text-xs font-medium text-gray-500 mb-2">
                <div class="text-center">Sen</div>
                <div class="text-center">Sel</div>
                <div class="text-center">Rab</div>
                <div class="text-center">Kam</div>
                <div class="text-center">Jum</div>
                <div class="text-center">Sab</div>
                <div class="text-center">Min</div>
            </div>

            <div id="calendarGridPeserta" class="grid grid-cols-7 gap-2 mb-6"></div>
            
            <!-- Selected Day Details -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="font-semibold text-gray-900 mb-2">Jadwal Tanggal <span id="selectedDateLabelPeserta">-</span></h4>
                <div id="selectedDayListPeserta">
                    <p class="text-gray-500 text-sm">Pilih tanggal pada kalender untuk melihat detail jadwal.</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Notes data for detail modal
const notesData = @json($catatanBimbingan->keyBy('id_catatan')->map(function($catatan) {
    return array(
        'id' => $catatan->id_catatan,
        'tanggal' => $catatan->tanggal_bimbingan->format('d F Y'),
        'status' => $catatan->status,
        'status_label' => $catatan->status_label,
        'hasil_bimbingan' => $catatan->hasil_bimbingan,
        'tugas_perbaikan' => $catatan->tugas_perbaikan,
        'catatan_mentor' => $catatan->catatan_mentor,
        'progress' => ($catatan->latest_progress ? array(
            'persentase' => $catatan->latest_progress->persentase,
            'deskripsi' => $catatan->latest_progress->deskripsi_progress
        ) : null)
    );
}));

// Schedule data for calendar
const scheduleData = @json($jadwals->map(function($jadwal) {
    return array(
        'id' => $jadwal->id_jadwal,
        'start' => $jadwal->tanggal_mulai->toDateString(),
        'end' => $jadwal->tanggal_akhir->toDateString(),
        'startTime' => $jadwal->jam_mulai->format('H:i'),
        'endTime' => $jadwal->jam_akhir->format('H:i'),
        'status' => $jadwal->status,
        'status_label' => $jadwal->status_label,
        'hari' => $jadwal->hari
    );
}));

function showAllNotes() {
    document.getElementById('allNotesModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeAllNotes() {
    document.getElementById('allNotesModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function showNoteDetail(noteId) {
    const note = notesData[noteId];
    if (!note) return;
    
    const statusClass = note.status === 'completed' ? 'bg-green-100 text-green-800' :
                       note.status === 'published' ? 'bg-blue-100 text-blue-800' :
                       note.status === 'reviewed' ? 'bg-yellow-100 text-yellow-800' :
                       'bg-gray-100 text-gray-800';
    
        const content = `
        <div class="border-b border-gray-200 pb-4 mb-4">
            <div class="flex items-center justify-between">
                <h4 class="text-lg font-semibold text-gray-900">${note.tanggal}</h4>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${statusClass}">
                    ${note.status_label}
                </span>
            </div>
        </div>
        
        <div class="space-y-4">
            <div>
                <h5 class="text-sm font-medium text-gray-700 mb-2">Hasil Bimbingan:</h5>
                <div class="bg-gray-50 rounded-lg p-3 text-sm text-gray-700">${note.hasil_bimbingan || 'Tidak ada catatan hasil bimbingan'}</div>
            </div>
            
            ${note.tugas_perbaikan ? `
            <div>
                <h5 class="text-sm font-medium text-gray-700 mb-2">Tugas Perbaikan:</h5>
                <div class="bg-yellow-50 rounded-lg p-3 text-sm text-gray-700">${note.tugas_perbaikan}</div>
            </div>
            ` : ''}
            
            ${note.catatan_mentor ? `
            <div>
                <h5 class="text-sm font-medium text-gray-700 mb-2">Catatan Mentor:</h5>
                <div class="bg-blue-50 rounded-lg p-3 text-sm text-gray-700">${note.catatan_mentor}</div>
            </div>
            ` : ''}
            
            ${note.progress ? `
            <div>
                <h5 class="text-sm font-medium text-gray-700 mb-2">Progress:</h5>
                <div class="bg-green-50 rounded-lg p-3">
                    <div class="flex items-center mb-2">
                        <div class="w-32 bg-gray-200 rounded-full h-2 mr-3">
                            <div class="bg-green-600 h-2 rounded-full" style="width: ${note.progress.persentase}%"></div>
                        </div>
                        <span class="text-sm font-medium text-green-600">${note.progress.persentase}%</span>
                    </div>
                    <p class="text-sm text-gray-600">${note.progress.deskripsi}</p>
                </div>
            </div>
            ` : ''}
        </div>
    `;
    
    document.getElementById('noteDetailContent').innerHTML = content;
    document.getElementById('noteDetailModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeNoteDetail() {
    document.getElementById('noteDetailModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function showScheduleCalendar() {
    document.getElementById('scheduleCalendarModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    renderPesertaCalendar();
}

function closeScheduleCalendar() {
    document.getElementById('scheduleCalendarModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Calendar functionality for peserta
let currentPeserta = new Date();
let selectedDatePeserta = null;

const monthNames = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

function formatDateKey(d) {
    const y = d.getFullYear();
    const m = String(d.getMonth()+1).padStart(2,'0');
    const day = String(d.getDate()).padStart(2,'0');
    return `${y}-${m}-${day}`;
}

function dateInRange(dateStr, startStr, endStr) {
    if(!startStr || !endStr) return false;
    return dateStr >= startStr && dateStr <= endStr;
}

function renderPesertaCalendar() {
    const year = currentPeserta.getFullYear();
    const month = currentPeserta.getMonth();
    document.getElementById('currentMonthPeserta').textContent = `${monthNames[month]} ${year}`;

    const firstDay = new Date(year, month, 1);
    const lastDay = new Date(year, month + 1, 0);

    let startOffset = firstDay.getDay();
    startOffset = (startOffset === 0) ? 6 : startOffset - 1;

    const calendarGrid = document.getElementById('calendarGridPeserta');
    calendarGrid.innerHTML = '';

    // Previous month placeholders
    for(let i=0; i<startOffset; i++){
        const cell = document.createElement('div');
        cell.className = 'border rounded-lg p-2 h-24 bg-gray-50';
        calendarGrid.appendChild(cell);
    }

    for(let day=1; day<=lastDay.getDate(); day++){
        const d = new Date(year, month, day);
        const key = formatDateKey(d);

        const cell = document.createElement('div');
        cell.className = 'border rounded-lg p-2 h-24 hover:shadow transition cursor-pointer relative';

        const label = document.createElement('div');
        label.className = 'text-xs font-semibold text-gray-600';
        label.textContent = day;
        cell.appendChild(label);

        const daySchedules = scheduleData.filter(s => dateInRange(key, s.start, s.end));
        
        const container = document.createElement('div');
        container.className = 'mt-1 space-y-1 overflow-y-auto max-h-16';

        daySchedules.slice(0,2).forEach(s => {
            const chip = document.createElement('div');
            const colorMap = {
                scheduled: 'bg-blue-100 text-blue-800',
                ongoing: 'bg-green-100 text-green-800',
                completed: 'bg-gray-100 text-gray-800',
                cancelled: 'bg-red-100 text-red-800',
            };
            chip.className = `text-xs ${colorMap[s.status] || 'bg-gray-100 text-gray-800'} px-1 py-0.5 rounded truncate`;
            chip.textContent = `${s.startTime}-${s.endTime}`;
            container.appendChild(chip);
        });

        if(daySchedules.length > 2){
            const more = document.createElement('div');
            more.className = 'text-xs text-gray-500';
            more.textContent = `+${daySchedules.length - 2}`;
            container.appendChild(more);
        }

        cell.appendChild(container);

        const today = new Date();
        if(today.toDateString() === d.toDateString()){
            const dot = document.createElement('div');
            dot.className = 'w-1.5 h-1.5 bg-green-500 rounded-full absolute top-1 right-1';
            cell.appendChild(dot);
        }

        cell.addEventListener('click', () => {
            selectedDatePeserta = key;
            renderSelectedDayPeserta();
        });

        calendarGrid.appendChild(cell);
    }
}

function renderSelectedDayPeserta() {
    if(!selectedDatePeserta) return;
    
    document.getElementById('selectedDateLabelPeserta').textContent = 
        new Date(selectedDatePeserta).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });

    const daySchedules = scheduleData.filter(s => dateInRange(selectedDatePeserta, s.start, s.end));

    if(daySchedules.length === 0){
        document.getElementById('selectedDayListPeserta').innerHTML = 
            '<p class="text-gray-500 text-sm">Tidak ada jadwal pada tanggal ini.</p>';
        return;
    }

    const html = daySchedules.map(s => `
        <div class="flex items-center justify-between p-3 mb-2 bg-white rounded-lg border">
            <div>
                <div class="font-medium text-gray-900">${s.startTime} - ${s.endTime}</div>
                ${s.hari ? `<div class="text-sm text-gray-500">${s.hari}</div>` : ''}
            </div>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                ${s.status === 'scheduled' ? 'bg-blue-100 text-blue-800' :
                  s.status === 'ongoing' ? 'bg-green-100 text-green-800' :
                  s.status === 'completed' ? 'bg-gray-100 text-gray-800' :
                  'bg-red-100 text-red-800'}">
                ${s.status_label}
            </span>
        </div>
    `).join('');

    document.getElementById('selectedDayListPeserta').innerHTML = html;
}

// Event listeners
document.getElementById('prevMonthPeserta').addEventListener('click', () => {
    currentPeserta.setMonth(currentPeserta.getMonth() - 1);
    renderPesertaCalendar();
});

document.getElementById('nextMonthPeserta').addEventListener('click', () => {
    currentPeserta.setMonth(currentPeserta.getMonth() + 1);
    renderPesertaCalendar();
});

// Close modals when clicking outside
document.getElementById('allNotesModal').addEventListener('click', function(e) {
    if (e.target === this) closeAllNotes();
});

document.getElementById('noteDetailModal').addEventListener('click', function(e) {
    if (e.target === this) closeNoteDetail();
});

document.getElementById('scheduleCalendarModal').addEventListener('click', function(e) {
    if (e.target === this) closeScheduleCalendar();
});

// Close modals with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeAllNotes();
        closeNoteDetail();
        closeScheduleCalendar();
    }
});
</script>
@endpush
@endsection