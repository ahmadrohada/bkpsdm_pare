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
use App\Models\Renja;
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

class RenjaController extends Controller {
    
    protected function nama_skpd($skpd_id){
        //nama SKPD 
        $nama_skpd       = \DB::table('demo_asn.m_skpd AS skpd')
                        ->WHERE('id',$skpd_id)
                        ->SELECT(['skpd.skpd AS skpd'])
                        ->first();
        return $nama_skpd->skpd;
    }


    public function showRenja(request $x)
	{
         
        
        $renja	= Renja::where('id', '=', $x->renja_id)
                        ->select('id','periode_id','skpd_id','kepala_skpd_id','admin_skpd_id','status','created_at')
                        ->first();
       


        return view('admin.pages.skpd-renja', [



                'nama_skpd'         => $this->nama_skpd($renja->skpd_id),
                'periode'           => $renja->Periode->label,
                'kepala_skpd'       => Pustaka::nama_pegawai($renja->KepalaSKPD->Pegawai->gelardpn , $renja->KepalaSKPD->Pegawai->nama , $renja->KepalaSKPD->Pegawai->gelarblk),
                'admin_skpd'        => Pustaka::nama_pegawai($renja->AdminSKPD->Pegawai->gelardpn , $renja->AdminSKPD->Pegawai->nama , $renja->AdminSKPD->Pegawai->gelarblk),
                'created_at'        => $renja->created_at,
                'h_box'             => 'box-info',

        		
	  			]
        );   

    }


    
    
}
