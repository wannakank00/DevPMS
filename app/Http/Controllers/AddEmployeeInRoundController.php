<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\PmsRound;
use Carbon\Carbon;
use App\Models\PmsRoundUser;

class AddEmployeeInRoundController extends Controller
{
    public function AddEmployeeInRoundForm()
    {
        return view('AddEmployeeInRoundView');
    }

    public function SevaEmployeeInRoundData(Request $request)
    {

        // ตรวจสอบว่ามีไฟล์ถูกส่งมาหรือไม่
        if ($request->hasFile('excel_file')) {
            $file = $request->file('excel_file');

            // ทำตามตัวอย่างในตอนที่แล้วเพื่อดึงข้อมูลจาก Excel
            // require_once base_path('vendor/autoload.php');  // ในกรณีที่ไม่ได้ให้ Composer สร้าง autoload.php ไว้ใน public แล้ว
            // $spreadsheet = IOFactory::load($file->getRealPath());
            // $sheetData = $spreadsheet->getActiveSheet()->toArray();
            // print_r($sheetData);

             // ใช้ PhpSpreadsheet เพื่อดึงข้อมูลจาก Excel
             $spreadsheet = IOFactory::load($file->getRealPath());
             $sheetData = $spreadsheet->getActiveSheet()->toArray();

             

          // ส่งข้อมูลในตาราง $sheetData ไปยัง Blade View
          return view('AddEmployeeInRoundView', ['sheetData' => $sheetData]);
        

        return redirect()->back()->with('error', 'No file uploaded.');
    }

}

}