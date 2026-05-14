@extends('layouts.app')
@section('title', 'Laporan Neraca')

@section('content')

{{-- Header --}}
<div class="flex items-start justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-900">Laporan Neraca</h1>
        <p class="text-sm text-gray-400 mt-0.5">Per Tanggal : {{ $tanggal ?? '31-01-2026' }}</p>
    </div>
     <a href="{{ route('accounting.jurnal.export-pdf', ['filter' => request('filter','7hari')]) }}"
       class="bg-red-500 border border-red-400 font-medium text-sm text-white hover:bg-red-700 hover:text-white py-2.5 px-5 rounded-xl">Export PDF</a>
</div>
{{-- Neraca Grid --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-5">

    {{-- Aset --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
        <div class="px-6 pt-5 pb-4 border-b border-gray-100">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">Aset</p>
        </div>
        <div class="px-6 py-5">
            @foreach($aset ?? [['nama'=>'Kas','jumlah'=>5000000],['nama'=>'Bank','jumlah'=>2000000],['nama'=>'Piutang','jumlah'=>1500000],['nama'=>'Persediaan','jumlah'=>1500000]] as $item)
            <div class="flex justify-between items-center py-2 border-b border-gray-50">
                <span class="text-sm text-gray-500">{{ $item['nama'] }}</span>
                <span class="text-sm font-semibold text-gray-800">Rp {{ number_format($item['jumlah'], 0, ',', '.') }}</span>
            </div>
            @endforeach
            <div class="flex justify-between items-center pt-4 mt-1">
                <span class="text-sm font-bold text-gray-700">Total Aset</span>
                <span class="text-sm font-bold text-gray-900">Rp {{ number_format($totalAset ?? 10000000, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    {{-- Kewajiban & Modal --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
        <div class="px-6 pt-5 pb-4 border-b border-gray-100">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">Kewajiban & Modal</p>
        </div>
        <div class="px-6 py-5">
            <p class="text-xs font-semibold text-gray-400 mb-2">Kewajiban</p>
            @foreach($kewajiban ?? [['nama'=>'Hutang Usaha','jumlah'=>3000000]] as $item)
            <div class="flex justify-between items-center py-2 border-b border-gray-50">
                <span class="text-sm text-gray-500">{{ $item['nama'] }}</span>
                <span class="text-sm font-semibold text-gray-800">Rp {{ number_format($item['jumlah'], 0, ',', '.') }}</span>
            </div>
            @endforeach

            <p class="text-xs font-semibold text-gray-400 mt-4 mb-2">Modal</p>
            @foreach($modal ?? [['nama'=>'Modal','jumlah'=>7000000]] as $item)
            <div class="flex justify-between items-center py-2 border-b border-gray-50">
                <span class="text-sm text-gray-500">{{ $item['nama'] }}</span>
                <span class="text-sm font-semibold text-gray-800">Rp {{ number_format($item['jumlah'], 0, ',', '.') }}</span>
            </div>
            @endforeach

            <div class="flex justify-between items-center pt-4 mt-1">
                <span class="text-sm font-bold text-gray-700">Total K + M</span>
                <span class="text-sm font-bold text-gray-900">Rp {{ number_format($totalKM ?? 10000000, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>
</div>

{{-- Balance Check --}}
@if(isset($totalAset, $totalKM) && $totalAset === $totalKM)
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-6 py-4 flex justify-between items-center">
    <span class="text-sm font-bold text-gray-700">Neraca Seimbang</span>
    <span class="text-base font-bold text-blue-600">Rp {{ number_format($totalAset, 0, ',', '.') }}</span>
</div>
@else
<div class="bg-yellow-50 border border-yellow-200 text-yellow-800 text-sm px-5 py-4 rounded-2xl flex items-center gap-2">
    <svg class="w-4 h-4 text-yellow-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
    </svg>
    Perhatian: Neraca tidak seimbang. Periksa kembali data transaksi.
</div>
@endif

@endsection