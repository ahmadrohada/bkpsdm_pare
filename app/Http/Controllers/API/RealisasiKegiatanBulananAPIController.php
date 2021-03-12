<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SasaranPerjanjianKinerja;
use App\Models\Sasaran;
use App\Models\IndikatorSasaran;
use App\Models\PerjanjianKinerja;
use App\Models\KegiatanSKPTahunan;
use App\Models\KegiatanSKPBulanan;
use App\Models\KegiatanSKPTahunanJFT;
use App\Models\KegiatanSKPBulananJFT;
use App\Models\RealisasiKegiatanBulanan;
use App\Models\RealisasiKegiatanBulananJFT;
use App\Models\RealisasiRencanaAksiEselon3;
use App\Models\RealisasiRencanaAksiEselon4;
use App\Models\RealisasiRencanaAksiKaban;
use App\Models\IndikatorProgram;
use App\Models\Skpd;
use App\Models\Jabatan;
use App\Models\SKPTahunan;
use App\Models\SKPBulanan;
use App\Models\RencanaAksi;

use App\Helpers\Pustaka;
use App\Traits\HitungCapaian;
use App\Traits\BawahanList;
use App\Traits\PJabatan;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;
use File;

class RealisasiKegiatanBulananAPIController extends Controller {
    use HitungCapaian;
    use BawahanList;
    use PJabatan;
    
