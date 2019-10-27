<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\SasaranPerjanjianKinerja;
use App\Models\Sasaran;
use App\Models\IndikatorSasaran;
use App\Models\Program;
use App\Models\Kegiatan;
use App\Models\KegiatanSKPTahunan;
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
use Gravatar;
use Input;
Use Alert;
class KegiatanAPIController extends Controller {
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
       
        //23-10-2019  distribusi berdasarkan jenis jabatan , 
        //Pimpinan tertinggi / Kaban /eselon II 
        //---- Administrator // KABID // eselon III
        //--------Pengawas // KASUBID // eselonIV  ------- jabatan inilah yang akan diberikan kegiatan
        //Pengecualian untuk irban
        $a = ['143','144','145','146'];
        //pengecualian untuk KEC Telukjambe Barat
        $b = ['1235','1236','1237','1238','1239'];

        // m_skpd ID 168 : UPTD kesehatan
        $pengelompokan = ['168'];

        $pengecualian = array_merge($a,$b);
        if ( $request->skpd_id == 3 ){
            //SEKDA 
            $level1 = SKPD::
                            leftjoin('demo_asn.m_skpd AS data', function($join){
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
            $data_level1['id']	            = "lv1|".$x->id;
			$data_level1['text']		    = Pustaka::capital_string($x->skpd);
            $data_level1['icon']            = "jstree-people";
            $data_level1['type']            = "JPT";
            
        
            //JIKA DINKES maka array level 2 nya di merge dengan uptd puskesmas
            if ( $x->id == '1'){
               
                $level2 = SKPD::where('parent_id','=',$x->id)
                                ->where('id','!=','168')
                                ->orwhere('parent_id','=', '168')
                                ->select('id','skpd')
                                ->get();
            }else{
                $level2 = SKPD::where('parent_id','=',$x->id)->select('id','skpd')->get();
            }

           


            foreach ($level2 as $y) {
                
                if (in_array( $y->id, $pengecualian)){
                //JIKA YANG DIKECUALIKAN,MALAH BISA ADD KEGIATAN
                    $data_level2['id']	        = "lv2|".$y->id;
                    $data_level2['text']		= Pustaka::capital_string($y->skpd);
                    $data_level2['icon']        = "jstree-people";
                    $data_level2['type']        = "pengawas";
                    $level3 = [] ;

                }else{
                    $data_level2['id']	        = "lv2|".$y->id;
                    $data_level2['type']        = "administrator";
                    $data_level2['text']		= Pustaka::capital_string($y->skpd);
                    $data_level2['icon']        = "jstree-people ";


                    

                    $level3 = SKPD::where('parent_id','=',$y->id)
                                    ->where(function ($query) {
                                        $query->where('id_eselon', '=' , null )
                                            ->orWhere('id_eselon', '<=', 8 );
                                    })
                                    ->select('id','skpd','id_eselon')->get();
                }
               
                    
                
              
                //$level3 = SKPD::where('parent_id','=',$y->id)->select('id','skpd')->get();
                
                foreach ($level3 as $z) {

                        $data_level3['id']	            = "lv3|".$z->id;
                        $data_level3['text']			= Pustaka::capital_string($z->skpd);
                        $data_level3['icon']            = "jstree-people   faa-pulse animated-hover ";
                        $data_level3['type']            = "pengawas";
                      
                        $kegiatan = Kegiatan::WHERE('jabatan_id','=',$z->id)->select('id','label','cost')->get();
    

                    foreach ($kegiatan as $a) {
                        $data_kegiatan['id']	        = "kegiatan|".$a->id;
                        $data_kegiatan['text']			= Pustaka::capital_string($a->label);
                        $data_kegiatan['type']          = "kegiatan";
                        if ( $a->cost > 0 ){
                            $data_kegiatan['icon']      = "jstree-kegiatan";
                        }else{
                            $data_kegiatan['icon']      = "jstree-kegiatan_non_anggaran";
                        }
                        
         
                            $ind_kegiatan = IndikatorKegiatan:: where('kegiatan_id','=',$a->id)->select('id','label')->get();
                            foreach ($ind_kegiatan as $g) {
                                $data_ind_kegiatan['id']	        = "ind_kegiatan|".$g->id;
                                $data_ind_kegiatan['text']			= Pustaka::capital_string($g->label);
                                $data_ind_kegiatan['icon']          = "jstree-ind_kegiatan";
                                $data_ind_kegiatan['type']          = "ind_kegiatan";
                                $ra = RencanaAksi::WHERE('indikator_kegiatan_id',$g->id)->get();
                                        foreach ($ra as $za) {
                                            $data_rencana_aksi['id']	= "rencana_aksi|".$za->id;
                                            $data_rencana_aksi['text']	= Pustaka::capital_string($za->label).' ['. Pustaka::bulan($za->waktu_pelaksanaan).']';
                                            $data_rencana_aksi['icon']  = 'jstree-rencana_aksi';
                                            $data_rencana_aksi['type']  = "rencana_aksi";
 //TARGET PADA KEGIATAN BULANAN
                                        $kb = KegiatanSKPBulanan::WHERE('rencana_aksi_id',$za->id)->get();
                                            foreach ($kb as $az) {
                                                $data_keg_bulanan['id']	    = "kegiatan_bulanan|".$az->id;
                                                $data_keg_bulanan['text']	=  'Target : '. $az->target.' '.$az->satuan.' / Pelaksana : '.Pustaka::capital_string($az->RencanaAksi->pelaksana->jabatan);
                                                $data_keg_bulanan['icon']	= 'jstree-target';
                                                $data_keg_bulanan['type']   = "kegiatan_bulanan";
                                            
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
                        $data_level3['children']     = $kegiatan_list;
                    }
                    $level3_list[] = $data_level3 ;
                    $kegiatan_list = "";
                    unset($data_level3['children']);
                
                }
                if(!empty($level3_list)) {
                    $data_level2['children']     = $level3_list;
                }
                $level2_list[] = $data_level2 ;
                $level3_list = "";
                unset($data_level2['children']);
            
            }
               
            if(!empty($level2_list)) {
                $data_level1['children']     = $level2_list;
            }
            $data[] = $data_level1 ;	
            $level2_list = "";
            unset($data_level1['children']);
		
        }	
           
		return $data;
        
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
                    
                    
                            if(!empty($kegiatan_list)) {
                                return  $kegiatan_list;
                            }else{
                                return "[{}]";
                            } 
    } 
    public function SKPTahunanKegiatanTree3(Request $request)
    {
       
        //Kegiatan nya KSUBID
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
        
            
		foreach ($kegiatan as $x) {
            if ( $x->kegiatan_tahunan_id >= 1 ){
                $kegiatan_id                    = "KegiatanTahunan|".$x->kegiatan_tahunan_id;
                $kegiatan_label                 = $x->kegiatan_tahunan_label;
                $data_kegiatan['icon']	        = 'jstree-kegiatan_tahunan';
            }else{
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
        if(!empty($kegiatan_list)) {
            return  $kegiatan_list;
        }else{
            return "[{}]";
        } 
        
    }
   
    public function SKPTahunanKegiatanTree4(Request $request)
    {
       
       
        $rencana_aksi = RencanaAksi::WHERE('jabatan_id',$request->jabatan_id)
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
        $dt = Kegiatan::where('indikator_program_id', '=' ,$request->get('ind_program_id'))
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
        $jm_data = Kegiatan::where('indikator_program_id', '=' ,$request->get('ind_program_id'))
                ->WHERE('renja_id',$request->get('renja_id'))
                ->WHERE('cost','>', 0 )
                ->count();
        $dt = Kegiatan::where('indikator_program_id', '=' ,$request->get('ind_program_id'))
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
        if (is_null($sr)) {
            return $this->sendError('Kegiatan Tidak ditemukan.');
        }
        $sr->jabatan_id     = 0;
        if ( $sr->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }
    public function Store(Request $request)
    {
        $messages = [
                'ind_program_id.required'       => 'Harus diisi',
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
                            'ind_program_id'        => 'required',
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
        $sr->indikator_program_id       = Input::get('ind_program_id');
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