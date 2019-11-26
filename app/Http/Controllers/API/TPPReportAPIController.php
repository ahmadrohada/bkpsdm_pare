<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\TPPReport;
use App\Models\TPPReportData;
use App\Models\Periode;
use App\Models\Pegawai;
use App\Models\Skpd;

use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Gravatar;
use Input;
use Alert;

class TPPReportAPIController extends Controller
{


    //=======================================================================================//
    protected function nama_skpd($skpd_id)
    {
        //nama SKPD 
        $nama_skpd       = \DB::table('demo_asn.m_skpd AS skpd')
            ->WHERE('id', $skpd_id)
            ->SELECT(['skpd.skpd AS skpd'])
            ->first();
        return $nama_skpd->skpd;
    }

    protected function total_pegawai_skpd($skpd_id)
    {

        return     Pegawai::rightjoin('demo_asn.tb_history_jabatan AS a', function ($join) {
            $join->on('a.id_pegawai', '=', 'tb_pegawai.id');
            $join->where('a.status', '=', 'active');
        })
            ->WHERE('a.id_skpd', '=', $skpd_id)
            ->WHERE('tb_pegawai.nip', '!=', 'admin')
            ->WHERE('tb_pegawai.status', 'active')
            ->count();
    }

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

        $data       = Periode::SELECT('label', 'awal')->OrderBy('id', 'DESC')->get();

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

