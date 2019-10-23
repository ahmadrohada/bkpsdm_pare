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

class StrukturOrganisasiAPIController extends Controller {


    public function skpd_struktur_organisasi(Request $request)
    {
       
		$skpd_id     = $request->skpd_id;
        //PETA JABATAN yaitu tabel Mm_skpd
		$peta_jabatan 		= PetaJabatan::join('demo_asn.tb_history_jabatan AS a', function($join){
										$join   ->on('a.id_jabatan','=','m_skpd.id');
										$join   ->WHERE('a.status','=','active');
											
									})
									

									->leftjoin('demo_asn.tb_pegawai AS pegawai', 'a.id_pegawai','=','pegawai.id')
									//eselon
									->leftjoin('demo_asn.m_eselon AS eselon', 'a.id_eselon','=','eselon.id')
									->leftjoin('demo_asn.m_jenis_jabatan AS c', 'c.id','=','eselon.id_jenis_jabatan')

									->select(
										'm_skpd.id',
										'm_skpd.skpd',
										'm_skpd.parent_id',
										'a.nip',
										'pegawai.nama',
										'pegawai.gelardpn',
										'pegawai.gelarblk',
										'pegawai.jenis_kelamin AS jk',
										'pegawai.status AS status_pegawai',
										'eselon.eselon',
										'c.jenis_jabatan'
									)
	

								
									//->where('pegawai.status', '=', 'active')
									->where('m_skpd.id_skpd','=',$skpd_id)
									->where('m_skpd.id','!=',$skpd_id)

									



									//->limit(10)
                                    ->get();
		
		//ORDER BY WEEK ASC,c.id ASC
		$no = 0;
		
		
		foreach ($peta_jabatan as $x) {
            if ( $no == 0 ){
				$parent = null;
			}else{
				$parent = $x->parent_id;
			}

			
			
			//jika pejabat nya sudah pensiun maka tampilin aja jabatan nya mah
			if ( $x->status_pegawai == 'active'){
				$title 			= Pustaka::nama_pegawai($x->gelardpn , $x->nama , $x->gelarblk);
				$label 			= Pustaka::nama_pegawai($x->gelardpn , $x->nama , $x->gelarblk);
				$nip			= $x->nip;
				$eselon			= $x->eselon;
				$jenis_jabatan	= $x->jenis_jabatan . $x->id;

				//Foto pagawai
				if ( $x->jk == 'Perempuan'){
					$sub_data['image']   = asset('assets/images/form/female_icon.png');
				}else{
					$sub_data['image']   = asset('assets/images/form/male_icon.png');
				}
				$sub_data['itemTitleColor']		= "#4b0082";

			}else{
				$title 			= "PENSIUN";
				$label 			= "PENSIUN";
				$nip			= "-";
				$eselon			= "-";
				$jenis_jabatan	= "-";
				$sub_data['image']   = asset('assets/images/form/default_icon.png');
				$sub_data['itemTitleColor']		= "#e3dede";
			}



			
			$sub_data['id']					= $x->id;
			$sub_data['parent']				= $parent;
			$sub_data['title']				= $title;
			$sub_data['label']				= $label;
			$sub_data['jabatan']			= Pustaka::capital_string($x->skpd);
			$sub_data['nip']				= $nip;
			$sub_data['eselon']				= $eselon;
			$sub_data['jenis_jabatan']		= $jenis_jabatan;
			$sub_data['groupTitleColor']	= "primitives.common.Colors.Green";
			
			$data[] = $sub_data ;	

			$no++;
		}	
		
		
		return $data; 

		
    }

   
}
