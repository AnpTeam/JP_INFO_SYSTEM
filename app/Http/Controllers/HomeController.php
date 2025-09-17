<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request; //รับค่าจากฟอร์ม
use Illuminate\Support\Facades\Validator; //form validation
use RealRashid\SweetAlert\Facades\Alert; //sweet alert
use Illuminate\Support\Facades\Storage; //สำหรับเก็บไฟล์ภาพ
use Illuminate\Pagination\Paginator; //แบ่งหน้า
use App\Models\AttractionModel; //model
use App\Models\CityModel; //model
use App\Models\RegionModel; //model
use Illuminate\Support\Facades\DB;



class HomeController extends Controller
{

    public function index(){
        /** CONFIG TOOLS
         *  @Tools : Pagination by bootstrap
         */
        Paginator::useBootstrap(); 

        /** DATABASE QUERY
         *  @SQL Syntax
         * ==========================
         *  SELECT *
         *  FROM tbl_attraction 
         *  =============================
         *  @Fetch Variable : $attrs
         *  @Tools : DB, Paginator
         */
        $attrs = AttractionModel::orderBy('like_count', 'desc')->get(); //order by & pagination
        $topThree = AttractionModel::orderBy('like_count', 'desc')->limit(3)->get(); //order by & pagination
        /** DATABASE QUERY
         *  @SQL Syntax
         * ==========================
         *  SELECT *
         *  FROM tbl_region
         *  =============================
         *  @Fetch Variable : $regions
         *  @Tools : DB, Paginator
         */
        $regions = RegionModel::orderBy('region_id', 'desc')->get(); //order by & pagination

                /** DATABASE QUERY
         *  @SQL Syntax
         * ==========================
         *  SELECT *
         *  FROM tbl_city
         *  =============================
         *  @Fetch Variable : $cats
         *  @Tools : DB, Paginator
         */
        $citys = CityModel::orderBy('city_id', 'desc')->get(); //order by & pagination

        return view('home.attraction_index',compact('attrs','citys','regions','topThree'));
    }

    public function searchAttraction(Request $request) {

    // print_r($_GET);

    // exit;
 
    Paginator::useBootstrap(); // ใช้ Bootstrap pagination
 
    $keyword = $request->keyword;
    $region = $request->region;
    $city = $request->city;

/** DATABASE QUERY
             *  @SQL Syntax
             * ==========================
             *  SELECT *
             *  FROM tbl_attraction
             *  JOIN tbl_category 
             *  ON tbl_attraction.category_id = tbl_category.category_id
             *  JOIN tbl_city
             *  ON tbl_attraction.city_id = tbl_city.city_id
             *  ORDER BY attr_id ASC
             *  LIMIT 5 
             *  =============================
             *  @Fetch Variable : $attrs
             *  @Tools : DB, Paginator
             */
$query = AttractionModel::query()
    ->join('tbl_city', 'tbl_attraction.city_id', '=', 'tbl_city.city_id')
    ->join('tbl_region', 'tbl_city.region_id', '=', 'tbl_region.region_id');





// Apply filters conditionally
if (!empty($keyword)) {
    $query->where('attr_name', 'like', "%{$keyword}%");
}

if (!empty($region)) {
    $query->where('tbl_region.region_id', $region);
}

if (!empty($city)) {
   $query->where('tbl_city.city_id', $city);
}

// Run the query with pagination
$attrs = $query->paginate(8);

// Count total results
$count = $attrs->Total(); // use total(), not count() when paginating
 
    return view('home.attraction_search', compact('attrs', 'keyword','count','city','region'));

} // searchattrs
} //class