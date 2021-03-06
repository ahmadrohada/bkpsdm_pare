<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Sasaran;
use App\Models\KegiatanSKPTahunanJFT;

use App\Models\Kegiatan;
use App\Models\IndikatorKegiatan;
use App\Models\Jabatan;
use App\Models\SKPD;
use App\Models\SKPTahunan;

use App\Helpers\Pustaka;
use App\Traits\TraitSKPTahunan;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class KegiatanSKPTahunanJFTAPIController extends Controller {

    use TraitSKPTahunan;

    public function KegiatanTahunanDetail(Request $request)
    {
       
        
        $x = KegiatanSKPTahunanJFT::

                            join('db_pare_2018.renja_sasaran AS sasaran', function($join){
                                $join   ->on('sasaran.id','=','skp_tahunan_kegiatan_jft.sasaran_id');
                                
                            })
                            ->SELECT(   'skp_tahunan_kegiatan_jft.id AS kegiatan_tahunan_id',
                                        'skp_tahunan_kegiatan_jft.label',
                                        'skp_tahunan_kegiatan_jft.target',
                                        'skp_tahunan_kegiatan_jft.satuan',
                                        'skp_tahunan_kegiatan_jft.angka_kredit',
                                        'skp_tahunan_kegiatan_jft.quality',
                                        'skp_tahunan_kegiatan_jft.cost',
                                        'skp_tahunan_kegiatan_jft.target_waktu',
                                        'skp_tahunan_kegiatan_jft.sasaran_id',
                                        'sasaran.id AS sasaran_id',
                                        'sasaran.label AS sasaran_label'

                                    ) 
                            ->WHERE('skp_tahunan_kegiatan_jft.id', $request->kegiatan_tahunan_id)
                            ->first();
      
		
		//return  $kegiatan_tahunan;
        $kegiatan_tahunan = array(
            'sasaran_id'            => $x->sasaran_id,
            'sasaran_label'         => $x->sasaran_label,  

            'id'                    => $x->kegiatan_tahunan_id,
            'label'                 => $x->label, 
            'ak'                    => $x->angka_kredit,
            'output'                => $x->target.' '.$x->satuan,
            'satuan'                => $x->satuan,
            'target'                => $x->target,
            'quality'               => $x->quality,
            'target_waktu'          => $x->target_waktu,
            'cost'	                => number_format($x->cost,'0',',','.'),
           
         
        );
        return $kegiatan_tahunan;
    }


    public function KegiatanSKPTahunan(Request $request) 
    {

        $kegiatan = $this->Kegiatan($request->skp_tahunan_id);

        $datatables = Datatables::of(collect($kegiatan));
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }      
        return $datatables->make(true);
             
      
        
    }

    public function KegiatanTahunanListelect2(Request $request)
    {
            
        $keg_tahunan = KegiatanSKPTahunanJFT::
                            WHERE('skp_tahunan_kegiatan_jft.skp_tahunan_id', $request->skp_tahunan_id )
                            ->SELECT(   'skp_tahunan_kegiatan_jft.id AS kegiatan_tahunan_id',
                                        'skp_tahunan_kegiatan_jft.label AS kegiatan_tahunan_label'
                                    ) 
                            ->get(); 

        $keg_tahunan_list = [];
            foreach ($keg_tahunan as $x) {
                $keg_tahunan_list[] = array(
                        'text'          => $x->kegiatan_tahunan_label,
                        'id'            => $x->kegiatan_tahunan_id,
                );
            }
        return $keg_tahunan_list;
    }



    public function Store(Request $request)
    {

        $messages = [
                'sasaran_id.required'            => 'Harus diisi',
                'skp_tahunan_id.required'        => 'Harus diisi',
                'label.required'                 => 'Harus diisi',
                'target.required'                => 'Harus diisi',
                'satuan.required'                => 'Harus diisi',
                //'angka_kredit.required'          => 'Harus diisi',
                'quality.required'               => 'Harus diisi',
                //'cost.required'                  => 'Harus diisi',
                'target_waktu.required'          => 'Harus diisi'

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'sasaran_id'        => 'required',
                            'skp_tahunan_id'    => 'required',
                            'label'             => 'required',
                            //'angka_kredit'      => 'required|numeric',
                            'target'            => 'required|numeric',
                            'satuan'            => 'required',
                            //'cost'              => 'required',
                            'quality'           => 'required|numeric|min:1|max:100',
                            'target_waktu'      => 'required|numeric|min:1|max:12',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $st_kt    = new KegiatanSKPTahunanJFT;

        $st_kt->sasaran_id              = Input::get('sasaran_id');
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
                'sasaran_id.required'            => 'Harus diisi',
                //'satuan.required'                => 'Harus diisi',
                'quality.required'               => 'Harus diisi',
                'target_waktu.required'          => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'kegiatan_tahunan_id'   => 'required',
                            'label'                 => 'required',
                            'sasaran_id'            => 'required',
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

        
        $st_kt    = KegiatanSKPTahunanJFT::find(Input::get('kegiatan_tahunan_id'));
        if (is_null($st_kt)) {
            return $this->sendError('Kegiatan Tahunan tidak ditemukan.');
        }

        $st_kt->sasaran_id        = Input::get('sasaran_id');
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

        
        $st_kt    = KegiatanSKPTahunanJFT::find(Input::get('kegiatan_tahunan_id'));
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
