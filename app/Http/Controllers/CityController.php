<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request; //รับค่าจากฟอร์ม
use Illuminate\Support\Facades\Validator; //form validation
use RealRashid\SweetAlert\Facades\Alert; //sweet alert
use Illuminate\Support\Facades\Storage; //สำหรับเก็บไฟล์ภาพ
use Illuminate\Pagination\Paginator; //แบ่งหน้า
use Illuminate\Support\Facades\DB; // Join Database (Query) 
use App\Models\CityModel; //model
use App\Models\RegionModel;




class CityController extends Controller
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
        $city = CityModel::orderBy('city_id')->paginate(5); //order by & pagination
        //  return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
        $city = DB::table('tbl_city')
            ->join('tbl_region', 'tbl_city.region_id', '=', 'tbl_region.region_id')
            ->orderBy('city_id')
            ->paginate(5);
        return view('citys.list', compact('city'));
    }
    public function adding()
    {
        $region = RegionModel::orderBy('region_name')->get();
        return view('citys.create', compact('region'));
    }




    public function create(Request $request)
    {
        //msg
        $messages = [
            'city_name.required' => 'กรุณากรอกชื่อเมือง',
            'city_name.min' => 'ต้องมีอย่างน้อย :min ตัวอักษร',
        ];

        //rule ตั้งขึ้นว่าจะเช็คอะไรบ้าง
        $validator = Validator::make($request->all(), [
            'city_name' => 'required|min:3'
        ], $messages);


        //ถ้าผิดกฏให้อยู่หน้าเดิม และแสดง msg ออกมา
        if ($validator->fails()) {
            return redirect('city/adding')
                ->withErrors($validator)
                ->withInput();
        }


        //ถ้ามีการอัพโหลดไฟล์เข้ามา ให้อัพโหลดไปเก็บยังโฟลเดอร์ uploads/product
        try {
            //insert เพิ่มข้อมูลลงตาราง
            CityModel::create([
                'city_name' => strip_tags($request->city_name),
                'region_id' => $request->region_id,
            ]);

            //แสดง sweet alert
            Alert::success('Insert Successfully');
            return redirect('/city');

        } catch (\Exception $e) {  //error debug
            return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            //return view('errors.404');
        }
    } //create 


    public function edit($city_id)
    {
        try {
            $citys = CityModel::findOrFail($city_id); // ใช้ findOrFail เพื่อให้เจอหรือ 404
            $region = RegionModel::orderBy('region_id')->get();

            //ประกาศตัวแปรเพื่อส่งไปที่ view
            if (isset($city)) {
                $city_id = $city->city_id;
                $city_name = $city->city_name;
                return view('citys.edit', compact('city_id', 'city_name', 'region_id'));
            }
        } catch (\Exception $e) {
            // return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            return view('errors.404');
        }
    } //func edit

    public function update($city_id, Request $request)
    {

        try {
            // ดึงข้อมูลสินค้าตามไอดี ถ้าไม่เจอจะ throw Exception
            $city = CityModel::findOrFail($city_id);

            // อัปเดตชื่อสินค้า โดยใช้ strip_tags ป้องกันการแทรกโค้ด HTML/JS
            $city->city_name = strip_tags($request->region_name);


            // บันทึกการเปลี่ยนแปลงในฐานข้อมูล
            $city->save();

            // แสดง SweetAlert แจ้งว่าบันทึกสำเร็จ
            Alert::success('Update Successfully');

            // เปลี่ยนเส้นทางกลับไปหน้ารายการสินค้า
            return redirect('/city');

        } catch (\Exception $e) {
            //return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            return view('errors.404');

            //return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            //return view('errors.404');
        }
    } //update  



    public function remove($city_id)
    {
        try {
            $city = CityModel::find($city_id); //คิวรี่เช็คว่ามีไอดีนี้อยู่ในตารางหรือไม่

            if (!$city_id) {   //ถ้าไม่มี
                Alert::error('City not found.');
                return redirect('city');
            }

            // ลบข้อมูลจาก DB
            $city->delete();

            Alert::success('Delete Successfully');
            return redirect('city');

        } catch (\Exception $e) {
            Alert::error('เกิดข้อผิดพลาด: ' . $e->getMessage());
            return redirect('city');
        }
    } //remove 




} //class