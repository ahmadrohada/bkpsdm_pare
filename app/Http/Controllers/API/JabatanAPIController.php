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



        
        $data       = SKPD::where('parent_id', $request->get('jabatan_id'))
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

    public function SKPDJabatanListSelect2(Request $request)
    {

        $jabatan       = SKPD::where('id_skpd', $request->get('skpd_id'))
                              ->where('id','!=',$request->get('skpd_id'))
                              ->Where('skpd','like', '%'.$request->get('skpd').'%')
                              ->get();

        $no = 0;
        $jabatan_list = [];
        foreach  ( $jabatan as $x){
            $no++;
            $jabatan_list[] = array(
                            'id'		  => $x->id,
                            'label'		=> Pustaka::capital_string($x->skpd),
                            );
            } 
        
        return $jabatan_list;


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

      $jabatan_id   = $request->jabatan_sendiri;
      $jabatan      = $request->jabatan;

      
      $eselon = SKPD::WHERE('m_skpd.id',$jabatan_id)->SELECT('m_skpd.id_eselon AS id_eselon')->first()->id_eselon;
      //id eselon
      //1 : I.a 2 : II.a 3 : II.b 4 : III.a  5 : III.b  6 : IV.a  7 : IV.b  8 : V.a  9 : JFU  10: JFT
      

      $bawahan = SKPD::WHERE('m_skpd.parent_id',$jabatan_id)
                      ->WHERE('m_skpd.skpd','LIKE','%'.$jabatan.'%')
                      ->SELECT( 'm_skpd.id AS jabatan_id',
                                'm_skpd.skpd',
                                'm_skpd.id_eselon'
                              );

      if ( $eselon == 6 ){
        $bawahan->WHERE('m_skpd.id_eselon','=',9);
      }
            
       $data = $bawahan->get();
          $no = 0;
          $pegawai_list = [];

          $pegawai_list[] = array(
                'id'		    => $request->jabatan_sendiri,
                'jabatan'	  => "Dilaksanakan Sendiri",
                );
      

         foreach  ( $data as $x){
             $no++;
             $pegawai_list[] = array(
                             'id'		    => $x->jabatan_id,
                             'jabatan'	=> Pustaka::capital_string($x->skpd),
                             );
             } 
         
         return $pegawai_list;  

    }
}
