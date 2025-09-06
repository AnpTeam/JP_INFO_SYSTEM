<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CityModel extends Model
{
    protected $table = 'tbl_city';
    protected $primaryKey = 'city_id'; // ตั้งให้ตรงกับชื่อจริงใน DB
    protected $fillable = ['city_name', 'region_id'];
    public $incrementing = true; // ถ้า primary key เป็นตัวเลข auto increment
    public $timestamps = false;
}
