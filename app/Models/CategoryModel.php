<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    protected $table = 'tbl_category';
    protected $primaryKey = 'category_id'; // ตั้งให้ตรงกับชื่อจริงใน DB
    protected $fillable = ['category_name'];
    public $incrementing = true; // ถ้า primary key เป็นตัวเลข auto increment
    public $timestamps = false;
}
