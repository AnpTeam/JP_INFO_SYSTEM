<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttractionModel extends Model
{
    protected $table = 'tbl_attraction';
    protected $primaryKey = 'attr_id'; // ตั้งให้ตรงกับชื่อจริงใน DB
    protected $fillable = ['attr_name', 'attr_thumbnail', 'attr_desc', 'category_id', 'like_count', 'city_id', 'date_created'];
    public $incrementing = true; // ถ้า primary key เป็นตัวเลข auto increment
    public $timestamps = false; // ใส่บรรทัดนี้ถ้าไม่มี created_at, updated_at

    public function likes()
    {
        return $this->belongsToMany(UserModel::class, 'attraction_user_likes', 'attraction_id', 'user_id');
    }


}


