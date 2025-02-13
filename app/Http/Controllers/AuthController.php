<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{

    public function getLogin()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();  

            if ($user->email === 'admin@gmail.com' && $user->role !== 'admin') {
                $user->role = 'admin';
                $user->save();
            }

            Cookie::queue('email', $user->email);
            Log::info($user->email . ' is logged in as ' . $user->role . '.');
            if ($user->role === 'admin') {
                return redirect()->route('admin.items');
            }
            return redirect('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.'
        ])->onlyInput('email');
    }

    public function getRegister()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|min:3|max:40',
            'email' => ['required', 'string', 'regex:/^[\w.+\-]+@gmail\.com$/i', 'unique:users,email'],
            'password' => 'required|string|min:6|max:12',
            'phone_number' => ['required', 'string', 'regex:/^08[0-9]{8,}$/', 'unique:users,phone_number']
        ], [
            'full_name.required' => 'Full Name is required.',
            'full_name.min' => 'Full Name must be at least 3 characters.',
            'full_name.max' => 'Full Name must not exceed 40 characters.',
            'email.required' => 'Email is required.',
            'email.regex' => 'Email must end with @gmail.com.',
            'email.unique' => 'This email is already registered.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters.',
            'password.max' => 'Password must not exceed 12 characters.',
            'phone_number.required' => 'Phone Number is required.',
            'phone_number.unique' => 'This Phone Number is already registered.',
            'phone_number.regex' => 'Phone Number must start with 08 and contain at least 10 digits.'
        ]);

        $role = $request->email === 'admin@gmail.com' ? 'admin' : 'user';

        User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'role' => $role,
        ]);

        return redirect()->route('getLogin')->with('success', 'Registration successful! Please login.');
    }

    function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Cookie::expire('email');
        return redirect('/');
    }
}
