<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Models\Accounting\Akun;

class CoaController extends Controller
{
    public function index(Request $request)
    {
        // TODO: uncomment saat model Akun sudah dibuat oleh backend
        // $akunList = Akun::query()
        //     ->when($request->search, fn($q, $s) => $q->where('nama_akun', 'like', "%$s%"))
        //     ->when($request->status, fn($q, $s) => $q->where('status', $s))
        //     ->paginate($request->get('per_page', 5));
        // $totalAkun = Akun::count();

        return view('accounting.coa.index', [
            'akunList'  => [],  // ganti: $akunList
            'totalAkun' => 0,   // ganti: $totalAkun
        ]);
    }

    public function create()
    {
        return view('accounting.coa.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_akun'   => ['required', 'string', 'max:20'],
            'nama_akun'   => ['required', 'string', 'max:100'],
            'tipe_parent' => ['nullable', 'string', 'max:50'],
            'status'      => ['required', 'in:Aktif,Non-Aktif'],
        ]);

        // TODO: Akun::create($request->only('kode_akun','nama_akun','tipe_parent','status'));

        return redirect()->route('accounting.coa.index')
                         ->with('success', 'Akun berhasil ditambahkan.');
    }

    public function edit($id)
    {
        // TODO: $akun = Akun::findOrFail($id);
        $akun = null; // hapus baris ini setelah backend siap

        return view('accounting.coa.form', compact('akun'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_akun'   => ['required', 'string', 'max:20'],
            'nama_akun'   => ['required', 'string', 'max:100'],
            'tipe_parent' => ['nullable', 'string', 'max:50'],
            'status'      => ['required', 'in:Aktif,Non-Aktif'],
        ]);

        // TODO: Akun::findOrFail($id)->update($request->only('kode_akun','nama_akun','tipe_parent','status'));

        return redirect()->route('accounting.coa.index')
                         ->with('success', 'Akun berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // TODO: Akun::findOrFail($id)->delete();

        return redirect()->route('accounting.coa.index')
                         ->with('success', 'Akun berhasil dihapus.');
    }
}