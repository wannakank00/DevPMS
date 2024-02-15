@extends('userlayout.main')

@section('content')
    <?php if (isset($PMS_Get_List_User_Added)) { ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">พนักงานในสายการบังคับบัญชาของคุณ</h6>
        </div>
        <div class="card-body">
            <!-- เพิ่มตัวชี้วัด -->
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center" style="font-size: 12px; color: #333333; font-weight: bold; ">No</th>
                            <th class="text-center" style="font-size: 14px; color: #333333; font-weight: bold; "></th>
                            <th class="text-center" style="font-size: 14px; color: #333333; font-weight: bold; "></th>
                            <th style="font-size: 14px; color: #333333; font-weight: bold; "></th>
                            <th class="text-center" style="font-size: 14px; color: #333333; font-weight: bold; ">
                                ประเมินตนเอง</th>
                            <th class="text-center" style="font-size: 14px; color: #333333; font-weight: bold; ">
                                หัวหน้าขั้นต้น</th>
                            <th class="text-center" style="font-size: 14px; color: #333333; font-weight: bold; ">
                                หัวหน้าสูงสุด</th>
                            <th class="text-center" style="font-size: 14px; color: #333333; font-weight: bold; ">การประเมิน
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                    $No = 0;
                    foreach ($PMS_Get_List_User_Added[0] as $row) {
    
                        $No++;
                        $user_running = $row->user_running;
                        $name = $row->name;
                        $surname = $row->surname;
                        $departmentName = $row->departmentName;
                        $positionShort = $row->positionShort;
                        $pic_name = $row->pic_name;
    
                        $PMS_Status_1 = $PMS_Get_List_User_Added[1]['Step_1_Status'][$user_running];
                        $PMS_Status_2 = $PMS_Get_List_User_Added[1]['Step_2_Status'][$user_running];
                        $PMS_Status_3 = $PMS_Get_List_User_Added[1]['Step_3_Status'][$user_running];
    
                        $Approver_1_ID = $PMS_Get_List_User_Added[1]['Approver_1_ID'][$user_running];
                        $Approver_2_ID = $PMS_Get_List_User_Added[1]['Approver_2_ID'][$user_running];
                        $Approver_1 = $PMS_Get_List_User_Added[1]['Approver_1_Name'][$user_running];
                        $Approver_2 = $PMS_Get_List_User_Added[1]['Approver_2_Name'][$user_running];
    
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
                            <td class="text-center"><?= $No ?></td>
                            <td class="text-center" style="padding-top: 8px; padding-bottom: 8px;">
                                <a href="https://km.mono.co.th/hr_img/<?= $pic_name ?>"target="_blank">
                                    <img src="https://km.mono.co.th/hr_img/<?= $pic_name ?>"style="max-height: 40px;">
                                </a>
                            </td>
                            <td class="text-center"><?= $user_running ?></td>
                            <td style="font-size:14px;">
                                <?= $name . ' ' . $surname ?>
                            </td>
                            <td class="text-center"><?= $Status_1 ?></td>
                            <td class="text-center"><?= $Status_2 . '<br>' . $Approver_1 ?></td>
                            <td class="text-center"><?= $Status_3 . '<br>' . $Approver_2 ?></td>
                            <td>
                                <?php if ($PMS_Status_1 != 'Finished') {
                                    if (Session::get('Admin_User_Running') == $Approver_1_ID or Session::get('Admin_User_Running') == $Approver_2_ID) { ?>
                                        <a href="{{route ("AddOtherGoals_1")}}">
                                            <button type="button" class="btn btn-info">เพิ่มตัวชี้วัด</button>
                                            {{-- <button type="button" class="btn open_modal" data-toggle="modal"
                                                data-target="#modal-user" rel="view_modal{{ $user_running }}"
                                                data-userid="{{ $user_running }}"
                                                style="width:140px;  background:#b4a9a9 ; font-weight:500; font-size:14px;  padding: 10px 10px;">
                                                <i class="material-icons" style="margin-right: 10px;"></i>เพิ่มตัวชี้วัด
                                            </button> --}}
                                        </a>
                            <?php }
                                     } 
                            ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php } ?>

    <script>
        $(document).on('click','.open_modal',function(){
                                                    var url = "/modal/Factor_User";
                                                    var user_id= $(this).val();
                                                    $.post(url , function (data) {
                                                        //success data
                                                        console.log(data);
                                                        $('#myModal').modal('show');
                                                    }) 
                                                }); 
        function SaveFactorUser(data) {

            // event.preventDefault();
            var form = $('#form-factor');
            var url = '/save-factor';

            // console.log("Form " + form[0]);
            // console.log("url " + url);
            $.ajax({
                url: url, // Use the URL for the AJAX request
                method: 'POST',
                data: {
                    formData: form.serialize(),
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    console.log(response);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }

         $('#modal-user').on('show.bs.modal', function(event) {
            // alert("TEST");

            var button = $(event.relatedTarget) // Button that triggered the modal
            var user_running = button.data('userid') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            $.ajax({
                url: "{{ url('modal/Get_Data_User') }}",
                type: "POST",
                data: {
                    user_running: user_running,
                    _token: "{{ csrf_token() }}"
                },
                dataType: 'html'
            }).done(function(res) {
                $('replace').html(res);
                $('#modal-user.modal').modal('show');
            });

        });
        $(document).on('click', '#modal-user', function() {
                    var user_running = $(this).data('user_running');
                    if (user_running != '' && user_running != '0') {
                        $.ajax({
                            url: "{{ url('/modal/Factor_User') }}",
                            type: 'POST',
                            data: {
                                user_running: user_running,
                                _token: "{{ csrf_token() }}"
                            },
                            dataType: 'html'
                        }).done(function(res) {
                            $('#modal-user').html(res);
                            $('#modal-user.modal').modal('show');
                        });
                    }
                });
         
        $(document).on('click', 'button[rel^="view_modal"]', function() {
            var user_running = $(this).data('userid');
            // alert(user_running);
            if (user_running != '' && user_running != '0') {
                $.ajax({
                    url: "{{ url('/modal/factor-user') }}",
                    type: 'POST',
                    data: {
                        user_running: user_running,
                        _token: "{{ csrf_token() }}"
                    },
                    dataType: 'html'
                }).done(function(res) {
                    $('#replace').html(res);
                    $('#modal-user-' + user_running + '.modal').modal('show');
                });
            }
        });

         $(document).ready(function() {
             $(document).on('click', '.editbtn', function() {
                 var book_id = $(this).val();
                 $.ajax({
                     type: "GET",
                     url: "/book-edit/" + book_id,
                     success: function(response) {
                         $('#bookId').val(response.bookdata.book_id);
                         $('#bookName').val(response.bookdata.book_name);
                         $('#bookAuthor').val(response.bookdata.book_author);
                         $('#bookStatus').val(response.bookdata.book_status);
                         $('#bookId').val(book_id);
                     }
                 });
             });
         });
    </script>
@endsection
