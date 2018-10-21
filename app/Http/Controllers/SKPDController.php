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

class SKPDController extends Controller {
    
    
    protected function total_pegawai(){
        return 	Pegawai::WHERE('status','active')->WHERE('nip','!=','admin')->count();
    }
    
    protected function total_users(){
        return 	\DB::table('db_pare_2018.users AS users')
                                ->leftjoin('demo_asn.tb_pegawai AS pegawai', function($join){
                                    $join   ->on('users.id_pegawai','=','pegawai.id');
                                    $join   ->where('pegawai.status','=', 'active');
                                })
                                ->leftjoin('demo_asn.tb_history_jabatan AS a', function($join){
                                    $join   ->on('a.id_pegawai','=','pegawai.id');
                                    $join   ->where('a.status','=', 'active');
                                })->count();
    }
    

    protected function total_skpd()
	{
       return SKPD::whereRaw('id = id_skpd AND id != 1 AND id != 6 AND id != 8 AND id != 10 AND id != 12 ')
                ->count();  
       
               
	}

    public function showSKPDAdministrator(Request $request)
    {
            
        
        $user                   = \Auth::user();
        $users 			        = \DB::table('users')->get();

        
        
        $attemptsAllowed        = 4;

        $total_users_confirmed  = $this->total_users();
        $total_users_locked 	= 67;


        $total_users_new        = 78;


        $userRole               = $user->hasRole('user');
        $admin_skpdRole         = $user->hasRole('admin_skpd');
        $adminRole              = $user->hasRole('administrator');

        if($userRole)
        {
            $access = 'User';
        } elseif ($admin_skpdRole) {
            $access = 'Admin Skpd';
        } elseif ($adminRole) {
            $access = 'Administrator';
        }


         //CARI id skpd nya
        $id_skpd    = $user->pegawai->history_jabatan->where('status','active')->first()->id_skpd;
        $skpd       = Skpd::where('id_skpd', $id_skpd)->first()->unit_kerja;
       
       

		return view('admin.pages.administrator-show-skpd', [
                'users' 		          => $users,
                'total_pegawai' 	      => $this->total_pegawai(),
                'total_users' 	          => $this->total_users(),
                'total_skpd'              => $this->total_skpd(),
				'nama_skpd' 	          => $skpd,
        		'user' 			          => $user,
        		'access' 	              => $access,
                'total_users_confirmed'   => $total_users_confirmed,
                'total_users_locked'      => $total_users_locked,
                'total_users_new'         => $total_users_new,
        	]
        );   

        
    }

    
}
