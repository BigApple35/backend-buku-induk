<?php

namespace App\Http\Controllers;

use App\Models\BagianKelas;
use Illuminate\Http\Request;

class BagianKelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bagianKelas = BagianKelas::all();
        return response()->json($bagianKelas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $bagianKelas = BagianKelas::create($validated);

        return response()->json($bagianKelas, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $bagianKelas = BagianKelas::findOrFail($id);
        return response()->json($bagianKelas);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $bagianKelas = BagianKelas::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $bagianKelas->update($validated);

        return response()->json($bagianKelas);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $bagianKelas = BagianKelas::findOrFail($id);
        $bagianKelas->delete();

        return response()->json(null, 204);
    }
}
