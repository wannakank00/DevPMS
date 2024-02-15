<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DetailRoundModel;
use App\Models\ListRoundModel;

class DetailRoundController extends Controller
{
    public static function PMS_Detail_Rounds(Request $request,$Action,$Rounds_ID){
      
        if(Session::get('Admin_Fullname') == NULL){ return redirect("/BOF");  } 

        if($Action=='Add'){

            return view("PMS_Detail_Rounds_V");

        }elseif($Action=='Edit'){

            $GET_DATA['Rounds_ID'] = $Rounds_ID;
            $GET_DATA['Data_Rounds'] = DetailRoundModel::PMS_Get_Detail_Rounds_For_Edit($GET_DATA);
            return view("PMS_Detail_Rounds_V",$GET_DATA);

        }elseif($Action=='Delete'){

            $GET_DATA['Rounds_ID'] = $Rounds_ID;
            $DATA['PMS_Delete_Rounds'] = DetailRoundModel::PMS_Delet_Rounds($GET_DATA);
            if($DATA['PMS_Delete_Rounds']==true){

                $GET_DATA['Action_Result'] = 'Deleted';
                $GET_DATA['Data_Rounds'] = ListRoundModel::PMS_List_Rounds();
                return view("PMS_List_Rounds_V",$GET_DATA);
            }else{

                return redirect("/PMS_List_Rounds");
            }

        }elseif($Action=='Edit_Status_On'){

            $GET_DATA['Rounds_ID'] = $Rounds_ID;
            $GET_DATA['PMS_Edit_Status_Rounds'] = DetailRoundModel::PMS_Edit_Status_Rounds_On($GET_DATA);
            if($GET_DATA['PMS_Edit_Status_Rounds']==true){
                $GET_DATA['Action_Result'] = 'Edited_Status';
                $GET_DATA['Data_Rounds'] = ListRoundModel::PMS_List_Rounds();
                return view("PMS_List_Rounds_V",$GET_DATA);
            }else{
                return redirect("/PMS_List_Rounds");
            }

        }elseif($Action=='Edit_Status_Off'){

            $GET_DATA['Rounds_ID'] = $Rounds_ID;
            $GET_DATA['PMS_Edit_Status_Rounds'] = DetailRoundModel::PMS_Edit_Status_Rounds_Off($GET_DATA);
            if($GET_DATA['PMS_Edit_Status_Rounds']==true){
                $GET_DATA['Action_Result'] = 'Edited_Status';
                $GET_DATA['Data_Rounds'] = ListRoundModel::PMS_List_Rounds();
                return view("PMS_List_Rounds_V",$GET_DATA);
            }else{
                return redirect("/PMS_List_Rounds");
            }

        }

       
    }


    public static function PMS_Add_Rounds(Request $request){
  
        if(Session::get('Admin_Fullname') == NULL){ return redirect("/BOF");  } 

        $POST_DATA['Rounds_Name'] = trim($request->input('Rounds_Name'));
        // $POST_DATA['Rounds_Start'] = $request->input('Rounds_Start');
        // $POST_DATA['Rounds_End'] = $request->input('Rounds_End');

        $POST_DATA['Round_Range'] = trim($request->input('Round_Range'));
        $Round_Range=$POST_DATA['Round_Range'];
        $Round_Range_explode = explode(" ",$Round_Range);
        $Rounds_Start=$Round_Range_explode[0];
        $Rounds_End=$Round_Range_explode[2];

        $Rounds_Start_explode = explode("/",$Rounds_Start); 
        $Rounds_Start_New = ($Rounds_Start_explode[2]+543).'-'.$Rounds_Start_explode[0].'-'.$Rounds_Start_explode[1]; 
        $POST_DATA['Rounds_Start'] = $Rounds_Start_New;

        $Rounds_End_explode = explode("/",$Rounds_End); 
        $Rounds_End_New = ($Rounds_End_explode[2]+543).'-'.$Rounds_End_explode[0].'-'.$Rounds_End_explode[1]; 
        $POST_DATA['Rounds_End'] = $Rounds_End_New;

        
      //  DD($POST_DATA);
        $DATA['PMS_Add_Rounds'] = DetailRoundModel::PMS_Add_Rounds($POST_DATA);

        if($DATA['PMS_Add_Rounds']==true){

            $GET_DATA['Action_Result'] = 'Success';
            $GET_DATA['Data_Rounds'] = ListRoundModel::PMS_List_Rounds();
            return view("PMS_List_Rounds_V",$GET_DATA);
        }else{
            return redirect("/PMS_Detail_Rounds/Add/0");
        }
     

       
    }

 
    
    public static function PMS_Edit_Rounds(Request $request){
  
        if(Session::get('Admin_Fullname') == NULL){ return redirect("/BOF");  } 

        $POST_DATA['Rounds_ID'] = trim($request->input('Rounds_ID'));
        $POST_DATA['Rounds_Name'] = trim($request->input('Rounds_Name'));
        // $POST_DATA['Rounds_Start'] = $request->input('Rounds_Start');
        // $POST_DATA['Rounds_End'] = $request->input('Rounds_End');
        
        $POST_DATA['Round_Range'] = trim($request->input('Round_Range'));
        $Round_Range=$POST_DATA['Round_Range'];
        $Round_Range_explode = explode(" ",$Round_Range);
        $Rounds_Start=$Round_Range_explode[0];
        $Rounds_End=$Round_Range_explode[2];

        $Rounds_Start_explode = explode("/",$Rounds_Start); 
        $Rounds_Start_New = ($Rounds_Start_explode[2]+543).'-'.$Rounds_Start_explode[0].'-'.$Rounds_Start_explode[1]; 
        $POST_DATA['Rounds_Start'] = $Rounds_Start_New;

        $Rounds_End_explode = explode("/",$Rounds_End); 
        $Rounds_End_New = ($Rounds_End_explode[2]+543).'-'.$Rounds_End_explode[0].'-'.$Rounds_End_explode[1]; 
        $POST_DATA['Rounds_End'] = $Rounds_End_New;




        $DATA['PMS_Edit_Rounds'] = PMS_Detail_Rounds_M::PMS_Edit_Rounds($POST_DATA);
     
        if($DATA['PMS_Edit_Rounds']==true){

            $GET_DATA['Action_Result'] = 'Edited';
            $GET_DATA['Data_Rounds'] = PMS_List_Rounds_M::PMS_List_Rounds();
            return view("PMS_List_Rounds_V",$GET_DATA);
        }else{
            return redirect("/PMS_List_Rounds");
        }
       
    }
}
