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
			          <th>NO</th>
			          <th>Rounds</th>
			          <th>Start</th>
			          <th>End</th>
			          <th>Status</th>
			          <th>Action</th>
			        </tr>
			      </thead>

			      <tbody>
					@foreach ($pmsRounds as $pmsRound)
			        <tr>
			          <td>{{ $pmsRound->Rounds_ID  }}</td>
			          <td>{{ $pmsRound->Rounds_Name }}</td>
			          <td>{{ $pmsRound->Rounds_Start}}</td>
			          <td>{{ $pmsRound->Rounds_End}}</td>
			          <td>	<div class="form-check form-switch form-switch-sm"  style="display: flex; justify-content: center; align-items: center;">
						<input class="form-check-input" type="checkbox" id="label">
						<label class="form-check-label" for="label"></label>
					  </div></td>
			          <td>
							<button type="button" class="btn btn-outline-warning btn-sm">แก้ไข</button>
							<button type="button" class="btn btn-outline-danger btn-sm">ลบ</button>
					</td>
			        </tr>
					@endforeach

			      </tbody>
			    </table>
			  </div>
			</div>
	</div>

@endsection
