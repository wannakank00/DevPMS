<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserLoginModel;
use App\Models\PMSWelcomeModel;
use App\Models\PmsRound;
use Session;
use DB;

class UserLoginController extends Controller
{
    public function login(Request $request)
    {
        $Data_Check['esUsername'] = $request->input('esUsername');
        $Data_Check['esPassword'] = $request->input('esPassword');

        $Data['UserLogin'] = UserLoginModel::UserLogin($Data_Check); 
        // dd($Data);
        if ($Data['UserLogin'] == "TRUE") {
            $GET_DATA['Rounds_ID'] = Session::get('Rounds_ID');
            $GET_DATA['user_running'] = Session::get('Admin_User_Running');
            $GET_DATA['Data_Rounds'] = PMSWelcomeModel::PMS_Get_Data_Rounds($GET_DATA);
            $GET_DATA['PMS_Get_Approver_Status_This_Employee'] = PMSWelcomeModel::PMS_Get_Approver_Status_This_Employee($GET_DATA);
            $GET_DATA['PMS_Get_List_User_Added'] = PMSWelcomeModel::PMS_Get_List_User_Added($GET_DATA);
            $GET_DATA['Factor_User'] = PMSWelcomeModel::PMS_Get_Factor_User($GET_DATA);
            
            $GET_DATA['Action_Result'] = "Login_Success";
            }   
            return view('PMSWelcomeView');
    }

}
