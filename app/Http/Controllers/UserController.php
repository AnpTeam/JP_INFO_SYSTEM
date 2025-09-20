<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\UserModel;
use Illuminate\Pagination\Paginator;

class UserController extends Controller
{

    public function __construct()
    {
        // Require authentication as admin
        $this->middleware('auth:web');


        $this->middleware(function ($request, $next) {
            if (auth()->check() && auth()->user()->user_role === 'admin') {
                return $next($request);
            }
            // Redirect non-admin users to home page
            return redirect('/');
        });
    }

    /** INDEX FUNCTION
     *  @USAGE : GET INDEX PAGE OF USER MANAGEMENT VIEWS
     */
    public function index()
    {
        /* Processing Try/Catch */
        try {
            Paginator::useBootstrap();
            $UserList = UserModel::orderBy('user_id', 'desc')->paginate(10); //order by & pagination
            return view('user.list', compact('UserList'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            /* DEBUG ZONE */
            //return view('errors.404');
            /* DEBUG ZONE END */
        }
    }
    /* INDEX FUNCTIOMN END */

    /** ADDING FUNCTION
     *  @USAGE : GET ADD PAGE OF USER MANAGEMENT VIEWS
     */
    public function adding()
    {
        return view('user.create');
    }

    /** CREATE FUNCTION
     *  @USAGE : BACKEND OF ADDING CRUD (Create)
     */
    public function create(Request $request)
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
                'user_role' => strip_tags($request->input('user_role')),
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
    /* CREATE FUNCTION END */


    /** EDIT FUNCTION
     *  @USAGE : GET EDIT PAGE OF USER MANAGEMENT VIEWS
     */
    public function edit($user_id)
    {
        /* Processing Try/Catch */
        try {
            /* query data for form edit */
            $test = UserModel::findOrFail($user_id); // ใช้ findOrFail เพื่อให้เจอหรือ 404
            if (isset($test)) {
                $user_id = $test->user_id;
                $user_name = $test->user_name;
                $user_phone = $test->user_phone;
                $user_email = $test->user_email;
                return view('user.edit', compact('user_id', 'user_name', 'user_phone', 'user_email'));
            }
        } catch (\Exception $e) {
            /* DEBUG ZONE */
            //return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            /* DEBUG ZONE END */
            return view('errors.404');
        }
    }
    /* EDIT FUNCTION END */

    /** UPDATE FUNCTION
     *  @USAGE : BACKEND OF UPDATE CRUD (UPDATE)
     */
    public function update($user_id, Request $request)
    {
        /* Validation Message */
        $messages = [
            /** User Name
             *  @params required, min, unique
             */
            'user_name.required' => 'กรุณากรอกข้อมูล',
            'user_name.min' => 'กรุณากรอกขั้นต่ำ :min ข้อมูล',
            'user_name.unique' => 'ชื่อผู้ใช้ซ้ำ เพิ่มใหม่อีกครั้ง',

            /** User Email
             *  @params required, email, unique
             */
            'user_email.required' => 'กรุณากรอกข้อมูล',
            'user_email.email' => 'รูปแบบอีเมลไม่ถูกต้อง',
            'user_email.unique' => 'Email ซ้ำ เพิ่มใหม่อีกครั้ง',

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
            'user_phone' => 'required|min:10|max:10',
        ], $messages);

        /* Validation Checking */
        if ($validator->fails()) {
            return redirect('user/' . $user_id)
                ->withErrors($validator)
                ->withInput();
        }
        /* Processing Try/Catch */
        try {
            $user = UserModel::find($user_id);
            $user->update([
                'user_name' => strip_tags($request->input('user_name')),
                'user_email' => strip_tags($request->input('user_email')),
                'user_phone' => strip_tags($request->input('user_phone')),
            ]);
            // แสดง Alert ก่อน return
            Alert::success('ปรับปรุงข้อมูลสำเร็จ');
            return redirect('/user');
        } catch (\Exception $e) {
            /* DEBUG ZONE */
            // return response()->json(['error' => $e->getMessage()], 500);
            /* DEBUG ZONE END */
            return view('errors.404');
        }
    }
    /* UPDATE FUNCTION END */

    /** REMOVE FUNCTION
     *  @USAGE : BACKEND OF DELETE CRUD (DELETE)
     */
    public function remove($user_id)
    {
        /* Processing Try/Catch */
        try {
            $user = UserModel::find($user_id);  //query หาว่ามีไอดีนี้อยู่จริงไหม 
            $user->delete();
            Alert::success('ลบข้อมูลสำเร็จ');
            return redirect('/user');
        } catch (\Exception $e) {
            //return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            return view('errors.404');
        }
    }
    /* REMOVE FUNCTION END */

    /** RESET FUNCTION 
     *  @USAGE : GET RESET PASSWORD PAGE OF USER MANAGEMENT VIEWS
     */
    public function reset($user_id)
    {
        /* Processing Try/Catch */
        try {
            //query data for form edit 
            $user = UserModel::findOrFail($user_id); // ใช้ findOrFail เพื่อให้เจอหรือ 404
            if (isset($user)) {

                $user_id = $user->user_id;
                $user_name = $user->user_name;
                $user_email = $user->user_email;

                return view('user.editPassword', compact('user_id', 'user_name', 'user_email'));
            }
        } catch (\Exception $e) {
            //return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            return view('errors.404');
        }
    }
    /* RESET FUNCTION END */

    /** RESET PASSWORD FUNCTION
     *  @USAGE : BACKEND OF UPDATE PASSWORD CRUD (UPDATE)
     */
    public function resetPassword($user_id, Request $request)
    {
        /* Validate Message */
        $messages = [
            'user_password.required' => 'กรุณากรอกข้อมูล',
            'user_password.min' => 'กรอกข้อมูลขั้นต่ำ :min ตัวอักษร',
            'user_password.confirmed' => 'รหัสผ่านไม่ตรงกัน',

            'password_confirmation.required' => 'กรุณากรอกข้อมูล',
            'user_password_confirmation.min' => 'กรอกข้อมูลขั้นต่ำ :min ตัว',
        ];

        /* Validate Rule */
        $validator = Validator::make($request->all(), [
            'user_password' => 'required|min:3|confirmed',
            'user_password_confirmation' => 'required|min:3',
        ], $messages);

        /* Validate Checking */
        if ($validator->fails()) {
            return redirect('user/reset/' . $user_id)
                ->withErrors($validator)
                ->withInput();
        }

        /* Processing Try/Catch */
        try {
            $user = UserModel::find($user_id);
            $user->update([
                'user_password' => bcrypt($request->input('user_password')),
            ]);
            // แสดง Alert ก่อน return
            Alert::success('แก้ไขรหัสผ่านสำเร็จ');
            return redirect('/user');
        } catch (\Exception $e) {
            /* DEBUG ZONE */
            // return response()->json(['error' => $e->getMessage()], 500);
            /* DEBUG ZONE END */
            return view('errors.404');
        }
    }
    /* RESET PASSWORD FUNCTION END */
}
/* CLASS END */