    public function RealisasiKegiatanBulananDetail(Request $request)
    {
       
        
        $x = RealisasiKegiatanBulanan::
                            leftjoin('db_pare_2018.skp_bulanan_kegiatan AS kegiatan_skp_bulanan', function($join){
                                $join   ->on('kegiatan_skp_bulanan.id','=','realisasi_kegiatan_bulanan.kegiatan_bulanan_id');
                            })
                            ->SELECT(   'realisasi_kegiatan_bulanan.id AS realisasi_kegiatan_bulanan_id',
                                        'realisasi_kegiatan_bulanan.realisasi AS realisasi',
                                        'realisasi_kegiatan_bulanan.satuan',
                                        'kegiatan_skp_bulanan.id',
                                        'realisasi_kegiatan_bulanan.kegiatan_bulanan_id',
                                        'realisasi_kegiatan_bulanan.bukti'
                                    ) 
                            ->WHERE('realisasi_kegiatan_bulanan.id', $request->realisasi_kegiatan_bulanan_id)
                            ->first();

        if ( $x->jabatan_id > 0 ){
            $pelaksana = Pustaka::capital_string($x->Pelaksana->skpd);
        }else{
            $pelaksana = '-';
        }

        //file extension
        if ( $x->bukti != "" ){
            $dtx		    = explode('.', $x->bukti);
            $ext_bukti  	= $dtx[1];
        }else{
            $ext_bukti  	= "";
        }
        
		
		//return  $rencana_aksi;
        $rencana_aksi = array(
            'id'                            => $x->kegiatan_bulanan_id,
            'skp_bulanan_id'                => $x->skp_bulanan_id,
            'kegiatan_bulanan_label'        => $x->KegiatanSKPBulanan->label,
            'kegiatan_bulanan_target'       => $x->KegiatanSKPBulanan->target,
            'kegiatan_bulanan_satuan'       => $x->KegiatanSKPBulanan->satuan,
            'kegiatan_bulanan_output'       => $x->KegiatanSKPBulanan->target.' '.$x->KegiatanSKPBulanan->satuan,
            'pelaksana'                     => Pustaka::capital_string($x->KegiatanSKPBulanan->RencanaAksi->Pelaksana->jabatan),
            'penanggung_jawab'              => Pustaka::capital_string($x->KegiatanSKPBulanan->RencanaAksi->IndikatorKegiatanSKPTahunan->KegiatanSKPTahunan->SubKegiatan->PenanggungJawab->jabatan),
            'kegiatan_tahunan_label'        => $x->KegiatanSKPBulanan->RencanaAksi->IndikatorKegiatanSKPTahunan->KegiatanSKPTahunan->label,
            'kegiatan_tahunan_target'       => $x->KegiatanSKPBulanan->RencanaAksi->IndikatorKegiatanSKPTahunan->KegiatanSKPTahunan->target,
            'kegiatan_tahunan_satuan'       => $x->KegiatanSKPBulanan->RencanaAksi->IndikatorKegiatanSKPTahunan->KegiatanSKPTahunan->satuan,
            'kegiatan_tahunan_waktu'        => $x->KegiatanSKPBulanan->RencanaAksi->IndikatorKegiatanSKPTahunan->KegiatanSKPTahunan->target_waktu,
            'kegiatan_tahunan_cost'         => number_format($x->KegiatanSKPBulanan->RencanaAksi->IndikatorKegiatanSKPTahunan->KegiatanSKPTahunan->cost,'0',',','.'),
            'kegiatan_tahunan_output'       => $x->KegiatanSKPBulanan->RencanaAksi->IndikatorKegiatanSKPTahunan->KegiatanSKPTahunan->target.' '.$x->KegiatanSKPBulanan->RencanaAksi->IndikatorKegiatanSKPTahunan->KegiatanSKPTahunan->satuan,

            'realisasi'                     => $x->realisasi,
            'bukti'                         => $x->bukti,
            'ext_bukti'                     => $ext_bukti,
            'realisasi_kegiatan_bulanan_id' => $x->realisasi_kegiatan_bulanan_id,
 
        );
        return $rencana_aksi;
    }

    
    public function RealisasiKegiatanBulananDetailJFT(Request $request)
    {
       
        
        $x = RealisasiKegiatanBulananJFT::
                            leftjoin('db_pare_2018.skp_bulanan_kegiatan_jft AS kegiatan_skp_bulanan', function($join){
                                $join   ->on('kegiatan_skp_bulanan.id','=','realisasi_kegiatan_bulanan_jft.kegiatan_bulanan_id');
                            })
                            ->join('db_pare_2018.skp_tahunan_kegiatan_jft AS kegiatan_tahunan', function($join){
                                $join   ->on('kegiatan_tahunan.id','=','kegiatan_skp_bulanan.kegiatan_tahunan_id');
                                
                            })
                            ->SELECT(   'realisasi_kegiatan_bulanan_jft.id AS realisasi_kegiatan_bulanan_id',
                                        'realisasi_kegiatan_bulanan_jft.realisasi AS realisasi',
                                        'realisasi_kegiatan_bulanan_jft.satuan',
                                        'kegiatan_skp_bulanan.id',
                                        'realisasi_kegiatan_bulanan_jft.kegiatan_bulanan_id',

                                        'kegiatan_tahunan.id AS kegiatan_tahunan_id',
                                        'kegiatan_tahunan.label AS kegiatan_tahunan_label',
                                        'kegiatan_tahunan.target AS kegiatan_tahunan_target',
                                        'kegiatan_tahunan.satuan AS kegiatan_tahunan_satuan',
                                        'kegiatan_tahunan.cost AS kegiatan_tahunan_cost',
                                        'kegiatan_tahunan.target_waktu AS kegiatan_tahunan_target_waktu'
                                    ) 
                            ->WHERE('realisasi_kegiatan_bulanan_jft.id', $request->realisasi_kegiatan_bulanan_id)
                            ->first();

        if ( $x->jabatan_id > 0 ){
            $pelaksana = Pustaka::capital_string($x->Pelaksana->skpd);
        }else{
            $pelaksana = '-';
        }
		
		//return  $rencana_aksi;
        $rencana_aksi = array( 
            'id'                            => $x->kegiatan_bulanan_id,
            'skp_bulanan_id'                => $x->skp_bulanan_id,
            'label'                         => $x->KegiatanSKPBulanan->label,
            'target'                        => $x->KegiatanSKPBulanan->target,
            'satuan'                        => $x->KegiatanSKPBulanan->satuan,
            'output'                        => $x->KegiatanSKPBulanan->target.' '.$x->KegiatanSKPBulanan->satuan,
            'pelaksana'                     => "-",
            'penanggung_jawab'              => "-",
            'kegiatan_tahunan_label'        => $x->kegiatan_tahunan_label,
            'kegiatan_tahunan_target'       => $x->kegiatan_tahunan_target,
            'kegiatan_tahunan_satuan'       => $x->kegiatan_tahunan_satuan,
            'kegiatan_tahunan_waktu'        => $x->kegiatan_tahunan_target_waktu,
            'kegiatan_tahunan_cost'         => number_format($x->kegiatan_tahunan_cost,'0',',','.'),
            'kegiatan_tahunan_output'       => $x->kegiatan_tahunan_target.' '.$x->kegiatan_tahunan_satuan,

            'realisasi'              => $x->realisasi,
            'realisasi_kegiatan_bulanan_id' => $x->realisasi_kegiatan_bulanan_id,
 
        );
        return $rencana_aksi;
    }

