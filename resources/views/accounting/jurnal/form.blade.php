@extends('layouts.app')
@section('title', isset($jurnal) ? 'Edit Jurnal' : 'Tambah Jurnal')

@section('content')

{{-- Header --}}
<div class="flex items-start justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-900">
            Formulir {{ isset($jurnal) ? 'Mengubah' : 'Menambahkan' }} Jurnal Transaksi
        </h1>
        <p class="text-sm text-gray-400 mt-0.5">Pencatatan riwayat transaksi keuangan</p>
    </div>
    <a href="{{ route('accounting.jurnal.index') }}"
        class="bg-red-500 border border-red-400 font-medium text-sm text-white hover:bg-red-700 hover:text-white py-2.5 px-5 rounded-xl">Kembali</a>
</div>

{{-- Form --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
    <div class="px-6 pt-5 pb-4 border-b border-gray-100">
        <h2 class="text-base font-bold text-gray-900">Detail Informasi Jurnal</h2>
    </div>

    <form method="POST"
          action="{{ isset($jurnal) ? route('accounting.jurnal.update', $jurnal->id) : route('accounting.jurnal.store') }}"
          class="px-6 py-6">
        @csrf
        @if(isset($jurnal)) @method('PUT') @endif

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

            {{-- Tanggal Jurnal --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal</label>
                <input type="date" name="tanggal"
                       value="{{ old('tanggal', isset($jurnal) ? \Carbon\Carbon::parse($jurnal->tanggal)->format('Y-m-d') : '') }}"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition
                              @error('tanggal') border-red-400 @enderror">
                @error('tanggal')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Kode Referensi (Ref) --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Referensi (Ref)</label>
                <input type="text" name="ref"
                       value="{{ old('ref', $jurnal->ref ?? '') }}"
                       placeholder="Contoh: INV-001, PO-002"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition
                              @error('ref') border-red-400 @enderror">
                @error('ref')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Modul Asal --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Modul</label>
                <input type="text" name="modul"
                       value="{{ old('modul', $jurnal->modul ?? '') }}"
                       placeholder="Contoh: Sales, Purchase, General"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition
                              @error('modul') border-red-400 @enderror">
                @error('modul')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Total Nominal --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Total Nominal (Rp)</label>
                <input type="number" name="total"
                       value="{{ old('total', $jurnal->total ?? '') }}"
                       placeholder="Masukkan Total Nominal"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition
                              @error('total') border-red-400 @enderror">
                @error('total')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Keterangan Transaksi --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Keterangan</label>
                <input type="text" name="keterangan"
                       value="{{ old('keterangan', $jurnal->keterangan ?? '') }}"
                       placeholder="Masukkan Keterangan Transaksi Jurnal"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition
                              @error('keterangan') border-red-400 @enderror">
                @error('keterangan')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Status Jurnal (Menggunakan struktur Alpine.js asli) --}}
            <div class="md:col-span-2" x-data="{ open: false, selected: '{{ old('status', $jurnal->status ?? 'draft') }}' }">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Status Jurnal</label>
                <div class="relative">
                    <button type="button" @click="open = !open"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 flex items-center justify-between bg-white transition">
                        <span x-text="selected === 'posted' ? 'Posted' : 'Draft'"></span>
                        <svg class="w-4 h-4 text-gray-400 transition-transform" :class="open ? 'rotate-180' : ''"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <input type="hidden" name="status" :value="selected">
                    <div x-show="open" x-cloak @click.away="open = false"
                         x-transition
                         class="absolute top-full left-0 right-0 mt-1 bg-white border border-gray-200 rounded-xl shadow-lg z-20 overflow-hidden">
                        @foreach(['draft', 'posted'] as $statusOption)
                        <button type="button"
                                @click="selected = '{{ $statusOption }}'; open = false"
                                class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 transition-colors">
                            {{ ucfirst($statusOption) }}
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
            <a href="{{ route('accounting.jurnal.index') }}"
               class="px-5 py-2.5 text-sm font-medium text-gray-600 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">
                Batal
            </a>
            <button type="submit"
                    class="px-6 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition-colors">
                {{ isset($jurnal) ? 'Simpan Perubahan' : 'Tambah Jurnal' }}
            </button>
        </div>

    </form>
</div>

@endsection