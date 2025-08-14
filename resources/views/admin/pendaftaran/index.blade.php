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

 @if (session('error'))
     <div class="mb-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center justify-between">
         <div class="flex items-center">
             <i class="fas fa-exclamation-circle mr-2 text-red-600"></i>
             <span class="font-medium">{{ session('error') }}</span>
         </div>
         <button type="button" class="text-red-600 hover:text-red-800" onclick="this.parentElement.remove()">
             <i class="fas fa-times"></i>
         </button>
     </div>
 @endif

 @if ($errors->any())
     <div class="mb-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
         <div class="flex items-center mb-2">
             <i class="fas fa-exclamation-triangle mr-2 text-red-600"></i>
             <span class="font-medium">Terjadi kesalahan:</span>
         </div>
         <ul class="list-disc list-inside text-sm">
             @foreach ($errors->all() as $error)
                 <li>{{ $error }}</li>
             @endforeach
         </ul>
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
                        <div class="flex items-center space-x-2">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeClass }}">
                                {{ ucfirst($status) }}
                            </span>
                            @if($row->status === 'diterima' && $row->jadwal)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800" title="Jadwal bimbingan telah dibuat">
                                    <i class="fas fa-calendar-check mr-1"></i>
                                    Terjadwal
                                </span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <form class="status-update-form flex items-center space-x-2" data-id="{{ $row->id_pendaftaran }}">
                            @csrf
                            @method('PATCH')
                            <select name="status" class="border-gray-300 rounded-lg text-sm px-2 py-1 focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="diterima" {{ $row->status === 'diterima' ? 'selected' : '' }}>Diterima</option>
                                <option value="ditolak" {{ $row->status === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                <option value="pending" {{ $row->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="review" {{ $row->status === 'review' ? 'selected' : '' }}>Review</option>
                                <option value="konsultasi" {{ $row->status === 'konsultasi' ? 'selected' : '' }}>Konsultasi</option>
                            </select>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-3 py-1.5 rounded-lg transition-colors duration-200">
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
                @if($row->status === 'diterima' && $row->jadwal)
                    <!-- Jadwal Bimbingan Section -->
                    <div class="mb-8 bg-green-50 border border-green-200 rounded-xl p-6">
                        <div class="flex items-center space-x-2 mb-4">
                            <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-calendar-check text-green-600 text-xs"></i>
                            </div>
                            <h4 class="font-bold text-green-800 text-lg">Jadwal Bimbingan</h4>
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-semibold">
                                {{ ucfirst($row->jadwal->status) }}
                            </span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-3">
                                <div>
                                    <p class="text-xs font-semibold text-green-600 uppercase tracking-wide mb-1">Mentor</p>
                                    <p class="text-sm font-medium text-green-900">{{ $row->jadwal->mentor->nama ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-green-600 uppercase tracking-wide mb-1">Periode</p>
                                    <p class="text-sm text-green-900">
                                        {{ $row->jadwal->tanggal_mulai ? \Carbon\Carbon::parse($row->jadwal->tanggal_mulai)->format('d/m/Y') : 'N/A' }} - 
                                        {{ $row->jadwal->tanggal_akhir ? \Carbon\Carbon::parse($row->jadwal->tanggal_akhir)->format('d/m/Y') : 'N/A' }}
                                    </p>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <div>
                                    <p class="text-xs font-semibold text-green-600 uppercase tracking-wide mb-1">Jam Bimbingan</p>
                                    <p class="text-sm text-green-900">{{ $row->jadwal->jam_mulai }} - {{ $row->jadwal->jam_akhir }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-green-600 uppercase tracking-wide mb-1">Kontak Mentor</p>
                                    @if($row->jadwal->mentor && $row->jadwal->mentor->nomor_wa)
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $row->jadwal->mentor->nomor_wa) }}" 
                                           target="_blank"
                                           class="text-sm text-green-600 hover:text-green-800 flex items-center">
                                            <i class="fab fa-whatsapp mr-1"></i>
                                            {{ $row->jadwal->mentor->nomor_wa }}
                                        </a>
                                    @else
                                        <p class="text-sm text-green-700">Tidak tersedia</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                
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

<!-- Modal Jadwal Bimbingan -->
<div id="schedule-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-all duration-300"></div>
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative w-full max-w-3xl bg-white rounded-2xl shadow-2xl overflow-hidden transform transition-all duration-300">
            <!-- Header -->
            <div class="bg-gradient-to-r from-green-600 to-emerald-700 px-8 py-6 text-white">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                            <i class="fas fa-calendar-plus text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold">Buat Jadwal Bimbingan</h3>
                            <p class="text-green-100 text-sm" id="schedule-modal-subtitle">Pendaftaran telah diterima</p>
                        </div>
                    </div>
                    <button id="close-schedule-modal" class="w-8 h-8 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center transition-colors duration-200">
                        <i class="fas fa-times text-sm"></i>
                    </button>
                </div>
            </div>

            <!-- Content -->
            <form id="schedule-form" class="p-8 space-y-6">
                @csrf
                
                <!-- Mentor Selection -->
                <div>
                    <label for="id_mentor" class="block text-sm font-medium text-gray-700 mb-2">
                        Pilih Mentor <span class="text-red-500">*</span>
                    </label>
                    <select name="id_mentor" id="id_mentor" required
                            class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                        <option value="">-- Pilih Mentor --</option>
                    </select>
                    <p class="mt-1 text-sm text-gray-500">Pilih mentor yang akan membimbing peserta</p>
                </div>

                <!-- Date Range -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Mulai <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal_mulai" id="tanggal_mulai" required
                               class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                    </div>
                    <div>
                        <label for="tanggal_akhir" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Akhir <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal_akhir" id="tanggal_akhir" required
                               class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                    </div>
                </div>

                <!-- Time Range -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="jam_mulai" class="block text-sm font-medium text-gray-700 mb-2">
                            Jam Mulai <span class="text-red-500">*</span>
                        </label>
                        <input type="time" name="jam_mulai" id="jam_mulai" value="09:00" required
                               class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                    </div>
                    <div>
                        <label for="jam_akhir" class="block text-sm font-medium text-gray-700 mb-2">
                            Jam Akhir <span class="text-red-500">*</span>
                        </label>
                        <input type="time" name="jam_akhir" id="jam_akhir" value="17:00" required
                               class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                    </div>
                </div>

                <!-- Days Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Hari Bimbingan (Opsional)
                    </label>
                    <div class="space-y-3">
                        <p class="text-sm text-gray-500 mb-3">Pilih hari-hari dalam seminggu untuk jadwal rutin bimbingan:</p>
                        
                        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-3 lg:gap-2">
                            <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors duration-200">
                                <input type="checkbox" name="days[]" value="senin" 
                                       class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                                <span class="ml-2 text-sm font-medium text-gray-700">Senin</span>
                            </label>
                            <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors duration-200">
                                <input type="checkbox" name="days[]" value="selasa" 
                                       class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                                <span class="ml-2 text-sm font-medium text-gray-700">Selasa</span>
                            </label>
                            <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors duration-200">
                                <input type="checkbox" name="days[]" value="rabu" 
                                       class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                                <span class="ml-2 text-sm font-medium text-gray-700">Rabu</span>
                            </label>
                            <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors duration-200">
                                <input type="checkbox" name="days[]" value="kamis" 
                                       class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                                <span class="ml-2 text-sm font-medium text-gray-700">Kamis</span>
                            </label>
                            <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors duration-200">
                                <input type="checkbox" name="days[]" value="jumat" 
                                       class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                                <span class="ml-2 text-sm font-medium text-gray-700">Jumat</span>
                            </label>
                            <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors duration-200">
                                <input type="checkbox" name="days[]" value="sabtu" 
                                       class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                                <span class="ml-2 text-sm font-medium text-gray-700">Sabtu</span>
                            </label>
                            <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors duration-200">
                                <input type="checkbox" name="days[]" value="minggu" 
                                       class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                                <span class="ml-2 text-sm font-medium text-gray-700">Minggu</span>
                            </label>
                        </div>
                        
                        <input type="hidden" name="hari" id="hari" value="">
                        
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex items-start">
                                <i class="fas fa-info-circle text-blue-600 mt-0.5 mr-3"></i>
                                <div class="text-sm text-blue-800">
                                    <p class="font-medium mb-1">Informasi Hari Bimbingan:</p>
                                    <ul class="list-disc list-inside space-y-1">
                                        <li>Jika tidak ada hari yang dipilih, jadwal akan bersifat satu kali (berdasarkan tanggal mulai dan akhir)</li>
                                        <li>Jika ada hari yang dipilih, jadwal akan berulang setiap minggu pada hari-hari tersebut</li>
                                        <li>Contoh: Pilih "Senin" dan "Rabu" untuk jadwal rutin setiap Senin dan Rabu</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-blue-600 mt-0.5 mr-3"></i>
                        <div class="text-sm text-blue-800">
                            <p class="font-medium mb-1">Informasi Jadwal:</p>
                            <ul class="list-disc list-inside space-y-1">
                                <li>Tanggal mulai tidak boleh kurang dari hari ini</li>
                                <li>Tanggal akhir harus setelah tanggal mulai</li>
                                <li>Jam akhir harus setelah jam mulai</li>
                                <li><strong>Status otomatis:</strong> "scheduled" jika tanggal mulai > hari ini, "ongoing" jika sedang berlangsung, "completed" jika sudah selesai</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <button type="button" id="cancel-schedule" 
                            class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200 flex items-center">
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </button>
                    <button type="submit" 
                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200 flex items-center">
                        <i class="fas fa-calendar-plus mr-2"></i>
                        Buat Jadwal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script>
let currentPendaftaranId = null;

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

// Handle status update form submission
document.addEventListener('DOMContentLoaded', function() {
    // Handle status update forms
    document.addEventListener('submit', function(e) {
        if (e.target.classList.contains('status-update-form')) {
            e.preventDefault();
            handleStatusUpdate(e.target);
        }
    });

    // Handle schedule modal
    const scheduleModal = document.getElementById('schedule-modal');
    const scheduleForm = document.getElementById('schedule-form');
    const closeScheduleModal = document.getElementById('close-schedule-modal');
    const cancelSchedule = document.getElementById('cancel-schedule');

    // Close schedule modal
    [closeScheduleModal, cancelSchedule].forEach(btn => {
        if (btn) {
            btn.addEventListener('click', function() {
                scheduleModal.classList.add('hidden');
                resetScheduleForm();
            });
        }
    });

    // Handle schedule form submission
    if (scheduleForm) {
        scheduleForm.addEventListener('submit', function(e) {
            e.preventDefault();
            handleScheduleSubmission();
        });
    }

    // Set minimum date for date inputs
    const today = new Date().toISOString().split('T')[0];
    const tanggalMulaiInput = document.getElementById('tanggal_mulai');
    const tanggalAkhirInput = document.getElementById('tanggal_akhir');
    
    if (tanggalMulaiInput) {
        tanggalMulaiInput.min = today;
        tanggalMulaiInput.addEventListener('change', function() {
            if (tanggalAkhirInput) {
                tanggalAkhirInput.min = this.value;
            }
        });
    }

    // Handle days selection in schedule modal
    const dayCheckboxes = document.querySelectorAll('input[name="days[]"]');
    const hariInput = document.getElementById('hari');
    
    dayCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const selectedDays = Array.from(dayCheckboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.value);
            
            if (hariInput) {
                hariInput.value = selectedDays.join(',');
            }
        });
    });
    
    // Initialize hari input on page load
    if (dayCheckboxes.length > 0 && hariInput) {
        const selectedDays = Array.from(dayCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value);
        hariInput.value = selectedDays.join(',');
    }
});

