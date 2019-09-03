<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SasaranPerjanjianKinerja;
use App\Models\Sasaran;
use App\Models\IndikatorSasaran;
use App\Models\PerjanjianKinerja;
use App\Models\KegiatanSKPTahunan;
use App\Models\RencanaAksi;
use App\Models\IndikatorProgram;
use App\Models\Kegiatan;
use App\Models\IndikatorKegiatan;
use App\Models\Jabatan;
use App\Models\SKPD;
use App\Models\SKPTahunan;

use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class KegiatanSKPTahunanAPIController extends Controller {


    




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
                                $join   ->on('kegiatan_tahunan.kegiatan_id','=','renja_kegiatan.id');
                                
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

    public function KegiatanTahunan2(Request $request)
    {
             
        $child = Jabatan::SELECT('id')->WHERE('parent_id', $request->jabatan_id )->get()->toArray(); 


       //KEGIATAN KABID
        $skp_tahunan_id = $request->skp_tahunan_id;
        $kegiatan = Kegiatan::SELECT('id','label')
                            ->WHERE('renja_kegiatan.renja_id', $request->renja_id )
                            ->WHEREIN('renja_kegiatan.jabatan_id',$child )
                            ->leftjoin('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join) use ( $skp_tahunan_id ){
                                $join   ->on('kegiatan_tahunan.kegiatan_id','=','renja_kegiatan.id');
                                
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
                                        'kegiatan_tahunan.target_waktu'
                                    ) 
                            ->get();

                
                
        $datatables = Datatables::of($kegiatan)
        ->addColumn('label', function ($x) {
            return $x->kegiatan_tahunan_label;
        })->addColumn('ak', function ($x) {
            return $x->ak;
        })->addColumn('output', function ($x) {
            return $x->target.' '.$x->satuan;
        })->addColumn('mutu', function ($x) {
            return $x->quality;
        })->addColumn('waktu', function ($x) {
            return $x->target_waktu;
        })->addColumn('biaya', function ($x) {
            return number_format($x->cost,'0',',','.');
        });

        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true); 
        
    }


    public function KegiatanTahunan3(Request $request)
    {
             
       
        /* 
        $kegiatan = IndikatorKegiatan::SELECT('id','label')
                            //RIGHT ke Kegiatan
                            ->join('db_pare_2018.renja_kegiatan AS renja_kegiatan', function($join) use ( $renja_id,$jabatan_id ){
                                $join   ->on('renja_indikator_kegiatan.kegiatan_id','=','renja_kegiatan.id');
                                $join   ->WHERE('renja_kegiatan.renja_id','=', $renja_id );
                                $join   ->WHERE('renja_kegiatan.jabatan_id', '=' ,$jabatan_id );
                            })
                            
                            //LEFT ke kegiatan tahunan
                            ->leftjoin('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join) use ( $skp_tahunan_id ){
                                $join   ->on('kegiatan_tahunan.indikator_kegiatan_id','=','renja_indikator_kegiatan.id');
                                $join   ->WHERE('kegiatan_tahunan.skp_tahunan_id','=', $skp_tahunan_id );
                            })
                            ->SELECT(   'renja_indikator_kegiatan.id AS ind_kegiatan_id',
                                        'renja_indikator_kegiatan.label AS ind_kegiatan_label',
                                        'renja_indikator_kegiatan.target AS renja_target',
                                        'renja_indikator_kegiatan.satuan AS renja_satuan',

                                        'renja_kegiatan.cost AS renja_biaya',

                                        'kegiatan_tahunan.label AS kegiatan_tahunan_label',
                                        'kegiatan_tahunan.id AS kegiatan_tahunan_id',
                                        'kegiatan_tahunan.target',
                                        'kegiatan_tahunan.satuan',
                                        'kegiatan_tahunan.angka_kredit',
                                        'kegiatan_tahunan.quality',
                                        'kegiatan_tahunan.cost',
                                        'kegiatan_tahunan.target_waktu'

                                       

                                        
                                        
                                    ) 
                            ->get(); */
        //KEGIATAN KASUBID
        $renja_id       = $request->renja_id;
        $jabatan_id     = $request->jabatan_id;
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

    public function KegiatanTahunan4(Request $request)
    {
             
       //KEGIATAN pelaksana

        $rencana_aksi = RencanaAksi::WHERE('jabatan_id',$request->jabatan_id)
                            ->leftjoin('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join){
                                $join  ->on('skp_tahunan_rencana_aksi.kegiatan_tahunan_id','=','kegiatan_tahunan.id');
                            })
                            
                            ->orderBY('skp_tahunan_rencana_aksi.label')
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

   

    public function KegiatanTahunanDetail(Request $request)
    {
       
        
        $x = KegiatanSKPtahunan::
                            SELECT(     'skp_tahunan_kegiatan.id AS kegiatan_tahunan_id',
                                        'skp_tahunan_kegiatan.label',
                                        'skp_tahunan_kegiatan.target',
                                        'skp_tahunan_kegiatan.satuan',
                                        'skp_tahunan_kegiatan.angka_kredit',
                                        'skp_tahunan_kegiatan.quality',
                                        'skp_tahunan_kegiatan.cost',
                                        'skp_tahunan_kegiatan.target_waktu',
                                        'skp_tahunan_kegiatan.kegiatan_id'

                                    ) 
                            ->WHERE('skp_tahunan_kegiatan.id', $request->kegiatan_tahunan_id)
                            ->first();
        //list indikator
        $list = IndikatorKegiatan::SELECT('id','label','target','satuan')
                                    ->WHERE('kegiatan_id','=',$x->kegiatan_id)
                                    ->get()
                                    ->toArray();
        
		
		//return  $kegiatan_tahunan;
        $kegiatan_tahunan = array(
            'id'            => $x->kegiatan_tahunan_id,
            'label'         => $x->label,
            'ak'            => $x->angka_kredit,
            'output'        => $x->target.' '.$x->satuan,
            'satuan'        => $x->satuan,
            'target'      => $x->target,
            'quality'       => $x->quality,
            'target_waktu'  => $x->target_waktu,
            'cost'	        => number_format($x->cost,'0',',','.'),
            'pejabat'       => Pustaka::capital_string($x->Kegiatan->PenanggungJawab->jabatan),
            'list_indikator'=> $list,
        );
        return $kegiatan_tahunan;
    }
    



    public function Store(Request $request)
    {

        $messages = [
                'kegiatan_id.required'           => 'Harus diisi',
                'skp_tahunan_id.required'        => 'Harus diisi',
                'label.required'                 => 'Harus diisi',
                'target.required'                => 'Harus diisi',
                'satuan.required'                => 'Harus diisi',
                'quality.required'               => 'Harus diisi',
                'target_waktu.required'          => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'kegiatan_id'       => 'required',
                            'skp_tahunan_id'    => 'required',
                            'label'             => 'required',
                            'target'            => 'required|numeric',
                            'satuan'            => 'required',
                            'quality'           => 'required|numeric|min:1|max:100',
                            'target_waktu'      => 'required|numeric|min:1|max:12',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $st_kt    = new KegiatanSKPtahunan;

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
                'target.required'              => 'Harus diisi',
                'satuan.required'                => 'Harus diisi',
                'quality.required'               => 'Harus diisi',
                'target_waktu.required'          => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'kegiatan_tahunan_id'   => 'required',
                            'label'                 => 'required',
                            'target'                => 'required|numeric',
                            'satuan'                => 'required',
                            'quality'               => 'required|numeric|min:1|max:100',
                            'target_waktu'          => 'required|numeric|min:1|max:12',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $st_kt    = KegiatanSKPtahunan::find(Input::get('kegiatan_tahunan_id'));
        if (is_null($st_kt)) {
            return $this->sendError('Kegiatan Tahunan tidak ditemukan.');
        }


        $st_kt->label             = Input::get('label');
        $st_kt->target          = preg_replace('/[^0-9]/', '', Input::get('target'));
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
                'kegiatan_tahunan_id.required'   => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'kegiatan_tahunan_id'   => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $st_kt    = KegiatanSKPtahunan::find(Input::get('kegiatan_tahunan_id'));
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
