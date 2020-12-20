<?php

namespace App\Traits;
use App\Models\PerilakuKerja;

use App\Helpers\Pustaka;

trait PenilaianPerilakuKerja
{


    public function NilaiPerilakuKerja($capaian_id){ 

        $x = PerilakuKerja::WHERE('penilaian_perilaku_kerja.capaian_tahunan_id', $capaian_id)->first();

		if ( $x != null ){
            $pelayanan = ($x->pelayanan_01+$x->pelayanan_02+$x->pelayanan_03)/15 * 100;
            $integritas = ($x->integritas_01+$x->integritas_02+$x->integritas_03+$x->integritas_04)/20*100;
            $komitmen = ($x->komitmen_03+$x->komitmen_03+$x->komitmen_03)/15*100;
            $disiplin = ($x->disiplin_01+$x->disiplin_02+$x->disiplin_03+$x->disiplin_04)/20*100;
            $kerjasama = ($x->kerjasama_01+$x->kerjasama_02+$x->kerjasama_03+$x->kerjasama_04+$x->kerjasama_05)/25*100;
            $kepemimpinan = ($x->kepemimpinan_01+$x->kepemimpinan_02+$x->kepemimpinan_03+$x->kepemimpinan_04+$x->kepemimpinan_05+$x->kepemimpinan_06)/30*100;

            if ( $x->CapaianTahunan->PejabatYangDinilai->Jabatan->Eselon->id_jenis_jabatan < 4 ){
                $jumlah = $pelayanan+$integritas+$komitmen+$disiplin+$kerjasama+$kepemimpinan;
                $ave    = $jumlah / 6 ;
            }else{
                $jumlah = $pelayanan+$integritas+$komitmen+$disiplin+$kerjasama;
                $ave    = $jumlah / 5 ; 
            }

            $pk = array(
                 
                    'pelayanan'         => Pustaka::persen_bulat($pelayanan),
					'integritas'        => Pustaka::persen_bulat($integritas),
					'komitmen'          => Pustaka::persen_bulat($komitmen),
					'disiplin'          => Pustaka::persen_bulat($disiplin),
					'kerjasama'         => Pustaka::persen_bulat($kerjasama),
                    'kepemimpinan'      => Pustaka::persen_bulat($kepemimpinan), 

                    'ket_pelayanan'     => Pustaka::perilaku($pelayanan),
					'ket_integritas'    => Pustaka::perilaku($integritas),
					'ket_komitmen'      => Pustaka::perilaku($komitmen),
					'ket_disiplin'      => Pustaka::perilaku($disiplin),
					'ket_kerjasama'     => Pustaka::perilaku($kerjasama),
                    'ket_kepemimpinan'  => Pustaka::perilaku($kepemimpinan), 


                    'jumlah'            => Pustaka::persen_bulat($jumlah), 
                    'rata_rata'         => Pustaka::persen_bulat($ave), 

                    'ket_rata_rata'     => Pustaka::perilaku($ave), 
            );
            return $pk;
        }else{
            $pk = array(




                    'pelayanan'     => "-",
					'integritas'    => "-",
					'komitmen'      => "-",
					'disiplin'      => "-",
					'kerjasama'     => "-",
                    'kepemimpinan'  => "-", 
                    'jumlah'        => "-",
                    'rata_rata'     => "-",
        );
        return $pk;
        }

    }


}