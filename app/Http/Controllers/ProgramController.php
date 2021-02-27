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
use App\Models\Sasaran;
use App\Models\IndikatorSasaran;
use App\Models\Program;
use App\Models\Periode;
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

class ProgramController extends Controller {


	
    

    public function DataProgram(Request $request)
    {
            
        
        $id_skpd_admin      = \Auth::user()->pegawai->history_jabatan->where('status','active')->first()->id_skpd;

		
        \DB::statement(\DB::raw('set @rownum='.$request->get('start')));
        //\DB::statement(\DB::raw('set @rownum=0'));
      
	  
		$indikator_sasaran_id = $_GET['indikator_sasaran_id'];
	  
        $dt = \DB::table('db_pare_2018.program AS program')
				->where('program.indikator_sasaran_id', '=',  $indikator_sasaran_id)
				->select([   
                           
                            \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                            'program.id AS program_id',
                            'program.label AS label',
							
						]);
        



        $datatables = Datatables::of($dt)
        ->addColumn('action', function ($x) {
			return 		'<a href="../program/'.$x->program_id.'" class="btn btn-xs btn-primary" style="margin:2px;"><i class="fa fa-eye"></i> Lihat </a>';
		})->addColumn('label', function ($x) {
            
            return $x->label;
        
        });

        
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true);

        
    }

   
	public function DetailProgram($id)
	{

        $user                   = \Auth::user();
        $id_skpd_admin          = \Auth::user()->pegawai->history_jabatan->where('status','active')->first()->id_skpd;
		
									
		//CARI Nama
        $skpd       = SKPD::where('id_skpd', $id_skpd_admin)->first()->unit_kerja;
		
		//DETAIL SASARAN
		$program	= Program::where('id', '=', $id)->firstOrFail();
       
	   
      return view('pare_pns.pages.skpd-indikator-sasaran-detail', [
                'nama_skpd'  		=> $skpd,
                'id_skpd'    		=> $id_skpd_admin,
        		'user' 		 		=> $user,
				'program'			=> $program,
	  			]
        );  
    }

}
