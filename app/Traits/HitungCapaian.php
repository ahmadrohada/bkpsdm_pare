<?php

namespace App\Traits;

use App\Models\CapaianBulanan;
use App\Models\CapaianTahunan;
use App\Models\Jabatan;
use App\Models\RencanaAksi;
use App\Models\RealisasiRencanaAksiKaban;
use App\Models\Kegiatan;
use App\Models\KegiatanSKPBulanan;
use App\Models\KegiatanSKPTahunan;
use App\Models\KegiatanSKPTahunanJFT;
use App\Models\KegiatanSKPBulananJFT;
use App\Models\UraianTugasTambahan;
use App\Models\RealisasiKegiatanTahunan;
use App\Models\RealisasiKegiatanTahunanJFT;
use App\Models\TugasTambahan;
use App\Models\RealisasiTugasTambahan;
use App\Models\UnsurPenunjangTugasTambahan;
use App\Models\UnsurPenunjangKreativitas;

use App\Traits\HitungUnsurPenunjang; 

use App\Helpers\Pustaka;

trait HitungCapaian
{
    use HitungUnsurPenunjang;

    protected function capaian_kinerja_irban($capaian_id,$skp_bulanan_id,$bulan,$renja_id,$jabatan_id)
    {
        //cari bawahan
        //$child = Jabatan::SELECT('id')->WHERE('id',$jabatan_id )->get()->toArray();

        //IRBAN DAN KAPUS sama, dicoba dengan kgeitan bawahan dan egiatan yang dilaksanakan sendiri,
        //update 24/06/2020
        $child = Jabatan::SELECT('id')->WHERE('parent_id',  $jabatan_id  )->ORWHERE('id',  $jabatan_id )->get()->toArray(); 

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
            ->WHERE('skp_tahunan_rencana_aksi.renja_id', $renja_id)
            ->get();

        $jm_capaian = 0 ;
        $jm_kegiatan_bulanan = 0 ;

        foreach ($xdata as $data) {

            if ( $data->target > 0 ){
                $jm_kegiatan_bulanan ++;
                $jm_capaian += Pustaka::persen($data->realisasi,$data->target);
            }

           
        }

        return array(
            'jm_kegiatan_bulanan'       => $jm_kegiatan_bulanan,
            'jm_capaian'                => $jm_capaian,
        );
    }

    protected function capaian_kinerja_jft($capaian_id,$skp_bulanan_id,$bulan,$renja_id)
    {
        //hitung capaian kinerja bulanan
        $xdata = KegiatanSKPBulananJFT::
                            leftjoin('db_pare_2018.realisasi_kegiatan_bulanan_jft AS realisasi', function($join) use($capaian_id){
                                $join   ->on('realisasi.kegiatan_bulanan_id','=','skp_bulanan_kegiatan_jft.id');
                                $join   ->where('realisasi.capaian_id','=',$capaian_id);
                            })
                            ->SELECT('skp_bulanan_kegiatan_jft.target','realisasi.realisasi')
                            ->WHERE('skp_bulanan_kegiatan_jft.skp_bulanan_id','=',$skp_bulanan_id)
                            ->get();
        $jm_capaian = 0 ;
        $jm_kegiatan_bulanan = 0 ;

        foreach ($xdata as $data) {
            if ( $data->target > 0 ){
                $jm_kegiatan_bulanan ++;
                $jm_capaian += Pustaka::persen($data->realisasi,$data->target);
            }
            

        }

        return array(
            'jm_kegiatan_bulanan'       => $jm_kegiatan_bulanan,
            'jm_capaian'                => $jm_capaian,
        );
    }

    protected function capaian_kinerja_jfu($capaian_id,$skp_bulanan_id,$bulan,$renja_id)
    {
        $xdata = KegiatanSKPBulanan::
                            leftjoin('db_pare_2018.realisasi_kegiatan_bulanan AS realisasi', function($join) use($capaian_id){
                                $join   ->on('realisasi.kegiatan_bulanan_id','=','skp_bulanan_kegiatan.id');
                                $join   ->where('realisasi.capaian_id','=',$capaian_id);
                            })
                            ->SELECT('skp_bulanan_kegiatan.target','realisasi.realisasi')
                            ->WHERE('skp_bulanan_kegiatan.skp_bulanan_id','=',$skp_bulanan_id)
                            ->get();
        $jm_capaian = 0 ;
        $jm_kegiatan_bulanan = 0 ;

        foreach ($xdata as $data) {
            if ( $data->target > 0 ){
                $jm_kegiatan_bulanan ++;
                $jm_capaian += Pustaka::persen($data->realisasi,$data->target);
            }
        }

        return array(
            'jm_kegiatan_bulanan'       => $jm_kegiatan_bulanan,
            'jm_capaian'                => $jm_capaian,
        );

    }

