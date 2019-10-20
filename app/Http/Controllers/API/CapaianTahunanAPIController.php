<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Periode;
use App\Models\PerjanjianKinerja;
use App\Models\SKPTahunan;
use App\Models\SKPBulanan;
use App\Models\CapaianBulanan;
use App\Models\CapaianTahunan;
use App\Models\Pegawai;
use App\Models\HistoryJabatan;
use App\Models\HistoryGolongan;
use App\Models\Jabatan;
use App\Models\Golongan;
use App\Models\Eselon; 

use App\Models\KegiatanSKPTahunan;
use App\Models\Kegiatan;
use App\Models\RealisasiKegiatanTahunan;
use App\Models\PerilakuKerja;
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

class CapaianTahunanAPIController extends Controller {

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

    //=======================================================================================//
    protected function atasan_id($pegawai_id){

        $tes =  HistoryJabatan::WHERE('tb_history_jabatan.id_pegawai', $pegawai_id)
                                //cari id jabatan nya
                                ->leftjoin('demo_asn.m_skpd AS m_skpd', function($join){
                                    $join   ->on('m_skpd.id','=','tb_history_jabatan.id_jabatan');
                                })

                                //
                                ->leftjoin('demo_asn.tb_history_jabatan AS atasan', function($join){
                                    $join   ->on('atasan.id_jabatan','=','m_skpd.parent_id');
                                    $join   ->WHERE('atasan.status','=','active');
                                })
                                ->WHERE('tb_history_jabatan.status','active')
                                ->SELECT('atasan.id_pegawai AS atasan_id')
                                ->first();


        return $tes->atasan_id;
       
    }

    /* //=======================================================================================//
    protected function golongan_aktif($pegawai_id){
        $gol       = \DB::table('demo_asn.tb_history_golongan')
                            ->leftjoin('demo_asn.m_golongan AS golongan', function($join){
                                $join   ->on('tb_history_golongan.id_golongan','=','golongan.id');
                            })
                            ->WHERE('tb_history_golongan.id_pegawai',$pegawai_id)
                            ->WHERE('tb_history_golongan.status','=','active')
                            ->SELECT(['golongan.golongan'])
                            ->first();
        return $gol->golongan;
    } */



    public function PersonalCapaianTahunanList(Request $request)
    {
        $skp = SKPTahunan::
                        leftjoin('db_pare_2018.capaian_tahunan', function($join){
                            $join   ->on('capaian_tahunan.skp_tahunan_id','=','skp_tahunan.id');
                        })
                        ->WHERE('skp_tahunan.pegawai_id',$request->pegawai_id)
                        ->select(
                                'skp_tahunan.id AS skp_tahunan_id',
                                'skp_tahunan.renja_id',
                                'skp_tahunan.tgl_mulai',
                                'skp_tahunan.tgl_selesai',
                                'skp_tahunan.u_jabatan_id',
                                'skp_tahunan.status AS skp_tahunan_status',
                                'capaian_tahunan.id AS capaian_id',
                                'capaian_tahunan.status_approve AS capaian_status_approve',
                                'capaian_tahunan.send_to_atasan AS capaian_send_to_atasan'

            
                         )
                       // ->orderBy('bulan','ASC')
                        ->get();

                    
       
           $datatables = Datatables::of($skp)
             ->addColumn('periode', function ($x) {
                //return  Pustaka::Tahun($x->tgl_mulai);
                return $x->Renja->Periode->label;
            }) 
            ->addColumn('pelaksanaan', function ($x) {
                $masa_penilaian = Pustaka::balik($x->tgl_mulai). ' s.d ' . Pustaka::balik($x->tgl_selesai);
                return   $masa_penilaian;
            }) 
            ->addColumn('jabatan', function ($x) {
                if ( $this->jabatan($x->u_jabatan_id) == null ){
                    return "ID Jabatan : ".$x->u_jabatan_id;
                }else{
                    return  $this->jabatan($x->u_jabatan_id);
                }
            })
            ->addColumn('capaian', function ($x) {
                return $x->capaian_id;
             
            })
            ->addColumn('remaining_time', function ($x) {

                $tgl_selesai = strtotime($x->tgl_selesai);
                $now         = time();
                return floor(($tgl_selesai - $now) / (60*60*24)) * -1 ;

            
                
            });
    
            if ($keyword = $request->get('search')['value']) {
                $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
            } 
            
    
        return $datatables->make(true);
        
    }

