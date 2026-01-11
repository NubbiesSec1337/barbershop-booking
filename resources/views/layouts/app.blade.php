<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BarberBook - @yield('title', 'Booking UMKM')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    
    {{-- Minimalist Header --}}
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                {{-- Logo --}}
                <a href="{{ route('bookings.index') }}" class="flex items-center gap-2 group">
                    <svg class="w-5 h-5 text-gray-700 group-hover:text-blue-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 5.758a3 3 0 10-4.243 4.243 3 3 0 004.243-4.243zm0-5.758a3 3 0 10-4.243-4.243 3 3 0 004.243 4.243z"/>
                    </svg>
                    <span class="text-lg font-medium text-gray-900">BarberBook</span>
                </a>
                
                {{-- Navigation --}}
                <nav class="flex items-center gap-6">
                    @auth
                    <a href="{{ route('bookings.my') }}" class="text-sm text-gray-700 hover:text-gray-900 transition">
                        Booking Saya
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm text-gray-700 hover:text-gray-900 transition">
                            Keluar
                        </button>
                    </form>
                    @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-gray-900 transition">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition">
                        Daftar
                    </a>
                    @endauth
                </nav>
            </div>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="min-h-screen">
        {{-- Flash Messages --}}
        @if(session('success'))
        <div class="max-w-6xl mx-auto px-4 pt-6">
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded text-sm">
                {{ session('success') }}
            </div>
        </div>
        @endif
        
        @if($errors->any())
        <div class="max-w-6xl mx-auto px-4 pt-6">
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        @yield('content')
    </main>

</body>
</html>
