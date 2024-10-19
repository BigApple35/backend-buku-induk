<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\User;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    public function index()
    {
        $jurusans = Jurusan::with(['user', 'kelas', 'angkatan'])->get();
        return response()->json(['jurusans' => $jurusans]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jurusan' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'angkatan_id' => 'required|exists:angkatan,id'
        ]);

        $jurusan = Jurusan::create($request->all());
        return response()->json(['message' => 'Jurusan created successfully', 'jurusan' => $jurusan], 201);
    }

    public function show(Jurusan $jurusan)
    {
        $jurusan->load(['user', 'kelas', 'angkatan']);
        return response()->json(['jurusan' => $jurusan]);
    }

    public function update(Request $request, Jurusan $jurusan)
    {
        $request->validate([
            'nama_jurusan' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'angkatan_id' => 'required|exists:angkatan,id'
        ]);

        $jurusan->update($request->all());
        return response()->json(['message' => 'Jurusan updated successfully', 'jurusan' => $jurusan]);
    }

    public function destroy(Jurusan $jurusan)
    {
        $jurusan->delete();
        return response()->json(['message' => 'Jurusan deleted successfully']);
    }

    public function getByUser($userId)
    {
        $user = User::findOrFail($userId);
        $jurusans = $user->jurusans;
        return response()->json(['jurusans' => $jurusans]);
    }

    public function getByAngkatan($angkatanId)
    {
        $jurusans = Jurusan::where('angkatan_id', $angkatanId)->get();
        return response()->json(['jurusans' => $jurusans]);
    }
}
