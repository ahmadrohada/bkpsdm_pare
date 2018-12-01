<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PeriodeTahunan;
use App\Models\PerjanjianKinerja;
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

class PetaJabatanAPIController extends Controller {


    public function skpd_peta_jabatan(Request $request)
    {
       
        
        $id_skpd_admin      = \Auth::user()->pegawai->history_jabatan
                                    ->where('status','active')
                                    ->first()
                                    ->id_skpd;

        
        $renja 		= PetaJabatan::select('id','skpd','parent_id')
                                    ->where('id_skpd','=',$id_skpd_admin)
                                    ->get();
		
		//ORDER BY WEEK ASC,c.id ASC
		$no = 0;
		
		
		foreach ($renja as $x) {
			
            $no++;
            
            
				
			$sub_data['id']				= $x->id;
			$sub_data['text']			= Pustaka::capital_string($x->skpd);
			$sub_data['parent_id']		= $x->parent_id;
			
			//array_push($response["list_renja"], $h);
			$data[] = $sub_data ;		
		}	
		
		$itemsByReference = array();

		// Build array of item references:
		foreach($data as $key => &$item) {
		   $itemsByReference[$item['id']] = &$item;
		   // Children array:
		   $itemsByReference[$item['id']]['nodes'] = array();
		}

		// Set items as children of the relevant parent item.
		foreach($data as $key => &$item)  {
		//echo "<pre>";print_r($itemsByReference[$item['parent_id']]);die;
		   if($item['parent_id'] && isset($itemsByReference[$item['parent_id']])) {
			  $itemsByReference [$item['parent_id']]['nodes'][] = &$item;
			}
		}
		// Remove items that were added to parents elsewhere:
		foreach($data as $key => &$item) {
			 if(empty($item['nodes'])) {
				unset($item['nodes']);
				}
		   if($item['parent_id'] && isset($itemsByReference[$item['parent_id']])) {
			  unset($data[$key]);
			 }
		}
		return $data;
        
    }

   
}
