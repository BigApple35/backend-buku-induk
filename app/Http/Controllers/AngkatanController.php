<?php

namespace App\Http\Controllers;

use App\Models\Angkatan;
use Illuminate\Http\Request;

class AngkatanController extends Controller
{
    public function index()
    {
        $angkatans = Angkatan::all();
        return response()->json(['angkatans' => $angkatans]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required|integer|unique:angkatan,tahun'
        ]);

        $angkatan = Angkatan::create($request->all());
        return response()->json(['message' => 'Angkatan created successfully', 'angkatan' => $angkatan], 201);
    }

    public function show(Angkatan $angkatan)
    {
        return response()->json(['angkatan' => $angkatan]);
    }

    public function update(Request $request, Angkatan $angkatan)
    {
        $request->validate([
            'tahun' => 'required|integer|unique:angkatan,tahun,' . $angkatan->id
        ]);

        $angkatan->update($request->all());
        return response()->json(['message' => 'Angkatan updated successfully', 'angkatan' => $angkatan]);
    }

    public function destroy(Angkatan $angkatan)
    {
        $angkatan->delete();
        return response()->json(['message' => 'Angkatan deleted successfully']);
    }
}