    protected function capaian_kinerja_eselon4($capaian_id,$skp_bulanan_id,$bulan,$renja_id,$jabatan_id)
    {

        //ada kondisi tertentu misal KA UPTD dan KASUBAG TU nya,, dia atasan dan bawahan, namun keggiatan
        //KA UPTD tidak dapat dilaksanakan oleh KASUBAG nya karena sama sama eselon 4
        
        //Cari bawahan ( staff nya ), 
        $child = Jabatan::
                            WHERE('id',$jabatan_id )
                            ->orwhere(function ($query) use($jabatan_id) {
                                $query  ->where('parent_id',$jabatan_id )
                                        //->Where('id_eselon', '=', 9 )
                                        //->orWhere('id_eselon', '=', 10 );
                                        ->whereBetween('id_eselon', [9,10]);
                            })
                            ->SELECT('id')
                            ->get()
                            ->toArray(); 

        //hitung capaian kinerja bulanan
        $xdata = RencanaAksi::
            WITH(['IndikatorKegiatanSKPTahunan'])
                ->WhereHas('IndikatorKegiatanSKPTahunan', function($q){
            }) 
            ->leftjoin('db_pare_2018.skp_tahunan_kegiatan AS kegiatan', function($join){
                $join   ->on('skp_tahunan_rencana_aksi.kegiatan_tahunan_id','=','kegiatan.id');
            })
            ->leftjoin('db_pare_2018.realisasi_rencana_aksi_kasubid AS realisasi', function($join) use($capaian_id){
                $join   ->on('realisasi.rencana_aksi_id','=','skp_tahunan_rencana_aksi.id');
                $join   ->where('realisasi.capaian_id','=',$capaian_id);
            })
            ->SELECT('skp_tahunan_rencana_aksi.target','realisasi.realisasi')
            ->WHEREIN('skp_tahunan_rencana_aksi.jabatan_id',$child)
            ->WHERE('skp_tahunan_rencana_aksi.waktu_pelaksanaan', $bulan)
            ->WHERE('skp_tahunan_rencana_aksi.renja_id', $renja_id)
            ->get();

        $jm_capaian = 0 ;
        $jm_kegiatan_bulanan = 0 ;

        foreach ($xdata as $data) {
            if ( $data->target > 0 ){
                $jm_kegiatan_bulanan ++;
                $jm_capaian += Pustaka::persen($data->realisasi,$data->target);
            }
           
        }

        return array(
            'jm_kegiatan_bulanan'       => $jm_kegiatan_bulanan,
            'jm_capaian'                => $jm_capaian,
        );


    }

    

    protected function capaian_kinerja_eselon3($capaian_id,$skp_bulanan_id,$bulan,$renja_id,$jabatan_id)
    {
       //cari bawahan bawahan nya
       $pelaksana_id = Jabatan::
                                leftjoin('demo_asn.m_skpd AS pelaksana', function($join){
                                    $join   ->on('pelaksana.parent_id','=','m_skpd.id');
                                })
                                ->SELECT('pelaksana.id')
                                ->WHERE('m_skpd.parent_id', $jabatan_id )
                                ->get();
                                //->toArray();  
        //ada beberapa eselon 4 yang melaksanakan kegiatan sendiri, kasus kasi dan lurah nagasari 23/0/2020
        //sehingga dicoba untuk kegiatan bawahan nya juga diikutsertakan
        $penanggung_jawab_id = Jabatan::
                                        SELECT('m_skpd.id')
                                        ->WHERE('m_skpd.parent_id', $jabatan_id )
                                        ->get();
                                        //->toArray();
        $pelaksana_id = $pelaksana_id->merge($penanggung_jawab_id);   

            
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
                                ->WHERE('skp_tahunan_rencana_aksi.renja_id', $renja_id)
                                ->get();

        $jm_capaian = 0 ;
        $jm_kegiatan_bulanan = 0 ;

        foreach ($xdata as $data) {
            if ( $data->target > 0 ){
                $jm_kegiatan_bulanan ++;
                $jm_capaian += Pustaka::persen($data->realisasi,$data->target);
            }
            
        }

        return array(
            'jm_kegiatan_bulanan'       => $jm_kegiatan_bulanan,
            'jm_capaian'                => $jm_capaian,
        );
    }


