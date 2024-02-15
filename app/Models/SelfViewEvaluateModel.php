<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class SelfViewEvaluateModel extends Model
{
    public static function PMS_Get_Data_Rounds($GET_DATA)
    {
        $Rounds_ID = $GET_DATA['Rounds_ID'];

        $Query_Rounds = DB::connection('mysql_public')
        ->table('pms_rounds')
        ->select('Rounds_ID','Rounds_Name','Rounds_Stsart','Rounds_End')
        ->where('Rounds_ID',$Rounds_ID)
        ->get();
        return array($Query_Rounds);
    }

    public static function PMS_Get_Factor_User($GET_DATA)
    {
        $Rounds_ID = $GET_DATA['Rounds_ID'];
        $user_running = $GET_DATA['user_running'];
        $Query_factor_User = DB::connection('mqsql_pubilc')
        ->table('pms_score_user_facton')
        ->where('Rounds_ID',$Rounds_ID)
        ->where('user_running',$user_running)
        ->orderBy('Order_Sort')
        ->get();
        return $Query_factor_User;
    }

    public static function PMS_Check_Factor_User($GET_DATA)
    {
        $Rounds_ID = $GET_DATA['Rounds_ID'];
        $user_running = $GET_DATA['user_running'];
        $Order_Sort = $GET_DATA['Order_Sort'];
        $Query_Factor_User =  DB::connection('mysql_public')
            ->table('pms_score_user_factor')
            ->where('Rounds_ID', $Rounds_ID)
            ->where('user_running', $user_running)
            ->where('Order_Sort', $Order_Sort)
            ->count();
        // dd($Query_Factor_User);
        return $Query_Factor_User;
    }

    public static function PMS_Save_Factor_User($result)
    {
        $Rounds_ID = $result['Rounds_ID'];
        $user_running = $result['user_running'];
        $Order_Sort = $result['Order_Sort'];
        // dd($result);
        $insert = [
            "Factor_Name" => isset($result['Factor_Name']) ? $result['Factor_Name'] : '',
            "Factor_Desc" => isset($result['Factor_Desc']) ? $result['Factor_Desc'] : '',
            "Factor_Score" => isset($result['Factor_Score']) ? $result['Factor_Score'] : 0
        ];
        return DB::connection('mysql_public')
            ->table('pms_score_user_factor')
            ->where('Rounds_ID', $Rounds_ID)
            ->where('user_running', $user_running)
            ->where('Order_Sort', $Order_Sort)
            ->insert($result);
    }
    public static function PMS_Update_Factor_User($result)
    {
        $Rounds_ID = $result['Rounds_ID'];
        $user_running = $result['user_running'];
        $Order_Sort = $result['Order_Sort'];
        
        $update = [
            "Factor_Name" => $result['Factor_Name'],
            "Factor_Desc" => $result['Factor_Desc'],
            "Factor_Score" => $result['Factor_Score']
        ];
        return  DB::connection('mysql_public')
            ->table('pms_score_user_factor')
            ->where('Rounds_ID', $Rounds_ID)
            ->where('user_running', $user_running)
            ->where('Order_Sort', $Order_Sort)
            ->update($update);
    }

    public static function PMS_Get_Approver_Status_This_Employee($POST_DATA)
    {

        $Rounds_ID = $POST_DATA['Rounds_ID'];
        $user_running = $POST_DATA['user_running'];


        $Query_List_User_ID_in_Rounds =  DB::connection('mysql_public')
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
            ->where('employeeID', $user_running)
            ->get();
        //DD($Query_List_User_in_Rounds);

        // foreach ($Query_List_User_in_Rounds as $key => $value) {
        //     $employeeID[]=$value;
        // }

        foreach ($Query_List_User_ID_in_Rounds as $row) {
            $Array_Employee_ID[] = $row->employeeID;
            $PMS_Status['Step_1_Status'][$row->employeeID] = $row->Step_1_Status;
            $PMS_Status['Step_2_Status'][$row->employeeID] = $row->Step_2_Status;
            $PMS_Status['Step_3_Status'][$row->employeeID] = $row->Step_3_Status;

            $Approver_1_ID = $row->Approver_1_ID;
            $Approver_2_ID = $row->Approver_2_ID;

            $Query_Approver_1 = DB::connection('mysql_mono')
                ->table('coreservice.view_ew_employee')
                ->leftJoin('tbl_sysuser', 'tbl_sysuser.user_id', '=', 'view_ew_employee.employeeID')
                ->select('view_ew_employee.user_running', 'view_ew_employee.name', 'view_ew_employee.surname')
                ->where('view_ew_employee.user_running', $Approver_1_ID)
                ->where('tbl_sysuser.bdel', '=', '0')
                ->first();

            $Query_Approver_2 = DB::connection('mysql_mono')
                ->table('coreservice.view_ew_employee')
                ->leftJoin('tbl_sysuser', 'tbl_sysuser.user_id', '=', 'view_ew_employee.employeeID')
                ->select('view_ew_employee.user_running', 'view_ew_employee.name', 'view_ew_employee.surname')
                ->where('view_ew_employee.user_running', $Approver_2_ID)
                ->where('tbl_sysuser.bdel', '=', '0')
                ->first();


            $PMS_Status['Approver_1_ID'][$row->employeeID] = $row->Approver_1_ID;
            $PMS_Status['Approver_2_ID'][$row->employeeID] = $row->Approver_2_ID;
            $PMS_Status['Approver_1_Name'][$row->employeeID] = $Query_Approver_1->name . ' ' . $Query_Approver_1->surname;
            $PMS_Status['Approver_2_Name'][$row->employeeID] = $Query_Approver_2->name . ' ' . $Query_Approver_2->surname;
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
            ->leftJoin('hroffice.esc_jobfamily_emp', 'esc_jobfamily_emp.jfemp_user', '=', 'view_ew_employee.employeeID')
            ->leftJoin('hroffice.esc_jobfamily', 'esc_jobfamily.jf_id', '=', 'esc_jobfamily_emp.jfemp_jf')
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
                'view_ew_employee.startWork',
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
                'sus1.user_running as approval_level_1_user_running',
                'sus1.name as approval_level_1_name',
                'sus1.surname as approval_level_1_surname',
                'sus1.email as approval_level_1_email',
                'sus2.user_running as approval_level_2_user_running',
                'sus2.name as approval_level_2_name',
                'sus2.surname as approval_level_2_surname',
                'sus2.email as approval_level_2_email',
                'emp_picture.pic_name',
                'esc_jobfamily_emp.jfemp_jf',
                'esc_jobfamily.jf_code',
                'esc_jobfamily.jf_name',
                'view_ew_employee.sex'
            )
            ->where('view_ew_employee.user_running', $Array_Employee_ID)
            ->where('tbl_sysuser.bdel', '=', '0')
            // ->where('tbl_userdetail.userstatus_id', '=', '1')
            ->whereIn('tbl_userdetail.userstatus_id', [1, 11])
            ->orderByRaw("CAST(view_ew_employee.user_running as UNSIGNED) ASC")
            ->get();
        //  $Query_List_User_in_Rounds['Step_1_Status']='xxx';
        //               DD($Query_List_User_in_Rounds->'user_running');
        //                 $Query_List_User_in_Rounds[] = ['Step_1_Status' => 'xxx'];
        //DD($Query_List_User_in_Rounds);
        //DD($PMS_Status);
        return array($Query_List_User_in_Rounds, $PMS_Status);
    }
    public static function TEST_PMS_Get_Approver_Status_This_Employee($POST_DATA)
    {

        $Rounds_ID = $POST_DATA['Rounds_ID'];
        $user_running = $POST_DATA['user_running'];


        $Query_List_User_ID_in_Rounds =  DB::connection('mysql_public')
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
            ->where('employeeID', $user_running)
            ->get();
        //DD($Query_List_User_in_Rounds);

        // foreach ($Query_List_User_in_Rounds as $key => $value) {
        //     $employeeID[]=$value;
        // }

        foreach ($Query_List_User_ID_in_Rounds as $row) {
            $Array_Employee_ID[] = $row->employeeID;
            $PMS_Status['Step_1_Status'][$row->employeeID] = $row->Step_1_Status;
            $PMS_Status['Step_2_Status'][$row->employeeID] = $row->Step_2_Status;
            $PMS_Status['Step_3_Status'][$row->employeeID] = $row->Step_3_Status;

            $Approver_1_ID = $row->Approver_1_ID;
            $Approver_2_ID = $row->Approver_2_ID;

            $Query_Approver_1 = DB::connection('mysql_mono')
                ->table('coreservice.view_ew_employee')
                ->leftJoin('tbl_sysuser', 'tbl_sysuser.user_id', '=', 'view_ew_employee.employeeID')
                ->select('view_ew_employee.user_running', 'view_ew_employee.name', 'view_ew_employee.surname')
                ->where('view_ew_employee.user_running', $Approver_1_ID)
                ->where('tbl_sysuser.bdel', '=', '0')
                ->first();

            $Query_Approver_2 = DB::connection('mysql_mono')
                ->table('coreservice.view_ew_employee')
                ->leftJoin('tbl_sysuser', 'tbl_sysuser.user_id', '=', 'view_ew_employee.employeeID')
                ->select('view_ew_employee.user_running', 'view_ew_employee.name', 'view_ew_employee.surname')
                ->where('view_ew_employee.user_running', $Approver_2_ID)
                ->where('tbl_sysuser.bdel', '=', '0')
                ->first();


            $PMS_Status['Approver_1_ID'][$row->employeeID] = $row->Approver_1_ID;
            $PMS_Status['Approver_2_ID'][$row->employeeID] = $row->Approver_2_ID;
            $PMS_Status['Approver_1_Name'][$row->employeeID] = $Query_Approver_1->name . ' ' . $Query_Approver_1->surname;
            $PMS_Status['Approver_2_Name'][$row->employeeID] = $Query_Approver_2->name . ' ' . $Query_Approver_2->surname;
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
            ->leftJoin('hroffice.esc_jobfamily_emp', 'esc_jobfamily_emp.jfemp_user', '=', 'view_ew_employee.employeeID')
            ->leftJoin('hroffice.esc_jobfamily', 'esc_jobfamily.jf_id', '=', 'esc_jobfamily_emp.jfemp_jf')
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
                'view_ew_employee.startWork',
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
                'sus1.user_running as approval_level_1_user_running',
                'sus1.name as approval_level_1_name',
                'sus1.surname as approval_level_1_surname',
                'sus1.email as approval_level_1_email',
                'sus2.user_running as approval_level_2_user_running',
                'sus2.name as approval_level_2_name',
                'sus2.surname as approval_level_2_surname',
                'sus2.email as approval_level_2_email',
                'emp_picture.pic_name',
                'esc_jobfamily_emp.jfemp_jf',
                'esc_jobfamily.jf_code',
                'esc_jobfamily.jf_name',
                'view_ew_employee.sex'
            )
            ->where('view_ew_employee.user_running', $Array_Employee_ID)
            ->where('tbl_sysuser.bdel', '=', '0')
            // ->where('tbl_userdetail.userstatus_id', '=', '1')
            ->orderByRaw("CAST(view_ew_employee.user_running as UNSIGNED) ASC")
            ->get();
        //  $Query_List_User_in_Rounds['Step_1_Status']='xxx';
        //               DD($Query_List_User_in_Rounds->'user_running');
        //                 $Query_List_User_in_Rounds[] = ['Step_1_Status' => 'xxx'];
        //DD($Query_List_User_in_Rounds);
        //DD($PMS_Status);
        return array($Query_List_User_in_Rounds, $PMS_Status);
    }





    /********** Question **********/

    public static function PMS_List_Factors()
    {
        $Query_Factors =  DB::connection('mysql_public')
            ->table('pms_factors')
            ->select('Factors_ID', 'Factors_Name', 'Factors_Indicators')
            ->limit(5)
            ->get();
        return array($Query_Factors);
    }

    public static function PMS_List_Competency()
    {
        $Query_Competency =  DB::connection('mysql_public')
            ->table('pms_factors_competency')
            ->select('Factors_ID', 'Factors_Name', 'Factors_Indicators')
            ->get();
        return array($Query_Competency);
    }

    public static function PMS_List_Behavior()
    {
        $Query_Behavior =  DB::connection('mysql_public')
            ->table('pms_factors_behavior')
            ->select('Factors_ID', 'Factors_Name', 'Factors_Indicators')
            ->get();
        return array($Query_Behavior);
    }

    public static function PMS_List_Functional($Emp_JF_ID)
    {
        //   DD($Emp_JF_ID);    
        $Query_Functional =  DB::connection('mysql_public')
            ->table('pms_factors_functional')
            ->select('Factors_ID', 'Factors_Name', 'Factors_Indicators')
            ->where('jf_id', $Emp_JF_ID)
            ->get();
        return array($Query_Functional);
    }

    public static function PMS_List_Managerial()
    {
        $Query_Managerial =  DB::connection('mysql_public')
            ->table('pms_factors_managerial')
            ->select('Factors_ID', 'Factors_Name', 'Factors_Indicators')
            ->get();
        return array($Query_Managerial);
    }






    /********** Answer Self**********/

    public static function PMS_List_Factors_Score_Self($GET_DATA)
    {
        $Rounds_ID = $GET_DATA['Rounds_ID'];
        $user_running = $GET_DATA['user_running'];
        // DD($Rounds_ID);
        $Query_Factors_Score_Self =  DB::connection('mysql_public')
            ->table('pms_score_user')
            ->select('Factors_ID', 'Score_Self', 'Score_App_1', 'Score_App_2')
            ->where('Score_Category', 'Individual')
            ->where('Rounds_ID', $Rounds_ID)
            ->where('employeeID', $user_running)
            ->get();
        $Query_Factors_Score_Self_Count =  DB::connection('mysql_public')
            ->table('pms_score_user')
            ->where('Score_Category', 'Individual')
            ->where('Rounds_ID', $Rounds_ID)
            ->where('employeeID', $user_running)
            ->count();

        return array($Query_Factors_Score_Self, $Query_Factors_Score_Self_Count);
    }

    public static function PMS_List_Competency_Score_Self($GET_DATA)
    {
        $Rounds_ID = $GET_DATA['Rounds_ID'];
        $user_running = $GET_DATA['user_running'];
        $Query_Factors_Score_Self =  DB::connection('mysql_public')
            ->table('pms_score_user')
            ->select('Factors_ID', 'Score_Self', 'Score_App_1', 'Score_App_2')
            ->where('Score_Category', 'Competency')
            ->where('Rounds_ID', $Rounds_ID)
            ->where('employeeID', $user_running)
            ->get();
        $Query_Factors_Score_Self_Count =  DB::connection('mysql_public')
            ->table('pms_score_user')
            ->where('Score_Category', 'Competency')
            ->where('Rounds_ID', $Rounds_ID)
            ->where('employeeID', $user_running)
            ->count();
        return array($Query_Factors_Score_Self, $Query_Factors_Score_Self_Count);
    }
    public static function PMS_List_Behavior_Score_Self($GET_DATA)
    {
        $Rounds_ID = $GET_DATA['Rounds_ID'];
        $user_running = $GET_DATA['user_running'];
        $Query_Factors_Score_Self =  DB::connection('mysql_public')
            ->table('pms_score_user')
            ->select('Factors_ID', 'Score_Self', 'Score_App_1', 'Score_App_2')
            ->where('Score_Category', 'Behavior')
            ->where('Rounds_ID', $Rounds_ID)
            ->where('employeeID', $user_running)
            ->get();
        $Query_Factors_Score_Self_Count =  DB::connection('mysql_public')
            ->table('pms_score_user')
            ->where('Score_Category', 'Behavior')
            ->where('Rounds_ID', $Rounds_ID)
            ->where('employeeID', $user_running)
            ->count();
        return array($Query_Factors_Score_Self, $Query_Factors_Score_Self_Count);
    }
    public static function PMS_List_Functional_Score_Self($GET_DATA)
    {
        $Rounds_ID = $GET_DATA['Rounds_ID'];
        $user_running = $GET_DATA['user_running'];
        $Query_Factors_Score_Self =  DB::connection('mysql_public')
            ->table('pms_score_user')
            ->select('Factors_ID', 'Score_Self', 'Score_App_1', 'Score_App_2')
            ->where('Score_Category', 'Functional')
            ->where('Rounds_ID', $Rounds_ID)
            ->where('employeeID', $user_running)
            ->get();
        $Query_Factors_Score_Self_Count =  DB::connection('mysql_public')
            ->table('pms_score_user')
            ->where('Score_Category', 'Functional')
            ->where('Rounds_ID', $Rounds_ID)
            ->where('employeeID', $user_running)
            ->count();
        return array($Query_Factors_Score_Self, $Query_Factors_Score_Self_Count);
    }
    public static function PMS_List_Managerial_Score_Self($GET_DATA)
    {
        $Rounds_ID = $GET_DATA['Rounds_ID'];
        $user_running = $GET_DATA['user_running'];
        $Query_Factors_Score_Self =  DB::connection('mysql_public')
            ->table('pms_score_user')
            ->select('Factors_ID', 'Score_Self', 'Score_App_1', 'Score_App_2')
            ->where('Score_Category', 'Managerial')
            ->where('Rounds_ID', $Rounds_ID)
            ->where('employeeID', $user_running)
            ->get();
        $Query_Factors_Score_Self_Count =  DB::connection('mysql_public')
            ->table('pms_score_user')
            ->where('Score_Category', 'Managerial')
            ->where('Rounds_ID', $Rounds_ID)
            ->where('employeeID', $user_running)
            ->count();
        return array($Query_Factors_Score_Self, $Query_Factors_Score_Self_Count);
    }




    public static function PMS_Text_Self($GET_DATA)
    {
        $Rounds_ID = $GET_DATA['Rounds_ID'];
        $user_running = $GET_DATA['user_running'];
        $Query_Text_Self =  DB::connection('mysql_public')
            ->table('pms_score_user_text')
            ->select('Project_Self', 'Note_Self', 'Note_App_1', 'Goodnote_App_1', 'Badnote_App_1', 'Note_App_2', 'Goodnote_App_2', 'Badnote_App_2')
            ->where('Rounds_ID', $Rounds_ID)
            ->where('employeeID', $user_running)
            ->get();
        return array($Query_Text_Self);
    }



    public static function List_Project($GET_DATA)
    {
        $Rounds_ID = $GET_DATA['Rounds_ID'];
        $user_running = $GET_DATA['user_running'];
        $Query_List_Project =  DB::connection('mysql_public')
            ->table('pms_score_user_project')
            ->select('*')
            ->where('Rounds_ID', $Rounds_ID)
            ->where('employeeID', $user_running)
            ->first();
        return $Query_List_Project;
    }
    
}
