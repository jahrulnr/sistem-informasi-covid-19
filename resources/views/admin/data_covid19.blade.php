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
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
<!-- Toastr -->
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>

<style type="text/css">
	/* DataTables */
	@import url('{{ asset("plugins/datatables-bs4/css/dataTables.bootstrap4.min.css") }}');
	@import url('{{ asset("plugins/datatables-responsive/css/responsive.bootstrap4.min.css") }}');
	@import url('{{ asset("plugins/select2/css/select2.min.css") }}');
	@import url('{{ asset("plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css") }}');
	@import url('{{ asset("plugins/toastr/toastr.min.css") }}');

	#btn_add {
		margin-bottom: 0.2rem !important;
		margin-left: 0.75rem;
	}

	th {
		text-align: center;
	}	

	#id_periode_style {
		width: 100%;
		height: calc(2.25rem + 2px);
		padding: .375rem .75rem;
		font-size: 1rem;
		font-weight: 400;
		line-height: 1.5;
		color: #495057;
		background-color: #fff;
		background-clip: padding-box;
		border: 1px solid #ced4da;
		border-radius: .25rem;
		box-shadow: inset 0 0 0 transparent;
		transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
	}

	#id_periode_style span{
		padding-left: 0.2rem;
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
						Kelurahan
					</th>
					<th>
						Aksi
					</th>
				</tr>
			</thead>
			<tbody>
				@foreach($data as $d)
				<tr>
					<td align="center" class="w-auto">
						{{ $i }}.
					</td>
					<td>
						{{ $d->kelurahan }}
					</td>
					<td align="center" class="w-auto">
						<data class="d-none" id="data-{{ $i }}">{{ json_encode($d) }}</data>
						<button class="btn btn-primary btn-sm mb-1" id="btn_edit" data-toggle="modal" data-target="#edit" onclick="ubah_data('#data-{{ $i++ }}')">
							<span class="fas fa-pencil-alt fa-sm"></span> Ubah
						</button>
						<button class="btn btn-danger btn-sm mb-1" data-toggle="modal" data-target="#hapus" onclick="hapus_data({{ $d->id_kelurahan }})">
							<span class="fas fa-trash fa-sm"></span> Hapus
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
           Ubah Data Kelurahan
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	@csrf
      	<input type="hidden" name="id_kelurahan" />
        <div class="form-group">
					<label>Kelurahan</label>
					<input type="text" name="kelurahan" class="form-control" placeholder="Kelurahan ..." required />
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
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="label_hapus">
           Hapus Data Kelurahan
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	Yakin menghapus data ini?<br/>
      	<small class="text-danger">* Menghapus data ini akan menghapus seluruh data covid yang terkait</small>
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
		$('#label_edit').html("Tambah Data Kelurahan");
		$('#form_data').attr('action', '/admin/kelurahan/simpan_data');
		$('form')[1].reset();
	}

	function ubah_data(id){
		$('#label_edit').html("Ubah Data Kelurahan");
		$('#form_data').attr('action', '/admin/kelurahan/ubah_data');

		var data = JSON.parse($(id).html());
		$('input[name="id_kelurahan"]').val(data.id_kelurahan);
		$('input[name="kelurahan"]').val(data.kelurahan);
	}

	function hapus_data(id){
		$('#hapus_data').attr('href', '/admin/kelurahan/hapus_data/'+id);
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
  });
</script>
@endsection