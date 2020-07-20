<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Pegawai;
use App\Models\PetaJabatan;
use App\Helpers\Pustaka;

use Input;

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
										'pegawai.id AS id_pegawai',
										'pegawai.nama',
										'pegawai.gelardpn',
										'pegawai.gelarblk',
										'pegawai.jenis_kelamin AS jk',
										'pegawai.status AS status_pegawai',
										'pegawai.nip',
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
            
			//jika pejabat nya sudah pensiun maka tampilin aja jabatan nya mah
			if ( $x->status_pegawai == 'active'){
				
				$filename = 'assets/images/foto/'.$x->nip.'.jpg';
				if (file_exists($filename)) {
					$sub_data['image']   =asset($filename);
				}else{
					if ( $x->jk == 'Perempuan'){
						$sub_data['image']   = asset('assets/images/foto/female_icon.png');
					}else{
						$sub_data['image']   = asset('assets/images/foto/male_icon.png');
					} 
				}
				
				

			}else{
				
				$sub_data['image']   = asset('assets/images/foto/default_icon.png');
			}



			$sub_data['id']					= $x->id;
			$sub_data['parent']				= ($no >= 1)?$x->parent_id : null;
			$sub_data['title']				= ( $x->status_pegawai == 'active')?Pustaka::nama_pegawai($x->gelardpn , $x->nama , $x->gelarblk):"PENSIUN";
			$sub_data['label']				= ( $x->status_pegawai == 'active')?Pustaka::nama_pegawai($x->gelardpn , $x->nama , $x->gelarblk):"PENSIUN";
			$sub_data['jabatan']			= Pustaka::capital_string($x->skpd);
			$sub_data['nip']				= ( $x->status_pegawai == 'active')?$x->nip:"-";
			$sub_data['eselon']				= ( $x->status_pegawai == 'active')?$x->eselon:"-";
			$sub_data['jenis_jabatan']		= ( $x->status_pegawai == 'active')?$x->jenis_jabatan . $x->id : "-";
			$sub_data['groupTitleColor']	= "primitives.common.Colors.Green";
			$sub_data['itemTitleColor']		= ( $x->status_pegawai == 'active')?"#4b0082":"#e3dede";
			
			$data[] = $sub_data ;	

			$no++;
		}	
		
		
		return $data; 

		
	}
	

	public function puskesmas_struktur_organisasi(Request $request)
    {
       
		$puskesmas_id     = $request->puskesmas_id;
        //PETA JABATAN yaitu tabel Mm_skpd
		$peta_jabatan 		= PetaJabatan::join('demo_asn.tb_history_jabatan AS a', function($join){
										$join   ->on('a.id_unit_kerja','=','m_skpd.id');
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
										'pegawai.id AS id_pegawai',
										'pegawai.nama',
										'pegawai.gelardpn',
										'pegawai.gelarblk',
										'pegawai.jenis_kelamin AS jk',
										'pegawai.status AS status_pegawai',
										'pegawai.nip',
										'eselon.eselon',
										'c.jenis_jabatan'
									)
									->where('pegawai.status', '=', 'active')
									->where('m_skpd.id','=',$puskesmas_id)
									//->where('m_skpd.parent_id','=',$puskesmas_id)
									//->limit(10)
                                    ->get();
		
		//ORDER BY WEEK ASC,c.id ASC
		$no = 0;
		
		
		foreach ($peta_jabatan as $x) {
            
			//jika pejabat nya sudah pensiun maka tampilin aja jabatan nya mah
			if ( $x->status_pegawai == 'active'){
				
				$filename = 'assets/images/foto/'.$x->nip.'.jpg';
				if (file_exists($filename)) {
					$sub_data['image']   =asset($filename);
				}else{
					if ( $x->jk == 'Perempuan'){
						$sub_data['image']   = asset('assets/images/foto/female_icon.png');
					}else{
						$sub_data['image']   = asset('assets/images/foto/male_icon.png');
					} 
				}
				
				

			}else{
				
				$sub_data['image']   = asset('assets/images/foto/default_icon.png');
			}



			$sub_data['id']					= $x->id;
			$sub_data['parent']				= ($no >= 1)?$x->parent_id : null;
			$sub_data['title']				= ( $x->status_pegawai == 'active')?Pustaka::nama_pegawai($x->gelardpn , $x->nama , $x->gelarblk):"PENSIUN";
			$sub_data['label']				= ( $x->status_pegawai == 'active')?Pustaka::nama_pegawai($x->gelardpn , $x->nama , $x->gelarblk):"PENSIUN";
			$sub_data['jabatan']			= Pustaka::capital_string($x->skpd);
			$sub_data['nip']				= ( $x->status_pegawai == 'active')?$x->nip:"-";
			$sub_data['eselon']				= ( $x->status_pegawai == 'active')?$x->eselon:"-";
			$sub_data['jenis_jabatan']		= ( $x->status_pegawai == 'active')?$x->jenis_jabatan . $x->id : "-";
			$sub_data['groupTitleColor']	= "primitives.common.Colors.Green";
			$sub_data['itemTitleColor']		= ( $x->status_pegawai == 'active')?"#4b0082":"#e3dede";
			
			$data[] = $sub_data ;	

			$no++;
		}	
		
		
		return $data; 

		
    }

   
}
