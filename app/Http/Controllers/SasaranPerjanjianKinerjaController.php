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
use App\Models\Periode;

use App\Models\PerjanjianKinerja;
use App\Models\Sasaran;
use App\Models\SasaranPerjanjianKinerja;
use App\Models\IndikatorSasaran;
use App\Models\Program;
use App\Models\IndikatorProgram;
use App\Models\Kegiatan;
use App\Models\IndikatorKegiatan;



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

class SasaranPerjanjianKinerjaController extends Controller {


    protected function skpd()
	{
        $data =  \Auth::user()->pegawai->history_jabatan->where('status','active')->first()->id_skpd;
        return SKPD::where('id_skpd', $data)->first();
	}

    protected function user()
	{
        return  \Auth::user();
	}


    
    



    
}
