<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\CapaianPKTriwulan;

use App\Models\Jabatan;

use App\Helpers\Pustaka;

use Illuminate\Http\Request;



class CapaianPKTriwulanController extends Controller {




    public function SKPDCapaianPKTriwulanEdit(Request $request)
	{
        $user                   = \Auth::user();
        $capaian_pk_triwulan    = CapaianPKTriwulan::WHERE('id', $request->capaian_pk_triwulan_id)->first();

        //if ( $capaian_pk_triwulan->pegawai_id == $user->id_pegawai ){
            return view('pare_pns.pages.skpd-capaian_pk_triwulan', ['capaian_pk_triwulan'=> $capaian_pk_triwulan]); 
       // }else{
       //     return redirect('/dashboard');
       // }
    }

   

}
