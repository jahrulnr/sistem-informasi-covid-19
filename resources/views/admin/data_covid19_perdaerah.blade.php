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

	select {
		font-family: sans-serif, FontAwesome
	}
</style>

<div class="mx-3">
	<div class="card card-body">
		<div class="card-header">
			<h5>Kelurahan {{ $data_kelurahan->kelurahan }}</h5>
		</div>
		<div class="card-body">
			<table class="table table-bordered" id="data_covid">
				<thead>
					<tr>
						<th>
							No.
						</th>
						<th>
							Periode
						</th>
						<th>
							RW
						</th>
						<th>
							Jumlah Pasien Covid
						</th>
						<th>
							Jumlah Rumah
						</th>
						<th>
							Status
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
							{{ date("d/m/y", strtotime($d->dari_tgl)) }} - {{ date("d/m/y", strtotime($d->sampai_tgl)) }}
						</td>
						<td align="center" class="w-auto">
							{{ $d->rw }}
						</td>
						<td align="center">
							{{ $d->jumlah_pasien_covid }}
						</td>
						<td align="center">
							{{ $d->jumlah_rumah }}
						</td>
						<td class="w-auto">
						@php
							$stat = Sisfor::status($d->jumlah_pasien_covid);
							$color = $stat[0];
							$status = $stat[1];
						@endphp
							<span class="fas fa-circle" style="color:var({{ $color }})"></span> {{ $status }}
						</td>
						<td align="center">
							<data class="d-none" id="data-{{ $i }}">{{ json_encode($d) }}</data>
							<button class="btn btn-primary btn-sm mb-1" id="btn_edit" data-toggle="modal" data-target="#edit" onclick="ubah_data('#data-{{ $i++ }}')">
								<span class="fas fa-pencil-alt fa-sm"></span> Ubah
							</button>
							<button class="btn btn-danger btn-sm mb-1" data-toggle="modal" data-target="#hapus" onclick="hapus_data({{ $d->id_data_covid }})">
								<span class="fas fa-trash fa-sm"></span> Hapus
							</button>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="label_edit" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <form method="POST" class="modal-content" id="form_data">
      <div class="modal-header">
        <h5 class="modal-title" id="label_edit"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	@csrf
      	<input type="hidden" name="id_data_covid" />
        <div class="form-group">
			<label>RW</label>
			<input type="text" class="form-control" data-inputmask="'mask': '999'" data-mask="" im-insert="true" name="rw" placeholder="rw ..." required>
		</div>
        <div class="form-group">
			<label>Jumlah Pasien Covid</label>
			<input type="number" name="jumlah_pasien_covid" class="form-control" min="0" placeholder="0" required />
		</div>
        <div class="form-group">
			<label>Jumlah Rumah</label>
			<input type="number" name="jumlah_rumah" class="form-control" min="0" placeholder="0" required />
		</div>
        <div class="form-group">
			<label>Periode</label>
			<select class="form-control col-12" name="id_periode" id="id_periode" required>
				<option disabled>-- Pilih Periode --</option>
				@php
					$i = 0;
				@endphp
				@foreach($periode as $p)
				<option {{ ($i++ === 0) ? "selected" : "" }} value="{{ $p->id_periode }}">
					{{ date("d/m/y", strtotime($p->dari_tgl)) }} - {{ date("d/m/y", strtotime($p->sampai_tgl)) }}
				</option>
				@endforeach
			</select>
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
           Hapus Data Covid-19
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	Yakin menghapus data ini?
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
		$('#label_edit').html("Tambah Data Covid-19");
		$('#form_data').attr('action', '/admin/data_covid19/{{ $id_kelurahan }}/simpan_data');
		$('form')[1].reset();
	}

	function ubah_data(id){
		$('#label_edit').html("Ubah Data Covid-19");
		$('#form_data').attr('action', '/admin/data_covid19/{{ $id_kelurahan }}/ubah_data');

		var data = JSON.parse($(id).html());
		$('input[name="id_data_covid"]').val(data.id_data_covid);
		$('input[name="rw"]').val(data.rw);
		$('input[name="jumlah_pasien_covid"]').val(data.jumlah_pasien_covid);
		$('input[name="jumlah_rumah"]').val(data.jumlah_rumah);
		$('select[name="id_periode"]').val(data.id_periode).trigger('change');
	}

	function hapus_data(id){
		$('#hapus_data').attr('href', '/admin/data_covid19/{{ $id_kelurahan }}/hapus_data/'+id);
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

  	$('#periode').change(function(){
		$('#btn_periode').click();
	});

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

	$('input[name="rw"]').inputmask();
  	$('#id_periode').select2();
  	$('span[aria-labelledby="select2-id_periode-container"]').attr('id', 'id_periode_style');

    $('#form_data').submit(function(event){
    	var rw = $('input[name="rw"]').val().replaceAll('_', '');
    	if(rw.length < 3){
    		toastr.warning('Input rw harus 3 angka.');
    		event.preventDefault();
    	}
    });
  });
</script>
@endsection