@extends('layouts.app')
@section('title', isset($akun) ? 'Edit Akun' : 'Tambah Akun')

@section('content')

{{-- Header --}}
<div class="flex items-start justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-900">
            Formulir {{ isset($akun) ? 'Mengubah' : 'Menambahkan' }} Akun Transaksi
        </h1>
        <p class="text-sm text-gray-400 mt-0.5">Akun transaksi yang terdiri dari 16 kode akun</p>
    </div>
    <a href="{{ route('accounting.coa.index') }}"
        class="bg-red-500 border border-red-400 font-medium text-sm text-white hover:bg-red-700 hover:text-white py-2.5 px-5 rounded-xl">Kembali</a>
</div>

{{-- Form --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
    <div class="px-6 pt-5 pb-4 border-b border-gray-100">
        <h2 class="text-base font-bold text-gray-900">Detail Informasi Akun</h2>
    </div>

    <form method="POST"
          action="{{ isset($akun) ? route('accounting.coa.update', $akun->id) : route('accounting.coa.store') }}"
          class="px-6 py-6">
        @csrf
        @if(isset($akun)) @method('PUT') @endif

        @if($errors->any())
        <div class="mb-5 bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-xl">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Kode Akun --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Kode Akun</label>
                <input type="text" name="kode_akun"
                       value="{{ old('kode_akun', $akun->kode_akun ?? '') }}"
                       placeholder="Masukkan Kode Akun"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition
                              @error('kode_akun') border-red-400 @enderror">
                @error('kode_akun')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nama Akun --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Akun</label>
                <input type="text" name="nama_akun"
                       value="{{ old('nama_akun', $akun->nama_akun ?? '') }}"
                       placeholder="Masukkan Nama Akun"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition
                              @error('nama_akun') border-red-400 @enderror">
                @error('nama_akun')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tipe Parent --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Tipe Parent</label>
                <input type="text" name="tipe_parent"
                       value="{{ old('tipe_parent', $akun->tipe_parent ?? '') }}"
                       placeholder="Masukkan Tipe Parent Akun"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition
                              @error('tipe_parent') border-red-400 @enderror">
                @error('tipe_parent')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tipe Akun --}}
<div>
    <label class="block text-sm font-medium text-gray-700 mb-1.5">Tipe Akun</label>
    <select name="tipe_akun"
            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition
                   @error('tipe_akun') border-red-400 @enderror">
        @foreach(['aset','kewajiban','modal','pendapatan','beban'] as $tipe)
        <option value="{{ $tipe }}" {{ old('tipe_akun', $akun->tipe_akun ?? '') === $tipe ? 'selected' : '' }}>
            {{ ucfirst($tipe) }}
        </option>
        @endforeach
    </select>
    @error('tipe_akun')
    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
    @enderror
</div>

            {{-- Status Akun --}}
            <div x-data="{ open: false, selected: '{{ old('status', $akun->status ?? 'Aktif') }}' }">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Status Akun</label>
                <div class="relative">
                    <button type="button" @click="open = !open"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 flex items-center justify-between bg-white transition">
                        <span x-text="selected"></span>
                        <svg class="w-4 h-4 text-gray-400 transition-transform" :class="open ? 'rotate-180' : ''"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <input type="hidden" name="status" :value="selected">
                    <div x-show="open" x-cloak @click.away="open = false"
                         x-transition
                         class="absolute top-full left-0 right-0 mt-1 bg-white border border-gray-200 rounded-xl shadow-lg z-20 overflow-hidden">
                        @foreach(['Aktif', 'Non-Aktif'] as $s)
                        <button type="button"
                                @click="selected = '{{ $s }}'; open = false"
                                class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 transition-colors">
                            {{ $s }}
                        </button>
                        @endforeach
                    </div>
                </div>
                @error('status')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

        </div>

        {{-- Action Buttons --}}
        <div class="flex justify-end gap-3 mt-8 pt-5 border-t border-gray-100">
            <a href="{{ route('accounting.coa.index') }}"
               class="px-5 py-2.5 text-sm font-medium text-gray-600 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">
                Batal
            </a>
            <button type="submit"
                    class="px-6 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition-colors">
                Simpan Perubahan
            </button>
        </div>

    </form>
</div>

@endsection