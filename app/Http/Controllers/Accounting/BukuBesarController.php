<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Models\JurnalDetail;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BukuBesarController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', '7hari');

        $query = JurnalDetail::with(['akun', 'jurnal'])
            ->whereHas('jurnal', function($q) use ($filter) {
                match($filter) {
                    '30hari' => $q->where('tanggal', '>=', now()->subDays(30)),
                    'bulan'  => $q->whereMonth('tanggal', now()->subMonth()->month)
                                  ->whereYear('tanggal', now()->subMonth()->year),
                    default  => $q->where('tanggal', '>=', now()->subDays(7)),
                };
            });

        $bukuBesars  = $query->paginate($request->get('per_page', 5));
        $totalDebit  = $query->sum('debit');
        $totalKredit = $query->sum('kredit');
        $saldoAkhir  = $totalDebit - $totalKredit;

        return view('accounting.buku-besar.index', compact(
            'bukuBesars', 'totalDebit', 'totalKredit', 'saldoAkhir'
        ));
    }

   public function exportPdf(Request $request)
    {
        $filter = $request->get('filter', '7hari');

        // Tarik data penuh (menggunakan ->get() bukan ->paginate()) untuk laporan PDF
        $query = JurnalDetail::with(['akun', 'jurnal'])
            ->whereHas('jurnal', function($q) use ($filter) {
                match($filter) {
                    '30hari' => $q->where('tanggal', '>=', now()->subDays(30)),
                    'bulan'  => $q->whereMonth('tanggal', now()->subMonth()->month)
                                  ->whereYear('tanggal', now()->subMonth()->year),
                    default  => $q->where('tanggal', '>=', now()->subDays(7)),
                };
            });

        $bukuBesars  = $query->get(); 
        $totalDebit  = $query->sum('debit');
        $totalKredit = $query->sum('kredit');
        $saldoAkhir  = $totalDebit - $totalKredit;

        // Render data ke dalam file view cetak PDF kamu
        $pdf = Pdf::loadView('accounting.buku-besar.pdf', compact(
            'bukuBesars', 'totalDebit', 'totalKredit', 'saldoAkhir', 'filter'
        ));

        // Download otomatis file laporan buku besar
        return $pdf->download('laporan-buku-besar-' . $filter . '.pdf');
    }
}