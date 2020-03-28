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


use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class CapaianTahunanController extends Controller {


    public function CapaianTahunanApprovalRequestList(Request $request)
	{
        
        $user      = \Auth::user();
        $pegawai   = $user->pegawai;       
        

        return view('admin.pages.approval_request-capaian_tahunan', [
               'pegawai' 		        => $pegawai,
               'nama_skpd'     	        => 'x',
               'h_box'                  => 'box-purple',
               
           ]
        );   

    }

    public function CapaianTahunanApprovalRequest(Request $request)
	{
        $capaian_tahunan    = CapaianTahunan::WHERE('id', $request->capaian_tahunan_id)->first();
        
      /*   if ( $capaian_tahunan->status_approve != '0' ){
            return redirect('/personal/capaian-tahunan/'.$request->capaian_tahunan_id)->with('status', 'telah diterima/ditolak');
        }else{ */
            return view('admin.pages.personal-capaian_tahunan_approvement', ['capaian'=> $capaian_tahunan]);
       // }
        

    }



    public function PersonalCapaianTahunanEdit(Request $request)
	{
        
        $capaian_tahunan    = CapaianTahunan::WHERE('id', $request->capaian_tahunan_id)->first();

        if ( $capaian_tahunan->send_to_atasan != '0' ){
            return redirect('/personal/capaian-tahunan/'.$request->capaian_tahunan_id)->with('status', 'terkirim');
        }else{
            return view('admin.pages.personal-capaian_tahunan_edit', ['capaian'=> $capaian_tahunan]);  
        }

          

    }

    public function PersonalCapaianTahunanRalat(Request $request)
	{
        
        $capaian_tahunan    = CapaianTahunan::WHERE('id', $request->capaian_tahunan_id)->first();

        if ( $capaian_tahunan->status_approve != '2' ){
            return redirect('/personal/capaian-tahunan/'.$request->capaian_tahunan_id)->with('status', 'terkirim');
        }else{
            return view('admin.pages.personal-capaian_tahunan_edit', ['capaian'=> $capaian_tahunan]);  
        }

          

    }

    public function PersonalCapaianTahunanDetail(Request $request)
	{
        
        $capaian_tahunan    = CapaianTahunan::WHERE('id', $request->capaian_tahunan_id)->first();

        if ( $capaian_tahunan->send_to_atasan == '0' ){
            return redirect('/personal/capaian-tahunan/'.$request->capaian_tahunan_id.'/edit')->with('status', 'terkirim');
        }else{
            return view('admin.pages.personal-capaian_tahunan_detail', ['capaian'=> $capaian_tahunan]);  
        }

          

    }

}
