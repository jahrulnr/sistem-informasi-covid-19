<?php

namespace App\Http\Controllers; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
 
class AdminController extends Controller{
	function admin(){
		if(session('user_name')){
			return view('admin');
		}else{
			return view('admin.login');
		}
	}

	function verify(Request $request){

		// cek user
		$check_user = DB::table('user')
			->where('user_name', $request->user_name);
		if($check_user->count() < 1)
			return redirect('/admin#login_gagal');

		// cek password
		$user = $check_user->first();
		if(!password_verify($request->pasword, $user->pasword))
			return redirect('/admin#login_gagal');

		// login sukses
		$session = [
			'id_user' => $user->id_user,
			'user_name' => $user->user_name
		];

		session($session);
		return redirect('/admin');
	}

	function logout(){
		$session = [
			'id_user' => '',
			'user_name' => ''
		];

		session($session);
		return redirect('/admin');
	}

	function kelurahan(){
		if(empty(session('user_name'))) redirect('/admin');
		$kelurahan = DB::table('kelurahan')->get();

	    return view('admin.data_covid19', [
	    	'i' => 1,
	    	'kelurahan' => $kelurahan,
	    	'data' => $kelurahan
	    ]);
	}

	function simpan_data_kelurahan(Request $request){
		// cek user
		if(empty(session('user_name'))) redirect('/admin');

		// proses
		$simpan_data = DB::table('kelurahan')->insert([
			'kelurahan' => $request->kelurahan
		]);

		if($simpan_data > 0){
			return redirect('/admin/kelurahan#simpan_berhasil');
		}else{
			return redirect('/admin/kelurahan#simpan_gagal');
		}
	}

	function ubah_data_kelurahan(Request $request){
		// cek user
		if(empty(session('user_name'))) redirect('/admin');

		// proses
		// return json_encode($_POST);
		$simpan_data = DB::table('kelurahan')
			->where('id_kelurahan', $request->id_kelurahan)
			->update([
				'kelurahan' => $request->kelurahan
			]);

		if($simpan_data > 0){
			return redirect('/admin/kelurahan#ubah_berhasil');
		}else{
			return redirect('/admin/kelurahan#ubah_gagal');
		}
	}

	function hapus_data_kelurahan($id){
		// cek user
		if(empty(session('user_name'))) redirect('/admin');

		// proses
		$hapus_data = DB::table('kelurahan')
			->where('id_kelurahan', $id)
			->delete();

		if($hapus_data > 0){
			return redirect('/admin/kelurahan#hapus_berhasil');
		}else{
			return redirect('/admin/kelurahan#hapus_gagal');
		}
	}

	function data_covid19($id_kelurahan){
		if(empty(session('user_name'))) redirect('/admin');
		$data_covid19 = DB::table(DB::raw('kelurahan, data_covid, priode'))
			->where('kelurahan.id_kelurahan', DB::raw('data_covid.id_kelurahan'))
			->where('data_covid.id_priode', DB::raw('priode.id_priode'))
			->where('kelurahan.id_kelurahan', $id_kelurahan)
			->get();
		$data_periode = DB::table('priode')->get();
		$kelurahan = DB::table('kelurahan')->orderby('kelurahan', 'asc')->get();
		$data_kelurahan = DB::table('kelurahan')->where('id_kelurahan', $id_kelurahan)->first();

	    return view('admin.data_covid19_perdaerah', [
	    	'i' => 1,
	    	'id_kelurahan' => $id_kelurahan,
	    	'kelurahan' => $kelurahan,
	    	'data_kelurahan' => $data_kelurahan,
	    	'data' => $data_covid19,
	    	'periode' => $data_periode
	    ]);
	}

	function simpan_data_covid19($id_kelurahan, Request $request){
		// cek user
		if(empty(session('user_name'))) redirect('/admin');

		// proses
		$simpan_data = DB::table('data_covid')->insert([
			'id_kelurahan' => $id_kelurahan,
			'rw' => $request->rw,
			'jumlah_pasien_covid' => $request->jumlah_pasien_covid,
			'jumlah_rumah' => $request->jumlah_rumah,
			'status' => $request->status,
			'id_priode' => $request->id_priode
		]);

		if($simpan_data > 0){
			return redirect(url()->previous() . '#simpan_berhasil');
		}else{
			return redirect(url()->previous() . '#simpan_gagal');
		}
	}

