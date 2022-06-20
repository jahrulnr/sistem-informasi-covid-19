@extends('template.admin')

@section('content')
<!-- Moment -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/moment/locale/id.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<!-- InputMask -->
<script src="{{ asset('plugins/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Toastr -->
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>

<style type="text/css">
	/* DataTables */
	@import url('{{ asset("plugins/datatables-bs4/css/dataTables.bootstrap4.min.css") }}');
	@import url('{{ asset("plugins/datatables-responsive/css/responsive.bootstrap4.min.css") }}');
	/* Daterange Picker */
	@import url('{{ asset("plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css") }}');
	@import url('{{ asset("plugins/toastr/toastr.min.css") }}');

	#btn_add {
		margin-bottom: 0.2rem !important;
		margin-left: 0.75rem;
	}

	th {
		text-align: center;
	}	
</style>

<div class="mx-3">
	<div class="card card-body">
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
					<th>
						Aksi
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
					<td align="center" class="w-auto">
						<button class="btn btn-danger btn-sm mb-1" data-toggle="modal" data-target="#kosongkan" onclick="kosongkan_data({{ $d->id_periode }})">
							<span class="fas fa-trash fa-sm"></span> Kosongkan
						</button>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="kosongkan" tabindex="-1" role="dialog" aria-labelledby="label_kosongkan" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="label_kosongkan">
			Kosongkan Data Data Periode
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	Yakin mengosongkan periode ini? <br/>
      	<small>* Mengosongkan periode akan menghapus data covid yang terkait pada periode ini.</small>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
        	Tidak
        </button>
        <a href="" class="btn btn-danger" id="kosongkan_data">
        	Ya
        </a>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

	function kosongkan_data(id){
		$('#kosongkan_data').attr('href', '/admin/periode/kosongkan_data/'+id);
	}
	
	$(document).ready(function(){
  	var hash = window.location.hash;
  	if(hash == '#simpan_berhasil'){
  		toastr.success('Data berhasil disimpan');
  	}
  	else if(hash == '#simpan_gagal'){
  		toastr.error('Data gagal disimpan');
  	}
  	else if(hash == '#ubah_berhasil'){
  		toastr.success('Data berhasil diubah');
  	}
  	else if(hash == '#ubah_gagal'){
  		toastr.error('Data gagal diubah');
  	}
  	else if(hash == '#kosongkan_berhasil'){
  		toastr.success('Data berhasil dikosongkan');
  	}
  	else if(hash == '#kosongkan_gagal'){
  		toastr.error('Data gagal dikosongkan');
  	}

    $("#data_covid").DataTable({
      "responsive": true,
      "autoWidth": false,
      "language": {
          url: '//cdn.datatables.net/plug-ins/1.11.3/i18n/id.json'
      },
    });

	  $('input[name="dari_tanggal"], input[name="sampai_tanggal"]').inputmask();
    $('#reservationdate1, #reservationdate2').datetimepicker({
        format: 'YYYY/MM/DD',
        locale: 'id'
    });
  });
</script>
@endsection