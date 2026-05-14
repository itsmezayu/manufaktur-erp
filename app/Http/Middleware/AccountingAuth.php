<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * AccountingAuth Middleware
 *
 * Memastikan user sudah login sebelum mengakses halaman modul akuntansi.
 * Jika belum login, redirect ke halaman login accounting.
 *
 * Cara daftarkan middleware ini ada di bagian bawah file (lihat komentar).
 */
class AccountingAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            // Simpan URL tujuan supaya setelah login bisa redirect ke sana
            return redirect()->route('accounting.login')
                             ->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}

/*
|--------------------------------------------------------------------------
| CARA MENDAFTARKAN MIDDLEWARE INI
|--------------------------------------------------------------------------
|
| Laravel 11 — edit file: bootstrap/app.php
|
|   ->withMiddleware(function (Middleware $middleware) {
|       $middleware->alias([
|           'accounting.auth' => \App\Http\Middleware\AccountingAuth::class,
|       ]);
|   })
|
| Laravel 10 ke bawah — edit file: app/Http/Kernel.php
|
|   protected $routeMiddleware = [
|       ...
|       'accounting.auth' => \App\Http\Middleware\AccountingAuth::class,
|   ];
|
|--------------------------------------------------------------------------
| CATATAN:
|--------------------------------------------------------------------------
| Middleware ini sebenarnya OPSIONAL karena kita sudah pakai middleware
| bawaan Laravel 'auth' di routes/web.php.
|
| Gunakan 'accounting.auth' ini hanya jika nanti perlu tambah logika khusus,
| misalnya: cek role user, cek akses per departemen, dll.
|
| Untuk sekarang, middleware 'auth' bawaan Laravel sudah cukup.
*/