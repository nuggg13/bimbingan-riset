@extends('mentor.layout')

@section('title', 'Jadwal Bimbingan')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Jadwal Bimbingan</h1>
                <p class="text-gray-600 mt-1">Daftar semua jadwal bimbingan Anda</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500">Total Jadwal</p>
                <p class="text-2xl font-bold text-green-600">{{ $jadwals->count() }}</p>
            </div>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex flex-wrap gap-2">
            <button onclick="filterSchedules('all')" class="filter-btn active px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
                Semua ({{ $jadwals->count() }})
            </button>
            <button onclick="filterSchedules('scheduled')" class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
                Terjadwal ({{ $jadwals->where('status', 'scheduled')->count() }})
            </button>
            <button onclick="filterSchedules('ongoing')" class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
                Berlangsung ({{ $jadwals->where('status', 'ongoing')->count() }})
            </button>
            <button onclick="filterSchedules('completed')" class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
                Selesai ({{ $jadwals->where('status', 'completed')->count() }})
            </button>
            <button onclick="filterSchedules('cancelled')" class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
                Dibatalkan ({{ $jadwals->where('status', 'cancelled')->count() }})
            </button>
        </div>
    </div>

    <!-- Schedules List -->
    <div class="bg-white rounded-lg shadow-sm">
        @if($jadwals->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Peserta & Riset
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Periode
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Jadwal
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($jadwals as $jadwal)
                            <tr class="hover:bg-gray-50 schedule-row" data-status="{{ $jadwal->status }}">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-user text-blue-600"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $jadwal->pendaftaran->peserta->nama }}</div>
                                            <div class="text-sm text-gray-500">{{ $jadwal->pendaftaran->peserta->instansi }}</div>
                                            <div class="text-sm text-gray-600 font-medium mt-1">{{ $jadwal->pendaftaran->judul_riset }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $jadwal->tanggal_mulai->format('d M Y') }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        s/d {{ $jadwal->tanggal_akhir->format('d M Y') }}
                                    </div>
                                    <div class="text-xs text-gray-400 mt-1">
                                        {{ $jadwal->tanggal_mulai->diffInDays($jadwal->tanggal_akhir) + 1 }} hari
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_akhir)->format('H:i') }}
                                    </div>
                                    @if($jadwal->hari)
                                        <div class="text-sm text-gray-500">{{ $jadwal->formatted_hari }}</div>
                                    @endif
                                    <div class="text-xs text-gray-400 mt-1">{{ $jadwal->schedule_description }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($jadwal->status == 'scheduled') bg-blue-100 text-blue-800
                                        @elseif($jadwal->status == 'ongoing') bg-green-100 text-green-800
                                        @elseif($jadwal->status == 'completed') bg-gray-100 text-gray-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ $jadwal->status_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('mentor.participants.detail', $jadwal->pendaftaran->peserta->id_peserta) }}" 
                                           class="text-green-600 hover:text-green-900">
                                            <i class="fas fa-eye mr-1"></i>Detail
                                        </a>
                                        <a href="https://wa.me/{{ str_replace(['+', '-', ' '], '', $jadwal->pendaftaran->peserta->nomor_wa) }}" 
                                           target="_blank"
                                           class="text-green-600 hover:text-green-900">
                                            <i class="fab fa-whatsapp mr-1"></i>Chat
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-calendar text-gray-400 text-6xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Jadwal</h3>
                <p class="text-gray-500">Anda belum memiliki jadwal bimbingan.</p>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function filterSchedules(status) {
    // Update active button
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('active', 'bg-green-100', 'text-green-700');
        btn.classList.add('bg-gray-100', 'text-gray-700');
    });
    
    event.target.classList.remove('bg-gray-100', 'text-gray-700');
    event.target.classList.add('active', 'bg-green-100', 'text-green-700');
    
    // Filter rows
    document.querySelectorAll('.schedule-row').forEach(row => {
        if (status === 'all' || row.dataset.status === status) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

// Initialize filter buttons
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.filter-btn').forEach(btn => {
        if (btn.classList.contains('active')) {
            btn.classList.add('bg-green-100', 'text-green-700');
        } else {
            btn.classList.add('bg-gray-100', 'text-gray-700');
        }
    });
});
</script>
@endpush
@endsection