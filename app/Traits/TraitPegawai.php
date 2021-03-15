<?php

namespace App\Traits;

use App\Models\Pegawai;


use App\Helpers\Pustaka;

trait TraitPegawai
{


    public function PegawaiSKPD($skpd_id){



    $pegawai_list = Pegawai::WITH(['JabatanAktif'])
                            ->WhereHas('JabatanAktif', function($q) use($skpd_id){
                                $q->WHERE('id_skpd',$skpd_id);
                            })
                ->leftjoin('demo_asn.tb_history_jabatan AS a', function($join){
                    $join   ->on('a.id_pegawai','=','tb_pegawai.id');
                    $join   ->where('a.status', '=', 'active');
                }) 
                //SKPD
                ->leftjoin('demo_asn.m_skpd AS skpd', function($join){
                             $join   ->on('skpd.id','=','a.id_skpd');
                })  
                //jabatan
                ->leftjoin('demo_asn.m_skpd AS jabatan', function($join){
                            $join   ->on('jabatan.id','=','a.id_jabatan');
                })  
                //eselon
                ->leftjoin('demo_asn.m_eselon AS eselon', function($join){
                            $join   ->on('eselon.id','=','jabatan.id_eselon');
                })  
                //GOL
                ->leftjoin('demo_asn.tb_history_golongan AS b', function($join){
                            $join   ->on('b.id_pegawai','=','tb_pegawai.id');
                            $join   ->WHERE('b.status','=','active');
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
                
                ->select([  'tb_pegawai.nama',
                            'tb_pegawai.id AS pegawai_id',
                            'tb_pegawai.nip',
                            'tb_pegawai.gelardpn',
                            'tb_pegawai.gelarblk',
                            'eselon.eselon AS eselon',
                            'golongan.golongan AS golongan',
                            'jabatan.skpd AS jabatan',
                            'a.unit_kerja AS unit_kerja',
                            'users.id AS user_id',
                            'role.id AS admin_role_user' 
                
                        ])
                ->where('tb_pegawai.status', '=', 'active')
                ->ORDERBY('a.id_eselon','ASC') 
                ->get();


        $item = array();
        foreach( $pegawai_list AS $x ){
        
            $item[] = array(
                
                            'user_id'           => $x->user_id,
                            'pegawai_id'        => $x->pegawai_id,
                            'nip'               => $x->nip,
                            'nama'              => Pustaka::nama_pegawai($x->gelardpn , $x->nama , $x->gelarblk),
                            'golongan'          => $x->golongan,
                            'jabatan'           => Pustaka::capital_string($x->jabatan),
                            'eselon'            => $x->eselon,
                            'unit_kerja'        => Pustaka::capital_string($x->unit_kerja),
                            'admin_role_user'   => $x->admin_role_user,
            );
        }
                
        return $item; 
    }


}