<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegionModel extends Model
{
    protected $table = 'tbl_region';
    protected $primaryKey = 'region_id'; // ตั้งให้ตรงกับชื่อจริงใน DB
    protected $fillable = ['region_name', 'region_desc','region_thumbnail'];
    public $incrementing = true; // ถ้า primary key เป็นตัวเลข auto increment
    public $timestamps = false;
}
