<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request; //รับค่าจากฟอร์ม
use Illuminate\Support\Facades\Validator; //form validation
use RealRashid\SweetAlert\Facades\Alert; //sweet alert
use Illuminate\Support\Facades\Storage; //สำหรับเก็บไฟล์ภาพ
use Illuminate\Pagination\Paginator; //แบ่งหน้า
use App\Models\CategoryModel; //model




class CategoryController extends Controller
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

    public function index()
    {
        Paginator::useBootstrap(); // ใช้ Bootstrap pagination
        $category = CategoryModel::orderBy('category_id')->paginate(5); //order by & pagination
        //  return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
        return view('categories.list', compact('category'));
    }
    public function adding()
    {
        return view('categories.create');
    }


    public function create(Request $request)
    {
        //msg
        $messages = [
            'category_name.required' => 'กรุณากรอกชื่อหมวดหมู่',
            'category_name.min' => 'ต้องมีอย่างน้อย :min ตัวอักษร',
        ];

        //rule ตั้งขึ้นว่าจะเช็คอะไรบ้าง
        $validator = Validator::make($request->all(), [
            'category_name' => 'required|min:3',
        ], $messages);


        //ถ้าผิดกฏให้อยู่หน้าเดิม และแสดง msg ออกมา
        if ($validator->fails()) {
            return redirect('category/adding')
                ->withErrors($validator)
                ->withInput();
        }


        //ถ้ามีการอัพโหลดไฟล์เข้ามา ให้อัพโหลดไปเก็บยังโฟลเดอร์ uploads/product
        try {
            //insert เพิ่มข้อมูลลงตาราง
            CategoryModel::create([
                'category_name' => strip_tags($request->category_name),
            ]);

            //แสดง sweet alert
            Alert::success('Insert Successfully');
            return redirect('/category');

        } catch (\Exception $e) {  //error debug
            return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            //return view('errors.404');
        }
    } //create 


    public function edit($category_id)
    {
        try {
            $category = CategoryModel::findOrFail($category_id); // ใช้ findOrFail เพื่อให้เจอหรือ 404

            //ประกาศตัวแปรเพื่อส่งไปที่ view
            if (isset($category)) {
                $category_id = $category->category_id;
                $category_name = $category->category_name;
                return view('categories.edit', compact('category_id', 'category_name'));
            }
        } catch (\Exception $e) {
            // return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            return view('errors.404');
        }
    } //func edit

    public function update($category_id, Request $request)
    {

        try {
            // ดึงข้อมูลสินค้าตามไอดี ถ้าไม่เจอจะ throw Exception
            $category = CategoryModel::findOrFail($category_id);



            // อัปเดตชื่อสินค้า โดยใช้ strip_tags ป้องกันการแทรกโค้ด HTML/JS
            $category->category_name = strip_tags($request->category_name);

            // บันทึกการเปลี่ยนแปลงในฐานข้อมูล
            $category->save();

            // แสดง SweetAlert แจ้งว่าบันทึกสำเร็จ
            Alert::success('Update Successfully');

            // เปลี่ยนเส้นทางกลับไปหน้ารายการสินค้า
            return redirect('/category');

        } catch (\Exception $e) {
            //return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            return view('errors.404');

            //return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            //return view('errors.404');
        }
    } //update  



    public function remove($category_id)
    {
        try {
            $category = CategoryModel::find($category_id); //คิวรี่เช็คว่ามีไอดีนี้อยู่ในตารางหรือไม่

            if (!$category) {   //ถ้าไม่มี
                Alert::error('Category not found.');
                return redirect('category');
            }


            // ลบข้อมูลจาก DB
            $category->delete();

            Alert::success('Delete Successfully');
            return redirect('category');

        } catch (\Exception $e) {
            Alert::error('เกิดข้อผิดพลาด: ' . $e->getMessage());
            return redirect('category');
        }
    } //remove 




} //class