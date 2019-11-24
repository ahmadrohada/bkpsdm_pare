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
use App\Models\CapaianTriwulan;

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

class CapaianTriwulanController extends Controller {




    public function PersonalCapaianTriwulanEdit(Request $request)
	{
        
            $capaian_triwulan   = CapaianTriwulan::WHERE('id', $request->capaian_triwulan_id)->first();

       /*  if ( $capaian_bulanan->send_to_atasan != '0' ){
            return redirect('/personal/capaian-bulanan/'.$request->capaian_bulanan_id)->with('status', 'terkirim');
        }else{
            return view('admin.pages.personal-capaian_bulanan_edit', ['capaian'=> $capaian_bulanan]);  
        } */

        return view('admin.pages.personal-capaian_triwulan_edit', ['capaian_triwulan'=> $capaian_triwulan]); 

    }

   

}
