<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    // Show the login page
    public function index()
    {
        return view('auth.login');
    }

    // Handle login form submission
    public function login(Request $request)
    {
        // Validate input fields with custom error messages
        $request->validate([
            'user_name' => 'required|max:100',
            'user_password' => 'required|string|min:3',
        ], [
            'user_name.required' => 'กรุณากรอกอีเมล',
            'user_name.max' => 'อีเมลต้องไม่เกิน 100 ตัวอักษร',
            'user_password.required' => 'กรุณากรอกรหัสผ่าน',
            'user_password.min' => 'รหัสผ่านต้องมีอย่างน้อย 3 ตัว',
        ]);

        // Validate credentials again (redundant but ensures both fields are present)
        $credentials = $request->validate([
            'user_name' => 'required',
            'user_password' => 'required',
        ]);

        // Attempt to authenticate user using 'web' guard
        if (
            Auth::guard('web')->attempt([
                'user_name' => $credentials['user_name'],
                'password' => $credentials['user_password'],
            ])
        ) {
            // Get the authenticated user
            $user = Auth::guard('web')->user();

            // Regenerate session to prevent session fixation attacks
            $request->session()->regenerate();

            // Store user information in session for later use in views
            session(['user_name' => $user->user_name]);
            session(['user_id' => $user->user_id]);
            session(['user_email' => $user->user_email]);

            // Show success alert
            Alert::success('Logged In', 'You have been successfully logged in.');

            // Redirect based on user role
            if ($user->user_role === 'admin') {
                // Redirect admin to dashboard
                return redirect('/user');
            } else {
                // Redirect regular user to home page
                return redirect('/');
            }
        } else {
            // If authentication fails, redirect back with error
            return back()->withErrors([
                'user_name' => 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง',
            ])->withInput();
        }
    }

    // Handle user logout
    public function logout(Request $request)
    {
        // Log out the user
        Auth::logout();

        // Invalidate the session and regenerate CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Show logout success alert
        Alert::success('Logged Out', 'You have been successfully logged out.');
        // Redirect to home page
        return redirect('/');
    }
} //class