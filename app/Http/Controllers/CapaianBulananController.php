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


use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class CapaianBulananController extends Controller {


    public function CapaianBulananApprovalRequestList(Request $request)
	{
        
        $user      = \Auth::user();
        $pegawai   = $user->pegawai;       
        

        return view('pare_pns.pages.approval_request-capaian_bulanan', [
               'pegawai' 		        => $pegawai,
               'nama_skpd'     	        => 'x',
               'h_box'                  => 'box-teal',
               
           ]
        );   

    }

    public function CapaianBulananApprovalRequest(Request $request)
	{

        $user               = \Auth::user();
        $capaian_bulanan    = CapaianBulanan::WHERE('id', $request->capaian_bulanan_id)->first();
        

        
        //hanya atasan yang bisa approve
        if ( $capaian_bulanan->PejabatPenilai->id_pegawai == $user->id_pegawai ){
            return view('pare_pns.pages.personal-capaian_bulanan_approvement', ['capaian'=> $capaian_bulanan]);
        }else{
            return redirect('/dashboard');
        }
        /* if ( $capaian_bulanan->status_approve != '0' ){
            return redirect('/personal/capaian-bulanan/'.$request->capaian_bulanan_id)->with('status', 'telah diterima/ditolak');
        }else{ */
            // view('pare_pns.pages.personal-capaian_bulanan_approvement', ['capaian'=> $capaian_bulanan]);
        //}
        

    }



    public function PersonalCapaianBulananEdit(Request $request)
	{
        $user           = \Auth::user();
        $capaian_bulanan    = CapaianBulanan::WHERE('id', $request->capaian_bulanan_id)->first();

        //hanya user ysb yang bisa buka skp tahunan tsb
        if ( $capaian_bulanan->pegawai_id == $user->id_pegawai ){

            if ( $capaian_bulanan->send_to_atasan != '0' ){
                return redirect('/personal/capaian-bulanan/'.$request->capaian_bulanan_id)->with('status', 'terkirim');
            }else{
                return view('pare_pns.pages.personal-capaian_bulanan_edit', ['capaian'=> $capaian_bulanan]);  
            } 
        }else{
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
                return view('pare_pns.pages.personal-capaian_bulanan_edit', ['capaian'=> $capaian_bulanan]);  
            }
        }else{
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
                return view('pare_pns.pages.personal-capaian_bulanan_detail', ['capaian'=> $capaian_bulanan]);  
            }
        }else{
            return redirect('/dashboard');
        }

          

    }

}
