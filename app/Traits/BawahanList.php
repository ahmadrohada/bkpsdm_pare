<?php

namespace App\Traits;

use App\Models\CapaianBulanan;
use App\Models\Jabatan;
use App\Models\RencanaAksi;
use App\Models\RealisasiRencanaAksiKaban;
use App\Models\KegiatanSKPBulanan;
use App\Models\KegiatanSKPBulananJFT;
use App\Models\HistoryJabatan;


use App\Helpers\Pustaka;

trait BawahanList
{




    protected function JabatanFromHistoryId($history_jabatan_id ){
        $data = HistoryJabatan::WHERE('tb_history_jabatan.id',$history_jabatan_id)
                                ->leftjoin('demo_asn.m_skpd AS skpd', function($join){
                                    $join   ->on('skpd.id','=','tb_history_jabatan.id_jabatan');
                                })

                                ->SELECT('skpd.skpd AS jabatan')
                                ->first();
        if ( $data != null ){
            return $data->jabatan;
        }else{
            return "-";
        }
        
    }




    protected function eselon2($jabatan_id){
        $data = Jabatan::WHERE('m_skpd.parent_id', $jabatan_id )
                        ->WHEREIN('m_skpd.id_eselon',[3,4,5])
                        ->leftjoin('demo_asn.m_eselon AS eselon', function($join){  //Pelaksana
                            $join   ->on('m_skpd.id_eselon','=','eselon.id');
                        })
                        ->SELECT('m_skpd.id AS jabatan_id','m_skpd.skpd AS jabatan','eselon.eselon AS eselon')
                        
                        ->get(); 
        return $data;
    }




        
    protected function BawahanListCapaianBulanan($jabatan_id,$jenis_jabatan)
    {
        switch($jenis_jabatan)
		{
			case '1' 	    : return $this->eselon2($jabatan_id);
				break;
			case '2'	    : "";
				break;	
            case '3'	    : "";
                break;	
            case '4'	    : "";
                break;	
            case 'jft'	    : "";
                break;	
            case 'jfu'	    : "";
                break;
            case 'irban'	: "";	
                break;            
        }



    }



}