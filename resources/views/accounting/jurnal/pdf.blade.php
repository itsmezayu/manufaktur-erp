<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Jurnal Transaksi</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            font-size: 11px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #333;
            padding-bottom: 8px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }
        .header p {
            margin: 4px 0 0;
            color: #666;
            font-size: 12px;
        }
        .info-table {
            width: 100%;
            margin-bottom: 15px;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }
        .data-table th {
            background-color: #f5f5f5;
            border: 1px solid #ddd;
            padding: 8px;
            font-weight: bold;
            text-align: left;
        }
        .data-table td {
            border: 1px solid #ddd;
            padding: 7px 8px;
            vertical-align: top;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .total-row { font-weight: bold; background-color: #fafafa; }
        .badge-posted { color: #16a34a; font-weight: bold; }
        .badge-draft { color: #d97706; font-weight: bold; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Jurnal Transaksi</h1>
        <p>Sistem Informasi Manufaktur ERP</p>
    </div>

    <table class="info-table">
        <tr>
            <td><strong>Periode:</strong> 
                @if($filter === '30hari')
                    30 Hari Terakhir
                @elseif($filter === 'bulan')
                    Bulan Lalu
                @else
                    7 Hari Terakhir
                @endif
            </td>
            <td class="text-right"><strong>Tanggal Cetak:</strong> {{ date('d/m/Y') }}</td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 12%;" class="text-center">Tanggal / No</th>
                <th style="width: 15%;">Kode Akun</th>
                <th style="width: 25%;">Nama Akun / Keterangan</th>
                <th style="width: 10%;" class="text-center">Status</th>
                <th style="width: 19%; text-align: right;">Debit</th>
                <th style="width: 19%; text-align: right;">Kredit</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jurnals as $jurnal)
                {{-- Baris Utama Jurnal --}}
                <tr style="background-color: #fdfdfd;">
                    <td class="text-center">
                        <strong>{{ isset($jurnal->tanggal) ? date('d/m/Y', strtotime($jurnal->tanggal)) : '–' }}</strong>
                        <br><span style="color: #777;">#{{ $jurnal->id }}</span>
                    </td>
                    <td colspan="2">
                        <strong>{{ $jurnal->keterangan ?? '–' }}</strong>
                    </td>
                    <td class="text-center">
                        <span class="{{ $jurnal->status === 'posted' ? 'badge-posted' : 'badge-draft' }}">
                            {{ strtoupper($jurnal->status) }}
                        </span>
                    </td>
                    <td class="text-right">Rp {{ number_format($jurnal->total_debit, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($jurnal->total_kredit, 0, ',', '.') }}</td>
                </tr>

                {{-- Baris Detail Akun Debet/Kredit --}}
                @foreach($jurnal->details as $detail)
                <tr>
                    <td></td>
                    <td><span style="color: #555;">{{ $detail->akun->kode_akun ?? '–' }}</span></td>
                    <td>
                        {{-- Menggeser teks jika posisi akun di sebelah kredit --}}
<span @if($detail->kredit > 0) style="padding-left: 20px; color: #666;" @endif>                            {{ $detail->akun->nama_akun ?? '–' }}
                        </span>
                    </td>
                    <td></td>
                    <td class="text-right" style="color: #555;">
                        {{ $detail->debit > 0 ? 'Rp '.number_format($detail->debit, 0, ',', '.') : '–' }}
                    </td>
                    <td class="text-right" style="color: #555;">
                        {{ $detail->kredit > 0 ? 'Rp '.number_format($detail->kredit, 0, ',', '.') : '–' }}
                    </td>
                </tr>
                @endforeach
            @empty
            <tr>
                <td colspan="6" class="text-center" style="padding: 20px; color: #999;">
                    Tidak ada data transaksi jurnal pada periode ini.
                </td>
            </tr>
            @endforelse

            {{-- Baris Akumulasi Total --}}
            @if(count($jurnals) > 0)
            <tr class="total-row" style="background-color: #eee;">
                <td colspan="4" class="text-right">TOTAL KESELURUHAN:</td>
                <td class="text-right">Rp {{ number_format($totalDebit, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($totalKredit, 0, ',', '.') }}</td>
            </tr>
            @endif
        </tbody>
    </table>

</body>
</html>