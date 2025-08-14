@extends('admin.layout')

@section('title', 'Mentor - Admin')

@section('content')
<!-- Loading Overlay -->
<div id="initial-loading" class="fixed inset-0 bg-white bg-opacity-90 flex items-center justify-center z-50 transition-opacity duration-300">
    <div class="text-center">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-4"></div>
        <p class="text-gray-600">Memuat data mentor...</p>
    </div>
</div>

<div class="mb-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Daftar Mentor</h2>
            <p class="text-gray-600">Kelola data mentor untuk bimbingan riset.</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <div class="text-sm bg-blue-50 text-blue-700 px-4 py-2 rounded-lg inline-flex items-center">
                <i class="fas fa-users mr-2"></i>
                Total: {{ $statistics['total'] }} mentor
            </div>
        </div>
    </div>
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


<!-- Filter Section -->
<div class="bg-white shadow rounded-lg mb-6">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900 flex items-center">
            <i class="fas fa-filter mr-2 text-blue-600"></i>
            Filter & Pencarian
        </h3>
    </div>
    <div class="px-6 py-4">
        <form method="GET" action="{{ route('admin.mentor.index') }}" class="space-y-4 sm:space-y-0 sm:flex sm:items-end sm:gap-4">
            <div class="flex-1 min-w-0">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Mentor</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" 
                       placeholder="Cari berdasarkan nama, email, atau keahlian..." 
                       class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
            </div>
            <div class="flex flex-col sm:flex-row gap-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center">
                    <i class="fas fa-search mr-2"></i>
                    Cari
                </button>
                <a href="{{ route('admin.mentor.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center">
                    <i class="fas fa-times mr-2"></i>
                    Reset
                </a>
                <a href="{{ route('admin.mentor.export', request()->query()) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center" onclick="showExportLoading(this)">
                    <i class="fas fa-download mr-2"></i>
                    Export CSV
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Action Buttons -->
<div class="mb-6 flex justify-between items-center">
    <div class="flex items-center space-x-4">
        <a href="{{ route('admin.mentor.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center">
            <i class="fas fa-plus mr-2"></i>
            Tambah Mentor
        </a>
    </div>
    <div class="text-sm text-gray-500">
        <i class="fas fa-clock mr-1"></i>
        Terakhir update: {{ now()->format('d/m/Y H:i') }}
    </div>
</div>

<div class="bg-white shadow overflow-hidden sm:rounded-lg">
    <!-- Info Section -->
    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex flex-wrap items-center gap-3">
                <span class="text-sm text-gray-600 flex items-center">
                    <i class="fas fa-list mr-1"></i>
                    Menampilkan {{ $mentor->count() }} dari {{ $mentor->total() }} data
                </span>
                @if(request('search'))
                    <span class="text-sm bg-green-100 text-green-800 px-2 py-1 rounded-full flex items-center">
                        <i class="fas fa-search mr-1"></i>
                        Pencarian: "{{ request('search') }}"
                    </span>
                @endif
                @if(request('search'))
                    <a href="{{ route('admin.mentor.index') }}" class="text-sm bg-red-100 text-red-800 px-2 py-1 rounded-full hover:bg-red-200 transition-colors duration-200 flex items-center">
                        <i class="fas fa-times mr-1"></i>
                        Hapus Filter
                    </a>
                @endif
            </div>
            <div class="text-sm text-gray-500 flex items-center">
                <i class="fas fa-file-alt mr-1"></i>
                Halaman {{ $mentor->currentPage() }} dari {{ $mentor->lastPage() }}
            </div>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">WhatsApp</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keahlian</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($mentor as $row)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $row->id_mentor }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm">
                            <div class="font-medium text-gray-900">{{ $row->nama }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $row->email }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($row->nomor_wa)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $row->nomor_wa) }}" 
                               target="_blank" 
                               class="inline-flex items-center px-3 py-1.5 bg-green-100 text-green-800 text-sm rounded-lg hover:bg-green-200 transition-colors duration-200 group relative"
                               title="Chat WhatsApp dengan {{ $row->nama }}">
                                <i class="fab fa-whatsapp mr-2 text-green-600"></i>
                                {{ $row->nomor_wa }}
                                <span class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap">
                                    Klik untuk chat WhatsApp
                                </span>
                            </a>
                        @else
                            <span class="text-gray-400 text-sm">Tidak tersedia</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 max-w-xs truncate" title="{{ $row->keahlian }}">
                            {{ $row->keahlian }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ optional($row->created_at)->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('admin.mentor.show', $row->id_mentor) }}" class="text-blue-600 hover:text-blue-900" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.mentor.edit', $row->id_mentor) }}" class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.mentor.destroy', $row->id_mentor) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mentor {{ $row->nama }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-search text-gray-400 text-xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">
                                @if(request('search'))
                                    Tidak ada mentor yang ditemukan
                                @else
                                    Belum ada data mentor
                                @endif
                            </h3>
                            <p class="text-gray-500 mb-4">
                                @if(request('search'))
                                    Coba ubah kata kunci pencarian Anda.
                                @else
                                    Data mentor akan muncul di sini setelah ada mentor yang ditambahkan.
                                @endif
                            </p>
                            @if(request('search'))
                                <a href="{{ route('admin.mentor.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                                    <i class="fas fa-times mr-2"></i>
                                    Hapus Filter
                                </a>
                            @else
                                <a href="{{ route('admin.mentor.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                                    <i class="fas fa-plus mr-2"></i>
                                    Tambah Mentor Pertama
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
                Menampilkan {{ $mentor->firstItem() ?? 0 }} - {{ $mentor->lastItem() ?? 0 }} dari {{ $mentor->total() }} data
            </div>
            <div>
                {{ $mentor->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
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

// Auto-submit search form when input changes
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                submitForm();
            }, 500); // Delay 500ms after user stops typing
        });
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
                <span class="text-gray-700">Mencari mentor...</span>
            </div>
        `;
        document.body.appendChild(overlay);
        
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mencari...';
        submitBtn.disabled = true;
        
        // Submit form
        form.submit();
    }
});

// WhatsApp confirmation
document.addEventListener('DOMContentLoaded', function() {
    const whatsappLinks = document.querySelectorAll('a[href^="https://wa.me/"]');
    whatsappLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const nama = this.getAttribute('title')?.replace('Chat WhatsApp dengan ', '') || 'mentor';
            const nomor = this.textContent.trim();
            
            if (!confirm(`Buka chat WhatsApp dengan ${nama} (${nomor})?`)) {
                e.preventDefault();
            }
        });
    });
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
