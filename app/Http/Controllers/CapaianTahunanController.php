<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Logic\User\UserRepository;
use App\Logic\User\CaptureIp;
use App\Http\Requests;

use App\Models\User;
use App\Models\Role;
use App\Models\Skpd;
use App\Models\Periode;
use App\Models\Renja;
use App\Models\SKPTahunan;
use App\Models\SKPBulanan;
use App\Models\CapaianBulanan;
use App\Models\CapaianTahunan;

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

use App\Traits\PJabatan;


use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;

use PDF;
use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class CapaianTahunanController extends Controller {

    use PJabatan; 

    protected function jm_approval_request_cap_bulanan($jabatan_id){
        $data_1 = CapaianBulanan::rightjoin('demo_asn.tb_history_jabatan AS atasan', function($join) use($jabatan_id){
                                    $join   ->on('atasan.id','=','capaian_bulanan.p_jabatan_id');
                                    $join   ->where('atasan.id_pegawai','=',$jabatan_id);
                                }) 
                                ->WHERE('capaian_bulanan.send_to_atasan','=','1')
                                ->WHERE('capaian_bulanan.status_approve','=','0')
                                ->count();
        $data_2 = CapaianBulanan::rightjoin('demo_asn.tb_history_jabatan AS atasan', function($join) use($jabatan_id){
                                    $join   ->on('atasan.id','=','capaian_bulanan.p_jabatan_id');
                                    $join   ->where('atasan.id_pegawai','=',$jabatan_id);
                                }) 
                                ->WHERE('capaian_bulanan.send_to_atasan','=','1')
                                ->count();
        return $data_1.' / '.$data_2;
    }

    protected function jm_approval_request_cap_tahunan($jabatan_id){
        $data_1 = CapaianTahunan::rightjoin('demo_asn.tb_history_jabatan AS atasan', function($join) use($jabatan_id){
                                    $join   ->on('atasan.id','=','capaian_tahunan.p_jabatan_id');
                                    $join   ->where('atasan.id_pegawai','=',$jabatan_id);
                                }) 
                                ->WHERE('capaian_tahunan.send_to_atasan','=','1')
                                ->WHERE('status_approve','=','0')
                                ->count();
        $data_2 = CapaianTahunan::rightjoin('demo_asn.tb_history_jabatan AS atasan', function($join) use($jabatan_id){
                                    $join   ->on('atasan.id','=','capaian_tahunan.p_jabatan_id');
                                    $join   ->where('atasan.id_pegawai','=',$jabatan_id);
                                }) 
                                ->WHERE('capaian_tahunan.send_to_atasan','=','1')
                                ->count();
        return $data_1.' / '.$data_2;
    }

    public function CapaianTahunanBawahanList(Request $request)
	{
        
        $user      = \Auth::user();
        $pegawai   = $user->pegawai;       
        
        if ( $pegawai->JabatanAktif->Eselon->id_jenis_jabatan <= 3 ) {
            return view('pare_pns.pages.bawahan-capaian_tahunan', [
                'pegawai' 		        => $pegawai,
                'nama_skpd'     	        => 'x',
                'h_box'                  => 'box-purple',
                'capaian_tahunan_app_req'    => $this->jm_approval_request_cap_tahunan($pegawai->id),
                'capaian_bulanan_app_req'    => $this->jm_approval_request_cap_bulanan($pegawai->id),
                
            ]);     
        }else{
            //return view('pare_pns.errors.users403');
            return redirect('/dashboard');
        } 

        

    }

    public function CapaianTahunanBawahanApprovement(Request $request)
	{
       

        $user               = \Auth::user();
        $capaian_tahunan    = CapaianTahunan::WHERE('id', $request->capaian_tahunan_id)->first();

        if ( $capaian_tahunan->PejabatPenilai->id_pegawai == $user->id_pegawai ){
            if ( $capaian_tahunan->status_approve == '0' ){
                return view('pare_pns.pages.personal-capaian_tahunan_approvement', ['capaian'                   => $capaian_tahunan,
                                                                                    'jabatan_sekda'             => $this->jenis_PJabatan('sekda'),
                                                                                    'jabatan_irban'             => $this->jenis_PJabatan('irban'),
                                                                                    'jabatan_lurah'             => $this->jenis_PJabatan('lurah'),
                                                                                    'jabatan_staf_ahli'         => $this->jenis_PJabatan('staf_ahli')]);
            } else {
                return redirect('/personal/capaian_tahunan_bawahan/'.$request->capaian_tahunan_id)->with('status', 'approved');
            }                                                                       
        }else{
            //return view('pare_pns.errors.users403');
            return redirect('/dashboard');
        }
    }


    public function CapaianTahunanBawahanDetail(Request $request)
	{
        $user               = \Auth::user();
        $capaian_tahunan    = CapaianTahunan::WHERE('id', $request->capaian_tahunan_id)->first();
        //hanya atasan yang bisa lhat detai capaian bahwan nya
        if ( $capaian_tahunan->PejabatPenilai->id_pegawai == $user->id_pegawai ){
            if ( $capaian_tahunan->send_to_atasan == '0' ){
                return redirect('/personal/capaian-tahunan/'.$request->capaian_tahunan_id.'/edit')->with('status', 'terkirim');
            }else{
                return view('pare_pns.pages.personal-capaian_tahunan_detail', ['capaian'=> $capaian_tahunan]);  
            }
        }else{
            //return view('pare_pns.errors.users403');
            return redirect('/dashboard');
        }
    }




    public function PersonalCapaianTahunanEdit(Request $request)
	{
        $user           = \Auth::user();
        $capaian_tahunan    = CapaianTahunan::WHERE('id', $request->capaian_tahunan_id)->first();

        //hanya user ysb yang bisa buka skp tahunan tsb
        if ( $capaian_tahunan->pegawai_id == $user->id_pegawai ){
            if ( $capaian_tahunan->send_to_atasan != '0' ){
                return redirect('/personal/capaian-tahunan/'.$request->capaian_tahunan_id)->with('status', 'terkirim');
            }else{
                return view('pare_pns.pages.personal-capaian_tahunan_edit', ['capaian'=> $capaian_tahunan]);  
            }
        }else{
            //return view('pare_pns.errors.users403');
            return redirect('/dashboard');
        }

          

    }

    public function PersonalCapaianTahunanRalat(Request $request)
	{
        $user           = \Auth::user();
        $capaian_tahunan    = CapaianTahunan::WHERE('id', $request->capaian_tahunan_id)->first();
        //hanya user ysb yang bisa buka skp tahunan tsb
        if ( $capaian_tahunan->pegawai_id == $user->id_pegawai ){
            if ( $capaian_tahunan->status_approve != '2' ){
                return redirect('/personal/capaian-tahunan/'.$request->capaian_tahunan_id)->with('status', 'terkirim');
            }else{
                return view('pare_pns.pages.personal-capaian_tahunan_edit', ['capaian'=> $capaian_tahunan]);  
            }
        }else{
            //return view('pare_pns.errors.users403');
            return redirect('/dashboard');
        }
          

    } 

    public function PersonalCapaianTahunanDetail(Request $request)
	{
         
        $user           = \Auth::user();
        $capaian_tahunan    = CapaianTahunan::WHERE('id', $request->capaian_tahunan_id)->first();

        if ( $capaian_tahunan->pegawai_id == $user->id_pegawai ){
            if ( $capaian_tahunan->send_to_atasan == '0' ){
                return redirect('/personal/capaian-tahunan/'.$request->capaian_tahunan_id.'/edit')->with('status', 'terkirim');
            }else{
                return view('pare_pns.pages.personal-capaian_tahunan_detail', ['capaian'=> $capaian_tahunan]);  
            }

        }else{
            //return view('pare_pns.errors.users403');
            return redirect('/dashboard');
        }

    }


    
    public function PersonalCapaianTahunancetak(Request $request)
    {
       

        //kegiatan eselon 3
        $renja_id   = $request->renja_id;
        $jabatan_id = $request->jabatan_id;
        $capaian_id = $request->capaian_id;
        $bawahan = Jabatan::SELECT('id')->WHERE('parent_id', $jabatan_id )->get()->toArray();


        $kegiatan_list = Kegiatan::WHERE('renja_kegiatan.renja_id', $renja_id )
                        ->WHEREIN('renja_kegiatan.jabatan_id', $bawahan  )
                        //LEFT JOIN ke Kegiatan SKP TAHUNAN
                        ->JOIN('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join){
                            $join   ->on('kegiatan_tahunan.kegiatan_id','=','renja_kegiatan.id');
                            
                        })
                        //LEFT JOIN ke INDIKATOR KEGIATAN
                        ->leftjoin('db_pare_2018.renja_indikator_kegiatan AS renja_indikator_kegiatan', function($join){
                            $join   ->on('renja_indikator_kegiatan.kegiatan_id','=','renja_kegiatan.id');
                            
                        })
                         //LEFT JOIN TERHADAP REALISASI INDIKATOR KEGIATAN
                         ->leftjoin('db_pare_2018.realisasi_indikator_kegiatan_tahunan AS realisasi_indikator', function($join) use ( $capaian_id ){
                            $join   ->on('realisasi_indikator.indikator_kegiatan_id','=','renja_indikator_kegiatan.id');
                            $join   ->WHERE('realisasi_indikator.capaian_id','=',  $capaian_id );
                            
                        })
                        //LEFT JOIN TERHADAP REALISASI TAHUNAN tahunan
                        ->leftjoin('db_pare_2018.realisasi_kegiatan_tahunan AS realisasi_kegiatan', function($join) use ( $capaian_id ){
                            $join   ->on('realisasi_kegiatan.kegiatan_tahunan_id','=','kegiatan_tahunan.id');
                            $join   ->WHERE('realisasi_kegiatan.capaian_id','=',  $capaian_id );
                            
                        })
                        //LEFT JOIN KE CAPAIAN TAHUNAN
                        ->leftjoin('db_pare_2018.capaian_tahunan AS capaian_tahunan', function($join){
                            $join   ->on('capaian_tahunan.id','=','realisasi_kegiatan.capaian_id');
                        })

                        ->SELECT(   'renja_kegiatan.id AS kegiatan_id',
                                    'renja_kegiatan.id AS no',
                                    'renja_kegiatan.jabatan_id',
                                    'renja_kegiatan.label AS kegiatan_label',

                                    'renja_indikator_kegiatan.id AS indikator_kegiatan_id',
                                    'renja_indikator_kegiatan.label AS indikator_kegiatan_label',
                                    'renja_indikator_kegiatan.target AS indikator_kegiatan_target',
                                    'renja_indikator_kegiatan.satuan AS indikator_kegiatan_satuan',

                                    'kegiatan_tahunan.id AS kegiatan_tahunan_id',
                                    'kegiatan_tahunan.label AS kegiatan_tahunan_label',
                                    'kegiatan_tahunan.quality AS kegiatan_tahunan_quality',
                                    'kegiatan_tahunan.cost AS kegiatan_tahunan_cost',
                                    'kegiatan_tahunan.target_waktu AS kegiatan_tahunan_target_waktu',
                                    'kegiatan_tahunan.angka_kredit AS kegiatan_tahunan_ak',

                                    'realisasi_indikator.id AS realisasi_indikator_id',
                                    'realisasi_indikator.target_quantity AS realisasi_indikator_target_quantity',
                                    'realisasi_indikator.realisasi_quantity AS realisasi_indikator_realisasi',
                                    'realisasi_indikator.satuan AS realisasi_indikator_satuan',

                                    'realisasi_kegiatan.id AS realisasi_kegiatan_id',
                                    'realisasi_kegiatan.target_angka_kredit AS realisasi_kegiatan_target_ak',
                                    'realisasi_kegiatan.target_quality AS realisasi_kegiatan_target_quality',
                                    'realisasi_kegiatan.target_cost AS realisasi_kegiatan_target_cost',
                                    'realisasi_kegiatan.target_waktu AS realisasi_kegiatan_target_waktu',
                                    'realisasi_kegiatan.realisasi_angka_kredit AS realisasi_kegiatan_realisasi_ak',
                                    'realisasi_kegiatan.realisasi_quality AS realisasi_kegiatan_realisasi_quality',
                                    'realisasi_kegiatan.realisasi_cost AS realisasi_kegiatan_realisasi_cost',
                                    'realisasi_kegiatan.realisasi_waktu AS realisasi_kegiatan_realisasi_waktu',

                                    'realisasi_kegiatan.hitung_quantity',
                                    'realisasi_kegiatan.hitung_quality',
                                    'realisasi_kegiatan.hitung_waktu',
                                    'realisasi_kegiatan.hitung_cost',
                                    'realisasi_kegiatan.akurasi',
                                    'realisasi_kegiatan.ketelitian',
                                    'realisasi_kegiatan.kerapihan',
                                    'realisasi_kegiatan.keterampilan',

                                    'capaian_tahunan.status'
                                   
                                ) 
                        
                        ->get();


       
        $pdf = PDF::loadView('pare_pns.printouts.capaian_tahunan_2', [  
                                                    'kegiatan_list' => $kegiatan_list

                                                    ], [], [
                                                    'format' => 'A4-L'
                                                    ]);
       
        $pdf->getMpdf()->shrink_tables_to_fit = 1;
        $pdf->getMpdf()->setWatermarkImage('assets/images/form/watermark.png');
        $pdf->getMpdf()->showWatermarkImage = true;
        
        $pdf->getMpdf()->SetHTMLFooter('
		<table width="100%">
			<tr>
				<td width="33%"></td>
				<td width="33%" align="center">{PAGENO}/{nbpg}</td>
				<td width="33%" style="text-align: right;"></td>
			</tr>
        </table>');
        //"tpp".$bulan_depan."_".$skpd."
        //return $pdf->stream('TPP'.$p->bulan.'_'.$this::nama_skpd($p->skpd_id).'.pdf');
        //return $pdf->download('PerjanjianKinerja'.$jabatan->PejabatYangDinilai->nip.'_'.Pustaka::tahun($Renja->periode->awal).'.pdf');
        return $pdf->stream('CapaianTahunan.pdf');
    }

}
