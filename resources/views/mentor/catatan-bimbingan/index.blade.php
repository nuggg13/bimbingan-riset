@extends('mentor.layout')

@section('title', 'Catatan Bimbingan')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Catatan Bimbingan</h1>
                <p class="text-gray-600 mt-1">Kelola catatan dan progress bimbingan peserta Anda</p>
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
                                Hasil Bimbingan
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Progress
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
                                    <div class="text-sm text-gray-900">{{ Str::limit($catatan->hasil_bimbingan, 100) }}</div>
                                    @if($catatan->tugas_perbaikan)
                                        <div class="text-sm text-gray-500 mt-1">
                                            <strong>Tugas:</strong> {{ Str::limit($catatan->tugas_perbaikan, 80) }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($catatan->latest_progress)
                                        <div class="flex items-center">
                                            <div class="w-16 bg-gray-200 rounded-full h-2 mr-3">
                                                <div class="bg-{{ $catatan->latest_progress->progress_color }}-600 h-2 rounded-full" 
                                                     style="width: {{ $catatan->latest_progress->persentase }}%"></div>
                                            </div>
                                            <span class="text-sm font-medium text-gray-900">{{ $catatan->latest_progress->formatted_persentase }}</span>
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1">{{ $catatan->latest_progress->progress_status }}</div>
                                    @else
                                        <span class="text-sm text-gray-500">Belum ada progress</span>
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
                                    <div class="flex space-x-2">
                                        <a href="{{ route('mentor.catatan-bimbingan.show', $catatan->id_catatan) }}" 
                                           class="text-green-600 hover:text-green-900">
                                            <i class="fas fa-eye mr-1"></i>Detail
                                        </a>
                                        <a href="{{ route('mentor.catatan-bimbingan.edit', $catatan->id_catatan) }}" 
                                           class="text-blue-600 hover:text-blue-900">
                                            <i class="fas fa-edit mr-1"></i>Edit
                                        </a>
                                        <form method="POST" action="{{ route('mentor.catatan-bimbingan.destroy', $catatan->id_catatan) }}" 
                                              class="inline" onsubmit="return confirm('Yakin ingin menghapus catatan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                <i class="fas fa-trash mr-1"></i>Hapus
                                            </button>
                                        </form>
                                    </div>
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
@endsection