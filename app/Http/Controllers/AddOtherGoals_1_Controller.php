<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PMSWelcomeModel;
use Session;

class AddOtherGoals_1_Controller extends Controller
{
    public function AddOtherGoals()
    {
        $GET_DATA = [];
      $GET_DATA['Rounds_ID'] = Session::get('Rounds_ID');
      $GET_DATA['user_running'] = Session::get('Admin_User_Running');        
      $GET_DATA['Data_Rounds'] = PMSWelcomeModel::PMS_Get_Data_Rounds($GET_DATA);
      $GET_DATA['PMS_Get_Approver_Status_This_Employee'] = PMSWelcomeModel::PMS_Get_Approver_Status_This_Employee($GET_DATA);
      $GET_DATA['PMS_Get_List_User_Added'] = PMSWelcomeModel::PMS_Get_List_User_Added($GET_DATA);
      $GET_DATA['PMS_List_Sup_No_sub'] = PMSWelcomeModel::PMS_List_Sup_No_sub();
      $GET_DATA['Factor_User'] = PMSWelcomeModel::PMS_Get_Factor_User($GET_DATA);
        return view("AddOtherGoals_1_View", $GET_DATA);
    }
}
