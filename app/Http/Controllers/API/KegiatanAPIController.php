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


    public function KegiatanDetail(Request $request)
    {
       
        
        $x = Kegiatan::SELECT('id','label')
                            ->WHERE('renja_kegiatan.id', $request->get('kegiatan_id') )
                            ->SELECT(   'renja_kegiatan.id AS kegiatan_id',
                                        'renja_kegiatan.label AS label',
                                        'renja_kegiatan.indikator AS indikator',
                                        'renja_kegiatan.quantity AS quantity',
                                        'renja_kegiatan.satuan AS satuan',
                                        'renja_kegiatan.cost AS cost'

                                    ) 
                            ->first();


		
        $kegiatan = array(
                'kegiatan_id'   => $x->kegiatan_id,
                'label'         => $x->label,
                'indikator'     => $x->indikator,
                'quantity'      => $x->quantity,
                'satuan'        => $x->satuan,
                'cost'	        => number_format($x->cost,'0',',','.')
                    
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
                    'quantity',
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
                        ->select([   
                            'id AS kegiatan_id',
                            'label AS label_kegiatan',
                            'indikator',
                            'quantity',
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
            return $x->quantity.' '.$x->satuan ;
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

        $messages = [
                'ind_program_id.required'     => 'Harus diisi',
                'renja_id.required'           => 'Harus diisi',
                'label_kegiatan.required'     => 'Harus diisi',
                'label_ind_kegiatan.required' => 'Harus diisi',
                'quantity_kegiatan.required'  => 'Harus diisi',
                'satuan_kegiatan.required'    => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'ind_program_id'        => 'required',
                            'renja_id'              => 'required',
                            'label_kegiatan'        => 'required',
                            'label_ind_kegiatan'    => 'required',
                            'quantity_kegiatan'     => 'required',
                            'satuan_kegiatan'       => 'required',

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
        $sr->indikator                  = Input::get('label_ind_kegiatan');
        $sr->quantity                   = Input::get('quantity_kegiatan');
        $sr->satuan                     = Input::get('satuan_kegiatan');
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
                'label_ind_kegiatan.required'   => 'Harus diisi',
                'quantity_kegiatan.required'    => 'Harus diisi',
                'satuan_kegiatan.required'      => 'Harus diisi',
                

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'kegiatan_id'           => 'required',
                            'label_kegiatan'        => 'required',
                            'label_ind_kegiatan'    => 'required',
                            'quantity_kegiatan'     => 'required',
                            'satuan_kegiatan'       => 'required',
                            
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
        $sr->indikator                  = Input::get('label_ind_kegiatan');
        $sr->quantity                   = Input::get('quantity_kegiatan');
        $sr->satuan                     = Input::get('satuan_kegiatan');
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
