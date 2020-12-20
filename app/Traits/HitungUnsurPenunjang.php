<?php

namespace App\Traits;


use App\Helpers\Pustaka;

trait HitungUnsurPenunjang
{


    public function Nilai_UP_TugasTambahan($count){ 

        if ( $count < 1){
            $n_nilai = 0;
        }else if ( $count <= 3 ){
            $n_nilai = 1;
        }else if ( $count <= 6 ){
            $n_nilai = 2;
        }else if ( $count >= 7 ){
            $n_nilai = 3;
        }


        return $n_nilai;
    }


}