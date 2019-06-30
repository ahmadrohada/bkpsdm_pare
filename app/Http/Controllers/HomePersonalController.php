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

class HomePersonalController extends Controller {
    
    

    //=======================================================================================//
    protected function nama_skpd($skpd_id){
            //nama SKPD 
            $nama_skpd       = \DB::table('demo_asn.m_skpd AS skpd')
                            ->WHERE('id',$skpd_id)
                            ->SELECT(['skpd.skpd AS skpd'])
                            ->first();
            return $nama_skpd->skpd;
    }

    
    

    public function showDashboard(Request $request)
    {
        $user      = \Auth::user();
        $pegawai   = $user->pegawai;       
        

        return view('admin.pages.personal-home', [
               'pegawai' 		        => $pegawai,
               'nama_pegawai'     	    => Pustaka::nama_pegawai($pegawai->gelardpn , $pegawai->nama , $pegawai->gelarblk),
               'h_box'                  => 'box-info',
               
           ]
        );   

        
    }


    public function showSKPJabatan(Request $request)
    {
        $user      = \Auth::user();
        $pegawai   = $user->pegawai;       
        

        return view('admin.pages.personal-home-skp', [
               'pegawai' 		        => $pegawai,
               'nama_pegawai'     	    => Pustaka::nama_pegawai($pegawai->gelardpn , $pegawai->nama , $pegawai->gelarblk),
               'h_box'                  => 'box-danger',
               
           ]
        );   

        
    }

    public function showSKPTahunan(Request $request)
    {
        $user      = \Auth::user();
        $pegawai   = $user->pegawai;       
        

        return view('admin.pages.personal-home-skp_tahunan', [
               'pegawai' 		        => $pegawai,
               'nama_pegawai'     	    => Pustaka::nama_pegawai($pegawai->gelardpn , $pegawai->nama , $pegawai->gelarblk),
               'h_box'                  => 'box-warning',
               
           ]
        );   

        
    }


    public function showSKPBulanan(Request $request)
    {
        $user      = \Auth::user();
        $pegawai   = $user->pegawai;       
        

        return view('admin.pages.personal-home-skp_bulanan', [
               'pegawai' 		        => $pegawai,
               'nama_pegawai'     	    => Pustaka::nama_pegawai($pegawai->gelardpn , $pegawai->nama , $pegawai->gelarblk),
               'h_box'                  => 'box-info',
               
           ]
        );   

        
    }


    public function showCapaianBulanan(Request $request)
    {
        $user      = \Auth::user();
        $pegawai   = $user->pegawai;       
        

        return view('admin.pages.personal-home-capaian_bulanan', [
               //'pegawai' 		        => $pegawai,
               'nama_pegawai'     	    => Pustaka::nama_pegawai($pegawai->gelardpn , $pegawai->nama , $pegawai->gelarblk),
               'h_box'                  => 'box-warning',
               
           ]
        );   

        
    }

}
