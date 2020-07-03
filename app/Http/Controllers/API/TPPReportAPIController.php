<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\TPPReport;
use App\Models\TPPReportData;
use App\Models\FormulaHitungTPP;
use App\Models\CapaianBulanan;
use App\Models\KegiatanSKPBulanan;
use App\Models\Jabatan;
use App\Models\RencanaAksi;
use App\Models\Periode;
use App\Models\Pegawai;
use App\Models\Skpd;
use App\Models\UnitKerja;

use App\Helpers\Pustaka;

use App\Traits\PJabatan;
use App\Traits\HitungCapaian;
use App\Traits\UpdateCapaian;

use GuzzleHttp\Client;

use Datatables;
use Validator;
use Gravatar;
use Input;
use Alert;
use PDF;

class TPPReportAPIController extends Controller
{
    use PJabatan;
    use HitungCapaian;
    use UpdateCapaian;
 

    //============================= AMBIL DATA ABSENSI SIAP ==========================================//
    protected function skor_kehadiran($month,$nip){
        

        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://apiv2-siap.silk.bkpsdm.karawangkab.go.id',
        ]);
          
        $response = $client->request('GET', '/absensi/'.$nip.'/monthly-report', [
            'form_params' => [
                'access_token'  => 'MjIzNTZmZjItNTJmOS00NjA1LTk5YWEtOGQwN2VhNmIwNjVm',
                'approvedOnly'  => true
             ],
            'query' =>       [
                            'month'         => $month ,
                        ]
        ]);
         
        //get status code using $response->getStatusCode();
        $body = $response->getBody();
        $arr_body = json_decode($body,true); 

        return  $arr_body['summary']['percentage'];

    }


    //============================= HITUNG CAPAIAN ==========================================//
    protected function penilaian_kode_etik($x)
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
    
       
                        
        //penilaian kode etik + capaian
        if ( ($capaian_bulanan->penilaian_kode_etik_id) >= 1 ){
            $jm = ($capaian_bulanan->santun + $capaian_bulanan->amanah + $capaian_bulanan->harmonis+$capaian_bulanan->adaptif+$capaian_bulanan->terbuka+$capaian_bulanan->efektif);
            $penilaian_kode_etik = Pustaka::persen($jm,30) ;
        }else{
            $penilaian_kode_etik = 0 ;
        }
        
        return $penilaian_kode_etik;


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


    public function Select2CetakPeriodeList(Request $request)
    {

        $data       = Periode::
        
                        rightjoin('db_pare_2018.tpp_report AS tpp', function ($join) {
                            $join->on('tpp.periode_id', '=', 'periode.id');
                        })
                        ->SELECT('periode.label', 'periode.id')
                        ->OrderBy('periode.id', 'DESC')
                        ->Distinct('tpp.periode_id')
                        ->get();

        $periode_list = [];
        foreach ($data as $x) {
            $periode_list[] = array(
                'text'          => $x->label,
                'id'            => $x->id,
            );
        }
        return $periode_list;
    }


    public function Select2CetakPeriodeBulanList(Request $request)
    {

        $data       = TPPReport::
                        SELECT('tpp_report.bulan')
                        ->WHERE('tpp_report.periode_id',$request->periode_id)
                        ->WHERE('tpp_report.status','1')
                        ->OrderBy('tpp_report.bulan', 'ASC')
                        ->Distinct('tpp_report.bulan')
                        ->get();

        $periode_list = [];
        foreach ($data as $x) {
            $periode_list[] = array(
                'text'          => Pustaka::bulan($x->bulan),
                'id'            => $x->bulan,
            );
        }
        return $periode_list;
    }




    public function Select2CetakSKPDList(Request $request)
    {

        $nama_skpd  = $request->nama_skpd;
        $periode_id = $request->periode_id;
        $bulan      = $request->bulan;

        
        $data       = TPPReport::
                            rightjoin('demo_asn.m_skpd AS skpd', function ($join) {
                                $join->on('skpd.id', '=', 'tpp_report.skpd_id');
                            })


                            ->SELECT('tpp_report.id AS tpp_report_id','skpd.skpd AS nama_skpd')
                            ->WHERE('tpp_report.periode_id',$request->periode_id)
                            ->WHERE('tpp_report.bulan',$request->bulan)
                            ->WHERE('tpp_report.status','1')
                            ->where('skpd.skpd', 'LIKE', '%' . $nama_skpd . '%')
                            //->OrderBy('tpp_report.bulan', 'ASC')
                            //->Distinct('tpp_report.bulan')
                            ->get();

        $skpd_list = [];
        foreach ($data as $x) {
            $skpd_list[] = array(
                'text'          => Pustaka::capital_string($x->nama_skpd),
                'id'            => $x->tpp_report_id,
            );
        }
        return $skpd_list;

    }

    public function Select2CetakUnitKerjaList(Request $request)
    {

        $nama_unit_kerja = $request->nama_unit_kerja;

        $tpp_report_id = $request->tpp_report_id;

        $data = TPPReportData::
                        join('demo_asn.m_unit_kerja AS unit_kerja', function ($join) {
                            $join->on('unit_kerja.id', '=', 'tpp_report_data.unit_kerja_id');
                        })
                        ->WHERE('tpp_report_data.tpp_report_id',$tpp_report_id)
                        ->where('unit_kerja.unit_kerja', 'LIKE', '%' . $nama_unit_kerja . '%')
                        ->select([
                            'unit_kerja.id AS unit_kerja_id',
                            'unit_kerja.unit_kerja AS unit_kerja'

                        ])
                        //->GROUPBY('tpp_report_data.unit_kerja_id')
                        ->DISTINCT('tpp_report_data.unit_kerja_id')
                        ->get();
        

        /* $data = TPPReport::
                        rightjoin('demo_asn.m_skpd AS skpd', function ($join) {
                            $join->on('skpd.parent_id', '=', 'tpp_report.skpd_id');
                        })
                        ->join('demo_asn.m_skpd AS a', function ($join) {
                            $join->on('a.parent_id', '=', 'skpd.id');
                        })
                        ->join('demo_asn.m_unit_kerja AS unit_kerja', function ($join) {
                            $join->on('a.id', '=', 'unit_kerja.id');
                        })
                        ->WHERE('tpp_report.id',$tpp_report_id)
                        ->where('unit_kerja.unit_kerja', 'LIKE', '%' . $nama_unit_kerja . '%')
                        ->select([
                            'unit_kerja.id AS unit_kerja_id',
                            'unit_kerja.unit_kerja AS unit_kerja'

                        ])

                        ->get(); */
           


        $unit_kerja_list = [];
        foreach ($data as $x) {
            $unit_kerja_list[] = array(
                'text'        => Pustaka::capital_string($x->unit_kerja),
                'id'          => $x->unit_kerja_id,
            );
        }

        //SEMUA
        $all[] = array(
            'text'        => "Semua Unit Kerja",
            'id'          => "0",
        );

        return array_merge($all,$unit_kerja_list);
    }

    public function TPPReportDataList(Request $request)
    {

        $tpp_report_id = $request->tpp_report_id;
        $unit_kerja_id = $request->unit_kerja_id;

        $dt = TPPReportData::
            rightjoin('demo_asn.tb_pegawai AS pegawai', function ($join) {
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
            ->leftjoin('demo_asn.m_golongan AS golongan ', function ($join) {
                $join->on('tpp_report_data.golongan_id', '=', 'golongan.id');
            })


            ->select([
                'pegawai.nama',
                'pegawai.id AS pegawai_id',
                'pegawai.nip',
                'pegawai.gelardpn',
                'pegawai.gelarblk',
                'tpp_report_data.capaian_bulanan_id AS capaian_id',
                'tpp_report_data.unit_kerja_id',
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
                'golongan.golongan AS golongan',
                'skpd.skpd AS jabatan'
                


            ])
            ->WHERE('tpp_report_data.tpp_report_id', $tpp_report_id)
            ->ORDERBY('tpp_report_data.eselon_id','ASC')
            ->where('pegawai.status', '=', 'active')
            ->where('a.status', '=', 'active');


        //JIKA UNIT KERJA BUKAN ALL
        if ( $unit_kerja_id != 0 ){
            $dt->WHERE('tpp_report_data.unit_kerja_id',$unit_kerja_id);
        }
        


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
                return Pustaka::short_eselon($x->eselon);
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
                if ( $x->skor_kehadiran < 0  ){
                    return "-" ;
                }else{
                    return Pustaka::persen_bulat($x->skor_kehadiran)." %";
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

    
    public function cetakTPPReportData(Request $request)
    {

        $tpp_report_id = $request->tpp_report_id;
        $unit_kerja_id = $request->unit_kerja_id;

        $dt = TPPReportData::
            rightjoin('demo_asn.tb_pegawai AS pegawai', function ($join) {
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
            ->leftjoin('demo_asn.m_golongan AS golongan ', function ($join) {
                $join->on('tpp_report_data.golongan_id', '=', 'golongan.id');
            })


            ->select([
                'pegawai.nama',
                'pegawai.id AS pegawai_id',
                'pegawai.nip',
                'pegawai.gelardpn',
                'pegawai.gelarblk',
                'tpp_report_data.capaian_bulanan_id AS capaian_id',
                'tpp_report_data.unit_kerja_id',
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
                'golongan.golongan AS golongan',
                'skpd.skpd AS jabatan'
                


            ])
            ->WHERE('tpp_report_data.tpp_report_id', $tpp_report_id)
            ->ORDERBY('tpp_report_data.eselon_id','ASC')
            ->where('pegawai.status', '=', 'active')
            ->where('a.status', '=', 'active');


        //JIKA UNIT KERJA BUKAN ALL
        if ( $unit_kerja_id != 0 ){
            $dt->WHERE('tpp_report_data.unit_kerja_id',$unit_kerja_id);

            //NAMA UNIT KERJA UNTUK PRINTOUT
            $dt_uk = UnitKerja::WHERE('id',$unit_kerja_id)->SELECT('unit_kerja')->first();
            $nama_unit_kerja = $dt_uk->unit_kerja;
        }else{
            $nama_unit_kerja = "";
        }

        $data = $dt->get();



        //TPP report detail
        $p = TPPReport::WHERE('tpp_report.id', $tpp_report_id)
            ->join('db_pare_2018.periode AS periode', function ($join) {
                $join->on('periode.id', '=', 'tpp_report.periode_id');
            })
            ->join('db_pare_2018.formula_hitung_tpp AS frm', function ($join) {
                $join->on('frm.id', '=', 'tpp_report.formula_hitung_id');
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
                'periode.awal AS tahun_periode',
                'frm.kinerja AS kinerja',
                'frm.kehadiran AS kehadiran'


            ])
            ->first();

        //NAMA ADMIN
    
        $user_x    = \Auth::user();
        $profil  = Pegawai::WHERE('tb_pegawai.id',  $user_x->id_pegawai)->first();
        

       $pdf = PDF::loadView('pare_pns.printouts.cetak_tpp_report', [  'data'          =>  $data , 
                                                        'nama_unit_kerja'          =>  $nama_unit_kerja,
                                                        'periode'       =>  strtoupper(Pustaka::bulan($p->bulan)) . "  " . Pustaka::tahun($p->tahun_periode), 
                                                        'kinerja'       =>  $p->kinerja,
                                                        'kehadiran'     =>  $p->kehadiran,
                                                        'nama_skpd'     =>  $this::nama_skpd($p->skpd_id),
                                                        'waktu_cetak'   =>  Pustaka::balik(date('Y'."-".'m'."-".'d'))." / ". date('H'.":".'i'.":".'s'),
                                                        'pic'           =>  Pustaka::nama_pegawai($profil->gelardpn, $profil->nama, $profil->gelarblk),


                                                     ], [], [
                                                     'format' => 'A4-L'
          ]);
       
        $pdf->getMpdf()->shrink_tables_to_fit = 1;
        $pdf->getMpdf()->setWatermarkImage('assets/images/form/watermark.png');
        $pdf->getMpdf()->showWatermarkImage = true;
        
        $pdf->getMpdf()->SetHTMLFooter('
		<table width="100%">
			<tr>
				<td width="33%"></td>
				<td width="33%" align="center">{PAGENO}/{nbpg}</td>
				<td width="33%" style="text-align: right;"></td>
			</tr>
        </table>');
        //"tpp".$bulan_depan."_".$skpd."
        return $pdf->download('TPP'.$p->bulan.Pustaka::tahun($p->tahun_periode).'_'.$this::nama_skpd($p->skpd_id).'.pdf');
        //return $pdf->stream('TPP'.$p->bulan.'_'.$this::nama_skpd($p->skpd_id).'.pdf');
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
            'nama_skpd'         => Pustaka::capital_string($x->SKPD->nama_skpd),


            'jm_data_pegawai'   => TPPReportData::WHERE('tpp_report_id', $x->tpp_report_id)->count(),
            'jm_data_capaian'   => TPPReportData::WHERE('tpp_report_id', $x->tpp_report_id)->count(),

            'status'            => $x->status,



        );
        return $tpp;
    }

    protected function TPPReportDataDetail(Request $request)
    {

        $x = TPPReportData::
            //JABATAN
            leftjoin('demo_asn.m_skpd AS jabatan', function ($join) {
                $join->on('jabatan.id', '=', 'tpp_report_data.jabatan_id');
            }) 
            //ESELON
            ->leftjoin('demo_asn.m_eselon AS eselon', function ($join) {
                $join->on('eselon.id', '=', 'tpp_report_data.eselon_id');
            }) 
            //UNIT KERJA 
            ->leftjoin('demo_asn.m_unit_kerja AS unit_kerja', function ($join) {
                $join->on('unit_kerja.id', '=', 'tpp_report_data.unit_kerja_id');
            })
            //Golongan
            ->leftjoin('demo_asn.m_golongan AS golongan', function ($join) {
                $join->on('golongan.id', '=', 'tpp_report_data.golongan_id');
            })
            //CAPAIAN SKP
            ->leftjoin('db_pare_2018.capaian_bulanan AS capaian', function ($join) {
                $join->on('capaian.id', '=', 'tpp_report_data.capaian_bulanan_id');
            })
            ->select([
                'tpp_report_data.id AS tpp_report_data_id',
                'jabatan.skpd AS jabatan',
                'eselon.eselon AS eselon',
                'unit_kerja.unit_kerja AS unit_kerja',
                'golongan.golongan AS golongan',
                'capaian.id AS capaian_id'


            ])
            ->WHERE('tpp_report_data.id', $request->tpp_report_data_id)


                
            
            ->first();


        $tpp = array(
            'tpp_report_data_id'    => $x->tpp_report_data_id,
            'jabatan'               => Pustaka::capital_string($x->jabatan),
            'eselon'                => $x->eselon,
            'unit_kerja'            => Pustaka::capital_string($x->unit_kerja),
            'golongan'              => $x->golongan,
            'capaian_id'            => $x->capaian_id,



        );
        return $tpp;
    }

    protected function TPPReportDataEdit(Request $request)
    {

        $x = TPPReportData::
            //JABATAN
            leftjoin('demo_asn.m_skpd AS jabatan', function ($join) {
                $join->on('jabatan.id', '=', 'tpp_report_data.jabatan_id');
            }) 
            //ESELON
            ->leftjoin('demo_asn.m_eselon AS eselon', function ($join) {
                $join->on('eselon.id', '=', 'tpp_report_data.eselon_id');
            }) 
            //UNIT KERJA 
            ->leftjoin('demo_asn.m_unit_kerja AS unit_kerja', function ($join) {
                $join->on('unit_kerja.id', '=', 'tpp_report_data.unit_kerja_id');
            })
            //Golongan
            ->leftjoin('demo_asn.m_golongan AS golongan', function ($join) {
                $join->on('golongan.id', '=', 'tpp_report_data.golongan_id');
            })
            //CAPAIAN SKP
            ->leftjoin('db_pare_2018.capaian_bulanan AS capaian', function ($join) {
                $join->on('capaian.id', '=', 'tpp_report_data.capaian_bulanan_id');
            })
            //TPP Report
            ->leftjoin('db_pare_2018.tpp_report AS tpp_report', function ($join) {
                $join->on('tpp_report.id', '=', 'tpp_report_data.tpp_report_id');
            })
            ->select([
                'tpp_report_data.id AS tpp_report_data_id',
                'tpp_report_data.nama_pegawai AS nama_pegawai',
                'tpp_report_data.pegawai_id AS pegawai_id',
                'tpp_report_data.skpd_id AS skpd_id',
                'tpp_report_data.tpp_rupiah',
                'tpp_report_data.tpp_kinerja',
                'tpp_report_data.cap_skp AS capaian',
                'tpp_report_data.skor_cap AS skor_capaian',
                'tpp_report_data.pot_kinerja',
                'tpp_report_data.tpp_kehadiran',
                'tpp_report_data.skor_kehadiran',
                'tpp_report_data.pot_kehadiran',
                'jabatan.skpd AS jabatan',
                'eselon.eselon AS eselon',
                'capaian.id AS capaian_id',
                'tpp_report.formula_hitung_id',
                'tpp_report.bulan',
                'tpp_report.periode_id'


            ])
            ->WHERE('tpp_report_data.id', $request->tpp_report_data_id)
            ->first();
        //FORMULA HITUNG
        $formula    = FormulaHitungTPP::WHERE('id',$x->formula_hitung_id)->first();


        //CARI CAPAIAN BULANAN TERBARU
        $tpp = array(
            'tpp_report_data_id'    => $x->tpp_report_data_id,
            'nama_pegawai'          => $x->nama_pegawai,
            'jabatan'               => Pustaka::capital_string($x->jabatan),
            'eselon'                => $x->eselon,

            'persen_kinerja'        => $formula->kinerja." %",
            'persen_kehadiran'      => $formula->kehadiran." %",

            'tpp_rupiah'            => "Rp. " . number_format($x->tpp_rupiah, '0', ',', '.'),
            'tpp_kinerja'           => "Rp. " . number_format($x->tpp_kinerja, '0', ',', '.'),
            'capaian'               => $x->capaian,
            'skor_capaian'          => Pustaka::persen_bulat($x->skor_capaian)." %",
            'pot_kinerja'           => $x->pot_kinerja,
            'jm_tpp_kinerja'        => "Rp. " . number_format( (($x->tpp_kinerja)*($x->skor_capaian/100) ) - ( ($x->pot_kinerja/100 )*$x->tpp_kinerja), '0', ',', '.'),


            'tpp_kehadiran'         => "Rp. " . number_format($x->tpp_kehadiran, '0', ',', '.'),
            'skor_kehadiran'        => Pustaka::persen_bulat($x->skor_kehadiran)." %",
            'pot_kehadiran'         => $x->pot_kehadiran,
            'jm_tpp_kehadiran'      => "Rp. " . number_format( (($x->tpp_kehadiran)*($x->skor_kehadiran/100) ) - ( ($x->pot_kehadiran/100 )*$x->tpp_kehadiran), '0', ',', '.'),
            
            'capaian_id'            => $x->capaian_id,

            'data_baru'             => $this->update_capaian($x->bulan,$x->periode_id,$x->pegawai_id,$x->skpd_id,$x->formula_hitung_id,$x->pot_kinerja,$x->skor_kehadiran,$x->pot_kehadiran),



        );
        return $tpp; 
    }


    
    public function AdministratorTPPList(Request $request)
    {



        $tpp_report = TPPReport::
                                join('db_pare_2018.periode AS periode', function ($join) {
                                    $join->on('periode.id', '=', 'tpp_report.periode_id');
                                })
                                ->join('demo_asn.m_skpd AS skpd', function ($join) {
                                    $join->on('tpp_report.skpd_id', '=', 'skpd.id');
                                })
                                ->select([
                                    'tpp_report.id AS tpp_report_id',
                                    'tpp_report.periode_id',
                                    'tpp_report.bulan',
                                    'tpp_report.skpd_id',
                                    'tpp_report.admin_skpd AS nama_admin',
                                    'tpp_report.status',
                                    'tpp_report.created_at',
                                    'periode.label AS periode_label',
                                    'periode.awal AS tahun_periode',
                                    'skpd.skpd'

                                ])
                                ->orderBy('tpp_report.created_at', 'ASC')
                                ->get();

        $datatables = Datatables::of($tpp_report)
            ->addColumn('periode', function ($x) {
                return Pustaka::bulan_short($x->bulan).' '.Pustaka::tahun($x->tahun_periode);
            })
            ->addColumn('jumlah_data', function ($x) {
                return TPPReportData::WHERE('tpp_report_id', $x->tpp_report_id)->count();
            })
            ->addColumn('skpd', function ($x) {
                return Pustaka::capital_string($x->skpd);
            })
            ->addColumn('created_at', function ($x) {
                return Pustaka::tgl_jam_short($x->created_at);
            });

        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $datatables->make(true);
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
                'tpp_report.admin_skpd AS nama_admin',
                'tpp_report.status',
                'tpp_report.created_at',
                'periode.label AS periode_label',
                'periode.awal AS tahun_periode'

            ])
            ->orderBy('tpp_report.id', 'DESC')
            ->get();

        $datatables = Datatables::of($tpp_report)
            ->addColumn('periode', function ($x) {
                return Pustaka::bulan_short($x->bulan) . "  " . Pustaka::tahun($x->tahun_periode);
            })
            ->addColumn('jumlah_data', function ($x) {
                return TPPReportData::WHERE('tpp_report_id', $x->tpp_report_id)->count();
            })
            ->addColumn('created_at', function ($x) {
                return Pustaka::tgl_jam_short($x->created_at);
            });

        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $datatables->make(true);
    }

    public function CreateConfirm(Request $request)
    {

        //data yang harus diterima yaitu SKPD ID
        //cari TPP report nya, kemudian kirim select data untuk memilih periode nya, yang kurang dari bulan ini
        $skpd_id            = $request->get('skpd_id');

        //jadi jika create januari , makan list periode dan list bulan merupakan periode tahuna lalu
        //cari data bulan lalu
        $prevN          = mktime(0, 0, 0, date("m") - 1, date("d"), date("Y")); 
        //$bulan_lalu     = date("m", $prevN);
        $tahun          = date("Y", $prevN);
        $periode        = 'Periode '.$tahun;
        $d_periode = Periode::WHERE('label', $periode)->first();

        //Cari tpp report yang sudah pernah dibuat oleh SKPD ini
        $data_report = TPPReport::WHERE('skpd_id', '=', $skpd_id)->SELECT('bulan')->get();

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

            $data = array(
                'status'            =>  '0',
                'periode_id'        =>  $d_periode->id,
                'tahun'             =>  $tahun,
                'skpd_id'           =>  $skpd_id,
                'nama_skpd'         =>  Pustaka::capital_string($this->nama_skpd($skpd_id)),
                'jumlah_pegawai'    =>  $this->total_pegawai_skpd($skpd_id),
                'ka_skpd'           =>  $nama_ka_skpd,
                'admin_skpd'        =>  Pustaka::nama_pegawai($admin->gelardpn, $admin->nama, $admin->gelarblk),

            );
            return $data;
       
    }

    public function Store(Request $request)
    {

        $messages = [
            'skpd_id.required'                  => 'Harus diisi',
            'periode_id.required'               => 'Harus diisi',
            'bulan.required'                    => 'Harus diisi',
            'formula_hitung_id.required'   => 'Harus diisi',

        ];

        $validator = Validator::make(
            Input::all(),
            array(
                'skpd_id'               => 'required',
                'periode_id'            => 'required|numeric',
                'bulan'                 => 'required|numeric',
                'formula_hitung_id' => 'required|numeric',
            ),
            $messages
        );

        if ($validator->fails()) {
            //$messages = $validator->messages();
            return response()->json(['errors' => $validator->messages()], 422);
        }


        //CARI DATA NYA ,APAKAH SUDAH ADA BELUM
        $cek_data = TPPReport::WHERE('periode_id',Input::get('periode_id'))
                                ->WHERE('bulan',Input::get('bulan'))
                                ->WHERE('skpd_id',Input::get('skpd_id'))
                                ->first();
        if ( $cek_data == null ){

        

        $st_kt    = new TPPReport;

        $st_kt->periode_id          = Input::get('periode_id');
        $st_kt->bulan               = Input::get('bulan');
        $st_kt->formula_hitung_id   = Input::get('formula_hitung_id');
        $st_kt->skpd_id             = Input::get('skpd_id');
        $st_kt->ka_skpd             = Input::get('ka_skpd');
        $st_kt->admin_skpd          = Input::get('admin_skpd');

        //Save data untuk TPP report ini
        if ($st_kt->save()) {

            //jika berhasil
            $tpp_report_id = $st_kt->id; 

            //ambil data periode skp bulanan, jikatpp report januari, maka skp bulanan nya adalah skp bulan sebelumnya
            $bulan_lalu = Pustaka::bulan_lalu(Input::get('bulan'));
            

            //jika bulan januari, maka periode nya cari yang periode sebelumnya
            if ( Input::get('bulan') == 01 ){
                $dt = Periode::WHERE('periode.id',Input::get('periode_id'))->first();
                $periode_akhir = date('Y-m-d', strtotime("-1 day", strtotime(date($dt->awal))));

                $data = Periode::WHERE('periode.akhir',$periode_akhir)->first();
                $periode_id = $data->id;

            }else{
                $periode_id = Input::get('periode_id');
            }

            

            //insert data pegawai to  tpp_report_data
            //dari data pegawai
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
            
            //SKP Bulanan 
            ->leftjoin('db_pare_2018.skp_bulanan AS skp', function ($join) use($bulan_lalu){
                $join->on('skp.pegawai_id', '=', 'tb_pegawai.id');
                $join->where('skp.bulan', '=', $bulan_lalu) ;
                //$join->where('skp.skp_tahunan_id', '=', 'skp_tahunan.id') ;
            })
            //SKP TAHUNAN 
            ->leftjoin('db_pare_2018.skp_tahunan AS skp_tahunan', function ($join) use($periode_id){
                $join->on('skp.skp_tahunan_id', '=', 'skp_tahunan.id');
            })
             //RENJA
             ->leftjoin('db_pare_2018.renja AS renja', function ($join) use($periode_id){
                $join->on('skp_tahunan.renja_id', '=', 'renja.id');
            })
            //CAPAIAN
            ->leftjoin('db_pare_2018.capaian_bulanan AS capaian', function ($join) {
                $join->on('capaian.skp_bulanan_id', '=', 'skp.id');
                $join->where('capaian.status_approve', '=', 1   );
            })

            //JABATN FROM SKP BULANAN -> JABATAN ->SKPD
            ->leftjoin('demo_asn.tb_history_jabatan AS jab', function ($join) {
                $join->on('jab.id', '=', 'skp.u_jabatan_id');
            })
            ->leftjoin('demo_asn.m_skpd AS skpd', function ($join) {
                $join->on('skpd.id', '=', 'jab.id_jabatan');
            })

            //GOLONGAN FROM SKP BULANAN -> JABATAN ->GOLONGAN
            ->leftjoin('demo_asn.tb_history_golongan AS gol', function ($join) {
                $join->on('gol.id', '=', 'skp.u_golongan_id');
            })

            ->SELECT(
                'tb_pegawai.id AS pegawai_id',
                'tb_pegawai.nama AS nama',
                'tb_pegawai.nip AS nip',
                'tb_pegawai.gelardpn AS gelardpn',
                'tb_pegawai.gelarblk AS gelarblk',
                'skp.id AS skp_bulanan_id',
                'skp.bulan AS skp_bulanan_bulan',
                'skp.tgl_mulai AS skp_bulanan_tgl_mulai',
                'capaian.id AS capaian_id',
                'a.id_skpd AS skpd_id',
                'renja.periode_id AS periode_id',
                
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
            ->ORDERBY('skp.id','ASC')
            
            ->get(); 

           //return $tpp_data;
                
            foreach ($tpp_data as $x) {

                //CAri formulasi perhitungan nya
                $formula    = FormulaHitungTPP::WHERE('id',Input::get('formula_hitung_id'))->first();
                $kinerja    = $formula->kinerja;
                $kehadiran  = $formula->kehadiran;

                //nilai capaian ..capaian_skp
                if (  $x->capaian_id != null ){

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
                    ->where('capaian_bulanan.id','=', $x->capaian_id )->first();


                    //HITUNG CAPAIAN KINERJA
                    $data_kinerja               = $this->hitung_capaian($x->capaian_id); 
                    $jm_capaian                 = $data_kinerja['jm_capaian'];
                    $jm_kegiatan_bulanan        = $data_kinerja['jm_kegiatan_bulanan'];

                    $capaian_kinerja_bulanan  = Pustaka::persen2($jm_capaian,$jm_kegiatan_bulanan);


                    //HITUNG PENILAIAN KODE ETIK
                    if ( ($capaian_bulanan->penilaian_kode_etik_id) >= 1 ){
                        $jm = ($capaian_bulanan->santun + $capaian_bulanan->amanah + $capaian_bulanan->harmonis+$capaian_bulanan->adaptif+$capaian_bulanan->terbuka+$capaian_bulanan->efektif);
           
                        $penilaian_kode_etik = Pustaka::persen($jm,30) ;
                        $cap_skp = number_format( ($capaian_kinerja_bulanan * 70 / 100)+( $penilaian_kode_etik * 30 / 100 ) , 2 );
                    }else{
                        $penilaian_kode_etik = 0 ;
                        $cap_skp = 0 ;
                    } 

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

                //hitung skor kehadiran from SIAP
                $bulan = $x->skp_bulanan_bulan;
                $tahun = Pustaka::tahun($x->skp_bulanan_tgl_mulai);

                $month = $tahun.'-'.$tahun;
                $nip = $x->nip;
                $skor_kehadiran = $this->skor_kehadiran($month,$nip);



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
                $report_data->tpp_rupiah            = ( $x->tpp_rupiah != null ) ? $x->tpp_rupiah : ( ( $x->tpp_rupiah_now != null ) ? $x->tpp_rupiah_now : 0 );
                
                //KINERJA
                $report_data->tpp_kinerja           = ( $x->tpp_rupiah != null ) ? $x->tpp_rupiah * $kinerja/100 : $x->tpp_rupiah_now * $kinerja/100 ;
                $report_data->cap_skp               = $cap_skp;
                $report_data->skor_cap              = $skor_cap;
                $report_data->pot_kinerja           = 0 ;

                //KEHADIRAN
                $report_data->tpp_kehadiran         = ( $x->tpp_rupiah != null ) ? $x->tpp_rupiah * $kehadiran/100 : $x->tpp_rupiah_now * $kehadiran/100 ;
                $report_data->skor_kehadiran        = $skor_kehadiran;
                $report_data->pot_kehadiran         = 0;

                //DATA TAMBAHAN
                /* $report_data->jm_capaian                = $jm_capaian;
                $report_data->jm_kegiatan_bulanan       = $jm_kegiatan_bulanan;
                $report_data->capaian_kinerja_bulanan   = $capaian_kinerja_bulanan;
                $report_data->penilaian_kode_etik       = $penilaian_kode_etik; */



                if ( $x->periode_id == null | $x->periode_id == $periode_id ){
                    $report_data->save();
                }
                
                
            }  
            return \Response::make('sukses', 200);
            
        } else {
            return \Response::make('error', 500);
        } 

        }else{
            //JIKA DATA SUDAH ADA
            return response()->json(['errors' => "Data TPP Report sudah ada"], 500);
        }
    }

    public function TPPClose(Request $request)
    {
        $messages = [
                'tpp_report_id.required'       => 'Harus diisi'
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'tpp_report_id'       => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $tpp_report    = TPPReport::find(Input::get('tpp_report_id'));
        if (is_null($tpp_report)) {
            return $this->sendError('TPP Report  tidak ditemukan.');
        }


        $tpp_report->status    = 1 ;

        if ( $tpp_report->save()){
            //return back();
            return \Response::make('sukses', 200);
            
        }else{
            return \Response::make('error', 500);
        } 
            
    }

    
    
    public function TPPReportDataUpdate(Request $request)
    {
        $messages = [
                'tpp_report_data_id.required'       => 'Harus diisi',
                'new_capaian_bulanan_id.required'   => 'Harus diisi',
                'new_tpp_rupiah.required'           => 'Harus diisi',
                'new_tpp_kinerja.required'          => 'Harus diisi',
                'new_capaian_kinerja.required'      => 'Harus diisi',
                'new_skor_capaian.required'         => 'Harus diisi',
                'new_potongan_kinerja.required'     => 'Harus diisi',
                'new_tpp_kehadiran.required'        => 'Harus diisi',
                'new_skor_kehadiran.required'       => 'Harus diisi',
                'new_pot_kehadiran.required'        => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            
                            'tpp_report_data_id'       => 'required',
                            'new_capaian_bulanan_id'   => 'required',
                            'new_tpp_rupiah'           => 'required',
                            'new_tpp_kinerja'          => 'required',
                            'new_capaian_kinerja'      => 'required',
                            'new_skor_capaian'         => 'required',
                            'new_potongan_kinerja'     => 'required',
                            'new_tpp_kehadiran'        => 'required',
                            'new_skor_kehadiran'       => 'required',
                            'new_pot_kehadiran'        => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $tpp_report_data    = TPPReportData::find(Input::get('tpp_report_data_id'));
        if (is_null($tpp_report_data)) {
            return $this->sendError('TPP Report Data tidak ditemukan.');
        }


        $tpp_report_data->capaian_bulanan_id    = Input::get('new_capaian_bulanan_id');
        $tpp_report_data->tpp_rupiah            = Input::get('new_tpp_rupiah');
        $tpp_report_data->tpp_kinerja           = Input::get('new_tpp_kinerja');
        $tpp_report_data->cap_skp               = Input::get('new_capaian_kinerja');
        $tpp_report_data->skor_cap              = Input::get('new_skor_capaian');
        $tpp_report_data->pot_kinerja           = Input::get('new_potongan_kinerja');
        $tpp_report_data->tpp_kehadiran         = Input::get('new_tpp_kehadiran');
        $tpp_report_data->skor_kehadiran        = Input::get('new_skor_kehadiran');
        $tpp_report_data->pot_kehadiran         = Input::get('new_pot_kehadiran');

        if ( $tpp_report_data->save()){
            //return back();
            return \Response::make('sukses', 200);
            
        }else{
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
