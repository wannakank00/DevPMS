<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class LeaveEmployeeController extends Controller
{
    public function getLeaveEmpData($id, $year)
    {
        $user_id = base64_decode($id);
        $emp_year = base64_decode($year);
        $data = $this->fetchLeaveEmpData($user_id, $emp_year);

        // Perform any additional processing or return the data as needed
        return response()->json($data);
    }

    protected function fetchLeaveEmpData($id, $year)
    {
        $username = 'hr-dev-thanapak';
        $password = 'aHItZGV2LXRoYW5hcGFr';

        $ch = curl_init();
        // $id = 4542;
        // $year = 2023;
        $url = 'https://eservice.mono.co.th/api/leave_quota';
        $postData = [
            'leave_emp_id' => $id,
            'leave_year' => $year
        ];


        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

        // Set option to return the response as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        // Check for errors or handle the response
        if ($response === false) {
            $error = curl_error($ch);
            // dd($error);
            // Handle the error
        } else {
            $responseData = json_decode($response);

            // Check if decoding was successful
            if ($responseData === null) {
                // Handle the JSON decoding error
            } else {
                // Process the response data
                // dd($responseData);
                return $responseData;
            }
        }
        // dd($response);
        // Close the cURL handle
        curl_close($ch);
        // Return the response
        return $response;
    }
    /* 
        "BU": ลากิจ
        "SI": ลาป่วย
        "HO": ลาพักร้อน
        "MA": ลาแต่งงาน
        "OR": ลาอุปสมบท
        "MI": ลาเพื่อรับราชการทหารในการเรียกพล
        "MT": ลาคลอด
        "DT": ลาจัดการพิธีศพ
        "BUO": ลากิจ (ไม่รับเงิน)
    */
    public function convertData($data)
    {
        $convertedData = [
            'BU' => isset($data->BU) ? $this->convertLeaveData($data->BU->leave_data) : null,
            'SI' => isset($data->SI) ? $this->convertLeaveData($data->SI->leave_data) : null,
            'HO' => isset($data->HO) ? $this->convertLeaveData($data->HO->leave_data) : null,
            'MA' => isset($data->MA) ? $this->convertLeaveData($data->MA->leave_data) : null,
            'OR' => isset($data->OR) ? $this->convertLeaveData($data->OR->leave_data) : null,
            'MI' => isset($data->MI) ? $this->convertLeaveData($data->MI->leave_data) : null,
            'MT' => isset($data->MT) ? $this->convertLeaveData($data->MT->leave_data) : null,
            'DT' => isset($data->DT) ? $this->convertLeaveData($data->DT->leave_data) : null,
            'BUO' => isset($data->BUO) ? $this->convertLeaveData($data->BUO->leave_data) : null,
        ];
        /* $PMS_Get_Leave_Quota = (object) [
            'Business_Quota' => $this->convertMinutesToHoursAndDays($data->BU->leave_data->quota),
            'Busniess_Use' => $this->convertMinutesToHoursAndDays($data->SI->leave_data->use),
            'Holiday_Quota' => $this->convertMinutesToHoursAndDays($data->MA->leave_data->quota),
            'Holiday_Use' => $this->convertMinutesToHoursAndDays($data->MA->leave_data->use),
            'Sick_Quota' => $this->convertMinutesToHoursAndDays($data->OR->leave_data->quota),
            'Sick_Use' => $this->convertMinutesToHoursAndDays($data->OR->leave_data->use),
        ]; */
        return $convertedData;
    }
    public function convertMinutesToDays($minutes)
    {
        $days = floor($minutes / 480);
        // $remainingMinutes = $minutes % 480;

        $result = "";
        if ($days > 0) {
            $result .= $days . " วัน ";
        }else if ($days == 0){
            $result .= 0 . " วัน";
        }
        /* if ($remainingMinutes > 0) {
            $result .= $remainingMinutes . " นาที";
        } */

        return $result;
    }

    public function convertLeaveData($leaveData)
    {
        $quota = $this->convertMinutesToDays($leaveData->quota);
        $use = $this->convertMinutesToOfficeHours($leaveData->use);

        return [
            'quota' => $quota,
            'use' => $use,
        ];
    }
    public function convertMinutesToOfficeHours($minutes)
    {
        // $days = floor($minutes / (60 * 24));
        $days = floor($minutes / 480);
        $hours = floor(($minutes % (60 * 24)) / 60);
        $remainingMinutes = $minutes % 60;

        $result = "";
        if ($days > 0) {
            $result .= $days . " วัน";
            $result .= " ";
        }else if ($days == 0){
            $result .= 0 . " วัน";
        }
        /* if ($hours > 0) {
            $result .= $hours . " ชั่วโมง";
            
            $result .= " ";
        }
        if ($remainingMinutes > 0) {
            $result .= $remainingMinutes . " นาที";
        } */

        return $result;
    }
}
