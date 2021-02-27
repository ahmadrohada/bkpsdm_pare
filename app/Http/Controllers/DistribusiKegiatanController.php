<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Logic\User\UserRepository;
use App\Logic\User\CaptureIp;
use App\Http\Requests;
use App\Models\Social;
use App\Models\User;
use App\Models\Role;
use App\Models\UsersRole;
use App\Models\Pegawai;
use App\Models\HistoryJabatan;
use App\Models\Skpd;
use App\Helpers\Pustaka;

use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades;
use Illuminate\Http\Request;


use Datatables;
use Validator;
use Gravatar;
use Input;

class DistribusiKegiatanController extends Controller {



	protected function dataSnapshots()
	{

		$user                   = \Auth::user();
        $id_skpd_admin          = \Auth::user()->pegawai->historyjabatan->where('status','active')->first()->id_skpd;

		$jabPTP 				= \DB::table('demo_asn.m_skpd AS jabatan')
									->where('jabatan.id_skpd', '=',  $id_skpd_admin)
									->where('jabatan.id','!=',$id_skpd_admin)
									->leftjoin('demo_asn.m_eselon AS eselon', 'eselon.id','=','jabatan.id_eselon')
									->leftJoin('demo_asn.m_unit_kerja AS unit_kerja', 'unit_kerja.id','=','jabatan.id_unit_kerja')
									->where('eselon.id_jenis_jabatan','=','1');

        $adminitrator           = \DB::table('demo_asn.m_skpd AS jabatan')
									->where('jabatan.id_skpd', '=',  $id_skpd_admin)
									->where('jabatan.id','!=',$id_skpd_admin)
									->leftjoin('demo_asn.m_eselon AS eselon', 'eselon.id','=','jabatan.id_eselon')
									->leftJoin('demo_asn.m_unit_kerja AS unit_kerja', 'unit_kerja.id','=','jabatan.id_unit_kerja')
									->where('eselon.id_jenis_jabatan','=','2');

        $pengawas                = \DB::table('demo_asn.m_skpd AS jabatan')
									->where('jabatan.id_skpd', '=',  $id_skpd_admin)
									->where('jabatan.id','!=',$id_skpd_admin)
									->leftjoin('demo_asn.m_eselon AS eselon', 'eselon.id','=','jabatan.id_eselon')
									->leftJoin('demo_asn.m_unit_kerja AS unit_kerja', 'unit_kerja.id','=','jabatan.id_unit_kerja')
									->where('eselon.id_jenis_jabatan','=','3');

        $pelaksana_fungsional  = \DB::table('demo_asn.m_skpd AS jabatan')
									->where('jabatan.id_skpd', '=',  $id_skpd_admin)
									->where('jabatan.id','!=',$id_skpd_admin)
									->leftjoin('demo_asn.m_eselon AS eselon', 'eselon.id','=','jabatan.id_eselon')
									->leftJoin('demo_asn.m_unit_kerja AS unit_kerja', 'unit_kerja.id','=','jabatan.id_unit_kerja')
                                    ->where('eselon.id_jenis_jabatan','=','4')->orwhere('eselon.id_jenis_jabatan','=','5');

	    return ([
			'jabPTP' 	               => $jabPTP->count(),
			'administrator'            => $adminitrator->count(),
			'pengawas'                 => $pengawas->count(),
			'pelaksana_fungsional'     => $pelaksana_fungsional->count(),
		]);  

	}

	public function ShowDistribusiKegiatanAll()
	{

        $user                   = \Auth::user();
        $id_skpd_admin          = \Auth::user()->pegawai->history_jabatan->where('status','active')->first()->id_skpd;
		
		$dtSnapshot = $this->dataSnapshots();	
									
		//CARI id skpd nya
        $skpd       = SKPD::where('id_skpd', $id_skpd_admin)->first()->unit_kerja;
       
	   
      return view('pare_pns.pages.distribusi-kegiatan', [
				'jenis_jabatan'            => 'All',
				'modules'				   => 'data_table',
				'nama_skpd' 			   => $skpd,
        		'user' 			           => $user,
        		'jabPTP' 	               => $dtSnapshot['jabPTP'],
                'administrator'            => $dtSnapshot['administrator'],
                'pengawas'                 => $dtSnapshot['pengawas'],
                'pelaksana_fungsional'     => $dtSnapshot['pelaksana_fungsional'],
	  			]
        );  
    }


