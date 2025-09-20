<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\AdminModel;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{

    public function index()
    {

        return view('auth.login');
    }

    public function login(Request $request)
    {
        // validate input พร้อมข้อความ error
        $request->validate([
            'user_name' => 'required|max:100',
            'user_password' => 'required|string|min:3',
        ], [
            'user_name.required' => 'กรุณากรอกอีเมล',

            'user_name.max' => 'อีเมลต้องไม่เกิน 100 ตัวอักษร',
            'user_password.required' => 'กรุณากรอกรหัสผ่าน',
            'user_password.min' => 'รหัสผ่านต้องมีอย่างน้อย 3 ตัว',
        ]);

        // ตรวจสอบข้อมูลที่ส่งมา
        $credentials = $request->validate([
            'user_name' => 'required',
            'user_password' => 'required',
        ]);

        if (
            Auth::guard('web')->attempt([
                'user_name' => $credentials['user_name'],
                'password' => $credentials['user_password'],
            ])
        ) {
            // Check role after login
            $user = Auth::guard('web')->user();
            // ===== ถ้า login สำเร็จ =====

            // เพื่อความปลอดภัย Laravel จะสร้าง session ใหม่
            // ป้องกัน session fixation attack
            $request->session()->regenerate();

            // เก็บ admin_name ของคนที่ login ลงใน session
            // จะได้เรียกใช้ใน view เช่น {{ session('admin_name') }}
            session(['user_name' => Auth::guard('web')->user()->user_name]);
            session(['user_id' => Auth::guard('web')->user()->user_id]);

            if ($user->user_role === 'admin') {
                // Redirect to admin dashboard
                return redirect('/dashboard');
            } else {
                // Redirect to user dashboard
                return redirect('/');
            }
        } else {
            // ===== ถ้า login ไม่สำเร็จ =====
            return back()->withErrors([
                'user_name' => 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง',
            ])->withInput();
        }
    }


    public function logout(Request $request)
    {
        // ออกจากระบบผู้ใช้ปัจจุบัน
        Auth::logout();

        // ล้าง session ทั้งหมดเพื่อความปลอดภัย
        $request->session()->invalidate();

        // สร้าง CSRF token ใหม่ ป้องกันการโจมตีแบบ CSRF
        $request->session()->regenerateToken();

        // เปลี่ยนเส้นทางกลับไปยังหน้าแรกหลัง logout
        return redirect('/');
    }









} //class
