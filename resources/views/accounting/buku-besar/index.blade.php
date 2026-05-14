@extends('layouts.app')
@section('title', 'Buku Besar')

@section('content')

{{-- ===== HEADER ===== --}}
<div class="flex items-start justify-between mb-6">
    <div>
        <h1 class="text-xl md:text-2xl font-bold text-gray-900">Buku Besar</h1>
        <p class="text-sm text-gray-400 mt-0.5">Buku besar dari keseluruhan transaksi</p>
    </div>
    <a href="{{ route('accounting.buku-besar.export-pdf', ['filter' => request('filter','7hari')]) }}"
       class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors shrink-0">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        <span class="hidden sm:inline">Export PDF</span>
    </a>
</div>

{{-- ===== SUMMARY CARDS ===== --}}
<div class="grid grid-cols-3 gap-3 md:gap-4 mb-5">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 md:p-5">
        <p class="text-xs text-gray-400 font-medium mb-1">Total Debit</p>
        <p class="text-base md:text-xl font-bold text-gray-900">
            Rp {{ number_format($totalDebit ?? 1000000, 0, ',', '.') }}
        </p>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 md:p-5">
        <p class="text-xs text-gray-400 font-medium mb-1">Total Kredit</p>
        <p class="text-base md:text-xl font-bold text-gray-900">
            Rp {{ number_format($totalKredit ?? 1000000, 0, ',', '.') }}
        </p>
    </div>
    <div class="bg-blue-600 rounded-2xl shadow-sm p-4 md:p-5">
        <p class="text-xs text-blue-200 font-medium mb-1">Saldo Akhir</p>
        <p class="text-base md:text-xl font-bold text-white">
            Rp {{ number_format($saldoAkhir ?? 1000000, 0, ',', '.') }}
        </p>
    </div>
</div>

