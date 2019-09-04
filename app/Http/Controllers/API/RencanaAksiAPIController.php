<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PeriodeTahunan;
use App\Models\PerjanjianKinerja;
use App\Models\KegiatanSKPTahunan;
use App\Models\KegiatanSKPBulanan;
use App\Models\CapaianRencanaAksi;



use App\Models\Tujuan;
use App\Models\IndikatorTujuan;
use App\Models\Sasaran;
use App\Models\Skpd;
use App\Models\SKPTahunan;
use App\Models\RencanaAksi;


use App\Models\SasaranPerjanjianKinerja;
use App\Models\IndikatorSasaran;
use App\Models\Program;
use App\Models\IndikatorProgram;
use App\Models\Kegiatan;
use App\Models\IndikatorKegiatan;
use App\Models\PetaJabatan;
use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class RencanaAksiAPIController extends Controller {



    public function rencana_aksi_tree(Request $request)
    {
       

        $skp_tahunan = SKPTahunan::where('id','=', $request->skp_tahunan_id )->select('id','perjanjian_kinerja_id')->get();
		foreach ($skp_tahunan as $x) {
            $data_skp['id']	            = "skp_tahunan_id".$x->id;
			$data_skp['text']			= "SKP Tahunan ".$x->Perjanjian_kinerja->renja->periode->label;
            $data_skp['icon']           = "jstree-file";
            $data_skp['type']           = "level_1";
            

            $keg_tugas_jabatan = KegiatanSKPTahunan::where('skp_tahunan_id','=',$x->id)->select('id','label')->get();
            foreach ($keg_tugas_jabatan as $y) {
                $data_kegiatan_skp['id']	        = "kabid".$y->id;
                $data_kegiatan_skp['text']			= Pustaka::capital_string($y->label);
                $data_kegiatan_skp['icon']          = "jstree-kegiatan";
                $data_kegiatan_skp['type']          = "level_2";


                $rencana_aksi = RencanaAksi::where('kegiatan_tugas_jabatan_id','=',$y->id)->select('id','label')->get();
                foreach ($rencana_aksi as $z) {
                    $data_rencana_aksi['id']	        = "kasubid".$z->id;
                    $data_rencana_aksi['text']			= Pustaka::capital_string($z->label);
                    $data_rencana_aksi['icon']          = "jstree-ind_kegiatan";
                    

                    
                    $kasubid_list[] = $data_rencana_aksi ;
                    unset($data_rencana_aksi['children']);
                
                }

                if(!empty($kasubid_list)) {
                    $data_kegiatan_skp['children']     = $kasubid_list;
                }
                $kabid_list[] = $data_kegiatan_skp ;
                $kasubid_list = "";
                unset($data_kegiatan_skp['children']);
            
            }
               
               

        }	

            if(!empty($kabid_list)) {
                $data_skp['children']     = $kabid_list;
            }
            $data[] = $data_skp ;	
            $kabid_list = "";
            unset($data_skp['children']);
		
		return $data;
        
    }



    public function RencanaAksiList(Request $request)
    {
            
       
        $dt = RencanaAksi::WHERE('kegiatan_tahunan_id','=', $request->kegiatan_tahunan_id )

                            ->select([   
                                'id AS rencana_aksi_id',
                                'label',
                                'target',
                                'satuan',
                                'waktu_pelaksanaan',
                                'jabatan_id'
                                
                                ])
                            ->orderBy('waktu_pelaksanaan','ASC')
                            ->orderBy('id','DESC')
                            ->get();

                 
                
        $datatables = Datatables::of($dt)
        ->addColumn('label', function ($x) {
            return $x->label;
        })
        ->addColumn('kegiatan_bulanan', function ($x) {
            $kb =  KegiatanSKPBulanan::WHERE('rencana_aksi_id',$x->rencana_aksi_id)->SELECT('id')->count();
            return $kb;
        })
        ->addColumn('target', function ($x) {
            
            return $x->target.' '.$x->satuan;
          
        })
        ->addColumn('pelaksana', function ($x) {
            if ($x->jabatan_id > 0 ){
                return Pustaka::capital_string($x->Pelaksana->jabatan);
            }else{
                return '-';
            }
        })     
        ->addColumn('waktu_pelaksanaan', function ($x) {
            return Pustaka::bulan($x->waktu_pelaksanaan);
        });

        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true); 
        
    }

    public function RencanaAksiList4(Request $request)
    {
            
       
        $dt = RencanaAksi::WHERE('kegiatan_tahunan_id','=', $request->kegiatan_tahunan_id )
                ->WHERE('jabatan_id',$request->jabatan_id)

                ->select([   
                    'id AS rencana_aksi_id',
                    'label',
                    'waktu_pelaksanaan',
                    'jabatan_id'
                    
                    ])
                
                ->get();

                
                
        $datatables = Datatables::of($dt)
        ->addColumn('label', function ($x) {
            return $x->label;
        })
        ->addColumn('pelaksana', function ($x) {
            if ($x->jabatan_id > 0 ){
                return Pustaka::capital_string($x->Pelaksana->jabatan);
            }else{
                return '-';
            }
             
        })
        ->addColumn('waktu_pelaksanaan', function ($x) {
            return Pustaka::bulan($x->waktu_pelaksanaan);
        });

        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true); 
        
    }
 
    public function RencanaAksiDetail1(Request $request)
    {
       
        $x = RencanaAksi::
                    WHERE('skp_tahunan_rencana_aksi.id', $request->rencana_aksi_id)
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
                    ->leftjoin('db_pare_2018.realisasi_rencana_aksi_kaban AS realisasi_rencana_aksi', function($join){
                        $join   ->on('realisasi_rencana_aksi.rencana_aksi_id','=','skp_tahunan_rencana_aksi.id');
                    })
                    ->SELECT(   'skp_tahunan_rencana_aksi.id AS rencana_aksi_id',
                                'skp_tahunan_rencana_aksi.label AS rencana_aksi_label',
                                'skp_tahunan_rencana_aksi.target AS target_rencana_aksi',
                                'skp_tahunan_rencana_aksi.satuan AS satuan_target_rencana_aksi',
                                'skp_tahunan_rencana_aksi.jabatan_id AS pelaksana_id',
                                'skp_tahunan_rencana_aksi.kegiatan_tahunan_id',
                                'skp_tahunan_rencana_aksi.waktu_pelaksanaan',
                                'kegiatan_bulanan.label AS kegiatan_bulanan_label',
                                'kegiatan_bulanan.id AS kegiatan_bulanan_id',
                                'kegiatan_bulanan.target AS target_pelaksana',
                                'kegiatan_bulanan.satuan AS satuan_pelaksana',
                                'realisasi_kegiatan_bulanan.id AS realisasi_kegiatan_bulanan_id',
                                'realisasi_kegiatan_bulanan.realisasi AS realisasi',
                                'realisasi_kegiatan_bulanan.satuan AS realisasi_satuan',
                                'realisasi_kegiatan_bulanan.bukti',
                                'realisasi_kegiatan_bulanan.alasan_tidak_tercapai',
                                'realisasi_rencana_aksi.id AS realisasi_rencana_aksi_id',
                                'realisasi_rencana_aksi.realisasi AS realisasi_rencana_aksi',
                                'realisasi_rencana_aksi.satuan AS satuan_rencana_aksi'

                            ) 
                    ->first();
        if ( $x->pelaksana_id != null ){
            $dt = SKPD::WHERE('id',$x->pelaksana_id)->SELECT('skpd')->first();
            $pelaksana = Pustaka::capital_string($dt->skpd);
        }else{
            $pelaksana = "-";
        }

		
		//return  $rencana_aksi;
        $rencana_aksi = array(
            'id'                            => $x->rencana_aksi_id,
            'label'                         => $x->rencana_aksi_label,
            'target_rencana_aksi'           => $x->target_rencana_aksi,
            'satuan_target_rencana_aksi'    => $x->satuan_target_rencana_aksi,
            'kegiatan_bulanan_label'        => $x->kegiatan_bulanan_label,
            'kegiatan_bulanan_target'       => $x->target_pelaksana,
            'kegiatan_bulanan_satuan'       => $x->satuan_pelaksana,
            'kegiatan_bulanan_output'       => $x->target_pelaksana." ".$x->satuan_pelaksana,
            'realisasi'                     => $x->realisasi,
            'realisasi_satuan'              => $x->realisasi_satuan,
            'realisasi_output'              => $x->realisasi." ".$x->realisasi_satuan,

            'realisasi_rencana_aksi'        => $x->realisasi_rencana_aksi,
            'satuan_rencana_aksi'           => $x->satuan_rencana_aksi,



            'waktu_pelaksanaan'             => $x->waktu_pelaksanaan,
            'jabatan_id'                    => $x->pelaksana_id,
            'penanggung_jawab'              => Pustaka::capital_string($x->KegiatanTahunan->Kegiatan->PenanggungJawab->jabatan),
            'nama_jabatan'                  => $pelaksana,
            'pelaksana'                     => $pelaksana,
            'kegiatan_tahunan_label'        => $x->KegiatanTahunan->label,
            'kegiatan_tahunan_target'       => $x->KegiatanTahunan->target,
            'kegiatan_tahunan_satuan'       => $x->KegiatanTahunan->satuan,
            'kegiatan_tahunan_waktu'        => $x->KegiatanTahunan->target_waktu,
            'kegiatan_tahunan_cost'         => number_format($x->KegiatanTahunan->cost,'0',',','.'),
            'kegiatan_tahunan_output'       => $x->KegiatanTahunan->target.' '.$x->KegiatanTahunan->satuan,
 
        );
        return $rencana_aksi;
    }

    public function RencanaAksiDetail2(Request $request)
    {
       
        $x = RencanaAksi::
                    WHERE('skp_tahunan_rencana_aksi.id', $request->rencana_aksi_id)
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
                    ->leftjoin('db_pare_2018.realisasi_rencana_aksi_kabid AS realisasi_rencana_aksi', function($join){
                        $join   ->on('realisasi_rencana_aksi.rencana_aksi_id','=','skp_tahunan_rencana_aksi.id');
                    })
                    ->SELECT(   'skp_tahunan_rencana_aksi.id AS rencana_aksi_id',
                                'skp_tahunan_rencana_aksi.label AS rencana_aksi_label',
                                'skp_tahunan_rencana_aksi.target AS target_rencana_aksi',
                                'skp_tahunan_rencana_aksi.satuan AS satuan_target_rencana_aksi',
                                'skp_tahunan_rencana_aksi.jabatan_id AS pelaksana_id',
                                'skp_tahunan_rencana_aksi.kegiatan_tahunan_id',
                                'skp_tahunan_rencana_aksi.waktu_pelaksanaan',
                                'kegiatan_bulanan.label AS kegiatan_bulanan_label',
                                'kegiatan_bulanan.id AS kegiatan_bulanan_id',
                                'kegiatan_bulanan.target AS target_pelaksana',
                                'kegiatan_bulanan.satuan AS satuan_pelaksana',
                                'realisasi_kegiatan_bulanan.id AS realisasi_kegiatan_bulanan_id',
                                'realisasi_kegiatan_bulanan.realisasi AS realisasi',
                                'realisasi_kegiatan_bulanan.satuan AS realisasi_satuan',
                                'realisasi_kegiatan_bulanan.bukti',
                                'realisasi_kegiatan_bulanan.alasan_tidak_tercapai',
                                'realisasi_rencana_aksi.id AS realisasi_rencana_aksi_id',
                                'realisasi_rencana_aksi.realisasi AS realisasi_rencana_aksi',
                                'realisasi_rencana_aksi.satuan AS satuan_rencana_aksi'

                            ) 
                    ->first();
        if ( $x->pelaksana_id != null ){
            $dt = SKPD::WHERE('id',$x->pelaksana_id)->SELECT('skpd')->first();
            $pelaksana = Pustaka::capital_string($dt->skpd);
        }else{
            $pelaksana = "-";
        }

		
		//return  $rencana_aksi;
        $rencana_aksi = array(
            'id'                            => $x->rencana_aksi_id,
            'label'                         => $x->rencana_aksi_label,
            'target_rencana_aksi'           => $x->target_rencana_aksi,
            'satuan_target_rencana_aksi'    => $x->satuan_target_rencana_aksi,
            'kegiatan_bulanan_label'        => $x->kegiatan_bulanan_label,
            'kegiatan_bulanan_target'       => $x->target_pelaksana,
            'kegiatan_bulanan_satuan'       => $x->satuan_pelaksana,
            'kegiatan_bulanan_output'       => $x->target_pelaksana." ".$x->satuan_pelaksana,
            'realisasi'                     => $x->realisasi,
            'realisasi_satuan'              => $x->realisasi_satuan,
            'realisasi_output'              => $x->realisasi." ".$x->realisasi_satuan,

            'realisasi_rencana_aksi'        => $x->realisasi_rencana_aksi,
            'satuan_rencana_aksi'           => $x->satuan_rencana_aksi,



            'waktu_pelaksanaan'             => $x->waktu_pelaksanaan,
            'jabatan_id'                    => $x->pelaksana_id,
            'penanggung_jawab'              => Pustaka::capital_string($x->KegiatanTahunan->Kegiatan->PenanggungJawab->jabatan),
            'nama_jabatan'                  => $pelaksana,
            'pelaksana'                     => $pelaksana,
            'kegiatan_tahunan_label'        => $x->KegiatanTahunan->label,
            'kegiatan_tahunan_target'       => $x->KegiatanTahunan->target,
            'kegiatan_tahunan_satuan'       => $x->KegiatanTahunan->satuan,
            'kegiatan_tahunan_waktu'        => $x->KegiatanTahunan->target_waktu,
            'kegiatan_tahunan_cost'         => number_format($x->KegiatanTahunan->cost,'0',',','.'),
            'kegiatan_tahunan_output'       => $x->KegiatanTahunan->target.' '.$x->KegiatanTahunan->satuan,
 
        );
        return $rencana_aksi;
    }

    public function RencanaAksiDetail3(Request $request)
    {
       
        $x = RencanaAksi::
                    WHERE('skp_tahunan_rencana_aksi.id', $request->rencana_aksi_id)
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
                    ->leftjoin('db_pare_2018.realisasi_rencana_aksi_kasubid AS realisasi_rencana_aksi', function($join){
                        $join   ->on('realisasi_rencana_aksi.rencana_aksi_id','=','skp_tahunan_rencana_aksi.id');
                    })
                    ->SELECT(   'skp_tahunan_rencana_aksi.id AS rencana_aksi_id',
                                'skp_tahunan_rencana_aksi.label AS rencana_aksi_label',
                                'skp_tahunan_rencana_aksi.target AS target_rencana_aksi',
                                'skp_tahunan_rencana_aksi.satuan AS satuan_target_rencana_aksi',
                                'skp_tahunan_rencana_aksi.jabatan_id AS pelaksana_id',
                                'skp_tahunan_rencana_aksi.kegiatan_tahunan_id',
                                'skp_tahunan_rencana_aksi.waktu_pelaksanaan',
                                'kegiatan_bulanan.label AS kegiatan_bulanan_label',
                                'kegiatan_bulanan.id AS kegiatan_bulanan_id',
                                'kegiatan_bulanan.target AS target_pelaksana',
                                'kegiatan_bulanan.satuan AS satuan_pelaksana',
                                'realisasi_kegiatan_bulanan.id AS realisasi_kegiatan_bulanan_id',
                                'realisasi_kegiatan_bulanan.realisasi AS realisasi',
                                'realisasi_kegiatan_bulanan.satuan AS realisasi_satuan',
                                'realisasi_kegiatan_bulanan.bukti',
                                'realisasi_kegiatan_bulanan.alasan_tidak_tercapai',
                                'realisasi_rencana_aksi.id AS realisasi_rencana_aksi_id',
                                'realisasi_rencana_aksi.realisasi AS realisasi_rencana_aksi',
                                'realisasi_rencana_aksi.satuan AS satuan_rencana_aksi'

                            ) 
                    ->first();
        if ( $x->pelaksana_id != null ){
            $dt = SKPD::WHERE('id',$x->pelaksana_id)->SELECT('skpd')->first();
            $pelaksana = Pustaka::capital_string($dt->skpd);
        }else{
            $pelaksana = "-";
        }

		
		//return  $rencana_aksi;
        $rencana_aksi = array(
            'id'                            => $x->rencana_aksi_id,
            'label'                         => $x->rencana_aksi_label,
            'target_rencana_aksi'           => $x->target_rencana_aksi,
            'satuan_target_rencana_aksi'    => $x->satuan_target_rencana_aksi,
            'kegiatan_bulanan_label'        => $x->kegiatan_bulanan_label,
            'kegiatan_bulanan_target'       => $x->target_pelaksana,
            'kegiatan_bulanan_satuan'       => $x->satuan_pelaksana,
            'kegiatan_bulanan_output'       => $x->target_pelaksana." ".$x->satuan_pelaksana,
            'realisasi'                     => $x->realisasi,
            'realisasi_satuan'              => $x->realisasi_satuan,
            'realisasi_output'              => $x->realisasi." ".$x->realisasi_satuan,

            'realisasi_rencana_aksi'        => $x->realisasi_rencana_aksi,
            'satuan_rencana_aksi'           => $x->satuan_rencana_aksi,



            'waktu_pelaksanaan'             => Pustaka::bulan($x->waktu_pelaksanaan),
            'jabatan_id'                    => $x->pelaksana_id,
            'penanggung_jawab'              => Pustaka::capital_string($x->KegiatanTahunan->Kegiatan->PenanggungJawab->jabatan),
            'nama_jabatan'                  => $pelaksana,
            'pelaksana'                     => $pelaksana,
            'kegiatan_tahunan_label'        => $x->KegiatanTahunan->label,
            'kegiatan_tahunan_target'       => $x->KegiatanTahunan->target,
            'kegiatan_tahunan_satuan'       => $x->KegiatanTahunan->satuan,
            'kegiatan_tahunan_waktu'        => $x->KegiatanTahunan->target_waktu,
            'kegiatan_tahunan_cost'         => number_format($x->KegiatanTahunan->cost,'0',',','.'),
            'kegiatan_tahunan_output'       => $x->KegiatanTahunan->target.' '.$x->KegiatanTahunan->satuan,
 
        );
        return $rencana_aksi;
    }

    public function RencanaAksiDetail4(Request $request)
    {
       
        $x = RencanaAksi::
                    WHERE('skp_tahunan_rencana_aksi.id', $request->rencana_aksi_id)
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
                    ->leftjoin('db_pare_2018.realisasi_rencana_aksi_kasubid AS realisasi_rencana_aksi', function($join){
                        $join   ->on('realisasi_rencana_aksi.rencana_aksi_id','=','skp_tahunan_rencana_aksi.id');
                    })
                    ->SELECT(   'skp_tahunan_rencana_aksi.id AS rencana_aksi_id',
                                'skp_tahunan_rencana_aksi.label AS rencana_aksi_label',
                                'skp_tahunan_rencana_aksi.target AS target_rencana_aksi',
                                'skp_tahunan_rencana_aksi.satuan AS satuan_target_rencana_aksi',
                                'skp_tahunan_rencana_aksi.jabatan_id AS pelaksana_id',
                                'skp_tahunan_rencana_aksi.kegiatan_tahunan_id',
                                'skp_tahunan_rencana_aksi.waktu_pelaksanaan',
                                'kegiatan_bulanan.label AS kegiatan_bulanan_label',
                                'kegiatan_bulanan.id AS kegiatan_bulanan_id',
                                'kegiatan_bulanan.target AS target_pelaksana',
                                'kegiatan_bulanan.satuan AS satuan_pelaksana',
                                'realisasi_kegiatan_bulanan.id AS realisasi_kegiatan_bulanan_id',
                                'realisasi_kegiatan_bulanan.realisasi AS realisasi',
                                'realisasi_kegiatan_bulanan.satuan AS realisasi_satuan',
                                'realisasi_kegiatan_bulanan.bukti',
                                'realisasi_kegiatan_bulanan.alasan_tidak_tercapai',
                                'realisasi_rencana_aksi.id AS realisasi_rencana_aksi_id',
                                'realisasi_rencana_aksi.realisasi AS realisasi_rencana_aksi',
                                'realisasi_rencana_aksi.satuan AS satuan_rencana_aksi'

                            ) 
                    ->first();
        if ( $x->pelaksana_id != null ){
            $dt = SKPD::WHERE('id',$x->pelaksana_id)->SELECT('skpd')->first();
            $pelaksana = Pustaka::capital_string($dt->skpd);
        }else{
            $pelaksana = "-";
        }
 
		
		//return  $rencana_aksi;
        $rencana_aksi = array(
            'id'                            => $x->rencana_aksi_id,
            'label'                         => $x->rencana_aksi_label,
            'target_rencana_aksi'           => $x->target_rencana_aksi,
            'satuan_target_rencana_aksi'    => $x->satuan_target_rencana_aksi,
            'kegiatan_bulanan_label'        => $x->kegiatan_bulanan_label,
            'kegiatan_bulanan_target'       => $x->target_pelaksana,
            'kegiatan_bulanan_satuan'       => $x->satuan_pelaksana,
            'kegiatan_bulanan_output'       => $x->target_pelaksana." ".$x->satuan_pelaksana,
            'realisasi'                     => $x->realisasi,
            'realisasi_satuan'              => $x->realisasi_satuan,
            'realisasi_output'              => $x->realisasi." ".$x->realisasi_satuan,

            'realisasi_rencana_aksi'        => $x->realisasi_rencana_aksi,
            'satuan_rencana_aksi'           => $x->satuan_rencana_aksi,



            'waktu_pelaksanaan'             => $x->waktu_pelaksanaan,
            'jabatan_id'                    => $x->pelaksana_id,
            'penanggung_jawab'              => Pustaka::capital_string($x->KegiatanTahunan->Kegiatan->PenanggungJawab->jabatan),
            'nama_jabatan'                  => $pelaksana,
            'pelaksana'                     => $pelaksana,
            'kegiatan_tahunan_label'        => $x->KegiatanTahunan->label,
            'kegiatan_tahunan_target'       => $x->KegiatanTahunan->target,
            'kegiatan_tahunan_satuan'       => $x->KegiatanTahunan->satuan,
            'kegiatan_tahunan_waktu'        => $x->KegiatanTahunan->target_waktu,
            'kegiatan_tahunan_cost'         => number_format($x->KegiatanTahunan->cost,'0',',','.'),
            'kegiatan_tahunan_output'       => $x->KegiatanTahunan->target.' '.$x->KegiatanTahunan->satuan,
 
        );
        return $rencana_aksi;
    }
    public function Store(Request $request)
    {

        $messages = [
                'kegiatan_tahunan_id.required'  => 'Harus diisi',
                'renja_id.required'             => 'Harus diisi',
                'waktu_pelaksanaan.required'    => 'Harus diisi',
                'pelaksana.required'            => 'Harus diisi',
                'target.required'               => 'Harus diisi',
                'satuan.required'               => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'kegiatan_tahunan_id'   => 'required',
                            'renja_id'              => 'required',
                            'pelaksana'             => 'required|numeric|min:1',
                            'waktu_pelaksanaan'     => 'required',
                            'label'                 => 'required',
                            'target'                => 'required',
                            'satuan'                => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        $target = Input::get('waktu_pelaksanaan');

        for ($i = 0; $i < count($target); $i++){
            $data[] = array(

            'kegiatan_tahunan_id'   => Input::get('kegiatan_tahunan_id'),
            'renja_id'              => Input::get('renja_id'),
            'jabatan_id'            => Input::get('pelaksana'),
            'label'                 => Input::get('label'),
            'waktu_pelaksanaan'     => $target[$i],
            'target'                => Input::get('target'),
            'satuan'                => Input::get('satuan'),
            'created_at'            => date('Y'."-".'m'."-".'d'." ".'H'.":".'i'.":".'s'),
            );



        }

        $st_ra   = new RencanaAksi;
        $st_ra -> insert($data);
    }


    public function Update(Request $request)
    {

        $messages = [
                'rencana_aksi_id.required'       => 'Harus diisi',
                'label.required'                 => 'Harus diisi',
                'target.required'                => 'Harus diisi',
                'satuan.required'                => 'Harus diisi',
                'pelaksana.required'             => 'Harus diisi',
                'waktu_pelaksanaan_edit.required'=> 'Harus diisi'

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'rencana_aksi_id'       => 'required',
                            'pelaksana'             => 'required|numeric|min:1',
                            'label'                 => 'required',
                            'target'                => 'required',
                            'satuan'                => 'required',
                            'waktu_pelaksanaan_edit'=> 'required'
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $st_ra    = RencanaAksi::find(Input::get('rencana_aksi_id'));
        if (is_null($st_ra)) {
            return $this->sendError('Rencana Aksi tidak ditemukan.');
        }


        $st_ra->label               = Input::get('label');
        $st_ra->target              = Input::get('target');
        $st_ra->satuan              = Input::get('satuan');
        $st_ra->jabatan_id          = Input::get('pelaksana');
        $st_ra->waktu_pelaksanaan	= Input::get('waktu_pelaksanaan_edit');

        if ( $st_ra->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }


    public function Hapus(Request $request)
    {

        $messages = [
                'rencana_aksi_id.required'   => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'rencana_aksi_id'   => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $st_ra    = RencanaAksi::find(Input::get('rencana_aksi_id'));
        if (is_null($st_ra)) {
            return $this->sendError('Kegiatan Tahunan tidak ditemukan.');
        }


        if ( $st_ra->delete()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }



}
