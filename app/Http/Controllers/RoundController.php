<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PmsRound;

class RoundController extends Controller
{
    public function showAddRoundView()
    {
        return view('AddRoundView'); // สร้างหน้าวิว addRound.blade.php สำหรับแสดงฟอร์ม
    }

    public function addRound(Request $request)
    {
        // ทำการบันทึกข้อมูลที่ได้รับจากฟอร์ม
        // $request->input('ชื่อฟิลด์') เพื่อดึงค่าจากฟอร์ม
        // ตัวอย่างการบันทึกข้อมูล
        $newRound = new PmsRound; // Model 
        $newRound->Rounds_Name = $request->input('Rounds_Name'); // ชื่อฟิลด์ในตาราง rounds
        $newRound->Rounds_Start = $request->input('Rounds_Start'); // ชื่อฟิลด์ในตาราง rounds
        $newRound->Rounds_End = $request->input('Rounds_End'); // ชื่อฟิลด์ในตาราง rounds
        $newRound->save();
       

        return redirect()->route('AddRound')->with('success', 'บันทึกรอบประเมินเรียบร้อยแล้ว');
    }
}
