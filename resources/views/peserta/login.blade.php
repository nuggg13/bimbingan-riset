@extends('peserta.layout')

@section('title', 'Login Peserta')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Header -->
        <div class="text-center">
            <div class="mx-auto w-20 h-20 gradient-bg rounded-full flex items-center justify-center mb-6">
                <i class="fas fa-user text-white text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Login Peserta</h1>
            <p class="text-gray-600">Masuk ke akun bimbingan riset Anda</p>
        </div>

        <!-- Login Form -->
        <div class="bg-white shadow-2xl rounded-2xl p-8">
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6 alert-auto-hide">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <div class="text-sm text-red-700">
                                @foreach($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6 alert-auto-hide">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-800">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6 alert-auto-hide">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('peserta.login.process') }}" class="space-y-6">
                @csrf
                
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-envelope text-gray-400 mr-2"></i>Email
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                        placeholder="Masukkan email Anda">
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock text-gray-400 mr-2"></i>Password
                    </label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                        placeholder="Masukkan password Anda">
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                    class="w-full gradient-bg text-white px-4 py-3 rounded-lg font-semibold hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transform hover:scale-105 transition duration-200">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Login
                </button>
            </form>

            <!-- Register Link -->
            <div class="text-center mt-6 pt-6 border-t border-gray-200">
                <p class="text-gray-600">
                    Belum memiliki akun? 
                    <a href="{{ route('register.step1') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                        Daftar di sini
                    </a>
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center text-gray-500 text-sm">
            <p>&copy; 2025 Bimbingan Riset. Semua hak dilindungi.</p>
        </div>
    </div>
</div>
@endsection