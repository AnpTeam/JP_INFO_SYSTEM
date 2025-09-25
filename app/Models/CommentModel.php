<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** COMMENT MODEL
 *  @DB Model tbl_comment table
 *  @field ['user_id', 'comment_desc','attr_id','like_count']
 */
class CommentModel extends Model
{
    protected $table = 'tbl_comment';
    protected $primaryKey = 'comment_id';
    protected $fillable = ['user_id', 'comment_desc','attr_id','like_count','date_created'];
    public $incrementing = true;
    public $timestamps = false;
}