	public function ShowDistribusiKegiatan($jenis_jabatan)
	{

        $user                   = \Auth::user();
        $id_skpd_admin          = \Auth::user()->pegawai->historyjabatan->where('status','active')->first()->id_skpd;

        
		$dtSnapshot = $this->dataSnapshots();							
		
    
        //CARI id skpd nya
        $skpd       = SKPD::where('id_skpd', $id_skpd_admin)->first()->unit_kerja;
       
	   
        return view('pare_pns.pages.distribusi-kegiatan', [
				'jenis_jabatan'            => ucwords($jenis_jabatan),
				'modules'				   => 'data_table',
				'nama_skpd' 			   => $skpd,
        		'user' 			           => $user,
        		'jabPTP' 	               => $dtSnapshot['jabPTP'],
                'administrator'            => $dtSnapshot['administrator'],
                'pengawas'                 => $dtSnapshot['pengawas'],
                'pelaksana_fungsional'     => $dtSnapshot['pelaksana_fungsional'],
        	]
        ); 
    }
	
	
	public function DataJabatanAll(Request $request)
    {
            
        
        $id_skpd_admin      = \Auth::user()->pegawai->historyjabatan->where('status','active')->first()->id_skpd;

		
		\DB::statement(\DB::raw('set @rownum='.$request->get('start')));
      
        $dt = \DB::table('demo_asn.m_skpd AS jabatan')
				->where('jabatan.id_skpd', '=',  $id_skpd_admin)
				->where('jabatan.id','!=',$id_skpd_admin)
				->leftjoin('demo_asn.m_eselon AS eselon', 'eselon.id','=','jabatan.id_eselon')
				->leftJoin('demo_asn.m_unit_kerja AS unit_kerja', 'unit_kerja.id','=','jabatan.id_unit_kerja')
				->leftJoin('demo_asn.m_jenis_jabatan AS jenis_jabatan', 'eselon.id_jenis_jabatan','=','jenis_jabatan.id')
				->select([   
							\DB::raw('@rownum  := @rownum  + 1 AS rownum'),
							'jabatan.id AS id_jabatan',
							'jabatan.skpd',
							'unit_kerja.unit_kerja',
							'unit_kerja.id',
							'jenis_jabatan.jenis_jabatan'
							
						]);
        



        $datatables = Datatables::of($dt)
        ->addColumn('action', function ($x) {
			return 		'<a href="administrator/'.$x->id_jabatan.'/add-kegiatan" class="btn btn-xs btn-primary" style="margin:2px; width:140px;"><i class="fa fa-plus"></i> Add Sub Kegiatan</a>';
		})->addColumn('nama_jabatan', function ($x) {
            
            return Pustaka::capital_string($x->skpd);
        
        })->addColumn('nama_unit_kerja', function ($x) {
            
            return Pustaka::capital_string($x->unit_kerja);
        
        });

        
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true);

        
    }
	
	public function DataJabatanJpt(Request $request)
    {
            
        
        $id_skpd_admin      = \Auth::user()->pegawai->historyjabatan->where('status','active')->first()->id_skpd;

       
        \DB::statement(\DB::raw('set @rownum='.$request->get('start')));
      
        $dt_jpt = \DB::table('demo_asn.m_skpd AS jabatan')
					->where('jabatan.id_skpd', '=',  $id_skpd_admin)
					->where('jabatan.id','!=',$id_skpd_admin)
					->leftjoin('demo_asn.m_eselon AS eselon', 'eselon.id','=','jabatan.id_eselon')
					->where('eselon.id_jenis_jabatan','=','1')
					->leftJoin('demo_asn.m_unit_kerja AS unit_kerja', 'unit_kerja.id','=','jabatan.id_unit_kerja')
					->leftJoin('demo_asn.m_jenis_jabatan AS jenis_jabatan', 'eselon.id_jenis_jabatan','=','jenis_jabatan.id')
					->select([   
								\DB::raw('@rownum  := @rownum  + 1 AS rownum'),
								'jabatan.id AS id_jabatan',
								'jabatan.skpd',
								'unit_kerja.unit_kerja',
								'unit_kerja.id',
								'jenis_jabatan.jenis_jabatan'
								
							]);
        



        $datatables = Datatables::of($dt_jpt)
        ->addColumn('action', function ($x) {
            return 		'<a href="jpt/'.$x->id_jabatan.'/add-kegiatan" class="btn btn-xs btn-primary" style="margin:2px; width:140px;"><i class="fa fa-plus"></i> Add Kegiatan</a>';
					   
        })->addColumn('nama_jabatan', function ($x) {
            
            return Pustaka::capital_string($x->skpd);
        
        })->addColumn('nama_unit_kerja', function ($x) {
            
            return Pustaka::capital_string($x->unit_kerja);
        
        });

        
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true);

        
    }
	

	
	public function DataJabatanAdministrator(Request $request)
    {
            
        
         $id_skpd_admin      = \Auth::user()->pegawai->historyjabatan->where('status','active')->first()->id_skpd;

       
		 \DB::statement(\DB::raw('set @rownum='.$request->get('start')));
      
        $dt = \DB::table('demo_asn.m_skpd AS jabatan')
					->where('jabatan.id_skpd', '=',  $id_skpd_admin)
					->where('jabatan.id','!=',$id_skpd_admin)
					->leftjoin('demo_asn.m_eselon AS eselon', 'eselon.id','=','jabatan.id_eselon')
					->where('eselon.id_jenis_jabatan','=','2')
					->leftJoin('demo_asn.m_unit_kerja AS unit_kerja', 'unit_kerja.id','=','jabatan.id_unit_kerja')
					->leftJoin('demo_asn.m_jenis_jabatan AS jenis_jabatan', 'eselon.id_jenis_jabatan','=','jenis_jabatan.id')
					->select([  'jabatan.id AS id_jabatan',
								'jabatan.skpd',
								'unit_kerja.unit_kerja',
								'unit_kerja.id',
								'jenis_jabatan.jenis_jabatan',
								\DB::raw('@rownum  := @rownum  + 1 AS rownum')
							]);
        



        $datatables = Datatables::of($dt)
        ->addColumn('action', function ($x) {


			

			//return 		'<a href="#" value="action(DistribusiKegiatanController@SkpdDataJabatanJpt,[id=>'.$x->id_jabatan.']) " class="btn btn-xs btn-primary" style="margin:2px; width:140px;"><i class="fa fa-plus"></i> Add Kegiatan</a>';	
			return 		'<a href="administrator/'.$x->id_jabatan.'/add-kegiatan" class="btn btn-xs btn-primary" style="margin:2px; width:140px;"><i class="fa fa-plus"></i> Add Kegiatan</a>';
		})->addColumn('nama_jabatan', function ($x) {
            
            return Pustaka::capital_string($x->skpd);
        
        })->addColumn('nama_unit_kerja', function ($x) {
            
            return Pustaka::capital_string($x->unit_kerja);
        
        });

        
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true);

        
    }
	
	public function DataJabatanPengawas(Request $request)
    {
            
        
         $id_skpd_admin      = \Auth::user()->pegawai->historyjabatan->where('status','active')->first()->id_skpd;

       
		 \DB::statement(\DB::raw('set @rownum='.$request->get('start')));
      
        $dt = \DB::table('demo_asn.m_skpd AS jabatan')
					->where('jabatan.id_skpd', '=',  $id_skpd_admin)
					->where('jabatan.id','!=',$id_skpd_admin)
					->leftjoin('demo_asn.m_eselon AS eselon', 'eselon.id','=','jabatan.id_eselon')
					->where('eselon.id_jenis_jabatan','=','3')
					->leftJoin('demo_asn.m_unit_kerja AS unit_kerja', 'unit_kerja.id','=','jabatan.id_unit_kerja')
					->leftJoin('demo_asn.m_jenis_jabatan AS jenis_jabatan', 'eselon.id_jenis_jabatan','=','jenis_jabatan.id')
					->select([  'jabatan.id AS id_jabatan',
								'jabatan.skpd',
								'unit_kerja.unit_kerja',
								'unit_kerja.id',
								'jenis_jabatan.jenis_jabatan',
								\DB::raw('@rownum  := @rownum  + 1 AS rownum')
							]);
        



        $datatables = Datatables::of($dt)
        ->addColumn('action', function ($x) {
			return 		'<a href="pengawas/'.$x->id_jabatan.'/add-kegiatan" class="btn btn-xs btn-primary" style="margin:2px; width:140px;"><i class="fa fa-plus"></i> Add Kegiatan</a>';
		})->addColumn('nama_jabatan', function ($x) {
            
            return Pustaka::capital_string($x->skpd);
        
        })->addColumn('nama_unit_kerja', function ($x) {
            
            return Pustaka::capital_string($x->unit_kerja);
        
        });

        
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true);

        
    }
	
	public function DataJabatanJfujft(Request $request)
    {
            
        
         $id_skpd_admin      = \Auth::user()->pegawai->historyjabatan->where('status','active')->first()->id_skpd;

       
		 \DB::statement(\DB::raw('set @rownum='.$request->get('start')));
      
        $dt = \DB::table('demo_asn.m_skpd AS jabatan')
					->where('jabatan.id_skpd', '=',  $id_skpd_admin)
					->where('jabatan.id','!=',$id_skpd_admin)
					->leftjoin('demo_asn.m_eselon AS eselon', 'eselon.id','=','jabatan.id_eselon')
					->where('eselon.id_jenis_jabatan','=','4')->orwhere('eselon.id_jenis_jabatan','=','5')
					->leftJoin('demo_asn.m_unit_kerja AS unit_kerja', 'unit_kerja.id','=','jabatan.id_unit_kerja')
					->leftJoin('demo_asn.m_jenis_jabatan AS jenis_jabatan', 'eselon.id_jenis_jabatan','=','jenis_jabatan.id')
					->select([   
								'jabatan.skpd',
								'unit_kerja.unit_kerja',
								'unit_kerja.id',
								'jenis_jabatan.jenis_jabatan',
								\DB::raw('@rownum  := @rownum  + 1 AS rownum')
							]);
        



        $datatables = Datatables::of($dt)
        ->addColumn('action', function ($x) {
			return ""; 
		
		})->addColumn('nama_jabatan', function ($x) {
            
            return Pustaka::capital_string($x->skpd);
        
        })->addColumn('nama_unit_kerja', function ($x) {
            
            return Pustaka::capital_string($x->unit_kerja);
        
        });

        
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true);

        
    }
	
	


	public function AddKegiatan($jenis_jabatan,$id_jabatan)
	{

        $user                   = \Auth::user();
        $id_skpd_admin          = \Auth::user()->pegawai->historyjabatan->where('status','active')->first()->id_skpd;

		$dtSnapshot = $this->dataSnapshots();	
    
        //CARI id skpd nya
        $skpd       = SKPD::where('id_skpd', $id_skpd_admin)->first()->unit_kerja;
		
		
		switch($jenis_jabatan)
		{
			case 'jpt' 				 : $jenis_jabatan='JABATAN PIMPINAN TERTINGGI PRATAMA';
				break;
			case 'administrator'	 : $jenis_jabatan='ADMINISTRATOR';
				break;	
			case 'pengawas'			 : $jenis_jabatan='PENGAWAS';
				break;
		}

	   
        return view('pare_pns.pages.distribusi-kegiatan', [
				'jenis_jabatan'            => $jenis_jabatan,
				'id_jabatan'               => $id_jabatan,
				'modules'				   => 'add_kegiatan',


				'nama_skpd' 			   => $skpd,
        		'user' 			           => $user,
        		'jabPTP' 	               => $dtSnapshot['jabPTP'],
                'administrator'            => $dtSnapshot['administrator'],
                'pengawas'                 => $dtSnapshot['pengawas'],
                'pelaksana_fungsional'     => $dtSnapshot['pelaksana_fungsional'],
        	]
        ); 
    }
   

}
