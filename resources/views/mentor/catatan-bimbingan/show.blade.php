@extends('mentor.layout')

@section('title', 'Detail Catatan Bimbingan')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('mentor.catatan-bimbingan.index') }}" class="text-green-600 hover:text-green-700 mr-4">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Detail Catatan Bimbingan</h1>
                    <p class="text-gray-600 mt-1">{{ $catatan->peserta->nama }} - {{ $catatan->tanggal_bimbingan->format('d M Y') }}</p>
                </div>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('mentor.catatan-bimbingan.edit', $catatan->id_catatan) }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
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
                    <i class="fas fa-sticky-note text-green-600 mr-2"></i>Informasi Catatan
                </h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Tanggal Bimbingan</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $catatan->tanggal_bimbingan->format('d M Y') }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500">Hasil Bimbingan</label>
                        <div class="mt-1 text-sm text-gray-900 leading-relaxed prose prose-sm max-w-none">{!! $catatan->hasil_bimbingan !!}</div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500">Tugas Perbaikan</label>
                        <div class="mt-1 text-sm text-gray-900 leading-relaxed prose prose-sm max-w-none">{!! $catatan->tugas_perbaikan !!}</div>
                    </div>

                    @if($catatan->catatan_tambahan)
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Catatan Tambahan</label>
                        <div class="mt-1 text-sm text-gray-900 leading-relaxed prose prose-sm max-w-none">{!! $catatan->catatan_tambahan !!}</div>
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
                <h2 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-chart-line text-blue-600 mr-2"></i>Update Progress
                </h2>

                <!-- Current Progress Display -->
                @if($catatan->updateProgress->count() > 0)
                    @php
                        $latestProgress = $catatan->updateProgress->sortByDesc('created_at')->first();
                    @endphp
                    <div class="mb-6 p-4 bg-gradient-to-r from-blue-50 to-green-50 rounded-lg border border-blue-200">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center">
                                <div class="w-16 h-16 rounded-full flex items-center justify-center mr-4" 
                                     style="background: linear-gradient(135deg, 
                                        {{ $latestProgress->persentase <= 20 ? '#fee2e2' : ($latestProgress->persentase <= 40 ? '#fef3c7' : ($latestProgress->persentase <= 60 ? '#dbeafe' : ($latestProgress->persentase <= 80 ? '#d1fae5' : '#dcfce7'))) }}, 
                                        {{ $latestProgress->persentase <= 20 ? '#fecaca' : ($latestProgress->persentase <= 40 ? '#fde68a' : ($latestProgress->persentase <= 60 ? '#93c5fd' : ($latestProgress->persentase <= 80 ? '#86efac' : '#bbf7d0'))) }})">
                                    <span class="font-bold text-lg" 
                                          style="color: {{ $latestProgress->persentase <= 20 ? '#dc2626' : ($latestProgress->persentase <= 40 ? '#d97706' : ($latestProgress->persentase <= 60 ? '#2563eb' : ($latestProgress->persentase <= 80 ? '#059669' : '#16a34a'))) }}">
                                        {{ number_format($latestProgress->persentase, 0) }}%
                                    </span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $latestProgress->progress_status }}</h3>
                                    <p class="text-sm text-gray-600">Progress Terkini</p>
                                </div>
                            </div>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3 mb-3">
                            <div class="h-3 rounded-full transition-all duration-500" 
                                 style="width: {{ $latestProgress->persentase }}%; 
                                        background: linear-gradient(90deg, 
                                            {{ $latestProgress->persentase <= 20 ? '#ef4444' : ($latestProgress->persentase <= 40 ? '#f59e0b' : ($latestProgress->persentase <= 60 ? '#3b82f6' : ($latestProgress->persentase <= 80 ? '#10b981' : '#22c55e'))) }}, 
                                            {{ $latestProgress->persentase <= 20 ? '#dc2626' : ($latestProgress->persentase <= 40 ? '#d97706' : ($latestProgress->persentase <= 60 ? '#2563eb' : ($latestProgress->persentase <= 80 ? '#059669' : '#16a34a'))) }})">
                            </div>
                        </div>
                        <p class="text-sm text-gray-700 leading-relaxed">{{ $latestProgress->deskripsi_progress }}</p>
                    </div>
                @endif

                <!-- Add Progress Form -->
                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <form method="POST" action="{{ route('mentor.catatan-bimbingan.addProgress', $catatan->id_catatan) }}">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label for="persentase" class="block text-sm font-medium text-gray-700 mb-2">
                                    Persentase Progress: <span id="percentageValue" class="font-semibold text-blue-600">0%</span>
                                </label>
                                <input type="range" name="persentase" id="persentase" min="0" max="100" step="1" value="0"
                                       class="w-full h-3 rounded-lg appearance-none cursor-pointer slider"
                                       oninput="updateSliderColor(this.value)">
                            </div>
                            <div>
                                <label for="deskripsi_progress" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Progress</label>
                                <textarea name="deskripsi_progress" id="deskripsi_progress" rows="3" required
                                          placeholder="Deskripsikan progress yang telah dicapai..."
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"></textarea>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg text-sm font-medium transition duration-200">
                                    <i class="fas fa-save mr-2"></i>Simpan Progress
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Progress History -->
                @if($catatan->updateProgress->count() > 0)
                    <div class="border-t pt-6">
                        <h3 class="text-md font-semibold text-gray-800 mb-4">
                            <i class="fas fa-history text-gray-600 mr-2"></i>Riwayat Progress
                        </h3>
                        <div class="space-y-3">
                            @foreach($catatan->updateProgress->sortByDesc('created_at') as $progress)
                                <div class="flex items-start space-x-4 p-3 bg-gray-50 rounded-lg">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-xs font-semibold"
                                             style="background-color: {{ $progress->persentase <= 20 ? '#fee2e2' : ($progress->persentase <= 40 ? '#fef3c7' : ($progress->persentase <= 60 ? '#dbeafe' : ($progress->persentase <= 80 ? '#d1fae5' : '#dcfce7'))) }};
                                                    color: {{ $progress->persentase <= 20 ? '#dc2626' : ($progress->persentase <= 40 ? '#d97706' : ($progress->persentase <= 60 ? '#2563eb' : ($progress->persentase <= 80 ? '#059669' : '#16a34a'))) }}">
                                            {{ number_format($progress->persentase, 0) }}%
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between">
                                            <p class="text-sm font-medium text-gray-900">{{ $progress->created_at->format('d M Y, H:i') }}</p>
                                        </div>
                                        <p class="text-sm text-gray-700 mt-1">{{ $progress->deskripsi_progress }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-chart-line text-gray-400 text-4xl mb-4"></i>
                        <p class="text-gray-500">Belum ada update progress</p>
                        <p class="text-gray-400 text-sm mt-2">Mulai tambahkan progress untuk melacak perkembangan bimbingan</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Peserta Info -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-user text-green-600 mr-2"></i>Informasi Peserta
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

@push('scripts')
<script>
function updateSliderColor(value) {
    const slider = document.getElementById('persentase');
    const percentageValue = document.getElementById('percentageValue');
    
    // Update percentage display
    percentageValue.textContent = value + '%';
    
    // Calculate color based on percentage
    let color;
    if (value <= 20) {
        color = '#ef4444'; // red
    } else if (value <= 40) {
        color = '#f59e0b'; // orange
    } else if (value <= 60) {
        color = '#3b82f6'; // blue
    } else if (value <= 80) {
        color = '#10b981'; // green
    } else {
        color = '#22c55e'; // bright green
    }
    
    // Update slider track color
    const percentage = (value / 100) * 100;
    slider.style.background = `linear-gradient(to right, ${color} 0%, ${color} ${percentage}%, #e5e7eb ${percentage}%, #e5e7eb 100%)`;
    
    // Update percentage value color
    percentageValue.style.color = color;
}

// Initialize slider on page load
document.addEventListener('DOMContentLoaded', function() {
    const slider = document.getElementById('persentase');
    updateSliderColor(slider.value);
});
</script>

<style>
.slider {
    -webkit-appearance: none;
    appearance: none;
    height: 12px;
    border-radius: 6px;
    background: #e5e7eb;
    outline: none;
    transition: all 0.3s ease;
}

.slider::-webkit-slider-thumb {
    -webkit-appearance: none;
    appearance: none;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: #ffffff;
    border: 3px solid #3b82f6;
    cursor: pointer;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.slider::-webkit-slider-thumb:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.slider::-moz-range-thumb {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: #ffffff;
    border: 3px solid #3b82f6;
    cursor: pointer;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.slider::-moz-range-thumb:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}
</style>
@endpush
@endsection