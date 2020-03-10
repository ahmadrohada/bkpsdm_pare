<?php

namespace App\Traits;

use App\Models\CapaianBulanan;
use App\Models\Jabatan;
use App\Models\RencanaAksi;
use App\Models\RealisasiRencanaAksiKaban;
use App\Models\KegiatanSKPBulanan;
use App\Models\KegiatanSKPBulananJFT;


use App\Helpers\Pustaka;

trait HitungCapaian
{


    protected function capaian_kinerja_irban($capaian_id,$skp_bulanan_id,$bulan,$renja_id,$jabatan_id)
    {
        //cari bawahan
        $child = Jabatan::SELECT('id')->WHERE('id',$jabatan_id )->get()->toArray(); 

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
            $jm_kegiatan_bulanan ++;
            $jm_capaian += Pustaka::persen($data->realisasi,$data->target);
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
        $jm_kegiatan_bulanan ++;

        $jm_capaian += Pustaka::persen($data->realisasi,$data->target);

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
        $jm_kegiatan_bulanan ++;

        $jm_capaian += Pustaka::persen($data->realisasi,$data->target);

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
                                        ->Where('id_eselon', '=', 9 )
                                        ->Where('id_eselon', '=', 10 );
                                    /*->orWhere('id_eselon', '=', 17 ); */
                            })
                            ->SELECT('id')
                            ->get()
                            ->toArray(); 

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
            $jm_kegiatan_bulanan ++;
            $jm_capaian += Pustaka::persen($data->realisasi,$data->target);
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
                                ->get()
                                ->toArray();  
            
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
            $jm_kegiatan_bulanan ++;
            $jm_capaian += Pustaka::persen($data->realisasi,$data->target);
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
                                $join   ->on('rencana_aksi.id','=','realisasi_rencana_aksi_kaban.rencana_aksi_id');
                            })
                            ->SELECT(   
                                        'realisasi_rencana_aksi_kaban.realisasi AS realisasi',
                                        'rencana_aksi.target'

                            ) 
                           
                            ->WHERE('capaian_id',$capaian_id)
                            ->get();

        $jm_capaian = 0 ;
        $jm_kegiatan_bulanan = 0 ;

        foreach ($xdata as $data) {
            $jm_kegiatan_bulanan ++;
            $jm_capaian += Pustaka::persen($data->realisasi,$data->target);

        }

        return array(
            'jm_kegiatan_bulanan'       => $jm_kegiatan_bulanan,
            'jm_capaian'                => $jm_capaian,
        );
    }


    public function hitung_capaian($capaian_id){

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

        //$jenis_jabatan = $capaian_bulanan->PejabatYangDinilai->Eselon->id_jenis_jabatan;
        $jenis_jabatan = $capaian_bulanan->id_jenis_jabatan;
        $bulan = $capaian_bulanan->SKPBulanan->bulan;
        $renja_id = $capaian_bulanan->SKPBulanan->SKPTahunan->renja_id;
        $skp_bulanan_id = $capaian_bulanan->skp_bulanan_id;
        $jabatan_id = ( $capaian_bulanan->PejabatYangDinilai ) ? $capaian_bulanan->PejabatYangDinilai->id_jabatan : 0 ;


        //JENIS JABATAN STAF AHLI
        $id_jabatan_staf_ahli = ['13','14','15','61068','61069'];
        if ( ( $jenis_jabatan == 1 ) & ( in_array( $jabatan_id, $id_jabatan_staf_ahli) ) ){
            $jenis_jabatan = 5 ; //staf ahli sebagai JFT
        }

        //JENIS JABATAN UNTUK IRBAN ** 
        $id_jabatan_irban = ['143','144','145','146'];
        if ( ( $jenis_jabatan == 2 ) & ( in_array( $jabatan_id, $id_jabatan_irban) ) ){
            $jenis_jabatan = 31 ; //irban
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
        return $data;
    }


}