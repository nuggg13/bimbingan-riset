@extends('admin.layout')

@section('title', 'Pendaftaran - Admin')

@section('content')
<!-- Loading Overlay -->
<div id="initial-loading" class="fixed inset-0 bg-white bg-opacity-90 flex items-center justify-center z-50 transition-opacity duration-300">
    <div class="text-center">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-4"></div>
        <p class="text-gray-600">Memuat data pendaftaran...</p>
    </div>
</div>
<div class="mb-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Daftar Pendaftaran</h2>
            <p class="text-gray-600">Data dari tabel <code>pendaftaran</code> dengan relasi ke tabel <code>peserta</code>.</p>
        </div>

    </div>

    

     
     @if(request('status') && request('status') !== 'semua' || request('search'))
         <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
             <div class="flex items-center justify-between">
                 <div class="flex items-center space-x-2">
                     <i class="fas fa-filter text-blue-600"></i>
                     <span class="text-sm font-medium text-blue-800">Filter Aktif:</span>
                 </div>
                 <a href="{{ route('admin.pendaftaran.index') }}" class="text-sm text-blue-600 hover:text-blue-800 underline">
                     <i class="fas fa-times mr-1"></i>
                     Hapus Semua Filter
                 </a>
             </div>
             <div class="mt-2 flex flex-wrap gap-2">
                 @if(request('status') && request('status') !== 'semua')
                     <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full">
                         Status: {{ ucfirst(request('status')) }}
                     </span>
                 @endif
                 @if(request('search'))
                     <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">
                         Pencarian: "{{ request('search') }}"
                     </span>
                 @endif
             </div>
         </div>
     @endif
 </div>

 @if (session('success'))
     <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center justify-between">
         <div class="flex items-center">
             <i class="fas fa-check-circle mr-2 text-green-600"></i>
             <span class="font-medium">{{ session('success') }}</span>
         </div>
         <button type="button" class="text-green-600 hover:text-green-800" onclick="this.parentElement.remove()">
             <i class="fas fa-times"></i>
         </button>
     </div>
 @endif

<!-- Statistics Section -->
<div class="grid grid-cols-1 md:grid-cols-7 gap-4 mb-6">
    <a href="{{ route('admin.pendaftaran.index') }}" class="bg-white shadow rounded-lg p-4 hover:shadow-md transition-shadow duration-200 cursor-pointer {{ !request('status') || request('status') === 'semua' ? 'ring-2 ring-blue-500' : '' }}" title="Lihat semua pendaftaran">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-list text-blue-600 text-sm"></i>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Total</p>
                <p class="text-lg font-semibold text-gray-900">{{ $statistics['total'] }}</p>
            </div>
        </div>
    </a>
    <a href="{{ route('admin.pendaftaran.index', ['status' => 'pending']) }}" class="bg-white shadow rounded-lg p-4 hover:shadow-md transition-shadow duration-200 cursor-pointer {{ request('status') === 'pending' ? 'ring-2 ring-yellow-500' : '' }}" title="Lihat pendaftaran dengan status pending">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-600 text-sm"></i>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Pending</p>
                <p class="text-lg font-semibold text-gray-900">{{ $statistics['pending'] }}</p>
            </div>
        </div>
    </a>
    <a href="{{ route('admin.pendaftaran.index', ['status' => 'review']) }}" class="bg-white shadow rounded-lg p-4 hover:shadow-md transition-shadow duration-200 cursor-pointer {{ request('status') === 'review' ? 'ring-2 ring-blue-500' : '' }}" title="Lihat pendaftaran dengan status review">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-eye text-blue-600 text-sm"></i>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Review</p>
                <p class="text-lg font-semibold text-gray-900">{{ $statistics['review'] }}</p>
            </div>
        </div>
    </a>
    <a href="{{ route('admin.pendaftaran.index', ['status' => 'konsultasi']) }}" class="bg-white shadow rounded-lg p-4 hover:shadow-md transition-shadow duration-200 cursor-pointer {{ request('status') === 'konsultasi' ? 'ring-2 ring-purple-500' : '' }}" title="Lihat pendaftaran dengan status konsultasi">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-comments text-purple-600 text-sm"></i>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Konsultasi</p>
                <p class="text-lg font-semibold text-gray-900">{{ $statistics['konsultasi'] }}</p>
            </div>
        </div>
    </a>
    <a href="{{ route('admin.pendaftaran.index', ['status' => 'diterima']) }}" class="bg-white shadow rounded-lg p-4 hover:shadow-md transition-shadow duration-200 cursor-pointer {{ request('status') === 'diterima' ? 'ring-2 ring-green-500' : '' }}" title="Lihat pendaftaran dengan status diterima">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-check text-green-600 text-sm"></i>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Diterima</p>
                <p class="text-lg font-semibold text-gray-900">{{ $statistics['diterima'] }}</p>
            </div>
        </div>
    </a>
    <a href="{{ route('admin.pendaftaran.index', ['status' => 'ditolak']) }}" class="bg-white shadow rounded-lg p-4 hover:shadow-md transition-shadow duration-200 cursor-pointer {{ request('status') === 'ditolak' ? 'ring-2 ring-red-500' : '' }}" title="Lihat pendaftaran dengan status ditolak">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-times text-red-600 text-sm"></i>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Ditolak</p>
                <p class="text-lg font-semibold text-gray-900">{{ $statistics['ditolak'] }}</p>
            </div>
        </div>
    </a>

