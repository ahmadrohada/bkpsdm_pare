<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;

use App\Models\RealisasiKegiatanTriwulan;
use App\Models\RealisasiIndikatorKegiatanTriwulan;
use App\Models\IndikatorKegiatan;
use App\Models\Kegiatan;
use App\Models\Jabatan;

use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Input;

class RealisasiKegiatanTriwulanAPIController extends Controller {

    protected function kegiatan_triwulan_eselon3($renja_id,$jabatan_id,$capaian_id,$search){
 

        //ESELON 3
        $bawahan = Jabatan::SELECT('id')->WHERE('parent_id', $jabatan_id )->get()->toArray();
    
        \DB::statement(\DB::raw('set @rownum=0'));
        $kegiatan = Kegiatan::WHERE('renja_kegiatan.renja_id', $renja_id )
                                ->WHEREIN('renja_kegiatan.jabatan_id', $bawahan  )
                                //LEFT JOIN ke Kegiatan SKP TAHUNAN
                                ->JOIN('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join){
                                    $join   ->on('kegiatan_tahunan.kegiatan_id','=','renja_kegiatan.id');
                                    
                                })
                                //LEFT JOIN ke INDIKATOR KEGIATAN
                                ->leftjoin('db_pare_2018.renja_indikator_kegiatan AS renja_indikator_kegiatan', function($join){
                                    $join   ->on('renja_indikator_kegiatan.kegiatan_id','=','renja_kegiatan.id');
                                    
                                })
                                 //LEFT JOIN TERHADAP REALISASI INDIKATOR KEGIATAN
                                 ->leftjoin('db_pare_2018.realisasi_indikator_kegiatan_triwulan AS realisasi_indikator', function($join) use ( $capaian_id ){
                                    $join   ->on('realisasi_indikator.indikator_kegiatan_id','=','renja_indikator_kegiatan.id');
                                    $join   ->WHERE('realisasi_indikator.capaian_id','=',  $capaian_id );
                                    
                                })
                                //LEFT JOIN TERHADAP REALISASI TAHUNAN tahunan
                                ->leftjoin('db_pare_2018.realisasi_kegiatan_triwulan AS realisasi_kegiatan', function($join) use ( $capaian_id ){
                                    $join   ->on('realisasi_kegiatan.kegiatan_tahunan_id','=','kegiatan_tahunan.id');
                                    $join   ->WHERE('realisasi_kegiatan.capaian_id','=',  $capaian_id );
                                    
                                })
                                //LEFT JOIN KE CAPAIAN TAHUNAN
                                ->leftjoin('db_pare_2018.capaian_triwulan AS capaian_triwulan', function($join){
                                    $join   ->on('capaian_triwulan.id','=','realisasi_kegiatan.capaian_id');
                                })
    
                                ->SELECT(   \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                                            'renja_kegiatan.id AS kegiatan_id',
                                            'renja_kegiatan.id AS no',
                                            'renja_kegiatan.jabatan_id',
                                            'renja_kegiatan.label AS kegiatan_label',
    
    
                                            'renja_indikator_kegiatan.id AS indikator_kegiatan_id',
                                            'renja_indikator_kegiatan.label AS indikator_label',
                                            'renja_indikator_kegiatan.target AS indikator_quantity',
                                            'renja_indikator_kegiatan.satuan AS indikator_satuan',
    
    
                                            'kegiatan_tahunan.id AS kegiatan_tahunan_id',
                                            'kegiatan_tahunan.label AS kegiatan_tahunan_label',
                                            'kegiatan_tahunan.quality AS kegiatan_tahunan_quality',
                                            'kegiatan_tahunan.cost AS kegiatan_tahunan_cost',
                                            'kegiatan_tahunan.target_waktu AS kegiatan_tahunan_target_waktu',
                                            'kegiatan_tahunan.angka_kredit AS kegiatan_tahunan_ak',
    
                                            'realisasi_indikator.id AS realisasi_indikator_id',
                                            'realisasi_indikator.target_quantity AS realisasi_indikator_target_quantity',
                                            'realisasi_indikator.realisasi_quantity AS realisasi_indikator_realisasi_quantity',
                                            'realisasi_indikator.satuan AS realisasi_indikator_satuan',
    
    
                                            'realisasi_kegiatan.id AS realisasi_kegiatan_id',
                                            'realisasi_kegiatan.target_cost AS realisasi_kegiatan_target_cost',
                                            'realisasi_kegiatan.realisasi_cost AS realisasi_kegiatan_realisasi_cost',
    
                                            'capaian_triwulan.status'
                                           
                                        ) 
                                
