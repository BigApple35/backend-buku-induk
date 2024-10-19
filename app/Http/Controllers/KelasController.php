<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::with('jurusan')->get();
        return response()->json(['kelas' => $kelas]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jurusan_id' => 'required|exists:jurusan,id'
        ]);

        $kelas = Kelas::create($request->all());
        return response()->json(['message' => 'Kelas created successfully', 'kelas' => $kelas], 201);
    }

    public function show(Kelas $kelas)
    {
        $kelas->load('jurusan');
        return response()->json(['kelas' => $kelas]);
    }

    public function update(Request $request, Kelas $kelas)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jurusan_id' => 'required|exists:jurusan,id'
        ]);

        $kelas->update($request->all());
        return response()->json(['message' => 'Kelas updated successfully', 'kelas' => $kelas]);
    }

    public function destroy(Kelas $kelas)
    {
        $kelas->delete();
        return response()->json(['message' => 'Kelas deleted successfully']);
    }

    public function getByJurusan($jurusanId)
    {
        $jurusan = Jurusan::findOrFail($jurusanId);
        $kelas = $jurusan->kelas;
        return response()->json(['kelas' => $kelas]);
    }
}
