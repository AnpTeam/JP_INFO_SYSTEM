<?php
/** CONTROLLER
 *  @Usage Base class of controller (Auth, Dispatch Job(Efficiency), Validate)
 */
namespace App\Http\Controllers;

/** FORM
 *  @Usage Form controller
 *  @Consist of Request (Value from any method), Validator(Data validation), Rule(Rule for data validation) 
 */
use Illuminate\Http\Request; // Get value from form
use Illuminate\Support\Facades\Validator; // Form validation
use Illuminate\Validation\Rule; // Validation rule

/** TOOLS
 *  ＠Usage Tools for processing 
 *  @Consist of Sweet alert (Dialog), Storage (Store assets), Paginator (Fetch data in page), DB (Import SQL syntax for Database)
 */
use RealRashid\SweetAlert\Facades\Alert; //Sweet alert 
use Illuminate\Support\Facades\Storage; // Store picture in public/storage
use Illuminate\Pagination\Paginator; // Break data in to pages
use Illuminate\Support\Facades\DB; // Join Database (Query) 

/** MODELS
 *  @Usage Table Structure for CRUD process
 *  @Consist of CommentModel, UserModel, AttractionModel
 */
use App\Models\AttractionModel; // Attraction table
use App\Models\CityModel; // City table
use App\Models\CategoryModel; // Category table



/** ATTRACTION CONTROLLER
 *  @Usage control the backend related to attraction table
 */
class AttractionController extends Controller
{


    // public function __construct()
    // {
    //     // Require authentication as admin
    //     $this->middleware('auth:web');


    //     $this->middleware(function ($request, $next) {
    //         if (auth()->check() && auth()->user()->user_role === 'admin') {
    //             return $next($request);
    //         }
    //         // Redirect non-admin users to home page
    //         return redirect('/');
    //     });
    // }

    /** INDEX() FUNCTION
     *  @Usage for show list of field in database 
     *  View : attractions/list.blade.php
     */
    public function index()
    {
        /** CONFIG TOOLS
         *  @Tools : Pagination by bootstrap
         */
        Paginator::useBootstrap(); // use Bootstrap for pagination

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
        $attrs = DB::table('tbl_attraction')
            ->join('tbl_category', 'tbl_attraction.category_id', '=', 'tbl_category.category_id')
            ->join('tbl_city', 'tbl_attraction.city_id', '=', 'tbl_city.city_id')
            ->orderBy('attr_id', 'asc')
            ->paginate(5);

        /* DEBUG ZONE */
        //return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
        /* DEBUG ZONE END */

        /** RETURN VALUE
         *  Views : attractions/list.blade.php
         *  @Compact Variable : $attrs
         */
        return view('attractions.list', compact('attrs'));
    }
    // INDEX() FUNCTION END

    /** ADDING() FUNCTION
     *  @Usage for show form for create the field
     *  View : attractions/create.blade.php
     */
    public function adding()
    {
        /** DATABASE QUERY
         *  @SQL Syntax
         * ===========================
         *  SELECT *
         *  FROM tbl_city
         *  ORDER BY city_name ASC;
         * 
         *  SELECT *
         *  FROM tbl_category
         *  ORDER BY category_name ASC;
         *  =============================
         *  @Fetch Variable : $citys, $categories
         *  @Tools : Paginator, Models
         */
        $citys = CityModel::orderBy('city_name', 'asc')->get();
        $categories = CategoryModel::orderBy('category_name', 'asc')->get();

        /** RETURN VALUE
         *  Views : attractions/create.blade.php
         *  @Compact Variable : $citys, $categories
         */
        return view('attractions.create', compact('citys', 'categories'));
    }
    // ADDING() FUNCTION END

