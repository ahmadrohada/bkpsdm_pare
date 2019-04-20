<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PeriodeTahunan;
use App\Models\PerjanjianKinerja;
use App\Models\KegiatanSKPTahunan;
use App\Models\KegiatanSKPBulanan;
use App\Models\RealisasiRencanaAksiKaban;



use App\Models\Tujuan;
use App\Models\IndikatorTujuan;
use App\Models\Sasaran;
use App\Models\Skpd;
use App\Models\SKPTahunan;
use App\Models\RencanaAksi;


use App\Models\SasaranPerjanjianKinerja;
use App\Models\IndikatorSasaran;
use App\Models\Program;
use App\Models\IndikatorProgram;
use App\Models\Kegiatan;
use App\Models\IndikatorKegiatan;
use App\Models\PetaJabatan;
use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class RealisasiRencanaAksiKabanAPIController extends Controller {



    public function RealisasiRencanaAksiDetail(Request $request)
    {
       

        $x = RealisasiRencanaAksiKaban::WHERE('realisasi_rencana_aksi.id', $request->realisasi_rencana_aksi_id)
                    ->leftjoin('db_pare_2018.skp_tahunan_rencana_aksi AS skp_tahunan_rencana_aksi', function($join){
                        $join   ->on('skp_tahunan_rencana_aksi.id','=','realisasi_rencana_aksi.rencana_aksi_id');
                       
                    })
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
                   
                    ->SELECT(   'skp_tahunan_rencana_aksi.id AS rencana_aksi_id',
                                'skp_tahunan_rencana_aksi.label AS rencana_aksi_label',
                                'skp_tahunan_rencana_aksi.jabatan_id AS pelaksana_id',
                                'skp_tahunan_rencana_aksi.kegiatan_tahunan_id',
                                'skp_tahunan_rencana_aksi.waktu_pelaksanaan',
                                'kegiatan_bulanan.label AS kegiatan_bulanan_label',
                                'kegiatan_bulanan.id AS kegiatan_bulanan_id',
                                'kegiatan_bulanan.target AS target_pelaksana',
                                'kegiatan_bulanan.satuan AS satuan_pelaksana',
                                'kegiatan_tahunan.target',
                                'kegiatan_tahunan.satuan',
                                'realisasi_kegiatan_bulanan.id AS realisasi_kegiatan_bulanan_id',
                                'realisasi_kegiatan_bulanan.realisasi AS realisasi',
                                'realisasi_kegiatan_bulanan.satuan AS realisasi_satuan',
                                'realisasi_kegiatan_bulanan.bukti',
                                'realisasi_kegiatan_bulanan.alasan_tidak_tercapai',
                                'realisasi_rencana_aksi.id AS realisasi_rencana_aksi_id',
                                'realisasi_rencana_aksi.rencana_aksi_id',
                                'realisasi_rencana_aksi.realisasi AS realisasi_rencana_aksi_target',
                                'realisasi_rencana_aksi.satuan AS realisasi_rencana_aksi_satuan'

                            ) 
                    ->first();
        if ( $x->pelaksana_id != null ){
            $dt = SKPD::WHERE('id',$x->pelaksana_id)->SELECT('skpd')->first();
            $pelaksana = Pustaka::capital_string($dt->skpd);
        }else{
            $pelaksana = "-";
        }

        /* $x = RencanaAksi::
                            SELECT(     'id AS rencana_aksi_id',
                                        'label',
                                        'waktu_pelaksanaan',
                                        'jabatan_id',
                                        'kegiatan_tahunan_id'
                                    ) 
                            ->WHERE('id', $request->rencana_aksi_id)
                            ->first();

        if ( $x->jabatan_id > 0 ){
            $pelaksana = Pustaka::capital_string($x->Pelaksana->jabatan);
        }else{
            $pelaksana = '-';
        } */
		
		//return  $rencana_aksi;
        $rencana_aksi = array(
            'realisasi_rencana_aksi_id'       => $x->realisasi_rencana_aksi_id,
            'label'                         => $x->rencana_aksi_label,
            'realisasi_rencana_aksi_target'   => $x->realisasi_rencana_aksi_target,
            'realisasi_rencana_aksi_satuan'   => $x->realisasi_rencana_aksi_satuan,


            'kegiatan_bulanan_label'        => $x->kegiatan_bulanan_label,
            'kegiatan_bulanan_target'       => $x->target_pelaksana,
            'kegiatan_bulanan_satuan'       => $x->satuan_pelaksana,
            'kegiatan_bulanan_output'       => $x->target_pelaksana." ".$x->satuan_pelaksana,
            'realisasi'                => $x->realisasi,
            'realisasi_satuan'                => $x->realisasi_satuan,
            'realisasi_output'                => $x->realisasi." ".$x->realisasi_satuan,



            'waktu_pelaksanaan'             => $x->waktu_pelaksanaan,
            'jabatan_id'                    => $x->pelaksana_id,
            'penanggung_jawab'              => Pustaka::capital_string($x->RencanaAksi->KegiatanTahunan->Kegiatan->PenanggungJawab->jabatan),
            'nama_jabatan'                  => $pelaksana,
            'pelaksana'                     => $pelaksana,
            'kegiatan_tahunan_label'        => $x->RencanaAksi->KegiatanTahunan->label,
            'kegiatan_tahunan_target'       => $x->RencanaAksi->KegiatanTahunan->target,
            'kegiatan_tahunan_satuan'       => $x->RencanaAksi->KegiatanTahunan->satuan,
            'kegiatan_tahunan_waktu'        => $x->RencanaAksi->KegiatanTahunan->target_waktu,
            'kegiatan_tahunan_cost'         => number_format($x->RencanaAksi->KegiatanTahunan->cost,'0',',','.'),
            'kegiatan_tahunan_output'       => $x->RencanaAksi->KegiatanTahunan->target.' '.$x->RencanaAksi->KegiatanTahunan->satuan,
 
        );
        return $rencana_aksi;
    }

   

    public function Store(Request $request)
    {

        $messages = [
                'rencana_aksi_id.required'      => 'Harus diisi',
                'capaian_id.required'               => 'Harus diisi',
                'realisasi.required'           => 'Harus diisi',
                'satuan.required'                   => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'rencana_aksi_id'   => 'required',
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


        $st_kt    = new RealisasiRencanaAksiKaban;

        $st_kt->rencana_aksi_id         = Input::get('rencana_aksi_id');
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
                'realisasi_rencana_aksi_id.required'  => 'Harus diisi',
                'realisasi.required'           => 'Harus diisi',
                'satuan.required'                   => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'realisasi_rencana_aksi_id'  => 'required',
                            'realisasi'                  => 'required',
                            'satuan'                     => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $st_ra    = RealisasiRencanaAksiKaban::find(Input::get('realisasi_rencana_aksi_id'));
        if (is_null($st_ra)) {
            return $this->sendError('Capaian Rencana Aksi tidak ditemukan.');
        }


        $st_ra->realisasi          = Input::get('realisasi');
        $st_ra->satuan                  = Input::get('satuan');

        if ( $st_ra->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }

    public function Destroy(Request $request)
    {

        $messages = [
                'realisasi_rencana_aksi_id.required'   => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'realisasi_rencana_aksi_id'   => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $st_ra    = RealisasiRencanaAksiKaban::find(Input::get('realisasi_rencana_aksi_id'));
        if (is_null($st_ra)) {
            return $this->sendError('Capaian Rencana Aksi tidak ditemukan.');
        }


        if ( $st_ra->delete()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }

}
