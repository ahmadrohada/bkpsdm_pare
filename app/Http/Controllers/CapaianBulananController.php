<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Logic\User\UserRepository;
use App\Logic\User\CaptureIp;
use App\Http\Requests;

use App\Models\User;
use App\Models\Role;
use App\Models\Skpd;
use App\Models\Periode;
use App\Models\Renja;
use App\Models\SKPTahunan;
use App\Models\SKPBulanan;
use App\Models\CapaianBulanan;
use App\Models\CapaianTahunan;


use App\Models\Jabatan;

use App\Helpers\Pustaka;

use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;

use App\Traits\PJabatan;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class CapaianBulananController extends Controller {

    use PJabatan; 


    protected function jm_approval_request_cap_bulanan($jabatan_id){
        $data_1 = CapaianBulanan::rightjoin('demo_asn.tb_history_jabatan AS atasan', function($join) use($jabatan_id){
                                    $join   ->on('atasan.id','=','capaian_bulanan.p_jabatan_id');
                                    $join   ->where('atasan.id_pegawai','=',$jabatan_id);
                                }) 
                                ->WHERE('capaian_bulanan.send_to_atasan','=','1')
                                ->WHERE('capaian_bulanan.status_approve','=','0')
                                ->count();
        $data_2 = CapaianBulanan::rightjoin('demo_asn.tb_history_jabatan AS atasan', function($join) use($jabatan_id){
                                    $join   ->on('atasan.id','=','capaian_bulanan.p_jabatan_id');
                                    $join   ->where('atasan.id_pegawai','=',$jabatan_id);
                                }) 
                                ->WHERE('capaian_bulanan.send_to_atasan','=','1')
                                ->count();
        return $data_1.' / '.$data_2;
    }

    protected function jm_approval_request_cap_tahunan($jabatan_id){
        $data_1 = CapaianTahunan::rightjoin('demo_asn.tb_history_jabatan AS atasan', function($join) use($jabatan_id){
                                    $join   ->on('atasan.id','=','capaian_tahunan.p_jabatan_id');
                                    $join   ->where('atasan.id_pegawai','=',$jabatan_id);
                                }) 
                                ->WHERE('capaian_tahunan.send_to_atasan','=','1')
                                ->WHERE('status_approve','=','0')
                                ->count();
        $data_2 = CapaianTahunan::rightjoin('demo_asn.tb_history_jabatan AS atasan', function($join) use($jabatan_id){
                                    $join   ->on('atasan.id','=','capaian_tahunan.p_jabatan_id');
                                    $join   ->where('atasan.id_pegawai','=',$jabatan_id);
                                }) 
                                ->WHERE('capaian_tahunan.send_to_atasan','=','1')
                                ->count();
        return $data_1.' / '.$data_2;
    }

    public function CapaianBulananBawahanList(Request $request)
	{
        
        $user      = \Auth::user();
        $pegawai   = $user->pegawai;       
        //return $pegawai->JabatanAktif->Eselon->id_jenis_jabatan;

        if ( $pegawai->JabatanAktif->Eselon->id_jenis_jabatan <= 3 ) {
            return view('pare_pns.pages.bawahan-capaian_bulanan', [
                    'pegawai' 		             => $pegawai,
                    'nama_skpd'     	         => 'x',
                    'h_box'                      => 'box-teal',
                    'capaian_tahunan_app_req'    => $this->jm_approval_request_cap_tahunan($pegawai->id),
                    'capaian_bulanan_app_req'    => $this->jm_approval_request_cap_bulanan($pegawai->id),
                    
                ]);   
        }else{
            //return view('pare_pns.errors.users403');
            return redirect('/dashboard');
        } 
       

    }

    public function CapaianBulananBawahanApprovement(Request $request)
	{

        $user               = \Auth::user();
        $capaian_bulanan    = CapaianBulanan::WHERE('id', $request->capaian_bulanan_id)->first();
        

        
        //hanya atasan yang bisa approve
        if ( $capaian_bulanan->PejabatPenilai->id_pegawai == $user->id_pegawai ){
            return view('pare_pns.pages.personal-capaian_bulanan_approvement', ['capaian'                   => $capaian_bulanan,
                                                                                'jabatan_sekda'             => $this->jenis_PJabatan('sekda'),
                                                                                'jabatan_irban'             => $this->jenis_PJabatan('irban'),
                                                                                'jabatan_lurah'             => $this->jenis_PJabatan('lurah'),
                                                                                'jabatan_staf_ahli'         => $this->jenis_PJabatan('jabatan_staf_ahli'),
                                                                                ]);
        }else{
           //return view('pare_pns.errors.users403');
           return redirect('/dashboard');
        }
    }


    public function CapaianBulananBawahanDetail(Request $request)
	{
        $user               = \Auth::user();
        $capaian_bulanan    = CapaianBulanan::WHERE('id', $request->capaian_bulanan_id)->first();
        //hanya atasan yang bisa lhat detai capaian bahwan nya
        if ( $capaian_bulanan->PejabatPenilai->id_pegawai == $user->id_pegawai ){
            return view('pare_pns.pages.personal-capaian_bulanan_detail', ['capaian'=> $capaian_bulanan,
                                                                            'jabatan_sekda'     => $this->jenis_PJabatan('sekda'),
                                                                            'jabatan_irban'     => $this->jenis_PJabatan('irban'),
                                                                            'jabatan_lurah'     => $this->jenis_PJabatan('lurah'),
                                                                            'jabatan_staf_ahli' => $this->jenis_PJabatan('jabatan_staf_ahli'),]); 
        }else{
            //return view('pare_pns.errors.users403');
            return redirect('/dashboard');
        }
    }



//========================= PERSONAL =============================================================================================================//


    public function PersonalCapaianBulananEdit(Request $request)
	{
        $user           = \Auth::user();
        $capaian_bulanan    = CapaianBulanan::WHERE('id', $request->capaian_bulanan_id)->first();

        //hanya user ysb yang bisa buka skp tahunan tsb
        if ( $capaian_bulanan->pegawai_id == $user->id_pegawai ){

            if ( $capaian_bulanan->send_to_atasan != '0' ){
                return redirect('/personal/capaian-bulanan/'.$request->capaian_bulanan_id)->with('status', 'terkirim');
            }else{
                return view('pare_pns.pages.personal-capaian_bulanan_edit', ['capaian'=> $capaian_bulanan,
                                                                            'jabatan_sekda'     => $this->jenis_PJabatan('sekda'),
                                                                            'jabatan_irban'     => $this->jenis_PJabatan('irban'),
                                                                            'jabatan_lurah'     => $this->jenis_PJabatan('lurah'),
                                                                            'jabatan_staf_ahli' => $this->jenis_PJabatan('jabatan_staf_ahli'),]);  
            } 
        }else{
            //return view('pare_pns.errors.users403');
            return redirect('/dashboard');
        }
          

    }

    public function PersonalCapaianBulananRalat(Request $request)
	{
        $user               = \Auth::user();
        $capaian_bulanan    = CapaianBulanan::WHERE('id', $request->capaian_bulanan_id)->first();

        //hanya user ysb yang bisa buka cap bln tsb
        if ( $capaian_bulanan->pegawai_id == $user->id_pegawai ){
            if ( $capaian_bulanan->status_approve != '2' ){
                return redirect('/personal/capaian-bulanan/'.$request->capaian_bulanan_id)->with('status', 'terkirim');
            }else{
                return view('pare_pns.pages.personal-capaian_bulanan_edit', ['capaian'=> $capaian_bulanan,
                                                                            'jabatan_sekda'     => $this->jenis_PJabatan('sekda'),
                                                                            'jabatan_irban'     => $this->jenis_PJabatan('irban'),
                                                                            'jabatan_lurah'     => $this->jenis_PJabatan('lurah'),
                                                                            'jabatan_staf_ahli' => $this->jenis_PJabatan('jabatan_staf_ahli'),]);  
            }
        }else{
            //return view('pare_pns.errors.users403');
            return redirect('/dashboard');
        }

          

    }

    public function PersonalCapaianBulananDetail(Request $request)
	{
        
        $user               = \Auth::user();
        $capaian_bulanan    = CapaianBulanan::WHERE('id', $request->capaian_bulanan_id)->first();

        //hanya user ysb yang bisa buka cap bln tsb
        if ( $capaian_bulanan->pegawai_id == $user->id_pegawai ){
            if ( $capaian_bulanan->send_to_atasan == '0' ){
                return redirect('/personal/capaian-bulanan/'.$request->capaian_bulanan_id.'/edit')->with('status', 'terkirim');
            }else{
                return view('pare_pns.pages.personal-capaian_bulanan_detail', ['capaian'=> $capaian_bulanan,
                                                                                'jabatan_sekda'     => $this->jenis_PJabatan('sekda'),
                                                                                'jabatan_irban'     => $this->jenis_PJabatan('irban'),
                                                                                'jabatan_lurah'     => $this->jenis_PJabatan('lurah'),
                                                                                'jabatan_staf_ahli' => $this->jenis_PJabatan('jabatan_staf_ahli'),]);  
            }
        }else{
            //return view('pare_pns.errors.users403');
            return redirect('/dashboard');
        }

          

    }

}