    protected function CapaianTahunanDetail(Request $request){
     





        $capaian = CapaianTahunan::WHERE('capaian_tahunan.id',$request->capaian_tahunan_id)->first();

    
        $p_detail   = $capaian->PejabatPenilai;
        $u_detail   = $capaian->PejabatYangDinilai;

        //GOLONGAN
        $p_golongan   = $capaian->GolonganPenilai;
        $u_golongan   = $capaian->GolonganYangDinilai;
       

        if ( $p_detail != null ){
            $data = array(
                    'periode'	            => $capaian->SKPTahunan->Renja->Periode->label,
                    'date_created'	        => Pustaka::tgl_jam($capaian->created_at),
                    'masa_penilaian'        => Pustaka::tgl_form($capaian->tgl_mulai).' s.d  '.Pustaka::tgl_form($capaian->tgl_selesai),

                    'tgl_mulai'             => $capaian->tgl_mulai,
                    'pegawai_id'	        => $capaian->pegawai_id,

                    'u_jabatan_id'	        => $u_detail->id,
                    'u_nip'	                => $u_detail->nip,
                    'u_nama'                => $capaian->u_nama,
                    'u_pangkat'	            => $u_golongan->Golongan ? $u_golongan->Golongan->pangkat : '',
                    'u_golongan'	        => $u_golongan->Golongan ? $u_golongan->Golongan->golongan : '',
                    'u_eselon'	            => $u_detail->Eselon ? $u_detail->Eselon->eselon : '',
                    'u_jabatan'	            => Pustaka::capital_string($u_detail->Jabatan ? $u_detail->Jabatan->skpd : ''),
                    'u_unit_kerja'	        => Pustaka::capital_string($u_detail->UnitKerja ? $u_detail->UnitKerja->unit_kerja : ''),
                    'u_skpd'	            => Pustaka::capital_string($u_detail->Skpd ? $u_detail->Skpd->skpd : ''),
                
                    'p_jabatan_id'	        => $p_detail->id,
                    'p_nip'	                => $p_detail->nip,
                    'p_nama'                => $capaian->p_nama,
                    'p_pangkat'	            => $p_golongan->Golongan ? $p_golongan->Golongan->pangkat : '',
                    'p_golongan'	        => $p_golongan->Golongan ? $p_golongan->Golongan->golongan : '',
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
                    'u_pangkat'	            => $u_golongan->Golongan ? $u_golongan->Golongan->pangkat : '',
                    'u_golongan'	        => $u_golongan->Golongan ? $u_golongan->Golongan->golongan : '',
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
   

    
    public function CreateConfirm(Request $request)
	{

       

      
        $skp_tahunan   = SKPTahunan::WHERE('skp_tahunan.id',$request->get('skp_tahunan_id'))
                        
                        ->SELECT('skp_tahunan.id AS skp_tahunan_id',
                                 'skp_tahunan.tgl_mulai',
                                 'skp_tahunan.tgl_selesai',
                                 'skp_tahunan.renja_id',
                                 'skp_tahunan.u_jabatan_id',
                                 'skp_tahunan.p_jabatan_id',
                                 'skp_tahunan.pegawai_id',
                                 'skp_tahunan.renja_id'

                                 
                                )
                        ->first();

        $jenis_jabatan = $skp_tahunan->PejabatYangDinilai->Eselon->id_jenis_jabatan;

        /*  1 : KABAN     / ESELON 2
            2 : KABID     / ESELON 3
            3 : KASUBID   / ESELON 4
            4 : PELAKSANA / JFU
        */

        //================================= PELAKSANA / JFU ================================================//
        if ( $jenis_jabatan == 4 ){


        //================================= KASUBID   / ESELON 4 ===========================================//
        }else if ( $jenis_jabatan == 3 ){
            $jm_kegiatan = KegiatanSKPTahunan::WHERE('skp_tahunan_id',$skp_tahunan->skp_tahunan_id)->count();


        //================================= KABID     / ESELON 3 ===========================================//
        }else if ( $jenis_jabatan == 2 ){
            //CARI BAWAHAN
            
            $child = Jabatan::SELECT('id')->WHERE('parent_id', $skp_tahunan->PejabatYangDinilai->id_jabatan )->get()->toArray();
            $jm_kegiatan = Kegiatan::SELECT('id','label')
                            ->WHERE('renja_kegiatan.renja_id', $skp_tahunan->renja_id )
                            ->WHEREIN('renja_kegiatan.jabatan_id',$child )
                            ->leftjoin('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join){
                                $join   ->on('kegiatan_tahunan.kegiatan_id','=','renja_kegiatan.id');
                                
                            })
                            ->count();
         
        //================================= KABAN     / ESELON 2 ===========================================//
        }else if ( $jenis_jabatan == 1 ){

        }else{

        }

        //CARI detail Pegawai sesuai kondisi saat ini ( bukan sesuai SKP nya )
        //nama - jabatan_id - golongan_id
        $pegawai_id = $skp_tahunan->pegawai_id;
        $pegawai = Pegawai::WHERE('id',$pegawai_id)->first();

        //CARI detail Atasan sesuai kondisi saat ini ( bukan sesuai SKP nya )
        //nama - jabatan_id - golongan_id
        $atasan_id = $this->atasan_id($pegawai_id);
        if ( $atasan_id != null  ){
            $atasan = Pegawai::WHERE('id',$atasan_id)->first();
        }

        //tanggal selesai capaian tahunan before end
        if ( strtotime(date("Y-m-d")) <= strtotime($skp_tahunan->tgl_selesai) ){
            $cap_tgl_selesai    = date("d-m-Y");
            $status             = "pass_before_end";
        }else{
            $cap_tgl_selesai    = Pustaka::tgl_form($skp_tahunan->tgl_selesai);
            $status             = "pass";
        }

        if ( $atasan_id != null  ){
            $data = array(
                'status'			    =>  $status,
                'skp_tahunan_id'        =>  $skp_tahunan->skp_tahunan_id,
                'jabatan_id'            =>  $skp_tahunan->PejabatYangDinilai->id_jabatan,
                'pegawai_id'            =>  $skp_tahunan->pegawai_id,
                'periode_label'			=>  $skp_tahunan->Renja->Periode->label,
                'masa_penilaian'        =>  Pustaka::balik($skp_tahunan->tgl_mulai). ' s.d '. Pustaka::balik($skp_tahunan->tgl_selesai),


                'cap_tgl_mulai'			=>  Pustaka::tgl_form($skp_tahunan->tgl_mulai),
                'cap_tgl_selesai'	    =>  $cap_tgl_selesai,


                'renja_id'	            =>  $skp_tahunan->Renja->id,
                'jm_kegiatan'           =>  $jm_kegiatan,

               
                'u_jabatan_id'	        => $pegawai->JabatanAktif->id,
                'u_golongan_id'	        => $pegawai->GolonganAktif->id,
                'u_nip'	                => $pegawai->nip,
                'u_nama'                => Pustaka::nama_pegawai($pegawai->gelardpn , $pegawai->nama , $pegawai->gelarblk),
                'u_pangkat'	            => $pegawai->GolonganAktif ? $pegawai->GolonganAktif->Golongan->pangkat : '',
                'u_golongan'	        => $pegawai->GolonganAktif ? $pegawai->GolonganAktif->Golongan->golongan : '',
                'u_eselon'	            => $pegawai->JabatanAktif->Eselon ? $pegawai->JabatanAktif->Eselon->eselon : '',
                'u_jabatan'	            => Pustaka::capital_string($pegawai->JabatanAktif->Jabatan ? $pegawai->JabatanAktif->Jabatan->skpd : ''),
                'u_unit_kerja'	        => Pustaka::capital_string($pegawai->JabatanAktif->UnitKerja ? $pegawai->JabatanAktif->UnitKerja->unit_kerja : ''),
                'u_skpd'	            => Pustaka::capital_string($pegawai->JabatanAktif->Skpd ? $pegawai->JabatanAktif->Skpd->skpd : ''),
                'u_jenis_jabatan'	    => $pegawai->JabatanAktif->Eselon->Jenis_jabatan->id,

                'p_jabatan_id'	        => $atasan->JabatanAktif->id,
                'p_golongan_id'	        => $atasan->GolonganAktif->id,
                'p_nip'	                => $atasan->nip,
                'p_nama'                => Pustaka::nama_pegawai($atasan->gelardpn , $atasan->nama , $atasan->gelarblk),
                'p_pangkat'	            => $atasan->GolonganAktif ? $atasan->GolonganAktif->Golongan->pangkat : '',
                'p_golongan'	        => $atasan->GolonganAktif ? $atasan->GolonganAktif->Golongan->golongan : '',
                'p_eselon'	            => $atasan->JabatanAktif->Eselon ? $atasan->JabatanAktif->Eselon->eselon : '',
                'p_jabatan'	            => Pustaka::capital_string($atasan->JabatanAktif->Jabatan ? $atasan->JabatanAktif->Jabatan->skpd : ''),
                'p_unit_kerja'	        => Pustaka::capital_string($atasan->JabatanAktif->UnitKerja ? $atasan->JabatanAktif->UnitKerja->unit_kerja : ''),
                'p_skpd'	            => Pustaka::capital_string($atasan->JabatanAktif->Skpd ? $atasan->JabatanAktif->Skpd->skpd : ''),
                'p_jenis_jabatan'	    => $atasan->JabatanAktif->Eselon->Jenis_jabatan->id,
                
                );
        }else{

        
        $data = array(
                    'status'			    =>  'pass',
                    'skp_tahunan_id'        => $skp_tahunan->skp_tahunan_id,
                    'jabatan_id'            =>  $skp_tahunan->PejabatYangDinilai->id_jabatan,
                    'pegawai_id'            =>  $skp_tahunan->pegawai_id,
                    'periode_label'			=>  $skp_tahunan->Renja->Periode->label,
                    'tgl_mulai'			    =>  Pustaka::tgl_form($skp_tahunan->tgl_mulai),
                    'tgl_selesai'			=>  Pustaka::tgl_form($skp_tahunan->tgl_selesai),
                    'tgl_selesai_baru'      => date("d-m-Y"),

                    'renja_id'	            =>  $skp_tahunan->Renja->id,

                   
                    'u_jabatan_id'	        => $pegawai->JabatanAktif->id,
                    'u_golongan_id'	        => $pegawai->GolonganAktif->id,
                    'u_nip'	                => $pegawai->nip,
                    'u_nama'                => Pustaka::nama_pegawai($pegawai->gelardpn , $pegawai->nama , $pegawai->gelarblk),
                    'u_pangkat'	            => $pegawai->GolonganAktif ? $pegawai->GolonganAktif->Golongan->pangkat : '',
                    'u_golongan'	        => $pegawai->GolonganAktif ? $pegawai->GolonganAktif->Golongan->golongan : '',
                    'u_eselon'	            => $pegawai->JabatanAktif->Eselon ? $pegawai->JabatanAktif->Eselon->eselon : '',
                    'u_jabatan'	            => Pustaka::capital_string($pegawai->JabatanAktif->Jabatan ? $pegawai->JabatanAktif->Jabatan->skpd : ''),
                    'u_unit_kerja'	        => Pustaka::capital_string($pegawai->JabatanAktif->UnitKerja ? $pegawai->JabatanAktif->UnitKerja->unit_kerja : ''),
                    'u_skpd'	            => Pustaka::capital_string($pegawai->JabatanAktif->Skpd ? $pegawai->JabatanAktif->Skpd->skpd : ''),
                    'u_jenis_jabatan'	    => $pegawai->JabatanAktif->Eselon->Jenis_jabatan->id,

                    'p_jabatan_id'	        => "",
                    'p_nip'	                => "",
                    'p_nama'                => "",
                    'p_pangkat'	            => "",
                    'p_golongan'	        => "",
                    'p_eselon'	            => "",
                    'p_jabatan'	            => "",
                    'p_unit_kerja'	        => "",
                    'p_skpd'	            => "", 
                    'p_jenis_jabatan'       => "",
                    
                    );
        }

        return $data; 
    }


    public function PejabatPenilaiUpdate(Request $request)
	{
        $messages = [
            'pejabat_penilai_id.required'           => 'Harus set Pegawai ID',
            'capaian_tahunan_id.required'           => 'Harus diisi',

        ];

        $validator = Validator::make(
            Input::all(),
            array(
                'pejabat_penilai_id'    => 'required',
                'capaian_tahunan_id'    => 'required',
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


        
       

        $capaian_tahunan    = CapaianTahunan::find($request->get('capaian_tahunan_id'));
        if (is_null($capaian_tahunan)) {
            return $this->sendError('Capaian tahunan tidak ditemukan tidak ditemukan.');
        }

        
        $capaian_tahunan->p_jabatan_id    = $p_jabatan_id;
        $capaian_tahunan->p_golongan_id   = $p_golongan_id;
        $capaian_tahunan->p_nama          = Pustaka::nama_pegawai($pegawai->gelardpn , $pegawai->nama , $pegawai->gelarblk);
   
        
        $item = array(
           
            "p_nip"			=> $pegawai->nip,
            "p_nama"		=> Pustaka::nama_pegawai($pegawai->gelardpn , $pegawai->nama , $pegawai->gelarblk),
            "p_pangkat"	    => $pegawai->JabatanAktif->golongan?$pegawai->JabatanAktif->golongan->pangkat:'',
            "p_golongan"	=> $pegawai->JabatanAktif->golongan?$pegawai->JabatanAktif->golongan->golongan:'',
            "p_eselon"		=> $pegawai->JabatanAktif->Eselon?$pegawai->JabatanAktif->Eselon->eselon:'',
            "p_jabatan"		=> Pustaka::capital_string($pegawai->JabatanAktif->Jabatan?$pegawai->JabatanAktif->Jabatan->skpd:''),
            "p_unit_kerja"	=> Pustaka::capital_string($pegawai->JabatanAktif->Skpd?$pegawai->JabatanAktif->Skpd->skpd:''),
            );


        
        if (  $capaian_tahunan->save() ){
            return \Response::make(  $item , 200);


        }else{
            return \Response::make('error', 500);
        } 

    }


    public function SendToAtasan(Request $request)
    {
        $messages = [
                'capaian_tahunan_id.required'   => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'capaian_tahunan_id'   => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $capaian    = CapaianTahunan::find(Input::get('capaian_tahunan_id'));
        if (is_null($capaian)) {
            return $this->sendError('ID capaian tahunan tidak ditemukan.');
        }


        $capaian->send_to_atasan    = '1';
        $capaian->date_of_send      = date('Y'."-".'m'."-".'d'." ".'H'.":".'i'.":".'s');
        $capaian->status_approve    = '0';

        if ( $capaian->save()){
            //return back();
            return \Response::make('sukses', 200);
            
        }else{
            return \Response::make('error', 500);
        } 
            
    }


    public function TolakByAtasan(Request $request)
    {
        $messages = [
                'capaian_tahunan_id.required'   => 'Harus diisi',
                'alasan.required'               => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'capaian_tahunan_id'   => 'required',
                            'alasan'               => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $capaian    = CapaianTahunan::find(Input::get('capaian_tahunan_id'));
        if (is_null($capaian)) {
            return $this->sendError('ID capaian tahunan tidak ditemukan.');
        }


        //$capaian->send_to_atasan    = '1';
        $capaian->date_of_approve     = date('Y'."-".'m'."-".'d'." ".'H'.":".'i'.":".'s');
        $capaian->status_approve      = '2';
        $capaian->alasan_penolakan    = Input::get('alasan');

        if ( $capaian->save()){
            //return back();
            return \Response::make('sukses', 200);
            
        }else{
            return \Response::make('error', 500);
        } 
            
    }

    public function TerimaByAtasan(Request $request)
    {
        $messages = [
                'capaian_tahunan_id.required'   => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'capaian_tahunan_id'   => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $capaian    = CapaianTahunan::find(Input::get('capaian_tahunan_id'));
        if (is_null($capaian)) {
            return $this->sendError('ID capaian tahunan tidak ditemukan.');
        }


        $capaian->date_of_approve     = date('Y'."-".'m'."-".'d'." ".'H'.":".'i'.":".'s');
        $capaian->status_approve      = '1';
        $capaian->alasan_penolakan    = "";

        if ( $capaian->save()){
            //return back();
            return \Response::make('sukses', 200);
            
        }else{
            return \Response::make('error', 500);
        } 
            
    }


    public function ApprovalRequestList(Request $request)
    {
        $pegawai_id = $request->pegawai_id;

        $jabatan_id = HistoryJabatan::SELECT('id')->WHERE('id_pegawai','=',$pegawai_id)->get();
       
        $dt = CapaianTahunan::
                    WHEREIN('capaian_tahunan.p_jabatan_id',$jabatan_id)
                    ->WHERE('capaian_tahunan.send_to_atasan','=','1')
                    ->SELECT( 
                             'capaian_tahunan.id AS capaian_tahunan_id',
                             'capaian_tahunan.u_nama',
                             'capaian_tahunan.skp_tahunan_id',
                             'capaian_tahunan.u_jabatan_id',
                             'capaian_tahunan.tgl_mulai',
                             'capaian_tahunan.status_approve'
                            );
 

    
        $datatables = Datatables::of($dt)
        ->addColumn('periode', function ($x) {
            return Pustaka::periode($x->tgl_mulai);
        })->addColumn('nama', function ($x) {
            return $x->u_nama;
        })->addColumn('jabatan', function ($x) {
            return Pustaka::capital_string($x->PejabatYangDinilai?$x->PejabatYangDinilai->jabatan:'');
        })->addColumn('capaian_tahunan_id', function ($x) {
            return $x->capaian_tahunan_id;
        });

        
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true);
        
    }


    public function CapaianTahunanStatus( Request $request )
    {
       
        $button_kirim = 0 ;
        $capaian_id = $request->capaian_tahunan_id;

        $capaian_tahunan = CapaianTahunan::
                            leftjoin('db_pare_2018.realisasi_kegiatan_tahunan AS rkt', function($join){
                                $join   ->on('rkt.capaian_id','=','capaian_tahunan.id');
                            })
                            ->leftjoin('db_pare_2018.penilaian_perilaku_kerja AS pke', function($join){
                                $join   ->on('pke.capaian_tahunan_id','=','capaian_tahunan.id');
                            })
                            
                            ->SELECT(
                                'capaian_tahunan.id AS capaian_tahunan_id',
                                'capaian_tahunan.skp_tahunan_id AS skp_tahunan_id',
                                'capaian_tahunan.created_at',
                                'capaian_tahunan.status_approve',
                                'capaian_tahunan.send_to_atasan',
                                'capaian_tahunan.alasan_penolakan',
                                'capaian_tahunan.p_jabatan_id',
                                'capaian_tahunan.u_jabatan_id',
                                'pke.id AS penilaian_perilaku_kerja'
                            )
                            ->where('capaian_tahunan.id','=', $capaian_id )->first();
    
        $jenis_jabatan = $capaian_tahunan->PejabatYangDinilai->Jabatan->Eselon->id_jenis_jabatan;
        //$bulan = $capaian_bulanan->SKPBulanan->bulan;

        //jm kegiatan pelaksana
        if ( $jenis_jabatan == 4 ){
            
           
        }else if ( $jenis_jabatan == 3){  //kasubid
            //Jumlah kegiatan 
            $jm_kegiatan = KegiatanSKPTahunan::WHERE('skp_tahunan_id',$capaian_tahunan->skp_tahunan_id)->count();
            $jm_realisasi = RealisasiKegiatanTahunan::WHERE('capaian_id',$capaian_id)->count();

            //cari nilai_capaian Kegiatan tahunan
            $data_cap = RealisasiKegiatanTahunan::WHERE('capaian_id',$capaian_id)->get();
            $nilai_capaian_kegiatan_tahunan = 0 ;
            foreach ($data_cap as $x) {
                $nilai_capaian_kegiatan_tahunan =  $nilai_capaian_kegiatan_tahunan + $x->hitung_quantity;
            }



        }else if ( $jenis_jabatan == 2){ //kabid
            //cari bawahan bawahan nya

       
        }else if ( $jenis_jabatan == 1){ //KABAN
            //cari bawahan bawahan nya
       
        }else{
            $jm_kegiatan_tahunan = 000 ;
        }
                        
        //Penilaian Perilkau kerja
        $x = PerilakuKerja::
                            SELECT( '*') 
                            ->WHERE('penilaian_perilaku_kerja.capaian_tahunan_id', $capaian_id)
                            ->first();

		if ( $x != null ){
            $pelayanan = ($x->pelayanan_01+$x->pelayanan_02+$x->pelayanan_03)/15 * 100;
            $integritas = ($x->integritas_01+$x->integritas_02+$x->integritas_03+$x->integritas_04)/20*100;
            $komitmen = ($x->komitmen_03+$x->komitmen_03+$x->komitmen_03)/15*100;
            $disiplin = ($x->disiplin_01+$x->disiplin_02+$x->disiplin_03+$x->disiplin_04)/20*100;
            $kerjasama = ($x->kerjasama_01+$x->kerjasama_02+$x->kerjasama_03+$x->kerjasama_04+$x->kerjasama_05)/25*100;
            $kepemimpinan = ($x->kepemimpinan_01+$x->kepemimpinan_02+$x->kepemimpinan_03+$x->kepemimpinan_04+$x->kepemimpinan_05+$x->kepemimpinan_06)/30*100;

            if ( $x->CapaianTahunan->PejabatYangDinilai->Jabatan->Eselon->id_jenis_jabatan < 4 ){
                $jumlah = $pelayanan+$integritas+$komitmen+$disiplin+$kerjasama+$kepemimpinan;
                $ave    = $jumlah / 6 ;
            }else{
                $jumlah = $pelayanan+$integritas+$komitmen+$disiplin+$kerjasama;
                $ave    = $jumlah / 5 ; 
            }
        }else{
            $ave    = 0 ; 
        }



      
        $p_detail   = $capaian_tahunan->PejabatPenilai;
        $u_detail   = $capaian_tahunan->PejabatYangDinilai;


        //STATUS APPROVE
        if ( ($capaian_tahunan->status_approve) == 1 ){
            $persetujuan_atasan = 'disetujui';
            $alasan_penolakan   = "";
        }else if ( ($capaian_tahunan->status_approve) == 2 ){
            $persetujuan_atasan = '<span class="text-danger">ditolak</span>';
            $alasan_penolakan   = $capaian_tahunan->alasan_penolakan;
        }else{
            $persetujuan_atasan = 'Menunggu Persetujuan';
            $alasan_penolakan   = "";
        }


            $penilaian_kode_etik = 0 ;
            $capaian_skp_tahunan = 0 ;
      
        $response = array(
                
                'jm_kegiatan_tahunan'           => $jm_kegiatan,
                'jm_realisasi_kegiatan_tahunan' => $jm_realisasi,

                'nilai_capaian_kegiatan_tahunan'=> $nilai_capaian_kegiatan_tahunan,
                'penilaian_perilaku_kerja'  => Pustaka::persen_bulat($ave),


                'capaian_kinerja_tahunan'   => "0",
                'capaian_skp_tahunan'       => $capaian_skp_tahunan,
                
                'status_approve'            => $persetujuan_atasan,
                'send_to_atasan'            => $capaian_tahunan->send_to_atasan,
                'alasan_penolakan'          => $alasan_penolakan,
                'skp_tahunan_id'            => $capaian_tahunan->skp_tahunan_id,
                'tgl_dibuat'                => Pustaka::balik2($capaian_tahunan->created_at),
                'p_nama'                    => Pustaka::nama_pegawai($p_detail->Pegawai->gelardpn , $p_detail->Pegawai->nama , $p_detail->Pegawai->gelarblk),
                'u_nama'                    => Pustaka::nama_pegawai($u_detail->Pegawai->gelardpn , $u_detail->Pegawai->nama , $u_detail->Pegawai->gelarblk),
                



        );
       
        return $response;


    }
    
    public function Store(Request $request)
	{
        $messages = [
                 'pegawai_id.required'                   => 'Harus diisi',
                 'skp_tahunan_id.required'               => 'Harus diisi',
                 'cap_tgl_mulai.required'                => 'Harus diisi',
                 'cap_tgl_selesai.required'              => 'Harus diisi',
                 'u_nama.required'                       => 'Harus diisi',
                 'jenis_jabatan.required'                => 'Harus diisi',
                 'u_jabatan_id.required'                 => 'Harus diisi',
                 'u_golongan_id.required'                => 'Harus diisi',
                 'jm_kegiatan'                           => 'Harus Lebih dari nol'

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'pegawai_id'            => 'required',
                            'skp_tahunan_id'        => 'required',
                            'cap_tgl_mulai'         => 'required',
                            'cap_tgl_selesai'       => 'required',
                            'u_nama'                => 'required',
                            'u_jabatan_id'          => 'required',
                            'u_golongan_id'         => 'required',
                            'jenis_jabatan'         => 'required',
                            'jm_kegiatan'           => 'required|integer|min:1'
                        ),
                        $messages
        );
    
        if ( $validator->fails() ){
            //$messages = $validator->messages();
                    return response()->json(['errors'=>$validator->messages()],422);
            
        }

        if ( (Pustaka::tgl_sql(Input::get('cap_tgl_mulai'))) >= (Pustaka::tgl_sql(Input::get('cap_tgl_selesai'))) ){
            $pesan =  ['masa_penilaian'  => 'Error'] ;
            return response()->json(['errors'=> $pesan ],422);
            
        }


        $cek = CapaianTahunan::WHERE('pegawai_id',Input::get('pegawai_id'))
                                ->WHERE('skp_tahunan_id',Input::get('skp_tahunan_id'))
                                ->SELECT('id')
                                ->count();

        if ( $cek == 0 ){
            $capaian_tahunan                              = new CapaianTahunan;
            $capaian_tahunan->pegawai_id                  = Input::get('pegawai_id');
            $capaian_tahunan->skp_tahunan_id              = Input::get('skp_tahunan_id');
            $capaian_tahunan->u_nama                      = Input::get('u_nama');
            $capaian_tahunan->u_jabatan_id                = Input::get('u_jabatan_id');
            $capaian_tahunan->u_golongan_id               = Input::get('u_golongan_id');
            $capaian_tahunan->p_nama                      = Input::get('p_nama');
            $capaian_tahunan->p_jabatan_id                = Input::get('p_jabatan_id');
            $capaian_tahunan->p_golongan_id               = Input::get('p_golongan_id');
            $capaian_tahunan->tgl_mulai                   = Pustaka::tgl_sql(Input::get('cap_tgl_mulai'));
            $capaian_tahunan->tgl_selesai                 = Pustaka::tgl_sql(Input::get('cap_tgl_selesai'));
            
    
            
    
            if ( $capaian_tahunan->save()){
               
                //UPDATE TANGGAL SELSAI SAKP TAHUNAN SESUAI CAPAIAN
                SKPTahunan::WHERE('id',Input::get('skp_tahunan_id'))->UPDATE( [ 'status' => '1',
                                                                                'tgl_selesai' => Pustaka::tgl_sql(Input::get('cap_tgl_selesai'))
                                                                             ]);

                //ADD KEGIATAN TAHUNAN KE REALISASI CAPAIAN TAHUNAN
                
                if ( Input::get('jenis_jabatan') == '2'){
                   /*  $bawahan_ls = Jabatan::SELECT('id')->WHERE('parent_id',Input::get('jabatan_id'))->get()->toArray();
                    //cari bawahan  , jabatanpelaksanan
                    $pelaksana_list = Jabatan::SELECT('id')->WHEREIN('parent_id', $bawahan_ls)->get()->toArray(); 
        
                    $kegiatan_list = RencanaAksi::WHEREIN('jabatan_id',$pelaksana_list)
                                                ->leftjoin('db_pare_2018.realisasi_rencana_aksi_kasubid AS realisasi', function($join){
                                                    $join   ->on('realisasi.rencana_aksi_id','=','skp_tahunan_rencana_aksi.id');
                                                })
                                                ->SELECT('skp_tahunan_rencana_aksi.id','realisasi.realisasi','skp_tahunan_rencana_aksi.satuan')
                                                ->WHERE('skp_tahunan_rencana_aksi.waktu_pelaksanaan',Input::get('waktu_pelaksanaan'))
                                                ->WHERE('skp_tahunan_rencana_aksi.renja_id',Input::get('renja_id'))
                                                ->get(); 
                    $i = 0 ;
                    foreach ($kegiatan_list as $x) {
                        $data[] = array(
                                        
                            'rencana_aksi_id'       => $x->id,
                            'capaian_id'            => $capaian_tahunan->id,
                            'realisasi'             => $x->realisasi,
                            'satuan'                => $x->satuan,
                            'created_at'            => date('Y'."-".'m'."-".'d'." ".'H'.":".'i'.":".'s'),
                        );
                        $i++;
                    }
                            
                    if ( $i >= 1 ){
                        $st_ra   = new RealisasiRencanaAksiKabid;
                        $st_ra -> insert($data);
                    } */
                }else if ( Input::get('jenis_jabatan') == '1'){ //KAABAN

                    /* $kasubid_ls = Jabatan::
                                        leftjoin('demo_asn.m_skpd AS kasubid', function($join){
                                            $join   ->on('kasubid.parent_id','=','m_skpd.id');
                                        })
                                        ->SELECT('kasubid.id')
                                        ->WHERE('m_skpd.parent_id',Input::get('jabatan_id') )
                                        ->get()
                                        ->toArray(); 

                  
                    //cari bawahan  , jabatanpelaksanan
                    $pelaksana_list = Jabatan::SELECT('id')->WHEREIN('parent_id', $kasubid_ls)->get()->toArray(); 
        
                    $kegiatan_list = RencanaAksi::WHEREIN('jabatan_id',$pelaksana_list)
                                                ->leftjoin('db_pare_2018.realisasi_rencana_aksi_kasubid AS realisasi', function($join){
                                                    $join   ->on('realisasi.rencana_aksi_id','=','skp_tahunan_rencana_aksi.id');
                                                })
                                                ->SELECT('skp_tahunan_rencana_aksi.id','realisasi.realisasi','skp_tahunan_rencana_aksi.satuan')
                                                ->WHERE('skp_tahunan_rencana_aksi.waktu_pelaksanaan',Input::get('waktu_pelaksanaan'))
                                                ->WHERE('skp_tahunan_rencana_aksi.renja_id',Input::get('renja_id'))
                                                ->get(); 
                    $i = 0 ;
                    foreach ($kegiatan_list as $x) {
                        $data[] = array(
                                        
                            'rencana_aksi_id'       => $x->id,
                            'capaian_id'            => $capaian_tahunan->id,
                            'realisasi'             => $x->realisasi,
                            'satuan'                => $x->satuan,
                            'created_at'            => date('Y'."-".'m'."-".'d'." ".'H'.":".'i'.":".'s'),
                        );
                        $i++;
                    }
                            
                    if ( $i >= 1 ){
                        $st_ra   = new RealisasiRencanaAksiKaban;
                        $st_ra -> insert($data);
                    } */
                
                }
                
              
               
                

                return \Response::make($capaian_tahunan->id, 200);
            }else{
                return \Response::make('error', 500);
            } 

        //IF CEK SUDAH ADA CAPAIAN NYA
        }else{
            return \Response::make('Capaian untuk SKP ini sudah ada :'. $cek, 500);
        } 

    }   

  
    public function Destroy(Request $request)
    {

        $messages = [
                'capaian_tahunan_id.required'   => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'capaian_tahunan_id'   => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $st_kt    = CapaianTahunan::find(Input::get('capaian_tahunan_id'));
        if (is_null($st_kt)) {

            return response()->json('Capaian Tahunan tidak ditemukan',422);
        }


        if ( $st_kt->delete()){

            SKPTahunan::WHERE('id',$st_kt->skp_tahunan_id)->UPDATE(['status' => '0']);

            return \Response::make($st_kt->skp_tahunan_id, 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }
   
}
