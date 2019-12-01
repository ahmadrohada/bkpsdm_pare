<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\TPPReport;
use App\Models\TPPReportData;
use App\Models\CapaianBulanan;
use App\Models\KegiatanSKPBulanan;
use App\Models\Jabatan;
use App\Models\RencanaAksi;
use App\Models\Periode;
use App\Models\Pegawai;
use App\Models\Skpd;

use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Gravatar;
use Input;
use Alert;

class TPPReportAPIController extends Controller
{


    //============================= HITUNG CAPAIAN ==========================================//
    protected function capaian_skp($x)
    {
        $capaian_id = $x;

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
        
        
        
       
       
        }else if ( $jenis_jabatan == 1){ //KABAN
            //cari bawahan bawahan nya

            //CARI KASUBID
            $child = Jabatan::
                                
                    leftjoin('demo_asn.m_skpd AS kasubid', function($join){
                        $join   ->on('kasubid.parent_id','=','m_skpd.id');
                    })
                    ->SELECT('kasubid.id')
                    ->WHERE('m_skpd.parent_id',  $capaian_bulanan->PejabatYangDinilai->id_jabatan )
                    ->get()
                    ->toArray();

            //cari bawahan  , jabatanpelaksanan
            $pelaksana_id = Jabatan::
                    SELECT('m_skpd.id')
                    ->WHEREIN('m_skpd.parent_id', $child )
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
                        
        //penilaian kode etik + capaian
        if ( ($capaian_bulanan->penilaian_kode_etik_id) >= 1 ){
            $jm = ($capaian_bulanan->santun + $capaian_bulanan->amanah + $capaian_bulanan->harmonis+$capaian_bulanan->adaptif+$capaian_bulanan->terbuka+$capaian_bulanan->efektif);
            $penilaian_kode_etik = Pustaka::persen($jm,30) ;

            $capaian_skp_bulanan = number_format( ($capaian_kinerja_bulanan * 70 / 100)+( $penilaian_kode_etik * 30 / 100 ) , 2 );
        }else{
            $penilaian_kode_etik = 0 ;
            $capaian_skp_bulanan = 0 ;
        }
        
        return $capaian_skp_bulanan;


    }

    //=======================================================================================//
    protected function nama_skpd($skpd_id)
    {
        //nama SKPD 
        $nama_skpd       = \DB::table('demo_asn.m_skpd AS skpd')
            ->WHERE('id', $skpd_id)
            ->SELECT(['skpd.skpd AS skpd'])
            ->first();
        return $nama_skpd->skpd;
    }

    protected function total_pegawai_skpd($skpd_id)
    {

        return     Pegawai::rightjoin('demo_asn.tb_history_jabatan AS a', function ($join) {
            $join->on('a.id_pegawai', '=', 'tb_pegawai.id');
            $join->where('a.status', '=', 'active');
        })
            ->WHERE('a.id_skpd', '=', $skpd_id)
            ->WHERE('tb_pegawai.nip', '!=', 'admin')
            ->WHERE('tb_pegawai.status', 'active')
            ->count();
    }

    //=======================================================================================//
    protected function jabatan($id_jabatan)
    {
        $jabatan       = HistoryJabatan::WHERE('id', $id_jabatan)
            ->SELECT('jabatan')
            ->first();
        return Pustaka::capital_string($jabatan->jabatan);
    }


    public function Select2PeriodeList(Request $request)
    {

        $data       = Periode::SELECT('label', 'awal')->OrderBy('id', 'DESC')->get();

        $periode_list = [];
        foreach ($data as $x) {
            $periode_list[] = array(
                'text'        => $x->label,
                'id'        => Pustaka::tahun($x->awal),
            );
        }
        return $periode_list;
    }




