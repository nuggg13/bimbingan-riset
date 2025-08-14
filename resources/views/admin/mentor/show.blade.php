@extends('admin.layout')

@section('title', 'Detail Mentor - Admin')

@section('content')
<div class="mb-6">
    <div class="flex items-center space-x-4">
        <a href="{{ route('admin.mentor.index') }}" class="text-gray-600 hover:text-gray-900">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Daftar Mentor
        </a>
    </div>
    <div class="mt-4">
        <h2 class="text-2xl font-bold text-gray-900">Detail Mentor</h2>
        <p class="text-gray-600">Informasi lengkap mentor: <strong>{{ $mentor->nama }}</strong></p>
    </div>
</div>

<!-- Action Buttons -->
<div class="mb-6 flex justify-between items-center">
    <div class="flex items-center space-x-3">
        <a href="{{ route('admin.mentor.edit', $mentor->id_mentor) }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center">
            <i class="fas fa-edit mr-2"></i>
            Edit Mentor
        </a>
        @if($mentor->nomor_wa)
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $mentor->nomor_wa) }}" 
               target="_blank"
               class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center">
                <i class="fab fa-whatsapp mr-2"></i>
                Chat WhatsApp
            </a>
        @endif
    </div>
    <div class="flex items-center space-x-3">
        <form method="POST" action="{{ route('admin.mentor.destroy', $mentor->id_mentor) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mentor {{ $mentor->nama }}? Tindakan ini tidak dapat dibatalkan.')">
            @csrf
            @method('DELETE')
            <button type="submit" 
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center">
                <i class="fas fa-trash mr-2"></i>
                Hapus Mentor
            </button>
        </form>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Info -->
    <div class="lg:col-span-2">
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 flex items-center">
                    <i class="fas fa-user mr-2 text-blue-600"></i>
                    Informasi Mentor
                </h3>
            </div>
            
            <div class="px-6 py-6 space-y-6">
                <!-- Nama -->
                <div class="group hover:bg-gray-50 p-4 rounded-xl transition-colors duration-200">
                    <label class="block text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">
                        <i class="fas fa-user-circle mr-2"></i>
                        Nama Lengkap
                    </label>
                    <p class="text-lg font-semibold text-gray-900">{{ $mentor->nama }}</p>
                </div>

                <!-- Email -->
                <div class="group hover:bg-gray-50 p-4 rounded-xl transition-colors duration-200">
                    <label class="block text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">
                        <i class="fas fa-envelope mr-2"></i>
                        Email
                    </label>
                    <div class="flex items-center space-x-3">
                        <p class="text-lg text-gray-900">{{ $mentor->email }}</p>
                        <a href="mailto:{{ $mentor->email }}" 
                           class="text-blue-600 hover:text-blue-800 transition-colors duration-200"
                           title="Kirim email">
                            <i class="fas fa-external-link-alt text-sm"></i>
                        </a>
                    </div>
                </div>

                <!-- WhatsApp -->
                <div class="group hover:bg-gray-50 p-4 rounded-xl transition-colors duration-200">
                    <label class="block text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">
                        <i class="fab fa-whatsapp mr-2"></i>
                        Nomor WhatsApp
                    </label>
                    @if($mentor->nomor_wa)
                        <div class="flex items-center space-x-3">
                            <p class="text-lg text-gray-900">{{ $mentor->nomor_wa }}</p>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $mentor->nomor_wa) }}" 
                               target="_blank"
                               class="inline-flex items-center px-3 py-1.5 bg-green-100 text-green-800 text-sm rounded-lg hover:bg-green-200 transition-colors duration-200"
                               title="Chat WhatsApp">
                                <i class="fab fa-whatsapp mr-2"></i>
                                Chat
                            </a>
                        </div>
                    @else
                        <p class="text-lg text-gray-400 italic">Tidak tersedia</p>
                    @endif
                </div>

                <!-- Keahlian -->
                <div class="group hover:bg-gray-50 p-4 rounded-xl transition-colors duration-200">
                    <label class="block text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">
                        <i class="fas fa-brain mr-2"></i>
                        Keahlian
                    </label>
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <p class="text-gray-900 leading-relaxed whitespace-pre-line">{{ $mentor->keahlian }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar Info -->
    <div class="space-y-6">
        <!-- Status Card -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 flex items-center">
                    <i class="fas fa-info-circle mr-2 text-green-600"></i>
                    Status
                </h3>
            </div>
            <div class="px-6 py-4 space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Status Akun</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <i class="fas fa-check-circle mr-1"></i>
                        Aktif
                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">WhatsApp</span>
                    @if($mentor->nomor_wa)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <i class="fab fa-whatsapp mr-1"></i>
                            Tersedia
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            <i class="fas fa-times mr-1"></i>
                            Tidak Ada
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Timestamps -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 flex items-center">
                    <i class="fas fa-clock mr-2 text-blue-600"></i>
                    Riwayat
                </h3>
            </div>
            <div class="px-6 py-4 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">
                        <i class="fas fa-calendar-plus mr-1"></i>
                        Dibuat
                    </label>
                    <p class="text-sm text-gray-900">
                        {{ $mentor->created_at ? $mentor->created_at->format('d/m/Y H:i') : 'N/A' }}
                    </p>
                    @if($mentor->created_at)
                        <p class="text-xs text-gray-500">
                            {{ $mentor->created_at->diffForHumans() }}
                        </p>
                    @endif
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">
                        <i class="fas fa-calendar-edit mr-1"></i>
                        Terakhir Diubah
                    </label>
                    <p class="text-sm text-gray-900">
                        {{ $mentor->updated_at ? $mentor->updated_at->format('d/m/Y H:i') : 'N/A' }}
                    </p>
                    @if($mentor->updated_at)
                        <p class="text-xs text-gray-500">
                            {{ $mentor->updated_at->diffForHumans() }}
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 flex items-center">
                    <i class="fas fa-bolt mr-2 text-yellow-600"></i>
                    Aksi Cepat
                </h3>
            </div>
            <div class="px-6 py-4 space-y-3">
                <a href="{{ route('admin.mentor.edit', $mentor->id_mentor) }}" 
                   class="w-full bg-blue-50 hover:bg-blue-100 text-blue-700 px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Data
                </a>
                @if($mentor->nomor_wa)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $mentor->nomor_wa) }}" 
                       target="_blank"
                       class="w-full bg-green-50 hover:bg-green-100 text-green-700 px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center">
                        <i class="fab fa-whatsapp mr-2"></i>
                        Chat WhatsApp
                    </a>
                @endif
                <a href="mailto:{{ $mentor->email }}" 
                   class="w-full bg-gray-50 hover:bg-gray-100 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center">
                    <i class="fas fa-envelope mr-2"></i>
                    Kirim Email
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// WhatsApp confirmation
document.addEventListener('DOMContentLoaded', function() {
    const whatsappLinks = document.querySelectorAll('a[href^="https://wa.me/"]');
    whatsappLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const nama = '{{ $mentor->nama }}';
            const nomor = '{{ $mentor->nomor_wa }}';
            
            if (!confirm(`Buka chat WhatsApp dengan ${nama} (${nomor})?`)) {
                e.preventDefault();
            }
        });
    });
});

// Email confirmation
document.addEventListener('DOMContentLoaded', function() {
    const emailLinks = document.querySelectorAll('a[href^="mailto:"]');
    emailLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const nama = '{{ $mentor->nama }}';
            const email = '{{ $mentor->email }}';
            
            if (!confirm(`Buka aplikasi email untuk mengirim email ke ${nama} (${email})?`)) {
                e.preventDefault();
            }
        });
    });
});
</script>
@endpush