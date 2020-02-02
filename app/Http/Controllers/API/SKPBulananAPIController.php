<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Periode;
use App\Models\PerjanjianKinerja;
use App\Models\SKPTahunan;
use App\Models\SKPBulanan;
use App\Models\Pegawai;
use App\Models\HistoryJabatan;
use App\Models\Golongan;
use App\Models\Jabatan;
use App\Models\Eselon;

use App\Models\KegiatanSKPTahunan;
use App\Models\RencanaAksi;
use App\Models\KegiatanSKPBulanan;

use App\Models\KegiatanSKPTahunanJFT;
use App\Models\KegiatanSKPBulananJFT;

use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class SKPBulananAPIController extends Controller {

    //=======================================================================================//
    protected function jabatan($id_jabatan){
        $jabatan       = HistoryJabatan::WHERE('id',$id_jabatan)
                        ->SELECT('jabatan')
                        ->first();
        return Pustaka::capital_string($jabatan->jabatan);
    }

    public function SKPBulanan_timeline_status( Request $request )
    {
        $response = array();
        $body = array();
        $body_2 = array();


        $skp_bulanan = SKPBulanan::where('id','=', $request->skp_bulanan_id )
                                ->select('*')
                                ->firstOrFail();

        
        //CREATED AT - Dibuat
        $x['tag']	    = 'p';
        $x['content']	= 'Dibuat';
        array_push($body, $x);
        $x['tag']	    = 'p';
        $x['content']	= $skp_bulanan->u_nama;
        array_push($body, $x);

        $h['time']	    = $skp_bulanan->created_at->format('Y-m-d H:i:s');
        $h['body']	    = $body;
        array_push($response, $h);
        //=====================================================================//

        //UPDATED AT - Dikirim
        $y['tag']	    = 'p';
        $y['content']	= 'Dikirim';
        array_push($body_2, $y);
        $y['tag']	    = 'p';
        $y['content']	= $skp_bulanan->u_nama;
        array_push($body_2, $y);

        $i['time']	    = $skp_bulanan->updated_at->format('Y-m-d H:i:s');
        $i['body']	    = $body_2;

        if ( $skp_bulanan->updated_at->format('Y') > 1 )
        {
            array_push($response, $i);
        }
        


        return $response;


    }
   
    public function PersonalSKPBulananList(Request $request)
    {
            
        $id_pegawai = $request->pegawai_id;

        $pegawai = Pegawai::SELECT('id')->WHERE('id',$id_pegawai)->first();

        
        $SKPBulanan = SKPBulanan::WHERE('skp_bulanan.pegawai_id',$id_pegawai)
                        //SKP tahunan
                        ->leftjoin('db_pare_2018.skp_tahunan', function($join){
                            $join   ->on('skp_tahunan.id','=','skp_bulanan.skp_tahunan_id');
                        }) 
                        //PERIODE
                        ->leftjoin('db_pare_2018.renja AS renja', function($join){
                            $join   ->on('renja.id','=','skp_tahunan.renja_id');
                        }) 
                        ->leftjoin('db_pare_2018.periode AS periode', function($join){
                            $join   ->on('renja.periode_id','=','periode.id');
                        }) 
                        //SKPD
                        ->leftjoin('demo_asn.m_skpd AS skpd', function($join){
                            $join   ->on('skpd.id','=','renja.skpd_id');
                        }) 
                        ->SELECT(   'skp_bulanan.tgl_mulai',
                                    'skp_bulanan.tgl_selesai',
                                    'skp_bulanan.u_jabatan_id',
                                    'skp_bulanan.id AS skp_bulanan_id',
                                    'skpd.skpd',
                                    'periode.label',
                                    'skp_bulanan.status'
                                )
                        ->orderBy('skp_bulanan.tgl_mulai','desc')
                        ->get();





        $datatables = Datatables::of($SKPBulanan)
            ->addColumn('periode', function ($x) {
                //return $x->label;
                return Pustaka::periode($x->tgl_mulai);
            }) 
            ->addColumn('masa_penilaian', function ($x) {
                return Pustaka::tgl_form($x->tgl_mulai)." s.d ". Pustaka::tgl_form($x->tgl_selesai);
            })
           
            ->addColumn('jabatan', function ($x) {
            
                return  $this->jabatan($x->u_jabatan_id);
                
            })
            ->addColumn('skpd', function ($x) {
                return  Pustaka::capital_string($x->skpd);
            })
            ->addColumn('skp_bulanan_id', function ($x) {
                    return $x->skp_bulanan_id;
            });
    
            if ($keyword = $request->get('search')['value']) {
                $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
            } 
            
    
        return $datatables->make(true); 
        //return $response; 
        
        
    }

    protected function SKPBulanandDetail(Request $request){
     

        $skp = SKPBulanan::WHERE('skp_bulanan.id',$request->skp_bulanan_id)
                            
                            ->first();

        

        $renja      = $skp->SKPTahunan->Renja;
        $p_detail   = $skp->PejabatPenilai;
        $u_detail   = $skp->PejabatYangDinilai;
       

        if ( $p_detail != null ){
            $data = array(
                    'periode'	            => $renja->Periode->label,
                    'date_created'	        => Pustaka::tgl_form($skp->created_at),
                    'masa_penilaian'        => Pustaka::tgl_form($skp->tgl_mulai).' s.d  '.Pustaka::tgl_form($skp->tgl_selesai),

                    'tgl_mulai'             => $skp->tgl_mulai,
                    'pegawai_id'	        => $skp->pegawai_id,

                    'u_jabatan_id'	        => $u_detail->id,
                    'u_nip'	                => $u_detail->nip,
                    'u_nama'                => $skp->u_nama,
                    'u_pangkat'	            => $u_detail->Golongan ? $u_detail->Golongan->pangkat : '',
                    'u_golongan'	        => $u_detail->Golongan ? $u_detail->Golongan->golongan : '',
                    'u_eselon'	            => $u_detail->Eselon ? $u_detail->Eselon->eselon : '',
                    'u_jabatan'	            => Pustaka::capital_string($u_detail->Jabatan ? $u_detail->Jabatan->skpd : ''),
                    'u_unit_kerja'	        => Pustaka::capital_string($u_detail->UnitKerja ? $u_detail->UnitKerja->unit_kerja : ''),
                    'u_skpd'	            => Pustaka::capital_string($u_detail->Skpd ? $u_detail->Skpd->skpd : ''),
                
                    'p_jabatan_id'	        => $p_detail->id,
                    'p_nip'	                => $p_detail->nip,
                    'p_nama'                => $skp->p_nama,
                    'p_pangkat'	            => $p_detail->Golongan ? $p_detail->Golongan->pangkat : '',
                    'p_golongan'	        => $p_detail->Golongan ? $p_detail->Golongan->golongan : '',
                    'p_eselon'	            => $p_detail->Eselon ? $p_detail->Eselon->eselon : '',
                    'p_jabatan'	            => Pustaka::capital_string($p_detail->Jabatan ? $p_detail->Jabatan->skpd : ''),
                    'p_unit_kerja'	        => Pustaka::capital_string($p_detail->UnitKerja ? $p_detail->UnitKerja->unit_kerja : ''),
                    'p_skpd'	            => Pustaka::capital_string($p_detail->Skpd ? $p_detail->Skpd->skpd : ''), 
                
                    

            );
        }else{
            $data = array(
                    'periode'	            => $renja->Periode->label,
                    'date_created'	        => Pustaka::tgl_form($skp->created_at),
                    'masa_penilaian'        => Pustaka::tgl_form($skp->tgl_mulai).' s.d  '.Pustaka::tgl_form($skp->tgl_selesai),

                    'tgl_mulai'             => $skp->tgl_mulai,
                    'pegawai_id'	        => $skp->pegawai_id,
                    
                    'u_jabatan_id'	        => $u_detail->id,
                    'u_nip'	                => $u_detail->nip,
                    'u_nama'                => Pustaka::nama_pegawai($u_detail->Pegawai->gelardpn , $u_detail->Pegawai->nama , $u_detail->Pegawai->gelarblk),
                    'u_pangkat'	            => $u_detail->Golongan ? $u_detail->Golongan->pangkat : '',
                    'u_golongan'	        => $u_detail->Golongan ? $u_detail->Golongan->golongan : '',
                    'u_eselon'	            => $u_detail->Eselon ? $u_detail->Eselon->eselon : '',
                    'u_jabatan'	            => Pustaka::capital_string($u_detail->Jabatan ? $u_detail->Jabatan->skpd : ''),
                    'u_unit_kerja'	        => Pustaka::capital_string($u_detail->UnitKerja ? $u_detail->UnitKerja->unit_kerja : ''),
                    'u_skpd'	            => Pustaka::capital_string($u_detail->Skpd ? $u_detail->Skpd->skpd : ''),
                
                    'p_jabatan_id'	        => $p_detail,
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
    public function SKPDSKPBulanan_list(Request $request)
    {
            
        $dt = \DB::table('db_pare_2018.renja AS renja')
                   
                    ->join('db_pare_2018.perjanjian_kinerja AS pk', function($join){
                        $join   ->on('pk.renja_id','=','renja.id');
                    })
                    ->join('db_pare_2018.skp_tahunan AS skp_tahunan', function($join){
                        $join   ->on('pk.id','=','skp_tahunan.perjanjian_kinerja_id');
                    }) 
                    ->rightjoin('db_pare_2018.skp_bulanan AS skp_bulanan', function($join){
                        $join   ->on('skp_bulanan.skp_tahunan_id','=','skp_tahunan.id');
                    }) 
                    //PERIODE
                    ->leftjoin('db_pare_2018.periode AS periode', function($join){
                        $join   ->on('renja.periode_id','=','periode.id');
                    }) 

                    //PEJABAT YANG DINILAI
                    ->leftjoin('demo_asn.tb_history_jabatan AS pejabat', function($join){
                        $join   ->on('skp_bulanan.u_jabatan_id','=','pejabat.id');
                    }) 
                    //ESELON PEJABAT YANG DINILAI
                     ->leftjoin('demo_asn.m_eselon AS eselon', function($join){
                        $join   ->on('eselon.id','=','pejabat.id_eselon');
                    }) 
                    //jabatan
                    ->leftjoin('demo_asn.m_skpd AS jabatan', 'pejabat.id_jabatan','=','jabatan.id')
                    ->select([  'skp_bulanan.id AS skp_bulanan_id',
                                'periode.label AS periode',
                                'skp_bulanan.pegawai_id AS pegawai_id',
                                'skp_bulanan.u_nama',
                                'skp_bulanan.bulan',
                                'skp_bulanan.u_jabatan_id',
                                'skp_bulanan.p_nama',
                                'skp_bulanan.p_jabatan_id',
                                'skp_bulanan.status',
                                'pejabat.nip AS u_nip',
                                'eselon.eselon AS eselon',
                                'jabatan.skpd AS jabatan'

                        ])
                    ->where('renja.skpd_id','=', $request->skpd_id);

       
                    $datatables = Datatables::of($dt)
                    ->addColumn('status', function ($x) {
                        return $x->status;
                    })->addColumn('periode', function ($x) {
                        return $x->bulan;
                    })->addColumn('nip_pegawai', function ($x) {
                        return $x->u_nip;
                    })->addColumn('nama_pegawai', function ($x) {
                        return $x->u_nama;
                    })
                    ->addColumn('eselon', function ($x) {
                        return  $x->eselon;
                    })->addColumn('jabatan', function ($x) {
                        return Pustaka::capital_string($x->jabatan);
                    })
                    ->addColumn('nama_atasan', function ($x) {
                        return $x->p_nama;
                    });
                    if ($keyword = $request->get('search')['value']) {
                        $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
                    } 
                    return $datatables->make(true);
    }

    public function skp_bulanan_tree1(Request $request)
    {
        //bawahan bawahan nya lagi
        $pelaksana_id = Jabatan::
                        leftjoin('demo_asn.m_skpd AS pelaksana', function($join){
                            $join   ->on('pelaksana.parent_id','=','m_skpd.id');
                        })
                        ->SELECT('pelaksana.id')
                        ->WHERE('m_skpd.parent_id', $request->jabatan_id )
                        ->get()
        
        
        
                        ->toArray(); 


        
        $skp_tahunan = SKPTahunan::where('id','=', $request->skp_tahunan_id )
                                    ->select('id','renja_id')
                                    ->get();


		foreach ($skp_tahunan as $x) {
            $data_skp['id']	            = "SKPTahunan|".$x->id;
			$data_skp['text']			= $x->Renja->Periode->label;
            $data_skp['icon']           = "jstree-skp_tahunan";
            $data_skp['type']           = "skp_tahunan";
            

            $skp_bulanan = SKPBulanan::where('skp_tahunan_id','=',$x->id)->select('id','bulan')->orderBy('bulan')->get();
            foreach ($skp_bulanan as $y) {
                $data_skp_bulanan['id']	            = "SKPBulanan|".$y->id;
                $data_skp_bulanan['text']		    = Pustaka::bulan($y->bulan);
                $data_skp_bulanan['icon']           = "jstree-skp_bulanan";
                $data_skp_bulanan['type']           = "skp_bulanan";


                $keg_skp = RencanaAksi::WHEREIN('jabatan_id',$pelaksana_id)
                                        ->WHERE('waktu_pelaksanaan','=',$y->bulan)
                                        ->select('id','label')
                                        ->get();

                foreach ($keg_skp as $z) {
                    $data_keg_skp['id']	           = "kegiatan_bulanan|".$z->id;
                    $data_keg_skp['text']			= Pustaka::capital_string($z->label);
                    $data_keg_skp['icon']           = "jstree-kegiatan";
                    $data_keg_skp['type']           = "rencana_aksi";
                    

                    
                    $keg_list[] = $data_keg_skp ;
                    unset($data_keg_skp['children']);
                
                }

                if(!empty($keg_list)) {
                    $data_skp_bulanan['children']     = $keg_list;
                }
                $kabid_list[] = $data_skp_bulanan ;
                $keg_list = "";
                unset($data_skp_bulanan['children']);
            
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

    public function skp_bulanan_tree2(Request $request)
    {
        //bawahan bawahan nya lagi
        $pelaksana_id = Jabatan::
                        leftjoin('demo_asn.m_skpd AS pelaksana', function($join){
                            $join   ->on('pelaksana.parent_id','=','m_skpd.id');
                        })
                        ->SELECT('pelaksana.id')
                        ->WHERE('m_skpd.parent_id', $request->jabatan_id )
                        ->get()
        
        
        
                        ->toArray(); 


        
        $skp_tahunan = SKPTahunan::where('id','=', $request->skp_tahunan_id )
                                    ->select('id','renja_id')
                                    ->get();


		foreach ($skp_tahunan as $x) {
            $data_skp['id']	            = "SKPTahunan|".$x->id;
			$data_skp['text']			= $x->Renja->Periode->label;
            $data_skp['icon']           = "jstree-skp_tahunan";
            $data_skp['type']           = "skp_tahunan";
            

            $skp_bulanan = SKPBulanan::where('skp_tahunan_id','=',$x->id)->select('id','bulan')->orderBy('bulan')->get();
            foreach ($skp_bulanan as $y) {
                $data_skp_bulanan['id']	            = "SKPBulanan|".$y->id;
                $data_skp_bulanan['text']		    = Pustaka::bulan($y->bulan);
                $data_skp_bulanan['icon']           = "jstree-skp_bulanan";
                $data_skp_bulanan['type']           = "skp_bulanan";


                $keg_skp = RencanaAksi::WHEREIN('jabatan_id',$pelaksana_id)
                                        ->WHERE('waktu_pelaksanaan','=',$y->bulan)
                                        ->select('id','label')
                                        ->get();

                foreach ($keg_skp as $z) {
                    $data_keg_skp['id']	           = "kegiatan_bulanan|".$z->id;
                    $data_keg_skp['text']			= Pustaka::capital_string($z->label);
                    $data_keg_skp['icon']           = "jstree-kegiatan";
                    $data_keg_skp['type']           = "rencana_aksi";
                    

                    
                    $keg_list[] = $data_keg_skp ;
                    unset($data_keg_skp['children']);
                
                }

                if(!empty($keg_list)) {
                    $data_skp_bulanan['children']     = $keg_list;
                }
                $kabid_list[] = $data_skp_bulanan ;
                $keg_list = "";
                unset($data_skp_bulanan['children']);
            
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


    public function skp_bulanan_tree3(Request $request)
    {
        $renja_id = $request->renja_id;
        //bawahan
        $child = Jabatan::SELECT('id')->WHERE('parent_id', $request->jabatan_id )->get()->toArray(); 

        $skp_tahunan = SKPTahunan::where('id','=', $request->skp_tahunan_id )
                                    ->select('id','renja_id')
                                    ->get();


		foreach ($skp_tahunan as $x) {
            $data_skp['id']	            = "SKPTahunan|".$x->id;
			$data_skp['text']			= $x->Renja->Periode->label;
            $data_skp['icon']           = "jstree-skp_tahunan";
            $data_skp['type']           = "skp_tahunan";
            

            $skp_bulanan = SKPBulanan::where('skp_tahunan_id','=',$x->id)->select('id','bulan')->orderBy('bulan')->get();
            foreach ($skp_bulanan as $y) {
                $data_skp_bulanan['id']	            = "SKPBulanan|".$y->id;
                $data_skp_bulanan['text']		    = Pustaka::bulan($y->bulan);
                $data_skp_bulanan['icon']           = "jstree-skp_bulanan";
                $data_skp_bulanan['type']           = "skp_bulanan";


                $keg_skp = RencanaAksi::WHEREIN('jabatan_id',$child)
                                        ->WHERE('waktu_pelaksanaan','=',$y->bulan)
                                        ->WHERE('renja_id','=',$renja_id)
                                        ->select('id','label')
                                        ->get();

                foreach ($keg_skp as $z) {
                    $data_keg_skp['id']	           = "kegiatan_bulanan|".$z->id;
                    $data_keg_skp['text']			= Pustaka::capital_string($z->label);
                    $data_keg_skp['icon']           = "jstree-kegiatan";
                    $data_keg_skp['type']           = "rencana_aksi";
                    

                    
                    $keg_list[] = $data_keg_skp ;
                    unset($data_keg_skp['children']);
                
                }

                if(!empty($keg_list)) {
                    $data_skp_bulanan['children']     = $keg_list;
                }
                $kabid_list[] = $data_skp_bulanan ;
                $keg_list = "";
                unset($data_skp_bulanan['children']);
            
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


    public function skp_bulanan_tree4(Request $request)
    {
       

        $skp_tahunan = SKPTahunan::where('id','=', $request->skp_tahunan_id )
                                    ->select('id','renja_id')
                                    ->get();


		foreach ($skp_tahunan as $x) {
            $data_skp['id']	            = "SKPTahunan|".$x->id;
			$data_skp['text']			= $x->Renja->Periode->label;
            $data_skp['icon']           = "jstree-skp_tahunan";
            $data_skp['type']           = "skp_tahunan";
            

            $skp_bulanan = SKPBulanan::where('skp_tahunan_id','=',$x->id)->select('id','bulan')->orderBy('bulan')->get();
            foreach ($skp_bulanan as $y) {
                $data_skp_bulanan['id']	            = "SKPBulanan|".$y->id;
                $data_skp_bulanan['text']		    = Pustaka::bulan($y->bulan);
                $data_skp_bulanan['icon']           = "jstree-skp_bulanan";
                $data_skp_bulanan['type']           = "skp_bulanan";


                $keg_skp = RencanaAksi::where('renja_id','=',$request->renja_id)
                                        ->where('jabatan_id','=',$request->jabatan_id)
                                        ->WHERE('waktu_pelaksanaan','=',$y->bulan)
                                        ->select('id','label')
                                        ->get();

                foreach ($keg_skp as $z) {
                    $data_keg_skp['id']	           = "kegiatan_bulanan|".$z->id;
                    $data_keg_skp['text']			= Pustaka::capital_string($z->label);
                    $data_keg_skp['icon']           = "jstree-kegiatan";
                    $data_keg_skp['type']           = "rencana_aksi";
                    

                    
                    $keg_list[] = $data_keg_skp ;
                    unset($data_keg_skp['children']);
                
                }

                if(!empty($keg_list)) {
                    $data_skp_bulanan['children']     = $keg_list;
                }
                $kabid_list[] = $data_skp_bulanan ;
                $keg_list = "";
                unset($data_skp_bulanan['children']);
            
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

    public function skp_bulanan_tree5(Request $request)
    {
       

        $skp_tahunan = SKPTahunan::where('id','=', $request->skp_tahunan_id )
                                    ->select('id','renja_id')
                                    ->get();


		foreach ($skp_tahunan as $x) {
            $data_skp['id']	            = "SKPTahunan|".$x->id;
			$data_skp['text']			= $x->Renja->Periode->label;
            $data_skp['icon']           = "jstree-skp_tahunan";
            $data_skp['type']           = "skp_tahunan";
            

            $skp_bulanan = SKPBulanan::where('skp_tahunan_id','=',$x->id)->select('id','bulan')->orderBy('bulan')->get();
            foreach ($skp_bulanan as $y) {
                $data_skp_bulanan['id']	            = "SKPBulanan|".$y->id;
                $data_skp_bulanan['text']		    = Pustaka::bulan($y->bulan);
                $data_skp_bulanan['icon']           = "jstree-skp_bulanan";
                $data_skp_bulanan['type']           = "skp_bulanan";


                $keg_skp = KegiatanSKPBulananJFT::where('skp_bulanan_id','=',$y->id)
                                        ->select('id','label')
                                        ->get();

                foreach ($keg_skp as $z) {
                    $data_keg_skp['id']	           = "kegiatan_bulanan|".$z->id;
                    $data_keg_skp['text']			= Pustaka::capital_string($z->label);
                    $data_keg_skp['icon']           = "jstree-kegiatan";
                    $data_keg_skp['type']           = "kegiatan_bulanan";
                    

                    
                    $keg_list[] = $data_keg_skp ;
                    unset($data_keg_skp['children']);
                
                }

                if(!empty($keg_list)) {
                    $data_skp_bulanan['children']     = $keg_list;
                }
                $kabid_list[] = $data_skp_bulanan ;
                $keg_list = "";
                unset($data_skp_bulanan['children']);
            
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

    

    public function SKPBulananList1(Request $request)
    {


        //CARI KASUBID
        $child = Jabatan::
                            
                            leftjoin('demo_asn.m_skpd AS kasubid', function($join){
                                $join   ->on('kasubid.parent_id','=','m_skpd.id');
                            })
                            ->SELECT('kasubid.id')
                            ->WHERE('m_skpd.parent_id', $request->jabatan_id )
                            ->get()
                            ->toArray(); 

        //cari bawahan  , jabatanpelaksanan
        $pelaksana_id = Jabatan::
                        SELECT('m_skpd.id')
                        ->WHEREIN('m_skpd.parent_id', $child )
                        ->get()
                        ->toArray(); 

        $skp = SKPBulanan::
                        WHERE('skp_tahunan_id',$request->skp_tahunan_id)
                        ->select(
                                'id AS skp_bulanan_id',
                                'skp_tahunan_id',
                                'bulan',
                                'tgl_mulai',
                                'tgl_selesai',
                                'p_nama',
                                'status'
            
                         )
                        ->orderBy('bulan')
                        ->get();

       
           $datatables = Datatables::of($skp)
           ->addColumn('periode', function ($x) {
                return Pustaka::bulan($x->bulan) . ' '.Pustaka::tahun($x->tgl_mulai);
            }) 
            ->addColumn('masa_penilaian', function ($x) {
                $masa_penilaian = Pustaka::balik($x->tgl_mulai). ' s.d ' . Pustaka::balik($x->tgl_selesai);
                return   $masa_penilaian;
            }) 
            ->addColumn('label', function ($x) {
                
                return   "SKP Periode " .Pustaka::bulan($x->bulan);
            })
            ->addColumn('pejabat_penilai', function ($x) {
            
                if ( !empty($x->p_nama)){
                    return $x->p_nama;
                }else{
                    return "<font style='color:red'>Belum Ada</font>";
                }
                
            })->addColumn('jm_kegiatan', function ($x) use($pelaksana_id) {
                
              
                return  RencanaAksi::WHEREIN('jabatan_id',$pelaksana_id )
                                    ->WHERE('waktu_pelaksanaan','=',$x->bulan)
                                    ->select('id')
                                    ->count();


               
            });
    
            if ($keyword = $request->get('search')['value']) {
                $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
            } 
            
    
        return $datatables->make(true);
        
    }

    public function SKPBulananList2(Request $request)
    {


        //cari bawahan  , jabatanpelaksanan
        $pelaksana_id = Jabatan::
                                leftjoin('demo_asn.m_skpd AS pelaksana', function($join){
                                    $join   ->on('pelaksana.parent_id','=','m_skpd.id');
                                })
                                ->SELECT('pelaksana.id')
                                ->WHERE('m_skpd.parent_id', $request->jabatan_id )
                                ->get()



                                ->toArray(); 

        $skp = SKPBulanan::
                        WHERE('skp_tahunan_id',$request->skp_tahunan_id)
                        ->select(
                                'id AS skp_bulanan_id',
                                'skp_tahunan_id',
                                'bulan',
                                'tgl_mulai',
                                'tgl_selesai',
                                'p_nama',
                                'status'
            
                         )
                        ->orderBy('bulan')
                        ->get();
                        
            $renja_id = SKPTahunan::find($request->skp_tahunan_id)->renja_id;
       
            $datatables = Datatables::of($skp)
            ->addColumn('periode', function ($x) {
                return Pustaka::bulan($x->bulan) . ' '.Pustaka::tahun($x->tgl_mulai);
            }) 
            ->addColumn('masa_penilaian', function ($x) {
                $masa_penilaian = Pustaka::balik($x->tgl_mulai). ' s.d ' . Pustaka::balik($x->tgl_selesai);
                return   $masa_penilaian;
            }) 
            ->addColumn('label', function ($x) {
                
                return   "SKP Periode " .Pustaka::bulan($x->bulan);
            })
            ->addColumn('pejabat_penilai', function ($x) {
            
                if ( !empty($x->p_nama)){
                    return $x->p_nama;
                }else{
                    return "<font style='color:red'>Belum Ada</font>";
                }
                
            })->addColumn('jm_kegiatan', function ($x) use($pelaksana_id,$renja_id) {
                
              
                return  RencanaAksi::WHEREIN('jabatan_id',$pelaksana_id )
                                    ->WHERE('waktu_pelaksanaan','=',$x->bulan)
                                    ->WHERE('renja_id',$renja_id)
                                    ->select('id')
                                    ->count();


               
            });
    
            if ($keyword = $request->get('search')['value']) {
                $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
            } 
            
    
        return $datatables->make(true);
        
    }

    public function SKPBulananList3(Request $request)
    {

        $renja_id = $request->renja_id;
        //BAWAHA
        $child = Jabatan::SELECT('id')->WHERE('parent_id', $request->jabatan_id )->get()->toArray(); 

        $skp = SKPBulanan::
                        WHERE('skp_tahunan_id',$request->skp_tahunan_id)
                        ->select(
                                'id AS skp_bulanan_id',
                                'skp_tahunan_id',
                                'bulan',
                                'tgl_mulai',
                                'tgl_selesai',
                                'p_nama',
                                'status'
            
                         )
                        ->orderBy('bulan')
                        ->get();

       
           $datatables = Datatables::of($skp)
           ->addColumn('periode', function ($x) {
                return Pustaka::bulan($x->bulan) . ' '.Pustaka::tahun($x->tgl_mulai);
            }) 
            ->addColumn('masa_penilaian', function ($x) {
                $masa_penilaian = Pustaka::balik($x->tgl_mulai). ' s.d ' . Pustaka::balik($x->tgl_selesai);
                return   $masa_penilaian;
            }) 
            ->addColumn('label', function ($x) {
                
                return   "SKP Periode " .Pustaka::bulan($x->bulan);
            })
            ->addColumn('pejabat_penilai', function ($x) {
            
                if ( !empty($x->p_nama)){
                    return $x->p_nama;
                }else{
                    return "<font style='color:red'>Belum Ada</font>";
                }
                
            })->addColumn('jm_kegiatan', function ($x) use($child,$renja_id) {
                
              
                return  RencanaAksi::WHEREIN('jabatan_id',$child )
                                    ->WHERE('waktu_pelaksanaan','=',$x->bulan)
                                    ->WHERE('renja_id','=',$renja_id)
                                    ->select('id')
                                    ->count();


               
            });
    
            if ($keyword = $request->get('search')['value']) {
                $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
            } 
            
    
        return $datatables->make(true);
        
    }

    public function SKPBulananList4(Request $request)
    {
        $skp = SKPBulanan::
                        WHERE('skp_tahunan_id',$request->skp_tahunan_id)
                        ->select(
                                'id AS skp_bulanan_id',
                                'skp_tahunan_id',
                                'bulan',
                                'tgl_mulai',
                                'tgl_selesai',
                                'p_nama',
                                'status'
            
                         )
                        ->orderBy('bulan')
                        ->get();

       
           $datatables = Datatables::of($skp)
           ->addColumn('periode', function ($x) {
                return Pustaka::bulan($x->bulan) . ' '.Pustaka::tahun($x->tgl_mulai);
            }) 
            ->addColumn('masa_penilaian', function ($x) {
                $masa_penilaian = Pustaka::balik($x->tgl_mulai). ' s.d ' . Pustaka::balik($x->tgl_selesai);
                return   $masa_penilaian;
            }) 
            ->addColumn('label', function ($x) {
                
                return   "SKP Periode " .Pustaka::bulan($x->bulan);
            })
            ->addColumn('pejabat_penilai', function ($x) {
            
                if ( !empty($x->p_nama)){
                    return $x->p_nama;
                }else{
                    return "<font style='color:red'>Belum Ada</font>";
                }
                
            })->addColumn('jm_kegiatan', function ($x) {
                
                return KegiatanSKPBulanan::WHERE('skp_bulanan_id',$x->skp_bulanan_id)->SELECT('id')->count();
               
            });
    
            if ($keyword = $request->get('search')['value']) {
                $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
            } 
            
    
        return $datatables->make(true);
        
    }

    public function SKPBulananList5(Request $request)
    {
        $skp = SKPBulanan::
                        WHERE('skp_tahunan_id',$request->skp_tahunan_id)
                        ->select(
                                'id AS skp_bulanan_id',
                                'skp_tahunan_id',
                                'bulan',
                                'tgl_mulai',
                                'tgl_selesai',
                                'p_nama',
                                'status'
            
                         )
                        ->orderBy('bulan')
                        ->get();

       
           $datatables = Datatables::of($skp)
           ->addColumn('periode', function ($x) {
                return Pustaka::bulan($x->bulan) . ' '.Pustaka::tahun($x->tgl_mulai);
            }) 
            ->addColumn('masa_penilaian', function ($x) {
                $masa_penilaian = Pustaka::balik($x->tgl_mulai). ' s.d ' . Pustaka::balik($x->tgl_selesai);
                return   $masa_penilaian;
            }) 
            ->addColumn('label', function ($x) {
                
                return   "SKP Periode " .Pustaka::bulan($x->bulan);
            })
            ->addColumn('pejabat_penilai', function ($x) {
            
                if ( !empty($x->p_nama)){
                    return $x->p_nama;
                }else{
                    return "<font style='color:red'>Belum Ada</font>";
                }
                
            })->addColumn('jm_kegiatan', function ($x) {
                
                return KegiatanSKPBulananJFT::WHERE('skp_bulanan_id',$x->skp_bulanan_id)->SELECT('id')->count();
               
            });
    
            if ($keyword = $request->get('search')['value']) {
                $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
            } 
            
    
        return $datatables->make(true);
        
    }

    public function create_skp_tahunan_confirm(Request $request)
	{

        $pegawai                    = Pegawai::where('id',$request->get('pegawai_id'))->first();
        $jabatan                    = $pegawai->history_jabatan->where('status','active')->first();

        // cek apakah user sudah memiliki SKP tahunan atau belum
        $periode_aktif              = PeriodeTahunan::where('status','1')->first();
        $perjanjian_kinerja_publish = $periode_aktif->perjanjian_kinerja
                                            ->where('active','1')
                                            ->where('publish','1')
                                            ->where('skpd_id', $pegawai->history_jabatan->where('status','active')->first()->id_skpd )
                                            ->first();

        $jm_perjanjian_kinerja      = PerjanjianKinerja::where('periode_tahunan_id',$periode_aktif->id)->get();

        //======= tidak boleh ada yang membuat SKP tahunan dengan 
        //======== PERSONAL JABATAN ID dan PERJANJIAN KINERTJA ID 
        // ======= yang sama untuk satu pegawai id
        $cek_data = SKPTahunan::where('pegawai_id',$pegawai->id)
                                ->where('perjanjian_kinerja_id',$perjanjian_kinerja_publish->id)
                                ->where('jabatan_id',$jabatan->id)
                                ->count();


        $response = array();

        //== jika bukan eselon 1,2,3 atau 4 , maka tunggu atasasn nya bikin SKP =================//
        if ( $jabatan->id_eselon == 9 ){
            $h['jabatan']			= 'Harus Atasan nya terlebih dahulu';
						
			array_push($response, $h);
        }

        

        if ( $response == null ){
            if (  $cek_data  == 0 ){
                //Kirim parameter yang dibutuhkan untuk membuat SKP baru
                return ([
                            'status'                => 'ok',
                            'periode_tahunan_id'    => $periode_aktif->id,
                            'periode_tahunan'       => $periode_aktif->label,
                            'tgl_mulai'             => Pustaka::tgl_form($periode_aktif->awal),
                            'tgl_selesai'           => Pustaka::tgl_form($periode_aktif->akhir),
    
    
                            'perjanjian_kinerja_id' => $perjanjian_kinerja_publish->id,
                            'pegawai_id'            => $pegawai->id,
                            'jabatan_id'            => $jabatan->id,
    
                            //DETAIL PEGAWAI
                            'u_nama'                => Pustaka::nama_pegawai($pegawai->gelardpn , $pegawai->nama , $pegawai->gelarblk),
                            'u_nip'                 => $pegawai->nip,
                            'u_pangkat'             => $jabatan->golongan->pangkat,
                            'u_golongan'            => $jabatan->golongan->golongan,
                            'u_jabatan'             => $jabatan->jabatan,
                            'u_unit_kerja'          => Pustaka::capital_string($jabatan->UnitKerja->unit_kerja),
                            'u_skpd'                => Pustaka::capital_string($jabatan->skpd->unit_kerja),
    
                            'msg'                   => $response
    
                          /*   //DETAIL ATASAN
                            'p_nama'                => Pustaka::nama_pegawai($pegawai->gelardpn , $pegawai->nama , $pegawai->gelarblk),
                            'p_nip'                 => $pegawai->nip,
                            //'jabatn'              => $jabatan,
                            'p_jabatan'             => $jabatan->jabatan,
                            'p_eselon'              => $jabatan->eselon->eselon,
                            'p_jenis_jabatan'       => $jabatan->eselon->jenis_jabatan->jenis_jabatan,
                            'p_unit_kerja'          => Pustaka::capital_string($jabatan->UnitKerja->unit_kerja),
                            'p_skpd'                => Pustaka::capital_string($jabatan->skpd->unit_kerja), */
                            
    
    
                        ]);
    
    
    
    
            }else{
                return \Response::make('SKP Tahunan Sudah Dibuat', 400);
            }
        }else{
            return \Response::make('JFU dan JFT nanti saja bikin SKP nya', 400);
        }
        

       
       
         
    }



    public function set_pejabat_penilai_skp_tahunan(Request $request)
	{
        $messages = [
            'pegawai_id.required'                   => 'Harus set Pegawai ID',
            'skp_tahunan_id.required'               => 'Harus diisi',

        ];

        $validator = Validator::make(
            Input::all(),
            array(
                'pegawai_id'            => 'required',
                'skp_tahunan_id'        => 'required',
            ),
            $messages
        );

        if ( $validator->fails() ){
                return response()->json(['errors'=>$validator->messages()],422);
        }


        //Cari nama dan id pejabatan penilai
        $pegawai     = Pegawai::where('id',$request->get('pegawai_id'))->first();
        $jabatan     = $pegawai->history_jabatan->where('status','active')->first();

        if ( $jabatan ){
            $jabatan_atasan_id = $jabatan->id;
        }else{
            return \Response::make('error', 500);
        }


        
        $data       = [
                'jabatan_atasan_id' => $jabatan->id,
                'p_nama'            => Pustaka::nama_pegawai($pegawai->gelardpn , $pegawai->nama , $pegawai->gelarblk),
        ];

        $skp_tahunan     = SKPTahunan::where('id', $request->get('skp_tahunan_id') );


        
        $item = array(
           
            "p_nip"			=> $pegawai->nip,
            "p_nama"		=> Pustaka::nama_pegawai($pegawai->gelardpn , $pegawai->nama , $pegawai->gelarblk),
            "p_golongan"	=> $jabatan->golongan->pangkat. '/' . $jabatan->golongan->golongan,
            "p_jabatan"		=> $jabatan->jabatan,
            "p_eselon"		=> $jabatan->jabatan,
            "p_unit_kerja"	=> Pustaka::capital_string($jabatan->UnitKerja->unit_kerja),
            );


        
        if (  $skp_tahunan->update($data) ){
            return \Response::make(  $item , 200);


        }else{
            return \Response::make('error', 500);
        } 

    }

    public function Store(Request $request)
	{
        $messages = [
                'pegawai_id.required'             => 'Harus diisi',
                'skp_tahunan_id.required'         => 'Harus diisi',
                'u_nama.required'                 => 'Harus diisi',
                //'p_nama.required'                 => 'Harus diisi',
                'u_jabatan_id.required'           => 'Harus diisi',
                //'p_jabatan_id.required'           => 'Harus diisi',
                'periode_skp_bulanan.required'    => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'pegawai_id'            => 'required',
                            'skp_tahunan_id'        => 'required',
                            'u_nama'                => 'required',
                            //'p_nama'                => 'required',
                            //'p_jabatan_id'          => 'required',
                            'u_jabatan_id'          => 'required',
                            'periode_skp_bulanan'   => 'required'
                        ),
                        $messages
        );
    
        if ( $validator->fails() ){
            //$messages = $validator->messages();
                    return response()->json(['errors'=>$validator->messages()],422);
            
        }

        $tgl_xmulai = Input::get('tgl_mulai');
        $pecah     = explode('-',$tgl_xmulai); 
        $thn       = $pecah[0];

        $periode = Input::get('periode_skp_bulanan');
        for ($i = 0; $i < count($periode); $i++){



            //cari tgl mulai dan selesai
            $inisial     = date($thn."-".$periode[$i]."-d");
            $tgl_mulai   = date('Y-m-01',strtotime($inisial));
            $tgl_selesai = date('Y-m-t',strtotime($inisial));


            $data[] = array(

                'pegawai_id'        => Input::get('pegawai_id'),
                'skp_tahunan_id'    => Input::get('skp_tahunan_id'),
                'bulan'             => $periode[$i],

                'u_nama'            => Input::get('u_nama'),
                'u_jabatan_id'      => Input::get('u_jabatan_id'),
                'p_nama'            => Input::get('p_nama'),
                'p_jabatan_id'      => Input::get('p_jabatan_id'),

                'tgl_mulai'         => $tgl_mulai,
                'tgl_selesai'       => $tgl_selesai,



            );
        }

        $skp_bulanan   = new SKPBulanan;
        $skp_bulanan   -> insert($data);

      /*   $skp_tahunan    = new SKPTahunan;
        $skp_tahunan->pegawai_id                  = Input::get('pegawai_id');
        $skp_tahunan->perjanjian_kinerja_id       = Input::get('perjanjian_kinerja_id');
        $skp_tahunan->jabatan_id                  = Input::get('jabatan_id');
        $skp_tahunan->tgl_mulai                   = Pustaka::tgl_sql(Input::get('tgl_mulai'));
        $skp_tahunan->tgl_selesai                 = Pustaka::tgl_sql(Input::get('tgl_selesai'));
        $skp_tahunan->u_nama                      = Input::get('u_nama');

        if ( $skp_tahunan->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        }  */
            
            
    }   


    public function Destroy(Request $request)
    {

        $messages = [
                'skp_tahunan_id.required'   => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'skp_bulanan_id'   => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $st_skp    = SKPBulanan::find(Input::get('skp_bulanan_id'));
        if (is_null($st_skp)) {
            return $this->sendError('SKP Bulanan tidak ditemukan.');
        }


        if ( $st_skp->delete()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }

}
