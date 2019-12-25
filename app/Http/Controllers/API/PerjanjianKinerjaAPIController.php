<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Renja;
use App\Models\Kegiatan;
use App\Models\Tujuan;
use App\Models\Sasaran;
use App\Models\Pegawai;
use App\Models\Jabatan;

use App\Helpers\Pustaka;


use Datatables;
use Validator;
use Gravatar;
use Input;
Use PDF;

class PerjanjianKinerjaAPIController extends Controller {

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
            
        $dt = Tujuan::
                    rightjoin('db_pare_2018.renja_sasaran AS sasaran', function ($join) {
                        $join->on('sasaran.tujuan_id', '=', 'renja_tujuan.id');
                    })
                    ->leftjoin('db_pare_2018.renja_indikator_sasaran AS ind_sasaran', function ($join) {
                        $join->on('ind_sasaran.sasaran_id', '=', 'sasaran.id');
                    })
                    ->where('renja_tujuan.renja_id', '=' ,$request->get('renja_id'))
                    ->select([   
                                'sasaran.id AS sasaran_id',
                                'sasaran.label AS sasaran_label',
                                'sasaran.pk_status AS pk_status',
                                'ind_sasaran.label AS ind_sasaran_label',
                                'ind_sasaran.target AS target',
                                'ind_sasaran.satuan AS satuan'
                            ])

                    ->ORDERBY('renja_tujuan.id','DESC')
                    ->ORDERBY('sasaran.id','DESC')
                    ->get();

        $datatables = Datatables::of($dt)
                    ->addColumn('id', function ($x) {
                        return $x->sasaran_id;
                    })
                    ->addColumn('sasaran', function ($x) {
                        return Pustaka::capital_string($x->sasaran_label);
                    })
                    ->addColumn('indikator', function ($x) {
                        return Pustaka::capital_string($x->ind_sasaran_label);
                    })
                    ->addColumn('target', function ($x) {
                        return $x->target." ".$x->satuan;
                    })
                    ->addColumn('pk_status', function ($x) {
                        return $x->pk_status;
                    });

