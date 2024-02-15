<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class DetailUserModel extends Model
{
    public static function PMS_Get_Detail_User_For_Edit($GET_DATA){       
   
        $Rounds_ID=$GET_DATA['Rounds_ID'];
  
          $Query_Rounds =  DB::connection('mysql_public')
              ->table('pms_rounds')
              ->select('Rounds_ID','Rounds_Name','Rounds_Start','Rounds_End')
              ->where('Rounds_ID', $Rounds_ID)
              ->get();
          return array($Query_Rounds);
  
      }

      public static function PMS_Get_List_User_Added($POST_DATA){       
   
        $Rounds_ID=$POST_DATA['Rounds_ID'];
//DD($Rounds_ID);

        $Count_User_ID_in_Rounds =  DB::connection('mysql_public')
        ->table('pms_round_user')
        ->select(
        'employeeID'
        ,'Step_1_Status'
        ,'Step_2_Status'
        ,'Step_3_Status'
        ,'Approver_1_ID'
        ,'Approver_2_ID')
        ->where('Rounds_ID', $Rounds_ID)
        ->count();


if($Count_User_ID_in_Rounds>0){

     $Query_List_User_ID_in_Rounds =  DB::connection('mysql_public')
              ->table('pms_round_user')
              ->select(
              'employeeID'
              ,'Step_1_Status'
              ,'Step_2_Status'
              ,'Step_3_Status'
              ,'Approver_1_ID'
              ,'Approver_2_ID')
              ->where('Rounds_ID', $Rounds_ID)
              ->get();
        //DD($Query_List_User_in_Rounds);
 
    // foreach ($Query_List_User_in_Rounds as $key => $value) {
    //     $employeeID[]=$value;
    // }
   
    foreach($Query_List_User_ID_in_Rounds as $row){  
        $Array_Employee_ID[]=$row->employeeID;
}
   

                $Query_List_User_in_Rounds = DB::connection('mysql_mono')
                ->table('coreservice.view_ew_employee')
                ->leftJoin('view_ew_company', 'view_ew_employee.companyID', '=', 'view_ew_company.companyID')
                ->leftJoin('view_ew_department', 'view_ew_employee.departmentID', '=', 'view_ew_department.departmentID')
                ->leftJoin('tbl_section', 'view_ew_employee.sectionID', '=', 'tbl_section.section_id')
                ->leftJoin('view_ew_position', 'view_ew_employee.positionID', '=', 'view_ew_position.positionID')
                ->leftJoin('tbl_sysuser', 'tbl_sysuser.user_id', '=', 'view_ew_employee.employeeID')
                ->leftJoin('tbl_mlevel', 'view_ew_employee.mLevel', '=', 'tbl_mlevel.mlevel_id')
                ->leftJoin('hroffice.emp_picture', 'emp_picture.user_id', '=', 'view_ew_employee.employeeID')
                ->leftJoin('view_ew_employee as sus1', 'view_ew_employee.approval_level_1', '=', 'sus1.employeeID')
                ->leftJoin('view_ew_employee as sus2', 'view_ew_employee.approval_level_2', '=', 'sus2.employeeID')
                ->leftJoin('tbl_userdetail', 'tbl_sysuser.user_id', '=', 'tbl_userdetail.user_id')
                ->select('view_ew_employee.user_running'
                ,'view_ew_employee.employeeID'
                ,'view_ew_employee.name'
                ,'view_ew_employee.surname'
                ,'view_ew_employee.eName'
                ,'view_ew_employee.eSurname'
                ,'view_ew_employee.email'
                ,'view_ew_employee.companyID'
                ,'view_ew_employee.sectionID'
                ,'view_ew_department.departmentID'
                ,'view_ew_company.companyName'
                ,'view_ew_department.departmentName'
                ,'tbl_section.section_name'
                ,'view_ew_employee.mLevel'
                ,'view_ew_position.positonName'
                ,'view_ew_position.positionShort'
                ,'tbl_mlevel.description'
                ,'emp_picture.pic_name'
                ,'view_ew_employee.approval_level_1'
                ,'view_ew_employee.approval_level_2'
                ,'sus1.name as approval_level_1_name'
                ,'sus1.surname as approval_level_1_surname'
                ,'sus1.email as approval_level_1_email'
                ,'sus2.name as approval_level_2_name'
                ,'sus2.surname as approval_level_2_surname'
                ,'sus2.email as approval_level_2_email'
                ,'tbl_userdetail.userstatus_id'
                )
                ->whereIn('view_ew_employee.user_running', $Array_Employee_ID)
                ->where('tbl_sysuser.bdel','=','0')
            //    ->where(function ($query)  {  
            //     $query->where('view_ew_employee.endwork',NULL);
            //     $query->orWhere('view_ew_employee.endwork','0000-00-00 00:00:00');
            // })
             //   ->where('tbl_userdetail.userstatus_id','=','1')
             ->whereIn('tbl_userdetail.userstatus_id', [1,11])
                ->orderByRaw("CAST(view_ew_employee.user_running as UNSIGNED) ASC")
                ->get(); 
 // DD($Query_List_User_in_Rounds);
        return array($Query_List_User_in_Rounds);   
    }
}
}
