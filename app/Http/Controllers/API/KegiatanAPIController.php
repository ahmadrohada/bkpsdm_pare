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

   

    
    

   

    public function KegiatanDetail(Request $request)
    {
       
        
        $x = Kegiatan::SELECT('id','label')
                            ->WHERE('renja_kegiatan.id', $request->get('kegiatan_id') )
                            ->SELECT(   'renja_kegiatan.id AS kegiatan_id',
                                        'renja_kegiatan.label AS label',
                                        'renja_kegiatan.indikator AS indikator',
                                        'renja_kegiatan.target AS target',
                                        'renja_kegiatan.satuan AS satuan',
                                        'renja_kegiatan.cost AS cost'
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
                //j'pejabat'       => Pustaka::capital_string($x->jabatan_id != '0' ? $x->PenanggungJawab->jabatan : '0'),
                'list_indikator'=> $list,   
            );
        return $kegiatan;
        
    }
    
    public function RenjaKegiatanList(Request $request)
    {
        
        
        $dt = Kegiatan::WHERE('renja_id','=',$request->renja_id)
                //->WHERE('jabatan_id','0')
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
                        //->WHERE('cost','>', 0 )
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