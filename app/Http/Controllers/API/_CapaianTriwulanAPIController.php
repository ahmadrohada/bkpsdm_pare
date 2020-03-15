<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Periode;
use App\Models\PerjanjianKinerja;
use App\Models\SKPTahunan;
use App\Models\SKPBulanan;
use App\Models\CapaianBulanan;
use App\Models\CapaianTriwulan;
use App\Models\Pegawai;
use App\Models\HistoryJabatan;
use App\Models\Jabatan;
use App\Models\Golongan;
use App\Models\Eselon;

use App\Models\KegiatanSKPTahunan;
use App\Models\RencanaAksi;
use App\Models\RealisasiRencanaAksiKasubid;
use App\Models\RealisasiRencanaAksiEselon3;
use App\Models\RealisasiRencanaAksiKaban;
use App\Models\KegiatanSKPBulanan;
use App\Models\RealisasiKegiatanBulanan;

use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class CapaianTriwulanAPIController extends Controller {

    public function CreateConfirm(Request $request)
	{

        //data yang harus diterima yaitu Pegawai ID dan tgl jangka waktu penilaian

        //dapatkan tgl akhir bulan
        $to     = Pustaka::tgl_akhir(Pustaka::tgl_sql($request->get('tgl_selesai')));

        //mencari tgl 3 bulan lalu
        $from   = Pustaka::triwulan_lalu($to);
        
       

        $jm_skp    =   SKPBulanan::whereBetween('tgl_selesai',[$from,$to])
                            ->WHERE('skp_bulanan.pegawai_id', $request->get('pegawai_id'))
                            ->count();
      
        $capaian   =   CapaianBulanan::whereBetween('tgl_selesai',[$from,$to])
                            ->WHERE('capaian_bulanan.pegawai_id',$request->get('pegawai_id'))
                            ->SELECT('id AS capaian_bulanan_id',
                                     'tgl_mulai',
                                     'u_nama',
                                     'u_jabatan_id',
                                     'p_nama',
                                     'p_jabatan_id'
                                    )
                            ->get();


        $total_realisasi = 0 ; 
        $ck_data = 0 ;
        foreach ($capaian as $x) {
                $ck_data++;
                //realisasi
                $jm_realisasi   = RealisasiKegiatanBulanan::WHERE('capaian_id',$x->capaian_bulanan_id)->count();
                
                ///$data_jabatan_id['jabatan']          = Pustaka::capital_string($x->jabatan);
                $data_capaian_id['capaian_bulanan_id']  = $x->capaian_bulanan_id;
                $data_capaian_id['periode_capaian']     = Pustaka::periode($x->tgl_mulai);

                //tes 
                $u_nama                                 = $x->u_nama;
                $u_jabatan_id                           = $x->u_jabatan_id;
                $p_nama                                 = $x->p_nama;
                $p_jabatan_id                           = $x->p_jabatan_id;

                $data_capaian_id['jm_realisasi']        = $jm_realisasi;
                
                $list_capaian[] = $data_capaian_id ;
                $total_realisasi += $jm_realisasi;
        }

        if ( $ck_data > 0){
            $list_capaian = $list_capaian;
        }else{
            $list_capaian   = 0;
            $u_nama         = "";
            $u_jabatan_id   = "";
            $p_nama         = "";
            $p_jabatan_id   = "";
        }
        

        $data = array(
                    'status'			            =>  'pass',
                    'jm_cap_skp'                    =>  $ck_data." / ".$jm_skp,
                    'periode_capaian_triwulan'      =>  Pustaka::periode($from)." s.d ".Pustaka::periode($to),
                    'total_realisasi'               =>  $total_realisasi,


                    'tgl_mulai_capaian'             => $from,
                    'tgl_selesai_capaian'           => $to,
                    
                    'pegawai_id'                    => $request->get('pegawai_id'),
                    'u_nama'                        => $u_nama,
                    'u_jabatan_id'                  => $u_jabatan_id,
                    'p_nama'                        => $p_nama,
                    'p_jabatan_id'                  => $p_jabatan_id,


                    'list_capaian'                  =>  $list_capaian
                );

        return $data;
    }


    public function PersonalCapaianTriwulanList(Request $request)
    {
        $capaian_triwulan = CapaianTriwulan::
                        WHERE('capaian_triwulan.pegawai_id',$request->pegawai_id)
                        ->select(
                                'capaian_triwulan.id AS capaian_triwulan_id',
                                'capaian_triwulan.tgl_mulai',
                                'capaian_triwulan.tgl_selesai',
                                'capaian_triwulan.u_jabatan_id',
                                'capaian_triwulan.status AS skp_bulanan_status'

            
                         )
                       // ->orderBy('bulan','ASC')
                        ->get();

       
           $datatables = Datatables::of($capaian_triwulan)
             ->addColumn('periode_capaian', function ($x) {
                $masa_penilaian = Pustaka::balik($x->tgl_mulai). ' s.d ' . Pustaka::balik($x->tgl_selesai);
                return   $masa_penilaian;
            }) 
           
           
            ->addColumn('jabatan', function ($x) {
                
                return   Pustaka::capital_string($x->PejabatYangDinilai->Jabatan->skpd);
            })
            ->addColumn('capaian', function ($x) {
                return $x->capaian_id;
             
            });
    
            if ($keyword = $request->get('search')['value']) {
                $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
            } 
            
    
        return $datatables->make(true);
        
    }


    
    public function Store(Request $request)
	{
        $messages = [
                 'pegawai_id.required'                   => 'Harus diisi',
                 'tgl_selesai_capaian.required'          => 'Harus diisi',
                 'tgl_mulai_capaian.required'            => 'Harus diisi',
                 'tgl_selesai.required'                  => 'Harus diisi',
                 'u_nama.required'                       => 'Harus diisi',
                 'u_jabatan_id.required'                 => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'pegawai_id'            => 'required',
                            'tgl_selesai_capaian'   => 'required',
                            'tgl_mulai_capaian'     => 'required',
                            'tgl_selesai'           => 'required',
                            'u_nama'                => 'required',
                            'u_jabatan_id'          => 'required',
                        ),
                        $messages
        );
    
        if ( $validator->fails() ){
            //$messages = $validator->messages();
                    return response()->json(['errors'=>$validator->messages()],422);
            
        }

       /*  if ( (Pustaka::tgl_sql(Input::get('tgl_mulai'))) >= (Pustaka::tgl_sql(Input::get('tgl_selesai'))) ){
            $pesan =  ['masa_penilaian'  => 'Error'] ;
            return response()->json(['errors'=> $pesan ],422);
            
        }
 */

            $capaian_triwulan                              = new CapaianTriwulan;
            $capaian_triwulan->pegawai_id                  = Input::get('pegawai_id');
            $capaian_triwulan->u_nama                      = Input::get('u_nama');
            $capaian_triwulan->u_jabatan_id                = Input::get('u_jabatan_id');
            $capaian_triwulan->p_nama                      = Input::get('p_nama');
            $capaian_triwulan->p_jabatan_id                = Input::get('p_jabatan_id');
            $capaian_triwulan->tgl_mulai                   = Input::get('tgl_mulai_capaian');
            $capaian_triwulan->tgl_selesai                 = Input::get('tgl_selesai_capaian');
            
    
            
    
            if ( $capaian_triwulan->save()){
                return \Response::make($capaian_triwulan->id, 200);
            }else{
                return \Response::make('error', 500);
            } 


    }   
   

}
