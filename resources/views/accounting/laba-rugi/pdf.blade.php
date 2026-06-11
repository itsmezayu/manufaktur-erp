<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Laba Rugi</title>
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
            margin-bottom: 20px;
        }
        .report-table {
            width: 100%;
            border-collapse: collapse;
        }
        .report-table th {
            background-color: #f5f5f5;
            border-top: 1px solid #333;
            border-bottom: 1px solid #333;
            padding: 8px;
            font-weight: bold;
            text-align: left;
        }
        .report-table td {
            padding: 6px 8px;
            vertical-align: top;
        }
        .category-title {
            font-weight: bold;
            font-size: 12px;
            padding-top: 15px;
            padding-bottom: 5px;
        }
        .indent {
            padding-left: 20px;
        }
        .subtotal-row {
            font-weight: bold;
            border-top: 1px solid #ddd;
            border-bottom: 1px dashed #333;
        }
        .grandtext {
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .grandtotal-row {
            background-color: #eee;
            border-top: 2px solid #333;
            border-bottom: 2px solid #333;
        }
        .text-right { text-align: right; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Laba Rugi</h1>
        <p>Sistem Informasi Manufaktur ERP</p>
    </div>

    <table class="info-table">
        <tr>
            <td><strong>Periode:</strong> {{ $periodeAwal }} s/d {{ $periodeAkhir }}</td>
            <td class="text-right"><strong>Tanggal Cetak:</strong> {{ date('d/m/Y') }}</td>
        </tr>
    </table>

    <table class="report-table">
        <thead>
            <tr>
                <th>Deskripsi / Akun</th>
                <th class="text-right" style="width: 25%;">Nilai (Rp)</th>
                <th class="text-right" style="width: 25%;">Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            
            {{-- BAGIAN PENDAPATAN --}}
            <tr>
                <td colspan="3" class="category-title">PENDAPATAN</td>
            </tr>
            @forelse($pendapatan as $p)
            <tr>
                <td class="indent">{{ $p['nama'] }}</td>
                <td class="text-right">{{ $p['jumlah'] > 0 ? number_format($p['jumlah'], 0, ',', '.') : '0' }}</td>
                <td></td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="indent text-muted">Belum ada data pendapatan.</td>
            </tr>
            @endforelse
            <tr class="subtotal-row">
                <td class="indent">Total Pendapatan</td>
                <td></td>
                <td class="text-right">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
            </tr>

            {{-- BAGIAN BEBAN --}}
            <tr>
                <td colspan="3" class="category-title">BEBAN / BIAYA</td>
            </tr>
            @forelse($beban as $b)
            <tr>
                <td class="indent">{{ $b['nama'] }}</td>
                <td class="text-right">{{ $b['jumlah'] > 0 ? number_format($b['jumlah'], 0, ',', '.') : '0' }}</td>
                <td></td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="indent text-muted">Belum ada data beban.</td>
            </tr>
            @endforelse
            <tr class="subtotal-row">
                <td class="indent">Total Beban</td>
                <td></td>
                <td class="text-right" style="color: #b91c1c;">(Rp {{ number_format($totalBeban, 0, ',', '.') }})</td>
            </tr>

            {{-- TOTAL LABA BERSIH --}}
            <tr>
                <td colspan="3" style="padding: 15px 0 0 0;"></td>
            </tr>
            <tr class="grandtotal-row">
                <td class="grandtext" style="padding: 10px 8px;">
                    {{ $labaBersih >= 0 ? 'Laba Bersih' : 'Rugi Bersih' }}
                </td>
                <td></td>
<td class="text-right grandtext" style="padding: 10px 8px; @if($labaBersih >= 0) color: #16a34a; @else color: #b91c1c; @endif">                    Rp {{ number_format($labaBersih, 0, ',', '.') }}
                </td>
            </tr>

        </tbody>
    </table>

</body>
</html>