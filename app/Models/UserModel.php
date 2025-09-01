<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $table = 'tbl_user';
    protected $primaryKey = 'user_id'; // ตั้งให้ตรงกับชื่อจริงใน DB
    protected $fillable = ['user_name', 'user_password', 'user_email', 'user_phone','user_role', 'date_created'];
    public $incrementing = true; // ถ้า primary key เป็นตัวเลข auto increment
    public $timestamps = false;
}
