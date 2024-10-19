<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
{
    $query = User::query();

    // Check the 'status' query parameter
    $status = $request->query('status');

    switch ($status) {
        case 'active':
            $query->whereNull('deleted_at');
            break;
        case 'inactive':
            $query->onlyTrashed();
            break;
        case 'all':
            $query->withTrashed();
            break;
        default:
            // If no status is specified, return only active users
            $query->whereNull('deleted_at');
    }

    // You can add pagination here if needed
    $users = $query->get();

    return response()->json(['users' => $users]);
}

    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json(['user' => $user]);
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Create the new user with the "teacher" role
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'teacher', // Set the role to "teacher"
        ]);

        return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'email' => 'string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user->name = $request->name ?? $user->name;
        $user->email = $request->email ?? $user->email;
        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }

    public function deactivate($id)
    {
        $user = User::findOrFail($id);
        $user->delete(); // This will set deleted_at to the current timestamp
        return response()->json(['message' => 'User deactivated successfully']);
    }

    public function activate($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore(); // This will set deleted_at to null
        return response()->json(['message' => 'User activated successfully']);
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->forceDelete(); // This will permanently delete the user
        return response()->json(['message' => 'User deleted permanently']);
    }
}
