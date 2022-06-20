<?php

namespace App\Http\Controllers; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \App\Helpers\Sisfor;
 
class HomeController extends Controller{

	public function __construct()
	{
		$this->middleware(function ($request, $next) {
			Sisfor::updatePeriode();
			return $next($request);
		});    
	}

	function homepage () {
		$t_week = Sisfor::date_this_week();
		$data = DB::table('periode')
			->leftJoin('data_covid', function($join){
				$join->on('data_covid.id_periode', 'periode.id_periode');
			})
			->select([
				DB::raw("sum(case when data_covid.id_periode = periode.id_periode and jumlah_pasien_covid>5 then jumlah_pasien_covid end) as Merah"),
				DB::raw("sum(case when data_covid.id_periode = periode.id_periode and jumlah_pasien_covid>2 and jumlah_pasien_covid<=5 then jumlah_pasien_covid end) as Oren"),
				DB::raw("sum(case when data_covid.id_periode = periode.id_periode and jumlah_pasien_covid>0 and jumlah_pasien_covid<=2 then jumlah_pasien_covid end) as Kuning"),
				DB::raw("sum(case when data_covid.id_periode = periode.id_periode and jumlah_pasien_covid=0 then jumlah_pasien_covid end) as Hijau"),
				'periode.*'
			])
			->whereNotNull('data_covid.id_periode')
			->where('dari_tgl', '<', $t_week)
			->groupBy('periode.id_periode')
			->orderby('sampai_tgl', 'asc')
			->take(7);

		$tampil_data = true;
		$periode = $hijau = $kuning = $Oren = $merah = null;
		if($data->count() < 1)
			$tampil_data = false;
		else{
			$data = $data->get();
			foreach($data as $d){
				$periode[] = [$d->id_periode, date("d/m/Y", strtotime($d->dari_tgl))." - ".date("d/m/Y", strtotime($d->sampai_tgl))];
				$hijau[] = $d->Hijau;
				$kuning[] = $d->Kuning;
				$Oren[] = $d->Oren;
				$merah[] = $d->Merah;
			}
		}

	    return view('homepage', [
	    	'periode'=>$periode, 
	    	'hijau'=>$hijau,
	    	'kuning'=>$kuning,
	    	'Oren'=>$Oren,
	    	'merah'=>$merah
	    ]);
	}