function handleStatusUpdate(form) {
    const formData = new FormData(form);
    const pendaftaranId = form.dataset.id;
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    const selectedStatus = formData.get('status');

    // Show loading state
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Mengubah...';
    submitBtn.disabled = true;

    // Make AJAX request
    fetch(`/admin/pendaftaran/${pendaftaranId}/status`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || formData.get('_token'),
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            status: selectedStatus,
            _method: 'PATCH'
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.show_schedule_modal) {
            // Show schedule modal
            showScheduleModal(data);
        } else if (data.success) {
            // Show success message and reload if needed
            showNotification(data.message, 'success');
            if (data.reload) {
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            }
        } else if (data.error) {
            showNotification(data.error, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Terjadi kesalahan saat mengubah status.', 'error');
    })
    .finally(() => {
        // Reset button state
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
}

function showScheduleModal(data) {
    currentPendaftaranId = data.pendaftaran.id_pendaftaran;
    
    // Update modal subtitle
    const subtitle = document.getElementById('schedule-modal-subtitle');
    if (subtitle) {
        subtitle.textContent = `Untuk: ${data.peserta_nama}`;
    }

    // Populate mentor options
    const mentorSelect = document.getElementById('id_mentor');
    if (mentorSelect && data.mentors) {
        mentorSelect.innerHTML = '<option value="">-- Pilih Mentor --</option>';
        data.mentors.forEach(mentor => {
            const option = document.createElement('option');
            option.value = mentor.id_mentor;
            option.textContent = `${mentor.nama} - ${mentor.keahlian}`;
            mentorSelect.appendChild(option);
        });
    }

    // Set default dates
    const today = new Date();
    const startDate = new Date(today);
    startDate.setDate(today.getDate() + 3); // 3 days from now
    const endDate = new Date(startDate);
    endDate.setMonth(startDate.getMonth() + 1); // 1 month later

    const tanggalMulaiInput = document.getElementById('tanggal_mulai');
    const tanggalAkhirInput = document.getElementById('tanggal_akhir');
    
    if (tanggalMulaiInput) {
        tanggalMulaiInput.value = startDate.toISOString().split('T')[0];
    }
    if (tanggalAkhirInput) {
        tanggalAkhirInput.value = endDate.toISOString().split('T')[0];
    }

    // Show modal
    const scheduleModal = document.getElementById('schedule-modal');
    if (scheduleModal) {
        scheduleModal.classList.remove('hidden');
    }
}

function handleScheduleSubmission() {
    const form = document.getElementById('schedule-form');
    const formData = new FormData(form);
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;

    // Show loading state
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Membuat Jadwal...';
    submitBtn.disabled = true;

    // Make AJAX request
    fetch(`/admin/pendaftaran/${currentPendaftaranId}/schedule`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || formData.get('_token'),
            'Accept': 'application/json',
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            // Close modal and reload page
            document.getElementById('schedule-modal').classList.add('hidden');
            resetScheduleForm();
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else if (data.error) {
            showNotification(data.error, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Terjadi kesalahan saat membuat jadwal.', 'error');
    })
    .finally(() => {
        // Reset button state
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
}

function resetScheduleForm() {
    const form = document.getElementById('schedule-form');
    if (form) {
        form.reset();
        // Reset default values
        document.getElementById('jam_mulai').value = '09:00';
        document.getElementById('jam_akhir').value = '17:00';
        
        // Reset day checkboxes
        const dayCheckboxes = document.querySelectorAll('input[name="days[]"]');
        dayCheckboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
        
        // Reset hidden hari input
        const hariInput = document.getElementById('hari');
        if (hariInput) {
            hariInput.value = '';
        }
    }
    currentPendaftaranId = null;
}

function showNotification(message, type = 'info') {
    // Remove existing notifications
    const existingNotifications = document.querySelectorAll('.notification-toast');
    existingNotifications.forEach(notification => notification.remove());

    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification-toast fixed top-4 right-4 z-50 max-w-sm w-full shadow-lg rounded-lg p-4 transition-all duration-300 transform translate-x-full`;
    
    let bgColor, textColor, icon;
    switch (type) {
        case 'success':
            bgColor = 'bg-green-50 border border-green-200';
            textColor = 'text-green-800';
            icon = 'fas fa-check-circle text-green-600';
            break;
        case 'error':
            bgColor = 'bg-red-50 border border-red-200';
            textColor = 'text-red-800';
            icon = 'fas fa-exclamation-circle text-red-600';
            break;
        default:
            bgColor = 'bg-blue-50 border border-blue-200';
            textColor = 'text-blue-800';
            icon = 'fas fa-info-circle text-blue-600';
    }

    notification.className += ` ${bgColor}`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="${icon} mr-2"></i>
            <span class="font-medium ${textColor}">${message}</span>
            <button type="button" class="ml-auto ${textColor.replace('text-', 'text-').replace('-800', '-600')} hover:${textColor}" onclick="this.parentElement.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;

    document.body.appendChild(notification);

    // Animate in
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);

    // Auto remove after 5 seconds
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 5000);
}

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

// Confirm status update
function confirmStatusUpdate(form) {
    const select = form.querySelector('select[name="status"]');
    const selectedStatus = select.options[select.selectedIndex].text;
    const currentRow = form.closest('tr');
    const pesertaName = currentRow.querySelector('td:nth-child(2) .font-medium').textContent.trim();
    
    return confirm(`Apakah Anda yakin ingin mengubah status pendaftaran ${pesertaName} menjadi "${selectedStatus}"?`);
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


