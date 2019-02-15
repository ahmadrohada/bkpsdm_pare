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


    public function SKPDRenjaDetail(Request $request)
	{
        $renja	= Renja::where('id', '=', $request->renja_id)->first();

        

        if(  ( ($renja->send_to_kaban) == 1 ) &  ( ($renja->status_approve) == 2 ) ){
            return redirect('/skpd/renja/'.$request->renja_id.'/ralat')->with('status', 'Renja belum dikirm ke kaban');
        }else if( ($renja->send_to_kaban) == 0 ) {
            return redirect('/skpd/renja/'.$request->renja_id.'/edit')->with('status', 'Renja belum dikirm ke kaban');
        }else{
            return view('admin.pages.skpd-renja_detail', ['renja'=> $renja]);  
        }
    }

    public function SKPDRenjaApproval(Request $request)
	{
        $renja	= Renja::where('id', '=', $request->renja_id)->first();

        
        return view('admin.pages.skpd-renja_approval', ['renja'=> $renja,'pegawai'=>\Auth::user()->pegawai]);  
        
    }

    public function SKPDRenjaEdit(request $x)
	{
         
        
        $renja	= Renja::where('id', '=', $x->renja_id)->first();
       

        if(  ( ($renja->send_to_kaban) == 1 ) &  ( ($renja->status_approve) != 2 ) ){
            return redirect('/skpd/renja/'.$x->renja_id)->with('status', 'Rencana Kerja dikirm ke atasan');
        }else{
            return view('admin.pages.skpd-renja_edit', ['renja'=> $renja,'h_box'=> 'box-info',]);    
        }

    }


    
    
}
