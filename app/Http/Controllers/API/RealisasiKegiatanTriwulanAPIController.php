<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SasaranPerjanjianKinerja;
use App\Models\Sasaran;
use App\Models\IndikatorSasaran;
use App\Models\PerjanjianKinerja;
use App\Models\KegiatanSKPTahunan;
use App\Models\KegiatanSKPBulanan;
use App\Models\RealisasiKegiatanBulanan;
use App\Models\RealisasiKegiatanTriwulan;
use App\Models\IndikatorProgram;
use App\Models\Skpd;
use App\Models\Jabatan;
use App\Models\SKPTahunan;
use App\Models\SKPBulanan;
use App\Models\RencanaAksi;
use App\Models\Kegiatan;

use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class RealisasiKegiatanTriwulanAPIController extends Controller {

   

    public function RealisasiKegiatanTriwulan2(Request $request) 
    {
            
        $child = Jabatan::SELECT('id')->WHERE('parent_id', $request->jabatan_id )->get()->toArray(); 


       //KEGIATAN KABID
        $skp_tahunan_id = $request->skp_tahunan_id;
        $kegiatan = Kegiatan::SELECT('id','label')
                            ->WHERE('renja_kegiatan.renja_id', $request->renja_id )
                            ->WHEREIN('renja_kegiatan.jabatan_id',$child )
                            ->leftjoin('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join) use ( $skp_tahunan_id ){
                                $join   ->on('kegiatan_tahunan.kegiatan_id','=','renja_kegiatan.id');
                                
                            })
                            ->SELECT(   'renja_kegiatan.id AS kegiatan_id',
                                        'renja_kegiatan.label AS kegiatan_label',
                                        'kegiatan_tahunan.label AS kegiatan_tahunan_label',
                                        'kegiatan_tahunan.id AS kegiatan_tahunan_id',
                                        'kegiatan_tahunan.target',
                                        'kegiatan_tahunan.satuan',
                                        'kegiatan_tahunan.angka_kredit',
                                        'kegiatan_tahunan.quality',
                                        'kegiatan_tahunan.cost',
                                        'kegiatan_tahunan.target_waktu'
                                    ) 
                            ->get();

                
                
        $datatables = Datatables::of($kegiatan)
        ->addColumn('label', function ($x) {
            return $x->kegiatan_tahunan_label;
        })->addColumn('ak', function ($x) {
            return $x->ak;
        })->addColumn('output', function ($x) {
            return $x->target.' '.$x->satuan;
        })->addColumn('mutu', function ($x) {
            return $x->quality;
        })->addColumn('waktu', function ($x) {
            return $x->target_waktu;
        })->addColumn('biaya', function ($x) {
            return number_format($x->cost,'0',',','.');
        });

        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true); 
        
    } 

    
}
