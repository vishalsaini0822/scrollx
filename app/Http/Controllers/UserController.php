<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    // Display a listing of the users.
    public function index()
    {
        $users = User::where('is_admin', 0)->where('id','!=',auth()->user()->id)->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    // Store a newly created user in storage.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        if ($request->ajax()) {
            if ($errors = $request->getSession()->get('errors')) {
            return response()->json([
                'success' => false,
                'errors' => $errors->getBag('default')->getMessages()
            ], 422);
            }
        }

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);
        return response()->json([
            'success' => true,
            'message' => 'User created successfully.'
        ]);
    }

    // Display the specified user.
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    // Show the form for editing the specified user.
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    // Update the specified user in storage.
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
        ]);

        if ($request->ajax()) {
            if ($errors = $request->getSession()->get('errors')) {
            return response()->json([
                'success' => false,
                'errors' => $errors->getBag('default')->getMessages()
            ], 422);
            }
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully.',
            'user' => $user
        ]);
    }

    // Remove the specified user from storage.
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.'
            ], 404);
        }
        if ($user->is_admin) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete an admin user.'
            ], 403);
        }
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully.'
        ]);
    }
}
