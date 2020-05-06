<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\SasaranPerjanjianKinerja;
use App\Models\Sasaran;
use App\Models\IndikatorSasaran;
use App\Models\Tujuan;
use App\Models\Kegiatan;
use App\Models\KegiatanSKPTahunan;
use App\Models\KegiatanSKPTahunanJFT;
use App\Models\Skpd;
use App\Models\Jabatan;
use App\Models\RencanaAksi;
use App\Models\KegiatanSKPBulanan;
use App\Models\SKPBulanan;
use App\Models\IndikatorKegiatan;
use App\Models\PerjanjianKinerja;
use App\Helpers\Pustaka;
use Datatables;
use Validator;
use Input;

use App\Traits\Pengecualian;

class KegiatanAPIController extends Controller {

    use Pengecualian;

    public function PohonKinerjaKegiatanTree(Request $request)
    {
       
        
        $skp_tahunan_id = $request->skp_tahunan_id;
        $kegiatan = Kegiatan::SELECT('id','label')
                            ->WHERE('renja_kegiatan.renja_id', $request->renja_id )
                            ->leftjoin('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join) use ( $skp_tahunan_id ){
                                $join   ->on('kegiatan_tahunan.kegiatan_id','=','renja_kegiatan.id');
                                //$join   ->WHERE('kegiatan_tahunan.skp_tahunan_id','=', $skp_tahunan_id );
                            })
                            ->SELECT(   'renja_kegiatan.id AS kegiatan_id',
                                        'renja_kegiatan.label AS kegiatan_label',
                                        'kegiatan_tahunan.id AS kegiatan_tahunan_id',
                                        'kegiatan_tahunan.label AS kegiatan_tahunan_label'
                                    ) 
                            ->get(); 
        
            
		foreach ($kegiatan as $x) {
            if ( $x->kegiatan_tahunan_id >= 1 ){
                $kegiatan_id                    = "KegiatanTahunan|".$x->kegiatan_tahunan_id;
                $kegiatan_label                 = $x->kegiatan_tahunan_label;
                $data_kegiatan['icon']	        = 'jstree-kegiatan_tahunan';
            }else{
                //$kegiatan_id                    = "KegiatanRenja|".$x->kegiatan_id."|".$x->kegiatan_label;
                $kegiatan_id                    = "KegiatanRenja|".$x->kegiatan_id;
                $kegiatan_label                 = $x->kegiatan_label;
                $data_kegiatan['icon']	        = 'jstree-kegiatan';
            }
            $data_kegiatan['id']	            = $kegiatan_id;
            $data_kegiatan['text']			    = Pustaka::capital_string($kegiatan_label);
            
          
            //Indikator Kegiatan
            $ik = IndikatorKegiatan::WHERE('kegiatan_id',$x->kegiatan_id)->get();
            foreach ($ik as $y) {
                $data_ind_kegiatan['id']	        = "IndikatorKegiatan|".$y->id;
                $data_ind_kegiatan['text']			= Pustaka::capital_string($y->label);
                $data_ind_kegiatan['icon']	        = 'jstree-ind_kegiatan';
              
                    //Rencana aksi
                    $ra = RencanaAksi::WHERE('indikator_kegiatan_id',$y->id)->get();
                    foreach ($ra as $z) {
                        $data_rencana_aksi['id']	        = "RencanaAksi|".$z->id;
                        $data_rencana_aksi['text']			= Pustaka::capital_string($z->label).' ['. Pustaka::bulan($z->waktu_pelaksanaan).']';
                        $data_rencana_aksi['icon']	        = 'jstree-rencana_aksi';
                      
        
                        //TARGET PADA KEGIATAN BULANAN
                        $kb = KegiatanSKPBulanan::WHERE('rencana_aksi_id',$z->id)->get();
                        foreach ($kb as $a) {
                            $data_keg_bulanan['id']	        = "KegiatanBulanan|".$a->id;
                            $data_keg_bulanan['text']			=  'Target : '. $a->target.' '.$a->satuan.' / Pelaksana : '.Pustaka::capital_string($a->RencanaAksi->pelaksana->jabatan);
                            $data_keg_bulanan['icon']	        = 'jstree-target';
                        
            
                            $keg_bulanan_list[] = $data_keg_bulanan ;
                        }	
                        if(!empty($keg_bulanan_list)) {
                            $data_rencana_aksi['children']     = $keg_bulanan_list;
                        }
                        $rencana_aksi_list[] = $data_rencana_aksi ;
                        $keg_bulanan_list = "";
                        unset($data_rencana_aksi['children']);
                    }	
                    
                if(!empty($rencana_aksi_list)) {
                    $data_ind_kegiatan['children']     = $rencana_aksi_list;
                }
                $ind_kegiatan_list[] = $data_ind_kegiatan ;
                $rencana_aksi_list = "";
                unset($data_ind_kegiatan['children']); 
            }	
            if(!empty($ind_kegiatan_list)) {
                $data_kegiatan['children']     = $ind_kegiatan_list;
            }
            $kegiatan_list[] = $data_kegiatan ;
            $ind_kegiatan_list = "";
            unset($data_kegiatan['children']);
        }	
        if(!empty($kegiatan_list)) {
            return  $kegiatan_list;
        }else{
            return "[{}]";
        } 
        
    }
 
    

    public function RenjaDistribusiKegiatanTree(Request $request)
    {
        //klasifikasi get data menurut root node nya,.. 
        if ( $request->id == "#"){
            $data = 'level_1';
        }else{
            $data = $request->data;
        }
        $state = array( "opened" => true, "selected" => false );


        switch ($data) {
            case 'level_1':

            if ( $request->skpd_id == 3 ){
                //SEKDA 
                $level1 = SKPD::leftjoin('demo_asn.m_skpd AS data', function($join){
                                    $join   ->on('data.parent_id','=','m_skpd.id');
                                })
                                ->select('data.id','data.skpd')
                                ->where('m_skpd.parent_id','=', $request->skpd_id)
                                ->get();
            }else if ( $request->skpd_id == 11 ){
                //JIKA KANTOR KESBANGPOL, level satunya adalah atasan nya
                $level1 = SKPD::where('id','=', 11)->select('id','skpd','id_eselon')->get();
            }else{
                //Distibusi kegiatan dengan level normal
                $level1 = SKPD::where('parent_id','=', $request->skpd_id)->select('id','skpd','id_eselon')->get();
            }
        
            foreach ($level1 as $x) {
                $data_level1['id']	            = $x->id;
                $data_level1['data']            = "level_1";
                $data_level1['type']            = "JPT";
                $data_level1['text']		    = Pustaka::capital_string($x->skpd);
                $data_level1['icon']            = "jstree-people";
                
                $data_level1['children']        = true ;
                $data_level1['state']           = $state;

                
                if ( $x->id == '273'){  //PUPR
                    $level2 = SKPD::whereRaw('(parent_id = ? and  id != ? ) or parent_id = ? ', array(273,302,302))
                                    ->select('id','skpd')
                                    ->get();
                }
                else{
                    //normal Level 2
                    $level2 = SKPD::where('parent_id','=',$x->id)->select('id','skpd')->get();
                }

                foreach ($level2 as $y) {
                    
                    if (in_array( $y->id, $this->pengecualian() )){ //yang dikeualikan from trait/pengecualian
                    //JIKA YANG DIKECUALIKAN,MALAH BISA ADD KEGIATAN
                        $data_level2['id']	        = $y->id;
                        $data_level2['data']        = "level_3"; // dianggap di level 3
                        $data_level2['text']		= Pustaka::capital_string($y->skpd);
                        $data_level2['icon']        = "jstree-people";
                        $data_level2['type']        = "pengawas";
                        $data_level2['state']       = "state";
                        $data_level2['children']    = true ;
                        //$data_level2['state']       = $state;
                        
                    }else{
                        $data_level2['id']	        = $y->id;
                        $data_level2['data']        = "level_2";
                        $data_level2['type']        = "administrator";
                        $data_level2['text']		= Pustaka::capital_string($y->skpd);
                        $data_level2['icon']        = "jstree-people ";
                        $data_level2['state']       = "state";
                        $data_level2['children']    = true ;
                        $data_level2['state']       = $state;

                    }

                    $level2_list[] = $data_level2 ;
                }
                if(!empty($level2_list)) {
                    $data_level1['children']     = $level2_list;
                }
                $level1_list[] = $data_level1 ;	
                $level2_list = "";
                unset($data_level1['children']);

               
            }    
            if(!empty($level1_list)) { 
                return $level1_list;
            }else{
                return "[{}]";
            }

            break;
            case 'level_2': //jika klik level 2
                //JIKA disdik,tampilkan korwil ( eselon 9 /Unit Kerja Teknis Korwil)
                if ( $request->id == 805 ){
                    $level3 = SKPD::where('parent_id','=',$request->id)
                                    ->where(function ($query) {
                                        $query->where('id_eselon', '=' , null )
                                            ->orWhere('id_eselon', '<=', 9 );
                                    })
                                    ->select('id','skpd','id_eselon')->get();
                
                //JIKA PUSKESMAS LEVEL  3 nya boleh eselon id 11 .. 
                //AGAR KASUBAG TU PUSKESMASNYA BISA SEJAJAR DENGAN DEWNGAN KEPALA PUSKESMAS
                }else if ( $request->id == 168 ){  //168 adalah id UPTD kesehatan
                    $level3a = SKPD::where('parent_id','=',$request->id)
                                    ->where(function ($query) {
                                        $query->where('id_eselon', '=' , null )
                                            ->orWhere('id_eselon', '<=', 8 )
                                            ->orWhere('id_eselon', '=', 17 );
                                    })
                                    ->select('id','skpd','id_eselon')->get();
                    $kapus_list = [];
                    foreach ($level3a as $x) {
                         $kapus_list[] = array( 'id' => $x->id );
                    }

                    $level3b = SKPD::WHEREIN('parent_id',$kapus_list)
                                    ->where(function ($query) {
                                        $query->where('id_eselon', '=' , null )
                                            ->orWhere('id_eselon', '<=', 8 );
                                    })
                                    ->select('id','skpd','id_eselon')->get();

                    $level3 = $level3a->merge($level3b);
                   
            
                //AGAR KASUBAG TU DISPERINDAG BISA SEJAJAR DENGAN DEWNGAN KEPALA UPTD DINAS
                }else if ( $request->id == 761 ){  
                    $level3a = SKPD::where('parent_id','=',$request->id)
                                    ->where(function ($query) {
                                        $query->where('id_eselon', '=' , null )
                                            ->orWhere('id_eselon', '<=', 8 );
                                    })
                                    ->select('id','skpd','id_eselon')->get();
                    $kapus_list = [];
                    foreach ($level3a as $x) {
                        $kapus_list[] = array( 'id' => $x->id );
                    }

                    $level3b = SKPD::WHEREIN('parent_id',$kapus_list)
                                    ->where(function ($query) {
                                        $query->where('id_eselon', '=' , null )
                                            ->orWhere('id_eselon', '<=', 8 );
                                    })
                                    ->select('id','skpd','id_eselon')->get();

                    $level3 = $level3a->merge($level3b);

                //AGAR KASUBAG TU Dinas Pertanian bisa add kegiatan
                }else if ( $request->id == 637 ){  //637 adalah ID UPTD dinas kesehatan
                    $level3a = SKPD::where('parent_id','=',$request->id)
                                    ->where(function ($query) {
                                        $query->where('id_eselon', '=' , null )
                                            ->orWhere('id_eselon', '<=', 8 );
                                    })
                                    ->select('id','skpd','id_eselon')->get();
                    $kapus_list = [];
                    foreach ($level3a as $x) {
                        $kapus_list[] = array( 'id' => $x->id );
                    }

                    $level3b = SKPD::WHEREIN('parent_id',$kapus_list)
                                    ->where(function ($query) {
                                        $query->where('id_eselon', '=' , null )
                                            ->orWhere('id_eselon', '<=', 8 );
                                    })
                                    ->select('id','skpd','id_eselon')->get();

                    $level3 = $level3a->merge($level3b);
            
            
                //AGAR KASUBAG TU dishub bisa add kegiatan
                }else if ( $request->id == 544 ){  //675 adalah 
                    $level3a = SKPD::where('parent_id','=',$request->id)
                                    ->where(function ($query) {
                                        $query->where('id_eselon', '=' , null )
                                            ->orWhere('id_eselon', '<=', 8 );
                                    })
                                    ->select('id','skpd','id_eselon')->get();
                    $kapus_list = [];
                    foreach ($level3a as $x) {
                        $kapus_list[] = array( 'id' => $x->id );
                    }

                    $level3b = SKPD::WHEREIN('parent_id',$kapus_list)
                                    ->where(function ($query) {
                                        $query->where('id_eselon', '=' , null )
                                            ->orWhere('id_eselon', '<=', 8 );
                                    })
                                    ->select('id','skpd','id_eselon')->get();

                    $level3 = $level3a->merge($level3b);
            
                }else if ( $request->id == 620 ){  //620 adalah perikanan
                    $level3a = SKPD::where('parent_id','=',$request->id)
                                    ->where(function ($query) {
                                        $query->where('id_eselon', '=' , null )
                                            ->orWhere('id_eselon', '<=', 8 );
                                    })
                                    ->select('id','skpd','id_eselon')->get();
                    $kapus_list = [];
                    foreach ($level3a as $x) {
                        $kapus_list[] = array( 'id' => $x->id );
                    }

                    $level3b = SKPD::WHEREIN('parent_id',$kapus_list)
                                    ->where(function ($query) {
                                        $query->where('id_eselon', '=' , null )
                                            ->orWhere('id_eselon', '<=', 8 );
                                    })
                                    ->select('id','skpd','id_eselon')->get();

                    $level3 = $level3a->merge($level3b);
            
                
                }else if ( $request->id == 61804 ){  //61804 adalah DLHK
                    $level3a = SKPD::where('parent_id','=',$request->id)
                                    ->where(function ($query) {
                                        $query->where('id_eselon', '=' , null )
                                            ->orWhere('id_eselon', '<=', 8 );
                                    })
                                    ->select('id','skpd','id_eselon')->get();
                    $kapus_list = [];
                    foreach ($level3a as $x) {
                        $kapus_list[] = array( 'id' => $x->id );
                    }

                    $level3b = SKPD::WHEREIN('parent_id',$kapus_list)
                                    ->where(function ($query) {
                                        $query->where('id_eselon', '=' , null )
                                            ->orWhere('id_eselon', '<=', 8 );
                                    })
                                    ->select('id','skpd','id_eselon')->get();

                    $level3 = $level3a->merge($level3b);
            
                
                }else if ( $request->id == 61830 ){  //61830 adalah DISNAKERTRANS
                    $level3a = SKPD::where('parent_id','=',$request->id)
                                    ->where(function ($query) {
                                        $query->where('id_eselon', '=' , null )
                                            ->orWhere('id_eselon', '<=', 8 );
                                    })
                                    ->select('id','skpd','id_eselon')->get();
                    $kapus_list = [];
                    foreach ($level3a as $x) {
                        $kapus_list[] = array( 'id' => $x->id );
                    }

                    $level3b = SKPD::WHEREIN('parent_id',$kapus_list)
                                    ->where(function ($query) {
                                        $query->where('id_eselon', '=' , null )
                                            ->orWhere('id_eselon', '<=', 8 );
                                    })
                                    ->select('id','skpd','id_eselon')->get();

                    $level3 = $level3a->merge($level3b);
            
                
                }else if ( $request->id == 61831 ){  //61831 adalah DINSOS
                    $level3a = SKPD::where('parent_id','=',$request->id)
                                    ->where(function ($query) {
                                        $query->where('id_eselon', '=' , null )
                                            ->orWhere('id_eselon', '<=', 8 );
                                    })
                                    ->select('id','skpd','id_eselon')->get();
                    $kapus_list = [];
                    foreach ($level3a as $x) {
                        $kapus_list[] = array( 'id' => $x->id );
                    }

                    $level3b = SKPD::WHEREIN('parent_id',$kapus_list)
                                    ->where(function ($query) {
                                        $query->where('id_eselon', '=' , null )
                                            ->orWhere('id_eselon', '<=', 8 );
                                    })
                                    ->select('id','skpd','id_eselon')->get();

                    $level3 = $level3a->merge($level3b);
            
                
                }else if ( $request->id == 61832 ){  //61832 adalah PRKP
                    $level3a = SKPD::where('parent_id','=',$request->id)
                                    ->where(function ($query) {
                                        $query->where('id_eselon', '=' , null )
                                            ->orWhere('id_eselon', '<=', 8 );
                                    })
                                    ->select('id','skpd','id_eselon')->get();
                    $kapus_list = [];
                    foreach ($level3a as $x) {
                        $kapus_list[] = array( 'id' => $x->id );
                    }

                    $level3b = SKPD::WHEREIN('parent_id',$kapus_list)
                                    ->where(function ($query) {
                                        $query->where('id_eselon', '=' , null )
                                            ->orWhere('id_eselon', '<=', 8 );
                                    })
                                    ->select('id','skpd','id_eselon')->get();

                    $level3 = $level3a->merge($level3b);
            
                
                }else{
                    $level3 = SKPD::where('parent_id','=',$request->id)
                                    ->where(function ($query) {
                                        $query->where('id_eselon', '=' , null )
                                            ->orWhere('id_eselon', '<=', 8 );
                                    })
                                    ->select('id','skpd','id_eselon')->get();
                }


                foreach ($level3 as $z) {

                    $data_level3['id']	            =  $z->id;
                    $data_level3['data']	        = "level_3";
                    $data_level3['text']			= Pustaka::capital_string($z->skpd);
                    $data_level3['icon']            = "jstree-people   faa-pulse animated-hover ";
                    $data_level3['type']            = "pengawas";
                    $data_level3['children']        = true ;
                    //$data_level3['state']           = $state;


                    $level3_list[] = $data_level3 ;
                }

                if(!empty($level3_list)) { 
                    return $level3_list;
                }else{
                    return "[{}]";
                }
               
            break;
            case 'level_3': //jika klik level 3
                $kegiatan = Kegiatan::WHERE('jabatan_id','=',$request->id)
                                    ->WHERE('renja_id',$request->renja_id)
                                    ->select('id','label','cost')
                                    ->get();

                foreach ($kegiatan as $a) {
                    $data_kegiatan['id']	        = $a->id;
                    $data_kegiatan['data']          = "kegiatan";
                    $data_kegiatan['type']          = "kegiatan";
                    $data_kegiatan['text']			= Pustaka::capital_string($a->label);
                    
                    if ( $a->cost > 0 ){
                            $data_kegiatan['icon']  = "jstree-kegiatan";
                    }else{
                        $data_kegiatan['icon']      = "jstree-kegiatan_non_anggaran";
                    }
                    $data_kegiatan['children']      = true ;

                    $kegiatan_list[] = $data_kegiatan ;
                }

                if(!empty($kegiatan_list)) { 
                    return $kegiatan_list;
                }else{
                    return "[{}]";
                }

            break;
            case 'kegiatan':
                $ind_kegiatan = IndikatorKegiatan:: where('kegiatan_id','=',$request->id)->select('id','label')->get();
                foreach ($ind_kegiatan as $g) {
                    $data_ind_kegiatan['id']	        = $g->id;
                    $data_ind_kegiatan['data']          = "ind_kegiatan";
                    $data_ind_kegiatan['type']          = "ind_kegiatan";
                    $data_ind_kegiatan['text']			= Pustaka::capital_string($g->label);
                    $data_ind_kegiatan['icon']          = "jstree-ind_kegiatan";
                    $data_ind_kegiatan['children']      = true ;

                    $ind_kegiatan_list[] = $data_ind_kegiatan ;
                }

                if(!empty($ind_kegiatan_list)) { 
                    return $ind_kegiatan_list;
                }else{
                    return "[{}]";
                }
            break;
            case 'ind_kegiatan':
                $ra = RencanaAksi::WHERE('indikator_kegiatan_id',$request->id)->get();
                foreach ($ra as $za) {
                    $data_rencana_aksi['id']	    = $za->id;
                    $data_rencana_aksi['type']      = "rencana_aksi";
                    $data_rencana_aksi['data']      = "rencana_aksi";
                    $data_rencana_aksi['text']	    = Pustaka::capital_string($za->label).' ['. Pustaka::bulan($za->waktu_pelaksanaan).']';
                    $data_rencana_aksi['icon']      = 'jstree-rencana_aksi';
                    $data_rencana_aksi['children']  = true ;
                    $rencana_aksi_list[] = $data_rencana_aksi ;
                }

                if(!empty($rencana_aksi_list)) { 
                    return $rencana_aksi_list;
                }else{
                    return "[{}]";
                }
            break;
            case 'rencana_aksi':
                $kb = KegiatanSKPBulanan::WHERE('rencana_aksi_id',$request->id)->get();
                foreach ($kb as $az) {
                    $data_keg_bulanan['id']	    = $az->id;
                    $data_keg_bulanan['data']   = "kegiatan_bulanan";
                    $data_keg_bulanan['type']   = "kegiatan_bulanan";
                    $data_keg_bulanan['text']	=  'Target : '. $az->target.' '.$az->satuan.' / Pelaksana : '.Pustaka::capital_string($az->RencanaAksi->pelaksana->jabatan);
                    $data_keg_bulanan['icon']	= 'jstree-target';
                
                    $keg_bulanan_list[] = $data_keg_bulanan ;
                }

                if(!empty($keg_bulanan_list)) { 
                    return $keg_bulanan_list;
                }else{
                    return "[{}]";
                }	
            break;
            default:
            return "[{}]";
            break;
        }
        
        
    }



    public function SKPTahunanKegiatanTreeSekda(Request $request)
    {
       
        //Kegiatan nya KABID , cari KASUBID yang parent KABID ini
        $x = Jabatan::
                            
                            leftjoin('demo_asn.m_skpd AS kasubid', function($join){
                                $join   ->on('kasubid.parent_id','=','m_skpd.id');
                            })
                            ->SELECT('kasubid.id')
                            ->WHERE('m_skpd.parent_id', $request->jabatan_id )
                            ->get()
                            ->toArray();  

        $child = Jabatan::
                            
                            leftjoin('demo_asn.m_skpd AS kasubid', function($join){
                                $join   ->on('kasubid.parent_id','=','m_skpd.id');
                            })
                            ->SELECT('kasubid.id')
                            ->WHEREIN('m_skpd.id', $x )
                            ->get()
                            ->toArray(); 


        $kegiatan = Kegiatan::SELECT('id','label')
                            ->WHERE('renja_kegiatan.renja_id', $request->renja_id )
                            ->WHEREIN('renja_kegiatan.jabatan_id',$child )
                            ->leftjoin('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join){
                                $join   ->on('kegiatan_tahunan.kegiatan_id','=','renja_kegiatan.id');
                                //$join   ->WHERE('kegiatan_tahunan.skp_tahunan_id','=', $skp_tahunan_id );
                            })
                            ->SELECT(   'renja_kegiatan.id AS kegiatan_id',
                                        'renja_kegiatan.label AS kegiatan_label',
                                        'kegiatan_tahunan.id AS kegiatan_tahunan_id'
                                    ) 
                            ->get();

        //return $child;   
                            
        $kegiatan_list = [];
		foreach ($kegiatan as $x) {
            if ( $x->kegiatan_tahunan_id >= 1 ){
                $kegiatan_id    = "KegiatanTahunan|".$x->kegiatan_tahunan_id;
            }else{
                $kegiatan_id    = "KegiatanRenja|".$x->kegiatan_id."|".$x->kegiatan_label;
            }
            $data_kegiatan['id']	        = $kegiatan_id;
			$data_kegiatan['text']			= Pustaka::capital_string($x->kegiatan_label);
            $data_kegiatan['icon']	        = 'jstree-kegiatan';
            //RENCANA AKSI
            $ra = RencanaAksi::WHERE('kegiatan_tahunan_id',$x->kegiatan_tahunan_id)->get();
            foreach ($ra as $y) {
                $data_rencana_aksi['id']	        = "RencanaAksi|".$y->id;
                $data_rencana_aksi['text']			= Pustaka::capital_string($y->label).' ['. Pustaka::bulan($y->waktu_pelaksanaan).']';
                $data_rencana_aksi['icon']	        = 'jstree-rencana_aksi';
              
                $rencana_aksi_list[] = $data_rencana_aksi ;
            }	
            if(!empty($rencana_aksi_list)) {
                $data_kegiatan['children']     = $rencana_aksi_list;
            }
            $kegiatan_list[] = $data_kegiatan ;
            $rencana_aksi_list = "";
            unset($data_kegiatan['children']);
        }	
		return  $kegiatan_list;
    }

    public function SKPTahunanKegiatanTree1(Request $request)
    {
       
        //Kegiatan nya KABID , cari KASUBID yang parent KABID ini
        $child = Jabatan::
                            
                            leftjoin('demo_asn.m_skpd AS kasubid', function($join){
                                $join   ->on('kasubid.parent_id','=','m_skpd.id');
                            })
                            ->SELECT('kasubid.id')
                            ->WHERE('m_skpd.parent_id', $request->jabatan_id )
                            ->get()
                            ->toArray();  

        


        $kegiatan = Kegiatan::SELECT('id','label')
                            ->WHERE('renja_kegiatan.renja_id', $request->renja_id )
                            ->WHEREIN('renja_kegiatan.jabatan_id',$child )
                            ->leftjoin('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join){
                                $join   ->on('kegiatan_tahunan.kegiatan_id','=','renja_kegiatan.id');
                                //$join   ->WHERE('kegiatan_tahunan.skp_tahunan_id','=', $skp_tahunan_id );
                            })
                            ->SELECT(   'renja_kegiatan.id AS kegiatan_id',
                                        'renja_kegiatan.label AS kegiatan_label',
                                        'kegiatan_tahunan.id AS kegiatan_tahunan_id'
                                    ) 
                            ->get();

        //return $child;   
                            
        $kegiatan_list = [];
		foreach ($kegiatan as $x) {
            if ( $x->kegiatan_tahunan_id >= 1 ){
                $kegiatan_id                    = "KegiatanTahunan|".$x->kegiatan_tahunan_id;
                $kegiatan_label                 = $x->kegiatan_label;
                $data_kegiatan['icon']	        = 'jstree-kegiatan_tahunan';
            }else{
                $kegiatan_id                    = "KegiatanRenja|".$x->kegiatan_id."|".$x->kegiatan_label;
                $kegiatan_label                 = $x->kegiatan_label;
                $data_kegiatan['icon']	        = 'jstree-kegiatan';
            }
                    
                                $data_kegiatan['id']	            = $kegiatan_id;
                                $data_kegiatan['text']			    = Pustaka::capital_string($kegiatan_label);
                                
                              
                    
                                //Indikator Kegiatan
                                $ik = IndikatorKegiatan::WHERE('kegiatan_id',$x->kegiatan_id)->get();
                    
                                foreach ($ik as $y) {
                                    $data_ind_kegiatan['id']	        = "IndikatorKegiatan|".$y->id;
                                    $data_ind_kegiatan['text']			= Pustaka::capital_string($y->label);
                                    $data_ind_kegiatan['icon']	        = 'jstree-ind_kegiatan';
                                  
                    
                                        //Rencana aksi
                                        $ra = RencanaAksi::WHERE('indikator_kegiatan_id',$y->id)->get();
                    
                                        foreach ($ra as $z) {
                                            $data_rencana_aksi['id']	        = "RencanaAksi|".$z->id;
                                            $data_rencana_aksi['text']			= Pustaka::capital_string($z->label).' ['. Pustaka::bulan($z->waktu_pelaksanaan).']';
                                            $data_rencana_aksi['icon']	        = 'jstree-rencana_aksi';
                                          
                            
                                            //TARGET PADA KEGIATAN BULANAN
                                           /*  $kb = KegiatanSKPBulanan::WHERE('rencana_aksi_id',$z->id)->get();
                                            foreach ($kb as $a) {
                                                $data_keg_bulanan['id']	        = "KegiatanBulanan|".$a->id;
                                                $data_keg_bulanan['text']			=  'Target : '. $a->target.' '.$a->satuan.' / Pelaksana : '.Pustaka::capital_string($a->RencanaAksi->pelaksana->jabatan);
                                                $data_keg_bulanan['icon']	        = 'jstree-target';
                                            
                                
                                                $keg_bulanan_list[] = $data_keg_bulanan ;
                                            }	
                    
                                            if(!empty($keg_bulanan_list)) {
                                                $data_rencana_aksi['children']     = $keg_bulanan_list;
                                            } */
                                            $rencana_aksi_list[] = $data_rencana_aksi ;
                                            $keg_bulanan_list = "";
                                            unset($data_rencana_aksi['children']);
                                        }	
                    
                                        
                                    if(!empty($rencana_aksi_list)) {
                                        $data_ind_kegiatan['children']     = $rencana_aksi_list;
                                    }
                    
                                    $ind_kegiatan_list[] = $data_ind_kegiatan ;
                                    $rencana_aksi_list = "";
                                    unset($data_ind_kegiatan['children']); 
                                    //$ind_kegiatan_list[] = $data_ind_kegiatan ;
                    
                                   
                                }	
                    
                    
                                if(!empty($ind_kegiatan_list)) {
                                    $data_kegiatan['children']     = $ind_kegiatan_list;
                                }
                    
                                $kegiatan_list[] = $data_kegiatan ;
                                $ind_kegiatan_list = "";
                                unset($data_kegiatan['children']);
        }	
		return  $kegiatan_list;
    }
    
    public function SKPTahunanKegiatanTree2(Request $request)
    {
       
        //Kegiatan nya KABID , cari KASUBID yang parent KABID ini
        $child = Jabatan::SELECT('id')->WHERE('parent_id', $request->jabatan_id )->get()->toArray(); 
        $skp_tahunan_id = $request->skp_tahunan_id;
        $kegiatan = Kegiatan::SELECT('id','label')
                            ->WHERE('renja_kegiatan.renja_id', $request->renja_id )
                            ->WHEREIN('renja_kegiatan.jabatan_id',$child )
                            ->join('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join) use ( $skp_tahunan_id ){
                                $join   ->on('kegiatan_tahunan.kegiatan_id','=','renja_kegiatan.id');
                                //$join   ->WHERE('kegiatan_tahunan.skp_tahunan_id','=', $skp_tahunan_id );
                            })
                            ->SELECT(   'renja_kegiatan.id AS kegiatan_id',
                                        'renja_kegiatan.label AS kegiatan_label',
                                        'kegiatan_tahunan.id AS kegiatan_tahunan_id',
                                        'kegiatan_tahunan.label AS kegiatan_tahunan_label'
                                    ) 
                            ->get();

        $kegiatan_list = [];
        foreach ($kegiatan as $x) {
            if ( $x->kegiatan_tahunan_id >= 1 ){
                $kegiatan_id                    = "KegiatanTahunan|".$x->kegiatan_tahunan_id;
                $kegiatan_label                 = $x->kegiatan_tahunan_label;
                $data_kegiatan['icon']	        = 'jstree-kegiatan_tahunan';
            }else{
                $kegiatan_id                    = "KegiatanRenja|".$x->kegiatan_id."|".$x->kegiatan_label;
                $kegiatan_label                 = $x->kegiatan_label;
                $data_kegiatan['icon']	        = 'jstree-kegiatan';
            }
                    
                                $data_kegiatan['id']	            = $kegiatan_id;
                                $data_kegiatan['text']			    = Pustaka::capital_string($kegiatan_label);
                                
                              
                    
                                //Indikator Kegiatan
                                $ik = IndikatorKegiatan::WHERE('kegiatan_id',$x->kegiatan_id)->get();
                    
                                foreach ($ik as $y) {
                                    $data_ind_kegiatan['id']	        = "IndikatorKegiatan|".$y->id;
                                    $data_ind_kegiatan['text']			= Pustaka::capital_string($y->label);
                                    $data_ind_kegiatan['icon']	        = 'jstree-ind_kegiatan';
                                  
                    
                                        //Rencana aksi
                                        $ra = RencanaAksi::WHERE('indikator_kegiatan_id',$y->id)->get();
                    
                                        foreach ($ra as $z) {
                                            $data_rencana_aksi['id']	        = "RencanaAksi|".$z->id;
                                            $data_rencana_aksi['text']			= Pustaka::capital_string($z->label).' ['. Pustaka::bulan($z->waktu_pelaksanaan).']';
                                            $data_rencana_aksi['icon']	        = 'jstree-rencana_aksi';
                                          
                            
                                            //TARGET PADA KEGIATAN BULANAN
                                            $kb = KegiatanSKPBulanan::WHERE('rencana_aksi_id',$z->id)->get();
                                            foreach ($kb as $a) {
                                                $data_keg_bulanan['id']	        = "KegiatanBulanan|".$a->id;
                                                $data_keg_bulanan['text']			=  'Target : '. $a->target.' '.$a->satuan.' / Pelaksana : '.Pustaka::capital_string($a->RencanaAksi->pelaksana->jabatan);
                                                $data_keg_bulanan['icon']	        = 'jstree-target';
                                            
                                
                                                $keg_bulanan_list[] = $data_keg_bulanan ;
                                            }	
                    
                                            if(!empty($keg_bulanan_list)) {
                                                $data_rencana_aksi['children']     = $keg_bulanan_list;
                                            }
                                            $rencana_aksi_list[] = $data_rencana_aksi ;
                                            $keg_bulanan_list = "";
                                            unset($data_rencana_aksi['children']);
                                        }	
                    
                                        
                                    if(!empty($rencana_aksi_list)) {
                                        $data_ind_kegiatan['children']     = $rencana_aksi_list;
                                    }
                    
                                    $ind_kegiatan_list[] = $data_ind_kegiatan ;
                                    $rencana_aksi_list = "";
                                    unset($data_ind_kegiatan['children']); 
                                    //$ind_kegiatan_list[] = $data_ind_kegiatan ;
                    
                                   
                                }	
                    
                    
                                if(!empty($ind_kegiatan_list)) {
                                    $data_kegiatan['children']     = $ind_kegiatan_list;
                                }
                    
                                $kegiatan_list[] = $data_kegiatan ;
                                $ind_kegiatan_list = "";
                                unset($data_kegiatan['children']);
                    
                            }	
                    
                            return  $kegiatan_list;
                           
    } 

    public function SKPTahunanKegiatanTree3(Request $request)
    {
       
        //Kegiatan nya ESELON IV
        $skp_tahunan_id = $request->skp_tahunan_id;
        $kegiatan = Kegiatan::SELECT('id','label')
                            ->WHERE('renja_kegiatan.renja_id', $request->renja_id )
                            ->WHERE('renja_kegiatan.jabatan_id',$request->jabatan_id )
                            ->leftjoin('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join) use ( $skp_tahunan_id ){
                                $join   ->on('kegiatan_tahunan.kegiatan_id','=','renja_kegiatan.id');
                                $join   ->WHERE('kegiatan_tahunan.skp_tahunan_id','=', $skp_tahunan_id );
                            })
                            ->SELECT(   'renja_kegiatan.id AS kegiatan_id',
                                        'renja_kegiatan.label AS kegiatan_label',
                                        'kegiatan_tahunan.id AS kegiatan_tahunan_id',
                                        'kegiatan_tahunan.label AS kegiatan_tahunan_label'
                                    ) 
                            ->get(); 
        
        $kegiatan_list = [];    
		foreach ($kegiatan as $x) {
            if ( $x->kegiatan_tahunan_id >= 1 ){
                $kegiatan_id                    = "KegiatanTahunan|".$x->kegiatan_tahunan_id;
                $kegiatan_label                 = $x->kegiatan_tahunan_label;
                $data_kegiatan['icon']	        = 'jstree-kegiatan_tahunan';

                $ik = IndikatorKegiatan::WHERE('kegiatan_id',$x->kegiatan_id)->get();
            }else{
                $kegiatan_id                    = "KegiatanRenja|".$x->kegiatan_id;
                $kegiatan_label                 = $x->kegiatan_label;
                $data_kegiatan['icon']	        = 'jstree-kegiatan';

                $ik = [];
            }
            $data_kegiatan['id']	            = $kegiatan_id;
            $data_kegiatan['text']			    = Pustaka::capital_string($kegiatan_label);
            
          
            //Indikator Kegiatan
            //$ik = IndikatorKegiatan::WHERE('kegiatan_id',$x->kegiatan_id)->get();
           
            foreach ($ik as $y) {
                $data_ind_kegiatan['id']	        = "IndikatorKegiatan|".$y->id;
                $data_ind_kegiatan['text']			= Pustaka::capital_string($y->label);
                $data_ind_kegiatan['icon']	        = 'jstree-ind_kegiatan';
              
                    //Rencana aksi
                    $ra = RencanaAksi::WHERE('indikator_kegiatan_id',$y->id)
                                        ->WHERE('kegiatan_tahunan_id',$x->kegiatan_tahunan_id) 
                                        ->orderBy('waktu_pelaksanaan','ASC')
                                        ->orderBy('id','DESC')
                                        ->get();
                    foreach ($ra as $z) {
                        $data_rencana_aksi['id']	        = "RencanaAksi|".$z->id;
                        $data_rencana_aksi['text']			= Pustaka::capital_string($z->label).' ['. Pustaka::bulan($z->waktu_pelaksanaan).']';
                        $data_rencana_aksi['icon']	        = 'jstree-rencana_aksi';
                      
        
                        //TARGET PADA KEGIATAN BULANAN
                        $kb = KegiatanSKPBulanan::WHERE('rencana_aksi_id',$z->id)->get();
                        foreach ($kb as $a) {
                            $data_keg_bulanan['id']	        = "KegiatanBulanan|".$a->id;
                            $data_keg_bulanan['text']			=  'Target : '. $a->target.' '.$a->satuan.' / Pelaksana : '.Pustaka::capital_string($a->RencanaAksi->pelaksana->jabatan);
                            $data_keg_bulanan['icon']	        = 'jstree-target';
                        
            
                            $keg_bulanan_list[] = $data_keg_bulanan ;
                        }	
                        if(!empty($keg_bulanan_list)) {
                            $data_rencana_aksi['children']     = $keg_bulanan_list;
                        }
                        $rencana_aksi_list[] = $data_rencana_aksi ;
                        $keg_bulanan_list = "";
                        unset($data_rencana_aksi['children']);
                    }	
                    
                if(!empty($rencana_aksi_list)) {
                    $data_ind_kegiatan['children']     = $rencana_aksi_list;
                }
                $ind_kegiatan_list[] = $data_ind_kegiatan ;
                $rencana_aksi_list = "";
                unset($data_ind_kegiatan['children']); 
                //$ind_kegiatan_list[] = $data_ind_kegiatan ;
               
            }	
            if(!empty($ind_kegiatan_list)) {
                $data_kegiatan['children']     = $ind_kegiatan_list;
            }
            $kegiatan_list[] = $data_kegiatan ;
            $ind_kegiatan_list = "";
            unset($data_kegiatan['children']);
        }	
        
        return  $kegiatan_list;
       
    }
   
    public function SKPTahunanKegiatanTree4(Request $request)
    {
       
       
        $rencana_aksi = RencanaAksi::WHERE('jabatan_id',$request->jabatan_id)
                            ->WHERE('renja_id',$request->renja_id)
                            ->leftjoin('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join){
                                $join  ->on('skp_tahunan_rencana_aksi.kegiatan_tahunan_id','=','kegiatan_tahunan.id');
                            })
                           
                            ->SELECT(   'skp_tahunan_rencana_aksi.id AS rencana_aksi_id',
                                        'skp_tahunan_rencana_aksi.label AS rencana_aksi_label',
                                        'kegiatan_tahunan.label AS kegiatan_tahunan_label',
                                        'kegiatan_tahunan.id AS kegiatan_tahunan_id',
                                        'kegiatan_tahunan.target',
                                        'kegiatan_tahunan.satuan',
                                        'kegiatan_tahunan.angka_kredit',
                                        'kegiatan_tahunan.quality',
                                        'kegiatan_tahunan.cost',
                                        'kegiatan_tahunan.target_waktu'
                                    ) 
                            ->groupBy('kegiatan_tahunan.id')
                            ->distinct()
                            ->get();
        $kegiatan_list = [];
		foreach ($rencana_aksi as $x) {
            if ( $x->kegiatan_tahunan_id >= 1 ){
                $kegiatan_id    = "KegiatanTahunan|".$x->kegiatan_tahunan_id;
                $kegiatan_label = $x->kegiatan_tahunan_label;
            }else{
                $kegiatan_id    = "KegiatanRenja|".$x->kegiatan_id."|".$x->kegiatan_label;
                $kegiatan_label = $x->kegiatan_label;
            }
            $data_kegiatan['id']	        = $kegiatan_id;
            $data_kegiatan['text']			= Pustaka::capital_string($kegiatan_label);
            $data_kegiatan['icon']	        = 'jstree-kegiatan_tahunan';
          
            //RENCANA AKSI
            $ra = RencanaAksi::WHERE('kegiatan_tahunan_id',$x->kegiatan_tahunan_id)->WHERE('jabatan_id',$request->jabatan_id)->orderBY('waktu_pelaksanaan')->orderBY('id','DESC')->get();
            foreach ($ra as $y) {
                $data_rencana_aksi['id']	        = "KegiatanBulanan|".$y->id;
                $data_rencana_aksi['text']			= Pustaka::capital_string($y->label).' ['. Pustaka::bulan($y->waktu_pelaksanaan).']';
                $data_rencana_aksi['icon']	        = 'jstree-kegiatan_bulanan';
              
                $rencana_aksi_list[] = $data_rencana_aksi ;
            }	
            if(!empty($rencana_aksi_list)) {
                $data_kegiatan['children']     = $rencana_aksi_list;
            }
            $kegiatan_list[] = $data_kegiatan ;
            $rencana_aksi_list = "";
            unset($data_kegiatan['children']);
        }	
		return  $kegiatan_list; 
        
    } 


    public function SKPTahunanKegiatanTree5(Request $request)
    {
       
        //Kegiatan nya JFT
        //MULAI DARI SASARAN

        $skp_tahunan_id = $request->skp_tahunan_id;
        $sasaran = Tujuan::
                           
                            join('db_pare_2018.renja_sasaran AS sasaran', function($join){
                                $join   ->on('sasaran.tujuan_id','=','renja_tujuan.id');
                                
                            }) 
                            ->WHERE('renja_tujuan.renja_id', $request->renja_id )
                            ->SELECT(   'sasaran.id AS sasaran_id',
                                        'sasaran.label AS sasaran_label'
                                    ) 
                            ->get(); 

        $kegiatan_list = [];
		foreach ($sasaran as $x) {
           
            $data_sasaran['id']            = "SasaranRenja|".$x->sasaran_id;
            $data_sasaran['text']          = $x->sasaran_label;
            $data_sasaran['icon']	       = 'jstree-sasaran';
            $data_sasaran['type']	       = 'sasaran';
           
            
            //Kegiatan TAhunan JFT
            $kst = KegiatanSKPTahunanJFT::WHERE('sasaran_id',$x->sasaran_id)
                                            ->WHERE('skp_tahunan_id',$skp_tahunan_id)
                                            ->get();
            foreach ($kst as $y) {
                $data_keg_tahunan['id']	        = "KegiatanTahunan|".$y->id;
                $data_keg_tahunan['text']			= Pustaka::capital_string($y->label);
                $data_keg_tahunan['icon']	        = 'jstree-kegiatan_tahunan';
              
                    //Rencana aksi
                    $ra = RencanaAksi::WHERE('indikator_kegiatan_id',$y->id)
                                        ->WHERE('kegiatan_tahunan_id',$x->kegiatan_tahunan_id)
                                        ->get();
                    foreach ($ra as $z) {
                        $data_rencana_aksi['id']	        = "RencanaAksi|".$z->id;
                        $data_rencana_aksi['text']			= Pustaka::capital_string($z->label).' ['. Pustaka::bulan($z->waktu_pelaksanaan).']';
                        $data_rencana_aksi['icon']	        = 'jstree-rencana_aksi';
                      
        
                        //TARGET PADA KEGIATAN BULANAN
                        $kb = KegiatanSKPBulanan::WHERE('rencana_aksi_id',$z->id)->get();
                        foreach ($kb as $a) {
                            $data_keg_bulanan['id']	        = "KegiatanBulanan|".$a->id;
                            $data_keg_bulanan['text']			=  'Target : '. $a->target.' '.$a->satuan.' / Pelaksana : '.Pustaka::capital_string($a->RencanaAksi->pelaksana->jabatan);
                            $data_keg_bulanan['icon']	        = 'jstree-target';
                        
            
                            $keg_bulanan_list[] = $data_keg_bulanan ;
                        }	
                        if(!empty($keg_bulanan_list)) {
                            $data_rencana_aksi['children']     = $keg_bulanan_list;
                        }
                        $rencana_aksi_list[] = $data_rencana_aksi ;
                        $keg_bulanan_list = "";
                        unset($data_rencana_aksi['children']);
                    }	
                    
                if(!empty($rencana_aksi_list)) {
                    $data_keg_tahunan['children']     = $rencana_aksi_list;
                }
                $ind_kegiatan_list[] = $data_keg_tahunan ;
                $rencana_aksi_list = "";
                unset($data_keg_tahunan['children']); 
                //$ind_kegiatan_list[] = $data_ind_kegiatan ;
               
            }	
            if(!empty($ind_kegiatan_list)) {
                $data_sasaran['children']     = $ind_kegiatan_list;
            }
            $kegiatan_list[] = $data_sasaran ;
            $ind_kegiatan_list = "";
            unset($data_sasaran['children']);
        }	
        
        return  $kegiatan_list;
       
        
    }

    public function KegiatanDetail(Request $request)
    {
       
        
        $x = Kegiatan::SELECT('id','label')
                            ->WHERE('renja_kegiatan.id', $request->get('kegiatan_id') )
                            ->SELECT(   'renja_kegiatan.id AS kegiatan_id',
                                        'renja_kegiatan.label AS label',
                                        'renja_kegiatan.indikator AS indikator',
                                        'renja_kegiatan.target AS target',
                                        'renja_kegiatan.satuan AS satuan',
                                        'renja_kegiatan.cost AS cost',
                                        'renja_kegiatan.jabatan_id'
                                    ) 
                            ->first();
        $list = IndikatorKegiatan::SELECT('id','label','target','satuan')
                            ->WHERE('kegiatan_id','=', $request->get('kegiatan_id') )
                            ->get()
                            ->toArray();
		
        $kegiatan = array(
                'kegiatan_id'   => $x->kegiatan_id,
                'label'         => $x->label,
                'indikator'     => $x->indikator,
                'target'        => $x->target,
                'satuan'        => $x->satuan,
                'output'        => $x->target.' '.$x->satuan,
                'quality'       => '-',
                'target_waktu'  => '-',
                'cost'	        => number_format($x->cost,'0',',','.'),
                'pejabat'       => Pustaka::capital_string($x->jabatan_id != '0' ? $x->PenanggungJawab->jabatan : '0'),
                'list_indikator'=> $list,   
            );
        return $kegiatan;
        
    }
    
    public function RenjaKegiatanList(Request $request)
    {
        
        
        $dt = Kegiatan::WHERE('renja_id','=',$request->renja_id)
                ->WHERE('jabatan_id','0')
                ->select([   
                    'id AS kegiatan_id',
                    'label',
                    'indikator',
                    'target',
                    'satuan',
                    'cost'
                    
                    ])
                ->get();
                
        $datatables = Datatables::of($dt)
        ->addColumn('checkbox', function ($x) {
           
            return '<input type="checkbox" class="cb_pilih" value="'.$x->kegiatan_id.'" name="cb_pilih[]" >';
        })
        ->addColumn('label', function ($x) {
            return $x->label;
        })
        ->addColumn('kegiatan_target', function ($x) {
            return $x->target.' '.$x->satuan;
        })
        ->addColumn('kegiatan_anggaran', function ($x) {
            return "Rp.  " .number_format($x->cost,'0',',','.') ;
        });
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 
        return $datatables->make(true); 
        
    }
    public function KegiatanList(Request $request)
    {
        $dt = Kegiatan::where('program_id', '=' ,$request->get('program_id'))
                        ->WHERE('renja_id',$request->get('renja_id'))
                        ->WHERE('cost','>', 0 )
                        ->select([   
                            'id AS kegiatan_id',
                            'label AS label_kegiatan',
                            'indikator',
                            'target',
                            'satuan',
                            'cost',
                            'jabatan_id'
                            ])
                            ->get();
        $datatables = Datatables::of($dt)
            ->addColumn('label_kegiatan', function ($x) {
            return $x->label_kegiatan;
         })
         ->addColumn('indikator_kegiatan', function ($x) {
            return $x->indikator;
        })
        ->addColumn('target_kegiatan', function ($x) {
            return $x->target.' '.$x->satuan ;
        })
        ->addColumn('cost_kegiatan', function ($x) {
            return "Rp.  " .number_format($x->cost,'0',',','.') ;
        })
        ->addColumn('action', function ($x) {
            return $x->kegiatan_id;
        });
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 
        return $datatables->make(true);
        
    }
    public function KegiatanNonAnggaranList(Request $request)
    {
        //JUMLAH kegiatan anggaran
        $jm_data = Kegiatan::where('program_id', '=' ,$request->get('program_id'))
                ->WHERE('renja_id',$request->get('renja_id'))
                ->WHERE('cost','>', 0 )
                ->count();
        $dt = Kegiatan::where('program_id', '=' ,$request->get('program_id'))
                        ->WHERE('renja_id',$request->get('renja_id'))
                        ->WHERE('cost','<=', 0 )
                        ->select([   
                            'id AS kegiatan_id',
                            'label AS label_kegiatan',
                            'indikator',
                            'target',
                            'satuan',
                            'cost',
                            'jabatan_id'
                            ])
                            ->get();
        $datatables = Datatables::of($dt)
        ->addColumn('label_kegiatan', function ($x) {
            return $x->label_kegiatan;
        })
        ->addColumn('indikator_kegiatan', function ($x) {
            return $x->indikator;
        })
        ->addColumn('target_kegiatan', function ($x) {
            return $x->target.' '.$x->satuan ;
        })
        ->addColumn('cost_kegiatan', function ($x) {
            return "Rp.  " .number_format($x->cost,'0',',','.') ;
        })
        ->addColumn('action', function ($x) {
            return $x->kegiatan_id;
        })
        ->addColumn('jm_data', function ($x) use($jm_data) {
            return $jm_data;
        });
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 
        return $datatables->make(true);
        
    }
    public function PohonKinerjaKegiatanKegiatanList(Request $request)
    {
        $dt = Kegiatan::where('renja_id', '=' ,$request->get('renja_id'))
                        ->leftjoin('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join){
                            $join   ->on('kegiatan_tahunan.kegiatan_id','=','renja_kegiatan.id');
                            
                        })
                        ->WHERE('renja_kegiatan.cost','>', 0 )
                        ->select([   
                            'kegiatan_tahunan.id AS kegiatan_tahunan_id',
                            'renja_kegiatan.id AS kegiatan_id',
                            'renja_kegiatan.label AS label_kegiatan',
                            'renja_kegiatan.indikator',
                            'renja_kegiatan.target',
                            'renja_kegiatan.satuan',
                            'renja_kegiatan.cost',
                            'renja_kegiatan.jabatan_id'
                            ])
                            ->get();
        $datatables = Datatables::of($dt)
            ->addColumn('label_kegiatan', function ($x) {
            return $x->label_kegiatan;
         })
         ->addColumn('indikator_kegiatan', function ($x) {
            return $x->indikator;
        })
        ->addColumn('target_kegiatan', function ($x) {
            return $x->target.' '.$x->satuan ;
        })
        ->addColumn('cost_kegiatan', function ($x) {
            return "Rp.  " .number_format($x->cost,'0',',','.') ;
        })
        ->addColumn('action', function ($x) {
            return $x->kegiatan_id;
        })
        ->addColumn('penanggung_jawab', function ($x) {
            if ( $x->PenanggungJawab != null ){
                return Pustaka::capital_string($x->PenanggungJawab->jabatan);
            }else{
                return "-";
            }
            
        });
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 
        return $datatables->make(true);
        
    }
    public function PohonKinerjaKegiatanKegiatanNonAnggaranList(Request $request)
    {
        //JUMLAH kegiatan anggaran
        $jm_data = Kegiatan::WHERE('renja_id',$request->get('renja_id'))
                ->WHERE('cost','>', 0 )
                ->count();
        $dt = Kegiatan::WHERE('renja_id',$request->get('renja_id'))
                        ->WHERE('cost','<=', 0 )
                        ->select([   
                            'id AS kegiatan_id',
                            'label AS label_kegiatan',
                            'indikator',
                            'target',
                            'satuan',
                            'cost',
                            'jabatan_id'
                            ])
                            ->get();
        $datatables = Datatables::of($dt)
        ->addColumn('label_kegiatan', function ($x) {
            return $x->label_kegiatan;
        })
        ->addColumn('indikator_kegiatan', function ($x) {
            return $x->indikator;
        })
        ->addColumn('target_kegiatan', function ($x) {
            return $x->target.' '.$x->satuan ;
        })
        ->addColumn('cost_kegiatan', function ($x) {
            return "Rp.  " .number_format($x->cost,'0',',','.') ;
        })
        ->addColumn('action', function ($x) {
            return $x->kegiatan_id;
        })
        ->addColumn('jm_data', function ($x) use($jm_data) {
            return $jm_data;
        })
        ->addColumn('penanggung_jawab', function ($x) {
            if ( $x->PenanggungJawab != null ){
                return Pustaka::capital_string($x->PenanggungJawab->jabatan);
            }else{
                return "-";
            }
            
        });
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 
        return $datatables->make(true);
        
    }
    public function RenjaKegiatanKaSKPD(Request $request)
    {
        $dt = Kegiatan::WHERE('renja_id', '=' ,$request->get('renja_id'))
                        //->WHERE('renja_id',$request->get('renja_id'))
                        ->WHERE('jabatan_id','>',0)
                        ->select([   
                            'id AS kegiatan_id',
                            'label AS label_kegiatan',
                            'indikator',
                            'target',
                            'satuan',
                            'cost'
                            ])
                            ->get();
        $datatables = Datatables::of($dt)
            ->addColumn('label_kegiatan', function ($x) {
            return $x->label_kegiatan;
         })
         ->addColumn('indikator_kegiatan', function ($x) {
            return $x->indikator;
        })
        ->addColumn('target_kegiatan', function ($x) {
            return $x->target.' '.$x->satuan ;
        })
        ->addColumn('cost_kegiatan', function ($x) {
            return "Rp.  " .number_format($x->cost,'0',',','.') ;
        })
        ->addColumn('action', function ($x) {
            return $x->kegiatan_id;
        });
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 
        return $datatables->make(true);
        
    }
    public function RenjaKegiatanKabid(Request $request)
    {
        //Kegiatan nya KABID , cari KASUBID yang parent KABID ini
        $child = Jabatan::SELECT('id')->WHERE('parent_id', $request->jabatan_id )->get()->toArray(); 
        $dt = Kegiatan::WHERE('renja_id', '=' ,$request->get('renja_id'))
                        ->WHEREIN('jabatan_id',$child)
                        ->select([   
                            'id AS kegiatan_id',
                            'label AS label_kegiatan',
                            'indikator',
                            'target',
                            'satuan',
                            'cost'
                            ])
                            ->get();
        $datatables = Datatables::of($dt)
            ->addColumn('label_kegiatan', function ($x) {
            return $x->label_kegiatan;
         })
         ->addColumn('indikator_kegiatan', function ($x) {
            return $x->indikator;
        })
        ->addColumn('target_kegiatan', function ($x) {
            return $x->target.' '.$x->satuan ;
        })
        ->addColumn('cost_kegiatan', function ($x) {
            return "Rp.  " .number_format($x->cost,'0',',','.') ;
        })
        ->addColumn('action', function ($x) {
            return $x->kegiatan_id;
        });
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 
        return $datatables->make(true);
        
    }
    public function RenjaKegiatanKasubid(Request $request)
    {
       $dt = Kegiatan::WHERE('renja_id', '=' ,$request->get('renja_id'))
                        ->WHERE('jabatan_id',$request->get('jabatan_id'))
                        ->select([   
                            'id AS kegiatan_id',
                            'label AS label_kegiatan',
                            'indikator',
                            'target',
                            'satuan',
                            'cost'
                            ])
                            ->get();
        $datatables = Datatables::of($dt)
            ->addColumn('label_kegiatan', function ($x) {
            return $x->label_kegiatan;
         })
         ->addColumn('indikator_kegiatan', function ($x) {
            return $x->indikator;
        })
        ->addColumn('target_kegiatan', function ($x) {
            return $x->target.' '.$x->satuan ;
        })
        ->addColumn('cost_kegiatan', function ($x) {
            return "Rp.  " .number_format($x->cost,'0',',','.') ;
        })
        ->addColumn('action', function ($x) {
            return $x->kegiatan_id;
        });
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 
        return $datatables->make(true);
        
    }
    public function AddKegiatanToPejabat(Request $request )
    {
        
        $x = $request->cb_pilih;
        $dt = $request->id_jabatan;
        
        Kegiatan::whereIn('id',$x)
                ->update(['jabatan_id' => $dt]);
        
      
    }
    
    
    public function RemoveKegiatanFromPejabat(Request $request)
    {
        $messages = [
                'kegiatan_id.required'          => 'Harus diisi',
                
        ];
        $validator = Validator::make(
                        Input::all(),
                        array(
                            'kegiatan_id'           => 'required',
                            
                        ),
                        $messages
        );
        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }
        
        $sr    = Kegiatan::find(Input::get('kegiatan_id'));
        $data = $sr->jabatan_id;
        if (is_null($sr)) {
            return $this->sendError('Kegiatan Tidak ditemukan.');
        }
        $sr->jabatan_id     = 0;
        if ( $sr->save()){
            //Hapus semua kegiatan tahunan yang nge link pada kegiatan ini
            KegiatanSKPTahunan::WHERE('kegiatan_id','=',Input::get('kegiatan_id'))->delete();


            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }
    public function Store(Request $request)
    {
        $messages = [
                'program_id.required'           => 'Harus diisi',
                'renja_id.required'             => 'Harus diisi',
                'label_kegiatan.required'       => 'Harus diisi',
                //'cost_kegiatan'                 => 'Harus diisi',
                //'label_ind_kegiatan.required'   => 'Harus diisi',
                //'target_kegiatan.required'      => 'Harus diisi',
                //'satuan_kegiatan.required'    => 'Harus diisi',
        ];
        $validator = Validator::make(
                        Input::all(),
                        array(
                            'program_id'            => 'required',
                            'renja_id'              => 'required',
                            'label_kegiatan'        => 'required',
                            //'cost_kegiatan'         => 'required',
                            //'target_kegiatan'       => 'required',
                            //'satuan_kegiatan'     => 'required',
                        ),
                        $messages
        );
        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }
        $sr    = new Kegiatan;
        $sr->program_id                 = Input::get('program_id');
        $sr->renja_id                   = Input::get('renja_id');
        $sr->label                      = Input::get('label_kegiatan');
        //$sr->indikator                  = Input::get('label_ind_kegiatan');
        //$sr->target                     = Input::get('target_kegiatan');
        //$sr->satuan                     = Input::get('satuan_kegiatan');
        $sr->cost                       = preg_replace('/[^0-9]/', '', Input::get('cost_kegiatan'));
        if ( $sr->save()){
            $tes = array('id' => 'kegiatan|'.$sr->id);
            return \Response::make($tes, 200);
        }else{
            return \Response::make('error', 500);
        } 
    }
    public function Update(Request $request)
    {
        $messages = [
                'kegiatan_id.required'          => 'Harus diisi',
                'label_kegiatan.required'       => 'Harus diisi',
                //'cost_kegiatan.required'        => 'Harus diisi',
                //'target_kegiatan.required'    => 'Harus diisi',
                //'satuan_kegiatan.required'    => 'Harus diisi',
                
        ];
        $validator = Validator::make(
                        Input::all(),
                        array(
                            'kegiatan_id'           => 'required',
                            'label_kegiatan'        => 'required',
                            //'cost_kegiatan'         => 'required',
                            //'target_kegiatan'     => 'required',
                            //'satuan_kegiatan'     => 'required',
                            
                        ),
                        $messages
        );
        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }
        
        $sr    = Kegiatan::find(Input::get('kegiatan_id'));
        if (is_null($sr)) {
            return $this->sendError('Kegiatan Tidak ditemukan.');
        }
        $sr->label                      = Input::get('label_kegiatan');
        //$sr->indikator                  = Input::get('label_ind_kegiatan');
        //$sr->target                     = Input::get('target_kegiatan');
        //$sr->satuan                     = Input::get('satuan_kegiatan');
        $sr->cost                       = preg_replace('/[^0-9]/', '', Input::get('cost_kegiatan'));
        if ( $sr->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }
    public function Hapus(Request $request)
    {
        $messages = [
                'kegiatan_id.required'   => 'Harus diisi',
        ];
        $validator = Validator::make(
                        Input::all(),
                        array(
                            'kegiatan_id'   => 'required',
                        ),
                        $messages
        );
        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }
        
        $sr    = Kegiatan::find(Input::get('kegiatan_id'));
        if (is_null($sr)) {
            return $this->sendError('Kegiatan tidak ditemukan.');
        }
        if ( $sr->delete()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }
    public function Rename(Request $request )
    {
        
        $kegiatan = Kegiatan::find($request->id);
        if (is_null($kegiatan)) {
            return \Response::make('Kegiatan  tidak ditemukan', 404);
        }
        $kegiatan->label = $request->text;
        
        
        if ( $kegiatan->save()){
            return \Response::make('Sukses', 200);
        }else{
            return \Response::make('error', 500);
        }
        
      
    }
   
}