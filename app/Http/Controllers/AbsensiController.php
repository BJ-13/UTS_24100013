<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use App\Models\Absensi;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $matakuliahs = Matakuliah::all();
        $mahasiswas = Mahasiswa::all();
        
        $selected_mk = $request->get('matakuliah_id');
        $selected_date = $request->get('tanggal', date('Y-m-d'));

    
        $existing_absensi = [];
        if ($selected_mk && $selected_date) {
            $existing_absensi = Absensi::where('matakuliah_id', $selected_mk)
                ->where('tanggal', $selected_date)
                ->pluck('status', 'mahasiswa_id')
                ->toArray();
        }

        return view('absensi.index', compact('matakuliahs', 'mahasiswas', 'selected_mk', 'selected_date', 'existing_absensi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'matakuliah_id' => 'required',
            'tanggal' => 'required|date',
            'status' => 'required|array',
        ]);

        foreach ($request->status as $mahasiswa_id => $status) {
    Absensi::updateOrCreate(
        [
            'mahasiswa_id'    => $mahasiswa_id,
            'matakuliah_id'   => $request->matakuliah_id,
            'tanggal_absensi' => $request->tanggal_absensi,
        ],
        [
            'status' => $status
        ]
    );
}

        return redirect()->route('absensi.index', [
            'matakuliah_id' => $request->matakuliah_id,
            'tanggal' => $request->tanggal
        ])->with('success', 'Data absensi berhasil disimpan!');
    }
}