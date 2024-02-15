<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminLoginModel;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Session;

class AdminLoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = 'DashboardAdminView'; // หน้าหลังล็อกอินสำหรับแอดมิน

    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }


        public function showLoginForm()
    {
        return view('admin.login');
    }

    protected function guard()
    {
        return auth()->guard('admin'); // ใช้ guard ของแอดมิน
    }

    public function login(Request $request)
    {
        // ตรวจสอบข้อมูลล็อกอินแอดมิน
        // ทำการล็อกอินใน guard ของแอดมิน
        $Data_Check['employeeID'] = $request->input('employeeID'); 
        $Data_Check['esPassword'] = $request->input('esPassword'); 
    

                $Data['BOF_Login'] = AdminLoginModel::BOF_Login($Data_Check);

                if($Data['BOF_Login']=="TRUE"){

                    return view('DashboardAdminView'); 
                    
                }else{
                    Session::put('Action_Check', 'No_User_Running', 3);
                    return redirect("/login"); 
                }
    }

}