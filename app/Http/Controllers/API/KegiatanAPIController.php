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
use App\Models\SKPD;
use App\Models\Jabatan;
use App\Models\RencanaAksi;
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

    
    
    public function SKPTahunanKegiatanTree2(Request $request)
    {
       
        //Kegiatan nya KABID , cari KASUBID yang parent KABID ini
        $child = Jabatan::SELECT('id')->WHERE('parent_id', $request->jabatan_id )->get()->toArray(); 

        $skp_tahunan_id = $request->skp_tahunan_id;
        $kegiatan = Kegiatan::SELECT('id','label')
                            ->WHERE('renja_kegiatan.renja_id', $request->renja_id )
                            ->WHEREIN('renja_kegiatan.jabatan_id',$child )
                            ->leftjoin('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join) use ( $skp_tahunan_id ){
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
          

            //RENCANA AKSI
            $ra = RencanaAksi::WHERE('kegiatan_tahunan_id',$x->kegiatan_tahunan_id)->get();

            foreach ($ra as $y) {
                $data_rencana_aksi['id']	        = "RencanaAksi|".$y->id;
                $data_rencana_aksi['text']			= Pustaka::capital_string($y->label);
              
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

    public function SKPTahunanKegiatanTree3(Request $request)
    {
       
        //Kegiatan nya KSUBID
        $skp_tahunan_id = $request->skp_tahunan_id;
        $kegiatan = Kegiatan::SELECT('id','label')
                            ->WHERE('renja_kegiatan.renja_id', $request->renja_id )
                            ->WHERE('renja_kegiatan.jabatan_id',$request->jabatan_id )
                            ->leftjoin('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join) use ( $skp_tahunan_id ){
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
          

            //RENCANA AKSI
            $ra = RencanaAksi::WHERE('kegiatan_tahunan_id',$x->kegiatan_tahunan_id)->get();

            foreach ($ra as $y) {
                $data_rencana_aksi['id']	        = "RencanaAksi|".$y->id;
                $data_rencana_aksi['text']			= Pustaka::capital_string($y->label);
              
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


    public function KegiatanDetailoverId(Request $request)
    {
       
        
        $kegiatan = Kegiatan::SELECT('id','label')
                            ->WHERE('renja_kegiatan.id', $request->kegiatan_renja_id )
                            ->leftjoin('db_pare_2018.renja_indikator_kegiatan AS indikator', function($join){
                                $join   ->on('indikator.kegiatan_id','=','renja_kegiatan.id');
                            })
                            ->SELECT(   'renja_kegiatan.id AS kegiatan_id',
                                        'renja_kegiatan.label AS kegiatan_label',
                                        'indikator.id AS indikator_id',
                                        'indikator.label AS indikator_label',
                                        'indikator.target AS target',
                                        'indikator.satuan AS satuan'

                                    ) 
                            ->first();

		
		return  $kegiatan;
        
    }

    public function RenjaKegiatanList(Request $request)
    {

        
        
        $dt = Kegiatan::WHERE('renja_id','=',$request->renja_id)
                ->WHERE('jabatan_id','0')
                ->select([   
                    'id AS kegiatan_id',
                    'label'
                    
                    ])
                ->get();

                
        $datatables = Datatables::of($dt)
        ->addColumn('checkbox', function ($x) {
           
            return '<input type="checkbox" class="cb_pilih" value="'.$x->kegiatan_id.'" name="cb_pilih[]" >';
        })
        ->addColumn('label', function ($x) {
            return $x->label;
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

          /*  $kegiatan = Kegiatan::find($request->id);
        if (is_null($kegiatan)) {
            return \Response::make('Kegiatan  tidak ditemukan', 404);
        }

        $kegiatan->label = $request->text;
        
        
        if ( $kegiatan->save()){
            return \Response::make('Sukses', 200);
        }else{
            return \Response::make('error', 500);
        }
 */
        
      
    }

    








    public function Store(Request $request)
    {

        $pk = new Kegiatan;
        $pk->label                  = Input::get('text');
        $pk->renja_id               = Input::get('renja_id');
        $pk->indikator_program_id   = Input::get('parent_id');

    
        if ( $pk->save()){
            $tes = array('id' => 'kegiatan|'.$pk->id);
            return \Response::make($tes, 200);
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
