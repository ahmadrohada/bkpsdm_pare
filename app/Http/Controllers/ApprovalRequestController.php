<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ApprovalRequestController extends Controller {
    
    

    //=======================================================================================//
    protected function nama_skpd($skpd_id){
            //nama SKPD 
            $nama_skpd       = \DB::table('demo_asn.m_skpd AS skpd')
                            ->WHERE('id',$skpd_id)
                            ->SELECT(['skpd.skpd AS skpd'])
                            ->first();
            return $nama_skpd->skpd;
    }


   

    public function showDashoard(Request $request)
    {
        return redirect('/personal/capaian_bulanan_bawahan');
    }

    

    
    public function showRenja(Request $request)
    {
        $user      = \Auth::user();
        $pegawai   = $user->pegawai;       
        

        return view('pare_pns.pages.approval_request-renja', [
               'pegawai' 		        => $pegawai,
               'nama_skpd'     	        => 'x',
               'h_box'                  => 'box-teal',
               
           ]
        );   

        
    }

    public function showSKpTahunan(Request $request)
    {
        $user      = \Auth::user();
        $pegawai   = $user->pegawai;       
        

        return view('pare_pns.pages.approval_request-skp_tahunan', [
               'pegawai' 		        => $pegawai,
               'nama_skpd'     	        => 'x',
               'h_box'                  => 'box-purple',
               
           ]
        );   

        
    }

}
