<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Masuk') — Manufaktur ERP</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: { primary: { DEFAULT: '#2563EB', hover: '#1D4ED8' } }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .input-field { @apply w-full border border-gray-200 rounded-full px-4 py-3 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition; }
    </style>
</head>
<body class="min-h-screen bg-gray-100 flex items-center justify-center p-4">

    <div class="w-full max-w-3xl bg-white rounded-2xl shadow-xl overflow-hidden flex" style="min-height: 480px;">

        {{-- LEFT PANEL - Blue Branding --}}
        {{-- SESUDAH (fix) --}}
<div class="hidden md:flex w-5/12 flex-col justify-between p-8"
     style="background-color: #1d4ed8;
            background-image: linear-gradient(135deg, #1d4ed8 0%, #2563eb 60%, #3b82f6 100%),
                              radial-gradient(circle at 20% 50%, rgba(255,255,255,0.07) 0%, transparent 50%),
                              radial-gradient(circle at 80% 20%, rgba(255,255,255,0.05) 0%, transparent 40%);
            position: relative; overflow: hidden;">

            {{-- Grid pattern overlay --}}
            <div style="position:absolute;inset:0;
                background-image: linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                                  linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
                background-size: 24px 24px;">
            </div>

            <div class="relative z-10">
                {{-- Logo --}}
                <div class="flex items-center gap-2.5 mb-8">
                    <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div class="leading-tight">
                        <div class="font-bold text-white text-sm">Manufaktur ERP</div>
                        <div class="text-xs text-blue-200">Modul Akuntansi</div>
                    </div>
                </div>

                {{-- Headline --}}
                <h1 class="text-white font-extrabold text-4xl leading-tight" style="font-style: italic; letter-spacing: -1px;">
                    Dapatkan<br>Akses Modul<br>Akuntansi<br>Manufaktur<br>ERP
                </h1>
            </div>

            <div class="relative z-10">
                <p class="text-blue-100 text-xs leading-relaxed">
                    Modul Akuntansi menyediakan solusi bisnis dengan kemudahan pengendalian.
                    Melalui modul ini, pengguna dapat melakukan manajemen transaksi dan laporan dalam satu media digital.
                </p>
            </div>
        </div>

        {{-- RIGHT PANEL - Form --}}
        <div class="flex-1 flex flex-col justify-center px-8 py-10">
            @yield('form')
        </div>
    </div>

</body>
</html>