<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CapaianPKTahunan;
use App\Models\Jabatan;
use App\Helpers\Pustaka;
use Illuminate\Http\Request;


class CapaianPKTahunanController extends Controller {


    public function SKPDCapaianPKTahunanEdit(Request $request)
	{
        $user                   = \Auth::user();
        $capaian_pk_tahunan     = CapaianPKTahunan::WHERE('id', $request->capaian_pk_tahunan_id)->first();

        //if ( $capaian_pk_tahunan->pegawai_id == $user->id_pegawai ){
            return view('pare_pns.pages.skpd-capaian_pk_tahunan_edit', ['capaian_pk_tahunan'=> $capaian_pk_tahunan]); 
       // }else{
       //     return redirect('/dashboard');
       // }
    }

   

}
