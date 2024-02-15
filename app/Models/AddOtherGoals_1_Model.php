<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Facade\Ignition\QueryRecorder\Query;

class AddOtherGoals_1_Model extends Model
{
    public static function PMS_Get_Data_Rounds($GET_DATA)
  {

    $Rounds_ID = $GET_DATA['Rounds_ID'];
    $Query_Rounds =  DB::connection('mysql_public')
      ->table('pms_rounds')
      ->select('Rounds_ID', 'Rounds_Name', 'Rounds_Start', 'Rounds_End')
      ->where('Rounds_ID', $Rounds_ID)
      ->get();
    return array($Query_Rounds);
  }
  
  public static function PMS_GetLastRounds($data){
    $Rounds_ID = $data['Rounds_ID'] - 1;
    $query = DB::connection('mysql_public')
    ->table('pms_rounds')
    ->select('Rounds_ID', 'Rounds_Name', 'Rounds_Start', 'Rounds_End')
    ->where('Rounds_ID',$Rounds_ID)
    ->get();
    return $query;
  }

  public static function PMS_Get_factor_User($GET_DATA)
  {
    $Rounds_ID = $GET_DATA['Rounds_ID'];
    $user_running = $GET_DATA['user_running'];
    $Query_Factor_User =  DB::connection('mysql_public')
      ->table('pms_score_user_factor')
      ->where('Rounds_ID', $Rounds_ID)
      ->where('user_running', $user_running)
      ->orderBy('Order_Sort')
      ->get();
    return $Query_Factor_User;
  }

  public static function PMS_Save_Factor_User($result)
  {
    $Rounds_ID = $result['Rounds_ID'];
    $user_running = $result['user_running'];
    $Order_Sort = $result['Order_Sort'];
    $insert = [
      "Factor_Name" => isset($result['Factor_Name']) ? $result['Factor_Name'] : '',
      "Factor_Desc" => isset($result['Factor_Desc']) ? $result['Factor_Desc'] : '',
    ];
    return DB::connection('mysql_public')
      ->table('pms_score_user_factor')
      ->where('Rounds_ID', $Rounds_ID)
      ->where('user_running', $user_running)
      ->where('Order_Sort', $Order_Sort)
      ->insert($result);
  }