	function getPeriodeData($id){
		$data = DB::table('data_covid')
			->join('kelurahan', 'kelurahan.id_kelurahan', 'data_covid.id_kelurahan')
			->where('id_periode', $id)
			->orderby('kelurahan', 'asc')
			->get();

		$data_periode = [];
		$curr_kelurahan = "";
		$i = 0;
		foreach($data as $d){
			if(in_array($d->kelurahan, array_keys($data_periode))){
				$i++;
				$data_periode[$d->kelurahan]['labels'][] = "RW " . $d->rw;
				$data_periode[$d->kelurahan]['jumlah'] += $d->jumlah_pasien_covid;
				$data_periode[$d->kelurahan]['rata2'] += $d->jumlah_pasien_covid;

			    switch(Sisfor::status($d->jumlah_pasien_covid)[1]){
			    	case "Hijau":
			    		$data_periode[$d->kelurahan]["datasets"][0]["data"][] = $d->jumlah_pasien_covid;
			    		$data_periode[$d->kelurahan]["datasets"][1]["data"][] = null;
			    		$data_periode[$d->kelurahan]["datasets"][2]["data"][] = null;
			    		$data_periode[$d->kelurahan]["datasets"][3]["data"][] = null;
			    	break;

			    	case "Kuning":
			    		$data_periode[$d->kelurahan]["datasets"][0]["data"][] = null;
			    		$data_periode[$d->kelurahan]["datasets"][1]["data"][] = $d->jumlah_pasien_covid;
			    		$data_periode[$d->kelurahan]["datasets"][2]["data"][] = null;
			    		$data_periode[$d->kelurahan]["datasets"][3]["data"][] = null;
			    	break;

			    	case "Oren":
			    		$data_periode[$d->kelurahan]["datasets"][0]["data"][] = null;
			    		$data_periode[$d->kelurahan]["datasets"][1]["data"][] = null;
			    		$data_periode[$d->kelurahan]["datasets"][2]["data"][] = $d->jumlah_pasien_covid;
			    		$data_periode[$d->kelurahan]["datasets"][3]["data"][] = null;
			    	break;

			    	case "Merah":
			    		$data_periode[$d->kelurahan]["datasets"][0]["data"][] = null;
			    		$data_periode[$d->kelurahan]["datasets"][1]["data"][] = null;
			    		$data_periode[$d->kelurahan]["datasets"][2]["data"][] = null;
			    		$data_periode[$d->kelurahan]["datasets"][3]["data"][] = $d->jumlah_pasien_covid;
			    	break;
			    }
			}else{
				$data_periode[$d->kelurahan] = array(
			      	"labels" => ["RW ".$d->rw],
					"jumlah" => $d->jumlah_pasien_covid,
					"rata2" => $d->jumlah_pasien_covid,
			      	"datasets" => [
			      		array( 
				    		"data" => [],
				    		"label" => "Hijau",
				    		"borderColor" => "#0b0",
				    		"backgroundColor" => "#0b0",
				    		"fill" => false,
			        	),
			      		array( 
				    		"data" => [],
				    		"label" => "Kuning",
				    		"borderColor" => "#ff0",
				    		"backgroundColor" => "#ff0",
				    		"fill" => false,
			        	),
			      		array( 
				    		"data" => [],
				    		"label" => "Oren",
				    		"borderColor" => "#fa0",
				    		"backgroundColor" => "#fa0",
				    		"fill" => false,
			        	),
			      		array( 
				    		"data" => [],
				    		"label" => "Merah",
				    		"borderColor" => "#e00",
				    		"backgroundColor" => "#e00",
				    		"fill" => true,
			        	)
			        ]
			    );
			    switch(Sisfor::status($d->jumlah_pasien_covid)[1]){
			    	case "Hijau":
			    		$data_periode[$d->kelurahan]["datasets"][0]["data"][] = $d->jumlah_pasien_covid;
			    		$data_periode[$d->kelurahan]["datasets"][1]["data"][] = null;
			    		$data_periode[$d->kelurahan]["datasets"][2]["data"][] = null;
			    		$data_periode[$d->kelurahan]["datasets"][3]["data"][] = null;
			    	break;

			    	case "Kuning":
			    		$data_periode[$d->kelurahan]["datasets"][0]["data"][] = null;
			    		$data_periode[$d->kelurahan]["datasets"][1]["data"][] = $d->jumlah_pasien_covid;
			    		$data_periode[$d->kelurahan]["datasets"][2]["data"][] = null;
			    		$data_periode[$d->kelurahan]["datasets"][3]["data"][] = null;
			    	break;

			    	case "Oren":
			    		$data_periode[$d->kelurahan]["datasets"][0]["data"][] = null;
			    		$data_periode[$d->kelurahan]["datasets"][1]["data"][] = null;
			    		$data_periode[$d->kelurahan]["datasets"][2]["data"][] = $d->jumlah_pasien_covid;
			    		$data_periode[$d->kelurahan]["datasets"][3]["data"][] = null;
			    	break;

			    	case "Merah":
			    		$data_periode[$d->kelurahan]["datasets"][0]["data"][] = null;
			    		$data_periode[$d->kelurahan]["datasets"][1]["data"][] = null;
			    		$data_periode[$d->kelurahan]["datasets"][2]["data"][] = null;
			    		$data_periode[$d->kelurahan]["datasets"][3]["data"][] = $d->jumlah_pasien_covid;
			    	break;
			    }
			}
			if($curr_kelurahan != $d->kelurahan){
				if($curr_kelurahan != null){
					$data_periode[$curr_kelurahan]['rata2'] = round($data_periode[$curr_kelurahan]['rata2'] / $i, 2);
					$data_periode[$curr_kelurahan]['status_jumlah'] = Sisfor::status($data_periode[$curr_kelurahan]['jumlah']);
					$data_periode[$curr_kelurahan]['status_rata2'] = Sisfor::status($data_periode[$curr_kelurahan]['rata2']);
				}
				$curr_kelurahan = $d->kelurahan;
				$i = 1;
			}
		}
		$data_periode[$curr_kelurahan]['rata2'] = round($data_periode[$curr_kelurahan]['rata2'] / ($i > 1 ? $i-1 : 1), 2);
		$data_periode[$curr_kelurahan]['status_jumlah'] = Sisfor::status($data_periode[$curr_kelurahan]['jumlah']);
		$data_periode[$curr_kelurahan]['status_rata2'] = Sisfor::status($data_periode[$curr_kelurahan]['rata2']);

        return $data_periode;
	}
}