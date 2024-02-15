<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class HistoryScoreModel extends Model
{
    public static function PMS_History_List_Round()
    {

        $Get_Data_Rounds = DB::connection('mysql_public')
            ->table('pms_rounds')
            ->select('*')
            ->get();

        //DD($Get_Data_Rounds);
        return array($Get_Data_Rounds);
    }

    public static function PMS_History_List_Score($user_running, $List_Round)
    {
        //    $Rounds_ID=11;
        // DD($List_Round[0]);

        foreach ($List_Round[0] as $row) {
            $Rounds_ID = $row->Rounds_ID;
            //   DD($Rounds_ID);
            $Get_Score_Individual[$Rounds_ID] =  DB::connection('mysql_public')
                ->table('pms_score_user')
                ->select('employeeID', 'Score_Category', 'Score_Self', 'Score_App_1', 'Score_App_2')
                ->where('employeeID', $user_running)
                ->where('Rounds_ID', $Rounds_ID)
                ->where('Score_Category', 'Individual')
                ->get();

            $Get_Score_Competency[$Rounds_ID] =  DB::connection('mysql_public')
                ->table('pms_score_user')
                ->select('employeeID', 'Score_Category', 'Score_Self', 'Score_App_1', 'Score_App_2')
                ->where('employeeID', $user_running)
                ->where('Rounds_ID', $Rounds_ID)
                ->where('Score_Category', 'Competency')
                ->get();

            $Get_Score_Behavior[$Rounds_ID] =  DB::connection('mysql_public')
                ->table('pms_score_user')
                ->select('employeeID', 'Score_Category', 'Score_Self', 'Score_App_1', 'Score_App_2')
                ->where('employeeID', $user_running)
                ->where('Rounds_ID', $Rounds_ID)
                ->where('Score_Category', 'Behavior')
                ->get();


            $Get_Score_Functional[$Rounds_ID] =  DB::connection('mysql_public')
                ->table('pms_score_user')
                ->select('employeeID', 'Score_Category', 'Score_Self', 'Score_App_1', 'Score_App_2')
                ->where('employeeID', $user_running)
                ->where('Rounds_ID', $Rounds_ID)
                ->where('Score_Category', 'Functional')
                ->get();


            $Get_Score_Managerial[$Rounds_ID] =  DB::connection('mysql_public')
                ->table('pms_score_user')
                ->select('employeeID', 'Score_Category', 'Score_Self', 'Score_App_1', 'Score_App_2')
                ->where('employeeID', $user_running)
                ->where('Rounds_ID', $Rounds_ID)
                ->where('Score_Category', 'Managerial')
                ->get();

            $Get_List_Project[$Rounds_ID] =  DB::connection('mysql_public')
                ->table('pms_score_user_project')
                ->select('*')
                ->where('Rounds_ID', $Rounds_ID)
                ->where('employeeID', $user_running)
                ->get();
        }

        return array($Get_Score_Individual, $Get_Score_Competency, $Get_Score_Behavior, $Get_Score_Functional, $Get_Score_Managerial, $Get_List_Project);
    }
}
