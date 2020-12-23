<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\CapaianBulanan;
use App\Models\CapaianTahunan;

use App\Models\Kegiatan;
use App\Models\UnsurPenunjangTugasTambahan;
use App\Models\UnsurPenunjangKreativitas;


use App\Models\Jabatan;
use App\Helpers\Pustaka;

use Illuminate\Http\Request;

use App\Traits\PJabatan;
use App\Traits\HitungCapaian; 
use App\Traits\PenilaianPerilakuKerja;

use PDF;
use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class CapaianTahunanController extends Controller {

    use PJabatan; 
    use HitungCapaian;
    use PenilaianPerilakuKerja;

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
       
        $capaian_id = $request->capaian_tahunan_id;
        $data       = CapaianTahunan::WHERE('id',$capaian_id)->first();
        $renja_id   = $data->SKPTahunan->renja_id;    
        $jabatan_id = $data->PejabatYangDinilai->id_jabatan;

        //return $data->PejabatYangDinilai->Eselon->id_jenis_jabatan;



        //KEGIATAN
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
        //UNSUR PENUNJANG Tugas Tambahan
        $unsur_penunjang_tugas_tambahan_list = UnsurPenunjangTugasTambahan::where('capaian_tahunan_id', '=' ,$capaian_id)
                                                                            ->select([   
                                                                                'id AS tugas_tambahan_id',
                                                                                'label AS tugas_tambahan_label',
                                                                                'approvement'
                                                                            ])->get();   

        $unsur_penunjang_kreativitas_list = UnsurPenunjangKreativitas::where('capaian_tahunan_id', '=' ,$capaian_id )
                                                                ->select([   
                                                                    'id AS kreativitas_id',
                                                                    'label AS kreativitas_label',
                                                                    'nilai AS kreativitas_nilai',
                                                                    'manfaat_id',
                                                                    'approvement'
                                                                ])->get();

        //==========================  HITUNG CAPAIAN SKP ===========================================================//
        $data_kinerja             = $this->hitung_capaian_tahunan($capaian_id); 
        //========================== PEnilaian Perilaku kekerja  ===================================================//
        $penilaian_perilaku_kerja = $this->NilaiPerilakuKerja($capaian_id);

        //Pejabat Yang dinilai
        $pejabat_yang_dinilai = array(
            'nama'          => $data->u_nama,
            'nip'           => $data->PejabatYangDinilai->nip,
            'pgr'           => $data->PejabatYangDinilai->Golongan->pangkat.' / ('.$data->PejabatYangDinilai->Golongan->golongan.' )',
            'jabatan'       => Pustaka::capital_string($data->PejabatYangDinilai->jabatan),
            'unit_kerja'    => Pustaka::capital_string($data->PejabatYangDinilai->UnitKerja->unit_kerja),
            
        );

        //Pejabat Penilai
        $pejabat_penilai = array(
            'nama'          => $data->p_nama,
            'nip'           => $data->PejabatPenilai->nip,
            'pgr'           => $data->PejabatPenilai->Golongan->pangkat.' / ('.$data->PejabatPenilai->Golongan->golongan.' )',
            'jabatan'       => Pustaka::capital_string($data->PejabatPenilai->jabatan),
            'unit_kerja'    => Pustaka::capital_string($data->PejabatPenilai->UnitKerja->unit_kerja),
            
        );

        //Atasan Pejabat Penilai
        $atasan_pejabat_penilai = array(
            'nama'          => '',
            'nip'           => '',
            'pgr'           => '',
            'jabatan'       => '',
            'unit_kerja'    => '',
            
        );

        $user      = \Auth::user();
        $pegawai   = $user->pegawai;   
        $tgl = date('Y'."-".'m'."-".'d');
        $waktu = date('H'.":".'i'.":".'s');

        $pdf = PDF::loadView('pare_pns.printouts.capaian_tahunan', [  
                                                                'user'                                      => $pegawai->nama,
                                                                'tgl_cetak'                                 => Pustaka::balik($tgl).' / '.$waktu,
                                                                'data'                                      => $data,
                                                                'nama_skpd'                                 => $data->PejabatYangDinilai->SKPD->skpd,
                                                                'kegiatan_list'                             => $kegiatan_list,
                                                                'kegiatan_list'                             => $kegiatan_list,
                                                                'unsur_penunjang_tugas_tambahan_list'       => $unsur_penunjang_tugas_tambahan_list,
                                                                'unsur_penunjang_kreativitas_list'          => $unsur_penunjang_kreativitas_list,
                                                                'data_kinerja'                              => $data_kinerja,
                                                                'penilaian_perilaku_kerja'                  => $penilaian_perilaku_kerja,
                                                                'pejabat_yang_dinilai'                      => $pejabat_yang_dinilai,
                                                                'pejabat_penilai'                           => $pejabat_penilai,
                                                                'atasan_pejabat_penilai'                    => $atasan_pejabat_penilai,
                                                                'tgl_dibuat'                                => Pustaka::balik2($data->created_at),
                                                                'masa_penilaian'                            => Pustaka::balik2($data->tgl_mulai) .' s.d '.Pustaka::balik2($data->tgl_selesai) ,

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
        return $pdf->download('CapaianTahunan_'.$pejabat_yang_dinilai['nip'].'.pdf');
    }

}
