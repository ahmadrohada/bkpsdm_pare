<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

use App\Models\PerilakuKerja;

use App\Helpers\Pustaka;
use Datatables;
use Validator;
use Input;


class PerilakuKerjaAPIController extends Controller {


   
  
    public function PenilaianPerilakuKerjaDetail(Request $request)
    {
       
        
        $x = PerilakuKerja::
                            SELECT( '*') 
                            ->WHERE('penilaian_perilaku_kerja.capaian_tahunan_id', $request->capaian_tahunan_id)
                            ->first();

		if ( $x != null ){
            $pk = array(
                    'id'           => $x->id,
                    'capaian_tahunan_id' => $request->capaian_tahunan_id,
                    'pelayanan_01' => $x->pelayanan_01,
					'pelayanan_02' => $x->pelayanan_02,
					'pelayanan_03' => $x->pelayanan_03,
					
					'integritas_01' => $x->integritas_01,
					'integritas_02' => $x->integritas_02,
					'integritas_03' => $x->integritas_03,
					'integritas_04' => $x->integritas_04,
					
					
					'komitmen_01' => $x->komitmen_01,
					'komitmen_02' => $x->komitmen_02,
					'komitmen_03' => $x->komitmen_03,
					
					
					'disiplin_01' => $x->disiplin_01,
					'disiplin_02' => $x->disiplin_02,
					'disiplin_03' => $x->disiplin_03,
					'disiplin_04' => $x->disiplin_04,
					
					'kerjasama_01' => $x->kerjasama_01,
					'kerjasama_02' => $x->kerjasama_02,
					'kerjasama_03' => $x->kerjasama_03,
					'kerjasama_04' => $x->kerjasama_04,
					'kerjasama_05' => $x->kerjasama_05,
					
					
					'kepemimpinan_01' => $x->kepemimpinan_01,
					'kepemimpinan_02' => $x->kepemimpinan_02,
					'kepemimpinan_03' => $x->kepemimpinan_03,
					'kepemimpinan_04' => $x->kepemimpinan_04,
					'kepemimpinan_05' => $x->kepemimpinan_05,
					'kepemimpinan_06' => $x->kepemimpinan_06, 
            );
            return $pk;
        }else{
            $pk = array(
                'id'           => 0,
                'capaian_tahunan_id' => $request->capaian_tahunan_id,
                'pelayanan_01' => 1,
                'pelayanan_02' => 1,
                'pelayanan_03' => 1,
                
                'integritas_01' => 1,
                'integritas_02' => 1,
                'integritas_03' => 1,
                'integritas_04' => 1,
                
                
                'komitmen_01' => 1,
                'komitmen_02' => 1,
                'komitmen_03' => 1,
                
                
                'disiplin_01' => 1,
                'disiplin_02' => 1,
                'disiplin_03' => 1,
                'disiplin_04' => 1,
                
                'kerjasama_01' => 1,
                'kerjasama_02' => 1,
                'kerjasama_03' => 1,
                'kerjasama_04' => 1,
                'kerjasama_05' => 1,
                
                
                'kepemimpinan_01' => 1,
                'kepemimpinan_02' => 1,
                'kepemimpinan_03' => 1,
                'kepemimpinan_04' => 1,
                'kepemimpinan_05' => 1,
                'kepemimpinan_06' => 1,
        );
        return $pk;
        }
       
    }

