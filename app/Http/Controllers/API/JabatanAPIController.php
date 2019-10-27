<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Jabatan;
use App\Models\HistoryJabatan;
use App\Models\Skpd;

use App\Helpers\Pustaka;

use Datatables;

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
      $jabatan = Jabatan::find($request->jabatan_id);

      $pejabat_aktif =  $jabatan->PejabatAktif;

      //cari jabatan aktif pada history jabatan
      if ( $pejabat_aktif ){
        $pegawai_aktif = $jabatan->PejabatAktif->PegawaiAktif;
        //JIKA Pensiun / ID pegaiai not valid
        if ( $pegawai_aktif ){
          $nip      = $pegawai_aktif->nip;
          $nama     = Pustaka::nama_pegawai($pegawai_aktif->gelardpn , $pegawai_aktif->nama , $pegawai_aktif->gelarblk);
          $tmt      = Pustaka::tgl_form($pejabat_aktif->tmt_jabatan);

          $golongan = $jabatan->PejabatAktif->Golongan->label;
          $pangkat  = $jabatan->PejabatAktif->Golongan->pangkat;

          if ( $pegawai_aktif->Foto ){
            $foto = 'data:image/jpeg;base64,'.base64_encode($pegawai_aktif->Foto->isi) ;
          }else{

            if ( $pegawai_aktif->jenis_kelamin == 'Perempuan'){
                $foto   = asset('assets/images/form/female_icon.png');
            }else{
                $foto   = asset('assets/images/form/male_icon.png');
            }

          }
          

        }else{

          //PEGAWAI TIDAK AKTIF
          $nip      = "-";
          $nama     = "Pensiun";
          $tmt      = "";
          $golongan = "-";
          $pangkat  = "-";
          $foto  = asset('assets/images/form/default_icon.png');
        }


        $data = array(
          
              'jabatan'       => Pustaka::capital_string($jabatan->skpd),
              'eselon'        => $jabatan->Eselon ? $jabatan->Eselon->label : "",
              'id_eselon'     => $jabatan->id_eselon,
              'jenis_jabatan' => $jabatan->Eselon ? $jabatan->Eselon->JenisJabatan->label : "",
              'nip'           => $nip,
              'nama'          => $nama,
              'foto'          => $foto,
              'tmt'           => $tmt,
              'golongan'      => $golongan,
              'pangkat'       => $pangkat,
              

        ); 
        return $data;
      }else{
        $data = array(
          
          'jabatan'       => Pustaka::capital_string($jabatan->skpd),
          'eselon'        => $jabatan->Eselon ? $jabatan->Eselon->label : "",
          'id_eselon'     => $jabatan->id_eselon,
          'jenis_jabatan' => $jabatan->Eselon ? $jabatan->Eselon->JenisJabatan->label : "",
          'nip'           => "",
          'nama'          => "Tidak ditemukan pejabat aktif pada jabatan ini",
          'tmt'           => "",
          'foto'          => asset('assets/images/form/default_icon.png'),
          'golongan'      => "",
          'pangkat'       => "",
          

        ); 
        return $data;


      }
      
       

    }


    public function Select2BawahanList(Request $request)
    {

      $jabatan = $request->jabatan;

      $jabatan       = HistoryJabatan:: 
                                leftjoin('demo_asn.m_skpd AS skpd', function($join) use($jabatan){
                                  $join   ->on('tb_history_jabatan.id_jabatan','=','skpd.parent_id');
                                  $join  ->where('skpd.skpd','LIKE','%'.$jabatan.'%');
                                })
                                ->WHERE('tb_history_jabatan.id',$request->jabatan_id)
                                ->SELECT('skpd.id AS jabatan_id','skpd.skpd')
                                ->get();
                        
      
      
         $no = 0;
         $pegawai_list = [];
         foreach  ( $jabatan as $x){
             $no++;
             $pegawai_list[] = array(
                             'id'		    => $x->jabatan_id,
                             'jabatan'	=> Pustaka::capital_string($x->skpd),
                             );
             } 
         
         return $pegawai_list;

    }
}
