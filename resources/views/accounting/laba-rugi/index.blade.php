@extends('layouts.app')
@section('title', 'Laporan Laba Rugi')

@section('content')

{{-- Header --}}
<div class="flex items-start justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-900">Laporan Laba Rugi</h1>
        <p class="text-sm text-gray-400 mt-0.5">Periode : {{ $periodeAwal ?? '01-01-2026' }} s/d {{ $periodeAkhir ?? '31-01-2026' }}</p>
    </div>
    <a href="{{ route('accounting.laba-rugi.export-pdf') }}"
   class="bg-red-500 border border-red-400 font-medium text-sm text-white hover:bg-red-700 hover:text-white py-2.5 px-5 rounded-xl">Export PDF</a>
</div>

{{-- Pendapatan --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm mb-5">
    <div class="px-6 pt-5 pb-4 border-b border-gray-100">
        <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">Pendapatan</p>
    </div>
    <div class="px-6 py-5">
        @foreach($pendapatan ?? [['nama'=>'Penjualan','jumlah'=>50000]] as $item)
        <div class="flex justify-between items-center py-2 border-b border-gray-50">
            <span class="text-sm text-gray-500">{{ $item['nama'] }}</span>
            <span class="text-sm font-semibold text-gray-800">Rp {{ number_format($item['jumlah'], 0, ',', '.') }}</span>
        </div>
        @endforeach
        <div class="flex justify-between items-center pt-4 mt-1">
            <span class="text-sm font-bold text-gray-700">Total Pendapatan</span>
            <span class="text-sm font-bold text-gray-900">Rp {{ number_format($totalPendapatan ?? 50000, 0, ',', '.') }}</span>
        </div>
    </div>
</div>

{{-- Beban --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm mb-5">
    <div class="px-6 pt-5 pb-4 border-b border-gray-100">
        <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">Beban</p>
    </div>
    <div class="px-6 py-5">
        @foreach($beban ?? [['nama'=>'Beban Gaji','jumlah'=>10000000],['nama'=>'Beban Listrik','jumlah'=>2000000],['nama'=>'Beban Bahan Baku','jumlah'=>20000000]] as $item)
        <div class="flex justify-between items-center py-2 border-b border-gray-50">
            <span class="text-sm text-gray-500">{{ $item['nama'] }}</span>
            <span class="text-sm font-semibold text-gray-800">Rp {{ number_format($item['jumlah'], 0, ',', '.') }}</span>
        </div>
        @endforeach
        <div class="flex justify-between items-center pt-4 mt-1">
            <span class="text-sm font-bold text-gray-700">Total Beban</span>
            <span class="text-sm font-bold text-gray-900">Rp {{ number_format($totalBeban ?? 32000000, 0, ',', '.') }}</span>
        </div>
    </div>
</div>

{{-- Laba Bersih --}}
@php $laba = $labaBersih ?? 18000000; @endphp
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
    <div class="px-6 py-5 flex justify-between items-center">
        <span class="text-base font-bold text-gray-900">Laba Bersih</span>
        <span class="text-xl font-bold {{ $laba >= 0 ? 'text-blue-600' : 'text-red-600' }}">
            Rp {{ number_format($laba, 0, ',', '.') }}
        </span>
    </div>
</div>

@endsection