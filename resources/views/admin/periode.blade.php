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
						Aksi
					</th>
				</tr>
			</thead>
			<tbody>
				@foreach($data as $d)
				<tr>
					<td>
						{{ $i }}.
					</td>
					<td>
						{{ date("d-m-Y", strtotime($d->dari_tgl)) }}
					</td>
					<td>
						{{ date("d-m-Y", strtotime($d->sampai_tgl)) }}
					</td>
					<td align="center">
						<data class="d-none" id="data-{{ $i }}">{{ json_encode($d) }}</data>
						<button class="btn btn-primary btn-sm mb-1"  data-toggle="modal" data-target="#edit" onclick="ubah_data('#data-{{ $i++ }}')">
							<span class="fas fa-pencil-alt fa-sm"></span>
						</button>
						<button class="btn btn-danger btn-sm mb-1" data-toggle="modal" data-target="#hapus" onclick="hapus_data({{ $d->id_priode }})">
							<span class="fas fa-trash fa-sm"></span>
						</button>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="label_edit" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <form method="POST" class="modal-content" id="form_data">
      <div class="modal-header">
        <h5 class="modal-title" id="label_edit">
           Ubah Data Periode
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	@csrf
      	<input type="hidden" name="id_priode">
        <div class="form-group">
					<label>Dari Tanggal</label>
					<div class="input-group date" id="reservationdate1" data-target-input="nearest">
            <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate1"   data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy/mm/dd" data-mask="" im-insert="false" name="dari_tgl" placeholder="yyyy/mm/dd" required>
            <div class="input-group-append" data-target="#reservationdate1" data-toggle="datetimepicker">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
          	</div>
        	</div>
				</div>
        <div class="form-group">
					<label>Sampai Tanggal</label>
					<div class="input-group date" id="reservationdate2" data-target-input="nearest">
            <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate2"   data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy/mm/dd" data-mask="" im-insert="false" name="sampai_tgl" placeholder="yyyy/mm/dd" required>
            <div class="input-group-append" data-target="#reservationdate2" data-toggle="datetimepicker">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
          	</div>
        	</div>
				</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
					<span class="fas fa-undo"></span>
        	Batal
        </button>
        <button type="submit" class="btn btn-primary">
        	<span class="fas fa-save"></span>
        	Simpan
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="hapus" tabindex="-1" role="dialog" aria-labelledby="label_hapus" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="label_hapus">
           Hapus Data Periode
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	Yakin menghapus periode ini? <br/>
      	<small>* Menghapus priode juga akan menghapus data covid yang terkait.</small>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
					<span class="fas fa-undo"></span>
        	Tidak
        </button>
        <a href="" class="btn btn-danger" id="hapus_data">
        	<span class="fas fa-trash"></span>
        	Ya
        </a>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	function tambah_data(){
		$('#label_edit').html("Tambah Data Periode");
		$('#form_data').attr('action', '/admin/periode/simpan_data');
		$('form')[1].reset();
	}

	function ubah_data(id){
		$('#label_edit').html("Ubah Data Periode");
		$('#form_data').attr('action', '/admin/periode/ubah_data');

		var data = JSON.parse($(id).html());
		$('input[name="id_priode"]').val(data.id_priode);
		$('input[name="dari_tgl"]').val(data.dari_tgl);
		$('input[name="sampai_tgl"]').val(data.sampai_tgl);
	}

	function hapus_data(id){
		$('#hapus_data').attr('href', '/admin/periode/hapus_data/'+id);
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
  	else if(hash == '#hapus_berhasil'){
  		toastr.success('Data berhasil dihapus');
  	}
  	else if(hash == '#hapus_gagal'){
  		toastr.error('Data gagal dihapus');
  	}

    $("#data_covid").DataTable({
      "responsive": true,
      "autoWidth": false,
      "language": {
          url: '//cdn.datatables.net/plug-ins/1.11.3/i18n/id.json'
      },
      "fnDrawCallback": function (oSettings) {
				$('.dataTables_filter').each(function () {
					if($('#btn_add').length < 1)
						$(this).append('<button class="btn btn-primary btn-sm" id="btn_add" data-toggle="modal" data-target="#edit" onclick="tambah_data()"><span class="fas fa-plus"></span> Tambah Data</button>');
				});
			}
    });

	  $('input[name="dari_tanggal"], input[name="sampai_tanggal"]').inputmask();
    $('#reservationdate1, #reservationdate2').datetimepicker({
        format: 'YYYY/MM/DD',
        locale: 'id'
    });
  });
</script>
@endsection