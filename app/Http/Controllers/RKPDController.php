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

class RKPDController extends Controller {
    


    public function editRKPD($rkpd_id)
	{
        //$skpd       = Skpd::where('id_skpd', $this->id_skpd_admin())->first();

      /*  return view('admin.pages.skpd-rencana_kerja_perangkat_daerah', [
               
	  			]
        );  */ 
        
		$perjanjian_kinerja	= PerjanjianKinerja::where('id', '=', 41)->firstOrFail();
       


        return view('admin.pages.skpd-rkpd_edit', [
                'skpd'              => 'Badan Kepegawaian dan Pengembangan SDM',
                'id_skpd'           => '42',
                'perjanjian_kinerja'=> $perjanjian_kinerja,
                'form_name'         => 'sasaran',
        		
	  			]
        );   

    }


    
    
}
