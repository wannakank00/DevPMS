<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EvaluateModel;
use App\Models\PMSWelcomeModel;
use App\Models\HistoryScoreModel;
use App\Http\Controllers\LeaveEmployeeController;
use Session;

class EvaluateController extends Controller
{
    public function Evaluate()
    {
        if (Session::get('Admin_Fullname') == NULL)
        {
            return redirect("/");
        }
        if (Session::get('Rounds_ID') == NULL || Session::get('user_running'))
        {
            return redirect("/");
        }
    
        $GET_DATA['Rounds_ID'] = Session::get('Rounds_ID');
        $GET_DATA['user_running'] = Session::get('Admin_User_Running');
    
        $GET_DATA['Data_Rounds'] = EvaluateModel::PMS_Get_Data_Rounds($GET_DATA);
        $GET_DATA['PMS_Get_Approver_Status_This_Employee'] = EvaluateModel::PMS_Get_Approver_Status_This_Employee($GET_DATA);
        if($GET_DATA['PMS_Get_Approver_Status_This_Employee'][1]['Step_1_Status'][$GET_DATA['user_running']] != 'Finished'){
            return redirect()->route('Evaluate');
        }
      
    
        $GET_DATA['List_Factors'] = EvaluateModel::PMS_List_Factors();
        $GET_DATA['List_Competency'] = EvaluateModel::PMS_List_Competency();
        $GET_DATA['List_Functional'] = EvaluateModel::PMS_List_Functional();
    
          // ดึงหัวข้อ Managerial
          foreach ($GET_DATA['PMS_Get_Approver_Status_This_Employee'][0] as $row) {
            $mLevel = $row->mLevel;
            $user_id = $row->employeeID;
        }
    
        $leaveEmployeeController = new LeaveEmployeeController();
        $year = base64_encode(date("Y"));
        $getuser_id = base64_encode($user_id);
        $leaveEmployeeData = $leaveEmployeeController->getLeaveEmpData($getuser_id,$year);
        $responseData = $leaveEmployeeData->getData();
        $data = $responseData->data;
    
        $PMS_Get_Leave_Quota = $leaveEmployeeController->convertData($data);
        $GET_DATA['PMS_Get_Leave_Quota'] = $PMS_Get_Leave_Quota;
    
        $check = EvaluateModel::PMS_Check_Chosen_Managerial($user_id, $GET_DATA['user_running'], $GET_DATA['Rounds_ID']);
        // Check role ไหนที่ level มีสิทธิ์เข้าถึง Managerial
        $match_level = EvaluateModel::PMS_Check_Managerial_byRole($mLevel);
    
        // ถ้าเกิดเป็นพนักงานใน list no sub จะไม่มี Managerial
        if ($check) {
            // if (!empty($match_level)) {
            if ($match_level > 0) {
                $GET_DATA['List_Topic_Managerial'] = EvaluateModel::PMS_Topic_List_Managerial();
                $GET_DATA['List_Managerial'] = EvaluateModel::PMS_List_Managerial_byRole($mLevel);
                $GET_DATA['List_checkbox_Managerial'] = EvaluateModel::PMS_List_Checkbox_Managerial($user_id, $GET_DATA['Rounds_ID']);
                $GET_DATA['List_score_managerial'] = EvaluateModel::PMS_score_managerial($user_id, $GET_DATA['Rounds_ID']);
                $GET_DATA['Count_MF_ID'] = EvaluateModel::getPmsCountMfManagerial();
                // หา chosen หา m1,m2 เพื่อเอา managerial
            }
        }
        $GET_DATA['List_Factors_Score_Self'] = EvaluateModel::PMS_List_Factors_Score_Self();
    
        $GET_DATA['List_Competency_Score_Self'] = EvaluateModel::PMS_List_Competency_Score_Self();
        $GET_DATA['List_Functional_Score_Self'] = EvaluateModel::PMS_List_Functional_Score_Self();
        $GET_DATA['List_Managerial_Score_Self'] = EvaluateModel::PMS_List_Managerial_Score_Self();
    
        $GET_DATA['Text_Self'] = EvaluateModel::PMS_Text_Self();
    
        $GET_DATA['List_Project'] = EvaluateModel::List_Project();
        $GET_DATA['List_Factor'] = EvaluateModel::List_Factor();
        
      
        $GET_DATA['History_List_Round'] = HistoryScoreModel::PMS_History_List_Round();
        $GET_DATA['History_List_Score'] = HistoryScoreModel::PMS_History_List_Score($GET_DATA['user_running'], $GET_DATA['History_List_Round']);
    
        $GET_DATA['PMS_List_Sup_No_sub'] = PMSWelcomeModel::PMS_List_Sup_No_sub();
    
        $GET_DATA['Factor_User'] = EvaluateModel::PMS_Get_Factor_User($GET_DATA);
        return view("EvaluateView", $GET_DATA);
        } 

}
