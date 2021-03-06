<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\TPPReport;
use App\Models\TPPReportData;
use App\Models\FormulaHitungTPP;
use App\Models\SKPBulanan;
use App\Models\CapaianBulanan;
use App\Models\KegiatanSKPBulanan;
use App\Models\Jabatan;
use App\Models\RencanaAksi;
use App\Models\Periode;
use App\Models\Pegawai;
use App\Models\Skpd;
use App\Models\UnitKerja;

use App\Helpers\Pustaka;

use App\Traits\HitungCapaian;
use App\Traits\UpdateCapaian;
use App\Traits\TraitPegawai;
use App\Traits\TraitCapaianBulanan;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

use Datatables;
use Validator;
use Gravatar;
use Input;
use Alert;
use PDF;

class TPPReportAPIController extends Controller 
{
    use HitungCapaian;
    use UpdateCapaian;
    use TraitPegawai;
    use TraitCapaianBulanan;
 


    //============================= UPADTE TABEL LAMA TPP REPORT DATA KE MODEL BARU ========================//
    protected function UpdateOldTable_(Request $request)
    {

        $skpd_id = $request->skpd_id;
        $tpp_data = TPPReportData::WHERE('skpd_id','=',$skpd_id)->get();

       //return $tpp_data;
        $no = 0 ;
        foreach ($tpp_data as $x) {

            //ubah ID menjadi text data
            $nama_skpd       = \DB::table('demo_asn.m_skpd AS skpd')
                                            ->WHERE('id', $x->skpd_id)
                                            ->SELECT(['skpd.skpd AS skpd'])
                                            ->first();
            //return Pustaka::capital_string($nama_skpd->skpd);
            $nama_unit_kerja       = \DB::table('demo_asn.m_unit_kerja AS unit_kerja')
                                            ->WHERE('id', $x->unit_kerja_id)
                                            ->SELECT(['unit_kerja.unit_kerja AS unit_kerja'])
                                            ->first();
            //return Pustaka::capital_string($nama_unit_kerja->unit_kerja);
            $nama_jabatan       = \DB::table('demo_asn.m_skpd AS jabatan')
                                        ->WHERE('id', $x->jabatan_id)
                                        ->SELECT(['jabatan.skpd AS jabatan'])
                                        ->first();
            //return Pustaka::capital_string($nama_jabatan->jabatan);
            $nama_golongan       = \DB::table('demo_asn.m_golongan AS golongan')
                                            ->WHERE('id', $x->golongan_id)
                                            ->SELECT(['golongan.golongan AS golongan'])
                                            ->first();
            //return $nama_golongan->golongan;
            $nama_eselon       = \DB::table('demo_asn.m_eselon AS eselon')
                                            ->WHERE('id', $x->eselon_id)
                                            ->SELECT(['eselon.eselon AS eselon'])
                                            ->first();
            //return $nama_eselon->eselon;

            $tpp_report_data    = TPPReportData::find($x->id);
          
            $tpp_report_data->skpd              = $nama_skpd ? Pustaka::capital_string($nama_skpd->skpd)  : '';
            $tpp_report_data->unit_kerja_id     = $nama_unit_kerja ? Pustaka::capital_string($nama_unit_kerja->unit_kerja) : '';
            $tpp_report_data->jabatan_id        = $nama_jabatan ? Pustaka::capital_string($nama_jabatan->jabatan) : '';
            $tpp_report_data->golongan_id       = $nama_golongan ? $nama_golongan->golongan : '';
            $tpp_report_data->eselon_id         = $nama_eselon ? $nama_eselon->eselon : '';
            $tpp_report_data->save();
            $no++;
        }
        return $no; 
    }


