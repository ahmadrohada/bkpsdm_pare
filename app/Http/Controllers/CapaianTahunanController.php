<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\CapaianBulanan;
use App\Models\CapaianTahunan;
use App\Models\SKPD;
use App\Models\Periode;

use App\Models\Kegiatan;
use App\Models\UnsurPenunjangTugasTambahan;
use App\Models\UnsurPenunjangKreativitas;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

use App\Models\Jabatan;
use App\Helpers\Pustaka;

use Illuminate\Http\Request;

use App\Traits\PJabatan;
use App\Traits\HitungCapaian; 
use App\Traits\TraitCapaianTahunan;


use PDF;
use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class CapaianTahunanController extends Controller {

    use PJabatan; 
    use HitungCapaian;
    use TraitCapaianTahunan;

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
        
        if ( $pegawai->JabatanAktif->Eselon->id_jenis_jabatan <= 5 ) {
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
       
        $capaian_id = $request->capaian_tahunan_id;
			
        $user       = \Auth::user();
        $pegawai    = $user->pegawai;   
        $tgl        = date('Y'."-".'m'."-".'d');
        $waktu      = date('H'.":".'i'.":".'s');

        $pdf = PDF::loadView('pare_pns.printouts.capaian_tahunan', [  
                                                                'user'                                      => $pegawai->nama,
                                                                'tgl_cetak'                                 => Pustaka::balik($tgl).' / '.$waktu,
                                                                'kegiatan_list'                             => $this->Kegiatan($capaian_id),
                                                                'unsur_penunjang_tugas_tambahan_list'       => $this->UnsurPenunjangTugasTambahan($capaian_id),
                                                                'unsur_penunjang_kreativitas_list'          => $this->UnsurPenunjangKreativitas($capaian_id),
                                                                'sumary'                                    => $this->Sumary($capaian_id),
                                                                'penilaian_perilaku_kerja'                  => $this->NilaiPerilakuKerja($capaian_id),
                                                                'pejabat'                                   => $this->Pejabat($capaian_id),

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
        return $pdf->download('CapaianTahunan_'.$pejabat['u_nip'].'.pdf'); 


        

    }


    public function showSKPDCapaianTahunanELapkin(Request $request)
    {
            
        
        //$user                     = \Auth::user();
        //$capaian_tahunan          = CapaianTahunan::WHERE('id', $request->capaian_tahunan_id)->first();
        $skpd = SKPD::WHERE('id',$request->skpd_id)->first();
        $periode = Periode::WHERE('id',$request->periode_id)->first();

        return view('pare_pns.pages.administrator-capaian_tahunan_elapkin', [
                                                                            
                                                                            'periode'   => Pustaka::periode_tahun($periode->label),
                                                                            'skpd'      => $skpd->skpd,
                                                                            'skpd_id'   => $request->skpd_id,
                                                                            'periode_id'=> $request->periode_id,
                                                                            'h_box'     => 'box-teal',
                                                                            
                                                                            ]);  
         
    }

}
