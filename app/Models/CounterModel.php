<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** 
 * COUNTER MODEL
 * 
 * Represents the 'tbl_counter' table in the database.
 * 
 * @table tbl_counter
 * @primaryKey c_id
 * @fillable ['c_date']
 */
class CounterModel extends Model
{
    // The associated table in the database
    protected $table = 'tbl_counter';

    // The primary key column for the table
    protected $primaryKey = 'c_id';

    // The attributes that are mass assignable
    protected $fillable = [
        'attr_id', // Foreign key to the attraction
        'c_date' // Date of the counter (e.g., could be used for tracking visits, stats, etc.)
    ];

    // Whether the primary key is auto-incrementing
    public $incrementing = true;

    // Disable Laravel's automatic timestamps (created_at, updated_at)
    public $timestamps = false;
}
