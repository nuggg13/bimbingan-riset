@extends('mentor.layout')

@section('title', 'Catatan Bimbingan')

@section('content')
<div class="space-y-6">
    <!-- Header + Search -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Catatan Bimbingan</h1>
                <p class="text-gray-600 mt-1">Kelola catatan dan progress bimbingan peserta Anda</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                <div class="relative">
                    <input id="catatanSearch" type="text" placeholder="Cari nama peserta, hasil bimbingan, status..." class="w-full sm:w-80 pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" />
                    <i class="fas fa-search absolute left-3 top-2.5 text-gray-400"></i>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('mentor.catatan-bimbingan.export') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
                        <i class="fas fa-download mr-2"></i>Export
                    </a>
                    <a href="{{ route('mentor.catatan-bimbingan.create') }}" 
                       class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
                        <i class="fas fa-plus mr-2"></i>Tambah Catatan
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- Catatan Bimbingan List -->
    <div class="bg-white rounded-lg shadow-sm">
        @if($catatanBimbingan->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Peserta
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal Bimbingan
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Hasil Bimbingan & Progress Terbaru
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
                        @foreach($catatanBimbingan as $catatan)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-user text-green-600"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $catatan->peserta->nama }}</div>
                                            <div class="text-sm text-gray-500">{{ $catatan->peserta->instansi }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $catatan->tanggal_bimbingan->format('d M Y') }}</div>
                                    <div class="text-sm text-gray-500">{{ $catatan->tanggal_bimbingan->diffForHumans() }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 mb-2">{{ Str::limit($catatan->hasil_bimbingan, 100) }}</div>
                                    @if($catatan->tugas_perbaikan)
                                        <div class="text-sm text-gray-500 mb-2">
                                            <strong>Tugas:</strong> {{ Str::limit($catatan->tugas_perbaikan, 80) }}
                                        </div>
                                    @endif
                                    @if($catatan->latest_progress)
                                        <div class="flex items-center mt-2">
                                            <div class="w-16 bg-gray-200 rounded-full h-2 mr-3">
                                                <div class="bg-green-600 h-2 rounded-full" 
                                                     style="width: {{ $catatan->latest_progress->persentase }}%"></div>
                                            </div>
                                            <span class="text-sm font-medium text-green-600">{{ $catatan->latest_progress->persentase }}%</span>
                                        </div>
                                    @else
                                        <div class="flex items-center mt-2">
                                            <div class="w-16 bg-gray-200 rounded-full h-2 mr-3">
                                                <div class="bg-gray-400 h-2 rounded-full" style="width: 0%"></div>
                                            </div>
                                            <span class="text-sm text-gray-500">0%</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($catatan->status == 'completed') bg-green-100 text-green-800
                                        @elseif($catatan->status == 'published') bg-blue-100 text-blue-800
                                        @elseif($catatan->status == 'reviewed') bg-yellow-100 text-yellow-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ $catatan->status_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('mentor.catatan-bimbingan.show', $catatan->id_catatan) }}" 
                                       class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-lg text-sm font-medium transition duration-200">
                                        <i class="fas fa-eye mr-1"></i>Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $catatanBimbingan->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-sticky-note text-gray-400 text-6xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Catatan Bimbingan</h3>
                <p class="text-gray-500 mb-6">Mulai dengan menambahkan catatan bimbingan pertama untuk peserta Anda.</p>
                <a href="{{ route('mentor.catatan-bimbingan.create') }}" 
                   class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg text-sm font-medium transition duration-200">
                    <i class="fas fa-plus mr-2"></i>Tambah Catatan Bimbingan
                </a>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('catatanSearch');
    const tableRows = document.querySelectorAll('tbody tr');
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        tableRows.forEach(row => {
            const participantName = row.querySelector('td:nth-child(1) .text-gray-900').textContent.toLowerCase();
            const participantInstansi = row.querySelector('td:nth-child(1) .text-gray-500').textContent.toLowerCase();
            const hasilBimbingan = row.querySelector('td:nth-child(3) .text-gray-900').textContent.toLowerCase();
            const tugasPerbaikan = row.querySelector('td:nth-child(3) strong') ? 
                                 row.querySelector('td:nth-child(3) strong').parentElement.textContent.toLowerCase() : '';
            const status = row.querySelector('td:nth-child(4) span').textContent.toLowerCase();
            
            const isVisible = participantName.includes(searchTerm) ||
                            participantInstansi.includes(searchTerm) ||
                            hasilBimbingan.includes(searchTerm) ||
                            tugasPerbaikan.includes(searchTerm) ||
                            status.includes(searchTerm);
            
            if (isVisible) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});
</script>
@endpush
@endsection