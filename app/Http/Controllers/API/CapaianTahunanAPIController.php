<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Periode;
use App\Models\PerjanjianKinerja;
use App\Models\SKPTahunan;
use App\Models\SKPBulanan;
use App\Models\CapaianBulanan;
use App\Models\CapaianTahunan;
use App\Models\Pegawai;
use App\Models\HistoryJabatan;
use App\Models\Jabatan;
use App\Models\Golongan;
use App\Models\Eselon;

use App\Models\KegiatanSKPTahunan;
use App\Models\RencanaAksi;
use App\Models\RealisasiRencanaAksiKasubid;
use App\Models\RealisasiRencanaAksiKabid;
use App\Models\RealisasiRencanaAksiKaban;
use App\Models\KegiatanSKPBulanan;
use App\Models\RealisasiKegiatanBulanan;

use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class CapaianTahunanAPIController extends Controller {

    protected function jabatan($id_jabatan){ 
        $jabatan       = HistoryJabatan::WHERE('id',$id_jabatan)
                        ->SELECT('jabatan')
                        ->first();
        if ( $jabatan == null ){
            return $jabatan;
        }else{
            return Pustaka::capital_string($jabatan->jabatan);
        }
        
    }



    public function PersonalCapaianTahunanList(Request $request)
    {
        $skp = SKPTahunan::
                        leftjoin('db_pare_2018.capaian_tahunan', function($join){
                            $join   ->on('capaian_tahunan.skp_tahunan_id','=','skp_tahunan.id');
                        })
                        ->WHERE('skp_tahunan.pegawai_id',$request->pegawai_id)
                        ->select(
                                'skp_tahunan.id AS skp_tahunan_id',
                                'skp_tahunan.renja_id',
                                'skp_tahunan.tgl_mulai',
                                'skp_tahunan.tgl_selesai',
                                'skp_tahunan.u_jabatan_id',
                                'skp_tahunan.status AS skp_tahunan_status',
                                'capaian_tahunan.id AS capaian_id',
                                'capaian_tahunan.status_approve AS capaian_status_approve',
                                'capaian_tahunan.send_to_atasan AS capaian_send_to_atasan'

            
                         )
                       // ->orderBy('bulan','ASC')
                        ->get();

                    
       
           $datatables = Datatables::of($skp)
             ->addColumn('periode', function ($x) {
                //return  Pustaka::Tahun($x->tgl_mulai);
                return $x->Renja->Periode->label;
            }) 
            ->addColumn('pelaksanaan', function ($x) {
                $masa_penilaian = Pustaka::balik($x->tgl_mulai). ' s.d ' . Pustaka::balik($x->tgl_selesai);
                return   $masa_penilaian;
            }) 
            ->addColumn('jabatan', function ($x) {
                if ( $this->jabatan($x->u_jabatan_id) == null ){
                    return "ID Jabatan : ".$x->u_jabatan_id;
                }else{
                    return  $this->jabatan($x->u_jabatan_id);
                }
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
   

    
    public function BeforeEndCreateConfirm(Request $request)
	{

       

      
        $skp_tahunan   = SKPTahunan::WHERE('skp_tahunan.id',$request->get('skp_tahunan_id'))
                        
                        ->SELECT('skp_tahunan.id AS skp_tahunan_id',
                                 'skp_tahunan.tgl_mulai',
                                 'skp_tahunan.tgl_selesai',
                                 'skp_tahunan.renja_id',
                                 'skp_tahunan.u_jabatan_id',
                                 'skp_tahunan.p_jabatan_id',
                                 'skp_tahunan.pegawai_id'

                                 
                                )
                        ->first();

        $jenis_jabatan = $skp_tahunan->PejabatYangDinilai->Eselon->id_jenis_jabatan;

        /*  1 : KABAN     / ESELON 2
            2 : KABID     / ESELON 3
            3 : KASUBID   / ESELON 4
            4 : PELAKSANA / JFU
        */

        //================================= PELAKSANA / JFU ================================================//
        if ( $jenis_jabatan == 4 ){


        //================================= KASUBID   / ESELON 4 ===========================================//
        }else if ( $jenis_jabatan == 3 ){
            $jm_kegiatan = KegiatanSKPTahunan::WHERE('skp_tahunan_id',$skp_tahunan->skp_tahunan_id)->count();


        //================================= KABID     / ESELON 3 ===========================================//
        }else if ( $jenis_jabatan == 2 ){

        //================================= KABAN     / ESELON 2 ===========================================//
        }else if ( $jenis_jabatan == 1 ){

        }else{

        }

      
        //DETAIL data pribadi dan atasan
        $u_detail = HistoryJabatan::WHERE('id',$skp_tahunan->u_jabatan_id)->first();
        $p_detail = HistoryJabatan::WHERE('id',$skp_tahunan->p_jabatan_id)->first();

        if ( $skp_tahunan->p_jabatan_id >= 1 ){
            $data = array(
                'status'			    =>  'pass',
                'skp_tahunan_id'        =>  $skp_tahunan->skp_tahunan_id,
                'jabatan_id'            =>  $skp_tahunan->PejabatYangDinilai->id_jabatan,
                'pegawai_id'            =>  $skp_tahunan->pegawai_id,
                'periode_label'			=>  $skp_tahunan->Renja->Periode->label,
                'tgl_mulai'			    =>  Pustaka::tgl_form($skp_tahunan->tgl_mulai),
                'tgl_selesai'			=>  Pustaka::tgl_form($skp_tahunan->tgl_selesai),
               
                'tgl_selesai_baru'      => date("d-m-Y"),

                'renja_id'	            =>  $skp_tahunan->Renja->id,
                'jm_kegiatan'           =>  $jm_kegiatan,

               
                'u_jabatan_id'	        => $u_detail->id,
                'u_nip'	                => $u_detail->nip,
                'u_nama'                => Pustaka::nama_pegawai($u_detail->Pegawai->gelardpn , $u_detail->Pegawai->nama , $u_detail->Pegawai->gelarblk),
                'u_pangkat'	            => $u_detail->Golongan ? $u_detail->Golongan->pangkat : '',
                'u_golongan'	        => $u_detail->Golongan ? $u_detail->Golongan->golongan : '',
                'u_eselon'	            => $u_detail->Eselon ? $u_detail->Eselon->eselon : '',
                'u_jabatan'	            => Pustaka::capital_string($u_detail->Jabatan ? $u_detail->Jabatan->skpd : ''),
                'u_unit_kerja'	        => Pustaka::capital_string($u_detail->UnitKerja ? $u_detail->UnitKerja->unit_kerja : ''),
                'u_skpd'	            => Pustaka::capital_string($u_detail->Skpd ? $u_detail->Skpd->skpd : ''),
                'u_jenis_jabatan'	    => $u_detail->Eselon->Jenis_jabatan->id,

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
        }else{

        
        $data = array(
                    'status'			    =>  'pass',
                    'skp_tahunan_id'        => $skp_tahunan->skp_tahunan_id,
                    'jabatan_id'            =>  $skp_tahunan->PejabatYangDinilai->id_jabatan,
                    'pegawai_id'            =>  $skp_tahunan->pegawai_id,
                    'periode_label'			=>  $skp_tahunan->Renja->Periode->label,
                    'tgl_mulai'			    =>  Pustaka::tgl_form($skp_tahunan->tgl_mulai),
                    'tgl_selesai'			=>  Pustaka::tgl_form($skp_tahunan->tgl_selesai),
                    'tgl_selesai_baru'      => date("d-m-Y"),

                    'renja_id'	            =>  $skp_tahunan->Renja->id,

                   
                    'u_jabatan_id'	        => $u_detail->id,
                    'u_nip'	                => $u_detail->nip,
                    'u_nama'                => Pustaka::nama_pegawai($u_detail->Pegawai->gelardpn , $u_detail->Pegawai->nama , $u_detail->Pegawai->gelarblk),
                    'u_pangkat'	            => $u_detail->Golongan ? $u_detail->Golongan->pangkat : '',
                    'u_golongan'	        => $u_detail->Golongan ? $u_detail->Golongan->golongan : '',
                    'u_eselon'	            => $u_detail->Eselon ? $u_detail->Eselon->eselon : '',
                    'u_jabatan'	            => Pustaka::capital_string($u_detail->Jabatan ? $u_detail->Jabatan->skpd : ''),
                    'u_unit_kerja'	        => Pustaka::capital_string($u_detail->UnitKerja ? $u_detail->UnitKerja->unit_kerja : ''),
                    'u_skpd'	            => Pustaka::capital_string($u_detail->Skpd ? $u_detail->Skpd->skpd : ''),
                    'u_jenis_jabatan'	    => $u_detail->Eselon->Jenis_jabatan->id,

                    'p_jabatan_id'	        => "",
                    'p_nip'	                => "",
                    'p_nama'                => "",
                    'p_pangkat'	            => "",
                    'p_golongan'	        => "",
                    'p_eselon'	            => "",
                    'p_jabatan'	            => "",
                    'p_unit_kerja'	        => "",
                    'p_skpd'	            => "",
                    
                    );
        }

        return $data;
    }

    public function BeforeEndStore(Request $request)
	{
        $messages = [
                 'pegawai_id.required'                   => 'Harus diisi',
                 'skp_tahunan_id.required'               => 'Harus diisi',
                 'tgl_mulai.required'                    => 'Harus diisi',
                 'tgl_selesai.required'                  => 'Harus diisi',
                 'tgl_selesai_baru.required'             => 'Harus diisi',
                 'u_nama.required'                       => 'Harus diisi',
                 'jenis_jabatan.required'                => 'Harus diisi',
                 'u_jabatan_id.required'                 => 'Harus diisi',
                 'jm_kegiatan'                           => 'Harus Lebih dari nol'

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'pegawai_id'            => 'required',
                            'skp_tahunan_id'        => 'required',
                            'tgl_mulai'             => 'required',
                            'tgl_selesai'           => 'required',
                            'tgl_selesai_baru'      => 'required',
                            'u_nama'                => 'required',
                            'u_jabatan_id'          => 'required',
                            'jenis_jabatan'         => 'required',
                            'jm_kegiatan'           => 'required|integer|min:1'
                        ),
                        $messages
        );
    
        if ( $validator->fails() ){
            //$messages = $validator->messages();
                    return response()->json(['errors'=>$validator->messages()],422);
            
        }

        if ( (Pustaka::tgl_sql(Input::get('tgl_mulai'))) >= (Pustaka::tgl_sql(Input::get('tgl_selesai_baru'))) ){
            $pesan =  ['masa_penilaian'  => 'Error'] ;
            return response()->json(['errors'=> $pesan ],422);
            
        }


        $cek = CapaianTahunan::WHERE('pegawai_id',Input::get('pegawai_id'))
                                ->WHERE('skp_tahunan_id',Input::get('skp_tahunan_id'))
                                ->SELECT('id')
                                ->count();

        if ( $cek == 0 ){
            $capaian_tahunan                              = new CapaianTahunan;
            $capaian_tahunan->pegawai_id                  = Input::get('pegawai_id');
            $capaian_tahunan->skp_tahunan_id              = Input::get('skp_tahunan_id');
            $capaian_tahunan->u_nama                      = Input::get('u_nama');
            $capaian_tahunan->u_jabatan_id                = Input::get('u_jabatan_id');
            $capaian_tahunan->p_nama                      = Input::get('p_nama');
            $capaian_tahunan->p_jabatan_id                = Input::get('p_jabatan_id');
            $capaian_tahunan->tgl_mulai                   = Pustaka::tgl_sql(Input::get('tgl_mulai'));
            $capaian_tahunan->tgl_selesai                 = Pustaka::tgl_sql(Input::get('tgl_selesai_baru'));
            
    
            
    
            if ( $capaian_tahunan->save()){
               
                SKPTahunan::WHERE('id',Input::get('skp_tahunan_id'))->UPDATE( [ 'status' => '1',
                                                                                'tgl_selesai' => Pustaka::tgl_sql(Input::get('tgl_selesai_baru'))
                                                                             ]);

               /*  //jika kabid, auto add kegiatan
                if ( Input::get('jenis_jabatan') == '2'){
                    $bawahan_ls = Jabatan::SELECT('id')->WHERE('parent_id',Input::get('jabatan_id'))->get()->toArray();
                    //cari bawahan  , jabatanpelaksanan
                    $pelaksana_list = Jabatan::SELECT('id')->WHEREIN('parent_id', $bawahan_ls)->get()->toArray(); 
        
                    $kegiatan_list = RencanaAksi::WHEREIN('jabatan_id',$pelaksana_list)
                                                ->leftjoin('db_pare_2018.realisasi_rencana_aksi_kasubid AS realisasi', function($join){
                                                    $join   ->on('realisasi.rencana_aksi_id','=','skp_tahunan_rencana_aksi.id');
                                                })
                                                ->SELECT('skp_tahunan_rencana_aksi.id','realisasi.realisasi','skp_tahunan_rencana_aksi.satuan')
                                                ->WHERE('skp_tahunan_rencana_aksi.waktu_pelaksanaan',Input::get('waktu_pelaksanaan'))
                                                ->WHERE('skp_tahunan_rencana_aksi.renja_id',Input::get('renja_id'))
                                                ->get(); 
                    $i = 0 ;
                    foreach ($kegiatan_list as $x) {
                        $data[] = array(
                                        
                            'rencana_aksi_id'       => $x->id,
                            'capaian_id'            => $capaian_bulanan->id,
                            'realisasi'             => $x->realisasi,
                            'satuan'                => $x->satuan,
                            'created_at'            => date('Y'."-".'m'."-".'d'." ".'H'.":".'i'.":".'s'),
                        );
                        $i++;
                    }
                            
                    if ( $i >= 1 ){
                        $st_ra   = new RealisasiRencanaAksiKabid;
                        $st_ra -> insert($data);
                    }
                }else if ( Input::get('jenis_jabatan') == '1'){ //KAABAN

                    $kasubid_ls = Jabatan::
                                        leftjoin('demo_asn.m_skpd AS kasubid', function($join){
                                            $join   ->on('kasubid.parent_id','=','m_skpd.id');
                                        })
                                        ->SELECT('kasubid.id')
                                        ->WHERE('m_skpd.parent_id',Input::get('jabatan_id') )
                                        ->get()
                                        ->toArray(); 

                  
                    //cari bawahan  , jabatanpelaksanan
                    $pelaksana_list = Jabatan::SELECT('id')->WHEREIN('parent_id', $kasubid_ls)->get()->toArray(); 
        
                    $kegiatan_list = RencanaAksi::WHEREIN('jabatan_id',$pelaksana_list)
                                                ->leftjoin('db_pare_2018.realisasi_rencana_aksi_kasubid AS realisasi', function($join){
                                                    $join   ->on('realisasi.rencana_aksi_id','=','skp_tahunan_rencana_aksi.id');
                                                })
                                                ->SELECT('skp_tahunan_rencana_aksi.id','realisasi.realisasi','skp_tahunan_rencana_aksi.satuan')
                                                ->WHERE('skp_tahunan_rencana_aksi.waktu_pelaksanaan',Input::get('waktu_pelaksanaan'))
                                                ->WHERE('skp_tahunan_rencana_aksi.renja_id',Input::get('renja_id'))
                                                ->get(); 
                    $i = 0 ;
                    foreach ($kegiatan_list as $x) {
                        $data[] = array(
                                        
                            'rencana_aksi_id'       => $x->id,
                            'capaian_id'            => $capaian_bulanan->id,
                            'realisasi'             => $x->realisasi,
                            'satuan'                => $x->satuan,
                            'created_at'            => date('Y'."-".'m'."-".'d'." ".'H'.":".'i'.":".'s'),
                        );
                        $i++;
                    }
                            
                    if ( $i >= 1 ){
                        $st_ra   = new RealisasiRencanaAksiKaban;
                        $st_ra -> insert($data);
                    }
                
                }
                 */
              
               
                

                return \Response::make($capaian_tahunan->id, 200);
            }else{
                return \Response::make('error', 500);
            } 

        //IF CEK SUDAH ADA CAPAIAN NYA
        }else{
            return \Response::make('Capaian untuk SKP ini sudah ada :'. $cek, 500);
        } 

    }   


}
