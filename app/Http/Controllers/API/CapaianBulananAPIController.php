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
use App\Models\CapaianTahunan;
use App\Models\Pegawai;
use App\Models\HistoryJabatan;
use App\Models\Jabatan;
use App\Models\Golongan;
use App\Models\Eselon;

use App\Models\KegiatanSKPTahunan;
use App\Models\RencanaAksi;
use App\Models\RealisasiRencanaAksiEselon4;
use App\Models\RealisasiRencanaAksiEselon3;
use App\Models\RealisasiRencanaAksiKaban;
use App\Models\KegiatanSKPBulanan;
use App\Models\KegiatanSKPBulananJFT;
use App\Models\RealisasiKegiatanBulanan;
use App\Models\TugasTambahan;
use App\Models\UraianTugasTambahan;


use App\Helpers\Pustaka;
use App\Traits\HitungCapaian; 
use App\Traits\BawahanList;
use App\Traits\PJabatan;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class CapaianBulananAPIController extends Controller {

    use HitungCapaian;
    use BawahanList;
    use PJabatan;

  
  
    protected function CapaianBulananDetail(Request $request){
     





        $capaian = CapaianBulanan::WHERE('capaian_bulanan.id',$request->capaian_bulanan_id)->first();

    
        $p_detail   = $capaian->PejabatPenilai;
        $u_detail   = $capaian->PejabatYangDinilai;
       

        if ( $p_detail != null ){
            $data = array(
                    'periode'	            => Pustaka::periode($capaian->SKPBulanan->tgl_mulai),
                    'date_created'	        => Pustaka::tgl_jam($capaian->created_at),
                    'masa_penilaian'        => Pustaka::tgl_form($capaian->tgl_mulai).' s.d  '.Pustaka::tgl_form($capaian->tgl_selesai),

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
                    'periode'	        => Pustaka::periode($capaian->SKPBulanan->tgl_mulai),
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

    public function PersonalCapaianBulananList(Request $request) 
    {
        $skp = SKPBulanan::
                        leftjoin('db_pare_2018.capaian_bulanan', function($join){
                            $join   ->on('capaian_bulanan.skp_bulanan_id','=','skp_bulanan.id');
                        })
                         
                        ->select(
                                'skp_bulanan.id AS skp_bulanan_id',
                                'skp_bulanan.skp_tahunan_id',
                                'skp_bulanan.bulan',
                                'skp_bulanan.tgl_mulai',
                                'skp_bulanan.tgl_selesai',
                                'skp_bulanan.u_jabatan_id',
                                'skp_bulanan.status AS skp_bulanan_status',
                                'capaian_bulanan.created_at',
                                'capaian_bulanan.id AS capaian_id',
                                'capaian_bulanan.status_approve AS capaian_status_approve',
                                'capaian_bulanan.send_to_atasan AS capaian_send_to_atasan'

            
                         )
                        ->WHERE('skp_bulanan.pegawai_id',$request->pegawai_id)
                        //->orderBy('skp_bulanan.tgl_mulai','DESC')
                        ->orderBy('skp_bulanan.skp_tahunan_id','desc')
                        //->orderBy('skp_bulanan.bulan','ASC')
                        //->orderBy('skp_bulanan.skp_tahunan_id')
                        ->get();

       
           $datatables = Datatables::of($skp)
            ->addColumn('periode', function ($x) {
                //return $x->label; 
                return  Pustaka::Tahun($x->tgl_mulai).' [ '.$x->skp_tahunan_id.' ]';
            }) 
            ->addColumn('periode_2', function ($x) {
                //return $x->label; 
                return  Pustaka::Tahun($x->tgl_mulai);
            })
            ->addColumn('bulan', function ($x) {
                return Pustaka::bulan($x->bulan);
            }) 
            ->addColumn('pelaksanaan', function ($x) {
                $masa_penilaian = Pustaka::tgl_form($x->tgl_mulai). ' &nbsp; s.d &nbsp; ' . Pustaka::tgl_form($x->tgl_selesai);
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
                return floor(($tgl_selesai - $now)/ (60*60*24)) * -1;

            
                
            });
    
            if ($keyword = $request->get('search')['value']) {
                $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
            } 
            
    
        return $datatables->make(true);
        
    }

   

    public function CreateConfirm(Request $request)
	{ 

        //data yang harus diterima yaitu SKP Bulanan ID
        //cek apakah sudah punya capaian atau belum
        //apakah tgl sudah lewat dari tgl akhir
        //lihat kegiatan nya serta pelihatkan capaian kegia9tan nya juga ( capaian kegiatan dapat dibuat dibulan berjalaan)
        
        //lihat jenis jabatan, 1,2,3,4
        $id_jabatan_sekda       = json_decode($this->jenis_PJabatan('sekda'));
        $id_jabatan_irban       = json_decode($this->jenis_PJabatan('irban')); //kapus dan kaarsip
        $id_jabatan_lurah       = json_decode($this->jenis_PJabatan('lurah'));
        $id_jabatan_staf_ahli   = json_decode($this->jenis_PJabatan('jabatan_staf_ahli'));

      
        $skp_bulanan   = SKPBulanan::WHERE('skp_bulanan.id',$request->get('skp_bulanan_id'))
                        
                        ->SELECT('skp_bulanan.id AS skp_bulanan_id',
                                 'skp_bulanan.tgl_mulai',
                                 'skp_bulanan.tgl_selesai',
                                 'skp_bulanan.skp_tahunan_id',
                                 'skp_bulanan.bulan',
                                 'skp_bulanan.u_jabatan_id',
                                 'skp_bulanan.p_jabatan_id',
                                 'skp_bulanan.pegawai_id'

                                 
                                )
                        ->first();

        $jenis_jabatan  = $skp_bulanan->PejabatYangDinilai->Eselon->id_jenis_jabatan;
        $renja_id       = $skp_bulanan->SKPTahunan->renja_id;
        $bulan          = $skp_bulanan->bulan;
        $jabatan_id     = $skp_bulanan->PejabatYangDinilai->id_jabatan;

        //Uraian Tugas Jabatan pada skp bulanan
        $jm_uraian_tugas_tambahan =  UraianTugasTambahan::WHERE('skp_bulanan_id',$request->get('skp_bulanan_id'))->count();
        
        //Jika STAF AHLI
        if ( ( $jenis_jabatan == 1 ) & ( in_array( $skp_bulanan->PejabatYangDinilai->id_jabatan, $id_jabatan_staf_ahli ) ) ){
            $jenis_jabatan = 5 ; //STAFF AHLI DIANGGAP JFT
        }

        //jika irban
        if ( ( $jenis_jabatan == 2 ) & ( in_array( $skp_bulanan->PejabatYangDinilai->id_jabatan, $id_jabatan_irban ) ) ){
            $jenis_jabatan = 31 ; //irban
        }

        //jika Lurah
        if ( ( $jenis_jabatan == 3 ) & ( in_array( $skp_bulanan->PejabatYangDinilai->id_jabatan, $id_jabatan_lurah ) ) ){
            $jenis_jabatan = 2 ; //lurah
        }




        //IRBAN
        if ( $jenis_jabatan == 31){
            //cari bawahan
            //$bawahan = Jabatan::SELECT('id','skpd AS jabatan')->WHERE('id',$jabatan_id )->get();

            //IRBAN DAN KAPUS sama, dicoba dengan kgeitan bawahan dan egiatan yang dilaksanakan sendiri,
            //update 24/06/2020
            $bawahan = Jabatan::SELECT('id','skpd AS jabatan')->WHERE('parent_id',  $jabatan_id  )->ORWHERE('id',  $jabatan_id )->get(); 

            //list bawahan
            $jm_kegiatan = 0 ; 
            foreach ($bawahan as $x) {
            
                $dt_reaksi = RencanaAksi::WHERE('jabatan_id',$x->id)
                                            ->WHERE('waktu_pelaksanaan',$skp_bulanan->bulan)
                                            ->WHERE('renja_id',$renja_id)
                                            ->count();
                $ls_reaksi = RencanaAksi::WHERE('jabatan_id',$x->id)
                                            ->WHERE('waktu_pelaksanaan',$skp_bulanan->bulan)
                                            ->WHERE('renja_id',$renja_id)
                                            ->SELECT('id')
                                            ->get()->toArray(); 
                $dt_keg_bulanan = KegiatanSKPBulanan::WHEREIN('rencana_aksi_id',$ls_reaksi)->SELECT('id')->get()->toArray();
                $jm_realisasi   = RealisasiKegiatanBulanan::WHEREIN('kegiatan_bulanan_id',$dt_keg_bulanan)->count();


                if ( $x->id == $jabatan_id){
                    $nm_jabatan     = 'Dilaksanakan Sendiri';
                    $t_kegiatan    = $dt_reaksi;
                }else{
                    $nm_jabatan     = Pustaka::capital_string($x->jabatan);
                    $t_kegiatan    =  $dt_reaksi.' / '.$jm_realisasi;
                }
               
    
                $data_jabatan_id['jabatan']             = $nm_jabatan;
                $data_jabatan_id['jm_keg']              = $dt_reaksi;
                $data_jabatan_id['jm_realisasi']        = $jm_realisasi;
                $data_jabatan_id['t_kegiatan']          = $t_kegiatan;

                
                $pelaksana_list[] = $data_jabatan_id ;
                $jm_kegiatan += $dt_reaksi;
            }
            $list_bawahan  = array_reverse($pelaksana_list);     
        //================================= JFT ===========================================//
        }else if ( $jenis_jabatan == 5 ){
            $jm_kegiatan = KegiatanSKPBulananJFT::WHERE('skp_bulanan_id','=',$request->get('skp_bulanan_id'))->count();

            $list_bawahan = "";
            $kegiatan_list = "";
			$jm_realisasi = "";


        //================================= PELAKSANA ===========================================//
        }else if ( $jenis_jabatan == 4 ){
            $jm_kegiatan = KegiatanSKPBulanan::WHERE('skp_bulanan_id','=',$request->get('skp_bulanan_id'))->count();
       
            
            $nm_jabatan     = 'Dilaksanakan Sendiri';
            $t_kegiatan     = $jm_kegiatan;
            
           

            $data_jabatan_id['jabatan']           = $nm_jabatan;
            $data_jabatan_id['jm_keg']            = $jm_kegiatan;
            $data_jabatan_id['jm_realisasi']      = 0;
            $data_jabatan_id['t_kegiatan']        = $t_kegiatan;

            $pelaksana_list[]                       = $data_jabatan_id ;
            $list_bawahan                           = array_reverse($pelaksana_list);

            $kegiatan_list = "";
			$jm_realisasi = "";
        //================================= K A S U B I D ========================================// 
        }else if ( $jenis_jabatan == 3 ){ //eselon IV
            //cari bawahan
            $jabatan_id = $skp_bulanan->PejabatYangDinilai->id_jabatan;
            $bawahan = Jabatan::
                            WHERE('id',$jabatan_id)
                            ->orwhere(function ($query) use($jabatan_id) {
                                $query  ->where('parent_id',$jabatan_id )
                                        ->whereBetween('id_eselon', [9,10]);
                            })
                            ->SELECT('id','skpd AS jabatan')
                            ->get();

            //list bawahan
            $jm_kegiatan = 0 ; 
            foreach ($bawahan as $x) {
              
                $dt_reaksi = RencanaAksi::WHERE('jabatan_id',$x->id)
                                            ->WHERE('waktu_pelaksanaan',$skp_bulanan->bulan)
                                            ->WHERE('renja_id',$renja_id)
                                            ->count();
                $ls_reaksi = RencanaAksi::WHERE('jabatan_id',$x->id)
                                            ->WHERE('waktu_pelaksanaan',$skp_bulanan->bulan)
                                            ->WHERE('renja_id',$renja_id)
                                            ->SELECT('id')
                                            ->get()->toArray(); 
                $dt_keg_bulanan = KegiatanSKPBulanan::WHEREIN('rencana_aksi_id',$ls_reaksi)->SELECT('id')->get()->toArray();
                $jm_realisasi   = RealisasiKegiatanBulanan::WHEREIN('kegiatan_bulanan_id',$dt_keg_bulanan)->count();

                if ( $x->id == $jabatan_id){
                    $nm_jabatan     = 'Dilaksanakan Sendiri';
                    $t_kegiatan     = $dt_reaksi;
                }else{
                    $nm_jabatan     = Pustaka::capital_string($x->jabatan);

                    if ( $dt_reaksi == 0 ){
                        $t_kegiatan     =  0;
                    }else{
                        $t_kegiatan     =  $dt_reaksi.' / '.$jm_realisasi;
                    }
                }
               

                $data_jabatan_id['jabatan']           = $nm_jabatan;
                $data_jabatan_id['jm_keg']            = $dt_reaksi;
                $data_jabatan_id['jm_realisasi']      = $jm_realisasi;
                $data_jabatan_id['t_kegiatan']       = $t_kegiatan;



                $pelaksana_list[] = $data_jabatan_id ;
                $jm_kegiatan += $dt_reaksi;
            }
            $list_bawahan  = array_reverse($pelaksana_list);    
        //================================= K A B I D ========================================// 
        }else if ( $jenis_jabatan == 2){   //Eselon III atau lurah

            
            $jabatan_id = $skp_bulanan->PejabatYangDinilai->id_jabatan;
            //cari bawahan
            $bawahan        = Jabatan::SELECT('id','skpd AS jabatan' )->WHERE('parent_id',$jabatan_id )->get();
            //$bawahan_ls     = Jabatan::SELECT('id')->WHERE('parent_id', $jabatan_id )->get()->toArray();
            //cari bawahan  , jabatanpelaksanan

            /* $pelaksana_list = Jabatan::
                                SELECT('id')
                                ->WHEREIN('parent_id', $bawahan_ls)
                                ->get()
                                ->toArray();  */

            //list bawahan
            $jm_kegiatan = 0 ; 
            foreach ($bawahan as $x) {
                //list pelaksana
                //$child = Jabatan::SELECT('id')->WHERE('parent_id',$x->id )->get()->toArray();

                //ada beberapa eselon 4 yang melaksanakan kegiatan sendiri, kasus kasi dan lurah nagasari 23/0/2020
                //sehingga dicoba untuk kegiatan bawahan nya juga diikutsertakan
                $child = Jabatan::SELECT('id')->WHERE('id',$x->id )->ORWHERE('parent_id',$x->id )->get()->toArray();



                $dt_reaksi = RencanaAksi::WHEREIN('jabatan_id',$child)
                                            ->WHERE('waktu_pelaksanaan',$skp_bulanan->bulan)
                                            ->WHERE('renja_id',$renja_id)
                                            ->count();
                $ls_reaksi = RencanaAksi::WHEREIN('jabatan_id',$child)
                                            ->WHERE('waktu_pelaksanaan',$skp_bulanan->bulan)
                                            ->WHERE('renja_id',$renja_id)
                                            ->SELECT('id')
                                            ->get()->toArray();
                //realisasi bawahan
                $jm_realisasi   = RealisasiRencanaAksiEselon4::WHEREIN('rencana_aksi_id',$ls_reaksi)->count();

                if ( $x->id == $jabatan_id){
                    $nm_jabatan     = 'Dilaksanakan Sendiri';
                    $t_kegiatan    = $dt_reaksi;
                }else{
                    $nm_jabatan     = Pustaka::capital_string($x->jabatan);
                    if ( $dt_reaksi == 0 ){
                        $t_kegiatan     =  0;
                    }else{
                        $t_kegiatan     =  $dt_reaksi.' / '.$jm_realisasi;
                    }
                }
               
    
                $data_jabatan_id['jabatan']             = $nm_jabatan;
                $data_jabatan_id['jm_keg']              = $dt_reaksi;
                $data_jabatan_id['jm_realisasi']        = $jm_realisasi;
                $data_jabatan_id['t_kegiatan']          = $t_kegiatan;



                $kasubid_list[] = $data_jabatan_id ;
                $jm_kegiatan += $dt_reaksi;
            }
            $list_bawahan = $kasubid_list;
            
        
        //============================   ESELON 2 dengan perlakuan Normal   ===================================// 
        }else if ( $jenis_jabatan == 1){

            $jabatan_id = $skp_bulanan->PejabatYangDinilai->id_jabatan;
            //BAWAHAN ESELON II normal
            $bawahan = $this->BawahanListCapaianBulanan($jabatan_id,$jenis_jabatan); 
         
            $jm_kegiatan = 0 ; 
            $jm_realisasi = 0 ; 

            //return $bawahan;

            foreach ($bawahan as $x) {   
                $jabatan_id = $x->jabatan_id;
                $data = SKPTahunan::WHERE('skp_tahunan.renja_id',$renja_id)
                                
                                    ->join('demo_asn.tb_history_jabatan AS jabatan', function($join) use($jabatan_id){
                                        $join   ->ON('jabatan.id','=','skp_tahunan.u_jabatan_id');
                                        $join   ->WHERE('jabatan.id_jabatan','=',$jabatan_id);
                                    })
                                    ->join('db_pare_2018.skp_bulanan AS skp_bulanan', function($join) use($bulan) {
                                        $join   ->ON('skp_tahunan.id','=','skp_bulanan.skp_tahunan_id');
                                        $join   ->WHERE('skp_bulanan.bulan','=',$bulan);
                                    }) 
                                    ->join('db_pare_2018.capaian_bulanan AS capaian_bulanan', function($join) use($bulan){
                                        $join   ->ON('capaian_bulanan.skp_bulanan_id','=','skp_bulanan.id');
                                        $join   ->WHERE('skp_bulanan.bulan','=',$bulan);
                                    }) 
                                    ->SELECT(   'jabatan.id_jabatan AS jabatan_id',
                                                'skp_tahunan.id AS skp_tahunan_id',
                                                'skp_bulanan.id AS skp_bulanan_id',
                                                'skp_bulanan.bulan AS skp_bulanan_bulan',
                                                'capaian_bulanan.id AS capaian_id'
                                            )
                                    ->first();

                //JUMLAH RENCANA AKSI YANG DIMILIKI OLEH BAWAHAN LANGSUNG / ESELON III 
                //atau setara eselon 4 untuk jabatan seperti irban

                if ( $data != null ){
                    //jika irban kapus atau ka arsip
                    //maka rwalisasinya ada di eselon4
                    if ( in_array( $jabatan_id, $id_jabatan_irban ) ){
                        $dt_reaksi      = RealisasiRencanaAksiEselon4::WHERE('capaian_id',$data->capaian_id)->count();
                        $dt_realisasi   = RealisasiRencanaAksiEselon4::WHERE('capaian_id',$data->capaian_id)->WHERE('realisasi','!=',null)->count();
                    }else{
                        //eselon3
                        $dt_reaksi      = RealisasiRencanaAksiEselon3::WHERE('capaian_id',$data->capaian_id)->count();
                        $dt_realisasi   = RealisasiRencanaAksiEselon3::WHERE('capaian_id',$data->capaian_id)->WHERE('realisasi','!=',null)->count();
                    }

                    

                }else{
                    $dt_reaksi      = 0 ;
                    $dt_realisasi   = 0 ;
                }
                
                
                $data_jabatan_id['jabatan']         = Pustaka::capital_string($x->jabatan)." / ".$x->eselon;
                $data_jabatan_id['jm_keg']          = $dt_reaksi;
                $data_jabatan_id['jm_realisasi']    = $dt_realisasi;
                $data_jabatan_id['t_kegiatan']      = $dt_reaksi.' / '.$dt_realisasi;


                $kabid_list[] = $data_jabatan_id ;
                $jm_kegiatan +=  $dt_reaksi;
                $jm_realisasi +=  $dt_realisasi;
            }
            $list_bawahan = $kabid_list;  
            
        
        //===================================================================================// 
        }else{
			$list_bawahan = "";
            $jm_kegiatan = 0 ;
			$jm_realisasi = "";
        }
        //
        
        
        //DETAIL data pribadi dan atasan
        $u_detail = HistoryJabatan::WHERE('id',$skp_bulanan->u_jabatan_id)->first();
        $p_detail = HistoryJabatan::WHERE('id',$skp_bulanan->p_jabatan_id)->first();

        if ( $skp_bulanan->p_jabatan_id >= 1 ){
            $data = array(
                'status'			    =>  'pass',
                'renja_id'              =>  $renja_id,
                'jenis_jabatan'         =>  $jenis_jabatan,
                'list_bawahan'          =>  $list_bawahan,
                'jabatan_id'            =>  $skp_bulanan->PejabatYangDinilai->id_jabatan,
                'pegawai_id'            =>  $skp_bulanan->pegawai_id,
                'skp_bulanan_id'        =>  $skp_bulanan->skp_bulanan_id,
                'periode_label'			=>  Pustaka::bulan($skp_bulanan->bulan),
                'tgl_mulai'			    =>  Pustaka::tgl_form($skp_bulanan->tgl_mulai),
                'tgl_selesai'			=>  Pustaka::tgl_form($skp_bulanan->tgl_selesai),
                'jm_kegiatan_bulanan'	=>  $jm_kegiatan + $jm_uraian_tugas_tambahan,
                'jm_realisasi'	        =>  $jm_realisasi,

                'jm_uraian_tugas_tambahan'	=>  $jm_uraian_tugas_tambahan,

                'renja_id'	            =>  $skp_bulanan->SKPTahunan->Renja->id,
                'waktu_pelaksanaan'	    =>  $skp_bulanan->bulan,

               
                'u_jabatan_id'	        => $u_detail->id,
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
                'p_nip'	                => $p_detail->nip,
                'p_nama'                => Pustaka::nama_pegawai($p_detail->Pegawai->gelardpn , $p_detail->Pegawai->nama , $p_detail->Pegawai->gelarblk),
                'p_pangkat'	            => $p_detail->Golongan ? $p_detail->Golongan->pangkat : '',
                'p_golongan'	        => $p_detail->Golongan ? $p_detail->Golongan->golongan : '',
                'p_eselon'	            => $p_detail->Eselon ? $p_detail->Eselon->eselon : '',
                'p_jabatan'	            => Pustaka::capital_string($p_detail->Jabatan ? $p_detail->Jabatan->skpd : ''),
                'p_unit_kerja'	        => Pustaka::capital_string($p_detail->UnitKerja ? $p_detail->UnitKerja->unit_kerja : ''),
                'p_skpd'	            => Pustaka::capital_string($p_detail->Skpd ? $p_detail->Skpd->skpd : ''),
                
                );
        }else{

        
        $data = array(
                    'status'			    =>  'pass',
                    'renja_id'              =>  $renja_id,
                    'list_bawahan'          =>  $list_bawahan,
                    //'list_kegiatan'         =>  $kegiatan_list,
                    'jabatan_id'            => $skp_bulanan->PejabatYangDinilai->id_jabatan,
                    'pegawai_id'            =>  $skp_bulanan->pegawai_id,
                    'skp_bulanan_id'        =>  $skp_bulanan->skp_bulanan_id,
                    'periode_label'			=>  Pustaka::bulan($skp_bulanan->bulan),
                    'tgl_mulai'			    =>  Pustaka::tgl_form($skp_bulanan->tgl_mulai),
                    'tgl_selesai'			=>  Pustaka::tgl_form($skp_bulanan->tgl_selesai),
                    'jm_kegiatan_bulanan'	=>  $jm_kegiatan,

                    'renja_id'	            =>  $skp_bulanan->SKPTahunan->Renja->id,
                    'waktu_pelaksanaan'	    =>  $skp_bulanan->bulan,

                   
                    'u_jabatan_id'	        => $u_detail->id,
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
                    'p_nip'	                => "",
                    'p_nama'                => "",
                    'p_pangkat'	            => "",
                    'p_golongan'	        => "",
                    'p_eselon'	            => "",
                    'p_jabatan'	            => "",
                    'p_unit_kerja'	        => "",
                    'p_skpd'	            => "",
                    
                    );
        }

        return $data;



         
    }


    public function CapaianBulananStatusPengisian( Request $request )
    {
       
        $capaian_id = $request->capaian_bulanan_id;

        $capaian_bulanan = CapaianBulanan::

                            leftjoin('db_pare_2018.penilaian_kode_etik AS pke', function($join){
                                $join   ->on('pke.capaian_bulanan_id','=','capaian_bulanan.id');
                            })
                            
                            ->SELECT(
                                'capaian_bulanan.id AS capaian_bulanan_id',
                                'capaian_bulanan.skp_bulanan_id',
                                'capaian_bulanan.created_at',
                                'capaian_bulanan.status_approve',
                                'capaian_bulanan.send_to_atasan',
                                'capaian_bulanan.alasan_penolakan',
                                'capaian_bulanan.p_jabatan_id',
                                'capaian_bulanan.u_jabatan_id',
                                'pke.id AS penilaian_kode_etik_id',
                                'pke.santun',
                                'pke.amanah',
                                'pke.harmonis',
                                'pke.adaptif',
                                'pke.terbuka',
                                'pke.efektif'
                            )
                            ->where('capaian_bulanan.id','=', $capaian_id )->first();
    
        $bulan = $capaian_bulanan->SKPBulanan->bulan;
        $p_detail   = $capaian_bulanan->PejabatPenilai;
        $u_detail   = $capaian_bulanan->PejabatYangDinilai;
        //STATUS APPROVE
        if ( ($capaian_bulanan->status_approve) == 1 ){ 
            $persetujuan_atasan = 'disetujui';
            $alasan_penolakan   = "";
        }else if ( ($capaian_bulanan->status_approve) == 2 ){
            $persetujuan_atasan = '<span class="text-danger">ditolak</span>';
            $alasan_penolakan   = $capaian_bulanan->alasan_penolakan;
        }else{
            $persetujuan_atasan = 'Menunggu Persetujuan';
            $alasan_penolakan   = "";
        }


        //HITUNG CAPAIAN KINERJA
        $data_kinerja               = $this->hitung_capaian($capaian_id); 

        //return $data_kinerja;

        $jm_capaian                         = $data_kinerja['jm_capaian'];
        $jm_kegiatan_bulanan                = $data_kinerja['jm_kegiatan_bulanan'];
        $jm_uraian_tugas_tambahan           = $data_kinerja['jm_uraian_tugas_tambahan'];
        $jm_capaian_uraian_tugas_tambahan   = $data_kinerja['jm_capaian_uraian_tugas_tambahan'];

        $jm_kegiatan_skp                    = $jm_kegiatan_bulanan + $jm_uraian_tugas_tambahan;
        $jm_capaian_kegiatan_skp            = $jm_capaian + $jm_capaian_uraian_tugas_tambahan;


        $capaian_kinerja_bulanan  = Pustaka::persen2($jm_capaian_kegiatan_skp,$jm_kegiatan_skp);


        //HITUNG PENILAIAN KODE ETIK
        if ( ($capaian_bulanan->penilaian_kode_etik_id) >= 1 ){
            $jm = ($capaian_bulanan->santun + $capaian_bulanan->amanah + $capaian_bulanan->harmonis+$capaian_bulanan->adaptif+$capaian_bulanan->terbuka+$capaian_bulanan->efektif);
           
            $penilaian_kode_etik = Pustaka::persen($jm,30) ;
            $capaian_skp_bulanan = number_format( ($capaian_kinerja_bulanan * 70 / 100)+( $penilaian_kode_etik * 30 / 100 ) , 2 );
        }else{
            $penilaian_kode_etik = 0 ;
            $capaian_skp_bulanan = 0 ;
        } 
        
        


        $response = array(
                
                'jm_kegiatan_bulanan'       => $jm_kegiatan_bulanan,
                'jm_uraian_tugas_tambahan'  => $jm_uraian_tugas_tambahan,
                'capaian_kinerja_bulanan'   => $capaian_kinerja_bulanan,
                'capaian_skp_bulanan'       => Pustaka::persen_bulat($capaian_skp_bulanan).' %',
                'penilaian_kode_etik_id'    => $capaian_bulanan->penilaian_kode_etik_id,
                'penilaian_kode_etik'       => $penilaian_kode_etik,
                'status_approve'            => $persetujuan_atasan,
                'send_to_atasan'            => $capaian_bulanan->send_to_atasan,
                'alasan_penolakan'          => $alasan_penolakan,
                'skp_bulanan_id'            => $capaian_bulanan->skp_bulanan_id,
                'bulan'                     => $bulan,
                'tgl_dibuat'                => Pustaka::balik2($capaian_bulanan->created_at),
                'p_nama'                    => isset($p_detail->Pegawai)?Pustaka::nama_pegawai($p_detail->Pegawai->gelardpn , $p_detail->Pegawai->nama , $p_detail->Pegawai->gelarblk) : "",
                'u_nama'                    => Pustaka::nama_pegawai($u_detail->Pegawai->gelardpn , $u_detail->Pegawai->nama , $u_detail->Pegawai->gelarblk),
                'santun'                    => $capaian_bulanan->santun*20,
                'amanah'                    => $capaian_bulanan->amanah*20,
                'harmonis'                  => $capaian_bulanan->harmonis*20,
                'adaptif'                   => $capaian_bulanan->adaptif*20,
                'terbuka'                   => $capaian_bulanan->terbuka*20,
                'efektif'                   => $capaian_bulanan->efektif*20,



        );
       
        return $response; 


    }



    public function Store(Request $request)
	{
        $messages = [
                 'pegawai_id.required'                   => 'Harus diisi',
                 'skp_bulanan_id.required'               => 'Harus diisi',
                 'tgl_mulai.required'                    => 'Harus diisi',
                 'tgl_selesai.required'                  => 'Harus diisi',
                 'u_nama.required'                       => 'Harus diisi',
                 'jenis_jabatan.required'                => 'Harus diisi',
                 'jabatan_id.required'                   => 'Harus diisi',
                 'u_jabatan_id.required'                 => 'Harus diisi',
                 'jm_kegiatan_bulanan'                   => 'Harus Lebih dari nol'

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'pegawai_id'            => 'required',
                            'skp_bulanan_id'        => 'required',
                            'tgl_mulai'             => 'required',
                            'tgl_selesai'           => 'required',
                            'u_nama'                => 'required',
                            'u_jabatan_id'          => 'required',
                            'jenis_jabatan'         => 'required',
                            'jabatan_id'            => 'required',
                            'jm_kegiatan_bulanan'   => 'required|integer|min:1'
                        ),
                        $messages
        );
    
        if ( $validator->fails() ){
            //$messages = $validator->messages();
                    return response()->json(['errors'=>$validator->messages()],422);
            
        }

        if ( (Pustaka::tgl_sql(Input::get('tgl_mulai'))) >= (Pustaka::tgl_sql(Input::get('tgl_selesai'))) ){
            $pesan =  ['masa_penilaian'  => 'Error'] ;
            return response()->json(['errors'=> $pesan ],422);
            
        }


        $cek = CapaianBulanan::WHERE('pegawai_id',Input::get('pegawai_id'))
                                ->WHERE('skp_bulanan_id',Input::get('skp_bulanan_id'))
                                ->SELECT('id')
                                ->count();

        if ( $cek == 0 ){
            $capaian_bulanan    = new CapaianBulanan;
            $capaian_bulanan->pegawai_id                  = Input::get('pegawai_id');
            $capaian_bulanan->skp_bulanan_id              = Input::get('skp_bulanan_id');
            $capaian_bulanan->u_nama                      = Input::get('u_nama');
            $capaian_bulanan->u_jabatan_id                = Input::get('u_jabatan_id');
            $capaian_bulanan->p_nama                      = Input::get('p_nama');
            $capaian_bulanan->p_jabatan_id                = Input::get('p_jabatan_id');
            $capaian_bulanan->tgl_mulai                   = Pustaka::tgl_sql(Input::get('tgl_mulai'));
            $capaian_bulanan->tgl_selesai                 = Pustaka::tgl_sql(Input::get('tgl_selesai'));
            
    
            
    
            if ( $capaian_bulanan->save()){
               
                // jabatn ID
                $id_jabatan_sekda       = json_decode($this->jenis_PJabatan('sekda'));
                $id_jabatan_irban       = json_decode($this->jenis_PJabatan('irban'));
                $id_jabatan_lurah       = json_decode($this->jenis_PJabatan('lurah'));
                $id_jabatan_staf_ahli   = json_decode($this->jenis_PJabatan('jabatan_staf_ahli'));

                //bikin jadi colse skp bulanan nya
                SKPBulanan::WHERE('id',Input::get('skp_bulanan_id'))->UPDATE(['status' => '1']);

                
                //cari jenis jabatan
                //JENIS JABATAN STAF AHLI
                if ( ( Input::get('jenis_jabatan') == 1 ) & ( in_array( Input::get('jabatan_id'), $id_jabatan_staf_ahli) ) ){
                    $jenis_jabatan = 5 ; //staf ahli sebagai JFT
                }

                 //jika irban ,kapus dll , walopun eslon 3, danggap sbg eselon 4
                if ( ( Input::get('jenis_jabatan') == 2 ) & ( in_array( Input::get('jabatan_id') , $id_jabatan_irban ) ) ){
                    $jenis_jabatan = 31 ; //irban
                }

                //lurah
                else if ( ( Input::get('jenis_jabatan') == 3 ) & ( in_array( Input::get('jabatan_id'), $id_jabatan_lurah ) ) ){
                    $jenis_jabatan = 2 ; //lurah
                }else{
                    $jenis_jabatan = Input::get('jenis_jabatan');
                }







                //jika kabid atau lurah, auto add kegiatan
                if ( $jenis_jabatan == '2'){
                    $bawahan_ls = Jabatan::SELECT('id')->WHERE('parent_id',Input::get('jabatan_id'))->get(); //->toArray();


                    //cari bawahan  , jabatanpelaksanan
                    $pelaksana_list = Jabatan::SELECT('id')->WHEREIN('parent_id', $bawahan_ls)->get(); //->toArray(); 

                    //ada beberapa eselon 4 yang melaksanakan kegiatan sendiri, kasus kasi dan lurah nagasari 23/0/2020
                    //sehingga dicoba untuk kegiatan bawahan nya juga diikutsertakan
                    //mengantisipasi kegiatan eseon 4 nya dilaksakan oleh sendiri
                    $pelaksana_list = $pelaksana_list->merge($bawahan_ls);


        
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
                            'capaian_id'            => $capaian_bulanan->id,
                            'realisasi'             => $x->realisasi,
                            'satuan'                => $x->satuan,
                            'created_at'            => date('Y'."-".'m'."-".'d'." ".'H'.":".'i'.":".'s'),
                        );
                        $i++;
                    }
                            
                    if ( $i >= 1 ){
                        $st_ra   = new RealisasiRencanaAksiEselon3;
                        $st_ra -> insert($data);
                    }
                }else if ( $jenis_jabatan == '1'){ //jenis jabatajn eselon 2

                    
                    $jenis_jabatan  = Input::get('jenis_jabatan');
                    $jabatan_id     = Input::get('jabatan_id');
                    $renja_id       = Input::get('renja_id');
                    $bulan          = Input::get('waktu_pelaksanaan');
                    //BAwahan langsung
                    $bawahan = $this->BawahanListCapaianBulanan($jabatan_id,$jenis_jabatan); 

                    //return \Response::make($bawahan, 500);
                    $i = 0 ;
                    foreach ($bawahan as $x) {
                        $jabatan_id = $x->jabatan_id;
                        $data = SKPTahunan::WHERE('skp_tahunan.renja_id',$renja_id)
                                        
                                            ->join('demo_asn.tb_history_jabatan AS jabatan', function($join) use($jabatan_id){
                                                $join   ->ON('jabatan.id','=','skp_tahunan.u_jabatan_id');
                                                $join   ->WHERE('jabatan.id_jabatan','=',$jabatan_id);
                                            })
                                            ->join('db_pare_2018.skp_bulanan AS skp_bulanan', function($join) use($bulan){
                                                $join   ->ON('skp_tahunan.id','=','skp_bulanan.skp_tahunan_id');
                                                $join   ->WHERE('skp_bulanan.bulan','=',$bulan);
                                            }) 
                                            ->join('db_pare_2018.capaian_bulanan AS capaian_bulanan', function($join) use($bulan){
                                                $join   ->ON('capaian_bulanan.skp_bulanan_id','=','skp_bulanan.id');
                                                $join   ->WHERE('skp_bulanan.bulan','=',$bulan);
                                            }) 
                                            ->SELECT(   'jabatan.id_jabatan AS jabatan_id',
                                                        'skp_tahunan.id AS skp_tahunan_id',
                                                        'skp_bulanan.id AS skp_bulanan_id',
                                                        'skp_bulanan.bulan AS skp_bulanan_bulan',
                                                        'capaian_bulanan.id AS capaian_id'
                                                    )
                                            ->first();
                        if ( $data != null ){

                            //ADA bawahan esl 2 yang esel nya esel 3 namun berperan jadi esl 4,
                            //jadi capaian nya ada di capaian esl 4
                            if ( in_array( $jabatan_id, $id_jabatan_irban ) ){
                                $dt_reaksi      = RealisasiRencanaAksiEselon4::WHERE('capaian_id',$data->capaian_id)
                                                                            ->SELECT(   'realisasi_rencana_aksi_kasubid.rencana_aksi_id AS rencana_aksi_id',
                                                                                        'realisasi_rencana_aksi_kasubid.realisasi',
                                                                                        'realisasi_rencana_aksi_kasubid.satuan'
                                                                            )
                                                                            ->get();
                            }else{
                                //eselon3
                                $dt_reaksi      = RealisasiRencanaAksiEselon3::WHERE('capaian_id',$data->capaian_id)
                                                                            ->SELECT(   'realisasi_rencana_aksi_kabid.rencana_aksi_id AS rencana_aksi_id',
                                                                                        'realisasi_rencana_aksi_kabid.realisasi',
                                                                                        'realisasi_rencana_aksi_kabid.satuan'
                                                                            )
                                                                            ->get();
                                
                            }
                           
                            //$dt_reaksi = $dt_reaksi_2->merge($dt_reaksi_1);
                            //$dt_reaksi = $dt_reaksi_1->unionAll($dt_reaksi_2)->get();
                            
                            foreach ($dt_reaksi as $y) {
                                $data_realisasi[] = array(
                                                
                                    
                                    'capaian_id'            => $capaian_bulanan->id,
                                    'rencana_aksi_id'       => $y->rencana_aksi_id,
                                    'realisasi'             => $y->realisasi,
                                    'satuan'                => $y->satuan
                                );
                                $i++;
                            }
                            
                            
                        } 
                       

                    }  
                    if ( $i >= 1 ){
                        $st_ra   = new RealisasiRencanaAksiKaban;
                        $st_ra -> insert($data_realisasi);
                    }    
                    
                
                }
                
                return \Response::make($capaian_bulanan->id, 200);
            }else{
                return \Response::make('error', 500);
            } 

        //IF CEK SUDAH ADA CAPAIAN NYA
        }else{
            return \Response::make('Capaian untuk SKP ini sudah ada :'. $cek, 500);
        } 

    }   

    public function PejabatPenilaiUpdate(Request $request)
	{
        $messages = [
            'pejabat_penilai_id.required'           => 'Harus set Pegawai ID',
            'capaian_bulanan_id.required'           => 'Harus diisi',

        ];

        $validator = Validator::make(
            Input::all(),
            array(
                'pejabat_penilai_id'    => 'required',
                'capaian_bulanan_id'    => 'required',
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



        
       

        $capaian_bulanan    = CapaianBulanan::find($request->get('capaian_bulanan_id'));
        if (is_null($capaian_bulanan)) {
            return $this->sendError('Capaian Bulanan tidak ditemukan tidak ditemukan.');
        }

        
        $capaian_bulanan->p_jabatan_id    = $p_jabatan_id;
        $capaian_bulanan->p_golongan_id    = $p_golongan_id;
        $capaian_bulanan->p_nama          = Pustaka::nama_pegawai($pegawai->gelardpn , $pegawai->nama , $pegawai->gelarblk);
   
        
        $item = array(
           
            "p_nip"			=> $pegawai->nip,
            "p_nama"		=> Pustaka::nama_pegawai($pegawai->gelardpn , $pegawai->nama , $pegawai->gelarblk),
            "p_pangkat"	    => $pegawai->JabatanAktif->golongan?$pegawai->JabatanAktif->golongan->pangkat:'',
            "p_golongan"	=> $pegawai->JabatanAktif->golongan?$pegawai->JabatanAktif->golongan->golongan:'',
            "p_eselon"		=> $pegawai->JabatanAktif->Eselon?$pegawai->JabatanAktif->Eselon->eselon:'',
            "p_jabatan"		=> Pustaka::capital_string($pegawai->JabatanAktif->Jabatan?$pegawai->JabatanAktif->Jabatan->skpd:''),
            "p_unit_kerja"	=> Pustaka::capital_string($pegawai->JabatanAktif->Skpd?$pegawai->JabatanAktif->Skpd->skpd:''),
            );


        
        if (  $capaian_bulanan->save() ){
            return \Response::make(  $item , 200);


        }else{
            return \Response::make('error', 500);
        } 

    }

    public function SendToAtasan(Request $request)
    {
        $messages = [
                'capaian_bulanan_id.required'   => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'capaian_bulanan_id'   => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $capaian    = CapaianBulanan::find(Input::get('capaian_bulanan_id'));
        if (is_null($capaian)) {
            return $this->sendError('ID capaian bulanan tidak ditemukan.');
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
                'capaian_bulanan_id.required'   => 'Harus diisi',
                'alasan.required'               => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'capaian_bulanan_id'   => 'required',
                            'alasan'               => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $capaian    = CapaianBulanan::find(Input::get('capaian_bulanan_id'));
        if (is_null($capaian)) {
            return $this->sendError('ID capaian bulanan tidak ditemukan.');
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
                'capaian_bulanan_id.required'   => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'capaian_bulanan_id'   => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $capaian    = CapaianBulanan::find(Input::get('capaian_bulanan_id'));
        if (is_null($capaian)) {
            return $this->sendError('ID capaian bulanan tidak ditemukan.');
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
       
        $dt = CapaianBulanan::
                    leftjoin('demo_asn.tb_history_jabatan AS a', function($join){
                        $join   ->on('a.id','=','capaian_bulanan.u_jabatan_id');
                    }) 
                    //jabatan
                    ->leftjoin('demo_asn.m_skpd AS jabatan', function($join){
                                $join   ->on('jabatan.id','=','a.id_jabatan');
                    })  
                    //eselon
                    ->leftjoin('demo_asn.m_eselon AS eselon', function($join){
                                $join   ->on('eselon.id','=','jabatan.id_eselon');
                    })  
                    ->SELECT( 
                             'capaian_bulanan.id AS capaian_bulanan_id',
                             'capaian_bulanan.u_nama',
                             'a.nip AS nip',
                             'capaian_bulanan.skp_bulanan_id',
                             'capaian_bulanan.u_jabatan_id',
                             'capaian_bulanan.tgl_mulai',
                             'capaian_bulanan.status_approve',
                             'eselon.eselon AS eselon',
                             'jabatan.skpd AS jabatan'
                            )
                    ->WHEREIN('capaian_bulanan.p_jabatan_id',$jabatan_id)
                    ->WHERE('capaian_bulanan.send_to_atasan','=','1');


    
        $datatables = Datatables::of($dt)
        ->addColumn('periode', function ($x) {
            return Pustaka::periode($x->tgl_mulai);
        })->addColumn('nama', function ($x) {
            return $x->u_nama;
        })->addColumn('jabatan', function ($x) {
            return Pustaka::capital_string($x->jabatan);
        })->addColumn('capaian_bulanan_id', function ($x) {
            return $x->capaian_bulanan_id;
        });

        
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true);
        
    }

    public function Destroy(Request $request)
    {

        $messages = [
                'capaian_bulanan_id.required'   => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'capaian_bulanan_id'   => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $st_kt    = CapaianBulanan::find(Input::get('capaian_bulanan_id'));
        if (is_null($st_kt)) {
            //return $this->sendError('Kegiatan Bulanan tidak ditemukan.');
            return response()->json('Capaian Bulanan tidak ditemukan',422);
        }


        if ( $st_kt->delete()){

            SKPBulanan::WHERE('id',$st_kt->skp_bulanan_id)->UPDATE(['status' => '0']);
            //cari jumlah skp
            $data_1       = CapaianTahunan::WHERE('pegawai_id',$st_kt->pegawai_id)->count();
            $data_2       = CapaianBulanan::WHERE('pegawai_id',$st_kt->pegawai_id)->count();
            $data_3       = CapaianTriwulan::WHERE('pegawai_id',$st_kt->pegawai_id)->count();
             
            


            return \Response::make(['skp_bulanan_id'        => $st_kt->skp_bulanan_id, 
                                    'jm_capaian_tahunan'    => $data_1,
                                    'jm_capaian_bulanan'    => $data_2,
                                    'jm_capaian_triwulan'   => $data_3,
                                
                                    
                                ], 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }
   

}
