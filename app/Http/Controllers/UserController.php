<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function dataUsers()
    {
        $data_user = User::all();
        return view('user.data-user', compact('data_user'));
    }

    public function addUsers()
    {
        return view('user.add-user');
    }

    public function saveUsers(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required',
                'role' => 'required',
            ]
        );

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->save();

        return redirect()->route('data-users')->with('success', 'Data saved successfully.');
    }

    public function editUsers($id)
    {
        $user = User::find($id);
        return view('user.edit-user', compact('user'));
    }

    public function updateUsers(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $id,
                'password' => 'nullable',
                'role' => 'required',
            ]
        );

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;

        // Jika password tidak kosong, hash dan simpan password baru
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->role = $request->role;
        $user->update();

        return redirect()->route('data-users')->with('updated', 'Data updated successfully.');
    }

    public function deleteUsers($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('data-users')->with('deleted', 'Data deleted successfully.');
    }
}