	function ubah_data_covid19($id_kelurahan, Request $request){
		// cek user
		if(empty(session('user_name'))) redirect('/admin');

		// proses
		$simpan_data = DB::table('data_covid')
			->where('id_data_covid', $request->id_data_covid)
			->update([
				'rw' => $request->rw,
				'jumlah_pasien_covid' => $request->jumlah_pasien_covid,
				'jumlah_rumah' => $request->jumlah_rumah,
				'status' => $request->status,
				'id_priode' => $request->id_priode
			]);

		if($simpan_data > 0){
			return redirect(url()->previous() . '#ubah_berhasil');
		}else{
			return redirect(url()->previous() . '#ubah_gagal');
		}
	}

	function hapus_data_covid19($id_kelurahan, $id){
		// cek user
		if(empty(session('user_name'))) redirect('/admin');

		// proses
		$hapus_data = DB::table('data_covid')
			->where('id_data_covid', $id)
			->delete();

		if($hapus_data > 0){
			return redirect(url()->previous() . '#hapus_berhasil');
		}else{
			return redirect(url()->previous() . '#hapus_gagal');
		}
	}

	function periode() {
		// cek user
		if(empty(session('user_name'))) redirect('/admin');

		// proses
		$data = DB::table('priode')->get();
		$kelurahan = DB::table('kelurahan')->get();

	    return view('admin.periode', [
	    	'i'=>1, 
	    	'kelurahan' => $kelurahan,
		    'data'=>$data
		]);
	}

	function simpan_data_periode(Request $request){
		// cek user
		if(empty(session('user_name'))) redirect('/admin');

		// proses
		$data = DB::table('priode')
			->insert([
				'dari_tgl' => $request->dari_tgl,
				'sampai_tgl' => $request->sampai_tgl
			]);

		if($data > 0){
			return redirect('/admin/periode#simpan_berhasil');
		}else{
			return redirect('/admin/periode#simpan_gagal');
		}
	}

	function ubah_data_periode(Request $request){
		// cek user
		if(empty(session('user_name'))) redirect('/admin');

		// proses
		$data = DB::table('priode')
			->where('id_priode', $request->id_priode)
			->update([
				'dari_tgl' => $request->dari_tgl,
				'sampai_tgl' => $request->sampai_tgl
			]);

		if($data > 0){
			return redirect('/admin/periode#ubah_berhasil');
		}else{
			return redirect('/admin/periode#ubah_gagal');
		}
	}

	function hapus_data_periode($id){
		// cek user
		if(empty(session('user_name'))) redirect('/admin');

		// proses
		$covid = DB::table('data_covid')
			->where('id_priode', $id)
			->delete();
		$data = DB::table('priode')
			->where('id_priode', $id)
			->delete();

		if($data > 0){
			return redirect('/admin/periode#hapus_berhasil');
		}else{
			return redirect('/admin/periode#hapus_gagal');
		}
	}

	function user() {
		// cek user
		if(empty(session('user_name'))) redirect('/admin');

		// proses
		$data = DB::table('user')->get();
		$kelurahan = DB::table('kelurahan')->get();

	    return view('admin.user', [
	    	'i'=>1, 
	    	'kelurahan' => $kelurahan,
		    'data'=>$data
		]);
	}

	function simpan_data_user(Request $request){
		$data = DB::table('user')->insert([
			'nama' => $request->nama,
			'user_name' => strtolower($request->user_name),
			'pasword' => bcrypt($request->pasword)
		]);

		if($data > 0){
			return redirect('/admin/user#simpan_berhasil');
		}else{
			return redirect('/admin/user#simpan_gagal');
		}
	}

	function ubah_data_user(Request $request){
		// cek user
		if(empty(session('user_name'))) redirect('/admin');

		// proses
		$user['nama'] = $request->nama;
		if(!empty($request->pasword))
			$user['pasword'] = bcrypt($request->pasword);
		$data = DB::table('user')
			->where('id_user', $request->id_user)
			->update($user);

		if($data > 0){
			return redirect('/admin/user#ubah_berhasil');
		}else{
			return redirect('/admin/user#ubah_gagal');
		}
	}

	function hapus_data_user($id){
		// cek user
		if(empty(session('user_name'))) redirect('/admin');

		// proses
		$hitung_user = DB::table('user')->count();

		if($hitung_user > 1){
			$data = DB::table('user')
				->where('id_user', $id)
				->delete();

			if($data > 0){
				return redirect('/admin/user#hapus_berhasil');
			}else{
				return redirect('/admin/user#hapus_gagal');
			}
		}else{
			return redirect('/admin/user#hapus_gagal');
		}
	}
}