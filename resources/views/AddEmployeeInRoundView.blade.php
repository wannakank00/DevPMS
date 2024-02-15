<!-- resources/views/AddEmployeeView.blade.php -->

@extends('layout.main')

@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">เพิ่มพนักงาน</h6>
        </div>
        <div class="card-body">
           <!-- แสดงข้อความหากมี Flash Message success -->
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <!-- แสดงข้อความหากมี Flash Message error -->
            @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif

            <!-- ฟอร์มพนักงานในรอบประเมิน -->
            <form action="{{Route('AddEmployeeInRound')}}" method="post" enctype="multipart/form-data" id="employeeForm">
                @csrf
                <input type="file" name="excel_file" accept=".xls, .xlsx">
                <input type="submit" value="Upload">
                <input type="button" value="clear" onclick="clearForm()">
            </form>
        </div>
    </div>
    
     <!-- แสดงข้อมูลจาก Excel -->
     @if(isset($sheetData) && count($sheetData) > 0)
     <table class="table table-striped table-hover">
         <thead>
             <tr>
                <th>รหัสพนักงาน</th>
                <th>วันที่ประเมิน</th>
             </tr>
         </thead>
         <tbody>
             @foreach(array_slice($sheetData, 0) as $row)
                 <tr>
                     @foreach($row as $value)
                         <td>{{ $value }}</td>
                     @endforeach
                 </tr>
             @endforeach
         </tbody>
     </table>
 @endif

    <script>
        function clearForm() {
            // เลือกฟอร์มโดยใช้ ID หรือชื่อฟอร์มของคุณ
            var form = document.getElementById("employeeForm"); // หรือ document.forms["yourFormName"];
        
            // ล้างค่าฟอร์มทั้งหมด
            form.reset();
        }
        </script>

@endsection

