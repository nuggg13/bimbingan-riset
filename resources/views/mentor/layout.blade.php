<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Mentor - Bimbingan Riset')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @stack('styles')
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200 hidden md:flex md:flex-col">
            <div class="h-16 flex items-center px-6 border-b border-gray-200">
                <i class="fas fa-chalkboard-teacher text-green-600 text-2xl"></i>
                <div class="ml-3">
                    <p class="text-sm text-gray-500 leading-tight">Panel Mentor</p>
                    <h1 class="text-lg font-semibold text-gray-800 leading-tight">Bimbingan Riset</h1>
                </div>
            </div>
            <nav class="flex-1 px-4 py-6 space-y-1">
                <a href="{{ route('mentor.dashboard') }}" class="flex items-center px-3 py-2 rounded-lg text-sm font-medium hover:bg-green-50 hover:text-green-700 {{ request()->routeIs('mentor.dashboard') ? 'bg-green-100 text-green-700' : 'text-gray-700' }}">
                    <i class="fas fa-home w-5 mr-3"></i> Dashboard
                </a>
                <a href="{{ route('mentor.participants') }}" class="flex items-center px-3 py-2 rounded-lg text-sm font-medium hover:bg-green-50 hover:text-green-700 {{ request()->routeIs('mentor.participants*') ? 'bg-green-100 text-green-700' : 'text-gray-700' }}">
                    <i class="fas fa-users w-5 mr-3"></i> Peserta Bimbingan
                </a>
                <a href="{{ route('mentor.schedules') }}" class="flex items-center px-3 py-2 rounded-lg text-sm font-medium hover:bg-green-50 hover:text-green-700 {{ request()->routeIs('mentor.schedules*') ? 'bg-green-100 text-green-700' : 'text-gray-700' }}">
                    <i class="fas fa-calendar-alt w-5 mr-3"></i> Jadwal Bimbingan
                </a>
                <a href="{{ route('mentor.catatan-bimbingan.index') }}" class="flex items-center px-3 py-2 rounded-lg text-sm font-medium hover:bg-green-50 hover:text-green-700 {{ request()->routeIs('mentor.catatan-bimbingan*') ? 'bg-green-100 text-green-700' : 'text-gray-700' }}">
                    <i class="fas fa-sticky-note w-5 mr-3"></i> Catatan Bimbingan
                </a>
            </nav>
            <div class="px-4 py-4 border-t border-gray-200">
                <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                    <p class="text-xs text-gray-500 mb-1">Logged in as:</p>
                    <p class="text-sm font-medium text-gray-800">{{ Auth::guard('mentor')->user()->nama }}</p>
                    <p class="text-xs text-gray-600">{{ Auth::guard('mentor')->user()->keahlian }}</p>
                </div>
                <form method="POST" action="{{ route('mentor.logout') }}">
                    @csrf
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main -->
        <div class="flex-1 flex flex-col min-w-0">
            <!-- Topbar (mobile) -->
            <div class="md:hidden bg-white border-b border-gray-200 h-16 flex items-center justify-between px-4">
                <div class="flex items-center">
                    <i class="fas fa-chalkboard-teacher text-green-600 text-xl"></i>
                    <span class="ml-2 font-semibold">Mentor</span>
                </div>
                <div>
                    <a href="{{ route('mentor.dashboard') }}" class="text-sm text-green-700">Dashboard</a>
                </div>
            </div>

            <!-- Content -->
            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>