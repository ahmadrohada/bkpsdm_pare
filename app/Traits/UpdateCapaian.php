<?php

namespace App\Traits;

use App\Models\Pegawai;
use App\Models\CapaianBulanan;
use App\Models\FormulaHitungTPP;
use App\Models\TPPReportData;
use App\Models\Jabatan;
use App\Models\RencanaAksi;
use App\Models\RealisasiRencanaAksiKaban;
use App\Models\KegiatanSKPBulanan;
use App\Models\KegiatanSKPBulananJFT;


use App\Helpers\Pustaka;
use App\Traits\HitungCapaian;

trait UpdateCapaian
{

  

    public function update_capaian($bulan,$periode_id,$pegawai_id,$skpd_id,$formula_hitung_id,$pot_kinerja,$skor_kehadiran,$pot_kehadiran)
    {
        //ambil data periode skp bulanan, jikatpp report januari, maka skp bulanan nya adalah skp bulan sebelumnya
        $bulan_lalu = Pustaka::bulan_lalu($bulan);


        //jika bulan januari, maka periode nya cari yang periode sebelumnya
        if ($bulan == 01) {
            $dt = Periode::WHERE('periode.id', $periode_id)->first();
            $periode_akhir = date('Y-m-d', strtotime("-1 day", strtotime(date($dt->awal))));

            $data = Periode::WHERE('periode.akhir', $periode_akhir)->first();
            $periode_id = $data->id;
        } else {
            $periode_id = $periode_id;
        }

        //dari data pegawai
        $tpp_data = Pegawai::rightjoin('demo_asn.tb_history_jabatan AS a', function ($join) {
                $join->on('a.id_pegawai', '=', 'tb_pegawai.id');
                $join->where('a.status', '=', 'active');
            })
            //SKP Bulanan 
            ->leftjoin('db_pare_2018.skp_bulanan AS skp', function ($join) use ($bulan_lalu) {
                $join->on('skp.pegawai_id', '=', 'tb_pegawai.id');
                $join->where('skp.bulan', '=', $bulan_lalu);
            })
            //SKP TAHUNAN 
            ->leftjoin('db_pare_2018.skp_tahunan AS skp_tahunan', function ($join) use ($periode_id) {
                $join->on('skp.skp_tahunan_id', '=', 'skp_tahunan.id');
            })
            //RENJA
            ->leftjoin('db_pare_2018.renja AS renja', function ($join) use ($periode_id) {
                $join->on('skp_tahunan.renja_id', '=', 'renja.id');
            })
            //CAPAIAN
            ->leftjoin('db_pare_2018.capaian_bulanan AS capaian', function ($join) {
                $join->on('capaian.skp_bulanan_id', '=', 'skp.id');
                $join->where('capaian.status_approve', '=', 1);
            })
            //JABATN FROM SKP BULANAN -> JABATAN ->SKPD
            ->leftjoin('demo_asn.tb_history_jabatan AS jab', function ($join) {
                $join->on('jab.id', '=', 'skp.u_jabatan_id');
            })
            ->leftjoin('demo_asn.m_skpd AS skpd', function ($join) {
                $join->on('skpd.id', '=', 'jab.id_jabatan');
            })
            ->SELECT(
                'tb_pegawai.id AS pegawai_id',
                'skp.id AS skp_bulanan_id',
                'skp.bulan AS skp_bulanan_bulan',
                'capaian.id AS capaian_id',
                'a.id_skpd AS skpd_id',
                'skpd.tunjangan AS tpp_rupiah'
            

            )

            ->WHERE('a.id_skpd', '=', $skpd_id)
            ->WHERE('tb_pegawai.id', $pegawai_id)
            ->WHERE('tb_pegawai.status', 'active')
            ->ORDERBY('skp.id', 'ASC')

            ->get();

            //return $tpp_data;
        foreach ($tpp_data as $x) {

            //CAri formulasi perhitungan nya
            $formula    = FormulaHitungTPP::WHERE('id', $formula_hitung_id)->first();
            $kinerja    = $formula->kinerja;
            $kehadiran  = $formula->kehadiran;

            //nilai capaian ..capaian_skp
            if ($x->capaian_id != null) {

                $capaian_bulanan = CapaianBulanan::leftjoin('db_pare_2018.penilaian_kode_etik AS pke', function ($join) {
                        $join->on('pke.capaian_bulanan_id', '=', 'capaian_bulanan.id');
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
                    ->where('capaian_bulanan.id', '=', $x->capaian_id)->first();


                //HITUNG CAPAIAN KINERJA
                $data_kinerja               = $this->hitung_capaian($x->capaian_id);
                $jm_capaian                 = $data_kinerja['jm_capaian'];
                $jm_kegiatan_bulanan        = $data_kinerja['jm_kegiatan_bulanan'];

                $capaian_kinerja_bulanan  = Pustaka::persen2($jm_capaian, $jm_kegiatan_bulanan);


                //HITUNG PENILAIAN KODE ETIK
                if (($capaian_bulanan->penilaian_kode_etik_id) >= 1) {
                    $jm = ($capaian_bulanan->santun + $capaian_bulanan->amanah + $capaian_bulanan->harmonis + $capaian_bulanan->adaptif + $capaian_bulanan->terbuka + $capaian_bulanan->efektif);

                    $penilaian_kode_etik = Pustaka::persen($jm, 30);
                    $cap_skp = number_format(($capaian_kinerja_bulanan * 70 / 100) + ($penilaian_kode_etik * 30 / 100), 2);
                } else {
                    $penilaian_kode_etik = 0;
                    $cap_skp = 0;
                }


                if ($cap_skp >= 85) {
                    $skor_cap = 100;
                } else if ($cap_skp < 50) {
                    $skor_cap = 0;
                } else {
                    $skor_cap    = number_format((50 + (1.43 * ($cap_skp - 50))), 2);
                }
            } else {
                $cap_skp  = 0;
                $skor_cap = 0;
            }

            $report_data    = new TPPReportData;
           
            $report_data->capaian_bulanan_id    = $x->capaian_id;
            $tpp_rupiah                         = ($x->tpp_rupiah != null) ? $x->tpp_rupiah :  0;
            $report_data->tpp_rupiah            = "Rp. " . number_format($tpp_rupiah, '0', ',', '.');
            $report_data->ntpp_rupiah           = $tpp_rupiah;
            
            $report_data->persen_kinerja        = $kinerja." %";
            $report_data->persen_kehadiran      = $kehadiran." %";
            
            //KINERJA
            $tpp_kinerja                        = ($x->tpp_rupiah != null) ? $x->tpp_rupiah * $kinerja / 100 : 0 ;
            $report_data->tpp_kinerja           = "Rp. " . number_format($tpp_kinerja, '0', ',', '.');
            $report_data->ntpp_kinerja          = $tpp_kinerja;
            $report_data->capaian               = $cap_skp;
            $report_data->skor_capaian          = Pustaka::persen_bulat($skor_cap)." %";
            $report_data->nskor_capaian         = $skor_cap;
            $report_data->pot_kinerja           = $pot_kinerja;
            $report_data->jm_tpp_kinerja        = "Rp. " . number_format( (($tpp_kinerja)*($skor_cap/100) ) - ( ($pot_kinerja/100 )*$tpp_kinerja), '0', ',', '.');

            //KEHADIRAN
            $tpp_kehadiran                      = ($x->tpp_rupiah != null) ? $x->tpp_rupiah * $kehadiran / 100 : 0 ;
            $report_data->tpp_kehadiran         = "Rp. " . number_format($tpp_kehadiran, '0', ',', '.');
            $report_data->ntpp_kehadiran        = $tpp_kehadiran;
            $report_data->skor_kehadiran        = Pustaka::persen_bulat($skor_kehadiran)." %";
            $report_data->nskor_kehadiran       = $skor_kehadiran;
            $report_data->pot_kehadiran         = $pot_kehadiran;
            $report_data->jm_tpp_kehadiran      = "Rp. " . number_format( (($tpp_kehadiran)*($skor_kehadiran/100) ) - ( ($pot_kehadiran/100 )*$tpp_kehadiran), '0', ',', '.');


            if ($x->periode_id == null | $x->periode_id == $periode_id) {
                return $report_data;
            }else{
                return "";
            }
        } 
    }
}
