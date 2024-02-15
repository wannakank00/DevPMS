@extends('userlayout.main')

@section('content')
    <div class="content" style="margin-top:55px;">
        <div class="container-fluid">
            <?php
            function dateThai($data)
            {
                // $dataExplode = explode('-', $data);
            
                if ($data == '01') {
                    return 'มกราคม';
                } elseif ($data == '02') {
                    return 'กุมภาพันธ์';
                } elseif ($data == '03') {
                    return 'มีนาคม';
                } elseif ($data == '04') {
                    return 'เมษายน';
                } elseif ($data == '05') {
                    return 'พฤษภาคม';
                } elseif ($data == '06') {
                    return 'มิถุนายน';
                } elseif ($data == '07') {
                    return 'กรกฎาคม';
                } elseif ($data == '08') {
                    return 'สิงหาคม';
                } elseif ($data == '09') {
                    return 'กันยายน';
                } elseif ($data == '10') {
                    return 'ตุลาคม';
                } elseif ($data == '11') {
                    return 'พฤศจิกายน';
                } elseif ($data == '12') {
                    return 'ธันวาคม';
                }
            }
            if (isset($Data_Rounds)) {
                foreach ($Data_Rounds[0] as $row) {
                    $Rounds_ID = $row->Rounds_ID;
                    $Rounds_Name = $row->Rounds_Name;
                    $Rounds_Start = $row->Rounds_Start;
                    $Rounds_End = $row->Rounds_End;
            
                    $Rounds_Start_explode = explode('-', $Rounds_Start);
            
                    $Text_Month_Start = dateThai($Rounds_Start_explode[1]);
            
                    $Rounds_Start_New = $Rounds_Start_explode[2] . ' ' . $Text_Month_Start . ' ' . $Rounds_Start_explode[0];
            
                    $Rounds_End_explode = explode('-', $Rounds_End);
            
                    $Text_Month_End = dateThai($Rounds_End_explode[1]);
            
                    $Rounds_End_New = $Rounds_End_explode[2] . ' ' . $Text_Month_End . ' ' . $Rounds_End_explode[0];
            
                    $Round_Range = $Rounds_Start_New . '&nbsp;&nbsp; ถึง &nbsp;&nbsp;' . $Rounds_End_New;
                }
            } else {
                $Rounds_ID = '';
                $Rounds_Name = '';
                $Rounds_Start = '';
                $Rounds_End = '';
                $Round_Range = '';
            }
            ?>
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title " style="font-weight: 400;"><b>Self-Evaluation</b> :
                        {{ $Rounds_Name }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <table cellspacing="0" width="100%" style="width: 100%;">
                                <?php
                if (isset($PMS_Get_Approver_Status_This_Employee)) {
                    $No = 0;
                    foreach ($PMS_Get_Approver_Status_This_Employee[0] as $row) {

                        $No++; 
                        $user_running = $row->user_running;
                        $employeeID = $row->employeeID;

                        $name = $row->name;
                        $surname = $row->surname;
                        $departmentName = $row->departmentName;
                        $positionShort = $row->positionShort;
                        $pic_name = $row->pic_name;

                        $startWork = $row->startWork;
                        $mLevel = $row->mLevel;

                        $sex = $row->sex;

                        $Date_Startwork = explode(' ', $startWork);
                        $Date_Start = $Date_Startwork[0];
                        $Date_Now = date('Y-m-d');
                        $diff = abs(strtotime($Date_Now) - strtotime($Date_Start));
                        $years = floor($diff / (365 * 60 * 60 * 24));
                        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                        $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));

                        if ($years > 0) {
                            $Text_Date_Startwork = $years . ' ปี ' . $months . ' เดือน';
                        } else {
                            $Text_Date_Startwork = $months . ' เดือน';
                        }

                        $PMS_Status_1 = $PMS_Get_Approver_Status_This_Employee[1]['Step_1_Status'][$user_running];
                        $PMS_Status_2 = $PMS_Get_Approver_Status_This_Employee[1]['Step_2_Status'][$user_running];
                        $PMS_Status_3 = $PMS_Get_Approver_Status_This_Employee[1]['Step_3_Status'][$user_running];

                        $Approver_1_ID = $PMS_Get_Approver_Status_This_Employee[1]['Approver_1_ID'][$user_running];
                        $Approver_2_ID = $PMS_Get_Approver_Status_This_Employee[1]['Approver_2_ID'][$user_running];
                        $Approver_1 = $PMS_Get_Approver_Status_This_Employee[1]['Approver_1_Name'][$user_running];
                        $Approver_2 = $PMS_Get_Approver_Status_This_Employee[1]['Approver_2_Name'][$user_running];

                        if ($PMS_Status_1 == 'Wait') {
                            $Status_1 = "<b style='font-weight: bold; color:#808080a6;'>Wait</b>";
                        } elseif ($PMS_Status_1 == 'Save') {
                            $Status_1 = "<b style='font-weight: bold; color:#0095ffe8;'>Save</b>";
                        } elseif ($PMS_Status_1 == 'Finished') {
                            $Status_1 = "<b style='font-weight: bold; color:#03c503;'>Finished</b>";
                        }

                        if ($PMS_Status_2 == 'Wait') {
                            $Status_2 = "<b style='font-weight: bold; color:#808080a6;'>Wait</b>";
                        } elseif ($PMS_Status_2 == 'Save') {
                            $Status_2 = "<b style='font-weight: bold; color:#0095ffe8;'>Save</b>";
                        } elseif ($PMS_Status_2 == 'Finished') {
                            $Status_2 = "<b style='font-weight: bold; color:#03c503;'>Finished</b>";
                        }

                        if ($PMS_Status_3 == 'Wait') {
                            $Status_3 = "<b style='font-weight: bold; color:#808080a6;'>Wait</b>";
                        } elseif ($PMS_Status_3 == 'Save') {
                            $Status_3 = "<b style='font-weight: bold; color:#0095ffe8;'>Save</b>";
                        } elseif ($PMS_Status_3 == 'Finished') {
                            $Status_3 = "<b style='font-weight: bold; color:#03c503;'>Finished</b>";
                        }

                        $jfemp_jf = $row->jfemp_jf;
                        $jf_code = $row->jf_code;
                        $jf_name = $row->jf_name;
                        
                        ?>

                                @if (isset($PMS_Get_Leave_Quota))
                                    @php
                                        $Business_Quota = isset($PMS_Get_Leave_Quota['BU']['quota']) ? $PMS_Get_Leave_Quota['BU']['quota'] : '0 วัน';
                                        $Holiday_Quota = isset($PMS_Get_Leave_Quota['HO']['quota']) ? $PMS_Get_Leave_Quota['HO']['quota'] : '0 วัน';
                                        $Sick_Quota = isset($PMS_Get_Leave_Quota['SI']['quota']) ? $PMS_Get_Leave_Quota['SI']['quota'] : '0 วัน';
                                        $Business_Use = isset($PMS_Get_Leave_Quota['BU']['use']) ? $PMS_Get_Leave_Quota['BU']['use'] : '0 วัน';
                                        $Holiday_Use = isset($PMS_Get_Leave_Quota['HO']['use']) ? $PMS_Get_Leave_Quota['HO']['use'] : '0 วัน';
                                        $Sick_Use = isset($PMS_Get_Leave_Quota['SI']['use']) ? $PMS_Get_Leave_Quota['SI']['use'] : '0 วัน';

                                        // dd($PMS_Get_Leave_Quota['SI']['use']);

                                        if ($sex == '1') {
                                            // ลาบวช
                                            $Ordain_Use = isset($PMS_Get_Leave_Quota['OR']['use']) ? $PMS_Get_Leave_Quota['OR']['use'] : '0 วัน';
                                            $Ordain_Quota = isset($PMS_Get_Leave_Quota['OR']['quota']) ? $PMS_Get_Leave_Quota['OR']['quota'] : '0 วัน';
                                        } else {
                                            $Ordain_Use = '0 วัน';
                                            $Ordain_Quota = '0 วัน';
                                        }

                                        if ($sex == '0 วัน') {
                                            // ลาคลอด
                                            $Maternity_Use = isset($PMS_Get_Leave_Quota['MT']['use']) ? $PMS_Get_Leave_Quota['MT']['use'] : '0 วัน';
                                            $Maternity_Quota = isset($PMS_Get_Leave_Quota['MT']['quota']) ? $PMS_Get_Leave_Quota['MT']['quota'] : '0 วัน';
                                        } else {
                                            $Maternity_Use = '0 วัน';
                                            $Maternity_Quota = '0 วัน';
                                        }

                                        // ลาแต่งงาน
                                        $Marry_Quota = isset($PMS_Get_Leave_Quota['MA']['quota']) ? $PMS_Get_Leave_Quota['MA']['quota'] : '0 วัน';
                                        $Marry_Use = isset($PMS_Get_Leave_Quota['MA']['use']) ? $PMS_Get_Leave_Quota['MA']['use'] : '0 วัน';

                                        if ($sex == '1') {
                                            // ลาเพื่อรับราชการทหารในการเรียกพล
                                            $Army_Use = isset($PMS_Get_Leave_Quota['MI']['use']) ? $PMS_Get_Leave_Quota['MI']['use'] : '0 วัน';
                                            $Army_Quota = isset($PMS_Get_Leave_Quota['MI']['quota']) ? $PMS_Get_Leave_Quota['MI']['quota'] : '0 วัน';
                                        } else {
                                            $Army_Use = '0 วัน';
                                            $Army_Quota = '0 วัน';
                                        }
                                    @endphp
                                @endif

                                <tr role="row" style="background-color:#8080801f;">
                                    <th class="text-center" style="font-size: 12px; color: #333333; font-weight: bold;">
                                        <?php echo $user_running; ?>
                                    </th>
                                    <!-- <th  style="font-size: 12px; color: #333333; font-weight: bold; ">รหัส</th> -->
                                    <th style="font-size: 12px; color: #333333; font-weight: bold; ">ชื่อ -
                                        นามสกุล</th>
                                    <th style="font-size: 12px; color: #333333; font-weight: bold; ">บริษัท /
                                        ฝ่าย</th>
                                    <th style="font-size: 12px; color: #333333; font-weight: bold; ">ตำแหน่ง
                                    </th>
                                    <!-- <th   style="font-size: 12px; color: #333333; font-weight: bold; ">อายุงาน</th> -->
                                    <th style="font-size: 12px; color: #333333; font-weight: bold; ">
                                        หัวหน้าขั้นต้น</th>
                                    <th style="font-size: 12px; color: #333333; font-weight: bold; ">
                                        หัวหน้าสูงสุด</th>
                                    <!-- <th  class="text-center" style="font-size: 14px; color: #333333; font-weight: bold; ">หัวหน้าระดับ 2</th> -->
                                </tr>

                                <tr role="row" style="font-size:16px; height: 35px;">
                                    <!-- <td><?php echo $user_running; ?></td> -->
                                    <td class="text-center" rowspan="3">
                                        <a href="https://km.mono.co.th/hr_img/<?= $pic_name ?>" target="_blank">
                                            <img src="https://km.mono.co.th/hr_img/<?= $pic_name ?>"
                                                style="max-height: 75px;">
                                        </a>
                                    </td>
                                    <td><?= $name . ' ' . $surname ?></td>
                                    <td><?= $departmentName ?></td>
                                    <td><?= $positionShort ?> </td>
                                    <!-- <td><?= $Text_Date_Startwork ?></td> -->
                                    <td><?= $Approver_1 ?></td>
                                    <td><?= $Approver_2 ?></td>
                                </tr>

                                <tr role="row" style="background-color:#8080801f;">
                                    <!-- <th  style="font-size: 12px; color: #333333; font-weight: bold; "></th> -->
                                    <th colpan="2" style="font-size: 12px; color: #333333; font-weight: bold; ">อายุงาน
                                    </th>
                                    <th style="font-size: 12px; color: #333333; font-weight: bold; ">Job Family
                                    </th>
                                    <th style="font-size: 12px; color: #333333; font-weight: bold; ">Jobs
                                        Description</th>
                                    <!-- <th   style="font-size: 12px; color: #333333; font-weight: bold; "></th> -->
                                    <th style="font-size: 12px; color: #333333; font-weight: bold; ">Project /
                                        Portfolio</th>
                                    <th style="font-size: 12px; color: #333333; font-weight: bold; ">Score
                                        History</th>
                                    <!-- <th  class="text-center" style="font-size: 14px; color: #333333; font-weight: bold; ">หัวหน้าระดับ 2</th> -->
                                </tr>

                                <tr role="row" style="font-size:16px; height: 35px;">
                                    <!-- <td></td> -->
                                    <td><?= $Text_Date_Startwork ?></td>
                                    <td><?= $jf_code . ' : ' . $jf_name ?> </td>
                                    <!-- <td></td> -->
                                    <td>
                                        <a href="https://hr.mono.co.th/JDS_Profile_Preview/<?= base64_encode($employeeID) ?>"
                                            style="color:#333333;" target="_blank">
                                            <button type="button" class="btn btn-primary pull-center">
                                                <i class="material-icons"></i>Preview&nbsp;&nbsp;</button>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="https://hr-checkin.mono.co.th/Update_Portfolio_Summary/<?= base64_encode($user_running) ?>"
                                            style="color:#333333;" target="_blank">
                                            <button type="button" class="btn btn-primary pull-center">
                                                <i class="material-icons"></i>Preview&nbsp;&nbsp;</button>
                                        </a>
                                    </td>

                                    <td>
                                        <a data-bs-toggle="modal" data-bs-target="#myModal" style="cursor: pointer;">
                                            <button type="button" class="btn btn-primary pull-center">
                                                <i class="material-icons"></i>Preview&nbsp;&nbsp;</button>
                                        </a>
                                    </td>
                                </tr>

                                <?php
                    }
                }
                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Modal Score History --}}
            <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" style="float:left; font-weight: bold;font-size: 18px;">
                                Score History</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <table class="table" cellspacing="0" width="100%">
                                <tr role="row" style="background-color:#8080801f;">
                                    <th style="font-size: 12px; color: #333333; font-weight: bold; ">รหัส</th>
                                    <th style="font-size: 12px; color: #333333; font-weight: bold; ">ชื่อ -
                                        นามสกุล</th>
                                    <th style="font-size: 12px; color: #333333; font-weight: bold; ">บริษัท /
                                        ฝ่าย</th>
                                    <th style="font-size: 12px; color: #333333; font-weight: bold; ">ตำแหน่ง
                                    </th>
                                    <th style="font-size: 12px; color: #333333; font-weight: bold; ">
                                        หัวหน้าขั้นต้น</th>
                                    <th style="font-size: 12px; color: #333333; font-weight: bold; ">
                                        หัวหน้าสูงสุด</th>
                                </tr>
                                <tr role="row" style="font-size:16px; height: 35px;">
                                    <td><?= $user_running ?></td>
                                    <td><?= $name . ' ' . $surname . ' ' ?></td>
                                    <td><?= $departmentName ?></td>
                                    <td><?= $positionShort ?> </td>
                                    <td><?= $Approver_1 ?></td>
                                    <td><?= $Approver_2 ?></td>
                                </tr>
                            </table>

                            <table class="table" cellspacing="0" width="100%" style="width: 100%;">
                                <tr role="row"
                                    style="text-align: center; font-size: 12px; color: #333333; font-weight: bold; background-color: #8080801f; border: 0.5px solid #dfdbdb;">
                                    <th>No</th>
                                    <th style="text-align:left;">Round</th>
                                    <th>Individual</th>
                                    <th>Extra</th>
                                    <th>Core Value<br>Behavior</th>
                                    <th>Functional</th>
                                    <th>Managerial</th>
                                    <th>Total</th>
                                    <th>Grade</th>
                                </tr>

                                <?php
                        if (isset($History_List_Round)) {
                            $No = 0;

                            $M_Level_ID = $mLevel;
                            foreach ($History_List_Round[0] as $row) {

                                $Rounds_ID = $row->Rounds_ID;
                                $Rounds_Name = $row->Rounds_Name;
                                $Rounds_Start = $row->Rounds_Start;
                                $Rounds_End = $row->Rounds_End;

                                $Count_Functional = 0;

                                $Core_Valule_Behavior = 0;
                                $Functional = 0;
                                $Managerial = 0;
                                $Core_Valule_Behavior_Sum = 0;
                                $Functional_Sum = 0;
                                $Managerial_Sum = 0;
                                $Total_Sum_New = 0;

                                if (isset($History_List_Score)) {
                                    $Individual_Score = $History_List_Score[0][$Rounds_ID];
                                    $Competency_Score = $History_List_Score[1][$Rounds_ID];
                                    $Behavior_Score = $History_List_Score[2][$Rounds_ID];
                                    $Functional_Score = $History_List_Score[3][$Rounds_ID];
                                    $Managerial_Score = $History_List_Score[4][$Rounds_ID];

                                    $Get_List_Project = $History_List_Score[5][$Rounds_ID];

                                    $Individual_Score_Self = 0;
                                    $Individual_Score_App_1 = 0;
                                    $Individual_Score_App_2 = 0;

                                    $Competency_Score_Self = 0;
                                    $Competency_Score_App_1 = 0;
                                    $Competency_Score_App_2 = 0;

                                    $Behavior_Score_Self = 0;
                                    $Behavior_Score_App_1 = 0;
                                    $Behavior_Score_App_2 = 0;

                                    $Functional_Score_Self = 0;
                                    $Functional_Score_App_1 = 0;
                                    $Functional_Score_App_2 = 0;

                                    $Managerial_Score_Self = 0;
                                    $Managerial_Score_App_1 = 0;
                                    $Managerial_Score_App_2 = 0;

                                    $Project_Count = 0;
                                    $Project_1_Score = 0;
                                    $Project_2_Score = 0;
                                    $Project_3_Score = 0;
                                    $Project_4_Score = 0;
                                    $Project_5_Score = 0;
                                    $Project_Total_Score = 0;
                                    $Individual_Extra = 0;

                                    foreach ($Individual_Score as $row) {
                                        $Individual_Score_Self = $Individual_Score_Self + $row->Score_Self;
                                        $Individual_Score_App_1 = $Individual_Score_App_1 + $row->Score_App_1;
                                        $Individual_Score_App_2 = $Individual_Score_App_2 + $row->Score_App_2;
                                    }

                                    foreach ($Competency_Score as $row) {
                                        $Competency_Score_Self = $Competency_Score_Self + $row->Score_Self;
                                        $Competency_Score_App_1 = $Competency_Score_App_1 + $row->Score_App_1;
                                        $Competency_Score_App_2 = $Competency_Score_App_2 + $row->Score_App_2;
                                    }

                                    foreach ($Behavior_Score as $row) {
                                        $Behavior_Score_Self = $Behavior_Score_Self + $row->Score_Self;
                                        $Behavior_Score_App_1 = $Behavior_Score_App_1 + $row->Score_App_1;
                                        $Behavior_Score_App_2 = $Behavior_Score_App_2 + $row->Score_App_2;
                                    }

                                    foreach ($Functional_Score as $row) {
                                        $Functional_Score_Self = $Functional_Score_Self + $row->Score_Self;
                                        $Functional_Score_App_1 = $Functional_Score_App_1 + $row->Score_App_1;
                                        $Functional_Score_App_2 = $Functional_Score_App_2 + $row->Score_App_2;
                                        $Count_Functional++;
                                    }
                                    if ($Count_Functional == '0') {
                                        $Count_Functional = 20;
                                    } else {
                                        $Count_Functional = $Count_Functional * 4;
                                    }

                                    foreach ($Managerial_Score as $row) {
                                        $Managerial_Score_Self = $Managerial_Score_Self + $row->Score_Self;
                                        $Managerial_Score_App_1 = $Managerial_Score_App_1 + $row->Score_App_1;
                                        $Managerial_Score_App_2 = $Managerial_Score_App_2 + $row->Score_App_2;
                                    }

                                    foreach ($Get_List_Project as $row) {
                                        $Project_1_Score = ($row->Project_1_App_1 + $row->Project_1_App_2) / 2;
                                        $Project_2_Score = ($row->Project_2_App_1 + $row->Project_2_App_2) / 2;
                                        $Project_3_Score = ($row->Project_3_App_1 + $row->Project_3_App_2) / 2;
                                        $Project_4_Score = ($row->Project_4_App_1 + $row->Project_4_App_2) / 2;
                                        $Project_5_Score = ($row->Project_5_App_1 + $row->Project_5_App_2) / 2;
                                    }

                                    if ($Project_1_Score != 0) {
                                        $Project_Count = 1;
                                    }
                                    if ($Project_2_Score != 0) {
                                        $Project_Count = 2;
                                    }
                                    if ($Project_3_Score != 0) {
                                        $Project_Count = 3;
                                    }
                                    if ($Project_4_Score != 0) {
                                        $Project_Count = 4;
                                    }
                                    if ($Project_5_Score != 0) {
                                        $Project_Count = 5;
                                    }

                                    if ($Project_Count > 0) {
                                        $Project_Total_Score = number_format((($Project_1_Score + $Project_2_Score + $Project_3_Score + $Project_4_Score + $Project_5_Score) * 5) / ($Project_Count * 4), 2);
                                    } else {
                                        $Project_Total_Score = 0;
                                    }
                                }

                                $Individual_Sum = number_format(((($Individual_Score_App_1 + $Individual_Score_App_2) / 2) * 70) / 20, 2);

                                $Core_Valule_Behavior = ($Competency_Score_App_1 + $Competency_Score_App_2) / 2 + ($Behavior_Score_App_1 + $Behavior_Score_App_2) / 2;

                                $Functional = ($Functional_Score_App_1 + $Functional_Score_App_2) / 2;
                                $Managerial = ($Managerial_Score_App_1 + $Managerial_Score_App_2) / 2;

                                if ($M_Level_ID == '5' or $M_Level_ID == '6' || $M_Level_ID == '7' || $M_Level_ID == '4') {
                                    // Officer - Sr.Officer - Staff

                                    $Core_Valule_Behavior_Sum = number_format(($Core_Valule_Behavior * 10) / 20, 2);
                                    $Functional_Sum = number_format(($Functional * 20) / $Count_Functional, 2);
                                    $Managerial_Sum = '-';
                                    $Text_Formula = '70% , 10% , 20% , -';
                                    // $Competency_Sum=number_format(($Core_Valule_Behavior_Sum+$Functional_Sum)/2,2);
                                    $Total_Sum_New = number_format($Individual_Sum + $Core_Valule_Behavior_Sum + $Functional_Sum, 2);

                                    if ($Individual_Sum + $Project_Total_Score >= 70) {
                                        $Individual_Extra = number_format(70 + $Core_Valule_Behavior_Sum + $Functional_Sum, 2);
                                    } else {
                                        $Individual_Extra = number_format($Individual_Sum + $Project_Total_Score + $Core_Valule_Behavior_Sum + $Functional_Sum, 2);
                                    }
                                } elseif ($M_Level_ID == '8') {
                                    // Super Visor

                                    //Update 07-10-2022
                                    if (
                                        $user_running == 8 ||
                                        $user_running == 13 ||
                                        $user_running == 40 ||
                                        $user_running == 129 ||
                                        $user_running == 131 ||
                                        $user_running == 282 ||
                                        $user_running == 307 ||
                                        $user_running == 325 ||
                                        $user_running == 339 ||
                                        $user_running == 404 ||
                                        $user_running == 458 ||
                                        $user_running == 614 ||
                                        $user_running == 654 ||
                                        $user_running == 667 ||
                                        $user_running == 695 ||
                                        $user_running == 708 ||
                                        $user_running == 774 ||
                                        $user_running == 894 ||
                                        $user_running == 895 ||
                                        $user_running == 896 ||
                                        $user_running == 990 ||
                                        $user_running == 1034 ||
                                        $user_running == 1084 ||
                                        $user_running == 1092 ||
                                        $user_running == 1265 ||
                                        $user_running == 1403 ||
                                        $user_running == 1478 ||
                                        $user_running == 1547 ||
                                        $user_running == 1647 ||
                                        $user_running == 1699 ||
                                        $user_running == 1731 ||
                                        $user_running == 2137 ||
                                        $user_running == 2140 ||
                                        $user_running == 2235 ||
                                        $user_running == 2291 ||
                                        $user_running == 2518 ||
                                        $user_running == 2540 ||
                                        $user_running == 2637 ||
                                        $user_running == 2640 ||
                                        $user_running == 2656 ||
                                        $user_running == 2660 ||
                                        $user_running == 2663 ||
                                        $user_running == 2827 ||
                                        $user_running == 2851 ||
                                        $user_running == 2853 ||
                                        $user_running == 2867 ||
                                        $user_running == 2870
                                    ) {
                                        $Core_Valule_Behavior_Sum = number_format(($Core_Valule_Behavior * 10) / 20, 2);
                                        $Functional_Sum = number_format(($Functional * 20) / $Count_Functional, 2);
                                        $Managerial_Sum = '-';
                                        $Text_Formula = '70% , 10% , 20% , -';
                                        // $Competency_Sum=number_format(($Core_Valule_Behavior_Sum+$Functional_Sum)/2,2);
                                        $Total_Sum_New = number_format($Individual_Sum + $Core_Valule_Behavior_Sum + $Functional_Sum, 2);

                                        if ($Individual_Sum + $Project_Total_Score >= 70) {
                                            $Individual_Extra = number_format(70 + $Core_Valule_Behavior_Sum + $Functional_Sum, 2);
                                        } else {
                                            $Individual_Extra = number_format($Individual_Sum + $Project_Total_Score + $Core_Valule_Behavior_Sum + $Functional_Sum, 2);
                                        }
                                    } else {
                                        $Core_Valule_Behavior_Sum = number_format(($Core_Valule_Behavior * 10) / 20, 2);
                                        $Functional_Sum = number_format(($Functional * 15) / $Count_Functional, 2);
                                        $Managerial_Sum = number_format(($Managerial * 5) / 20, 2);
                                        $Text_Formula = '70% , 10% , 15% , 5%';
                                        // $Competency_Sum=number_format(($Core_Valule_Behavior_Sum+$Functional_Sum+$Managerial_Sum)/3,2);
                                        $Total_Sum_New = number_format($Individual_Sum + $Core_Valule_Behavior_Sum + $Functional_Sum + $Managerial_Sum, 2);

                                        if ($Individual_Sum + $Project_Total_Score >= 70) {
                                            $Individual_Extra = number_format(70 + $Core_Valule_Behavior_Sum + $Functional_Sum + $Managerial_Sum, 2);
                                        } else {
                                            $Individual_Extra = number_format($Individual_Sum + $Project_Total_Score + $Core_Valule_Behavior_Sum + $Functional_Sum + $Managerial_Sum, 2);
                                        }
                                    }
                                } elseif ($M_Level_ID == '9' || $M_Level_ID == '10' || $M_Level_ID == '11') {
                                    // AM - Sr.M

                                    //Update 07-10-2022
                                    if (
                                        $user_running == 8 ||
                                        $user_running == 13 ||
                                        $user_running == 40 ||
                                        $user_running == 129 ||
                                        $user_running == 131 ||
                                        $user_running == 282 ||
                                        $user_running == 307 ||
                                        $user_running == 325 ||
                                        $user_running == 339 ||
                                        $user_running == 404 ||
                                        $user_running == 458 ||
                                        $user_running == 614 ||
                                        $user_running == 654 ||
                                        $user_running == 667 ||
                                        $user_running == 695 ||
                                        $user_running == 708 ||
                                        $user_running == 774 ||
                                        $user_running == 894 ||
                                        $user_running == 895 ||
                                        $user_running == 896 ||
                                        $user_running == 990 ||
                                        $user_running == 1034 ||
                                        $user_running == 1084 ||
                                        $user_running == 1092 ||
                                        $user_running == 1265 ||
                                        $user_running == 1403 ||
                                        $user_running == 1478 ||
                                        $user_running == 1547 ||
                                        $user_running == 1647 ||
                                        $user_running == 1699 ||
                                        $user_running == 1731 ||
                                        $user_running == 2137 ||
                                        $user_running == 2140 ||
                                        $user_running == 2235 ||
                                        $user_running == 2291 ||
                                        $user_running == 2518 ||
                                        $user_running == 2540 ||
                                        $user_running == 2637 ||
                                        $user_running == 2640 ||
                                        $user_running == 2656 ||
                                        $user_running == 2660 ||
                                        $user_running == 2663 ||
                                        $user_running == 2827 ||
                                        $user_running == 2851 ||
                                        $user_running == 2853 ||
                                        $user_running == 2867 ||
                                        $user_running == 2870
                                    ) {
                                        $Core_Valule_Behavior_Sum = number_format(($Core_Valule_Behavior * 10) / 20, 2);
                                        $Functional_Sum = number_format(($Functional * 20) / $Count_Functional, 2);
                                        $Managerial_Sum = '-';
                                        $Text_Formula = '70% , 10% , 20% , -';
                                        // $Competency_Sum=number_format(($Core_Valule_Behavior_Sum+$Functional_Sum)/2,2);
                                        $Total_Sum_New = number_format($Individual_Sum + $Core_Valule_Behavior_Sum + $Functional_Sum, 2);

                                        if ($Individual_Sum + $Project_Total_Score >= 70) {
                                            $Individual_Extra = number_format(70 + $Core_Valule_Behavior_Sum + $Functional_Sum, 2);
                                        } else {
                                            $Individual_Extra = number_format($Individual_Sum + $Project_Total_Score + $Core_Valule_Behavior_Sum + $Functional_Sum, 2);
                                        }
                                    } else {
                                        $Core_Valule_Behavior_Sum = number_format(($Core_Valule_Behavior * 10) / 20, 2);
                                        $Functional_Sum = number_format(($Functional * 10) / $Count_Functional, 2);
                                        $Managerial_Sum = number_format(($Managerial * 10) / 20, 2);
                                        $Text_Formula = '70% , 10% , 10% , 10%';
                                        $Total_Sum_New = number_format($Individual_Sum + $Core_Valule_Behavior_Sum + $Functional_Sum + $Managerial_Sum, 2);

                                        if ($Individual_Sum + $Project_Total_Score >= 70) {
                                            $Individual_Extra = number_format(70 + $Core_Valule_Behavior_Sum + $Functional_Sum + $Managerial_Sum, 2);
                                        } else {
                                            $Individual_Extra = number_format($Individual_Sum + $Project_Total_Score + $Core_Valule_Behavior_Sum + $Functional_Sum + $Managerial_Sum, 2);
                                        }
                                    }
                                } elseif ($M_Level_ID == '13' || $M_Level_ID == '14' || $M_Level_ID == '15' || $M_Level_ID == '16' || $M_Level_ID == '17' || $M_Level_ID == '19' || $M_Level_ID == '20' || $M_Level_ID == '21' || $M_Level_ID == '23') {
                                    // Executive

                                    $Core_Valule_Behavior_Sum = number_format(($Core_Valule_Behavior * 5) / 20, 2);
                                    $Functional_Sum = number_format(($Functional * 10) / $Count_Functional, 2);
                                    $Managerial_Sum = number_format(($Managerial * 15) / 20, 2);
                                    $Text_Formula = '70% , 5% , 10% , 15%';
                                    // $Competency_Sum=number_format(($Core_Valule_Behavior_Sum+$Functional_Sum+$Managerial_Sum)/3,2);
                                    $Total_Sum_New = number_format($Individual_Sum + $Core_Valule_Behavior_Sum + $Functional_Sum + $Managerial_Sum, 2);

                                    if ($Individual_Sum + $Project_Total_Score >= 70) {
                                        $Individual_Extra = number_format(70 + $Core_Valule_Behavior_Sum + $Functional_Sum + $Managerial_Sum, 2);
                                    } else {
                                        $Individual_Extra = number_format($Individual_Sum + $Project_Total_Score + $Core_Valule_Behavior_Sum + $Functional_Sum + $Managerial_Sum, 2);
                                    }
                                } else {
                                    $Text_Formula = 'N/A';
                                }

                                //  $Total_Sum=number_format($Individual_Sum+$Competency_Sum,2);

                                if ($Individual_Extra == '0.00') {
                                    $New_Grade = '-';
                                } elseif ($Individual_Extra >= 80) {
                                    $New_Grade = 'A';
                                } elseif ($Individual_Extra >= 70) {
                                    $New_Grade = 'B';
                                } elseif ($Individual_Extra >= 60) {
                                    $New_Grade = 'C';
                                } elseif ($Individual_Extra < 60) {
                                    $New_Grade = 'D';
                                } else {
                                    $New_Grade = 'N/A';
                                }

                                if ($Individual_Sum == '0.00') {
                                    $Hide_Record = 'display:none;';
                                } else {
                                    $Hide_Record = '';
                                    $No++;
                                }
                                ?>
                                <tr
                                    style="text-align:center;  font-size: 14px; border: 0.5px solid #dfdbdb; <?php echo $Hide_Record; ?>">
                                    <td><?php echo $No; ?></td>
                                    <td style="text-align:left;"><?php echo $Rounds_Name; ?></td>
                                    <td><?php echo $Individual_Sum; ?></td>
                                    <td><?php if ($Project_Total_Score != '0') {
                                        echo $Project_Total_Score;
                                    } else {
                                        echo '-';
                                    } ?></td>
                                    <td><?php echo $Core_Valule_Behavior_Sum; ?></td>
                                    <td><?php echo $Functional_Sum; ?></td>
                                    <td><?php echo $Managerial_Sum; ?></td>
                                    <td><?php echo $Individual_Extra; ?></td>
                                    <td><?php echo $New_Grade; ?></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Modal -->

            <?php if (isset($PMS_Get_Leave_Quota)) { ?>
            <div class="card" style="margin-top: 0px; margin-bottom: 10px;">
                <div class="card-body" style="padding-top: 7px; padding-bottom: 7px;">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <table cellspacing="0" width="100%" style="width: 100%;">

                                <tr>
                                    <td style="width: 20%; text-align: center;  font-weight: bold;" rowspan="2">Leave
                                        Record
                                    </td>
                                    <td style="width: 16%; font-size: 15px; color: #333333; ">ลากิจ</td>
                                    <td style="width: 16%; font-size: 15px; color: #333333; ">ลาพักร้อน</td>
                                    <td style="width: 16%; font-size: 15px; color: #333333; ">ลาป่วย</td>
                                </tr>
                                <tr>
                                    <td style="width: 16%;"><?php echo $Business_Use . ' / ' . $Business_Quota; ?></td>
                                    <td style="width: 16%;"><?php echo $Holiday_Use . ' / ' . $Holiday_Quota; ?></td>
                                    <td style="width: 16%;"><?php echo $Sick_Use . ' / ' . $Sick_Quota; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>

            <div class="card" style="margin-top:5px;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <!-- <b>Definition</b> :  คำนิยาม      -->
                            <table cellspacing="0" width="100%" style="width: 100%;">
                                <tr role="row" style="font-size:12px;">
                                    <td style="width: 5%;"></td>
                                    <td class="text-left" style="padding-bottom: 5px; line-height: 24px; width: 35%;">
                                        คะแนน <b style="font-weight: bold;">Individual Goals</b> แบ่งเป็น 5
                                        ระดับ ดังนี้ <br>
                                        &nbsp;&nbsp; <b style="font-weight: bold;">5</b> : ปฏิบัติงานได้ <b
                                            style="font-weight: bold;">สูงกว่ามาตรฐาน</b>
                                        หรือเป้าหมายที่กำหนดไว้อย่างมาก<br>
                                        &nbsp;&nbsp; <b style="font-weight: bold;">4</b> : ปฏิบัติงานได้ <b
                                            style="font-weight: bold;">สูงกว่ามาตรฐาน</b>
                                        หรือเป้าหมายที่กำหนดไว้<br>
                                        &nbsp;&nbsp; <b style="font-weight: bold;">3</b> : ปฏิบัติงานได้ <b
                                            style="font-weight: bold;">ตามมาตรฐาน</b>
                                        หรือเป้าหมายที่กำหนดไว้<br>
                                        &nbsp;&nbsp; <b style="font-weight: bold;">2</b> : ปฏิบัติงานได้ <b
                                            style="font-weight: bold;">ต่ำกว่ามาตรฐาน</b>
                                        หรือเป้าหมายที่กำหนดไว้ <b style="font-weight: bold;">เล็กน้อย</b> <br>
                                        &nbsp;&nbsp; <b style="font-weight: bold;">1</b> : ปฏิบัติงานได้ <b
                                            style="font-weight: bold;">ต่ำกว่ามาตรฐาน</b>
                                        หรือเป้าหมายที่กำหนดไว้ <b style="font-weight: bold;">อย่างมาก</b> <br>
                                    </td>
                                    <td style="width: 2%;"></td>
                                    <td class="text-left" style="padding-bottom: 5px; line-height: 24px;  width: 58%;">
                                        คะแนน <b style="font-weight: bold;">Core Competency , Behavior ,
                                            Functional Competency , Managerial Skills
                                        </b> แบ่งเป็น 5 ระดับ ดังนี้ <br>

                                        &nbsp;&nbsp; <b style="font-weight: bold;">5</b> : <b
                                            style="font-weight: bold;">เป็นแบบอย่าง</b> และสามารถเปลี่ยนคนรอบข้างได้<br>

                                        &nbsp;&nbsp; <b style="font-weight: bold;">4</b> : แสดงพฤติกรรม<b
                                            style="font-weight: bold;">เชิงรุกเกินกว่าที่คาดหวัง</b><br>

                                        &nbsp;&nbsp; <b style="font-weight: bold;">3</b> : แสดงพฤติกรรมเป็น<b
                                            style="font-weight: bold;">ประจำ</b><br>

                                        &nbsp;&nbsp; <b style="font-weight: bold;">2</b> : แสดงพฤติกรรมบ้างเป็น<b
                                            style="font-weight: bold;">บางครั้ง</b><br>

                                        &nbsp;&nbsp; <b style="font-weight: bold;">1</b> : แสดงพฤติกรรม<b
                                            style="font-weight: bold;">เล็กน้อยหรือไม่แสดง</b>พฤติกรรมเลย<br>

                                    </td>
                                    <!-- <td  style="width: 5%;"></td> -->
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <!--  end card  -->
            </div>

            <form name="Form_Self_Evaluate" id="Form_Self_Evaluate" action="{{ URL('Form_Self_Evaluate') }}"
                method="post" enctype="multipart/form-data" onsubmit="return validateForm();">
                <div class="card" style="margin-top:5px; margin-bottom: 5px;">
                    <div class="card-header card-header-primary" style="padding-top: 8px; padding-bottom: 8px;">
                        <h4 class="card-title " style="font-weight: 400;"><b>Section 1 : Individual Goals</b>
                            (การประเมินประสิทธิภาพของงานรายบุคคล)</h4>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <p style="margin-bottom: 10px; font-size: 15px; font-weight: 500; color:#ff6933; ">
                                    1.1 <b> Individual Goals</b> (การประเมินประสิทธิภาพของงานรายบุคคล) </p>
                                <table cellspacing="0" width="100%" style="width: 100%;">
                                    <thead>
                                        <tr role="row" style="background-color:#8080801f;">
                                            <th style="font-size: 12px; color: #333333; font-weight: bold; width:32px; ">
                                                &nbsp;No.</th>
                                            <th style="font-size: 12px; color: #333333; font-weight: bold; width: 305px;">
                                                Factors / Components</th>
                                            <th style="font-size: 12px; color: #333333; font-weight: bold; ">
                                                Indicators</th>
                                            <th class="text-center"
                                                style="font-size: 12px; color: #333333; font-weight: bold; width:80px;">
                                                พนักงาน</th>
                                            <th class="text-center"
                                                style="font-size: 12px; color: #333333; font-weight: bold; width:80px;">
                                                หัวหน้าขั้นต้น</th>
                                            <th class="text-center"
                                                style="font-size: 12px; color: #333333; font-weight: bold; width:80px;">
                                                หัวหน้าสูงสุด</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($List_Factors))
                                            @foreach ($List_Factors[0] as $key => $row)
                                                @php
                                                    $No = $key + 1;
                                                    $Factors_ID = $row->Factors_ID;
                                                    $Factors_Name = $row->Factors_Name;
                                                    $Factors_New = str_replace(' (', '<br>(', $Factors_Name);
                                                    $Factors_Indicators = $row->Factors_Indicators;
                                                    $Indicator_New = str_replace(' - ', '<br> - ', $Factors_Indicators);

                                                    $Score_Self = null;
                                                    $Score_App_1 = null;
                                                    $Score_App_2 = null;
                                                    // dd($List_Factors_Score_Self);
                                                    if (isset($List_Factors_Score_Self[1]) && $List_Factors_Score_Self[1] > 0) {
                                                        $factorScore = $List_Factors_Score_Self[0][$key];
                                                        $Score_Self = $factorScore->Score_Self;
                                                        $Score_App_1 = $factorScore->Score_App_1;
                                                        $Score_App_2 = $factorScore->Score_App_2;
                                                    }
                                                @endphp

                                                <tr role="row"
                                                    style="font-size:13px; border-top: #e6e6e6 solid 1px; border-bottom: #e6e6e6 solid 1px;">
                                                    <td style="padding-left: 5px;">&nbsp;{{ $No }}</td>
                                                    <td style="font-weight: bold;">{!! $Factors_New !!}</td>
                                                    <td style="padding-top: 10px; padding-bottom: 10px;">
                                                        {!! $Indicator_New !!}
                                                    </td>
                                                    <td
                                                        style="text-align: center; border-left: 1px solid #e9e0ea73;  background-color: #8080801f;">
                                                        <input type="hidden" name="Factors_ID[]"
                                                            value="{{ $Factors_ID }}">
                                                        <select name="Factors_Self[]"
                                                            style="width:40%;border: solid 1px #e6e6e6;padding-left: 11px;">
                                                            <option value="" <?php if ($Score_Self == '') {
                                                                echo 'selected';
                                                            } ?>>-</option>
                                                            <option value="5" <?php if ($Score_Self == '5') {
                                                                echo 'selected';
                                                            } ?>>5</option>
                                                            <option value="4" <?php if ($Score_Self == '4') {
                                                                echo 'selected';
                                                            } ?>>4</option>
                                                            <option value="3" <?php if ($Score_Self == '3') {
                                                                echo 'selected';
                                                            } ?>>3</option>
                                                            <option value="2" <?php if ($Score_Self == '2') {
                                                                echo 'selected';
                                                            } ?>>2</option>
                                                            <option value="1" <?php if ($Score_Self == '1') {
                                                                echo 'selected';
                                                            } ?>>1</option>
                                                        </select>
                                                    </td>
                                                    <td
                                                        style="text-align: center; border-left: 1px solid #e9e0ea73; border-right: 1px solid #e9e0ea73;">
                                                        <select name="Factors_App_1[]"
                                                            style="width:40%;border: solid 1px #e6e6e6;padding-left: 11px; "
                                                            disabled>
                                                            <option value="{{ $Score_App_1 }}">{{ $Score_App_1 }}
                                                            </option>
                                                        </select>
                                                    </td>
                                                    <td style="text-align: center; ">
                                                        <select name="Factors_App_2[]"
                                                            style="width:40%;border: solid 1px #e6e6e6;padding-left: 11px;"
                                                            disabled>
                                                            <option value="{{ $Score_App_2 }}">{{ $Score_App_2 }}
                                                            </option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--  end card  -->
                </div>

                <div class="card" style="margin-top:0px; margin-bottom: 5px;">
                    <?php
                    $Project_1_Name = '';
                    $Project_1_Desc = '';
                    $Project_1_Self = '';
                    $Project_1_App_1 = '';
                    $Project_1_App_2 = '';
                    
                    $Project_2_Name = '';
                    $Project_2_Desc = '';
                    $Project_2_Self = '';
                    $Project_2_App_1 = '';
                    $Project_2_App_2 = '';
                    
                    $Project_3_Name = '';
                    $Project_3_Desc = '';
                    $Project_3_Self = '';
                    $Project_3_App_1 = '';
                    $Project_3_App_2 = '';
                    
                    $Project_4_Name = '';
                    $Project_4_Desc = '';
                    $Project_4_Self = '';
                    $Project_4_App_1 = '';
                    $Project_4_App_2 = '';
                    
                    $Project_5_Name = '';
                    $Project_5_Desc = '';
                    $Project_5_Self = '';
                    $Project_5_App_1 = '';
                    $Project_5_App_2 = '';
                    
                    if (isset($List_Project)) {
                        $Project_1_Name = $List_Project->Project_1_Name;
                        $Project_2_Name = $List_Project->Project_2_Name;
                        $Project_3_Name = $List_Project->Project_3_Name;
                        $Project_4_Name = $List_Project->Project_4_Name;
                        $Project_5_Name = $List_Project->Project_5_Name;
                    
                        $Project_1_Desc = $List_Project->Project_1_Desc;
                        $Project_2_Desc = $List_Project->Project_2_Desc;
                        $Project_3_Desc = $List_Project->Project_3_Desc;
                        $Project_4_Desc = $List_Project->Project_4_Desc;
                        $Project_5_Desc = $List_Project->Project_5_Desc;
                    
                        $Project_1_Self = $List_Project->Project_1_Self;
                        $Project_2_Self = $List_Project->Project_2_Self;
                        $Project_3_Self = $List_Project->Project_3_Self;
                        $Project_4_Self = $List_Project->Project_4_Self;
                        $Project_5_Self = $List_Project->Project_5_Self;
                    
                        $Project_1_App_1 = $List_Project->Project_1_App_1;
                        $Project_2_App_1 = $List_Project->Project_2_App_1;
                        $Project_3_App_1 = $List_Project->Project_3_App_1;
                        $Project_4_App_1 = $List_Project->Project_4_App_1;
                        $Project_5_App_1 = $List_Project->Project_5_App_1;
                    
                        $Project_1_App_2 = $List_Project->Project_1_App_2;
                        $Project_2_App_2 = $List_Project->Project_2_App_2;
                        $Project_3_App_2 = $List_Project->Project_3_App_2;
                        $Project_4_App_2 = $List_Project->Project_4_App_2;
                        $Project_5_App_2 = $List_Project->Project_5_App_2;
                    }
                    
                    $Factor_Name = [];
                    $Factor_Desc = [];
                    $Factor_Score = []; // define $Factor_Score as an empty array
                    $Factor_App_1 = [];
                    $Factor_App_2 = [];
                    $os = 1;
                    $number_other = 1.2;
                    function select_othergoals($name, $options, $selected_value = null, $disabled = false)
                    {
                        $select = "<select name=\"$name\" style=\"width: 40%; border: solid 1px #e6e6e6; padding-left: 11px;\" " . ($disabled ? 'disabled' : '') . ">\n";
                        foreach ($options as $value => $text) {
                            $selected = $value == $selected_value ? ' selected' : '';
                            $select .= "<option value='$value'$selected>$text</option>\n";
                        }
                        $select .= "</select>\n";
                    
                        return $select;
                    }
                    $options_score = [
                        null => '-',
                        '5' => '5',
                        '4' => '4',
                        '3' => '3',
                        '2' => '2',
                        '1' => '1',
                    ];
                    ?>
                    @if (isset($Factor_User[0]->Factor_Name))
                        <div class="card-body" style="background: #fbebe6;">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <p style="margin-bottom: 10px; font-size: 15px; font-weight: 500;  color:#ff6933;">
                                        {{ $number_other }} <b>Additional Factors </b> ประเมินหัวข้อเพิ่มเติมรายบุคคล
                                    </p>

                                    <table cellspacing="0" width="100%" style="width: 100%;">
                                        <thead>
                                            <tr role="row" style="background-color:#8080801f;">
                                                <th
                                                    style="font-size: 12px; color: #333333; font-weight: bold; width:32px; ">
                                                    &nbsp;No.</th>
                                                <th
                                                    style="font-size: 12px; color: #333333; font-weight: bold; width: 305px;">
                                                    Factors / Components</th>
                                                <th style="font-size: 12px; color: #333333; font-weight: bold; ">
                                                    Description</th>
                                                <th class="text-center"
                                                    style="font-size: 12px; color: #333333; font-weight: bold; width:80px;">
                                                    พนักงาน</th>
                                                <th class="text-center"
                                                    style="font-size: 12px; color: #333333; font-weight: bold; width:80px;">
                                                    หัวหน้าขั้นต้น</th>
                                                <th class="text-center"
                                                    style="font-size: 12px; color: #333333; font-weight: bold; width:80px;">
                                                    หัวหน้าสูงสุด</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @for ($i = 0; $i < 5; $i++)
                                                <tr role="row"
                                                    style="font-size:13px; border-top: #e6e6e6 solid 1px; border-bottom: #e6e6e6 solid 1px;">
                                                    <input type="hidden" name="Order_Sort[]"
                                                        value="{{ isset($Factor_User[$i]->Order_Sort) ? $Factor_User[$i]->Order_Sort : $os }}" />
                                                    <td style="text-align:center; font-weight: bold;">{{ $i + 1 }}
                                                    </td>
                                                    <td style="text-align:left; font-weight: bold;">
                                                        <input type="text" name="Factor_Name[]"
                                                            id="Factor_Name[{{ $i }}]"
                                                            title="{{ isset($Factor_User[$i]->Factor_Name) ? $Factor_User[$i]->Factor_Name : '' }}"
                                                            value="{{ isset($Factor_User[$i]->Factor_Name) ? $Factor_User[$i]->Factor_Name : '' }}"
                                                            class="form-control"
                                                            style="background-color: white; padding-left:5px;"
                                                            @if ($i == 0) placeholder='(ตัวอย่าง) ยอดขาย' @endif
                                                            readonly="readonly" />
                                                    </td>
                                                    <td style="text-align:left; font-weight: bold;">
                                                        <input type="text" name="Factor_Desc[]"
                                                            title="{{ isset($Factor_User[$i]->Factor_Desc) ? $Factor_User[$i]->Factor_Desc : '' }}"
                                                            value="{{ isset($Factor_User[$i]->Factor_Desc) ? $Factor_User[$i]->Factor_Desc : '' }}"
                                                            class="form-control"
                                                            style="background-color: white; padding-left:5px;"
                                                            @if ($i == 0) placeholder='(ตัวอย่าง) ยอดขาย 100 ล้านภายใน 10 เดือน' @endif
                                                            readonly="readonly" />
                                                    </td>

                                                    <td
                                                        style="text-align: center; border-left: 1px solid #e9e0ea73; background-color: #8080801f;">
                                                        <select name="Factor_Score[]"
                                                            id="Factor_Score[{{ $i }}]"
                                                            style="width: 40%; border: solid 1px #e6e6e6; padding-left: 11px;">
                                                            @php
                                                                $factorScoreValue = isset($Factor_User[$i]->Factor_Score) ? $Factor_User[$i]->Factor_Score : '';
                                                            @endphp
                                                            <option value=""
                                                                {{ $factorScoreValue === '' ? 'selected' : '' }}>-</option>
                                                            @for ($score = 5; $score > 0; $score--)
                                                                <option value="{{ $score }}"
                                                                    {{ $factorScoreValue == $score ? 'selected' : '' }}>
                                                                    {{ $score }}</option>
                                                            @endfor
                                                        </select>
                                                    </td>
                                                    <td
                                                        style="text-align: center; border-left: 1px solid #e9e0ea73; border-right: 1px solid #e9e0ea73;">
                                                        <?= select_othergoals('Factor_App_1[]', $options_score, isset($Factor_User[$i]->Factor_App_1) ? $Factor_User[$i]->Factor_App_1 : '', true) ?>
                                                    </td>
                                                    <td
                                                        style="text-align: center; border-left: 1px solid #e9e0ea73; border-right: 1px solid #e9e0ea73;">
                                                        <?= select_othergoals('Factor_App_2[]', $options_score, isset($Factor_User[$i]->Factor_App_2) ? $Factor_User[$i]->Factor_App_2 : '', true) ?>
                                                    </td>
                                                </tr>
                                            @endfor

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <?php $number_other = 1.3; ?>
                    @endif
                    <?php
                    $collapseClass = empty($List_Project->Project_1_Name) && empty($List_Project->Project_2_Name) && empty($List_Project->Project_3_Name) && empty($List_Project->Project_4_Name) && empty($List_Project->Project_5_Name) ? 'collapse' : 'show';
                    ?>
                    <div class="card-body" style="background: #fff8f5;">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                <div style="display: flex; align-items: center;">
                                    <p
                                        style="margin-bottom: 5px; margin-right: 10px; font-size: 15px; font-weight: 500; color:#ff6933;">
                                        {{ $number_other }} <b>Project </b> พิเศษที่ได้รับมอบหมายนอกเหนือจากงานประจำ
                                        (ถ้ามี)</p>
                                    <a data-toggle="collapse" href="#table_project" id="toggle_icon" class="collapsed">
                                        <?= empty($List_Project->Project_1_Name) && empty($List_Project->Project_2_Name) && empty($List_Project->Project_3_Name) && empty($List_Project->Project_4_Name) && empty($List_Project->Project_5_Name) ? '<i class="bi bi-dash-square-fill"></i>' : '<i class="bi bi-plus-square-fill"></i>' ?>
                                    </a>
                                </div>
                                <table id="table_project" class="panel-collapse <?php echo $collapseClass; ?>" cellspacing="0"
                                    width="100%" style="width: 100%;">
                                    <thead>
                                        <tr role="row" style="background-color:#8080801f;">

                                            <th style="font-size: 12px; color: #333333; font-weight: bold; width:32px; ">
                                                &nbsp;No.</th>
                                            <th style="font-size: 12px; color: #333333; font-weight: bold; width: 305px;">
                                                Project Name</th>
                                            <th style="font-size: 12px; color: #333333; font-weight: bold; ">
                                                Description</th>
                                            <th class="text-center"
                                                style="font-size: 12px; color: #333333; font-weight: bold; width:80px;">
                                                พนักงาน</th>
                                            <th class="text-center"
                                                style="font-size: 12px; color: #333333; font-weight: bold; width:80px;">
                                                หัวหน้าขั้นต้น</th>
                                            <th class="text-center"
                                                style="font-size: 12px; color: #333333; font-weight: bold; width:80px;">
                                                หัวหน้าสูงสุด</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr role="row"
                                            style="font-size:13px; border-top: #e6e6e6 solid 1px; border-bottom: #e6e6e6 solid 1px;">
                                            <td style="text-align:center; font-weight: bold;">1</td>
                                            <td style="text-align:left; font-weight: bold;">
                                                <input type="text" name="Project_1_Name" id="Project_1_Name"
                                                    value="<?php echo $Project_1_Name; ?>" class="form-control"
                                                    style="background-color: white; padding-left:5px;"
                                                    placeholder="(ตัวอย่าง) โปรโมทแคมเปญภาพยนตร์">
                                            </td>
                                            <td style="text-align:left; font-weight: bold;">
                                                <input type="text" name="Project_1_Desc" value="<?php echo $Project_1_Desc; ?>"
                                                    class="form-control"
                                                    style="background-color: white; padding-left:5px;"
                                                    placeholder="(ตัวอย่าง) ร่วมวางแผนการโปรโมท">
                                            </td>

                                            <td
                                                style="text-align: center; border-left: 1px solid #e9e0ea73;  background-color: #8080801f;">
                                                <select name="Project_1_Self" id="Project_1_Self"
                                                    style="width:40%;border: solid 1px #e6e6e6;padding-left: 11px;">
                                                    <option value="" <?php if ($Project_1_Self == '') {
                                                        echo 'selected';
                                                    } ?>>-</option>
                                                    </option>
                                                    <option value="5" <?php if ($Project_1_Self == '5') {
                                                        echo 'selected';
                                                    } ?>>5</option>
                                                    <option value="4" <?php if ($Project_1_Self == '4') {
                                                        echo 'selected';
                                                    } ?>>4</option>
                                                    <option value="3" <?php if ($Project_1_Self == '3') {
                                                        echo 'selected';
                                                    } ?>>3</option>
                                                    <option value="2" <?php if ($Project_1_Self == '2') {
                                                        echo 'selected';
                                                    } ?>>2</option>
                                                    <option value="1" <?php if ($Project_1_Self == '1') {
                                                        echo 'selected';
                                                    } ?>>1</option>
                                                </select>
                                            </td>
                                            <td
                                                style="text-align: center; border-left: 1px solid #e9e0ea73; border-right: 1px solid #e9e0ea73; ">
                                                <select name="Project_1_App_1"
                                                    style="width:40%;border: solid 1px #e6e6e6;padding-left: 11px;"
                                                    disabled>
                                                    <option value="<?php echo $Project_1_App_1; ?>">
                                                        <?php echo $Project_1_App_1; ?></option>
                                                </select>
                                            </td>
                                            <td style="text-align: center; ">
                                                <select name="Project_1_App_2"
                                                    style="width:40%;border: solid 1px #e6e6e6;padding-left: 11px;"
                                                    disabled>
                                                    <option value="<?php echo $Project_1_App_2; ?>">
                                                        <?php echo $Project_1_App_2; ?></option>
                                                </select>
                                            </td>
                                        </tr>

                                        <tr role="row"
                                            style="font-size:13px; border-top: #e6e6e6 solid 1px; border-bottom: #e6e6e6 solid 1px;">
                                            <td style="text-align:center; font-weight: bold;">2</td>
                                            <td style="text-align:left; font-weight: bold;">
                                                <input type="text" name="Project_2_Name" id="Project_2_Name"
                                                    value="<?php echo $Project_2_Name; ?>" class="form-control"
                                                    style="background-color: white; padding-left:5px;">
                                            </td>
                                            <td style="text-align:left; font-weight: bold;">
                                                <input type="text" name="Project_2_Desc" value="<?php echo $Project_2_Desc; ?>"
                                                    class="form-control"
                                                    style="background-color: white; padding-left:5px;">
                                            </td>

                                            <td
                                                style="text-align: center; border-left: 1px solid #e9e0ea73;  background-color: #8080801f;">
                                                <select name="Project_2_Self" id="Project_2_Self"
                                                    style="width:40%;border: solid 1px #e6e6e6;padding-left: 11px;">
                                                    <option value="" <?php if ($Project_2_Self == '') {
                                                        echo 'selected';
                                                    } ?>>-</option>
                                                    <option value="5" <?php if ($Project_2_Self == '5') {
                                                        echo 'selected';
                                                    } ?>>5</option>
                                                    <option value="4" <?php if ($Project_2_Self == '4') {
                                                        echo 'selected';
                                                    } ?>>4</option>
                                                    <option value="3" <?php if ($Project_2_Self == '3') {
                                                        echo 'selected';
                                                    } ?>>3</option>
                                                    <option value="2" <?php if ($Project_2_Self == '2') {
                                                        echo 'selected';
                                                    } ?>>2</option>
                                                    <option value="1" <?php if ($Project_2_Self == '1') {
                                                        echo 'selected';
                                                    } ?>>1</option>
                                                </select>
                                            </td>
                                            <td
                                                style="text-align: center; border-left: 1px solid #e9e0ea73; border-right: 1px solid #e9e0ea73; ">
                                                <select name="Project_2_App_1"
                                                    style="width:40%;border: solid 1px #e6e6e6;padding-left: 11px;"
                                                    disabled>
                                                    <option value="<?php echo $Project_2_App_1; ?>">
                                                        <?php echo $Project_2_App_1; ?></option>
                                                </select>
                                            </td>
                                            <td style="text-align: center; ">
                                                <select name="Project_2_App_2"
                                                    style="width:40%;border: solid 1px #e6e6e6;padding-left: 11px;"
                                                    disabled>
                                                    <option value="<?php echo $Project_2_App_2; ?>">
                                                        <?php echo $Project_2_App_2; ?></option>
                                                </select>
                                            </td>

                                        </tr>

                                        <tr role="row"
                                            style="font-size:13px; border-top: #e6e6e6 solid 1px; border-bottom: #e6e6e6 solid 1px;">
                                            <td style="text-align:center; font-weight: bold;">3</td>
                                            <td style="text-align:left; font-weight: bold;">
                                                <input type="text" name="Project_3_Name" id="Project_3_Name"
                                                    value="<?php echo $Project_3_Name; ?>" class="form-control"
                                                    style="background-color: white; padding-left:5px;">
                                            </td>
                                            <td style="text-align:left; font-weight: bold;">
                                                <input type="text" name="Project_3_Desc" value="<?php echo $Project_3_Desc; ?>"
                                                    class="form-control"
                                                    style="background-color: white; padding-left:5px;">
                                            </td>

                                            <td
                                                style="text-align: center; border-left: 1px solid #e9e0ea73;  background-color: #8080801f;">
                                                <select name="Project_3_Self" id="Project_3_Self"
                                                    style="width:40%;border: solid 1px #e6e6e6;padding-left: 11px;">
                                                    <option value="" <?php if ($Project_3_Self == '') {
                                                        echo 'selected';
                                                    } ?>>-</option>
                                                    <option value="5" <?php if ($Project_3_Self == '5') {
                                                        echo 'selected';
                                                    } ?>>5</option>
                                                    <option value="4" <?php if ($Project_3_Self == '4') {
                                                        echo 'selected';
                                                    } ?>>4</option>
                                                    <option value="3" <?php if ($Project_3_Self == '3') {
                                                        echo 'selected';
                                                    } ?>>3</option>
                                                    <option value="2" <?php if ($Project_3_Self == '2') {
                                                        echo 'selected';
                                                    } ?>>2</option>
                                                    <option value="1" <?php if ($Project_3_Self == '1') {
                                                        echo 'selected';
                                                    } ?>>1</option>
                                                </select>
                                            </td>
                                            <td
                                                style="text-align: center; border-left: 1px solid #e9e0ea73; border-right: 1px solid #e9e0ea73; ">
                                                <select name="Project_3_App_1"
                                                    style="width:40%;border: solid 1px #e6e6e6;padding-left: 11px;"
                                                    disabled>
                                                    <option value="<?php echo $Project_3_App_1; ?>">
                                                        <?php echo $Project_3_App_1; ?></option>
                                                </select>
                                            </td>
                                            <td style="text-align: center; ">
                                                <select name="Project_3_App_2"
                                                    style="width:40%;border: solid 1px #e6e6e6;padding-left: 11px;"
                                                    disabled>
                                                    <option value="<?php echo $Project_3_App_2; ?>">
                                                        <?php echo $Project_3_App_2; ?></option>
                                                </select>
                                            </td>

                                        </tr>

                                        <tr role="row"
                                            style="font-size:13px; border-top: #e6e6e6 solid 1px; border-bottom: #e6e6e6 solid 1px;">
                                            <td style="text-align:center; font-weight: bold;">4</td>
                                            <td style="text-align:left; font-weight: bold;">
                                                <input type="text" name="Project_4_Name" id="Project_4_Name"
                                                    value="<?php echo $Project_4_Name; ?>" class="form-control"
                                                    style="background-color: white; padding-left:5px;">
                                            </td>
                                            <td style="text-align:left; font-weight: bold;">
                                                <input type="text" name="Project_4_Desc" value="<?php echo $Project_4_Desc; ?>"
                                                    class="form-control"
                                                    style="background-color: white; padding-left:5px;">
                                            </td>

                                            <td
                                                style="text-align: center; border-left: 1px solid #e9e0ea73;  background-color: #8080801f;">
                                                <select name="Project_4_Self" id="Project_4_Self"
                                                    style="width:40%;border: solid 1px #e6e6e6;padding-left: 11px;">
                                                    <option value="" <?php if ($Project_4_Self == '') {
                                                        echo 'selected';
                                                    } ?>>-</option>
                                                    <option value="5" <?php if ($Project_4_Self == '5') {
                                                        echo 'selected';
                                                    } ?>>5</option>
                                                    <option value="4" <?php if ($Project_4_Self == '4') {
                                                        echo 'selected';
                                                    } ?>>4</option>
                                                    <option value="3" <?php if ($Project_4_Self == '3') {
                                                        echo 'selected';
                                                    } ?>>3</option>
                                                    <option value="2" <?php if ($Project_4_Self == '2') {
                                                        echo 'selected';
                                                    } ?>>2</option>
                                                    <option value="1" <?php if ($Project_4_Self == '1') {
                                                        echo 'selected';
                                                    } ?>>1</option>
                                                </select>
                                            </td>
                                            <td
                                                style="text-align: center; border-left: 1px solid #e9e0ea73; border-right: 1px solid #e9e0ea73; ">
                                                <select name="Project_4_App_1"
                                                    style="width:40%;border: solid 1px #e6e6e6;padding-left: 11px;"
                                                    disabled>
                                                    <option value="<?php echo $Project_4_App_1; ?>">
                                                        <?php echo $Project_4_App_1; ?></option>
                                                </select>
                                            </td>
                                            <td style="text-align: center; ">
                                                <select name="Project_4_App_2"
                                                    style="width:40%;border: solid 1px #e6e6e6;padding-left: 11px;"
                                                    disabled>
                                                    <option value="<?php echo $Project_4_App_2; ?>">
                                                        <?php echo $Project_4_App_2; ?></option>
                                                </select>
                                            </td>

                                        </tr>

                                        <tr role="row"
                                            style="font-size:13px; border-top: #e6e6e6 solid 1px; border-bottom: #e6e6e6 solid 1px;">
                                            <td style="text-align:center; font-weight: bold;">5</td>
                                            <td style="text-align:left; font-weight: bold;">
                                                <input type="text" name="Project_5_Name" id="Project_5_Name"
                                                    value="<?php echo $Project_5_Name; ?>" class="form-control"
                                                    style="background-color: white; padding-left:5px;">
                                            </td>
                                            <td style="text-align:left; font-weight: bold;">
                                                <input type="text" name="Project_5_Desc" value="<?php echo $Project_5_Desc; ?>"
                                                    class="form-control"
                                                    style="background-color: white; padding-left:5px;">
                                            </td>

                                            <td
                                                style="text-align: center; border-left: 1px solid #e9e0ea73;  background-color: #8080801f;">
                                                <select name="Project_5_Self" id="Project_5_Self"
                                                    style="width:40%;border: solid 1px #e6e6e6;padding-left: 11px;">
                                                    <option value="" <?php if ($Project_5_Self == '') {
                                                        echo 'selected';
                                                    } ?>>-</option>
                                                    <option value="5" <?php if ($Project_5_Self == '5') {
                                                        echo 'selected';
                                                    } ?>>5</option>
                                                    <option value="4" <?php if ($Project_5_Self == '4') {
                                                        echo 'selected';
                                                    } ?>>4</option>
                                                    <option value="3" <?php if ($Project_5_Self == '3') {
                                                        echo 'selected';
                                                    } ?>>3</option>
                                                    <option value="2" <?php if ($Project_5_Self == '2') {
                                                        echo 'selected';
                                                    } ?>>2</option>
                                                    <option value="1" <?php if ($Project_5_Self == '1') {
                                                        echo 'selected';
                                                    } ?>>1</option>
                                                </select>
                                            </td>
                                            <td
                                                style="text-align: center; border-left: 1px solid #e9e0ea73; border-right: 1px solid #e9e0ea73; ">
                                                <select name="Project_5_App_1"
                                                    style="width:40%;border: solid 1px #e6e6e6;padding-left: 11px;"
                                                    disabled>
                                                    <option value="<?php echo $Project_5_App_1; ?>">
                                                        <?php echo $Project_5_App_1; ?></option>
                                                </select>
                                            </td>
                                            <td style="text-align: center; ">
                                                <select name="Project_5_App_2"
                                                    style="width:40%;border: solid 1px #e6e6e6;padding-left: 11px;"
                                                    disabled>
                                                    <option value="<?php echo $Project_5_App_2; ?>">
                                                        <?php echo $Project_5_App_2; ?></option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card" style="margin-top:30px; margin-bottom: 5px;">
                    <div class="card-header card-header-primary" style="padding-top: 8px; padding-bottom: 8px;">

                        <h4 class="card-title " style="font-weight: 400;"><b>Section 2 : Competency </b>
                            (การประเมินสมรรถนะ)</h4>
                        <!-- <h4 class="card-title " style="font-weight: 400;"><b>2.1 Core Competency</b>  : การประเมินสมรรถนะหลัก</h4> -->
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <p style="margin-bottom: 10px; font-size: 15px; font-weight: 500; color:#ff6933; ">
                                    2.1 <b>Core Competency</b> (การประเมินสมรรถนะหลัก)</p>

                                <table cellspacing="0" width="100%" style="width: 100%;">
                                    <thead>
                                        <tr role="row" style="background-color:#8080801f;">
                                            <th style="font-size: 12px; color: #333333; font-weight: bold; width:32px; ">
                                                &nbsp;No.</th>
                                            <th style="font-size: 12px; color: #333333; font-weight: bold; width: 305px;">
                                                Factors / Components</th>
                                            <th style="font-size: 12px; color: #333333; font-weight: bold; ">
                                                Indicators</th>
                                            <th class="text-center"
                                                style="font-size: 12px; color: #333333; font-weight: bold; width:80px;">
                                                พนักงาน</th>
                                            <th class="text-center"
                                                style="font-size: 12px; color: #333333; font-weight: bold; width:80px;">
                                                หัวหน้าขั้นต้น</th>
                                            <th class="text-center"
                                                style="font-size: 12px; color: #333333; font-weight: bold; width:80px;">
                                                หัวหน้าสูงสุด</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                            if (isset($List_Competency)) {
                                $No = 0;
                                foreach ($List_Competency[0] as $row) {

                                    $No++;
                                    $Factors_ID = $row->Factors_ID;
                                    $Factors_Name = $row->Factors_Name;
                                    $Factors_New = str_replace(' (', '<br>(', $Factors_Name);
                                    $Factors_Indicators = $row->Factors_Indicators;
                                    $Indicator_New = str_replace(' - ', '<br> - ', $Factors_Indicators);

                                    $Score_Self = null;
                                    $Score_App_1 = null;
                                    $Score_App_2 = null;
                                    if (isset($List_Competency_Score_Self[1]) and $List_Competency_Score_Self[1] > 0) {
                                        $competencyScore = $List_Competency_Score_Self[0][$No - 1];
                                        $Score_Self = $competencyScore->Score_Self;
                                        $Score_App_1 = $competencyScore->Score_App_1;
                                        $Score_App_2 = $competencyScore->Score_App_2;
                                    }

                                    //$Score_Self=NULL;
                                    ?>

                                        <tr role="row"
                                            style="font-size:13px; border-top: #e6e6e6 solid 1px; border-bottom: #e6e6e6 solid 1px;">
                                            <td style="padding-left:5px;">&nbsp;<?php echo $No; ?> </td>
                                            <td style="font-weight:bold;"><?php echo $Factors_New; ?></td>
                                            <td style="padding-top: 10px; padding-bottom: 10px;">
                                                <?php echo $Indicator_New; ?></td>
                                            <td
                                                style="text-align: center; border-left: 1px solid #e9e0ea73;  background-color: #8080801f;">
                                                <input type="hidden" name="Competency_ID[]"
                                                    value="<?php echo $Factors_ID; ?>">
                                                <select name="Competency_Self[]"
                                                    style="width:40%;border: solid 1px #e6e6e6;padding-left: 11px;">
                                                    <option value="" <?php if ($Score_Self == '') {
                                                        echo 'selected';
                                                    } ?>>-</option>
                                                    <option value="5" <?php if ($Score_Self == '5') {
                                                        echo 'selected';
                                                    } ?>>5</option>
                                                    <option value="4" <?php if ($Score_Self == '4') {
                                                        echo 'selected';
                                                    } ?>>4</option>
                                                    <option value="3" <?php if ($Score_Self == '3') {
                                                        echo 'selected';
                                                    } ?>>3</option>
                                                    <option value="2" <?php if ($Score_Self == '2') {
                                                        echo 'selected';
                                                    } ?>>2</option>
                                                    <option value="1" <?php if ($Score_Self == '1') {
                                                        echo 'selected';
                                                    } ?>>1</option>
                                                </select>
                                            </td>
                                            <td
                                                style="text-align: center; border-left: 1px solid #e9e0ea73; border-right: 1px solid #e9e0ea73; ">
                                                <select name="Competency_App_1[]"
                                                    style="width:40%;border: solid 1px #e6e6e6;padding-left: 11px; "
                                                    disabled>
                                                    <option value="<?php echo $Score_App_1; ?>">
                                                        <?php echo $Score_App_1; ?></option>
                                                </select>
                                            </td>
                                            <td style="text-align: center; ">
                                                <select name="Competency_App_2[]"
                                                    style="width:40%;border: solid 1px #e6e6e6;padding-left: 11px;"
                                                    disabled>
                                                    <option value="<?php echo $Score_App_2; ?>">
                                                        <?php echo $Score_App_2; ?></option>
                                                </select>
                                            </td>

                                        </tr>

                                        <?php
                                }
                            }
                            ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--  end card  -->
                </div>

                <div class="card" style="margin-top:0px;">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <p style="margin-bottom: 10px; font-size: 15px; font-weight: 500;  color:#ff6933;">
                                    2.2 <b>Functional Competency</b> (การประเมินสมรรถนะตามหน้าที่รับผิดชอบ)</p>
                                <table cellspacing="0" width="100%" style="width: 100%;">
                                    <thead>
                                        <tr role="row" style="background-color:#8080801f;">
                                            <th style="font-size: 12px; color: #333333; font-weight: bold; width:32px; ">
                                                &nbsp;No.</th>
                                            <th style="font-size: 12px; color: #333333; font-weight: bold; width: 305px;">
                                                Factors / Components</th>
                                            <th style="font-size: 12px; color: #333333; font-weight: bold; ">
                                                Indicators</th>
                                            <th class="text-center"
                                                style="font-size: 12px; color: #333333; font-weight: bold; width:80px;">
                                                พนักงาน</th>
                                            <th class="text-center"
                                                style="font-size: 12px; color: #333333; font-weight: bold; width:80px;">
                                                หัวหน้าขั้นต้น</th>
                                            <th class="text-center"
                                                style="font-size: 12px; color: #333333; font-weight: bold; width:80px;">
                                                หัวหน้าสูงสุด</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                            if (isset($List_Functional)) {
                                    $No = 0;
                                    foreach ($List_Functional[0] as $row) {

                                        $No++;
                                        $Factors_ID = $row->Factors_ID;
                                        $Factors_Name = $row->Factors_Name;
                                        $Factors_New = str_replace(' (', '<br>(', $Factors_Name);
                                        $Factors_Indicators = $row->Factors_Indicators;
                                        $Indicator_New = str_replace(' - ', '<br> - ', $Factors_Indicators);

                                        $Score_Self = null;
                                        $Score_App_1 = null;
                                        $Score_App_2 = null;
                                        if (isset($List_Functional_Score_Self[1]) and $List_Functional_Score_Self[1] > 0) {
                                            $funtionalScore = $List_Functional_Score_Self[0][$No - 1];
                                            $Score_Self = $funtionalScore->Score_Self;
                                            $Score_App_1 = $funtionalScore->Score_App_1;
                                            $Score_App_2 = $funtionalScore->Score_App_2;
                                        }
                                    ?>
                                        <tr role="row"
                                            style="font-size:13px; border-top: #e6e6e6 solid 1px; border-bottom: #e6e6e6 solid 1px;">
                                            <td style="padding-left:5px;">&nbsp;<?php echo $No; ?> </td>
                                            <td style="font-weight:bold;"><?php echo $Factors_New; ?></td>
                                            <td style="padding-top: 10px; padding-bottom: 10px;">
                                                <?php echo $Indicator_New; ?></td>
                                            <td
                                                style="text-align: center; border-left: 1px solid #e9e0ea73;  background-color: #8080801f;">
                                                <input type="hidden" name="Functional_ID[]"
                                                    value="<?php echo $Factors_ID; ?>">
                                                <select name="Functional_Self[]"
                                                    style="width:40%;border: solid 1px #e6e6e6;padding-left: 11px;">
                                                    <option value="" <?php if ($Score_Self == '') {
                                                        echo 'selected';
                                                    } ?>>-</option>
                                                    <option value="5" <?php if ($Score_Self == '5') {
                                                        echo 'selected';
                                                    } ?>>5</option>
                                                    <option value="4" <?php if ($Score_Self == '4') {
                                                        echo 'selected';
                                                    } ?>>4</option>
                                                    <option value="3" <?php if ($Score_Self == '3') {
                                                        echo 'selected';
                                                    } ?>>3</option>
                                                    <option value="2" <?php if ($Score_Self == '2') {
                                                        echo 'selected';
                                                    } ?>>2</option>
                                                    <option value="1" <?php if ($Score_Self == '1') {
                                                        echo 'selected';
                                                    } ?>>1</option>
                                                </select>
                                            </td>
                                            <td
                                                style="text-align: center; border-left: 1px solid #e9e0ea73; border-right: 1px solid #e9e0ea73; ">
                                                <select name="Functional_App_1[]"
                                                    style="width:40%;border: solid 1px #e6e6e6;padding-left: 11px; "
                                                    disabled>
                                                    <option value="<?php echo $Score_App_1; ?>">
                                                        <?php echo $Score_App_1; ?></option>
                                                </select>
                                            </td>
                                            <td style="text-align: center; ">
                                                <select name="Functional_App_2[]"
                                                    style="width:40%;border: solid 1px #e6e6e6;padding-left: 11px;"
                                                    disabled>
                                                    <option value="<?php echo $Score_App_2; ?>">
                                                        <?php echo $Score_App_2; ?></option>
                                                </select>
                                            </td>

                                        </tr>
                                        <?php
                                }
                            }
                            ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--  end card  -->
                </div>


                <input id="List_Managerial" type="hidden"
                    value="<?= isset($List_Managerial) ? $List_Managerial : '' ?>" />
                <?php isset($List_Managerial) ? ($lastIndex = count($List_Managerial) - 1) : ''; ?>
                <input id="Count_MF_ID" type="hidden"
                    value="<?= isset($List_Managerial) ? $List_Managerial[$lastIndex]->mf_id : '' ?>" />

                <?php
        function generate_select($mf_id, $options, $selected_value = null, $disabled = false)
        {
            $select = "<select style='width:40%;border: solid 1px #e6e6e6;' class='text-center' name='Managerial_Self_$mf_id' " . ($disabled ? 'disabled' : '') . ">\n";
            foreach ($options as $value => $text) {
                $selected = $value == $selected_value ? ' selected' : '';
                $select .= "<option class='text-center' value='$value'$selected>$text</option>\n";
            }
            $select .= "</select>\n";
        
            return $select;
        }
        if (isset($PMS_List_Sup_No_sub)) {
            foreach ($PMS_List_Sup_No_sub[0] as $row) {
                $PMS_List_Sup_No_sub_Arr[] = $row->user_running;
            }
        
            if (in_array("$user_running", $PMS_List_Sup_No_sub_Arr, true)) {
                // echo $user_running . ' Match found';
            } else {
                // echo $user_running . ' Match not found';
            }
        }
        
        $Section_Comment = 3;
        if(isset($List_Managerial)) {
        ?>

                <div class="card" style="margin-top:5px; ">
                    <div class="card-header card-header-primary" style="padding-top: 8px; padding-bottom: 8px;">

                        <h4 class="card-title " style="font-weight: 400;"><b> Section <?= $Section_Comment ?> : Managerial
                                Skills</b> (การประเมินทักษะด้านการบริหารจัดการ) </h4>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <table cellspacing="0" width="100%" style="width: 100%;">
                                    <thead>
                                        <tr role="row" style="background-color:#8080801f;">
                                            <th style="font-size: 12px; color: #333333; font-weight: bold; width:32px; ">
                                                &nbsp;No.</th>
                                            <th style="font-size: 12px; color: #333333; font-weight: bold; width: 305px;">
                                                Factors / Components</th>
                                            <th style="width:50px"></th>
                                            <th style="font-size: 12px; color: #333333; font-weight: bold; ">
                                                Indicators
                                                (ใส่เครื่องหมายถูกเพื่อตรวจสอบคุณลักษณะพฤติกรรมของท่าน)</th>
                                            <th class="text-center"
                                                style="font-size: 12px; color: #333333; font-weight: bold; width:80px;">
                                                พนักงาน</th>
                                            <th class="text-center"
                                                style="font-size: 12px; color: #333333; font-weight: bold; width:80px;">
                                                หัวหน้าขั้นต้น</th>
                                            <th class="text-center"
                                                style="font-size: 12px; color: #333333; font-weight: bold; width:80px;">
                                                หัวหน้าสูงสุด</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                            // วนเหมือนหา topic แต่เก็บทุกค่าแล้วเอามาเช็คว่า checkbox ได้ chexbox ไปรึยัง
                                $No = 1;
                                $mf_name = '';
                                $seen_text = '';
                                $i = 0;
                                $count_mf = 1;
                                $array_mf = [];
                                $count_mf2  = 1;
                                $count_mid = 0;
                                $count_name = array();
                                // dd($List_Managerial);
                                foreach ($List_Managerial as $key => $row) {
                                    $m_id = $row->m_id;
                                    
                                    if(isset($m_id)) { $count_mid++; }
                                    if(!isset($array_mf[$row->mf_name])) {
                                        $array_mf[$row->mf_name] = true;
                                        $mf_name = $row->mf_name;
                                    }
                                    if($seen_text != $row->mf_name){
                                        // first value
                                        $mf_id = $row->mf_id;
                                        $seen_text = $row->mf_name;
                                        $mf_name = $row->mf_name;
                                        $c = 0;
                                        $m = 1;
                                        $count_mf2++;
                                        /* $options = [
                                            0 => '-',
                                            1 => 'ไม่เคย (Hardly ever)',
                                            2 => 'บางครั้ง (Sometimes)',
                                            3 => 'บ่อยครั้ง (Often)',
                                            4 => 'เป็นประจำ (Always)',
                                        ]; */
                                        $options = [
                                            null => '-',
                                            '5' => '5',
                                            '4' => '4',
                                            '3' => '3',
                                            '2' => '2',
                                            '1' => '1',
                                        ];


                                        $select_self = generate_select($mf_id, $options, $List_score_managerial[$mf_id]['score'] ?? null);
                                        $select_s1 = generate_select($mf_id, $options,  $List_score_managerial[$mf_id]['score_app_1'] ?? null, true);
                                        $select_s2 = generate_select($mf_id, $options,  $List_score_managerial[$mf_id]['score_app_2'] ?? null, true);
                                    }else{
                                        $mf_name = '';
                                        $select_self = '';
                                        $select_s1 = '';
                                        $select_s2 = '';
                                        $c++;
                                        $m++;
                                        
                                        $count_mf = $count_mf2;
                                    }
                                    $count_name[$mf_id] = $m;
                                    
                                    if($c == 0 ){
                                        // $count_indi[$m]++;
                                ?>
                                        <tr role="row" style="font-size:13px; border-top: #e6e6e6 solid 1px; ">
                                            <?php
                                    }else{
                                        // $count_indi[$m] = 0; 
                                        // dd($Count_MF_ID);
                                        $mf_check[$mf_id] = true;
                                    ?>
                                        <tr role="row" style="font-size:13px; border-bottom:unset; ">
                                            <?php } ?>
                                            <input type="hidden" name="mf_id[]" value="<?php echo $mf_id; ?>">
                                            <input type="hidden" id="Count_MF_ID[<?php echo $mf_id; ?>]"
                                                name="Count_MF_ID[<?php echo $mf_id; ?>]" value="<?php echo $Count_MF_ID[$mf_id]; ?>">
                                            <td style="padding-left:5px;">&nbsp;<?php echo $count_mf != $count_mf2 ? $count_mf : ''; ?> </td>

                                            <td style="font-weight:bold;"><?php echo $mf_name; ?></td>
                                            <td style="width:50px">

                                                <input type="checkbox" class="styled"
                                                    data-mf-id-status="<?php echo $mf_id; ?>" name="m_status[]"
                                                    value="<?php echo $m_id; ?>" <?php echo isset($List_checkbox_Managerial[$m_id]) ? 'checked' : ''; ?>>

                                            </td>
                                            <td style="padding-top: 10px; padding-bottom: 10px;">
                                                <?php echo ' - ' . $row->managerial_indicators; ?>
                                            </td>
                                            <td style="text-align: center; border-left: 1px solid #e9e0ea73;  background-color: #8080801f;"
                                                class="text-center">
                                                <?php echo $select_self; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php echo $select_s1; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php echo $select_s2; ?>
                                            </td>
                                        </tr>
                                        <?php
                                $No++;
                                $i++;
                                }
                                
                                ?>
                                        <input type="hidden" name="count_mid" id="count_mid"
                                            value="<?php echo isset($count_mid) ? $count_mid : ''; ?>" />

                                        <input type="hidden" name="count_mf" id="count_mf"
                                            value="<?php echo isset($count_mf) ? $count_mf : ''; ?>" />

                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                    <!--  end card  -->
                </div>
                <?php
            $Section_Comment = 4;
            }
        ?>
                <input type="hidden" name="user_running" id="user_running" value="<?php echo $user_running; ?>" />
                <input type="hidden" name="user_id" id="user_id" value="<?php echo $employeeID; ?>" />
                <?php
                if (isset($Text_Self[0])) {
                    foreach ($Text_Self[0] as $row) {
                        $Project_Self = trim($row->Project_Self);
                        $Note_Self = trim($row->Note_Self);
                
                        $Note_App_1 = trim($row->Note_App_1);
                        $Goodnote_App_1 = trim($row->Goodnote_App_1);
                        $Badnote_App_1 = trim($row->Badnote_App_1);
                
                        $Note_App_2 = trim($row->Note_App_2);
                        $Goodnote_App_2 = trim($row->Goodnote_App_2);
                        $Badnote_App_2 = trim($row->Badnote_App_2);
                    }
                } ?>


                <div class="card" style="margin-top:5px;">
                    <div class="card-header card-header-primary" style="padding-top: 8px; padding-bottom: 8px;">
                        <h4 class="card-title " style="font-weight: 400;"><b>Section
                                <?php echo $Section_Comment; ?> : Contribution & Comments</b>
                            (ผลงานและความคิดเห็นเพิ่มเติม)</h4>
                    </div>

                    <div class="card-body" style="padding-top: 0px;">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label class="col-form-label"
                                    style="text-align: left;  color:#333333; padding-bottom: 5px;">ระบุผลงานที่ได้ทำในรอบการประเมิน
                                    (สามารถแนบลิ้งค์ไฟล์ Google Drive ได้):</label>
                                <textarea class="form-control" name="Project_Self" rows="7"
                                    style="width:100%;  border: solid 1px #e8e8e8; padding-left:5px; background-color: #8080801f;"><?php if (isset($Project_Self)) {
                                        echo $Project_Self;
                                    } ?></textarea>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label class="col-form-label"
                                    style="text-align: left;  color:#333333; padding-bottom: 5px;">ความคิดเห็นเพิ่มเติม:</label>
                                <textarea class="form-control" name="Note_Self" rows="7"
                                    style="width:100%;  border: solid 1px #e8e8e8; padding-left:5px; background-color: #8080801f;"><?php if (isset($Note_Self)) {
                                        echo $Note_Self;
                                    } ?></textarea>
                            </div>
                        </div>
                    </div>
                    <!--  end card  -->
                </div>


                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="padding:0px; padding-right:5px;  float:left;">

                    <div class="card" style="margin-top:5px;">
                        <div class="card-header card-header-primary"
                            style="background:linear-gradient(60deg, #ffffff, #ffffff);  padding-top: 8px; padding-bottom: 8px;">
                            <h4 class="card-title " style="font-weight: 400;">สำหรับหัวหน้าขั้นต้น</h4>
                        </div>

                        <div class="card-body" style="padding-top: 0px;">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom:8px;">
                                    <label class="col-form-label"
                                        style="text-align: left;  color:#333333; padding-bottom: 5px;">ความคิดเห็นเพิ่มเติม
                                        :</label>
                                    <textarea readonly class="form-control" name="Note_App_1" rows="5"
                                        style=" background-color:white; width:100%;  border: solid 1px #e8e8e8; padding-left:5px;"><?php if (isset($Note_App_1)) {
                                            echo $Note_App_1;
                                        } ?></textarea>
                                </div>


                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label class="col-form-label"
                                        style="text-align: left;  color:#333333; padding-bottom: 5px;">พฤติกรรมที่โดดเด่นและเป็น
                                        <b>ตัวอย่างที่ดี</b> :</label>
                                    <textarea readonly class="form-control" name="Goodnote_App_1" rows="5"
                                        style="background-color:white; width:100%;  border: solid 1px #e8e8e8; padding-left:5px;"><?php if (isset($Goodnote_App_1)) {
                                            echo $Goodnote_App_1;
                                        } ?></textarea>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label class="col-form-label"
                                        style="text-align: left;  color:#333333; padding-bottom: 5px;">พฤติกรรมที่
                                        <b>ต้องปรับปรุง</b> :</label>
                                    <textarea readonly class="form-control" name="Badnote_App_1" rows="5"
                                        style=" background-color:white; width:100%;  border: solid 1px #e8e8e8; padding-left:5px;"><?php if (isset($Badnote_App_1)) {
                                            echo $Badnote_App_1;
                                        } ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="padding:0px;  padding-left:5px; float:left;">
                    <div class="card" style="margin-top:5px;">
                        <div class="card-header card-header-primary"
                            style="background:linear-gradient(60deg, #ffffff, #fefefe);  padding-top: 8px; padding-bottom: 8px;">
                            <h4 class="card-title " style="font-weight: 400;">สำหรับหัวหน้าสูงสุด</h4>
                        </div>

                        <div class="card-body" style="padding-top: 0px;">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom:8px;">
                                    <label class="col-form-label"
                                        style="background-color:white; text-align: left;  color:#333333; padding-bottom: 5px;">ความคิดเห็นเพิ่มเติม
                                        :</label>
                                    <textarea readonly class="form-control" name="Note_App_2" rows="5"
                                        style="background-color:white; width:100%;  border: solid 1px #e8e8e8; padding-left:5px;"><?php if (isset($Note_App_2)) {
                                            echo $Note_App_2;
                                        } ?></textarea>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label class="col-form-label"
                                        style="text-align: left;  color:#333333; padding-bottom: 5px;">พฤติกรรมที่โดดเด่นและเป็น
                                        <b>ตัวอย่างที่ดี</b> :</label>
                                    <textarea readonly class="form-control" name="Goodnote_App_2" rows="5"
                                        style=" background-color:white; width:100%;  border: solid 1px #e8e8e8; padding-left:5px;"><?php if (isset($Goodnote_App_2)) {
                                            echo $Goodnote_App_2;
                                        } ?></textarea>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label class="col-form-label"
                                        style="text-align: left;  color:#333333; padding-bottom: 5px;">พฤติกรรมที่
                                        <b>ต้องปรับปรุง</b> :</label>
                                    <textarea readonly class="form-control" name="Badnote_App_2" rows="5"
                                        style=" background-color:white; width:100%;  border: solid 1px #e8e8e8; padding-left:5px;"><?php if (isset($Badnote_App_2)) {
                                            echo $Badnote_App_2;
                                        } ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="card" style="margin-top:5px;">
                    <div class="card-header card-header-primary" style="padding-top: 8px; padding-bottom: 8px;">
                        <h4 class="card-title " style="font-weight: 400;"><b>PMS : Self-Evaluation</b>
                            (พนักงานประเมินตนเอง)</h4>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <table cellspacing="0" width="100%" style="width: 100%;">
                                    <tr role="row" style="font-size:14px;">
                                        <td class="text-left" colspan="2"
                                            style="padding-top: 2px;padding-bottom: 2px; font-size:11px; line-height: 22px;">
                                            &nbsp;&nbsp; <b style="font-weight: bold; color:#FFBD71;font-size: 13px;"><i
                                                    class="material-icons"
                                                    style="font-size: 14px; margin-right:10px;">save
                                                </i>Save
                                            </b>&nbsp;&nbsp; : เป็นการบันทึกคะแนนที่เลือกไว้ก่อน
                                            ยังไม่ส่งผลไปยังหัวหน้า และ <b
                                                style="font-weight: bold;">สามารถเข้ามาแก้ไขได้</b>
                                            ในภายหลัง
                                            <br>
                                            &nbsp;&nbsp; <b style="font-weight: bold; color:#FD8F52;font-size: 13px;"><i
                                                    class="material-icons"
                                                    style="font-size: 14px; margin-right:10px;">
                                                </i>Send
                                            </b>&nbsp;&nbsp; : เป็นการส่งคะแนนเข้าสู่ระบบ ส่งผลไปยังหัวหน้า และ
                                            <b style="font-weight: bold;">ไม่สามารถเข้ามาแก้ไขได้อีก</b>
                                        </td>
                                        <td class="text-right" colspan="2"
                                            style="padding-top: 2px;padding-bottom: 2px;">
                                            <a href="/PMS_Welcome">
                                                <button type="button" class="btn btn-primary pull-center"
                                                    style="background: linear-gradient(60deg, gray, #80808078); font-weight:500; font-size:15px; padding: 9px 25px; width:150px;">
                                                    <i class="material-icons" style="margin-right:10px;">
                                                    </i>Back &nbsp;&nbsp;</button>
                                            </a>
                                            <a>
                                                <button type="submit" id="BtnSave" name="Action" value="Save"
                                                    class="btn btn-primary pull-center"
                                                    style="background: linear-gradient(60deg, #FFBD71, #FFBD71); font-weight:500; font-size:15px; padding: 9px 25px; width:150px; "><i
                                                        class="material-icons" style="margin-right:10px;">
                                                    </i>Save &nbsp;&nbsp;</button>
                                            </a>

                                            <a>
                                                <button type="submit" id="BtnFinished" name="Action" value="Finished"
                                                    class="btn btn-primary pull-center"
                                                    style="background: linear-gradient(60deg, #FD8F52, #FD8F52); font-weight:500; font-size:15px; padding: 9px 12px;  width:150px; ">
                                                    <i class="material-icons" style="margin-right:10px;"></i>SEND
                                                    &nbsp;&nbsp;</button>
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--  end card  -->
                </div>
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            </form>
        </div>
    </div>
@endsection
