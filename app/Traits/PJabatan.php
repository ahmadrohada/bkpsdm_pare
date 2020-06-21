<?php

namespace App\Traits;

use App\Models\PerlakuanJabatan;

trait PJabatan
{


    protected function jenis_PJabatan($label){
        $data = PerlakuanJabatan::WHERE('label', $label )->pluck('jabatan_id');
        return json_encode($data);
    }


}