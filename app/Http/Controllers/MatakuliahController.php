<?php

namespace App\Http\Controllers;

use App\Models\Matakuliah;
use Illuminate\Http\Request;

class MatakuliahController extends Controller
{
    public function index()
    {
        $matakuliahs = Matakuliah::all();
        return view('matakuliah.index', compact('matakuliahs'));
    }

    public function create()
    {
        return view('matakuliah.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:matakuliah,kode',
            'nama_matakuliah' => 'required',
        ]);

        Matakuliah::create($request->all());

        return redirect()->route('matakuliah.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit(Matakuliah $matakuliah)
    {
        return view('matakuliah.edit', compact('matakuliah'));
    }

    public function update(Request $request, Matakuliah $matakuliah)
    {
        $request->validate([
            'kode' => 'required|unique:matakuliah,kode,' . $matakuliah->id,
            'nama_matakuliah' => 'required',
        ]);

        $matakuliah->update($request->all());

        return redirect()->route('matakuliah.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(Matakuliah $matakuliah)
    {
        $matakuliah->delete();

        return redirect()->route('matakuliah.index')->with('success', 'Data berhasil dihapus.');
    }
}