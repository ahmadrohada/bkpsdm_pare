<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Periode;
use App\Models\PerjanjianKinerja;
use App\Models\SKPTahunan;
use App\Models\SKPBulanan;
use App\Models\CapaianBulanan;
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

class CapaianBulananAPIController extends Controller {

  
    protected function CapaianBulananDetail(Request $request){
     

        $capaian = CapaianBulanan::WHERE('capaian_bulanan.id',$request->capaian_bulanan_id)->first();

    
        $p_detail   = $capaian->PejabatPenilai;
        $u_detail   = $capaian->PejabatYangDinilai;
       

        if ( $p_detail != null ){
            $data = array(
                    'periode'	            => $capaian->SKPBulanan->SKPTahunan->Renja->Periode->label,
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

    public function PersonalCapaianBulananList(Request $request)
    {
        $skp = SKPBulanan::
                        leftjoin('db_pare_2018.capaian_bulanan', function($join){
                            $join   ->on('capaian_bulanan.skp_bulanan_id','=','skp_bulanan.id');
                        })
                        ->WHERE('skp_bulanan.pegawai_id',$request->pegawai_id)
                        ->select(
                                'skp_bulanan.id AS skp_bulanan_id',
                                'skp_bulanan.skp_tahunan_id',
                                'skp_bulanan.bulan',
                                'skp_bulanan.tgl_mulai',
                                'skp_bulanan.tgl_selesai',
                                'skp_bulanan.u_jabatan_id',
                                'skp_bulanan.status AS skp_bulanan_status',
                                'capaian_bulanan.id AS capaian_id',
                                'capaian_bulanan.status_approve AS capaian_status_approve',
                                'capaian_bulanan.send_to_atasan AS capaian_send_to_atasan'

            
                         )
                       // ->orderBy('bulan','ASC')
                        ->get();

       
           $datatables = Datatables::of($skp)
             ->addColumn('periode', function ($x) {
                return  $x->SKPTahunan->Renja->Periode->label;
            }) 
            ->addColumn('bulan', function ($x) {
                return Pustaka::bulan($x->bulan);
            }) 
            ->addColumn('pelaksanaan', function ($x) {
                $masa_penilaian = Pustaka::balik($x->tgl_mulai). ' s.d ' . Pustaka::balik($x->tgl_selesai);
                return   $masa_penilaian;
            }) 
            ->addColumn('jabatan', function ($x) {
                
                return   Pustaka::capital_string($x->PejabatYangDinilai->Jabatan->skpd);
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

        $jenis_jabatan = $skp_bulanan->PejabatYangDinilai->Eselon->id_jenis_jabatan;


        $renja_id = $skp_bulanan->SKPTahunan->renja_id;
        //$kegiatan_tahunan = KegiatanSKPTahunan::WHERE('skp_tahunan_id',$skp_bulanan->skp_tahunan_id)->get()->toArray();


        //================================= PELAKSANA ===========================================//
        if ( $jenis_jabatan == 4 ){
            $jm_kegiatan = KegiatanSKPBulanan::WHERE('skp_bulanan_id','=',$request->get('skp_bulanan_id'))->count();
       
            $list_bawahan = "";
            $kegiatan_list = "";
        //================================= K A S U B I D ========================================// 
        }else if ( $jenis_jabatan == 3){
            //cari bawahan
            $bawahan = Jabatan::SELECT('id','skpd AS jabatan')->WHERE('parent_id',$skp_bulanan->PejabatYangDinilai->id_jabatan )->get();

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

                $data_jabatan_id['jabatan']           = Pustaka::capital_string($x->jabatan);
                $data_jabatan_id['jm_keg']            = $dt_reaksi;
                $data_jabatan_id['jm_realisasi']      = $jm_realisasi;



                $pelaksana_list[] = $data_jabatan_id ;
                $jm_kegiatan += $dt_reaksi;
            }
            $list_bawahan  = $pelaksana_list;                            
            $kegiatan_list = "";
        //================================= K A B I D ========================================// 
        }else if ( $jenis_jabatan == 2){

            //cari bawahan
            $bawahan = Jabatan::SELECT('id','skpd AS jabatan' )->WHERE('parent_id',$skp_bulanan->PejabatYangDinilai->id_jabatan )->get();

            $bawahan_ls = Jabatan::SELECT('id')->WHERE('parent_id',$skp_bulanan->PejabatYangDinilai->id_jabatan )->get()->toArray();
            //cari bawahan  , jabatanpelaksanan
            $pelaksana_list = Jabatan::
                                SELECT('id')
                                ->WHEREIN('parent_id', $bawahan_ls)
                                ->get()
                                ->toArray(); 

            $kegiatan_list = RencanaAksi::
                                        WHEREIN('jabatan_id',$pelaksana_list)
                                        ->SELECT('id')
                                        ->WHERE('waktu_pelaksanaan',$skp_bulanan->bulan)
                                        ->WHERE('renja_id',$renja_id)
                                        ->get(); 

          
           

            //list bawahan
            $jm_kegiatan = 0 ; 
            foreach ($bawahan as $x) {
                //list pelaksana
                $child = Jabatan::SELECT('id')->WHERE('parent_id',$x->id )->get()->toArray();
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
                $jm_realisasi   = RealisasiRencanaAksiKasubid::WHEREIN('rencana_aksi_id',$ls_reaksi)->count();

                $data_jabatan_id['jabatan']         = Pustaka::capital_string($x->jabatan);
                $data_jabatan_id['jm_keg']          = $dt_reaksi;
                $data_jabatan_id['jm_realisasi']    = $jm_realisasi;



                $kasubid_list[] = $data_jabatan_id ;
                $jm_kegiatan += $dt_reaksi;
            }
            $list_bawahan = $kasubid_list;
            $kegiatan_list = $kegiatan_list;
            
        
        //===================================================================================// 
        }else{
            $jm_kegiatan = 0 ;
        }
        //
        
        
        //DETAIL data pribadi dan atasan
        $u_detail = HistoryJabatan::WHERE('id',$skp_bulanan->u_jabatan_id)->first();
        $p_detail = HistoryJabatan::WHERE('id',$skp_bulanan->p_jabatan_id)->first();


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

        return $data;



         
    }


    public function CapaianBulananStatusPengisian( Request $request )
    {
       
        
        $button_kirim = 0 ;
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
    
        $jenis_jabatan = $capaian_bulanan->PejabatYangDinilai->Eselon->id_jenis_jabatan;
        $bulan = $capaian_bulanan->SKPBulanan->bulan;

        //jm kegiatan pelaksana
        if ( $jenis_jabatan == 4 ){
            
            //hitung capaian kinerja bulanan
            $xdata = KegiatanSKPBulanan::
                                        leftjoin('db_pare_2018.realisasi_kegiatan_bulanan AS realisasi', function($join) use($capaian_id){
                                            $join   ->on('realisasi.kegiatan_bulanan_id','=','skp_bulanan_kegiatan.id');
                                            $join   ->where('realisasi.capaian_id','=',$capaian_id);
                                        })
                                        ->SELECT('skp_bulanan_kegiatan.target','realisasi.realisasi')
                                        ->WHERE('skp_bulanan_kegiatan.skp_bulanan_id','=',$capaian_bulanan->skp_bulanan_id)
                                        ->get();
            $capaian_kinerja_bulanan = 0 ;
            $jm_kegiatan_bulanan = 0 ;

            foreach ($xdata as $data) {
                $jm_kegiatan_bulanan ++;

                $capaian_kinerja_bulanan += Pustaka::persen($data->realisasi,$data->target);

            }

            $capaian_kinerja_bulanan =  Pustaka::persen2($capaian_kinerja_bulanan,$jm_kegiatan_bulanan);
       
       
       
        }else if ( $jenis_jabatan == 3){  //kasubid
            //cari bawahan
            $child = Jabatan::SELECT('id')->WHERE('parent_id',$capaian_bulanan->PejabatYangDinilai->id_jabatan )->get()->toArray(); 
           
            //hitung capaian kinerja bulanan
            $xdata = RencanaAksi::
                        leftjoin('db_pare_2018.skp_tahunan_kegiatan AS kegiatan', function($join){
                            $join   ->on('skp_tahunan_rencana_aksi.kegiatan_tahunan_id','=','kegiatan.id');
                        })
                        ->leftjoin('db_pare_2018.realisasi_rencana_aksi_kasubid AS realisasi', function($join) use($capaian_id){
                            $join   ->on('realisasi.rencana_aksi_id','=','skp_tahunan_rencana_aksi.id');
                            $join   ->where('realisasi.capaian_id','=',$capaian_id);
                        })
                        ->SELECT('skp_tahunan_rencana_aksi.target','realisasi.realisasi')
                        ->WHEREIN('skp_tahunan_rencana_aksi.jabatan_id',$child)
                        ->WHERE('skp_tahunan_rencana_aksi.waktu_pelaksanaan', $bulan)
                        ->get();

            $capaian_kinerja_bulanan = 0 ;
            $jm_kegiatan_bulanan = 0 ;

            foreach ($xdata as $data) {
            $jm_kegiatan_bulanan ++;

            $capaian_kinerja_bulanan += Pustaka::persen($data->realisasi,$data->target);

            }

            $capaian_kinerja_bulanan =  Pustaka::persen2($capaian_kinerja_bulanan,$jm_kegiatan_bulanan);
        
        
        
        
        }else if ( $jenis_jabatan == 2){ //kabid
            //cari bawahan bawahan nya

            $pelaksana_id = Jabatan::
                        leftjoin('demo_asn.m_skpd AS pelaksana', function($join){
                            $join   ->on('pelaksana.parent_id','=','m_skpd.id');
                        })
                        ->SELECT('pelaksana.id')
                        ->WHERE('m_skpd.parent_id', $capaian_bulanan->PejabatYangDinilai->id_jabatan )
                        ->get()
                        ->toArray();  
            //jm kegiatan kabid   
            //$jm_kegiatan_bulanan = RencanaAksi::WHEREIN('jabatan_id',$pelaksana_id)->WHERE('waktu_pelaksanaan', $bulan)->count();
       
            //hitung capaian kinerja bulanan
            $xdata = RencanaAksi::
                        leftjoin('db_pare_2018.skp_tahunan_kegiatan AS kegiatan', function($join){
                            $join   ->on('skp_tahunan_rencana_aksi.kegiatan_tahunan_id','=','kegiatan.id');
                        })
                        ->leftjoin('db_pare_2018.realisasi_rencana_aksi_kabid AS realisasi', function($join) use($capaian_id){
                            $join   ->on('realisasi.rencana_aksi_id','=','skp_tahunan_rencana_aksi.id');
                            $join   ->where('realisasi.capaian_id','=',$capaian_id);
                        })
                        ->SELECT('skp_tahunan_rencana_aksi.target','realisasi.realisasi')
                        ->WHEREIN('skp_tahunan_rencana_aksi.jabatan_id',$pelaksana_id)
                        ->WHERE('skp_tahunan_rencana_aksi.waktu_pelaksanaan', $bulan)
                        ->get();

            $capaian_kinerja_bulanan = 0 ;
            $jm_kegiatan_bulanan = 0 ;

            foreach ($xdata as $data) {
            $jm_kegiatan_bulanan ++;

            $capaian_kinerja_bulanan += Pustaka::persen($data->realisasi,$data->target);

            }

            $capaian_kinerja_bulanan =  Pustaka::persen2($capaian_kinerja_bulanan,$jm_kegiatan_bulanan);
        
        
        
       
       
        }else{
            $jm_kegiatan_bulanan = 000 ;
        }
                        

      
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


        //penilaian kode etik
        if ( ($capaian_bulanan->penilaian_kode_etik_id) >= 1 ){
            $jm = ($capaian_bulanan->santun + $capaian_bulanan->amanah + $capaian_bulanan->harmonis+$capaian_bulanan->adaptif+$capaian_bulanan->terbuka+$capaian_bulanan->efektif);
            
            
            
            $penilaian_kode_etik = Pustaka::persen($jm,30) ;

            $capaian_skp_bulanan = number_format( ($capaian_kinerja_bulanan * 70 / 100)+( $penilaian_kode_etik * 30 / 100 ) , 2 ).' %';
            
          
          

        }else{
            $penilaian_kode_etik = 0 ;
            $capaian_skp_bulanan = 0 ;
        }
        

        $response = array(
                
                'jm_kegiatan_bulanan'       => $jm_kegiatan_bulanan,
                'capaian_kinerja_bulanan'   => $capaian_kinerja_bulanan,
                'capaian_skp_bulanan'       => $capaian_skp_bulanan,
                'penilaian_kode_etik_id'    => $capaian_bulanan->penilaian_kode_etik_id,
                'penilaian_kode_etik'       => $penilaian_kode_etik,
                'status_approve'            => $persetujuan_atasan,
                'send_to_atasan'            => $capaian_bulanan->send_to_atasan,
                'alasan_penolakan'          => $alasan_penolakan,
                'skp_bulanan_id'            => $capaian_bulanan->skp_bulanan_id,
                'bulan'                     => $bulan,
                'tgl_dibuat'                => Pustaka::balik2($capaian_bulanan->created_at),
                'p_nama'                    => Pustaka::nama_pegawai($p_detail->Pegawai->gelardpn , $p_detail->Pegawai->nama , $p_detail->Pegawai->gelarblk),
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
                 'jenis_jabatan.required'              => 'Harus diisi',
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
                            'jenis_jabatan'       => 'required',
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
                //SKPTahunanTimeline::INSERT(['capaian_bulanan_id'=>$capaian_bulanan->id]);
                SKPBulanan::WHERE('id',Input::get('skp_bulanan_id'))->UPDATE(['status' => '1']);


                //jika kabid, auto add kegiatan
                $bawahan_ls = Jabatan::SELECT('id')->WHERE('parent_id',Input::get('jabatan_id'))->get()->toArray();
                //cari bawahan  , jabatanpelaksanan
                $pelaksana_list = Jabatan::SELECT('id')->WHEREIN('parent_id', $bawahan_ls)->get()->toArray(); 
    
                $kegiatan_list = RencanaAksi::WHEREIN('jabatan_id',$pelaksana_list)
                                            ->SELECT('id','target','satuan')
                                            ->WHERE('waktu_pelaksanaan',Input::get('waktu_pelaksanaan'))
                                            ->WHERE('renja_id',Input::get('renja_id'))
                                            ->get(); 
                $i = 0 ;
                foreach ($kegiatan_list as $x) {
                    $data[] = array(
                                    
                        'rencana_aksi_id'       => $x->id,
                        'capaian_id'            => $capaian_bulanan->id,
                        'realisasi'             => $x->target,
                        'satuan'                => $x->satuan,
                        'created_at'            => date('Y'."-".'m'."-".'d'." ".'H'.":".'i'.":".'s'),
                    );
                    $i++;
                }
                        
                if ( $i >= 1 ){
                    $st_ra   = new RealisasiRencanaAksiKabid;
                    $st_ra -> insert($data);
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


        
       

        $capaian_bulanan    = CapaianBulanan::find($request->get('capaian_bulanan_id'));
        if (is_null($capaian_bulanan)) {
            return $this->sendError('Capaian Bulanan tidak ditemukan tidak ditemukan.');
        }

        
        $capaian_bulanan->p_jabatan_id    = $p_jabatan_id;
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
                    WHEREIN('capaian_bulanan.p_jabatan_id',$jabatan_id)
                    ->WHERE('capaian_bulanan.send_to_atasan','=','1')
                    ->SELECT( 
                             'capaian_bulanan.id AS capaian_bulanan_id',
                             'capaian_bulanan.u_nama',
                             'capaian_bulanan.skp_bulanan_id',
                             'capaian_bulanan.u_jabatan_id',
                             'capaian_bulanan.tgl_mulai',
                             'capaian_bulanan.status_approve'
                            );


    
        $datatables = Datatables::of($dt)
        ->addColumn('periode', function ($x) {
            return Pustaka::periode($x->tgl_mulai);
        })->addColumn('nama', function ($x) {
            return $x->u_nama;
        })->addColumn('jabatan', function ($x) {
            return Pustaka::capital_string($x->PejabatYangDinilai->Jabatan->skpd);
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

            return \Response::make($st_kt->skp_bulanan_id, 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }
   

}
