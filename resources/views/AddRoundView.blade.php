<!-- resources/views/AddRoundView.blade.php -->

@extends('layout.main')

@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">รอบการประเมิน</h6>
        </div>
        <div class="card-body">
            <!-- แสดงข้อความหากมีการบันทึกข้อมูลสำเร็จ -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- แสดงฟอร์มเพิ่มรอบประเมิน -->
            <form method="post" action="{{ route('SaveRound') }}" id="roundsForm">
                @csrf
                <div class="form-group">
                    <label for="Rounds_Name">ชื่อรอบประเมิน:</label>
                    <input type="text" class="form-control" id="Rounds_Name" name="Rounds_Name" required>
                </div>
                <div class="form-group">
                    <label for="Rounds_Start">ชื่อรอบประเมิน:</label>
                    <input type="date" class="form-control" id="Rounds_Start" name="Rounds_Start" required>
                </div>
                <div class="form-group">
                    <label for="Rounds_End">ชื่อรอบประเมิน:</label>
                    <input type="date" class="form-control" id="Rounds_End" name="Rounds_End" required>
                </div>
                <button type="submit" class="btn btn-primary">บันทึก</button>
                <button type="button" class="btn btn-danger" onclick="clearForm()">ยกเลิก</button>
            </form>
        </div>
    </div>

    <script>
        function clearForm() {
            // เลือกฟอร์มโดยใช้ ID หรือชื่อฟอร์มของคุณ
            var form = document.getElementById("roundsForm"); // หรือ document.forms["yourFormName"];
        
            // ล้างค่าฟอร์มทั้งหมด
            form.reset();
        }
        </script>

@endsection
