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
use App\Models\Jabatan;


use App\Models\SasaranPerjanjianKinerja;
use App\Models\IndikatorSasaran;
use App\Models\Program;
use App\Models\IndikatorProgram;
use App\Models\Kegiatan;
use App\Models\IndikatorKegiatan;
use App\Models\KegiatanSKPBulanan;
use App\Models\RencanaAksi;
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

            //ADMIN
            $admin = Pegawai::WHERE('id',$request->admin_id)->first();




            //KABAN
            $kaban = Jabatan::WHERE('parent_id', '=',$request->skpd_id )->first();
            if ( $kaban->PejabatAktif != null ){
                $pegawai            = $kaban->PejabatAktif->pegawai;
                $kaban_jabatan_id   = $pegawai->JabatanAktif->id;
                $kaban_nip          = $pegawai->nip;
                $kaban_nama         = Pustaka::nama_pegawai($pegawai->gelardpn , $pegawai->nama , $pegawai->gelarblk);
                $kaban_pangkat      = $pegawai->JabatanAktif->golongan->pangkat;
                $kaban_golongan     = $pegawai->JabatanAktif->golongan->pangkat;
                $kaban_eselon       = $pegawai->JabatanAktif->eselon->eselon;
                $kaban_jabatan      = Pustaka::capital_string($pegawai->JabatanAktif->Jabatan->skpd);
           
           
            }else{
                $pegawai = "";
                $kaban_jabatan_id   = $admin->JabatanAktif->id;
                $kaban_nip          = "";
                $kaban_nama         = Pustaka::nama_pegawai($admin->gelardpn , $admin->nama , $admin->gelarblk);
                $kaban_pangkat      = "";
                $kaban_golongan     = "";
                $kaban_eselon       = "";
                $kaban_jabatan      = "";
            }
            

            

            $data = array(
                'status'			    => 'pass',
                
                'periode_label'	        => $periode->label,
                'skpd_id'	            => $request->get('skpd_id'),

                'kaban_jabatan_id'	    => $kaban_jabatan_id,
                'kaban_nip'	            => $kaban_nip,
                'kaban_nama'	        => $kaban_nama,
                'kaban_pangkat'	        => $kaban_pangkat,
                'kaban_golongan'	    => $kaban_golongan,
                'kaban_eselon'	        => $kaban_eselon,
                'kaban_jabatan'	        => $kaban_jabatan,

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
        $body_3 = array();
        $body_4 = array();


        $renja = Renja::where('id','=', $request->renja_id )
                                ->select('*')
                                ->firstOrFail();
 
        
        //CREATED AT - Dibuat
        $x['tag']	    = 'p';
        $x['content']	= '<b class="text-success">Dibuat</b>';
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
        $y['content']	= '<b class="text-info">Dikirim</b>';
        array_push($body_2, $y);
        $y['tag']	    = 'p';
        $y['content']	= $renja->nama_admin_skpd;
        array_push($body_2, $y);

        $i['time']	    = $renja->date_of_send;
        $i['body']	    = $body_2;

        if ( $renja->send_to_kaban == 1 )
        {
            array_push($response, $i);
        }

        //APPROVE  AT - Diterima
        $z['tag']	    = 'p';
        $z['content']	= '<b class="text-info">Disetujui</b>';
        array_push($body_3, $z);
        $z['tag']	    = 'p';
        $z['content']	= $renja->nama_kepala_skpd;
        array_push($body_3, $z);

        $j['time']	    = $renja->date_of_approve;
        $j['body']	    = $body_3;

        if ( $renja->status_approve == 1 )
        {
            array_push($response, $j);
        }

        //APPROVE  AT - Ditolak
        $a['tag']	    = 'p';
        $a['content']	= '<b class="text-danger">Ditolak</b>';
        array_push($body_4, $a);
        $a['tag']	    = 'p';
        $a['content']	= 'Alasan : ';
        array_push($body_4, $a);
        $a['tag']	    = 'p';
        $a['content']	= $renja->alasan_penolakan;
        array_push($body_4, $a);
        $a['tag']	    = 'p';
        $a['content']	= $renja->nama_kepala_skpd;
        array_push($body_4, $a);

        $k['time']	    = $renja->date_of_approve;
        $k['body']	    = $body_4;

        if ( $renja->status_approve == 2 )
        {
            array_push($response, $k);
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
                                    'renja.id AS renja_id',
                                    'renja.status_approve')
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
        if ( ($renja->status_approve) === '1' ){
            $data_persetujuan_kaban = 'ok';
        }else{
            $data_persetujuan_kaban = '-';
        }

        //user role
        $administrator = \Auth::user()->hasRole('administrator');
      


        $response = array(
                'created'                 => $created,
                'data_kepala_skpd'        => $data_kepala_skpd,
                'data_persetujuan_kaban'  => $data_persetujuan_kaban,
                'button_kirim'            => $button_kirim,
                'administrator'           => $administrator


        );
       
        return $response;


    }

    public function RenjaDetail( Request $request )
    {
       $renja = Renja::
                            leftjoin('demo_asn.tb_history_jabatan AS kaban', function($join){
                                $join   ->on('kaban.id','=','renja.kepala_skpd_id');
                            })
                            ->leftjoin('db_pare_2018.periode AS periode', function($join){
                                $join   ->on('periode.id','=','renja.periode_id');
                            })
                            ->SELECT('kaban.id AS kaban_id',
                                    'renja.created_at AS created',
                                    'renja.id AS renja_id',
                                    'renja.status_approve',
                                    'renja.nama_kepala_skpd',
                                    'periode.label AS periode_label'
                                    )

                            ->where('renja.id','=', $request->renja_id )
                            ->first();

      
       
        $administrator = \Auth::user()->hasRole('administrator');
        $response = array(
                'created'                 => $renja->created,
                'periode'                 => $renja->periode_label,
                'nama_kepala_skpd'        => $renja->nama_kepala_skpd,
                'administrator'           => $administrator


        );
       
        return $response;


    }


    public function AdministratorPohonKinerjaList(Request $request)
    {
       
        
        $dt = Renja::
                            leftjoin('demo_asn.m_skpd AS skpd', function($join) { 
                                $join   ->on('renja.skpd_id','=','skpd.id');
                                
                            })                
                            ->SELECT(
                                 'renja.id AS renja_id',
                                 'renja.periode_id',
                                 'renja.skpd_id',
                                 'renja.send_to_kaban AS send_to_kaban',
                                 'renja.kepala_skpd_id',
                                 'renja.nama_kepala_skpd AS kaban_nama',
                                 'renja.status_approve',
                                 'skpd.skpd AS skpd'


                                )
                            ->ORDERBY('renja.created_at','DESC');


    
        $datatables = Datatables::of($dt)
        ->addColumn('periode', function ($x) {
            return $x->Periode->label;
        })->addColumn('renja_id', function ($x) {
            return $x->renja_id;
        })->addColumn('nama_skpd', function ($x) {
           return Pustaka::capital_string($x->skpd);
        })->addColumn('jm_tujuan', function ($x) {
            $jm = Tujuan::WHERE('renja_id','=',$x->renja_id)->count();
            return $jm;
        })->addColumn('ka_skpd', function ($x) {
            if ( $x->KepalaSKPD != null ){
                $pegawai =  $x->KepalaSKPD->pegawai;
                //return $pegawai;
                return Pustaka::nama_pegawai($pegawai->gelardpn , $pegawai->nama , $pegawai->gelarblk);
            }else{
                return "-";
            } 

        });

        
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true);
        
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
                                 'renja.nama_kepala_skpd AS kaban_nama',
                                 'renja.status_approve'


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
                $kaban = Jabatan::WHERE('parent_id', $skpd_id)->first();
                //return $kaban->PejabatAktif->pegawai;
                if ( $kaban->PejabatAktif != null ){
                    $pegawai =  $kaban->PejabatAktif->pegawai;
                    return Pustaka::nama_pegawai($pegawai->gelardpn , $pegawai->nama , $pegawai->gelarblk);
                }else{
                    return "Kepala SKPD tidak ditemukan";
                }
                 
           }else{
               return $x->kaban_nama;
            }
            
        
        })->addColumn('skpd', function ($x) {
            
        })->addColumn('status_approve', function ($x) {
            if ( $x->renja_id != null ){
                return 0 ;
            }else{
                return $x->status_approve;
            }

        });

        
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true);
        
    }


    public function RenjaApprovalRequestList(Request $request)
    {
        $pegawai_id = $request->pegawai_id;
       
        $dt = Renja::
                    leftjoin('db_pare_2018.periode AS periode', function($join){ 
                        $join   ->on('renja.periode_id','=','periode.id');
                        
                    })
                    ->rightjoin('demo_asn.tb_history_jabatan AS kaban', function($join) use($pegawai_id){ 
                        $join   ->on('renja.kepala_skpd_id','=','kaban.id');
                        $join   ->where('kaban.id_pegawai','=',$pegawai_id);
                    })
                    ->WHERE('renja.send_to_kaban','=','1')
                    //->WHERE('renja.status_approve','!=','2')
                    ->SELECT( 'periode.label AS periode_label',
                             'renja.id AS renja_id',
                             'renja.nama_admin_skpd',
                             'renja.status_approve',
                             'renja.created_at'
                            );


    
        $datatables = Datatables::of($dt)
        ->addColumn('periode', function ($x) {

            return $x->periode_label;

        })->addColumn('nama_admin', function ($x) {
            
            return $x->nama_admin_skpd;
        
        })->addColumn('tgl_dibuat', function ($x) {

            return $x->created_at;

        })->addColumn('tgl_dikirim', function ($x) {

            return $x->created_at;

        })->addColumn('renja_id', function ($x) {


            return $x->renja_id;
        });

        
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true);
        
    }



    public function SKPDMonitoringKinerja(Request $request)
    {
       
        
        $renja = Tujuan::
                            leftjoin('db_pare_2018.renja_indikator_tujuan AS indikator_tujuan', function($join) { 
                                $join   ->on('indikator_tujuan.tujuan_id','=','renja_tujuan.id');
                                
                            })
                            ->leftjoin('db_pare_2018.renja_sasaran AS sasaran', function($join) { 
                                $join   ->on('sasaran.tujuan_id','=','renja_tujuan.id');
                                
                            }) 
                            ->leftjoin('db_pare_2018.renja_indikator_sasaran AS indikator_sasaran', function($join) { 
                                $join   ->on('indikator_sasaran.sasaran_id','=','sasaran.id');
                                
                            }) 
                            ->leftjoin('db_pare_2018.renja_program AS program', function($join) { 
                                $join   ->on('program.sasaran_id','=','sasaran.id');
                                
                            }) 
                            ->leftjoin('db_pare_2018.renja_indikator_program AS indikator_program', function($join) { 
                                $join   ->on('indikator_program.program_id','=','program.id');
                                
                            })  
                            ->leftjoin('db_pare_2018.renja_kegiatan AS kegiatan', function($join) { 
                                $join   ->on('kegiatan.program_id','=','program.id');
                                
                            }) 
                            ->leftjoin('db_pare_2018.renja_indikator_kegiatan AS indikator_kegiatan', function($join) { 
                                $join   ->on('indikator_kegiatan.kegiatan_id','=','kegiatan.id');
                                
                            })                
                            ->SELECT(
                                 'renja_tujuan.label AS tujuan_label',
                                 'indikator_tujuan.label AS indikator_tujuan_label',
                                 'sasaran.label AS sasaran_label',
                                 'indikator_sasaran.label AS indikator_sasaran_label',
                                 'program.label AS program_label',
                                 'indikator_program.label AS indikator_program_label',
                                 'kegiatan.label AS kegiatan_label',
                                 'indikator_kegiatan.label AS indikator_kegiatan_label'


                                )
                            ->WHERE('renja_tujuan.renja_id','=',$request->renja_id)
                            ->get();
                            
    
        $datatables = Datatables::of($renja)
        ->addColumn('periode', function ($x) {
            return "";
        })->addColumn('renja_id', function ($x) {
            return "";
        });

        
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true);
        
    }
    


    
    public function Store(Request $request)
	{
        $messages = [
                'skpd_id.required'           => 'Harus diisi',
                'periode_id.required'        => 'Harus diisi',
                //'kaban_nama.required'        => 'Harus diisi',
                //'kaban_jabatan_id.required'  => 'Harus diisi',
                'admin_nama.required'        => 'Harus diisi',
                'admin_jabatan_id.required'  => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'skpd_id'            => 'required',
                            'periode_id'        => 'required',
                            //'kaban_nama'                => 'required',
                            //'kaban_jabatan_id'          => 'required',
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
        $renja->periode_id               = Input::get('periode_id');
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


    public function KepalaSKPDUpdate(Request $request)
	{
        $messages = [
            'ka_skpd_id.required'           => 'Harus set Pegawai ID',
            'renja_id.required'             => 'Harus diisi',

        ];

        $validator = Validator::make(
            Input::all(),
            array(
                'ka_skpd_id'    => 'required',
                'renja_id'      => 'required',
            ),
            $messages
        );

        if ( $validator->fails() ){
                return response()->json(['errors'=>$validator->messages()],422);
        }


        //Cari nama dan id pejabatan penilai
        $pegawai     = Pegawai::SELECT('*')->where('id',$request->ka_skpd_id )->first();

        //$jabatan_x     = $pegawai->JabatanAktif;

        if ( $pegawai->JabatanAktif ){

            $kepala_skpd_id  =  $pegawai->JabatanAktif->id;
        }else{
            return \Response::make('Jabatan tidak ditemukan', 500);
        }


        
       

        $renja    = Renja::find($request->get('renja_id'));
        if (is_null($renja)) {
            return $this->sendError('Capaian Bulanan tidak ditemukan tidak ditemukan.');
        }

        
        $renja->kepala_skpd_id          = $kepala_skpd_id;
        $renja->nama_kepala_skpd        = Pustaka::nama_pegawai($pegawai->gelardpn , $pegawai->nama , $pegawai->gelarblk);
   
        
        $item = array(
           
            "nama_kepala_skpd"		=> Pustaka::nama_pegawai($pegawai->gelardpn , $pegawai->nama , $pegawai->gelarblk),
              );


        
        if (  $renja->save() ){
            return \Response::make(  $item , 200);


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

    public function PullFromKaban(Request $request)
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


        $renja->send_to_kaban    = '0';
        $renja->date_of_send      = date('Y'."-".'m'."-".'d'." ".'H'.":".'i'.":".'s');
        $renja->status_approve    = '0';

        if ( $renja->save()){
            
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            



    }

    public function SetujuByKaban(Request $request)
    {
        $messages = [
                'renja_id.required'   => 'Harus diisi',
                'kaban_id.required'   => 'Harus diisi'

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'renja_id'   => 'required',
                            'kaban_id'   => 'required'
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


        $renja->status_approve    = '1';
        $renja->date_of_approve   = date('Y'."-".'m'."-".'d'." ".'H'.":".'i'.":".'s');

       
        if ( $renja->kepala_skpd_id == Input::get('kaban_id')){
            if ( $renja->save()){
            
                return \Response::make('sukses', 200);
            }else{
                return \Response::make('error', 500);
            }  
        }else{
            return \Response::make('ID Kaban tidak sama', 500);
        }

        
        



    }

    public function TolakByKaban(Request $request)
    {
        $messages = [
                'renja_id.required'   => 'Harus diisi',
                'kaban_id.required'   => 'Harus diisi',
                'alasan.required'     => 'Harus diisi'

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'renja_id'   => 'required',
                            'kaban_id'   => 'required',
                            'alasan'     => 'required'
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


        $renja->status_approve    = '2';
        $renja->alasan_penolakan  = Input::get('alasan');
        $renja->date_of_approve   = date('Y'."-".'m'."-".'d'." ".'H'.":".'i'.":".'s');

       
        if ( $renja->kepala_skpd_id == Input::get('kaban_id')){
            if ( $renja->save()){
            
                return \Response::make('sukses', 200);
            }else{
                return \Response::make('error', 500);
            }  
        }else{
            return \Response::make('ID Kaban tidak sama', 500);
        }

        
        



    }


}
