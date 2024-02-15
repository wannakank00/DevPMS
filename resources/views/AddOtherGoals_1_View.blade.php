@extends('userlayout.main')

@section('content')
    <style>
        input[type=text] {
            width: 100%;
            padding: 0px 20px;
            margin: 0px 0;
            box-sizing: border-box;
            border: none;
            border-bottom: 2px solid rgb(134, 131, 131);
        }
    </style>
     <div class="card" style="margin-bottom: 5px;">
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
                                //$Date_Now = date("2014-12-10");
                                $diff = abs(strtotime($Date_Now) - strtotime($Date_Start));
                                $years = floor($diff / (365 * 60 * 60 * 24));
                                $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                                $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));

                                //printf("%d years, %d months, %d days\n", $years, $months, $days);

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
                            
                        <tr role="row" style="background-color:#8080801f;">
                            <th class="text-center"
                                style="font-size: 12px; color: #333333; font-weight: bold;">
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
                            <th colpan="2"
                                style="font-size: 12px; color: #333333; font-weight: bold; ">อายุงาน
                            </th>
                            <th style="font-size: 12px; color: #333333; font-weight: bold; ">Job Family
                            </th>
                        </tr>

                        <tr role="row" style="font-size:16px; height: 35px;">
                            <!-- <td></td> -->
                            <td><?= $Text_Date_Startwork ?></td>
                            <td><?= $jf_code . ' : ' . $jf_name ?> </td>
                            <!-- <td></td> -->
                            
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
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-wight-bold text-primary">เพิ่มตัวชี้วัด</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <p>Other Goals ประเมินหัวข้อเพิ่มเติมรายบุคคล</p>
            </div>
            <form class="OtherGoals">
                <table class="table">
                    <thead>
                        <tr role="row" style="background-color:#8080801f;">
                            <th scope="col">N0.</th>
                            <th scope="col">Factors/Components</th>
                            <th scope="col">Description</th>
                            <th scope="col">พนักงาน</th>
                            <th scope="col">หัวหน้าขั้นต้น</th>
                            <th scope="col">หัวหน้าสูงสุด</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td><input type="text" id="fname" name="fname"><br></td>
                            <td><input type="text" id="fname" name="fname"><br></td>
                            <td style="text-align: center; border-left: 1px solid #e9e0ea73; background-color:#8080801f;">
                                <select class="form-select" aria-label="Default select example">
                                    <option selected>-</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </td>
                            <td>
                                <select style="width:40%;border: solid 1px #e6e6e6;padding-left: 11px;" disabled>
                                    <option selected>-</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </td>
                            <td>
                                <select style="width:40%;border: solid 1px #e6e6e6;padding-left: 11px;" disabled>
                                    <option selected>-</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td><input type="text" id="fname" name="fname"><br></td>
                            <td><input type="text" id="fname" name="fname"><br></td>
                            <td style="text-align: center; border-left: 1px solid #e9e0ea73; background-color:#8080801f;">
                                <select class="form-select" aria-label="Default select example">
                                    <option selected>-</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </td>
                            <td>
                                <select style="width:40%;border: solid 1px #e6e6e6;padding-left: 11px;" disabled>
                                    <option selected>-</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </td>
                            <td>
                                <select style="width:40%;border: solid 1px #e6e6e6;padding-left: 11px;" disabled>
                                    <option selected>-</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td><input type="text" id="fname" name="fname"><br></td>
                            <td><input type="text" id="fname" name="fname"><br></td>
                            <td style="text-align: center; border-left: 1px solid #e9e0ea73; background-color:#8080801f;">
                                <select class="form-select" aria-label="Default select example">
                                    <option selected>-</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </td>
                            <td>
                                <select style="width:40%;border: solid 1px #e6e6e6;padding-left: 11px;" disabled>
                                    <option selected>-</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </td>
                            <td>
                                <select style="width:40%;border: solid 1px #e6e6e6;padding-left: 11px;" disabled>
                                    <option selected>-</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">4</th>
                            <td><input type="text" id="fname" name="fname"><br></td>
                            <td><input type="text" id="fname" name="fname"><br></td>
                            <td style="text-align: center; border-left: 1px solid #e9e0ea73; background-color:#8080801f;">
                                <select class="form-select" aria-label="Default select example">
                                    <option selected>-</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </td>
                            <td>
                                <select style="width:40%;border: solid 1px #e6e6e6;padding-left: 11px;" disabled>
                                    <option selected>-</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </td>
                            <td>
                                <select style="width:40%;border: solid 1px #e6e6e6;padding-left: 11px;" disabled>
                                    <option selected>-</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">5</th>
                            <td><input type="text" id="fname" name="fname"><br></td>
                            <td><input type="text" id="fname" name="fname"><br></td>
                            <td style="text-align: center; border-left: 1px solid #e9e0ea73; background-color:#8080801f;">
                                <select class="form-select" aria-label="Default select example">
                                    <option selected>-</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </td>
                            <td>
                                <select style="width:40%;border: solid 1px #e6e6e6;padding-left: 11px;" disabled>
                                    <option selected>-</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </td>
                            <td>
                                <select style="width:40%;border: solid 1px #e6e6e6;padding-left: 11px;" disabled>
                                    <option selected>-</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="button" align="right">
                    <button type="button" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-secondary">close</button>
                </div>
            </form>
        </div>
    </div>


@endsection
