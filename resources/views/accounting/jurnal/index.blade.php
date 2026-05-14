@extends('layouts.app')
@section('title', 'Jurnal Transaksi')

@section('content')

{{-- Header --}}
<div class="flex items-start justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-900">Jurnal Transaksi</h1>
        <p class="text-sm text-gray-400 mt-0.5">Riwayat transaksi</p>
    </div>
    <a href="{{ route('accounting.jurnal.export-pdf', ['filter' => request('filter','7hari')]) }}"
       class="bg-red-500 border border-red-400 font-medium text-sm text-white hover:bg-red-700 hover:text-white py-2.5 px-5 rounded-xl">Export PDF</a>
</div>

{{-- Filter + Search --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm mb-5 px-6 py-4">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div class="flex gap-2">
            @foreach([['7hari','7 Hari Terakhir'],['30hari','30 Hari Terakhir'],['bulan','Bulan Lalu']] as [$val, $label])
            <a href="{{ route('accounting.jurnal.index', ['filter' => $val]) }}"
               class="px-4 py-2 text-sm font-semibold rounded-full transition-colors
                      {{ request('filter', '7hari') === $val
                         ? 'bg-blue-600 text-white'
                         : 'border border-gray-200 text-gray-600 hover:border-blue-300 hover:text-blue-600' }}">
                {{ $label }}
            </a>
            @endforeach
        </div>
        <div class="flex items-center gap-2">
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </span>
                <input type="text" id="searchInput" placeholder="Search"
                       class="pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-400 w-52">
            </div>
            <button class="flex items-center gap-1.5 px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-full hover:bg-blue-700 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                </svg>
                Filter
            </button>
        </div>
    </div>
</div>

{{-- Tabel Jurnal --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm mb-5">
    <div class="px-6 pb-5 overflow-x-auto">
        <table class="w-full mt-4">
            <thead>
                <tr>
                    <th class="text-left text-xs font-semibold text-gray-400 pb-3">Tanggal</th>
                    <th class="text-left text-xs font-semibold text-gray-400 pb-3">Ref</th>
                    <th class="text-left text-xs font-semibold text-gray-400 pb-3">Modul</th>
                    <th class="text-left text-xs font-semibold text-gray-400 pb-3">Keterangan</th>
                    <th class="text-left text-xs font-semibold text-gray-400 pb-3">Total</th>
                    <th class="text-left text-xs font-semibold text-gray-400 pb-3">Status</th>
                    <th class="text-center text-xs font-semibold text-gray-400 pb-3">Aksi</th>
                </tr>
            </thead>
            <tbody id="jurnalTableBody">
                @forelse($jurnals ?? [] as $jurnal)
                <tr class="border-t border-gray-50">
                    <td class="py-3 text-sm text-gray-500">{{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d/m/y') }}</td>
                    <td class="py-3 text-sm font-semibold text-gray-800">{{ $jurnal->ref }}</td>
                    <td class="py-3 text-sm text-gray-500">{{ $jurnal->modul }}</td>
                    <td class="py-3 text-sm text-gray-500">{{ $jurnal->keterangan }}</td>
                    <td class="py-3 text-sm font-semibold text-gray-800">Rp {{ number_format($jurnal->total, 0, ',', '.') }}</td>
                    <td class="py-3">
                        <span class="{{ $jurnal->status === 'posted' ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-gray-50 text-gray-500 border border-gray-200' }} text-xs font-medium px-2.5 py-1 rounded-full">
                            {{ ucfirst($jurnal->status) }}
                        </span>
                    </td>
                    <td class="py-3">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('accounting.jurnal.edit', $jurnal->id) }}"
                               class="w-8 h-8 border border-gray-200 rounded-full flex items-center justify-center hover:bg-blue-50 hover:border-blue-300 transition-colors">
                                <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('accounting.jurnal.destroy', $jurnal->id) }}"
                                  onsubmit="return confirm('Hapus jurnal ini?')" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-8 h-8 border border-gray-200 rounded-full flex items-center justify-center hover:bg-red-50 hover:border-red-300 transition-colors">
                                    <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                @foreach([['01/01/26','INV-001','Sales','Penjualan','1.000.000','draft'],['01/01/26','PO-002','Purchase','Pembelian','500.000','posted']] as $r)
                <tr class="border-t border-gray-50">
                    <td class="py-3 text-sm text-gray-500">{{ $r[0] }}</td>
                    <td class="py-3 text-sm font-semibold text-gray-800">{{ $r[1] }}</td>
                    <td class="py-3 text-sm text-gray-500">{{ $r[2] }}</td>
                    <td class="py-3 text-sm text-gray-500">{{ $r[3] }}</td>
                    <td class="py-3 text-sm font-semibold text-gray-800">Rp {{ $r[4] }}</td>
                    <td class="py-3">
                        <span class="{{ $r[5]==='posted' ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-gray-50 text-gray-500 border border-gray-200' }} text-xs font-medium px-2.5 py-1 rounded-full">
                            {{ ucfirst($r[5]) }}
                        </span>
                    </td>
                    <td class="py-3">
                        <div class="flex items-center justify-center gap-2">
                            <button class="w-8 h-8 border border-gray-200 rounded-full flex items-center justify-center hover:bg-blue-50 hover:border-blue-300 transition-colors">
                                <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                            <button class="w-8 h-8 border border-gray-200 rounded-full flex items-center justify-center hover:bg-red-50 hover:border-red-300 transition-colors">
                                <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="flex items-center justify-between px-6 py-4 border-t border-gray-100">
        <button onclick="changePage('prev')" class="text-sm font-medium text-gray-500 hover:text-gray-700">Sebelumnya</button>
        <div class="flex items-center gap-2">
            <span class="text-sm text-gray-400">Per page</span>
            <select onchange="changePerPage(this.value)"
                    class="border border-gray-200 rounded-full px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="25">25</option>
            </select>
        </div>
        <button onclick="changePage('next')" class="text-sm font-medium text-gray-500 hover:text-gray-700">Selanjutnya</button>
    </div>
</div>

{{-- Detail Debit & Kredit --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
    <div class="flex items-center justify-between px-6 pt-5 pb-4 border-b border-gray-100">
        <h2 class="text-base font-bold text-gray-900">Detail Debit & Kredit</h2>
        <div class="flex gap-6">
            <div class="text-right">
                <p class="text-xs text-gray-400 font-medium">Total Debit</p>
                <p class="text-base font-bold text-gray-900">Rp {{ number_format($totalDebit ?? 1000000, 0, ',', '.') }}</p>
            </div>
            <div class="text-right">
                <p class="text-xs text-gray-400 font-medium">Total Kredit</p>
                <p class="text-base font-bold text-gray-900">Rp {{ number_format($totalKredit ?? 1000000, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
    <div class="px-6 pb-5 overflow-x-auto">
        <table class="w-full mt-4">
            <thead>
                <tr>
                    <th class="text-left text-xs font-semibold text-gray-400 pb-3">Akun</th>
                    <th class="text-left text-xs font-semibold text-gray-400 pb-3">Debit</th>
                    <th class="text-left text-xs font-semibold text-gray-400 pb-3">Kredit</th>
                </tr>
            </thead>
            <tbody>
                @forelse($detailDebitKredit ?? [] as $detail)
                <tr class="border-t border-gray-50">
                    <td class="py-3 text-sm text-gray-500">{{ $detail->tanggal }}</td>
                    <td class="py-3 text-sm font-semibold text-gray-800">{{ $detail->debit ? 'Rp '.number_format($detail->debit,0,',','.') : '-' }}</td>
                    <td class="py-3 text-sm font-semibold text-gray-800">{{ $detail->kredit ? 'Rp '.number_format($detail->kredit,0,',','.') : '-' }}</td>
                </tr>
                @empty
                <tr class="border-t border-gray-50">
                    <td class="py-3 text-sm text-gray-500">01/01/26</td>
                    <td class="py-3 text-sm font-semibold text-gray-800">Rp 1.000.000</td>
                    <td class="py-3 text-sm text-gray-400">-</td>
                </tr>
                <tr class="border-t border-gray-50">
                    <td class="py-3 text-sm text-gray-500">01/01/26</td>
                    <td class="py-3 text-sm text-gray-400">-</td>
                    <td class="py-3 text-sm font-semibold text-gray-800">Rp 1.000.000</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.getElementById('searchInput').addEventListener('input', function () {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#jurnalTableBody tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});
function changePage(dir) {
    const url = new URL(window.location);
    let page = parseInt(url.searchParams.get('page') || 1);
    url.searchParams.set('page', dir === 'next' ? page + 1 : Math.max(1, page - 1));
    window.location = url;
}
function changePerPage(val) {
    const url = new URL(window.location);
    url.searchParams.set('per_page', val);
    url.searchParams.set('page', 1);
    window.location = url;
}
</script>
@endpush