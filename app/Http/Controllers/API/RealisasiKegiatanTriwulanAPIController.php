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
use App\Models\RealisasiAnggaranKegiatan;
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

   
    //KABID
    public function RealisasiKegiatanTriwulan2(Request $request) 
    {
            

        $child = Jabatan::SELECT('id')->WHERE('parent_id', $request->jabatan_id )->get()->toArray(); 

        $capaian_triwulan_id = $request->capaian_triwulan_id;

       //KEGIATAN KABID
        $skp_tahunan_id = $request->skp_tahunan_id;
        $kegiatan = Kegiatan::WHERE('renja_kegiatan.renja_id', $request->renja_id )
                            ->WHEREIN('renja_kegiatan.jabatan_id',  $child  )
                            //LEFT JOIN ke Kegiatan SKP TAHUNAN
                            ->join('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join){
                                $join   ->on('kegiatan_tahunan.kegiatan_id','=','renja_kegiatan.id');
                                
                            })
                            //LEFT JOIN ke INDIKATOR KEGIATAN
                            ->leftjoin('db_pare_2018.renja_indikator_kegiatan AS indikator_kegiatan', function($join){
                                $join   ->on('indikator_kegiatan.kegiatan_id','=','renja_kegiatan.id');
                                
                            })
                            //LEFT JOIN TERHADAP REALISASI TRIWULAN NYA QTY
                            ->leftjoin('db_pare_2018.realisasi_triwulan_kegiatan_tahunan AS realisasi_triwulan', function($join) use ( $capaian_triwulan_id ){
                                $join   ->on('realisasi_triwulan.indikator_kegiatan_id','=','indikator_kegiatan.id');
                                $join   ->WHERE('realisasi_triwulan.capaian_id','=',  $capaian_triwulan_id );
                                
                            })

                            //LEFT JOIN TERHADAP REALISASI TRIWULAN COST
                            ->leftjoin('db_pare_2018.realisasi_triwulan_anggaran_kegiatan AS realisasi_anggaran', function($join) use ( $capaian_triwulan_id ){
                                $join   ->on('realisasi_anggaran.kegiatan_tahunan_id','=','kegiatan_tahunan.id');
                                $join   ->WHERE('realisasi_anggaran.capaian_id','=',  $capaian_triwulan_id );
                                
                            })
                            
                            //LEFT JOIN KE CAPAIAN TRIWULAN
                            ->leftjoin('db_pare_2018.capaian_triwulan AS capaian_triwulan', function($join){
                                $join   ->on('capaian_triwulan.id','=','realisasi_triwulan.capaian_id');
                            })

                            ->SELECT(   
                                        'renja_kegiatan.id AS kegiatan_id',
                                        'renja_kegiatan.jabatan_id',
                                        'renja_kegiatan.label AS kegiatan_label',

                                        'indikator_kegiatan.id AS indikator_id',
                                        'indikator_kegiatan.label AS indikator_label',
                                        'indikator_kegiatan.target AS qty_target',
                                        'indikator_kegiatan.satuan',

                                        'kegiatan_tahunan.id AS kegiatan_tahunan_id',
                                        'kegiatan_tahunan.cost AS cost_target',
                                        'kegiatan_tahunan.target_waktu AS waktu_target',
                                        'realisasi_triwulan.id AS realisasi_kegiatan_id',
                                        'realisasi_triwulan.quantity AS qty_realisasi',
                                        
                                        'realisasi_anggaran.cost AS cost_realisasi',

                                        'capaian_triwulan.status'
                                       
                                    ) 
                            
                            ->get();
                
        $datatables = Datatables::of($kegiatan)
        ->addColumn('id', function ($x) {
            return $x->kegiatan_tahunan_id;
        })->addColumn('qty_target', function ($x) {
            return $x->qty_target.' '.$x->satuan;
        })->addColumn('cost_target', function ($x) {
            return "Rp. ".number_format($x->cost_target,'0',',','.');
        })->addColumn('qty_realisasi', function ($x) {
            return $x->qty_realisasi.' '.$x->satuan;
        })->addColumn('cost_realisasi', function ($x) {
            return "Rp. ".number_format($x->cost_realisasi,'0',',','.');
        });

        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true); 
        
    } 

    //KASUBID
    public function RealisasiKegiatanTriwulan3(Request $request) 
    {
            
       
        $capaian_triwulan_id = $request->capaian_triwulan_id;

        //KASUBID
        $kegiatan = Kegiatan::WHERE('renja_kegiatan.renja_id', $request->renja_id )
                            ->WHERE('renja_kegiatan.jabatan_id','=',  $request->jabatan_id  )
                            //LEFT JOIN ke Kegiatan SKP TAHUNAN
                            ->JOIN('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join){
                                $join   ->on('kegiatan_tahunan.kegiatan_id','=','renja_kegiatan.id');
                                
                            })
                            //LEFT JOIN ke INDIKATOR KEGIATAN
                            ->leftjoin('db_pare_2018.renja_indikator_kegiatan AS indikator_kegiatan', function($join){
                                $join   ->on('indikator_kegiatan.kegiatan_id','=','renja_kegiatan.id');
                                
                            })
                            //LEFT JOIN TERHADAP REALISASI TRIWULAN NYA QTY
                            ->leftjoin('db_pare_2018.realisasi_triwulan_kegiatan_tahunan AS realisasi_triwulan', function($join) use ( $capaian_triwulan_id ){
                                $join   ->on('realisasi_triwulan.indikator_kegiatan_id','=','indikator_kegiatan.id');
                                $join   ->WHERE('realisasi_triwulan.capaian_id','=',  $capaian_triwulan_id );
                                
                            })

                            //LEFT JOIN TERHADAP REALISASI TRIWULAN COST
                            ->leftjoin('db_pare_2018.realisasi_triwulan_anggaran_kegiatan AS realisasi_anggaran', function($join) use ( $capaian_triwulan_id ){
                                $join   ->on('realisasi_anggaran.kegiatan_tahunan_id','=','kegiatan_tahunan.id');
                                $join   ->WHERE('realisasi_anggaran.capaian_id','=',  $capaian_triwulan_id );
                                
                            })
                            
                            //LEFT JOIN KE CAPAIAN TRIWULAN
                            ->leftjoin('db_pare_2018.capaian_triwulan AS capaian_triwulan', function($join){
                                $join   ->on('capaian_triwulan.id','=','realisasi_triwulan.capaian_id');
                            })

                            ->SELECT(   
                                        'renja_kegiatan.id AS kegiatan_id',
                                        'renja_kegiatan.jabatan_id',
                                        'renja_kegiatan.label AS kegiatan_label',

                                        'indikator_kegiatan.id AS indikator_id',
                                        'indikator_kegiatan.label AS indikator_label',
                                        'indikator_kegiatan.target AS qty_target',
                                        'indikator_kegiatan.satuan',

                                        'kegiatan_tahunan.id AS kegiatan_tahunan_id',
                                        'kegiatan_tahunan.cost AS cost_target',
                                        'kegiatan_tahunan.target_waktu AS waktu_target',
                                        'realisasi_triwulan.id AS realisasi_kegiatan_id',
                                        'realisasi_triwulan.quantity AS qty_realisasi',
                                        
                                        'realisasi_anggaran.cost AS cost_realisasi',

                                        'capaian_triwulan.status'
                                       
                                    ) 
                            
                            ->get();
                
        $datatables = Datatables::of($kegiatan)
        ->addColumn('id', function ($x) {
            return $x->kegiatan_tahunan_id;
        })->addColumn('qty_target', function ($x) {
            return $x->qty_target.' '.$x->satuan;
        })->addColumn('cost_target', function ($x) {
            return "Rp. ".number_format($x->cost_target,'0',',','.');
        })->addColumn('qty_realisasi', function ($x) {
            return $x->qty_realisasi.' '.$x->satuan;
        })->addColumn('cost_realisasi', function ($x) {
            return "Rp. ".number_format($x->cost_realisasi,'0',',','.');
        });

        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true); 
        
    } 

    
    public function Store(Request $request)
    {

        $messages = [
                'capaian_triwulan_id.required' => 'Harus diisi',
                'kegiatan_tahunan_id.required' => 'Harus diisi',
                'ind_kegiatan_id.required'     => 'Harus diisi',
                'qty_realisasi.required'       => 'Harus diisi',
                'satuan.required'              => 'Harus diisi',
                'cost_realisasi.required'      => 'Harus diisi'
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'capaian_triwulan_id'   => 'required',
                            'ind_kegiatan_id'       => 'required',
                            'kegiatan_tahunan_id'   => 'required',
                            'qty_realisasi'         => 'required',
                            'satuan'                => 'required',
                            'cost_realisasi'        => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $st_kt    = new RealisasiKegiatanTriwulan;

        $st_kt->indikator_kegiatan_id   = Input::get('ind_kegiatan_id');
        $st_kt->capaian_id              = Input::get('capaian_triwulan_id');
        $st_kt->quantity                = Input::get('qty_realisasi');
        $st_kt->satuan                  = Input::get('satuan');
        //$st_kt->cost                  = preg_replace('/[^0-9]/', '', Input::get('cost_realisasi'));
       

        if ( $st_kt->save()){

            //cari anggaran kegiatan realisasinya
            $rag    = RealisasiAnggaranKegiatan::WHERE('capaian_id','=',Input::get('capaian_triwulan_id'))->WHERE('kegiatan_tahunan_id','=',Input::get('kegiatan_tahunan_id'))->count();

            //jikia belum ada add new
            if ( $rag == 0 ) {
                $rag_save    = new RealisasiAnggaranKegiatan;
                $rag_save->capaian_id              = Input::get('capaian_triwulan_id');
                $rag_save->kegiatan_tahunan_id     = Input::get('kegiatan_tahunan_id');
                $rag_save->cost                    = preg_replace('/[^0-9]/', '', Input::get('cost_realisasi'));
                $rag_save->save();

            //jika sudah ada update saja
            }else{

                $rag_save    = RealisasiAnggaranKegiatan::find(Input::get('realisasi_triwulan_anggaran_kegiatan_id'));
                $rag_save->cost                    = preg_replace('/[^0-9]/', '', Input::get('cost_realisasi'));
                $rag_save->save();
            }

            return \Response::make('sukses'+$rag, 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }

    public function Detail(Request $request)
    {
       
        $capaian_triwulan_id = $request->capaian_triwulan_id;
        
        $x = RealisasiKegiatanTriwulan::

                            //LEFT JOIN ke INDIKATOR Kegiatan
                            join('db_pare_2018.renja_indikator_kegiatan AS indikator_kegiatan', function($join){
                                $join   ->on('indikator_kegiatan.id','=','realisasi_triwulan_kegiatan_tahunan.indikator_kegiatan_id');
                            })


                             //LEFT JOIN ke RENJA Kegiatan
                            ->join('db_pare_2018.renja_kegiatan AS kegiatan', function($join){
                                $join   ->on('kegiatan.id','=','indikator_kegiatan.kegiatan_id');
                            })

                           
                            //LEFT JOIN KE CAPAIAN TRIWULAN
                            ->join('db_pare_2018.capaian_triwulan AS capaian_triwulan', function($join){
                                $join   ->on('capaian_triwulan.id','=','realisasi_triwulan_kegiatan_tahunan.capaian_id');
                            })

                            //LEFT JOIN ke Kegiatan SKP TAHUNAN
                            ->leftjoin('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join){
                                $join   ->on('kegiatan_tahunan.kegiatan_id','=','kegiatan.id');
                            })
                            //LEFT JOIN TERHADAP REALISASI TRIWULAN COST
                            ->leftjoin('db_pare_2018.realisasi_triwulan_anggaran_kegiatan AS realisasi_anggaran', function($join) use($capaian_triwulan_id) {
                                $join   ->on('realisasi_anggaran.kegiatan_tahunan_id','=','kegiatan_tahunan.id');
                                $join   ->WHERE('realisasi_anggaran.capaian_id','=',  $capaian_triwulan_id );
                                
                            })
                            

                           
                            ->SELECT(   'realisasi_triwulan_kegiatan_tahunan.id AS realisasi_triwulan_kegiatan_tahunan_id',
                                        'realisasi_triwulan_kegiatan_tahunan.quantity AS qty_realisasi',
                                        'realisasi_triwulan_kegiatan_tahunan.satuan',
                                        'realisasi_triwulan_kegiatan_tahunan.indikator_kegiatan_id',

                                        'realisasi_anggaran.id AS realisasi_triwulan_anggaran_kegiatan_id',
                                        'realisasi_anggaran.cost AS cost_realisasi',
                                        
                                        'kegiatan_tahunan.id AS kegiatan_tahunan_id',
                                        'kegiatan_tahunan.label AS kegiatan_tahunan_label',
                                        'kegiatan_tahunan.cost AS anggaran',

                                        'indikator_kegiatan.id AS indikator_id',
                                        'indikator_kegiatan.label AS indikator_label',
                                        'indikator_kegiatan.target AS qty_target',
                                        'indikator_kegiatan.satuan',
                                        

                                        'capaian_triwulan.status',
                                        'capaian_triwulan.id AS capaian_triwulan_id'


                                    ) 
                            ->WHERE('realisasi_triwulan_kegiatan_tahunan.id', $request->id)
                            
                            ->firstOrFail();

        if ( $x->jabatan_id > 0 ){
            $pelaksana = Pustaka::capital_string($x->Pelaksana->skpd);
        }else{
            $pelaksana = '-';
        }
		
		//return  $rencana_aksi;
        $triwulan = array(
            'id'                        => $x->realisasi_triwulan_kegiatan_tahunan_id,
            'capaian_status'            => $x->status,
            'indikator_label'           => $x->indikator_label,
            'indikator_kegiatan_id'     => $x->indikator_kegiatan_id,
            'kegiatan_tahunan_id'       => $x->kegiatan_tahunan_id,
            'capaian_triwulan_id'       => $x->capaian_triwulan_id,
            'kegiatan_tahunan_label'    => $x->kegiatan_tahunan_label,
            

            'triwulan_qty_target'       => $x->qty_target,
            'triwulan_qty_realisasi'    => $x->qty_realisasi,
            'triwulan_satuan'           => $x->satuan,
            'anggaran_kegiatan'         => number_format($x->anggaran,'0',',','.'),
            'triwulan_cost_realisasi'   => number_format($x->cost_realisasi,'0',',','.'),
            'realisasi_triwulan_anggaran_kegiatan_id' => $x->realisasi_triwulan_anggaran_kegiatan_id,
       
 
        );
        return $triwulan;
    }





    public function Update(Request $request)
    {

        $messages = [
                'realisasi_triwulan_id.required'   => 'Harus diisi',
                'qty_realisasi.required'       => 'Harus diisi',
                'satuan.required'              => 'Harus diisi',
                'cost_realisasi.required'      => 'Harus diisi'
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'realisasi_triwulan_id'  => 'required',
                            'qty_realisasi'          => 'required',
                            'cost_realisasi'         => 'required',
                            'satuan'                 => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $st_kt    = RealisasiKegiatanTriwulan::find(Input::get('realisasi_triwulan_id'));
        if (is_null($st_kt)) {
            return $this->sendError('Realisasi Kegiatan Triwulan tidak ditemukan.');
        }


        $st_kt->quantity                = Input::get('qty_realisasi');
        $st_kt->satuan                  = Input::get('satuan');
        //$st_kt->cost                    = preg_replace('/[^0-9]/', '', Input::get('cost_realisasi'));
       

        if ( $st_kt->save()){

        //cari anggaran kegiatan realisasinya
        $rag    = RealisasiAnggaranKegiatan::WHERE('capaian_id','=',Input::get('capaian_triwulan_id'))->WHERE('kegiatan_tahunan_id','=',Input::get('kegiatan_tahunan_id'))->count();

        //jikia belum ada add new
        if ( $rag == 0 ) {
            $rag_save    = new RealisasiAnggaranKegiatan;
            $rag_save->capaian_id              = Input::get('capaian_triwulan_id');
            $rag_save->kegiatan_tahunan_id     = Input::get('kegiatan_tahunan_id');
            $rag_save->cost                    = preg_replace('/[^0-9]/', '', Input::get('cost_realisasi'));
            $rag_save->save();

        //jika sudah ada update saja
        }else{

            $rag_save    = RealisasiAnggaranKegiatan::find(Input::get('realisasi_triwulan_anggaran_kegiatan_id'));
            $rag_save->cost                    = preg_replace('/[^0-9]/', '', Input::get('cost_realisasi'));
            $rag_save->save();
        }


            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }



    public function Destroy(Request $request)
    {

        $messages = [
                'realisasi_kegiatan_id.required'   => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'realisasi_kegiatan_id'   => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $st_kt    = RealisasiKegiatanTriwulan::find(Input::get('realisasi_kegiatan_id'));
        if (is_null($st_kt)) {
            return $this->sendError('Realisasi Kegiatan Triwulan tidak ditemukan.');
        }


        if ( $st_kt->delete()){



            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    } 
}
