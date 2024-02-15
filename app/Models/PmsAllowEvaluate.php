<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PmsAllowEvaluate extends Model
{
    protected $table = 'pms_allow_evaluate';
    public $timestamps = false;

    protected $fillable = [
        'user_running',
        'date_evaluate',
        // เพิ่มคอลัมน์ตามที่มีในตาราง
    ];
}