                    if ($keyword = $request->get('search')['value']) {
                        $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
                    } 
        return $datatables->make(true);
    }


    public function ProgramSKPD(Request $request)
    {
            
        $dt = Tujuan::
                    rightjoin('db_pare_2018.renja_sasaran AS sasaran', function ($join) {
                        $join->on('sasaran.tujuan_id', '=', 'renja_tujuan.id');
                        $join->WHERE('sasaran.pk_status', '=', '1');
                    })
                    ->rightjoin('db_pare_2018.renja_program AS program', function ($join) {
                        $join->on('program.sasaran_id', '=', 'sasaran.id');
                    })
                    ->where('renja_tujuan.renja_id', '=' ,$request->get('renja_id'))
                    ->select([   
                                'program.id AS program_id',
                                'program.label AS program_label'
                            ])

                    ->get();

        $datatables = Datatables::of($dt)
                    ->addColumn('id', function ($x) {
                        return $x->program_id;
                    })
                    ->addColumn('program', function ($x) {
                        return $x->program_label;
                    })
                    ->addColumn('anggaran', function ($x) {

                        $dt = Kegiatan::WHERE('program_id',$x->program_id)->select( \DB::raw('SUM(cost) as anggaran'))->get();
                        //return $dt[0]['anggaran'];
                        return "Rp.   " . number_format( $dt[0]['anggaran'], '0', ',', '.');
                    })
                    ->addColumn('keterangan', function ($x) {
                        return "";
                    });

                    if ($keyword = $request->get('search')['value']) {
                        $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
                    } 
        return $datatables->make(true);
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

    
    public function TotalAnggaranSKPD(Request $request)
    {
        $dt = Tujuan::
                    rightjoin('db_pare_2018.renja_sasaran AS sasaran', function ($join) {
                        $join->on('sasaran.tujuan_id', '=', 'renja_tujuan.id');
                        $join->WHERE('sasaran.pk_status', '=', '1');
                    })
                    ->rightjoin('db_pare_2018.renja_program AS program', function ($join) {
                        $join->on('program.sasaran_id', '=', 'sasaran.id');
                    })
                    ->where('renja_tujuan.renja_id', '=' ,$request->get('renja_id'))
                    ->select([   
                                'program.id AS program_id',
                                'program.label AS program_label'
                            ])

                    ->get();

        $total_anggaran = 0 ;
        foreach ($dt as $x) {
            $dt = Kegiatan::WHERE('program_id',$x->program_id)->select( \DB::raw('SUM(cost) as anggaran'))->get();
            $total_anggaran = $total_anggaran+$dt[0]['anggaran'];
            //return "Rp.   " . number_format( $dt[0]['anggaran'], '0', ',', '.');

        }

		
		//return  $kegiatan_tahunan;
        $ta = array(
            'total_anggaran'    => "Rp.   " . number_format( $total_anggaran, '0', ',', '.'),

        );
        return $ta;
    }


    public function cetakPerjanjianKinerjaEsl2(Request $request)
    {
        $data = Tujuan::
                    rightjoin('db_pare_2018.renja_sasaran AS sasaran', function ($join) {
                        $join->on('sasaran.tujuan_id', '=', 'renja_tujuan.id');
                        $join->WHERE('sasaran.pk_status', '=', '1');
                    })
                    ->leftjoin('db_pare_2018.renja_indikator_sasaran AS ind_sasaran', function ($join) {
                        $join->on('ind_sasaran.sasaran_id', '=', 'sasaran.id');
                    })
                    ->where('renja_tujuan.renja_id', '=' ,$request->get('renja_id'))
                    ->select([   
                                'sasaran.id AS sasaran_id',
                                'sasaran.label AS sasaran_label',
                                'sasaran.pk_status AS pk_status',
                                'ind_sasaran.label AS ind_sasaran_label',
                                'ind_sasaran.target AS target',
                                'ind_sasaran.satuan AS satuan'
                            ])

                    ->ORDERBY('renja_tujuan.id','DESC')
                    ->ORDERBY('sasaran.id','DESC')
                    ->get();

        $data_2 = Tujuan:: 
                    rightjoin('db_pare_2018.renja_sasaran AS sasaran', function ($join) {
                        $join->on('sasaran.tujuan_id', '=', 'renja_tujuan.id');
                        $join->WHERE('sasaran.pk_status', '=', '1');
                    })
                    ->rightjoin('db_pare_2018.renja_program AS program', function ($join) {
                        $join->on('program.sasaran_id', '=', 'sasaran.id');
                    })
                    ->leftjoin('db_pare_2018.renja_kegiatan AS kegiatan', function ($join) {
                        $join->on('kegiatan.program_id', '=', 'program.id');
                    })
                    ->where('renja_tujuan.renja_id', '=' ,$request->get('renja_id'))
                    ->select([   
                                'program.id AS program_id',
                                'program.label AS program_label',
                                \DB::raw("SUM(kegiatan.cost) as anggaran")
                            ])
                    ->GroupBy('program.label')
                    ->get();

        $dt_3 = Tujuan::
                    rightjoin('db_pare_2018.renja_sasaran AS sasaran', function ($join) {
                        $join->on('sasaran.tujuan_id', '=', 'renja_tujuan.id');
                        $join->WHERE('sasaran.pk_status', '=', '1');
                    })
                    ->rightjoin('db_pare_2018.renja_program AS program', function ($join) {
                        $join->on('program.sasaran_id', '=', 'sasaran.id');
                    })
                    ->leftjoin('db_pare_2018.renja_kegiatan AS kegiatan', function ($join) {
                        $join->on('kegiatan.program_id', '=', 'program.id');
                    })
                    ->where('renja_tujuan.renja_id', '=' ,$request->get('renja_id'))
                    ->select([   
                                \DB::raw("SUM(kegiatan.cost) as total_anggaran")
                            ])
                    ->first();
       

        //NAMA SKPD
        $Renja = Renja::WHERE('renja.id',$request->get('renja_id'))
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
        

       $pdf = PDF::loadView('admin.printouts.cetak_perjanjian_kinerja', [   
                                                    'data'          => $data , 
                                                    'data_2'        => $data_2 ,
                                                    'total_anggaran'=> $dt_3->total_anggaran,
                                                    'tgl_dibuat'    => $Renja->tgl_dibuat,
                                                    'nama_ka_skpd'  => $Renja->nama_kepala_skpd,
                                                    'nip_ka_skpd'   => $Renja->nip_ka_skpd,
                                                    'jenis_jabatan_ka_skpd'=> $Renja->jenis_jabatan_ka_skpd,
                                                    'nama_skpd'     => $this::nama_skpd($Renja->skpd_id),
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
        //return $pdf->download('TPP'.$p->bulan.'_'.$this::nama_skpd($p->skpd_id).'.pdf');
        return $pdf->stream('PerjanjianKinerja.pdf');
    }


    public function SasaranStrategisEselon3(Request $request)
    {
        $jabatan_id     = 901;
        $renja_id       = 2;
       

        //cari bawahan nya, karena eselon 3 tidak punya kegiatan tahunan,yang punya nya adalah  bawahan nya
        $child = Jabatan::SELECT('id')->WHERE('parent_id', $jabatan_id )->get()->toArray(); 
        $dt = Kegiatan::
                            
                            /* join('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join){
                                $join   ->on('kegiatan_tahunan.kegiatan_id','=','renja_kegiatan.id');
                            }) */
                            join('db_pare_2018.renja_program AS program', function($join){
                                $join   ->on('renja_kegiatan.program_id','=','program.id');
                            })
                            ->join('db_pare_2018.renja_indikator_program AS ind_program', function($join){
                                $join   ->on('ind_program.program_id','=','program.id');
                            })
                            ->SELECT(   'program.label AS program_label',
                                        'program.id AS program_id',
                                        'ind_program.label AS ind_program_label',
                                        'ind_program.target AS target',
                                        'ind_program.satuan AS satuan'
                                    ) 
                            ->WHERE('renja_kegiatan.renja_id', $renja_id )
                            ->WHEREIN('renja_kegiatan.jabatan_id',$child )
                            ->GroupBy('ind_program.id')
                            ->OrderBY('program.id','ASC')
                            ->OrderBY('ind_program.id','ASC')
                            ->get();

        $datatables = Datatables::of($dt)
                            ->addColumn('id', function ($x) {
                                return $x->sasaran_id;
                            })
                            ->addColumn('program', function ($x) {
                                return Pustaka::capital_string($x->program_label);
                            })
                            ->addColumn('indikator', function ($x) {
                                return Pustaka::capital_string($x->ind_program_label);
                            })
                            ->addColumn('target', function ($x) {
                                return $x->target." ".$x->satuan;
                            });
                            
        
                            if ($keyword = $request->get('search')['value']) {
                                $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
                            } 
        return $datatables->make(true);


    }

    public function ProgramEselon3(Request $request)
    {
            
        $jabatan_id     = 901;
        $renja_id       = 2;
       

        //cari bawahan nya, karena eselon 3 tidak punya kegiatan tahunan,yang punya nya adalah  bawahan nya
        $child = Jabatan::SELECT('id')->WHERE('parent_id', $jabatan_id )->get()->toArray(); 
        $dt = Kegiatan::
                            SELECT(     'renja_kegiatan.id AS kegiatan_id',
                                        'renja_kegiatan.label AS kegiatan_label',
                                        'renja_kegiatan.cost AS anggaran'
                                    ) 
                            ->WHERE('renja_kegiatan.renja_id', $renja_id )
                            ->WHEREIN('renja_kegiatan.jabatan_id',$child )
                            ->get();

        
        $datatables = Datatables::of($dt)
                            ->addColumn('id', function ($x) {
                                return $x->kegiatan_id;
                            })
                            ->addColumn('kegiatan', function ($x) {
                                return Pustaka::capital_string($x->kegiatan_label);
                            })
                            ->addColumn('anggaran', function ($x) {
                                return "Rp.   " . number_format( $x->anggaran, '0', ',', '.');
                            })
                            ->addColumn('keterangan', function ($x) {
                                return "";
                            });
                            
        
                            if ($keyword = $request->get('search')['value']) {
                                $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
                            } 
        return $datatables->make(true); 

    }

    public function TotalAnggaranEselon3(Request $request)
    {
        $jabatan_id     = 901;
        $renja_id       = 2;
       

        //cari bawahan nya, karena eselon 3 tidak punya kegiatan tahunan,yang punya nya adalah  bawahan nya
        $child = Jabatan::SELECT('id')->WHERE('parent_id', $jabatan_id )->get()->toArray(); 
        $dt = Kegiatan::
                            SELECT(     \DB::raw("SUM(renja_kegiatan.cost) as total_anggaran")
                                    ) 
                            ->WHERE('renja_kegiatan.renja_id', $renja_id )
                            ->WHEREIN('renja_kegiatan.jabatan_id',$child )
                            ->first();


        $ta = array(
                'total_anggaran'    => "Rp.   " . number_format( $dt->total_anggaran, '0', ',', '.'),
                );
        return $ta;
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