    public function RealisasiKegiatanBulanan1(Request $request) 
    {
        $capaian_id     = $request->capaian_id;
        $skp_bulanan    = SKPBulanan::WHERE('id',$request->skp_bulanan_id)->first();
        $jabatan_id     = $skp_bulanan->PegawaiYangDinilai->id_jabatan;
        $jenis_jabatan  = $skp_bulanan->PegawaiYangDinilai->Eselon->id_jenis_jabatan;
        $renja_id       = $skp_bulanan->SKPTahunan->renja_id;
        $bulan          = $skp_bulanan->bulan;

        //BAWAHAN ESELON II normal
        $bawahan = $this->BawahanListCapaianBulanan($jabatan_id,$jenis_jabatan); 
        //ARRAY BAWAHAN
        foreach ($bawahan as $x) {   
            $bawahan_id_list[] = $x->jabatan_id ;
        }
     
        $capaian_id_bawahan = SKPTahunan::WHERE('skp_tahunan.renja_id',$renja_id)
                                
                                    ->join('demo_asn.tb_history_jabatan AS jabatan', function($join) use($bawahan_id_list){
                                        $join   ->ON('jabatan.id','=','skp_tahunan.u_jabatan_id');
                                        $join   ->WHEREIN('jabatan.id_jabatan',$bawahan_id_list);
                                    })
                                    ->join('db_pare_2018.skp_bulanan AS skp_bulanan', function($join) use($bulan) {
                                        $join   ->ON('skp_tahunan.id','=','skp_bulanan.skp_tahunan_id');
                                        $join   ->WHERE('skp_bulanan.bulan','=',$bulan);
                                    }) 
                                    ->join('db_pare_2018.capaian_bulanan AS capaian_bulanan', function($join) use($bulan){
                                        $join   ->ON('capaian_bulanan.skp_bulanan_id','=','skp_bulanan.id');
                                        $join   ->WHERE('skp_bulanan.bulan','=',$bulan);
                                    }) 
                                    ->SELECT('capaian_bulanan.id AS capaian_id')
                                    ->get()->toArray();

        $dt1 = RealisasiRencanaAksiKaban::
                                        join('db_pare_2018.skp_tahunan_rencana_aksi AS rencana_aksi', function($join){
                                            $join   ->ON('rencana_aksi.id','=','realisasi_rencana_aksi_eselon2.rencana_aksi_id');
                                        }) 
                                        ->join('db_pare_2018.realisasi_rencana_aksi_kabid AS realisasi_eselon3', function($join) use($capaian_id_bawahan){
                                            $join   ->ON('realisasi_eselon3.rencana_aksi_id','=','realisasi_rencana_aksi_eselon2.rencana_aksi_id');
                                            $join   ->WHEREIN('realisasi_eselon3.capaian_id',$capaian_id_bawahan);
                                        }) 
                                        ->join('db_pare_2018.capaian_bulanan AS capaian_bulanan_bawahan', function($join){
                                            $join   ->ON('capaian_bulanan_bawahan.id','=','realisasi_eselon3.capaian_id');
                                        })
                                        ->SELECT(   'realisasi_rencana_aksi_eselon2.id AS realisasi_rencana_aksi_id',
                                                    'realisasi_rencana_aksi_eselon2.realisasi AS realisasi_target',
                                                    'realisasi_rencana_aksi_eselon2.satuan AS realisasi_satuan',
                                                    'rencana_aksi.label',
                                                    'rencana_aksi.target',
                                                    'rencana_aksi.satuan',
                                                    'realisasi_eselon3.realisasi AS realisasi_bawahan',
                                                    'realisasi_eselon3.satuan AS satuan_bawahan',
                                                    'capaian_bulanan_bawahan.u_jabatan_id'

                                        ) 
                                       
                                        ->WHERE('realisasi_rencana_aksi_eselon2.capaian_id',$capaian_id);
                                        //->get(); 

        $dt2 = RealisasiRencanaAksiKaban::
                                        join('db_pare_2018.skp_tahunan_rencana_aksi AS rencana_aksi', function($join){
                                            $join   ->ON('rencana_aksi.id','=','realisasi_rencana_aksi_eselon2.rencana_aksi_id');
                                        }) 
                                        ->join('db_pare_2018.realisasi_rencana_aksi_kasubid AS realisasi_eselon3', function($join) use($capaian_id_bawahan){
                                            $join   ->ON('realisasi_eselon3.rencana_aksi_id','=','realisasi_rencana_aksi_eselon2.rencana_aksi_id');
                                            $join   ->WHEREIN('realisasi_eselon3.capaian_id',$capaian_id_bawahan);
                                        }) 
                                        ->join('db_pare_2018.capaian_bulanan AS capaian_bulanan_bawahan', function($join){
                                            $join   ->ON('capaian_bulanan_bawahan.id','=','realisasi_eselon3.capaian_id');
                                        })
                                        ->SELECT(   'realisasi_rencana_aksi_eselon2.id AS realisasi_rencana_aksi_id',
                                                    'realisasi_rencana_aksi_eselon2.realisasi AS realisasi_target',
                                                    'realisasi_rencana_aksi_eselon2.satuan AS realisasi_satuan',
                                                    'rencana_aksi.label',
                                                    'rencana_aksi.target',
                                                    'rencana_aksi.satuan',
                                                    'realisasi_eselon3.realisasi AS realisasi_bawahan',
                                                    'realisasi_eselon3.satuan AS satuan_bawahan',
                                                    'capaian_bulanan_bawahan.u_jabatan_id'

                                        ) 
                                       
                                        ->WHERE('realisasi_rencana_aksi_eselon2.capaian_id',$capaian_id);
                                        

        //$dt = $dt1->merge($dt2);
        $dt = $dt1->unionAll($dt2)->get();

        $datatables = Datatables::of($dt)
        ->addColumn('realisasi_rencana_aksi_id', function ($x){
            return $x->realisasi_rencana_aksi_id;
        })->addColumn('rencana_aksi_label', function ($x) {
            return $x->label; 
        })->addColumn('rencana_aksi_target', function ($x) {
            return    $x->target." ".$x->satuan;
        })->addColumn('rencana_aksi_realisasi', function ($x) {
            return   ( $x->realisasi_target == null )? "-": ( $x->realisasi_target." ".$x->realisasi_satuan );
        })->addColumn('persentasi_realisasi_rencana_aksi', function ($x) {
            return   Pustaka::persen($x->realisasi_target,$x->target);
        })->addColumn('rencana_aksi_realisasi_bawahan', function ($x) {
            return   ( $x->realisasi_bawahan == null )? "-": ( $x->realisasi_bawahan." ".$x->satuan_bawahan );
        })->addColumn('jabatan_bawahan', function ($x) {
            return Pustaka::capital_string( $this->JabatanFromHistoryId($x->u_jabatan_id) );
        })->addColumn('status_skp', function ($x) use($skp_bulanan){
            return $skp_bulanan->status;
        });

        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true); 
        
        
    } 

    public function RealisasiKegiatanBulanan2(Request $request) 
    {
            
        $skp_bln = SKPBulanan::WHERE('id',$request->skp_bulanan_id)->SELECT('bulan','status','skp_tahunan_id')->first();
        
        //cari bawahan  , jabatanpelaksanan
        $pelaksana_id = Jabatan::
                        leftjoin('demo_asn.m_skpd AS pelaksana', function($join){
                            $join   ->on('pelaksana.parent_id','=','m_skpd.id');
                        })
                        ->SELECT('pelaksana.id')
                        ->WHERE('m_skpd.parent_id', $request->jabatan_id )
                        ->get();
                        //->toArray(); 

        //ada beberapa eselon 4 yang melaksanakan kegiatan sendiri, kasus kasi dan lurah nagasari 23/0/2020
        //sehingga dicoba untuk kegiatan bawahan nya juga diikutsertakan
        $penanggung_jawab_id = Jabatan::
                                        SELECT('m_skpd.id')
                                        ->WHERE('m_skpd.parent_id', $request->jabatan_id )
                                        ->get();
                                        //->toArray();
        $pelaksana_id = $pelaksana_id->merge($penanggung_jawab_id);               
                        


        $capaian_id = $request->capaian_id;
        
        $dt = RencanaAksi::
                    WITH(['IndikatorKegiatanSKPTahunan'])
                        ->WhereHas('IndikatorKegiatanSKPTahunan', function($q){
                    }) 
                    ->WHEREIN('skp_tahunan_rencana_aksi.jabatan_id',$pelaksana_id )
                    ->WHERE('skp_tahunan_rencana_aksi.waktu_pelaksanaan',$skp_bln->bulan)
                    ->WHERE('skp_tahunan_rencana_aksi.renja_id',$skp_bln->SKPTahunan->renja_id)
                    ->leftjoin('db_pare_2018.skp_bulanan_kegiatan AS kegiatan_bulanan', function($join){
                        $join   ->on('kegiatan_bulanan.rencana_aksi_id','=','skp_tahunan_rencana_aksi.id');
                        //$join   ->WHERE('kegiatan_bulanan.skp_tahunan_id','=', $skp_tahunan_id );
                    })
                    ->leftjoin('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join){
                        $join   ->on('kegiatan_tahunan.id','=','skp_tahunan_rencana_aksi.kegiatan_tahunan_id');
                        //$join   ->WHERE('kegiatan_bulanan.skp_tahunan_id','=', $skp_tahunan_id );
                    })
                    ->leftjoin('db_pare_2018.realisasi_kegiatan_bulanan', function($join){
                        $join   ->on('realisasi_kegiatan_bulanan.kegiatan_bulanan_id','=','kegiatan_bulanan.id');
                    })
                    //realisasi bawahan
                    ->leftjoin('db_pare_2018.realisasi_rencana_aksi_kasubid AS realisasi_rencana_aksi', function($join) use($capaian_id){
                        $join   ->on('realisasi_rencana_aksi.rencana_aksi_id','=','skp_tahunan_rencana_aksi.id');
                        $join   ->where('realisasi_rencana_aksi.capaian_id','!=', $capaian_id);
                    })
                    //self rencana aksi
                    ->leftjoin('db_pare_2018.realisasi_rencana_aksi_kabid AS realisasi_kabid', function($join) use($capaian_id){
                        $join   ->on('realisasi_kabid.rencana_aksi_id','=','skp_tahunan_rencana_aksi.id');
                        $join   ->where('realisasi_kabid.capaian_id','=', $capaian_id);
                    })
                    ->SELECT(   'skp_tahunan_rencana_aksi.id AS rencana_aksi_id',
                                'skp_tahunan_rencana_aksi.label AS rencana_aksi_label',
                                'skp_tahunan_rencana_aksi.jabatan_id AS pelaksana_id',
                                'skp_tahunan_rencana_aksi.kegiatan_tahunan_id',
                                'skp_tahunan_rencana_aksi.indikator_kegiatan_tahunan_id',
                                'skp_tahunan_rencana_aksi.target AS rencana_aksi_target',
                                'skp_tahunan_rencana_aksi.satuan AS rencana_aksi_satuan',

                                'kegiatan_tahunan.label AS kegiatan_tahunan_label',

                                'kegiatan_bulanan.label AS kegiatan_bulanan_label',
                                'kegiatan_bulanan.id AS kegiatan_bulanan_id',
                                'kegiatan_bulanan.target AS kegiatan_bulanan_target',
                                'kegiatan_bulanan.satuan AS kegiatan_bulanan_satuan',


                                'realisasi_rencana_aksi.id AS realisasi_rencana_aksi_bawahan_id',
                                'realisasi_rencana_aksi.realisasi AS realisasi_rencana_aksi_bawahan',
                                'realisasi_rencana_aksi.satuan AS satuan_rencana_aksi_bawahan',

                                'realisasi_kabid.id AS realisasi_rencana_aksi_id',
                                'realisasi_kabid.realisasi AS realisasi_rencana_aksi',
                                'realisasi_kabid.satuan AS satuan_rencana_aksi'

                            ) 
                    ->GroupBy('skp_tahunan_rencana_aksi.id')
                    ->orderBY('skp_tahunan_rencana_aksi.label','ASC')
                    ->get();
        
        $skp_id = $request->skp_bulanan_id;


        $datatables = Datatables::of($dt)
        ->addColumn('skp_bulanan_id', function ($x) use($skp_id){
            return $skp_id;
        })->addColumn('kegiatan_tahunan_label', function ($x) {
            return $x->IndikatorKegiatanSKPTahunan->KegiatanSKPTahunan->label;
        })->addColumn('persentasi_realisasi_rencana_aksi', function ($x) {
            return   Pustaka::persen($x->realisasi_rencana_aksi,$x->rencana_aksi_target);
        })->addColumn('penanggung_jawab', function ($x) {
            if ( $x->IndikatorKegiatanSKPTahunan->KegiatanSKPTahunan->SubKegiatan ){
                return Pustaka::capital_string($x->IndikatorKegiatanSKPTahunan->KegiatanSKPTahunan->SubKegiatan->PenanggungJawab->jabatan);
            }else{
                return "";
            } 
        })->addColumn('pelaksana', function ($x) {
            if ( $x->pelaksana_id != null ){
                $dt = SKPD::WHERE('id',$x->pelaksana_id)->SELECT('skpd')->first();
                $pelaksana = Pustaka::capital_string($dt->skpd);
            }else{
                $pelaksana = "-";
            }
            return $pelaksana;
        })->addColumn('status_skp', function ($x) use($skp_bln){
            return $skp_bln->status;
        });

        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true); 
        
    } 

    public function RealisasiKegiatanBulanan3(Request $request)
    {
            
        $skp_bln = SKPBulanan::WHERE('id',$request->skp_bulanan_id)->SELECT('skp_tahunan_id','bulan','status','skp_tahunan_id')->first();
        $renja_id = $skp_bln->SKPTahunan->renja_id;
        $skp_tahunan_id = $skp_bln->SKPTahunan->id;
        $jabatan_id = $request->jabatan_id;

        //Cari bawahan ( staff nya ), 
        $child = Jabatan::
                            WHERE('id',$jabatan_id )
                            ->orwhere(function ($query) use($jabatan_id) {
                                $query  ->where('parent_id',$jabatan_id )
                                        ->Where('id_eselon', '!=', 7 );
                            })
                            ->SELECT('id')
                            ->get() 
                            ->toArray(); 

        $keg_tahunan = $skp_bln->SKPTahunan->KegiatanSKPTahunan;
        
        $capaian_id = $request->capaian_id;

        //return  $keg_tahunan;
     

        $dt = RencanaAksi:: 
                    WITH(['IndikatorKegiatanSKPTahunan'])
                        ->WhereHas('IndikatorKegiatanSKPTahunan', function($q){
                    }) 
                    ->WHEREIN('skp_tahunan_rencana_aksi.jabatan_id',$child )
                    //->WHEREIN('skp_tahunan_rencana_aksi.kegiatan_tahunan_id',$keg_tahunan )
                    ->WHERE('skp_tahunan_rencana_aksi.waktu_pelaksanaan','=',$skp_bln->bulan)
                    ->WHERE('skp_tahunan_rencana_aksi.renja_id','=',$renja_id)
                    ->leftjoin('db_pare_2018.skp_bulanan_kegiatan AS kegiatan_bulanan', function($join) use($skp_tahunan_id){
                        $join   ->on('kegiatan_bulanan.rencana_aksi_id','=','skp_tahunan_rencana_aksi.id');
                        //$join   ->WHERE('kegiatan_bulanan.skp_tahunan_id','=', $skp_tahunan_id );
                    })
                    ->leftjoin('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join){
                        $join   ->on('kegiatan_tahunan.id','=','skp_tahunan_rencana_aksi.kegiatan_tahunan_id');
                        //$join   ->WHERE('kegiatan_bulanan.skp_tahunan_id','=', $skp_tahunan_id );
                    })
                    ->leftjoin('db_pare_2018.realisasi_kegiatan_bulanan AS realisasi_bawahan ', function($join){
                        $join   ->on('realisasi_bawahan.kegiatan_bulanan_id','=','kegiatan_bulanan.id');
                    })
                    ->leftjoin('db_pare_2018.realisasi_rencana_aksi_kasubid AS realisasi_rencana_aksi', function($join) use($capaian_id){
                        $join   ->on('realisasi_rencana_aksi.rencana_aksi_id','=','skp_tahunan_rencana_aksi.id');
                        $join   ->where('realisasi_rencana_aksi.capaian_id','=', $capaian_id);
                    }) 
                    ->SELECT(   'skp_tahunan_rencana_aksi.id AS rencana_aksi_id',
                                'skp_tahunan_rencana_aksi.label AS rencana_aksi_label',
                                'skp_tahunan_rencana_aksi.jabatan_id AS pelaksana_id',
                                'skp_tahunan_rencana_aksi.kegiatan_tahunan_id',
                                'skp_tahunan_rencana_aksi.indikator_kegiatan_tahunan_id',
                                'skp_tahunan_rencana_aksi.target AS rencana_aksi_target',
                                'skp_tahunan_rencana_aksi.satuan AS rencana_aksi_satuan',

                                'kegiatan_tahunan.label AS kegiatan_tahunan_label',

                                'kegiatan_bulanan.label AS kegiatan_bulanan_label',
                                'kegiatan_bulanan.id AS kegiatan_bulanan_id',
                                'kegiatan_bulanan.target AS kegiatan_bulanan_target',
                                'kegiatan_bulanan.satuan AS kegiatan_bulanan_satuan',
                                
                                'realisasi_bawahan.id AS realisasi_kegiatan_bulanan_bawahan_id',
                                'realisasi_bawahan.realisasi AS realisasi_bawahan',
                                'realisasi_bawahan.satuan AS satuan_realisasi_bawahan',
                                'realisasi_bawahan.bukti AS bukti_realisasi_bawahan',
                                'realisasi_bawahan.alasan_tidak_tercapai',

                                'realisasi_rencana_aksi.id AS realisasi_rencana_aksi_id',
                                'realisasi_rencana_aksi.realisasi AS realisasi_rencana_aksi',
                                'realisasi_rencana_aksi.satuan AS satuan_rencana_aksi',
                                'realisasi_rencana_aksi.bukti' 

                            ) 
                    ->GroupBy('skp_tahunan_rencana_aksi.id')
                    ->get();
        
        $skp_id = $request->skp_bulanan_id;


        $datatables = Datatables::of($dt)
        ->addColumn('skp_bulanan_id', function ($x) use($skp_id){
            return $skp_id;
        })
        ->addColumn('persentasi_realisasi_rencana_aksi', function ($x) {
            return   Pustaka::persen($x->realisasi_rencana_aksi,$x->rencana_aksi_target);
        })
        ->addColumn('kegiatan_tahunan_label', function ($x) {

            if ( $x->IndikatorKegiatanSKPTahunan ){
                return $x->IndikatorKegiatanSKPTahunan->KegiatanSKPTahunan->label; 
            }else{
                return "-"; 
            }
            
            
        })
        ->addColumn('pelaksana', function ($x) {
            if ( $x->pelaksana_id != null ){
                $dt = SKPD::WHERE('id',$x->pelaksana_id)->SELECT('skpd')->first();
                $pelaksana = Pustaka::capital_string($dt->skpd);
            }else{
                $pelaksana = "-";
            }
            return $pelaksana;
        })
        ->addColumn('status_skp', function ($x) use($skp_bln){
            return $skp_bln->status;
        });

        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true);
        
    } 

    public function RealisasiKegiatanBulanan4(Request $request)
    {
            
        //$skp_bln = SKPBulanan::WHERE('id',$request->skp_bulanan_id)->SELECT('bulan')->first();

        $dt = KegiatanSKPBulanan::
                    WHERE('skp_bulanan_kegiatan.skp_bulanan_id','=', $request->skp_bulanan_id )
                    ->leftjoin('db_pare_2018.realisasi_kegiatan_bulanan', function($join){
                        $join   ->on('realisasi_kegiatan_bulanan.kegiatan_bulanan_id','=','skp_bulanan_kegiatan.id');
                    })
                    ->SELECT(   'skp_bulanan_kegiatan.id AS kegiatan_bulanan_id',
                                'skp_bulanan_kegiatan.label AS kegiatan_bulanan_label',
                                'skp_bulanan_kegiatan.target',
                                'skp_bulanan_kegiatan.satuan',
                                'realisasi_kegiatan_bulanan.id AS realisasi_kegiatan_bulanan_id',
                                'realisasi_kegiatan_bulanan.realisasi AS realisasi',
                                'realisasi_kegiatan_bulanan.satuan AS realisasi_satuan',
                                'realisasi_kegiatan_bulanan.bukti',
                                'realisasi_kegiatan_bulanan.alasan_tidak_tercapai',
                                'skp_bulanan_kegiatan.rencana_aksi_id'
                            ) 
                    
                    ->get();
        
        $skp_id = $request->skp_bulanan_id;


        $datatables = Datatables::of($dt)
        ->addColumn('kegiatan_bulanan_id', function ($x) use($skp_id){
            return $x->kegiatan_bulanan_id;
        })
        ->addColumn('kegiatan_tahunan_label', function ($x) use($skp_id){
            return $x->RencanaAksi->IndikatorKegiatanSKPTahunan->KegiatanSKPTahunan->label;
        })
        ->addColumn('persentase_realisasi', function ($x) use($skp_id){
            return   Pustaka::persen($x->realisasi,$x->target);

        })
        ->addColumn('capaian_kegiatan_bulanan_id', function ($x) use($skp_id){
            return $x->capaian_kegiatan_bulanan_id;
        });

        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true); 
        
    } 

    public function RealisasiKegiatanBulanan5(Request $request)
    {
            
        //$skp_bln = SKPBulanan::WHERE('id',$request->skp_bulanan_id)->SELECT('bulan')->first();

        $dt = KegiatanSKPBulananJFT::
                    WHERE('skp_bulanan_kegiatan_jft.skp_bulanan_id','=', $request->skp_bulanan_id )
                    ->leftjoin('db_pare_2018.realisasi_kegiatan_bulanan_jft', function($join){
                        $join   ->on('realisasi_kegiatan_bulanan_jft.kegiatan_bulanan_id','=','skp_bulanan_kegiatan_jft.id');
                    })
                    ->SELECT(   'skp_bulanan_kegiatan_jft.id AS kegiatan_bulanan_id',
                                'skp_bulanan_kegiatan_jft.label AS kegiatan_bulanan_label',
                                'skp_bulanan_kegiatan_jft.target',
                                'skp_bulanan_kegiatan_jft.satuan',
                                'skp_bulanan_kegiatan_jft.kegiatan_tahunan_id',
                                'realisasi_kegiatan_bulanan_jft.id AS realisasi_kegiatan_bulanan_id',
                                'realisasi_kegiatan_bulanan_jft.realisasi AS realisasi',
                                'realisasi_kegiatan_bulanan_jft.satuan AS realisasi_satuan',
                                'realisasi_kegiatan_bulanan_jft.bukti',
                                'realisasi_kegiatan_bulanan_jft.alasan_tidak_tercapai',
                                'skp_bulanan_kegiatan_jft.kegiatan_tahunan_id'
                            ) 
                    
                    ->get();
        
        $skp_id = $request->skp_bulanan_id;


        $datatables = Datatables::of($dt)
        ->addColumn('kegiatan_bulanan_id', function ($x) use($skp_id){
            return $x->kegiatan_bulanan_id;
        })
        ->addColumn('kegiatan_tahunan_label', function ($x) use($skp_id){
            return $x->KegiatanTahunan->label;
        })
        ->addColumn('persentase_realisasi', function ($x) use($skp_id){
            return   Pustaka::persen($x->realisasi,$x->target);

        });

        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true); 
        
    } 



    public function Store(Request $request)
    {

        $messages = [
                'kegiatan_bulanan_id.required'      => 'Harus diisi',
                'capaian_id.required'               => 'Harus diisi',
                'target.required'                   => 'Harus diisi',
                'realisasi.required'                => 'Harus diisi',
                'satuan.required'                   => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'kegiatan_bulanan_id'   => 'required',
                            'capaian_id'            => 'required',
                            'target'                => 'required',
                            //'realisasi'             => 'required|numeric|max:'.$request->target,
                            'realisasi'             => 'required|numeric',
                            'satuan'                => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        //UPDATE dulu target nya
        $keg_bulanan            = KegiatanSKPBulanan::find(Input::get('kegiatan_bulanan_id'));
        $keg_bulanan->target    = $request->target;
        $keg_bulanan->save();

        $st_kt    = new RealisasiKegiatanBulanan;

        $st_kt->kegiatan_bulanan_id     = Input::get('kegiatan_bulanan_id');
        $st_kt->capaian_id              = Input::get('capaian_id');
        $st_kt->realisasi               = Input::get('realisasi');
        $st_kt->satuan                  = Input::get('satuan');
        $st_kt->alasan_tidak_tercapai   = Input::get('alasan_tidak_tercapai');
        $st_kt->bukti                   = "";
       

        if ( $st_kt->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }


    public function Update(Request $request)
    {

        $messages = [
                'realisasi_kegiatan_bulanan_id.required'    => 'Harus diisi',
                'kegiatan_bulanan_id.required'              => 'Harus diisi',
                'realisasi.required'                        => 'Harus diisi',
                'target.required'                           => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'realisasi_kegiatan_bulanan_id'     => 'required',
                            'kegiatan_bulanan_id'               => 'required',
                            //'realisasi'                         => 'required|numeric|max:'.$request->target,
                            'realisasi'                         => 'required|numeric',
                            'target'                            => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        //UPDATE dulu target nya
        $keg_bulanan            = KegiatanSKPBulanan::find(Input::get('kegiatan_bulanan_id'));
        $keg_bulanan->target    = $request->target;
        $keg_bulanan->save();

        
        $st_kt    = RealisasiKegiatanBulanan::find(Input::get('realisasi_kegiatan_bulanan_id'));
        if (is_null($st_kt)) {
            return response()->json('Realisasi Kegiatan Bulanan tidak ditemukan.',422);
        }


        $st_kt->realisasi             = Input::get('realisasi');
        if ( $st_kt->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            

    
    }

    public function UpdateBukti(Request $request)
    {

        $messages = [
                'realisasi_kegiatan_bulanan_id.required'    => 'Harus diisi',
                'bukti.required'                           => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'realisasi_kegiatan_bulanan_id'     => 'required',
                            'bukti'                             => 'required',
                        ),
                        $messages
        );


        //mencari nama file lama nya
        $dt = RealisasiKegiatanBulanan::WHERE('id','=', $request->realisasi_kegiatan_bulanan_id )->SELECT('bukti')->first();
        $old_file_name = $dt->bukti;


        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        $st_kt                      = RealisasiKegiatanBulanan::find(Input::get('realisasi_kegiatan_bulanan_id'));
        $st_kt->bukti               = Input::get('bukti');
        if ( $st_kt->save()){

            //hapus file bukti lama nya
            $destinationPath = 'files_upload';
            File::delete($destinationPath.'/'.$old_file_name);
            
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
    }
   

    public function Destroy(Request $request)
    {

        $messages = [
                'realisasi_kegiatan_bulanan_id.required'   => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'realisasi_kegiatan_bulanan_id'   => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        //mencari nama file  nya
        $dt = RealisasiKegiatanBulanan::WHERE('id','=', $request->realisasi_kegiatan_bulanan_id )->SELECT('bukti')->first();
        $old_file_name = $dt->bukti;
        $destinationPath = 'files_upload';

        
        $st_kt    = RealisasiKegiatanBulanan::find(Input::get('realisasi_kegiatan_bulanan_id'));
        if (is_null($st_kt)) {
            return $this->sendError('Realisasi Kegiatan Bulanan tidak ditemukan.');
        }


        if ( $st_kt->delete()){
            //hapus file bukti lama nya
            if ( $old_file_name != null ){
                File::delete($destinationPath.'/'.$old_file_name);
            }
            
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    } 


//================================== jft  ===================================================//

    public function StoreJFT(Request $request)
    {

        $messages = [
                'kegiatan_bulanan_id.required'      => 'Harus diisi',
                'capaian_id.required'               => 'Harus diisi',
                'realisasi.required'           => 'Harus diisi',
                'satuan.required'                   => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'kegiatan_bulanan_id'   => 'required',
                            'capaian_id'        => 'required',
                            'realisasi'        => 'required',
                            'satuan'                => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $st_kt    = new RealisasiKegiatanBulananJFT;

        $st_kt->kegiatan_bulanan_id     = Input::get('kegiatan_bulanan_id');
        $st_kt->capaian_id              = Input::get('capaian_id');
        $st_kt->realisasi               = Input::get('realisasi');
        $st_kt->satuan                  = Input::get('satuan');
        $st_kt->alasan_tidak_tercapai   = Input::get('alasan_tidak_tercapai');
        $st_kt->bukti                   = "";
    

        if ( $st_kt->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            

    }


    public function UpdateJFT(Request $request)
    {

        $messages = [
                'realisasi_kegiatan_bulanan_id.required'   => 'Harus diisi',
                'realisasi.required'                => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'realisasi_kegiatan_bulanan_id'   => 'required',
                            'realisasi'                => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $st_kt    = RealisasiKegiatanBulananJFT::find(Input::get('realisasi_kegiatan_bulanan_id'));
        if (is_null($st_kt)) {
            return response()->json('Realisasi Kegiatan Bulanan tidak ditemukan.',422);
        }


        $st_kt->realisasi             = Input::get('realisasi');
        if ( $st_kt->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            


    }


    public function DestroyJFT(Request $request)
    {

        $messages = [
                'realisasi_kegiatan_bulanan_id.required'   => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'realisasi_kegiatan_bulanan_id'   => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $st_kt    = RealisasiKegiatanBulananJFT::find(Input::get('realisasi_kegiatan_bulanan_id'));
        if (is_null($st_kt)) {
            return $this->sendError('Realisasi Kegiatan Bulanan tidak ditemukan.');
        }


        if ( $st_kt->delete()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            

    } 




}
