@extends('template.admin')

@section('content')
<div class="row mx-3">
	<div class="col-md-4">
		<a href="admin/data_covid19" class="card card-body bg-danger">
			<div class="text-center">
				<span class="fas fa-virus fa-4x"></span>
				<hr/>
				Data Covid-19
			</div>
		</a> 
	</div>

	<div class="col-md-4">
		<a href="admin/periode" class="card card-body bg-success">
			<div class="text-center">
				<span class="fas fa-calendar-week fa-4x"></span>
				<hr/>
				Periode
			</div>
		</a> 
	</div>

	<div class="col-md-4">
		<a href="admin/user" class="card card-body bg-info">
			<div class="text-center">
				<span class="fas fa-user fa-4x"></span>
				<hr/>
				User
			</div>
		</a> 
	</div>
</div>
@endsection