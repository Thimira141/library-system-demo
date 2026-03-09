<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle login
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if ($request->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Login successful!',
                    'redirect' => route('dashboard-main'),
                ], 200);
            }

            // if it wasn't ajax use this redirect
            return redirect()->intended('/dashboard');
        }

        if ($request->ajax()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials',
            ], 401);
        }

        // if it wasn't ajax use this redirect
        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    /**
     * Show register form
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle registration
     */
    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|alpha_spaces',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        if ($validate->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'validateFail',
                    'errorBag' => $validate->errors()->toArray(),
                    'message' => 'Data validation failed!',
                ], 401);
            }
            return back()->withErrors($validate->errors()->toArray());
        }

        $validated = $validate->validated();

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Account created successfully!',
                'redirect' => route('login'),
            ]);
        }

        // if it wasn't ajax use this redirect
        return redirect()->route('login')->with('success', 'Account created. Please login.');
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Logged out successfully!',
                'redirect' => url('/'),
            ]);
        }

        // if it wasn't ajax use this redirect
        return redirect('/');
    }
}
