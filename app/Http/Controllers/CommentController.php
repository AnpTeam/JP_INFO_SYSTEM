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
use App\Models\CommentModel; // Comment table
use App\Models\UserModel; // User table
use App\Models\AttractionModel; // Attraction table


/** COMMENTS CONTROLLER
 *  @Usage control the backend related to comment table
 */
class CommentController extends Controller
{
    /** INDEX() FUNCTION
     *  @Usage for show list of field in database 
     *  View : comments/list.blade.php
     */
    public function index(){
        /** CONFIG TOOLS
         *  @Tools : Pagination by bootstrap
         */
        Paginator::useBootstrap(); // use Bootstrap for pagination

        /** DATABASE QUERY
         *  @SQL Syntax
         * ==========================
         *  SELECT *
         *  FROM tbl_comment
         *  JOIN tbl_user 
         *  ON tbl_comment.user_id = tbl_user.user_id
         *  JOIN tbl_attraction 
         *  ON tbl_comment.attr_id = tbl_attraction.attr_id
         *  ORDER BY comment_id ASC
         *  LIMIT 5 
         *  =============================
         *  @Fetch Variable : @comments
         *  @Tools : DB, Paginator
         */
        $comments = DB::table('tbl_comment')
            ->join('tbl_user', 'tbl_comment.user_id', '=', 'tbl_user.user_id')
            ->join('tbl_attraction', 'tbl_attraction.attr_id', '=', 'tbl_comment.attr_id')
            ->orderBy('comment_id', 'asc')
            ->paginate(5);

        /* DEBUG ZONE */
            //return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
        /* DEBUG ZONE END */

        /** RETURN VALUE
         *  Views : comments/list.blade.php
         *  @Compact Variable : $comments
         */
        return view('comments.list', compact('comments'));
    }
    // INDEX() FUNCTION END
    
    
    public function adding() {
        // User & Attraction List
        $users = UserModel::orderBy('user_name', 'asc')->get();
        $attractions = AttractionModel::orderBy('attr_name', 'asc')->get();

        return view('comments.create',compact('users','attractions'));
    }


public function create(Request $request)
{
    /* Validate Message */
    $messages = [
        'user_id.required' => 'กรุณากรอกข้อมูล',

        'comment_desc.required' => 'กรุณากรอกข้อมูล',
        'comment_desc.min' => 'ต้องมีอย่างน้อย :min ตัวอักษร',

        'attr_id.required' => 'กรุณากรอกข้อมูล',
    ];

    //rule ตั้งขึ้นว่าจะเช็คอะไรบ้าง
    $validator = Validator::make($request->all(), [
        'user_id' => 'required|min:3|',
        'comment_desc' => 'required|min:5',
        'attr_id' => 'required',
    ], $messages);
    
    //ถ้าผิดกฏให้อยู่หน้าเดิม และแสดง msg ออกมา
    if ($validator->fails()) {
        return redirect('comment/adding')
            ->withErrors($validator)
            ->withInput();
    }


    //ถ้ามีการอัพโหลดไฟล์เข้ามา ให้อัพโหลดไปเก็บยังโฟลเดอร์ uploads/product
    try {
        //insert เพิ่มข้อมูลลงตาราง
        CommentModel::create([
            'user_id' => strip_tags($request->user_id),
            'comment_desc' => strip_tags($request->comment_desc),
            'attr_id' => strip_tags($request->attr_id),
        ]);

        //แสดง sweet alert
        Alert::success('Insert Successfully');
        return redirect('/comment');

    } catch (\Exception $e) {  //error debug
        return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
        //return view('errors.404');
    }
} //create 

public function edit($id)
    {
        try {
            $comment = CommentModel::findOrFail($id); // ใช้ findOrFail เพื่อให้เจอหรือ 404

                             // User & Attraction List
        $users = UserModel::orderBy('user_name', 'asc')->get();
        $attractions = AttractionModel::orderBy('attr_name', 'asc')->get();

            //ประกาศตัวแปรเพื่อส่งไปที่ view
            if (isset($comment)) {
                $id = $comment->comment_id;
                $comment_user_id = $comment->user_id;
                $comment_desc = $comment->comment_desc;
                $comment_attr_id = $comment->attr_id;


                return view('comments.edit', compact('id', 'comment_user_id', 'comment_desc', 'comment_attr_id','users','attractions'));
            }
        } catch (\Exception $e) {
            //return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            return view('errors.404');
        }
    } //func edit

public function update($id, Request $request)
{
    // //error msg
    //  $messages = [
    //     'std_code.required' => 'กรุณากรอกข้อมูล',
    //     'std_code.min' => 'ต้องมีอย่างน้อย :min ตัวอักษร',
    //     'std_code.unique' => 'ข้อมูลซ้ำ',
    //     'std_name.required' => 'กรุณากรอกข้อมูล',
    //     'std_name.min' => 'ต้องมีอย่างน้อย :min ตัวอักษร',
    //     'std_phone.required' => 'กรุณากรอกข้อมูล',
    //     'std_phone.min' => 'ต้องมีอย่างน้อย :min ตัวอักษร',
    //     'std_phone.max' => 'ห้ามเกิน :max ตัวอักษร',
    //     'std_img.mimes' => 'รองรับ jpeg, png, jpg เท่านั้น !!',
    //     'std_img.max' => 'ขนาดไฟล์ไม่เกิน 5MB !!',
    // ];

    // // ตรวจสอบข้อมูลจากฟอร์มด้วย Validator
    // $validator = Validator::make($request->all(), [
    //     'std_code' => [
    //                 'required',
    //                 'min:3',
    //                     Rule::unique('tbl_student', 'std_code')->ignore($id, 'id'), //ห้ามแก้ซ้ำ
    //         ],
    //     'std_name' => 'required|min:5',
    //     'std_phone' => 'required|min:10|max:10',
    //     'std_img' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
    // ], $messages);

    // ถ้า validation ไม่ผ่าน ให้กลับไปหน้าฟอร์มพร้อมแสดง error และข้อมูลเดิม
    // if ($validator->fails()) {
    //     return redirect('comment/' . $id)
    //         ->withErrors($validator)
    //         ->withInput();
    // }

    try {
        // ดึงข้อมูลสินค้าตามไอดี ถ้าไม่เจอจะ throw Exception
        $comment = CommentModel::findOrFail($id);

        // อัปเดตชื่อสินค้า โดยใช้ strip_tags ป้องกันการแทรกโค้ด HTML/JS
        $comment->user_id = $request->user_id;
        // อัปเดตรายละเอียดสินค้า โดยใช้ strip_tags ป้องกันการแทรกโค้ด HTML/JS
        $comment->comment_desc = strip_tags($request->comment_desc);
        // อัปเดตราคาสินค้า
        $comment->attr_id = $request->attr_id;

        // บันทึกการเปลี่ยนแปลงในฐานข้อมูล
        $comment->save();

        // แสดง SweetAlert แจ้งว่าบันทึกสำเร็จ
        Alert::success('Update Successfully');

        // เปลี่ยนเส้นทางกลับไปหน้ารายการสินค้า
        return redirect('/comment');

    } catch (\Exception $e) {
       return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
        //return view('errors.404');
    }
} //update  



public function remove($id)
{
    try {
        $comment = CommentModel::find($id); //คิวรี่เช็คว่ามีไอดีนี้อยู่ในตารางหรือไม่

        if (!$comment) {   //ถ้าไม่มี
            Alert::error('Comment not found.');
            return redirect('comment');
        }

        // ลบข้อมูลจาก DB
        $comment->delete();

        Alert::success('Delete Successfully');
        return redirect('comment');

    } catch (\Exception $e) {
        Alert::error('เกิดข้อผิดพลาด: ' . $e->getMessage());
        return redirect('comment');
    }
} //remove 



} //class