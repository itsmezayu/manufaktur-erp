<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Models\Jurnal;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class JurnalController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', '7hari');

        $query = Jurnal::with('details')->when(true, function($q) use ($filter) {
            match($filter) {
                '30hari' => $q->where('tanggal', '>=', now()->subDays(30)),
                'bulan'  => $q->whereMonth('tanggal', now()->subMonth()->month)
                              ->whereYear('tanggal', now()->subMonth()->year),
                default  => $q->where('tanggal', '>=', now()->subDays(7)),
            };
        });

        $jurnals           = $query->paginate($request->get('per_page', 5));
        $detailDebitKredit = $query->get()->flatMap->details;
        $totalDebit        = $query->sum('total_debit');
        $totalKredit       = $query->sum('total_kredit');

        return view('accounting.jurnal.index', compact(
            'jurnals', 'detailDebitKredit', 'totalDebit', 'totalKredit'
        ));
    }

    public function edit($id)
    {
        $jurnal = Jurnal::with('details')->findOrFail($id);
        return view('accounting.jurnal.form', compact('jurnal'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'keterangan' => ['required', 'string'],
            'status'     => ['required', 'in:draft,posted'],
        ]);

        Jurnal::findOrFail($id)->update($request->only('keterangan', 'status'));

        return redirect()->route('accounting.jurnal.index')
                         ->with('success', 'Jurnal berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Jurnal::findOrFail($id)->delete();

        return redirect()->route('accounting.jurnal.index')
                         ->with('success', 'Jurnal berhasil dihapus.');
    }

    public function exportPdf(Request $request)
    {
        $filter = $request->get('filter', '7hari');

        // Tarik data penuh menggunakan ->get() tanpa pagination untuk laporan cetak
        $query = Jurnal::with(['details.akun'])->when(true, function($q) use ($filter) {
            match($filter) {
                '30hari' => $q->where('tanggal', '>=', now()->subDays(30)),
                'bulan'  => $q->whereMonth('tanggal', now()->subMonth()->month)
                              ->whereYear('tanggal', now()->subMonth()->year),
                default  => $q->where('tanggal', '>=', now()->subDays(7)),
            };
        });

        $jurnals     = $query->get();
        $totalDebit  = $query->sum('total_debit');
        $totalKredit = $query->sum('total_kredit');

        // Render data ke file view pdf
        $pdf = Pdf::loadView('accounting.jurnal.pdf', compact(
            'jurnals', 'totalDebit', 'totalKredit', 'filter'
        ));

        // Download otomatis file laporan jurnal
        return $pdf->download('laporan-jurnal-transaksi-' . $filter . '.pdf');
    }
}