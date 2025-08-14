@extends('registration.layout')

@section('title', 'Pendaftaran Berhasil')

@section('content')
<div class="max-w-2xl mx-auto text-center">
    <!-- Success Icon -->
    <div class="mb-8">
        <div class="mx-auto w-24 h-24 bg-gradient-to-r from-green-400 to-green-600 rounded-full flex items-center justify-center">
            <i class="fas fa-check text-white text-4xl"></i>
        </div>
    </div>

    <!-- Success Message -->
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">Pendaftaran Berhasil!</h2>
        <p class="text-lg text-gray-600 mb-6">
            Selamat! Pendaftaran Anda telah berhasil disubmit dan sedang dalam proses review.
        </p>
    </div>

    <!-- Registration Details -->
    <div class="bg-gray-50 rounded-xl p-6 mb-8 text-left">
        <h3 class="text-xl font-semibold text-gray-900 mb-4 text-center">Detail Pendaftaran</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-500">Nama Lengkap</label>
                <p class="text-gray-900 font-semibold">{{ $peserta->nama }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-500">Email</label>
                <p class="text-gray-900 font-semibold">{{ $peserta->email }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-500">Instansi</label>
                <p class="text-gray-900 font-semibold">{{ $peserta->instansi }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-500">Fakultas</label>
                <p class="text-gray-900 font-semibold">{{ $peserta->fakultas }}</p>
            </div>
        </div>
        
        <div class="mt-4">
            <label class="block text-sm font-medium text-gray-500">Judul Riset</label>
            <p class="text-gray-900 font-semibold">{{ $pendaftaran->judul_riset }}</p>
        </div>
        
        <div class="mt-4">
            <label class="block text-sm font-medium text-gray-500">Minat Keilmuan</label>
            <p class="text-gray-900 font-semibold">{{ $pendaftaran->minat_keilmuan }}</p>
        </div>
    </div>

    <!-- Status Information -->
    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 mb-8">
        <div class="flex items-center justify-center mb-4">
            <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                <i class="fas fa-clock text-yellow-600 text-xl"></i>
            </div>
        </div>
        
        <h3 class="text-lg font-semibold text-yellow-800 mb-2">Status: {{ $pendaftaran->status_label }}</h3>
        <p class="text-yellow-700">
            {{ $pendaftaran->status_message }}
        </p>
    </div>

    <!-- Next Steps -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-8">
        <h3 class="text-lg font-semibold text-blue-800 mb-4">Langkah Selanjutnya</h3>
        <div class="text-left space-y-3 text-blue-700">
            <div class="flex items-start">
                <i class="fas fa-check-circle text-blue-500 mt-1 mr-3"></i>
                <p>Tim kami akan mereview pendaftaran Anda dalam 1-3 hari kerja</p>
            </div>
            <div class="flex items-start">
                <i class="fas fa-envelope text-blue-500 mt-1 mr-3"></i>
                <p>Anda akan menerima notifikasi melalui email dan WhatsApp</p>
            </div>
            <div class="flex items-start">
                <i class="fas fa-sign-in-alt text-blue-500 mt-1 mr-3"></i>
                <p>Login ke akun Anda untuk melihat update status pendaftaran</p>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="space-y-4">
        <a href="{{ route('peserta.login') }}" 
            class="w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white px-8 py-4 rounded-lg font-semibold hover:from-blue-600 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transform hover:scale-105 transition duration-200 flex items-center justify-center">
            <i class="fas fa-sign-in-alt mr-2"></i>
            Login ke Akun Saya
        </a>
        
        <a href="{{ route('register.step1') }}" 
            class="w-full bg-gray-100 text-gray-700 px-8 py-4 rounded-lg font-semibold hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition duration-200 flex items-center justify-center">
            <i class="fas fa-plus mr-2"></i>
            Daftarkan Riset Lain
        </a>
    </div>

    <!-- Contact Information -->
    <div class="mt-8 pt-6 border-t border-gray-200">
        <p class="text-gray-600 text-sm">
            Butuh bantuan? Hubungi kami di 
            <a href="mailto:admin@bimbinganriset.com" class="text-blue-600 hover:text-blue-800 font-semibold">
                admin@bimbinganriset.com
            </a>
        </p>
    </div>
</div>

<script>
    // Clear registration success session after page load
    window.addEventListener('load', function() {
        fetch('{{ route("register.clear-session") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            }
        });
    });
</script>
@endsection