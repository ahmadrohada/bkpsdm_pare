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
use App\Models\Kegiatan;


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

class SKPTahunanController extends Controller {

    public function AdministratorSKPTahunanDetail(Request $request)
	{
        $skp_tahunan    = SKPTahunan::WHERE('id', $request->skp_tahunan_id)->first();

        
        return view('pare_pns.pages.personal-skp_tahunan_detail', ['skp'=> $skp_tahunan,'role' =>'admin']);  
       
    }

    public function SKPDSKPTahunanDetail(Request $request)
	{
        $skp_tahunan    = SKPTahunan::WHERE('id', $request->skp_tahunan_id)->first();

        
        return view('pare_pns.pages.personal-skp_tahunan_detail', ['skp'=> $skp_tahunan , 'role' =>'skpd']);  
       
    }

    public function PersonalSKPTahunanDetail(Request $request)
	{
        $user           = \Auth::user();
        $skp_tahunan    = SKPTahunan::WHERE('id', $request->skp_tahunan_id)->first();

        //hanya user ysb yang bisa buka skp tahunan tsb
        if ( $skp_tahunan->pegawai_id == $user->id_pegawai ){ 

            if( ($skp_tahunan->status) == 0 ) {
                return redirect('/personal/skp_tahunan/'.$request->skp_tahunan_id.'/edit')->with('status', 'SKP belum dikirm ke atasan');
            }else{
                return view('pare_pns.pages.personal-skp_tahunan_detail', ['skp'=> $skp_tahunan , 'role' =>'personal']);  
            }
        }else{
            return redirect('/dashboard');
        }

        //APPROVAL MODE
        /* if(  ( ($skp_tahunan->send_to_atasan) == 1 ) &  ( ($skp_tahunan->status_approve) == 2 ) ){
            return redirect('/personal/skp_tahunan/'.$request->skp_tahunan_id.'/ralat')->with('status', 'SKP belum dikirm ke atasan');
        }else if( ($skp_tahunan->send_to_atasan) == 0 ) {
            return redirect('/personal/skp_tahunan/'.$request->skp_tahunan_id.'/edit')->with('status', 'SKP belum dikirm ke atasan');
        }else{
            return view('pare_pns.pages.personal-skp_tahunan_detail', ['skp'=> $skp_tahunan]);  
        } */
    }



    public function PersonalSKPTahunanEdit(Request $request)
	{
        $user           = \Auth::user();
        $skp_tahunan    = SKPTahunan::WHERE('id', $request->skp_tahunan_id)->first();

        //hanya user ysb yang bisa buka skp tahunan tsb
        if ( $skp_tahunan->pegawai_id == $user->id_pegawai ){
            if ( $skp_tahunan->status != '0' ){
                return redirect('/personal/skp_tahunan/'.$request->skp_tahunan_id)->with('status', 'SKP close ');
            }else{
                return view('pare_pns.pages.personal-skp_tahunan_edit', ['skp'=> $skp_tahunan,'role' =>'personal']);  
            }
        }else{
            return redirect('/dashboard');
        }

        

          

    }

    public function PersonalSKPTahunanRalat(Request $request)
	{
        $user           = \Auth::user();
        $skp_tahunan    = SKPTahunan::WHERE('id', $request->skp_tahunan_id)->first();

        //hanya user ysb yang bisa buka skp tahunan tsb
        if ( $skp_tahunan->pegawai_id == $user->id_pegawai ){

            if(  ( ($skp_tahunan->send_to_atasan) == 1 ) &  ( ($skp_tahunan->status_approve) != 2 ) ){
                return redirect('/personal/skp_tahunan/'.$request->skp_tahunan_id)->with('status', 'SKP belum dikirm ke atasan');
            }else if( ($skp_tahunan->send_to_atasan) == 0 ) {
                return redirect('/personal/skp_tahunan/'.$request->skp_tahunan_id.'/edit')->with('status', 'SKP belum dikirm ke atasan');
            }else{
                return view('pare_pns.pages.personal-skp_tahunan_ralat', ['skp'=> $skp_tahunan,'role' =>'personal']);  
            }
        }else{
            return redirect('/dashboard');
        }
    }

    public function SKPTahunanApproval(Request $request)
	{
        $skp_tahunan	= SKPTahunan::where('id', '=', $request->skp_tahunan_id)->first();


        if(  $skp_tahunan->status_approve == '0'   ){
        
            return view('pare_pns.pages.personal-skp_tahunan_approval', ['skp'=> $skp_tahunan,'pegawai'=>\Auth::user()->pegawai]);  
        }else if(  $skp_tahunan->status_approve == '1'   ){
            return redirect('/personal/skp_tahunan/'.$skp_tahunan->id)->with('status', 'SKP Tahunan Sudah disetujui/ditolak');
        }else if(  $skp_tahunan->status_approve == '2'   ){
            return redirect('/personal/skp_tahunan_approval-request')->with('status', 'SKP Tahunan Sudah disetujui/ditolak');
        }
    }

}
