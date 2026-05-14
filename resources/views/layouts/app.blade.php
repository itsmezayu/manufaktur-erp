<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Manufaktur ERP') — Modul Akuntansi</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { DEFAULT: '#2563EB', hover: '#1D4ED8', light: '#EFF6FF' },
                        danger:  { DEFAULT: '#B91C1C', hover: '#991B1B', light: '#FEF2F2' },
                    },
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F3F4F6; }

        /* Nav link desktop */
        .nav-link { color: #6B7280; font-weight: 500; font-size: 0.875rem; padding: 6px 14px; border-radius: 999px; transition: all 0.15s; }
        .nav-link:hover { color: #111827; background-color: #F3F4F6; }
        .nav-link.active { color: #fff; font-weight: 600; background-color: #2563EB; }

        /* Nav link mobile (sidebar) */
        .nav-link-mobile { display: flex; align-items: center; gap: 12px; padding: 12px 16px; border-radius: 12px; font-size: 0.9rem; font-weight: 500; color: #6B7280; transition: all 0.15s; }
        .nav-link-mobile:hover { background-color: #F3F4F6; color: #111827; }
        .nav-link-mobile.active { background-color: #EFF6FF; color: #2563EB; font-weight: 600; }
        .nav-link-mobile.active svg { color: #2563EB; }

        /* Sidebar slide */
        .sidebar { transform: translateX(-100%); transition: transform 0.3s cubic-bezier(0.4,0,0.2,1); }
        .sidebar.open { transform: translateX(0); }

        /* Overlay */
        .overlay { opacity: 0; pointer-events: none; transition: opacity 0.3s; }
        .overlay.open { opacity: 1; pointer-events: all; }

        .badge-aktif  { display: inline-flex; align-items: center; padding: 2px 12px; border-radius: 999px; font-size: 0.75rem; font-weight: 500; border: 1px solid #D1D5DB; color: #6B7280; }
        .badge-posted { display: inline-flex; align-items: center; padding: 2px 12px; border-radius: 999px; font-size: 0.75rem; font-weight: 500; border: 1px solid #BBF7D0; color: #15803D; background: #F0FDF4; }
        .badge-draft  { display: inline-flex; align-items: center; padding: 2px 12px; border-radius: 999px; font-size: 0.75rem; font-weight: 500; border: 1px solid #D1D5DB; color: #9CA3AF; background: #F9FAFB; }
        .card { background: #fff; border-radius: 1rem; box-shadow: 0 1px 3px rgba(0,0,0,0.06); border: 1px solid #F3F4F6; padding: 1.5rem; }
        .input-field { width: 100%; border: 1px solid #E5E7EB; border-radius: 999px; padding: 10px 16px; font-size: 0.875rem; color: #374151; outline: none; transition: all 0.15s; }
        .input-field:focus { ring: 2px solid #2563EB; border-color: transparent; }
        [x-cloak] { display: none !important; }
    </style>
    @stack('styles')
</head>

<body class="min-h-screen" x-data="{ sidebarOpen: false }">

    {{-- ===== OVERLAY (mobile) ===== --}}
    <div class="fixed inset-0 bg-black/40 z-40 md:hidden overlay"
         :class="sidebarOpen ? 'open' : ''"
         @click="sidebarOpen = false">
    </div>

    {{-- ===== SIDEBAR MOBILE ===== --}}
    <aside class="fixed top-0 left-0 h-full w-72 bg-white z-50 md:hidden shadow-2xl sidebar"
           :class="sidebarOpen ? 'open' : ''">

        {{-- Sidebar Header --}}
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div class="leading-tight">
                    <div class="font-bold text-gray-900 text-sm">Manufaktur ERP</div>
                    <div class="text-xs text-gray-400">Modul Akuntansi</div>
                </div>
            </div>
            {{-- Close button --}}
            <button @click="sidebarOpen = false"
                    class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 transition-colors">
                <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- User info --}}
        <div class="px-5 py-4 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-gray-800 truncate">{{ auth()->user()->name ?? 'User' }}</p>
                    <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email ?? '' }}</p>
                </div>
            </div>
        </div>

        {{-- Nav Links --}}
        <div class="px-4 py-4 space-y-1 flex-1">
            @php
                $navItems = [
                    ['route' => 'accounting.dashboard',       'label' => 'Beranda',           'match' => 'accounting.dashboard', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>'],
                    ['route' => 'accounting.jurnal.index',    'label' => 'Jurnal Transaksi',  'match' => 'accounting.jurnal.*',  'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>'],
                    ['route' => 'accounting.buku-besar.index','label' => 'Buku Besar',        'match' => 'accounting.buku-besar.*', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>'],
                    ['route' => 'accounting.laba-rugi.index', 'label' => 'Laporan Laba Rugi', 'match' => 'accounting.laba-rugi.*', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>'],
                    ['route' => 'accounting.neraca.index',    'label' => 'Neraca',            'match' => 'accounting.neraca.*',  'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>'],
                ];
            @endphp

            @foreach($navItems as $item)
            @php $isActive = request()->routeIs($item['match']); @endphp
            <a href="{{ route($item['route']) }}"
               @click="sidebarOpen = false"
               class="nav-link-mobile {{ $isActive ? 'active' : '' }}">
                <svg class="w-5 h-5 shrink-0 {{ $isActive ? 'text-blue-600' : 'text-gray-400' }}"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    {!! $item['icon'] !!}
                </svg>
                {{ $item['label'] }}
            </a>
            @endforeach
        </div>

        {{-- Logout --}}
        <div class="px-4 pb-6 border-t border-gray-100 pt-4">
            <form method="POST" action="{{ route('accounting.logout') }}">
                @csrf
                <button type="submit"
                        class="nav-link-mobile w-full text-red-500 hover:bg-red-50">
                    <svg class="w-5 h-5 text-red-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- ===== NAVBAR ===== --}}
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-30">
        <div class="max-w-screen-xl mx-auto px-4 md:px-6 h-16 flex items-center justify-between gap-4">

            {{-- Hamburger (mobile only) --}}
            <button @click="sidebarOpen = true"
                    class="md:hidden w-9 h-9 flex items-center justify-center rounded-lg hover:bg-gray-100 transition-colors shrink-0">
                <svg class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            {{-- Brand --}}
            <a href="{{ route('accounting.dashboard') }}" class="flex items-center gap-2.5 shrink-0">
                <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div class="leading-tight">
                    <div class="font-bold text-gray-900 text-sm">Manufaktur ERP</div>
                    <div class="text-xs text-gray-400 hidden sm:block">Modul Akuntansi</div>
                </div>
            </a>

            {{-- Desktop Nav Links --}}
            <div class="hidden md:flex items-center gap-1 flex-1 justify-center">
                @php
                    $navItems = [
                        ['route' => 'accounting.dashboard',        'label' => 'Beranda',           'match' => 'accounting.dashboard'],
                        ['route' => 'accounting.jurnal.index',     'label' => 'Jurnal Transaksi',  'match' => 'accounting.jurnal.*'],
                        ['route' => 'accounting.buku-besar.index', 'label' => 'Buku Besar',        'match' => 'accounting.buku-besar.*'],
                        ['route' => 'accounting.laba-rugi.index',  'label' => 'Laba Rugi',         'match' => 'accounting.laba-rugi.*'],
                        ['route' => 'accounting.neraca.index',     'label' => 'Neraca',            'match' => 'accounting.neraca.*'],
                    ];
                @endphp
                @foreach($navItems as $item)
                @php $isActive = request()->routeIs($item['match']); @endphp
                <a href="{{ route($item['route']) }}"
                   class="nav-link {{ $isActive ? 'active' : '' }}">
                    {{ $item['label'] }}
                </a>
                @endforeach
            </div>

            {{-- Right: Search + User --}}
            <div class="flex items-center gap-2 shrink-0">
                {{-- Search (hidden on very small screens) --}}
                <div class="hidden sm:flex items-center gap-2 border border-gray-200 rounded-full px-3 py-2 bg-gray-50 w-36 lg:w-44">
                    <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" placeholder="Search" class="text-sm bg-transparent focus:outline-none w-full text-gray-600 placeholder-gray-400">
                </div>

                {{-- User Dropdown --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                            class="w-9 h-9 bg-blue-100 rounded-full flex items-center justify-center hover:bg-blue-200 transition-colors">
                        <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </button>
                    <div x-show="open" x-cloak @click.away="open = false" x-transition
                         class="absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-50">
                        <div class="px-4 py-2.5 border-b border-gray-100">
                            <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name ?? 'User' }}</p>
                            <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email ?? '' }}</p>
                        </div>
                        <form method="POST" action="{{ route('accounting.logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 transition-colors font-medium">
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </nav>

    {{-- Flash Messages --}}
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition
         class="fixed top-20 right-4 z-50 bg-green-50 border border-green-200 text-green-800 text-sm font-medium px-4 py-3 rounded-xl shadow-lg flex items-center gap-2 max-w-xs">
        <svg class="w-4 h-4 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition
         class="fixed top-20 right-4 z-50 bg-red-50 border border-red-200 text-red-800 text-sm font-medium px-4 py-3 rounded-xl shadow-lg flex items-center gap-2 max-w-xs">
        <svg class="w-4 h-4 text-red-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
        </svg>
        {{ session('error') }}
    </div>
    @endif

    {{-- Main Content --}}
    <main class="max-w-screen-xl mx-auto px-4 md:px-6 py-6 md:py-8">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>