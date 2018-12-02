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
       
        
       	$id_skpd_admin      = \Auth::user()->pegawai->history_jabatan
                                    ->where('status','active')
                                    ->first()
                                    ->id_skpd;

        
		$renja 		= PetaJabatan::join('demo_asn.tb_history_jabatan AS a', function($join){
										$join   ->on('a.id_jabatan','=','m_skpd.id');
										$join   ->WHERE('a.status','=','active');
											
									})
									

									->leftjoin('demo_asn.tb_pegawai AS pegawai', 'a.id_pegawai','=','pegawai.id')
									//eselon
									->leftjoin('demo_asn.m_eselon AS eselon', 'a.id_eselon','=','eselon.id')
									->leftjoin('demo_asn.m_jenis_jabatan AS c', 'c.id','=','eselon.id_jenis_jabatan')

									->leftjoin('demo_asn.foto AS y ', function($join){
										$join   ->on('pegawai.nip','=','y.nipbaru');
									}) 

									->select(
										'm_skpd.id',
										'm_skpd.skpd',
										'm_skpd.parent_id',
										'a.nip',
										'pegawai.nama',
										'pegawai.gelardpn',
										'pegawai.gelarblk',
										'eselon.eselon',
										'c.jenis_jabatan',
										'y.isi AS foto'
									)
	

								

									->where('m_skpd.id_skpd','=',$id_skpd_admin)
									->where('m_skpd.id','!=',$id_skpd_admin)

									



									//->limit(10)
                                    ->get();
		
		//ORDER BY WEEK ASC,c.id ASC
		$no = 0;
		
		
		foreach ($renja as $x) {
			
            
            if ( $no == 0 ){
				$parent = null;
			}else{
				$parent = $x->parent_id;
			}
		   
			if ( $x->foto != null  ){
				$sub_data['image']   = 'data:image/jpeg;base64,'.base64_encode( $x->foto );
			}else{
				$sub_data['image']   = asset('assets/images/form/sample.jpg');
			}
				
			$sub_data['id']					= $x->id;
			$sub_data['parent']				= $parent;
			$sub_data['title']				= Pustaka::nama_pegawai($x->gelardpn , $x->nama , $x->gelarblk);
			$sub_data['label']				= Pustaka::nama_pegawai($x->gelardpn , $x->nama , $x->gelarblk);
			$sub_data['jabatan']			= Pustaka::capital_string($x->skpd);
			$sub_data['nip']				= $x->nip;
			$sub_data['eselon']				= $x->eselon;
			$sub_data['jenis_jabatan']		= $x->jenis_jabatan;
			$sub_data['itemTitleColor']		= "#4b0082";
			$sub_data['groupTitleColor']	= "primitives.common.Colors.Green";
			
			
			
			
			$data[] = $sub_data ;	

			$no++;
		}	
		
		
		return $data; 

		
    }

   
}
