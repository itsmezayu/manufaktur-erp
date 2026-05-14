@extends('layouts.auth')
@section('title', 'Buat Akun')

@section('form')
<h2 class="text-2xl font-bold text-gray-900 mb-1">Buat Akun</h2>
<p class="text-sm text-gray-500 mb-7">Mulai pengalaman bisnis yang terstruktur untuk membantu anda dalam manajemen transaksi.</p>

@if($errors->any())
<div class="mb-4 bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-xl">
    <ul class="list-disc list-inside space-y-0.5">
        @foreach($errors->all() as $err)
        <li>{{ $err }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('accounting.register.post') }}" class="space-y-4">
    @csrf

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama</label>
        <input type="text" name="name" value="{{ old('name') }}" required
               placeholder="Masukkan Nama Anda"
               class="w-full border border-gray-200 rounded-full px-4 py-3 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('name') border-red-400 @enderror">
    </div>

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
        Sign Up
    </button>
</form>

<p class="text-center text-sm text-gray-500 mt-5">
    Sudah punya akun?
    <a href="{{ route('accounting.login') }}" class="text-blue-600 font-semibold hover:underline">Log In</a>
</p>
@endsection