<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eager load related Jurusan, BagianKelas, and Angkatan
        $kelas = Kelas::with(['jurusan', 'bagianKelas', 'angkatan'])->get();

        // Add the 'judul_kelas' field to each class
        $kelas->transform(function ($kls) {
            $kls->judul_kelas = $kls->nama . ' ' . $kls->bagianKelas->nama;
            return $kls;
        });

        return response()->json($kelas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jurusan_id' => 'required|exists:jurusan,id',
            'angkatan_id' => 'required|exists:angkatan,id',
            'bagian_kelas_id' => 'required|array',
            'bagian_kelas_id.*' => 'exists:bagian_kelas,id',
        ]);

        $classes = [];

        // Loop through each bagian_kelas_id and create a class
        foreach ($validated['bagian_kelas_id'] as $bagianKelasId) {
            $kelas = Kelas::create([
                'nama' => $validated['nama'],
                'jurusan_id' => $validated['jurusan_id'],
                'angkatan_id' => $validated['angkatan_id'],
                'bagian_kelas_id' => $bagianKelasId,
            ]);
            $classes[] = $kelas;
        }

        return response()->json($classes, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Eager load related Jurusan, BagianKelas, and Angkatan for a single class
        $kelas = Kelas::with(['jurusan', 'bagianKelas', 'angkatan'])->findOrFail($id);

        // Add the 'judul_kelas' field
        $kelas->judul_kelas = $kelas->nama . ' ' . $kelas->bagianKelas->nama;

        return response()->json($kelas);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'sometimes|string|max:255',
            'jurusan_id' => 'sometimes|exists:jurusan,id',
            'angkatan_id' => 'sometimes|exists:angkatan,id',
            'bagian_kelas_id' => 'sometimes|exists:bagian_kelas,id',
        ]);

        $kelas->update($validated);

        return response()->json($kelas);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();

        return response()->json(null, 204);
    }
}
