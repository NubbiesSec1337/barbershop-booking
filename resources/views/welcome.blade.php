<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BarberBook - Platform Booking Barbershop Premium #1 di Indonesia</title>
    <meta name="description" content="Booking barbershop online mudah dan cepat. Pilih barber profesional, layanan lengkap, dan jadwal fleksibel. Tanpa antre, tanpa ribet.">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .gradient-text {
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .glass-effect {
            background: rgba(17, 24, 39, 0.6);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .float-animation {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }
        
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
        
        @keyframes pulse-slow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        
        .pulse-slow {
            animation: pulse-slow 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
</head>
<body class="font-sans antialiased bg-black text-white">
    
    {{-- Header --}}
    <header class="fixed top-0 left-0 right-0 z-50 glass-effect border-b border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 lg:h-20">
                <a href="{{ route('home') }}" class="flex items-center gap-2 lg:gap-3 group">
                    <div class="w-9 h-9 lg:w-11 lg:h-11 bg-white rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 lg:w-6 lg:h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 5.758a3 3 0 10-4.243 4.243 3 3 0 004.243-4.243zm0-5.758a3 3 0 10-4.243-4.243 3 3 0 004.243 4.243z"/>
                        </svg>
                    </div>
                    <span class="text-lg lg:text-xl font-bold text-white">BarberBook</span>
                </a>
                
                {{-- Desktop Navigation --}}
                <nav class="hidden lg:flex items-center gap-8">
                    <a href="#services" class="text-sm font-medium text-gray-300 hover:text-white transition">Layanan</a>
                    <a href="#benefits" class="text-sm font-medium text-gray-300 hover:text-white transition">Keunggulan</a>
                    <a href="#barbers" class="text-sm font-medium text-gray-300 hover:text-white transition">Barber</a>
                    <a href="#how" class="text-sm font-medium text-gray-300 hover:text-white transition">Cara Booking</a>
                    <a href="#faq" class="text-sm font-medium text-gray-300 hover:text-white transition">FAQ</a>
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="px-5 py-2.5 bg-white text-black text-sm font-semibold rounded-lg hover:bg-gray-100 transition">Admin Panel</a>
                        @else
                            <a href="{{ route('bookings.index') }}" class="px-5 py-2.5 bg-white text-black text-sm font-semibold rounded-lg hover:bg-gray-100 transition">Dashboard</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-sm font-medium text-gray-300 hover:text-white transition">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-300 hover:text-white transition">Masuk</a>
                        <a href="{{ route('register') }}" class="px-5 py-2.5 bg-white text-black text-sm font-semibold rounded-lg hover:bg-gray-100 transition">Daftar Gratis</a>
                    @endauth
                </nav>
                
                {{-- Mobile Menu Button --}}
                <button id="mobile-menu-btn" class="lg:hidden p-2 text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
        
        {{-- Mobile Menu --}}
        <div id="mobile-menu" class="hidden lg:hidden border-t border-gray-800 glass-effect">
            <div class="px-4 py-4 space-y-3">
                <a href="#services" class="block text-sm font-medium text-gray-300 hover:text-white transition py-2">Layanan</a>
                <a href="#benefits" class="block text-sm font-medium text-gray-300 hover:text-white transition py-2">Keunggulan</a>
                <a href="#barbers" class="block text-sm font-medium text-gray-300 hover:text-white transition py-2">Barber</a>
                <a href="#how" class="block text-sm font-medium text-gray-300 hover:text-white transition py-2">Cara Booking</a>
                <a href="#faq" class="block text-sm font-medium text-gray-300 hover:text-white transition py-2">FAQ</a>
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="block w-full px-5 py-2.5 bg-white text-black text-sm font-semibold rounded-lg hover:bg-gray-100 transition text-center">Admin Panel</a>
                    @else
                        <a href="{{ route('bookings.index') }}" class="block w-full px-5 py-2.5 bg-white text-black text-sm font-semibold rounded-lg hover:bg-gray-100 transition text-center">Dashboard</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="block text-sm font-medium text-gray-300 hover:text-white transition py-2">Masuk</a>
                    <a href="{{ route('register') }}" class="block w-full px-5 py-2.5 bg-white text-black text-sm font-semibold rounded-lg hover:bg-gray-100 transition text-center">Daftar Gratis</a>
                @endauth
            </div>
        </div>
    </header>

    {{-- Hero Section --}}
    <section class="relative min-h-screen flex items-center justify-center pt-24 lg:pt-20 pb-16 lg:pb-32 overflow-hidden">
        {{-- Background Effects --}}
        <div class="absolute inset-0 bg-gradient-to-b from-gray-900 via-black to-black"></div>
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-20 left-10 w-72 lg:w-96 h-72 lg:h-96 bg-blue-600 rounded-full blur-3xl float-animation"></div>
            <div class="absolute bottom-20 right-10 w-72 lg:w-96 h-72 lg:h-96 bg-purple-600 rounded-full blur-3xl float-animation" style="animation-delay: 3s;"></div>
        </div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center fade-in-up">
            <div class="mb-4 lg:mb-6">
                <span class="inline-block px-4 lg:px-5 py-2 glass-effect border border-white/20 rounded-full text-xs lg:text-sm font-medium text-gray-300">
                    Platform Booking Barbershop Terpercaya
                </span>
            </div>
            <h1 class="text-4xl sm:text-5xl lg:text-7xl xl:text-8xl font-black mb-6 lg:mb-8 leading-tight tracking-tight">
                Tampil Fresh & Percaya Diri,<br/>
                <span class="gradient-text">Tanpa Antre Lama</span>
            </h1>
            <p class="text-base sm:text-lg lg:text-2xl text-gray-400 mb-8 lg:mb-12 max-w-4xl mx-auto leading-relaxed px-4">
                Booking barber profesional kapan saja, dimana saja. Pilih layanan grooming premium, tentukan jadwal fleksibel, dan nikmati pengalaman barbershop modern tanpa ribet. Dapatkan potongan rambut berkualitas dengan harga terjangkau mulai dari 35 ribu.
            </p>
            <div class="flex flex-col sm:flex-row gap-3 lg:gap-4 justify-center items-center px-4">
                <a href="{{ route('bookings.index') }}" class="group w-full sm:w-auto inline-flex items-center justify-center px-6 lg:px-8 py-3 lg:py-4 bg-white text-black text-sm lg:text-base font-bold rounded-xl hover:bg-gray-100 transition-all hover:scale-105 shadow-2xl shadow-white/10">
                    Booking Sekarang Gratis
                    <svg class="ml-2 w-4 h-4 lg:w-5 lg:h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
                <a href="#services" class="w-full sm:w-auto inline-flex items-center justify-center px-6 lg:px-8 py-3 lg:py-4 glass-effect border-2 border-white/20 text-white text-sm lg:text-base font-semibold rounded-xl hover:bg-white/10 hover:border-white/30 transition">
                    Lihat Layanan Lengkap
                </a>
            </div>
            
            {{-- Stats --}}
            <div class="mt-12 lg:mt-20 grid grid-cols-3 gap-4 lg:gap-8 max-w-3xl mx-auto px-4">
                <div class="text-center">
                    <div class="text-2xl lg:text-4xl font-bold text-white mb-1 lg:mb-2">{{ $stats['bookings'] ?? 0 }}+</div>
                    <div class="text-xs lg:text-sm text-gray-500 uppercase tracking-wider">Customer Puas</div>
                </div>
                <div class="text-center border-x border-white/10">
                    <div class="text-2xl lg:text-4xl font-bold text-white mb-1 lg:mb-2">{{ $stats['barbers'] ?? 0 }}+</div>
                    <div class="text-xs lg:text-sm text-gray-500 uppercase tracking-wider">Barber Profesional</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl lg:text-4xl font-bold text-white mb-1 lg:mb-2">4.9</div>
                    <div class="text-xs lg:text-sm text-gray-500 uppercase tracking-wider">Rating Rata-rata</div>
                </div>
            </div>
            
            {{-- Trust Badges --}}
            <div class="mt-12 lg:mt-16 flex flex-wrap items-center justify-center gap-4 lg:gap-8 text-xs lg:text-sm text-gray-500 px-4">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 lg:w-5 lg:h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>Booking Instant</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 lg:w-5 lg:h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>Gratis Pendaftaran</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 lg:w-5 lg:h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>Data Aman Terjaga</span>
                </div>
            </div>
        </div>
    </section>

    {{-- Benefits Section --}}
    <section id="benefits" class="py-16 lg:py-32 bg-gradient-to-b from-black to-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 lg:mb-20">
                <span class="inline-block px-4 lg:px-5 py-2 glass-effect border border-blue-500/20 rounded-full text-xs lg:text-sm font-medium text-blue-400 mb-4 lg:mb-6">
                    Kenapa Harus BarberBook?
                </span>
                <h2 class="text-3xl lg:text-6xl font-black text-white mb-4 lg:mb-6">Solusi Grooming Modern</h2>
                <p class="text-base lg:text-xl text-gray-400 max-w-3xl mx-auto">Lupakan cara lama booking barbershop. Kami hadirkan pengalaman booking yang cepat, mudah, dan professional untuk gaya hidup modern Anda.</p>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8 mb-12 lg:mb-20">
                <div class="glass-effect border border-gray-700 rounded-2xl p-6 lg:p-10 hover:border-blue-500/50 transition hover-lift">
                    <div class="w-14 h-14 lg:w-16 lg:h-16 bg-blue-500/10 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 lg:w-9 lg:h-9 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl lg:text-2xl font-bold text-white mb-3 lg:mb-4">Hemat Waktu, Tanpa Antre</h3>
                    <p class="text-sm lg:text-base text-gray-400 leading-relaxed mb-4 lg:mb-6">Tidak perlu lagi menunggu lama di barbershop. Booking online dari rumah, pilih waktu yang pas, dan datang tepat waktu sesuai jadwal Anda. Sistem kami memastikan tidak ada double booking dan jadwal yang clash.</p>
                    <ul class="space-y-2 lg:space-y-3 text-sm lg:text-base text-gray-400">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 lg:w-6 lg:h-6 text-blue-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Booking 24/7 kapan saja dari smartphone</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 lg:w-6 lg:h-6 text-blue-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Lihat jadwal real-time barber favorit</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 lg:w-6 lg:h-6 text-blue-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Konfirmasi instant tanpa telepon</span>
                        </li>
                    </ul>
                </div>

                <div class="glass-effect border border-gray-700 rounded-2xl p-6 lg:p-10 hover:border-blue-500/50 transition hover-lift">
                    <div class="w-14 h-14 lg:w-16 lg:h-16 bg-purple-500/10 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 lg:w-9 lg:h-9 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl lg:text-2xl font-bold text-white mb-3 lg:mb-4">Barber Berpengalaman & Tersertifikasi</h3>
                    <p class="text-sm lg:text-base text-gray-400 leading-relaxed mb-4 lg:mb-6">Semua barber di platform kami adalah profesional bersertifikat dengan minimal 2 tahun pengalaman. Mereka ahli dalam berbagai teknik cutting modern seperti fade, undercut, pompadour, dan styling klasik. Hasil dijamin memuaskan atau uang kembali.</p>
                    <ul class="space-y-2 lg:space-y-3 text-sm lg:text-base text-gray-400">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 lg:w-6 lg:h-6 text-purple-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Tersertifikasi profesional barbering</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 lg:w-6 lg:h-6 text-purple-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Rating & review transparan dari customer</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 lg:w-6 lg:h-6 text-purple-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Update trend & teknik cutting terbaru</span>
                        </li>
                    </ul>
                </div>

                <div class="glass-effect border border-gray-700 rounded-2xl p-6 lg:p-10 hover:border-blue-500/50 transition hover-lift">
                    <div class="w-14 h-14 lg:w-16 lg:h-16 bg-green-500/10 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 lg:w-9 lg:h-9 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl lg:text-2xl font-bold text-white mb-3 lg:mb-4">Harga Transparan & Terjangkau</h3>
                    <p class="text-sm lg:text-base text-gray-400 leading-relaxed mb-4 lg:mb-6">Tidak ada biaya tersembunyi. Harga yang tertera adalah harga final yang Anda bayar. Dapatkan layanan barbershop premium dengan harga yang masuk akal mulai dari 35 ribu. Bandingkan dengan barbershop lain yang bisa sampai 2-3x lipat untuk kualitas yang sama.</p>
                    <ul class="space-y-2 lg:space-y-3 text-sm lg:text-base text-gray-400">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 lg:w-6 lg:h-6 text-green-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Harga tetap, tidak ada markup mendadak</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 lg:w-6 lg:h-6 text-green-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Paket hemat untuk perawatan rutin</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 lg:w-6 lg:h-6 text-green-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Gratis konsultasi gaya rambut sebelum potong</span>
                        </li>
                    </ul>
                </div>

                <div class="glass-effect border border-gray-700 rounded-2xl p-6 lg:p-10 hover:border-blue-500/50 transition hover-lift">
                    <div class="w-14 h-14 lg:w-16 lg:h-16 bg-orange-500/10 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 lg:w-9 lg:h-9 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl lg:text-2xl font-bold text-white mb-3 lg:mb-4">Hygiene & Keamanan Terjamin</h3>
                    <p class="text-sm lg:text-base text-gray-400 leading-relaxed mb-4 lg:mb-6">Semua alat potong dan peralatan grooming disterilkan sebelum dan sesudah pemakaian. Protokol kesehatan ketat diterapkan untuk kenyamanan dan keamanan Anda. Kami paham pentingnya kebersihan dalam layanan personal grooming.</p>
                    <ul class="space-y-2 lg:space-y-3 text-sm lg:text-base text-gray-400">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 lg:w-6 lg:h-6 text-orange-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Alat steril & disinfeksi setiap pemakaian</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 lg:w-6 lg:h-6 text-orange-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Cape bersih sekali pakai per customer</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 lg:w-6 lg:h-6 text-orange-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Tempat nyaman & bersih terawat</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- Statistics Section --}}
    <section class="py-16 lg:py-24 bg-black border-y border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
                <div class="text-center">
                    <div class="text-4xl lg:text-5xl font-black text-white mb-2">5+</div>
                    <div class="text-sm lg:text-base text-gray-400">Tahun Beroperasi</div>
                    <p class="text-xs lg:text-sm text-gray-500 mt-2">Sejak 2021</p>
                </div>
                <div class="text-center">
                    <div class="text-4xl lg:text-5xl font-black text-white mb-2">15K+</div>
                    <div class="text-sm lg:text-base text-gray-400">Booking Selesai</div>
                    <p class="text-xs lg:text-sm text-gray-500 mt-2">Dan terus bertambah</p>
                </div>
                <div class="text-center">
                    <div class="text-4xl lg:text-5xl font-black text-white mb-2">98%</div>
                    <div class="text-sm lg:text-base text-gray-400">Tingkat Kepuasan</div>
                    <p class="text-xs lg:text-sm text-gray-500 mt-2">Customer puas</p>
                </div>
                <div class="text-center">
                    <div class="text-4xl lg:text-5xl font-black text-white mb-2">10+</div>
                    <div class="text-sm lg:text-base text-gray-400">Barber Profesional</div>
                    <p class="text-xs lg:text-sm text-gray-500 mt-2">Bersertifikat resmi</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Testimonials Section --}}
    <section class="py-16 lg:py-32 bg-gradient-to-b from-black to-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 lg:mb-20">
                <span class="inline-block px-4 lg:px-5 py-2 glass-effect border border-blue-500/20 rounded-full text-xs lg:text-sm font-medium text-blue-400 mb-4 lg:mb-6">
                    Testimoni Customer
                </span>
                <h2 class="text-3xl lg:text-6xl font-black text-white mb-4 lg:mb-6">Kata Mereka tentang Kami</h2>
                <p class="text-base lg:text-xl text-gray-400 max-w-3xl mx-auto">Ribuan customer puas dengan layanan kami. Ini kata mereka yang sudah merasakan pengalaman booking barbershop modern bersama BarberBook.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                <div class="glass-effect border border-gray-700 rounded-2xl p-6 lg:p-8 hover:border-gray-600 transition">
                    <div class="flex items-center gap-1 mb-4">
                        @for($i = 0; $i < 5; $i++)
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        @endfor
                    </div>
                    <p class="text-sm lg:text-base text-gray-300 mb-6 leading-relaxed">"Booking super mudah! Ga perlu antre lagi, tinggal pilih waktu yang pas dan langsung datang. Barbernya profesional banget, hasilnya rapih sesuai request. Recommended!"</p>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-purple-500"></div>
                        <div>
                            <div class="font-bold text-white text-sm lg:text-base">Andi Pratama</div>
                            <div class="text-xs lg:text-sm text-gray-500">Software Engineer</div>
                        </div>
                    </div>
                </div>

                <div class="glass-effect border border-gray-700 rounded-2xl p-6 lg:p-8 hover:border-gray-600 transition">
                    <div class="flex items-center gap-1 mb-4">
                        @for($i = 0; $i < 5; $i++)
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        @endfor
                    </div>
                    <p class="text-sm lg:text-base text-gray-300 mb-6 leading-relaxed">"Sistem bookingnya efisien banget. Bisa liat jadwal barber real-time, pilih yang available, dan konfirmasi langsung. Harganya transparan, ga ada biaya tambahan. Mantap!"</p>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-green-500 to-blue-500"></div>
                        <div>
                            <div class="font-bold text-white text-sm lg:text-base">Rizky Hidayat</div>
                            <div class="text-xs lg:text-sm text-gray-500">Marketing Manager</div>
                        </div>
                    </div>
                </div>

                <div class="glass-effect border border-gray-700 rounded-2xl p-6 lg:p-8 hover:border-gray-600 transition">
                    <div class="flex items-center gap-1 mb-4">
                        @for($i = 0; $i < 5; $i++)
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        @endfor
                    </div>
                    <p class="text-sm lg:text-base text-gray-300 mb-6 leading-relaxed">"Akhirnya ada solusi buat anak milenial yang males antre. Interface-nya user friendly, barbernya skilled, tempatnya bersih. Worth it banget dengan harganya. Will comeback!"</p>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-500 to-pink-500"></div>
                        <div>
                            <div class="font-bold text-white text-sm lg:text-base">Dimas Saputra</div>
                            <div class="text-xs lg:text-sm text-gray-500">Content Creator</div>
                        </div>
                    </div>
                </div>

                <div class="glass-effect border border-gray-700 rounded-2xl p-6 lg:p-8 hover:border-gray-600 transition">
                    <div class="flex items-center gap-1 mb-4">
                        @for($i = 0; $i < 5; $i++)
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        @endfor
                    </div>
                    <p class="text-sm lg:text-base text-gray-300 mb-6 leading-relaxed">"Sebagai orang yang sibuk, BarberBook sangat membantu. Bisa booking dari kantor saat lunch break, datang tepat waktu tanpa nunggu. Layanan cepat dan hasil memuaskan."</p>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-orange-500 to-red-500"></div>
                        <div>
                            <div class="font-bold text-white text-sm lg:text-base">Farhan Akbar</div>
                            <div class="text-xs lg:text-sm text-gray-500">Business Owner</div>
                        </div>
                    </div>
                </div>

                <div class="glass-effect border border-gray-700 rounded-2xl p-6 lg:p-8 hover:border-gray-600 transition">
                    <div class="flex items-center gap-1 mb-4">
                        @for($i = 0; $i < 5; $i++)
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        @endfor
                    </div>
                    <p class="text-sm lg:text-base text-gray-300 mb-6 leading-relaxed">"Pertama kali nyoba booking online untuk barbershop, ternyata gampang banget. Barbernya ramah, hasil potongannya presisi. Ditambah harga affordable. Highly recommended!"</p>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-teal-500 to-cyan-500"></div>
                        <div>
                            <div class="font-bold text-white text-sm lg:text-base">Yoga Permana</div>
                            <div class="text-xs lg:text-sm text-gray-500">UI/UX Designer</div>
                        </div>
                    </div>
                </div>

                <div class="glass-effect border border-gray-700 rounded-2xl p-6 lg:p-8 hover:border-gray-600 transition">
                    <div class="flex items-center gap-1 mb-4">
                        @for($i = 0; $i < 5; $i++)
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        @endfor
                    </div>
                    <p class="text-sm lg:text-base text-gray-300 mb-6 leading-relaxed">"Game changer! Ga perlu lagi datang pagi-pagi buat dapet urutan. Tinggal book malam sebelumnya, pagi datang langsung dilayani. Sistem yang sangat efisien untuk zaman sekarang."</p>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-indigo-500 to-blue-500"></div>
                        <div>
                            <div class="font-bold text-white text-sm lg:text-base">Bayu Wijaya</div>
                            <div class="text-xs lg:text-sm text-gray-500">Photographer</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Pricing Comparison --}}
    <section class="py-16 lg:py-32 bg-black">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 lg:mb-20">
                <span class="inline-block px-4 lg:px-5 py-2 glass-effect border border-blue-500/20 rounded-full text-xs lg:text-sm font-medium text-blue-400 mb-4 lg:mb-6">
                    Perbandingan Harga
                </span>
                <h2 class="text-3xl lg:text-6xl font-black text-white mb-4 lg:mb-6">Harga Terbaik di Kelasnya</h2>
                <p class="text-base lg:text-xl text-gray-400 max-w-3xl mx-auto">Bandingkan harga kami dengan barbershop konvensional. Dapatkan kualitas premium dengan harga yang lebih terjangkau dan tanpa biaya tambahan.</p>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8 max-w-5xl mx-auto">
                {{-- Barbershop Konvensional --}}
                <div class="glass-effect border border-gray-700 rounded-2xl p-6 lg:p-8">
                    <div class="text-center mb-6">
                        <h3 class="text-xl lg:text-2xl font-bold text-gray-400 mb-2">Barbershop Biasa</h3>
                        <div class="text-3xl lg:text-4xl font-black text-gray-500 mb-4">50K - 75K</div>
                        <p class="text-sm text-gray-500">Per potong rambut</p>
                    </div>
                    <ul class="space-y-3 mb-6">
                        <li class="flex items-start gap-3 text-sm text-gray-400">
                            <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <span>Harus antre lama</span>
                        </li>
                        <li class="flex items-start gap-3 text-sm text-gray-400">
                            <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <span>Tidak bisa pilih barber</span>
                        </li>
                        <li class="flex items-start gap-3 text-sm text-gray-400">
                            <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <span>Harga bisa berubah</span>
                        </li>
                        <li class="flex items-start gap-3 text-sm text-gray-400">
                            <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <span>Tidak ada riwayat booking</span>
                        </li>
                    </ul>
                </div>

                {{-- Barbershop Premium --}}
                <div class="glass-effect border border-gray-700 rounded-2xl p-6 lg:p-8">
                    <div class="text-center mb-6">
                        <h3 class="text-xl lg:text-2xl font-bold text-gray-400 mb-2">Barbershop Premium</h3>
                        <div class="text-3xl lg:text-4xl font-black text-gray-500 mb-4">100K - 200K</div>
                        <p class="text-sm text-gray-500">Per potong rambut</p>
                    </div>
                    <ul class="space-y-3 mb-6">
                        <li class="flex items-start gap-3 text-sm text-gray-400">
                            <svg class="w-5 h-5 text-yellow-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Bisa booking (kadang)</span>
                        </li>
                        <li class="flex items-start gap-3 text-sm text-gray-400">
                            <svg class="w-5 h-5 text-yellow-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Barber berpengalaman</span>
                        </li>
                        <li class="flex items-start gap-3 text-sm text-gray-400">
                            <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <span>Harga sangat mahal</span>
                        </li>
                        <li class="flex items-start gap-3 text-sm text-gray-400">
                            <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <span>Sistem booking ribet</span>
                        </li>
                    </ul>
                </div>

                {{-- BarberBook --}}
                <div class="relative glass-effect border-2 border-blue-500 rounded-2xl p-6 lg:p-8 shadow-2xl shadow-blue-500/20">
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-blue-500 text-white text-xs font-bold px-4 py-2 rounded-full">
                        BEST VALUE
                    </div>
                    <div class="text-center mb-6">
                        <h3 class="text-xl lg:text-2xl font-bold text-white mb-2">BarberBook</h3>
                        <div class="text-3xl lg:text-4xl font-black text-blue-400 mb-4">35K - 120K</div>
                        <p class="text-sm text-gray-400">Harga transparan</p>
                    </div>
                    <ul class="space-y-3 mb-6">
                        <li class="flex items-start gap-3 text-sm text-white">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Booking instant 24/7</span>
                        </li>
                        <li class="flex items-start gap-3 text-sm text-white">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Pilih barber favorit</span>
                        </li>
                        <li class="flex items-start gap-3 text-sm text-white">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Harga tetap & jelas</span>
                        </li>
                        <li class="flex items-start gap-3 text-sm text-white">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Riwayat booking lengkap</span>
                        </li>
                        <li class="flex items-start gap-3 text-sm text-white">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Tanpa antre & ribet</span>
                        </li>
                    </ul>
                    <a href="{{ route('register') }}" class="block w-full py-3 text-center bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition">
                        Daftar Sekarang
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Services Section --}}
    <section id="services" class="py-16 lg:py-32 bg-gradient-to-b from-black to-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 lg:mb-20">
                <span class="inline-block px-4 lg:px-5 py-2 glass-effect border border-blue-500/20 rounded-full text-xs lg:text-sm font-medium text-blue-400 mb-4 lg:mb-6">
                    Layanan Lengkap
                </span>
                <h2 class="text-3xl lg:text-6xl font-black text-white mb-4 lg:mb-6">Paket Grooming Premium</h2>
                <p class="text-base lg:text-xl text-gray-400 max-w-3xl mx-auto">Dari potongan rambut klasik hingga styling modern, kami punya semua yang Anda butuhkan untuk tampil maksimal. Semua layanan menggunakan produk premium dan ditangani barber berpengalaman.</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
                @foreach($services as $index => $service)
                <div class="group relative bg-gradient-to-br from-gray-800/80 to-gray-900/80 glass-effect border border-gray-700 rounded-2xl p-6 lg:p-8 hover:border-blue-500/50 transition-all duration-500 hover-lift">
                    @if($index === 3)
                    <div class="absolute -top-2 lg:-top-3 -right-2 lg:-right-3 bg-blue-500 text-white text-xs font-bold px-2 lg:px-3 py-1 lg:py-1.5 rounded-full">Terpopuler</div>
                    @endif
                    <div class="w-14 h-14 lg:w-16 lg:h-16 bg-blue-500/10 border border-blue-500/20 rounded-xl flex items-center justify-center mb-4 lg:mb-6 group-hover:bg-blue-500 group-hover:scale-110 transition-all">
                        <svg class="w-7 h-7 lg:w-8 lg:h-8 text-blue-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 5.758a3 3 0 10-4.243 4.243 3 3 0 004.243-4.243zm0-5.758a3 3 0 10-4.243-4.243 3 3 0 004.243 4.243z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl lg:text-2xl font-bold text-white mb-2 lg:mb-3">{{ $service->name }}</h3>
                    <p class="text-sm lg:text-base text-gray-400 mb-4 lg:mb-6 leading-relaxed">{{ $service->description }}</p>
                    <div class="flex items-baseline gap-2 mb-4 lg:mb-6">
                        <span class="text-2xl lg:text-3xl font-black text-white">Rp {{ number_format($service->price / 1000, 0) }}K</span>
                        <span class="text-xs lg:text-sm text-gray-500">/ {{ $service->duration_minutes }} menit</span>
                    </div>
                    <a href="{{ route('bookings.index') }}" class="block w-full py-2.5 lg:py-3 text-center bg-white/10 text-white text-sm lg:text-base font-semibold rounded-lg hover:bg-white hover:text-black transition">
                        Booking Sekarang
                    </a>
                </div>
                @endforeach
            </div>
            
            <div class="mt-12 lg:mt-16 text-center">
                <p class="text-sm lg:text-base text-gray-400 mb-6 lg:mb-8">Semua layanan sudah termasuk konsultasi gratis dan produk premium</p>
                <a href="{{ route('bookings.index') }}" class="inline-flex items-center justify-center px-6 lg:px-8 py-3 lg:py-4 bg-blue-600 text-white text-sm lg:text-base font-bold rounded-xl hover:bg-blue-700 transition">
                    Lihat Semua Layanan & Harga
                    <svg class="ml-2 w-4 h-4 lg:w-5 lg:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    {{-- Barbers Section --}}
    <section id="barbers" class="py-16 lg:py-32 bg-black">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 lg:mb-20">
                <span class="inline-block px-4 lg:px-5 py-2 glass-effect border border-blue-500/20 rounded-full text-xs lg:text-sm font-medium text-blue-400 mb-4 lg:mb-6">
                    Tim Profesional
                </span>
                <h2 class="text-3xl lg:text-6xl font-black text-white mb-4 lg:mb-6">Barber Berpengalaman</h2>
                <p class="text-base lg:text-xl text-gray-400 max-w-3xl mx-auto">Kenalan dengan barber profesional kami yang siap memberikan layanan terbaik. Setiap barber telah melewati seleksi ketat dan training intensif untuk memastikan kepuasan Anda.</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                @forelse($barbers as $barber)
                <div class="group glass-effect border border-gray-700 rounded-2xl p-6 lg:p-8 hover:border-blue-500/50 transition-all duration-500 hover-lift text-center">
                    <div class="w-20 h-20 lg:w-24 lg:h-24 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 mb-4 lg:mb-6 mx-auto group-hover:scale-110 transition-transform"></div>
                    <h3 class="text-xl lg:text-2xl font-bold text-white mb-2">{{ $barber->name }}</h3>
                    <p class="text-sm lg:text-base text-gray-400 mb-4 lg:mb-6 leading-relaxed">{{ $barber->bio ?? 'Barber profesional dengan pengalaman bertahun-tahun dalam memberikan layanan grooming berkualitas tinggi.' }}</p>
                    <div class="flex items-center justify-center gap-2 mb-4 lg:mb-6">
                        <div class="flex items-center gap-1">
                            @for($i = 0; $i < 5; $i++)
                            <svg class="w-4 h-4 lg:w-5 lg:h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            @endfor
                        </div>
                        <span class="text-xs lg:text-sm text-gray-400">(4.9)</span>
                    </div>
                    <div class="flex items-center justify-center gap-2 text-xs lg:text-sm text-gray-400 mb-4 lg:mb-6">
                        <div class="w-2 h-2 rounded-full bg-green-500 pulse-slow"></div>
                        <span>Tersedia</span>
                    </div>
                    <a href="{{ route('bookings.index') }}" class="block w-full py-2.5 lg:py-3 text-center bg-white/10 text-white text-sm lg:text-base font-semibold rounded-lg hover:bg-white hover:text-black transition">
                        Book {{ $barber->name }}
                    </a>
                </div>
                @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-400">Barber akan segera tersedia</p>
                </div>
                @endforelse
            </div>
            
            <div class="mt-12 lg:mt-16 text-center">
                <a href="{{ route('bookings.index') }}" class="inline-flex items-center justify-center px-6 lg:px-8 py-3 lg:py-4 glass-effect border-2 border-white/20 text-white text-sm lg:text-base font-semibold rounded-xl hover:bg-white/10 transition">
                    Lihat Semua Barber
                    <svg class="ml-2 w-4 h-4 lg:w-5 lg:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    {{-- How It Works --}}
    <section id="how" class="py-16 lg:py-32 bg-gradient-to-b from-black to-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 lg:mb-20">
                <span class="inline-block px-4 lg:px-5 py-2 glass-effect border border-blue-500/20 rounded-full text-xs lg:text-sm font-medium text-blue-400 mb-4 lg:mb-6">
                    Proses Mudah
                </span>
                <h2 class="text-3xl lg:text-6xl font-black text-white mb-4 lg:mb-6">Cara Booking dalam 3 Langkah</h2>
                <p class="text-base lg:text-xl text-gray-400 max-w-3xl mx-auto">Sistem booking yang dirancang user-friendly agar siapapun bisa melakukan booking dengan mudah dan cepat tanpa bingung.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12">
                <div class="text-center">
                    <div class="w-16 h-16 lg:w-20 lg:h-20 bg-blue-500 text-white text-2xl lg:text-3xl font-black rounded-full flex items-center justify-center mx-auto mb-4 lg:mb-6 shadow-2xl shadow-blue-500/30">1</div>
                    <h3 class="text-xl lg:text-2xl font-bold text-white mb-3 lg:mb-4">Daftar & Pilih Layanan</h3>
                    <p class="text-sm lg:text-base text-gray-400 leading-relaxed">Daftar akun gratis dalam 30 detik. Pilih layanan barbershop yang kamu butuhkan dari berbagai pilihan lengkap mulai dari potong rambut biasa hingga styling premium.</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 lg:w-20 lg:h-20 bg-blue-500 text-white text-2xl lg:text-3xl font-black rounded-full flex items-center justify-center mx-auto mb-4 lg:mb-6 shadow-2xl shadow-blue-500/30">2</div>
                    <h3 class="text-xl lg:text-2xl font-bold text-white mb-3 lg:mb-4">Pilih Barber & Jadwal</h3>
                    <p class="text-sm lg:text-base text-gray-400 leading-relaxed">Lihat profil barber, rating, dan jadwal tersedia secara real-time. Pilih barber favorit dan waktu yang pas dengan schedule kamu. Bisa booking hari ini atau untuk minggu depan.</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 lg:w-20 lg:h-20 bg-blue-500 text-white text-2xl lg:text-3xl font-black rounded-full flex items-center justify-center mx-auto mb-4 lg:mb-6 shadow-2xl shadow-blue-500/30">3</div>
                    <h3 class="text-xl lg:text-2xl font-bold text-white mb-3 lg:mb-4">Konfirmasi & Datang</h3>
                    <p class="text-sm lg:text-base text-gray-400 leading-relaxed">Terima konfirmasi booking instant via email dan notifikasi. Datang sesuai jadwal yang sudah ditentukan. Tidak perlu antre, barber sudah siap melayani kamu.</p>
                </div>
            </div>
            
            <div class="mt-12 lg:mt-16 text-center">
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-6 lg:px-8 py-3 lg:py-4 bg-white text-black text-sm lg:text-base font-bold rounded-xl hover:bg-gray-100 transition hover:scale-105">
                    Mulai Booking Gratis Sekarang
                    <svg class="ml-2 w-4 h-4 lg:w-5 lg:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    {{-- Additional Benefits Section --}}
    <section class="py-16 lg:py-32 bg-black">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 lg:mb-20">
                <h2 class="text-3xl lg:text-5xl font-black text-white mb-4 lg:mb-6">Mengapa Ribuan Pria Memilih Kami?</h2>
                <p class="text-base lg:text-xl text-gray-400 max-w-3xl mx-auto">Lebih dari sekedar potong rambut. Kami menghadirkan pengalaman grooming modern yang disesuaikan dengan gaya hidup Anda.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                <div class="flex gap-6 glass-effect border border-gray-700 rounded-2xl p-6 lg:p-8 hover:border-gray-600 transition">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 lg:w-14 lg:h-14 bg-blue-500/10 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 lg:w-7 lg:h-7 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg lg:text-xl font-bold text-white mb-2 lg:mb-3">Super Cepat & Efisien</h3>
                        <p class="text-sm lg:text-base text-gray-400 leading-relaxed">Sistem booking yang dirancang untuk menghemat waktu Anda. Dari proses booking hingga selesai layanan, semuanya berjalan dengan efisien. Rata-rata customer kami menghemat 30-45 menit per kunjungan karena tidak perlu antre.</p>
                    </div>
                </div>

                <div class="flex gap-6 glass-effect border border-gray-700 rounded-2xl p-6 lg:p-8 hover:border-gray-600 transition">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 lg:w-14 lg:h-14 bg-purple-500/10 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 lg:w-7 lg:h-7 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg lg:text-xl font-bold text-white mb-2 lg:mb-3">Jaminan Kepuasan 100%</h3>
                        <p class="text-sm lg:text-base text-gray-400 leading-relaxed">Tidak puas dengan hasilnya? Kami akan re-cut gratis atau uang kembali penuh. Kepuasan Anda adalah prioritas utama kami. Itulah mengapa 98% customer kami memberikan rating 5 bintang dan kembali lagi.</p>
                    </div>
                </div>

                <div class="flex gap-6 glass-effect border border-gray-700 rounded-2xl p-6 lg:p-8 hover:border-gray-600 transition">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 lg:w-14 lg:h-14 bg-green-500/10 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 lg:w-7 lg:h-7 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg lg:text-xl font-bold text-white mb-2 lg:mb-3">Reward & Loyalty Program</h3>
                        <p class="text-sm lg:text-base text-gray-400 leading-relaxed">Dapatkan poin setiap booking yang bisa ditukar dengan diskon atau layanan gratis. Booking ke-10 Anda gratis! Plus akses ke promo eksklusif dan early bird booking untuk slot favorit.</p>
                    </div>
                </div>

                <div class="flex gap-6 glass-effect border border-gray-700 rounded-2xl p-6 lg:p-8 hover:border-gray-600 transition">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 lg:w-14 lg:h-14 bg-orange-500/10 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 lg:w-7 lg:h-7 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg lg:text-xl font-bold text-white mb-2 lg:mb-3">Customer Support 24/7</h3>
                        <p class="text-sm lg:text-base text-gray-400 leading-relaxed">Ada pertanyaan atau kendala? Tim support kami siap membantu kapan saja melalui chat, email, atau WhatsApp. Response time rata-rata kami di bawah 5 menit untuk memastikan pengalaman terbaik.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FAQ Section --}}
    <section id="faq" class="py-16 lg:py-32 bg-gradient-to-b from-black to-gray-900">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 lg:mb-16">
                <span class="inline-block px-4 lg:px-5 py-2 glass-effect border border-blue-500/20 rounded-full text-xs lg:text-sm font-medium text-blue-400 mb-4 lg:mb-6">
                    Pertanyaan Umum
                </span>
                <h2 class="text-3xl lg:text-5xl font-black text-white mb-4 lg:mb-6">Frequently Asked Questions</h2>
                <p class="text-base lg:text-xl text-gray-400">Semua yang perlu Anda ketahui tentang BarberBook</p>
            </div>
            
            <div class="space-y-4 lg:space-y-6">
                <div class="glass-effect border border-gray-700 rounded-2xl p-6 lg:p-8 hover:border-gray-600 transition">
                    <h3 class="text-lg lg:text-xl font-bold text-white mb-3 lg:mb-4">Apakah gratis untuk booking?</h3>
                    <p class="text-sm lg:text-base text-gray-400 leading-relaxed mb-4">Ya, 100% gratis. Tidak ada biaya pendaftaran, biaya admin, atau biaya tersembunyi lainnya. Anda hanya membayar harga layanan yang tertera saat datang ke barbershop. Platform kami sepenuhnya gratis untuk customer.</p>
                    <p class="text-sm lg:text-base text-gray-400 leading-relaxed">Kami percaya teknologi harus membuat hidup lebih mudah, bukan lebih mahal. Oleh karena itu, BarberBook selamanya gratis untuk semua pengguna.</p>
                </div>
                
                <div class="glass-effect border border-gray-700 rounded-2xl p-6 lg:p-8 hover:border-gray-600 transition">
                    <h3 class="text-lg lg:text-xl font-bold text-white mb-3 lg:mb-4">Bagaimana jika saya ingin membatalkan booking?</h3>
                    <p class="text-sm lg:text-base text-gray-400 leading-relaxed mb-4">Anda bisa membatalkan booking kapan saja melalui dashboard tanpa penalti. Kami sarankan untuk membatalkan minimal 2 jam sebelum jadwal agar slot tersedia untuk customer lain dan tidak merugikan barber yang sudah mempersiapkan waktu untuk Anda.</p>
                    <p class="text-sm lg:text-base text-gray-400 leading-relaxed">Untuk pembatalan mendadak (kurang dari 2 jam sebelum jadwal), mungkin Anda akan mendapat warning. Pembatalan berulang tanpa alasan dapat mempengaruhi akun Anda.</p>
                </div>
                
                <div class="glass-effect border border-gray-700 rounded-2xl p-6 lg:p-8 hover:border-gray-600 transition">
                    <h3 class="text-lg lg:text-xl font-bold text-white mb-3 lg:mb-4">Apakah bisa booking untuk hari ini?</h3>
                    <p class="text-sm lg:text-base text-gray-400 leading-relaxed mb-4">Tentu bisa! Sistem kami menampilkan jadwal real-time. Jika ada slot kosong untuk hari ini, Anda bisa langsung booking dan datang. Banyak customer kami yang booking di pagi hari dan datang siang harinya.</p>
                    <p class="text-sm lg:text-base text-gray-400 leading-relaxed">Untuk hasil terbaik, kami rekomendasikan booking minimal 1 hari sebelumnya agar Anda punya lebih banyak pilihan waktu dan barber. Tapi untuk urgent case, same-day booking sangat memungkinkan.</p>
                </div>
                
                <div class="glass-effect border border-gray-700 rounded-2xl p-6 lg:p-8 hover:border-gray-600 transition">
                    <h3 class="text-lg lg:text-xl font-bold text-white mb-3 lg:mb-4">Apakah saya bisa pilih barber tertentu?</h3>
                    <p class="text-sm lg:text-base text-gray-400 leading-relaxed mb-4">Ya, Anda bebas memilih barber mana pun yang tersedia. Lihat profil lengkap mereka termasuk spesialisasi, rating dari customer lain, dan jadwal ketersediaan. Anda juga bisa menyimpan barber favorit untuk booking lebih cepat di lain waktu.</p>
                    <p class="text-sm lg:text-base text-gray-400 leading-relaxed">Jika barber favorit Anda penuh, sistem akan merekomendasikan barber lain dengan spesialisasi serupa dan rating tinggi sebagai alternatif.</p>
                </div>
                
                <div class="glass-effect border border-gray-700 rounded-2xl p-6 lg:p-8 hover:border-gray-600 transition">
                    <h3 class="text-lg lg:text-xl font-bold text-white mb-3 lg:mb-4">Bagaimana sistem pembayarannya?</h3>
                    <p class="text-sm lg:text-base text-gray-400 leading-relaxed mb-4">Saat ini pembayaran dilakukan langsung di barbershop setelah layanan selesai. Kami menerima cash, transfer bank, e-wallet (GoPay, OVO, Dana, ShopeePay), dan QRIS. Tidak perlu bayar di muka saat booking.</p>
                    <p class="text-sm lg:text-base text-gray-400 leading-relaxed">Dalam waktu dekat, kami akan meluncurkan fitur pembayaran online untuk kemudahan lebih. Customer yang sudah terdaftar akan dapat notifikasi saat fitur ini aktif.</p>
                </div>
                
                <div class="glass-effect border border-gray-700 rounded-2xl p-6 lg:p-8 hover:border-gray-600 transition">
                    <h3 class="text-lg lg:text-xl font-bold text-white mb-3 lg:mb-4">Apakah data saya aman?</h3>
                    <p class="text-sm lg:text-base text-gray-400 leading-relaxed mb-4">Keamanan data adalah prioritas utama kami. Semua data personal Anda dienkripsi menggunakan SSL/TLS 256-bit, standar yang sama dengan bank online. Kami tidak akan pernah membagikan data Anda kepada pihak ketiga tanpa izin eksplisit.</p>
                    <p class="text-sm lg:text-base text-gray-400 leading-relaxed">Platform kami comply dengan standar keamanan data internasional (GDPR & ISO 27001). Anda juga bisa hapus akun dan semua data kapan saja melalui dashboard.</p>
                </div>
                
                <div class="glass-effect border border-gray-700 rounded-2xl p-6 lg:p-8 hover:border-gray-600 transition">
                    <h3 class="text-lg lg:text-xl font-bold text-white mb-3 lg:mb-4">Bagaimana jika saya terlambat datang?</h3>
                    <p class="text-sm lg:text-base text-gray-400 leading-relaxed mb-4">Kami memahami kadang ada situasi tak terduga. Jika Anda terlambat kurang dari 15 menit, booking Anda masih valid. Lebih dari 15 menit, booking mungkin otomatis cancel dan slot diberikan ke customer lain.</p>
                    <p class="text-sm lg:text-base text-gray-400 leading-relaxed">Jika tahu akan terlambat, hubungi barbershop atau customer support kami segera. Kami akan coba reschedule atau koordinasi dengan barber untuk menunggu sedikit lebih lama jika memungkinkan.</p>
                </div>
                
                <div class="glass-effect border border-gray-700 rounded-2xl p-6 lg:p-8 hover:border-gray-600 transition">
                    <h3 class="text-lg lg:text-xl font-bold text-white mb-3 lg:mb-4">Apakah ada program referral atau diskon?</h3>
                    <p class="text-sm lg:text-base text-gray-400 leading-relaxed mb-4">Ya! Ajak teman Anda dan dapatkan diskon 20% untuk booking berikutnya setiap teman yang mendaftar dan melakukan booking pertama mereka. Tidak ada batas berapa banyak teman yang bisa Anda referral.</p>
                    <p class="text-sm lg:text-base text-gray-400 leading-relaxed">Kami juga punya loyalty program di mana Anda kumpulkan poin setiap booking. 10 booking = 1 potong rambut gratis. Plus promo bulanan eksklusif untuk member setia kami.</p>
                </div>
                
                <div class="glass-effect border border-gray-700 rounded-2xl p-6 lg:p-8 hover:border-gray-600 transition">
                    <h3 class="text-lg lg:text-xl font-bold text-white mb-3 lg:mb-4">Bagaimana jika saya tidak puas dengan hasilnya?</h3>
                    <p class="text-sm lg:text-base text-gray-400 leading-relaxed mb-4">Jaminan kepuasan 100%! Jika Anda tidak puas dengan hasil potongan, hubungi kami dalam 24 jam. Kami akan arrange re-cut gratis dengan barber lain atau refund penuh jika memang ada kesalahan dari pihak kami.</p>
                    <p class="text-sm lg:text-base text-gray-400 leading-relaxed">Kepuasan customer adalah yang terpenting. Feedback Anda juga membantu kami meningkatkan kualitas layanan dan melatih barber untuk hasil yang lebih baik.</p>
                </div>
                
                <div class="glass-effect border border-gray-700 rounded-2xl p-6 lg:p-8 hover:border-gray-600 transition">
                    <h3 class="text-lg lg:text-xl font-bold text-white mb-3 lg:mb-4">Apakah tersedia untuk semua kota?</h3>
                    <p class="text-sm lg:text-base text-gray-400 leading-relaxed mb-4">Saat ini kami melayani Jakarta, Bandung, Surabaya, Yogyakarta, dan Bali. Kami terus ekspansi ke kota-kota besar lainnya di Indonesia. Check website atau app kami untuk update lokasi terbaru.</p>
                    <p class="text-sm lg:text-base text-gray-400 leading-relaxed">Jika kota Anda belum tersedia, daftar di waiting list kami. Ketika kami launch di kota Anda, Anda akan dapat early access dan promo spesial sebagai customer pertama.</p>
                </div>
            </div>
            
            <div class="mt-12 lg:mt-16 text-center">
                <p class="text-sm lg:text-base text-gray-400 mb-6">Masih ada pertanyaan?</p>
                <a href="#" class="inline-flex items-center justify-center px-6 lg:px-8 py-3 lg:py-4 glass-effect border-2 border-white/20 text-white text-sm lg:text-base font-semibold rounded-xl hover:bg-white/10 transition">
                    Hubungi Customer Support
                    <svg class="ml-2 w-4 h-4 lg:w-5 lg:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="py-16 lg:py-32 bg-black">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative glass-effect border border-gray-700 rounded-3xl p-8 lg:p-16 text-center overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-600/20 via-purple-600/20 to-pink-600/20"></div>
                <div class="absolute top-0 left-1/4 w-64 lg:w-96 h-64 lg:h-96 bg-blue-600/30 rounded-full blur-3xl"></div>
                <div class="absolute
