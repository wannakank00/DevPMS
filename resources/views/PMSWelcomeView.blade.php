@extends('userlayout.main')

@section('content')
    <div class="content" style="margin-top: 55px;">
        <div class="container-fluid">
            <?php
                if (isset($Data_Rounds)) {
                    foreach ($Data_Rounds[0] as $row) {
                        $Rounds_ID = $row->Rounds_ID;
                        $Rounds_Name = $row->Rounds_Name;
                        $Rounds_Start = $row->Rounds_Start;
                        $Rounds_End = $row->Rounds_End;
            
                         $Rounds_Start_explode = explode('-', $Rounds_Start);
            
                        if ($Rounds_Start_explode[1] == '01') {
                            $Text_Month_Start = 'มกราคม';
                        } elseif ($Rounds_Start_explode[1] == '02') {
                            $Text_Month_Start = 'กุมภาพันธ์';
                        } elseif ($Rounds_Start_explode[1] == '03') {
                            $Text_Month_Start = 'มีนาคม';
                        } elseif ($Rounds_Start_explode[1] == '04') {
                            $Text_Month_Start = 'เมษายน';
                        } elseif ($Rounds_Start_explode[1] == '05') {
                            $Text_Month_Start = 'พฤษภาคม';
                        } elseif ($Rounds_Start_explode[1] == '06') {
                            $Text_Month_Start = 'มิถุนายน';
                        } elseif ($Rounds_Start_explode[1] == '07') {
                            $Text_Month_Start = 'กรกฎาคม';
                        } elseif ($Rounds_Start_explode[1] == '08') {
                            $Text_Month_Start = 'สิงหาคม';
                        } elseif ($Rounds_Start_explode[1] == '09') {
                            $Text_Month_Start = 'กันยายน';
                        } elseif ($Rounds_Start_explode[1] == '10') {
                            $Text_Month_Start = 'ตุลาคม';
                        } elseif ($Rounds_Start_explode[1] == '11') {
                            $Text_Month_Start = 'พฤศจิกายน';
                        } elseif ($Rounds_Start_explode[1] == '12') {
                            $Text_Month_Start = 'ธันวาคม';
                        }
                        $Rounds_Start_New = $Rounds_Start_explode[2] . ' ' . $Text_Month_Start . ' ' . $Rounds_Start_explode[0];
            
                        $Rounds_End_explode = explode('-', $Rounds_End);
                        if ($Rounds_End_explode[1] == '01') {
                            $Text_Month_End = 'มกราคม';
                        } elseif ($Rounds_End_explode[1] == '02') {
                            $Text_Month_End = 'กุมภาพันธ์';
                        } elseif ($Rounds_End_explode[1] == '03') {
                            $Text_Month_End = 'มีนาคม';
                        } elseif ($Rounds_End_explode[1] == '04') {
                            $Text_Month_End = 'เมษายน';
                        } elseif ($Rounds_End_explode[1] == '05') {
                            $Text_Month_End = 'พฤษภาคม';
                        } elseif ($Rounds_End_explode[1] == '06') {
                            $Text_Month_End = 'มิถุนายน';
                        } elseif ($Rounds_End_explode[1] == '07') {
                            $Text_Month_End = 'กรกฎาคม';
                        } elseif ($Rounds_End_explode[1] == '08') {
                            $Text_Month_End = 'สิงหาคม';
                        } elseif ($Rounds_End_explode[1] == '09') {
                            $Text_Month_End = 'กันยายน';
                        } elseif ($Rounds_End_explode[1] == '10') {
                            $Text_Month_End = 'ตุลาคม';
                        } elseif ($Rounds_End_explode[1] == '11') {
                            $Text_Month_End = 'พฤศจิกายน';
                        } elseif ($Rounds_End_explode[1] == '12') {
                            $Text_Month_End = 'ธันวาคม';
                        }
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
            <!-- การประเมินรอบนี้ -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">การประเมินรอบนี้</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>รายละเอียด : <input style=" font-size:14px;" type="text" name="Rounds_Name"
                                            class="form-control" value="{{ $Rounds_Name }}" disabled>
                                    </th>

                                    <th>กำหนดเปิด - ปิด : <input type="text" style=" font-size:14px;" name="Round_Range"
                                            class="form-control" value="<?php echo $Round_Range; ?>" disabled />
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- สถานะการประเมินของคุณ -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">สถานะการประเมินของคุณ</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class=text-center>สถานะ ประเมินตนเอง</th>

                                <th class=text-center>สถานะ หัวหน้าขั้นต้น</th>

                                <th class=text-center>สถานะ หัวหน้าขั้นสุด</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                              $PMS_Status_1 = "";
                              $PMS_Status_2 = "";
                              $PMS_Status_3 = "";
                            if (isset($PMS_Get_Approver_Status_This_Employee))
                                {
                                    $No = 0;
                                        foreach ($PMS_Get_Approver_Status_This_Employee[0] as $row) 
                                        
                                            {

                                                $No++;
                                                $user_running = $row->user_running;
                                                $name = $row->name;
                                                $surname = $row->surname;
                                                $departmentName = $row->departmentName;
                                                $positionShort = $row->positionShort;
                                                $pic_name = $row->pic_name;

                                                if ($user_running == '2876' or $user_running == '1647' or  $user_running == '807') {  }
                             
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
                                                    $Status_1 = "<b style='font-weight: bold; color:#FFBD71;'>Save</b>";
                                                } elseif ($PMS_Status_1 == 'Finished') {
                                                    $Status_1 = "<b style='font-weight: bold; color:#FD8F52;'>Finished</b>";
                                                }

                                                if ($PMS_Status_2 == 'Wait') {
                                                    $Status_2 = "<b style='font-weight: bold; color:#808080a6;'>Wait</b>";
                                                } elseif ($PMS_Status_2 == 'Save') {
                                                    $Status_2 = "<b style='font-weight: bold; color:#FFBD71;'>Save</b>";
                                                } elseif ($PMS_Status_2 == 'Finished') {
                                                    $Status_2 = "<b style='font-weight: bold; color:#FD8F52;'>Finished</b>";
                                                }

                                                if ($PMS_Status_3 == 'Wait') {
                                                    $Status_3 = "<b style='font-weight: bold; color:#808080a6;'>Wait</b>";
                                                } elseif ($PMS_Status_3 == 'Save') {
                                                    $Status_3 = "<b style='font-weight: bold; color:#FFBD71;'>Save</b>";
                                                } elseif ($PMS_Status_3 == 'Finished') {
                                                    $Status_3 = "<b style='font-weight: bold; color:#FD8F52;'>Finished</b>";
                                                }
                            ?>
                            <tr>
                                <td class="text-center" style="padding-top: 7px; padding-bottom:10px;">
                                    <?php echo $Status_1 . '<br>' . $name . ' ' . $surname; ?></td>
                                <td class="text-center" style="padding-top: 7px; padding-bottom:10px;">
                                    <?php echo $Status_2 . '<br>' . $Approver_1; ?></td>
                                <td class="text-center" style="padding-top: 7px; padding-bottom:10px;">
                                    <?php echo $Status_3 . '<br>' . $Approver_2; ?></td>
                            </tr>

                            <?php
                                }
                            } ?>
                            <tr role="row" style="font-size:14px; background-color:#e9e0ea47;">
                                <td class="text-center" style="padding-top: 15px; padding-bottom: 15px;" colspan="3">
                                    @if (
                                        ($PMS_Status_1 == 'Wait' || $PMS_Status_1 == 'Save') &&
                                            ((!empty($permission_period[$user_running]) && $permission_period[$user_running] == date('Y-m-d')) ||
                                                empty($permission_period[$user_running])))
                                        <a href="{{ route('User_Evaluate') }}">
                                            <button type="submit" class="btn btn-primary pull-center"
                                                style="background: linear-gradient(60deg, #38b7d3, #38b7d3); font-weight:500; font-size:14px;  padding: 10px 20px;">
                                                <i class="fas fa-sign-in-alt"></i> เข้าทำประเมิน
                                            </button>
                                        </a>
                                    @elseif ($PMS_Status_2 == 'Finished' && $PMS_Status_3 == 'Finished')
                                        <a href="/PMS_Self_View_Evaluate">
                                            <button type="button" class="btn btn-primary pull-center"
                                                style="background: linear-gradient(60deg, #38b7d3, #38b7d3); font-weight:500; font-size:14px;  padding: 10px 20px;">
                                                <i class="material-icons"
                                                    style="margin-right: 7px;">manage_search</i>ผลการประเมิน &nbsp;&nbsp;
                                            </button>
                                        </a>
                                    @else
                                        @if ($PMS_Status_1 != 'Wait' && $PMS_Status_1 != 'Save')
                                            <b style='font-weight: bold;'>คุณสามารถตรวจสอบคะแนนประเมินได้
                                                หลังจากหัวหน้าขั้นต้นและหัวหน้าสูงสุดประเมินเสร็จสิ้น</b>
                                        @elseif (!$permission_period[$user_running] <= date('Y-m-d'))
                                            <b style='font-weight: bold;'>คุณไม่สามารถทำการประเมินผลได้
                                                เนื่องจากวันและเวลาไม่ตรงตามที่กำหนด กรุณาติดต่อฝ่ายทรัพยากรบุคคล
                                                ขออภัยในความไม่สะดวก</b>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                            <?php
                            ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