</div>

<!-- Filter Section -->
<div class="bg-white shadow rounded-lg mb-6">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900 flex items-center">
            <i class="fas fa-filter mr-2 text-blue-600"></i>
            Filter Pendaftaran
        </h3>
    </div>
    <div class="px-6 py-4">
        <form method="GET" action="{{ route('admin.pendaftaran.index') }}" class="space-y-4 sm:space-y-0 sm:flex sm:items-end sm:gap-4">
            <div class="flex-1 min-w-0">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Nama/Judul</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" 
                       placeholder="Cari berdasarkan nama peserta atau judul riset..." 
                       class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
            </div>
            <div class="flex-1 min-w-0">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status Pendaftaran</label>
                <select name="status" id="status" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                    @foreach($statusOptions as $value => $label)
                        <option value="{{ $value }}" {{ request('status', 'semua') == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col sm:flex-row gap-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center">
                    <i class="fas fa-search mr-2"></i>
                    Filter
                </button>
                <a href="{{ route('admin.pendaftaran.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center">
                    <i class="fas fa-times mr-2"></i>
                    Reset
                </a>
                <a href="{{ route('admin.pendaftaran.export', request()->query()) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center" onclick="showExportLoading(this)">
                    <i class="fas fa-download mr-2"></i>
                    Export CSV
                </a>
            </div>
        </form>
    </div>
</div>

<div class="bg-white shadow overflow-hidden sm:rounded-lg">
    <!-- Info Section -->
    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex flex-wrap items-center gap-3">
                <span class="text-sm text-gray-600 flex items-center">
                    <i class="fas fa-list mr-1"></i>
                    Menampilkan {{ $pendaftaran->count() }} dari {{ $pendaftaran->total() }} data
                </span>
                @if(request('status') && request('status') !== 'semua')
                    <span class="text-sm bg-blue-100 text-blue-800 px-2 py-1 rounded-full flex items-center">
                        <i class="fas fa-filter mr-1"></i>
                        Status: {{ ucfirst(request('status')) }}
                    </span>
                @endif
                @if(request('search'))
                    <span class="text-sm bg-green-100 text-green-800 px-2 py-1 rounded-full flex items-center">
                        <i class="fas fa-search mr-1"></i>
                        Pencarian: "{{ request('search') }}"
                    </span>
                @endif
                @if(request('status') && request('status') !== 'semua' || request('search'))
                    <a href="{{ route('admin.pendaftaran.index') }}" class="text-sm bg-red-100 text-red-800 px-2 py-1 rounded-full hover:bg-red-200 transition-colors duration-200 flex items-center">
                        <i class="fas fa-times mr-1"></i>
                        Hapus Filter
                    </a>
                @endif
            </div>
            <div class="text-sm text-gray-500 flex items-center">
                <i class="fas fa-file-alt mr-1"></i>
                Halaman {{ $pendaftaran->currentPage() }} dari {{ $pendaftaran->lastPage() }}
                <span class="mx-2">•</span>
                <i class="fas fa-clock mr-1"></i>
                Terakhir update: {{ now()->format('d/m/Y H:i') }}
            </div>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peserta</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">WhatsApp</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ubah Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detail</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($pendaftaran as $row)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $row->id_pendaftaran }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm">
                            <div class="font-medium text-gray-900">{{ $row->peserta->nama ?? 'N/A' }}</div>
                            <div class="text-gray-500">{{ $row->peserta->fakultas ?? 'N/A' }}</div>
                            <div class="text-gray-500 text-xs">{{ $row->peserta->instansi ?? 'N/A' }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($row->peserta && $row->peserta->nomor_wa)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $row->peserta->nomor_wa) }}" 
                               target="_blank" 
                               class="inline-flex items-center px-3 py-1.5 bg-green-100 text-green-800 text-sm rounded-lg hover:bg-green-200 transition-colors duration-200 group relative"
                               title="Chat WhatsApp dengan {{ $row->peserta->nama }}">
                                <i class="fab fa-whatsapp mr-2 text-green-600"></i>
                                {{ $row->peserta->nomor_wa }}
                                <span class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap">
                                    Klik untuk chat WhatsApp
                                </span>
                            </a>
                        @else
                            <span class="text-gray-400 text-sm">Tidak tersedia</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $status = $row->status ?? 'pending';
                            $badgeClass = [
                                'diterima' => 'bg-green-100 text-green-800',
                                'ditolak' => 'bg-red-100 text-red-800',
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'review' => 'bg-blue-100 text-blue-800',
                                'konsultasi' => 'bg-purple-100 text-purple-800',
                            ][$status] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeClass }}">
                            {{ ucfirst($status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <form method="POST" action="{{ route('admin.pendaftaran.updateStatus', $row->id_pendaftaran) }}" class="flex items-center space-x-2">
                            @csrf
                            @method('PATCH')
                            <select name="status" class="border-gray-300 rounded-lg text-sm px-2 py-1 focus:ring-blue-500 focus:border-blue-500">
                                <option value="diterima" {{ $row->status === 'diterima' ? 'selected' : '' }}>diterima</option>
                                <option value="ditolak" {{ $row->status === 'ditolak' ? 'selected' : '' }}>ditolak</option>
                                <option value="pending" {{ $row->status === 'pending' ? 'selected' : '' }}>pending</option>
                                <option value="review" {{ $row->status === 'review' ? 'selected' : '' }}>review</option>
                                <option value="konsultasi" {{ $row->status === 'konsultasi' ? 'selected' : '' }}>konsultasi</option>
                            </select>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-3 py-1.5 rounded-lg transition-colors duration-200" onclick="showStatusUpdateLoading(this)">
                                Ubah
                            </button>
                        </form>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ optional($row->created_at)->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-700">
                        <button type="button" class="underline hover:no-underline" data-modal-target="modal-pendaftaran-{{ $row->id_pendaftaran }}">
                            Detail
                        </button>
                    </td>
                </tr>
                <!-- Modal Detail akan dirender di bawah tabel -->
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-search text-gray-400 text-xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">
                                @if(request('search') || (request('status') && request('status') !== 'semua'))
                                    Tidak ada data yang ditemukan
                                @else
                                    Belum ada data pendaftaran
                                @endif
                            </h3>
                            <p class="text-gray-500 mb-4">
                                @if(request('search') || (request('status') && request('status') !== 'semua'))
                                    Coba ubah filter atau kata kunci pencarian Anda.
                                @else
                                    Data pendaftaran akan muncul di sini setelah ada peserta yang mendaftar.
                                @endif
                            </p>
                            @if(request('search') || (request('status') && request('status') !== 'semua'))
                                <a href="{{ route('admin.pendaftaran.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                                    <i class="fas fa-times mr-2"></i>
                                    Hapus Filter
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-4 py-3 bg-gray-50 border-t border-gray-200">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-500">
                Menampilkan {{ $pendaftaran->firstItem() ?? 0 }} - {{ $pendaftaran->lastItem() ?? 0 }} dari {{ $pendaftaran->total() }} data
            </div>
            <div>
                {{ $pendaftaran->links() }}
            </div>
        </div>
    </div>
</div>
<!-- Render semua modal di luar tabel agar tidak tertutup oleh display: none tabel -->
@foreach ($pendaftaran as $row)
<div id="modal-pendaftaran-{{ $row->id_pendaftaran }}" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-all duration-300" data-modal-close></div>
    <div class="flex min-h-screen items-start justify-center p-4">
        <div class="relative w-full max-w-5xl bg-white rounded-2xl shadow-2xl overflow-hidden transform transition-all duration-300 max-h-[85vh] flex flex-col">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-8 py-6 text-white flex-shrink-0">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                            <i class="fas fa-file-alt text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold">Detail Pendaftaran</h3>
                            <p class="text-blue-100 text-sm">#{{ $row->id_pendaftaran }}</p>
                        </div>
                    </div>
                    <button class="w-8 h-8 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center transition-colors duration-200" data-modal-close>
                        <i class="fas fa-times text-sm"></i>
                    </button>
                </div>
            </div>

            <!-- Content -->
            <div class="p-8 overflow-y-auto flex-1">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Data Pendaftaran -->
                    <div class="space-y-6">
                        <div class="flex items-center space-x-2 mb-4">
                            <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-clipboard-list text-blue-600 text-xs"></i>
                            </div>
                            <h4 class="font-bold text-gray-800 text-lg">Data Pendaftaran</h4>
                        </div>
                        
                        <div class="space-y-5">
                            <div class="group hover:bg-gray-50 p-4 rounded-xl transition-colors duration-200">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">ID Pendaftaran</p>
                                <p class="text-sm font-semibold text-gray-900 bg-blue-50 inline-block px-3 py-1 rounded-full">{{ $row->id_pendaftaran }}</p>
                            </div>
                            <div class="group hover:bg-gray-50 p-4 rounded-xl transition-colors duration-200">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Judul Riset</p>
                                <p class="text-sm font-medium text-gray-900 leading-relaxed">{{ $row->judul_riset }}</p>
                            </div>
                            <div class="group hover:bg-gray-50 p-4 rounded-xl transition-colors duration-200">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Penjelasan</p>
                                <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">{{ $row->penjelasan }}</p>
                            </div>
                            <div class="group hover:bg-gray-50 p-4 rounded-xl transition-colors duration-200">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Minat Keilmuan</p>
                                <p class="text-sm font-medium text-gray-900">
                                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">{{ $row->minat_keilmuan }}</span>
                                </p>
                            </div>
                            <div class="group hover:bg-gray-50 p-4 rounded-xl transition-colors duration-200">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Berbasis</p>
                                <p class="text-sm font-medium text-gray-900">
                                    <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-xs font-semibold">{{ $row->basis_sistem ?? '-' }}</span>
                                </p>
                            </div>
                            <div class="group hover:bg-gray-50 p-4 rounded-xl transition-colors duration-200">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Status</p>
                                <p class="text-sm font-medium text-gray-900">
                                    <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-semibold flex items-center w-fit">
                                        <i class="fas fa-clock text-xs mr-2"></i>
                                        {{ $row->status ?? '-' }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Data Peserta -->
                    <div class="space-y-6">
                        <div class="flex items-center space-x-2 mb-4">
                            <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-green-600 text-xs"></i>
                            </div>
                            <h4 class="font-bold text-gray-800 text-lg">Data Peserta</h4>
                        </div>
                        
                        <div class="space-y-5">
                            <div class="group hover:bg-gray-50 p-4 rounded-xl transition-colors duration-200">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">ID Peserta</p>
                                <p class="text-sm font-semibold text-gray-900 bg-green-50 inline-block px-3 py-1 rounded-full">{{ $row->id_peserta }}</p>
                            </div>
                            <div class="group hover:bg-gray-50 p-4 rounded-xl transition-colors duration-200">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Nama</p>
                                <p class="text-sm font-medium text-gray-900 flex items-center">
                                    <i class="fas fa-user-circle text-gray-400 mr-2"></i>
                                    {{ $row->peserta->nama ?? 'N/A' }}
                                </p>
                            </div>
                            <div class="group hover:bg-gray-50 p-4 rounded-xl transition-colors duration-200">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Fakultas</p>
                                <p class="text-sm font-medium text-gray-900 flex items-center">
                                    <i class="fas fa-graduation-cap text-gray-400 mr-2"></i>
                                    {{ $row->peserta->fakultas ?? 'N/A' }}
                                </p>
                            </div>
                            <div class="group hover:bg-gray-50 p-4 rounded-xl transition-colors duration-200">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Instansi</p>
                                <p class="text-sm font-medium text-gray-900 flex items-center">
                                    <i class="fas fa-university text-gray-400 mr-2"></i>
                                    {{ $row->peserta->instansi ?? 'N/A' }}
                                </p>
                            </div>
                            <div class="group hover:bg-gray-50 p-4 rounded-xl transition-colors duration-200">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">WhatsApp</p>
                                @if($row->peserta && $row->peserta->nomor_wa)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $row->peserta->nomor_wa) }}" 
                                       target="_blank" 
                                       class="text-sm font-medium text-green-600 hover:text-green-800 flex items-center transition-colors duration-200">
                                        <i class="fab fa-whatsapp text-gray-400 mr-2"></i>
                                        {{ $row->peserta->nomor_wa }}
                                        <i class="fas fa-external-link-alt ml-2 text-xs"></i>
                                    </a>
                                @else
                                    <p class="text-sm font-medium text-gray-500 flex items-center">
                                        <i class="fas fa-phone text-gray-400 mr-2"></i>
                                        Tidak tersedia
                                    </p>
                                @endif
                            </div>
                            <div class="group hover:bg-gray-50 p-4 rounded-xl transition-colors duration-200">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Dibuat</p>
                                <p class="text-sm font-medium text-gray-900 flex items-center">
                                    <i class="fas fa-calendar-plus text-gray-400 mr-2"></i>
                                    {{ optional($row->created_at)->format('d/m/Y H:i') }}
                                </p>
                            </div>
                            <div class="group hover:bg-gray-50 p-4 rounded-xl transition-colors duration-200">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Diubah</p>
                                <p class="text-sm font-medium text-gray-900 flex items-center">
                                    <i class="fas fa-calendar-edit text-gray-400 mr-2"></i>
                                    {{ optional($row->updated_at)->format('d/m/Y H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="px-8 py-6 bg-gray-50 border-t border-gray-200 flex-shrink-0">
                <div class="flex justify-end">
                    <button class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl font-semibold transition-colors duration-200 flex items-center space-x-2 shadow-sm hover:shadow-md" data-modal-close>
                        <i class="fas fa-times text-sm"></i>
                        <span>Tutup</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection


@push('scripts')
<script>
// Gunakan event delegation agar bekerja untuk elemen dinamis/paginated
document.addEventListener('click', function (e) {
  const openBtn = e.target.closest('[data-modal-target]');
  if (openBtn) {
    const id = openBtn.getAttribute('data-modal-target');
    const modal = document.getElementById(id);
    if (modal) modal.classList.remove('hidden');
    return;
  }
  const closeBtn = e.target.closest('[data-modal-close]');
  if (closeBtn) {
    const wrapper = closeBtn.closest('.fixed.inset-0');
    if (wrapper) wrapper.classList.add('hidden');
    return;
  }
});

// Hide initial loading overlay
window.addEventListener('load', function() {
    const loadingOverlay = document.getElementById('initial-loading');
    if (loadingOverlay) {
        loadingOverlay.style.opacity = '0';
        setTimeout(() => {
            loadingOverlay.style.display = 'none';
        }, 300);
    }
});

// Auto-submit filter form when status changes
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.getElementById('status');
    const searchInput = document.getElementById('search');
    
    // Load saved preferences
    loadFilterPreferences();
    
    if (statusSelect) {
        statusSelect.addEventListener('change', function() {
            saveFilterPreferences();
            submitForm();
        });
    }
    
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                saveFilterPreferences();
                submitForm();
            }, 500); // Delay 500ms after user stops typing
        });
    }
    
    function saveFilterPreferences() {
        const formData = new FormData(document.querySelector('form[method="GET"]'));
        const preferences = {
            status: formData.get('status') || 'semua',
            search: formData.get('search') || ''
        };
        localStorage.setItem('pendaftaranFilterPreferences', JSON.stringify(preferences));
    }
    
    function loadFilterPreferences() {
        const saved = localStorage.getItem('pendaftaranFilterPreferences');
        if (saved) {
            const preferences = JSON.parse(saved);
            
            // Only load if current URL doesn't have parameters
            if (!window.location.search) {
                if (preferences.status && preferences.status !== 'semua' && statusSelect) {
                    statusSelect.value = preferences.status;
                }
                if (preferences.search && searchInput) {
                    searchInput.value = preferences.search;
                }
            }
        }
    }
    
    function submitForm() {
        const form = document.querySelector('form[method="GET"]');
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        // Add loading overlay
        const overlay = document.createElement('div');
        overlay.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
        overlay.innerHTML = `
            <div class="bg-white rounded-lg p-6 flex items-center space-x-3">
                <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600"></div>
                <span class="text-gray-700">Memfilter data...</span>
            </div>
        `;
        document.body.appendChild(overlay);
        
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memfilter...';
        submitBtn.disabled = true;
        
        // Submit form
        form.submit();
    }
});

