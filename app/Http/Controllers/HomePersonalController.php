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


use App\Models\SKPTahunan;
use App\Models\SKPBulanan;
use App\Models\CapaianBulanan;
use App\Models\CapaianTriwulan;
use App\Models\CapaianTahunan;



use App\Helpers\Pustaka;
use Illuminate\Http\Request;



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

    protected function jm_skp_tahunan($pegawai_id){
        $data       = SKPTahunan::WHERE('pegawai_id',$pegawai_id)->count();
        return $data;
    }
    protected function jm_skp_bulanan($pegawai_id){
        $data       = SKPBulanan::WHERE('pegawai_id',$pegawai_id)->count();
        return $data;
    }

    protected function jm_capaian_bulanan($pegawai_id){
        $data       = CapaianBulanan::WHERE('pegawai_id',$pegawai_id)->count();
        return $data;
    }

    protected function jm_capaian_triwulan($pegawai_id){
        $data       = CapaianTriwulan::WHERE('pegawai_id',$pegawai_id)->count();
        return $data;
    }

    protected function jm_capaian_tahunan($pegawai_id){
        $data       = CapaianTahunan::WHERE('pegawai_id',$pegawai_id)->count();
        return $data;
    }

    
    public function showHomePersonal(Request $request)
    {
        $user      = \Auth::user();
        $pegawai   = $user->pegawai;       
        

        return view('pare_pns.pages.personal-home', [
               'pegawai' 		        => $pegawai,
               'nama_pegawai'     	    => Pustaka::nama_pegawai($pegawai->gelardpn , $pegawai->nama , $pegawai->gelarblk),
               'jm_skp_tahunan'         => $this->jm_skp_tahunan($pegawai->id),
               'jm_skp_bulanan'         => $this->jm_skp_bulanan($pegawai->id),
               'h_box'                  => 'box-info',
               
               
           ]
        );   
    }

    public function showDashboard(Request $request)
    {
        $user      = \Auth::user();
        $pegawai   = $user->pegawai;       
        

        return view('pare_pns.pages.personal-home', [
               'pegawai' 		        => $pegawai,
               'nama_pegawai'     	    => Pustaka::nama_pegawai($pegawai->gelardpn , $pegawai->nama , $pegawai->gelarblk),
               'jm_skp_tahunan'         => $this->jm_skp_tahunan($pegawai->id),
               'jm_skp_bulanan'         => $this->jm_skp_bulanan($pegawai->id),
               'h_box'                  => 'box-info',
               
           ]
        );   

        
    }


    public function showSKPJabatan(Request $request)
    {
        $user      = \Auth::user();
        $pegawai   = $user->pegawai;       
        

        return view('pare_pns.pages.personal-home-skp', [
               'pegawai' 		        => $pegawai,
               'nama_pegawai'     	    => Pustaka::nama_pegawai($pegawai->gelardpn , $pegawai->nama , $pegawai->gelarblk),
               'jm_skp_tahunan'         => $this->jm_skp_tahunan($pegawai->id),
               'jm_skp_bulanan'         => $this->jm_skp_bulanan($pegawai->id),
               'h_box'                  => 'box-teal',
               
           ]
        );   

        
    }

    public function showSKPTahunan(Request $request)
    {
        $user      = \Auth::user();
        $pegawai   = $user->pegawai;       
        

        return view('pare_pns.pages.personal-home-skp_tahunan', [
               'pegawai' 		        => $pegawai,
               'nama_pegawai'     	    => Pustaka::nama_pegawai($pegawai->gelardpn , $pegawai->nama , $pegawai->gelarblk),
               'jm_skp_tahunan'         => $this->jm_skp_tahunan($pegawai->id),
               'jm_skp_bulanan'         => $this->jm_skp_bulanan($pegawai->id),
               'h_box'                  => 'box-red',
               
           ]
        );   

        
    }


    public function showSKPBulanan(Request $request)
    {
        $user      = \Auth::user();
        $pegawai   = $user->pegawai;       
        

        return view('pare_pns.pages.personal-home-skp_bulanan', [
               'pegawai' 		        => $pegawai,
               'nama_pegawai'     	    => Pustaka::nama_pegawai($pegawai->gelardpn , $pegawai->nama , $pegawai->gelarblk),
               'jm_skp_tahunan'         => $this->jm_skp_tahunan($pegawai->id),
               'jm_skp_bulanan'         => $this->jm_skp_bulanan($pegawai->id),
               'h_box'                  => 'box-green',
               
           ]
        );   

        
    }


    public function showCapaianBulanan(Request $request)
    {
        $user      = \Auth::user();
        $pegawai   = $user->pegawai;       
        

        return view('pare_pns.pages.personal-home-capaian_bulanan', [
               'pegawai' 		        => $pegawai,
               'nama_pegawai'     	    => Pustaka::nama_pegawai($pegawai->gelardpn , $pegawai->nama , $pegawai->gelarblk),
               'jm_capaian_bulanan'     => $this->jm_capaian_bulanan($pegawai->id),
               'jm_capaian_triwulan'    => $this->jm_capaian_triwulan($pegawai->id),
               'jm_capaian_tahunan'     => $this->jm_capaian_tahunan($pegawai->id),
               'h_box'                  => 'box-warning',
               
           ]
        );   

        
    }

    public function showCapaianTriwulan(Request $request)
    {
        $user      = \Auth::user();
        $pegawai   = $user->pegawai;       
        

        return view('pare_pns.pages.personal-home-capaian_triwulan', [
               'pegawai' 		        => $pegawai,
               'nama_pegawai'     	    => Pustaka::nama_pegawai($pegawai->gelardpn , $pegawai->nama , $pegawai->gelarblk),
               'jm_capaian_bulanan'     => $this->jm_capaian_bulanan($pegawai->id),
               'jm_capaian_triwulan'    => $this->jm_capaian_triwulan($pegawai->id),
               'jm_capaian_tahunan'     => $this->jm_capaian_tahunan($pegawai->id),
               'h_box'                  => 'box-info',
               
           ]
        );   

        
    }

    public function showCapaianTahunan(Request $request)
    {
        $user      = \Auth::user();
        $pegawai   = $user->pegawai;       
        

        return view('pare_pns.pages.personal-home-capaian_tahunan', [
               'pegawai' 		        => $pegawai,
               'nama_pegawai'     	    => Pustaka::nama_pegawai($pegawai->gelardpn , $pegawai->nama , $pegawai->gelarblk),
               'jm_capaian_bulanan'     => $this->jm_capaian_bulanan($pegawai->id),
               'jm_capaian_triwulan'    => $this->jm_capaian_triwulan($pegawai->id),
               'jm_capaian_tahunan'     => $this->jm_capaian_tahunan($pegawai->id),
               'h_box'                  => 'box-danger',
               
           ]
        );   

        
    }

    public function showCapaianGabungan(Request $request)
    {
        $user      = \Auth::user();
        $pegawai   = $user->pegawai;       
        

        return view('pare_pns.pages.personal-home-capaian_gabungan', [
               'pegawai' 		        => $pegawai,
               'nama_pegawai'     	    => Pustaka::nama_pegawai($pegawai->gelardpn , $pegawai->nama , $pegawai->gelarblk),
               'jm_capaian_bulanan'     => $this->jm_capaian_bulanan($pegawai->id),
               'jm_capaian_triwulan'    => $this->jm_capaian_triwulan($pegawai->id),
               'jm_capaian_tahunan'     => $this->jm_capaian_tahunan($pegawai->id),
               'jm_capaian_gabungan'    => "*",
               'h_box'                  => 'box-green',
               
           ]
        );   

        
    }


    public function showTPP(Request $request)
    {
        $user      = \Auth::user();
        $pegawai   = $user->pegawai;       
        

        return view('pare_pns.pages.personal-home-tpp', [
               'pegawai' 		        => $pegawai,
               'nama_pegawai'     	    => Pustaka::nama_pegawai($pegawai->gelardpn , $pegawai->nama , $pegawai->gelarblk),
               'jm_capaian_bulanan'     => $this->jm_capaian_bulanan($pegawai->id),
               'jm_capaian_triwulan'    => $this->jm_capaian_triwulan($pegawai->id),
               'jm_capaian_tahunan'     => $this->jm_capaian_tahunan($pegawai->id),
               'h_box'                  => 'box-maroon',
               
           ]
        );   

        
    }

}
