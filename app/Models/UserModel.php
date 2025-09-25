<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserModel extends Authenticatable
{
    protected $table = 'tbl_user';
    protected $primaryKey = 'user_id'; // ตั้งให้ตรงกับชื่อจริงใน DB
    protected $fillable = ['user_name', 'user_password', 'user_email', 'user_phone','user_role', 'date_created'];
    public $incrementing = true; // ถ้า primary key เป็นตัวเลข auto increment
    public $timestamps = false;

    // ระบุ laravel
    public function getAuthPassword()
    {
        return $this->user_password;
    }

    public function likedAttractions()
{
        return $this->belongsToMany(AttractionModel::class, 'attraction_user_likes', 'user_id', 'attraction_id')->withTimestamps();
}

}
