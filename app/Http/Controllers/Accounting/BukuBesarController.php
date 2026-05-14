<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Models\Accounting\BukuBesar;
// use Barryvdh\DomPDF\Facade\Pdf;

class BukuBesarController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', '7hari');

        // TODO: uncomment saat model BukuBesar sudah dibuat
        // $query = BukuBesar::query();
        // $query = match($filter) {
        //     '30hari' => $query->where('tanggal', '>=', now()->subDays(30)),
        //     'bulan'  => $query->whereMonth('tanggal', now()->subMonth()->month),
        //     default  => $query->where('tanggal', '>=', now()->subDays(7)),
        // };
        // $bukuBesars  = $query->paginate($request->get('per_page', 5));
        // $totalDebit  = $query->sum('debit');
        // $totalKredit = $query->sum('kredit');
        // $saldoAkhir  = $query->orderBy('tanggal','desc')->first()?->saldo ?? 0;

        return view('accounting.buku-besar.index', [
            'bukuBesars'  => [],      // ganti: $bukuBesars
            'totalDebit'  => 1000000, // ganti: $totalDebit
            'totalKredit' => 1000000, // ganti: $totalKredit
            'saldoAkhir'  => 1000000, // ganti: $saldoAkhir
        ]);
    }

    public function exportPdf(Request $request)
    {
        // TODO:
        // $bukuBesars = BukuBesar::filter($request->filter)->get();
        // $pdf = Pdf::loadView('accounting.buku-besar.pdf', compact('bukuBesars'));
        // return $pdf->download('buku-besar.pdf');

        return back()->with('error', 'Export PDF: jalankan composer require barryvdh/laravel-dompdf terlebih dahulu.');
    }
}