@extends('layouts.app')
@section('title', 'Daftar Akun Transaksi')

@section('content')

{{-- ===== HEADER ===== --}}
<div class="flex items-start justify-between mb-6">
    <div>
        <div class="flex items-center gap-1.5 text-xs text-gray-400 mb-1.5">
            <a href="{{ route('accounting.dashboard') }}" class="hover:text-blue-600 transition-colors">Beranda</a>
            <span>›</span>
            <span class="text-gray-600 font-medium">Akun Transaksi</span>
        </div>
        <h1 class="text-xl md:text-2xl font-bold text-gray-900">Daftar Akun Transaksi</h1>
        <p class="text-sm text-gray-400 mt-0.5">Total {{ $totalAkun ?? 16 }} kode akun terdaftar</p>
    </div>
    <a href="{{ route('accounting.coa.create') }}"
       class="flex items-center gap-1.5 px-4 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 transition-colors shrink-0">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        <span class="hidden sm:inline">Tambah Akun</span>
    </a>
</div>

{{-- ===== MAIN CARD ===== --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm">

    {{-- Toolbar --}}
    <div class="flex flex-wrap items-center justify-between gap-3 px-4 md:px-6 py-4 border-b border-gray-100">
        <p class="text-sm text-gray-500 hidden sm:block">Menampilkan semua akun transaksi</p>

        <div class="flex items-center gap-2 w-full sm:w-auto">
            {{-- Search --}}
            <div class="flex items-center gap-2 border border-gray-200 rounded-full px-3 py-2 bg-gray-50 flex-1 sm:w-52 sm:flex-none">
                <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" id="searchInput" placeholder="Cari akun..."
                       class="text-sm bg-transparent focus:outline-none w-full text-gray-600 placeholder-gray-400">
            </div>

            {{-- Filter Dropdown --}}
            <div x-data="{ open: false }" class="relative shrink-0">
                <button @click="open = !open"
                        class="flex items-center gap-1.5 px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-full hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                    </svg>
                    <span class="hidden sm:inline">Filter</span>
                </button>
                <div x-show="open" x-cloak @click.away="open = false"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     class="absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-lg border border-gray-100 p-4 z-30">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Status</p>
                    @foreach(['Aktif','Non-Aktif'] as $s)
                    <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer py-1.5 hover:text-gray-900">
                        <input type="checkbox" class="rounded border-gray-300 text-blue-600"> {{ $s }}
                    </label>
                    @endforeach
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mt-3 mb-2">Tipe Akun</p>
                    @foreach(['Aset','Kewajiban','Modal','Pendapatan','Beban'] as $tipe)
                    <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer py-1.5 hover:text-gray-900">
                        <input type="checkbox" class="rounded border-gray-300 text-blue-600"> {{ $tipe }}
                    </label>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- ===== TABLE (Desktop) ===== --}}
    <div class="hidden md:block overflow-x-auto px-6">
        <table class="w-full">
            <thead>
                <tr>
                    <th class="text-left text-xs font-semibold text-gray-400 py-4">Kode Akun</th>
                    <th class="text-left text-xs font-semibold text-gray-400 py-4">Nama Akun</th>
                    <th class="text-left text-xs font-semibold text-gray-400 py-4">Tipe Akun</th>
                    <th class="text-left text-xs font-semibold text-gray-400 py-4">Parent</th>
                    <th class="text-left text-xs font-semibold text-gray-400 py-4">Status</th>
                    <th class="text-center text-xs font-semibold text-gray-400 py-4">Aksi</th>
                </tr>
            </thead>
            <tbody id="akunTableBody">
                @forelse($akunList ?? [] as $akun)
                <tr class="border-t border-gray-50 hover:bg-gray-50 transition-colors">
                    <td class="py-3.5 text-sm font-bold text-gray-800">{{ $akun->kode_akun }}</td>
                    <td class="py-3.5 text-sm text-gray-700">{{ $akun->nama_akun }}</td>
                    <td class="py-3.5 text-sm text-gray-500">{{ $akun->tipe_akun }}</td>
                    <td class="py-3.5 text-sm text-gray-400">{{ $akun->parent ?? '–' }}</td>
                    <td class="py-3.5">
                        <span class="{{ $akun->status === 'Aktif'
                            ? 'bg-green-50 text-green-700 border-green-200'
                            : 'bg-gray-50 text-gray-500 border-gray-200' }}
                            border text-xs font-medium px-2.5 py-1 rounded-full inline-flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full {{ $akun->status === 'Aktif' ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                            {{ $akun->status }}
                        </span>
                    </td>
                    <td class="py-3.5">
                        <div class="flex items-center justify-center gap-1.5">
                            <a href="{{ route('accounting.coa.edit', $akun->id) }}"
                               class="w-8 h-8 border border-gray-200 rounded-lg flex items-center justify-center hover:bg-blue-50 hover:border-blue-300 transition-colors"
                               title="Edit">
                                <svg class="w-3.5 h-3.5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('accounting.coa.destroy', $akun->id) }}"
                                  onsubmit="return confirm('Hapus akun {{ $akun->nama_akun }}?')" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="w-8 h-8 border border-gray-200 rounded-lg flex items-center justify-center hover:bg-red-50 hover:border-red-300 transition-colors"
                                        title="Hapus">
                                    <svg class="w-3.5 h-3.5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                @foreach([['1110','Beban Gaji','Beban'],['1120','Kas','Aset'],['1130','Bank','Aset'],['1140','Piutang Usaha','Aset'],['1150','Hutang Usaha','Kewajiban']] as $row)
                <tr class="border-t border-gray-50 hover:bg-gray-50 transition-colors">
                    <td class="py-3.5 text-sm font-bold text-gray-800">{{ $row[0] }}</td>
                    <td class="py-3.5 text-sm text-gray-700">{{ $row[1] }}</td>
                    <td class="py-3.5 text-sm text-gray-500">{{ $row[2] }}</td>
                    <td class="py-3.5 text-sm text-gray-400">–</td>
                    <td class="py-3.5">
                        <span class="bg-green-50 text-green-700 border border-green-200 text-xs font-medium px-2.5 py-1 rounded-full inline-flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                            Aktif
                        </span>
                    </td>
                    <td class="py-3.5">
                        <div class="flex items-center justify-center gap-1.5">
                            <button class="w-8 h-8 border border-gray-200 rounded-lg flex items-center justify-center hover:bg-blue-50 hover:border-blue-300 transition-colors">
                                <svg class="w-3.5 h-3.5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                            <button class="w-8 h-8 border border-gray-200 rounded-lg flex items-center justify-center hover:bg-red-50 hover:border-red-300 transition-colors">
                                <svg class="w-3.5 h-3.5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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

    {{-- ===== CARD LIST (Mobile) ===== --}}
    <div class="md:hidden px-4 py-3 space-y-3" id="akunMobileList">
        @forelse($akunList ?? [] as $akun)
        <div class="border border-gray-100 rounded-xl p-4">
            <div class="flex items-start justify-between mb-3">
                <div>
                    <div class="flex items-center gap-2 mb-0.5">
                        <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-md">{{ $akun->kode_akun }}</span>
                        <span class="{{ $akun->status === 'Aktif' ? 'bg-green-50 text-green-700 border-green-200' : 'bg-gray-50 text-gray-500 border-gray-200' }} border text-xs font-medium px-2 py-0.5 rounded-full">
                            {{ $akun->status }}
                        </span>
                    </div>
                    <p class="text-sm font-semibold text-gray-800 mt-1">{{ $akun->nama_akun }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $akun->tipe_akun }} {{ $akun->parent ? '• '.$akun->parent : '' }}</p>
                </div>
                <div class="flex items-center gap-1.5 shrink-0">
                    <a href="{{ route('accounting.coa.edit', $akun->id) }}"
                       class="w-8 h-8 border border-gray-200 rounded-lg flex items-center justify-center hover:bg-blue-50 hover:border-blue-300 transition-colors">
                        <svg class="w-3.5 h-3.5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </a>
                    <form method="POST" action="{{ route('accounting.coa.destroy', $akun->id) }}"
                          onsubmit="return confirm('Hapus akun {{ $akun->nama_akun }}?')" class="inline">
                        @csrf @method('DELETE')
                        <button class="w-8 h-8 border border-gray-200 rounded-lg flex items-center justify-center hover:bg-red-50 hover:border-red-300 transition-colors">
                            <svg class="w-3.5 h-3.5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        @foreach([['1110','Beban Gaji','Beban'],['1120','Kas','Aset'],['1130','Bank','Aset'],['1140','Piutang Usaha','Aset'],['1150','Hutang Usaha','Kewajiban']] as $row)
        <div class="border border-gray-100 rounded-xl p-4">
            <div class="flex items-start justify-between">
                <div>
                    <div class="flex items-center gap-2 mb-0.5">
                        <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-md">{{ $row[0] }}</span>
                        <span class="bg-green-50 text-green-700 border border-green-200 text-xs font-medium px-2 py-0.5 rounded-full">Aktif</span>
                    </div>
                    <p class="text-sm font-semibold text-gray-800 mt-1">{{ $row[1] }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $row[2] }}</p>
                </div>
                <div class="flex items-center gap-1.5 shrink-0">
                    <button class="w-8 h-8 border border-gray-200 rounded-lg flex items-center justify-center hover:bg-blue-50 transition-colors">
                        <svg class="w-3.5 h-3.5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </button>
                    <button class="w-8 h-8 border border-gray-200 rounded-lg flex items-center justify-center hover:bg-red-50 transition-colors">
                        <svg class="w-3.5 h-3.5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
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
    document.querySelectorAll('#akunTableBody tr').forEach(r => {
        r.style.display = r.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
    // Mobile
    document.querySelectorAll('#akunMobileList > div').forEach(r => {
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