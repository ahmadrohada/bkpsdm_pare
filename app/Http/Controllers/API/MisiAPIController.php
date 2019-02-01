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
use App\Models\Tujuan;
use App\Models\Misi;
use App\Models\IndikatorKegiatan;
use App\Models\PerjanjianKinerja;
use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class MisiAPIController extends Controller {


    public function MisiSelect2(Request $request)
    {
         
        $label 		 =  ($request->get('label') !== null)?$request->get('label'):null;
        $dt = Misi::
                WHERE('misi.label', 'like' , '%'.$label.'%')
                ->select([   
                    'misi.id AS misi_id',
                    'misi.label',
                    ])
                    ->get();

       /*  while($x = $query->fetch(PDO::FETCH_OBJ)) {
						$no++;
						$item[] = array(
									'no'		=> $no,
									'id'		=> $x->jenis_beras_id,
									'label'		=> $x->label,
						);
		}	 */
        return $dt ;
        
    }

       
}
