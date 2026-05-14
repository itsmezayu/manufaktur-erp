<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Models\Accounting\Jurnal;
// use Barryvdh\DomPDF\Facade\Pdf;

class JurnalController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', '7hari');

        // TODO: uncomment saat model Jurnal sudah dibuat
        // $query = Jurnal::with('details');
        // $query = match($filter) {
        //     '30hari' => $query->where('tanggal', '>=', now()->subDays(30)),
        //     'bulan'  => $query->whereMonth('tanggal', now()->subMonth()->month)
        //                       ->whereYear('tanggal', now()->subMonth()->year),
        //     default  => $query->where('tanggal', '>=', now()->subDays(7)),
        // };
        // $jurnals           = $query->paginate($request->get('per_page', 5));
        // $detailDebitKredit = $query->get()->flatMap->details;
        // $totalDebit        = $query->sum('total_debit');
        // $totalKredit       = $query->sum('total_kredit');

        return view('accounting.jurnal.index', [
            'jurnals'           => [],      // ganti: $jurnals
            'detailDebitKredit' => [],      // ganti: $detailDebitKredit
            'totalDebit'        => 1000000, // ganti: $totalDebit
            'totalKredit'       => 1000000, // ganti: $totalKredit
        ]);
    }

    public function edit($id)
    {
        // TODO: $jurnal = Jurnal::with('details')->findOrFail($id);
        // return view('accounting.jurnal.form', compact('jurnal'));
        return redirect()->route('accounting.jurnal.index');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'keterangan' => ['required', 'string'],
            'status'     => ['required', 'in:draft,posted'],
        ]);

        // TODO: Jurnal::findOrFail($id)->update($request->only('keterangan','status'));

        return redirect()->route('accounting.jurnal.index')
                         ->with('success', 'Jurnal berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // TODO: Jurnal::findOrFail($id)->delete();

        return redirect()->route('accounting.jurnal.index')
                         ->with('success', 'Jurnal berhasil dihapus.');
    }

    public function exportPdf(Request $request)
    {
        // TODO: install dompdf dulu: composer require barryvdh/laravel-dompdf
        // $filter  = $request->get('filter', '7hari');
        // $jurnals = Jurnal::filter($filter)->with('details')->get();
        // $pdf = Pdf::loadView('accounting.jurnal.pdf', compact('jurnals'));
        // return $pdf->download('jurnal-transaksi.pdf');

        return back()->with('error', 'Export PDF: jalankan composer require barryvdh/laravel-dompdf terlebih dahulu.');
    }
}