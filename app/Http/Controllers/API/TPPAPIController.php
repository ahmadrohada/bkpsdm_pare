<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Periode;
use App\Models\SKPD;
use App\Models\SKPTahunan;
use App\Models\SKPBulanan;
use App\Models\CapaianBulanan;
use App\Models\Pegawai;
use App\Models\HistoryJabatan;
use App\Models\Golongan;
use App\Models\Jabatan;
use App\Models\Eselon;

use App\Models\KegiatanSKPTahunan;
use App\Models\RencanaAksi;
use App\Models\KegiatanSKPBulanan;

use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Gravatar;
use Input;
use Alert;

class TPPAPIController extends Controller
{

    //=======================================================================================//
    protected function jabatan($id_jabatan)
    {
        $jabatan       = HistoryJabatan::WHERE('id', $id_jabatan)
            ->SELECT('jabatan')
            ->first();
        return Pustaka::capital_string($jabatan->jabatan);
    }


    public function Select2PeriodeList(Request $request)
    {

        $data       = Periode::get();

        $periode_list = [];
        foreach ($data as $x) {
            $periode_list[] = array(
                'text'        => $x->label,
                'id'        => Pustaka::tahun($x->awal),
            );
        }
        return $periode_list;
    }




    public function Select2SKPDList(Request $request)
    {

        $nama_skpd = $request->nama_skpd;

        $data = \DB::table('demo_asn.m_skpd AS skpd')

            ->whereRaw('id = id_skpd AND id != 1 AND id != 6 AND id != 8 AND id != 10 AND id != 12 ')
            ->where('skpd.skpd', 'LIKE', '%' . $nama_skpd . '%')
            ->select([
                'skpd.id_skpd AS skpd_id',
                'skpd.id_unit_kerja AS unit_kerja_id',
                'skpd.skpd AS skpd'
            ])

            ->get();


        $skpd_list = [];
        foreach ($data as $x) {
            $skpd_list[] = array(
                'text'        => $x->skpd,
                'id'        => $x->skpd_id,
            );
        }
        return $skpd_list;
    }

    public function Select2UnitKerjaList(Request $request)
    {

        $nama_unit_kerja = $request->nama_unit_kerja;

        $id_skpd = $request->skpd_id;


        $data = \DB::table('demo_asn.m_skpd AS skpd')
            ->rightjoin('demo_asn.m_skpd AS a', function ($join) {
                $join->on('a.parent_id', '=', 'skpd.id');
            })
            ->join('demo_asn.m_unit_kerja AS unit_kerja', function ($join) {
                $join->on('a.id', '=', 'unit_kerja.id');
            })
            ->WHERE('skpd.parent_id', $id_skpd)
            ->where('skpd.skpd', 'LIKE', '%' . $nama_unit_kerja . '%')
            ->select([
                'unit_kerja.id AS unit_kerja_id',
                'unit_kerja.unit_kerja AS unit_kerja'

            ])

            ->get();


        $unit_kerja_list = [];
        foreach ($data as $x) {
            $unit_kerja_list[] = array(
                'text'        => $x->unit_kerja,
                'id'        => $x->unit_kerja_id,
            );
        }
        return $unit_kerja_list;
    }

    public function AdministratorTPPBulananList(Request $request)
    {

        $id_skpd = $request->skpd_id ;

        $dt = \DB::table('demo_asn.tb_pegawai AS pegawai')
            ->rightjoin('demo_asn.tb_history_jabatan AS a', function ($join) {
                $join->on('a.id_pegawai', '=', 'pegawai.id');
            })
            //eselon
            ->leftjoin('demo_asn.m_skpd AS skpd ', function ($join) {
                $join->on('a.id_jabatan', '=', 'skpd.id');
            })
            

            ->select([
                'pegawai.nama',
                'pegawai.id AS pegawai_id',
                'pegawai.nip',
                'pegawai.gelardpn',
                'pegawai.gelarblk',
                'skpd.tunjangan AS tunjangan'
                

            ])
            ->where('pegawai.status', '=', 'active')
            ->where('a.id_skpd', '=', $id_skpd)
            ->where('a.status', '=', 'active');



        $datatables = Datatables::of($dt)
        ->addColumn('nama_pegawai', function ($x) {
            return Pustaka::nama_pegawai($x->gelardpn , $x->nama , $x->gelarblk);
        })
        ->addColumn('nip_pegawai', function ($x) {
            return $x->nip;
        })
        ->addColumn('tunjangan', function ($x) {
            return "Rp. ".number_format($x->tunjangan,'0',',','.');
        });
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }
        return $datatables->make(true);
    }
}
