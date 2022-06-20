@extends('template.admin')

@section('content')
<div class="row mx-3">
	<div class="col-md-4">
		<a href="admin/kelurahan" class="card card-body bg-danger">
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

<div class="mx-4">
	<div class="card">
		<div class="card-header">
			<h5><b>Status Covid-19</b></h5>
		</div>
		<div class="card-body">
			<table class="table table-bordered" id="data_covid">
				<thead>
					<tr>
						<th>
							No.
						</th>
						<th>
							Dari Tanggal
						</th>
						<th>
							Sampai Tanggal
						</th>
						<th>
							Jumlah Positif
						</th>
						<th>
							Rata-Rata Positif
						</th>
					</tr>
				</thead>
				<tbody>
					@php
						$i = 1;
						$bulan = Sisfor::varBulan();
					@endphp
					@foreach(Sisfor::data_periode() as $d)
					<tr>
						<td align="center" class="w-auto">
							{{ $i++ }}.
						</td>
						<td>
							@php
								$tgl = str_replace("--", 
									$bulan[(int) date("m", strtotime($d->dari_tgl))], 
									date("d -- Y", strtotime($d->dari_tgl)));
							@endphp
							{{ $tgl }}
						</td>
						<td>
							@php
								$tgl = str_replace("--", 
									$bulan[(int) date("m", strtotime($d->sampai_tgl))], 
									date("d -- Y", strtotime($d->sampai_tgl)));
							@endphp
							{{ $tgl }}
						</td>
						<td>
							@php
								$totalPasien = Sisfor::status($d->total_pasien);
								$rata2Pasien = Sisfor::status($d->rata2_pasien);
							@endphp
							<span class="fas fa-circle" style="color:var({{$totalPasien[0]}})"></span>
							{{$d->total_pasien}} Orang
						</td>
						<td>
							<span class="fas fa-circle" style="color:var({{$rata2Pasien[0]}})"></span>
							{{round($d->rata2_pasien, 2)}} Orang
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection