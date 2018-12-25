<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SasaranPerjanjianKinerja;
use App\Models\Sasaran;
use App\Models\IndikatorSasaran;
use App\Models\PerjanjianKinerja;
use App\Models\KegiatanSKPTahunan;
use App\Models\IndikatorProgram;
use App\Models\SKPD;
use App\Models\SKPTahunan;

use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class KegiatanSKPTahunanAPIController extends Controller {


   
    public function kegiatan_tugas_jabatan_list(Request $request)
    {
            
       
        $dt = KegiatanSKPTahunan::WHERE('skp_tahunan_id','=', $request->skp_tahunan_id )

                ->select([   
                    'id AS kegiatan_tugas_jabatan_id',
                    'label',
                    'quantity',
                    'satuan',
                    'angka_kredit',
                    'quality',
                    'cost',
                    'target_waktu'
                    
                    ])
                ->get();

                
                
        $datatables = Datatables::of($dt)
        ->addColumn('label', function ($x) {
            return $x->label;
        })->addColumn('ak', function ($x) {
            return $x->angka_kredit;
        })->addColumn('output', function ($x) {
            return $x->quantity.' '.$x->satuan;
        })->addColumn('mutu', function ($x) {
            return $x->quality .' %';
        })->addColumn('waktu', function ($x) {
            return $x->target_waktu . ' bln';
        })->addColumn('biaya', function ($x) {
            return number_format($x->cost);
        });

        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true); 
        
    }


}
