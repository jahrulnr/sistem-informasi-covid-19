<?php

namespace App\Helpers;
use Illuminate\Support\Facades\DB;

class Sisfor
{
    public static function varBulan(){
        return array (
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
    }

    public static function week_start_time(){
        return strtotime('sunday last week') + 7 * 3600;
    }

    public static function date_this_week(){
        return date("Y-m-d", self::week_start_time());
    }

    public static function updatePeriode(){
        // update periode otomatis
        $time = self::week_start_time();
        if(DB::table('periode')->where('dari_tgl', date("Y-m-d", $time))->doesntExist())
            $data = DB::table('periode')
                ->insert([
                    'dari_tgl' => date("Y-m-d", $time), // minggu
                    'sampai_tgl' => date("Y-m-d", $time + 6 * 24 * 3600) // sabtu
                ]);
    }

    public static function data_periode(){
        return DB::table('periode')
        ->leftJoin("data_covid", "data_covid.id_periode", "periode.id_periode")
        ->select(["periode.*", 
            DB::raw("IF(sum(jumlah_pasien_covid) is null, 0, SUM(jumlah_pasien_covid)) as total_pasien"), 
            DB::raw("IF(avg(jumlah_pasien_covid) is null, 0, avg(jumlah_pasien_covid)) as rata2_pasien")
            ])
        ->groupBy("periode.id_periode")
        ->get(); 
    }

    public static function status($n){
        $color = "--gray";
        $status = "Tidak diketahui";
        if($n > 5){
            $color = "--red";
            $status = "Merah";
        }
        elseif($n > 2){
            $color = "--orange";
            $status = "Oren";
        }
        elseif($n > 0){
            $color = "--yellow";
            $status = "Kuning";
        }
        elseif($n == 0){
            $color = "--green";
            $status = "Hijau";
        }

        return [$color, $status];
    }
}
