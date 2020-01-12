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


   
 /*    protected function skpd()
	{
        $data =  \Auth::user()->pegawai->history_jabatan->where('status','active')->first()->id_skpd;
        return Skpd::where('id_skpd', $data)->first();
	}

    protected function user()
	{
        return  \Auth::user();
	}

    public function SKPTahunanPersonal()
	{
        
       return view('admin.pages.personal-skp_tahunan', [
                'skpd'      => $this->skpd(),
        		'user' 		=> $this->user()
	  			]
        );    
    } */

    
    public function PersonalSKPBulananDetail(Request $request)
	{
        $skp_bulanan = SKPBulanan::where('id', $request->skp_bulanan_id )->first();

        if( ($skp_bulanan->status) == 0 ) {
            return redirect('/personal/skp_bulanan/'.$request->skp_bulanan_id.'/edit')->with('status', 'SKP belum dikirm ke atasan');
        }else{
            return view('admin.pages.personal-skp_bulanan_detail', ['skp'=> $skp_bulanan]);  
        }
    }




    public function SKPBulananDetail(Request $skp_bulanan_id)
	{
        
    
        $skp_bulanan	= SKPBulanan::where('id', '=', $skp_bulanan_id->id )
                                    ->first();



        return view('admin.pages.skpd-skp_bulanan', [
                    
                    'skp'                   => $skp_bulanan,
                    ]
        );    

    }

}
