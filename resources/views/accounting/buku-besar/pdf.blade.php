<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Buku Besar</title>
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
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Buku Besar</h1>
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
                <th style="width: 12%;" class="text-center">Tanggal</th>
                <th style="width: 15%;">Kode Akun</th>
                <th style="width: 25%;">Nama Akun</th>
                <th style="width: 20%;">Keterangan</th>
                <th style="width: 14%; text-align: right;">Debit</th>
                <th style="width: 14%; text-align: right;">Kredit</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bukuBesars as $bb)
            <tr>
                <td class="text-center">{{ isset($bb->jurnal->tanggal) ? date('d/m/Y', strtotime($bb->jurnal->tanggal)) : '–' }}</td>
                <td>{{ $bb->akun->kode_akun ?? '–' }}</td>
                <td>{{ $bb->akun->nama_akun ?? '–' }}</td>
                <td>{{ $bb->jurnal->keterangan ?? '–' }}</td>
                <td class="text-right">{{ $bb->debit > 0 ? 'Rp '.number_format($bb->debit, 0, ',', '.') : '–' }}</td>
                <td class="text-right">{{ $bb->kredit > 0 ? 'Rp '.number_format($bb->kredit, 0, ',', '.') : '–' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center" style="padding: 20px; color: #999;">
                    Tidak ada data transaksi pada periode ini.
                </td>
            </tr>
            @endforelse

            @if(count($bukuBesars) > 0)
            <tr class="total-row">
                <td colspan="4" class="text-right">Total:</td>
                <td class="text-right">Rp {{ number_format($totalDebit, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($totalKredit, 0, ',', '.') }}</td>
            </tr>
            <tr class="total-row" style="background-color: #eee;">
                <td colspan="4" class="text-right">Saldo Akhir:</td>
                <td colspan="2" class="text-right">Rp {{ number_format($saldoAkhir, 0, ',', '.') }}</td>
            </tr>
            @endif
        </tbody>
    </table>

</body>
</html>