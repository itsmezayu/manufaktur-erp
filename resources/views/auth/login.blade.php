@extends('layouts.auth')
@section('title', 'Masuk')

@section('form')
<h2 class="text-2xl font-bold text-gray-900 mb-1">Selamat Datang</h2>
<p class="text-sm text-gray-500 mb-7">Mulai pengalaman bisnis yang terstruktur untuk membantu anda dalam manajemen transaksi.</p>

@if($errors->any())
<div class="mb-4 bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-xl">
    {{ $errors->first() }}
</div>
@endif

<form method="POST" action="{{ route('accounting.login.post') }}" class="space-y-4">
    @csrf

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required
               placeholder="Masukkan Email Anda"
               class="w-full border border-gray-200 rounded-full px-4 py-3 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('email') border-red-400 @enderror">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
        <input type="password" name="password" required
               placeholder="Masukkan Password Akun Anda"
               class="w-full border border-gray-200 rounded-full px-4 py-3 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('password') border-red-400 @enderror">
    </div>

    <button type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-full transition-colors text-sm mt-2">
        Log In
    </button>
</form>

<p class="text-center text-sm text-gray-500 mt-5">
    Belum punya akun?
    <a href="{{ route('accounting.register') }}" class="text-blue-600 font-semibold hover:underline">Sign In</a>
</p>
@endsection