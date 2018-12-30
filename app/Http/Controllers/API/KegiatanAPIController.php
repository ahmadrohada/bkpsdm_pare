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
use App\Models\IndikatorKegiatan;
use App\Models\PerjanjianKinerja;
use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class KegiatanAPIController extends Controller {

    


    public function RenjaKegiatanList(Request $request)
    {

        
        
        $dt = Kegiatan::WHERE('renja_id','=',$request->renja_id)
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