  public static function PMS_Get_List_User_Added($POST_DATA)
  {

    $Rounds_ID = $POST_DATA['Rounds_ID'];
    $user_running = $POST_DATA['user_running'];

    $Count_User_ID_in_Rounds =  DB::connection('mysql_public')
      ->table('pms_round_user')
      ->select(
        'employeeID',
        'Step_1_Status',
        'Step_2_Status',
        'Step_3_Status',
        'Approver_1_ID',
        'Approver_2_ID'
      )
      ->where('Rounds_ID', $Rounds_ID)
      ->count();


    if ($Count_User_ID_in_Rounds > 0) {

      //DD($Rounds_ID);

      $Count_Sub_in_team =  DB::connection('mysql_public')
        ->table('pms_round_user')
        ->where('Rounds_ID', $Rounds_ID)
        // ->where('Approver_1_ID', $user_running)
        // ->orwhere('Approver_2_ID', $user_running)
        ->where(function ($query)  use ($user_running) {
          $query->where('Approver_1_ID', $user_running);
          $query->orWhere('Approver_2_ID', $user_running);
        })
        ->count();

      /* if($user_running=='2959'){
          DD($Count_Sub_in_team);  
      }
      */
      if ($Count_Sub_in_team > 0) {
        
        $Query_List_User_ID_in_Rounds =  DB::connection('mysql_public')
          ->table('pms_round_user')
          ->select(
            'Rounds_ID',
            'employeeID',
            'Step_1_Status',
            'Step_2_Status',
            'Step_3_Status',
            'Approver_1_ID',
            'Approver_2_ID'
          )
          ->where('Rounds_ID', $Rounds_ID)
          // ->where('Approver_1_ID', $user_running)
          // ->orwhere('Approver_2_ID', $user_running)
          ->where(function ($query)  use ($user_running) {
            $query->where('Approver_1_ID', $user_running);
            $query->orWhere('Approver_2_ID', $user_running);
          })
          ->get();

        //   SELECT
        //   hr_pms.pms_round_user.*
        //   FROM
        //   hr_pms.pms_round_user
        //   WHERE
        //   Rounds_ID='1'
        //   AND 
        //   (Approver_1_ID=655 OR Approver_2_ID=655)

       


        // DD($Query_List_User_ID_in_Rounds);
        // $Array_Employee_ID = array();
        foreach ($Query_List_User_ID_in_Rounds as $row) {
          $Array_Employee_ID[] = $row->employeeID;
          $PMS_Status['Rounds_ID'][$row->employeeID] = $row->Rounds_ID;
          $PMS_Status['Step_1_Status'][$row->employeeID] = $row->Step_1_Status;
          $PMS_Status['Step_2_Status'][$row->employeeID] = $row->Step_2_Status;
          $PMS_Status['Step_3_Status'][$row->employeeID] = $row->Step_3_Status;
          $Approver_1_ID = $row->Approver_1_ID;
          $Approver_2_ID = $row->Approver_2_ID;

          $Query_Approver_1 = DB::connection('mysql_mono')
            ->table('coreservice.view_ew_employee')
            ->leftJoin('tbl_sysuser', 'tbl_sysuser.user_id', '=', 'view_ew_employee.employeeID')
            ->leftJoin('tbl_userdetail', 'tbl_sysuser.user_id', '=', 'tbl_userdetail.user_id')
            ->select('view_ew_employee.user_running', 'view_ew_employee.name', 'view_ew_employee.surname')
            ->where('view_ew_employee.user_running', $Approver_1_ID)
            ->where('tbl_sysuser.bdel', '=', '0')
            // ->where('tbl_userdetail.userstatus_id', '=', '1')
            ->first();

          $Query_Approver_2 = DB::connection('mysql_mono')
            ->table('coreservice.view_ew_employee')
            ->leftJoin('tbl_sysuser', 'tbl_sysuser.user_id', '=', 'view_ew_employee.employeeID')
            ->leftJoin('tbl_userdetail', 'tbl_sysuser.user_id', '=', 'tbl_userdetail.user_id')
            ->select('view_ew_employee.user_running', 'view_ew_employee.name', 'view_ew_employee.surname')
            ->where('view_ew_employee.user_running', $Approver_2_ID)
            ->where('tbl_sysuser.bdel', '=', '0')
            // ->where('tbl_userdetail.userstatus_id', '=', '1')
            ->first();


          $PMS_Status['Approver_1_ID'][$row->employeeID] = $row->Approver_1_ID;
          $PMS_Status['Approver_2_ID'][$row->employeeID] = $row->Approver_2_ID;
          $PMS_Status['Approver_1_Name'][$row->employeeID] = $Query_Approver_1->name;
          $PMS_Status['Approver_2_Name'][$row->employeeID] = $Query_Approver_2->name;
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
          ->select(
            'view_ew_employee.user_running',
            'view_ew_employee.employeeID',
            'view_ew_employee.name',
            'view_ew_employee.surname',
            'view_ew_employee.eName',
            'view_ew_employee.eSurname',
            'view_ew_employee.email',
            'view_ew_employee.companyID',
            'view_ew_employee.sectionID',
            'view_ew_department.departmentID',
            'view_ew_company.companyName',
            'view_ew_department.departmentName',
            'tbl_section.section_name',
            'view_ew_employee.mLevel',
            'view_ew_position.positonName',
            'view_ew_position.positionShort',
            'tbl_mlevel.description',
            'emp_picture.pic_name',
            'view_ew_employee.approval_level_1',
            'view_ew_employee.approval_level_2',
            'sus1.name as approval_level_1_name',
            'sus1.surname as approval_level_1_surname',
            'sus1.email as approval_level_1_email',
            'sus2.name as approval_level_2_name',
            'sus2.surname as approval_level_2_surname',
            'sus2.email as approval_level_2_email'
          )
          ->whereIn('view_ew_employee.user_running', $Array_Employee_ID)
          ->where('tbl_sysuser.bdel', '=', '0')
          ->where('tbl_userdetail.userstatus_id', '=', '1')
          ->orderByRaw("CAST(view_ew_employee.user_running as UNSIGNED) ASC")
          ->get();


        return array($Query_List_User_in_Rounds, $PMS_Status);
      }
    }
  }

  public static function PMS_List_Sup_No_sub()
  {
    $Query_List_Sup_No_Sub =  DB::connection('mysql_public')
      ->table('pms_list_sup_no_sub')
      ->select('user_running')
      ->get();
    return array($Query_List_Sup_No_Sub);
  }
}
