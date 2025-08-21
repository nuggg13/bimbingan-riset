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
                    <p class="text-gray-600 mt-1">{{ $catatan->peserta->nama }} - Semua Catatan Bimbingan</p>
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- All Notes for this Participant -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-6">
                    <i class="fas fa-sticky-note text-green-600 mr-2"></i>Informasi Catatan
                </h2>
                
                @php
                    $allNotes = \App\Models\CatatanBimbingan::where('id_peserta', $catatan->id_peserta)
                                ->orderBy('tanggal_bimbingan', 'desc')
                                ->get();
                @endphp

                <div class="space-y-6">
                    @foreach($allNotes as $note)
                        <div class="border border-gray-200 rounded-lg p-4 {{ $note->id_catatan == $catatan->id_catatan ? 'bg-blue-50 border-blue-300' : '' }}">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-calendar text-green-600"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900">{{ $note->tanggal_bimbingan->format('d F Y') }}</h3>
                                        <p class="text-sm text-gray-500">{{ $note->tanggal_bimbingan->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($note->status == 'completed') bg-green-100 text-green-800
                                        @elseif($note->status == 'published') bg-blue-100 text-blue-800
                                        @elseif($note->status == 'reviewed') bg-yellow-100 text-yellow-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ $note->status_label }}
                                    </span>
                                    <div class="flex space-x-1">
                                        <a href="{{ route('mentor.catatan-bimbingan.edit', $note->id_catatan) }}" 
                                           class="text-blue-600 hover:text-blue-900 p-1">
                                            <i class="fas fa-edit text-sm"></i>
                                        </a>
                                        <form method="POST" action="{{ route('mentor.catatan-bimbingan.destroy', $note->id_catatan) }}" 
                                              class="inline" onsubmit="return confirm('Yakin ingin menghapus catatan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 p-1">
                                                <i class="fas fa-trash text-sm"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Hasil Bimbingan</label>
                                    <div class="text-sm text-gray-900 leading-relaxed prose prose-sm max-w-none">{!! $note->hasil_bimbingan !!}</div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Tugas Perbaikan</label>
                                    <div class="text-sm text-gray-900 leading-relaxed prose prose-sm max-w-none">{!! $note->tugas_perbaikan !!}</div>
                                </div>

                                @if($note->catatan_tambahan)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Catatan Tambahan</label>
                                    <div class="text-sm text-gray-900 leading-relaxed prose prose-sm max-w-none">{!! $note->catatan_tambahan !!}</div>
                                </div>
                                @endif

                                @if($note->latest_progress)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Progress Terbaru</label>
                                    <div class="flex items-center mt-2">
                                        <div class="w-20 bg-gray-200 rounded-full h-2 mr-3">
                                            <div class="bg-green-600 h-2 rounded-full" 
                                                 style="width: {{ $note->latest_progress->persentase }}%"></div>
                                        </div>
                                        <span class="text-sm font-medium text-green-600">{{ $note->latest_progress->persentase }}%</span>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
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

            <!-- Update Progress Section -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-chart-line text-blue-600 mr-2"></i>Update Progress
                </h3>

                @php
                    $latestProgress = \App\Models\UpdateProgress::whereHas('catatanBimbingan', function($query) use ($catatan) {
                        $query->where('id_peserta', $catatan->id_peserta);
                    })->orderBy('created_at', 'desc')->first();
                @endphp

                <!-- Current Progress Display -->
                @if($latestProgress)
                    <div class="mb-4 p-4 bg-gradient-to-r from-blue-50 to-green-50 rounded-lg border border-blue-200">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-full flex items-center justify-center mr-3 bg-green-100">
                                    <span class="font-bold text-green-600">{{ number_format($latestProgress->persentase, 0) }}%</span>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-900">Progress Terkini</h4>
                                    <p class="text-xs text-gray-600">{{ $latestProgress->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2 mb-2">
                            <div class="bg-green-600 h-2 rounded-full transition-all duration-500" 
                                 style="width: {{ $latestProgress->persentase }}%"></div>
                        </div>
                        <p class="text-xs text-gray-700">{{ $latestProgress->deskripsi_progress }}</p>
                    </div>
                @endif

                <!-- Add Progress Form -->
                <div class="p-4 bg-gray-50 rounded-lg">
                    <form method="POST" action="{{ route('mentor.catatan-bimbingan.addProgress', $catatan->id_catatan) }}">
                        @csrf
                        <div class="space-y-3">
                            <div>
                                <label for="persentase" class="block text-sm font-medium text-gray-700 mb-1">
                                    Persentase: <span id="percentageValue" class="font-semibold text-blue-600">{{ $latestProgress ? $latestProgress->persentase : 0 }}%</span>
                                </label>
                                <input type="range" name="persentase" id="persentase" min="0" max="100" step="1" 
                                       value="{{ $latestProgress ? $latestProgress->persentase : 0 }}"
                                       class="w-full h-2 rounded-lg appearance-none cursor-pointer slider"
                                       oninput="updateSliderColor(this.value)">
                            </div>
                            <div>
                                <label for="deskripsi_progress" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                                <textarea name="deskripsi_progress" id="deskripsi_progress" rows="2" required
                                          placeholder="Deskripsikan progress..."
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm"></textarea>
                            </div>
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
                                <i class="fas fa-save mr-2"></i>Update Progress
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Progress History (Smaller) -->
                @php
                    $progressHistory = \App\Models\UpdateProgress::whereHas('catatanBimbingan', function($query) use ($catatan) {
                        $query->where('id_peserta', $catatan->id_peserta);
                    })->orderBy('created_at', 'desc')->take(5)->get();
                @endphp

                @if($progressHistory->count() > 0)
                    <div class="mt-4 pt-4 border-t">
                        <h4 class="text-sm font-semibold text-gray-800 mb-3">
                            <i class="fas fa-history text-gray-600 mr-1"></i>Riwayat Progress
                        </h4>
                        <div class="space-y-2">
                            @foreach($progressHistory as $progress)
                                <div class="flex items-center space-x-3 p-2 bg-gray-50 rounded text-xs">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center bg-green-100 text-green-600 font-semibold">
                                        {{ number_format($progress->persentase, 0) }}%
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-medium text-gray-900">{{ $progress->created_at->format('d M Y') }}</p>
                                        <p class="text-gray-600 truncate">{{ $progress->deskripsi_progress }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
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
    height: 8px;
    border-radius: 4px;
    background: #e5e7eb;
    outline: none;
    transition: all 0.3s ease;
}

.slider::-webkit-slider-thumb {
    -webkit-appearance: none;
    appearance: none;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #ffffff;
    border: 2px solid #3b82f6;
    cursor: pointer;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.slider::-webkit-slider-thumb:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.slider::-moz-range-thumb {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #ffffff;
    border: 2px solid #3b82f6;
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