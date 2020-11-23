<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Renja;
use App\Models\Kegiatan;
use App\Models\Tujuan;
use App\Models\Sasaran;
use App\Models\Program;
use App\Models\IndikatorProgram;
use App\Models\IndikatorSasaran;
use App\Models\Pegawai;
use App\Models\Jabatan;
use App\Models\SKPTahunan;

use App\Helpers\Pustaka;


use Datatables;
use Validator;
use Gravatar;
use Input;
Use PDF;

class KontrakKinerjaAPIController extends Controller {

   //SASARAN KOntrak kinerja JFU
   public function SasaranStrategisJFU(Request $request)
   {
       $jabatan_id     = $request->get('jabatan_id');
       $renja_id       = $request->get('renja_id');
       $skp_tahunan_id = $request->get('skp_tahunan_id');
      

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
                           ->join('db_pare_2018.renja_sasaran AS sasaran', function($join){
                               $join   ->on('program.sasaran_id','=','sasaran.id');
                           })
                           ->SELECT(   'sasaran.label AS sasaran_label',
                                       'program.label AS program_label',
                                       'program.id AS program_id',
                                       'ind_program.id AS ind_program_id',
                                       'ind_program.label AS ind_program_label',
                                       'ind_program.target AS target',
                                       'ind_program.satuan AS satuan',
                                       'ind_program.pk_status AS pk_status'
                                   ) 
                           ->WHERE('renja_kegiatan.renja_id', $renja_id )
                           ->WHEREIN('renja_kegiatan.jabatan_id',$child )
                           ->GroupBy('ind_program.id')
                           ->OrderBY('program.id','ASC')
                           ->OrderBY('ind_program.id','ASC')
                           ->get();

       $datatables = Datatables::of($dt)
                           ->addColumn('id', function ($x) {
                               return $x->program_id;
                           })
                           ->addColumn('program', function ($x) {
                               return Pustaka::capital_string($x->sasaran_label)." / ".Pustaka::capital_string($x->program_label);
                           })
                           ->addColumn('indikator', function ($x) {
                               return Pustaka::capital_string($x->ind_program_label);
                           })
                           ->addColumn('pk_status', function ($x) {
                               return $x->pk_status;
                           })
                           ->addColumn('target', function ($x) {
                               return $x->target." ".$x->satuan;
                           });
                           
       
                           if ($keyword = $request->get('search')['value']) {
                               $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
                           } 
       return $datatables->make(true);


   }


}
