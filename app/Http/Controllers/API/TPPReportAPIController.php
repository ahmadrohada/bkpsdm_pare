<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\TPPReport;
use App\Models\TPPReportData;
use App\Models\Periode;
use App\Models\Pegawai;
use App\Models\SKPD;

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
    protected function TPPReportDetail(Request $request)
    {
        $x = TPPReport::WHERE('tpp_report.id', $request->tpp_report_id)
            ->join('db_pare_2018.periode AS periode', function ($join) {
                $join->on('periode.id', '=', 'tpp_report.periode_id');
            })
            ->join('demo_asn.tb_pegawai AS ka_skpd', function ($join) {
                $join->on('ka_skpd.id', '=', 'tpp_report.ka_skpd_id');
            })
            ->join('demo_asn.tb_pegawai AS admin_skpd', function ($join) {
                $join->on('admin_skpd.id', '=', 'tpp_report.admin_skpd_id');
            })
            ->select([
                'tpp_report.id AS tpp_report_id',
                'tpp_report.periode_id',
                'tpp_report.bulan',
                'tpp_report.skpd_id',
                'tpp_report.ka_skpd_id',
                'tpp_report.admin_skpd_id',
                'tpp_report.status',
                'tpp_report.created_at',
                'periode.label AS periode_label',
                'periode.awal AS tahun_periode',
                'admin_skpd.nama AS nama_admin_skpd',
                'admin_skpd.gelardpn AS gelardpn_admin_skpd',
                'admin_skpd.gelarblk AS gelarblk_admin_skpd',
                'ka_skpd.nama AS nama_ka_skpd',
                'ka_skpd.gelardpn AS gelardpn_ka_skpd',
                'ka_skpd.gelarblk AS gelarblk_ka_skpd'

            ])
            ->first();


        $tpp = array(
            'tpp_report_id'     => $x->tpp_report_id,
            'periode'           => Pustaka::bulan($x->bulan) . "  " . Pustaka::tahun($x->tahun_periode),
            'created_at'        => Pustaka::tgl_jam($x->created_at),
            'ka_skpd'           => "",
            'admin_skpd'        => Pustaka::nama_pegawai($x->gelardpn_admin_skpd, $x->nama_admin_skpd, $x->gelarblk_admin_skpd),
            'ka_skpd'           => Pustaka::nama_pegawai($x->gelardpn_ka_skpd, $x->nama_ka_skpd, $x->gelarblk_ka_skpd),

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
            /*  ->orderBy('rencana_aksi.waktu_pelaksanaan', 'ASC')
            ->orderBy('rencana_aksi.id', 'DESC') */
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


        /* 
        $skp_bulanan   = SKPBulanan::WHERE('skp_bulanan.id',$request->get('skp_bulanan_id'))
                        
                        ->SELECT('skp_bulanan.id AS skp_bulanan_id',
                                 'skp_bulanan.tgl_mulai',
                                 'skp_bulanan.tgl_selesai',
                                 'skp_bulanan.skp_tahunan_id',
                                 'skp_bulanan.bulan',
                                 'skp_bulanan.u_jabatan_id',
                                 'skp_bulanan.p_jabatan_id',
                                 'skp_bulanan.pegawai_id'

                                 
                                )
                        ->first();

        $jenis_jabatan = $skp_bulanan->PejabatYangDinilai->Eselon->id_jenis_jabatan;

       
        //DETAIL data pribadi dan atasan
        $u_detail = HistoryJabatan::WHERE('id',$skp_bulanan->u_jabatan_id)->first();
        $p_detail = HistoryJabatan::WHERE('id',$skp_bulanan->p_jabatan_id)->first();

        if ( $skp_bulanan->p_jabatan_id >= 1 ){
            $data = array(
                'status'			    =>  'pass',
                'renja_id'              =>  $renja_id,
                'list_bawahan'          =>  $list_bawahan,
                'jabatan_id'            => $skp_bulanan->PejabatYangDinilai->id_jabatan,
                'pegawai_id'            =>  $skp_bulanan->pegawai_id,
                'skp_bulanan_id'        =>  $skp_bulanan->skp_bulanan_id,
                'periode_label'			=>  Pustaka::bulan($skp_bulanan->bulan),
                'tgl_mulai'			    =>  Pustaka::tgl_form($skp_bulanan->tgl_mulai),
                'tgl_selesai'			=>  Pustaka::tgl_form($skp_bulanan->tgl_selesai),
                'jm_kegiatan_bulanan'	=>  $jm_kegiatan,

                'renja_id'	            =>  $skp_bulanan->SKPTahunan->Renja->id,
                'waktu_pelaksanaan'	    =>  $skp_bulanan->bulan,

               
                'u_jabatan_id'	        => $u_detail->id,
                'u_nip'	                => $u_detail->nip,
                'u_nama'                => Pustaka::nama_pegawai($u_detail->Pegawai->gelardpn , $u_detail->Pegawai->nama , $u_detail->Pegawai->gelarblk),
                'u_pangkat'	            => $u_detail->Golongan ? $u_detail->Golongan->pangkat : '',
                'u_golongan'	        => $u_detail->Golongan ? $u_detail->Golongan->golongan : '',
                'u_eselon'	            => $u_detail->Eselon ? $u_detail->Eselon->eselon : '',
                'u_jabatan'	            => Pustaka::capital_string($u_detail->Jabatan ? $u_detail->Jabatan->skpd : ''),
                'u_unit_kerja'	        => Pustaka::capital_string($u_detail->UnitKerja ? $u_detail->UnitKerja->unit_kerja : ''),
                'u_skpd'	            => Pustaka::capital_string($u_detail->Skpd ? $u_detail->Skpd->skpd : ''),
                'u_jenis_jabatan'	    => $u_detail->Eselon->Jenis_jabatan->id,

                'p_jabatan_id'	        => $p_detail->id,
                'p_nip'	                => $p_detail->nip,
                'p_nama'                => Pustaka::nama_pegawai($p_detail->Pegawai->gelardpn , $p_detail->Pegawai->nama , $p_detail->Pegawai->gelarblk),
                'p_pangkat'	            => $p_detail->Golongan ? $p_detail->Golongan->pangkat : '',
                'p_golongan'	        => $p_detail->Golongan ? $p_detail->Golongan->golongan : '',
                'p_eselon'	            => $p_detail->Eselon ? $p_detail->Eselon->eselon : '',
                'p_jabatan'	            => Pustaka::capital_string($p_detail->Jabatan ? $p_detail->Jabatan->skpd : ''),
                'p_unit_kerja'	        => Pustaka::capital_string($p_detail->UnitKerja ? $p_detail->UnitKerja->unit_kerja : ''),
                'p_skpd'	            => Pustaka::capital_string($p_detail->Skpd ? $p_detail->Skpd->skpd : ''),
                
                );
       
        }

        return $data;


 */
    }

    public function Store(Request $request)
    {

        $messages = [
            'skpd_id.required'           => 'Harus diisi',
            'periode_tahun.required'     => 'Harus diisi',
            'periode_bulan.required'     => 'Harus diisi',

        ];

        $validator = Validator::make(
            Input::all(),
            array(
                'skpd_id'           => 'required',
                'periode_tahun'     => 'required|numeric',
                'periode_bulan'     => 'required|numeric',
            ),
            $messages
        );

        if ($validator->fails()) {
            //$messages = $validator->messages();
            return response()->json(['errors' => $validator->messages()], 422);
        }


        $st_kt    = new TPPReport;

        $st_kt->skpd_id             = Input::get('kegiatan_id');
        $st_kt->periode_tahun       = Input::get('periode_tahun');
        $st_kt->periode_bulan       = Input::get('periode_bulan');

        if ($st_kt->save()) {
            return \Response::make('sukses', 200);
        } else {
            return \Response::make('error', 500);
        }
    }
}
