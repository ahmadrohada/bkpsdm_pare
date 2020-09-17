<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Periode;
use App\Models\Renja;
use App\Models\CapaianPKTahunan;



use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Input;

class CapaianPKTahunanAPIController extends Controller {



    public function CreateConfirm(Request $request)
	{

        //data yang harus diterima yaitu Renja  ID dan triwulan
        $renja_id     = $request->renja_id;

        $cp_status = Renja::WHERE('renja.id',$renja_id)
                            ->rightjoin('db_pare_2018.capaian_pk_tahunan AS capaian_pk', function($join){
                                $join   ->on('capaian_pk.renja_id','=','renja.id');
                            })
                            ->count();

        return $cp_status;
    }

    public function SKPDCapaianPKTahunanList(Request $request)
    {

        $skpd_id = $request->skpd_id;
        $skp = Renja::
                        LEFTJOIN('db_pare_2018.capaian_pk_tahunan AS capaian_tahunan', function($join){
                            $join   ->on('capaian_tahunan.renja_id','=','renja.id');
                        })
                        ->LEFTJOIN('db_pare_2018.periode AS periode', function($join){
                            $join   ->on('renja.periode_id','=','periode.id');
                        }) 
                        ->SELECT(
                                'renja.id AS renja_id',
                                'renja.periode_id',
                                'renja.send_to_kaban',
                                'renja.kepala_skpd_id',
                                'renja.nama_kepala_skpd',
                                'renja.status_approve',
                                'capaian_tahunan.id AS capaian_pk_tahunan_id',
                                'periode.label AS periode_label',
                                'periode.awal AS awal'

            
                         )
                        ->WHERE('renja.skpd_id',$skpd_id)
                        ->ORDERBY('renja.id','DESC')
                        ->GET();

                    
       
           $datatables = Datatables::of($skp)
            ->addColumn('periode', function ($x) {
                //return Pustaka::periode_tahun($x->Periode->label);
                return $x->periode_label;
            }) 
            ->addColumn('nama_kepala_skpd', function ($x) {
                return $x->nama_kepala_skpd;
            })
            ->addColumn('capaian_pk', function ($x) {
                return '-';
                /* if ( $x->capaian_id != null ){
                    $data_kinerja               = $this->hitung_capaian_tahunan($x->capaian_id); 
                
                    //kegiatan tahunan
                    $jm_capaian_kegiatan_tahunan        = $data_kinerja['jm_capaian_kegiatan_tahunan'];
                    $jm_kegiatan_tahunan                = $data_kinerja['jm_kegiatan_tahunan'];
                    $ave_capaian_kegiatan_tahunan       = $data_kinerja['ave_capaian_kegiatan_tahunan'];
                    //tugas tambahan
                    $jm_tugas_tambahan                  = $data_kinerja['jm_tugas_tambahan'];
                    $jm_capaian_tugas_tambahan          = $data_kinerja['jm_capaian_tugas_tambahan'];
                    $ave_capaian_tugas_tambahan         = $data_kinerja['ave_capaian_tugas_tambahan'];
                    //unsur penunjang
                    $nilai_unsur_penunjang_tugas_tambahan   = $data_kinerja['nilai_unsur_penunjang_tugas_tambahan'];
                    $nilai_unsur_penunjang_kreativitas      = $data_kinerja['nilai_unsur_penunjang_kreativitas'];
                    $nilai_unsur_penunjang              = $nilai_unsur_penunjang_tugas_tambahan + $nilai_unsur_penunjang_kreativitas;
            
                    $jm_kegiatan_skp                    = $jm_kegiatan_tahunan + $jm_tugas_tambahan;
                    $jm_capaian_kegiatan_skp            = $jm_capaian_kegiatan_tahunan + $jm_capaian_tugas_tambahan;
            
                    $capaian_kinerja_tahunan  = Pustaka::ave($jm_capaian_kegiatan_skp,$jm_kegiatan_skp);
                    $capaian_skp              = $capaian_kinerja_tahunan +  $nilai_unsur_penunjang ;
                    return $capaian_skp;
                }else{
                    return '-';
                } */
                
             
            });
          
    
            if ($keyword = $request->get('search')['value']) {
                $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
            } 
            
    
        return $datatables->make(true);
        
    }

    public function Store(Request $request)
	{
        $messages = [
                 'renja_id.required'                   => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'renja_id'            => 'required',
                        ),
                        $messages
        );
    
        if ( $validator->fails() ){
            return response()->json(['errors'=>$validator->messages()],422);
        }

            $capaian_pk_tahunan                         = new CapaianPKTahunan;
            $capaian_pk_tahunan->renja_id               = Input::get('renja_id');
            
    
            if ( $capaian_pk_tahunan->save()){
                return \Response::make($capaian_pk_tahunan->id, 200);
            }else{
                return \Response::make('error', 500);
            } 
    } 

   
}
