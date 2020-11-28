<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Renja;
use App\Models\Kegiatan;
use App\Models\Tujuan;
use App\Models\Sasaran;
use App\Models\Program;
use App\Models\IndikatorProgram;
use App\Models\IndikatorSasaran;
use App\Models\Pegawai;
use App\Models\Jabatan;
use App\Models\SKPTahunan;
use App\Models\RencanaAksi;

use App\Helpers\Pustaka;


use Datatables;
use Validator;
use Gravatar;
use Input;
Use PDF;

class KontrakKinerjaAPIController extends Controller {

    protected function nama_skpd($skpd_id)
    {
        //nama SKPD 
        $nama_skpd       = \DB::table('demo_asn.m_skpd AS skpd')
            ->WHERE('id', $skpd_id)
            ->SELECT(['skpd.skpd AS skpd'])
            ->first();
        return $nama_skpd->skpd;
    }

   //SASARAN KOntrak kinerja JFU
   public function SasaranStrategisJFU(Request $request)
   {
       $jabatan_id     = $request->get('jabatan_id');
       $renja_id       = $request->get('renja_id');
       $skp_tahunan_id = $request->get('skp_tahunan_id');
      
        //KEGIATAN pelaksana
        $rencana_aksi = RencanaAksi::WHERE('jabatan_id',$jabatan_id)
                                    ->WHERE('renja_id',$renja_id)
                                    ->leftjoin('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join){
                                        $join  ->on('skp_tahunan_rencana_aksi.kegiatan_tahunan_id','=','kegiatan_tahunan.id');
                                    })
                                    /* ->leftjoin('db_pare_2018.renja_indikator_kegiatan AS indikator_kegiatan', function($join){
                                        $join  ->on('skp_tahunan_rencana_aksi._indikator_kegiatan_id','=','indikator_kegiatan.id');
                                    }) */
                                    ->SELECT(   'skp_tahunan_rencana_aksi.id AS rencana_aksi_id',
                                                'skp_tahunan_rencana_aksi.label AS rencana_aksi_label',
                                                'kegiatan_tahunan.label AS kegiatan_label',
                                                'kegiatan_tahunan.id AS kegiatan_tahunan_id',
                                                'skp_tahunan_rencana_aksi.target',
                                                'skp_tahunan_rencana_aksi.satuan',
                                                'kegiatan_tahunan.angka_kredit',
                                                'kegiatan_tahunan.quality',
                                                'kegiatan_tahunan.cost',
                                                'kegiatan_tahunan.target_waktu'

                                            ) 
                                    ->groupBy('kegiatan_tahunan.label')
                                    ->groupBy('skp_tahunan_rencana_aksi.label')
                                    //->WHERE('kegiatan_tahunan.skp_tahunan_id','=',$skp_tahunan_id)
                                    ->distinct()
                                    ->get(); 

