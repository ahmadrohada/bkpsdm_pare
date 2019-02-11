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
use App\Models\Skpd;
use App\Models\Periode;
use App\Models\Renja;

use App\Models\PerjanjianKinerja;
use App\Models\Sasaran;
use App\Models\SasaranPerjanjianKinerja;
use App\Models\IndikatorSasaran;
use App\Models\Program;
use App\Models\IndikatorProgram;
use App\Models\Kegiatan;
use App\Models\IndikatorKegiatan;

use App\Models\Jabatan;

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

class PerjanjianKinerjaController extends Controller {


   
    protected function skpd()
	{
        $data =  \Auth::user()->pegawai->history_jabatan->where('status','active')->first()->id_skpd;
        return Skpd::where('id_skpd', $data)->first();
	}

    protected function user()
	{
        return  \Auth::user();
    }
    
    protected function nama_skpd($skpd_id){
        //nama SKPD 
        $nama_skpd       = \DB::table('demo_asn.m_skpd AS skpd')
                        ->WHERE('id',$skpd_id)
                        ->SELECT(['skpd.skpd AS skpd'])
                        ->first();
        return $nama_skpd->skpd;
    }


   

    public function showPerjanjianKinerja(request $x)
	{
         
        
        $pk	= PerjanjianKinerja::where('id', '=', $x->perjanjian_kinerja_id)->first();
       


        return view('admin.pages.skpd-perjanjian_kinerja', [



                'pk'                =>  $pk,
                'h_box'             => 'box-info',

        		
	  			]
        );   

    }


    public function SKPDEditPerjanjianKinerja_sasaran($perjanjian_kinerja_id)
	{
       
        //DETAIL PerJanjian KInerja
		$perjanjian_kinerja	= PerjanjianKinerja::where('id', '=', $perjanjian_kinerja_id)->firstOrFail();
       


        return view('admin.pages.skpd-edit_perjanjian_kinerja', [
                'skpd'              => $this->skpd(),
                'id_skpd'           => $this->skpd()->id,
                'perjanjian_kinerja'=> $perjanjian_kinerja,
                'form_name'         => 'sasaran',
        		
	  			]
        );   
    }

    public function SKPDEditPerjanjianKinerja_indikator_sasaran($perjanjian_kinerja_id,$sasaran_perjanjian_kinerja_id)
	{
       
        //DETAIL PerJanjian KInerja
        $perjanjian_kinerja	 = PerjanjianKinerja::where('id', '=', $perjanjian_kinerja_id)->first();
        $sasaran             = SasaranPerjanjianKinerja::where('id', $sasaran_perjanjian_kinerja_id )->first();
      
        return view('admin.pages.skpd-edit_perjanjian_kinerja', [
                'skpd'              => $this->skpd(),
                'id_skpd'           => $this->skpd()->id,
                'perjanjian_kinerja'=> $perjanjian_kinerja,
                'sasaran'           => $sasaran,
                'form_name'         => 'indikator_sasaran',
                ]
        );   
    }

    public function SKPDEditPerjanjianKinerja_program($perjanjian_kinerja_id,$indikator_sasaran_id)
	{
       
        //DETAIL PerJanjian KInerja
        $perjanjian_kinerja	 = PerjanjianKinerja::where('id', '=', $perjanjian_kinerja_id)->first();
        
        $indikator_sasaran =  IndikatorSasaran::where('id','=',$indikator_sasaran_id)->first();
      

        return view('admin.pages.skpd-edit_perjanjian_kinerja', [
                'skpd'              => $this->skpd(),
                'id_skpd'           => $this->skpd()->id,
                'perjanjian_kinerja'=> $perjanjian_kinerja,
                'indikator_sasaran' => $indikator_sasaran,
                'form_name'         => 'program',
	  			]
        );   
    }


    public function SKPDEditPerjanjianKinerja_indikator_program($perjanjian_kinerja_id,$program_id)
	{
       
        //DETAIL PerJanjian KInerja
        $perjanjian_kinerja	 = PerjanjianKinerja::where('id', '=', $perjanjian_kinerja_id)->first();
        
        $program =  Program::where('id','=',$program_id)->first();
        
        //== cari unit kerja atau bidang pada SKPD perjanjian kinerja
        $unit_kerja      = $perjanjian_kinerja->skpd->UnitKerja;

        return view('admin.pages.skpd-edit_perjanjian_kinerja', [
                'skpd'              => $this->skpd(),
                'id_skpd'           => $this->skpd()->id,
                'perjanjian_kinerja'=> $perjanjian_kinerja,
                'program'           => $program,
                'form_name'         => 'indikator_program',
                'unit_kerja'        => $unit_kerja,
	  			]
        );   
    }

    public function SKPDEditPerjanjianKinerja_kegiatan($perjanjian_kinerja_id,$indikator_program_id)
	{
       
        //DETAIL PerJanjian KInerja
        $perjanjian_kinerja	 = PerjanjianKinerja::where('id', '=', $perjanjian_kinerja_id)->first();
        
        $indikator_program   =  IndikatorProgram::where('id','=',$indikator_program_id)->first();
        
        //== cari unit kerja atau bidang pada SKPD perjanjian kinerja
        $unit_kerja      = $perjanjian_kinerja->skpd->UnitKerja;

        return view('admin.pages.skpd-edit_perjanjian_kinerja', [
                'skpd'              => $this->skpd(),
                'id_skpd'           => $this->skpd()->id,
                'perjanjian_kinerja'=> $perjanjian_kinerja,
                'indikator_program' => $indikator_program,
                'form_name'         => 'kegiatan',
                'unit_kerja'        => $unit_kerja,
	  			]
        );   
    }

    public function SKPDEditPerjanjianKinerja_indikator_kegiatan($perjanjian_kinerja_id,$kegiatan_id)
	{
       
        //DETAIL PerJanjian KInerja
        $perjanjian_kinerja	 = PerjanjianKinerja::where('id', '=', $perjanjian_kinerja_id)->first();
        
        $kegiatan   =  Kegiatan::where('id','=',$kegiatan_id)->first();
        //$kegiatan            = $indikator_program->kegiatan;

        return view('admin.pages.skpd-edit_perjanjian_kinerja', [
                'skpd'              => $this->skpd(),
                'id_skpd'           => $this->skpd()->id,
                'perjanjian_kinerja'=> $perjanjian_kinerja,
                'kegiatan'          => $kegiatan,
                'form_name'         => 'indikator_kegiatan',
	  			]
        );   
    }

   

}