    //============================= AMBIL DATA ABSENSI SIAP PER NIP==========================================//
    protected function skor_kehadiran($month,$nip){
        

        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://api-siap.silk.bkpsdm.karawangkab.go.id',
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
        $arr_body = json_decode($body); 

        return  $arr_body->summary->percentage;

    }

    
    //============================= AMBIL DATA ABSENSI SIAP PER SKPD ==========================================//
    protected function data_kehadiran($month,$skpd_id){
        try {
            $client = new Client([ 'base_uri' => 'https://api-siap.silk.bkpsdm.karawangkab.go.id']);
            $guzzleResult = $client->request('GET', '/absensi-monthly-report/', [
                'form_params'   =>  [
                                        'access_token'  => 'MjIzNTZmZjItNTJmOS00NjA1LTk5YWEtOGQwN2VhNmIwNjVm',
                                        'approvedOnly'  => true
                                    ],
                'timeout'       =>  360,
                'query'         =>  [
                                        'month'         => $month ,
                                        'skpdId'        => $skpd_id,
                                        'limit'         => 2000,
                                    ]
            ]);
           
            //$statuscode = $guzzleResult->getStatusCode();
            $body = $guzzleResult->getBody();
            $arr_body = json_decode($body); 
            return  $arr_body->data;  
            

        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $guzzleResult = $e->getResponse();
        }
      
        
    }

