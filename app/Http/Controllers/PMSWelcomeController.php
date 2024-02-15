<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PmsAdmin;
use App\Models\PmsUser;
use App\Models\PmsRound;
use Session;
use Illuminate\Support\Facades\Cache;
use App\Http\Models\PMSWelcomeModel;

class PMSWelcomeController extends Controller
{
    public static function PMS_Welcome()
    {

        if (Session::get('Admin_Fullname') != NULL) {
            // ถ้ามีค่าใน Session
            return redirect('DashboardAdminView');
        } else {
            // ถ้าไม่มีค่าใน Session
            return redirect('/');
        }

        # ตรวจสอบระยะเวลาผู้มีสิทธิเข้าทำประเมิน
        Cache::flush();
        $GET_DATA['permission_period'] = Cache::get('get_permission_period');

        $GET_DATA['Rounds_ID'] = Session::get('Rounds_ID');
        $GET_DATA['user_running'] = Session::get('Admin_User_Running');        
        $GET_DATA['Data_Rounds'] = PMSWelcomeModel::PMS_Get_Data_Rounds($GET_DATA);
        $GET_DATA['PMS_Get_Approver_Status_This_Employee'] = PMSWelcomeModel::PMS_Get_Approver_Status_This_Employee($GET_DATA);
        $GET_DATA['PMS_Get_List_User_Added'] = PMSWelcomeModel::PMS_Get_List_User_Added($GET_DATA);
        $GET_DATA['PMS_List_Sup_No_sub'] = PMSWelcomeModel::PMS_List_Sup_No_sub();
        $GET_DATA['Factor_User'] = PMSWelcomeModel::PMS_Get_Factor_User($GET_DATA);


        return view("PMSWelcomeView", $GET_DATA);
    }
    public static function PMS_Get_Data_User(Request $request)
    {
        $GET_DATA['Rounds_ID'] = Session::get('Rounds_ID');
        $GET_DATA['user_running'] = $request->input('user_running') != NULL ? $request->input('user_running') : '0';

        $GET_DATA['Factor_User'] = PMSWelcomeModel::PMS_Get_Factor_User($GET_DATA);
        return view("modal.Factor_User", $GET_DATA);
    }
    public static function SaveFactorUser(request $request)
    {

        /* 
                        เอา data ส่งไป insert หรือว่า update
                */
        $Rounds_ID = Session::get('Rounds_ID');
        // Get the form data
        $data = $request->all();
        $user_running = $data['user_running'];

        // dd($data);


        $validator = Validator::make($data, [
            'Factor_Name' => 'required',
            'Factor_Desc' => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        } else {
            $result = [];
            // foreach($data as $row){
            for ($i = 0; $i < count($data['Factor_Name']); $i++) {
                // if ($data['Factor_Name'][$i] != "" && $data['Factor_Desc'][$i] != "" && $data['Factor_Score'][$i] != "") {

                $result[] = [
                    'Rounds_ID' => $Rounds_ID,
                    'user_running' =>  $data['user_running'],
                    'Factor_Name' => $data['Factor_Name'][$i],
                    'Factor_Desc' => $data['Factor_Desc'][$i],
                    'Order_Sort' => $data['Order_Sort'][$i],
                ];

                // ส่ง result ไปอัพเดท
                // dd($result[$i]['Order_Sort']);
                // ส่ง result ไปสองค่า เพื่อไป get ข้อมูลมา check
                $GET_DATA['Rounds_ID'] = $Rounds_ID;
                $GET_DATA['user_running'] = $user_running;
                $GET_DATA['Order_Sort'] = $result[$i]['Order_Sort'];
                $factor = PMSWelcomeModel::PMS_Check_Factor_User($GET_DATA);
                // dd($factor);
                if ($factor) {
                    // ถ้ามีแล้ว ให้ update
                    // dd($result[$i]);
                    $updated = PMSWelcomeModel::PMS_Update_Factor_User($result[$i]);

                    // dd($updated);
                    if ($updated) {
                        // Data updated successfully
                        // return redirect()->back()->with('success', 'Factors updated successfully.');
                        // dump("update success");
                        // dd("Factors updated successfully.");
                    } else {
                        // Update failed
                        // return redirect()->back()->with('failed', 'Factors can\'t update.');
                        // dd("Factors can't update.");
                        // dump("update success");
                    }
                } else {
                    // แต่ถ้ายังไม่มี ให้ insert 
                    // dd($result[$i]);                                        
                    $inserted = PMSWelcomeModel::PMS_Save_Factor_User($result[$i]);
                    // dd($inserted);
                    if ($inserted) {
                        // Data inserted successfully
                        // return redirect()->back()->with('success', 'Factors inserted successfully.');
                        // dd("Factors inserted successfully.");
                        // dump("Factors inserted successfully.");
                    } else {
                        // Insert failed
                        // return redirect()->back()->with('success', 'Factors can\'t inserted.');
                        // dd("Factors can't insert.");
                        // dump("Factors can't  insert.");
                    }
                }
                // }
            }
            // dd($result);

            // Redirect back with a success message
            return redirect()->back();
            // return view("PMS_Welcome_V");
        }
    }

    public static function simulateFactor(Request $request)
    {
        // Convert the 'Rounds_ID' session value to an integer
        $Rounds_ID = (int)Session::get('Rounds_ID');

        // $data = $request->all();
        // $user_running = $data['user_running'];
        // dd($Rounds_ID);
        $user_running = $request->user_running;
        // dd($user_running);
        $get_data['Rounds_ID'] = $Rounds_ID;
        $get_data['user_running'] = $user_running;
        $factorThisRound = PMSWelcomeModel::PMS_Get_Factor_User($get_data);

        $updatefactor = false;
        // dd($factorThisRound);

        if (isset($factorThisRound)) {
            // dd('first');
            // additional factor is null
            // get last Rounds_ID
            if (empty($factorThisRound[0]->Factor_Name) || empty($factorThisRound[0]->Factor_Name)) {
                $getLastRounds = PMSWelcomeModel::PMS_GetLastRounds($get_data);
                if (isset($getLastRounds)) {
                    // dd('second');
                    // last round not empty 
                    $lastRound = $getLastRounds[0];
                    $get_data['Rounds_ID'] = $lastRound->Rounds_ID;
                    $get_data['user_running'] = $user_running;
                    // Get factor data for the last round   
                    $factorLastRound = PMSWelcomeModel::PMS_Get_Factor_User($get_data);

                    // Check if factor data exists for the last round
                    if (isset($factorLastRound)) {
                        // dd('third');
                        $updatefactor = false;

                        foreach ($factorLastRound as $lastRoundFactor) {
                            // Check if Factor_Name or Order_Sort is empty for any factor in the last round
                            // echo $lastRoundFactor->Factor_Name .' and '.$lastRoundFactor->Order_Sort ;
                            if ($lastRoundFactor->Factor_Name != '' || $lastRoundFactor->Order_Sort != '') {
                                $updatefactor = true;
                                break;
                            }
                        }
                        // dd($updatefactor);
                        if ($updatefactor) {
                            // dd('forth');
                            // Update factor data for the current round based on the last round
                            foreach ($factorLastRound as $factor) {
                                // dd($Rounds_ID);
                                // if ($factor->Factor_Name != '' || $factor->Order_Sort != '') {
                                    // Prepare data for updating
                                    $data = [
                                        'Rounds_ID' => $Rounds_ID,
                                        'user_running' => $user_running,
                                        'Factor_Name' => $factor->Factor_Name,
                                        'Factor_Desc' => $factor->Factor_Desc,
                                        'Order_Sort' => $factor->Order_Sort,
                                    ];
                                    // dd($data);
                                    // Update the factor data
                                    $update = PMSWelcomeModel::PMS_Update_Factor_User($data);
                                    if(!$update){
                                        // can't update then insert
                                        PMSWelcomeModel::PMS_Save_Factor_User($data);
                                    }
                                    // dd('done');

                                    // return update already
                                // }
                            }
                            $action['updated'] = $updatefactor;
                            echo json_encode($action);
                            // return redirect()->route('PMS_Welcome');
                        }
                    }
                }
            }
        }
    }
}