    protected function capaian_kinerja_eselon2($capaian_id,$skp_bulanan_id,$bulan,$renja_id,$jabatan_id)
    {
    //cari bawahan bawahan nya
        //CARI KASUBID
        $child = Jabatan::
                            leftjoin('demo_asn.m_skpd AS kasubid', function($join){
                                $join   ->on('kasubid.parent_id','=','m_skpd.id');
                            })
                            ->SELECT('kasubid.id')
                            ->WHERE('m_skpd.parent_id',  $jabatan_id )
                            ->get()
                            ->toArray();

        //cari bawahan  , jabatanpelaksanan
        $pelaksana_id = Jabatan::
                            SELECT('m_skpd.id')
                            ->WHEREIN('m_skpd.parent_id', $child )
                            ->get()
                            ->toArray();  

        //hitung capaian kinerja bulanan
        /* $xdata = RencanaAksi::
                            leftjoin('db_pare_2018.skp_tahunan_kegiatan AS kegiatan', function($join){
                                $join   ->on('skp_tahunan_rencana_aksi.kegiatan_tahunan_id','=','kegiatan.id');
                            })
                            ->leftjoin('db_pare_2018.realisasi_rencana_aksi_kabid AS realisasi', function($join) use($capaian_id){
                                $join   ->on('realisasi.rencana_aksi_id','=','skp_tahunan_rencana_aksi.id');
                                //$join   ->where('realisasi.capaian_id','=',$capaian_id); //untuk eselon2 mah capain nya pake yang pelaksana aja
                            })
                            ->SELECT('skp_tahunan_rencana_aksi.target','realisasi.realisasi')
                            ->WHEREIN('skp_tahunan_rencana_aksi.jabatan_id',$pelaksana_id)
                            ->WHERE('skp_tahunan_rencana_aksi.waktu_pelaksanaan', $bulan)
                            ->WHERE('skp_tahunan_rencana_aksi.renja_id', $renja_id)
                            ->get(); */
        $xdata = RealisasiRencanaAksiKaban::
                            leftjoin('db_pare_2018.skp_tahunan_rencana_aksi AS rencana_aksi', function($join){
                                $join   ->on('rencana_aksi.id','=','realisasi_rencana_aksi_eselon2.rencana_aksi_id');
                            })
                            ->SELECT(   
                                        'realisasi_rencana_aksi_eselon2.realisasi AS realisasi',
                                        'rencana_aksi.target'

                            ) 
                           
                            ->WHERE('capaian_id',$capaian_id)
                            ->get();

        $jm_capaian = 0 ;
        $jm_kegiatan_bulanan = 0 ;

        foreach ($xdata as $data) {
            if ( $data->target > 0 ){
                $jm_kegiatan_bulanan ++;
                $jm_capaian += Pustaka::persen($data->realisasi,$data->target);
            }
            

        }

        return array(
            'jm_kegiatan_bulanan'       => $jm_kegiatan_bulanan,
            'jm_capaian'                => $jm_capaian,
        );
    }

