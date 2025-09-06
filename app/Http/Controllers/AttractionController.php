<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request; //รับค่าจากฟอร์ม
use Illuminate\Support\Facades\Validator; //form validation
use RealRashid\SweetAlert\Facades\Alert; //sweet alert
use Illuminate\Support\Facades\Storage; //สำหรับเก็บไฟล์ภาพ
use Illuminate\Pagination\Paginator; //แบ่งหน้า
use Illuminate\Support\Facades\DB; // JOIN
use App\Models\AttractionModel; //model
use App\Models\CityModel; //model
use App\Models\CategoryModel; //model




class AttractionController extends Controller
{

    public function index(){
        Paginator::useBootstrap(); // ใช้ Bootstrap pagination
        // $attrs = AttractionModel::orderBy('attr_id', 'desc')->paginate(5); //order by & pagination
        // JOIN TABLE CATEGORY
        $attrs = DB::table('tbl_attraction')
            ->join('tbl_category', 'tbl_attraction.category_id', '=', 'tbl_category.category_id')
            ->join('tbl_city', 'tbl_attraction.city_id', '=', 'tbl_city.city_id')
            ->orderBy('attr_id', 'asc')
            ->paginate(5);

        //  return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
        return view('attractions.list', compact('attrs'));
    }
     public function adding() {
        // City & Category List
        $citys = CityModel::orderBy('city_id', 'desc')->get();
        $categories = CategoryModel::orderBy('category_id', 'desc')->get();

        return view('attractions.create',compact('citys','categories'));
    }


public function create(Request $request)
{
    //msg
    $messages = [
        'attr_name.required' => 'กรุณากรอกชื่อสถานที่',
        'attr_name.min' => 'ต้องมีอย่างน้อย :min ตัวอักษร',

        'attr_desc.required' => 'กรุณากรอกรายละเอียดสถานที่',
        'attr_desc.min' => 'ต้องมีอย่างน้อย :min ตัวอักษร',

        'attr_thumbnail.mimes' => 'รองรับ jpeg, png, jpg เท่านั้น !!',
        'attr_thumbnail.max' => 'ขนาดไฟล์ไม่เกิน 5MB !!',
    ];

    //rule ตั้งขึ้นว่าจะเช็คอะไรบ้าง
    $validator = Validator::make($request->all(), [
        'attr_name' => 'required|min:3',
        'attr_desc' => 'required|min:10',
        'attr_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
    ], $messages);
    

    //ถ้าผิดกฏให้อยู่หน้าเดิม และแสดง msg ออกมา
    if ($validator->fails()) {
        return redirect('attraction/adding')
            ->withErrors($validator)
            ->withInput();
    }


    //ถ้ามีการอัพโหลดไฟล์เข้ามา ให้อัพโหลดไปเก็บยังโฟลเดอร์ uploads/product
    try {
        $imagePath = null;
        if ($request->hasFile('attr_thumbnail')) {
            $imagePath = $request->file('attr_thumbnail')->store('uploads/attraction', 'public');
        }

        //insert เพิ่มข้อมูลลงตาราง
        AttractionModel::create([
            'attr_name' => strip_tags($request->attr_name),
            'attr_desc' => strip_tags($request->attr_desc),
            'category_id' =>$request->category_id,
            'city_id' => $request->city_id,
            'attr_thumbnail' => $imagePath,
        ]);

        //แสดง sweet alert
        Alert::success('Insert Successfully');
        return redirect('/attraction');

    } catch (\Exception $e) {  //error debug
        return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
        //return view('errors.404');
    }
} //create 


public function edit($attr_id)
    {
        try {
            $attracts = AttractionModel::findOrFail($attr_id); // ใช้ findOrFail เพื่อให้เจอหรือ 404

            $citys = CityModel::orderBy('city_id', 'desc')->get();
            $categories = CategoryModel::orderBy('category_id', 'desc')->get();

            //ประกาศตัวแปรเพื่อส่งไปที่ view
            if (isset($attracts) &&  isset($citys) && isset($categories)){
                $attr_id = $attracts->attr_id;
                $attr_name = $attracts->attr_name;
                $attr_desc = $attracts->attr_desc;
                $category_id = $attracts->category_id;
                $attr_thumbnail = $attracts->attr_thumbnail;
                return view('attractions.edit', compact('attr_id', 'attr_name', 'category_id', 'attr_desc', 'attr_thumbnail','citys','categories'));
            }
        } catch (\Exception $e) {
            // return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            return view('errors.404');
        }
    } //func edit

public function update($attr_id, Request $request)
{
    //msg
    $messages = [
        'attr_name.required' => 'กรุณากรอกชื่อสถานที่',
        'attr_name.min' => 'ต้องมีอย่างน้อย :min ตัวอักษร',

        'attr_desc.required' => 'กรุณากรอกรายละเอียดสถานที่',
        'attr_desc.min' => 'ต้องมีอย่างน้อย :min ตัวอักษร',
        
        'attr_thumbnail.mimes' => 'รองรับ jpeg, png, jpg เท่านั้น !!',
        'attr_thumbnail.max' => 'ขนาดไฟล์ไม่เกิน 5MB !!',
    ];

    //rule ตั้งขึ้นว่าจะเช็คอะไรบ้าง
    $validator = Validator::make($request->all(), [
        'attr_name' => 'required|min:3',
        'attr_desc' => 'required|min:10',
        'attr_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
    ], $messages);
    

    //ถ้าผิดกฏให้อยู่หน้าเดิม และแสดง msg ออกมา
    if ($validator->fails()) {
        return redirect('attraction/' . $attr_id)
            ->withErrors($validator)
            ->withInput();
    }

    try {
        // ดึงข้อมูลสินค้าตามไอดี ถ้าไม่เจอจะ throw Exception
        $attracts = AttractionModel::findOrFail($attr_id);

        // ตรวจสอบว่ามีไฟล์รูปใหม่ถูกอัปโหลดมาหรือไม่
        if ($request->hasFile('attr_thumbnail')) {
            // ถ้ามีรูปเดิมให้ลบไฟล์รูปเก่าออกจาก storage
            if ($attracts->product_img) {
                Storage::disk('public')->delete($attracts->attr_thumbnail);
            }
            // บันทึกไฟล์รูปใหม่ลงโฟลเดอร์ 'uploads/product' ใน disk 'public'
            $imagePath = $request->file('attr_thumbnail')->store('uploads/product', 'public');
            // อัปเดต path รูปภาพใหม่ใน model
            $attracts->attr_thumbnail = $imagePath;
        }

        // อัปเดตชื่อสินค้า โดยใช้ strip_tags ป้องกันการแทรกโค้ด HTML/JS
        $attracts->attr_name = strip_tags($request->attr_name);
        // อัปเดตรายละเอียดสินค้า โดยใช้ strip_tags ป้องกันการแทรกโค้ด HTML/JS
        $attracts->attr_desc = strip_tags($request->attr_desc);
        // อัปเดตราคาสินค้า
        $attracts->category_id = $request->category_id;
        // อัปเดตราคาสินค้า
        $attracts->city_id = $request->city_id;

        // บันทึกการเปลี่ยนแปลงในฐานข้อมูล
        $attracts->save();

        // แสดง SweetAlert แจ้งว่าบันทึกสำเร็จ
        Alert::success('Update Successfully');

        // เปลี่ยนเส้นทางกลับไปหน้ารายการสินค้า
        return redirect('/attraction');

    } catch (\Exception $e) {
       //return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
        return view('errors.404');

         //return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
        //return view('errors.404');
    }
} //update  



public function remove($attr_id)
{
    try {
        $attr = AttractionModel::find($attr_id); //คิวรี่เช็คว่ามีไอดีนี้อยู่ในตารางหรือไม่

        if (!$attr) {   //ถ้าไม่มี
            Alert::error('Product not found.');
            return redirect('attraction');
        }

        //ถ้ามีภาพ ลบภาพในโฟลเดอร์ 
        if ($attr->attr_thumbnail && Storage::disk('public')->exists($attr->attr_thumbnail)) {
            Storage::disk('public')->delete($attr->attr_thumbnail);
        }

        // ลบข้อมูลจาก DB
        $attr->delete();

        Alert::success('Delete Successfully');
        return redirect('attraction');

    } catch (\Exception $e) {
        Alert::error('เกิดข้อผิดพลาด: ' . $e->getMessage());
        return redirect('attraction');
    }
} //remove 




} //class