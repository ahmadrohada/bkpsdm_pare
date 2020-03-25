<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Logic\User\UserRepository;
use App\Logic\User\CaptureIp;
use App\Http\Requests;

use App\Models\TPPReport;
use App\Models\TPPReportData;

use App\Helpers\Pustaka;

use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades;
use Illuminate\Http\Request;

use PDF;
use Datatables;
use Validator;
use Gravatar;
use Input;
use Alert;

class TPPReportController extends Controller
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

    public function AdministratorCetakTPPReport(Request $request)
    {

        $user                   = \Auth::user();
        $users                  = \DB::table('users')->get();
        $userRole               = $user->hasRole('personal');
        $admin_skpdRole         = $user->hasRole('admin_skpd');
        $adminRole              = $user->hasRole('administrator');

        if ($userRole) {
            $access = 'User';
        } elseif ($admin_skpdRole) {
            $access = 'Admin Skpd';
        } elseif ($adminRole) {
            $access = 'Administrator';
        }

        

        return view(
            'admin.pages.administrator-TPP_report_cetak',
            [
                'users'                   => $users,
                'user'                    => $user,
                'access'                  => $access,
                'h_box'                   => 'box-warning',
            ]
        );

        
    }


    

    public function showSKPDTPPReport(Request $request)
    {
        $user      = \Auth::user();
        $pegawai   = $user->pegawai;


        return view(
            'admin.pages.skpd-tpp_report',
            [
                'skpd'                     => $pegawai->JabatanAktif->SKPD,
                'pegawai_id'               => $pegawai->id,
                'nama_pegawai'             => Pustaka::nama_pegawai($pegawai->gelardpn, $pegawai->nama, $pegawai->gelarblk),
                'h_box'                  => 'box-danger',

            ]
        ); 
    }
     

    public function editSKPDTPPReport(Request $request)
    {
        $user      = \Auth::user();
        $pegawai   = $user->pegawai;
        $tpp_report = TPPreport::where('id', $request->tpp_report_id)->first();

        return view(
            'admin.pages.skpd-tpp_report_edit',
            [
                'skpd'                => $pegawai->JabatanAktif->SKPD,
                'tpp_report'          => $tpp_report,
                'kinerja'             => $tpp_report->FormulaHitung->kinerja,
                'kehadiran'           => $tpp_report->FormulaHitung->kehadiran,
                'nama_pegawai'        => Pustaka::nama_pegawai($pegawai->gelardpn, $pegawai->nama, $pegawai->gelarblk),
                'h_box'               => 'box-danger',

            ]
        );
    }

    public function SKPDTPPReport(Request $request)
    {
        $user      = \Auth::user();
        $pegawai   = $user->pegawai;
        $tpp_report = TPPreport::where('id', $request->tpp_report_id)->first();

        return view(
            'admin.pages.skpd-tpp_report_detail',
            [
                'skpd'                => $pegawai->JabatanAktif->SKPD,
                'tpp_report'          => $tpp_report,
                'kinerja'             => $tpp_report->FormulaHitung->kinerja,
                'kehadiran'           => $tpp_report->FormulaHitung->kehadiran,
                'nama_pegawai'        => Pustaka::nama_pegawai($pegawai->gelardpn, $pegawai->nama, $pegawai->gelarblk),
                'h_box'               => 'box-danger',

            ]
        );
    }


    public function AdministratorTPPReport(Request $request)
    {
        $user      = \Auth::user();
        $pegawai   = $user->pegawai;
        $tpp_report = TPPreport::where('id', $request->tpp_report_id)->first();

        return view(
            'admin.pages.administrator-tpp_report_detail',
            [
                'tpp_report'          => $tpp_report,
                'kinerja'             => $tpp_report->FormulaHitung->kinerja,
                'kehadiran'           => $tpp_report->FormulaHitung->kehadiran,
                'nama_pegawai'        => Pustaka::nama_pegawai($pegawai->gelardpn, $pegawai->nama, $pegawai->gelarblk),
                'h_box'               => 'box-danger',

            ]
        );
    }
}
