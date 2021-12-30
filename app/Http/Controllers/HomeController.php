<?php

namespace App\Http\Controllers; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
 
class HomeController extends Controller{

	function homepage () {
		$data = DB::table(DB::raw('priode'))
			->select([
				DB::raw("sum(case when data_covid.id_priode = priode.id_priode and status='Hijau' then jumlah_pasien_covid end) as Hijau"),
				DB::raw("sum(case when data_covid.id_priode = priode.id_priode and status='Kuning' then jumlah_pasien_covid end) as Kuning"),
				DB::raw("sum(case when data_covid.id_priode = priode.id_priode and status='Orange' then jumlah_pasien_covid end) as Orange"),
				DB::raw("sum(case when data_covid.id_priode = priode.id_priode and status='Merah' then jumlah_pasien_covid end) as Merah"),
				'priode.*'
			])
			->leftJoin('data_covid', function($join){
				$join->on('data_covid.id_priode', '=', 'priode.id_priode');
			})
			->whereNotNull('data_covid.id_priode')
			->groupBy('priode.id_priode')
			->orderby('sampai_tgl', 'asc')
			->take(7);

		$tampil_data = true;
		$priode = $hijau = $kuning = $orange = $merah = null;
		if($data->count() < 1)
			$tampil_data = false;
		else{
			$data = $data->get();
			foreach($data as $d){
				$priode[] = [$d->id_priode, date("d/m/Y", strtotime($d->dari_tgl))." - ".date("d/m/Y", strtotime($d->sampai_tgl))];
				$hijau[] = $d->Hijau;
				$kuning[] = $d->Kuning;
				$orange[] = $d->Orange;
				$merah[] = $d->Merah;
			}
		}

	    return view('homepage', [
	    	'priode'=>$priode, 
	    	'hijau'=>$hijau,
	    	'kuning'=>$kuning,
	    	'orange'=>$orange,
	    	'merah'=>$merah
	    ]);
	}

	function getPeriodeData($id){
		$data = DB::table(DB::raw('data_covid'))
			->where('id_priode', $id)
			->orderby('kelurahan', 'asc')
			->get();

		$data_periode = [];
		foreach($data as $d){
			// $data_periode[] = $d->kelurahan;
			if(in_array($d->kelurahan, array_keys($data_periode))){
				$data_periode[$d->kelurahan]['labels'][] = "RW ".$d->rw;

			    switch($d->status){
			    	case "Hijau":
			    		$data_periode[$d->kelurahan]["datasets"][0]["data"][] = $d->jumlah_pasien_covid;
			    		$data_periode[$d->kelurahan]["datasets"][1]["data"][] = 0;
			    		$data_periode[$d->kelurahan]["datasets"][2]["data"][] = 0;
			    		$data_periode[$d->kelurahan]["datasets"][3]["data"][] = 0;
			    	break;

			    	case "Kuning":
			    		$data_periode[$d->kelurahan]["datasets"][0]["data"][] = 0;
			    		$data_periode[$d->kelurahan]["datasets"][1]["data"][] = $d->jumlah_pasien_covid;
			    		$data_periode[$d->kelurahan]["datasets"][2]["data"][] = 0;
			    		$data_periode[$d->kelurahan]["datasets"][3]["data"][] = 0;
			    	break;

			    	case "Orange":
			    		$data_periode[$d->kelurahan]["datasets"][0]["data"][] = 0;
			    		$data_periode[$d->kelurahan]["datasets"][1]["data"][] = 0;
			    		$data_periode[$d->kelurahan]["datasets"][2]["data"][] = $d->jumlah_pasien_covid;
			    		$data_periode[$d->kelurahan]["datasets"][3]["data"][] = 0;
			    	break;

			    	case "Merah":
			    		$data_periode[$d->kelurahan]["datasets"][0]["data"][] = 0;
			    		$data_periode[$d->kelurahan]["datasets"][1]["data"][] = 0;
			    		$data_periode[$d->kelurahan]["datasets"][2]["data"][] = 0;
			    		$data_periode[$d->kelurahan]["datasets"][3]["data"][] = $d->jumlah_pasien_covid;
			    	break;
			    }
			}else{
				$data_periode[$d->kelurahan] = array(
			      	"labels" => ["RW ".$d->rw],
			      	"datasets" => [
			      		array( 
				    		"data" => [],
				    		"label" => "Hijau",
				    		"borderColor" => "#0b0",
				    		"backgroundColor" => "#0b0",
				    		"fill" => false
			        	),
			      		array( 
				    		"data" => [],
				    		"label" => "Kuning",
				    		"borderColor" => "#ff0",
				    		"backgroundColor" => "#ff0",
				    		"fill" => false
			        	),
			      		array( 
				    		"data" => [],
				    		"label" => "Orange",
				    		"borderColor" => "#fa0",
				    		"backgroundColor" => "#fa0",
				    		"fill" => false
			        	),
			      		array( 
				    		"data" => [],
				    		"label" => "Merah",
				    		"borderColor" => "#e00",
				    		"backgroundColor" => "#e00",
				    		"fill" => false
			        	)
			        ]
			    );
			    switch($d->status){
			    	case "Hijau":
			    		$data_periode[$d->kelurahan]["datasets"][0]["data"][] = $d->jumlah_pasien_covid;
			    		$data_periode[$d->kelurahan]["datasets"][1]["data"][] = 0;
			    		$data_periode[$d->kelurahan]["datasets"][2]["data"][] = 0;
			    		$data_periode[$d->kelurahan]["datasets"][3]["data"][] = 0;
			    	break;

			    	case "Kuning":
			    		$data_periode[$d->kelurahan]["datasets"][0]["data"][] = 0;
			    		$data_periode[$d->kelurahan]["datasets"][1]["data"][] = $d->jumlah_pasien_covid;
			    		$data_periode[$d->kelurahan]["datasets"][2]["data"][] = 0;
			    		$data_periode[$d->kelurahan]["datasets"][3]["data"][] = 0;
			    	break;

			    	case "Orange":
			    		$data_periode[$d->kelurahan]["datasets"][0]["data"][] = 0;
			    		$data_periode[$d->kelurahan]["datasets"][1]["data"][] = 0;
			    		$data_periode[$d->kelurahan]["datasets"][2]["data"][] = $d->jumlah_pasien_covid;
			    		$data_periode[$d->kelurahan]["datasets"][3]["data"][] = 0;
			    	break;

			    	case "Merah":
			    		$data_periode[$d->kelurahan]["datasets"][0]["data"][] = 0;
			    		$data_periode[$d->kelurahan]["datasets"][1]["data"][] = 0;
			    		$data_periode[$d->kelurahan]["datasets"][2]["data"][] = 0;
			    		$data_periode[$d->kelurahan]["datasets"][3]["data"][] = $d->jumlah_pasien_covid;
			    	break;
			    }
			}
		}

        return json_encode($data_periode);
	}
}