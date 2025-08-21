@extends('mentor.layout')

@section('title', 'Peserta Bimbingan')

@section('content')
<div class="space-y-6">
    <!-- Header + Search -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Peserta Bimbingan</h1>
                <p class="text-gray-600 mt-1">Daftar peserta yang Anda bimbing</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                <div class="relative">
                    <input id="participantSearch" type="text" placeholder="Cari nama, email, instansi, judul riset..." class="w-full sm:w-80 pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" />
                    <i class="fas fa-search absolute left-3 top-2.5 text-gray-400"></i>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Total Peserta</p>
                    <p class="text-2xl font-bold text-green-600" id="participantCount">{{ $participants->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Participants List -->
    <div class="bg-white rounded-lg shadow-sm">
        @if($participants->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Peserta
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Judul Riset
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
                        @foreach($participants as $participant)
                            @php
                                $jadwal = $participant->pendaftaran->jadwals->first();
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-user text-green-600"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $participant->nama }}</div>
                                            <div class="text-sm text-gray-500">{{ $participant->email }}</div>
                                            <div class="text-sm text-gray-500">{{ $participant->instansi }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 font-medium" style="max-width: 220px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $participant->pendaftaran->judul_riset }}">
                                        {{ $participant->pendaftaran->judul_riset }}
                                    </div>
                                    <div class="text-sm text-gray-500">{{ $participant->pendaftaran->minat_keilmuan }}</div>
                                    <div class="text-sm text-gray-500">{{ $participant->pendaftaran->basis_sistem }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($jadwal)
                                        <div class="text-sm text-gray-900">{{ $jadwal->schedule_description }}</div>
                                        <div class="text-sm text-gray-500">
                                            {{ $jadwal->tanggal_mulai->format('d M Y') }} - {{ $jadwal->tanggal_akhir->format('d M Y') }}
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-500">Belum dijadwalkan</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($jadwal)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($jadwal->status == 'scheduled') bg-blue-100 text-blue-800
                                            @elseif($jadwal->status == 'ongoing') bg-green-100 text-green-800
                                            @elseif($jadwal->status == 'completed') bg-gray-100 text-gray-800
                                            @else bg-red-100 text-red-800
                                            @endif">
                                            {{ $jadwal->status_label }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Menunggu Jadwal
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('mentor.participants.detail', $participant->id_peserta) }}" 
                                       class="text-green-600 hover:text-green-900">
                                        <i class="fas fa-eye mr-1"></i>Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-users text-gray-400 text-6xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Peserta</h3>
                <p class="text-gray-500">Anda belum memiliki peserta yang dibimbing.</p>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('participantSearch');
    const participantCount = document.getElementById('participantCount');
    const tableRows = document.querySelectorAll('tbody tr');
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        let visibleCount = 0;
        
        tableRows.forEach(row => {
            const participantName = row.querySelector('td:nth-child(1) .text-gray-900').textContent.toLowerCase();
            const participantEmail = row.querySelector('td:nth-child(1) .text-gray-500:nth-child(1)').textContent.toLowerCase();
            const participantInstansi = row.querySelector('td:nth-child(1) .text-gray-500:nth-child(2)').textContent.toLowerCase();
            const judulRiset = row.querySelector('td:nth-child(2) .font-medium').textContent.toLowerCase();
            const minatKeilmuan = row.querySelector('td:nth-child(2) .text-gray-500:nth-child(1)').textContent.toLowerCase();
            const basisSistem = row.querySelector('td:nth-child(2) .text-gray-500:nth-child(2)').textContent.toLowerCase();
            
            const isVisible = participantName.includes(searchTerm) ||
                            participantEmail.includes(searchTerm) ||
                            participantInstansi.includes(searchTerm) ||
                            judulRiset.includes(searchTerm) ||
                            minatKeilmuan.includes(searchTerm) ||
                            basisSistem.includes(searchTerm);
            
            if (isVisible) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });
        
        participantCount.textContent = visibleCount;
    });
});
</script>
@endpush
@endsection