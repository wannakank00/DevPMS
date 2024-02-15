<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Session;
use DB;

class LoginModel extends Model
{
  
  public static function login($Data_Check)
    { 
        $count = DB::connection('mysql_mono')
            ->table('coreservice.tbl_userdetail')
            ->leftJoin('tbl_sysuser', 'tbl_sysuser.user_id', '=', 'tbl_userdetail.user_id')
            ->select('tbl_userdetail.user_running', 'tbl_sysuser.bdel', 'tbl_userdetail.dp_id')
            ->where('tbl_sysuser.user_name', $Data_Check['esUsername'])
            ->where('tbl_sysuser.bdel', 0)
            ->whereIn('tbl_userdetail.userstatus_id', [1, 11])
            ->count();

        $user_granted = false;

        // Login pass
        if ($count > 0) {
            // Get detail user
            $detailQuery = DB::connection('mysql_mono')
                ->table('coreservice.tbl_userdetail')
                ->leftJoin('tbl_sysuser', 'tbl_sysuser.user_id', '=', 'tbl_userdetail.user_id')
                ->select('tbl_userdetail.user_running')
                ->where('tbl_sysuser.user_name', $Data_Check['esUsername'])
                ->where('tbl_sysuser.bdel', 0)
                ->whereIn('tbl_userdetail.userstatus_id', [1, 11])
                ->first();
          
            $user_running = $detailQuery->user_running;

            $user_mlevel = DB::connection('mysql_mono')
                ->table('view_ew_employee')
                ->select('mLevel')
                ->where('user_running', '=', $user_running)
                ->whereRaw('status COLLATE utf8_unicode_ci != "D"')
                ->pluck('mLevel');

            $check_manager = DB::connection('mysql_mono')
                ->table('view_ew_employee as vee')
                ->where('vee.user_running', $user_running)
                ->where('vee.mLevel', '>=', 8)
                ->where('vee.mLevel', '<=', 23)
                ->whereNotIn('vee.mLevel', [18, 22])
                ->count();


            $Check_ID_User_Login_in_Round = DB::connection('mysql_public')
                ->table('pms_rounds')
                ->leftJoin('pms_round_user', 'pms_rounds.Rounds_ID', '=', 'pms_round_user.Rounds_ID')
                ->select('pms_rounds.Rounds_ID')
                ->where('pms_rounds.Rounds_Status', '=', '1')
                ->where('pms_round_user.employeeID', '=', $user_running)
                ->count();
            if ($Check_ID_User_Login_in_Round > 0) {

                $Get_Data_Rounds = DB::connection('mysql_public')
                    ->table('pms_rounds')
                    ->leftJoin('pms_round_user', 'pms_rounds.Rounds_ID', '=', 'pms_round_user.Rounds_ID')
                    ->select('pms_rounds.Rounds_ID')
                    ->where('pms_rounds.Rounds_Status', '=', '1')
                    ->where('pms_round_user.employeeID', '=', $user_running)
                    ->first();

                $Get_Data_User = DB::connection('mysql_mono')
                    ->table('coreservice.view_ew_employee')
                    ->leftJoin('tbl_sysuser', 'tbl_sysuser.user_id', '=', 'view_ew_employee.employeeID')
                    ->leftJoin('view_ew_department', 'view_ew_employee.departmentID', '=', 'view_ew_department.departmentID')
                    ->leftJoin('view_ew_position', 'view_ew_employee.positionID', '=', 'view_ew_position.positionID')
                    ->leftJoin('hroffice.esc_jobfamily_emp', 'esc_jobfamily_emp.jfemp_user', '=', 'view_ew_employee.employeeID')
                    ->leftJoin('hroffice.esc_jobfamily', 'esc_jobfamily.jf_id', '=', 'esc_jobfamily_emp.jfemp_jf')
                    ->leftJoin('hroffice.emp_picture', 'emp_picture.user_id', '=', 'view_ew_employee.employeeID')
                    ->leftJoin('tbl_userdetail', 'tbl_sysuser.user_id', '=', 'tbl_userdetail.user_id')
                    ->select(
                        'view_ew_employee.user_running',
                        'view_ew_employee.eName',
                        'view_ew_employee.eSurname',
                        'view_ew_employee.name',
                        'view_ew_employee.surname',
                        'view_ew_employee.email',
                        'view_ew_department.departmentName',
                        'view_ew_position.positionShort',
                        'esc_jobfamily_emp.jfemp_jf',
                        'emp_picture.pic_name'
                    )
                    ->where('view_ew_employee.user_running', $user_running)
                    ->where('tbl_sysuser.bdel', '=', '0')
                    //  ->where('tbl_userdetail.userstatus_id','=','1')
                    ->whereIn('tbl_userdetail.userstatus_id', [1, 11])
                    ->first();


                $Full_Name = $Get_Data_User->eName . '  ' . $Get_Data_User->eSurname;
                $Full_Name_TH = $Get_Data_User->name . '  ' . $Get_Data_User->surname;
                $Rounds_ID = $Get_Data_Rounds->Rounds_ID;
                $Admin_JF_ID = $Get_Data_User->jfemp_jf;
                $pic_name = $Get_Data_User->pic_name;

                //   DD($Admin_JF_ID);
                Session::put('Admin_User_Running', $Get_Data_User->user_running);
                Session::put('Admin_Fullname', $Full_Name);
                Session::put('Admin_Fullname_TH', $Full_Name_TH);
                Session::put('Admin_Email', $Get_Data_User->email);
                Session::put('Admin_Department', $Get_Data_User->departmentName);
                Session::put('Admin_Position', $Get_Data_User->positionShort);
                Session::put('Rounds_ID', $Rounds_ID);
                Session::put('Admin_JF_ID', $Admin_JF_ID);
                Session::put('Admin_pic_name', $pic_name);
                // dd($Get_Data_User);
                $Login_Result = "TRUE";
                return $Login_Result;
            } else {
                $Login_Result = "FALSE_Permision";
                return $Login_Result;
            }
        } else {
            $Login_Result = "FALSE";
            return $Login_Result;
        }
    }


}
    