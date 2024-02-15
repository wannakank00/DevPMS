<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class EvaluateModel extends Model
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

    public static function PMS_Get_Factor_User($GET_DATA)
    {
        $Rounds_ID = $GET_DATA['Rounds_ID'];
        $user_running = $GET_DATA['user_running'];
        $Query_Factor_User =  DB::connection('mysql_public')
            ->table('pms_score_user_factor')
            ->where('Rounds_ID', $Rounds_ID)
            ->where('user_running', $user_running)
            ->orderBy('Order_Sort')
            ->get();
        // dd($Query_Factor_User);
        return $Query_Factor_User;
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
            ->insert($insert);
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
            ->whereIn('view_ew_employee.user_running', $Array_Employee_ID)
            ->where('tbl_sysuser.bdel', '=', '0')
            // ->where('tbl_userdetail.userstatus_id','=','1')
            //  ->where('tbl_userdetail.userstatus_id','=','1')
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


    public static function PMS_Get_Leave_Quota($POST_DATA)
    {

        $user_running = $POST_DATA['user_running'];


        $Query_Leave_Quota =  DB::connection('mysql_public')
            ->table('pms_leave_quota')
            ->select('*')
            ->where('employeeID', $user_running)
            ->get();

        //DD($Query_Leave_Quota);

        return $Query_Leave_Quota;
    }





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

    public static function PMS_List_Functional()
    {
        $Query_Functional =  DB::connection('mysql_public')
            ->table('pms_factors_functional')
            ->select('Factors_ID', 'Factors_Name', 'Factors_Indicators')
            ->where('jf_id', Session::get('Admin_JF_ID'))
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

    public static function PMS_Topic_List_Managerial()
    {
        $query =  DB::connection('mysql_public')
            ->table('pms_managerial_factor')
            ->get();
        return array($query);
    }
    // รับ position ของพนักงาน เพื่อดึง data ของ managerial
    /* 
        coreservice ดึงตำแหน่ง
    */

    public static function PMS_Check_Managerial_byRole($mLevel)
    {

        // get position
        /* $query =  DB::connection('mysql_public')
            ->table('pms_managerial_role')
            ->leftJoin('pms_managerial', 'pms_managerial_role.m_id', '=', 'pms_managerial.m_id')
            ->where('mlevel_id', 'LIKE', '%' . $mLevel . '%')
            ->count(); */
        $query =  DB::connection('mysql_public')
            ->table('pms_managerial_role')
            ->where('mlevel_id',  $mLevel )
            ->count();
        return $query;
    }

    public static function PMS_List_Managerial_byRole($mLevel)
    {

        // get position
        $query =  DB::connection('mysql_public')
            ->table('pms_managerial_role as pmr')
            ->leftJoin('pms_managerial as pm', 'pmr.m_id', '=', 'pm.m_id')
            ->leftJoin('pms_managerial_factor as pmf', 'pm.mf_id', '=', 'pmf.mf_id')
            ->select('pmr.m_id', 'pmr.mlevel_id', 'pmf.mf_name', 'pm.managerial_indicators', 'pm.mf_id')
            ->where('mlevel_id', '=', $mLevel)
            // ->groupBy('pmr.m_id')
            ->get();
        return $query;
    }

    public static function getPmsCountMfManagerial()
    {
        $result = array();
        $query = DB::connection('mysql_public')
            ->table('pms_managerial_factor as pmf')
            ->leftJoin('pms_managerial as pm', 'pm.mf_id', '=', 'pmf.mf_id')
            ->select('pmf.mf_id as mf_id', DB::raw('count(pm.mf_id) as count_mf'))
            ->groupBy('pmf.mf_id')
            ->get();
        if (count($query) > 0) {
            foreach ($query as $row) {
                $result[$row->mf_id] = $row->count_mf;
            }
        }
        return $result;
    }

    public static function PMS_List_Checkbox_Managerial($user_id, $Rounds_ID)
    {
        $result = array();
        $query =  DB::connection('mysql_public')
            ->table('pms_managerial_status')
            ->where('user_id', '=', $user_id)
            ->where('Rounds_ID', '=', $Rounds_ID)
            // ->groupBy('pmr.m_id')
            ->get();
        if (count($query) > 0) {
            foreach ($query as $row) {
                $result[$row->m_id] = $row->m_id;
            }
        }
        return $result;
    }

    public static function PMS_score_managerial($user_id, $Rounds_ID)
    {
        $result = array();
        $query =  DB::connection('mysql_public')
            ->table('pms_managerial_user')
            ->where('user_id', '=', $user_id)
            ->where('Rounds_ID', '=', $Rounds_ID)
            ->get();
        if (count($query) > 0) {
            foreach ($query as $row) {
                $result[$row->mf_id]['score'] = $row->score;
                $result[$row->mf_id]['score_app_1'] = isset($row->score_app_1) ? $row->score_app_1 : 0;
                $result[$row->mf_id]['score_app_2'] = isset($row->score_app_2) ? $row->score_app_2 : 0;
            }
        }
        return $result;
    }

    public static function GET_EMP_MLEVEL($user_running)
    {
        $Query = DB::connection('mysql_mono')
            ->table('view_ew_employee')
            ->select('mLevel')
            ->where('user_running', '=', $user_running)
            ->whereRaw('status COLLATE utf8_unicode_ci != "D"')
            ->get();
        return $Query;
    }

    public static function PMS_Check_Chosen_Managerial($user_id, $user_running, $Rounds_ID)
    {
        // user_running รหัสพนักงานของคนที่ login
        $check = false;
        // Check user
        $query =  DB::connection('mysql_public')
            ->table('pms_round_user as pru')
            ->rightJoin('pms_list_sup_no_sub as plsns', 'pru.employeeID', '=', 'plsns.user_running')
            ->where('plsns.user_running',  $user_running)
            ->where('pru.Rounds_ID', $Rounds_ID)
            ->count();
	
        /* $query = DB::connection('mysql_public')
            ->table('pms_round_user as pru')
            ->leftJoin('pms_list_sup_no_sub as plsns', 'pru.employeeID', '=', 'plsns.user_running')
            ->select('pru.*')
            ->whereNull('plsns.user_running')
            ->where('pru.Rounds_ID', '=', $Rounds_ID)
            ->where(function ($query) use ($user_running) {
                $query->where('pru.employeeID', '=', $user_running)
                    ->orWhere('pru.Approver_1_ID', '=', $user_running)
                    ->orWhere('pru.Approver_2_ID', '=', $user_running);
            })
            ->count(); */
        // เอา user_id m1 และ m2 ไปหา user_running
        // if (isset($query)) {
            // dd($query);
            if($query == '0' || $query == ''){
                $check = true;
            }
       /*  if ($query > 0) {
            $check = true;
        } */
        return $check;
    }

    public static function PMS_Save_Score_Managerial($post_data, $table)
    {
        // Send $table to delete and insert

        // dd($post_data);
        $Rounds_ID = $post_data['Rounds_ID'];
        $user_running = $post_data['user_running'];
        // เอา user_running ไปหา user_id เพื่อเอาไป insert pms_managerial_user
        $user_id = $post_data['user_id'];
        
        // dd($m_status);
        $Managerial_Self = $post_data['managerial_score_self'];
        $mf_id = $post_data['mf_id'];
        if ($table == 'pms_score_user') {
            $check_rounds_user = DB::connection('mysql_public')
                ->table($table)
                ->where('Rounds_ID', $Rounds_ID)
                ->where('employeeID', $user_running)
                ->where('Score_Category', 'Managerial')
                ->first();
            // ถ้าเจอข้อมูลใให้ทำการ update แต่ถ้าไม่เจอให้ทำการ insert
            if (isset($check_rounds_user)) {
                //update
                foreach ($Managerial_Self as $key => $value) {
                    DB::connection('mysql_public')
                        ->table($table)
                        ->where('Factors_ID', $key)
                        ->where('Rounds_ID', $Rounds_ID)
                        ->where('user_id', $user_id)
                        ->where('Score_Category', 'Managerial')
                        ->update(
                            [
                                'Score_Self' => $value
                            ]
                        );
                }
            } else {
                //insert
                foreach ($Managerial_Self as $key => $value) {
                    DB::connection('mysql_public')
                        ->table($table)
                        ->insert(
                            [
                                'Rounds_ID' => $Rounds_ID, 'employeeID' => $user_running, 'Score_Category' => 'Managerial', 'Factors_ID' =>  $key, 'Score_Self' => $value
                            ]
                        );
                }
            }
        } elseif ($table == 'pms_managerial_user') {
            /*mu_id
            user_id
            user_running
            mf_id
            score
            score_app_1
            score_app_2
            updated_by
            updated_at
            insert pms_maanagerial_user and pms_managerial_status
            */
            $m_status = $post_data['m_status'];
            $check_rounds_user = DB::connection('mysql_public')
                ->table($table)
                ->where('Rounds_ID', $Rounds_ID)
                ->where('user_running', $user_running)
                ->first();
            // dd($check_rounds_user);
            if ($check_rounds_user) {
                // update score
                // dd($Managerial_Self);
                /* DB::connection('mysql_public')
                    ->table($table)
                    ->where('Rounds_ID', $Rounds_ID)
                    ->where('user_id', $user_id)
                    ->delete(); */

                foreach ($Managerial_Self as $key => $value) {
                    /* DB::connection('mysql_public')
                        ->table($table)
                        ->insert([
                            'Rounds_ID' => $Rounds_ID,
                            'user_id' => $user_id,
                            'user_running' => $user_running,
                            'mf_id' => $key,
                            'score' => $value,
                            'updated_by' => $user_running
                        ]); */
                        DB::connection('mysql_public')
                        ->table($table)
                        ->where('mf_id', $key)
                        ->where('Rounds_ID', $Rounds_ID)
                        ->where('user_id', $user_id)
                        ->update(
                            [
                                'score' => $value, 'updated_by' => $user_running
                            ]
                        );
                }
                /* foreach ($Managerial_Self as $key => $value) {
                    DB::connection('mysql_public')
                        ->table($table)
                        ->where('mf_id', $key)
                        ->where('Rounds_ID', $Rounds_ID)
                        ->where('user_id', $user_id)
                        ->update(
                            [
                                'score' => $value, 'updated_by' => $user_running
                            ]
                        );
                    // echo 'KEY '. $key . ' | Value '. $value.'<br>';

                } */
                // exit();
                // Update status
                $check_status = DB::connection('mysql_public')
                    ->table('pms_managerial_status')
                    ->where('user_id', $user_id)
                    ->where('Rounds_ID', $Rounds_ID)
                    ->first();
                if ($check_status) {
                    // delete
                    DB::connection('mysql_public')
                        ->table('pms_managerial_status')
                        ->where('user_id', $user_id)
                        ->where('Rounds_ID', $Rounds_ID)
                        ->delete();
                    // insert
                    // dd($m_status);
                }
                foreach ($m_status as $key => $value) {
                    DB::connection('mysql_public')
                        ->table('pms_managerial_status')
                        ->insert(
                            [
                                'm_id' => $value, 'Rounds_ID' => $Rounds_ID, 'user_id' => $user_id
                            ]
                        );
                }
            } else {
                // insert
                foreach ($Managerial_Self as $key => $value) {
                    DB::connection('mysql_public')
                        ->table($table)
                        ->insert(
                            [
                                'Rounds_ID' => $Rounds_ID, 'user_id' => $user_id, 'user_running' => $user_running, 'mf_id' =>  $key, 'score' => $value, 'updated_by' => $user_running
                            ]
                        );
                }

                $check_status = DB::connection('mysql_public')
                    ->table('pms_managerial_status')
                    ->where('user_id', $user_id)
                    ->where('Rounds_ID', $Rounds_ID)
                    ->first();
                if ($check_status) {
                    // delete
                    DB::connection('mysql_public')
                        ->table('pms_managerial_status')
                        ->where('user_id', $user_id)
                        ->where('Rounds_ID', $Rounds_ID)
                        ->delete();
                    // insert
                    // dd($m_status);

                }
                // insert
                // dd($m_status);
                foreach ($m_status as $key => $value) {
                    DB::connection('mysql_public')
                        ->table('pms_managerial_status')
                        ->insert(
                            [
                                'm_id' => $value, 'Rounds_ID' => $Rounds_ID, 'user_id' => $user_id
                            ]
                        );
                }
            }
        }
    }



    public static function PMS_List_Factors_Score_Self()
    {
        $Query_Factors_Score_Self =  DB::connection('mysql_public')
            ->table('pms_score_user')
            ->select('Factors_ID', 'Score_Self', 'Score_App_1', 'Score_App_2')
            ->where('Score_Category', 'Individual')
            ->where('Rounds_ID', Session::get('Rounds_ID'))
            ->where('employeeID', Session::get('Admin_User_Running'))
            ->get();
        $Query_Factors_Score_Self_Count =  DB::connection('mysql_public')
            ->table('pms_score_user')
            ->where('Score_Category', 'Individual')
            ->where('Rounds_ID', Session::get('Rounds_ID'))
            ->where('employeeID', Session::get('Admin_User_Running'))
            ->count();

        return array($Query_Factors_Score_Self, $Query_Factors_Score_Self_Count);
    }

    public static function PMS_List_Competency_Score_Self()
    {
        $Query_Factors_Score_Self =  DB::connection('mysql_public')
            ->table('pms_score_user')
            ->select('Factors_ID', 'Score_Self', 'Score_App_1', 'Score_App_2')
            ->where('Score_Category', 'Competency')
            ->where('Rounds_ID', Session::get('Rounds_ID'))
            ->where('employeeID', Session::get('Admin_User_Running'))
            ->get();
        $Query_Factors_Score_Self_Count =  DB::connection('mysql_public')
            ->table('pms_score_user')
            ->where('Score_Category', 'Competency')
            ->where('Rounds_ID', Session::get('Rounds_ID'))
            ->where('employeeID', Session::get('Admin_User_Running'))
            ->count();
        return array($Query_Factors_Score_Self, $Query_Factors_Score_Self_Count);
    }
    public static function PMS_List_Behavior_Score_Self()
    {
        $Query_Factors_Score_Self =  DB::connection('mysql_public')
            ->table('pms_score_user')
            ->select('Factors_ID', 'Score_Self', 'Score_App_1', 'Score_App_2')
            ->where('Score_Category', 'Behavior')
            ->where('Rounds_ID', Session::get('Rounds_ID'))
            ->where('employeeID', Session::get('Admin_User_Running'))
            ->get();
        $Query_Factors_Score_Self_Count =  DB::connection('mysql_public')
            ->table('pms_score_user')
            ->where('Score_Category', 'Behavior')
            ->where('Rounds_ID', Session::get('Rounds_ID'))
            ->where('employeeID', Session::get('Admin_User_Running'))
            ->count();
        return array($Query_Factors_Score_Self, $Query_Factors_Score_Self_Count);
    }
    public static function PMS_List_Functional_Score_Self()
    {
        $Query_Factors_Score_Self =  DB::connection('mysql_public')
            ->table('pms_score_user')
            ->select('Factors_ID', 'Score_Self', 'Score_App_1', 'Score_App_2')
            ->where('Score_Category', 'Functional')
            ->where('Rounds_ID', Session::get('Rounds_ID'))
            ->where('employeeID', Session::get('Admin_User_Running'))
            ->get();
        $Query_Factors_Score_Self_Count =  DB::connection('mysql_public')
            ->table('pms_score_user')
            ->where('Score_Category', 'Functional')
            ->where('Rounds_ID', Session::get('Rounds_ID'))
            ->where('employeeID', Session::get('Admin_User_Running'))
            ->count();
        return array($Query_Factors_Score_Self, $Query_Factors_Score_Self_Count);
    }
    public static function PMS_List_Managerial_Score_Self()
    {
        $Query_Factors_Score_Self =  DB::connection('mysql_public')
            ->table('pms_score_user')
            ->select('Factors_ID', 'Score_Self', 'Score_App_1', 'Score_App_2')
            ->where('Score_Category', 'Managerial')
            ->where('Rounds_ID', Session::get('Rounds_ID'))
            ->where('employeeID', Session::get('Admin_User_Running'))
            ->get();
        $Query_Factors_Score_Self_Count =  DB::connection('mysql_public')
            ->table('pms_score_user')
            ->where('Score_Category', 'Managerial')
            ->where('Rounds_ID', Session::get('Rounds_ID'))
            ->where('employeeID', Session::get('Admin_User_Running'))
            ->count();
        return array($Query_Factors_Score_Self, $Query_Factors_Score_Self_Count);
    }


    public static function PMS_Text_Self()
    {
        $Query_Text_Self =  DB::connection('mysql_public')
            ->table('pms_score_user_text')
            ->select('Project_Self', 'Note_Self', 'Note_App_1', 'Goodnote_App_1', 'Badnote_App_1', 'Note_App_2', 'Goodnote_App_2', 'Badnote_App_2')
            ->where('Rounds_ID', Session::get('Rounds_ID'))
            ->where('employeeID', Session::get('Admin_User_Running'))
            ->get();
        return array($Query_Text_Self);
    }


    public static function List_Project()
    {
        $Query_List_Project =  DB::connection('mysql_public')
            ->table('pms_score_user_project')
            ->select('*')
            ->where('Rounds_ID', Session::get('Rounds_ID'))
            ->where('employeeID', Session::get('Admin_User_Running'))
            ->first();
        return $Query_List_Project;
    }

    public static function List_Factor()
    {
        $Query_List_Factor = DB::connection('mysql_public')->table('pms_score_user_factor')
            ->select('*')
            ->where('Rounds_ID', Session::get('Rounds_ID'))
            ->first();
        return $Query_List_Factor;
    }



    public static function PMS_Form_Self_Evaluate($POST_DATA)
    {


        $Action = $POST_DATA['Action'];

        $Array_Factors_ID = $POST_DATA['Array_Factors_ID'];
        $Array_Competency_ID = $POST_DATA['Array_Competency_ID'];
        // $Array_Behavior_ID = $POST_DATA['Array_Behavior_ID'];
        $Array_Functional_ID = $POST_DATA['Array_Functional_ID'];
        // $Array_Managerial_ID = $POST_DATA['Array_Managerial_ID'];


        $Array_Factors_Self = $POST_DATA['Array_Factors_Self'];
        $Array_Competency_Self = $POST_DATA['Array_Competency_Self'];
        // $Array_Behavior_Self = $POST_DATA['Array_Behavior_Self'];
        $Array_Functional_Self = $POST_DATA['Array_Functional_Self'];
        $Array_Managerial_Self = $POST_DATA['Array_Managerial_Self'];
        $Project_Self = $POST_DATA['Project_Self'];
        $Note_Self = $POST_DATA['Note_Self'];



        $Array_Factors_App_1 = $POST_DATA['Array_Factors_App_1'];
        $Array_Competency_App_1 = $POST_DATA['Array_Competency_App_1'];
        $Array_Behavior_App_1 = $POST_DATA['Array_Behavior_App_1'];
        $Array_Functional_App_1 = $POST_DATA['Array_Functional_App_1'];
        $Array_Managerial_App_1 = $POST_DATA['Array_Managerial_App_1'];
        $Note_App_1 = $POST_DATA['Note_App_1'];
        $Goodnote_App_1 = $POST_DATA['Goodnote_App_1'];
        $Badnote_App_1 = $POST_DATA['Badnote_App_1'];


        $Array_Factors_App_2 = $POST_DATA['Array_Factors_App_2'];
        $Array_Competency_App_2 = $POST_DATA['Array_Competency_App_2'];
        $Array_Behavior_App_2 = $POST_DATA['Array_Behavior_App_2'];
        $Array_Functional_App_2 = $POST_DATA['Array_Functional_App_2'];
        $Array_Managerial_App_2 = $POST_DATA['Array_Managerial_App_2'];
        $Note_App_2 = $POST_DATA['Note_App_2'];
        $Goodnote_App_2 = $POST_DATA['Goodnote_App_2'];
        $Badnote_App_2 = $POST_DATA['Badnote_App_2'];



        $Project_1_Name = $POST_DATA['Project_1_Name'];
        $Project_2_Name = $POST_DATA['Project_2_Name'];
        $Project_3_Name = $POST_DATA['Project_3_Name'];
        $Project_4_Name = $POST_DATA['Project_4_Name'];
        $Project_5_Name = $POST_DATA['Project_5_Name'];

        $Project_1_Desc = $POST_DATA['Project_1_Desc'];
        $Project_2_Desc = $POST_DATA['Project_2_Desc'];
        $Project_3_Desc = $POST_DATA['Project_3_Desc'];
        $Project_4_Desc = $POST_DATA['Project_4_Desc'];
        $Project_5_Desc = $POST_DATA['Project_5_Desc'];

        $Project_1_Self = $POST_DATA['Project_1_Self'];
        $Project_2_Self = $POST_DATA['Project_2_Self'];
        $Project_3_Self = $POST_DATA['Project_3_Self'];
        $Project_4_Self = $POST_DATA['Project_4_Self'];
        $Project_5_Self = $POST_DATA['Project_5_Self'];

        $Project_1_App_1 = $POST_DATA['Project_1_App_1'];
        $Project_2_App_1 = $POST_DATA['Project_2_App_1'];
        $Project_3_App_1 = $POST_DATA['Project_3_App_1'];
        $Project_4_App_1 = $POST_DATA['Project_4_App_1'];
        $Project_5_App_1 = $POST_DATA['Project_5_App_1'];

        $Project_1_App_2 = $POST_DATA['Project_1_App_2'];
        $Project_2_App_2 = $POST_DATA['Project_2_App_2'];
        $Project_3_App_2 = $POST_DATA['Project_3_App_2'];
        $Project_4_App_2 = $POST_DATA['Project_4_App_2'];
        $Project_5_App_2 = $POST_DATA['Project_5_App_2'];




        $user_running = $POST_DATA['user_running'];
        $Rounds_ID = $POST_DATA['Rounds_ID'];


        //DD($user_running,$Rounds_ID,$Array_Competency_ID,$Array_Competency_Self);


        DB::connection('mysql_public')
            ->table('pms_score_user')
            ->where('Rounds_ID', $Rounds_ID)
            ->where('employeeID', $user_running)
            ->delete();

        DB::connection('mysql_public')
            ->table('pms_score_user_text')
            ->where('Rounds_ID', $Rounds_ID)
            ->where('employeeID', $user_running)
            ->delete();


        DB::connection('mysql_public')
            ->table('pms_score_user_project')
            ->where('Rounds_ID', $Rounds_ID)
            ->where('employeeID', $user_running)
            ->delete();


        foreach ($Array_Factors_ID as $key => $value) {
            // $Score_Self=$Array_Factors_Self[$key];
            // $Factors_ID=$value;

            DB::connection('mysql_public')
                ->table('pms_score_user')
                ->insert(
                    [
                        'Rounds_ID' => $Rounds_ID, 'employeeID' => $user_running, 'Score_Category' => 'Individual', 'Factors_ID' =>  $value, 'Score_Self' => $Array_Factors_Self[$key], 'Score_App_1' =>  (isset($Array_Factors_App_1[$key]) ? $Array_Factors_App_1[$key] : 0), 'Score_App_2' =>  (isset($Array_Factors_App_2[$key]) ? $Array_Factors_App_2[$key] : 0)
                    ]
                );
        }


        foreach ($Array_Competency_ID as $key => $value) {
            DB::connection('mysql_public')
                ->table('pms_score_user')
                ->insert(
                    [
                        'Rounds_ID' => $Rounds_ID, 'employeeID' => $user_running, 'Score_Category' => 'Competency', 'Factors_ID' =>  $value, 'Score_Self' => $Array_Competency_Self[$key], 'Score_App_1' => (isset($Array_Competency_App_1[$key]) ? $Array_Competency_App_1[$key] : 0), 'Score_App_2' => (isset($Array_Competency_App_2[$key]) ? $Array_Competency_App_2[$key] : 0)
                    ]
                );
        }


        /* foreach ($Array_Behavior_ID as $key => $value) {
            DB::connection('mysql_public')
                ->table('pms_score_user')
                ->insert(
                    [
                        'Rounds_ID' => $Rounds_ID, 'employeeID' => $user_running, 'Score_Category' => 'Behavior', 'Factors_ID' =>  $value, 'Score_Self' => $Array_Behavior_Self[$key], 'Score_App_1' => $Array_Behavior_App_1[$key], 'Score_App_2' => $Array_Behavior_App_2[$key]
                    ]
                );
        } */

        if (is_array($Array_Functional_ID) || is_object($Array_Functional_ID)) {
            foreach ($Array_Functional_ID as $key => $value) {
                DB::connection('mysql_public')
                    ->table('pms_score_user')
                    ->insert(
                        [
                            'Rounds_ID' => $Rounds_ID, 'employeeID' => $user_running, 'Score_Category' => 'Functional', 'Factors_ID' =>  $value, 'Score_Self' => $Array_Functional_Self[$key], 'Score_App_1' => (isset($Array_Functional_App_1[$key]) ? $Array_Functional_App_1[$key] : 0), 'Score_App_2' => (isset($Array_Functional_App_2[$key]) ? $Array_Functional_App_2[$key] : 0)
                        ]
                    );
            }
        }


        /* foreach ($Array_Managerial_ID as $key => $value) {
            DB::connection('mysql_public')
                ->table('pms_score_user')
                ->insert(
                    [
                        'Rounds_ID' => $Rounds_ID, 'employeeID' => $user_running, 'Score_Category' => 'Managerial', 'Factors_ID' =>  $value, 'Score_Self' => $Array_Managerial_Self[$key], 'Score_App_1' => $Array_Managerial_App_1[$key], 'Score_App_2' => $Array_Managerial_App_2[$key]
                    ]
                );
        } */


        DB::connection('mysql_public')
            ->table('pms_score_user_text')
            ->insert(
                [
                    'Rounds_ID' => $Rounds_ID, 'employeeID' => $user_running, 'Project_Self' => $Project_Self, 'Note_Self' =>  $Note_Self, 'Note_App_1' => $Note_App_1, 'Goodnote_App_1' => $Goodnote_App_1, 'Badnote_App_1' => $Badnote_App_1, 'Note_App_2' => $Note_App_2, 'Goodnote_App_2' => $Goodnote_App_2, 'Badnote_App_2' => $Badnote_App_2
                ]
            );





        DB::connection('mysql_public')
            ->table('pms_score_user_project')
            ->insert(
                [
                    'Rounds_ID' => $Rounds_ID, 'employeeID' => $user_running, 'Project_1_Name' => $Project_1_Name, 'Project_2_Name' => $Project_2_Name, 'Project_3_Name' => $Project_3_Name, 'Project_4_Name' => $Project_4_Name, 'Project_5_Name' => $Project_5_Name, 'Project_1_Desc' => $Project_1_Desc, 'Project_2_Desc' => $Project_2_Desc, 'Project_3_Desc' => $Project_3_Desc, 'Project_4_Desc' => $Project_4_Desc, 'Project_5_Desc' => $Project_5_Desc, 'Project_1_Self' => $Project_1_Self, 'Project_2_Self' => $Project_2_Self, 'Project_3_Self' => $Project_3_Self, 'Project_4_Self' => $Project_4_Self, 'Project_5_Self' => $Project_5_Self, 'Project_1_App_1' => $Project_1_App_1, 'Project_2_App_1' => $Project_2_App_1, 'Project_3_App_1' => $Project_3_App_1, 'Project_4_App_1' => $Project_4_App_1, 'Project_5_App_1' => $Project_5_App_1, 'Project_1_App_2' => $Project_1_App_2, 'Project_2_App_2' => $Project_2_App_2, 'Project_3_App_2' => $Project_3_App_2, 'Project_4_App_2' => $Project_4_App_2, 'Project_5_App_2' => $Project_5_App_2
                ]
            );


        return DB::connection('mysql_public')
            ->table('pms_round_user')
            ->where('Rounds_ID', $Rounds_ID)
            ->where('employeeID', $user_running)
            ->update(
                [
                    'Step_1_Status' => $Action, 'Step_2_Status' => 'Wait', 'Step_3_Status' => 'Wait'
                ]
            );
    }


    public static function DEMO($POST_DATA)
    {

        $Rounds_ID = $POST_DATA['Rounds_ID'];
        $user_running = $POST_DATA['user_running'];
        $Check_Factors_Custom = $POST_DATA['Check_Factors_Custom'];



        DB::connection('mysql_public')
            ->table('pms_factors_custom')
            ->where('Rounds_ID', $Rounds_ID)
            ->where('employeeID', $user_running)
            ->delete();

        foreach ($Check_Factors_Custom as $key => $value) {

            $Add_Custom_Factor_Check = DB::connection('mysql_public')
                ->table('pms_factors_custom')
                ->insert(
                    [
                        'Rounds_ID'  => $Rounds_ID, 'employeeID' => $user_running, 'Factors_ID' => $value
                    ]
                );
        }


        return  $Add_Custom_Factor_Check;
    }
}