    public function Select2SKPDList(Request $request)
    {

        $nama_skpd = $request->nama_skpd;

        $data = \DB::table('demo_asn.m_skpd AS skpd')

            ->whereRaw('id = id_skpd AND id != 1 AND id != 6 AND id != 8 AND id != 10 AND id != 12 ')
            ->where('skpd.skpd', 'LIKE', '%' . $nama_skpd . '%')
            ->select([
                'skpd.id_skpd AS skpd_id',
                'skpd.id_unit_kerja AS unit_kerja_id',
                'skpd.skpd AS skpd'
            ])

            ->get();


        $skpd_list = [];
        foreach ($data as $x) {
            $skpd_list[] = array(
                'text'        => $x->skpd,
                'id'        => $x->skpd_id,
            );
        }
        return $skpd_list;
    }

    public function Select2UnitKerjaList(Request $request)
    {

        $nama_unit_kerja = $request->nama_unit_kerja;

        $id_skpd = $request->skpd_id;


        $data = \DB::table('demo_asn.m_skpd AS skpd')
            ->rightjoin('demo_asn.m_skpd AS a', function ($join) {
                $join->on('a.parent_id', '=', 'skpd.id');
            })
            ->join('demo_asn.m_unit_kerja AS unit_kerja', function ($join) {
                $join->on('a.id', '=', 'unit_kerja.id');
            })
            ->WHERE('skpd.parent_id', $id_skpd)
            ->where('skpd.skpd', 'LIKE', '%' . $nama_unit_kerja . '%')
            ->select([
                'unit_kerja.id AS unit_kerja_id',
                'unit_kerja.unit_kerja AS unit_kerja'

            ])

            ->get();


        $unit_kerja_list = [];
        foreach ($data as $x) {
            $unit_kerja_list[] = array(
                'text'        => $x->unit_kerja,
                'id'        => $x->unit_kerja_id,
            );
        }
        return $unit_kerja_list;
    }