    /** CREATE() FUNCTION
     *  @Usage for show create page and insert the value 
     *  View : attractions/create.blade.php
     */
    public function create(Request $request)
    {
        /** Validate message
         *  @Dict Rule => Validate string
         *  ============================================
         *              LIST OF VALIDATION
         *  ============================================
         *  $attr_name      =>  required|min
         *  $attr_desc      =>  required|min
         *  $category_id    =>  required
         *  $attr_thumbnail =>  nullable|image|mimes|max
         */
        $messages = [
            'attr_name.required' => 'กรุณากรอกชื่อสถานที่',
            'attr_name.min' => 'ต้องมีอย่างน้อย :min ตัวอักษร',

            'attr_desc.required' => 'กรุณากรอกรายละเอียดสถานที่',
            'attr_desc.min' => 'ต้องมีอย่างน้อย :min ตัวอักษร',

            'category_id.required' => 'กรุณาเลือกประเภทสถานที่',

            'attr_thumbnail.mimes' => 'รองรับ jpeg, png, jpg เท่านั้น !!',
            'attr_thumbnail.max' => 'ขนาดไฟล์ไม่เกิน 5MB !!',
        ];

        /** Validate Rule
         *  @Attribute attr_name, attr_desc, category_id, attr_thumbnail
         *  @Tools : Validator, Request
         */
        $validator = Validator::make($request->all(), [
            'attr_name' => 'required|min:3',
            'attr_desc' => 'required|min:10',
            'category_id' => 'required',
            'attr_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ], $messages);

        /** CONDITION ON VALIDATE FAIL
         *  @Validate Fail : Views -> attractions/create.blade.php with error
         */
        if ($validator->fails()) {
            return redirect('attraction/adding')
                ->withErrors($validator)
                ->withInput();
        }

        /** TRY / CATCH METHOD
         *  @Usage Catch error on processing 
         */
        try {
            /** STORAGE IMAGE
             *  @Usage Store a image file by form that been assign on $request
             *  @Location : public/storage/uploads/attraction
             *  @Tools : Request, Storage
             */
            $imagePath = null;
            if ($request->hasFile('attr_thumbnail')) {
                $imagePath = $request->file('attr_thumbnail')->store('uploads/attraction', 'public');
            }

            /** INSERT VALUE IN DATABASE
             *  @params  $attr_name, $attr_desc, $category_id, $city_id, $attr_thumbnail
             *  @Tools : Model, Controller, Request
             */
            AttractionModel::create([
                'attr_name' => strip_tags($request->attr_name),
                'attr_desc' => strip_tags($request->attr_desc),
                'category_id' => $request->category_id,
                'city_id' => $request->city_id,
                'attr_thumbnail' => $imagePath,
            ]);

            /** ALERT SUCCESS
             *  @Usage Alert the result
             *  @Tools : Sweet alert
             *  Redirect : /attraction (attractions/list.blade.php)
             */
            Alert::success('Insert Successfully');
            return redirect('/attraction');
        }

        /** CATCH THE ERROR
         *  @Usage Return forbidden view (404)
         *  View : errors/404.blade.php
         */ catch (\Exception $e) {  //error debug
            /* DEBUG ZONE */
            // return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            /* DEBUG ZONE END */
            return view('errors.404');
        }
    }
    // CREATE() FUNCTION END

    /** EDIT() FUNCTION
     *  @Attribute : $attr_id
     *  @Usage for show edit page and insert the value 
     *  View : attractions/edit.blade.php
     */
    public function edit($attr_id)
    {
        /** TRY / CATCH METHOD
         *  @Usage Catch error on processing 
         */
        try {
            /** DATABASE QUERY
             *  @SQL Syntax
             * ===========================
             *  SELECT *
             *  FROM tbl_attraction;
             *  
             *  SELECT *
             *  FROM tbl_city
             *  ORDER BY city_id DESC;
             * 
             *  SELECT *
             *  FROM tbl_category
             *  ORDER BY category_id DESC;
             *  =============================
             *  @Fetch Variable : $attracts, $citys, $categories
             *  @Tools : Paginator, Models
             *  @If not found : View -> 404.blade.php
             */
            $attracts = AttractionModel::findOrFail($attr_id);
            $citys = CityModel::orderBy('city_id', 'desc')->get();
            $categories = CategoryModel::orderBy('category_id', 'desc')->get();

            /** CHECK VARIABLE VALUE
             *  @Usage for precess insert operation when variable is not null
             *  @params check $attracts, $citys, $categories
             *  @Insert params $attr_id, $attr_name, $category_id, $attr_desc, $attr_thumbnail, $citys, $categories
             *  Views : attractions/edit.blade.php compact with @Insert params
             */
            if (isset($attracts) && isset($citys) && isset($categories)) {
                $attr_id = $attracts->attr_id;
                $attr_name = $attracts->attr_name;
                $attr_desc = $attracts->attr_desc;
                $category_id = $attracts->category_id;
                $attr_thumbnail = $attracts->attr_thumbnail;
                return view('attractions.edit', compact('attr_id', 'attr_name', 'category_id', 'attr_desc', 'attr_thumbnail', 'citys', 'categories'));
            }
        }

        /** CATCH THE ERROR
         *  @Usage Return forbidden view (404)
         *  View : errors/404.blade.php
         */ catch (\Exception $e) {
            /* DEBUG ZONE */
            // return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            /* DEBUG ZONE END */
            return view('errors.404');
        }
    }
    // EDIT() FUNCTION END

    /** UPDATE() FUNCTION
     *  @Attribute : $attr_id
     *  @Usage for edit the value in database suppose by id
     *  View : attractions/edit.blade.php
     */
    public function update($attr_id, Request $request)
    {
        /** Validate message
         *  @Dict Rule => Validate string
         *  ============================================
         *              LIST OF VALIDATION
         *  ============================================
         *  $attr_name      =>  required|min
         *  $attr_desc      =>  required|min
         *  $category_id    =>  required
         *  $attr_thumbnail =>  nullable|image|mimes|max
         */
        $messages = [
            'attr_name.required' => 'กรุณากรอกชื่อสถานที่',
            'attr_name.min' => 'ต้องมีอย่างน้อย :min ตัวอักษร',

            'attr_desc.required' => 'กรุณากรอกรายละเอียดสถานที่',
            'attr_desc.min' => 'ต้องมีอย่างน้อย :min ตัวอักษร',

            'category_id.required' => 'กรุณาเลือกประเภทสถานที่',

            'attr_thumbnail.mimes' => 'รองรับ jpeg, png, jpg เท่านั้น !!',
            'attr_thumbnail.max' => 'ขนาดไฟล์ไม่เกิน 5MB !!',
        ];

        /** Validate Rule
         *  @Attribute attr_name, attr_desc, category_id, attr_thumbnail
         *  @Tools : Validator, Request
         */
        $validator = Validator::make($request->all(), [
            'attr_name' => 'required|min:3',
            'attr_desc' => 'required|min:10',
            'category_id' => 'required',
            'attr_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ], $messages);

        /** CONDITION ON VALIDATE FAIL
         *  @Validate Fail : Views -> attractions/edit.blade.php with error
         */
        if ($validator->fails()) {
            return redirect('attraction/' . $attr_id)
                ->withErrors($validator)
                ->withInput();
        }

        /** TRY / CATCH METHOD
         *  @Usage Catch error on processing 
         */
        try {
            /** DATABASE QUERY
             *  @SQL Syntax
             * ===========================
             *  SELECT *
             *  FROM tbl_attraction
             *  WHERE attr_id = $attr_id;
             *  =============================
             *  @Fetch Variable : $attracts
             *  @Tools : Models
             */
            $attracts = AttractionModel::findOrFail($attr_id);

            /** DELETE THE OLD STORAGE FILE | STORE A NEW FILE
             *  @params attr_thumbnail
             *  @Tools : Request, Controller
             *  @Path : public/storage/uploads/attraction/[File Name]
             */
            if ($request->hasFile('attr_thumbnail')) {
                /** VALIDATE THE OLD FILE & DELETE
                 *  @Usage for delete file
                 *  @params attr_thumbnail
                 *  Tools : Controller
                 */
                if ($attracts->attr_thumbnail) {
                    Storage::disk('public')->delete($attracts->attr_thumbnail);
                }

                /** VALIDATE THE NEW FILE & STORE
                 *  @Usage for store a file
                 *  @params attr_thumbnail
                 *  Tools : Controller
                 */
                $imagePath = $request->file('attr_thumbnail')->store('uploads/attraction', 'public');

                /** DATABASE QUERY
                 *  @SQL Syntax
                 * ===========================
                 *  UPDATE tbl_attraction
                 *  SET attr_thumbnail = $imagepath
                 *  WHERE attr_id = $attr_id;
                 *  =============================
                 *  @Tools : Models
                 */
                $attracts->attr_thumbnail = $imagePath;
            }

            /** DATABASE QUERY
             *  @SQL Syntax
             * ===========================
             *  UPDATE tbl_attraction
             *  SET attr_name   = $attr_name,
             *      attr_desc   = $attr_desc,
             *      category_id = $category_id,
             *      city_id     = $city_id
             *  WHERE attr_id = $attr_id;
             *  =============================
             *  @Tools : Models
             */
            $attracts->attr_name = strip_tags($request->attr_name);
            $attracts->attr_desc = strip_tags($request->attr_desc);
            $attracts->category_id = $request->category_id;
            $attracts->city_id = $request->city_id;
            $attracts->save();

            /** ALERT SUCCESS
             *  @Usage Alert the result
             *  @Tools : Sweet alert
             *  Redirect : /attraction (attractions/list.blade.php)
             */
            Alert::success('Update Successfully');
            return redirect('/attraction');
        }

        /** CATCH THE ERROR
         *  @Usage Return forbidden view (404)
         *  View : errors/404.blade.php
         */ catch (\Exception $e) {
            /* DEBUG ZONE */
            // return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            /* DEBUG ZONE END */
            return view('errors.404');
        }
    }
    // UPDATE() FUNCTION END 

    /** REMOVE() FUNCTION
     *  @Attribute : $attr_id
     *  @Usage for delete field in database suppose by id
     *  View : attractions/list.blade.php
     */
    public function remove($attr_id)
    {
        /** TRY / CATCH METHOD
         *  @Usage Catch error on processing 
         */
        try {
            /** DATABASE QUERY
             *  @SQL Syntax
             * ===========================
             *  SELECT *
             *  FROM tbl_attraction
             *  WHERE attr_id = $attr_id;
             *  =============================
             *  @Fetch Variable : $attracts
             *  @Tools : Models
             */
            $attr = AttractionModel::find($attr_id);

            /** VALIDATE THE VARIABLE WHEN IS NULL
             *  @params $attrs
             *  Tools : Controller
             *  Views : attractions/list.blade.php
             */
            if (!$attr) {
                Alert::error('Product not found.');
                return redirect('attraction');
            }

            /** DELETE THE OLD STORAGE FILE
             *  @params attr_thumbnail
             *  @Tools : Request, Controller
             *  @Path : public/storage/uploads/attraction/[File Name]
             */
            if ($attr->attr_thumbnail && Storage::disk('public')->exists($attr->attr_thumbnail)) {
                Storage::disk('public')->delete($attr->attr_thumbnail);
            }

            /** DATABASE QUERY
             *  @SQL Syntax
             * ===========================
             *  DELETE FROM tbl_attraction
             *  WHERE attr_id = $attr_id;
             *  =============================
             *  @Tools : Models
             */
            $attr->delete();

            /** ALERT SUCCESS
             *  @Usage Alert the result
             *  @Tools : Sweet alert
             *  Redirect : /attraction (attractions/list.blade.php)
             */
            Alert::success('Delete Successfully');
            return redirect('attraction');
        }
        /** CATCH THE ERROR
         *  @Usage Return table view with error
         *  View : list.blade,php
         */ catch (\Exception $e) {
            Alert::error('เกิดข้อผิดพลาด: ' . $e->getMessage());
            return redirect('attraction');
        }
    }
    // REMOVE() FUNCTION END
}
// CLASS END