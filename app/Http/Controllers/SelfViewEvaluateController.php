<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SelfViewEvaluateModel;
use App\Models\SelfEvaluateModel;
use App\Models\HistoryScoreModel;
use App\Http\Controller\LeaveEmployeeController;
use Session;


class SelfViewEvaluateController extends Controller
{
  public static function PMS_Self_View_Evaluate()
  {
    if (Session::get('Admin_Fullname') == NULL) {
        return redirect("/");
      }
      if (Session::get('Rounds_ID') == NULL || Session::get('user_running')) {
        return redirect("/");
      }
    //   DD(Session::get('Rounds_ID'));
  
      $GET_DATA['Rounds_ID'] = Session::get('Rounds_ID');
      $GET_DATA['user_running'] = Session::get('Admin_User_Running');
  
      $GET_DATA['Data_Rounds'] = SelfViewEvaluateModel::PMS_Get_Data_Rounds($GET_DATA);
      $GET_DATA['PMS_Get_Approver_Status_This_Employee'] = SelfViewEvaluateModel::PMS_Get_Approver_Status_This_Employee($GET_DATA);
      // $GET_DATA['PMS_Get_Leave_Quota'] = PMS_Self_Evaluate_M::PMS_Get_Leave_Quota($GET_DATA);
      $Emp_JF_ID = $GET_DATA['PMS_Get_Approver_Status_This_Employee'][0][0]->jfemp_jf;
  
      /********** Question **********/
      $GET_DATA['List_Factors'] = SelfViewEvaluateModel::PMS_List_Factors();
      $GET_DATA['List_Competency'] = SelfViewEvaluateModel::PMS_List_Competency();
      $GET_DATA['List_Functional'] = SelfViewEvaluateModel::PMS_List_Functional($Emp_JF_ID);

      // ดึงหัวข้อ Managerial
      foreach ($GET_DATA['PMS_Get_Approver_Status_This_Employee'][0] as $row) {
        // dd($row->mLevel);
        $mLevel = $row->mLevel;
        $user_id = $row->employeeID;
      }
  
      $leaveEmployeeController = new LeaveEmployeeController();
      $year = base64_encode(date("Y"));
      $getuser_id = base64_encode($user_id);
      $leaveEmployeeData = $leaveEmployeeController->getLeaveEmpData($getuser_id, $year);
      $responseData = $leaveEmployeeData->getData();
      $data = $responseData->data;
  
      $PMS_Get_Leave_Quota = $leaveEmployeeController->convertData($data);
      $GET_DATA['PMS_Get_Leave_Quota'] = $PMS_Get_Leave_Quota;
  
      $GET_DATA['List_Topic_Managerial'] = SelfViewEvaluateModel::PMS_Topic_List_Managerial();
      $match_level = SelfViewEvaluateModel::PMS_Check_Managerial_byRole($mLevel);
  
      // dd($user_id);
      $check = SelfViewEvaluateModel::PMS_Check_Chosen_Managerial($user_id, $GET_DATA['user_running'], $GET_DATA['Rounds_ID']);
  
      // dd($check);
      // if (!empty($check)) {
        
      if ($check) {
        if (!empty($match_level)) {
          $GET_DATA['List_Managerial'] = SelfViewEvaluateModel::PMS_List_Managerial_byRole($mLevel);
          $GET_DATA['List_checkbox_Managerial'] = SelfViewEvaluateModel::PMS_List_Checkbox_Managerial($user_id, $GET_DATA['Rounds_ID']);
          $GET_DATA['List_score_managerial'] = SelfViewEvaluateModel::PMS_score_managerial($user_id, $GET_DATA['Rounds_ID']);
          $GET_DATA['Count_MF_ID'] = SelfViewEvaluateModel::getPmsCountMfManagerial();
          // dd($GET_DATA['List_score_managerial']);
          // หา chosen หา m1,m2 เพื่อเอา managerial
        }
      }
      /********** Answer Self**********/
      $GET_DATA['List_Factors_Score_Self'] = SelfViewEvaluateModel::PMS_List_Factors_Score_Self($GET_DATA);
      $GET_DATA['List_Competency_Score_Self'] = SelfViewEvaluateModel::PMS_List_Competency_Score_Self($GET_DATA);
      $GET_DATA['List_Functional_Score_Self'] = SelfViewEvaluateModel::PMS_List_Functional_Score_Self($GET_DATA);
      $GET_DATA['List_Managerial_Score_Self'] = SelfViewEvaluateModel::PMS_List_Managerial_Score_Self($GET_DATA);
      $GET_DATA['Text_Self'] = SelfViewEvaluateModel::PMS_Text_Self($GET_DATA);
  
      $GET_DATA['List_Project'] = SelfViewEvaluateModel::List_Project($GET_DATA);
      $GET_DATA['List_Factor'] = SelfEvaluateModel::List_Factor();
  
  
      $GET_DATA['History_List_Round'] = HistoryScoreModel::PMS_History_List_Round();
      $GET_DATA['History_List_Score'] = HistoryScoreModel::PMS_History_List_Score($GET_DATA['user_running'], $GET_DATA['History_List_Round']);
      $GET_DATA['Factor_User'] = SelfViewEvaluateModel::PMS_Get_Factor_User($GET_DATA);
      return view("SelfViewEvaluateView", $GET_DATA);
    }
  }
