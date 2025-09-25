<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

use App\Models\UserModel;
use Illuminate\Support\Facades\Validator;

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

         // Determine whether login is email or username
        $fieldType = filter_var($request->user_name, FILTER_VALIDATE_EMAIL) ? 'user_email' : 'user_name';

        // Attempt to authenticate user using 'web' guard
        if (
            Auth::guard('web')->attempt([
                $fieldType => $credentials['user_name'],
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

    // Handle user registration
    public function registerForm(){
        return view('auth.register');
    }

    public function register(Request $request)
    {
/* DEBUG ZONE */
        // echo '<pre>';
        // dd($_POST);
        // exit();
        /* DEBUG ZONE END */

        /* Validation Message */
        $messages = [
            /** User Name
             *  @params required, min, unique
             */
            'user_name.required' => 'กรุณากรอกข้อมูลผู้ใช้',
            'user_name.min' => 'กรุณากรอกขั้นต่ำ :min ตัวอักศร',
            'user_name.unique' => 'ชื่อผู้ใช้ซ้ำ เพิ่มใหม่อีกครั้ง',

            /** User Email
             *  @params required, email, unique
             */
            'user_email.required' => 'กรุณากรอกข้อมูล',
            'user_email.email' => 'รูปแบบอีเมลไม่ถูกต้อง',
            'user_email.unique' => 'Email ซ้ำ เพิ่มใหม่อีกครั้ง',

            /** User Password
             *  @params required, min
             */
            'user_password.required' => 'กรุณากรอกข้อมูล',
            'user_password.min' => 'กรอกข้อมูลขั้นต่ำ :min ตัว',

            /** User Phone
             *  @params required, min,  max
             */
            'user_phone.required' => 'กรุณากรอกข้อมูล',
            'user_phone.min' => 'กรอกข้อมูลขั้นต่ำ :min ตัว',
            'user_phone.max' => 'กรอกข้อมูลขั้นต่ำ :max ตัว',
        ];

        /* Validation Rule */
        $validator = Validator::make($request->all(), [
            'user_name' => 'required|min:3|unique:tbl_user',
            'user_email' => 'required|email|unique:tbl_user',
            'user_password' => 'required|min:3',
            'user_phone' => 'required|min:10|max:10',
        ], $messages);

        /* Validation Checking */
        if ($validator->fails()) {
            return redirect('user/adding')
                ->withErrors($validator)
                ->withInput();
        }

        /* Processing Try/Catch */
        try {

            /* ปลอดภัย: กัน XSS ที่มาจาก <script>, <img onerror=...> ได้ */
            UserModel::create([
                'user_name' => strip_tags($request->input('user_name')),
                'user_email' => strip_tags($request->input('user_email')),
                'user_password' => bcrypt($request->input('user_password')),
                'user_phone' => strip_tags($request->input('user_phone')),
                'user_role' => strip_tags('user'),
            ]);
            /* แสดง Alert ก่อน return */
            Alert::success('เพิ่มข้อมูลสำเร็จ');
            return redirect('/user');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            /* DEBUG ZONE */
            //return view('errors.404');
            /* DEBUG ZONE END */
        }
    }
} //class