    public function hitung_capaian($capaian_id){ 


        //jenisd jabatan
        $id_jabatan_sekda       = json_decode($this->jenis_PJabatan('sekda'));
        $id_jabatan_irban       = json_decode($this->jenis_PJabatan('irban'));
        $id_jabatan_lurah       = json_decode($this->jenis_PJabatan('lurah'));
        $id_jabatan_staf_ahli   = json_decode($this->jenis_PJabatan('staf_ahli'));


        $capaian_bulanan = CapaianBulanan::

                leftjoin('db_pare_2018.penilaian_kode_etik AS pke', function($join){
                    $join   ->on('pke.capaian_bulanan_id','=','capaian_bulanan.id');
                })
                ->leftjoin('demo_asn.tb_history_jabatan AS a', function($join){
                    $join   ->on('a.id','=','capaian_bulanan.u_jabatan_id');
                })
                ->leftjoin('demo_asn.m_skpd AS jabatan', function($join){
                    $join   ->on('jabatan.id','=','a.id_jabatan');
                })  
                //eselon
                ->leftjoin('demo_asn.m_eselon AS eselon', function($join){
                            $join   ->on('eselon.id','=','a.id_eselon');
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
                    'pke.efektif',
                    'eselon.id_jenis_jabatan AS id_jenis_jabatan'
                )
                ->where('capaian_bulanan.id','=', $capaian_id )->first();

                

        //$jenis_jabatan = $capaian_bulanan->PegawaiYangDinilai->Eselon->id_jenis_jabatan;
        $jenis_jabatan = $capaian_bulanan->id_jenis_jabatan;
        $bulan = $capaian_bulanan->SKPBulanan->bulan;
        $renja_id = $capaian_bulanan->SKPBulanan->SKPTahunan->renja_id;
        $skp_bulanan_id = $capaian_bulanan->skp_bulanan_id;
        $jabatan_id = ( $capaian_bulanan->PegawaiYangDinilai ) ? $capaian_bulanan->PegawaiYangDinilai->id_jabatan : 0 ;


        //Uraian Tugas Jabatan pada skp bulanan
        $jm_uraian_tugas_tambahan =  UraianTugasTambahan::WHERE('skp_bulanan_id',$skp_bulanan_id)->count();


        $cdata = UraianTugasTambahan::
                                    leftjoin('db_pare_2018.realisasi_uraian_tugas_tambahan AS realisasi', function($join) use($capaian_id){
                                        $join   ->on('realisasi.uraian_tugas_tambahan_id','=','uraian_tugas_tambahan.id');
                                        $join   ->where('realisasi.capaian_id','=',$capaian_id);
                                    })
                                    ->SELECT('uraian_tugas_tambahan.target','realisasi.realisasi')
                                    ->WHERE('uraian_tugas_tambahan.skp_bulanan_id','=',$skp_bulanan_id)
                                    ->get();

        $jm_capaian_uraian_tugas_tambahan = 0 ;
        $jm_uraian_tugas_tambahan = 0 ;

        foreach ($cdata as $data) {
            $jm_uraian_tugas_tambahan ++;
            $jm_capaian_uraian_tugas_tambahan += Pustaka::persen($data->realisasi,$data->target);
        }

        $data_2 = array(
                        'jm_uraian_tugas_tambahan'           => $jm_uraian_tugas_tambahan,
                        'jm_capaian_uraian_tugas_tambahan'   => $jm_capaian_uraian_tugas_tambahan,
                        );


        //JENIS JABATAN STAF AHLI
        if ( ( $jenis_jabatan == 1 ) & ( in_array( $jabatan_id, $id_jabatan_staf_ahli) ) ){
            $jenis_jabatan = 5 ; //staf ahli sebagai JFT
        }

        //JENIS JABATAN UNTUK IRBAN ** 
        if ( ( $jenis_jabatan == 2 ) & ( in_array( $jabatan_id, $id_jabatan_irban) ) ){
            $jenis_jabatan = 31 ; //irban
        }

        //jika Lurah
        if ( ( $jenis_jabatan == 3 ) & ( in_array( $jabatan_id, $id_jabatan_lurah ) ) ){
            $jenis_jabatan = 2 ; //lurah
        }


        if ( $jenis_jabatan == 31){  //IRBAN
            //CAPAIAN KINERJA UNTUK IRBAN
            $data = $this->capaian_kinerja_irban($capaian_id,$skp_bulanan_id,$bulan,$renja_id,$jabatan_id);
        }else if ( $jenis_jabatan == 5 ){//jm kegiatan JFT
            $data = $this->capaian_kinerja_jft($capaian_id,$skp_bulanan_id,$bulan,$renja_id);
        }else if ( $jenis_jabatan == 4 ){ //jm kegiatan pelaksana JFU
            $data = $this->capaian_kinerja_jfu($capaian_id,$skp_bulanan_id,$bulan,$renja_id);
        }else if ( $jenis_jabatan == 3 ){  //kasubid ESELON IV
            $data =  $this->capaian_kinerja_eselon4($capaian_id,$skp_bulanan_id,$bulan,$renja_id,$jabatan_id);
        }else if ( $jenis_jabatan == 2){ //kabid ESELON III
            $data =  $this->capaian_kinerja_eselon3($capaian_id,$skp_bulanan_id,$bulan,$renja_id,$jabatan_id);
        }else if ( $jenis_jabatan == 1){ //KABAN ESELON II
            $data =  $this->capaian_kinerja_eselon2($capaian_id,$skp_bulanan_id,$bulan,$renja_id,$jabatan_id);
        }else{
            $data = array(
                'jm_kegiatan_bulanan'       => 0,
                'jm_capaian'                => 0,
            ); 
        }

        
        return array_merge($data,$data_2);
    }

 
//==================================== CAPAIAN TAHUNAN AREA ===========================================================//
    protected function capaian_tahunan_jfu($capaian_id,$skp_tahunan_id,$renja_id,$jabatan_id)
    {

        //Jumlah kegiatan 
        $jm_kegiatan = RencanaAksi::WHERE('jabatan_id',$jabatan_id)
                            ->WHERE('renja_id',$renja_id)
                            ->leftjoin('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join){
                                $join  ->on('skp_tahunan_rencana_aksi.kegiatan_tahunan_id','=','kegiatan_tahunan.id');
                            })
                            ->distinct('kegiatan_tahunan.id')->count('kegiatan_tahunan.id');
        $jm_realisasi = RealisasiKegiatanTahunan::WHERE('capaian_id',$capaian_id)->count();

        //cari nilai_capaian Kegiatan tahunan
        $xdata = RealisasiKegiatanTahunan::WHERE('capaian_id',$capaian_id)->get();
       
        $jm_capaian_kegiatan_tahunan = 0 ;
        foreach ($xdata as $x) {

            if ( $x->hitung_cost <=0 ){
                $capaian_kegiatan_tahunan = ($x->hitung_quantity + $x->hitung_quality + $x->hitung_waktu +$x->hitung_cost )/3;
            }else{
                $capaian_kegiatan_tahunan = ($x->hitung_quantity + $x->hitung_quality + $x->hitung_waktu +$x->hitung_cost )/4;
            }

            $jm_capaian_kegiatan_tahunan =  $jm_capaian_kegiatan_tahunan + $capaian_kegiatan_tahunan;
        }

        return array(
            'jm_kegiatan_tahunan'           => $jm_kegiatan,
            'jm_capaian_kegiatan_tahunan'   => $jm_capaian_kegiatan_tahunan,
            'ave_capaian_kegiatan_tahunan'  => Pustaka::ave($jm_capaian_kegiatan_tahunan,$jm_kegiatan),
        );

    }

