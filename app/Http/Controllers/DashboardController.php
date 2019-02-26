<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Pegawai;
use App\Models\HistoryJabatan;
use App\Models\Skpd;
use App\Helpers\Foto;
use App\Helpers\Pustaka;



class DashboardController extends Controller
{

//NEW AUTH

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $user           = \Auth::user();
        $userRole       = $user->hasRole('personal');
        $admin_skpdRole = $user->hasRole('admin_skpd');
        $adminRole      = $user->hasRole('administrator');

        if($userRole)
        {
            $access = 'Personal';
			$dashboard = 'personal';
        } elseif ($admin_skpdRole) {
            $access = 'Admin SKPD';
            //$dashboard = 'admin-skpd';
            $dashboard = 'personal';
        } elseif ($adminRole) {
            $access = 'Administrator';
            //$dashboard = 'administrator';
            $dashboard = 'personal';
        }




        $profil = Pegawai::WHERE('tb_pegawai.id',  $user->id_pegawai) 
                            ->leftjoin('demo_asn.tb_history_jabatan AS a', function($join){
                                        $join   ->on('a.id_pegawai','=','tb_pegawai.id');
                                        $join   ->where('a.status','=', 'active');
                            })

                            //unit_kerja
                            ->leftjoin('demo_asn.m_skpd AS s_skpd', 's_skpd.id','=','a.id_unit_kerja')
                            ->leftjoin('demo_asn.m_unit_kerja AS b', 's_skpd.parent_id','=','b.id')
                    
                            //skpd
                            ->leftjoin('demo_asn.m_skpd AS c', 'a.id_skpd','=','c.id')


                            //eselon
                            ->leftjoin('demo_asn.m_eselon AS d', 'a.id_eselon','=','d.id')
    
                            //jenis_jabatan
                            ->leftjoin('demo_asn.m_jenis_jabatan AS e ', function($join){
                                $join   ->on('d.id_jenis_jabatan','=','e.id');
                            })

                            //golongan
                            ->leftjoin('demo_asn.m_golongan AS f', 'a.id_golongan','=','f.id')
                    
                            ->leftjoin('demo_asn.foto AS y ', function($join){
                                $join   ->on('a.nip','=','y.nipbaru');
                            }) 
                           
                            ->SELECT(   'tb_pegawai.*',
                                        'a.*',
                                        'b.unit_kerja AS unit_kerja',
                                        'c.skpd AS skpd',
                                        'd.eselon AS eselon',
                                        'e.jenis_jabatan AS jenis_jabatan',
                                        'f.golongan AS golongan',
                                        'y.isi AS foto'
                                       
                                       
                                     
                                     
                                     
                                     )
                            ->first();

        $nama           = Pustaka::nama_pegawai($profil->gelardpn , $profil->nama , $profil->gelarblk);
        $nip            = $profil->nip;
        
        $skpd           = Pustaka::capital_string($profil->skpd);
        $unit_kerja     = Pustaka::capital_string($profil->unit_kerja);

        $jabatan        = Pustaka::capital_string($profil->jabatan);
        $jenis_jabatan  = $profil->jenis_jabatan;
        $eselon         = $profil->eselon;
        $jenis_jabatan  = $profil->jenis_jabatan;
        $golongan       = $profil->golongan;
        $tmt_jabatan    = $profil->tmt_jabatan;
        $no_hp          = $profil->no_hp;
        $email          = $profil->email;
        $alamat         = $profil->alamat;

        

        if ( $profil->foto != null  ){
            

            $foto   = 'data:image/jpeg;base64,'.base64_encode( $profil->foto );

        }else{
            if ( $profil->jenis_kelamin == 'Perempuan'){
                $foto   = asset('assets/images/form/female_icon.png');
            }else{
                $foto   = asset('assets/images/form/male_icon.png');
            }
            

        }


        $d_info 	        =  $dt = \DB::table('db_pare_2018.dashboard_info AS info')
                            ->WHERE('status','1')
                            ->first();

        if ($d_info){
            $info    = $d_info->text_info;
            $author  = $d_info->author;
            $waktu   = Pustaka::balik($d_info->created_at);
        }else{
            $info    = "";
            $author  = "";
            $waktu   = "";
        }


        if(isset($dashboard))
        {
            return view('admin.pages.home-'.$dashboard ,[
               
                        'nama'                  => $nama,
                        'nip'                   => $nip,
                        'skpd'                  => $skpd,
                        'unit_kerja'            => $unit_kerja,

                        'jabatan'               => $jabatan,
                        'eselon'                => $eselon,
                        'jenis_jabatan'         => $jenis_jabatan,
                        'golongan'              => $golongan,
                        'tmt_jabatan'           => $tmt_jabatan,
                        'no_hp'                 => $no_hp,
                        'email'                 => $email,
                        'alamat'                => $alamat,

                        'user' 			        => $user,
                        'access' 	            => $access,
                        'foto'                  => $foto,  


                        'info'                  => $info,
                        'author'                => $author,
                        'waktu'                 => $waktu,
            ])->withUser($user)->withAccess($access);
        }else{
            \Auth::logout();
            return redirect('auth/login')->with('status', 'Roles is Unidentified');
        }
       
      
        
        
    }

    public function getHome()
    {
        $user           = \Auth::user();
        $userRole       = $user->hasRole('pegawai');
        $admin_skpdRole = $user->hasRole('admin_skpd');
        $adminRole      = $user->hasRole('administrator');

        if($userRole)
        {
            $access = 'Pegawai';
			$dashboard = 'pegawai';
        } elseif ($admin_skpdRole) {
            $access = 'admin-skpd';
			$dashboard = 'skpd';
        } elseif ($adminRole) {
            $access = 'Administrator';
			$dashboard = 'administrator';
        }

        return view('admin.pages.home-'.$dashboard);
    }

//OLD LTE

    /**
    * Show the User DASHBOARD Page
    *
    * @return View
    */
    public function showUserDashboard()
    {
        return view('admin.layouts.dashboard');
    }

    /**
    * Show the User PROFILE Page
    *
    * @return View
    */
    public function showUserProfile()
    {
        return view('admin.layouts.user-profile');
    }

    public function show($id)
    {
        //
    }

}