    public function PenilaianPerilakuKerja(Request $request)
    {
       
        
        $x = PerilakuKerja::
                            SELECT( '*') 
                            ->WHERE('penilaian_perilaku_kerja.capaian_tahunan_id', $request->capaian_tahunan_id)
                            ->first();

		if ( $x != null ){
            $pelayanan = ($x->pelayanan_01+$x->pelayanan_02+$x->pelayanan_03)/15 * 100;
            $integritas = ($x->integritas_01+$x->integritas_02+$x->integritas_03+$x->integritas_04)/20*100;
            $komitmen = ($x->komitmen_03+$x->komitmen_03+$x->komitmen_03)/15*100;
            $disiplin = ($x->disiplin_01+$x->disiplin_02+$x->disiplin_03+$x->disiplin_04)/20*100;
            $kerjasama = ($x->kerjasama_01+$x->kerjasama_02+$x->kerjasama_03+$x->kerjasama_04+$x->kerjasama_05)/25*100;
            $kepemimpinan = ($x->kepemimpinan_01+$x->kepemimpinan_02+$x->kepemimpinan_03+$x->kepemimpinan_04+$x->kepemimpinan_05+$x->kepemimpinan_06)/30*100;

            if ( $x->CapaianTahunan->PejabatYangDinilai->Jabatan->Eselon->id_jenis_jabatan < 4 ){
                $jumlah = $pelayanan+$integritas+$komitmen+$disiplin+$kerjasama+$kepemimpinan;
                $ave    = $jumlah / 6 ;
            }else{
                $jumlah = $pelayanan+$integritas+$komitmen+$disiplin+$kerjasama;
                $ave    = $jumlah / 5 ; 
            }

            $pk = array(
                 
                    'pelayanan'         => Pustaka::persen_bulat($pelayanan),
					'integritas'        => Pustaka::persen_bulat($integritas),
					'komitmen'          => Pustaka::persen_bulat($komitmen),
					'disiplin'          => Pustaka::persen_bulat($disiplin),
					'kerjasama'         => Pustaka::persen_bulat($kerjasama),
                    'kepemimpinan'      => Pustaka::persen_bulat($kepemimpinan), 

                    'ket_pelayanan'     => Pustaka::perilaku($pelayanan),
					'ket_integritas'    => Pustaka::perilaku($integritas),
					'ket_komitmen'      => Pustaka::perilaku($komitmen),
					'ket_disiplin'      => Pustaka::perilaku($disiplin),
					'ket_kerjasama'     => Pustaka::perilaku($kerjasama),
                    'ket_kepemimpinan'  => Pustaka::perilaku($kepemimpinan), 


                    'jumlah'            => Pustaka::persen_bulat($jumlah), 
                    'rata_rata'         => Pustaka::persen_bulat($ave), 

                    'ket_rata_rata'     => Pustaka::perilaku($ave), 
            );
            return $pk;
        }else{
            $pk = array(




                    'pelayanan'     => "-",
					'integritas'    => "-",
					'komitmen'      => "-",
					'disiplin'      => "-",
					'kerjasama'     => "-",
                    'kepemimpinan'  => "-", 
                    'jumlah'        => "-",
                    'rata_rata'     => "-",
        );
        return $pk;
        }
       
    }

