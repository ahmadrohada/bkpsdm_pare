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
use App\Models\RencanaKerja;
use App\Models\PetaJabatan;



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

class HomeAdminController extends Controller {
    
    

    //=======================================================================================//
    protected function nama_skpd($skpd_id){
        //nama SKPD 
        $nama_skpd       = \DB::table('demo_asn.m_skpd AS skpd')
                        ->WHERE('id',$skpd_id)
                        ->SELECT(['skpd.skpd AS skpd'])
                        ->first();
        return $nama_skpd->skpd;
    }

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


    protected function total_pegawai_skpd( $skpd_id){
        
        return 	Pegawai::rightjoin('demo_asn.tb_history_jabatan AS a', function($join){
                                            $join   ->on('a.id_pegawai','=','tb_pegawai.id');
                                            $join   ->where('a.status','=', 'active');
                                    })
                                    ->WHERE('a.id_skpd','=', $skpd_id)
                                    ->WHERE('tb_pegawai.nip','!=','admin')
                                    ->WHERE('tb_pegawai.status','active')
                                    ->count();
    }


    protected function total_unit_kerja( $skpd_id){
        
        return 	SKPD::WHERE('m_skpd.parent_id','=', $skpd_id)
                                    ->rightjoin('demo_asn.m_skpd AS a', function($join){
                                        $join   ->on('a.parent_id','=','m_skpd.id');
                                    })
                                    ->count();
    }





    protected function total_skpd()
    {
    return SKPD::whereRaw('id = id_skpd AND id != 1 AND id != 6 AND id != 8 AND id != 10 AND id != 12 ')
                ->count();  
    
            
    }


    public function showPegawai(Request $request)
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
       
       

		return view('admin.pages.administrator-pegawai', [
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
                'h_box'                   => 'box-info',
        	]
        );   

        
    }


    public function showUser(Request $request)
    {
            
        
        $user                   = \Auth::user();
        $users 			        = \DB::table('users')->get();

       
        $attemptsAllowed        = 4;

        $total_users_confirmed  = $this->total_users();
        $total_users_locked 	= 0;


        $total_users_new        = 0;


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
       
       

		return view('admin.pages.administrator-users', [
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
                'h_box'                   => 'box-success',
        	]
        );   

        
    }

    public function showSKPD(Request $request)
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
        $skpd_id    = $user->pegawai->history_jabatan->where('status','active')->first()->id_skpd;
       
		return view('admin.pages.administrator-skpd', [
                'users' 		          => $users,
                'total_pegawai' 	      => $this->total_pegawai(),
                'total_users' 	          => $this->total_users(),
                'total_skpd'              => $this->total_skpd(),
				'nama_skpd' 	          => $this->nama_skpd($skpd_id),
        		'user' 			          => $user,
        		'access' 	              => $access,
                'total_users_confirmed'   => $total_users_confirmed,
                'total_users_locked'      => $total_users_locked,
                'total_users_new'         => $total_users_new,
                'h_box'                   => 'box-danger',
        	]
        );   

        
    }
   
    
}
