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
use App\Models\PeriodeTahunan;

use App\Models\PerjanjianKinerja;
use App\Models\Sasaran;
use App\Models\SasaranPerjanjianKinerja;
use App\Models\IndikatorSasaran;
use App\Models\Program;
use App\Models\IndikatorProgram;
use App\Models\Kegiatan;
use App\Models\IndikatorKegiatan;



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
Use Alert;

class SasaranController extends Controller {



    protected function id_skpd_admin()
	{
        return  \Auth::user()->pegawai->history_jabatan->where('status','active')->first()->id_skpd;
	}


    public function ShowSasaranSkpd()
	{

        $user                   = \Auth::user();
       
									
		//CARI Nama
        $skpd       = SKPD::where('id_skpd', $this->id_skpd_admin() )->first()->unit_kerja;
       
	   
      return view('pare_pns.pages.skpd-sasaran', [
                'nama_skpd'  => $skpd,
                'id_skpd'    => $this->id_skpd_admin(),
        		'user' 		 => $user
	  			]
        );  
    }

   /*  public function PerjanjianKinerjaIndikatorSasaran($x)
	{

        $user                   = \Auth::user();
       							
		//CARI Nama
        $skpd       = SKPD::where('id_skpd', $this->id_skpd_admin() )->first()->unit_kerja;
       
        //DETAIL PerJanjian KInerja
		$perjanjian_kinerja	= PerjanjianKinerja::where('id', '=', $x)->firstOrFail();
       
        
        
        return view('pare_pns.pages.skpd-perjanjian_kinerja_sasaran', [
                'nama_skpd'         => $skpd,
                'id_skpd'           => $this->id_skpd_admin(),
                'perjanjian_kinerja'=> $perjanjian_kinerja,
        		'user' 		        => $user
	  			]
        );   
        
    } */


    public function DataSasaranSkpd(Request $request)
    {
            
        
      
		
        \DB::statement(\DB::raw('set @rownum='.$request->get('start')));
        //\DB::statement(\DB::raw('set @rownum=0'));
      
        $dt = \DB::table('db_pare_2018.sasaran AS sasaran')
				->where('sasaran.skpd_id', '=',  $this->id_skpd_admin() )
				->leftjoin('db_pare_2018.periode_tahunan AS periode', 'periode.id','=','sasaran.periode_tahunan_id')
				->select([   
                           
                            \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                            'sasaran.id AS sasaran_id',
                            'sasaran.label AS label',
							'periode.label AS thn_anggaran',
							'sasaran.total_anggaran AS total_anggaran'
							
						]);
        



        $datatables = Datatables::of($dt)
        ->addColumn('action', function ($x) {
			return 		'<a href="sasaran/'.$x->sasaran_id.'" class="btn btn-xs btn-primary" style="margin:2px;"><i class="fa fa-eye"></i> Lihat </a>';
		})->addColumn('label', function ($x) {
            
            return $x->label;
        
        })->addColumn('total_anggaran', function ($x) {
            
            return number_format($x->total_anggaran,0);
        
        
        });

        
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true);

        
    }

   

    public function AddIndikatorSkpd($id)
	{

        $user                   = \Auth::user();
        
									
		//CARI Nama
        $skpd       = SKPD::where('id_skpd', $this->id_skpd_admin() )->first()->unit_kerja;
       
	   
      return view('pare_pns.pages.add-indikator-sasaran', [
                'nama_skpd'  => $skpd,
                'id_skpd'    => $this->id_skpd_admin(),
        		'user' 		 => $user
	  			]
        );  
    }


    

}