                                ->get();
                    
            $datatables = Datatables::of($kegiatan)
           
            ->addColumn('id', function ($x) {
                return $x->kegiatan_tahunan_id;
            })->addColumn('capaian_tahunan_id', function ($x) use ($capaian_id) {
                return $capaian_id;
            })->addColumn('target_quantity', function ($x) {
                return ( $x->realisasi_indikator_id ? $x->realisasi_indikator_target_quantity : $x->indikator_quantity )." ".($x->realisasi_indikator_id ? $x->realisasi_indikator_satuan : $x->indikator_satuan);
            })->addColumn('target_quality', function ($x) {
                return ($x->realisasi_kegiatan_id ? $x->realisasi_kegiatan_target_quality : $x->kegiatan_tahunan_quality )." %";
            })->addColumn('target_waktu', function ($x) {
                return  ($x->realisasi_kegiatan_id ? $x->realisasi_kegiatan_realisasi_waktu : $x->kegiatan_tahunan_target_waktu )." bln";
            })->addColumn('target_cost', function ($x) {
                return "Rp. ". ($x->realisasi_kegiatan_id ? number_format($x->realisasi_kegiatan_target_cost,'0',',','.') : number_format($x->kegiatan_tahunan_cost,'0',',','.') );
            })->addColumn('realisasi_quantity', function ($x) {
                return ( $x->realisasi_indikator_id ? $x->realisasi_indikator_realisasi_quantity." ".$x->realisasi_indikator_satuan : "-" );
            })->addColumn('realisasi_quality', function ($x) {
                return ($x->realisasi_kegiatan_id ? $x->realisasi_kegiatan_realisasi_quality." %" : "-" );
            })->addColumn('realisasi_waktu', function ($x) {
                return  ($x->realisasi_kegiatan_id ? $x->realisasi_kegiatan_realisasi_waktu." bln" : "-" );
            })->addColumn('realisasi_cost', function ($x) {
                return ($x->realisasi_kegiatan_id ? "Rp. ". number_format($x->realisasi_kegiatan_realisasi_cost,'0',',','.') : "-" );
            })->addColumn('jumlah', function ($x) {
                return  ($x->hitung_quantity + $x->hitung_quality + $x->hitung_waktu +$x->hitung_cost );
            })->addColumn('capaian_skp', function ($x) {
                if ( $x->hitung_cost <=0 ){
                    return number_format(($x->hitung_quantity + $x->hitung_quality + $x->hitung_waktu +$x->hitung_cost )/3 ,2) ;
                }else{
                    return number_format(($x->hitung_quantity + $x->hitung_quality + $x->hitung_waktu +$x->hitung_cost )/4 ,2);
                }
            })->addColumn('hitung_quantity', function ($x) {
                return Pustaka::persen_bulat($x->hitung_quantity);
            })->addColumn('hitung_quality', function ($x) {
                return Pustaka::persen_bulat($x->hitung_quality);
            })->addColumn('hitung_waktu', function ($x) {
                return Pustaka::persen_bulat($x->hitung_waktu);
            })->addColumn('hitung_cost', function ($x) {
                return Pustaka::persen_bulat($x->hitung_cost);
            })->addColumn('realisasi_kegiatan_id', function ($x) {
            
                return $x->realisasi_kegiatan_id;
    
                
            })->addColumn('penilaian', function ($x) {
                if ( ($x->akurasi + $x->ketelitian + $x->kerapihan + $x->keterampilan ) == 0) {
                    return 0;
                }else{
                    return 1;
                }
    
                
            });
    
            if ($keyword = $search ) {
                $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
            } 
    
