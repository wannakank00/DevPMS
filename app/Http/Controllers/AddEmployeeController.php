<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\PmsAllowEvaluate;
use Carbon\Carbon;
use App\Models\PMSRound;


class AddEmployeeController extends Controller
{
    public function addEmployeeForm()
    {
        $pmsRounds = PMSRound::all(); // ดึงข้อมูลทั้งหมดจากตาราง pms_rounds
        return view('AddEmployeeView', compact('pmsRounds'));
    }

}
