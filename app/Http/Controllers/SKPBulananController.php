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

class SKPBulananController extends Controller {

    public function PersonalSKPBulananDetail(Request $request)
	{
        $skp_bulanan = SKPBulanan::where('id', $request->skp_bulanan_id )->first();

        if( ($skp_bulanan->status) == 0 ) {
            return redirect('/personal/skp_bulanan/'.$request->skp_bulanan_id.'/edit')->with('status', 'SKP belum dikirm ke atasan');
        }else{
            return view('pare_pns.pages.personal-skp_bulanan_detail', ['skp'=> $skp_bulanan]);  
        }
    }

    public function PersonalSKPBulananEdit(Request $request) 
	{
        $user           = \Auth::user();
        $skp_bulanan    = SKPBulanan::where('id', $request->skp_bulanan_id )->first();

        //hanya user ysb yang bisa buka skp bulanan tsb
        if ( $skp_bulanan->pegawai_id == $user->id_pegawai ){ 

            if( ($skp_bulanan->status) == 1 ) {
                return redirect('/personal/skp_bulanan/'.$request->skp_bulanan_id)->with('status', 'SKP sudah dikirm ke atasan');
            }else{
                return view('pare_pns.pages.personal-skp_bulanan_edit', ['skp'=> $skp_bulanan]);  
            }
        }else{
            //return view('pare_pns.errors.users403');
            return redirect('/dashboard');
        }
    }




    public function SKPBulananDetail(Request $skp_bulanan_id)
	{
        
        $user           = \Auth::user();
        $skp_bulanan	= SKPBulanan::where('id', '=', $skp_bulanan_id->id )
                                    ->first();


        //hanya user ysb yang bisa buka skp bulanan tsb
        if ( $skp_bulanan->pegawai_id == $user->id_pegawai ){ 
            return view('pare_pns.pages.skpd-skp_bulanan', [
                                                            'skp'   => $skp_bulanan,
                                                        ]
                    );    
        }else{
            //return view('pare_pns.errors.users403');
            return redirect('/dashboard');
        }
    }

}
