<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Periode;
use App\Models\PerjanjianKinerja;
use App\Models\SKPTahunan;
use App\Models\SKPBulanan;
use App\Models\CapaianBulanan;
use App\Models\Pegawai;
use App\Models\HistoryJabatan;
use App\Models\Jabatan;
use App\Models\Golongan;
use App\Models\Eselon;

use App\Models\KegiatanSKPTahunan;
use App\Models\RencanaAksi;
use App\Models\KegiatanSKPBulanan;

use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class CapaianBulananAPIController extends Controller {

  
    protected function CapaianBulananDetail(Request $request){
     

        $capaian = CapaianBulanan::WHERE('capaian_bulanan.id',$request->capaian_bulanan_id)->first();

    
        $p_detail   = $capaian->PejabatPenilai;
        $u_detail   = $capaian->PejabatYangDinilai;
       

        if ( $p_detail != null ){
            $data = array(
                    'periode'	            => $capaian->SKPBulanan->SKPTahunan->Renja->Periode->label,
                    'date_created'	        => Pustaka::tgl_jam($capaian->created_at),
                    'masa_penilaian'        => Pustaka::tgl_form($capaian->tgl_mulai).' s.d  '.Pustaka::tgl_form($capaian->tgl_selesai),

                    'tgl_mulai'             => $capaian->tgl_mulai,
                    'pegawai_id'	        => $capaian->pegawai_id,

                    'u_jabatan_id'	        => $u_detail->id,
                    'u_nip'	                => $u_detail->nip,
                    'u_nama'                => $capaian->u_nama,
                    'u_pangkat'	            => $u_detail->Golongan ? $u_detail->Golongan->pangkat : '',
                    'u_golongan'	        => $u_detail->Golongan ? $u_detail->Golongan->golongan : '',
                    'u_eselon'	            => $u_detail->Eselon ? $u_detail->Eselon->eselon : '',
                    'u_jabatan'	            => Pustaka::capital_string($u_detail->Jabatan ? $u_detail->Jabatan->skpd : ''),
                    'u_unit_kerja'	        => Pustaka::capital_string($u_detail->UnitKerja ? $u_detail->UnitKerja->unit_kerja : ''),
                    'u_skpd'	            => Pustaka::capital_string($u_detail->Skpd ? $u_detail->Skpd->skpd : ''),
                
                    'p_jabatan_id'	        => $p_detail->id,
                    'p_nip'	                => $p_detail->nip,
                    'p_nama'                => $capaian->p_nama,
                    'p_pangkat'	            => $p_detail->Golongan ? $p_detail->Golongan->pangkat : '',
                    'p_golongan'	        => $p_detail->Golongan ? $p_detail->Golongan->golongan : '',
                    'p_eselon'	            => $p_detail->Eselon ? $p_detail->Eselon->eselon : '',
                    'p_jabatan'	            => Pustaka::capital_string($p_detail->Jabatan ? $p_detail->Jabatan->skpd : ''),
                    'p_unit_kerja'	        => Pustaka::capital_string($p_detail->UnitKerja ? $p_detail->UnitKerja->unit_kerja : ''),
                    'p_skpd'	            => Pustaka::capital_string($p_detail->Skpd ? $p_detail->Skpd->skpd : ''), 
                
                   

            );
        }else{
            $data = array(
                    'periode'	        => $renja->Periode->label,
                    'date_created'	    => Pustaka::tgl_jam($capaian->created_at),
                    'masa_penilaian'    => Pustaka::tgl_form($capaian->tgl_mulai).' s.d  '.Pustaka::tgl_form($capaian->tgl_selesai),

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

        }


        return $data; 





    }

    public function PersonalCapaianBulananList(Request $request)
    {
        $skp = SKPBulanan::
                        leftjoin('db_pare_2018.capaian_bulanan', function($join){
                            $join   ->on('capaian_bulanan.skp_bulanan_id','=','skp_bulanan.id');
                        })
                        ->WHERE('skp_bulanan.pegawai_id',$request->pegawai_id)
                        ->select(
                                'skp_bulanan.id AS skp_bulanan_id',
                                'skp_bulanan.skp_tahunan_id',
                                'skp_bulanan.bulan',
                                'skp_bulanan.tgl_mulai',
                                'skp_bulanan.tgl_selesai',
                                'skp_bulanan.u_jabatan_id',
                                'skp_bulanan.status',
                                'capaian_bulanan.id AS capaian_id'
            
                         )
                       // ->orderBy('bulan','ASC')
                        ->get();

       
           $datatables = Datatables::of($skp)
             ->addColumn('periode', function ($x) {
                return  $x->SKPTahunan->Renja->Periode->label;
            }) 
            ->addColumn('bulan', function ($x) {
                return Pustaka::bulan($x->bulan);
            }) 
            ->addColumn('pelaksanaan', function ($x) {
                $masa_penilaian = Pustaka::balik($x->tgl_mulai). ' s.d ' . Pustaka::balik($x->tgl_selesai);
                return   $masa_penilaian;
            }) 
            ->addColumn('jabatan', function ($x) {
                
                return   Pustaka::capital_string($x->PejabatYangDinilai->Jabatan->skpd);
            })
            ->addColumn('capaian', function ($x) {
                return $x->capaian_id;
             
            })
            ->addColumn('remaining_time', function ($x) {

                $tgl_selesai = strtotime($x->tgl_selesai);
                $now         = time();
                return floor(($tgl_selesai - $now)/ (60*60*24)) * -1;

            
                
            });
    
            if ($keyword = $request->get('search')['value']) {
                $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
            } 
            
    
        return $datatables->make(true);
        
    }


    public function CreateConfirm(Request $request)
	{

        //data yang harus diterima yaitu SKP Bulanan ID
        //cek apakah sudah punya capaian atau belum
        //apakah tgl sudah lewat dari tgl akhir
        //lihat kegiatan nya serta pelihatkan capaian kegia9tan nya juga ( capaian kegiatan dapat dibuat dibulan berjalaan)
        
        //lihat jenis jabatan, 1,2,3,4

      
        $skp_bulanan   = SKPBulanan::WHERE('skp_bulanan.id',$request->get('skp_bulanan_id'))
                        
                        ->SELECT('skp_bulanan.id AS skp_bulanan_id',
                                 'skp_bulanan.tgl_mulai',
                                 'skp_bulanan.tgl_selesai',
                                 'skp_bulanan.skp_tahunan_id',
                                 'skp_bulanan.bulan',
                                 'skp_bulanan.u_jabatan_id',
                                 'skp_bulanan.p_jabatan_id',
                                 'skp_bulanan.pegawai_id'

                                 
                                )
                        ->first();

        $jenis_jabatan = $skp_bulanan->PejabatYangDinilai->Eselon->id_jenis_jabatan;

        //jm kegiatan pelaksana
        if ( $jenis_jabatan == 4 ){
            $jm_kegiatan = KegiatanSKPBulanan::WHERE('skp_bulanan_id','=',$request->get('skp_bulanan_id'))->count();
        }else if ( $jenis_jabatan == 3){
            //cari bawahan
            $child = Jabatan::SELECT('id')->WHERE('parent_id',$skp_bulanan->PejabatYangDinilai->id_jabatan )->get()->toArray(); 

        //jm kegiatan kasubid   
            $jm_kegiatan = RencanaAksi::WHEREIN('jabatan_id',$child)->WHERE('waktu_pelaksanaan',$skp_bulanan->bulan)->count();
        }else if ( $jenis_jabatan == 2){
            //cari bawahan  , jabatanpelaksanan
            $pelaksana_id = Jabatan::
                    leftjoin('demo_asn.m_skpd AS pelaksana', function($join){
                        $join   ->on('pelaksana.parent_id','=','m_skpd.id');
                    })
                    ->SELECT('pelaksana.id')
                    ->WHERE('m_skpd.parent_id', $request->jabatan_id )
                    ->get()
                    ->toArray(); 
            //jm kegiatan kasubid   
            $jm_kegiatan = RencanaAksi::WHEREIN('jabatan_id',$pelaksana_id)->WHERE('waktu_pelaksanaan',$skp_bulanan->bulan)->count();
        }else{
            $jm_kegiatan = 0 ;
        }
        //
        
        
        //DETAIL data pribadi dan atasan
        $u_detail = HistoryJabatan::WHERE('id',$skp_bulanan->u_jabatan_id)->first();
        $p_detail = HistoryJabatan::WHERE('id',$skp_bulanan->p_jabatan_id)->first();


        $data = array(
                    'status'			    => 'pass',
                    'pegawai_id'            =>  $skp_bulanan->pegawai_id,
                    'skp_bulanan_id'        =>  $skp_bulanan->skp_bulanan_id,
                    'periode_label'			=>  Pustaka::bulan($skp_bulanan->bulan),
                    'tgl_mulai'			    =>  Pustaka::tgl_form($skp_bulanan->tgl_mulai),
                    'tgl_selesai'			=>  Pustaka::tgl_form($skp_bulanan->tgl_selesai),
                    'jm_kegiatan_bulanan'	=>  $jm_kegiatan,

                   
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



         
    }


    public function CapaianBulananStatusPengisian( Request $request )
    {
       
        
        $button_kirim = 0 ;


        $capaian_bulanan = CapaianBulanan::
                            SELECT(
                                'capaian_bulanan.id AS capaian_bulanan_id',
                                'capaian_bulanan.skp_bulanan_id',
                                'capaian_bulanan.created_at',
                                'capaian_bulanan.status_approve',
                                'capaian_bulanan.p_jabatan_id',
                                'capaian_bulanan.u_jabatan_id'
                            )
                            ->where('capaian_bulanan.id','=', $request->capaian_bulanan_id )->first();;
    
        $jenis_jabatan = $capaian_bulanan->PejabatYangDinilai->Eselon->id_jenis_jabatan;

        //jm kegiatan pelaksana
        if ( $jenis_jabatan == 4 ){
           /*  $jm_kegiatan_bulanan = KegiatanSKPBulanan::SELECT('id')
            ->WHERE('skp_bulanan_id', $capaian_bulanan->skp_bulanan_id )
            ->count(); */

            $jm_kegiatan_bulanan = KegiatanSKPBulanan::WHERE('skp_bulanan_id','=',$capaian_bulanan->skp_bulanan_id)->count();
        }else if ( $jenis_jabatan == 3){
            //cari bawahan
            $child = Jabatan::SELECT('id')->WHERE('parent_id',$capaian_bulanan->PejabatYangDinilai->id_jabatan )->get()->toArray(); 
                    
            //jm kegiatan kasubid   
            $jm_kegiatan_bulanan = RencanaAksi::WHEREIN('jabatan_id',$child)->WHERE('waktu_pelaksanaan', '01')->count();
        }else{
            $jm_kegiatan_bulanan = 0 ;
        }
                        

        //ATASAN
        $p_detail = HistoryJabatan::WHERE('id',$capaian_bulanan->p_jabatan_id)->first();


       /*  //apakah skp tahnan ini meiliki kegiatan tahunan dan setiap kegiatan minimal memiliki 1 rencana aksi
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
        if ( $capaian_bulanan->capaian_bulanan_id != null ){
            $created = 'ok';
        }else{
            $created = '-';
        }
        
        //STATUS PEJABAT PENILAI
        if ( $capaian_bulanan->atasan_id != null ){
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
         if ( ($capaian_bulanan->status_approve) == 1 ){
            $persetujuan_atasan = 'ok';
        }else{
            $persetujuan_atasan = '-';
        } */


        $response = array(
                
                'jm_kegiatan_bulanan'   => $jm_kegiatan_bulanan,
                'skp_bulanan_id'        => $capaian_bulanan->skp_bulanan_id,
                'tgl_dibuat'            => Pustaka::balik2($capaian_bulanan->created_at),
                'p_nama'                => Pustaka::nama_pegawai($p_detail->Pegawai->gelardpn , $p_detail->Pegawai->nama , $p_detail->Pegawai->gelarblk),


        );
       
        return $response;


    }



    public function Store(Request $request)
	{
        $messages = [
                 'pegawai_id.required'                   => 'Harus diisi',
                'skp_bulanan_id.required'               => 'Harus diisi',
                'tgl_mulai.required'                    => 'Harus diisi',
                'tgl_selesai.required'                  => 'Harus diisi',
                'u_nama.required'                       => 'Harus diisi',
                'u_jabatan_id.required'                 => 'Harus diisi',
                'jm_kegiatan_bulanan'                   => 'Harus Lebih dari nol'

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'pegawai_id'            => 'required',
                            'skp_bulanan_id'        => 'required',
                            'tgl_mulai'             => 'required',
                            'tgl_selesai'           => 'required',
                            'u_nama'                => 'required',
                            'u_jabatan_id'          => 'required',
                            'jm_kegiatan_bulanan'   => 'required|integer|min:1'
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


        $cek = CapaianBulanan::WHERE('pegawai_id',Input::get('pegawai_id'))
                                ->WHERE('skp_bulanan_id',Input::get('skp_bulanan_id'))
                                ->SELECT('id')
                                ->count();

        if ( $cek == 0 ){
            $capaian_bulanan    = new CapaianBulanan;
            $capaian_bulanan->pegawai_id                  = Input::get('pegawai_id');
            $capaian_bulanan->skp_bulanan_id              = Input::get('skp_bulanan_id');
            $capaian_bulanan->u_nama                      = Input::get('u_nama');
            $capaian_bulanan->u_jabatan_id                = Input::get('u_jabatan_id');
            $capaian_bulanan->p_nama                      = Input::get('p_nama');
            $capaian_bulanan->p_jabatan_id                = Input::get('p_jabatan_id');
            $capaian_bulanan->tgl_mulai                   = Pustaka::tgl_sql(Input::get('tgl_mulai'));
            $capaian_bulanan->tgl_selesai                 = Pustaka::tgl_sql(Input::get('tgl_selesai'));
            
    
            
    
            if ( $capaian_bulanan->save()){
                //SKPTahunanTimeline::INSERT(['capaian_bulanan_id'=>$capaian_bulanan->id]);
                SKPBulanan::WHERE('id',Input::get('skp_bulanan_id'))->UPDATE(['status' => '1']);
                return \Response::make($capaian_bulanan->id, 200);
            }else{
                return \Response::make('error', 500);
            } 

        //IF CEK SUDAH ADA CAPAIAN NYA
        }else{
            return \Response::make('Capaian untuk SKP ini sudah ada :'. $cek, 500);
        } 

    }   

    public function PejabatPenilaiUpdate(Request $request)
	{
        $messages = [
            'pejabat_penilai_id.required'           => 'Harus set Pegawai ID',
            'capaian_bulanan_id.required'           => 'Harus diisi',

        ];

        $validator = Validator::make(
            Input::all(),
            array(
                'pejabat_penilai_id'    => 'required',
                'capaian_bulanan_id'    => 'required',
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


        
       

        $capaian_bulanan    = CapaianBulanan::find($request->get('capaian_bulanan_id'));
        if (is_null($capaian_bulanan)) {
            return $this->sendError('Capaian Bulanan tidak ditemukan tidak ditemukan.');
        }

        
        $capaian_bulanan->p_jabatan_id    = $p_jabatan_id;
        $capaian_bulanan->p_nama          = Pustaka::nama_pegawai($pegawai->gelardpn , $pegawai->nama , $pegawai->gelarblk);
   
        
        $item = array(
           
            "p_nip"			=> $pegawai->nip,
            "p_nama"		=> Pustaka::nama_pegawai($pegawai->gelardpn , $pegawai->nama , $pegawai->gelarblk),
            "p_pangkat"	    => $pegawai->JabatanAktif->golongan?$pegawai->JabatanAktif->golongan->pangkat:'',
            "p_golongan"	=> $pegawai->JabatanAktif->golongan?$pegawai->JabatanAktif->golongan->golongan:'',
            "p_eselon"		=> $pegawai->JabatanAktif->Eselon?$pegawai->JabatanAktif->Eselon->eselon:'',
            "p_jabatan"		=> Pustaka::capital_string($pegawai->JabatanAktif->Jabatan?$pegawai->JabatanAktif->Jabatan->skpd:''),
            "p_unit_kerja"	=> Pustaka::capital_string($pegawai->JabatanAktif->Skpd?$pegawai->JabatanAktif->Skpd->skpd:''),
            );


        
        if (  $capaian_bulanan->save() ){
            return \Response::make(  $item , 200);


        }else{
            return \Response::make('error', 500);
        } 

    }


    public function Destroy(Request $request)
    {

        $messages = [
                'capaian_bulanan_id.required'   => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'capaian_bulanan_id'   => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $st_kt    = CapaianBulanan::find(Input::get('capaian_bulanan_id'));
        if (is_null($st_kt)) {
            //return $this->sendError('Kegiatan Bulanan tidak ditemukan.');
            return response()->json('Capaian Bulanan tidak ditemukan',422);
        }


        if ( $st_kt->delete()){

            SKPBulanan::WHERE('id',$st_kt->skp_bulanan_id)->UPDATE(['status' => '0']);

            return \Response::make($st_kt->skp_bulanan_id, 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }
   

}
