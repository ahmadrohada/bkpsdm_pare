<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\UsersRole;
use App\Models\Pegawai;
use App\Models\Skpd;

use App\Helpers\Pustaka;

use Input;
class PegawaiController extends Controller {
    
    //=======================================================================================//
     protected function golongan_aktif($pegawai_id){
        //GOLONGAN 
        $gol       = \DB::table('demo_asn.tb_history_golongan')
                            ->leftjoin('demo_asn.m_golongan AS golongan', function($join){
                                $join   ->on('tb_history_golongan.id_golongan','=','golongan.id');
                            })
                            ->WHERE('tb_history_golongan.id_pegawai',$pegawai_id)
                            ->WHERE('tb_history_golongan.status','=','active')
                            ->SELECT(['golongan.golongan'])
                            ->first();
        if ($gol != null ){
            return $gol->golongan;
        }else{
            return "";
        }
                            
        
    }

    //=======================================================================================//
      protected function tmt_golongan_aktif($pegawai_id){
        //GOLONGAN 
        $gol       = \DB::table('demo_asn.tb_history_golongan')
                           
                            ->WHERE('tb_history_golongan.id_pegawai',$pegawai_id)
                            ->WHERE('tb_history_golongan.status','=','active')
                            ->SELECT(['tb_history_golongan.tmt_golongan'])
                            ->first();
        
        if ($gol != null ){
            return $gol->tmt_golongan;
        }else{
            return "";
        }
        
    }

    //=======================================================================================//
    protected function nama_skpd($skpd_id){
            //nama SKPD 
            $nama_skpd       = \DB::table('demo_asn.m_skpd AS skpd')
                            ->WHERE('id',$skpd_id)
                            ->SELECT(['skpd.skpd AS skpd'])
                            ->first();
            return $nama_skpd->skpd;
    }

    protected function total_pegawai(){
        
        return 	Pegawai::WHERE('status','active')->WHERE('nip','!=','admin')->count();
    } 
    
    protected function total_users(){
        return 	\DB::table('db_pare_2018.users AS users')
                                ->leftjoin('demo_asn.tb_pegawai AS pegawai', function($join){
                                    $join   ->on('users.id_pegawai','=','pegawai.id');
                                    $join   ->where('pegawai.status','=', 'active');
                                })
                                ->leftjoin('demo_asn.tb_history_jabatan AS a', function($join){
                                    $join   ->on('a.id_pegawai','=','pegawai.id');
                                    $join   ->where('a.status','=', 'active');
                                })->count();
    }
    

    protected function total_pegawai_skpd( $skpd_id){
        
        return 	Pegawai::rightjoin('demo_asn.tb_history_jabatan AS a', function($join){
                                            $join   ->on('a.id_pegawai','=','tb_pegawai.id');
                                            $join   ->where('a.status','=', 'active');
                                    })
                                    ->WHERE('a.id_skpd','=', $skpd_id)
                                    ->WHERE('tb_pegawai.nip','!=','admin')
                                    ->WHERE('tb_pegawai.status','active')
                                    ->count();
    }
    

    protected function total_unit_kerja( $skpd_id){
        
        return 	SKPD::WHERE('m_skpd.parent_id','=', $skpd_id)
                                    ->rightjoin('demo_asn.m_skpd AS a', function($join){
                                        $join   ->on('a.parent_id','=','m_skpd.id');
                                    })
                                    ->count();
    }


   
    

    protected function total_skpd()
	{
       return SKPD::whereRaw('id = id_skpd AND id != 1 AND id != 6 AND id != 8 AND id != 10 AND id != 12 ')
                ->count();  
       
               
	}