        $id_skpd = $request->skpd_id;

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
                return Pustaka::nama_pegawai($x->gelardpn, $x->nama, $x->gelarblk);
            })
            ->addColumn('nip_pegawai', function ($x) {
                return $x->nip;
            })
            ->addColumn('tunjangan', function ($x) {
                return "Rp. " . number_format($x->tunjangan, '0', ',', '.');
            })
            ->addColumn('e', function ($x) {
                return "Rp. " . number_format($x->tunjangan * (60 / 100), '0', ',', '.');
            })
            ->addColumn('f', function ($x) {
                return "";
            })
            ->addColumn('g', function ($x) {
                return "";
            })
            ->addColumn('h', function ($x) {
                return "";
            })
            ->addColumn('i', function ($x) {
                return "";
            })
            ->addColumn('j', function ($x) {
                return "Rp. " . number_format($x->tunjangan * (40 / 100), '0', ',', '.');
            })
            ->addColumn('k', function ($x) {
                return "";
            })
            ->addColumn('l', function ($x) {
                return "";
            })
            ->addColumn('m', function ($x) {
                return "";
            })
            ->addColumn('n', function ($x) {
                return "";
            });
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }
        return $datatables->make(true);
    }

    public function TPPBulananList(Request $request)
    {

        $tpp_report_id = $request->tpp_report_id;

        $dt = TPPReportData::WHERE('tpp_report_data.tpp_report_id', $tpp_report_id)
            ->rightjoin('demo_asn.tb_pegawai AS pegawai', function ($join) {
                $join->on('pegawai.id', '=', 'tpp_report_data.pegawai_id');
            })
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
            ->where('a.status', '=', 'active');



        $datatables = Datatables::of($dt)
            ->addColumn('nama_pegawai', function ($x) {
                return Pustaka::nama_pegawai($x->gelardpn, $x->nama, $x->gelarblk);
            })
            ->addColumn('nip_pegawai', function ($x) {
                return $x->nip;
            })
            ->addColumn('tunjangan', function ($x) {
                return "Rp. " . number_format($x->tunjangan, '0', ',', '.');
            })
            ->addColumn('e', function ($x) {
                return "Rp. " . number_format($x->tunjangan * (60 / 100), '0', ',', '.');
            })
            ->addColumn('f', function ($x) {
                return "";
            })
            ->addColumn('g', function ($x) {
                return "";
            })
            ->addColumn('h', function ($x) {
                return "";
            })
            ->addColumn('i', function ($x) {
                return "";
            })
            ->addColumn('j', function ($x) {
                return "Rp. " . number_format($x->tunjangan * (40 / 100), '0', ',', '.');
            })
            ->addColumn('k', function ($x) {
                return "";
            })
            ->addColumn('l', function ($x) {
                return "";
            })
            ->addColumn('m', function ($x) {
                return "";
            })
            ->addColumn('n', function ($x) {
                return "";
            });
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }
        return $datatables->make(true);
    }


    protected function TPPReportDetail(Request $request)
    {
        $x = TPPReport::WHERE('tpp_report.id', $request->tpp_report_id)
            ->join('db_pare_2018.periode AS periode', function ($join) {
                $join->on('periode.id', '=', 'tpp_report.periode_id');
            })
            ->select([
                'tpp_report.id AS tpp_report_id',
                'tpp_report.periode_id',
                'tpp_report.bulan',
                'tpp_report.skpd_id',
                'tpp_report.ka_skpd',
                'tpp_report.admin_skpd',
                'tpp_report.status',
                'tpp_report.created_at',
                'periode.label AS periode_label',
                'periode.awal AS tahun_periode'


            ])
            ->first();


        $tpp = array(
            'tpp_report_id'     => $x->tpp_report_id,
            'periode'           => Pustaka::bulan($x->bulan) . "  " . Pustaka::tahun($x->tahun_periode),
            'created_at'        => Pustaka::tgl_jam($x->created_at),
            'ka_skpd'           => $x->ka_skpd,
            'admin_skpd'        => $x->admin_skpd,


            'jm_data_pegawai'   => TPPReportData::WHERE('tpp_report_id', $x->tpp_report_id)->count(),
            'jm_data_capaian'   => TPPReportData::WHERE('tpp_report_id', $x->tpp_report_id)->count(),

            'status'            => $x->status,



        );
        return $tpp;
    }

    public function SKPDTTPReportList(Request $request)
    {



        $tpp_report = TPPReport::WHERE('skpd_id', $request->skpd_id)
            ->join('db_pare_2018.periode AS periode', function ($join) {
                $join->on('periode.id', '=', 'tpp_report.periode_id');
            })
            ->select([
                'tpp_report.id AS tpp_report_id',
                'tpp_report.periode_id',
                'tpp_report.bulan',
                'tpp_report.skpd_id',
                'tpp_report.status',
                'tpp_report.created_at',
                'periode.label AS periode_label',
                'periode.awal AS tahun_periode'

            ])
            ->orderBy('tpp_report.id', 'DESC')
            ->get();

        $datatables = Datatables::of($tpp_report)
            ->addColumn('periode', function ($x) {
                return Pustaka::bulan($x->bulan) . "  " . Pustaka::tahun($x->tahun_periode);
            })
            ->addColumn('jumlah_data', function ($x) {
                return TPPReportData::WHERE('tpp_report_id', $x->tpp_report_id)->count();
            });

        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $datatables->make(true);
    }

    public function CreateConfirm(Request $request)
    {

        //data yang harus diterima yaitu SKPD ID
        //periode dan bulan di generate disini

        //periode aktif
        $d_periode = Periode::WHERE('status', '1')->first();
        $periode_id         = $d_periode->id;
        $periode_tahun      = Pustaka::tahun($d_periode->awal);

        //bulan capaian
        $bulan              = date('m');
        $skpd_id            = $request->get('skpd_id');

        //aDMIN skpd
        $admin = Pegawai::WHERE('id', $request->admin_id)->first();

        //KA SKPD
        $ka_skpd = SKPD::WHERE('parent_id', '=', $skpd_id)->first();
        if ($ka_skpd->pejabat != null) {
            $pegawai            = $ka_skpd->pejabat->pegawai;

            $nama_ka_skpd         = Pustaka::nama_pegawai($pegawai->gelardpn, $pegawai->nama, $pegawai->gelarblk);
        } else {
            $nama_ka_skpd = "";
        }


        $data_tpp = TPPReport::WHERE('skpd_id', '=', $skpd_id)
            ->WHERE('periode_id', '=', $periode_id)
            ->WHERE('bulan', '=', $bulan)
            ->count();

        if ($data_tpp == 0) {

            $data = array(
                'status'            =>  '0',
                'periode_id'        =>  $periode_id,
                'bulan'             =>  $bulan,
                'periode_label'     =>  Pustaka::bulan($bulan) . " " . Pustaka::tahun($d_periode->awal),
                'skpd_id'           =>  $skpd_id,
                'nama_skpd'         =>  Pustaka::capital_string($this->nama_skpd($skpd_id)),
                'jumlah_pegawai'    =>  $this->total_pegawai_skpd($skpd_id),
                'ka_skpd'           =>  $nama_ka_skpd,
                'admin_skpd'        =>  Pustaka::nama_pegawai($admin->gelardpn, $admin->nama, $admin->gelarblk),

            );
            return $data;
        } else {
            $data = array('status'    =>  '1');
            return $data;
        }
    }

    public function Store(Request $request)
    {

        $messages = [
            'skpd_id.required'                  => 'Harus diisi',
            'periode_id.required'               => 'Harus diisi',
            'bulan.required'                    => 'Harus diisi',
            'formula_perhitungan_id.required'   => 'Harus diisi',

        ];

        $validator = Validator::make(
            Input::all(),
            array(
                'skpd_id'               => 'required',
                'periode_id'            => 'required|numeric',
                'bulan'                 => 'required|numeric',
                'formula_perhitungan_id' => 'required|numeric',
            ),
            $messages
        );

        if ($validator->fails()) {
            //$messages = $validator->messages();
            return response()->json(['errors' => $validator->messages()], 422);
        }


        $st_kt    = new TPPReport;

        $st_kt->periode_id          = Input::get('periode_id');
        $st_kt->bulan               = Input::get('bulan');
        $st_kt->formula_perhitungan_id = Input::get('formula_perhitungan_id');
        $st_kt->skpd_id             = Input::get('skpd_id');
        $st_kt->ka_skpd             = Input::get('ka_skpd');
        $st_kt->admin_skpd          = Input::get('admin_skpd');

        if ($st_kt->save()) {

            //jika berhasil
            $tpp_report_id = $st_kt->id;


        //insert data pegawai to  tpp-report_data
        $pegawai = Pegawai::rightjoin('demo_asn.tb_history_jabatan AS a', function ($join) {
            $join->on('a.id_pegawai', '=', 'tb_pegawai.id');
            $join->where('a.status', '=', 'active');
        })
        ->leftjoin('demo_asn.m_unit_kerja AS unit_kerja', function ($join) {
            $join->on('unit_kerja.id', '=', 'a.id_unit_kerja');
        })
            ->leftjoin('demo_asn.m_skpd AS skpd', function ($join) {
                $join->on('skpd.id', '=', 'a.id_jabatan');
            })
            ->leftjoin('db_pare_2018.skp_bulanan AS skp', function ($join) {
                $join->on('skp.pegawai_id', '=', 'tb_pegawai.id');
                $join->where('skp.bulan', '=', Pustaka::bulan_lalu(Input::get('bulan'))  );
            })
            ->leftjoin('db_pare_2018.capaian_bulanan AS capaian', function ($join) {
                $join->on('capaian.skp_bulanan_id', '=', 'skp.id');
                $join->where('capaian.status_approve', '=', 1   );
            })



            ->SELECT(
                'tb_pegawai.id AS pegawai_id',
                'tb_pegawai.nama AS nama',
                'tb_pegawai.gelardpn AS gelardpn',
                'tb_pegawai.gelarblk AS gelarblk',
                'skp.id AS skp_bulanan_id',
                'skp.bulan AS skp_bulanan_bulan',
                'capaian.id AS capaian_id',
                'a.id AS skpd_id',
                'unit_kerja.unit_kerja AS unit_kerja',
                'skpd.id AS jabatan_id',
                'skpd.tunjangan AS tpp_rupiah',
                'skpd.id_eselon AS eselon_id'


            )



            ->WHERE('a.id_skpd', '=', Input::get('skpd_id'))
            ->WHERE('tb_pegawai.nip', '!=', 'admin')
            ->WHERE('tb_pegawai.status', 'active')
            ->get();


            foreach ($pegawai as $x) {
                $report_data    = new TPPReportData;

                $report_data->nama_pegawai          = Pustaka::nama_pegawai($x->gelardpn , $x->nama , $x->gelarblk);
                $report_data->tpp_report_id         = $tpp_report_id;
                $report_data->pegawai_id            = $x->pegawai_id;
                $report_data->capaian_bulanan_id    = $x->capaian_bulanan_id;
                $report_data->skpd_id               = $x->skpd_id;
                $report_data->unit_kerja            = $x->unit_kerja;
                $report_data->eselon_id             = $x->eselon_id;
                $report_data->tpp_rupiah            = $x->tpp_rupiah;


                $report_data->save();
            }






            return \Response::make('sukses', 200);
        } else {
            return \Response::make('error', 500);
        }
    }

    public function Destroy(Request $request)
    {

        $messages = [
            'tpp_report_id.required'   => 'Harus diisi',
        ];

        $validator = Validator::make(
            Input::all(),
            array(
                'tpp_report_id'   => 'required',
            ),
            $messages
        );

        if ($validator->fails()) {
            //$messages = $validator->messages();
            return response()->json(['errors' => $validator->messages()], 422);
        }


        $del    = TPPReport::find(Input::get('tpp_report_id'));
        if (is_null($del)) {
            return $this->sendError('TPP Report tidak ditemukan.');
        }


        if ($del->delete()) {
            return \Response::make('sukses', 200);
        } else {
            return \Response::make('error', 500);
        }
    }
}
