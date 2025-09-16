<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request; //รับค่าจากฟอร์ม
use Illuminate\Support\Facades\Validator; //form validation
use RealRashid\SweetAlert\Facades\Alert; //sweet alert
use Illuminate\Support\Facades\Storage; //สำหรับเก็บไฟล์ภาพ
use Illuminate\Pagination\Paginator; //แบ่งหน้า
use App\Models\RegionModel; //model




class RegionController extends Controller
{

    public function index(){
        Paginator::useBootstrap(); // ใช้ Bootstrap pagination
        $region = RegionModel::orderBy('region_id', 'desc')->paginate(5); //order by & pagination
        //  return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
        return view('regions.list', compact('region'));
    }
     public function adding() {
        return view('regions.create');
    }


public function create(Request $request)
{
    //msg
    $messages = [
        'region_name.required' => 'กรุณากรอกชื่อภูมิภาค',
        'region_name.min' => 'ต้องมีอย่างน้อย :min ตัวอักษร',
        'region_desc.required' => 'กรุณากรอกรายละเอียดภูมิภาค',
        'region_desc.min' => 'ต้องมีอย่างน้อย :min ตัวอักษร',
        'region_thumbnail.mimes' => 'รองรับ jpeg, png, jpg เท่านั้น !!',
        'region_thumbnail.max' => 'ขนาดไฟล์ไม่เกิน 5MB !!',
    ];

    //rule ตั้งขึ้นว่าจะเช็คอะไรบ้าง
    $validator = Validator::make($request->all(), [
        'region_name' => 'required|min:3',
        'region_desc' => 'required|min:10',
        'region_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
    ], $messages);
    

    //ถ้าผิดกฏให้อยู่หน้าเดิม และแสดง msg ออกมา
    if ($validator->fails()) {
        return redirect('region/adding')
            ->withErrors($validator)
            ->withInput();
    }


    //ถ้ามีการอัพโหลดไฟล์เข้ามา ให้อัพโหลดไปเก็บยังโฟลเดอร์ uploads/product
    try {
        $imagePath = null;
        if ($request->hasFile('region_thumbnail')) {
            $imagePath = $request->file('region_thumbnail')->store('uploads/region', 'public');
        }

        //insert เพิ่มข้อมูลลงตาราง
        RegionModel::create([
            'region_name' => strip_tags($request->region_name),
            'region_desc' => strip_tags($request->region_desc),
            'region_thumbnail' => $imagePath,
        ]);

        //แสดง sweet alert
        Alert::success('Insert Successfully');
        return redirect('/region');

    } catch (\Exception $e) {  //error debug
        return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
        //return view('errors.404');
    }
} //create 


public function edit($region_id)
    {
        try {
            $region = RegionModel::findOrFail($region_id); // ใช้ findOrFail เพื่อให้เจอหรือ 404

            //ประกาศตัวแปรเพื่อส่งไปที่ view
            if (isset($region)) {
                $region_id = $region->region_id;
                $region_name = $region->region_name;
                $region_desc = $region->region_desc;
                $region_thumbnail = $region->region_thumbnail;
                return view('regions.edit', compact('region_id', 'region_name','region_desc', 'region_thumbnail'));
            }
        } catch (\Exception $e) {
            // return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            return view('errors.404');
        }
    } //func edit

public function update($region_id, Request $request)
{

    try {
        // ดึงข้อมูลสินค้าตามไอดี ถ้าไม่เจอจะ throw Exception
        $region = RegionModel::findOrFail($region_id);

        // ตรวจสอบว่ามีไฟล์รูปใหม่ถูกอัปโหลดมาหรือไม่
        if ($request->hasFile('region_thumbnail')) {
            // ถ้ามีรูปเดิมให้ลบไฟล์รูปเก่าออกจาก storage
            if ($region->product_img) {
                Storage::disk('public')->delete($region->region_thumbnail);
            }
            // บันทึกไฟล์รูปใหม่ลงโฟลเดอร์ 'uploads/product' ใน disk 'public'
            $imagePath = $request->file('region_thumbnail')->store('uploads/region', 'public');
            // อัปเดต path รูปภาพใหม่ใน model
            $region->region_thumbnail = $imagePath;
        }

        // อัปเดตชื่อสินค้า โดยใช้ strip_tags ป้องกันการแทรกโค้ด HTML/JS
        $region->region_name = strip_tags($request->region_name);
        // อัปเดตรายละเอียดสินค้า โดยใช้ strip_tags ป้องกันการแทรกโค้ด HTML/JS
        $region->region_desc = strip_tags($request->region_desc);
        // อัปเดตราคาสินค้า

        // บันทึกการเปลี่ยนแปลงในฐานข้อมูล
        $region->save();

        // แสดง SweetAlert แจ้งว่าบันทึกสำเร็จ
        Alert::success('Update Successfully');

        // เปลี่ยนเส้นทางกลับไปหน้ารายการสินค้า
        return redirect('/region');

    } catch (\Exception $e) {
       //return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
        return view('errors.404');

         //return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
        //return view('errors.404');
    }
} //update  



public function remove($region_id)
{
    try {
        $region =RegionModel::find($region_id); //คิวรี่เช็คว่ามีไอดีนี้อยู่ในตารางหรือไม่

        if (!$region) {   //ถ้าไม่มี
            Alert::error('Product not found.');
            return redirect('region');
        }

        //ถ้ามีภาพ ลบภาพในโฟลเดอร์ 
        if ($region->region_thumbnail && Storage::disk('public')->exists($region->region_thumbnail)) {
            Storage::disk('public')->delete($region->region_thumbnail);
        }

        // ลบข้อมูลจาก DB
        $region->delete();

        Alert::success('Delete Successfully');
        return redirect('region');

    } catch (\Exception $e) {
        Alert::error('เกิดข้อผิดพลาด: ' . $e->getMessage());
        return redirect('region');
    }
} //remove 




} //class