       $datatables = Datatables::of($rencana_aksi)
                           ->addColumn('id', function ($x) {
                               return $x->kegiatan_tahunan_id;
                           })
                           ->addColumn('kegiatan', function ($x) {
                               return Pustaka::capital_string($x->kegiatan_label);
                           })
                           ->addColumn('indikator', function ($x) {
                               return Pustaka::capital_string($x->rencana_aksi_label);
                           })
                           ->addColumn('kk_status', function ($x) {
                               return 1 ;
                           })
                           ->addColumn('target', function ($x) {
                               return $x->target." ".$x->satuan;
                           });
                           
       
                           if ($keyword = $request->get('search')['value']) {
                               $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
                           } 
       return $datatables->make(true);


   }

   //aNGGARAN KOntrak kinerja JFU
   public function AnggaranKegiatanJFU(Request $request)
   {
       $jabatan_id     = $request->get('jabatan_id');
       $renja_id       = $request->get('renja_id');
       $skp_tahunan_id = $request->get('skp_tahunan_id');
      
        //KEGIATAN pelaksana
        $rencana_aksi = RencanaAksi::WHERE('jabatan_id',$jabatan_id)
                                    ->WHERE('renja_id',$renja_id)
                                    ->leftjoin('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join){
                                        $join  ->on('skp_tahunan_rencana_aksi.kegiatan_tahunan_id','=','kegiatan_tahunan.id');
                                    })
                                    /* ->leftjoin('db_pare_2018.renja_indikator_kegiatan AS indikator_kegiatan', function($join){
                                        $join  ->on('skp_tahunan_rencana_aksi._indikator_kegiatan_id','=','indikator_kegiatan.id');
                                    }) */
                                    ->SELECT(   'skp_tahunan_rencana_aksi.id AS rencana_aksi_id',
                                                'skp_tahunan_rencana_aksi.label AS rencana_aksi_label',
                                                'kegiatan_tahunan.label AS kegiatan_label',
                                                'kegiatan_tahunan.id AS kegiatan_tahunan_id',
                                                'skp_tahunan_rencana_aksi.target',
                                                'skp_tahunan_rencana_aksi.satuan',
                                                'kegiatan_tahunan.angka_kredit',
                                                'kegiatan_tahunan.quality',
                                                'kegiatan_tahunan.cost as anggaran',
                                                'kegiatan_tahunan.target_waktu'

                                            ) 
                                    ->groupBy('kegiatan_tahunan.id')
                                    //->orderBY('skp_tahunan_rencana_aksi.label')
                                    ->distinct()
                                    ->get(); 

       $datatables = Datatables::of($rencana_aksi)
                            ->addColumn('kegiatan_id', function ($x) {
                               return $x->kegiatan_tahunan_id;
                            })
                            ->addColumn('kegiatan_label', function ($x) {
                               return Pustaka::capital_string($x->kegiatan_label);
                            })
                            ->addColumn('kk_status', function ($x) {
                                return 1 ;
                            })
                            ->addColumn('anggaran', function ($x) {
                                return "Rp.   " . number_format( $x->anggaran, '0', ',', '.');
                            });
                          
                           
       
                           if ($keyword = $request->get('search')['value']) {
                               $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
                           } 
       return $datatables->make(true);


   }

   public function TotalAnggaranKegiatanJFU(Request $request)
   {
    $jabatan_id     = $request->get('jabatan_id');
    $renja_id       = $request->get('renja_id');
    $skp_tahunan_id = $request->get('skp_tahunan_id');
   
     //KEGIATAN pelaksana
     $dt = RencanaAksi::WHERE('jabatan_id',$jabatan_id)
                                 ->WHERE('renja_id',$renja_id)
                                 ->leftjoin('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join){
                                     $join  ->on('skp_tahunan_rencana_aksi.kegiatan_tahunan_id','=','kegiatan_tahunan.id');
                                 })
                                 /* ->leftjoin('db_pare_2018.renja_indikator_kegiatan AS indikator_kegiatan', function($join){
                                     $join  ->on('skp_tahunan_rencana_aksi._indikator_kegiatan_id','=','indikator_kegiatan.id');
                                 }) */
                                 ->SELECT(   
                                             'kegiatan_tahunan.cost as anggaran'

                                         ) 
                                 ->groupBy('kegiatan_tahunan.id')
                                 //->orderBY('skp_tahunan_rencana_aksi.label')
                                 ->distinct()
                                 ->get(); 

       $total_anggaran = 0 ;
       foreach ($dt as $x) {
           $total_anggaran = $total_anggaran + $x->anggaran;
       }

       $ta = array(
               'total_anggaran'    => "Rp.   " . number_format( $total_anggaran, '0', ',', '.'),
               );
       return $ta;
   }

   public function cetakKontrakKinerjaJFU(Request $request)
    {
        $jabatan_id     = $request->get('jabatan_id');
        $renja_id       = $request->get('renja_id');
        $skp_tahunan_id = $request->get('skp_tahunan_id');
       

        $data_1 = RencanaAksi::WHERE('jabatan_id',$jabatan_id)
                                    ->WHERE('renja_id',$renja_id)
                                    ->leftjoin('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join){
                                        $join  ->on('skp_tahunan_rencana_aksi.kegiatan_tahunan_id','=','kegiatan_tahunan.id');
                                    })
                                    ->SELECT(   'skp_tahunan_rencana_aksi.id AS rencana_aksi_id',
                                                'skp_tahunan_rencana_aksi.label AS rencana_aksi_label',
                                                'kegiatan_tahunan.label AS kegiatan_label',
                                                'kegiatan_tahunan.id AS kegiatan_tahunan_id',
                                                'skp_tahunan_rencana_aksi.target',
                                                'skp_tahunan_rencana_aksi.satuan',
                                                'kegiatan_tahunan.angka_kredit',
                                                'kegiatan_tahunan.quality',
                                                'kegiatan_tahunan.cost',
                                                'kegiatan_tahunan.target_waktu'

                                            ) 
                                    ->groupBy('kegiatan_tahunan.label')
                                    ->groupBy('skp_tahunan_rencana_aksi.label')
                                    //->WHERE('kegiatan_tahunan.skp_tahunan_id','=',$skp_tahunan_id)
                                    ->distinct()
                                    ->get(); 
        $data_2 = RencanaAksi::WHERE('jabatan_id',$jabatan_id)
                                    ->WHERE('renja_id',$renja_id)
                                    ->leftjoin('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join){
                                        $join  ->on('skp_tahunan_rencana_aksi.kegiatan_tahunan_id','=','kegiatan_tahunan.id');
                                    })
                                    /* ->leftjoin('db_pare_2018.renja_indikator_kegiatan AS indikator_kegiatan', function($join){
                                        $join  ->on('skp_tahunan_rencana_aksi._indikator_kegiatan_id','=','indikator_kegiatan.id');
                                    }) */
                                    ->SELECT(   'skp_tahunan_rencana_aksi.id AS rencana_aksi_id',
                                                'skp_tahunan_rencana_aksi.label AS rencana_aksi_label',
                                                'kegiatan_tahunan.label AS kegiatan_label',
                                                'kegiatan_tahunan.id AS kegiatan_tahunan_id',
                                                'skp_tahunan_rencana_aksi.target',
                                                'skp_tahunan_rencana_aksi.satuan',
                                                'kegiatan_tahunan.angka_kredit',
                                                'kegiatan_tahunan.quality',
                                                'kegiatan_tahunan.cost as anggaran',
                                                'kegiatan_tahunan.target_waktu'

                                            ) 
                                    ->groupBy('kegiatan_tahunan.id')
                                    //->orderBY('skp_tahunan_rencana_aksi.label')
                                    ->distinct()
                                    ->get(); 

        $total_anggaran = 0 ;
        foreach ($data_2 as $x) {
            $total_anggaran = $total_anggaran + $x->anggaran;
        }

        //NAMA SKPD
        $Renja = Renja::WHERE('renja.id',$renja_id )
                ->leftjoin('demo_asn.tb_history_jabatan AS jabatan', function ($join) {
                    $join->on('jabatan.id', '=', 'renja.kepala_skpd_id');
                })
                ->leftjoin('demo_asn.m_eselon AS eselon', function ($join) {
                    $join->on('eselon.id', '=', 'jabatan.id_eselon');
                })
                ->leftjoin('demo_asn.m_jenis_jabatan AS j_jabatan', function ($join) {
                    $join->on('j_jabatan.id', '=', 'eselon.id_jenis_jabatan');
                })
                ->leftjoin('db_pare_2018.periode AS periode', function ($join) {
                    $join->on('periode.id', '=', 'renja.periode_id');
                })
                ->leftjoin('db_pare_2018.masa_pemerintahan AS masa_pemerintahan', function ($join) {
                    $join->on('masa_pemerintahan.id', '=', 'periode.masa_pemerintahan_id');
                })
                ->SELECT(   'renja.periode_id',
                            'renja.skpd_id',
                            'renja.kepala_skpd_id',
                            'renja.nama_kepala_skpd',
                            'renja.created_at AS tgl_dibuat',
                            'jabatan.nip AS nip_ka_skpd',
                            'j_jabatan.jenis_jabatan AS jenis_jabatan_ka_skpd',
                            'masa_pemerintahan.kepala_daerah AS nama_bupati'
                        )
                ->first();

        //NAMA ADMIN
        $user_x  = \Auth::user();
        $profil  = Pegawai::WHERE('tb_pegawai.id',  $user_x->id_pegawai)->first();

        //JAbatan
        $jabatan = SKPTahunan::WHERE('id',$skp_tahunan_id)->first();
        $pdf = PDF::loadView('pare_pns.printouts.cetak_kontrak_kinerja-JFU', [   
                                                    'data'          => $data_1 ,
                                                    'data_2'        => $data_2 ,
                                                    'total_anggaran'=> $total_anggaran,
                                                    'tgl_dibuat'    => $Renja->tgl_dibuat,
                                                    'periode'       => Pustaka::tahun($Renja->periode->awal),
                                                    'nama_skpd'     => $this::nama_skpd($Renja->skpd_id),
                                                    //DATA ASN YANG DINILAI
                                                    'nama_pejabat'  => $jabatan->u_nama,
                                                    'nip_pejabat'   => $jabatan->PejabatYangDinilai->nip,
                                                    'jenis_jabatan' => $jabatan->PejabatYangDinilai->Eselon->JenisJabatan->jenis_jabatan,
                                                    'jabatan'       => $jabatan->PejabatYangDinilai->jabatan,
                                                    //DATA ASN PNILAI
                                                    'nama_atasan'  => $jabatan->p_nama,
                                                    'nip_atasan'   => $jabatan->PejabatPenilai->nip,
                                                    'jenis_jabatan_atasan' => $jabatan->PejabatPenilai->Eselon->JenisJabatan->jenis_jabatan,
                                                    'jabatan_atasan'       => $jabatan->PejabatPenilai->jabatan,
                                                    //DATA KA SKPD
                                                    'nama_ka_skpd'  => $Renja->nama_kepala_skpd,
                                                    'nip_ka_skpd'   => $Renja->nip_ka_skpd,
                                                    'jenis_jabatan_ka_skpd'=> $Renja->jenis_jabatan_ka_skpd,
                                                    'nama_bupati'   => $Renja->nama_bupati,
                                                    'waktu_cetak'   => Pustaka::balik(date('Y'."-".'m'."-".'d'))." / ". date('H'.":".'i'.":".'s'),


                                                     ], [], [
                                                     'format' => 'A4-P'
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
        //return $pdf->stream('TPP'.$p->bulan.'_'.$this::nama_skpd($p->skpd_id).'.pdf');
        return $pdf->stream('KontrakKinerja'.$jabatan->PejabatYangDinilai->nip.'_'.Pustaka::tahun($Renja->periode->awal).'.pdf');
    }


//===============================================================================================================================//
//============================================================   J F T    =======================================================//
//===============================================================================================================================//


   //SASARAN KOntrak kinerja JFT
   public function SasaranStrategisJFT(Request $request)
   {
       $jabatan_id     = $request->get('jabatan_id');
       $renja_id       = $request->get('renja_id');
       $skp_tahunan_id_a = $request->get('skp_tahunan_id');


       $dt_atasan = SKPTahunan::
                                leftjoin('db_pare_2018.skp_tahunan AS skp_atasan', function($join){
                                    $join  ->on('skp_atasan.u_jabatan_id','=','skp_tahunan.p_jabatan_id');
                                })
                                ->SELECT(   'skp_atasan.id AS skp_atasan_id',
                                            'skp_atasan.u_nama AS nama_atasan'

                                        )
                                ->WHERE('skp_tahunan.id',$skp_tahunan_id_a)

                                ->first();


      
      
        //KEGIATAN pelaksana
        $skp_tahunan_id = $request->skp_tahunan_id;

        $kegiatan = Kegiatan::SELECT('id','label')
                            ->WHERE('renja_kegiatan.renja_id', $request->renja_id )
                            ->rightjoin('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join) use ( $skp_tahunan_id ){
                                $join   ->on('kegiatan_tahunan.kegiatan_id','=','renja_kegiatan.id');
                                $join   ->WHERE('kegiatan_tahunan.skp_tahunan_id','=', $skp_tahunan_id );
                            })
                            ->SELECT(   'renja_kegiatan.id AS kegiatan_id',
                                        'renja_kegiatan.label AS kegiatan_label',
                                        'kegiatan_tahunan.label AS kegiatan_tahunan_label',
                                        'kegiatan_tahunan.id AS kegiatan_tahunan_id',
                                        'kegiatan_tahunan.target',
                                        'kegiatan_tahunan.satuan',
                                        'kegiatan_tahunan.angka_kredit',
                                        'kegiatan_tahunan.quality',
                                        'kegiatan_tahunan.cost',
                                        'kegiatan_tahunan.target_waktu',

                                        'renja_kegiatan.target AS renja_target',
                                        'renja_kegiatan.satuan AS renja_satuan',
                                        'renja_kegiatan.cost AS renja_biaya'
                                    ) 
                            ->get();

        return $kegiatan;

       $datatables = Datatables::of($rencana_aksi)
                           ->addColumn('id', function ($x) {
                               return $x->kegiatan_tahunan_id;
                           })
                           ->addColumn('kegiatan', function ($x) {
                               return Pustaka::capital_string($x->kegiatan_label);
                           })
                           ->addColumn('indikator', function ($x) {
                               return Pustaka::capital_string($x->rencana_aksi_label);
                           })
                           ->addColumn('kk_status', function ($x) {
                               return 1 ;
                           })
                           ->addColumn('target', function ($x) {
                               return $x->target." ".$x->satuan;
                           });
                           
       
                           if ($keyword = $request->get('search')['value']) {
                               $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
                           } 
       return $datatables->make(true);


   }

   //aNGGARAN KOntrak kinerja JFT
   public function AnggaranKegiatanJFT(Request $request)
   {
       $jabatan_id     = $request->get('jabatan_id');
       $renja_id       = $request->get('renja_id');
       $skp_tahunan_id = $request->get('skp_tahunan_id');
      
        //KEGIATAN pelaksana
        $rencana_aksi = RencanaAksi::WHERE('jabatan_id',$jabatan_id)
                                    ->WHERE('renja_id',$renja_id)
                                    ->leftjoin('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join){
                                        $join  ->on('skp_tahunan_rencana_aksi.kegiatan_tahunan_id','=','kegiatan_tahunan.id');
                                    })
                                    /* ->leftjoin('db_pare_2018.renja_indikator_kegiatan AS indikator_kegiatan', function($join){
                                        $join  ->on('skp_tahunan_rencana_aksi._indikator_kegiatan_id','=','indikator_kegiatan.id');
                                    }) */
                                    ->SELECT(   'skp_tahunan_rencana_aksi.id AS rencana_aksi_id',
                                                'skp_tahunan_rencana_aksi.label AS rencana_aksi_label',
                                                'kegiatan_tahunan.label AS kegiatan_label',
                                                'kegiatan_tahunan.id AS kegiatan_tahunan_id',
                                                'skp_tahunan_rencana_aksi.target',
                                                'skp_tahunan_rencana_aksi.satuan',
                                                'kegiatan_tahunan.angka_kredit',
                                                'kegiatan_tahunan.quality',
                                                'kegiatan_tahunan.cost as anggaran',
                                                'kegiatan_tahunan.target_waktu'

                                            ) 
                                    ->groupBy('kegiatan_tahunan.id')
                                    //->orderBY('skp_tahunan_rencana_aksi.label')
                                    ->distinct()
                                    ->get(); 

       $datatables = Datatables::of($rencana_aksi)
                            ->addColumn('kegiatan_id', function ($x) {
                               return $x->kegiatan_tahunan_id;
                            })
                            ->addColumn('kegiatan_label', function ($x) {
                               return Pustaka::capital_string($x->kegiatan_label);
                            })
                            ->addColumn('kk_status', function ($x) {
                                return 1 ;
                            })
                            ->addColumn('anggaran', function ($x) {
                                return "Rp.   " . number_format( $x->anggaran, '0', ',', '.');
                            });
                          
                           
       
                           if ($keyword = $request->get('search')['value']) {
                               $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
                           } 
       return $datatables->make(true);


   }

   public function TotalAnggaranKegiatanJFT(Request $request)
   {
    $jabatan_id     = $request->get('jabatan_id');
    $renja_id       = $request->get('renja_id');
    $skp_tahunan_id = $request->get('skp_tahunan_id');
   
     //KEGIATAN pelaksana
     $dt = RencanaAksi::WHERE('jabatan_id',$jabatan_id)
                                 ->WHERE('renja_id',$renja_id)
                                 ->leftjoin('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join){
                                     $join  ->on('skp_tahunan_rencana_aksi.kegiatan_tahunan_id','=','kegiatan_tahunan.id');
                                 })
                                 /* ->leftjoin('db_pare_2018.renja_indikator_kegiatan AS indikator_kegiatan', function($join){
                                     $join  ->on('skp_tahunan_rencana_aksi._indikator_kegiatan_id','=','indikator_kegiatan.id');
                                 }) */
                                 ->SELECT(   
                                             'kegiatan_tahunan.cost as anggaran'

                                         ) 
                                 ->groupBy('kegiatan_tahunan.id')
                                 //->orderBY('skp_tahunan_rencana_aksi.label')
                                 ->distinct()
                                 ->get(); 

       $total_anggaran = 0 ;
       foreach ($dt as $x) {
           $total_anggaran = $total_anggaran + $x->anggaran;
       }

       $ta = array(
               'total_anggaran'    => "Rp.   " . number_format( $total_anggaran, '0', ',', '.'),
               );
       return $ta;
   }

   public function cetakKontrakKinerjaJFT(Request $request)
    {
        $jabatan_id     = $request->get('jabatan_id');
        $renja_id       = $request->get('renja_id');
        $skp_tahunan_id = $request->get('skp_tahunan_id');
       

        $data_1 = RencanaAksi::WHERE('jabatan_id',$jabatan_id)
                                    ->WHERE('renja_id',$renja_id)
                                    ->leftjoin('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join){
                                        $join  ->on('skp_tahunan_rencana_aksi.kegiatan_tahunan_id','=','kegiatan_tahunan.id');
                                    })
                                    ->SELECT(   'skp_tahunan_rencana_aksi.id AS rencana_aksi_id',
                                                'skp_tahunan_rencana_aksi.label AS rencana_aksi_label',
                                                'kegiatan_tahunan.label AS kegiatan_label',
                                                'kegiatan_tahunan.id AS kegiatan_tahunan_id',
                                                'skp_tahunan_rencana_aksi.target',
                                                'skp_tahunan_rencana_aksi.satuan',
                                                'kegiatan_tahunan.angka_kredit',
                                                'kegiatan_tahunan.quality',
                                                'kegiatan_tahunan.cost',
                                                'kegiatan_tahunan.target_waktu'

                                            ) 
                                    ->groupBy('kegiatan_tahunan.label')
                                    ->groupBy('skp_tahunan_rencana_aksi.label')
                                    //->WHERE('kegiatan_tahunan.skp_tahunan_id','=',$skp_tahunan_id)
                                    ->distinct()
                                    ->get(); 
        $data_2 = RencanaAksi::WHERE('jabatan_id',$jabatan_id)
                                    ->WHERE('renja_id',$renja_id)
                                    ->leftjoin('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join){
                                        $join  ->on('skp_tahunan_rencana_aksi.kegiatan_tahunan_id','=','kegiatan_tahunan.id');
                                    })
                                    /* ->leftjoin('db_pare_2018.renja_indikator_kegiatan AS indikator_kegiatan', function($join){
                                        $join  ->on('skp_tahunan_rencana_aksi._indikator_kegiatan_id','=','indikator_kegiatan.id');
                                    }) */
                                    ->SELECT(   'skp_tahunan_rencana_aksi.id AS rencana_aksi_id',
                                                'skp_tahunan_rencana_aksi.label AS rencana_aksi_label',
                                                'kegiatan_tahunan.label AS kegiatan_label',
                                                'kegiatan_tahunan.id AS kegiatan_tahunan_id',
                                                'skp_tahunan_rencana_aksi.target',
                                                'skp_tahunan_rencana_aksi.satuan',
                                                'kegiatan_tahunan.angka_kredit',
                                                'kegiatan_tahunan.quality',
                                                'kegiatan_tahunan.cost as anggaran',
                                                'kegiatan_tahunan.target_waktu'

                                            ) 
                                    ->groupBy('kegiatan_tahunan.id')
                                    //->orderBY('skp_tahunan_rencana_aksi.label')
                                    ->distinct()
                                    ->get(); 

        $total_anggaran = 0 ;
        foreach ($data_2 as $x) {
            $total_anggaran = $total_anggaran + $x->anggaran;
        }

        //NAMA SKPD
        $Renja = Renja::WHERE('renja.id',$renja_id )
                ->leftjoin('demo_asn.tb_history_jabatan AS jabatan', function ($join) {
                    $join->on('jabatan.id', '=', 'renja.kepala_skpd_id');
                })
                ->leftjoin('demo_asn.m_eselon AS eselon', function ($join) {
                    $join->on('eselon.id', '=', 'jabatan.id_eselon');
                })
                ->leftjoin('demo_asn.m_jenis_jabatan AS j_jabatan', function ($join) {
                    $join->on('j_jabatan.id', '=', 'eselon.id_jenis_jabatan');
                })
                ->leftjoin('db_pare_2018.periode AS periode', function ($join) {
                    $join->on('periode.id', '=', 'renja.periode_id');
                })
                ->leftjoin('db_pare_2018.masa_pemerintahan AS masa_pemerintahan', function ($join) {
                    $join->on('masa_pemerintahan.id', '=', 'periode.masa_pemerintahan_id');
                })
                ->SELECT(   'renja.periode_id',
                            'renja.skpd_id',
                            'renja.kepala_skpd_id',
                            'renja.nama_kepala_skpd',
                            'renja.created_at AS tgl_dibuat',
                            'jabatan.nip AS nip_ka_skpd',
                            'j_jabatan.jenis_jabatan AS jenis_jabatan_ka_skpd',
                            'masa_pemerintahan.kepala_daerah AS nama_bupati'
                        )
                ->first();

        //NAMA ADMIN
        $user_x  = \Auth::user();
        $profil  = Pegawai::WHERE('tb_pegawai.id',  $user_x->id_pegawai)->first();

        //JAbatan
        $jabatan = SKPTahunan::WHERE('id',$skp_tahunan_id)->first();
        $pdf = PDF::loadView('pare_pns.printouts.cetak_kontrak_kinerja-JFU', [   
                                                    'data'          => $data_1 ,
                                                    'data_2'        => $data_2 ,
                                                    'total_anggaran'=> $total_anggaran,
                                                    'tgl_dibuat'    => $Renja->tgl_dibuat,
                                                    'periode'       => Pustaka::tahun($Renja->periode->awal),
                                                    'nama_skpd'     => $this::nama_skpd($Renja->skpd_id),
                                                    //DATA ASN YANG DINILAI
                                                    'nama_pejabat'  => $jabatan->u_nama,
                                                    'nip_pejabat'   => $jabatan->PejabatYangDinilai->nip,
                                                    'jenis_jabatan' => $jabatan->PejabatYangDinilai->Eselon->JenisJabatan->jenis_jabatan,
                                                    'jabatan'       => $jabatan->PejabatYangDinilai->jabatan,
                                                    //DATA ASN PNILAI
                                                    'nama_atasan'  => $jabatan->p_nama,
                                                    'nip_atasan'   => $jabatan->PejabatPenilai->nip,
                                                    'jenis_jabatan_atasan' => $jabatan->PejabatPenilai->Eselon->JenisJabatan->jenis_jabatan,
                                                    'jabatan_atasan'       => $jabatan->PejabatPenilai->jabatan,
                                                    //DATA KA SKPD
                                                    'nama_ka_skpd'  => $Renja->nama_kepala_skpd,
                                                    'nip_ka_skpd'   => $Renja->nip_ka_skpd,
                                                    'jenis_jabatan_ka_skpd'=> $Renja->jenis_jabatan_ka_skpd,
                                                    'nama_bupati'   => $Renja->nama_bupati,
                                                    'waktu_cetak'   => Pustaka::balik(date('Y'."-".'m'."-".'d'))." / ". date('H'.":".'i'.":".'s'),


                                                     ], [], [
                                                     'format' => 'A4-P'
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
        //return $pdf->stream('TPP'.$p->bulan.'_'.$this::nama_skpd($p->skpd_id).'.pdf');
        return $pdf->stream('KontrakKinerja'.$jabatan->PejabatYangDinilai->nip.'_'.Pustaka::tahun($Renja->periode->awal).'.pdf');
    }


}
