<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Periode;
use App\Models\PerjanjianKinerja;
use App\Models\SKPTahunan;
use App\Models\SKPBulanan;
use App\Models\CapaianBulanan;
use App\Models\CapaianTriwulan;
use App\Models\Pegawai;
use App\Models\HistoryJabatan;
use App\Models\Jabatan;
use App\Models\Golongan;
use App\Models\Eselon;

use App\Models\KegiatanSKPTahunan;
use App\Models\RencanaAksi;
use App\Models\RealisasiRencanaAksiKasubid;
use App\Models\RealisasiRencanaAksiKabid;
use App\Models\RealisasiRencanaAksiKaban;
use App\Models\KegiatanSKPBulanan;
use App\Models\RealisasiKegiatanBulanan;

use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class CapaianTriwulanAPIController extends Controller {

     //=======================================================================================//
     protected function jabatan($id_jabatan){
        $jabatan       = HistoryJabatan::WHERE('id',$id_jabatan)
                        ->SELECT('jabatan')
                        ->first();
        return Pustaka::capital_string($jabatan->jabatan);
    }


    /* public function CreateConfirm(Request $request)
	{

        //data yang harus diterima yaitu SKP tahunan ID dan trimester

        //dapatkan tgl akhir bulan
        $to     = Pustaka::tgl_akhir(Pustaka::tgl_sql($request->get('tgl_selesai')));

        //mencari tgl 3 bulan lalu
        $from   = Pustaka::triwulan_lalu($to);
        
       

        $jm_skp    =   SKPBulanan::whereBetween('tgl_selesai',[$from,$to])
                            ->WHERE('skp_bulanan.pegawai_id', $request->get('pegawai_id'))
                            ->count();
      
        $capaian   =   CapaianBulanan::whereBetween('tgl_selesai',[$from,$to])
                            ->WHERE('capaian_bulanan.pegawai_id',$request->get('pegawai_id'))
                            ->SELECT('id AS capaian_bulanan_id',
                                     'tgl_mulai',
                                     'u_nama',
                                     'u_jabatan_id',
                                     'p_nama',
                                     'p_jabatan_id'
                                    )
                            ->get();


        $total_realisasi = 0 ; 
        $ck_data = 0 ;
        foreach ($capaian as $x) {
                $ck_data++;
                //realisasi
                $jm_realisasi   = RealisasiKegiatanBulanan::WHERE('capaian_id',$x->capaian_bulanan_id)->count();
                
                ///$data_jabatan_id['jabatan']          = Pustaka::capital_string($x->jabatan);
                $data_capaian_id['capaian_bulanan_id']  = $x->capaian_bulanan_id;
                $data_capaian_id['periode_capaian']     = Pustaka::periode($x->tgl_mulai);

                //tes 
                $u_nama                                 = $x->u_nama;
                $u_jabatan_id                           = $x->u_jabatan_id;
                $p_nama                                 = $x->p_nama;
                $p_jabatan_id                           = $x->p_jabatan_id;

                $data_capaian_id['jm_realisasi']        = $jm_realisasi;
                
                $list_capaian[] = $data_capaian_id ;
                $total_realisasi += $jm_realisasi;
        }

        if ( $ck_data > 0){
            $list_capaian = $list_capaian;
        }else{
            $list_capaian   = 0;
            $u_nama         = "";
            $u_jabatan_id   = "";
            $p_nama         = "";
            $p_jabatan_id   = "";
        }
        

        $data = array(
                    'status'			            =>  'pass',
                    'jm_cap_skp'                    =>  $ck_data." / ".$jm_skp,
                    'periode_capaian_triwulan'      =>  Pustaka::periode($from)." s.d ".Pustaka::periode($to),
                    'total_realisasi'               =>  $total_realisasi,


                    'tgl_mulai_capaian'             => $from,
                    'tgl_selesai_capaian'           => $to,
                    
                    'pegawai_id'                    => $request->get('pegawai_id'),
                    'u_nama'                        => $u_nama,
                    'u_jabatan_id'                  => $u_jabatan_id,
                    'p_nama'                        => $p_nama,
                    'p_jabatan_id'                  => $p_jabatan_id,


                    'list_capaian'                  =>  $list_capaian
                );

        return $data;
    } */


    public function CreateConfirm(Request $request)
	{

        //data yang harus diterima yaitu SKP tahunan ID dan trimester
        $skp_tahunan_id = $request->skp_tahunan_id;
        $trimester = $request->trimester;

        $cp_status = SKPTahunan::WHERE('skp_tahunan.id',$skp_tahunan_id)
                            //CAPAIAN TRIWULAN I
                            ->rightjoin('db_pare_2018.capaian_triwulan AS triwulan', function($join)  use($trimester){
                                $join   ->on('triwulan.skp_tahunan_id','=','skp_tahunan.id');
                                $join   ->where('triwulan.trimester','=',$trimester);
                            })
                            ->count();
      

        

        return $cp_status;
    }


    public function PersonalCapaianTriwulanList(Request $request)
    {


        $id_pegawai = $request->pegawai_id;

        $pegawai = Pegawai::SELECT('id')->WHERE('id',$id_pegawai)->first();

        
        $SKPTahunan = SKPTahunan::WHERE('skp_tahunan.pegawai_id',$id_pegawai)
                        //PERIODE
                        ->leftjoin('db_pare_2018.renja AS renja', function($join){
                            $join   ->on('renja.id','=','skp_tahunan.renja_id');
                        }) 
                        ->leftjoin('db_pare_2018.periode AS periode', function($join){
                            $join   ->on('renja.periode_id','=','periode.id');
                        }) 
                        //SKPD
                        ->leftjoin('demo_asn.m_skpd AS skpd', function($join){
                            $join   ->on('skpd.id','=','renja.skpd_id');
                        }) 

                        //CAPAIAN TRIWULAN I
                        ->leftjoin('db_pare_2018.capaian_triwulan AS triwulan1', function($join){
                            $join   ->on('triwulan1.skp_tahunan_id','=','skp_tahunan.id');
                            $join   ->where('triwulan1.trimester','=','1');
                        })
                         //CAPAIAN TRIWULAN II
                        ->leftjoin('db_pare_2018.capaian_triwulan AS triwulan2', function($join){
                            $join   ->on('triwulan2.skp_tahunan_id','=','skp_tahunan.id');
                            $join   ->where('triwulan2.trimester','=','2');
                        })
                        //CAPAIAN TRIWULAN III
                        ->leftjoin('db_pare_2018.capaian_triwulan AS triwulan3', function($join){
                            $join   ->on('triwulan3.skp_tahunan_id','=','skp_tahunan.id');
                            $join   ->where('triwulan3.trimester','=','3');
                        })
                         //CAPAIAN TRIWULAN IV
                        ->leftjoin('db_pare_2018.capaian_triwulan AS triwulan4', function($join){
                            $join   ->on('triwulan4.skp_tahunan_id','=','skp_tahunan.id');
                            $join   ->where('triwulan4.trimester','=','4');
                        })
                        ->SELECT(   
                            
                            
                                    'skp_tahunan.id AS skp_tahunan_id',
                                    'periode.label',
                                    'skp_tahunan.tgl_mulai',
                                    'skp_tahunan.tgl_selesai',
                                    'skp_tahunan.u_jabatan_id',
                                    'skp_tahunan.status',

                                    'triwulan1.id AS capaian_triwulan1_id',
                                    'triwulan2.id AS capaian_triwulan2_id',
                                    'triwulan3.id AS capaian_triwulan3_id',
                                    'triwulan4.id AS capaian_triwulan4_id'
                                )
                        ->get(); 

       





           $datatables = Datatables::of($SKPTahunan)
            ->addColumn('periode_SKP_tahunan', function ($x) {
                return $x->label;
            }) 
            ->addColumn('jabatan', function ($x) {
                
                return  $this->jabatan($x->u_jabatan_id);
            })
            
            ->addColumn('remaining_time_triwulan1', function ($x) {

                $tgl_selesai = strtotime("2019-04-01");
                $now         = time();
                return floor(($tgl_selesai - $now)/ (60*60*24)) * -1;

            
                
            })
            ->addColumn('remaining_time_triwulan2', function ($x) {

                $tgl_selesai = strtotime("2019-07-01");
                $now         = time();
                return floor(($tgl_selesai - $now)/ (60*60*24)) * -1;

            
                
            })
            ->addColumn('remaining_time_triwulan3', function ($x) {

                $tgl_selesai = strtotime("2019-10-01");
                $now         = time();
                return floor(($tgl_selesai - $now)/ (60*60*24)) * -1;

            
                
            })
            ->addColumn('remaining_time_triwulan4', function ($x) {

                $tgl_selesai = strtotime("2020-01-01");
                $now         = time();
                return floor(($tgl_selesai - $now)/ (60*60*24)) * -1;

            
                
            });
    
            if ($keyword = $request->get('search')['value']) {
                $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
            } 
            
    
        return $datatables->make(true);
        
    }


    
    public function Store(Request $request)
	{
        $messages = [
                 'pegawai_id.required'                   => 'Harus diisi',
                 //'tgl_selesai_capaian.required'          => 'Harus diisi',
                 //'tgl_mulai_capaian.required'            => 'Harus diisi',
                 //'tgl_selesai.required'                  => 'Harus diisi',
                 'u_nama.required'                       => 'Harus diisi',
                 'u_jabatan_id.required'                 => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'pegawai_id'            => 'required',
                            //'tgl_selesai_capaian'   => 'required',
                            //'tgl_mulai_capaian'     => 'required',
                            //'tgl_selesai'           => 'required',
                            'u_nama'                => 'required',
                            'u_jabatan_id'          => 'required',
                        ),
                        $messages
        );
    
        if ( $validator->fails() ){
            //$messages = $validator->messages();
                    return response()->json(['errors'=>$validator->messages()],422);
            
        }

       /*  if ( (Pustaka::tgl_sql(Input::get('tgl_mulai'))) >= (Pustaka::tgl_sql(Input::get('tgl_selesai'))) ){
            $pesan =  ['masa_penilaian'  => 'Error'] ;
            return response()->json(['errors'=> $pesan ],422);
            
        }
 */

            $capaian_triwulan                              = new CapaianTriwulan;
            $capaian_triwulan->pegawai_id                  = Input::get('pegawai_id');
            $capaian_triwulan->trimester                   = Input::get('trimester');
            $capaian_triwulan->skp_tahunan_id              = Input::get('skp_tahunan_id');
            $capaian_triwulan->u_nama                      = Input::get('u_nama');
            $capaian_triwulan->u_jabatan_id                = Input::get('u_jabatan_id');
            $capaian_triwulan->p_nama                      = Input::get('p_nama');
            $capaian_triwulan->p_jabatan_id                = Input::get('p_jabatan_id');
            
    
            
    
            if ( $capaian_triwulan->save()){
                return \Response::make($capaian_triwulan->id, 200);
            }else{
                return \Response::make('error', 500);
            } 


    }   
   
    public function Destroy(Request $request)
    {

        $messages = [
                'capaian_triwulan_id.required'   => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'capaian_triwulan_id'   => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $st_kt    = CapaianTriwulan::find(Input::get('capaian_triwulan_id'));
        if (is_null($st_kt)) {
            //return $this->sendError('Kegiatan Bulanan tidak ditemukan.');
            return response()->json('Capaian Triwulan tidak ditemukan',422);
        }


        if ( $st_kt->delete()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }

}
