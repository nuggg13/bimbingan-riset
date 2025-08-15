@extends('admin.layout')

@section('title', 'Detail Catatan Bimbingan')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('admin.catatan-bimbingan.index') }}" class="text-blue-600 hover:text-blue-700 mr-4">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Detail Catatan Bimbingan</h1>
                    <p class="text-gray-600 mt-1">{{ $catatan->peserta->nama }} - {{ $catatan->tanggal_bimbingan->format('d M Y') }}</p>
                </div>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.catatan-bimbingan.edit', $catatan->id_catatan) }}" 
                   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
                    <i class="fas fa-edit mr-2"></i>Edit Catatan
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Catatan Details -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-sticky-note text-blue-600 mr-2"></i>Informasi Catatan
                </h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Tanggal Bimbingan</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $catatan->tanggal_bimbingan->format('d M Y') }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500">Hasil Bimbingan</label>
                        <p class="mt-1 text-sm text-gray-900 leading-relaxed">{{ $catatan->hasil_bimbingan }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500">Tugas Perbaikan</label>
                        <p class="mt-1 text-sm text-gray-900 leading-relaxed">{{ $catatan->tugas_perbaikan }}</p>
                    </div>

                    @if($catatan->catatan_tambahan)
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Catatan Tambahan</label>
                        <p class="mt-1 text-sm text-gray-900 leading-relaxed">{{ $catatan->catatan_tambahan }}</p>
                    </div>
                    @endif

                    <div>
                        <label class="block text-sm font-medium text-gray-500">Status</label>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium mt-1
                            @if($catatan->status == 'completed') bg-green-100 text-green-800
                            @elseif($catatan->status == 'published') bg-blue-100 text-blue-800
                            @elseif($catatan->status == 'reviewed') bg-yellow-100 text-yellow-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ $catatan->status_label }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Progress Updates -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-800">
                        <i class="fas fa-chart-line text-green-600 mr-2"></i>Update Progress
                    </h2>
                    <button onclick="toggleAddProgressForm()" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
                        <i class="fas fa-plus mr-2"></i>Tambah Progress
                    </button>
                </div>

                <!-- Add Progress Form (Hidden by default) -->
                <div id="addProgressForm" class="hidden mb-6 p-4 bg-gray-50 rounded-lg">
                    <form method="POST" action="{{ route('admin.catatan-bimbingan.addProgress', $catatan->id_catatan) }}">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="tanggal_update" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                                <input type="date" name="tanggal_update" id="tanggal_update" value="{{ date('Y-m-d') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label for="persentase" class="block text-sm font-medium text-gray-700 mb-1">Persentase (%)</label>
                                <input type="number" name="persentase" id="persentase" min="0" max="100" step="0.1"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div class="flex items-end">
                                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
                                    Simpan
                                </button>
                            </div>
                        </div>
                        <div class="mt-4">
                            <label for="deskripsi_progress" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Progress</label>
                            <textarea name="deskripsi_progress" id="deskripsi_progress" rows="3" 
                                      placeholder="Deskripsikan progress yang telah dicapai..."
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>
                    </form>
                </div>

                <!-- Progress List -->
                @if($catatan->updateProgress->count() > 0)
                    <div class="space-y-4">
                        @foreach($catatan->updateProgress->sortByDesc('tanggal_update') as $progress)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-{{ $progress->progress_color }}-100 rounded-full flex items-center justify-center mr-4">
                                            <span class="text-{{ $progress->progress_color }}-600 font-semibold text-sm">{{ number_format($progress->persentase, 0) }}%</span>
                                        </div>
                                        <div>
                                            <h4 class="font-medium text-gray-900">{{ $progress->progress_status }}</h4>
                                            <p class="text-sm text-gray-500">{{ $progress->tanggal_update->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button onclick="editProgress({{ $progress->id_progress }}, '{{ $progress->tanggal_update->format('Y-m-d') }}', '{{ $progress->deskripsi_progress }}', {{ $progress->persentase }})" 
                                                class="text-blue-600 hover:text-blue-900 text-sm">
                                            <i class="fas fa-edit mr-1"></i>Edit
                                        </button>
                                        <form method="POST" action="{{ route('admin.catatan-bimbingan.deleteProgress', [$catatan->id_catatan, $progress->id_progress]) }}" 
                                              class="inline" onsubmit="return confirm('Yakin ingin menghapus progress ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 text-sm">
                                                <i class="fas fa-trash mr-1"></i>Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2 mb-3">
                                    <div class="bg-{{ $progress->progress_color }}-600 h-2 rounded-full" style="width: {{ $progress->persentase }}%"></div>
                                </div>
                                <p class="text-sm text-gray-700">{{ $progress->deskripsi_progress }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-chart-line text-gray-400 text-4xl mb-4"></i>
                        <p class="text-gray-500">Belum ada update progress</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Peserta Info -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-user text-blue-600 mr-2"></i>Informasi Peserta
                </h3>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Nama</label>
                        <p class="text-sm text-gray-900">{{ $catatan->peserta->nama }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Email</label>
                        <p class="text-sm text-gray-900">{{ $catatan->peserta->email }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Instansi</label>
                        <p class="text-sm text-gray-900">{{ $catatan->peserta->instansi }}</p>
                    </div>
                    @if($catatan->peserta->pendaftaran)
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Judul Riset</label>
                        <p class="text-sm text-gray-900">{{ $catatan->peserta->pendaftaran->judul_riset }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-bolt text-yellow-600 mr-2"></i>Aksi Cepat
                </h3>
                <div class="space-y-3">
                    <a href="https://wa.me/{{ str_replace(['+', '-', ' '], '', $catatan->peserta->nomor_wa) }}" 
                       target="_blank"
                       class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200 flex items-center justify-center">
                        <i class="fab fa-whatsapp mr-2"></i>Chat WhatsApp
                    </a>
                    <a href="mailto:{{ $catatan->peserta->email }}" 
                       class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200 flex items-center justify-center">
                        <i class="fas fa-envelope mr-2"></i>Kirim Email
                    </a>
                </div>
            </div>

            <!-- Progress Summary -->
            @if($catatan->latest_progress)
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-chart-pie text-purple-600 mr-2"></i>Ringkasan Progress
                </h3>
                <div class="text-center">
                    <div class="w-20 h-20 bg-{{ $catatan->latest_progress->progress_color }}-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-{{ $catatan->latest_progress->progress_color }}-600 font-bold text-lg">{{ number_format($catatan->latest_progress->persentase, 0) }}%</span>
                    </div>
                    <p class="text-sm font-medium text-gray-900">{{ $catatan->latest_progress->progress_status }}</p>
                    <p class="text-xs text-gray-500 mt-1">Update terakhir: {{ $catatan->latest_progress->tanggal_update->format('d M Y') }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Edit Progress Modal -->
<div id="editProgressModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Edit Progress</h3>
                <form id="editProgressForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                            <input type="date" name="tanggal_update" id="edit_tanggal_update"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Persentase (%)</label>
                            <input type="number" name="persentase" id="edit_persentase" min="0" max="100" step="0.1"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Progress</label>
                            <textarea name="deskripsi_progress" id="edit_deskripsi_progress" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>
                    </div>
                    <div class="flex items-center justify-end space-x-4 mt-6">
                        <button type="button" onclick="closeEditModal()" 
                                class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
                            Batal
                        </button>
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function toggleAddProgressForm() {
    const form = document.getElementById('addProgressForm');
    form.classList.toggle('hidden');
}

function editProgress(id, tanggal, deskripsi, persentase) {
    document.getElementById('edit_tanggal_update').value = tanggal;
    document.getElementById('edit_deskripsi_progress').value = deskripsi;
    document.getElementById('edit_persentase').value = persentase;
    
    const form = document.getElementById('editProgressForm');
    form.action = `{{ route('admin.catatan-bimbingan.updateProgress', [$catatan->id_catatan, ':id']) }}`.replace(':id', id);
    
    document.getElementById('editProgressModal').classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('editProgressModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('editProgressModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditModal();
    }
});
</script>
@endpush
@endsection