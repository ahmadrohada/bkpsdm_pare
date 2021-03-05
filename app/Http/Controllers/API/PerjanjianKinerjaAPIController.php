<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Renja;
use App\Models\Kegiatan;
use App\Models\Tujuan;
use App\Models\Sasaran;
use App\Models\Program;
use App\Models\SubKegiatan;
use App\Models\IndikatorProgram;
use App\Models\IndikatorSasaran;
use App\Models\Pegawai;
use App\Models\Jabatan;
use App\Models\SKPTahunan;

use App\Helpers\Pustaka;
use App\Traits\TraitPerjanjianKinerja;


use Datatables;
use Validator;
use Gravatar;
use Input;
Use PDF;

class PerjanjianKinerjaAPIController extends Controller {

    use TraitPerjanjianKinerja;

    protected function nama_skpd($skpd_id)
    {
        //nama SKPD 
        $nama_skpd       = \DB::table('demo_asn.m_skpd AS skpd')
            ->WHERE('id', $skpd_id)
            ->SELECT(['skpd.skpd AS skpd'])
            ->first();
        return $nama_skpd->skpd;
    }




    public function SasaranStrategisSKPD(Request $request)
    {
        $sasaran = $this->TraitSasaranSKPD($request->renja_id);
       
        $no = 0 ;
        $arrayForTable = array();
        foreach ( $sasaran as $dbValue) {
            $temp = [];
            if(!isset($arrayForTable[$dbValue['sasaran_label']])){
                $arrayForTable[$dbValue['sasaran_label']] = [];
                $no += 1 ;
            }
            $temp['no']         = $no;
            $arrayForTable[$dbValue['sasaran_label']] = $temp;
        }
        $datatables = Datatables::of(collect($sasaran))
                                    ->addColumn('no', function ($x) use($arrayForTable){
                                        return $arrayForTable[$x['sasaran_label']]['no'];
                                    })
                                    ->addColumn('action', function ($x){
                                        return $x['pk_status'];
                                    });

        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }      
        return $datatables->make(true);
    }

 
    public function ProgramSKPD(Request $request) 
    {

        $program = $this->TraitProgramSKPD($request->renja_id);
       
        if ( $program ){
            $no = 0 ;
            foreach ( $program as $dbValue) {
                $temp = [];
                if(!isset($arrayForTable[$dbValue['program_label']])){
                    $arrayForTable[$dbValue['program_label']] = [];
                    $no += 1 ;
                }
                $temp['no']         = $no;
                $arrayForTable[$dbValue['program_label']] = $temp;
            }
            $datatables = Datatables::of(collect($program)) 
                                        ->addColumn('no', function ($x) use($arrayForTable){
                                            return $arrayForTable[$x['program_label']]['no'];
                                        })
                                        ->addColumn('keterangan', function ($x){
                                            return "";
                                        });
    
            if ($keyword = $request->get('search')['value']) {
                $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
            }      
            return $datatables->make(true);
        }else{
            $datatables = Datatables::of(collect($program)) ;
            return $datatables->make(true);
        }

        
    }




    
    
    public function AddSasaranToPK(Request $request)
    {

            $messages = [
                'sasaran_id.required'=> 'Harus diisi'
            ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'sasaran_id' => 'required|numeric|min:1',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $st_update  = Sasaran::find(Input::get('sasaran_id'));

        $st_update->pk_status         = '1';
    
        if ( $st_update->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
    } 


    public function RemoveSasaranFromPK(Request $request)
    {

            $messages = [
                'sasaran_id.required'=> 'Harus diisi'
            ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'sasaran_id' => 'required|numeric|min:1',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $st_update  = Sasaran::find(Input::get('sasaran_id'));

        $st_update->pk_status         = '0';
    
        if ( $st_update->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
    } 


    public function AddIndProgramToPK(Request $request)
    {

            $messages = [
                'ind_program_id.required'=> 'Harus diisi'
            ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'ind_program_id' => 'required|numeric|min:1',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $st_update  = IndikatorProgram::find(Input::get('ind_program_id'));

        $st_update->pk_status         = '1';
    
        if ( $st_update->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
    } 


    public function RemoveIndProgramFromPK(Request $request)
    {

            $messages = [
                'ind_program_id.required'=> 'Harus diisi'
            ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'ind_program_id' => 'required|numeric|min:1',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $st_update  = IndikatorProgram::find(Input::get('ind_program_id'));

        $st_update->pk_status         = '0';
    
        if ( $st_update->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
    } 

    
    public function TotalAnggaranSKPD(Request $request)
    {
        $total = $this->TraitTotalAnggaranSKPD($request->renja_id);
        return $total;
    }


    

    public function SubKegiatanListSKPD(Request $request)
    {
        $sasaran = $this->TraitSubKegiatanListSKPD($request->program_id);
        $datatables = Datatables::of(collect($sasaran));   
        return $datatables->make(true);
    }

    public function AddEsl2SubKegiatanToPK(Request $request)
    {

            $messages = [
                'subkegiatan_id.required'=> 'Harus diisi'
            ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'subkegiatan_id' => 'required|numeric|min:1',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $st_update  = SubKegiatan::find(Input::get('subkegiatan_id'));

        $st_update->esl2_pk_status         = '1';
    
        if ( $st_update->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
    }

    public function RemoveEsl2SubKegiatanFromPK(Request $request)
    {

            $messages = [
                'subkegiatan_id.required'=> 'Harus diisi'
            ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'subkegiatan_id' => 'required|numeric|min:1',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $st_update  = SubKegiatan::find(Input::get('subkegiatan_id'));

        $st_update->esl2_pk_status         = '0';
    
        if ( $st_update->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
    }
    
    public function AddEsl3SubKegiatanToPK(Request $request)
    {

            $messages = [
                'subkegiatan_id.required'=> 'Harus diisi'
            ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'subkegiatan_id' => 'required|numeric|min:1',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $st_update  = SubKegiatan::find(Input::get('subkegiatan_id'));

        $st_update->esl3_pk_status         = '1';
    
        if ( $st_update->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
    }

    public function RemoveEsl3SubKegiatanFromPK(Request $request)
    {

            $messages = [
                'subkegiatan_id.required'=> 'Harus diisi'
            ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'subkegiatan_id' => 'required|numeric|min:1',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $st_update  = SubKegiatan::find(Input::get('subkegiatan_id'));

        $st_update->esl3_pk_status         = '0';
    
        if ( $st_update->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
    }


    public function TotalAnggaranSubKegiatanSKPD(Request $request)
    {
        return $this->TraitTotalAnggaranSubKegiatanSKPD($request->program_id);
    }

    public function cetakPerjanjianKinerjaEsl2(Request $request)
    {

        $jabatan_id     = $request->get('jabatan_id');
        $renja_id       = $request->get('renja_id');
        $skp_tahunan_id = $request->get('skp_tahunan_id');

        
        //NAMA SKPD
        $Renja = Renja::WHERE('renja.id',$renja_id )
                ->leftjoin('demo_asn.tb_history_jabatan AS jabatan', function ($join) {
                    $join->on('jabatan.id', '=', 'renja.kepala_skpd_id');
                })
                ->leftjoin('demo_asn.m_eselon AS eselon', function ($join) {
                    $join->on('eselon.id', '=', 'jabatan.id_eselon');
                })
                ->leftjoin('demo_asn.m_jenis_jabatan AS j_jabatan', function ($join) {
                    $join->on('j_jabatan.id', '=', 'eselon.id_jenis_jabatan');
                })
                ->leftjoin('db_pare_2018.periode AS periode', function ($join) {
                    $join->on('periode.id', '=', 'renja.periode_id');
                })
                ->leftjoin('db_pare_2018.masa_pemerintahan AS masa_pemerintahan', function ($join) {
                    $join->on('masa_pemerintahan.id', '=', 'periode.masa_pemerintahan_id');
                })
                ->SELECT(   'renja.periode_id',
                            'renja.skpd_id',
                            'renja.kepala_skpd_id',
                            'renja.nama_kepala_skpd',
                            'renja.created_at AS tgl_dibuat',
                            'jabatan.nip AS nip_ka_skpd',
                            'j_jabatan.jenis_jabatan AS jenis_jabatan_ka_skpd',
                            'masa_pemerintahan.kepala_daerah AS nama_bupati'
                        )
                ->first();

        //NAMA ADMIN
        $user_x  = \Auth::user();
        $profil  = Pegawai::WHERE('tb_pegawai.id',  $user_x->id_pegawai)->first();

        //JAbatan
        $jabatan = SKPTahunan::WHERE('id',$skp_tahunan_id)->first();
        

        $pdf = PDF::loadView('pare_pns.printouts.cetak_perjanjian_kinerja-Eselon2', [   
                                                    'sasaran_list'  => $this->TraitSasaranSKPD($renja_id), 
                                                    'program_list'  => $this->TraitProgramSKPD($renja_id),
                                                    'total_anggaran'=> $this->TraitTotalAnggaranSKPD($renja_id),
                                                    'tgl_dibuat'    => $Renja->tgl_dibuat,
                                                    'periode'       => Pustaka::tahun($Renja->periode->awal),
                                                    'nama_skpd'     => $this::nama_skpd($Renja->skpd_id),
                                                    //DATA ASN YANG DINILAI
                                                    'nama_pejabat'  => $jabatan->u_nama,
                                                    'nip_pejabat'   => $jabatan->PegawaiYangDinilai->nip,
                                                    'jenis_jabatan' => $jabatan->PegawaiYangDinilai->Eselon->JenisJabatan->jenis_jabatan,
                                                    'jabatan'       => $jabatan->PegawaiYangDinilai->jabatan,
                                                    //DATA ASN PNILAI
                                                    'nama_atasan'  => $jabatan->p_nama,
                                                    'nip_atasan'   => $jabatan->PejabatPenilai?$jabatan->PejabatPenilai->nip:"",
                                                    'jenis_jabatan_atasan' => $jabatan->PejabatPenilai?$jabatan->PejabatPenilai->Eselon->JenisJabatan->jenis_jabatan:"",
                                                    'jabatan_atasan'       => $jabatan->PejabatPenilai?$jabatan->PejabatPenilai->jabatan:"",
                                                    //DATA KA SKPD
                                                    'nama_ka_skpd'  => $Renja->nama_kepala_skpd,
                                                    'nip_ka_skpd'   => $Renja->nip_ka_skpd,
                                                    'jenis_jabatan_ka_skpd'=> $Renja->jenis_jabatan_ka_skpd,
                                                    'nama_bupati'   => $Renja->nama_bupati,
                                                    'waktu_cetak'   => Pustaka::balik(date('Y'."-".'m'."-".'d'))." / ". date('H'.":".'i'.":".'s'),

                                                     ], [], [
                                                     'format' => 'A4-P'
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
        return $pdf->download('PerjanjianKinerja'.$Renja->nip_ka_skpd.'_'.Pustaka::tahun($Renja->periode->awal).'.pdf');
    }

    public function cetakPerjanjianKinerjaSKPD(Request $request)
    {

       
        $renja_id       = $request->get('renja_id');
        
        //NAMA SKPD
        $Renja = Renja::WHERE('renja.id',$renja_id )
                ->leftjoin('demo_asn.tb_history_jabatan AS jabatan', function ($join) {
                    $join->on('jabatan.id', '=', 'renja.kepala_skpd_id');
                })
                ->leftjoin('demo_asn.m_eselon AS eselon', function ($join) {
                    $join->on('eselon.id', '=', 'jabatan.id_eselon');
                })
                ->leftjoin('demo_asn.m_jenis_jabatan AS j_jabatan', function ($join) {
                    $join->on('j_jabatan.id', '=', 'eselon.id_jenis_jabatan');
                })
                ->leftjoin('db_pare_2018.periode AS periode', function ($join) {
                    $join->on('periode.id', '=', 'renja.periode_id');
                })
                ->leftjoin('db_pare_2018.masa_pemerintahan AS masa_pemerintahan', function ($join) {
                    $join->on('masa_pemerintahan.id', '=', 'periode.masa_pemerintahan_id');
                })
                ->SELECT(   'renja.periode_id',
                            'renja.skpd_id',
                            'renja.kepala_skpd_id',
                            'renja.nama_kepala_skpd',
                            'renja.created_at AS tgl_dibuat',
                            'jabatan.nip AS nip_ka_skpd',
                            'j_jabatan.jenis_jabatan AS jenis_jabatan_ka_skpd',
                            'masa_pemerintahan.kepala_daerah AS nama_bupati'
                        )
                ->first();

        //NAMA ADMIN
        $user_x  = \Auth::user();
        $profil  = Pegawai::WHERE('tb_pegawai.id',  $user_x->id_pegawai)->first();

        //JAbatan
        //$jabatan = SKPTahunan::WHERE('id',$skp_tahunan_id)->first();
        

        $pdf = PDF::loadView('pare_pns.printouts.cetak_perjanjian_kinerja-Eselon2', [   
                                                    'sasaran_list'  => $this->TraitSasaranSKPD($renja_id), 
                                                    'program_list'  => $this->TraitProgramSKPD($renja_id),
                                                    'total_anggaran'=> $this->TraitTotalAnggaranSKPD($renja_id),
                                                    'tgl_dibuat'    => $Renja->tgl_dibuat,
                                                    'periode'       => Pustaka::tahun($Renja->periode->awal),
                                                    'periode'       => Pustaka::tahun($Renja->periode->awal),
                                                    'nama_skpd'     => $this::nama_skpd($Renja->skpd_id),
                                                    //DATA ASN YANG DINILAI
                                                    'nama_pejabat'  => $Renja->nama_kepala_skpd,
                                                    'nip_pejabat'   => $Renja->nip_ka_skpd,
                                                    'jenis_jabatan' => $Renja->jenis_jabatan_ka_skpd,
                                                    'jabatan'       => "Kepala ".Pustaka::capital_string($this::nama_skpd($Renja->skpd_id)),
                                                    //DATA ASN PNILAI
                                                    'nama_atasan'  => "",
                                                    'nip_atasan'   => "",
                                                    'jenis_jabatan_atasan' => "",
                                                    'jabatan_atasan'       => "",
                                                    //DATA KA SKPD
                                                    'nama_ka_skpd'  => $Renja->nama_kepala_skpd,
                                                    'nip_ka_skpd'   => $Renja->nip_ka_skpd,
                                                    'jenis_jabatan_ka_skpd'=> $Renja->jenis_jabatan_ka_skpd,
                                                    'nama_bupati'   => $Renja->nama_bupati,
                                                    'waktu_cetak'   => Pustaka::balik(date('Y'."-".'m'."-".'d'))." / ". date('H'.":".'i'.":".'s'),

                                                   

                                                     ], [], [
                                                     'format' => 'A4-P'
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
        //return $pdf->stream('PerjanjianKinerja'.$Renja->nip_ka_skpd.'_'.Pustaka::tahun($Renja->periode->awal).'.pdf');
        return $pdf->stream('PerjanjianKinerja'.$Renja->nip_ka_skpd.'_'.Pustaka::tahun($Renja->periode->awal).'.pdf');
    }


    //SASARAN Perjajian kinerja nya kabid nih pa
    public function SasaranStrategisEselon3(Request $request)
    {
        //sasran nya esl 3 adalah program

        $program = $this->TraitSasaranEselon3($request->skp_tahunan_id);
       
        $no = 0 ;
        foreach ( $program as $dbValue) {
            $temp = [];
            if(!isset($arrayForTable[$dbValue['program_label']])){
                $arrayForTable[$dbValue['program_label']] = [];
                $no += 1 ;
            }
            $temp['no']         = $no;
            $arrayForTable[$dbValue['program_label']] = $temp;
        }
        $datatables = Datatables::of(collect($program))
                                    ->addColumn('no', function ($x) use($arrayForTable){
                                        return $arrayForTable[$x['program_label']]['no'];
                                    });    
        return $datatables->make(true);


    }

    public function ProgramEselon3(Request $request)
    {
        //program PK nya eslon 3 adalah kegiatan
        return Datatables::of(collect($this->TraitProgramEselon3($request->skp_tahunan_id)))->make(true);
    }

    public function TotalAnggaranEselon3(Request $request)
    {
        return $this->TraitTotalAnggaranSubKegiatanEselon3($request->skp_tahunan_id);
    }


    public function cetakPerjanjianKinerjaEsl3(Request $request)
    {
        $skp_tahunan_id = $request->get('skp_tahunan_id');
        $skp_tahunan    = SKPTahunan::WHERE('id',$skp_tahunan_id)->first();
        $renja_id       = $skp_tahunan->Renja->id;

       
       

        //NAMA SKPD
        $Renja = Renja::WHERE('renja.id',$renja_id )
                ->leftjoin('demo_asn.tb_history_jabatan AS jabatan', function ($join) {
                    $join->on('jabatan.id', '=', 'renja.kepala_skpd_id');
                })
                ->leftjoin('demo_asn.m_eselon AS eselon', function ($join) {
                    $join->on('eselon.id', '=', 'jabatan.id_eselon');
                })
                ->leftjoin('demo_asn.m_jenis_jabatan AS j_jabatan', function ($join) {
                    $join->on('j_jabatan.id', '=', 'eselon.id_jenis_jabatan');
                })
                ->leftjoin('db_pare_2018.periode AS periode', function ($join) {
                    $join->on('periode.id', '=', 'renja.periode_id');
                })
                ->leftjoin('db_pare_2018.masa_pemerintahan AS masa_pemerintahan', function ($join) {
                    $join->on('masa_pemerintahan.id', '=', 'periode.masa_pemerintahan_id');
                })
                ->SELECT(   'renja.periode_id',
                            'renja.skpd_id',
                            'renja.kepala_skpd_id',
                            'renja.nama_kepala_skpd',
                            'renja.created_at AS tgl_dibuat',
                            'jabatan.nip AS nip_ka_skpd',
                            'j_jabatan.jenis_jabatan AS jenis_jabatan_ka_skpd',
                            'masa_pemerintahan.kepala_daerah AS nama_bupati'
                        )
                ->first();

        //NAMA ADMIN
        $user_x  = \Auth::user();
        $profil  = Pegawai::WHERE('tb_pegawai.id',  $user_x->id_pegawai)->first();

        //JAbatan
        $jabatan = SKPTahunan::WHERE('id',$skp_tahunan_id)->first();
        $pdf = PDF::loadView('pare_pns.printouts.cetak_perjanjian_kinerja-Eselon3', [   
                                                    'program_list'  => $this->TraitSasaranEselon3($skp_tahunan_id), 
                                                    'subkegiatan_list'  => $this->TraitProgramEselon3($skp_tahunan_id),
                                                    'total_anggaran'=> $this->TraitTotalAnggaranSubKegiatanEselon3($skp_tahunan_id),
                                                    'tgl_dibuat'    => $Renja->tgl_dibuat,
                                                    'periode'       => Pustaka::tahun($Renja->periode->awal),
                                                    'nama_skpd'     => $this::nama_skpd($Renja->skpd_id),
                                                    //DATA ASN YANG DINILAI
                                                    'nama_pejabat'  => $jabatan->u_nama,
                                                    'nip_pejabat'   => $jabatan->PegawaiYangDinilai->nip,
                                                    'jenis_jabatan' => $jabatan->PegawaiYangDinilai->Eselon->JenisJabatan->jenis_jabatan,
                                                    'jabatan'       => $jabatan->PegawaiYangDinilai->jabatan,
                                                    //DATA ASN PNILAI
                                                    'nama_atasan'  => $jabatan->p_nama,
                                                    'nip_atasan'   => $jabatan->PejabatPenilai->nip,
                                                    'jenis_jabatan_atasan' => $jabatan->PejabatPenilai->Eselon->JenisJabatan->jenis_jabatan,
                                                    'jabatan_atasan'       => $jabatan->PejabatPenilai->jabatan,
                                                    //DATA KA SKPD
                                                    'nama_ka_skpd'  => $Renja->nama_kepala_skpd,
                                                    'nip_ka_skpd'   => $Renja->nip_ka_skpd,
                                                    'jenis_jabatan_ka_skpd'=> $Renja->jenis_jabatan_ka_skpd,
                                                    'nama_bupati'   => $Renja->nama_bupati,
                                                    'waktu_cetak'   => Pustaka::balik(date('Y'."-".'m'."-".'d'))." / ". date('H'.":".'i'.":".'s'),


                                                     ], [], [
                                                     'format' => 'A4-P'
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
        return $pdf->download('PerjanjianKinerja'.$jabatan->PegawaiYangDinilai->nip.'_'.Pustaka::tahun($Renja->periode->awal).'.pdf');
    }


    
    public function SasaranStrategisEselon4(Request $request) 
    {
        //sasran nya esl 4 adalah SUbKegiatan

        $subkegiatan = $this->TraitSasaranEselon4($request->skp_tahunan_id);
       
        if ( $subkegiatan ){
            $no = 0 ;
            foreach ( $subkegiatan as $dbValue) {
                $temp = [];
                if(!isset($arrayForTable[$dbValue['subkegiatan_label']])){
                    $arrayForTable[$dbValue['subkegiatan_label']] = [];
                    $no += 1 ;
                }
                $temp['no']         = $no;
                $arrayForTable[$dbValue['subkegiatan_label']] = $temp;
            }
            $datatables = Datatables::of(collect($subkegiatan))
                                        ->addColumn('no', function ($x) use($arrayForTable){
                                            return $arrayForTable[$x['subkegiatan_label']]['no'];
                                        });    
            return $datatables->make(true);
        }else{
            $datatables = Datatables::of(collect($subkegiatan));
               
            return $datatables->make(true);
        } 
    }

    public function ProgramEselon4(Request $request)
    {
        return Datatables::of(collect($this->TraitProgramEselon4($request->skp_tahunan_id)))->make(true);
    }

     
    public function TotalAnggaranEselon4(Request $request)
    {
        return $this->TraitTotalAnggaranSubKegiatanEselon4($request->skp_tahunan_id);
    }
    

    public function AddEsl4SubKegiatanToPK(Request $request)
    {

            $messages = [
                'subkegiatan_id.required'=> 'Harus diisi'
            ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'subkegiatan_id' => 'required|numeric|min:1',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $st_update  = SubKegiatan::find(Input::get('subkegiatan_id'));

        $st_update->esl4_pk_status         = '1';
    
        if ( $st_update->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
    }

    public function RemoveEsl4SubKegiatanFromPK(Request $request)
    {

            $messages = [
                'subkegiatan_id.required'=> 'Harus diisi'
            ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'subkegiatan_id' => 'required|numeric|min:1',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $st_update  = SubKegiatan::find(Input::get('subkegiatan_id'));

        $st_update->esl4_pk_status         = '0';
    
        if ( $st_update->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
    }

    

    public function cetakPerjanjianKinerjaEsl4(Request $request)
    {
        $jabatan_id     = $request->get('jabatan_id');
        $renja_id       = $request->get('renja_id');
        $skp_tahunan_id = $request->get('skp_tahunan_id');
       

        //NAMA SKPD
        $Renja = Renja::WHERE('renja.id',$renja_id )
                ->leftjoin('demo_asn.tb_history_jabatan AS jabatan', function ($join) {
                    $join->on('jabatan.id', '=', 'renja.kepala_skpd_id');
                })
                ->leftjoin('demo_asn.m_eselon AS eselon', function ($join) {
                    $join->on('eselon.id', '=', 'jabatan.id_eselon');
                })
                ->leftjoin('demo_asn.m_jenis_jabatan AS j_jabatan', function ($join) {
                    $join->on('j_jabatan.id', '=', 'eselon.id_jenis_jabatan');
                })
                ->leftjoin('db_pare_2018.periode AS periode', function ($join) {
                    $join->on('periode.id', '=', 'renja.periode_id');
                })
                ->leftjoin('db_pare_2018.masa_pemerintahan AS masa_pemerintahan', function ($join) {
                    $join->on('masa_pemerintahan.id', '=', 'periode.masa_pemerintahan_id');
                })
                ->SELECT(   'renja.periode_id',
                            'renja.skpd_id',
                            'renja.kepala_skpd_id',
                            'renja.nama_kepala_skpd',
                            'renja.created_at AS tgl_dibuat',
                            'jabatan.nip AS nip_ka_skpd',
                            'j_jabatan.jenis_jabatan AS jenis_jabatan_ka_skpd',
                            'masa_pemerintahan.kepala_daerah AS nama_bupati'
                        )
                ->first();

        //NAMA ADMIN
        $user_x  = \Auth::user();
        $profil  = Pegawai::WHERE('tb_pegawai.id',  $user_x->id_pegawai)->first();

        //JAbatan
        $jabatan = SKPTahunan::WHERE('id',$skp_tahunan_id)->first();
        

       $pdf = PDF::loadView('pare_pns.printouts.cetak_perjanjian_kinerja-Eselon4', [   
                                                    'sasaran_list'  => $this->TraitSasaranEselon4($skp_tahunan_id), 
                                                    'subkegiatan_list'  => $this->TraitProgramEselon4($skp_tahunan_id),
                                                    'total_anggaran'=> $this->TraitTotalAnggaranSubKegiatanEselon4($skp_tahunan_id),
                                                    'tgl_dibuat'    => $Renja->tgl_dibuat,
                                                    'periode'       => Pustaka::tahun($Renja->periode->awal),
                                                    'nama_skpd'     => $this::nama_skpd($Renja->skpd_id),
                                                    //DATA ASN YANG DINILAI
                                                    'nama_pejabat'  => $jabatan->u_nama,
                                                    'nip_pejabat'   => $jabatan->PegawaiYangDinilai->nip,
                                                    'jenis_jabatan' => $jabatan->PegawaiYangDinilai->Eselon->JenisJabatan->jenis_jabatan,
                                                    'jabatan'       => $jabatan->PegawaiYangDinilai->jabatan,
                                                    //DATA ASN PNILAI
                                                    'nama_atasan'  => $jabatan->p_nama,
                                                    'nip_atasan'   => $jabatan->PejabatPenilai->nip,
                                                    'jenis_jabatan_atasan' => $jabatan->PejabatPenilai->Eselon->JenisJabatan->jenis_jabatan,
                                                    'jabatan_atasan'       => $jabatan->PejabatPenilai->jabatan,
                                                    //DATA KA SKPD
                                                    'nama_ka_skpd'  => $Renja->nama_kepala_skpd,
                                                    'nip_ka_skpd'   => $Renja->nip_ka_skpd,
                                                    'jenis_jabatan_ka_skpd'=> $Renja->jenis_jabatan_ka_skpd,
                                                    'nama_bupati'   => $Renja->nama_bupati,
                                                    'waktu_cetak'   => Pustaka::balik(date('Y'."-".'m'."-".'d'))." / ". date('H'.":".'i'.":".'s'),


                                                     ], [], [
                                                     'format' => 'A4-P'
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
        return $pdf->download('PerjanjianKinerja'.$jabatan->PegawaiYangDinilai->nip.'_'.Pustaka::tahun($Renja->periode->awal).'.pdf');
    }

    /* public function PerjanjianKinerjaTimelineStatus( Request $request )
    {
        $response = array();
        $body = array();
        $body_2 = array();


        $renja = PerjanjianKinerja::where('id','=', $request->perjanjian_kinerja_id )
                                ->select('*')
                                ->firstOrFail();

        
        //CREATED AT - Dibuat
        $x['tag']	    = 'p';
        $x['content']	= 'Dibuat';
        array_push($body, $x);
        $x['tag']	    = 'p';
        $x['content']	= $renja->nama_admin_skpd;
        array_push($body, $x);

        //CREATED AT - Dibuat
        $x['tag']	    = 'p';
        $x['content']	= 'Kepala SKPD';
        array_push($body, $x);
        $x['tag']	    = 'p';
        $x['content']	= $renja->nama_kepala_skpd;
        array_push($body, $x);

        $h['time']	    = $renja->created_at->format('Y-m-d H:i:s');
        $h['body']	    = $body;
        array_push($response, $h);
        //=====================================================================//

        //UPDATED AT - Dikirim
        $y['tag']	    = 'p';
        $y['content']	= 'Dikirim';
        array_push($body_2, $y);
        $y['tag']	    = 'p';
        $y['content']	= $renja->nama_admin_skpd;
        array_push($body_2, $y);

        $i['time']	    = $renja->updated_at->format('Y-m-d H:i:s');
        $i['body']	    = $body_2;

        if ( $renja->updated_at->format('Y') > 1 )
        {
            array_push($response, $i);
        }
        


        return $response;


    }

    public function SKPDPerjanjianKinerja_list(Request $request)
    {
            
        $dt = \DB::table('db_pare_2018.renja AS renja')
                   
                    ->rightjoin('db_pare_2018.perjanjian_kinerja AS pk', function($join){
                        $join   ->on('pk.renja_id','=','renja.id');
                    }) //ID KEPALA SKPD
                    ->leftjoin('demo_asn.tb_history_jabatan AS id_ka_skpd', function($join){
                        $join   ->on('id_ka_skpd.id','=','renja.kepala_skpd_id');
                    })
                    //NAMA KEPALA SKPD
                    ->leftjoin('demo_asn.tb_pegawai AS kepala_skpd', function($join){
                        $join   ->on('kepala_skpd.id','=','id_ka_skpd.id_pegawai');
                    })//PERIODE
                    ->join('db_pare_2018.periode AS periode', function($join){
                        $join   ->on('periode.id','=','renja.periode_id');
                        
                    })

                    ->select([  'pk.id AS pk_id',
                                'periode.label AS periode',
                                'kepala_skpd.nama',
                                'kepala_skpd.gelardpn',
                                'kepala_skpd.gelarblk',
                                'renja.status'
                                
                        ])
                    ->where('renja.skpd_id','=', $request->skpd_id);

       
                    $datatables = Datatables::of($dt)
                    ->addColumn('status', function ($x) {
            
                        return $x->status;
            
                    })->addColumn('periode', function ($x) {
                        
                        return $x->periode;
                    
                    })->addColumn('kepala_skpd', function ($x) {
                        
                        return Pustaka::nama_pegawai($x->gelardpn , $x->nama , $x->gelarblk);
                    
                    })->addColumn('skpd', function ($x) {
                        
                        //return Pustaka::capital_string($x->skpd);
                    
                    });
            
                    
                    if ($keyword = $request->get('search')['value']) {
                        $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
                    } 
            
                    return $datatables->make(true);
        
    }


    public function SKPDPerjanjianKinerjaBreadcrumb(Request $request)
    {
        
        $perjanjian_kinerja	= PerjanjianKinerja::where('id', '=', Request('perjanjian_kinerja_id') )->firstOrFail();

        $data            = SasaranPerjanjianKinerja::where('perjanjian_kinerja_id',$perjanjian_kinerja->id);
        $sasaran         = $data->count();


        
        $jm_indikator_sasaran   = 0;
        $jm_program             = 0 ;
        $jm_indikator_program   = 0 ;
        $jm_kegiatan            = 0 ;
        $jm_indikator_kegiatan  = 0 ;
        $publish_status         = 1 ;

        if ( $sasaran == 0){
            $publish_status =  $publish_status * 0;
        }

        //JUMLAH INDIKATOR SASARAN
        foreach ( $data->get() as $dt) {
            $ind_sasaran = IndikatorSasaran::where('sasaran_perjanjian_kinerja_id',$dt->id);

            //JUMLAH PROGRAM
            foreach( $ind_sasaran->get() as  $x ) {
                $program = Program::where('indikator_sasaran_id',$x->id);

                //JUMLAH INDIKATOR PROGRAM
                foreach( $program->get() as  $y ) {
                    $indikator_program = IndikatorProgram::where('program_id',$y->id);

                    //JUMLAH KEGIATAN
                    foreach( $indikator_program->get() as  $z ) {
                        $kegiatan = Kegiatan::where('indikator_program_id',$z->id);

                        //JUMLAH INDIKATOR KEGIATAN
                        foreach( $kegiatan->get() as  $a ) {
                            $indikator_kegiatan = IndikatorKegiatan::where('kegiatan_id',$a->id);
                            $jm_indikator_kegiatan = $jm_indikator_kegiatan+$indikator_kegiatan->count();
                            if ( $indikator_kegiatan->count() == 0 ){
                                $publish_status =  $publish_status * 0;
                            }
                        }  
                        $jm_kegiatan = $jm_kegiatan+$kegiatan->count();
                        if ( $kegiatan->count() == 0 ){
                            $publish_status =  $publish_status * 0;
                        }
                    }  
                    $jm_indikator_program = $jm_indikator_program+$indikator_program->count();
                    if ( $indikator_program->count() == 0 ){
                        $publish_status =  $publish_status * 0;
                    }
                }  
                $jm_program = $jm_program+$program->count();
                if ( $program->count() == 0 ){
                    $publish_status =  $publish_status * 0;
                }
            } 

            $jm_indikator_sasaran = $jm_indikator_sasaran+$ind_sasaran->count();
            if ( $ind_sasaran->count() == 0 ){
                $publish_status =  $publish_status * 0;
            }
            
        }

        

        return ( [
            //'perjanjian_kinerja_id'=> $perjanjian_kinerja,
            'data'                 => $data->select('id')->get(),
            'sasaran'              => $sasaran,
            'indikator_sasaran'    => $jm_indikator_sasaran,
            'program'              => $jm_program,
            'indikator_program'    => $jm_indikator_program,
            'kegiatan'             => $jm_kegiatan,
            'indikator_kegiatan'   => $jm_indikator_kegiatan,
            'publish_status'       => $publish_status,
            
              ]);
        
    }



    public function Store()
    {

        $pk = new PerjanjianKinerja;
        $pk->skpd_id                 = Input::get('skpd_id');
        $pk->periode_tahunan_id      = Input::get('periode_tahunan_id');
        $pk->active                  = '0';

        

        if ( $pk->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        }
        
       
    } */






}
