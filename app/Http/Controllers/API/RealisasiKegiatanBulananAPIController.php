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
use App\Models\IndikatorProgram;
use App\Models\Skpd;
use App\Models\Jabatan;
use App\Models\SKPTahunan;
use App\Models\SKPBulanan;
use App\Models\RencanaAksi;

use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class RealisasiKegiatanBulananAPIController extends Controller {

    public function RealisasiKegiatanBulananDetail(Request $request)
    {
       
        
        $x = RealisasiKegiatanBulanan::
                            leftjoin('db_pare_2018.skp_bulanan_kegiatan AS kegiatan_skp_bulanan', function($join){
                                $join   ->on('kegiatan_skp_bulanan.id','=','realisasi_kegiatan_bulanan.kegiatan_bulanan_id');
                            })
                            ->SELECT(   'realisasi_kegiatan_bulanan.id AS realisasi_kegiatan_bulanan_id',
                                        'realisasi_kegiatan_bulanan.realisasi AS realisasi',
                                        'realisasi_kegiatan_bulanan.satuan',
                                        'kegiatan_skp_bulanan.id',
                                        'realisasi_kegiatan_bulanan.kegiatan_bulanan_id'
                                    ) 
                            ->WHERE('realisasi_kegiatan_bulanan.id', $request->realisasi_kegiatan_bulanan_id)
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
            'kegiatan_bulanan_label'        => $x->KegiatanSKPBulanan->label,
            'kegiatan_bulanan_target'       => $x->KegiatanSKPBulanan->target,
            'kegiatan_bulanan_satuan'       => $x->KegiatanSKPBulanan->satuan,
            'kegiatan_bulanan_output'       => $x->KegiatanSKPBulanan->target.' '.$x->KegiatanSKPBulanan->satuan,
            'pelaksana'                     => Pustaka::capital_string($x->KegiatanSKPBulanan->RencanaAksi->Pelaksana->jabatan),
            'penanggung_jawab'              => Pustaka::capital_string($x->KegiatanSKPBulanan->RencanaAksi->KegiatanTahunan->Kegiatan->PenanggungJawab->jabatan),
            'kegiatan_tahunan_label'        => $x->KegiatanSKPBulanan->RencanaAksi->KegiatanTahunan->label,
            'kegiatan_tahunan_target'       => $x->KegiatanSKPBulanan->RencanaAksi->KegiatanTahunan->target,
            'kegiatan_tahunan_satuan'       => $x->KegiatanSKPBulanan->RencanaAksi->KegiatanTahunan->satuan,
            'kegiatan_tahunan_waktu'        => $x->KegiatanSKPBulanan->RencanaAksi->KegiatanTahunan->target_waktu,
            'kegiatan_tahunan_cost'         => number_format($x->KegiatanSKPBulanan->RencanaAksi->KegiatanTahunan->cost,'0',',','.'),
            'kegiatan_tahunan_output'       => $x->KegiatanSKPBulanan->RencanaAksi->KegiatanTahunan->target.' '.$x->KegiatanSKPBulanan->RencanaAksi->KegiatanTahunan->satuan,

            'realisasi'              => $x->realisasi,
            'realisasi_kegiatan_bulanan_id' => $x->realisasi_kegiatan_bulanan_id,
 
        );
        return $rencana_aksi;
    }

    public function RealisasiKegiatanBulanan2(Request $request)
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
        $capaian_id = $request->capaian_id;
        
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
                    ->leftjoin('db_pare_2018.realisasi_kegiatan_bulanan', function($join){
                        $join   ->on('realisasi_kegiatan_bulanan.kegiatan_bulanan_id','=','kegiatan_bulanan.id');
                    })
                    ->leftjoin('db_pare_2018.realisasi_rencana_aksi', function($join) use($capaian_id){
                        $join   ->on('realisasi_rencana_aksi.rencana_aksi_id','=','skp_tahunan_rencana_aksi.id');
                        $join   ->where('realisasi_rencana_aksi.capaian_id','!=', $capaian_id);
                    })
                    ->leftjoin('db_pare_2018.realisasi_rencana_aksi AS realisasi_kabid', function($join) use($capaian_id){
                        $join   ->on('realisasi_kabid.rencana_aksi_id','=','skp_tahunan_rencana_aksi.id');
                        $join   ->where('realisasi_kabid.capaian_id','=', $capaian_id);
                    })
                    ->SELECT(   'skp_tahunan_rencana_aksi.id AS rencana_aksi_id',
                                'skp_tahunan_rencana_aksi.label AS rencana_aksi_label',
                                'skp_tahunan_rencana_aksi.jabatan_id AS pelaksana_id',
                                'skp_tahunan_rencana_aksi.kegiatan_tahunan_id',
                                'skp_tahunan_rencana_aksi.target AS rencana_aksi_target',
                                'skp_tahunan_rencana_aksi.satuan AS rencana_aksi_satuan',

                                'kegiatan_tahunan.label AS kegiatan_tahunan_label',

                                'kegiatan_bulanan.label AS kegiatan_bulanan_label',
                                'kegiatan_bulanan.id AS kegiatan_bulanan_id',
                                'kegiatan_bulanan.target AS kegiatan_bulanan_target',
                                'kegiatan_bulanan.satuan AS kegiatan_bulanan_satuan',


                               /*  'realisasi_kegiatan_bulanan.id AS realisasi_kegiatan_bulanan_id',
                                'realisasi_kegiatan_bulanan.realisasi AS realisasi',
                                'realisasi_kegiatan_bulanan.satuan AS capaian_satuan',
                                'realisasi_kegiatan_bulanan.bukti',
                                'realisasi_kegiatan_bulanan.alasan_tidak_tercapai', */

                                'realisasi_rencana_aksi.id AS realisasi_rencana_aksi_bawahan_id',
                                'realisasi_rencana_aksi.realisasi AS realisasi_rencana_aksi_bawahan',
                                'realisasi_rencana_aksi.satuan AS satuan_rencana_aksi_bawahan',

                                'realisasi_kabid.id AS realisasi_rencana_aksi_id',
                                'realisasi_kabid.realisasi AS realisasi_rencana_aksi',
                                'realisasi_kabid.satuan AS satuan_rencana_aksi'

                            ) 
                    ->get();
        
        $skp_id = $request->skp_bulanan_id;


        $datatables = Datatables::of($dt)
        ->addColumn('skp_bulanan_id', function ($x) use($skp_id){
            return $skp_id;
       
        })->addColumn('kegiatan_tahunan_label', function ($x) {
            return $x->KegiatanTahunan->label;
            
        })->addColumn('persentasi_realisasi_rencana_aksi', function ($x) {
          
            return   Pustaka::persen($x->realisasi_rencana_aksi,$x->rencana_aksi_target);
    
            
        })->addColumn('penanggung_jawab', function ($x) {

            return Pustaka::capital_string($x->KegiatanTahunan->Kegiatan->PenanggungJawab->jabatan);

        })->addColumn('pelaksana', function ($x) {

            if ( $x->pelaksana_id != null ){
                $dt = Skpd::WHERE('id',$x->pelaksana_id)->SELECT('skpd')->first();
                $pelaksana = Pustaka::capital_string($dt->skpd);
            }else{
                $pelaksana = "-";
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

    public function RealisasiKegiatanBulanan3(Request $request)
    {
            
        $skp_bln = SKPBulanan::WHERE('id',$request->skp_bulanan_id)->SELECT('skp_tahunan_id','bulan','status')->first();
        
        //cari bawahan  , jabatanpelaksanan
        $child = Jabatan::SELECT('id')->WHERE('parent_id', $request->jabatan_id )->get()->toArray(); 

        $keg_tahunan = $skp_bln->SKPTahunan->KegiatanTahunan;
        
        $capaian_id = $request->capaian_id;

      /*   $dt = RencanaAksi::
                            WHEREIN('skp_tahunan_rencana_aksi.jabatan_id',$child )
                            ->WHEREIN('skp_tahunan_rencana_aksi.kegiatan_tahunan_id',$keg_tahunan )
                            ->WHERE('skp_tahunan_rencana_aksi.waktu_pelaksanaan','=',$skp_bln->bulan)
                            ->SELECT('skp_tahunan_rencana_aksi.id')
                            ->GET();

        return $dt; */


        $dt = RencanaAksi::
                    WHEREIN('skp_tahunan_rencana_aksi.jabatan_id',$child )
                    ->WHEREIN('skp_tahunan_rencana_aksi.kegiatan_tahunan_id',$keg_tahunan )
                    ->WHERE('skp_tahunan_rencana_aksi.waktu_pelaksanaan','=',$skp_bln->bulan)
                    ->leftjoin('db_pare_2018.skp_bulanan_kegiatan AS kegiatan_bulanan', function($join){
                        $join   ->on('kegiatan_bulanan.rencana_aksi_id','=','skp_tahunan_rencana_aksi.id');
                        //$join   ->WHERE('kegiatan_bulanan.skp_tahunan_id','=', $skp_tahunan_id );
                    })
                    ->leftjoin('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join){
                        $join   ->on('kegiatan_tahunan.id','=','skp_tahunan_rencana_aksi.kegiatan_tahunan_id');
                        //$join   ->WHERE('kegiatan_bulanan.skp_tahunan_id','=', $skp_tahunan_id );
                    })
                    ->leftjoin('db_pare_2018.realisasi_kegiatan_bulanan AS realisasi_bawahan ', function($join){
                        $join   ->on('realisasi_bawahan.kegiatan_bulanan_id','=','kegiatan_bulanan.id');
                    })
                    ->leftjoin('db_pare_2018.realisasi_rencana_aksi AS realisasi_rencana_aksi', function($join) use($capaian_id){
                        $join   ->on('realisasi_rencana_aksi.rencana_aksi_id','=','skp_tahunan_rencana_aksi.id');
                        $join   ->where('realisasi_rencana_aksi.capaian_id','=', $capaian_id);
                    })
                    ->SELECT(   'skp_tahunan_rencana_aksi.id AS rencana_aksi_id',
                                'skp_tahunan_rencana_aksi.label AS rencana_aksi_label',
                                'skp_tahunan_rencana_aksi.jabatan_id AS pelaksana_id',
                                'skp_tahunan_rencana_aksi.kegiatan_tahunan_id',
                                'skp_tahunan_rencana_aksi.target AS rencana_aksi_target',
                                'skp_tahunan_rencana_aksi.satuan AS rencana_aksi_satuan',

                                'kegiatan_tahunan.label AS kegiatan_tahunan_label',

                                'kegiatan_bulanan.label AS kegiatan_bulanan_label',
                                'kegiatan_bulanan.id AS kegiatan_bulanan_id',
                                'kegiatan_bulanan.target AS kegiatan_bulanan_target',
                                'kegiatan_bulanan.satuan AS kegiatan_bulanan_satuan',
                                
                                'realisasi_bawahan.id AS realisasi_kegiatan_bulanan_bawahan_id',
                                'realisasi_bawahan.realisasi AS realisasi_bawahan',
                                'realisasi_bawahan.satuan AS satuan_realisasi_bawahan',
                                'realisasi_bawahan.bukti AS bukti_realisasi_bawahan',
                                'realisasi_bawahan.alasan_tidak_tercapai',

                                'realisasi_rencana_aksi.id AS realisasi_rencana_aksi_id',
                                'realisasi_rencana_aksi.realisasi AS realisasi_rencana_aksi',
                                'realisasi_rencana_aksi.satuan AS satuan_rencana_aksi'

                            ) 
                    ->get();
        
        $skp_id = $request->skp_bulanan_id;


        $datatables = Datatables::of($dt)
        ->addColumn('skp_bulanan_id', function ($x) use($skp_id){
            return $skp_id;
        })
       
        ->addColumn('persentasi_realisasi_rencana_aksi', function ($x) {
          
            return   Pustaka::persen($x->realisasi_rencana_aksi,$x->rencana_aksi_target);
    
            
        })
        ->addColumn('kegiatan_tahunan_label', function ($x) {
            return $x->KegiatanTahunan->label;
        })
        ->addColumn('pelaksana', function ($x) {

            if ( $x->pelaksana_id != null ){
                $dt = Skpd::WHERE('id',$x->pelaksana_id)->SELECT('skpd')->first();
                $pelaksana = Pustaka::capital_string($dt->skpd);
            }else{
                $pelaksana = "-";
            }

            return $pelaksana;
        })
        ->addColumn('status_skp', function ($x) use($skp_bln){
            return $skp_bln->status;
        });

        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true);
        
    } 

    public function RealisasiKegiatanBulanan4(Request $request)
    {
            
        //$skp_bln = SKPBulanan::WHERE('id',$request->skp_bulanan_id)->SELECT('bulan')->first();

        $dt = KegiatanSKPBulanan::
                    WHERE('skp_bulanan_kegiatan.skp_bulanan_id','=', $request->skp_bulanan_id )
                    ->leftjoin('db_pare_2018.realisasi_kegiatan_bulanan', function($join){
                        $join   ->on('realisasi_kegiatan_bulanan.kegiatan_bulanan_id','=','skp_bulanan_kegiatan.id');
                    })
                    ->SELECT(   'skp_bulanan_kegiatan.id AS kegiatan_bulanan_id',
                                'skp_bulanan_kegiatan.label AS kegiatan_bulanan_label',
                                'skp_bulanan_kegiatan.target',
                                'skp_bulanan_kegiatan.satuan',
                                'realisasi_kegiatan_bulanan.id AS realisasi_kegiatan_bulanan_id',
                                'realisasi_kegiatan_bulanan.realisasi AS realisasi',
                                'realisasi_kegiatan_bulanan.satuan AS realisasi_satuan',
                                'realisasi_kegiatan_bulanan.bukti',
                                'realisasi_kegiatan_bulanan.alasan_tidak_tercapai',
                                'skp_bulanan_kegiatan.rencana_aksi_id'
                            ) 
                    
                    ->get();
        
        $skp_id = $request->skp_bulanan_id;


        $datatables = Datatables::of($dt)
        ->addColumn('kegiatan_bulanan_id', function ($x) use($skp_id){
            return $x->kegiatan_bulanan_id;
        })
        ->addColumn('kegiatan_tahunan_label', function ($x) use($skp_id){
            return $x->RencanaAksi->KegiatanTahunan->label;
        })
        ->addColumn('persentase_realisasi', function ($x) use($skp_id){
            return   Pustaka::persen($x->realisasi,$x->target);

        })
        ->addColumn('capaian_kegiatan_bulanan_id', function ($x) use($skp_id){
            return $x->capaian_kegiatan_bulanan_id;
        });

        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true); 
        
    } 


    public function Store(Request $request)
    {

        $messages = [
                'kegiatan_bulanan_id.required'      => 'Harus diisi',
                'capaian_id.required'               => 'Harus diisi',
                'realisasi.required'           => 'Harus diisi',
                'satuan.required'                   => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'kegiatan_bulanan_id'   => 'required',
                            'capaian_id'        => 'required',
                            'realisasi'        => 'required',
                            'satuan'                => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $st_kt    = new RealisasiKegiatanBulanan;

        $st_kt->kegiatan_bulanan_id     = Input::get('kegiatan_bulanan_id');
        $st_kt->capaian_id              = Input::get('capaian_id');
        $st_kt->realisasi          = Input::get('realisasi');
        $st_kt->satuan                  = Input::get('satuan');
        $st_kt->alasan_tidak_tercapai   = Input::get('alasan_tidak_tercapai');
        $st_kt->bukti                   = "";
       

        if ( $st_kt->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }


    public function Update(Request $request)
    {

        $messages = [
                'realisasi_kegiatan_bulanan_id.required'   => 'Harus diisi',
                'realisasi.required'                => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'realisasi_kegiatan_bulanan_id'   => 'required',
                            'realisasi'                => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $st_kt    = RealisasiKegiatanBulanan::find(Input::get('realisasi_kegiatan_bulanan_id'));
        if (is_null($st_kt)) {
            return response()->json('Realisasi Kegiatan Bulanan tidak ditemukan.',422);
        }


        $st_kt->realisasi             = Input::get('realisasi');
        if ( $st_kt->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            

    
    }
   

    public function Destroy(Request $request)
    {

        $messages = [
                'realisasi_kegiatan_bulanan_id.required'   => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'realisasi_kegiatan_bulanan_id'   => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $st_kt    = RealisasiKegiatanBulanan::find(Input::get('realisasi_kegiatan_bulanan_id'));
        if (is_null($st_kt)) {
            return $this->sendError('Realisasi Kegiatan Bulanan tidak ditemukan.');
        }


        if ( $st_kt->delete()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    } 
}
