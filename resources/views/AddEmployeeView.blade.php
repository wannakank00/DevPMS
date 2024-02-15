<!-- resources/views/AddEmployeeView.blade.php -->

@extends('layout.main')

@section('content')
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">รอบการประเมิน</h6>
    </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Rounds</th>
                  <th>Start</th>
                  <th>End</th>
                  <th>Employee</th>
                </tr>
              </thead>

              <tbody>
                @foreach ($pmsRounds as $pmsRound)
                <tr>
                    <td>{{ $pmsRound->Rounds_Name }}</td>
                    <td>{{ $pmsRound->Rounds_Start }}</td>
                    <td>{{ $pmsRound->Rounds_End }}</td>
                    <td>
                        <a href="{{ route('AddEmployeeInRound') }}" class="btn btn-secondary">เพิ่มพนักงาน</a>
                    </td>
                </tr>
            @endforeach

              </tbody>
            </table>
          </div>
        </div>
</div>



@endsection
