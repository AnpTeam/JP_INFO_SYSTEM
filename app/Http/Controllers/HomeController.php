<?php
namespace App\Http\Controllers;

use App\Models\AttractionModel;           //รับค่าจากฟอร์ม
use App\Models\CityModel;                 //form validation
use App\Models\RegionModel;               //sweet alert
use App\Models\CommentModel;
use Illuminate\Http\Request;              //สำหรับเก็บไฟล์ภาพ
use Illuminate\Pagination\Paginator;      //แบ่งหน้า
use Illuminate\Support\Facades\DB;       //model
use Illuminate\Support\Facades\Validator; //ตรวจสอบข้อมูล
use RealRashid\SweetAlert\Facades\Alert; //sweet alert

class HomeController extends Controller
{

    public function index()
    {
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
        $attrs = DB::table('tbl_attraction')
            ->join('tbl_city', 'tbl_attraction.city_id', '=', 'tbl_city.city_id')
            ->join('tbl_region', 'tbl_city.region_id', '=', 'tbl_region.region_id')
            ->join('tbl_category', 'tbl_attraction.category_id', '=', 'tbl_category.category_id')
            ->select(
                'tbl_attraction.*',
                'tbl_city.city_name',
                'tbl_region.region_name',
                'tbl_category.category_name'
            )
            ->orderBy('tbl_attraction.attr_id', 'desc')
            ->paginate(8);

        $likesSubquery = DB::table('attraction_user_likes')
            ->select('attraction_id', DB::raw('COUNT(user_id) as like_count'))
            ->groupBy('attraction_id');

        $topThree = DB::table('tbl_attraction as a')
            ->joinSub($likesSubquery, 'likes', function ($join) {
                $join->on('a.attr_id', '=', 'likes.attraction_id');
            })
            ->orderByDesc('likes.like_count')
            ->limit(3)
            ->get(); // ดึงแค่ 3 อันดับแรก

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

        return view('home.attraction_index', compact('attrs', 'citys', 'regions', 'topThree'));
    }

    public function searchAttraction(Request $request)
    {

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

        return view('home.attraction_search', compact('attrs', 'keyword', 'count', 'city', 'region'));

    } // searchattrs

    public function searchRegion(Request $request)
    {

        // print_r($_GET);

        // exit;

        Paginator::useBootstrap(); // ใช้ Bootstrap pagination

        $keyword = $request->keyword;

        /** DATABASE QUERY
         *  @SQL Syntax
         * ==========================
         *  SELECT *
         *  FROM tbl_region
         *  =============================
         *  @Fetch Variable : $attrs
         *  @Tools : DB, Paginator
         */
        $query = RegionModel::query();

        // Apply filters conditionally
        if (!empty($keyword)) {
            $query->where('region_name', 'like', "%{$keyword}%");
        }
        // Run the query with pagination
        $regions = $query->paginate(8);

        // Count total results
        $count = $regions->Total(); // use total(), not count() when paginating

        return view('home.region_search', compact('regions', 'keyword', 'count'));

    } // searchattrs


    public function detailAttraction($id)
    {
        // count view
        DB::table('tbl_counter')->insert([
            'attr_id' => $id,
            'c_date' => now()
        ]);

        try {
            $attr = DB::table('tbl_attraction')
                ->join('tbl_city', 'tbl_attraction.city_id', '=', 'tbl_city.city_id')
                ->join('tbl_region', 'tbl_city.region_id', '=', 'tbl_region.region_id')
                ->join('tbl_category', 'tbl_attraction.category_id', '=', 'tbl_category.category_id')
                ->where('tbl_attraction.attr_id', $id)
                ->select(
                    'tbl_attraction.*',
                    'tbl_city.city_name',
                    'tbl_region.region_name',
                    'tbl_category.category_name'
                )
                ->first();

            $comments = DB::table('tbl_comment')
                ->join('tbl_user', 'tbl_comment.user_id', '=', 'tbl_user.user_id')
                ->where('attr_id', $id)
                ->orderBy('tbl_comment.date_created', 'desc')
                ->get();

            $commentCount = $comments->count();

            $attractions = AttractionModel::with('likes')->get();


            //ประกาศตัวแปรเพื่อส่งไปที่ view
            if (isset($attr)) {
                $attr_id = $attr->attr_id;
                $attr_name = $attr->attr_name;
                $attr_desc = $attr->attr_desc;
                $region_name = $attr->region_name;
                $category_name = $attr->category_name;
                $city_name = $attr->city_name;
                $attr_thumbnail = $attr->attr_thumbnail;

                return view('home.attraction_detail', compact('attr_id', 'attr_name', 'attr_desc', 'region_name', 'category_name', 'city_name', 'attr_thumbnail', 'comments', 'commentCount', 'attractions'));
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            // return view('errors.404');
            // return redirect('/');
        }
    } // detailattrs

    public function detailRegion($id)
    {
        try {
            $region = RegionModel::findOrFail($id);


            //ประกาศตัวแปรเพื่อส่งไปที่ view
            if (isset($region)) {
                $region_id = $region->region_id;
                $region_name = $region->region_name;
                $region_desc = $region->region_desc;
                $region_thumbnail = $region->region_thumbnail;

                return view('home.region_detail', compact('region_id', 'region_name', 'region_desc', 'region_thumbnail'));
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            // return view('errors.404');
            // return redirect('/');
        }
    } // detailRegion

    public function addComment(Request $request)
    {
        try {
            //insert เพิ่มข้อมูลลงตาราง
            CommentModel::create([
                'user_id' => strip_tags($request->user_id),
                'comment_desc' => strip_tags($request->comment_desc),
                'attr_id' => strip_tags($request->attr_id),
            ]);

            return redirect()->back();

        } catch (\Exception $e) {  //error debug
            return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            //return view('errors.404');
        }
    } // addComment

} //class