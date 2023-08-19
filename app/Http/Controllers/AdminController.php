<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function userView()
    {
        $users = User::where('role', false)->get();
        return view('admin.users', compact('users'));
    }

    public function edit()
    {
        $admin = Auth::user();
        return view('admin.edit', compact('admin'));
    }

    public function update(Request $request)
    {
        /** @var User $admin */
        $admin = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $admin->id,
        ]);

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->save();

        return redirect()->route('admin.edit')->withSuccess('Details edited successfully');
    }

    public function showChangePassForm()
    {
        return view('admin.change-password');
    }

    public function updatePassword(Request $request)
    {
        $admin = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->with('error', 'Password not matched');
        }

        /** @var User $admin */
        $admin->update([
            'password' => Hash::make($request->new_password),
        ]);


        return redirect()->route('change.password')->with('success', 'Password changed successfully.');
    }
}
