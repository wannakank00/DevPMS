<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PmsRound extends Model
{

    use HasFactory;

    protected $table = 'PMS_rounds';

    protected $fillable = [
        'Rounds_ID', 'Rounds_Name', 'Rounds_Start', 'Rounds_End', 'Rounds_Status'
        // เพิ่มฟิลด์อื่น ๆ ที่คุณต้องการดึงข้อมูลด้วย
    ];
    public $timestamps = false;
}