    public function Store(Request $request)
    {

        $messages = [
                'capaian_tahunan_id.required'   => 'Harus diisi',
                'pelayanan_01.required'         => 'Harus diisi',
                'pelayanan_02.required'         => 'Harus diisi',
                'pelayanan_03.required'         => 'Harus diisi',
                'integritas_01.required'        => 'Harus diisi',
                'integritas_02.required'        => 'Harus diisi',
                'integritas_03.required'        => 'Harus diisi',
                'integritas_04.required'        => 'Harus diisi',
                'komitmen_01.required'          => 'Harus diisi',
                'komitmen_02.required'          => 'Harus diisi',
                'komitmen_03.required'          => 'Harus diisi',
                'disiplin_01.required'          => 'Harus diisi',
                'disiplin_02.required'          => 'Harus diisi',
                'disiplin_03.required'          => 'Harus diisi',
                'disiplin_04.required'          => 'Harus diisi',
                'kerjasama_01.required'         => 'Harus diisi',
                'kerjasama_02.required'         => 'Harus diisi',
                'kerjasama_03.required'         => 'Harus diisi',
                'kerjasama_04.required'         => 'Harus diisi',
                'kerjasama_05.required'         => 'Harus diisi',
                /* 'kepemimpinan_01.required'      => 'Harus diisi',
                'kepemimpinan_02.required'      => 'Harus diisi',
                'kepemimpinan_03.required'      => 'Harus diisi',
                'kepemimpinan_04.required'      => 'Harus diisi',
                'kepemimpinan_05.required'      => 'Harus diisi',
                'kepemimpinan_06.required'      => 'Harus diisi', */

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'capaian_tahunan_id'   => 'required',
                            'pelayanan_01'         => 'required|numeric|min:1|max:5',
                            'pelayanan_02'         => 'required|numeric|min:1|max:5',
                            'pelayanan_03'         => 'required|numeric|min:1|max:5',
                            'integritas_01'        => 'required|numeric|min:1|max:5',
                            'integritas_02'        => 'required|numeric|min:1|max:5',
                            'integritas_03'        => 'required|numeric|min:1|max:5',
                            'integritas_04'        => 'required|numeric|min:1|max:5',
                            'komitmen_01'          => 'required|numeric|min:1|max:5',
                            'komitmen_02'          => 'required|numeric|min:1|max:5',
                            'komitmen_03'          => 'required|numeric|min:1|max:5',
                            'disiplin_01'          => 'required|numeric|min:1|max:5',
                            'disiplin_02'          => 'required|numeric|min:1|max:5',
                            'disiplin_03'          => 'required|numeric|min:1|max:5',
                            'disiplin_04'          => 'required|numeric|min:1|max:5',
                            'kerjasama_01'         => 'required|numeric|min:1|max:5',
                            'kerjasama_02'         => 'required|numeric|min:1|max:5',
                            'kerjasama_03'         => 'required|numeric|min:1|max:5',
                            'kerjasama_04'         => 'required|numeric|min:1|max:5',
                            'kerjasama_05'         => 'required|numeric|min:1|max:5',
                           /*  'kepemimpinan_01'      => 'required|numeric|min:1|max:5',
                            'kepemimpinan_02'      => 'required|numeric|min:1|max:5',
                            'kepemimpinan_03'      => 'required|numeric|min:1|max:5',
                            'kepemimpinan_04'      => 'required|numeric|min:1|max:5',
                            'kepemimpinan_05'      => 'required|numeric|min:1|max:5',
                            'kepemimpinan_06'      => 'required|numeric|min:1|max:5', */

                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $sr    = new PerilakuKerja;

        $sr->capaian_tahunan_id   = Input::get('capaian_tahunan_id');
        $sr->pelayanan_01         = Input::get('pelayanan_01');
        $sr->pelayanan_02         = Input::get('pelayanan_02');
        $sr->pelayanan_03         = Input::get('pelayanan_03');
        $sr->integritas_01        = Input::get('integritas_01');
        $sr->integritas_02        = Input::get('integritas_02');
        $sr->integritas_03        = Input::get('integritas_03');
        $sr->integritas_04        = Input::get('integritas_04');
        $sr->komitmen_01          = Input::get('komitmen_01');
        $sr->komitmen_02          = Input::get('komitmen_02');
        $sr->komitmen_03          = Input::get('komitmen_03');
        $sr->disiplin_01          = Input::get('disiplin_01');
        $sr->disiplin_02          = Input::get('disiplin_02');
        $sr->disiplin_03          = Input::get('disiplin_03');
        $sr->disiplin_04          = Input::get('disiplin_04');
        $sr->kerjasama_01         = Input::get('kerjasama_01');
        $sr->kerjasama_02         = Input::get('kerjasama_02');
        $sr->kerjasama_03         = Input::get('kerjasama_03');
        $sr->kerjasama_04         = Input::get('kerjasama_04');
        $sr->kerjasama_05         = Input::get('kerjasama_05');
        $sr->kepemimpinan_01      = Input::get('kepemimpinan_01') ? Input::get('kepemimpinan_01') : 0 ;
        $sr->kepemimpinan_02      = Input::get('kepemimpinan_02') ? Input::get('kepemimpinan_01') : 0 ;
        $sr->kepemimpinan_03      = Input::get('kepemimpinan_03') ? Input::get('kepemimpinan_01') : 0 ;
        $sr->kepemimpinan_04      = Input::get('kepemimpinan_04') ? Input::get('kepemimpinan_01') : 0 ;
        $sr->kepemimpinan_05      = Input::get('kepemimpinan_05') ? Input::get('kepemimpinan_01') : 0 ;
        $sr->kepemimpinan_06      = Input::get('kepemimpinan_06') ? Input::get('kepemimpinan_01') : 0 ;


        if ( $sr->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }

    
    public function Update(Request $request)
    {

        $messages = [
                'perilaku_kerja_id.required'    => 'Harus diisi',
                'pelayanan_01.required'         => 'Harus diisi',
                'pelayanan_02.required'         => 'Harus diisi',
                'pelayanan_03.required'         => 'Harus diisi',
                'integritas_01.required'        => 'Harus diisi',
                'integritas_02.required'        => 'Harus diisi',
                'integritas_03.required'        => 'Harus diisi',
                'integritas_04.required'        => 'Harus diisi',
                'komitmen_01.required'          => 'Harus diisi',
                'komitmen_02.required'          => 'Harus diisi',
                'komitmen_03.required'          => 'Harus diisi',
                'disiplin_01.required'          => 'Harus diisi',
                'disiplin_02.required'          => 'Harus diisi',
                'disiplin_03.required'          => 'Harus diisi',
                'disiplin_04.required'          => 'Harus diisi',
                'kerjasama_01.required'         => 'Harus diisi',
                'kerjasama_02.required'         => 'Harus diisi',
                'kerjasama_03.required'         => 'Harus diisi',
                'kerjasama_04.required'         => 'Harus diisi',
                'kerjasama_05.required'         => 'Harus diisi',
                'kepemimpinan_01.required'      => 'Harus diisi',
                'kepemimpinan_02.required'      => 'Harus diisi',
                'kepemimpinan_03.required'      => 'Harus diisi',
                'kepemimpinan_04.required'      => 'Harus diisi',
                'kepemimpinan_05.required'      => 'Harus diisi',
                'kepemimpinan_06.required'      => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'perilaku_kerja_id'    => 'required',
                            'pelayanan_01'         => 'required|numeric|min:1|max:5',
                            'pelayanan_02'         => 'required|numeric|min:1|max:5',
                            'pelayanan_03'         => 'required|numeric|min:1|max:5',
                            'integritas_01'        => 'required|numeric|min:1|max:5',
                            'integritas_02'        => 'required|numeric|min:1|max:5',
                            'integritas_03'        => 'required|numeric|min:1|max:5',
                            'integritas_04'        => 'required|numeric|min:1|max:5',
                            'komitmen_01'          => 'required|numeric|min:1|max:5',
                            'komitmen_02'          => 'required|numeric|min:1|max:5',
                            'komitmen_03'          => 'required|numeric|min:1|max:5',
                            'disiplin_01'          => 'required|numeric|min:1|max:5',
                            'disiplin_02'          => 'required|numeric|min:1|max:5',
                            'disiplin_03'          => 'required|numeric|min:1|max:5',
                            'disiplin_04'          => 'required|numeric|min:1|max:5',
                            'kerjasama_01'         => 'required|numeric|min:1|max:5',
                            'kerjasama_02'         => 'required|numeric|min:1|max:5',
                            'kerjasama_03'         => 'required|numeric|min:1|max:5',
                            'kerjasama_04'         => 'required|numeric|min:1|max:5',
                            'kerjasama_05'         => 'required|numeric|min:1|max:5',
                            'kepemimpinan_01'      => 'required|numeric|min:1|max:5',
                            'kepemimpinan_02'      => 'required|numeric|min:1|max:5',
                            'kepemimpinan_03'      => 'required|numeric|min:1|max:5',
                            'kepemimpinan_04'      => 'required|numeric|min:1|max:5',
                            'kepemimpinan_05'      => 'required|numeric|min:1|max:5',
                            'kepemimpinan_06'      => 'required|numeric|min:1|max:5',

                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        $sr    = PerilakuKerja::find(Input::get('perilaku_kerja_id'));
        if (is_null($sr)) {
            return $this->sendError('Penilaian Perilaku Kerja Tidak ditemukan.');
        }



        $sr->capaian_tahunan_id   = Input::get('capaian_tahunan_id');
        $sr->pelayanan_01         = Input::get('pelayanan_01');
        $sr->pelayanan_02         = Input::get('pelayanan_02');
        $sr->pelayanan_03         = Input::get('pelayanan_03');
        $sr->integritas_01        = Input::get('integritas_01');
        $sr->integritas_02        = Input::get('integritas_02');
        $sr->integritas_03        = Input::get('integritas_03');
        $sr->integritas_04        = Input::get('integritas_04');
        $sr->komitmen_01          = Input::get('komitmen_01');
        $sr->komitmen_02          = Input::get('komitmen_02');
        $sr->komitmen_03          = Input::get('komitmen_03');
        $sr->disiplin_01          = Input::get('disiplin_01');
        $sr->disiplin_02          = Input::get('disiplin_02');
        $sr->disiplin_03          = Input::get('disiplin_03');
        $sr->disiplin_04          = Input::get('disiplin_04');
        $sr->kerjasama_01         = Input::get('kerjasama_01');
        $sr->kerjasama_02         = Input::get('kerjasama_02');
        $sr->kerjasama_03         = Input::get('kerjasama_03');
        $sr->kerjasama_04         = Input::get('kerjasama_04');
        $sr->kerjasama_05         = Input::get('kerjasama_05');
        $sr->kepemimpinan_01      = Input::get('kepemimpinan_01');
        $sr->kepemimpinan_02      = Input::get('kepemimpinan_02');
        $sr->kepemimpinan_03      = Input::get('kepemimpinan_03');
        $sr->kepemimpinan_04      = Input::get('kepemimpinan_04');
        $sr->kepemimpinan_05      = Input::get('kepemimpinan_05');
        $sr->kepemimpinan_06      = Input::get('kepemimpinan_06');


        if ( $sr->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }

    public function Hapus(Request $request)
    {

        $messages = [
                'perilaku_kerja_id.required'   => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'perilaku_kerja_id'   => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $sr    = Perilaku_Kerja::find(Input::get('perilaku_kerja_id'));
        if (is_null($sr)) {
            return $this->sendError('Penilaian Perilaku kerja tidak ditemukan.');
        }


        if ( $sr->delete()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }
   

}
