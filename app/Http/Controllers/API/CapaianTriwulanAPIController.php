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
use App\Models\RealisasiRencanaAksiEselon3;
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
        if ( $jabatan == null ){
            return $jabatan;
        }else{
            return Pustaka::capital_string($jabatan->jabatan);
        }
        
    }

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
                                    'periode.awal AS awal',
                                    'skp_tahunan.tgl_mulai',
                                    'skp_tahunan.tgl_selesai',
                                    'skp_tahunan.u_jabatan_id',
                                    'skp_tahunan.status',

                                    'triwulan1.id AS capaian_triwulan1_id',
                                    'triwulan2.id AS capaian_triwulan2_id',
                                    'triwulan3.id AS capaian_triwulan3_id',
                                    'triwulan4.id AS capaian_triwulan4_id',
                                    'triwulan1.status AS capaian_triwulan1_status',
                                    'triwulan2.status AS capaian_triwulan2_status',
                                    'triwulan3.status AS capaian_triwulan3_status',
                                    'triwulan4.status AS capaian_triwulan4_status'
                                )
                        ->orderBy('periode.id','DESC')
                        ->get(); 

       



          

            $datatables = Datatables::of($SKPTahunan)
            ->addColumn('periode_SKP_tahunan', function ($x) {
                return $x->label;
            }) 
            ->addColumn('id_jenis_jabatan', function ($x) {
                return ($x->PejabatYangDinilai->Eselon)?($x->PejabatYangDinilai->Eselon->id_jenis_jabatan):'';
            })
            ->addColumn('jabatan', function ($x) {
                if ( $this->jabatan($x->u_jabatan_id) == null ){
                    return "ID Jabatan : ".$x->u_jabatan_id;
                }else{
                    return  $this->jabatan($x->u_jabatan_id);
                }
            })
            ->addColumn('remaining_time_triwulan1', function ($x){
                $tahun = Pustaka::tahun($x->awal);
                $tgl_selesai = strtotime($tahun."-04-01");
                $now         = time();
                return floor(($tgl_selesai - $now)/ (60*60*24)) * -1; 
            })
            ->addColumn('remaining_time_triwulan2', function ($x){
                $tahun = Pustaka::tahun($x->awal);
                $tgl_selesai = strtotime($tahun."-07-01");
                $now         = time();
                return floor(($tgl_selesai - $now)/ (60*60*24)) * -1;
            })
            ->addColumn('remaining_time_triwulan3', function ($x){
                $tahun = Pustaka::tahun($x->awal);
                $tgl_selesai = strtotime($tahun."-10-01");
                $now         = time();
                return floor(($tgl_selesai - $now)/ (60*60*24)) * -1;
            })
            ->addColumn('remaining_time_triwulan4', function ($x){
                $tahun = Pustaka::tahun($x->awal);
                $tgl_selesai = strtotime(($tahun+1)."-01-01");
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
                //add realisasi kegiatan bawahan












                
            }else{
                return \Response::make('error', 500);
            } 


    }   

    protected function CapaianTriwulanDetail(Request $request){
     

        $capaian = CapaianTriwulan::WHERE('capaian_triwulan.id',$request->capaian_triwulan_id)->first();

    
        $p_detail   = $capaian->PejabatPenilai;
        $u_detail   = $capaian->PejabatYangDinilai;
       

        if ( $p_detail != null ){
            $data = array(
                    'date_created'	        => Pustaka::tgl_jam($capaian->created_at),
                    'periode_triwulan'	    => Pustaka::trimester($capaian->trimester),

                    'periode_skp_tahunan'	=> $capaian->SKPTahunan->Renja->Periode->label,
                    'masa_penilaian_skp_tahunan'=> Pustaka::tgl_form($capaian->SKPTahunan->tgl_mulai).' s.d  '.Pustaka::tgl_form($capaian->SKPTahunan->tgl_selesai),

                    'tgl_mulai'             => $capaian->tgl_mulai,
                    'pegawai_id'	        => $capaian->pegawai_id,

                    'u_jabatan_id'	        => $u_detail->id,
                    'u_nip'	                => $u_detail->nip,
                    'u_nama'                => $capaian->u_nama,
                    'u_pangkat'	            => $u_detail->Golongan ? $u_detail->Golongan->pangkat : '',
                    'u_golongan'	        => $u_detail->Golongan ? $u_detail->Golongan->golongan : '',
                    'u_eselon'	            => $u_detail->Eselon ? $u_detail->Eselon->eselon : '',
                    'u_jabatan'	            => Pustaka::capital_string($u_detail->Jabatan ? $u_detail->Jabatan->skpd : ''),
                    'u_unit_kerja'	        => Pustaka::capital_string($u_detail->UnitKerja ? $u_detail->UnitKerja->unit_kerja : ''),
                    'u_skpd'	            => Pustaka::capital_string($u_detail->Skpd ? $u_detail->Skpd->skpd : ''),
                
                    'p_jabatan_id'	        => $p_detail->id,
                    'p_nip'	                => $p_detail->nip,
                    'p_nama'                => $capaian->p_nama,
                    'p_pangkat'	            => $p_detail->Golongan ? $p_detail->Golongan->pangkat : '',
                    'p_golongan'	        => $p_detail->Golongan ? $p_detail->Golongan->golongan : '',
                    'p_eselon'	            => $p_detail->Eselon ? $p_detail->Eselon->eselon : '',
                    'p_jabatan'	            => Pustaka::capital_string($p_detail->Jabatan ? $p_detail->Jabatan->skpd : ''),
                    'p_unit_kerja'	        => Pustaka::capital_string($p_detail->UnitKerja ? $p_detail->UnitKerja->unit_kerja : ''),
                    'p_skpd'	            => Pustaka::capital_string($p_detail->Skpd ? $p_detail->Skpd->skpd : ''), 
                
                   

            );
        }else{
            $data = array(
                    'periode'	        => $capaian->SKPBulanan->SKPTahunan->Renja->Periode->label,
                    'date_created'	    => Pustaka::tgl_jam($capaian->created_at),
                    'masa_penilaian'    => Pustaka::tgl_form($capaian->tgl_mulai).' s.d  '.Pustaka::tgl_form($capaian->tgl_selesai),

                    'u_jabatan_id'	        => $u_detail->id,
                    'u_nip'	                => $u_detail->nip,
                    'u_nama'                => Pustaka::nama_pegawai($u_detail->Pegawai->gelardpn , $u_detail->Pegawai->nama , $u_detail->Pegawai->gelarblk),
                    'u_pangkat'	            => $u_detail->Golongan ? $u_detail->Golongan->pangkat : '',
                    'u_golongan'	        => $u_detail->Golongan ? $u_detail->Golongan->golongan : '',
                    'u_eselon'	            => $u_detail->Eselon ? $u_detail->Eselon->eselon : '',
                    'u_jabatan'	            => Pustaka::capital_string($u_detail->Jabatan ? $u_detail->Jabatan->skpd : ''),
                    'u_unit_kerja'	        => Pustaka::capital_string($u_detail->UnitKerja ? $u_detail->UnitKerja->unit_kerja : ''),
                    'u_skpd'	            => Pustaka::capital_string($u_detail->Skpd ? $u_detail->Skpd->skpd : ''),
                
                    'p_jabatan_id'	        => '',
                    'p_nip'	                => '',
                    'p_nama'                => '',
                    'p_pangkat'	            => '',
                    'p_golongan'	        => '',
                    'p_eselon'	            => '',
                    'p_jabatan'	            => '',
                    'p_unit_kerja'	        => '',
                    'p_skpd'	            => '', 
                
                

            );

        }

        return $data; 
    }


    
    public function CapaianTriwulanStatusPengisian( Request $request )
    {
       
        
        $capaian_id = $request->capaian_triwulan_id;

        $capaian_triwulan = CapaianTriwulan::
                            SELECT(
                                'capaian_triwulan.id AS capaian_triwulan_id',
                                'capaian_triwulan.skp_tahunan_id',
                                'capaian_triwulan.created_at',
                                'capaian_triwulan.status_approve',
                                'capaian_triwulan.send_to_atasan',
                                'capaian_triwulan.alasan_penolakan',
                                'capaian_triwulan.p_jabatan_id',
                                'capaian_triwulan.u_jabatan_id',
                                'capaian_triwulan.status'
                            )
                            ->where('capaian_triwulan.id','=', $capaian_id )->first();
        
        
        //Jumlah KEGIATAN KASUBID
        $keg_skp_tahunan = KegiatanSKPTahunan::WHERE('skp_tahunan_id',$capaian_triwulan->skp_tahunan_id)->count();
       
        
      
        $p_detail   = $capaian_triwulan->PejabatPenilai;


    
        $response = array(
                
                'jm_kegiatan_tahunan'       => $keg_skp_tahunan,
                'status'                    => $capaian_triwulan->status,
                'send_to_atasan'            => $capaian_triwulan->send_to_atasan,
                'tgl_dibuat'                => Pustaka::balik2($capaian_triwulan->created_at),
                'p_nama'                    => Pustaka::nama_pegawai($p_detail->Pegawai->gelardpn , $p_detail->Pegawai->nama , $p_detail->Pegawai->gelarblk),
               

        );
       
        return $response;


    }




    public function PejabatPenilaiUpdate(Request $request)
	{
        $messages = [
            'pejabat_penilai_id.required'           => 'Harus set Pegawai ID',
            'capaian_triwulan_id.required'           => 'Harus diisi',

        ];

        $validator = Validator::make(
            Input::all(),
            array(
                'pejabat_penilai_id'     => 'required',
                'capaian_triwulan_id'    => 'required',
            ),
            $messages
        );

        if ( $validator->fails() ){
                return response()->json(['errors'=>$validator->messages()],422);
        }


        //Cari nama dan id pejabatan penilai
        $pegawai     = Pegawai::SELECT('*')->where('id',$request->pejabat_penilai_id )->first();

        //$jabatan_x     = $pegawai->JabatanAktif;

        if ( $pegawai->JabatanAktif ){

            $p_jabatan_id  =  $pegawai->JabatanAktif->id;
        }else{
            return \Response::make('Jabatan tidak ditemukan', 500);
        }

        //Golongan Aktif
        $gol_atasan = HistoryGolongan::WHERE('id_pegawai', $request->pejabat_penilai_id)
                    ->WHERE('status','active')
                    ->first();
        if ($gol_atasan!=null){
            $p_golongan_id = $gol_atasan->id;
        }else{
            $p_golongan_id = 0 ;
        }


        
       

        $capaian_triwulan    = CapaianTriwulan::find($request->get('capaian_triwulan_id'));
        if (is_null($capaian_triwulan)) {
            return $this->sendError('Capaian Triwulan tidak ditemukan tidak ditemukan.');
        }

        
        $capaian_triwulan->p_jabatan_id    = $p_jabatan_id;
        $capaian_triwulan->p_golongan_id   = $p_golongan_id;
        $capaian_triwulan->p_nama          = Pustaka::nama_pegawai($pegawai->gelardpn , $pegawai->nama , $pegawai->gelarblk);
   
        
        $item = array(
           
            "p_nip"			=> $pegawai->nip,
            "p_nama"		=> Pustaka::nama_pegawai($pegawai->gelardpn , $pegawai->nama , $pegawai->gelarblk),
            "p_pangkat"	    => $pegawai->JabatanAktif->golongan?$pegawai->JabatanAktif->golongan->pangkat:'',
            "p_golongan"	=> $pegawai->JabatanAktif->golongan?$pegawai->JabatanAktif->golongan->golongan:'',
            "p_eselon"		=> $pegawai->JabatanAktif->Eselon?$pegawai->JabatanAktif->Eselon->eselon:'',
            "p_jabatan"		=> Pustaka::capital_string($pegawai->JabatanAktif->Jabatan?$pegawai->JabatanAktif->Jabatan->skpd:''),
            "p_unit_kerja"	=> Pustaka::capital_string($pegawai->JabatanAktif->Skpd?$pegawai->JabatanAktif->Skpd->skpd:''),
            );


        
        if (  $capaian_triwulan->save() ){
            return \Response::make(  $item , 200);


        }else{
            return \Response::make('error', 500);
        } 

    }


    public function Close(Request $request)
	{
        $messages = [
           
            'capaian_triwulan_id.required'           => 'Harus diisi',

        ];

        $validator = Validator::make(
            Input::all(),
            array(
                'capaian_triwulan_id'    => 'required',
            ),
            $messages
        );

        if ( $validator->fails() ){
                return response()->json(['errors'=>$validator->messages()],422);
        }


        $capaian_triwulan    = CapaianTriwulan::find($request->get('capaian_triwulan_id'));
        if (is_null($capaian_triwulan)) {
            return $this->sendError('Capaian Triwulan tidak ditemukan tidak ditemukan.');
        }

        
        $capaian_triwulan->status    = '1';
       
        
        if (  $capaian_triwulan->save() ){
            return \Response::make( 'sukses', 200);
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