            return $datatables->make(true); 
    
    
        }

        protected function kegiatan_triwulan_eselon4($renja_id,$jabatan_id,$capaian_id,$search){
 
    
            \DB::statement(\DB::raw('set @rownum=0'));
            $kegiatan = Kegiatan::WHERE('renja_kegiatan.renja_id', $renja_id )
                                    ->WHERE('renja_kegiatan.jabatan_id','=',  $jabatan_id  )
                                    //LEFT JOIN ke Kegiatan SKP TAHUNAN
                                    ->JOIN('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join){
                                        $join   ->on('kegiatan_tahunan.kegiatan_id','=','renja_kegiatan.id');
                                        
                                    })
                                    //LEFT JOIN ke INDIKATOR KEGIATAN
                                    ->leftjoin('db_pare_2018.renja_indikator_kegiatan AS renja_indikator_kegiatan', function($join){
                                        $join   ->on('renja_indikator_kegiatan.kegiatan_id','=','renja_kegiatan.id');
                                        
                                    })
                                     //LEFT JOIN TERHADAP REALISASI INDIKATOR KEGIATAN
                                     ->leftjoin('db_pare_2018.realisasi_indikator_kegiatan_triwulan AS realisasi_indikator', function($join) use ( $capaian_id ){
                                        $join   ->on('realisasi_indikator.indikator_kegiatan_id','=','renja_indikator_kegiatan.id');
                                        $join   ->WHERE('realisasi_indikator.capaian_id','=',  $capaian_id );
                                        
                                    })
                                    //LEFT JOIN TERHADAP REALISASI TAHUNAN tahunan
                                    ->leftjoin('db_pare_2018.realisasi_kegiatan_triwulan AS realisasi_kegiatan', function($join) use ( $capaian_id ){
                                        $join   ->on('realisasi_kegiatan.kegiatan_tahunan_id','=','kegiatan_tahunan.id');
                                        $join   ->WHERE('realisasi_kegiatan.capaian_id','=',  $capaian_id );
                                        
                                    })
                                    //LEFT JOIN KE CAPAIAN TAHUNAN
                                    ->leftjoin('db_pare_2018.capaian_triwulan AS capaian_triwulan', function($join){
                                        $join   ->on('capaian_triwulan.id','=','realisasi_kegiatan.capaian_id');
                                    })
        
                                    ->SELECT(   \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                                                'renja_kegiatan.id AS kegiatan_id',
                                                'renja_kegiatan.id AS no',
                                                'renja_kegiatan.jabatan_id',
                                                'renja_kegiatan.label AS kegiatan_label',
        
        
                                                'renja_indikator_kegiatan.id AS indikator_kegiatan_id',
                                                'renja_indikator_kegiatan.label AS indikator_label',
                                                'renja_indikator_kegiatan.target AS indikator_quantity',
                                                'renja_indikator_kegiatan.satuan AS indikator_satuan',
        
        
                                                'kegiatan_tahunan.id AS kegiatan_tahunan_id',
                                                'kegiatan_tahunan.label AS kegiatan_tahunan_label',
                                                'kegiatan_tahunan.quality AS kegiatan_tahunan_quality',
                                                'kegiatan_tahunan.cost AS kegiatan_tahunan_cost',
                                                'kegiatan_tahunan.target_waktu AS kegiatan_tahunan_target_waktu',
                                                'kegiatan_tahunan.angka_kredit AS kegiatan_tahunan_ak',
        
                                                'realisasi_indikator.id AS realisasi_indikator_id',
                                                'realisasi_indikator.target_quantity AS realisasi_indikator_target_quantity',
                                                'realisasi_indikator.realisasi_quantity AS realisasi_indikator_realisasi_quantity',
                                                'realisasi_indikator.satuan AS realisasi_indikator_satuan',
        
        
                                                'realisasi_kegiatan.id AS realisasi_kegiatan_id',
                                                'realisasi_kegiatan.target_cost AS realisasi_kegiatan_target_cost',
                                                'realisasi_kegiatan.realisasi_cost AS realisasi_kegiatan_realisasi_cost',
        
                                                'capaian_triwulan.status'
                                               
                                            ) 
                                    
                                    ->get();
                        
                $datatables = Datatables::of($kegiatan)
               
                ->addColumn('id', function ($x) {
                    return $x->kegiatan_tahunan_id;
                })->addColumn('capaian_tahunan_id', function ($x) use ($capaian_id) {
                    return $capaian_id;
                })->addColumn('target_quantity', function ($x) {
                    return ( $x->realisasi_indikator_id ? $x->realisasi_indikator_target_quantity : $x->indikator_quantity )." ".($x->realisasi_indikator_id ? $x->realisasi_indikator_satuan : $x->indikator_satuan);
                })->addColumn('target_quality', function ($x) {
                    return ($x->realisasi_kegiatan_id ? $x->realisasi_kegiatan_target_quality : $x->kegiatan_tahunan_quality )." %";
                })->addColumn('target_waktu', function ($x) {
                    return  ($x->realisasi_kegiatan_id ? $x->realisasi_kegiatan_realisasi_waktu : $x->kegiatan_tahunan_target_waktu )." bln";
                })->addColumn('target_cost', function ($x) {
                    return "Rp. ". ($x->realisasi_kegiatan_id ? number_format($x->realisasi_kegiatan_target_cost,'0',',','.') : number_format($x->kegiatan_tahunan_cost,'0',',','.') );
                })->addColumn('realisasi_quantity', function ($x) {
                    return ( $x->realisasi_indikator_id ? $x->realisasi_indikator_realisasi_quantity." ".$x->realisasi_indikator_satuan : "-" );
                })->addColumn('realisasi_quality', function ($x) {
                    return ($x->realisasi_kegiatan_id ? $x->realisasi_kegiatan_realisasi_quality." %" : "-" );
                })->addColumn('realisasi_waktu', function ($x) {
                    return  ($x->realisasi_kegiatan_id ? $x->realisasi_kegiatan_realisasi_waktu." bln" : "-" );
                })->addColumn('realisasi_cost', function ($x) {
                    return ($x->realisasi_kegiatan_id ? "Rp. ". number_format($x->realisasi_kegiatan_realisasi_cost,'0',',','.') : "-" );
                })->addColumn('jumlah', function ($x) {
                    return  ($x->hitung_quantity + $x->hitung_quality + $x->hitung_waktu +$x->hitung_cost );
                })->addColumn('capaian_skp', function ($x) {
                    if ( $x->hitung_cost <=0 ){
                        return number_format(($x->hitung_quantity + $x->hitung_quality + $x->hitung_waktu +$x->hitung_cost )/3 ,2) ;
                    }else{
                        return number_format(($x->hitung_quantity + $x->hitung_quality + $x->hitung_waktu +$x->hitung_cost )/4 ,2);
                    }
                })->addColumn('hitung_quantity', function ($x) {
                    return Pustaka::persen_bulat($x->hitung_quantity);
                })->addColumn('hitung_quality', function ($x) {
                    return Pustaka::persen_bulat($x->hitung_quality);
                })->addColumn('hitung_waktu', function ($x) {
                    return Pustaka::persen_bulat($x->hitung_waktu);
                })->addColumn('hitung_cost', function ($x) {
                    return Pustaka::persen_bulat($x->hitung_cost);
                })->addColumn('realisasi_kegiatan_id', function ($x) {
                
                    return $x->realisasi_kegiatan_id;
        
                    
                })->addColumn('penilaian', function ($x) {
                    if ( ($x->akurasi + $x->ketelitian + $x->kerapihan + $x->keterampilan ) == 0) {
                        return 0;
                    }else{
                        return 1;
                    }
        
                    
                });
        
                if ($keyword = $search ) {
                    $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
                } 
        
                return $datatables->make(true); 
        
        
        }

    public function RealisasiKegiatanTriwulan(Request $request) 
    {
        $jenis_jabatan          = $request->jenis_jabatan;
        $jabatan_id             = $request->jabatan_id;
        $renja_id               = $request->renja_id;
        $capaian_id             = $request->capaian_triwulan_id;
        $search                 = $request->get('search')['value'];
        

        switch($jenis_jabatan)
					{
				case 1 : "";
						break;
				case 2 : return $this->kegiatan_triwulan_eselon3($renja_id,$jabatan_id,$capaian_id,$search);
						break;
				case 3 : return $this->kegiatan_triwulan_eselon4($renja_id,$jabatan_id,$capaian_id,$search);
						break;
				case 4 : "";
						break;
				case 5 : "";
						break;
					}

     
    } 
    
    
    
    public function AddRealisasiKegiatanTriwulan(Request $request)
    {
       
        $capaian_id = $request->capaian_id;
        $indikator_kegiatan_id = $request->indikator_kegiatan_id;

        $x = IndikatorKegiatan::
                            leftjoin('db_pare_2018.renja_kegiatan AS renja_kegiatan', function($join) {
                                $join   ->on('renja_indikator_kegiatan.kegiatan_id','=','renja_kegiatan.id');
                            })
                            ->leftjoin('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join) {
                                $join   ->on('kegiatan_tahunan.kegiatan_id','=','renja_kegiatan.id');
                            })
                            //REALISASINYA
                            ->leftjoin('db_pare_2018.realisasi_indikator_kegiatan_triwulan AS realisasi_indikator', function($join) use($capaian_id) {
                                $join   ->on('realisasi_indikator.indikator_kegiatan_id','=','renja_indikator_kegiatan.id');
                                $join   ->WHERE('realisasi_indikator.capaian_id','=', $capaian_id );
                            })
                            ->leftjoin('db_pare_2018.realisasi_kegiatan_triwulan AS realisasi_kegiatan', function($join) use($capaian_id) {
                                $join   ->on('realisasi_kegiatan.kegiatan_tahunan_id','=','kegiatan_tahunan.id');
                                $join   ->WHERE('realisasi_kegiatan.capaian_id','=', $capaian_id );
                            })
                
                            ->SELECT(       'renja_kegiatan.id AS kegiatan_id',


                                            'renja_indikator_kegiatan.id AS ind_kegiatan_id',
                                            'renja_indikator_kegiatan.label AS indikator_label',
                                            'renja_indikator_kegiatan.target AS indikator_quantity',
                                            'renja_indikator_kegiatan.satuan AS indikator_satuan',

                                            'kegiatan_tahunan.id AS kegiatan_tahunan_id',
                                            'kegiatan_tahunan.label AS kegiatan_tahunan_label',
                                            'kegiatan_tahunan.quality AS kegiatan_tahunan_quality',
                                            'kegiatan_tahunan.cost AS kegiatan_tahunan_cost',
                                            'kegiatan_tahunan.target_waktu AS kegiatan_tahunan_target_waktu',
                                            'kegiatan_tahunan.angka_kredit AS kegiatan_tahunan_ak',

                                            'realisasi_indikator.id AS realisasi_indikator_id',
                                            'realisasi_indikator.target_quantity AS realisasi_indikator_target_quantity',
                                            'realisasi_indikator.realisasi_quantity AS realisasi_indikator_realisasi_quantity',
                                            'realisasi_indikator.satuan AS realisasi_indikator_satuan',


                                            'realisasi_kegiatan.id AS realisasi_kegiatan_id',
                                            'realisasi_kegiatan.target_cost AS realisasi_kegiatan_target_cost',
                                            'realisasi_kegiatan.realisasi_cost AS realisasi_kegiatan_realisasi_cost'
                                        



                                            
                                    ) 
                            ->WHERE('renja_indikator_kegiatan.id', $indikator_kegiatan_id)
                            ->first();

       
        $jm_indikator = IndikatorKegiatan::WHERE('kegiatan_id',$x->kegiatan_id)->count();


        $ind_kegiatan = array(
            'ind_kegiatan_id'           => $x->ind_kegiatan_id,
            'indikator_label'           => $x->indikator_label,
            'kegiatan_tahunan_id'       => $x->kegiatan_tahunan_id,
            'kegiatan_tahunan_label'    => $x->kegiatan_tahunan_label,

           
			'realisasi_indikator_id'    => $x->realisasi_indikator_id,
			'realisasi_kegiatan_id'     => $x->realisasi_kegiatan_id,

            'jumlah_indikator'          => $jm_indikator,

            

            'target_quantity'           => $x->realisasi_indikator_id ? $x->realisasi_indikator_target_quantity : $x->indikator_quantity,
            'target_cost'               => $x->realisasi_kegiatan_id ? number_format($x->realisasi_kegiatan_target_cost,'0',',','.') : number_format($x->kegiatan_tahunan_cost,'0',',','.'),
            'satuan'                    => $x->realisasi_indikator_id ? $x->realisasi_indikator_satuan : $x->indikator_satuan,

            'realisasi_quantity'        => $x->realisasi_indikator_realisasi_quantity,
            'realisasi_cost'            => number_format($x->realisasi_kegiatan_realisasi_cost,'0',',','.'),



        ); 
        return $ind_kegiatan;
    }

    public function Store(Request $request)
    {

        $messages = [
                'capaian_triwulan_id.required' => 'Harus diisi',
                'kegiatan_tahunan_id.required' => 'Harus diisi',
                'ind_kegiatan_id.required'     => 'Harus diisi',
                'target_quantity.required'     => 'Harus diisi',
                'realisasi_quantity.required'  => 'Harus diisi',
                'satuan.required'              => 'Harus diisi',
                'target_cost.required'         => 'Harus diisi',
                'realisasi_cost.required'      => 'Harus diisi'

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'capaian_triwulan_id'   => 'required',
                            'ind_kegiatan_id'       => 'required',
                            'kegiatan_tahunan_id'   => 'required',
                            'target_quantity'       => 'required',
                            'realisasi_quantity'    => 'required',
                            'satuan'                => 'required',
                            'target_cost'           => 'required',
                            'realisasi_cost'        => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $st_kt    = new RealisasiIndikatorKegiatanTriwulan;

        $st_kt->indikator_kegiatan_id   = Input::get('ind_kegiatan_id');
        $st_kt->capaian_id              = Input::get('capaian_triwulan_id');
        $st_kt->target_quantity         = Input::get('target_quantity');
        $st_kt->realisasi_quantity      = Input::get('realisasi_quantity');
        $st_kt->satuan                  = Input::get('satuan');
       

        if ( $st_kt->save()){

            //CARI REALISASI KEGIATAN NYA
            $rkt    = RealisasiKegiatanTriwulan::WHERE('capaian_id','=',Input::get('capaian_triwulan_id'))
                                                ->WHERE('kegiatan_tahunan_id','=',Input::get('kegiatan_tahunan_id'))
                                                ->count();

            //jikia belum ada add new
            if ( $rkt == 0 ) {
                $rkt_save    = new RealisasiKegiatanTriwulan;
                $rkt_save->capaian_id              = Input::get('capaian_triwulan_id');
                $rkt_save->kegiatan_tahunan_id     = Input::get('kegiatan_tahunan_id');
                $rkt_save->jumlah_indikator        = Input::get('jumlah_indikator');
                $rkt_save->target_cost             = preg_replace('/[^0-9]/', '', Input::get('target_cost'));
                $rkt_save->realisasi_cost          = preg_replace('/[^0-9]/', '', Input::get('realisasi_cost'));
                $rkt_save->save();

            //jika sudah ada update saja
            }else{

                $rkt_update                     = RealisasiKegiatanTriwulan::find(Input::get('realisasi_kegiatan_triwulan_id'));
                $rkt_update->jumlah_indikator   = Input::get('jumlah_indikator');
                $rkt_update->realisasi_cost     = preg_replace('/[^0-9]/', '', Input::get('realisasi_cost'));
                $rkt_update->save();
            }

            return \Response::make('sukses'+$rkt, 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }

   
    
    public function Update(Request $request)
    {

            $messages = [
                'realisasi_indikator_kegiatan_triwulan_id.required'=> 'Harus diisi',
                'capaian_triwulan_id.required'  => 'Harus diisi',
                'kegiatan_tahunan_id.required'  => 'Harus diisi',
                'ind_kegiatan_id.required'      => 'Harus diisi',
                'jumlah_indikator.required'     => 'Harus diisi',

                'target_quantity.required'      => 'Harus diisi',
                'target_cost.required'          => 'Harus diisi',
                'satuan.required'               => 'Harus diisi',

                'realisasi_quantity.required'   => 'Harus diisi',
                'realisasi_cost.required'       => 'Harus diisi',
        

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'realisasi_indikator_kegiatan_triwulan_id' => 'required',
                            'capaian_triwulan_id'   => 'required',
                            'kegiatan_tahunan_id'   => 'required',
                            'ind_kegiatan_id'       => 'required',
                            'jumlah_indikator'      => 'required|numeric|min:1',

                            'target_quantity'       => 'required|numeric|min:1',
                            'target_cost'           => 'required',

                            'realisasi_quantity'    => 'required|numeric|min:1',
                            'realisasi_cost'        => 'required',
                            'satuan'                => 'required',


                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $st_update                      = RealisasiIndikatorKegiatanTriwulan::find(Input::get('realisasi_indikator_kegiatan_triwulan_id'));

        $st_update->target_quantity         = Input::get('target_quantity');
        $st_update->realisasi_quantity      = Input::get('realisasi_quantity');
        $st_update->satuan                  = Input::get('satuan');
    

        if ( $st_update->save()){

            //CARI REALISASI KEGIATAN NYA
            $rkt    = RealisasiKegiatanTriwulan::WHERE('capaian_id','=',Input::get('capaian_triwulan_id'))
                                                ->WHERE('kegiatan_tahunan_id','=',Input::get('kegiatan_tahunan_id'))
                                                ->count();

            //jikia belum ada add new
            if ( $rkt == 0 ) {
                $rkt_save    = new RealisasiKegiatanTriwulan;
                $rkt_save->capaian_id               = Input::get('capaian_triwulan_id');
                $rkt_save->kegiatan_tahunan_id      = Input::get('kegiatan_tahunan_id');
                $rkt_save->jumlah_indikator         = Input::get('jumlah_indikator');

                $rkt_save->target_cost              = preg_replace('/[^0-9]/', '', Input::get('target_cost'));
              
                $rkt_save->save();

            //jika sudah ada update saja
            }else{

                $rkt_update                           = RealisasiKegiatanTriwulan::find(Input::get('realisasi_kegiatan_triwulan_id'));
                $rkt_update->jumlah_indikator         = Input::get('jumlah_indikator');
                //$rkt_update->realisasi_quality        = Input::get('realisasi_quality');
                $rkt_update->realisasi_cost           = preg_replace('/[^0-9]/', '', Input::get('realisasi_cost'));
             
                $rkt_update->save();
            }

            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
    } 


    public function Destroy(Request $request)
    {

        $messages = [
               
                'realisasi_indikator_kegiatan_id.required'      => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'realisasi_indikator_kegiatan_id'   => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $st_kt    = RealisasiIndikatorKegiatanTriwulan::find(Input::get('realisasi_indikator_kegiatan_id'));
        if (is_null($st_kt)) {
            return $this->sendError('Realisasi Indikator Kegiatan tidak ditemukan.');
        }


        if ( $st_kt->delete()){
            //Saata indikator kegiatan di hapus.,cek dulu jumlah indikator 
            $capaian_id = $st_kt->capaian_id ;
            $data_uing = IndikatorKegiatan::WHERE('kegiatan_id',Input::get('kegiatan_id'))
                                            //LEFT JOIN TERHADAP REALISASI INDIKATOR KEGIATAN
                                            ->join('db_pare_2018.realisasi_indikator_kegiatan_triwulan AS realisasi_indikator', function($join) use($capaian_id) {
                                                $join   ->on('realisasi_indikator.indikator_kegiatan_id','=','renja_indikator_kegiatan.id');
                                                $join   ->WHERE('realisasi_indikator.capaian_id','=',  $capaian_id );
                                                
                                            })
                                            ->count();

            if ( $data_uing === 0 ){
                $del_ah    = RealisasiKegiatanTriwulan::find(Input::get('realisasi_kegiatan_id'));
                $del_ah->delete();
            }


            return \Response::make('sukses'. $data_uing  , 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    } 
}