    //=======================================================================================//

    
    //========================== FUNGSI UNTUK ADD PEGAWAI KE PARE   =========================//
    public function addPegawai($pegawai_id)
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
            $access = 'Admin SKPD';
            //$dashboard = 'admin-skpd';
            $dashboard = 'pegawai';
        } elseif ($adminRole) {
            $access = 'Administrator';
            //$dashboard = 'administrator';
            $dashboard = 'pegawai';
        }


        $dt = Pegawai::WHERE('tb_pegawai.id',$pegawai_id)
                            ->rightjoin('demo_asn.tb_history_jabatan AS a', function($join){
                                            $join   ->on('a.id_pegawai','=','tb_pegawai.id');
                                                
                                        })
                            //eselon
                            ->leftjoin('demo_asn.m_eselon AS eselon', 'a.id_eselon','=','eselon.id')
            
                            //jenis jabatan
                            ->leftjoin('demo_asn.m_jenis_jabatan AS jenis_jabatan ', 'eselon.id_jenis_jabatan','=','jenis_jabatan.id' )

                           
                            //jabatan
                            ->leftjoin('demo_asn.m_skpd AS jabatan', 'a.id_jabatan','=','jabatan.id')
                            
                            

                            //skpd
                            ->leftjoin('demo_asn.m_skpd AS skpd', 'a.id_skpd','=','skpd.id')
            
                            //foto
                            ->leftjoin('demo_asn.foto AS foto ','a.nip','=','foto.nipbaru')

                            //user_id
                            ->leftjoin('db_pare_2018.users AS users ','a.id_pegawai','=','users.id_pegawai')
                            
                             ->select([ 'tb_pegawai.nama AS nama',
                                        'tb_pegawai.id AS pegawai_id',
                                        'tb_pegawai.nip AS nip',
                                        'tb_pegawai.gelardpn AS gelardpn',
                                        'tb_pegawai.gelarblk AS gelarblk',
                                        'eselon.eselon AS eselon',
                                        'jenis_jabatan.jenis_jabatan AS jenis_jabatan',
                                        'jabatan.skpd AS jabatan',
                                        'a.unit_kerja AS unit_kerja',
                                        'skpd.skpd AS skpd',
                                        'a.tmt_jabatan AS tmt_jabatan',
                                        'tb_pegawai.no_hp',
                                        'tb_pegawai.alamat',
                                        'tb_pegawai.email',
                                        'foto.isi AS foto',
                                        'users.id AS user_id'
                                            
                                    ])
                            //->where('a.id_skpd','=', $id_skpd)
                            ->where('a.status', '=', 'active')
                            ->first();

        //DETAIL PEGAWAI
        
        $nama           = Pustaka::nama_pegawai($dt->gelardpn , $dt->nama , $dt->gelarblk);
        $nip            = $dt->nip;

        $skpd           = Pustaka::capital_string($dt->skpd);
        $unit_kerja     = Pustaka::capital_string($dt->unit_kerja);

        $jabatan        = Pustaka::capital_string($dt->jabatan);
        $jenis_jabatan  = $dt->jenis_jabatan;
        $eselon         = $dt->eselon;
        $jenis_jabatan  = $dt->jenis_jabatan;
        $tmt_jabatan    = $dt->tmt_jabatan;
        $golongan       = $this->golongan_aktif($pegawai_id);
        $tmt_golongan   = $this->tmt_golongan_aktif($pegawai_id);
        $no_hp          = $dt->no_hp;
        $email          = $dt->email;
        $alamat         = $dt->alamat;


       
        if ( $dt->foto != null  ){
            

            $foto   = 'data:image/jpeg;base64,'.base64_encode( $dt->foto );

        }else{
            $foto   = asset('assets/images/form/sample.jpg');
        }

       
        if ( $dt->user_id === null  ){
            return view('pare_pns.pages.administrator-add-pegawai', [
                'pegawai_id'            => $pegawai_id,
                'nama'                  => $nama,
                'nip'                   => $nip,
                'skpd'                  => $skpd,
                'unit_kerja'            => $unit_kerja,

                'jabatan'               => $jabatan,
                'eselon'                => $eselon,
                'jenis_jabatan'         => $jenis_jabatan,
                'golongan'              => $golongan,
                'tmt_golongan'          => $tmt_golongan,
                'tmt_jabatan'           => $tmt_jabatan,
                'no_hp'                 => $no_hp,
                'email'                 => $email,
                'alamat'                => $alamat,

                'user' 			        => $user,
                'access' 	            => $access,
                'foto'                  => $foto,  


        	    ]
            );   
        }else{
            $middleware = request()->segment(1);
            return redirect('/'.$middleware.'/pegawai/'.$pegawai_id)->with('status', 'Pegawai sudah terdaftar');
           
        }


		 

        
    }



    

    public function detailPegawai($pegawai_id)
    {

        $user = User::WHERE('id_pegawai',$pegawai_id)->exists();
        if ( $user ){

       


        $user           = \Auth::user();
        $pegawaix        = Pegawai::WHERE('id',$pegawai_id)->first();
        $userRole       = $user->hasRole('pegawai');
        $admin_skpdRole = $user->hasRole('admin_skpd');
        $adminRole      = $user->hasRole('administrator');

        if($userRole)
        {
            $access = 'Pegawai';
			$dashboard = 'pegawai';
        } elseif ($admin_skpdRole) {
            $access = 'Admin SKPD';
            //$dashboard = 'admin-skpd';
            $dashboard = 'pegawai';
        } elseif ($adminRole) {
            $access = 'Administrator';
            //$dashboard = 'administrator';
            $dashboard = 'pegawai';
        }

        $dt = Pegawai::WHERE('tb_pegawai.id',$pegawai_id)
                            ->rightjoin('demo_asn.tb_history_jabatan AS a', function($join){
                                            $join   ->on('a.id_pegawai','=','tb_pegawai.id');
                                                
                                        })
                           //eselon
                            ->leftjoin('demo_asn.m_eselon AS eselon', 'a.id_eselon','=','eselon.id')
            
                            //jenis jabatan
                            ->leftjoin('demo_asn.m_jenis_jabatan AS jenis_jabatan ', 'eselon.id_jenis_jabatan','=','jenis_jabatan.id' )

                            


                            //jabatan
                            ->leftjoin('demo_asn.m_skpd AS jabatan', 'a.id_jabatan','=','jabatan.id')
                            
                            

                            //skpd
                            ->leftjoin('demo_asn.m_skpd AS skpd', 'a.id_skpd','=','skpd.id')
            
                            //unit_kerja
                            //->leftjoin('demo_asn.m_skpd AS s_skpd', 's_skpd.id','=','a.id_unit_kerja')
                            //->leftjoin('demo_asn.m_unit_kerja AS unit_kerja', 's_skpd.parent_id','=','unit_kerja.id')

                            //foto
                            ->leftjoin('demo_asn.foto AS foto ','a.nip','=','foto.nipbaru')

                            //User
                            ->leftjoin('db_pare_2018.users AS user', 'tb_pegawai.id', '=' ,'user.id_pegawai')
                            
                             ->select([ 'tb_pegawai.nama AS nama',
                                        'tb_pegawai.id AS pegawai_id',
                                        'tb_pegawai.nip AS nip',
                                        'tb_pegawai.gelardpn AS gelardpn',
                                        'tb_pegawai.gelarblk AS gelarblk',
                                        'eselon.eselon AS eselon',
                                        'jenis_jabatan.jenis_jabatan AS jenis_jabatan',
                                        'jabatan.skpd AS jabatan',
                                        'a.unit_kerja AS unit_kerja',
                                        'skpd.skpd AS skpd',
                                        'a.tmt_jabatan AS tmt_jabatan',
                                        'tb_pegawai.no_hp',
                                        'tb_pegawai.alamat',
                                        'tb_pegawai.email',
                                        'foto.isi AS foto',
                                        'user.username AS username',
                                        'user.id AS user_id'
                                            
                                    ])
                            //->where('a.id_skpd','=', $id_skpd)
                            ->where('a.status', '=', 'active')
                            ->first();

        //DETAIL PEGAWAI
        
        $nama           = Pustaka::nama_pegawai($dt->gelardpn , $dt->nama , $dt->gelarblk);
        $nip            = $dt->nip;
        
        $username       = $dt->username;
        $user_id        = $dt->user_id;

        $skpd           = Pustaka::capital_string($dt->skpd);
        $unit_kerja     = Pustaka::capital_string($dt->unit_kerja);

        $jabatan        = Pustaka::capital_string($dt->jabatan);
        $jenis_jabatan  = $dt->jenis_jabatan;
        $eselon         = $dt->eselon;
        $jenis_jabatan  = $dt->jenis_jabatan;
        $golongan       = $this->golongan_aktif($pegawai_id);
        $tmt_golongan   = $this->tmt_golongan_aktif($pegawai_id);
        $tmt_jabatan    = $dt->tmt_jabatan;
        $no_hp          = $dt->no_hp;
        $email          = $dt->email;
        $alamat         = $dt->alamat;


       
        if ( $dt->foto != null  ){
            $foto   = 'data:image/jpeg;base64,'.base64_encode( $dt->foto );
        }else{
            $foto   = asset('assets/images/form/sample.jpg');
        }

        
        
		return view('pare_pns.pages.administrator-detail-pegawai', [
                'pegawai_id'            => $pegawai_id,
                'user_id'               => $user_id,
                'nama'                  => $nama,
                'nip'                   => $nip,

                'username'              => $username,


                'skpd'                  => $skpd,
                'unit_kerja'            => $unit_kerja,

                'jabatan'               => $jabatan,
                'eselon'                => $eselon,
                'jenis_jabatan'         => $jenis_jabatan,
                'golongan'              => $golongan,
                'tmt_golongan'          => $tmt_golongan,
                'tmt_jabatan'           => $tmt_jabatan,
                'no_hp'                 => $no_hp,
                'email'                 => $email,
                'alamat'                => $alamat,

                'user' 			        => $user,
                'access' 	            => $access,
                'foto'                  => $foto,  


        	]
        );  

    }else{
        $middleware = request()->segment(1);
        return redirect('/'.$middleware.'/pegawai/'.$pegawai_id.'/add')->with('status', 'Pegawai blm terdaftar');
    }
    
    }

    
}
