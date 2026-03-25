<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Manual auth check because User model auto-hashes passwords
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'No account found with this email'])->withInput();
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['email' => 'Incorrect password'])->withInput();
        }

        Auth::login($user, $request->boolean('remember'));

        if (!Auth::check()) {
            return back()->withErrors(['email' => 'Login failed - session error'])->withInput();
        }

        return redirect('/admin');
    }

    public function showRegister(Request $request)
    {
        return view('auth.register', ['ref' => $request->query('ref')]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'nullable|string',
            'country' => 'nullable|string',
        ]);

        $data = $request->only('name', 'email', 'password', 'phone', 'country');
        $data['role'] = 'user';

        // Handle referral
        if ($request->filled('referral_code')) {
            $referrer = User::where('referral_code', $request->referral_code)->first();
            if ($referrer) {
                $data['referred_by'] = $referrer->id;
            }
        }

        $user = User::create($data);
        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Account created successfully!');
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('home');
    }
}
