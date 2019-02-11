<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PeriodeTahunan;
use App\Models\PerjanjianKinerja;


use App\Models\Tujuan;
use App\Models\IndikatorTujuan;
use App\Models\Sasaran;
use App\Models\Skpd;
use App\Models\Renja;
use App\Models\Periode;
use App\Models\Pegawai;


use App\Models\SasaranPerjanjianKinerja;
use App\Models\IndikatorSasaran;
use App\Models\Program;
use App\Models\IndikatorProgram;
use App\Models\Kegiatan;
use App\Models\IndikatorKegiatan;
use App\Models\PetaJabatan;
use App\Models\MasaPemerintahan;

use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class RenjaAPIController extends Controller {


    
    public function ConfirmRenja( Request $request )
    {

        $renja_count    = Renja::WHERE('skpd_id', $request->get('skpd_id'))
                                ->WHERE('periode_id',$request->get('periode_id'))
                                ->count();

        if ($renja_count == 0 ){

            //PEIRODE
            $periode = Periode::WHERE('id',$request->get('periode_id'))->first();

            //KABAN
            $kaban = SKPD::WHERE('parent_id', '=',$request->skpd_id )->first();
            $pegawai =  $kaban->pejabat->pegawai;

            //ADMIN
            $admin = Pegawai::WHERE('id',$request->admin_id)->first();

            $data = array(
                'status'			    => 'pass',
                
                'periode_label'	        => $periode->label,
                'skpd_id'	            => $request->get('skpd_id'),

                'kaban_jabatan_id'	    => $pegawai->JabatanAktif->id,
                'kaban_nip'	            => $pegawai->nip,
                'kaban_nama'	        => Pustaka::nama_pegawai($pegawai->gelardpn , $pegawai->nama , $pegawai->gelarblk),
                'kaban_pangkat'	        => $pegawai->JabatanAktif->golongan->golongan,
                'kaban_golongan'	    => $pegawai->JabatanAktif->golongan->pangkat,
                'kaban_eselon'	        => $pegawai->JabatanAktif->eselon->eselon,
                'kaban_jabatan'	        => Pustaka::capital_string($pegawai->JabatanAktif->Jabatan->skpd),

                'admin_nama'            => Pustaka::nama_pegawai($admin->gelardpn , $admin->nama , $admin->gelarblk),
                'admin_jabatan_id'	    => $admin->JabatanAktif->id,
                
            );

            return $data;
        }else{
            return \Response::make('error', 500);
        }

    }



    public function RenjaTimelineStatus( Request $request )
    {
        $response = array();
        $body = array();
        $body_2 = array();


        $renja = Renja::where('id','=', $request->renja_id )
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

        if ( $renja->send_to_kaban == 1 )
        {
            array_push($response, $i);
        }
        
        


        return $response;


    }


    public function RenjaStatusPengisian( Request $request )
    {
       
        $button_kirim = 0 ;


        $renja = Renja::
                            leftjoin('demo_asn.tb_history_jabatan AS kaban', function($join){
                                $join   ->on('kaban.id','=','renja.kepala_skpd_id');
                            })
                            ->SELECT('kaban.id AS kaban_id',
                                    'renja.created_at AS created',
                                    'renja.id AS renja_id')
                            ->where('renja.id','=', $request->renja_id )->first();

      
        //STATUS KEPALA SKPD
        if ( $renja->kaban_id != null ){
            $data_kepala_skpd = 'ok';
        }else{
            $data_kepala_skpd = '-';
        }

        //created
        if ( $renja->renja_id != null ){
            $created = 'ok';
        }else{
            $created = '-';
        }

        //button kirim
        if ( ( $created == 'ok') && ( $data_kepala_skpd == 'ok') ){
            $button_kirim = 1 ;
        }else{
            $button_kirim = 0 ;
        }
        
         //STATUS APPROVE
         if ( ($renja->status_approve) == 1 ){
            $data_persetujuan_kaban = 'ok';
        }else{
            $data_persetujuan_kaban = '-';
        }


        $response = array(
                'created'                 => $created,
                'data_kepala_skpd'        => $data_kepala_skpd,
                'data_persetujuan_kaban'  => $data_persetujuan_kaban,
                'button_kirim'            => $button_kirim


        );
       
        return $response;


    }


    public function SKPDRenjaList(Request $request)
    {
       
        $skpd_id = $request->skpd_id;
        $dt = Periode::
                
                        leftjoin('db_pare_2018.renja AS renja', function($join) use($skpd_id) { 
                            $join   ->on('renja.periode_id','=','periode.id');
                            $join   ->WHERE('renja.skpd_id','=',$skpd_id);
                            
                        })
                        ->WHERE('periode.awal','>','2018-01-01')
                        ->SELECT('periode.id AS periode_id',
                                 'periode.label AS periode_label',
                                 'periode.status AS periode_status',
                                 'renja.id AS renja_id',
                                 'renja.send_to_kaban AS send_to_kaban',
                                 'renja.kepala_skpd_id AS kaban_id',
                                 'renja.nama_kepala_skpd AS kaban_nama'


                                );


    
        $datatables = Datatables::of($dt)
        ->addColumn('periode_id', function ($x) {

            return $x->periode_id;

        })->addColumn('periode_label', function ($x) {
            
            return $x->periode_label;
        
        })->addColumn('renja_id', function ($x) {


            return $x->renja_id;
        })->addColumn('skpd_id', function ($x) use($skpd_id) {
           return $skpd_id;
        
        })->addColumn('kepala_skpd', function ($x) use($skpd_id) {
            if ( $x->renja_id == null ){
                //Tampilkan nama kaban yang aktif
                $kaban = SKPD::WHERE('parent_id', $skpd_id)->first();
                $pegawai =  $kaban->pejabat->pegawai;
                return Pustaka::nama_pegawai($pegawai->gelardpn , $pegawai->nama , $pegawai->gelarblk);
            }else{
                return $x->kaban_nama;
            }
            
        
        })->addColumn('skpd', function ($x) {
            
            //return Pustaka::capital_string($x->skpd);
        
        });

        
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true);
        
    }


    public function SKPDRenjaactivity(Request $request)
    {
       

     
        
//TUJUAN
        $tujuan = Tujuan::where('renja_id','=', $request->renja_id )->select('id','label')->get();
		foreach ($tujuan as $x) {
            $sub_data_tujuan['id']	            = "tujuan|".$x->id;
			$sub_data_tujuan['text']			= Pustaka::capital_string($x->label);
            $sub_data_tujuan['icon']            = "jstree-tujuan";
            $sub_data_tujuan['type']            = "tujuan";


//INDIKATOR TUJUAN 
            $ind_tujuan = IndikatorTujuan::where('tujuan_id','=',$x->id)->select('id','label')->get();
            foreach ($ind_tujuan as $v) {
                $sub_data_ind_tujuan['id']		        = "ind_tujuan|".$v->id;
                $sub_data_ind_tujuan['text']			= Pustaka::capital_string($v->label);
                $sub_data_ind_tujuan['icon']            = "jstree-ind_tujuan";
                $sub_data_ind_tujuan['type']            = "ind_tujuan";
               
            
//SASARAN 
            $sasaran = Sasaran::where('indikator_tujuan_id','=',$v->id)
                                ->select('id','label')->get();
            foreach ($sasaran as $y) {
                $sub_data_sasaran['id']		        = "sasaran|".$y->id;
                $sub_data_sasaran['text']			= Pustaka::capital_string($y->label);
                $sub_data_sasaran['icon']           = "jstree-sasaran";
                $sub_data_sasaran['type']           = "sasaran";

//INDIKATOR SASARAN 
                $ind_sasaran = IndikatorSasaran::where('sasaran_id','=',$y->id)->select('id','label')->get();
               
                foreach ($ind_sasaran as $z) {
                    $sub_data_ind_sasaran['id']		                    = "ind_sasaran|".$z->id;
                    $sub_data_ind_sasaran['text']			            = Pustaka::capital_string($z->label);
                    $sub_data_ind_sasaran['icon']                       = "jstree-ind_sasaran";
                    $sub_data_ind_sasaran['type']                       = "ind_sasaran";
                                        
//PROGRAM 
                    $program = Program:: where('indikator_sasaran_id','=',$z->id)->select('id','label')->get();
                        foreach ($program as $d) {
                            $sub_data_program['id']		        = "program|".$d->id;
                            $sub_data_program['text']			= Pustaka::capital_string($d->label);
                            $sub_data_program['icon']           = "jstree-program";
                            $sub_data_program['type']           = "program";
//INDIKATOR PROGRAM
                        $ind_program = IndikatorProgram:: where('program_id','=',$d->id)->select('id','label')->get();
                            foreach ($ind_program as $e) {
                                $sub_data_ind_program['id']	                    = "ind_program|".$e->id;
                                $sub_data_ind_program['text']			        = Pustaka::capital_string($e->label);
                                $sub_data_ind_program['icon']                   = "jstree-ind_program";
                                $sub_data_ind_program['type']                   = "ind_program";
                        

//KEGIATAN

                            $kegiatan = Kegiatan:: where('indikator_program_id','=',$e->id)->select('id','label')->get();
                                foreach ($kegiatan as $f) {
                                    $sub_data_kegiatan['id']	        = "kegiatan|".$f->id;
                                    $sub_data_kegiatan['text']			= Pustaka::capital_string($f->label);
                                    $sub_data_kegiatan['icon']          = "jstree-kegiatan";
                                    $sub_data_kegiatan['type']          = "kegiatan";
                                   


//INDIKATOR KEGIATAN

                                $ind_kegiatan = IndikatorKegiatan:: where('kegiatan_id','=',$f->id)->select('id','label')->get();
                                    foreach ($ind_kegiatan as $g) {
                                        $sub_data_ind_kegiatan['id']	        = "ind_kegiatan|".$g->id;
                                        $sub_data_ind_kegiatan['text']			= Pustaka::capital_string($g->label);
                                        $sub_data_ind_kegiatan['icon']          = "jstree-ind_kegiatan";
                                        $sub_data_ind_kegiatan['type']          = "ind_kegiatan";


                                        $ind_kegiatan_list[] = $sub_data_ind_kegiatan ;
                                    }

                                    if(!empty($ind_kegiatan_list)) {
                                        $sub_data_kegiatan['children']     = $ind_kegiatan_list;
                                    }

                                    $kegiatan_list[] = $sub_data_kegiatan ;
                                    $ind_kegiatan_list = "";
                                    unset($sub_data_kegiatan['children']);
                                }

                                if(!empty($kegiatan_list)) {
                                    $sub_data_ind_program['children']     = $kegiatan_list;
                                }

                                $ind_program_list[] = $sub_data_ind_program ;
                                $kegiatan_list = "";
                                unset($sub_data_ind_program['children']);

                            }


                            if(!empty($ind_program_list)) {
                                $sub_data_program['children']     = $ind_program_list;
                            }
                            $program_list[] = $sub_data_program ;
                            $ind_program_list = "";
                            unset($sub_data_program['children']);
                          
                            

                        }

                        if(!empty($program_list)) {
                            $sub_data_ind_sasaran['children']     = $program_list;
                        }
                        
                        
                        $ind_sasaran_list[] = $sub_data_ind_sasaran ;
                        $program_list = "";
                        unset($sub_data_ind_sasaran['children']);
                        
                    
                }	
                if(!empty($ind_sasaran_list)) {
                    $sub_data_sasaran['children']     = $ind_sasaran_list;
                }
                $sasaran_list[] = $sub_data_sasaran ;
                $ind_sasaran_list = "";
                unset($sub_data_sasaran['children']);
                
            }	


            

            if(!empty($sasaran_list)) { 
                $sub_data_ind_tujuan['children']       = $sasaran_list;
            }
            $ind_tujuan_list[] = $sub_data_ind_tujuan ;	
            $sasaran_list = "";
            unset($sub_data_ind_tujuan['children']);
        }	


        if(!empty($ind_tujuan_list)) { 
            $sub_data_tujuan['children']       = $ind_tujuan_list;
        }
        $data[] = $sub_data_tujuan ;	
        //reset sasaran list
        $ind_tujuan_list = "";
        unset($sub_data_tujuan['children']);
    }	
        
        
        
       
		return $data;
        
    }
    


    
    public function Store(Request $request)
	{
        $messages = [
                'skpd_id.required'           => 'Harus diisi',
                'periode_id.required'        => 'Harus diisi',
                'kaban_nama.required'        => 'Harus diisi',
                'kaban_jabatan_id.required'  => 'Harus diisi',
                'admin_nama.required'        => 'Harus diisi',
                'admin_jabatan_id.required'  => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'skpd_id'            => 'required',
                            'periode_id'        => 'required',
                            'kaban_nama'                => 'required',
                            'kaban_jabatan_id'          => 'required',
                            'admin_nama'                => 'required',
                            'admin_jabatan_id'          => 'required',
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

        $renja    = new Renja;
        $renja->skpd_id                  = Input::get('skpd_id');
        $renja->periode_id              = Input::get('periode_id');
        $renja->kepala_skpd_id           = Input::get('kaban_jabatan_id');
        $renja->nama_kepala_skpd                = Input::get('kaban_nama');
        $renja->admin_skpd_id                      = Input::get('admin_jabatan_id');
        $renja->nama_admin_skpd               = Input::get('admin_nama');
        

        if ( $renja->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    }   

    public function SendToKaban(Request $request)
    {
        $messages = [
                'renja_id.required'   => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'renja_id'   => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $renja    = Renja::find(Input::get('renja_id'));
        if (is_null($renja)) {
            return $this->sendError('Renja tidak ditemukan.');
        }


        $renja->send_to_kaban     = '1';
        $renja->date_of_send      = date('Y'."-".'m'."-".'d'." ".'H'.":".'i'.":".'s');
        $renja->status_approve    = '0';

        if ( $renja->save()){
            //return back();
            return \Response::make('sukses', 200);
            
        }else{
            return \Response::make('error', 500);
        } 
            



    }


}
