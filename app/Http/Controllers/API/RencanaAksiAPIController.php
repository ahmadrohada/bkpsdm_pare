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
            

            $keg_tugas_jabatan = KegiatanSKPTahunan::where('skp_tahunan_id','=',$x->id)->select('id','label')->get();
            foreach ($keg_tugas_jabatan as $y) {
                $data_kegiatan_skp['id']	        = "kabid".$y->id;
                $data_kegiatan_skp['text']			= Pustaka::capital_string($y->label);
                $data_kegiatan_skp['icon']         = "jstree-kegiatan";


                $rencana_aksi = RencanaAksi::where('kegiatan_tugas_jabatan_id','=',$y->id)->select('id','label')->get();
                foreach ($rencana_aksi as $z) {
                    $data_rencana_aksi['id']	            = "kasubid".$z->id;
                    $data_rencana_aksi['text']			= Pustaka::capital_string($z->label);
                    $data_rencana_aksi['icon']           = "jstree-ind_kegiatan";
                    

                    
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
  

}