// Show loading state for export
function showExportLoading(button) {
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengekspor...';
    button.disabled = true;
    
    // Re-enable after 3 seconds in case download doesn't start
    setTimeout(() => {
        button.innerHTML = originalText;
        button.disabled = false;
    }, 3000);
}

// WhatsApp confirmation
document.addEventListener('DOMContentLoaded', function() {
    const whatsappLinks = document.querySelectorAll('a[href^="https://wa.me/"]');
    whatsappLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const nama = this.getAttribute('title')?.replace('Chat WhatsApp dengan ', '') || 'peserta';
            const nomor = this.textContent.trim();
            
            if (!confirm(`Buka chat WhatsApp dengan ${nama} (${nomor})?`)) {
                e.preventDefault();
            }
        });
    });
});

// Show loading state for status update
function showStatusUpdateLoading(button) {
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Mengubah...';
    button.disabled = true;
    
    // Re-enable after 5 seconds in case of error
    setTimeout(() => {
        button.innerHTML = originalText;
        button.disabled = false;
    }, 5000);
}

// Add loading state for pagination links
document.addEventListener('DOMContentLoaded', function() {
    const paginationLinks = document.querySelectorAll('.pagination a');
    paginationLinks.forEach(link => {
        link.addEventListener('click', function() {
            // Add loading overlay
            const overlay = document.createElement('div');
            overlay.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
            overlay.innerHTML = `
                <div class="bg-white rounded-lg p-6 flex items-center space-x-3">
                    <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600"></div>
                    <span class="text-gray-700">Memuat halaman...</span>
                </div>
            `;
            document.body.appendChild(overlay);
        });
    });
});
</script>
@endpush


