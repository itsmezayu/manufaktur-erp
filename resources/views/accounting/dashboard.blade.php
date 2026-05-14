@extends('layouts.app')
@section('title', 'Beranda')

@section('content')

{{-- STAT CARDS --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-5">
    <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
        <p class="text-xs text-gray-400 font-medium mb-1">Total Debit</p>
        <p class="text-base lg:text-xl font-bold text-gray-900">Rp {{ number_format($totalDebit ?? 1000000, 0, ',', '.') }}</p>
        <p class="text-xs text-green-500 mt-1 font-medium">↑ 25% dari bulan lalu</p>
    </div>
    <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
        <p class="text-xs text-gray-400 font-medium mb-1">Total Kredit</p>
        <p class="text-base lg:text-xl font-bold text-gray-900">Rp {{ number_format($totalKredit ?? 1000000, 0, ',', '.') }}</p>
        <p class="text-xs text-green-500 mt-1 font-medium">↑ 25% dari bulan lalu</p>
    </div>
    <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
        <p class="text-xs text-gray-400 font-medium mb-1">Laba Bersih</p>
        <p class="text-base lg:text-xl font-bold text-blue-600">Rp {{ number_format($labaBersih ?? 18000000, 0, ',', '.') }}</p>
        <p class="text-xs text-gray-400 mt-1">Periode {{ now()->format('M Y') }}</p>
    </div>
    <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
        <p class="text-xs text-gray-400 font-medium mb-1">Total Aset</p>
        <p class="text-base lg:text-xl font-bold text-gray-900">Rp {{ number_format($totalAset ?? 10000000, 0, ',', '.') }}</p>
        <p class="text-xs text-gray-400 mt-1">Per {{ now()->format('d M Y') }}</p>
    </div>
</div>

{{-- Jurnal Transaksi --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm mb-5">
    <div class="flex items-center justify-between px-5 pt-5 pb-4 border-b border-gray-100">
        <div>
            <h2 class="text-sm font-bold text-gray-900">Jurnal Transaksi</h2>
            <p class="text-xs text-gray-400 mt-0.5">Riwayat transaksi terbaru</p>
        </div>
        <a href="{{ route('accounting.jurnal.index') }}"
           class="text-xs font-semibold text-blue-600 border border-blue-200 px-3 py-1.5 rounded-full hover:bg-blue-50 transition-colors">
            Lihat Semua
        </a>
    </div>
    <div class="px-5 pb-5 overflow-x-auto">
        <table class="w-full mt-4 min-w-[500px]">
            <thead>
                <tr>
                    <th class="text-left text-xs font-semibold text-gray-400 pb-3">Tanggal</th>
                    <th class="text-left text-xs font-semibold text-gray-400 pb-3">Ref</th>
                    <th class="text-left text-xs font-semibold text-gray-400 pb-3">Modul</th>
                    <th class="text-left text-xs font-semibold text-gray-400 pb-3">Keterangan</th>
                    <th class="text-left text-xs font-semibold text-gray-400 pb-3">Total</th>
                    <th class="text-left text-xs font-semibold text-gray-400 pb-3">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentJurnals ?? [] as $jurnal)
                <tr class="border-t border-gray-50">
                    <td class="py-3 text-xs text-gray-500">{{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d/m/y') }}</td>
                    <td class="py-3 text-xs font-semibold text-gray-800">{{ $jurnal->ref }}</td>
                    <td class="py-3 text-xs text-gray-500">{{ $jurnal->modul }}</td>
                    <td class="py-3 text-xs text-gray-500">{{ $jurnal->keterangan }}</td>
                    <td class="py-3 text-xs font-semibold text-gray-800">Rp {{ number_format($jurnal->total, 0, ',', '.') }}</td>
                    <td class="py-3">
                        <span class="{{ $jurnal->status === 'posted' ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-gray-50 text-gray-500 border border-gray-200' }} text-xs font-medium px-2 py-0.5 rounded-full">
                            {{ ucfirst($jurnal->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                @foreach([['01/01/26','INV-001','Sales','Penjualan','1.000.000','draft'],['01/01/26','INV-002','Purchase','Pembelian','500.000','posted']] as $r)
                <tr class="border-t border-gray-50">
                    <td class="py-3 text-xs text-gray-500">{{ $r[0] }}</td>
                    <td class="py-3 text-xs font-semibold text-gray-800">{{ $r[1] }}</td>
                    <td class="py-3 text-xs text-gray-500">{{ $r[2] }}</td>
                    <td class="py-3 text-xs text-gray-500">{{ $r[3] }}</td>
                    <td class="py-3 text-xs font-semibold text-gray-800">Rp {{ $r[4] }}</td>
                    <td class="py-3">
                        <span class="{{ $r[5]==='posted' ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-gray-50 text-gray-500 border border-gray-200' }} text-xs font-medium px-2 py-0.5 rounded-full">
                            {{ ucfirst($r[5]) }}
                        </span>
                    </td>
                </tr>
                @endforeach
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Laba Rugi + Neraca --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-5">

    {{-- Laba Rugi --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between px-5 pt-5 pb-4 border-b border-gray-100">
            <div>
                <h2 class="text-sm font-bold text-gray-900">Laporan Laba Rugi</h2>
                <p class="text-xs text-gray-400 mt-0.5">{{ $periodeLabaRugi ?? '01-01-2026 s/d 31-01-2026' }}</p>
            </div>
            <a href="{{ route('accounting.laba-rugi.index') }}"
               class="text-xs font-semibold text-blue-600 border border-blue-200 px-3 py-1.5 rounded-full hover:bg-blue-50 transition-colors">
                Detail
            </a>
        </div>
        <div class="px-5 py-4 space-y-4">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Pendapatan</p>
                @foreach($pendapatan ?? [['nama'=>'Penjualan','jumlah'=>50000]] as $item)
                <div class="flex justify-between items-center py-1.5">
                    <span class="text-xs text-gray-600">{{ $item['nama'] }}</span>
                    <span class="text-xs font-semibold text-gray-800">Rp {{ number_format($item['jumlah'], 0, ',', '.') }}</span>
                </div>
                @endforeach
                <div class="flex justify-between pt-2 mt-1 border-t border-gray-100">
                    <span class="text-xs font-semibold text-gray-700">Total</span>
                    <span class="text-xs font-bold text-gray-900">Rp {{ number_format($totalPendapatan ?? 50000, 0, ',', '.') }}</span>
                </div>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Beban</p>
                @foreach($beban ?? [['nama'=>'Beban Gaji','jumlah'=>10000000],['nama'=>'Beban Listrik','jumlah'=>2000000],['nama'=>'Beban Bahan Baku','jumlah'=>20000000]] as $item)
                <div class="flex justify-between items-center py-1.5">
                    <span class="text-xs text-gray-600">{{ $item['nama'] }}</span>
                    <span class="text-xs font-semibold text-gray-800">Rp {{ number_format($item['jumlah'], 0, ',', '.') }}</span>
                </div>
                @endforeach
                <div class="flex justify-between pt-2 mt-1 border-t border-gray-100">
                    <span class="text-xs font-semibold text-gray-700">Total</span>
                    <span class="text-xs font-bold text-gray-900">Rp {{ number_format($totalBeban ?? 32000000, 0, ',', '.') }}</span>
                </div>
            </div>
            <div class="flex justify-between items-center bg-blue-50 rounded-xl px-4 py-3">
                <span class="text-xs font-bold text-gray-900">Laba Bersih</span>
                <span class="text-sm font-bold text-blue-600">Rp {{ number_format($labaBersih ?? 18000000, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    {{-- Neraca --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between px-5 pt-5 pb-4 border-b border-gray-100">
            <div>
                <h2 class="text-sm font-bold text-gray-900">Laporan Neraca</h2>
                <p class="text-xs text-gray-400 mt-0.5">Per {{ $tanggalNeraca ?? now()->format('d-m-Y') }}</p>
            </div>
            <a href="{{ route('accounting.neraca.index') }}"
               class="text-xs font-semibold text-blue-600 border border-blue-200 px-3 py-1.5 rounded-full hover:bg-blue-50 transition-colors">
                Detail
            </a>
        </div>
        <div class="px-5 py-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-3">Aset</p>
                    @foreach($aset ?? [['nama'=>'Kas','jumlah'=>5000000],['nama'=>'Bank','jumlah'=>2000000],['nama'=>'Piutang','jumlah'=>1500000],['nama'=>'Persediaan','jumlah'=>1500000]] as $item)
                    <div class="py-1.5">
                        <p class="text-xs text-gray-400">{{ $item['nama'] }}</p>
                        <p class="text-xs font-semibold text-gray-800">Rp {{ number_format($item['jumlah'], 0, ',', '.') }}</p>
                    </div>
                    @endforeach
                    <div class="mt-2 pt-2 border-t border-gray-100">
                        <p class="text-xs text-gray-400">Total Aset</p>
                        <p class="text-xs font-bold text-gray-900">Rp {{ number_format($totalAset ?? 10000000, 0, ',', '.') }}</p>
                    </div>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-3">Kewajiban & Modal</p>
                    @foreach($kewajibanModal ?? [['nama'=>'Hutang Usaha','jumlah'=>3000000],['nama'=>'Modal','jumlah'=>7000000]] as $item)
                    <div class="py-1.5">
                        <p class="text-xs text-gray-400">{{ $item['nama'] }}</p>
                        <p class="text-xs font-semibold text-gray-800">Rp {{ number_format($item['jumlah'], 0, ',', '.') }}</p>
                    </div>
                    @endforeach
                    <div class="mt-2 pt-2 border-t border-gray-100">
                        <p class="text-xs text-gray-400">Total K + M</p>
                        <p class="text-xs font-bold text-gray-900">Rp {{ number_format($totalKM ?? 10000000, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Charts --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-5">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
        <h3 class="text-sm font-bold text-gray-900 mb-4">Jurnal Transaksi Overview</h3>
        <canvas id="jurnalOverviewChart" height="160"></canvas>
        <div class="flex flex-wrap gap-3 mt-3">
            @foreach([['EMEA','#14532d'],['APAC','#16a34a'],['Americas','#86efac'],['Others','#e5e7eb']] as $l)
            <span class="flex items-center gap-1 text-xs text-gray-500">
                <span class="w-2 h-2 rounded-sm inline-block" style="background:{{ $l[1] }}"></span>{{ $l[0] }}
            </span>
            @endforeach
        </div>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
        <h3 class="text-sm font-bold text-gray-900 mb-4">Laba Rugi per Departemen</h3>
        <canvas id="labaRugiDeptChart" height="160"></canvas>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
        <h3 class="text-sm font-bold text-gray-900 mb-3">Pengeluaran per Departemen</h3>
        <div class="flex items-center gap-4 mb-4">
            <div class="w-20 h-20 shrink-0">
                <canvas id="deptDonutChart"></canvas>
            </div>
            <div class="space-y-1.5">
                @foreach($departemenBeban ?? [['nama'=>'Production','pct'=>60],['nama'=>'Marketing','pct'=>40],['nama'=>'Lainnya','pct'=>10]] as $d)
                <div class="flex justify-between gap-4 text-xs">
                    <span class="text-gray-500">{{ $d['nama'] }}</span>
                    <span class="font-bold text-gray-800">{{ $d['pct'] }}%</span>
                </div>
                @endforeach
            </div>
        </div>
        <div class="border-t border-gray-100 pt-4">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-3">Perhitungan Rasio</p>
            <div class="grid grid-cols-2 gap-2">
                @foreach($rasio ?? [['label'=>'Current Ratio','nilai'=>'1.50'],['label'=>'Quick Ratio','nilai'=>'1.20'],['label'=>'ROA','nilai'=>'12.50%'],['label'=>'ROE','nilai'=>'12.50%']] as $r)
                <div class="bg-gray-50 rounded-lg px-3 py-2">
                    <p class="text-xs text-gray-400">{{ $r['label'] }}</p>
                    <p class="text-sm font-bold text-gray-800">{{ $r['nilai'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- Akun Transaksi --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
    <div class="flex items-center justify-between px-5 pt-5 pb-4 border-b border-gray-100">
        <div>
            <h2 class="text-sm font-bold text-gray-900">Akun Transaksi</h2>
            <p class="text-xs text-gray-400 mt-0.5">Daftar akun yang terdaftar</p>
        </div>
        <a href="{{ route('accounting.coa.index') }}"
           class="text-xs font-semibold text-blue-600 border border-blue-200 px-3 py-1.5 rounded-full hover:bg-blue-50 transition-colors">
            Lihat Akun
        </a>
    </div>
    <div class="px-5 py-5">
        @if(isset($akunList) && count($akunList) > 0)
        <div class="grid grid-cols-3 md:grid-cols-6 lg:grid-cols-8 gap-3">
            @foreach($akunList as $akun)
            <a href="{{ route('accounting.coa.index') }}"
               class="flex flex-col items-center gap-2 p-3 bg-gray-50 hover:bg-blue-50 rounded-xl transition-colors group">
                <div class="w-10 h-10 bg-blue-600 group-hover:bg-blue-700 rounded-xl flex items-center justify-center transition-colors">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <span class="text-xs text-gray-600 text-center font-medium leading-tight">{{ $akun->nama_akun }}</span>
            </a>
            @endforeach
        </div>
        @else
        <div class="text-center py-8">
            <div class="w-12 h-12 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <p class="text-sm font-semibold text-gray-700">Belum ada akun</p>
            <p class="text-xs text-gray-400 mt-1">Tambahkan akun transaksi pertama kamu</p>
            <a href="{{ route('accounting.coa.create') }}"
               class="inline-flex items-center gap-1.5 mt-3 px-4 py-2 bg-blue-600 text-white text-xs font-semibold rounded-full hover:bg-blue-700 transition-colors">
                + Tambah Akun
            </a>
        </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script>
Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
Chart.defaults.font.size = 11;
const g = ['#14532d','#16a34a','#86efac','#e5e7eb'];
new Chart(document.getElementById('jurnalOverviewChart'), {
    type:'bar',
    data:{labels:['Q1','Q2','Q3','Q4'],datasets:[
        {label:'EMEA',data:[40,55,35,45],backgroundColor:g[0],borderRadius:3},
        {label:'APAC',data:[30,40,25,35],backgroundColor:g[1],borderRadius:3},
        {label:'Americas',data:[20,25,20,20],backgroundColor:g[2],borderRadius:3},
        {label:'Others',data:[10,10,10,10],backgroundColor:g[3],borderRadius:3},
    ]},
    options:{indexAxis:'y',plugins:{legend:{display:false}},scales:{
        x:{stacked:true,grid:{display:false},ticks:{display:false},border:{display:false}},
        y:{stacked:true,grid:{display:false},border:{display:false}}
    }}
});
new Chart(document.getElementById('labaRugiDeptChart'), {
    type:'bar',
    data:{labels:['Q1','Q2','Q3','Q4'],datasets:[
        {label:'EMEA',data:[200,350,280,320],backgroundColor:g[0],borderRadius:4},
        {label:'APAC',data:[150,200,180,200],backgroundColor:g[1],borderRadius:4},
        {label:'Americas',data:[100,120,90,110],backgroundColor:g[2],borderRadius:4},
        {label:'Others',data:[50,60,40,50],backgroundColor:g[3],borderRadius:4},
    ]},
    options:{plugins:{legend:{display:false}},scales:{
        x:{stacked:true,grid:{display:false},border:{display:false}},
        y:{stacked:true,grid:{color:'#F3F4F6'},border:{display:false}}
    }}
});
new Chart(document.getElementById('deptDonutChart'), {
    type:'doughnut',
    data:{labels:['Production','Marketing','Lainnya'],datasets:[{data:[60,40,10],backgroundColor:[g[0],g[1],g[2]],borderWidth:0}]},
    options:{cutout:'65%',plugins:{legend:{display:false}}}
});
</script>
@endpush