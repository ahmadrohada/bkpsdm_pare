<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Logic\User\UserRepository;
use App\Logic\User\CaptureIp;
use App\Http\Requests;

use App\Models\User;
use App\Models\Role;
use App\Models\Skpd;
use App\Models\Periode;

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


   
    protected function skpd()
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
    }


    public function SKPTahunanPersonalEdit($skp_tahunan_id)
	{
        
        $skp_tahunan    = SKPTahunan::WHERE('id', $skp_tahunan_id)->first();

        $pejabat_penilai    = $skp_tahunan->pejabat_penilai ;
        if ( $pejabat_penilai == null ){
            $nip_penilai                        = "";
            $nama_pejabat_penilai               = "";
            $pangkat_golongan_pejabat_penilai   = "";
            $jabatan_pejabat_penilai            = "";
            $eselon_pejabat_penilai             = "";
            $unit_kerja_pejabat_penilai         = "";
        }else{
            $nip_penilai                        = $pejabat_penilai->nip;
            $nama_pejabat_penilai               = $skp_tahunan->p_nama;
            $pangkat_golongan_pejabat_penilai   = $pejabat_penilai->golongan->pangkat .'/'. $pejabat_penilai->golongan->golongan;
            $jabatan_pejabat_penilai            = $pejabat_penilai->jabatan;
            $eselon_pejabat_penilai             = $pejabat_penilai->eselon->eselon;
            $unit_kerja_pejabat_penilai         = Pustaka::capital_string($pejabat_penilai->UnitKerja->unit_kerja);
        }


        //===== list kegiatan Perjanjina kinerja =========/
        $kegiatan_pk       = Kegiatan::where('jabatan_id','908')->get();



        return view('admin.pages.personal-edit_skp_tahunan', [
                    'skpd'                  => $this->skpd(),
                    'user' 		            => $this->user(),
                    'skp_tahunan'           => $skp_tahunan,
                    'pejabat_yang_dinilai'  => $skp_tahunan->pejabat_yang_dinilai,

                    
                    'nip_penilai'                       => $nip_penilai,
                    'nama_pejabat_penilai'              => $nama_pejabat_penilai,
                    'pangkat_golongan_pejabat_penilai'  => $pangkat_golongan_pejabat_penilai,
                    'jabatan_pejabat_penilai'           => $jabatan_pejabat_penilai,
                    'eselon_pejabat_penilai'            => $eselon_pejabat_penilai,
                    'unit_kerja_pejabat_penilai'        => $unit_kerja_pejabat_penilai,


                    'kegiatan_pk'                       => $kegiatan_pk,
                    ]
        );    

    }

}
