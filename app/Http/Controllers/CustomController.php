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

        $token = Str::random(60);
        $data['token'] = $token;

        $check = $this->create($data);

        Auth::login($check);
        return redirect('dashboard');
    }

    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'token' => $data['token'],
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

    public function approved(Request $request, $id)
    {
        $currentStatus = $request->input('status');
        $data = User::findOrFail($id);
        $data->status = ($currentStatus == 1) ? 0 : 1;
        $data->save();

        return response()->json(['message' => 'Response processed successfully']);
    }


    public function femail()
    {
        return view('auth.email_forgotpassword');
    }

    public function validate_email(Request $request){
        $request -> validate([
            'email_f' => 'required|email',
        ]);

        $user = User::where('email', $request->input('email_f'))->first();

        if(!$user){
            return back()->with('error','Email not found');
        }

        if(!$user->token){
            return back()->with('error', 'Token not found');
        }

        // return redirect()->route('forgot.password');
        return redirect()->route('forgot.password', ['token' => $user->token]);
    }

    public function forgotPasswordForm(){
        return view('auth.fpassword');
    }

    public function newPassword(Request $request){

        $request->validate([
        'token' => 'required',
        'new_password_f' => 'required|string|min:6|confirmed',
        ]);

        $user = User::where('token', $request->input('token'))->first();

        if(!$user){
            return back()->with('error', 'Invalid  Token');
        }

       $user->update([
        'password' => Hash::make($request->new_password_f),
        ]);

        return redirect()->route('login')->with('success', 'Password changed successfully.');
    }
}
