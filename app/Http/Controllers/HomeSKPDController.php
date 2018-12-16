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

class HomeSKPDController extends Controller {
    
    

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
        

        //CARI id skpd nya
       $skpd_id    = $user->pegawai->history_jabatan->where('status','active')->first()->id_skpd;
       

       return view('admin.pages.skpd-home-pegawai', [
               //'users' 		          => $users,
               'skpd_id'                 => $skpd_id,
               'nama_skpd'     	      => $this->nama_skpd($skpd_id),
               'total_pegawai' 	      => $this->total_pegawai_skpd($skpd_id),
               'total_unit_kerja' 	      => $this->total_unit_kerja($skpd_id),
               'total_jabatan'           => 'x',
               'total_renja'             => 'x',
               'h_box'                   => 'box-info',
               
           ]
       );  

        
    }
    
    public function showUnitKerja(Request $request)
    {
            
        $skpd_id      = \Auth::user()->pegawai->history_jabatan->where('status','active')->first()->id_skpd;

        
         

		return view('admin.pages.skpd-home-unit_kerja', [
                //'users' 		          => $users,
                'skpd_id'                 => $skpd_id,
                'nama_skpd'     	      => $this->nama_skpd($skpd_id),
                'total_pegawai' 	      => $this->total_pegawai_skpd($skpd_id),
                'total_unit_kerja' 	      => $this->total_unit_kerja($skpd_id),
                'total_jabatan'           => 'x',
                'total_renja'             => 'x',
                'h_box'                   => 'box-danger',
                
        	]
        );   

        
    }

    public function showRenja(Request $request)
    {
            
        
        $user                   = \Auth::user();
        

        //CARI id skpd nya
        $skpd_id    = $user->pegawai->history_jabatan->where('status','active')->first()->id_skpd;
       

        return view('admin.pages.skpd-home-renja', [
               //'users' 		         => $users,
               'skpd_id'                => $skpd_id,
               'nama_skpd'     	        => $this->nama_skpd($skpd_id),
               'total_pegawai' 	        => $this->total_pegawai_skpd($skpd_id),
               'total_unit_kerja' 	    => $this->total_unit_kerja($skpd_id),
               'total_jabatan'          => 'x',
               'total_renja'            => 'x',
               'h_box'                  => 'box-warning',
               
           ]
        );   

        
    }

    public function ShowPetaJabatan(Request $request)
    {
            

        $user                   = \Auth::user();
        

        //CARI id skpd nya
        $skpd_id    = $user->pegawai->history_jabatan->where('status','active')->first()->id_skpd;
       

        return view('admin.pages.skpd-home-peta_jabatan', [
               //'users' 		         => $users,
               'skpd_id'                => $skpd_id,
               'nama_skpd'     	        => $this->nama_skpd($skpd_id),
               'total_pegawai' 	        => $this->total_pegawai_skpd($skpd_id),
               'total_unit_kerja' 	    => $this->total_unit_kerja($skpd_id),
               'total_jabatan'          => 'x',
               'total_renja'            => 'x',
               'h_box'                  => 'box-success',
               
           ]
        ); 
        
    }

    public function ShowStrukturOrganisasi(Request $request)
    {
            

        $user                   = \Auth::user();
        

        //CARI id skpd nya
        $skpd_id    = $user->pegawai->history_jabatan->where('status','active')->first()->id_skpd;
       

        return view('admin.pages.skpd-home-struktur_organisasi', [
               //'users' 		         => $users,
               'skpd_id'                => $skpd_id,
               'nama_skpd'     	        => $this->nama_skpd($skpd_id),
               'total_pegawai' 	        => $this->total_pegawai_skpd($skpd_id),
               'total_unit_kerja' 	    => $this->total_unit_kerja($skpd_id),
               'total_jabatan'          => 'x',
               'total_renja'            => 'x',
               'h_box'                  => 'box-danger',
               
           ]
        ); 
        
    }

    
}
