<?php

namespace App\Traits;

use App\Models\Pegawai;


use App\Helpers\Pustaka;

trait TraitPegawai
{






    public function PegawaiSKPD($skpd_id){
        $pegawai_list = Pegawai::
                            join("demo_asn.tb_history_jabatan AS a",function($join)use($skpd_id){
                                $join->on("a.id_pegawai","=","tb_pegawai.id")
                                    ->where("a.id_skpd","=",$skpd_id)
                                    ->where('a.status', '=', 'active');
                            })
                            ->join('demo_asn.tb_history_golongan AS b', function($join){
                                $join   ->on('b.id_pegawai','=','tb_pegawai.id');
                                $join   ->WHERE('b.status','=','active');
                            })  
                            //SKPD
                            ->leftjoin('demo_asn.m_skpd AS skpd', function($join){
                                $join   ->on('skpd.id','=','a.id_skpd');
                            }) 
                            //UNIT KERJA
                            /* ->leftjoin('demo_asn.m_unit_kerja AS c ', function($join){
                                $join   ->on('a.id_unit_kerja','=','c.id');
                            }) */
                            //jabatan
                            ->leftjoin('demo_asn.m_skpd AS jabatan', function($join){
                                $join   ->on('jabatan.id','=','a.id_jabatan');
                            })  
                            ->leftjoin('demo_asn.m_eselon AS eselon', function($join){
                                $join   ->on('eselon.id','=','jabatan.id_eselon');
                            }) 
                            //GOLONGAN
                            ->leftjoin('demo_asn.m_golongan AS golongan', function($join){
                                $join   ->on('golongan.id','=','b.id_golongan');
                            })  
                            //LEFT JOIN ke user
                            ->leftjoin('db_pare_2018.users', 'users.id_pegawai','=','tb_pegawai.id')

                            //LEFT JOIN ke roles admin SKPD
                            ->leftjoin('db_pare_2018.role_user AS role', function($join){
                                        $join   ->on('role.user_id','=','users.id');
                                        $join   ->where('role.role_id','=','2');
                            })
                            ->select([  'tb_pegawai.id AS pegawai_id',
                                        'tb_pegawai.nip',
                                        'tb_pegawai.nama',
                                        'tb_pegawai.gelardpn',
                                        'tb_pegawai.gelarblk',
                                        'a.jabatan AS jabatan',
                                        'a.unit_kerja',
                                        'skpd.skpd AS skpd',
                                        'jabatan.tunjangan AS tpp_rupiah',
                                        'golongan.golongan AS golongan',
                                        'eselon.eselon AS eselon',
                                        'role.id AS admin_role_user',
                                        'users.id AS user_id'
                                    
                                    
                                    ])
                            ->orderBy('a.id_eselon','ASC')
                            ->get();
                          
        $item = array();
        foreach( $pegawai_list AS $x ){


        
            $item[] = array(
                
                            //'user_id'           => $x->user_id,
                            'pegawai_id'        => $x->pegawai_id,
                            'nip'               => $x->nip,
                            'nama'              => Pustaka::nama_pegawai($x->gelardpn , $x->nama , $x->gelarblk),
                            'jabatan'           => Pustaka::capital_string($x->jabatan),
                            'unit_kerja'        => Pustaka::capital_string($x->unit_kerja),
                            'skpd'              => Pustaka::capital_string($x->skpd),
                            'golongan'          => $x->golongan,
                            'eselon'            => $x->eselon,
                            'admin_role_user'   => $x->admin_role_user, 
                            'user_id'           => $x->user_id,
                            'tpp_rupiah'        => $x->tpp_rupiah,
            );
        }
                
        return $item;  
    }


}