<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Periode;
use App\Models\PerjanjianKinerja;
use App\Models\KegiatanSKPTahunan;
use App\Models\MasaPemerintahan;
use App\Models\RencanaAksi;
use App\Models\SKPTahunanTimeline;
use App\Models\SKPTahunan;
use App\Models\SKPBulanan;
use App\Models\Pegawai;
use App\Models\HistoryJabatan;
use App\Models\Skpd;
use App\Models\Golongan;
use App\Models\Jabatan;
use App\Models\Kegiatan;
use App\Models\Renja;
use App\Models\Eselon;


use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class SKPTahunanAPIController extends Controller {

    //=======================================================================================//
    protected function jabatan($id_jabatan){
        $jabatan       = HistoryJabatan::WHERE('id',$id_jabatan)
                        ->SELECT('jabatan')
                        ->first();
        return Pustaka::capital_string($jabatan->jabatan);
    }


    protected function SKPTahunandDetail(Request $request){
     

        $skp = SKPTahunan::WHERE('skp_tahunan.id',$request->skp_tahunan_id)
                            
                            ->first();

        $skp_bulanan_list = SKPBulanan::SELECT('bulan')->WHERE('skp_tahunan_id',$request->skp_tahunan_id)->get()->toArray();


        $renja      = $skp->Renja;
        $p_detail   = $skp->PejabatPenilai;
        $u_detail   = $skp->PejabatYangDinilai;
       

        if ( $p_detail != null ){
            $data = array(
                    'periode'	        => $renja->Periode->label,
                    'date_created'	    => Pustaka::tgl_jam($skp->created_at),
                    'masa_penilaian'    => Pustaka::tgl_form($skp->tgl_mulai).' s.d  '.Pustaka::tgl_form($skp->tgl_selesai),

                    'tgl_mulai'         => $skp->tgl_mulai,
                    'pegawai_id'	        => $skp->pegawai_id,

                    'u_jabatan_id'	        => $u_detail->id,
                    'u_nip'	                => $u_detail->nip,
                    'u_nama'                => $skp->u_nama,
                    'u_pangkat'	            => $u_detail->Golongan ? $u_detail->Golongan->pangkat : '',
                    'u_golongan'	        => $u_detail->Golongan ? $u_detail->Golongan->golongan : '',
                    'u_eselon'	            => $u_detail->Eselon ? $u_detail->Eselon->eselon : '',
                    'u_jabatan'	            => Pustaka::capital_string($u_detail->Jabatan ? $u_detail->Jabatan->skpd : ''),
                    'u_unit_kerja'	        => Pustaka::capital_string($u_detail->UnitKerja ? $u_detail->UnitKerja->unit_kerja : ''),
                    'u_skpd'	            => Pustaka::capital_string($u_detail->Skpd ? $u_detail->Skpd->skpd : ''),
                
                    'p_jabatan_id'	        => $p_detail->id,
                    'p_nip'	                => $p_detail->nip,
                    'p_nama'                => $skp->p_nama,
                    'p_pangkat'	            => $p_detail->Golongan ? $p_detail->Golongan->pangkat : '',
                    'p_golongan'	        => $p_detail->Golongan ? $p_detail->Golongan->golongan : '',
                    'p_eselon'	            => $p_detail->Eselon ? $p_detail->Eselon->eselon : '',
                    'p_jabatan'	            => Pustaka::capital_string($p_detail->Jabatan ? $p_detail->Jabatan->skpd : ''),
                    'p_unit_kerja'	        => Pustaka::capital_string($p_detail->UnitKerja ? $p_detail->UnitKerja->unit_kerja : ''),
                    'p_skpd'	            => Pustaka::capital_string($p_detail->Skpd ? $p_detail->Skpd->skpd : ''), 
                
                    'skp_bulanan_list'      => $skp_bulanan_list,

            );
        }else{
            $data = array(
                    'periode'	        => $renja->Periode->label,
                    'date_created'	    => Pustaka::tgl_jam($skp->created_at),
                    'masa_penilaian'    => Pustaka::tgl_form($skp->tgl_mulai).' s.d  '.Pustaka::tgl_form($skp->tgl_selesai),

                    'tgl_mulai'         => $skp->tgl_mulai,
                    'pegawai_id'	        => $skp->pegawai_id,
                    
                    'u_jabatan_id'	        => $u_detail->id,
                    'u_nip'	                => $u_detail->nip,
                    'u_nama'                => Pustaka::nama_pegawai($u_detail->Pegawai->gelardpn , $u_detail->Pegawai->nama , $u_detail->Pegawai->gelarblk),
                    'u_pangkat'	            => $u_detail->Golongan ? $u_detail->Golongan->pangkat : '',
                    'u_golongan'	        => $u_detail->Golongan ? $u_detail->Golongan->golongan : '',
                    'u_eselon'	            => $u_detail->Eselon ? $u_detail->Eselon->eselon : '',
                    'u_jabatan'	            => Pustaka::capital_string($u_detail->Jabatan ? $u_detail->Jabatan->skpd : ''),
                    'u_unit_kerja'	        => Pustaka::capital_string($u_detail->UnitKerja ? $u_detail->UnitKerja->unit_kerja : ''),
                    'u_skpd'	            => Pustaka::capital_string($u_detail->Skpd ? $u_detail->Skpd->skpd : ''),
                
                    'p_jabatan_id'	        => '',
                    'p_nip'	                => '',
                    'p_nama'                => '',
                    'p_pangkat'	            => '',
                    'p_golongan'	        => '',
                    'p_eselon'	            => '',
                    'p_jabatan'	            => '',
                    'p_unit_kerja'	        => '',
                    'p_skpd'	            => '', 
                    'skp_bulanan_list'      => $skp_bulanan_list,
                
                

            );

        }


        return $data; 





    }
  
    //KASUBID
    public function SKPTahunanStatusPengisian3( Request $request )
    {
       
        $button_kirim = 0 ;


        $skp_tahunan = SKPTahunan::
                            leftjoin('demo_asn.tb_history_jabatan AS atasan', function($join){
                                $join   ->on('atasan.id','=','skp_tahunan.p_jabatan_id');
                            })
                            ->SELECT(
                                'skp_tahunan.id AS skp_tahunan_id',
                                'atasan.id AS atasan_id',
                                'skp_tahunan.status_approve'
                            )
                            ->where('skp_tahunan.id','=', $request->skp_tahunan_id )->first();


        //KEGITAN RENJA KSUBID
        $kegiatan_renja = Kegiatan::SELECT('id')
                            ->WHERE('renja_id', $request->renja_id )
                            ->WHERE('jabatan_id',$request->jabatan_id )
                            ->get()->toArray(); ;


        //apakah skp tahnan ini meiliki kegiatan tahunan dan setiap kegiatan minimal memiliki 1 rencana aksi
        $data_kegiatan_tahunan = KegiatanSKPTahunan::SELECT('id')
                                                ->WHEREIN('kegiatan_id',$kegiatan_renja)
                                                ->count();

        if ( $data_kegiatan_tahunan == COUNT($kegiatan_renja) ){
            $kegiatan_tahunan = 'ok';

            $rencana_aksi = 1 ;
            //cari paakah setiap kegiatan tahunan meiliki minimal 1 rencana aksi
            $query_x = KegiatanSKPTahunan::SELECT('id')
                                        ->WHEREIN('kegiatan_id',$kegiatan_renja)
                                        ->get();
            foreach ( $query_x AS $x ){
                $query_y = RencanaAksi::SELECT('id')
                                        ->WHERE('kegiatan_tahunan_id',$x->id)
                                        ->count();

                if ($query_y >= 1 ){
                    $tes_val = 1 ;
                }else{
                    $tes_val = 0 ;
                }

                $rencana_aksi = $rencana_aksi*$tes_val;

            }

            if ( $rencana_aksi == 0 ){
                $data_rencana_aksi = '-';
            }else{
                $data_rencana_aksi = 'ok';
            }


        }else{
            $data_rencana_aksi = '-';
            $kegiatan_tahunan = '-';
        }              
        
        //STATUS SKP
        if ( $skp_tahunan->skp_tahunan_id != null ){
            $created = 'ok';
        }else{
            $created = '-';
        }
        
        //STATUS PEJABAT PENILAI
        if ( $skp_tahunan->atasan_id != null ){
            $atasan = 'ok';
        }else{
            $atasan = '-';
        }


        //button kirim
        if ( ( $created == 'ok') && ( $atasan == 'ok') && ( $kegiatan_tahunan == 'ok' ) && (  $data_rencana_aksi == 'ok') ){
            $button_kirim = 1 ;
        }else{
            $button_kirim = 0 ;
        }
        
         //STATUS APPROVE
         if ( ($skp_tahunan->status_approve) == 1 ){
            $persetujuan_atasan = 'ok';
        }else{
            $persetujuan_atasan = '-';
        }


        $response = array(
                'created'                 => $created,
                'data_pejabat_penilai'    => $atasan,
                'data_kegiatan_tahunan'   => $kegiatan_tahunan,
                'data_rencana_aksi'       => $data_rencana_aksi,
                'persetujuan_atasan'      => $persetujuan_atasan,
                'button_kirim'            => $button_kirim ,


        );
       
        return $response;


    }


    public function SKPTahunanCekStatus( Request $request )
    {


        $pegawai  = Pegawai::SELECT('nip','id')->WHERE('id', $request->pegawai_id )->first();

        $mp = MasaPemerintahan::WHERE('status','1')->first();
        //status true artinya sudah bikin, false  artinya blm bikin pada jabatan ini
        
        $skp_tahunan = SKPTahunan::
                            where('pegawai_id','=', $request->pegawai_id )
                            ->where('u_jabatan_id','=', $request->jabatan_id )
                            ->exists();

       


        $response = array(
                'skp_tahunan_status'     => $skp_tahunan,
                'nip_pegawai'            => $pegawai->nip ,
                'jabatan_aktif'          => Pustaka::capital_string($pegawai->JabatanAktif->Jabatan->skpd),
                'periode_aktif'          => $mp->PeriodeAktif->label,
        );
       
        return $response;


    }

    public function SKPTahunanTimelineStatus( Request $request )
    {
        $response = array();
        $body = array();
        $body_2 = array();
        $body_3 = array();
        $body_4 = array();


        $skp_tahunan = SKPTahunan::where('id','=', $request->skp_tahunan_id )
                                ->select('*')
                                ->firstOrFail();

        
        //CREATED AT - Dibuat
        $x['tag']	    = 'p';
        $x['content']	= '<b class="text-success">Dibuat</b>';
        array_push($body, $x);
        $x['tag']	    = 'p';
        $x['content']	= $skp_tahunan->u_nama;
        array_push($body, $x);

        $h['time']	    = $skp_tahunan->created_at->format('Y-m-d H:i:s');
        $h['body']	    = $body;
        array_push($response, $h);
        //=====================================================================//

        //UPDATED AT - Dikirim
        $y['tag']	    = 'p';
        $y['content']	= '<b class="text-info">Dikirim</b>';
        array_push($body_2, $y);
        $y['tag']	    = 'p';
        $y['content']	= $skp_tahunan->u_nama;
        array_push($body_2, $y);

        $i['time']	    = $skp_tahunan->date_of_send;
        $i['body']	    = $body_2;

        if ( $skp_tahunan->send_to_atasan == 1 )
        {
            array_push($response, $i);
        }
        

         //APPROVE  AT - Diterima
         $z['tag']	    = 'p';
         $z['content']	= '<b class="text-info">Disetujui</b>';
         array_push($body_3, $z);
         $z['tag']	    = 'p';
         $z['content']	= $skp_tahunan->p_nama;
         array_push($body_3, $z);
 
         $j['time']	    = $skp_tahunan->date_of_approve;
         $j['body']	    = $body_3;
 
         if ( $skp_tahunan->status_approve == 1 )
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
         $a['content']	= $skp_tahunan->alasan_penolakan;
         array_push($body_4, $a);
         $a['tag']	    = 'p';
         $a['content']	= $skp_tahunan->p_nama;
         array_push($body_4, $a);
 
         $k['time']	    = $skp_tahunan->date_of_approve;
         $k['body']	    = $body_4;
 
         if ( $skp_tahunan->status_approve == 2 )
         {
             array_push($response, $k);
         }
         

        return $response;


    }


    public function SKPTahunanGeneralTimeline( Request $request )
    {
       
        $response = array();
        $body = array();

        //cari SKP tahunan dengan renja ID sesuai request
        $skp_tahunan = SKPTahunan::WHERE('renja_id',$request->renja_id)->SELECT('id')->get();

        $timeline = SKPTahunanTimeline::
                                WHEREIN('skp_tahunan_id',$skp_tahunan)
                                ->get();

        
        
        foreach($timeline as $tm) {

            //Jabatan
            /* if ( $tm->SKPTahunan->PejabatYangDinilai->jabatan != '' ){
                $jabatan = Pustaka::capital_string($tm->SKPTahunan->PejabatYangDinilai->Jabatan->skpd);

            }else{
                $jabatan = "";
            } */
            $jabatan = Pustaka::capital_string($tm->SKPTahunan->PejabatYangDinilai?$tm->SKPTahunan->PejabatYangDinilai->jabatan:'');

            $h['time']	    = $tm->created_at->format('Y-m-d H:i:s');
            $h['body']	    = [ ['tag'=>'p','content'=>'<b class="text-success">'.$tm->SKPTahunan->u_nama.'</b>'] , 
                                ['tag'=>'p','content'=>'<p class="text-success">'.$jabatan.'</p>'],
                                
                              
                              ];

            array_push($response, $h);

            

        }            
       
        return $response;

    }
   

    public function SKPDSKPTahunanList(Request $request)
    {
            
        $dt = \DB::table('db_pare_2018.renja AS renja')
                   
                    /* ->join('db_pare_2018.perjanjian_kinerja AS pk', function($join){
                        $join   ->on('pk.renja_id','=','renja.id');
                    }) */
                    ->rightjoin('db_pare_2018.skp_tahunan AS skp_tahunan', function($join){
                        $join   ->on('renja.id','=','skp_tahunan.renja_id');
                    }) 
                    //PERIODE
                    ->leftjoin('db_pare_2018.periode AS periode', function($join){
                        $join   ->on('renja.periode_id','=','periode.id');
                    }) 

                    //PEJABAT YANG DINILAI
                    ->leftjoin('demo_asn.tb_history_jabatan AS pejabat', function($join){
                        $join   ->on('skp_tahunan.u_jabatan_id','=','pejabat.id');
                    }) 

                    //ESELON PEJABAT YANG DINILAI
                     ->leftjoin('demo_asn.m_eselon AS eselon', function($join){
                        $join   ->on('eselon.id','=','pejabat.id_eselon');
                    }) 

                    
                    //jabatan
                    ->leftjoin('demo_asn.m_skpd AS jabatan', 'pejabat.id_jabatan','=','jabatan.id')


                    ->select([  'skp_tahunan.id AS skp_tahunan_id',
                                'periode.label AS periode',
                                'skp_tahunan.pegawai_id AS pegawai_id',
                                'skp_tahunan.u_nama',
                                'skp_tahunan.u_jabatan_id',
                                'skp_tahunan.p_nama',
                                'skp_tahunan.p_jabatan_id',
                                'skp_tahunan.send_to_atasan',
                                'pejabat.nip AS u_nip',
                                'eselon.eselon AS eselon',
                                'jabatan.skpd AS jabatan'

                        ])
                    ->where('renja.skpd_id','=', $request->skpd_id);

       
                    $datatables = Datatables::of($dt)
                    ->addColumn('status', function ($x) {
            
                        return $x->send_to_atasan;
            
                    })->addColumn('periode', function ($x) {
                        
                        return $x->periode;
                    
                    })->addColumn('nip_pegawai', function ($x) {
                        
                        return $x->u_nip;
                    
                    })->addColumn('nama_pegawai', function ($x) {
                        
                        return $x->u_nama;
                    
                    })
                    ->addColumn('eselon', function ($x) {
                        
                        
                        return  $x->eselon;
                        
                    })->addColumn('jabatan', function ($x) {
                        
                        return Pustaka::capital_string($x->jabatan);
                    
                    })
                    ->addColumn('nama_atasan', function ($x) {
                        
                        return $x->p_nama;
                    
                    });
            
                    
                    if ($keyword = $request->get('search')['value']) {
                        $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
                    } 
            
                    return $datatables->make(true);
        
    }


    

    public function SKPTahunanBawahanMd(Request $request)
    {
            
        $bawahan_aktif = SKPD::WHERE('parent_id', $request->jabatan_id )
                            ->rightjoin('demo_asn.tb_history_jabatan AS bawahan', function($join){
                                $join   ->on('bawahan.id_jabatan','=','m_skpd.id');
                                $join   ->where('bawahan.status','=','active');
                            }) 
                            ->leftjoin('demo_asn.tb_pegawai AS pegawai', function($join){
                                $join   ->on('pegawai.id','=','bawahan.id_pegawai');
                            })
                            ->leftjoin('db_pare_2018.skp_tahunan AS skp_tahunan', function($join){
                                $join   ->on('skp_tahunan.u_jabatan_id','=','bawahan.id');
                                //$join   ->where('skp_tahunan.send_to_atasan','=','1');
                                //$join   ->where('skp_tahunan.status_approve','=','1');
                            })
                            ->SELECT(   'bawahan.id AS bawahan_id',
                                        'skp_tahunan.id AS skp_tahunan_id',
                                        'pegawai.nip',
                                        'pegawai.nama',
                                        'pegawai.gelardpn',
                                        'pegawai.gelarblk'

                                    )
                            ->get(); 

       
        $datatables = Datatables::of($bawahan_aktif)
            ->addColumn('bawahan_id', function ($x) {
                return $x->bawahan_id;
            })->addColumn('skp_tahunan_id', function ($x) {
                return $x->skp_tahunan_id;
            })->addColumn('nama_pegawai', function ($x) {
                return Pustaka::nama_pegawai($x->gelardpn , $x->nama , $x->gelarblk);
            });
            
            if ($keyword = $request->get('search')['value']) {
                $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
            } 
            
            return $datatables->make(true);
        
    }



  

    //=======================================================================================//

    protected function status_renja($skpd_id,$periode_id){
        $renja = Renja::
            
                where('renja.skpd_id',$skpd_id)
                ->where('renja.send_to_kaban','1')
                ->where('renja.status_approve','1')
                ->where('renja.periode_id',$periode_id)
                ->exists();

        return $renja;
    }



    protected function skp_tahunan_id($skpd_id,$periode_id,$pegawai_id,$jabatan_id){
        $pk = Renja::
              /*   rightjoin('db_pare_2018.perjanjian_kinerja AS pk', function($join){
                    $join   ->on('pk.renja_id','=','renja.id');
                    $join   ->where('pk.status_approve','=','1');
                }) */
                rightjoin('db_pare_2018.skp_tahunan AS skp', function($join){
                    $join   ->on('skp.renja_id','=','renja.id');
                })
                ->where('skp.pegawai_id',$pegawai_id)
                ->where('skp.u_jabatan_id',$jabatan_id)
                ->where('renja.skpd_id',$skpd_id)
                ->where('renja.periode_id',$periode_id)
                ->first();

        if ( $pk ){
            return $pk->id;
        }else{
            return null ;
        }
        
    }


    public function PersonalSKPTahunanList(Request $request)
    {
            
        $id_pegawai = $request->pegawai_id;

        $pegawai = Pegawai::SELECT('id')->WHERE('id',$id_pegawai)->first();

        
        $SKPTahunan = SKPTahunan::WHERE('pegawai_id',$id_pegawai)
                        //PERIODE
                        ->leftjoin('db_pare_2018.renja AS renja', function($join){
                            $join   ->on('renja.id','=','skp_tahunan.renja_id');
                        }) 
                        ->leftjoin('db_pare_2018.periode AS periode', function($join){
                            $join   ->on('renja.periode_id','=','periode.id');
                        }) 
                        //SKPD
                        ->leftjoin('demo_asn.m_skpd AS skpd', function($join){
                            $join   ->on('skpd.id','=','renja.skpd_id');
                        }) 
                        ->SELECT(   'skp_tahunan.tgl_mulai',
                                    'skp_tahunan.tgl_selesai',
                                    'skp_tahunan.u_jabatan_id',
                                    'skp_tahunan.id AS skp_tahunan_id',
                                    'skpd.skpd',
                                    'periode.label',
                                    'skp_tahunan.status'
                                )
                        ->get(); 





        $datatables = Datatables::of($SKPTahunan)
            ->addColumn('periode', function ($x) {
                return $x->label;
            }) 
            ->addColumn('masa_penilaian', function ($x) {
                return Pustaka::balik($x->tgl_mulai)." s.d ". Pustaka::balik($x->tgl_selesai);
            })
           
            ->addColumn('jabatan', function ($x) {
            
                return  $this->jabatan($x->u_jabatan_id);
                
            })
            ->addColumn('skpd', function ($x) {
                return  Pustaka::capital_string($x->skpd);
            })
            ->addColumn('skp_tahunan_id', function ($x) {
                    return $x->skp_tahunan_id;
                
                 
            });
    
            if ($keyword = $request->get('search')['value']) {
                $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
            } 
            
    
        return $datatables->make(true); 
        //return $response; 
        
        
    }


    public function PersonalSKPJabatanList(Request $request)
    {
            
        $id_pegawai = $request->pegawai_id;

        $pegawai = Pegawai::SELECT('id')->WHERE('id',$id_pegawai)->first();

        $periode = Periode::ORDERBY('id','ASC')->get();

        $response= array();
        $last_jabatan       = '-';
        $last_jabatan_id    = '-';
        $last_skpd          = '-';
        $last_skpd_id       = '-';
        $last_tmt_jabatan   = '-';
        $no                 = 1;

        foreach ( $periode AS $x ){
            

            $thn = substr($x->awal,0,4);
            
            $dt = HistoryJabatan::
                        WHERE('id_pegawai','=', $id_pegawai)
                        ->whereRAW('YEAR(tmt_jabatan) = ' .$thn )
                        ->SELECT('jabatan AS jabatan','id AS jabatan_id')
                        ->count(); 

            if ( $dt >= 1 ){    //adakah jabatan id yang tmt nya sesuai tah
                $xt = HistoryJabatan::
                                WHERE('id_pegawai','=', $id_pegawai)
                                ->whereRAW('YEAR(tmt_jabatan) = ' .$thn )
                                ->SELECT('id AS jabatan_id','id_jabatan','id_skpd','tmt_jabatan')
                                ->ORDERBY('tmt_jabatan','ASC')
                                ->get(); 

                foreach ( $xt AS $y ){

                    $h['id']			        = $no;
                    $h['pegawai_id']			= $id_pegawai;
                    $h['periode']			    = $x->label;
                    $h['periode_id']	        = $x->id;
                    $h['jabatan']			    = Pustaka::capital_string($y->Jabatan ? $y->Jabatan->skpd : '');
                    $h['jabatan_id']			= $y->jabatan_id;
                    $h['skpd']			        = Pustaka::capital_string($y->Skpd ? $y->Skpd->skpd : '');
                    $h['skpd_id']			    = $y->Skpd ? $y->Skpd->id : '';
                    $h['tmt_jabatan']			= $y->tmt_jabatan;
                    $h['renja_status']          = $this->status_renja($y->Skpd ? $y->Skpd->id : '',$x->id);
                    $h['skp_tahunan_id']        = $this->skp_tahunan_id($y->Skpd ? $y->Skpd->id : '',$x->id , $id_pegawai , $y->jabatan_id);

                    array_push($response, $h);

                    $last_jabatan       = Pustaka::capital_string($y->Jabatan ? $y->Jabatan->skpd : '');
                    $last_jabatan_id    = $y->jabatan_id;
                    $last_skpd          = Pustaka::capital_string($y->Skpd ? $y->Skpd->skpd : '');
                    $last_skpd_id       = $y->Skpd ? $y->Skpd->id : '';
                    $last_tmt_jabatan   = $y->tmt_jabatan;
                    $no = $no+1;
                } 

            }else{
                    $h['id']			    = $no;
                    $h['pegawai_id']		= $id_pegawai;
                    $h['periode']			= $x->label;
                    $h['periode_id']	    = $x->id;
                    $h['jabatan']			= $last_jabatan;
                    $h['jabatan_id']		= $last_jabatan_id;
                    $h['skpd']			    = $last_skpd;
                    $h['skpd_id']			= $last_skpd_id;
                    $h['tmt_jabatan']	    = $last_tmt_jabatan;
                    $h['renja_status']      = $this->status_renja($last_skpd_id,$x->id);
                    $h['skp_tahunan_id']    = $this->skp_tahunan_id( $pegawai->JabatanAktif->id_skpd ,$x->id , $id_pegawai , $pegawai->JabatanAktif->id );
                    array_push($response, $h);
                    $no = $no+1;
            }

           
           

        }

        $datatables = Datatables::of(collect($response))
            ->addColumn('id', function ($x) {
                return $x['id'] ;
            }) 
           ->addColumn('periode', function ($x) {
                return $x['periode'];
            }) 
           
            ->addColumn('jabatan', function ($x) {
            
                return  $x['jabatan'];
                
            }) 
            ->addColumn('tmt_jabatan', function ($x) {
                
                if ($x['jabatan_id'] >= 1){
                    return  Pustaka::tgl_form($x['tmt_jabatan']).'  ['.$x['jabatan_id'].']';
                }else{
                    return '';
                }

                
                
            }) 
            ->addColumn('skpd', function ($x) {
                return  $x['skpd'];
            })
            ->addColumn('renja', function ($x) {
                //true = skpd sudah memilik renja false = skpd blm memiliki renja
                return  $x['renja_status'];
                
            })
            ->addColumn('skp_tahunan', function ($x) {
            
                if ( ( $x['renja_status'] === true ) && ( $x['skp_tahunan_id'] === null ) ) {
                    return 0; //0 = skpd sudah memiiki renja, skp belum dibuat , button create enable and show
                }else if ( ( $x['renja_status'] === true ) && ( $x['skp_tahunan_id'] != null ) ) {
                    return 1 ;  //1 = skpd sudah memiiki renja, skp sudah dibuat , button edit enable show
                }else if ($x['renja_status'] === false){
                    return 2 ;  //2 = skpd belum memiiki renja,  button create disabled
                }
                
            })
            ->addColumn('skp_tahunan_status', function ($x) {
                if ( $x['skp_tahunan_id'] >= 1 ){
                    $skp_status = SKPTahunan::WHERE('id', $x['skp_tahunan_id'] )
                                    ->SELECT('send_to_atasan')
                                    ->first();
                    return $skp_status->send_to_atasan;
                }else{
                    return 0 ;
                }

            })
            ->addColumn('status', function ($x) {
                if ( $x['skp_tahunan_id'] >= 1 ){
                    $skp_status = SKPTahunan::WHERE('id', $x['skp_tahunan_id'] )
                                    ->SELECT('status')
                                    ->first();
                    return $skp_status->status;
                }else{
                    return 0 ;
                }

            })
            ->addColumn('skp_tahunan_id', function ($x) {
                    return $x['skp_tahunan_id'];
                
                 
            });
    
            if ($keyword = $request->get('search')['value']) {
                $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
            } 
            
    
        return $datatables->make(true); 
        //return $response; 
        
        
    }


    protected function new_skp_componen($jabatan_id,$renja_id,$periode_id){
        //return $jabatan_id.'|'.$renja_id.'|'.$periode_id;


        //peridoe masa penilaian 
        $periode    = Periode::WHERE('id',$periode_id)->first();

        //return Pustaka::tgl_form($periode->awal);
        

        //DETAIL data pribadi dan atasan
        $u_detail = HistoryJabatan::WHERE('id',$jabatan_id)->first();


        //detail atasan
        $id_jab_atasan = SKPD::WHERE('id',$u_detail->id_jabatan)->first()->parent_id;
        $p_detail = HistoryJabatan::WHERE('id_jabatan', $id_jab_atasan)
                                    ->WHERE('status','active')
                                    ->first();

        $data = array(
                    'status'			    => 'pass',
                    'pegawai_id'			=> $u_detail->id_pegawai,
                    'periode_label'	        => $periode->label,
                    'renja_id'	            => $renja_id,
                    'u_jabatan_id'	        => $u_detail->id,
                    'u_nip'	                => $u_detail->nip,
                    'u_nama'                => Pustaka::nama_pegawai($u_detail->Pegawai->gelardpn , $u_detail->Pegawai->nama , $u_detail->Pegawai->gelarblk),
                    'u_pangkat'	            => $u_detail->Golongan ? $u_detail->Golongan->pangkat : '',
                    'u_golongan'	        => $u_detail->Golongan ? $u_detail->Golongan->golongan : '',
                    'u_eselon'	            => $u_detail->Eselon ? $u_detail->Eselon->eselon : '',
                    'u_jabatan'	            => Pustaka::capital_string($u_detail->Jabatan ? $u_detail->Jabatan->skpd : ''),
                    'u_unit_kerja'	        => Pustaka::capital_string($u_detail->UnitKerja ? $u_detail->UnitKerja->unit_kerja : ''),
                    'u_skpd'	            => Pustaka::capital_string($u_detail->Skpd ? $u_detail->Skpd->skpd : ''),

                    'p_jabatan_id'	        => $p_detail->id,
                    'p_nip'	                => $p_detail->nip,
                    'p_nama'                => Pustaka::nama_pegawai($p_detail->Pegawai->gelardpn , $p_detail->Pegawai->nama , $p_detail->Pegawai->gelarblk),
                    'p_pangkat'	            => $p_detail->Golongan ? $p_detail->Golongan->pangkat : '',
                    'p_golongan'	        => $p_detail->Golongan ? $p_detail->Golongan->golongan : '',
                    'p_eselon'	            => $p_detail->Eselon ? $p_detail->Eselon->eselon : '',
                    'p_jabatan'	            => Pustaka::capital_string($p_detail->Jabatan ? $p_detail->Jabatan->skpd : ''),
                    'p_unit_kerja'	        => Pustaka::capital_string($p_detail->UnitKerja ? $p_detail->UnitKerja->unit_kerja : ''),
                    'p_skpd'	            => Pustaka::capital_string($p_detail->Skpd ? $p_detail->Skpd->skpd : ''),

        );

        return $data;





        //nama lengkap pribdai dan atasan




    }

    protected function new_skp_componen_kaban($jabatan_id,$renja_id,$periode_id){
        //return $jabatan_id.'|'.$renja_id.'|'.$periode_id;


        //peridoe masa penilaian 
        $periode    = Periode::WHERE('id',$periode_id)->first();

        //return Pustaka::tgl_form($periode->awal);
        

        //DETAIL data pribadi dan atasan
        $u_detail = HistoryJabatan::WHERE('id',$jabatan_id)->first();


        //detail atasan
       /*  $id_jab_atasan = SKPD::WHERE('id',$u_detail->id_jabatan)->first()->parent_id;
        $p_detail = HistoryJabatan::WHERE('id_jabatan', $id_jab_atasan)
                                    ->WHERE('status','active')
                                    ->first(); */

        $data = array(
                    'status'			    => 'pass',
                    'pegawai_id'			=> $u_detail->id_pegawai,
                    'periode_label'	        => $periode->label,
                    'renja_id'	            => $renja_id,
                    'u_jabatan_id'	        => $u_detail->id,
                    'u_nip'	                => $u_detail->nip,
                    'u_nama'                => Pustaka::nama_pegawai($u_detail->Pegawai->gelardpn , $u_detail->Pegawai->nama , $u_detail->Pegawai->gelarblk),
                    'u_pangkat'	            => $u_detail->Golongan ? $u_detail->Golongan->pangkat : '',
                    'u_golongan'	        => $u_detail->Golongan ? $u_detail->Golongan->golongan : '',
                    'u_eselon'	            => $u_detail->Eselon ? $u_detail->Eselon->eselon : '',
                    'u_jabatan'	            => Pustaka::capital_string($u_detail->Jabatan ? $u_detail->Jabatan->skpd : ''),
                    'u_unit_kerja'	        => Pustaka::capital_string($u_detail->UnitKerja ? $u_detail->UnitKerja->unit_kerja : ''),
                    'u_skpd'	            => Pustaka::capital_string($u_detail->Skpd ? $u_detail->Skpd->skpd : ''),

                    'p_jabatan_id'	        => '',
                    'p_nip'	                => '',
                    'p_nama'                => '',
                    'p_pangkat'	            => '',
                    'p_golongan'	        => '',
                    'p_eselon'	            => '',
                    'p_jabatan'	            => '',
                    'p_unit_kerja'	        => '',
                    'p_skpd'	            => '',

        );

        return $data;





        //nama lengkap pribdai dan atasan




    }


    public function CreateConfirm(Request $request)
	{

        //data yang harus diterima yaitu periode ID, jabatan ID, 
        //karena kita butuh periode dan jenis jabatan nya untuk confirm dan mengetahui atasan nya
        //======= tidak boleh ada yang membuat SKP tahunan dengan 
        //======== PERSONAL JABATAN ID dan PERJANJIAN KINERTJA ID 
        // ======= yang sama untuk satu pegawai id

        //cari SKPD ID from jabatan_id
        $skpd_id = HistoryJabatan::WHERE('id',$request->get('jabatan_id'))->SELECT('id','id_skpd')->first()->id_skpd;
       
        //cari perjanjian kinerja dari periode ID
        $renja_id   = Renja::WHERE('renja.periode_id',$request->get('periode_id'))
                        ->WHERE('renja.skpd_id',$skpd_id)
                        ->WHERE('renja.send_to_kaban','1')
                        ->WHERE('renja.status_approve','1')
                        /* ->leftjoin('db_pare_2018.perjanjian_kinerja AS pk', function($join){
                            $join   ->on('renja.id','=','pk.renja_id');
                        }) */
                        ->SELECT('renja.id AS renja_id')
                        ->first()
                        ->renja_id;

        

        // COUNT SKP TAHUNAN DENWGAN DATA DIATAS
        $skp_count      = SKPTahunan::WHERE('pegawai_id', $request->get('pegawai_id'))
                                ->WHERE('renja_id',$renja_id)
                                ->WHERE('u_jabatan_id', $request->get('jabatan_id'))
                                ->count();

        //ready to create SKP, but check the jabatan type id , if he is 
        //if 1 nunggu 2 , if 2 nunggu 3 . jadi kalo 3 mah bisa langsung bikin SKP tahunan , 
        //if 4, nunggu 3

        $jenis_jabatan = HistoryJabatan::WHERE('id',$request->get('jabatan_id'))
                            ->SELECT('id','id_eselon')->first()->Eselon->id_jenis_jabatan;

        if ($skp_count === 0 ){
            if (  $jenis_jabatan == 1 ){
                //cek SKP bawahan jabatn 2 nya
//Jabatan Pimpinan Tinggi Pratama KA SKPD=====================================================================================//
                $data = $this->new_skp_componen_kaban($request->get('jabatan_id'),$renja_id,$request->get('periode_id'));

                return $data;


            }else if ( $jenis_jabatan == 2 ){
//Jabatan Administrator KABID =====================================================================================//
               //cek SKP TAHUNAN bawahan  jabatan 3 nya
                $data = HistoryJabatan::WHERE('id', $request->jabatan_id )->first();
                $jabatan_id = $data->id_jabatan;
                $skpd_id    = $data->id_skpd;

                $renja = Renja::WHERE('skpd_id',$skpd_id)
                                ->WHERE('periode_id',$request->periode_id)
                                ->WHERE('send_to_kaban','1')
                                ->WHERE('status_approve','1')
                                /* ->rightjoin('db_pare_2018.perjanjian_kinerja AS pk', function($join){
                                    $join   ->on('pk.renja_id','=','renja.id');
                                    $join   ->where('pk.status_approve','=','1');
                                })  */
                                ->SELECT(
                                            'renja.id AS renja_id'
                                        )
                                ->first();
                $renja_id = $renja->renja_id;

               
                $bawahan_aktif = SKPD::WHERE('parent_id', $jabatan_id )
                                        ->rightjoin('demo_asn.tb_history_jabatan AS bawahan', function($join){
                                            $join   ->on('bawahan.id_jabatan','=','m_skpd.id');
                                            $join   ->where('bawahan.status','=','active');
                                        }) 
                                        ->SELECT('bawahan.id AS bawahan_id')
                                        ->get(); 

                //$bawahan_aktif = ['35342','35245'];


                $skp_bawahan = SKPTahunan::WHERE('renja_id',$renja_id)
                                            //->WHERE('send_to_atasan','1')
                                            //->WHERE('status_approve','1')
                                            ->WHEREIN('u_jabatan_id',$bawahan_aktif)
                                            ->count();

               if ( COUNT($bawahan_aktif) == $skp_bawahan ){
                    $data = $this->new_skp_componen($request->get('jabatan_id'),$renja_id,$request->get('periode_id'));

                    return $data;
               }else{
                    $data = array(
                                    'status'			    => 'fail',
                                    'jenis_jabatan'			=> $jenis_jabatan,
                                    'renja_id'              => $renja_id,
                                    'jabatan_id'            => $jabatan_id
                                );

                    return $data;
                   
               } 




            }else if ( $jenis_jabatan == 4 ){
//Jabatan PELAKSANA JFU =======================================================================================//
                //cek SKP atasan  jabatan 3 nya
                $data = $this->new_skp_componen($request->get('jabatan_id'),$renja_id,$request->get('periode_id'));

                return $data;






            }else if ( $jenis_jabatan == 3 ){
//Jabatan PENGAWAS KASUBID =======================================================================================//
 
                //ready to SKP
                $data = $this->new_skp_componen($request->get('jabatan_id'),$renja_id,$request->get('periode_id'));

                return $data;
            }else{
                return \Response::make( 'error', 400);

            }
        }
        
       
       
         
    }



    public function PejabatPenilaiUpdate(Request $request)
	{
        $messages = [
            'pejabat_penilai_id.required'           => 'Harus set Pegawai ID',
            'skp_tahunan_id.required'               => 'Harus diisi',

        ];

        $validator = Validator::make(
            Input::all(),
            array(
                'pejabat_penilai_id'    => 'required',
                'skp_tahunan_id'        => 'required',
            ),
            $messages
        );

        if ( $validator->fails() ){
                return response()->json(['errors'=>$validator->messages()],422);
        }


        //Cari nama dan id pejabatan penilai
        $pegawai     = Pegawai::SELECT('*')->where('id',$request->pejabat_penilai_id )->first();

        //$jabatan_x     = $pegawai->JabatanAktif;

        if ( $pegawai->JabatanAktif ){

            $p_jabatan_id  =  $pegawai->JabatanAktif->id;
        }else{
            return \Response::make('Jabatan tidak ditemukan', 500);
        }


        
       

        $skp_tahunan    = SKPTahunan::find($request->get('skp_tahunan_id'));
        if (is_null($skp_tahunan)) {
            return $this->sendError('SKP Tahunan tidak ditemukan tidak ditemukan.');
        }

        
        $skp_tahunan->p_jabatan_id    = $p_jabatan_id;
        $skp_tahunan->p_nama          = Pustaka::nama_pegawai($pegawai->gelardpn , $pegawai->nama , $pegawai->gelarblk);
   
        
        $item = array(
           
            "p_nip"			=> $pegawai->nip,
            "p_nama"		=> Pustaka::nama_pegawai($pegawai->gelardpn , $pegawai->nama , $pegawai->gelarblk),
            "p_pangkat"	    => $pegawai->JabatanAktif->golongan?$pegawai->JabatanAktif->golongan->pangkat:'',
            "p_golongan"	=> $pegawai->JabatanAktif->golongan?$pegawai->JabatanAktif->golongan->golongan:'',
            "p_eselon"		=> $pegawai->JabatanAktif->Eselon?$pegawai->JabatanAktif->Eselon->eselon:'',
            "p_jabatan"		=> Pustaka::capital_string($pegawai->JabatanAktif->Jabatan?$pegawai->JabatanAktif->Jabatan->skpd:''),
            "p_unit_kerja"	=> Pustaka::capital_string($pegawai->JabatanAktif->Skpd?$pegawai->JabatanAktif->Skpd->skpd:''),
            );


        
        if (  $skp_tahunan->save() ){
            return \Response::make(  $item , 200);


        }else{
            return \Response::make('error', 500);
        } 

    }


    public function SKPTahunanApprovalRequestList(Request $request)
    {
        $pegawai_id = $request->pegawai_id;

        $jabatan_id = HistoryJabatan::SELECT('id')->WHERE('id_pegawai','=',$pegawai_id)->get();
       
        $dt = SKPTahunan::
                    WHEREIN('skp_tahunan.p_jabatan_id',$jabatan_id)
                    ->WHERE('skp_tahunan.send_to_atasan','=','1')
                    ->SELECT( 
                             'skp_tahunan.id AS skp_tahunan_id',
                             'skp_tahunan.u_nama',
                             'skp_tahunan.renja_id',
                             'skp_tahunan.u_jabatan_id',
                             'skp_tahunan.status_approve'
                            );


    
        $datatables = Datatables::of($dt)
        ->addColumn('periode', function ($x) {
            return $x->Renja->Periode->label;
        })->addColumn('nama', function ($x) {
            return $x->u_nama;
        })->addColumn('jabatan', function ($x) {
            return Pustaka::capital_string($x->PejabatYangDinilai->Jabatan->skpd);
        })->addColumn('skp_tahunan_id', function ($x) {
            return $x->skp_tahunan_id;
        });

        
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true);
        
    }

    
    public function SetujuByAtasan(Request $request)
    {
        $messages = [
                'skp_tahunan_id.required'   => 'Harus diisi',
                'atasan_id.required'        => 'Harus diisi'

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'skp_tahunan_id'   => 'required',
                            'atasan_id'        => 'required'
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $skp    = SKPTahunan::find(Input::get('skp_tahunan_id'));
        if (is_null($skp)) {
            return $this->sendError('SKp Tahunan tidak ditemukan.');
        }


        $skp->status_approve    = '1';
        $skp->date_of_approve   = date('Y'."-".'m'."-".'d'." ".'H'.":".'i'.":".'s');

       
        if ( $skp->p_jabatan_id == Input::get('atasan_id')){
            if ( $skp->save()){
            
                return \Response::make('sukses', 200);
            }else{
                return \Response::make('error', 500);
            }  
        }else{
            return \Response::make('ID Atasan tidak sama', 500);
        }

        
        



    }

    public function TolakByAtasan(Request $request)
    {
        $messages = [
                'skp_tahunan_id.required'   => 'Harus diisi',
                'atasan_id.required'        => 'Harus diisi',
                'alasan.required'           => 'Harus diisi'

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'skp_tahunan_id'   => 'required',
                            'atasan_id'        => 'required',
                            'alasan'           => 'required'
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $skp    = SKPTahunan::find(Input::get('skp_tahunan_id'));
        if (is_null($skp)) {
            return $this->sendError('SKP Tahunan tidak ditemukan.');
        }


        $skp->status_approve    = '2';
        $skp->alasan_penolakan  = Input::get('alasan');
        $skp->date_of_approve   = date('Y'."-".'m'."-".'d'." ".'H'.":".'i'.":".'s');

       
        if ( $skp->p_jabatan_id == Input::get('atasan_id')){
            if ( $skp->save()){
            
                return \Response::make('sukses', 200);
            }else{
                return \Response::make('error', 500);
            }  
        }else{
            return \Response::make('ID atasan tidak sama', 500);
        }

        
        



    }

    public function Store(Request $request)
	{
        $messages = [
                'pegawai_id.required'                   => 'Harus diisi',
                'renja_id.required'                     => 'Harus diisi',
                'tgl_mulai.required'                    => 'Harus diisi',
                'tgl_selesai.required'                  => 'Harus diisi',
                'u_nama.required'                       => 'Harus diisi',
                'u_jabatan_id.required'                 => 'Harus diisi',
               // 'p_nama.required'                       => 'Harus diisi',
                //'p_jabatan_id.required'                 => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'pegawai_id'            => 'required',
                            'renja_id' => 'required',
                            'tgl_mulai'             => 'required',
                            'tgl_selesai'           => 'required',
                            'u_nama'                => 'required',
                            'u_jabatan_id'          => 'required',
                            //'p_nama'                => 'required',
                            //'p_jabatan_id'          => 'required',
                        ),
                        $messages
        );
    
        if ( $validator->fails() ){
            //$messages = $validator->messages();
                    return response()->json(['errors'=>$validator->messages()],422);
            
        }

        if ( (Pustaka::tgl_sql(Input::get('tgl_mulai'))) >= (Pustaka::tgl_sql(Input::get('tgl_selesai'))) ){
            $pesan =  ['masa_penilaian'  => 'Error'] ;
            return response()->json(['errors'=> $pesan ],422);
            
        }


        $skp_tahunan    = new SKPTahunan;
        $skp_tahunan->pegawai_id                  = Input::get('pegawai_id');
        $skp_tahunan->renja_id       = Input::get('renja_id');
        $skp_tahunan->u_nama                      = Input::get('u_nama');
        $skp_tahunan->u_jabatan_id                = Input::get('u_jabatan_id');
        $skp_tahunan->p_nama                      = Input::get('p_nama');
        $skp_tahunan->p_jabatan_id                = Input::get('p_jabatan_id');
        $skp_tahunan->tgl_mulai                   = Pustaka::tgl_sql(Input::get('tgl_mulai'));
        $skp_tahunan->tgl_selesai                 = Pustaka::tgl_sql(Input::get('tgl_selesai'));
        

        if ( $skp_tahunan->save()){

            SKPTahunanTimeline::INSERT(['skp_tahunan_id'=>$skp_tahunan->id]);
            return \Response::make($skp_tahunan->id, 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    }   

    public function SKPClose(Request $request)
    {
        $messages = [
                'skp_tahunan_id.required'   => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'skp_tahunan_id'   => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $skp_tahunan    = SKPTahunan::find(Input::get('skp_tahunan_id'));
        if (is_null($skp_tahunan)) {
            return $this->sendError('SKP Tahunan tidak ditemukan.');
        }


        $skp_tahunan->status    = '1';

        if ( $skp_tahunan->save()){
            //return back();
            return \Response::make('sukses', 200);
            
        }else{
            return \Response::make('error', 500);
        } 
            
    }

    public function SKPOpen(Request $request)
    {
        $messages = [
                'skp_tahunan_id.required'   => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'skp_tahunan_id'   => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $skp_tahunan    = SKPTahunan::find(Input::get('skp_tahunan_id'));
        if (is_null($skp_tahunan)) {
            return $this->sendError('SKP Tahunan tidak ditemukan.');
        }


        $skp_tahunan->status    = '0';

        if ( $skp_tahunan->save()){
            //return back();
            return \Response::make('sukses', 200);
            
        }else{
            return \Response::make('error', 500);
        } 
            
    }
    
    public function SendToAtasan(Request $request)
    {
        $messages = [
                'skp_tahunan_id.required'   => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'skp_tahunan_id'   => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $skp_tahunan    = SKPTahunan::find(Input::get('skp_tahunan_id'));
        if (is_null($skp_tahunan)) {
            return $this->sendError('SKP Tahunan tidak ditemukan.');
        }


        $skp_tahunan->send_to_atasan    = '1';
        $skp_tahunan->date_of_send      = date('Y'."-".'m'."-".'d'." ".'H'.":".'i'.":".'s');
        $skp_tahunan->status_approve    = '0';

        if ( $skp_tahunan->save()){
            //return back();
            return \Response::make('sukses', 200);
            
        }else{
            return \Response::make('error', 500);
        } 
            



    }

    public function PullFromAtasan(Request $request)
    {
        $messages = [
                'skp_tahunan_id.required'   => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'skp_tahunan_id'   => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $skp_tahunan    = SKPTahunan::find(Input::get('skp_tahunan_id'));
        if (is_null($skp_tahunan)) {
            return $this->sendError('SKP Tahunan tidak ditemukan.');
        }


        $skp_tahunan->send_to_atasan    = '0';
        $skp_tahunan->date_of_send      = date('Y'."-".'m'."-".'d'." ".'H'.":".'i'.":".'s');
        $skp_tahunan->status_approve    = '';

        if ( $skp_tahunan->save()){
            
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            



    }



    public function Destroy(Request $request)
    {

        $messages = [
                'skp_tahunan_id.required'   => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'skp_tahunan_id'   => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $st_skp    = SKPtahunan::find(Input::get('skp_tahunan_id'));
        if (is_null($st_skp)) {
            return $this->sendError('SKP Tahunan tidak ditemukan.');
        }


        if ( $st_skp->delete()){

            $tm    = SKPtahunanTimeline::
                        where('skp_tahunan_id',Input::get('skp_tahunan_id'))
                        ->delete();

            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }

}
