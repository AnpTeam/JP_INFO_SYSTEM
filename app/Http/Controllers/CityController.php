<?php
namespace App\Http\Controllers;

use App\Models\CityModel;                 //รับค่าจากฟอร์ม
use App\Models\RegionModel;               //form validation
use Illuminate\Http\Request;              //sweet alert
use Illuminate\Pagination\Paginator;      //สำหรับเก็บไฟล์ภาพ
use Illuminate\Support\Facades\DB;        //แบ่งหน้า
use Illuminate\Support\Facades\Storage;   // Join Database (Query)
use Illuminate\Support\Facades\Validator; //model
use RealRashid\SweetAlert\Facades\Alert;

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
        $cities = DB::table('tbl_city')
            ->join('tbl_region', 'tbl_city.region_id', '=', 'tbl_region.region_id')
            ->orderBy('city_id')
            ->paginate(5);
        return view('cities.list', compact('cities'));
    }
    public function adding()
    {
        $cities  = CityModel::orderBy('city_name')->get();
        $regions = RegionModel::orderBy('region_name')->get();
        return view('cities.create', compact('cities', 'regions'));
    }

    public function create(Request $request)
    {
        //msg
        $messages = [
            'city_name.required' => 'กรุณากรอกชื่อเมือง',
            'city_name.min'      => 'ต้องมีอย่างน้อย :min ตัวอักษร',
        ];

        //rule ตั้งขึ้นว่าจะเช็คอะไรบ้าง
        $validator = Validator::make($request->all(), [
            'city_name' => 'required|min:3',
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

        } catch (\Exception $e) {                                    //error debug
            return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
                                                                         //return view('errors.404');
        }
    } //create

    public function edit($city_id)
    {

        try {

            $cities  = CityModel::findOrFail($city_id);
            $regions = RegionModel::orderBy('region_id', 'desc')->get();

            if (isset($cities) && isset($regions)) {
                $city_id   = $cities->city_id;
                $city_name = $cities->city_name;
                $region_id = $cities->region_id;
                return view('cities.edit', compact('city_id', 'city_name', 'region_id', 'regions'));
            }
        } catch (\Exception $e) {
            return view('errors.404');
        }
    }
    // EDIT() FUNCTION END
// public function edit($city_id)
//     {
//         try {
//             $citys = CityModel::findOrFail($city_id); // ใช้ findOrFail เพื่อให้เจอหรือ 404
//             $regions = RegionModel::orderBy('region_id', 'desc')->get();
//             $citys = CityModel::orderBy('city_id')->get();

//             //ประกาศตัวแปรเพื่อส่งไปที่ view
//             if (isset($citys)  &&  isset($regions)) {
//                 $city_id = $citys->city_id;
//                 $city_name = $citys->city_name;
//                 return view('citys.edit', compact('city_id', 'city_name','region_id'));
//             }
//         } catch (\Exception $e) {
//             // return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
//             return view('errors.404');
//         }
//     } //func edit

    public function update($city_id, Request $request)
    {

        try {
            // ดึงข้อมูลสินค้าตามไอดี ถ้าไม่เจอจะ throw Exception
            $cities = CityModel::findOrFail($city_id);

            // อัปเดตชื่อสินค้า โดยใช้ strip_tags ป้องกันการแทรกโค้ด HTML/JS
            $cities->city_name = strip_tags($request->city_name);
            $cities->region_id = $request->region_id;

            // บันทึกการเปลี่ยนแปลงในฐานข้อมูล
            $cities->save();

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
            $cities = CityModel::find($city_id); //คิวรี่เช็คว่ามีไอดีนี้อยู่ในตารางหรือไม่

            if (! $city_id) { //ถ้าไม่มี
                Alert::error('City not found.');
                return redirect('city');
            }

            // ลบข้อมูลจาก DB
            $cities->delete();

            Alert::success('Delete Successfully');
            return redirect('city');

        } catch (\Exception $e) {
            Alert::error('เกิดข้อผิดพลาด: ' . $e->getMessage());
            return redirect('city');
        }
    } //remove

} //class
