@extends('registration.layout')

@section('title', 'Langkah 1 - Data Diri')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-2">Data Diri Peserta</h2>
        <p class="text-gray-600">Lengkapi informasi pribadi Anda untuk melanjutkan pendaftaran</p>
    </div>

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6 alert-auto-hide">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-400"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan pada form:</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('register.step1.process') }}" class="space-y-6">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Nama -->
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-user text-gray-400 mr-2"></i>Nama Lengkap
                </label>
                <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                    placeholder="Masukkan nama lengkap Anda">
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-envelope text-gray-400 mr-2"></i>Email
                </label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                    placeholder="contoh@email.com">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-lock text-gray-400 mr-2"></i>Password
                </label>
                <input type="password" id="password" name="password" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                    placeholder="Minimal 8 karakter">
            </div>

            <!-- Konfirmasi Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-lock text-gray-400 mr-2"></i>Konfirmasi Password
                </label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                    placeholder="Ulangi password">
            </div>
        </div>

        <!-- Nomor WhatsApp -->
        <div>
            <label for="nomor_wa" class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fab fa-whatsapp text-gray-400 mr-2"></i>Nomor WhatsApp
            </label>
            <div class="relative">
                <input type="text" id="nomor_wa" name="nomor_wa" value="{{ old('nomor_wa') }}" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                    placeholder="+628xxxxxxxxxx"
                    pattern="^\+62[0-9]{9,13}$">
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <i class="fas fa-info-circle text-gray-400" title="Format: +62 diikuti 9-13 digit angka"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-1">Format: +62 diikuti dengan nomor tanpa angka 0 di depan (contoh: +628123456789)</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Instansi -->
            <div>
                <label for="instansi" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-university text-gray-400 mr-2"></i>Instansi/Universitas
                </label>
                <input type="text" id="instansi" name="instansi" value="{{ old('instansi') }}" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                    placeholder="Nama universitas atau instansi">
            </div>

            <!-- Fakultas -->
            <div>
                <label for="fakultas" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-graduation-cap text-gray-400 mr-2"></i>Fakultas/Jurusan
                </label>
                <input type="text" id="fakultas" name="fakultas" value="{{ old('fakultas') }}" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                    placeholder="Nama fakultas atau jurusan">
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end pt-6">
            <button type="submit" 
                class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-8 py-3 rounded-lg font-semibold hover:from-blue-600 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transform hover:scale-105 transition duration-200 flex items-center">
                Lanjutkan ke Langkah 2
                <i class="fas fa-arrow-right ml-2"></i>
            </button>
        </div>
    </form>

    <!-- Login Link -->
    <div class="text-center mt-8 pt-6 border-t border-gray-200">
        <p class="text-gray-600">
            Sudah memiliki akun? 
            <a href="{{ route('peserta.login') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                Login di sini
            </a>
        </p>
    </div>
</div>
@endsection