    protected function capaian_tahunan_jft($capaian_id,$skp_tahunan_id,$renja_id,$jabatan_id)
    {

        //Jumlah kegiatan 
        $jm_kegiatan = KegiatanSKPTahunanJFT::WHERE('skp_tahunan_id',$skp_tahunan_id)->count();
        $jm_realisasi = RealisasiKegiatanTahunanJFT::WHERE('capaian_id',$capaian_id)->count();

        //cari nilai_capaian Kegiatan tahunan
        $xdata = RealisasiKegiatanTahunanJFT::WHERE('capaian_id',$capaian_id)->get();
       
        $jm_capaian_kegiatan_tahunan = 0 ;
        foreach ($xdata as $x) {

            if ( $x->hitung_cost <=0 ){
                $capaian_kegiatan_tahunan = ($x->hitung_quantity + $x->hitung_quality + $x->hitung_waktu +$x->hitung_cost )/3;
            }else{
                $capaian_kegiatan_tahunan = ($x->hitung_quantity + $x->hitung_quality + $x->hitung_waktu +$x->hitung_cost )/4;
            }

            $jm_capaian_kegiatan_tahunan =  $jm_capaian_kegiatan_tahunan + $capaian_kegiatan_tahunan;
        } 

        return array(
            'jm_kegiatan_tahunan'           => $jm_kegiatan,
            'jm_capaian_kegiatan_tahunan'   => $jm_capaian_kegiatan_tahunan,
            'ave_capaian_kegiatan_tahunan'  => null,
        );

    }

