<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CustomController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function registration()
    {
        return view('auth.registration');
    }

    public function customLogin(Request $request)
    {

        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard');
        } else {
            return redirect('login')->withErrors('Details not matched!');
        }
    }

    public function customRegistration(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        $data = $request->all();
        $check = $this->create($data);

        Auth::login($check);
        return redirect('dashboard');
    }

    public function create(array $data)
    {
        $token = Str::random(60);
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function dashboard()
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->role == 1) {
                $total = User::where('role', false)->count();
                $pendingCount = User::where('status', false)->count();
                return view('admin.home', compact('total', 'pendingCount'));
            } else {
                if ($user->status == 0) {
                    return redirect('approval');
                } else {
                    return view('dashboard', compact('user'));
                }
            }
        }
        return redirect('login')->withErrors('Oops! You have entered invalid credentials');
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();

        return redirect('/');
    }

    public function approval()
    {
        return view('approval');
    }

    public function approved(Request $request,$id)
    {
        $currentStatus = $request->input('status');
        $data = User::findOrFail($id);
        $data->status = ($currentStatus == 1) ? 0 : 1;
        $data->save();

        return response()->json(['message' => 'Response processed successfully']);
    }
}
