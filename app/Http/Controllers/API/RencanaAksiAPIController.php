<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PeriodeTahunan;
use App\Models\PerjanjianKinerja;
use App\Models\KegiatanSKPTahunan;


use App\Models\Tujuan;
use App\Models\IndikatorTujuan;
use App\Models\Sasaran;
use App\Models\Skpd;
use App\Models\SKPTahunan;
use App\Models\RencanaAksi;


use App\Models\SasaranPerjanjianKinerja;
use App\Models\IndikatorSasaran;
use App\Models\Program;
use App\Models\IndikatorProgram;
use App\Models\Kegiatan;
use App\Models\IndikatorKegiatan;
use App\Models\PetaJabatan;
use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class RencanaAksiAPIController extends Controller {



    public function rencana_aksi_tree(Request $request)
    {
       

        $skp_tahunan = SKPTahunan::where('id','=', $request->skp_tahunan_id )->select('id','perjanjian_kinerja_id')->get();
		foreach ($skp_tahunan as $x) {
            $data_skp['id']	            = "skp_tahunan_id".$x->id;
			$data_skp['text']			= "SKP Tahunan ".$x->Perjanjian_kinerja->renja->periode->label;
            $data_skp['icon']           = "jstree-file";
            $data_skp['type']           = "level_1";
            

            $keg_tugas_jabatan = KegiatanSKPTahunan::where('skp_tahunan_id','=',$x->id)->select('id','label')->get();
            foreach ($keg_tugas_jabatan as $y) {
                $data_kegiatan_skp['id']	        = "kabid".$y->id;
                $data_kegiatan_skp['text']			= Pustaka::capital_string($y->label);
                $data_kegiatan_skp['icon']          = "jstree-kegiatan";
                $data_kegiatan_skp['type']          = "level_2";


                $rencana_aksi = RencanaAksi::where('kegiatan_tugas_jabatan_id','=',$y->id)->select('id','label')->get();
                foreach ($rencana_aksi as $z) {
                    $data_rencana_aksi['id']	        = "kasubid".$z->id;
                    $data_rencana_aksi['text']			= Pustaka::capital_string($z->label);
                    $data_rencana_aksi['icon']          = "jstree-ind_kegiatan";
                    

                    
                    $kasubid_list[] = $data_rencana_aksi ;
                    unset($data_rencana_aksi['children']);
                
                }

                if(!empty($kasubid_list)) {
                    $data_kegiatan_skp['children']     = $kasubid_list;
                }
                $kabid_list[] = $data_kegiatan_skp ;
                $kasubid_list = "";
                unset($data_kegiatan_skp['children']);
            
            }
               
               

        }	

            if(!empty($kabid_list)) {
                $data_skp['children']     = $kabid_list;
            }
            $data[] = $data_skp ;	
            $kabid_list = "";
            unset($data_skp['children']);
		
		return $data;
        
    }



    public function RencanaAksiList(Request $request)
    {
            
       
        $dt = Rencanaaksi::WHERE('kegiatan_tahunan_id','=', $request->kegiatan_tahunan_id )

                ->select([   
                    'id AS rencana_aksi_id',
                    'label',
                    'waktu_pelaksanaan',
                    'jabatan_id'
                    
                    ])
                ->get();

                
                
        $datatables = Datatables::of($dt)
        ->addColumn('label', function ($x) {
            return $x->label;
        })
        ->addColumn('pelaksana', function ($x) {
            if ($x->jabatan_id > 0 ){
                return Pustaka::capital_string($x->Pelaksana->skpd);
            }else{
                return '-';
            }
             
        })
        ->addColumn('waktu_pelaksanaan', function ($x) {
            return Pustaka::bulan($x->waktu_pelaksanaan);
        });

        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true); 
        
    }

    public function RencanaAksiDetail(Request $request)
    {
       
        
        $x = RencanaAksi::
                            SELECT(     'id AS rencana_aksi_id',
                                        'label',
                                        'waktu_pelaksanaan',
                                        'jabatan_id'
                                    ) 
                            ->WHERE('id', $request->rencana_aksi_id)
                            ->first();

        if ( $jabatan->id > 0 ){
            $pelaksana = Pustaka::capital_string($x->Pelaksana->skpd);
        }else{
            $pelaksana = '-';
        }
		
		//return  $rencana_aksi;
        $rencana_aksi = array(
            'id'                 => $x->rencana_aksi_id,
            'label'              => $x->label,
            'waktu_pelaksanaan'  => $x->waktu_pelaksanaan,
            'jabatan_id'         => $x->jabatan_id,
            'nama_jabatan'       => $pelaksana
 
        );
        return $rencana_aksi;
    }

    public function Store(Request $request)
    {

        $messages = [
                'kegiatan_tahunan_id.required'  => 'Harus diisi',
                'waktu_pelaksanaan.required'    => 'Harus diisi',
                'pelaksana.required'            => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'kegiatan_tahunan_id'   => 'required',
                            'pelaksana'             => 'required',
                            'waktu_pelaksanaan'     => 'required',
                            'label'                 => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        $target = Input::get('waktu_pelaksanaan');

        for ($i = 0; $i < count($target); $i++){
            $data[] = array(

            'kegiatan_tahunan_id'   => Input::get('kegiatan_tahunan_id'),
            'jabatan_id'            => Input::get('pelaksana'),
            'label'                 => Input::get('label'),
            'waktu_pelaksanaan'     => $target[$i],
            'created_at'            => date('Y'."-".'m'."-".'d'." ".'H'.":".'i'.":".'s'),
            );



        }

        $st_ra   = new RencanaAksi;
        $st_ra -> insert($data);

      
            
    
    }


    public function Update(Request $request)
    {

        $messages = [
                'rencana_aksi_id.required'   => 'Harus diisi',
                'label.required'             => 'Harus diisi',
                'waktu_pelaksanaan_edit.required'=> 'Harus diisi'

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'rencana_aksi_id'        => 'required',
                            'label'                  => 'required',
                            'waktu_pelaksanaan_edit'=> 'required'
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $st_ra    = RencanaAksi::find(Input::get('rencana_aksi_id'));
        if (is_null($st_ra)) {
            return $this->sendError('Rencana Aksi tidak ditemukan.');
        }


        $st_ra->label               = Input::get('label');
        $st_ra->waktu_pelaksanaan	= Input::get('waktu_pelaksanaan_edit');

        if ( $st_ra->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }


    public function Hapus(Request $request)
    {

        $messages = [
                'rencana_aksi_id.required'   => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'rencana_aksi_id'   => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $st_ra    = RencanaAksi::find(Input::get('rencana_aksi_id'));
        if (is_null($st_ra)) {
            return $this->sendError('Kegiatan Tahunan tidak ditemukan.');
        }


        if ( $st_ra->delete()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }
  

}