    protected function capaian_tahunan_eselon4($capaian_id,$skp_tahunan_id,$renja_id,$jabatan_id)
    {

        //Jumlah kegiatan 
        $jm_kegiatan = KegiatanSKPTahunan::WHERE('skp_tahunan_id',$skp_tahunan_id)->count();
        $jm_realisasi = RealisasiKegiatanTahunan::WHERE('capaian_id',$capaian_id)->count();

        //cari nilai_capaian Kegiatan tahunan
        $data_cap = RealisasiKegiatanTahunan::WHERE('capaian_id',$capaian_id)->get();
        $nilai_capaian_kegiatan_tahunan = 0 ;
        foreach ($data_cap as $x) {
            if ( $x->hitung_cost <=0 ){
                $nilai_capaian_kegiatan_tahunan =  $nilai_capaian_kegiatan_tahunan + ($x->hitung_quantity + $x->hitung_quality + $x->hitung_waktu +$x->hitung_cost )/3 ;
            }else{
                $nilai_capaian_kegiatan_tahunan =  $nilai_capaian_kegiatan_tahunan + ($x->hitung_quantity + $x->hitung_quality + $x->hitung_waktu +$x->hitung_cost )/4 ;
            }
        }

        return array(
            'jm_kegiatan_tahunan'           => $jm_kegiatan,
            'jm_capaian_kegiatan_tahunan'   => $nilai_capaian_kegiatan_tahunan,
            'ave_capaian_kegiatan_tahunan'  => '',
        );

    }

    protected function capaian_tahunan_eselon3($capaian_id,$skp_tahunan_id,$renja_id,$jabatan_id)
    {

       /*  //Jumlah kegiatan 
        $child = Jabatan::SELECT('id')->WHERE('parent_id', $jabatan_id )->get()->toArray();
        $jm_kegiatan = Kegiatan::SELECT('id','label')
                            ->WHERE('renja_kegiatan.renja_id', $renja_id )
                            ->WHEREIN('renja_kegiatan.jabatan_id',$child )
                            ->leftjoin('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join){
                                $join   ->on('kegiatan_tahunan.subkegiatan_id','=','renja_kegiatan.id');
                                
                            })
                            ->count(); */
        $data       = CapaianTahunan::WHERE('id',$capaian_id)->first();
        $renja_id   = $data->SKPTahunan->renja_id;    
        $jabatan_id = $data->PegawaiYangDinilai->id_jabatan;
                   
        $bawahan = Jabatan::SELECT('id')->WHERE('parent_id', $jabatan_id )->get()->toArray();
                   
                   
        $jm_kegiatan = Kegiatan::WHERE('renja_kegiatan.renja_id', $renja_id )
                                            ->WHEREIN('renja_kegiatan.jabatan_id', $bawahan  )
                                            //LEFT JOIN ke Kegiatan SKP TAHUNAN
                                            ->JOIN('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join){
                                                $join   ->on('kegiatan_tahunan.subkegiatan_id','=','renja_kegiatan.id');
                                                
                                            })
                                            ->DISTINCT('kegiatan_tahunan.id')
                                            ->count('kegiatan_tahunan.id');


       
        $jm_realisasi = RealisasiKegiatanTahunan::WHERE('capaian_id',$capaian_id)->count();

        //cari nilai_capaian Kegiatan tahunan
        $data_cap = RealisasiKegiatanTahunan::WHERE('capaian_id',$capaian_id)->get();
        $nilai_capaian_kegiatan_tahunan = 0 ;
        foreach ($data_cap as $x) {

            //jika kegiatan tsb tidak dilaksnakan, kasih nilai 100 aja
            if ( $x->realisasi_waktu == 0 ){
                $nilai_capaian_kegiatan_tahunan = $nilai_capaian_kegiatan_tahunan + 100;
            }else{
                if ( $x->hitung_cost <=0 ){
                    $nilai_capaian_kegiatan_tahunan =  $nilai_capaian_kegiatan_tahunan + ($x->hitung_quantity + $x->hitung_quality + $x->hitung_waktu +$x->hitung_cost )/3 ;
                }else{
                    $nilai_capaian_kegiatan_tahunan =  $nilai_capaian_kegiatan_tahunan + ($x->hitung_quantity + $x->hitung_quality + $x->hitung_waktu +$x->hitung_cost )/4 ;
                }
            }

            
        }

