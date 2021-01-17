<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SKPTahunan;
use App\Models\SKPBulanan;
use App\Models\CapaianBulanan;
use App\Models\CapaianTriwulan;
use App\Models\CapaianTahunan;
use App\Models\Pegawai;
use App\Models\HistoryJabatan;
use App\Models\HistoryGolongan;
use App\Models\Jabatan;

use App\Models\KegiatanSKPTahunan;
use App\Models\KegiatanSKPTahunanJFT;

use App\Models\Kegiatan;
use App\Models\PerilakuKerja;
use App\Models\RencanaAksi;


use App\Helpers\Pustaka;
use App\Traits\HitungCapaian; 
use App\Traits\BawahanList;
use App\Traits\PJabatan;
use App\Traits\TraitCapaianTahunan;

use Datatables;
use Validator;
use Input;

class CapaianTahunanAPIController extends Controller {

    use HitungCapaian;
    use BawahanList;
    use PJabatan;
    use TraitCapaianTahunan;

    

   

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
                        ->orderBy('skp_tahunan.id','DESC')
                        ->get();

                    
       
           $datatables = Datatables::of($skp)
             ->addColumn('periode', function ($x) {
                return Pustaka::periode_tahun($x->Renja->Periode->label);
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
            ->addColumn('capaian_skp', function ($x) {

                if ( $x->capaian_id != null ){
                    $data_kinerja               = $this->hitung_capaian_tahunan($x->capaian_id); 
                
                    $capaian_skp                        = $data_kinerja['nilai_capaian_skp'];
                    return $capaian_skp;
                }else{
                    return '-';
                }
                
             
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

        $data = array(
                    'periode'	            => $capaian->SKPTahunan->Renja->Periode->label,
                    'date_of_created'	    => Pustaka::tgl_jam($capaian->created_at),
                    'masa_penilaian'        => Pustaka::tgl_form($capaian->tgl_mulai).' s.d  '.Pustaka::tgl_form($capaian->tgl_selesai),
                    'date_of_send'	        => Pustaka::tgl_jam($capaian->date_of_send),
                    'date_of_approve'	    => Pustaka::tgl_jam($capaian->date_of_approve),

                    'tgl_mulai'             => $capaian->tgl_mulai,
                    'pegawai_id'	        => $capaian->pegawai_id,

                    'send_to_atasan'	    => $capaian->send_to_atasan,
                    'status_approve'	    => $capaian->status_approve,

                   
            );
        return $data; 
    }

    protected function CapaianTahunanPejabat(Request $request){
        return $this->Pejabat($request->capaian_tahunan_id);
       

    }
   



    
    public function CreateConfirm(Request $request)
	{
        $skp_tahunan   = SKPTahunan::WHERE('skp_tahunan.id',$request->get('skp_tahunan_id'))
                        
                        ->SELECT('skp_tahunan.id AS skp_tahunan_id',
                                 'skp_tahunan.tgl_mulai',
                                 'skp_tahunan.tgl_selesai',
                                 'skp_tahunan.renja_id',
                                 'skp_tahunan.u_golongan_id',
                                 'skp_tahunan.p_golongan_id',
                                 'skp_tahunan.u_jabatan_id',
                                 'skp_tahunan.p_jabatan_id',
                                 'skp_tahunan.pegawai_id',
                                 'skp_tahunan.renja_id'

                                 
                                )
                        ->first();

        //lihat jenis jabatan, 1,2,3,4
        $id_jabatan_sekda       = json_decode($this->jenis_PJabatan('sekda'));
        $id_jabatan_irban       = json_decode($this->jenis_PJabatan('irban')); //kapus dan kaarsip
        $id_jabatan_lurah       = json_decode($this->jenis_PJabatan('lurah'));
        $id_jabatan_staf_ahli   = json_decode($this->jenis_PJabatan('staf_ahli'));

        $jenis_jabatan  = $skp_tahunan->PegawaiYangDinilai->Eselon->id_jenis_jabatan;
        $jabatan_id     = $skp_tahunan->PegawaiYangDinilai->id_jabatan;
        $renja_id       = $skp_tahunan->Renja->id;

        //return $renja_id;
        /*  1 : KABAN     / ESELON 2
            2 : KABID     / ESELON 3
            3 : KASUBID   / ESELON 4
            4 : PELAKSANA / JFU
            5 : JFT -> kegiatan nya mandiri
        */

        /* //Uraian Tugas Jabatan pada skp bulanan
        $jm_uraian_tugas_tambahan =  UraianTugasTambahan::WHERE('skp_bulanan_id',$request->get('skp_bulanan_id'))->count();
                
        //Jika STAF AHLI
        if ( ( $jenis_jabatan == 1 ) & ( in_array( $skp_bulanan->PegawaiYangDinilai->id_jabatan, $id_jabatan_staf_ahli ) ) ){
            $jenis_jabatan = 5 ; //STAFF AHLI DIANGGAP JFT
        }

        //jika irban
        if ( ( $jenis_jabatan == 2 ) & ( in_array( $skp_bulanan->PegawaiYangDinilai->id_jabatan, $id_jabatan_irban ) ) ){
            $jenis_jabatan = 31 ; //irban
        }

        //jika Lurah
        if ( ( $jenis_jabatan == 3 ) & ( in_array( $skp_bulanan->PegawaiYangDinilai->id_jabatan, $id_jabatan_lurah ) ) ){
            $jenis_jabatan = 2 ; //lurah
        } */



        //=================================  JFT ================================================//
        if ( $jenis_jabatan == 5 ){

            $jm_kegiatan = KegiatanSKPTahunanJFT::WHERE('skp_tahunan_id',$skp_tahunan->skp_tahunan_id)->count();
          
        //================================= PELAKSANA / JFU ================================================//
        }else if ( $jenis_jabatan == 4 ){

        /*     $jm_kegiatan = RencanaAksi::WHERE('jabatan_id',$jabatan_id)
                            ->WHERE('renja_id',$renja_id)
                            ->leftjoin('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join){
                                $join  ->on('skp_tahunan_rencana_aksi.kegiatan_tahunan_id','=','kegiatan_tahunan.id');
                            })
                            ->groupBy('kegiatan_tahunan.id')
                            ->count();  */
            $jm_kegiatan = RencanaAksi::WHERE('jabatan_id',$jabatan_id)
                            ->WHERE('renja_id',$renja_id)
                            ->leftjoin('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join){
                                $join  ->on('skp_tahunan_rencana_aksi.kegiatan_tahunan_id','=','kegiatan_tahunan.id');
                            })
                            ->distinct('kegiatan_tahunan.id')->count('kegiatan_tahunan.id');
                
            //$jm_kegiatan = 3; 

        //================================= KASUBID   / ESELON 4 ===========================================//
        }else if ( $jenis_jabatan == 3 ){
            $jm_kegiatan = KegiatanSKPTahunan::WHERE('skp_tahunan_id',$skp_tahunan->skp_tahunan_id)->count();


        //================================= KABID     / ESELON 3 ===========================================//
        }else if ( $jenis_jabatan == 2 ){
            //CARI BAWAHAN
            
            $child = Jabatan::SELECT('id')->WHERE('parent_id', $jabatan_id )->get()->toArray();
            $jm_kegiatan = Kegiatan::SELECT('id','label')
                            ->WHERE('renja_kegiatan.renja_id', $renja_id )
                            ->WHEREIN('renja_kegiatan.jabatan_id',$child )
                            ->leftjoin('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join){
                                $join   ->on('kegiatan_tahunan.subkegiatan_id','=','renja_kegiatan.id');
                                
                            })
                            ->count();
         
        //================================= KABAN     / ESELON 2 ===========================================//
        }else if ( $jenis_jabatan == 1 ){

        }else{

        }

        

       

        //tanggal selesai capaian tahunan before end
        if ( strtotime(date("Y-m-d")) <= strtotime($skp_tahunan->tgl_selesai) ){
            $cap_tgl_selesai    = date("d-m-Y");
            $status             = "pass_before_end";
        }else{
            $cap_tgl_selesai    = Pustaka::tgl_form($skp_tahunan->tgl_selesai);
            $status             = "pass";
        }


        /*//CARI detail Pegawai sesuai kondisi saat ini ( bukan sesuai SKP nya )
        //nama - jabatan_id - golongan_id
        $pegawai_id = $skp_tahunan->pegawai_id;
        $pegawai = Pegawai::WHERE('id',$pegawai_id)->first();
        //CARI detail Atasan sesuai kondisi saat ini ( bukan sesuai SKP nya )
        //nama - jabatan_id - golongan_id
        $atasan_id = $this->atasan_id($pegawai_id);
        if ( $atasan_id != null  ){
            $atasan = Pegawai::WHERE('id',$atasan_id)->first();
        } */

        //DETAIL data pribadi dan atasan sesuai dengan SKP tahunan
        $u_detail = HistoryJabatan::WHERE('id',$skp_tahunan->u_jabatan_id)->first();
        $p_detail = HistoryJabatan::WHERE('id',$skp_tahunan->p_jabatan_id)->first();


        if ( $skp_tahunan->p_jabatan_id >= 1 ){
            $data = array( 
                'status'			    =>  $status,
                'skp_tahunan_id'        =>  $skp_tahunan->skp_tahunan_id,
                'jabatan_id'            =>  $skp_tahunan->PegawaiYangDinilai->id_jabatan,
                'pegawai_id'            =>  $skp_tahunan->pegawai_id,
                'periode_label'			=>  $skp_tahunan->Renja->Periode->label,
                'masa_penilaian'        =>  Pustaka::balik($skp_tahunan->tgl_mulai). ' s.d '. Pustaka::balik($skp_tahunan->tgl_selesai),
                'cap_tgl_mulai'			=>  Pustaka::tgl_form($skp_tahunan->tgl_mulai),
                'cap_tgl_selesai'	    =>  $cap_tgl_selesai,
                'renja_id'	            =>  $skp_tahunan->Renja->id,
                'jm_kegiatan'           =>  $jm_kegiatan,

                'u_jabatan_id'	        => $u_detail->id,
                'u_golongan_id'	        => $skp_tahunan->u_golongan_id,
                'u_nip'	                => $u_detail->nip,
                'u_nama'                => Pustaka::nama_pegawai($u_detail->Pegawai->gelardpn , $u_detail->Pegawai->nama , $u_detail->Pegawai->gelarblk),
                'u_pangkat'	            => $u_detail->Golongan ? $u_detail->Golongan->pangkat : '',
                'u_golongan'	        => $u_detail->Golongan ? $u_detail->Golongan->golongan : '',
                'u_eselon'	            => $u_detail->Eselon ? $u_detail->Eselon->eselon : '',
                'u_jabatan'	            => Pustaka::capital_string($u_detail->Jabatan ? $u_detail->Jabatan->skpd : ''),
                'u_unit_kerja'	        => Pustaka::capital_string($u_detail->UnitKerja ? $u_detail->UnitKerja->unit_kerja : ''),
                'u_skpd'	            => Pustaka::capital_string($u_detail->Skpd ? $u_detail->Skpd->skpd : ''),
                'u_jenis_jabatan'	    => $u_detail->Eselon->Jenis_jabatan->id,

                'p_jabatan_id'	        => $p_detail->id,
                'p_golongan_id'	        => $skp_tahunan->p_golongan_id,
                'p_nip'	                => $p_detail->nip,
                'p_nama'                => Pustaka::nama_pegawai($p_detail->Pegawai->gelardpn , $p_detail->Pegawai->nama , $p_detail->Pegawai->gelarblk),
                'p_pangkat'	            => $p_detail->Golongan ? $p_detail->Golongan->pangkat : '',
                'p_golongan'	        => $p_detail->Golongan ? $p_detail->Golongan->golongan : '',
                'p_eselon'	            => $p_detail->Eselon ? $p_detail->Eselon->eselon : '',
                'p_jabatan'	            => Pustaka::capital_string($p_detail->Jabatan ? $p_detail->Jabatan->skpd : ''),
                'p_unit_kerja'	        => Pustaka::capital_string($p_detail->UnitKerja ? $p_detail->UnitKerja->unit_kerja : ''),
                'p_skpd'	            => Pustaka::capital_string($p_detail->Skpd ? $p_detail->Skpd->skpd : ''),
                'p_jenis_jabatan'	    => $p_detail->Eselon->Jenis_jabatan->id,

                
                );
        }else{

        
        $data = array(
                'status'			    =>  $status,
                'skp_tahunan_id'        =>  $skp_tahunan->skp_tahunan_id,
                'jabatan_id'            =>  $skp_tahunan->PegawaiYangDinilai->id_jabatan,
                'pegawai_id'            =>  $skp_tahunan->pegawai_id,
                'periode_label'			=>  $skp_tahunan->Renja->Periode->label,
                'masa_penilaian'        =>  Pustaka::balik($skp_tahunan->tgl_mulai). ' s.d '. Pustaka::balik($skp_tahunan->tgl_selesai),
                'cap_tgl_mulai'			=>  Pustaka::tgl_form($skp_tahunan->tgl_mulai),
                'cap_tgl_selesai'	    =>  $cap_tgl_selesai,
                'renja_id'	            =>  $skp_tahunan->Renja->id,
                'jm_kegiatan'           =>  $jm_kegiatan,

                'u_jabatan_id'	        => $u_detail->id,
                'u_golongan_id'	        => $u_detail->Golongan ? $u_detail->Golongan->id : "",
                'u_nip'	                => $u_detail->nip,
                'u_nama'                => Pustaka::nama_pegawai($u_detail->Pegawai->gelardpn , $u_detail->Pegawai->nama , $u_detail->Pegawai->gelarblk),
                'u_pangkat'	            => $u_detail->Golongan ? $u_detail->Golongan->pangkat : '',
                'u_golongan'	        => $u_detail->Golongan ? $u_detail->Golongan->golongan : '',
                'u_eselon'	            => $u_detail->Eselon ? $u_detail->Eselon->eselon : '',
                'u_jabatan'	            => Pustaka::capital_string($u_detail->Jabatan ? $u_detail->Jabatan->skpd : ''),
                'u_unit_kerja'	        => Pustaka::capital_string($u_detail->UnitKerja ? $u_detail->UnitKerja->unit_kerja : ''),
                'u_skpd'	            => Pustaka::capital_string($u_detail->Skpd ? $u_detail->Skpd->skpd : ''),
                'u_jenis_jabatan'	    => $u_detail->Eselon->Jenis_jabatan->id,

                'p_jabatan_id'	        => "",
                'p_golongan_id'	        => "",
                'p_nip'	                => "",
                'p_nama'                => "",
                'p_pangkat'	            => "",
                'p_golongan'	        => "",
                'p_eselon'	            => "",
                'p_jabatan'	            => "",
                'p_unit_kerja'	        => "",
                'p_skpd'	            => "",
                'p_jenis_jabatan'	    => "",
                    
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


    public function AtasanPejabatPenilaiUpdate(Request $request)
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

            $ap_jabatan_id  =  $pegawai->JabatanAktif->id;
        }else{
            return \Response::make('Jabatan tidak ditemukan', 500);
        }


        //Golongan Aktif
        $gol_atasan = HistoryGolongan::WHERE('id_pegawai', $request->pejabat_penilai_id)
                    ->WHERE('status','active')
                    ->first();
        if ($gol_atasan!=null){
            $ap_golongan_id = $gol_atasan->id;
        }else{
            $ap_golongan_id = 0 ;
        }


        
       

        $capaian_tahunan    = CapaianTahunan::find($request->get('capaian_tahunan_id'));
        if (is_null($capaian_tahunan)) {
            return $this->sendError('Capaian tahunan tidak ditemukan tidak ditemukan.');
        }

        
        $capaian_tahunan->ap_jabatan_id    = $ap_jabatan_id;
        $capaian_tahunan->ap_golongan_id   = $ap_golongan_id;
        $capaian_tahunan->ap_nama          = Pustaka::nama_pegawai($pegawai->gelardpn , $pegawai->nama , $pegawai->gelarblk);
   
        
        $item = array(
           
            "ap_nip"			=> $pegawai->nip,
            "ap_nama"		    => Pustaka::nama_pegawai($pegawai->gelardpn , $pegawai->nama , $pegawai->gelarblk),
            "ap_pangkat"	    => $pegawai->JabatanAktif->golongan?$pegawai->JabatanAktif->golongan->pangkat:'',
            "ap_golongan"	    => $pegawai->JabatanAktif->golongan?$pegawai->JabatanAktif->golongan->golongan:'',
            "ap_eselon"		    => $pegawai->JabatanAktif->Eselon?$pegawai->JabatanAktif->Eselon->eselon:'',
            "ap_jabatan"		=> Pustaka::capital_string($pegawai->JabatanAktif->Jabatan?$pegawai->JabatanAktif->Jabatan->skpd:''),
            "ap_unit_kerja"	    => Pustaka::capital_string($pegawai->JabatanAktif->Skpd?$pegawai->JabatanAktif->Skpd->skpd:''),
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
            return Pustaka::tahun($x->tgl_mulai);
        })->addColumn('nama', function ($x) {
            return $x->u_nama;
        })->addColumn('jabatan', function ($x) {
            return Pustaka::capital_string($x->PegawaiYangDinilai?$x->PegawaiYangDinilai->jabatan:'');
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
       
        return $this->Sumary($request->capaian_tahunan_id);


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
                
                //HAPUS SKP bulanan setelah masa penilaian skp tahunan ini berakhir
                //Bulan penilaian range 
                $bln_awal  = Pustaka::angka_bln_tz(Pustaka::tgl_sql(Input::get('cap_tgl_mulai')));
                $bln_akhir = Pustaka::angka_bln_tz(Pustaka::tgl_sql(Input::get('cap_tgl_selesai')));
                $bln_skp_list = array();
                foreach (range($bln_awal, $bln_akhir) as $number) {
                    $z['bulan']	= Pustaka::nol($number);
                    array_push($bln_skp_list, $z);
                } 
                SKPBulanan::WHERE('skp_tahunan_id',Input::get('skp_tahunan_id'))->whereNotIn('bulan', $bln_skp_list)->delete(); 



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
                        $st_ra   = new RealisasiRencanaAksiEselon3;
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

            //cari jumlah skp
            $data_1       = CapaianTahunan::WHERE('pegawai_id',$st_kt->pegawai_id)->count();
            $data_2       = CapaianBulanan::WHERE('pegawai_id',$st_kt->pegawai_id)->count();
            $data_3       = CapaianTriwulan::WHERE('pegawai_id',$st_kt->pegawai_id)->count();
             
            


            return \Response::make(['skp_tahunan_id'        => $st_kt->skp_tahunan_id, 
                                    'jm_capaian_tahunan'    => $data_1,
                                    'jm_capaian_bulanan'    => $data_2,
                                    'jm_capaian_triwulan'   => $data_3,
                                
                                    
                                ], 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }
   
}
