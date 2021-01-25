<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SasaranPerjanjianKinerja;
use App\Models\Sasaran;
use App\Models\IndikatorSasaran;
use App\Models\PerjanjianKinerja;

use App\Models\RencanaAksi;
use App\Models\IndikatorProgram;
use App\Models\Kegiatan;
use App\Models\IndikatorKegiatan;
use App\Models\Jabatan;
use App\Models\SKPD;
use App\Models\SKPTahunan;

use App\Models\SubKegiatan;
use App\Models\IndikatorSubKegiatan;

use App\Models\KegiatanSKPTahunan;
use App\Models\IndikatorKegiatanSKPTahunan;

use App\Helpers\Pustaka;
use App\Traits\TraitSKPTahunan;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class KegiatanSKPTahunanAPIController extends Controller {

    use TraitSKPTahunan;

    public function SubKegiatanKasubid(Request $request)
    {
        $skp = SKPTahunan::WHERE('id',$request->skp_tahunan_id)->first();
        $skp_tahunan_id = $skp->id;
        $renja_id   = $skp->Renja->id;    
        $jabatan_id = $skp->PegawaiYangDinilai->id_jabatan;

      
        $dt = SubKegiatan::WHERE('renja_id', '=' ,$renja_id )
                        ->WHERE('jabatan_id',$jabatan_id )
                        ->get();
        $datatables = Datatables::of($dt)
                                    ->addColumn('subkegiatan_id', function ($x) {
                                        return $x->id;
                                    })
                                    ->addColumn('label_subkegiatan', function ($x) {
                                        return $x->label;
                                    })
                                    ->addColumn('cost_subkegiatan', function ($x) {
                                        return "Rp.  " .number_format($x->cost,'0',',','.') ;
                                    })
                                    ->addColumn('kegiatan_skp_tahunan_id', function ($x) use($skp_tahunan_id) {
                                        return $x->KegiatanSKPTahunan->WHERE('skp_tahunan_id',$skp_tahunan_id)->count();
                                    })
                                    ->addColumn('action', function ($x) {
                                        return $x->id;
                                    });
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 
        return $datatables->make(true);
        
    }

    
    public function AddSubKegiatanToKegiatan(Request $request){


        $subkegiatan_list   = $request->cb_pilih;
        $skp_tahunan_id     = $request->skp_tahunan_id;
        
        $subkegiatan = SubKegiatan::whereIn('id',$subkegiatan_list)->get();

        //loop sub kegiatan 
        foreach ($subkegiatan as $x) {
            //cek apakah ada kegiatan yang subkeg_id dan skptahunanid nya sama, jika ada restore kegiatan

            $dt_cek = KegiatanSKPTahunan::WHERE('subkegiatan_id',$x->id)->WHERE('skp_tahunan_id',$skp_tahunan_id)->withTrashed()->first();
            if (  $dt_cek != null  ){
                KegiatanSKPTahunan::WHERE('id',$dt_cek->id)->restore();
                foreach ($dt_cek->IndikatorKegiatanSKPTahunan()->withTrashed()->get() as $indikator) {
                    $indikator->restore();
                } 


            }else{
                //insert to kegiatan skp tahunan
                $s_kt    = new KegiatanSKPTahunan;

                $s_kt->subkegiatan_id       = $x->id;
                $s_kt->skp_tahunan_id       = $skp_tahunan_id;
                $s_kt->label                = $x->label;
                $s_kt->target_waktu         = 12 ;
                $s_kt->cost                 = $x->cost;

                if ( $s_kt->save() ){
                    foreach ( IndikatorSubKegiatan::WHERE('subkegiatan_id','=',$x->id)->get() AS $indikator ) {
                        //insert infdikator tio indikator kegiatan tyaunan
                        $s_ind = new IndikatorKegiatanSKPTahunan;
                        $s_ind->kegiatan_id    = $s_kt->id;
                        $s_ind->label          = $indikator->label;
                        $s_ind->target         = $indikator->target;
                        $s_ind->satuan         = $indikator->satuan ;

                        $s_ind->save();
                    }
                }

            }


            
        }
    }




    public function KegiatanTugasJabatanList(Request $request)
    {
            
       
        $dt = KegiatanSKPTahunan::WHERE('skp_tahunan_id','=', $request->skp_tahunan_id )

                ->select([   
                    'id AS kegiatan_tugas_jabatan_id',
                    'label',
                    'target',
                    'satuan',
                    'angka_kredit',
                    'quality',
                    'cost',
                    'target_waktu'
                    
                    ])
                ->get();

                
                
        $datatables = Datatables::of($dt)
        ->addColumn('label', function ($x) {
            return $x->label;
        })->addColumn('ak', function ($x) {
            return $x->angka_kredit;
        })->addColumn('output', function ($x) {
            return $x->target.' '.$x->satuan;
        })->addColumn('mutu', function ($x) {
            return $x->quality .' %';
        })->addColumn('waktu', function ($x) {
            return $x->target_waktu . ' bln';
        })->addColumn('biaya', function ($x) {
            return number_format($x->cost,'0',',','.');
        });

        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true); 
        
    }
    public function KegiatanTahunanSekda(Request $request)
    {
             
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

        //return $child;

        //KEGIATAN KABAN

        $kegiatan = Kegiatan::SELECT('id','label')
                            ->WHERE('renja_kegiatan.renja_id', $request->renja_id )
                            ->WHEREIN('renja_kegiatan.jabatan_id',$child )
                            ->leftjoin('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join){
                                $join   ->on('kegiatan_tahunan.subkegiatan_id','=','renja_kegiatan.id');
                                
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

                
                
        $datatables = Datatables::of($kegiatan)
            ->addColumn('label', function ($x) {
                return $x->kegiatan_tahunan_label;
            })->addColumn('ak', function ($x) {
                return $x->ak;
            })->addColumn('renja_output', function ($x) {
                return $x->renja_target.' '.$x->renja_satuan;
            })->addColumn('output', function ($x) {
                return $x->target.' '.$x->satuan;
            })->addColumn('mutu', function ($x) {
                return $x->quality;
            })->addColumn('waktu', function ($x) {
                return $x->target_waktu;
            })->addColumn('renja_biaya', function ($x) {
                return number_format($x->renja_biaya,'0',',','.');
            })->addColumn('biaya', function ($x) {
                return number_format($x->cost,'0',',','.');
            });

        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true);  
        
    }

    public function KegiatanTahunan1(Request $request)
    {
             
        $child = Jabatan::
                            
                            leftjoin('demo_asn.m_skpd AS kasubid', function($join){
                                $join   ->on('kasubid.parent_id','=','m_skpd.id');
                            })
                            ->SELECT('kasubid.id')
                            ->WHERE('m_skpd.parent_id', $request->jabatan_id )
                            ->get()
                            ->toArray(); 

        //return $child;

        //KEGIATAN KABAN

        $kegiatan = Kegiatan::SELECT('id','label')
                            ->WHERE('renja_kegiatan.renja_id', $request->renja_id )
                            ->WHEREIN('renja_kegiatan.jabatan_id',$child )
                            ->leftjoin('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join){
                                $join   ->on('kegiatan_tahunan.subkegiatan_id','=','renja_kegiatan.id');
                                
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

                
                
        $datatables = Datatables::of($kegiatan)
            ->addColumn('label', function ($x) {
                return $x->kegiatan_tahunan_label;
            })->addColumn('ak', function ($x) {
                return $x->ak;
            })->addColumn('renja_output', function ($x) {
                return $x->renja_target.' '.$x->renja_satuan;
            })->addColumn('output', function ($x) {
                return $x->target.' '.$x->satuan;
            })->addColumn('mutu', function ($x) {
                return $x->quality;
            })->addColumn('waktu', function ($x) {
                return $x->target_waktu;
            })->addColumn('renja_biaya', function ($x) {
                return number_format($x->renja_biaya,'0',',','.');
            })->addColumn('biaya', function ($x) {
                return number_format($x->cost,'0',',','.');
            });

        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true);  
        
    }

    public function KegiatanSKPTahunan2(Request $request)
    {
            
        $kegiatan = $this->Kegiatan($request->skp_tahunan_id);

        $datatables = Datatables::of(collect($kegiatan));
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }      
        return $datatables->make(true);
        
    }


    public function KegiatanSKPTahunan3(Request $request) //sudah update
    {

        $kegiatan = $this->Kegiatan($request->skp_tahunan_id);

        $datatables = Datatables::of(collect($kegiatan));
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }      
        return $datatables->make(true); 

    }

    public function KegiatanSKPTahunanTree3(Request $request)
    {
       
        //klasifikasi get data menurut root node nya,.. 
        if ( $request->id == "#"){
            $data = 'kegiatan_skp_tahunan';
        }else{
            $data = $request->data;
        }
        $state = array( "opened" => true, "selected" => false );
        
        switch ($data) {
            case 'kegiatan_skp_tahunan':
                $skp_tahunan_id = $request->skp_tahunan_id;
                $kegiatan = KegiatanSKPTahunan::
                                                SELECT(     'skp_tahunan_kegiatan.id AS kegiatan_tahunan_id',
                                                            'skp_tahunan_kegiatan.label AS kegiatan_tahunan_label'
                                                        ) 
                                                ->WHERE('skp_tahunan_kegiatan.skp_tahunan_id',$skp_tahunan_id)
                                                ->get(); 
                

                foreach ($kegiatan as $x) {
                   
                        $data_kegiatan['id']        = $x->kegiatan_tahunan_id;
                        $data_kegiatan['data']	    = "kegiatan_skp_tahunan";
                        $data_kegiatan['text']      = Pustaka::capital_string($x->kegiatan_tahunan_label);
                        $data_kegiatan['icon']	    = 'jstree-kegiatan_skp_tahunan';
                        $data_kegiatan['type']      = "kegiatan_skp_tahunan";
                        $data_kegiatan['state']     = $state;
                        
                        $ik = IndikatorKegiatanSKPTahunan::WHERE('kegiatan_id',$x->kegiatan_tahunan_id)->get();
                        foreach ($ik as $y) {
                            $data_ind_kegiatan['id']	        = $y->id;
                            $data_ind_kegiatan['data']	        = "ind_kegiatan_skp_tahunan";
                            $data_ind_kegiatan['text']			= Pustaka::capital_string($y->label);
                            $data_ind_kegiatan['icon']	        = 'jstree-ind_kegiatan_skp_tahunan';
                            $data_ind_kegiatan['type']          = "ind_kegiatan_skp_tahunan";
                            $data_ind_kegiatan['children']      = true ;
                            


                            $ind_subkegiatan_list[] = $data_ind_kegiatan;
                        }

                        if(!empty($ind_subkegiatan_list)) { 
                            $data_kegiatan['children']       = $ind_subkegiatan_list;
                        }
                        $kegiatan_list[] = $data_kegiatan ;	
                        $ind_subkegiatan_list = "";
                        unset($data_kegiatan['children']);
                }
                    
                if(!empty($kegiatan_list)) { 
                    return $kegiatan_list;
                }else{
                    return "[{}]";
                }
                                       
            break;
            case 'ind_kegiatan_skp_tahunan':

               
                $keg_skp = KegiatanSKPTahunan::SELECT('id')->WHERE('skp_tahunan_id', $request->skp_tahunan_id )->get()->toArray(); 
                $ra = RencanaAksi::WHERE('skp_tahunan_rencana_aksi.indikator_kegiatan_tahunan_id',$request->id)
                                    ->WHEREIN('skp_tahunan_rencana_aksi.kegiatan_tahunan_id',$keg_skp)
                                    ->orderBy('skp_tahunan_rencana_aksi.waktu_pelaksanaan','ASC')
                                    ->orderBy('skp_tahunan_rencana_aksi.id','DESC')
                                    ->get();
                    
                foreach ($ra as $z) {
                    $data_rencana_aksi['id']	        = $z->id;
                    $data_rencana_aksi['data']	        = "rencana_aksi";
                    $data_rencana_aksi['text']			= Pustaka::capital_string($z->label).' ['. Pustaka::bulan($z->waktu_pelaksanaan).']';
                    $data_rencana_aksi['icon']	        = 'jstree-rencana_aksi';
                    $data_rencana_aksi['type']          = "rencana_aksi";
                    //$data_rencana_aksi['children']      = true ;
                    //$data_rencana_aksi['state']         = $state;
                    $kb = KegiatanSKPBulanan::
                            leftjoin('db_pare_2018.skp_tahunan_rencana_aksi AS rencana_aksi', function($join){
                                            $join   ->on('rencana_aksi.id','=','skp_bulanan_kegiatan.rencana_aksi_id');
                                        })
                                        ->leftjoin('demo_asn.m_skpd AS skpd', function($join){
                                            $join   ->on('skpd.id','=','rencana_aksi.jabatan_id');
                                        })
                                        ->SELECT(   'skp_bulanan_kegiatan.id AS kegiatan_id',
                                                    'skp_bulanan_kegiatan.target AS target',
                                                    'skp_bulanan_kegiatan.satuan AS satuan',
                                                    'skpd.skpd AS pelaksana'

                                                    )
                                        ->WHERE('rencana_aksi_id',$z->id)->get();
               

                    foreach ($kb as $a) {
                            $pelaksana  = ( $a->pelaksana != "" ) ? Pustaka::capital_string($a->pelaksana) : '-'; 

                            $data_keg_bulanan['id']	        = $a->id;
                            $data_keg_bulanan['data']	    = "kegiatan_bulanan";
                            $data_keg_bulanan['text']		=  'Target : '. $a->target.' '.$a->satuan.' / Pelaksana : '.$pelaksana;
                            $data_keg_bulanan['icon']	    = 'jstree-target';
                            $data_keg_bulanan['type']       = "kegiatan_bulanan";
                            
                
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
                    return $rencana_aksi_list;
                }else{
                    return "[{}]";
                }


            break;
            case 'rencana_aksi':
                
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

    public function KegiatanTahunan4(Request $request)
    {
             
        //KEGIATAN pelaksana
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
                            //->orderBY('skp_tahunan_rencana_aksi.label')
                            ->distinct()
                            ->get(); 
             
                
        $datatables = Datatables::of($rencana_aksi)
        ->addColumn('label', function ($x) {
            return $x->kegiatan_tahunan_label;
        })->addColumn('ak', function ($x) {
            return $x->ak;
        })->addColumn('renja_output', function ($x) {
            return $x->renja_target.' '.$x->renja_satuan;
        })->addColumn('output', function ($x) {
            return $x->target.' '.$x->satuan;
        })->addColumn('mutu', function ($x) {
            return $x->quality." %";
        })->addColumn('waktu', function ($x) {
            return $x->target_waktu." bln";
        })->addColumn('renja_biaya', function ($x) {
            return "Rp. ".number_format($x->renja_biaya,'0',',','.');
        })->addColumn('biaya', function ($x) {
            return "Rp. ".number_format($x->cost,'0',',','.');
        });

        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true); 
        
    }

   

    public function KegiatanSKPTahunanDetail(Request $request)
    {
       
        
        $x = KegiatanSKPTahunan::
                            SELECT(     'skp_tahunan_kegiatan.id AS kegiatan_skp_tahunan_id',
                                        'skp_tahunan_kegiatan.label',
                                        'skp_tahunan_kegiatan.target',
                                        'skp_tahunan_kegiatan.satuan',
                                        'skp_tahunan_kegiatan.angka_kredit',
                                        'skp_tahunan_kegiatan.quality',
                                        'skp_tahunan_kegiatan.cost',
                                        'skp_tahunan_kegiatan.target_waktu',
                                        'skp_tahunan_kegiatan.subkegiatan_id'

                                    ) 
                            ->WHERE('skp_tahunan_kegiatan.id', $request->kegiatan_skp_tahunan_id)
                            ->first();
        //list indikator
        $list = IndikatorKegiatanSKPTahunan::SELECT('id','label','target','satuan')
                                    ->WHERE('kegiatan_id','=',$x->kegiatan_skp_tahunan_id)
                                    ->get()
                                    ->toArray();
        
		
		//return  $kegiatan_tahunan;
        $kegiatan_skp_tahunan = array(
            'id'                    => $x->kegiatan_skp_tahunan_id,
            'label'                 => $x->label,
            'ak'                    => $x->angka_kredit,
            'output'                => $x->target.' '.$x->satuan,
            'satuan'                => $x->satuan,
            'target'                => $x->target,
            'quality'               => $x->quality,
            'target_waktu'          => $x->target_waktu,
            'cost'	                => number_format($x->cost,'0',',','.'),
            'pejabat'               => Pustaka::capital_string($x->SubKegiatan->PenanggungJawab->jabatan),
            'list_indikator'        => $list,
        );
        return $kegiatan_skp_tahunan;
    }
    



    public function Store(Request $request)
    {

        $messages = [
                'kegiatan_id.required'           => 'Harus diisi',
                'skp_tahunan_id.required'        => 'Harus diisi',
                'label.required'                 => 'Harus diisi',
                //'target.required'                => 'Harus diisi',
                //'satuan.required'                => 'Harus diisi',
                'quality.required'               => 'Harus diisi',
                'target_waktu.required'          => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'kegiatan_id'       => 'required',
                            'skp_tahunan_id'    => 'required',
                            'label'             => 'required',
                            //'target'            => 'required|numeric',
                            //'satuan'            => 'required',
                            'quality'           => 'required|numeric|min:1|max:100',
                            'target_waktu'      => 'required|numeric|min:1|max:12',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $st_kt    = new KegiatanSKPTahunan;

        $st_kt->kegiatan_id             = Input::get('kegiatan_id');
        $st_kt->skp_tahunan_id          = Input::get('skp_tahunan_id');
        $st_kt->label                   = Input::get('label');
        $st_kt->target                  = Input::get('target');
        $st_kt->satuan                  = Input::get('satuan');
        $st_kt->angka_kredit            = Input::get('angka_kredit');
        $st_kt->quality                 = Input::get('quality');
        $st_kt->cost                    = preg_replace('/[^0-9]/', '', Input::get('cost'));
        $st_kt->target_waktu            = Input::get('target_waktu');

        if ( $st_kt->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }


    public function Update(Request $request)
    {

        $messages = [
                'kegiatan_tahunan_id.required'   => 'Harus diisi',
                'label.required'                 => 'Harus diisi',
                //'target.required'              => 'Harus diisi',
                //'satuan.required'                => 'Harus diisi',
                'quality.required'               => 'Harus diisi',
                'target_waktu.required'          => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'kegiatan_tahunan_id'   => 'required',
                            'label'                 => 'required',
                            //'target'                => 'required|numeric',
                            //'satuan'                => 'required',
                            'quality'               => 'required|numeric|min:1|max:100',
                            'target_waktu'          => 'required|numeric|min:1|max:12',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $st_kt    = KegiatanSKPTahunan::find(Input::get('kegiatan_tahunan_id'));
        if (is_null($st_kt)) {
            return $this->sendError('Kegiatan Tahunan tidak ditemukan.');
        }


        $st_kt->label             = Input::get('label');
        $st_kt->target            = preg_replace('/[^0-9]/', '', Input::get('target'));
        $st_kt->satuan            = Input::get('satuan');
        $st_kt->angka_kredit      = Input::get('angka_kredit');
        $st_kt->quality           = preg_replace('/[^0-9]/', '', Input::get('quality'));
        $st_kt->cost              = preg_replace('/[^0-9]/', '', Input::get('cost'));
        $st_kt->target_waktu      = preg_replace('/[^0-9]/', '', Input::get('target_waktu'));

        if ( $st_kt->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            

    
    }


    public function Hapus(Request $request)
    {

        $messages = [
                'id.required'   => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'id'   => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $st_kt    = KegiatanSKPTahunan::find(Input::get('id'));
        if (is_null($st_kt)) {
            return $this->sendError('Kegiatan Tahunan tidak ditemukan.');
        }


        if ( $st_kt->delete()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }


}