        return array(
            'jm_kegiatan_tahunan'           => $jm_kegiatan,
            'jm_capaian_kegiatan_tahunan'   => $nilai_capaian_kegiatan_tahunan,
            'ave_capaian_kegiatan_tahunan'  => null ,
        );

    }

    public function hitung_capaian_tahunan($capaian_id){ 


        //jenis jabatan
        $id_jabatan_sekda       = json_decode($this->jenis_PJabatan('sekda'));
        $id_jabatan_irban       = json_decode($this->jenis_PJabatan('irban'));
        $id_jabatan_lurah       = json_decode($this->jenis_PJabatan('lurah'));
        $id_jabatan_staf_ahli   = json_decode($this->jenis_PJabatan('staf_ahli'));


        $capaian_tahunan = CapaianTahunan::
                                leftjoin('demo_asn.tb_history_jabatan AS a', function($join){
                                    $join   ->on('a.id','=','capaian_tahunan.u_jabatan_id');
                                })
                                ->leftjoin('demo_asn.m_skpd AS jabatan', function($join){
                                    $join   ->on('jabatan.id','=','a.id_jabatan');
                                })  
                                //eselon
                                ->leftjoin('demo_asn.m_eselon AS eselon', function($join){
                                            $join   ->on('eselon.id','=','a.id_eselon');
                                })  
                                ->SELECT(
                                    'capaian_tahunan.id AS capaian_tahunan_id',
                                    'capaian_tahunan.skp_tahunan_id',
                                    'capaian_tahunan.created_at',
                                    'capaian_tahunan.status_approve',
                                    'capaian_tahunan.send_to_atasan',
                                    'capaian_tahunan.alasan_penolakan',
                                    'capaian_tahunan.p_jabatan_id',
                                    'capaian_tahunan.u_jabatan_id',
                                    'eselon.id_jenis_jabatan AS id_jenis_jabatan'
                                )
                                ->where('capaian_tahunan.id','=', $capaian_id )
                                ->first();

       
                

        //$jenis_jabatan = $capaian_tahunan->PegawaiYangDinilai->Eselon->id_jenis_jabatan;
        $jenis_jabatan = $capaian_tahunan->id_jenis_jabatan;
        $renja_id = $capaian_tahunan->SKPTahunan->renja_id;
        $skp_tahunan_id = $capaian_tahunan->skp_tahunan_id;
        $jabatan_id = ( $capaian_tahunan->PegawaiYangDinilai ) ? $capaian_tahunan->PegawaiYangDinilai->id_jabatan : 0 ;

         

        //Tugas Tambahan pada skp tahunan
        //tidak dihitung pada capaian tahunan
       //$jm_tugas_tambahan =  TugasTambahan::WHERE('skp_tahunan_id',$skp_tahunan_id)->count();
     /*    $cdata = TugasTambahan::
                                    leftjoin('db_pare_2018.realisasi_tugas_tambahan AS realisasi', function($join) use($capaian_id){
                                        $join   ->on('realisasi.tugas_tambahan_id','=','skp_tahunan_tugas_tambahan.id');
                                        $join   ->where('realisasi.capaian_id','=',$capaian_id);
                                    })
                                    ->SELECT('skp_tahunan_tugas_tambahan.target','realisasi.realisasi')
                                    ->WHERE('skp_tahunan_tugas_tambahan.skp_tahunan_id','=',$skp_tahunan_id)
                                    ->get();  */

        $jm_capaian_tugas_tambahan = 0 ;
        $jm_tugas_tambahan = 0 ;

      /*  foreach ($cdata as $data) {
            $jm_tugas_tambahan ++;
            $jm_capaian_tugas_tambahan += Pustaka::persen($data->realisasi,$data->target);
        } 
 */
        $data_2 = array(
                        'jm_tugas_tambahan'           => $jm_tugas_tambahan,
                        'jm_capaian_tugas_tambahan'   => $jm_capaian_tugas_tambahan,
                        'ave_capaian_tugas_tambahan'  => Pustaka::ave($jm_capaian_tugas_tambahan,$jm_tugas_tambahan),
                        );

        //Unsur penunjang pada capaian
        $n_tt = UnsurPenunjangTugasTambahan::WHERE('capaian_tahunan_id', '=' ,$capaian_id)->WHERE('approvement', '=' , '1' )->count();

        $n_nilai_tt                                =  $this->Nilai_UP_TugasTambahan($n_tt);

        $n_kreativitas = UnsurPenunjangKreativitas::WHERE('capaian_tahunan_id', '=' ,$capaian_id)
                                            ->WHERE('approvement', '=' , '1' )
                                            ->sum('nilai');
        


        
        $data_3 = array(
            'nilai_unsur_penunjang_tugas_tambahan'      => $n_nilai_tt,
            'nilai_unsur_penunjang_kreativitas'         => $n_kreativitas,
            );



        //JENIS JABATAN STAF AHLI
        if ( ( $jenis_jabatan == 1 ) & ( in_array( $jabatan_id, $id_jabatan_staf_ahli) ) ){
            $jenis_jabatan = 5 ; //staf ahli sebagai JFT
        }

        //JENIS JABATAN UNTUK IRBAN ** 
        if ( ( $jenis_jabatan == 2 ) & ( in_array( $jabatan_id, $id_jabatan_irban) ) ){
            $jenis_jabatan = 31 ; //irban
        }

        //jika Lurah
        if ( ( $jenis_jabatan == 3 ) & ( in_array( $jabatan_id, $id_jabatan_lurah ) ) ){
            $jenis_jabatan = 2 ; //lurah
        }


        //Cari capaian Kinerja
        if ( $jenis_jabatan == 31){  //IRBAN 
            $data = $this->capaian_tahunan_irban($capaian_id,$skp_tahunan_id,$renja_id,$jabatan_id);
        }else if ( $jenis_jabatan == 5 ){//jm kegiatan JFT
            $data = $this->capaian_tahunan_jft($capaian_id,$skp_tahunan_id,$renja_id,$jabatan_id);
        }else if ( $jenis_jabatan == 4 ){ //jm kegiatan pelaksana JFU
            $data = $this->capaian_tahunan_jfu($capaian_id,$skp_tahunan_id,$renja_id,$jabatan_id);
        }else if ( $jenis_jabatan == 3 ){  //kasubid ESELON IV
            $data =  $this->capaian_tahunan_eselon4($capaian_id,$skp_tahunan_id,$renja_id,$jabatan_id);
        }else if ( $jenis_jabatan == 2){ //kabid ESELON III
            $data =  $this->capaian_tahunan_eselon3($capaian_id,$skp_tahunan_id,$renja_id,$jabatan_id);
        }else if ( $jenis_jabatan == 1){ //KABAN ESELON II
            $data =  $this->capaian_tahunan_eselon2($capaian_id,$skp_tahunan_id,$bulan,$renja_id,$jabatan_id);
        }else{
            $data = array(
                'jm_kegiatan_tahunan'           => 0,
                'jm_capaian_kegiatan_tahunan'   => 0,
                'ave_capaian_kegiatan_tahunan'  => 0,
            ); 
        }

        $data_all =  array_merge($data,$data_2,$data_3);


        //perhitungan akhir
        $jm_capaian_kegiatan_skp = $data_all['jm_capaian_kegiatan_tahunan'] + $data_all['jm_capaian_tugas_tambahan'];
        $jm_kegiatan_skp         = $data_all['jm_kegiatan_tahunan'] + $data_all['jm_tugas_tambahan'];
        $nilai_unsur_penunjang   = $data_all['nilai_unsur_penunjang_tugas_tambahan'] + $data_all['nilai_unsur_penunjang_kreativitas'];
        $capaian_kinerja_tahunan = Pustaka::ave($jm_capaian_kegiatan_skp,$jm_kegiatan_skp);
        $nilai_capaian_skp       = $capaian_kinerja_tahunan + $nilai_unsur_penunjang;

        $data_new = array(
            
            'jm_capaian_kegiatan_skp' => $jm_capaian_kegiatan_skp,
            'jm_kegiatan_skp'         => $jm_kegiatan_skp,
            'nilai_unsur_penunjang'   => $nilai_unsur_penunjang,
            'capaian_kinerja_tahunan' => $capaian_kinerja_tahunan,
            'nilai_capaian_skp'       => $nilai_capaian_skp,
            
            
        ); 
        
        $data_all =  array_merge($data_all,$data_new);
        return $data_all;
        
    }


}