     //============================= Try API ke SIAP ==========================================//
     public function Store_(){

        $month      = '05';
        $skpd_id    = 42 ;

        try {
            $client = new Client([ 'base_uri' => 'https://api-siap.silk.bkpsdm.karawangkab.go.id']);
            $guzzleResult = $client->request('GET', '/absensi-monthly-report/', [
                'form_params'   =>  [
                                        'access_token'  => 'MjIzNTZmZjItNTJmOS00NjA1LTk5YWEtOGQwN2VhNmIwNjVm',
                                        'approvedOnly'  => true
                                    ],
                'timeout'       =>  60,
                'query'         =>  [
                                        'month'         => $month ,
                                        'skpdId'        => $skpd_id,
                                        'limit'         => 1000,
                                    ]
            ]);
           
            $statuscode = $guzzleResult->getStatusCode();
            $body = $guzzleResult->getBody();
            $arr_body = json_decode($body); 
            return  $arr_body->data;  
            

        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $guzzleResult = $e->getResponse();
        }  
      
        
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
    protected function periode_capaian_bulanan($capaian_id)
    {

        if ( $capaian_id != null ){
            $x = CapaianBulanan::
                                select('capaian_bulanan.tgl_mulai')
                                ->WHERE('capaian_bulanan.id',$capaian_id)
                                ->first();

            return  Pustaka::periode($x->tgl_mulai);
        }else{
            return "";
        }
       
    }


    protected function nama_skpd($skpd_id)
    {
        //nama SKPD 
        $nama_skpd       = \DB::table('demo_asn.m_skpd AS skpd')
            ->WHERE('id', $skpd_id)
            ->SELECT(['skpd.skpd AS skpd'])
            ->first();
        return $nama_skpd->skpd;
    }

    

    //=======================================================================================//
    protected function nama_puskesmas($puskesmas_id){
        //nama puskesmas 
        $nama_puskesmas  = UnitKerja::WHERE('m_unit_kerja.id',$puskesmas_id)
                                    ->SELECT(['m_unit_kerja.unit_kerja AS puskesmas'])
                                    ->first();
        return $nama_puskesmas->puskesmas;
    }

    
    protected function total_pegawai_puskesmas( $puskesmas_id){
        
        return 	Pegawai::rightjoin('demo_asn.tb_history_jabatan AS a', function($join) use($puskesmas_id){
                                            $join   ->on('a.id_pegawai','=','tb_pegawai.id')
                                            ->where(function ($query) use($puskesmas_id) {
                                                $query  ->where('a.id_unit_kerja','=', $puskesmas_id)
                                                        ->orwhere('a.id_jabatan','=', $puskesmas_id);
                                            });
                                            $join   ->where('a.status','=', 'active');
                                    })
                                    ->WHERE('tb_pegawai.nip','!=','admin')
                                    ->WHERE('tb_pegawai.status','active')
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
                        WHERE('tpp_report_data.tpp_report_id',$tpp_report_id)
                        ->where('tpp_report_data.unit_kerja', 'LIKE', '%' . $nama_unit_kerja . '%')
                        ->select([
                            'tpp_report_data.unit_kerja AS unit_kerja_id',
                            'tpp_report_data.unit_kerja AS unit_kerja'

                        ])
                        ->DISTINCT('tpp_report_data.unit_kerja')
                        ->get();
        

        $unit_kerja_list = [];
        foreach ($data as $x) {
            $unit_kerja_list[] = array(
                'text'        => $x->unit_kerja,
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
            join('demo_asn.tb_pegawai AS pegawai', function ($join) {
                $join->on('pegawai.id', '=', 'tpp_report_data.pegawai_id');
            })
            ->select([
                'pegawai.nama',
                'pegawai.id AS pegawai_id',
                'pegawai.nip',
                'pegawai.gelardpn',
                'pegawai.gelarblk',
                'tpp_report_data.capaian_bulanan_id AS capaian_id',
                'tpp_report_data.unit_kerja',
                'tpp_report_data.id AS tpp_report_data_id',
                'tpp_report_data.tpp_rupiah AS tunjangan',
                'tpp_report_data.tpp_kinerja AS tpp_kinerja',
                'tpp_report_data.cap_skp AS capaian',
                'tpp_report_data.skor_cap AS skor',
                'tpp_report_data.pot_kinerja AS pot_kinerja',
                'tpp_report_data.tpp_kehadiran AS tpp_kehadiran',
                'tpp_report_data.skor_kehadiran AS skor_kehadiran',
                'tpp_report_data.pot_kehadiran AS pot_kehadiran',
                'tpp_report_data.eselon AS eselon',
                'tpp_report_data.golongan AS golongan',
                'tpp_report_data.skpd AS skpd',
                'tpp_report_data.jabatan AS jabatan'

                
                


            ])
            ->WHERE('tpp_report_data.tpp_report_id', $tpp_report_id);


        //JIKA UNIT KERJA BUKAN ALL
        if ( $unit_kerja_id != "" ){
            $dt->WHERE('tpp_report_data.unit_kerja',$unit_kerja_id);
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
                return $x->eselon;
            })
            ->addColumn('jabatan', function ($x) {
                return $x->jabatan;
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

    public function PuskesmasTPPReportDataList(Request $request) 
    {

        $tpp_report_id = $request->tpp_report_id;
        $puskesmas_id = $request->puskesmas_id;

        //data tpp nya adalah yang unit kerja_id nya adalah puskes ini or unit_kerja_id = ka uptd puskes ini
        //cari parent nya

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
                'tpp_report_data.unit_kerja',
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
            ->WHERE('tpp_report_data.unit_kerja_id',$puskesmas_id)
            ->ORDERBY('tpp_report_data.jabatan_id','ASC')
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

    public function PersonalTPPReportDataList(Request $request) 
    {

        $dt = SKPBulanan::
            rightjoin('db_pare_2018.capaian_bulanan', function($join){
                $join   ->on('capaian_bulanan.skp_bulanan_id','=','skp_bulanan.id');
               
            })
            ->leftjoin('db_pare_2018.tpp_report_data AS tpp_report_data', function($join){
                $join   ->on('tpp_report_data.capaian_bulanan_id','=','capaian_bulanan.id');
            })
       
            ->rightjoin('demo_asn.tb_pegawai AS pegawai', function ($join) {
                $join->on('pegawai.id', '=', 'tpp_report_data.pegawai_id');
            })
           
            ->select([
                'pegawai.nama',
                'pegawai.id AS pegawai_id',
                'pegawai.nip',
                'pegawai.gelardpn',
                'pegawai.gelarblk',
                'tpp_report_data.capaian_bulanan_id AS capaian_id',
                'tpp_report_data.unit_kerja',
                'tpp_report_data.id AS tpp_report_data_id',
                'tpp_report_data.tpp_rupiah AS tunjangan',
                'tpp_report_data.tpp_kinerja AS tpp_kinerja',
                'tpp_report_data.cap_skp AS capaian',
                'tpp_report_data.skor_cap AS skor',
                'tpp_report_data.pot_kinerja AS pot_kinerja',
                'tpp_report_data.tpp_kehadiran AS tpp_kehadiran',
                'tpp_report_data.skor_kehadiran AS skor_kehadiran',
                'tpp_report_data.pot_kehadiran AS pot_kehadiran',
                'tpp_report_data.eselon AS eselon',
                'tpp_report_data.golongan AS golongan',
                'tpp_report_data.jabatan AS jabatan'
                


            ])
            ->WHERE('pegawai.id', $request->pegawai_id)
            ->orderBy('tpp_report_data.id','desc');


        $datatables = Datatables::of($dt)
          
            ->addColumn('periode', function ($x) {
                return $this::periode_capaian_bulanan($x->capaian_id);
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
        $unit_kerja = $request->unit_kerja_id;

        $dt = TPPReportData::
            rightjoin('demo_asn.tb_pegawai AS pegawai', function ($join) {
                $join->on('pegawai.id', '=', 'tpp_report_data.pegawai_id');
            })
            ->select([
                'pegawai.nama',
                'pegawai.id AS pegawai_id',
                'pegawai.nip',
                'pegawai.gelardpn',
                'pegawai.gelarblk',
                'tpp_report_data.capaian_bulanan_id AS capaian_id',
                'tpp_report_data.unit_kerja',
                'tpp_report_data.id AS tpp_report_data_id',
                'tpp_report_data.tpp_rupiah AS tunjangan',
                'tpp_report_data.tpp_kinerja AS tpp_kinerja',
                'tpp_report_data.cap_skp AS capaian',
                'tpp_report_data.skor_cap AS skor',
                'tpp_report_data.pot_kinerja AS pot_kinerja',
                'tpp_report_data.tpp_kehadiran AS tpp_kehadiran',
                'tpp_report_data.skor_kehadiran AS skor_kehadiran',
                'tpp_report_data.pot_kehadiran AS pot_kehadiran',
                'tpp_report_data.eselon AS eselon',
                'tpp_report_data.golongan AS golongan',
                'tpp_report_data.skpd AS skpd',
                'tpp_report_data.jabatan AS jabatan'
                


            ])
            ->WHERE('tpp_report_data.tpp_report_id', $tpp_report_id);
            //->where('pegawai.status', '=', 'active')


        //JIKA UNIT KERJA BUKAN ALL
        if ( $unit_kerja != '0' ){
            $dt->WHERE('tpp_report_data.unit_kerja',$unit_kerja);
            $dt->ORDERBY('tpp_report_data.id','ASC');
            //NAMA UNIT KERJA UNTUK PRINTOUT
            $nama_unit_kerja = $unit_kerja;
        }else{
            $dt->ORDERBY('tpp_report_data.id','ASC');
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
        //stream or download
        return $pdf->download('TPP'.$p->bulan.Pustaka::tahun($p->tahun_periode).'_'.$this::nama_skpd($p->skpd_id).'.pdf');
    }

    public function cetakPuskesmasTPPReportData(Request $request)
    {

        $tpp_report_id = $request->tpp_report_id;
        $unit_kerja = $request->puskesmas_id;

        $data = TPPReportData::
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
                'tpp_report_data.unit_kerja',
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
            ->WHERE('tpp_report_data.unit_kerja',$unit_kerja)
            ->ORDERBY('tpp_report_data.jabatan_id','ASC')
            ->where('pegawai.status', '=', 'active')
            ->where('a.status', '=', 'active')
            ->get();

      
    

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
        

       $pdf = PDF::loadView('pare_pns.printouts.cetak_tpp_report', [  'data'            =>  $data , 
                                                        'nama_unit_kerja'               =>  $this->nama_puskesmas($request->puskesmas_id),
                                                        'periode'                       =>  strtoupper(Pustaka::bulan($p->bulan)) . "  " . Pustaka::tahun($p->tahun_periode), 
                                                        'kinerja'                       =>  $p->kinerja,
                                                        'kehadiran'                     =>  $p->kehadiran,
                                                        'nama_skpd'                     =>  $this::nama_skpd($p->skpd_id),
                                                        'waktu_cetak'                   =>  Pustaka::balik(date('Y'."-".'m'."-".'d'))." / ". date('H'.":".'i'.":".'s'),
                                                        'pic'                           =>  Pustaka::nama_pegawai($profil->gelardpn, $profil->nama, $profil->gelarblk),


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
    protected function PuskesmasTPPReportDetail(Request $request)
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

            'nama_puskesmas'    => Pustaka::capital_string($this->nama_puskesmas($request->puskesmas_id)),


            'jm_data_pegawai'   => TPPReportData::WHERE('tpp_report_id', $x->tpp_report_id)->WHERE('unit_kerja_id', $request->puskesmas_id)->count(),
            'jm_data_capaian'   => TPPReportData::WHERE('tpp_report_id', $x->tpp_report_id)->WHERE('unit_kerja_id', $request->puskesmas_id)->count(),

            'status'            => $x->status,



        );
        return $tpp;
    }

    protected function TPPReportDataDetail(Request $request)
    {

        $x = TPPReportData::
           
            //CAPAIAN SKP
            leftjoin('db_pare_2018.capaian_bulanan AS capaian', function ($join) {
                $join->on('capaian.id', '=', 'tpp_report_data.capaian_bulanan_id');
            })
            ->select([
                'tpp_report_data.id AS tpp_report_data_id',
                'tpp_report_data.jabatan AS jabatan',
                'tpp_report_data.eselon AS eselon',
                'tpp_report_data.unit_kerja AS unit_kerja',
                'tpp_report_data.golongan AS golongan',
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
            //CAPAIAN SKP
            leftjoin('db_pare_2018.capaian_bulanan AS capaian', function ($join) {
                $join->on('capaian.id', '=', 'tpp_report_data.capaian_bulanan_id');
            })
            //TPP Report
            ->leftjoin('db_pare_2018.tpp_report AS tpp_report', function ($join) {
                $join->on('tpp_report.id', '=', 'tpp_report_data.tpp_report_id');
            })
            //ambil nip
            ->leftjoin('demo_asn.tb_pegawai AS pegawai', function ($join) {
                $join->on('pegawai.id', '=', 'tpp_report_data.pegawai_id');
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
                'tpp_report_data.jabatan AS jabatan',
                'tpp_report_data.eselon AS eselon',
                'capaian.id AS capaian_id',
                'tpp_report.formula_hitung_id',
                'tpp_report.bulan',
                'tpp_report.periode_id',
                'pegawai.nip AS nip'


            ])
            ->WHERE('tpp_report_data.id', $request->tpp_report_data_id)
            ->first();
        //FORMULA HITUNG
        $formula    = FormulaHitungTPP::WHERE('id',$x->formula_hitung_id)->first();


        
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

            //CARI CAPAIAN BULANAN TERBARU
            'data_baru'             => $this->update_capaian($x->pegawai_id,$x->nip,$x->periode_id,$x->bulan,$x->formula_hitung_id,$x->pot_kinerja),

 

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
                                ->orderBy('tpp_report.created_at', 'DESC')
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

    public function PuskesmasTTPReportList(Request $request)
    {

        $puskesmas_id = $request->puskesmas_id;

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
            ->addColumn('jumlah_data', function ($x) use( $puskesmas_id) {
                return TPPReportData::WHERE('tpp_report_id', $x->tpp_report_id)
                                    ->WHERE('unit_kerja_id', $puskesmas_id)
                                    ->count();
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
                'jumlah_pegawai'    =>  count($this->PegawaiSKPD($skpd_id)),
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

        //CAri formulasi perhitungan nya
        $formula    = FormulaHitungTPP::WHERE('id',Input::get('formula_hitung_id'))->first();
        $kinerja    = $formula->kinerja;
        $kehadiran  = $formula->kehadiran;

        //Save data untuk TPP report ini
        if ($st_kt->save()) {

            //jika berhasil
            $tpp_report_id = $st_kt->id; 

            //ambil data periode skp bulanan, jikatpp report januari, maka skp bulanan nya adalah skp bulan sebelumnya
          
            $bulan_lalu = Pustaka::bulan_lalu($st_kt->bulan);
            $dt = Periode::WHERE('periode.id',$st_kt->periode_id)->first();
            

            //jika bulan januari, maka periode nya cari yang periode sebelumnya
            if ( Input::get('bulan') == 01 ){

                $periode_akhir = date('Y-m-d', strtotime("-1 day", strtotime(date($dt->awal))));

                $data = Periode::WHERE('periode.akhir',$periode_akhir)->first();
                $periode_id = $data->id;

                //jika bln j\nya januari,maka tahuna nya pun min 1
                $periode_tahun = Pustaka::periode_tahun($dt->label) - 1 ;

            }else{
                $periode_id = $st_kt->periode_id;
                $periode_tahun = Pustaka::periode_tahun($dt->label);
            }


            //AMBIL DATA KEHADIRAN   from SIAP WITH ID SKPD AND BULAN TAHUN
            if ( ( $st_kt->skpd_id != 19 ) & ( $st_kt->skpd_id != 39 ) ) {  //kecuali dinkes(19) dan disdik(39)
                $dt             = Periode::WHERE('periode.id',$st_kt->periode_id)->first();
                $month          = $periode_tahun.'-'.$bulan_lalu;
                $data_kehadiran = $this->data_kehadiran($month,$st_kt->skpd_id);
            }else{
                $dt             = Periode::WHERE('periode.id',$st_kt->periode_id)->first();
                $month          = $periode_tahun.'-'.$bulan_lalu;
                $data_kehadiran = null ;
            } 
        
            $pegawai_skpd_list = $this->PegawaiSKPD(Input::get('skpd_id'));
            
            foreach ($pegawai_skpd_list as $x) {

                $skor_capaian = $this->CapaianBulananDetail($x['pegawai_id'],$periode_id,$bulan_lalu);

                

                $skor_kehadiran = 0 ;
                $findWith = (object)['nip' => $x['nip'] ];
                if (!empty($data_kehadiran)) {
                    foreach ( $data_kehadiran AS $dataPegawai ){
                        if ( $dataPegawai->user->nip === $findWith->nip ){
                            $skor_kehadiran = $dataPegawai->summary->percentage;
                        }
                    }
                }
            
                $report_data    = new TPPReportData;
                $report_data->nama_pegawai          = $x['nama'];
                $report_data->tpp_report_id         = $tpp_report_id;
                $report_data->pegawai_id            = $x['pegawai_id'];
                $report_data->capaian_bulanan_id    = $skor_capaian['capaian_bulanan_id'];
                $report_data->skpd                  = $x['skpd'];
                $report_data->skpd_id               = Input::get('skpd_id');
                $report_data->unit_kerja            = $x['unit_kerja'];
                $report_data->eselon                = $x['eselon'];
                $report_data->jabatan               = $x['jabatan'];
                $report_data->golongan              = $x['golongan'];
                $report_data->tpp_rupiah            = $x['tpp_rupiah'];
                //KINERJA
                $report_data->tpp_kinerja           = ( $x['tpp_rupiah'] != null ) ? $x['tpp_rupiah'] * $kinerja/100 : 0 ;
                $report_data->cap_skp               = $skor_capaian['cap_skp'];
                $report_data->skor_cap              = $skor_capaian['skor_cap'];
                $report_data->pot_kinerja           = 0 ;

                //KEHADIRAN
                $report_data->tpp_kehadiran         = ( $x['tpp_rupiah'] != null ) ? $x['tpp_rupiah'] * $kehadiran/100 : 0 ;
                $report_data->skor_kehadiran        = $skor_kehadiran;
                $report_data->pot_kehadiran         = 0;

                //DATA TAMBAHAN
                //$report_data->jm_capaian             = $jm_capaian;
                //$report_data->jm_kegiatan_bulanan       = $jm_kegiatan_bulanan;
                //$report_data->capaian_kinerja_bulanan   = $capaian_kinerja_bulanan;
                //$report_data->penilaian_kode_etik       = $penilaian_kode_etik;


                $report_data->save();
                
            } 
            return \Response::make('sukses', 200);
            
        } else {
            return response()->json(['errors' => "Terjadi Kesalahan saat inset Data"], 500);
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
