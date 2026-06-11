<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Akun;

class CoaController extends Controller
{
    public function index(Request $request)
    {
        // TODO: uncomment saat model Akun sudah dibuat oleh backend
         $akunList = Akun::query()
        ->when($request->search, fn($q, $s) => $q->where('nama_akun', 'like', "%$s%"))
        ->when($request->status, fn($q, $s) => $q->where('status', $s))
        ->paginate($request->get('per_page', 5));
    $totalAkun = Akun::count();


           return view('accounting.coa.index', compact('akunList', 'totalAkun'));

    }

    public function create()
    {
        return view('accounting.coa.form');
    }

public function store(Request $request)
{
    $request->validate([
        'kode_akun'  => ['required', 'string', 'max:20', 'unique:akuns,kode_akun'], // ← tambah ini
        'nama_akun'  => ['required', 'string', 'max:100'],
        'tipe_akun'  => ['required', 'in:aset,kewajiban,modal,pendapatan,beban'],
        'tipe_parent'=> ['nullable', 'string', 'max:50'],
        'status'     => ['required', 'in:Aktif,Non-Aktif'],
    ]);

    Akun::create($request->only('kode_akun', 'nama_akun', 'tipe_akun', 'tipe_parent', 'status'));

    return redirect()->route('accounting.coa.index')
                     ->with('success', 'Akun berhasil ditambahkan.');
}

public function update(Request $request, $id)
{
    $request->validate([
        'kode_akun'  => ['required', 'string', 'max:20', "unique:akuns,kode_akun,$id"], // ← tambah ini (ignore ID sendiri)
        'nama_akun'  => ['required', 'string', 'max:100'],
        'tipe_akun'  => ['required', 'in:aset,kewajiban,modal,pendapatan,beban'],
        'tipe_parent'=> ['nullable', 'string', 'max:50'],
        'status'     => ['required', 'in:Aktif,Non-Aktif'],
    ]);

    Akun::findOrFail($id)->update($request->only('kode_akun', 'nama_akun', 'tipe_akun', 'tipe_parent', 'status'));

    return redirect()->route('accounting.coa.index')
                     ->with('success', 'Akun berhasil diperbarui.');
}

public function edit($id)
{
    $akun = Akun::findOrFail($id);
    return view('accounting.coa.form', compact('akun'));
}

public function destroy($id)
{
    Akun::findOrFail($id)->delete();

    return redirect()->route('accounting.coa.index')
                     ->with('success', 'Akun berhasil dihapus.');
}
}