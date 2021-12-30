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
<!-- Toastr -->
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>

<style type="text/css">
	/* DataTables */
	@import url('{{ asset("plugins/datatables-bs4/css/dataTables.bootstrap4.min.css") }}');
	@import url('{{ asset("plugins/datatables-responsive/css/responsive.bootstrap4.min.css") }}');
	/* Toastr */
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
						Username
					</th>
					<th>
						Nama
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
						{{ $d->user_name }}
					</td>
					<td>
						{{ $d->nama }}
					</td>
					<td align="center">
						{{ $d->pasword = null }}
						<data class="d-none" id="data-{{ $d->id_user}}">{{ json_encode($d) }}</data>
						<button class="btn btn-primary btn-sm mb-1"  data-toggle="modal" data-target="#edit" onclick="ubah_data('#data-{{ $d->id_user }}');">
							<span class="fas fa-pencil-alt fa-sm"></span>
						</button>
						<button class="btn btn-danger btn-sm mb-1" data-toggle="modal" data-target="#hapus" onclick="hapus_data({{ $d->id_user }})">
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
    <form method="POST"  class="modal-content" id="form_data">
      <div class="modal-header">
        <h5 class="modal-title" id="label_edit">
           Ubah Data User
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	@csrf
      	<input type="hidden" name="id_user">
        <div class="form-group">
					<label>Username</label>
					<input type="text" name="user_name" class="form-control" disabled required/>
				</div>
        <div class="form-group">
					<label>Nama</label>
					<input type="text" name="nama" class="form-control" placeholder="Nama ..." required />
				</div>
        <div class="form-group">
					<label id="password">Password <sup>(*Optional)</sup></label>
					<input type="password" name="pasword" class="form-control" placeholder="Password ..." required />
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
           Hapus Data User
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	Yakin menghapus user ini?
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
		$('#label_edit').html("Tambah User");
		$('#form_data').attr('action', '/admin/user/simpan_data');
		$('#password').html('Password');

		$('input[name="user_name"]').removeAttr('disabled', true);
		$('input[name="pasword"]').attr('required', true);
		$('form')[1].reset();
	}

	function ubah_data(id){
		$('#label_edit').html("Ubah User");
		$('#form_data').attr('action', '/admin/user/ubah_data');
		$('#password').html('Password <sup>(*Optional)</sup>');
		$('input[name="pasword"]').removeAttr('required');

		var data = JSON.parse($(id).html());
		$('input[name="id_user"]').val(data.id_user);
		$('input[name="user_name"]').attr('disabled', true);
		$('input[name="user_name"]').val(data.user_name);
		$('input[name="nama"]').val(data.nama);
		$('input[name="pasword"]').val('');
	}

	function hapus_data(id){
		$('#hapus_data').attr('href', '/admin/user/hapus_data/'+id);
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

    $('#form_data').submit(function(event){
    	var pass = $('input[name="pasword"]').val();

    	if(pass.length > 0 && pass.length < 6){
    		toastr.warning("Password harus lebih dari 6 karakter.");
    		event.preventDefault();
    	}
    });
  });
</script>
@endsection