<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

use App\Models\Jabatan;
use App\Models\Skpd;

use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class JabatanAPIController extends Controller {


   
    public function select2_jabatan_list(Request $request)
    {

        /* $tes = '{
            "results": [
              { 
                "text": "Group 1", 
                "children" : [
                  {
                      "id": 1,
                      "text": "Option 1.1"
                  },
                  {
                      "id": 2,
                      "text": "Option 1.2"
                  }
                ]
              },
              { 
                "text": "Group 2", 
                "children" : [
                  {
                      "id": 3,
                      "text": "Option 2.1",
                      "disabled": true
                  },
                  {
                      "id": 4,
                      "text": "Option 2.2"
                  }
                ]
              }
            ],
            "paginate": {
              "more": true
            }
          }'; */



        
        $data       = Skpd::where('parent_id', $request->get('jabatan_id'))
                      ->get();

        $unit_kerja_list = [];
        foreach  ( $data as $x){
           
            //== cari jabatan pada unit kerja ini
            $jabatan_list = [];
            $jabatan  = Jabatan::where('parent_id',$x->id)->get();
            foreach  ( $jabatan as $y){
                $jabatan_list[] = array(
                            'id'		=> $y->id,
                            'text'		=> Pustaka::capital_string($y->skpd),
                );
    
            }
            
            $unit_kerja_list[] = array(
                'text'		=> Pustaka::capital_string($x->bidang->unit_kerja),
                'children'  => $jabatan_list,
             );


        } 
                    
        return $unit_kerja_list;


    }



    public function PejabatAktifDetail(Request $request)
    {
       
        
        $x = Jabatan::
                            leftjoin('demo_asn.tb_history_jabatan AS pejabat', function($join){
                                $join   ->on('pejabat.id_jabatan','=','m_skpd.id');
                                $join   ->WHERE('pejabat.status','=', 'active' );
                            })
                            ->leftjoin('demo_asn.tb_pegawai AS asn', function($join){
                                $join   ->on('asn.id','=','pejabat.id_pegawai');
                            })
                            ->leftjoin('demo_asn.m_eselon AS eselon', function($join){
                              $join   ->on('pejabat.id_eselon','=','eselon.id');
                            })
                            ->leftjoin('demo_asn.m_jenis_jabatan AS jenis_jabatan', function($join){
                              $join   ->on('eselon.id_jenis_jabatan','=','jenis_jabatan.id');
                            })
                            
                            ->WHERE('m_skpd.id', $request->jabatan_id)
                            ->SELECT('m_skpd.skpd AS jabatan',
                                     'pejabat.id_pegawai',
                                     'pejabat.id AS jabatan_id',
                                     'pejabat.id_pegawai',
                                     'asn.nip',
                                     'asn.nama',
                                     'asn.gelardpn',
                                     'asn.gelarblk',
                                     'eselon.eselon',
                                     'jenis_jabatan.jenis_jabatan'

                                    )
                            ->first();

		
		//return  $kegiatan_tahunan;
        $pejabat = array(
            'nip'           => $x->nip,
            'nama'          => Pustaka::nama_pegawai($x->gelardpn , $x->nama , $x->gelarblk),
            'jenis_jabatan' => $x->jenis_jabatan,
            'eselon'        => $x->eselon,
            'jabatan'       => Pustaka::capital_string($x->jabatan)

        ); 
        return $pejabat;
    }


}