    public function AdministratorTPPBulananList(Request $request)
    {

        $id_skpd = $request->skpd_id;

        $dt = \DB::table('demo_asn.tb_pegawai AS pegawai')
            ->rightjoin('demo_asn.tb_history_jabatan AS a', function ($join) {
                $join->on('a.id_pegawai', '=', 'pegawai.id');
            })
            //eselon
            ->leftjoin('demo_asn.m_skpd AS skpd ', function ($join) {
                $join->on('a.id_jabatan', '=', 'skpd.id');
            })


            ->select([
                'pegawai.nama',
                'pegawai.id AS pegawai_id',
                'pegawai.nip',
                'pegawai.gelardpn',
                'pegawai.gelarblk',
                'skpd.tunjangan AS tunjangan'


            ])
            ->where('pegawai.status', '=', 'active')
            ->where('a.id_skpd', '=', $id_skpd)
            ->where('a.status', '=', 'active');



        $datatables = Datatables::of($dt)
            ->addColumn('nama_pegawai', function ($x) {
                return Pustaka::nama_pegawai($x->gelardpn, $x->nama, $x->gelarblk);
            })
            ->addColumn('nip_pegawai', function ($x) {
                return $x->nip;
            })
            ->addColumn('tunjangan', function ($x) {
                return "Rp. " . number_format($x->tunjangan, '0', ',', '.');
            })
            ->addColumn('e', function ($x) {
                return "Rp. " . number_format($x->tunjangan * (60 / 100), '0', ',', '.');
            })
            ->addColumn('f', function ($x) {
                return "";
            })
            ->addColumn('g', function ($x) {
                return "";
            })
            ->addColumn('h', function ($x) {
                return "";
            })
            ->addColumn('i', function ($x) {
                return "";
            })
            ->addColumn('j', function ($x) {
                return "Rp. " . number_format($x->tunjangan * (40 / 100), '0', ',', '.');
            })
            ->addColumn('k', function ($x) {
                return "";
            })
            ->addColumn('l', function ($x) {
                return "";
            })
            ->addColumn('m', function ($x) {
                return "";
            })
            ->addColumn('n', function ($x) {
                return "";
            });
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }
        return $datatables->make(true);
    }

    public function TPPBulananList(Request $request)
    {

        $tpp_report_id = $request->tpp_report_id;

        $dt = TPPReportData::WHERE('tpp_report_data.tpp_report_id', $tpp_report_id)
            ->rightjoin('demo_asn.tb_pegawai AS pegawai', function ($join) {
                $join->on('pegawai.id', '=', 'tpp_report_data.pegawai_id');
            })
            ->rightjoin('demo_asn.tb_history_jabatan AS a', function ($join) {
                $join->on('a.id_pegawai', '=', 'pegawai.id');
            })
            
            ->leftjoin('demo_asn.m_skpd AS skpd ', function ($join) {
                $join->on('a.id_jabatan', '=', 'skpd.id');
            })
            //eselon
            ->leftjoin('demo_asn.m_eselon AS eselon ', function ($join) {
                $join->on('tpp_report_data.eselon_id', '=', 'eselon.id');
            })
            //golongan
            ->leftjoin('demo_asn.m_golongan AS eselon ', function ($join) {
                $join->on('tpp_report_data.eselon_id', '=', 'eselon.id');
            })


            ->select([
                'pegawai.nama',
                'pegawai.id AS pegawai_id',
                'pegawai.nip',
                'pegawai.gelardpn',
                'pegawai.gelarblk',
                'tpp_report_data.capaian_bulanan_id AS capaian_id',
                'tpp_report_data.id AS tpp_report_data_id',
                'tpp_report_data.tpp_rupiah AS tunjangan',
                'tpp_report_data.tpp_kinerja AS tpp_kinerja',
                'tpp_report_data.cap_skp AS capaian',
                'tpp_report_data.skor_cap AS skor',
                'tpp_report_data.pot_kinerja AS pot_kinerja',
                'tpp_report_data.tpp_kehadiran AS tpp_kehadiran',
                'tpp_report_data.skor_kehadiran AS skor_kehadiran',
                'tpp_report_data.pot_kehadiran AS pot_kehadiran',
                'eselon.eselon AS eselon',
                'skpd.skpd AS jabatan'
                


            ])
            ->ORDERBY('tpp_report_data.eselon_id','ASC')
            ->where('pegawai.status', '=', 'active')
            ->where('a.status', '=', 'active');



        $datatables = Datatables::of($dt)
            ->addColumn('nama_pegawai', function ($x) {
                return Pustaka::nama_pegawai($x->gelardpn, $x->nama, $x->gelarblk);
            })
            ->addColumn('nip_pegawai', function ($x) {
                return $x->nip;
            })
            ->addColumn('gol', function ($x) {
                return $x->golongan;
            })
            ->addColumn('eselon', function ($x) {
                return $x->eselon;
            })
            ->addColumn('jabatan', function ($x) {
                return Pustaka::capital_string($x->jabatan);
            })
            ->addColumn('tunjangan', function ($x) {
                return "Rp. " . number_format($x->tunjangan, '0', ',', '.');
            })
            ->addColumn('tpp_kinerja', function ($x) {
                return "Rp. " . number_format($x->tpp_kinerja, '0', ',', '.');
            })
            ->addColumn('capaian', function ($x) {
                if ( $x->capaian_id == null  ){
                    return "-" ;
                }else{
                    return Pustaka::persen_bulat($x->capaian);
                }
                
            })
            ->addColumn('skor', function ($x) {
                if ( $x->capaian_id == null  ){
                    return "-" ;
                }else{
                    return Pustaka::persen_bulat($x->skor)." %";
                }
                
            })
            ->addColumn('potongan_kinerja', function ($x) {
                if ( $x->pot_kinerja <= 0  ){
                    return "-" ;
                }else{
                    return Pustaka::persen_bulat($x->pot_kinerja)." %";
                }
            })
            ->addColumn('jm_tpp_kinerja', function ($x) {

                return "Rp. " . number_format( (($x->tpp_kinerja)*($x->skor/100) ) - ( ($x->pot_kinerja/100 )*$x->tpp_kinerja), '0', ',', '.');


            })
            ->addColumn('tpp_kehadiran', function ($x) {
                return "Rp. " . number_format($x->tpp_kehadiran , '0', ',', '.');
            })
            ->addColumn('skor_kehadiran', function ($x) {
                if ( $x->skor_kehadiran > 0  ){
                    return "-" ;
                }else{
                    return Pustaka::persen_bulat($x->skor)." %";
                }
            })
            ->addColumn('potongan_kehadiran', function ($x) {
                if ( $x->pot_kehadiran<= 0  ){
                    return "-" ;
                }else{
                    return Pustaka::persen_bulat($x->pot_kehadiran)." %";
                }
            })
            ->addColumn('jm_tpp_kehadiran', function ($x) {
                return "Rp. " . number_format( (($x->tpp_kehadiran)*($x->skor_kehadiran/100) ) - ( ($x->pot_kehadiran/100 )*$x->tpp_kehadiran), '0', ',', '.');
            })
            ->addColumn('total_tpp', function ($x) {
                $tpp_a = (($x->tpp_kinerja)*($x->skor/100) ) - ( ($x->pot_kinerja/100 )*$x->tpp_kinerja);
                $tpp_b = (($x->tpp_kehadiran)*($x->skor_kehadiran/100) ) - ( ($x->pot_kehadiran/100 )*$x->tpp_kehadiran);

                return "Rp. " . number_format( ($tpp_a + $tpp_b) , '0', ',', '.');
            });
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }
        return $datatables->make(true);
    }


    protected function TPPReportDetail(Request $request)
    {
        $x = TPPReport::WHERE('tpp_report.id', $request->tpp_report_id)
            ->join('db_pare_2018.periode AS periode', function ($join) {
                $join->on('periode.id', '=', 'tpp_report.periode_id');
            })
            ->select([
                'tpp_report.id AS tpp_report_id',
                'tpp_report.periode_id',
                'tpp_report.bulan',
                'tpp_report.skpd_id',
                'tpp_report.ka_skpd',
                'tpp_report.admin_skpd',
                'tpp_report.status',
                'tpp_report.created_at',
                'periode.label AS periode_label',
                'periode.awal AS tahun_periode'


            ])
            ->first();


        $tpp = array(
            'tpp_report_id'     => $x->tpp_report_id,
            'periode'           => Pustaka::bulan($x->bulan) . "  " . Pustaka::tahun($x->tahun_periode),
            'created_at'        => Pustaka::tgl_jam($x->created_at),
            'ka_skpd'           => $x->ka_skpd,
            'admin_skpd'        => $x->admin_skpd,


            'jm_data_pegawai'   => TPPReportData::WHERE('tpp_report_id', $x->tpp_report_id)->count(),
            'jm_data_capaian'   => TPPReportData::WHERE('tpp_report_id', $x->tpp_report_id)->count(),

            'status'            => $x->status,



        );
        return $tpp;
    }

    protected function TPPReportDataDetail(Request $request)
    {




        $tpp_data = Pegawai::rightjoin('demo_asn.tb_history_jabatan AS a', function ($join) {
            $join->on('a.id_pegawai', '=', 'tb_pegawai.id');
            $join->where('a.status', '=', 'active');
        })


            ->leftjoin('demo_asn.m_unit_kerja AS unit_kerja', function ($join) {
                $join->on('unit_kerja.id', '=', 'a.id_unit_kerja');
            })
            ->leftjoin('demo_asn.m_skpd AS skpd_now', function ($join) {
                $join->on('skpd_now.id', '=', 'a.id_jabatan');
            }) 
            ->leftjoin('db_pare_2018.skp_bulanan AS skp', function ($join) {
                $join->on('skp.pegawai_id', '=', 'tb_pegawai.id');
                $join->where('skp.bulan', '=', Pustaka::bulan_lalu(Input::get('bulan'))  );
                //$join->where('skp.bulan', '=', '02'  );
            })

            //TPP FROM SKP BULANAN -> JABATAN ->SKPD
            ->leftjoin('demo_asn.m_skpd AS skpd', function ($join) {
                $join->on('skpd.id', '=', 'skp.u_jabatan_id');
            })

            ->leftjoin('db_pare_2018.capaian_bulanan AS capaian', function ($join) {
                $join->on('capaian.skp_bulanan_id', '=', 'skp.id');
                $join->where('capaian.status_approve', '=', 1   );
            })



            ->SELECT(
                'tb_pegawai.id AS pegawai_id',
                'tb_pegawai.nama AS nama',
                'tb_pegawai.gelardpn AS gelardpn',
                'tb_pegawai.gelarblk AS gelarblk',
                'skp.id AS skp_bulanan_id',
                'skp.bulan AS skp_bulanan_bulan',
                'capaian.id AS capaian_id',
                'a.id_skpd AS skpd_id',
                'unit_kerja.unit_kerja AS unit_kerja',
                'skpd.id AS jabatan_id',
                'skpd.tunjangan AS tpp_rupiah',
                'skpd.id_eselon AS eselon_id',
                'skpd_now.id AS jabatan_id_now',
                'skpd_now.tunjangan AS tpp_rupiah_now',
                'skpd_now.id_eselon AS eselon_id_now'


            )



            ->WHERE('a.id_skpd', '=', Input::get('skpd_id'))
            ->WHERE('tb_pegawai.nip', '!=', 'admin')
            ->WHERE('tb_pegawai.status', 'active')
            ->get(); 




        $x = TPPReportData::WHERE('tpp_report_data.id', $request->tpp_report_data_id)
            ->select([
                'tpp_report_data.id AS tpp_report_data_id'


            ])
            ->first();


        $tpp = array(
            'tpp_report_data_id'     => $x->tpp_report_data_id,



        );
        return $tpp;
    }

    public function SKPDTTPReportList(Request $request)
    {



        $tpp_report = TPPReport::WHERE('skpd_id', $request->skpd_id)
            ->join('db_pare_2018.periode AS periode', function ($join) {
                $join->on('periode.id', '=', 'tpp_report.periode_id');
            })
            ->select([
                'tpp_report.id AS tpp_report_id',
                'tpp_report.periode_id',
                'tpp_report.bulan',
                'tpp_report.skpd_id',
                'tpp_report.status',
                'tpp_report.created_at',
                'periode.label AS periode_label',
                'periode.awal AS tahun_periode'

            ])
            ->orderBy('tpp_report.id', 'DESC')
            ->get();

        $datatables = Datatables::of($tpp_report)
            ->addColumn('periode', function ($x) {
                return Pustaka::bulan($x->bulan) . "  " . Pustaka::tahun($x->tahun_periode);
            })
            ->addColumn('jumlah_data', function ($x) {
                return TPPReportData::WHERE('tpp_report_id', $x->tpp_report_id)->count();
            });

        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $datatables->make(true);
    }

    public function CreateConfirm(Request $request)
    {

        //data yang harus diterima yaitu SKPD ID
        //periode dan bulan di generate disini

        //periode aktif
        $d_periode = Periode::WHERE('status', '1')->first();
        $periode_id         = $d_periode->id;
        $periode_tahun      = Pustaka::tahun($d_periode->awal);

        //bulan capaian
        $bulan              = date('m');
        $skpd_id            = $request->get('skpd_id');

        //aDMIN skpd
        $admin = Pegawai::WHERE('id', $request->admin_id)->first();

        //KA SKPD
        $ka_skpd = SKPD::WHERE('parent_id', '=', $skpd_id)->first();
        if ($ka_skpd->pejabat != null) {
            $pegawai            = $ka_skpd->pejabat->pegawai;

            $nama_ka_skpd         = Pustaka::nama_pegawai($pegawai->gelardpn, $pegawai->nama, $pegawai->gelarblk);
        } else {
            $nama_ka_skpd = "";
        }


        $data_tpp = TPPReport::WHERE('skpd_id', '=', $skpd_id)
            ->WHERE('periode_id', '=', $periode_id)
            ->WHERE('bulan', '=', $bulan)
            ->count();

        if ($data_tpp == 0) {

            $data = array(
                'status'            =>  '0',
                'periode_id'        =>  $periode_id,
                'bulan'             =>  $bulan,
                'periode_label'     =>  Pustaka::bulan($bulan) . " " . Pustaka::tahun($d_periode->awal),
                'skpd_id'           =>  $skpd_id,
                'nama_skpd'         =>  Pustaka::capital_string($this->nama_skpd($skpd_id)),
                'jumlah_pegawai'    =>  $this->total_pegawai_skpd($skpd_id),
                'ka_skpd'           =>  $nama_ka_skpd,
                'admin_skpd'        =>  Pustaka::nama_pegawai($admin->gelardpn, $admin->nama, $admin->gelarblk),

            );
            return $data;
        } else {
            $data = array('status'    =>  '1');
            return $data;
        }
    }

    public function Store(Request $request)
    {

        $messages = [
            'skpd_id.required'                  => 'Harus diisi',
            'periode_id.required'               => 'Harus diisi',
            'bulan.required'                    => 'Harus diisi',
            'formula_perhitungan_id.required'   => 'Harus diisi',

        ];

        $validator = Validator::make(
            Input::all(),
            array(
                'skpd_id'               => 'required',
                'periode_id'            => 'required|numeric',
                'bulan'                 => 'required|numeric',
                'formula_perhitungan_id' => 'required|numeric',
            ),
            $messages
        );

        if ($validator->fails()) {
            //$messages = $validator->messages();
            return response()->json(['errors' => $validator->messages()], 422);
        }


        $st_kt    = new TPPReport;

        $st_kt->periode_id          = Input::get('periode_id');
        $st_kt->bulan               = Input::get('bulan');
        $st_kt->formula_perhitungan_id = Input::get('formula_perhitungan_id');
        $st_kt->skpd_id             = Input::get('skpd_id');
        $st_kt->ka_skpd             = Input::get('ka_skpd');
        $st_kt->admin_skpd          = Input::get('admin_skpd');

        if ($st_kt->save()) {

            //jika berhasil
            $tpp_report_id = $st_kt->id; 


        //insert data pegawai to  tpp-report_data

        $tpp_data = Pegawai::rightjoin('demo_asn.tb_history_jabatan AS a', function ($join) {
            $join->on('a.id_pegawai', '=', 'tb_pegawai.id');
            $join->where('a.status', '=', 'active');
        })

            ->leftjoin('demo_asn.m_skpd AS skpd_now', function ($join) {
                $join->on('skpd_now.id', '=', 'a.id_jabatan');
            }) 


            //golongan saat ini
            ->leftjoin('demo_asn.tb_history_golongan AS gol_now', function ($join) {
                $join->on('gol_now.id_pegawai', '=', 'tb_pegawai.id');
                $join->where('gol_now.status', '=', 'active');
            })
            

            ->leftjoin('db_pare_2018.skp_bulanan AS skp', function ($join) {
                $join->on('skp.pegawai_id', '=', 'tb_pegawai.id');
                $join->where('skp.bulan', '=', Pustaka::bulan_lalu(Input::get('bulan'))  );
                //$join->where('skp.bulan', '=', '02'  );
            })

            //JABATN FROM SKP BULANAN -> JABATAN ->SKPD
            ->leftjoin('demo_asn.m_skpd AS skpd', function ($join) {
                $join->on('skpd.id', '=', 'skp.u_jabatan_id');
            })

            //GOLONGAN FROM SKP BULANAN -> JABATAN ->GOLONGAN
            ->leftjoin('demo_asn.tb_history_golongan AS gol', function ($join) {
                $join->on('gol.id', '=', 'skp.u_golongan_id');
            })


            

           

            ->leftjoin('db_pare_2018.capaian_bulanan AS capaian', function ($join) {
                $join->on('capaian.skp_bulanan_id', '=', 'skp.id');
                $join->where('capaian.status_approve', '=', 1   );
            })



            ->SELECT(
                'tb_pegawai.id AS pegawai_id',
                'tb_pegawai.nama AS nama',
                'tb_pegawai.gelardpn AS gelardpn',
                'tb_pegawai.gelarblk AS gelarblk',
                'skp.id AS skp_bulanan_id',
                'skp.bulan AS skp_bulanan_bulan',
                'capaian.id AS capaian_id',
                'a.id_skpd AS skpd_id',
                
                'skpd.id AS jabatan_id',
                'skpd.id_unit_kerja AS unit_kerja_id',
                'gol.id_golongan AS golongan_id',
                'skpd.tunjangan AS tpp_rupiah',
                'skpd.id_eselon AS eselon_id',

                'skpd_now.id AS jabatan_id_now',
                'skpd_now.id_unit_kerja AS id_unit_kerja_now',
                'skpd_now.tunjangan AS tpp_rupiah_now',
                'skpd_now.id_eselon AS eselon_id_now',
                'gol_now.id_golongan AS golongan_id_now'


            )



            ->WHERE('a.id_skpd', '=', Input::get('skpd_id'))
            ->WHERE('tb_pegawai.nip', '!=', 'admin')
            ->WHERE('tb_pegawai.status', 'active')
            ->get(); 


            foreach ($tpp_data as $x) {


                //nilai capaian ..capaian_skp
                if (  $x->capaian_id != null ){
                    $cap_skp  = $this->capaian_skp($x->capaian_id);



                    if ( $cap_skp >= 85 ){
                        $skor_cap = 100 ;
                    }else if ( $cap_skp < 50 ){
                        $skor_cap = 0 ;
                    }else{
                        $skor_cap	= number_format( (50 + (1.43*($cap_skp-50))),2 );
                        
                    }

                }else{
                    $cap_skp  = 0 ;
                    $skor_cap = 0 ;
                }

                $report_data    = new TPPReportData;

                $report_data->nama_pegawai          = Pustaka::nama_pegawai($x->gelardpn , $x->nama , $x->gelarblk);
                $report_data->tpp_report_id         = $tpp_report_id;
                $report_data->pegawai_id            = $x->pegawai_id;
                $report_data->capaian_bulanan_id    = $x->capaian_id;
                $report_data->skpd_id               = $x->skpd_id;
                $report_data->unit_kerja_id         = ( $x->unit_kerja_id != null ) ? $x->unit_kerja_id : $x->unit_kerja_id_now;
                $report_data->eselon_id             = ( $x->eselon_id != null ) ? $x->eselon_id : $x->eselon_id_now ;
                $report_data->jabatan_id            = ( $x->jabatan_id != null ) ? $x->jabatan_id : $x->jabatan_id_now;
                $report_data->golongan_id           = ( $x->golongan_id != null ) ? $x->golongan_id : $x->golongan_id_now;
                $report_data->tpp_rupiah            = ( $x->tpp_rupiah != null ) ? $x->tpp_rupiah : $x->tpp_rupiah_now ;
                
                //KINERJA
                $report_data->tpp_kinerja           = ( $x->tpp_rupiah != null ) ? $x->tpp_rupiah * 60/100 : $x->tpp_rupiah_now * 60/100 ;
                $report_data->cap_skp               = $cap_skp;
                $report_data->skor_cap              = $skor_cap;
                $report_data->pot_kinerja           = 0 ;

                //KEHADIRAN
                $report_data->tpp_kehadiran         = ( $x->tpp_rupiah != null ) ? $x->tpp_rupiah * 40/100 : $x->tpp_rupiah_now * 40/100 ;
                $report_data->skor_kehadiran        = 100;
                $report_data->pot_kehadiran         = 0;




                $report_data->save();
            }






            return \Response::make('sukses', 200);
        } else {
            return \Response::make('error', 500);
        } 
    }

    public function Destroy(Request $request)
    {

        $messages = [
            'tpp_report_id.required'   => 'Harus diisi',
        ];

        $validator = Validator::make(
            Input::all(),
            array(
                'tpp_report_id'   => 'required',
            ),
            $messages
        );

        if ($validator->fails()) {
            //$messages = $validator->messages();
            return response()->json(['errors' => $validator->messages()], 422);
        }


        $del    = TPPReport::find(Input::get('tpp_report_id'));
        if (is_null($del)) {
            return $this->sendError('TPP Report tidak ditemukan.');
        }


        if ($del->delete()) {
            return \Response::make('sukses', 200);
        } else {
            return \Response::make('error', 500);
        }
    }
}
