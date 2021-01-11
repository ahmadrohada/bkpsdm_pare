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

    public function AdministratorRenjaDetail(Request $request)
	{
        $renja	= Renja::where('id', '=', $request->renja_id)->first();


        //if ( $renja->periode->id == 7 ){
            //RENJA 2021
            //return view('pare_2021.pages.administrator-pohon_kinerja', ['renja'=> $renja, 'role' => 'administrator' ]);
        //}else{
            //RENJA 2020
            return view('pare_pns.pages.administrator-pohon_kinerja_detail', ['renja'=> $renja, 'role' => 'administrator' ]);
        //}
          
       
    }
 

    public function SKPDRenjaDetail(Request $request)
	{
        $renja	= Renja::where('id', '=', $request->renja_id)->first();

        

        if(  ( ($renja->send_to_kaban) == 1 ) &  ( ($renja->status_approve) == 2 ) ){
            return redirect('/skpd/pohon_kinerja/'.$request->renja_id.'/ralat')->with('status', 'Renja ditolak kaban');
        }else if( ($renja->send_to_kaban) == 0 ) {
            return redirect('/skpd/pohon_kinerja/'.$request->renja_id.'/edit')->with('status', 'Renja belum dikirm ke kaban');
        }else{
            return view('pare_pns.pages.skpd-pohon_kinerja_detail', ['renja'=> $renja , 'role' => 'skpd']);  
        }
    }

    public function PersonalRenjaDetail(Request $request)
	{
        $renja	= Renja::where('id', '=', $request->renja_id)->first();

        

        if(  ( ($renja->send_to_kaban) == '0' ) ){
            return redirect('personal/renja_approval-request')->with('status', 'akses ditolak');
        }else if(  ( ($renja->send_to_kaban) == '1' ) &  ( ($renja->status_approve) != '1' ) ){
            return redirect('personal/renja_approval-request')->with('status', 'akses ditolak');
        }else if( ($renja->send_to_kaban) == '0' ) {
            return redirect('/personal/renja/'.$request->renja_id.'/edit')->with('status', 'Renja belum dikirm ke kaban');
        }else{
            return view('pare_pns.pages.skpd-pohon_kinerja_detail', ['renja'=> $renja , 'role' =>'personal' ]);  
        }
    }

    public function SKPDRenjaApproval(Request $request)
	{
        $renja	= Renja::where('id', '=', $request->renja_id)->first();


        if(  $renja->status_approve == '0'   ){
        
            return view('pare_pns.pages.skpd-renja_approval', ['renja'=> $renja,'pegawai'=>\Auth::user()->pegawai]);  
        }else{
            return redirect('/personal/renja/'.$renja->id)->with('status', 'Renja Sudah disetujui/ditolak');
        }
    }

    public function SKPDRenjaEdit(request $x)
	{
         
        
        $renja	        = Renja::where('id', '=', $x->renja_id)->first();
        $user           = \Auth::user();

       
        //RENJA 2020
        if ( $user->pegawai->JabatanAktif->id_skpd == $renja->skpd_id ){
            if(  ( ($renja->send_to_kaban) == 1 ) &  ( ($renja->status_approve) != 2 ) ){
                return redirect('/skpd/pohon_kinerja/'.$x->renja_id)->with('status', 'Rencana Kerja dikirm ke atasan');
            }else{
                return view('pare_pns.pages.skpd-pohon_kinerja_edit', ['renja'=> $renja,'h_box'=> 'box-info','role' =>'skpd']);    
            }
        }else{
            return redirect('/dashboard');
        }
    }

    public function SKPDRenjaRalat(Request $request)
	{
        $renja	= Renja::where('id', '=', $request->renja_id)->first();

        
        if(  ( ($renja->send_to_kaban) == 1 ) &  ( ($renja->status_approve) == 2 ) ){
            return view('pare_pns.pages.skpd-renja_ralat', ['renja'=> $renja,'h_box'=> 'box-warning']);
        }else if( ($renja->send_to_kaban) == 0 ) {
            return redirect('/skpd/pohon_kinerja/'.$renja->id.'/edit')->with('status', 'Renja belum dikirm ke kaban');
        }else{
            return redirect('/skpd/pohon_kinerja/'.$renja->id)->with('status', 'Rencana Kerja dikirm ke atasan');
        }
        
    }


    public function SKPDMonitoringKinerja(Request $request)
	{
        $renja_id = $request->renja_id;
        $renja	= Renja::where('id', '=', $request->renja_id)->first();

        return view('pare_pns.pages.skpd-monitoring_kinerja', ['renja'=> $renja , 'role' =>'skpd' ,'h_box'=> 'box-info' ,'skpd_id' =>  $renja->skpd_id ]);  
       
    }

    
    
}
