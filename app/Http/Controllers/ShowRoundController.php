<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PmsRound;
use Illuminate\Support\Facades\DB;

class ShowRoundController extends Controller
{
    public function index()
    {
        $pmsRounds = PmsRound::all(); // ดึงข้อมูลทั้งหมดจากตาราง pms_rounds
        // dd($pmsRound);
        return view('ShowRoundView', compact('pmsRounds'));
    }
    
}