{{-- ===== MAIN TABLE CARD ===== --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm">

    {{-- Toolbar --}}
    <div class="px-4 md:px-6 py-4 border-b border-gray-100">
        {{-- Filter Tabs --}}
        <div class="flex flex-wrap gap-2 mb-3">
            @foreach([['7hari','7 Hari Terakhir'],['30hari','30 Hari Terakhir'],['bulan','Bulan Lalu']] as [$val,$label])
            <a href="{{ route('accounting.buku-besar.index', ['filter' => $val]) }}"
               class="px-3 md:px-4 py-1.5 md:py-2 text-xs md:text-sm font-semibold rounded-full transition-colors
                      {{ request('filter','7hari') === $val
                         ? 'bg-blue-600 text-white'
                         : 'border border-gray-200 text-gray-500 hover:border-blue-300 hover:text-blue-600' }}">
                {{ $label }}
            </a>
            @endforeach
        </div>

        {{-- Search + Filter --}}
        <div class="flex items-center gap-2">
            <div class="flex items-center gap-2 border border-gray-200 rounded-full px-3 py-2 bg-gray-50 flex-1 max-w-xs">
                <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" id="searchInput" placeholder="Cari transaksi..."
                       class="text-sm bg-transparent focus:outline-none w-full text-gray-600 placeholder-gray-400">
            </div>
            <button class="flex items-center gap-1.5 px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-full hover:bg-blue-700 transition-colors shrink-0">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                </svg>
                <span class="hidden sm:inline">Filter</span>
            </button>
        </div>
    </div>

    {{-- Table (desktop) --}}
    <div class="hidden md:block overflow-x-auto px-6">
        <table class="w-full">
            <thead>
                <tr>
                    <th class="text-left text-xs font-semibold text-gray-400 py-4">Tanggal</th>
                    <th class="text-left text-xs font-semibold text-gray-400 py-4">Ref</th>
                    <th class="text-left text-xs font-semibold text-gray-400 py-4">Keterangan</th>
                    <th class="text-left text-xs font-semibold text-gray-400 py-4">Debit</th>
                    <th class="text-left text-xs font-semibold text-gray-400 py-4">Kredit</th>
                    <th class="text-left text-xs font-semibold text-gray-400 py-4">Saldo</th>
                </tr>
            </thead>
            <tbody id="bukuBesarTableBody">
                @forelse($bukuBesars ?? [] as $entry)
                <tr class="border-t border-gray-50 hover:bg-gray-50 transition-colors">
                    <td class="py-3.5 text-sm text-gray-500">{{ \Carbon\Carbon::parse($entry->tanggal)->format('d/m/y') }}</td>
                    <td class="py-3.5 text-sm font-semibold text-gray-800">{{ $entry->ref }}</td>
                    <td class="py-3.5 text-sm text-gray-500">{{ $entry->keterangan }}</td>
                    <td class="py-3.5 text-sm font-semibold {{ $entry->debit ? 'text-gray-800' : 'text-gray-300' }}">
                        {{ $entry->debit ? 'Rp '.number_format($entry->debit,0,',','.') : '–' }}
                    </td>
                    <td class="py-3.5 text-sm font-semibold {{ $entry->kredit ? 'text-gray-800' : 'text-gray-300' }}">
                        {{ $entry->kredit ? 'Rp '.number_format($entry->kredit,0,',','.') : '–' }}
                    </td>
                    <td class="py-3.5 text-sm font-bold text-blue-600">
                        Rp {{ number_format($entry->saldo,0,',','.') }}
                    </td>
                </tr>
                @empty
                @foreach([
                    ['01/01/26','INV-001','Penjualan','1.000.000',null,'1.000.000'],
                    ['01/01/26','INV-002','Pembayaran',null,'500.000','500.000'],
                ] as $r)
                <tr class="border-t border-gray-50 hover:bg-gray-50 transition-colors">
                    <td class="py-3.5 text-sm text-gray-500">{{ $r[0] }}</td>
                    <td class="py-3.5 text-sm font-semibold text-gray-800">{{ $r[1] }}</td>
                    <td class="py-3.5 text-sm text-gray-500">{{ $r[2] }}</td>
                    <td class="py-3.5 text-sm font-semibold {{ $r[3] ? 'text-gray-800' : 'text-gray-300' }}">
                        {{ $r[3] ? 'Rp '.$r[3] : '–' }}
                    </td>
                    <td class="py-3.5 text-sm font-semibold {{ $r[4] ? 'text-gray-800' : 'text-gray-300' }}">
                        {{ $r[4] ? 'Rp '.$r[4] : '–' }}
                    </td>
                    <td class="py-3.5 text-sm font-bold text-blue-600">Rp {{ $r[5] }}</td>
                </tr>
                @endforeach
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Card list (mobile) --}}
    <div class="md:hidden px-4 py-3 space-y-3" id="bukuBesarMobileList">
        @forelse($bukuBesars ?? [] as $entry)
        <div class="border border-gray-100 rounded-xl p-4">
            <div class="flex items-start justify-between mb-2">
                <div>
                    <p class="text-sm font-bold text-gray-800">{{ $entry->ref }}</p>
                    <p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($entry->tanggal)->format('d/m/y') }} • {{ $entry->keterangan }}</p>
                </div>
                <p class="text-sm font-bold text-blue-600">Rp {{ number_format($entry->saldo,0,',','.') }}</p>
            </div>
            <div class="flex gap-4 pt-2 border-t border-gray-50">
                <div>
                    <p class="text-xs text-gray-400">Debit</p>
                    <p class="text-sm font-semibold text-gray-700">{{ $entry->debit ? 'Rp '.number_format($entry->debit,0,',','.') : '–' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Kredit</p>
                    <p class="text-sm font-semibold text-gray-700">{{ $entry->kredit ? 'Rp '.number_format($entry->kredit,0,',','.') : '–' }}</p>
                </div>
            </div>
        </div>
        @empty
        @foreach([['01/01/26','INV-001','Penjualan','1.000.000',null,'1.000.000'],['01/01/26','INV-002','Pembayaran',null,'500.000','500.000']] as $r)
        <div class="border border-gray-100 rounded-xl p-4">
            <div class="flex items-start justify-between mb-2">
                <div>
                    <p class="text-sm font-bold text-gray-800">{{ $r[1] }}</p>
                    <p class="text-xs text-gray-400">{{ $r[0] }} • {{ $r[2] }}</p>
                </div>
                <p class="text-sm font-bold text-blue-600">Rp {{ $r[5] }}</p>
            </div>
            <div class="flex gap-4 pt-2 border-t border-gray-50">
                <div>
                    <p class="text-xs text-gray-400">Debit</p>
                    <p class="text-sm font-semibold text-gray-700">{{ $r[3] ? 'Rp '.$r[3] : '–' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Kredit</p>
                    <p class="text-sm font-semibold text-gray-700">{{ $r[4] ? 'Rp '.$r[4] : '–' }}</p>
                </div>
            </div>
        </div>
        @endforeach
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="flex items-center justify-between px-4 md:px-6 py-4 border-t border-gray-100">
        <button onclick="changePage('prev')"
                class="flex items-center gap-1.5 px-4 py-2 text-sm font-medium border border-gray-200 rounded-full hover:bg-gray-50 transition-colors text-gray-600">
            ← <span class="hidden sm:inline">Sebelumnya</span>
        </button>
        <div class="flex items-center gap-2 text-sm text-gray-500">
            <span class="hidden sm:inline">Per page</span>
            <select onchange="changePerPage(this.value)"
                    class="border border-gray-200 rounded-full px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="25">25</option>
            </select>
        </div>
        <button onclick="changePage('next')"
                class="flex items-center gap-1.5 px-4 py-2 text-sm font-medium border border-gray-200 rounded-full hover:bg-gray-50 transition-colors text-gray-600">
            <span class="hidden sm:inline">Selanjutnya</span> →
        </button>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.getElementById('searchInput').addEventListener('input', function() {
    const q = this.value.toLowerCase();
    // Desktop
    document.querySelectorAll('#bukuBesarTableBody tr').forEach(r => {
        r.style.display = r.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
    // Mobile
    document.querySelectorAll('#bukuBesarMobileList > div').forEach(r => {
        r.style.display = r.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});
function changePage(dir) {
    const url = new URL(window.location);
    let p = parseInt(url.searchParams.get('page') || 1);
    url.searchParams.set('page', dir === 'next' ? p+1 : Math.max(1, p-1));
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