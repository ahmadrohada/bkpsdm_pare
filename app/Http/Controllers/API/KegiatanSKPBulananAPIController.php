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
use App\Models\Jabatan;
use App\Models\IndikatorProgram;
use App\Models\Skpd;
use App\Models\SKPTahunan;
use App\Models\SKPBulanan;
use App\Models\RencanaAksi;

use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class KegiatanSKPBulananAPIController extends Controller {

 
    public function KegiatanBulananDetail(Request $request)
    {
       
        
        $x = KegiatanSKPBulanan::
                            SELECT(     'id AS kegiatan_bulanan_id',
                                        'rencana_aksi_id',
                                        'skp_bulanan_id',
                                        'label',
                                        'target',
                                        'satuan'
                                    ) 
                            ->WHERE('id', $request->kegiatan_bulanan_id)
                            ->first();

        if ( $x->jabatan_id > 0 ){
            $pelaksana = Pustaka::capital_string($x->Pelaksana->skpd);
        }else{
            $pelaksana = '-';
        }
		
		//return  $rencana_aksi;
        $rencana_aksi = array(
            'id'                            => $x->kegiatan_bulanan_id,
            'skp_bulanan_id'                => $x->skp_bulanan_id,
            'kegiatan_bulanan_label'        => $x->label,
            'kegiatan_bulanan_target'       => $x->target,
            'kegiatan_bulanan_satuan'       => $x->satuan,
            'kegiatan_bulanan_output'       => $x->target.' '.$x->satuan,
            'pelaksana'                     => Pustaka::capital_string($x->RencanaAksi->Pelaksana->jabatan),
            'penanggung_jawab'              => Pustaka::capital_string($x->RencanaAksi->KegiatanTahunan->Kegiatan->PenanggungJawab->jabatan),
            'kegiatan_tahunan_label'        => $x->RencanaAksi->KegiatanTahunan->label,
            'kegiatan_tahunan_target'       => $x->RencanaAksi->KegiatanTahunan->target,
            'kegiatan_tahunan_satuan'       => $x->RencanaAksi->KegiatanTahunan->satuan,
            'kegiatan_tahunan_waktu'        => $x->RencanaAksi->KegiatanTahunan->target_waktu,
            'kegiatan_tahunan_cost'         => number_format($x->RencanaAksi->KegiatanTahunan->cost,'0',',','.'),
            'kegiatan_tahunan_output'       => $x->RencanaAksi->KegiatanTahunan->target.' '.$x->RencanaAksi->KegiatanTahunan->satuan,
 
        );
        return $rencana_aksi;
    }


    public function kegiatan_tugas_jabatan_list(Request $request)
    {
            
       
        $dt = KegiatanSKPBulanan::WHERE('skp_bulanan_id','=', $request->skp_bulanan_id )

                ->select([   
                    'id AS kegiatan_tugas_jabatan_id',
                    'label',
                    'target',
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
            return $x->target.' '.$x->satuan;
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


    public function KegiatanBulanan4(Request $request)
    {
            
        $skp_bln = SKPBulanan::WHERE('id',$request->skp_bulanan_id)->SELECT('bulan','status')->first();

        $dt = RencanaAksi::
                    WHERE('jabatan_id','=', $request->jabatan_id )
                    ->WHERE('waktu_pelaksanaan',$skp_bln->bulan)
                    ->leftjoin('db_pare_2018.skp_bulanan_kegiatan AS kegiatan_bulanan', function($join){
                        $join   ->on('kegiatan_bulanan.rencana_aksi_id','=','skp_tahunan_rencana_aksi.id');
                        //$join   ->WHERE('kegiatan_bulanan.skp_tahunan_id','=', $skp_tahunan_id );
                    })
                    ->SELECT(   'skp_tahunan_rencana_aksi.id AS rencana_aksi_id',
                                'skp_tahunan_rencana_aksi.label AS rencana_aksi_label',
                                'skp_tahunan_rencana_aksi.target AS rencana_aksi_target',
                                'skp_tahunan_rencana_aksi.satuan AS rencana_aksi_satuan',
                                'kegiatan_bulanan.label AS kegiatan_bulanan_label',
                                'kegiatan_bulanan.id AS kegiatan_bulanan_id',
                                'kegiatan_bulanan.target AS kegiatan_bulanan_target',
                                'kegiatan_bulanan.satuan AS kegiatan_bulanan_satuan',
                                'skp_tahunan_rencana_aksi.kegiatan_tahunan_id'
                            ) 
                    ->get();
        
        $skp_id = $request->skp_bulanan_id;


        $datatables = Datatables::of($dt)
        ->addColumn('skp_bulanan_id', function ($x) use($skp_id){
            return $skp_id;
        })->addColumn('target', function ($x) {
            if ( $x->kegiatan_bulanan_id >= 1 ){
                $target = $x->kegiatan_bulanan_target.' '.$x->kegiatan_bulanan_satuan;
            }else{
                $target = $x->rencana_aksi_target.' '.$x->rencana_aksi_satuan;
            }
            return $target;
        })->addColumn('status_skp', function ($x) use($skp_bln){
            return $skp_bln->status;
        })->addColumn('kegiatan_tahunan_label', function ($x) use($skp_bln){
            return $x->KegiatanTahunan->label;
        });

        
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true); 
        
    } 


    public function KegiatanBulanan1(Request $request)
    {
            
        $skp_bln = SKPBulanan::WHERE('id',$request->skp_bulanan_id)->SELECT('bulan','status')->first();

        //CARI KASUBID
        $child = Jabatan::
                            
                            leftjoin('demo_asn.m_skpd AS kasubid', function($join){
                                $join   ->on('kasubid.parent_id','=','m_skpd.id');
                            })
                            ->SELECT('kasubid.id')
                            ->WHERE('m_skpd.parent_id', $request->jabatan_id )
                            ->get()
                            ->toArray(); 

        //cari bawahan  , jabatanpelaksanan
        $pelaksana_id = Jabatan::
                        SELECT('m_skpd.id')
                        ->WHEREIN('m_skpd.parent_id', $child )
                        ->get()
                        ->toArray(); 

        //return $pelaksana_id;

        $dt = RencanaAksi::
                    WHEREIN('skp_tahunan_rencana_aksi.jabatan_id',$pelaksana_id )
                    ->WHERE('skp_tahunan_rencana_aksi.waktu_pelaksanaan',$skp_bln->bulan)
                    ->leftjoin('db_pare_2018.skp_bulanan_kegiatan AS kegiatan_bulanan', function($join){
                        $join   ->on('kegiatan_bulanan.rencana_aksi_id','=','skp_tahunan_rencana_aksi.id');
                        //$join   ->WHERE('kegiatan_bulanan.skp_tahunan_id','=', $skp_tahunan_id );
                    })
                    ->leftjoin('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join){
                        $join   ->on('kegiatan_tahunan.id','=','skp_tahunan_rencana_aksi.kegiatan_tahunan_id');
                        //$join   ->WHERE('kegiatan_bulanan.skp_tahunan_id','=', $skp_tahunan_id );
                    })
                    ->SELECT(   'skp_tahunan_rencana_aksi.id AS rencana_aksi_id',
                                'skp_tahunan_rencana_aksi.label AS rencana_aksi_label',
                                'skp_tahunan_rencana_aksi.jabatan_id AS pelaksana_id',
                                'skp_tahunan_rencana_aksi.kegiatan_tahunan_id',
                                'kegiatan_bulanan.label AS kegiatan_bulanan_label',
                                'kegiatan_bulanan.id AS kegiatan_bulanan_id',
                                'kegiatan_bulanan.target AS target_pelaksana',
                                'kegiatan_bulanan.satuan AS satuan_pelaksana',
                                'kegiatan_tahunan.target',
                                'kegiatan_tahunan.satuan'
                            ) 
                    ->get();
        
        $skp_id = $request->skp_bulanan_id;


        $datatables = Datatables::of($dt)
        ->addColumn('skp_bulanan_id', function ($x) use($skp_id){
            return $skp_id;
        })->addColumn('ak', function ($x) {
            return '';
        })->addColumn('output', function ($x) {
            return '';
        })->addColumn('mutu', function ($x) {
            return '';
        })->addColumn('waktu', function ($x) {
            return '';
        })->addColumn('biaya', function ($x) {
            return '';
        })->addColumn('pelaksana', function ($x) {

            if ( $x->pelaksana_id != null ){
                $dt = Skpd::WHERE('id',$x->pelaksana_id)->SELECT('skpd')->first();
                $pelaksana = Pustaka::capital_string($dt->skpd);
            }else{
                $pelaksana = "s";
            }

            return $pelaksana;
        })->addColumn('penanggung_jawab', function ($x) {

            return Pustaka::capital_string($x->KegiatanTahunan->Kegiatan->PenanggungJawab->jabatan);
          
        })->addColumn('status_skp', function ($x) use($skp_bln){
            return $skp_bln->status;
        });

        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true);
        
    } 

    public function KegiatanBulanan2(Request $request)
    {
            
        $skp_bln = SKPBulanan::WHERE('id',$request->skp_bulanan_id)->SELECT('bulan','status')->first();

        //cari bawahan  , jabatanpelaksanan
        $pelaksana_id = Jabatan::
                        leftjoin('demo_asn.m_skpd AS pelaksana', function($join){
                            $join   ->on('pelaksana.parent_id','=','m_skpd.id');
                        })
                        ->SELECT('pelaksana.id')
                        ->WHERE('m_skpd.parent_id', $request->jabatan_id )
                        ->get()
        
        
        
                        ->toArray(); 
        

        $dt = RencanaAksi::
                    WHEREIN('skp_tahunan_rencana_aksi.jabatan_id',$pelaksana_id )
                    ->WHERE('skp_tahunan_rencana_aksi.waktu_pelaksanaan',$skp_bln->bulan)
                    ->leftjoin('db_pare_2018.skp_bulanan_kegiatan AS kegiatan_bulanan', function($join){
                        $join   ->on('kegiatan_bulanan.rencana_aksi_id','=','skp_tahunan_rencana_aksi.id');
                        //$join   ->WHERE('kegiatan_bulanan.skp_tahunan_id','=', $skp_tahunan_id );
                    })
                    ->leftjoin('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join){
                        $join   ->on('kegiatan_tahunan.id','=','skp_tahunan_rencana_aksi.kegiatan_tahunan_id');
                        //$join   ->WHERE('kegiatan_bulanan.skp_tahunan_id','=', $skp_tahunan_id );
                    })
                    ->SELECT(   'skp_tahunan_rencana_aksi.id AS rencana_aksi_id',
                                'skp_tahunan_rencana_aksi.label AS rencana_aksi_label',
                                'skp_tahunan_rencana_aksi.jabatan_id AS pelaksana_id',
                                'skp_tahunan_rencana_aksi.kegiatan_tahunan_id',
                                'kegiatan_bulanan.label AS kegiatan_bulanan_label',
                                'kegiatan_bulanan.id AS kegiatan_bulanan_id',
                                'kegiatan_bulanan.target AS target_pelaksana',
                                'kegiatan_bulanan.satuan AS satuan_pelaksana',
                                'kegiatan_tahunan.target',
                                'kegiatan_tahunan.satuan'
                            ) 
                    ->get();
        
        $skp_id = $request->skp_bulanan_id;


        $datatables = Datatables::of($dt)
        ->addColumn('skp_bulanan_id', function ($x) use($skp_id){
            return $skp_id;
        })->addColumn('ak', function ($x) {
            return '';
        })->addColumn('output', function ($x) {
            return '';
        })->addColumn('mutu', function ($x) {
            return '';
        })->addColumn('waktu', function ($x) {
            return '';
        })->addColumn('biaya', function ($x) {
            return '';
        })->addColumn('pelaksana', function ($x) {

            if ( $x->pelaksana_id != null ){
                $dt = Skpd::WHERE('id',$x->pelaksana_id)->SELECT('skpd')->first();
                $pelaksana = Pustaka::capital_string($dt->skpd);
            }else{
                $pelaksana = "s";
            }

            return $pelaksana;
        })->addColumn('penanggung_jawab', function ($x) {

            return Pustaka::capital_string($x->KegiatanTahunan->Kegiatan->PenanggungJawab->jabatan);
           /*  if ( $x->pelaksana_id != null ){
                $dt = Skpd::WHERE('id',$x->pelaksana_id)->SELECT('skpd')->first();
                $pelaksana = Pustaka::capital_string($dt->skpd);
            }else{
                $pelaksana = "s";
            }

            return $pelaksana; */
        })->addColumn('status_skp', function ($x) use($skp_bln){
            return $skp_bln->status;
        });

        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true); 
        
    } 

    public function KegiatanBulanan3(Request $request)
    {
            
        $skp_bln = SKPBulanan::WHERE('id',$request->skp_bulanan_id)->SELECT('bulan','status')->first();

        //cari bawahan  , jabatanpelaksanan
        $child = Jabatan::SELECT('id')->WHERE('parent_id', $request->jabatan_id )->get()->toArray(); 
        

        $dt = RencanaAksi::
                    WHEREIN('skp_tahunan_rencana_aksi.jabatan_id',$child )
                    ->WHERE('skp_tahunan_rencana_aksi.waktu_pelaksanaan',$skp_bln->bulan)
                    ->leftjoin('db_pare_2018.skp_bulanan_kegiatan AS kegiatan_bulanan', function($join){
                        $join   ->on('kegiatan_bulanan.rencana_aksi_id','=','skp_tahunan_rencana_aksi.id');
                        //$join   ->WHERE('kegiatan_bulanan.skp_tahunan_id','=', $skp_tahunan_id );
                    })
                    ->leftjoin('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join){
                        $join   ->on('kegiatan_tahunan.id','=','skp_tahunan_rencana_aksi.kegiatan_tahunan_id');
                        //$join   ->WHERE('kegiatan_bulanan.skp_tahunan_id','=', $skp_tahunan_id );
                    })
                    ->SELECT(   'skp_tahunan_rencana_aksi.id AS rencana_aksi_id',
                                'skp_tahunan_rencana_aksi.label AS rencana_aksi_label',
                                'skp_tahunan_rencana_aksi.target AS rencana_aksi_target',
                                'skp_tahunan_rencana_aksi.satuan AS rencana_aksi_satuan',
                                'skp_tahunan_rencana_aksi.jabatan_id AS pelaksana_id',
                                'kegiatan_bulanan.label AS kegiatan_bulanan_label',
                                'kegiatan_bulanan.id AS kegiatan_bulanan_id',
                                'kegiatan_bulanan.target AS target_pelaksana',
                                'kegiatan_bulanan.satuan AS satuan_pelaksana'
                            ) 
                    ->get();
        
        $skp_id = $request->skp_bulanan_id;


        $datatables = Datatables::of($dt)
        ->addColumn('skp_bulanan_id', function ($x) use($skp_id){
            return $skp_id;
        })->addColumn('pelaksana', function ($x) {

            if ( $x->pelaksana_id != null ){
                $dt = Skpd::WHERE('id',$x->pelaksana_id)->SELECT('skpd')->first();
                $pelaksana = Pustaka::capital_string($dt->skpd);
            }else{
                $pelaksana = "s";
            }

            return $pelaksana;
        })->addColumn('status_skp', function ($x) use($skp_bln){
            return $skp_bln->status;
        });

        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true); 
        
    } 


    public function Store(Request $request)
    {

        $messages = [
                'rencana_aksi_id.required'       => 'Harus diisi',
                'skp_bulanan_id.required'        => 'Harus diisi',
                'rencana_aksi_label.required'    => 'Harus diisi',
                'target.required'                => 'Harus diisi',
                'satuan.required'                => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'rencana_aksi_id'   => 'required',
                            'skp_bulanan_id'    => 'required',
                            'rencana_aksi_label'=> 'required',
                            'target'            => 'required',
                            'satuan'            => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $st_kt    = new KegiatanSKPBulanan;

        $st_kt->rencana_aksi_id   = Input::get('rencana_aksi_id');
        $st_kt->skp_bulanan_id    = Input::get('skp_bulanan_id');
        $st_kt->label             = Input::get('rencana_aksi_label');
        $st_kt->target            = Input::get('target');
        $st_kt->satuan            = Input::get('satuan');
       

        if ( $st_kt->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }

    public function Destroy(Request $request)
    {

        $messages = [
                'kegiatan_bulanan_id.required'   => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'kegiatan_bulanan_id'   => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $st_kt    = KegiatanSKPBulanan::find(Input::get('kegiatan_bulanan_id'));
        if (is_null($st_kt)) {
            return $this->sendError('Kegiatan Bulanan tidak ditemukan.');
        }


        if ( $st_kt->delete()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }
}
