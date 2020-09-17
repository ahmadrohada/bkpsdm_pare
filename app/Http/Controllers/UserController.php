<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Logic\User\UserRepository;
use App\Logic\User\CaptureIp;
use App\Http\Requests;
use App\Models\Social;
use App\Models\User;
use App\Models\Role;
use App\Models\UsersRole;
use App\Models\Pegawai;
use App\Models\HistoryJabatan;
use App\Models\Skpd;
use App\Helpers\Foto;
use App\Helpers\Pustaka;

use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades;
use Illuminate\Http\Request;


use Datatables;
use Validator;
use Gravatar;
use Input;



class UserController extends Controller {

	
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
    return $gol->golongan;
}

//=======================================================================================//
  protected function tmt_golongan_aktif($pegawai_id){
    //GOLONGAN 
    $gol       = \DB::table('demo_asn.tb_history_golongan')
                       
                        ->WHERE('tb_history_golongan.id_pegawai',$pegawai_id)
                        ->WHERE('tb_history_golongan.status','=','active')
                        ->SELECT(['tb_history_golongan.tmt_golongan'])
                        ->first();
    return $gol->tmt_golongan;
}

    
	
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


    protected function total_users(){
        return 	\DB::table('db_pare_2018_demo.users AS users')
                                ->leftjoin('demo_asn.tb_pegawai AS pegawai', function($join){
                                    $join   ->on('users.id_pegawai','=','pegawai.id');
                                    $join   ->where('pegawai.status','=', 'active');
                                })
                                ->leftjoin('demo_asn.tb_history_jabatan AS a', function($join){
                                    $join   ->on('a.id_pegawai','=','pegawai.id');
                                    $join   ->where('a.status','=', 'active');
                                })->count();
    }
    

    protected function total_skpd()
	{
       return SKPD::whereRaw('id = id_skpd AND id != 1 AND id != 6 AND id != 8 AND id != 10 AND id != 12 ')
                ->count();  
       
               
	}



    


    
    
    

    

    public function detailUser($user_id)
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



        //Data profil pegawai
        
        $profil = User::WHERE('users.id',$user_id) 
                            ->leftjoin('demo_asn.tb_pegawai AS pegawai', function($join){
                                        $join   ->on('users.id_pegawai','=','pegawai.id');
                            })
                            ->leftjoin('demo_asn.tb_history_jabatan AS a', function($join){
                                        $join   ->on('a.id_pegawai','=','pegawai.id');
                                        $join   ->where('a.status','=', 'active');
                            })
                    
                            ->leftjoin('demo_asn.m_unit_kerja AS c ', function($join){
                                $join   ->on('a.id_skpd','=','c.id');
                            })
                            ->leftjoin('demo_asn.m_eselon AS d ', function($join){
                                $join   ->on('a.id_eselon','=','d.id');
                            })
                            ->leftjoin('demo_asn.m_jenis_jabatan AS e ', function($join){
                                $join   ->on('d.id_jenis_jabatan','=','e.id');
                            })
                          
                            ->leftjoin('demo_asn.foto AS y ', function($join){
                                $join   ->on('a.nip','=','y.nipbaru');
                            }) 
                            ->SELECT(   'pegawai.*',
                                        'a.*',
                                        'a.unit_kerja AS unit_kerja',
                                        'c.unit_kerja AS skpd',
                                        'd.eselon AS eselon',
                                        'e.jenis_jabatan AS jenis_jabatan',
                                        'y.isi AS foto',
                                        'users.username AS username',
                                        'users.id AS user_id'
                                       
                                     
                                     
                                     
                                     )
                            ->first();

        //DETAIL PEGAWAI
        
        $nama           = Pustaka::nama_pegawai($profil->gelardpn , $profil->nama , $profil->gelarblk);
        $nip            = $profil->nip;
        
        $username       = $profil->username;

        $skpd           = Pustaka::capital_string($profil->skpd);
        $unit_kerja     = Pustaka::capital_string($profil->unit_kerja);

        $jabatan        = Pustaka::capital_string($profil->jabatan);
        $jenis_jabatan  = $profil->jenis_jabatan;
        $eselon         = $profil->eselon;
        $jenis_jabatan  = $profil->jenis_jabatan;
        $tmt_jabatan    = $profil->tmt_jabatan;
        $golongan       = $this->golongan_aktif($user->Pegawai->id);
        $tmt_golongan   = $this->tmt_golongan_aktif($user->Pegawai->id);
        $no_hp          = $profil->no_hp;
        $email          = $profil->email;
        $alamat         = $profil->alamat;


       
        if ( $profil->foto != null  ){
            

            $foto   = 'data:image/jpeg;base64,'.base64_encode( $profil->foto );

        }else{
            $foto   = asset('assets/images/form/sample.jpg');
        }

       


		return view('pare_pns.pages.administrator-detail-pegawai', [
                'pegawai_id'            => $profil->id,
                'user_id'               => $profil->user_id,
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

        
    }

   


    /* public function showPegawaiSkpd()
	{
        $user                   = \Auth::user();
        

         //CARI id skpd nya
        $skpd_id    = $user->pegawai->history_jabatan->where('status','active')->first()->id_skpd;
        

		return view('pare_pns.pages.skpd-show-pegawai', [
                //'users' 		          => $users,
                'skpd_id'                 => $skpd_id,
                'nama_skpd'     	      => $this->nama_skpd($skpd_id),
                'total_pegawai' 	      => $this->total_pegawai_skpd($skpd_id),
                'total_unit_kerja' 	      => $this->total_unit_kerja($skpd_id),
                'total_jabatan'           => 'x',
                'total_renja'             => 'x',
                'h_box'                   => 'box-info',
                
        	]
        );   




	} */

	
    /* public function skpd_data_users(Request $request)
    {
            
        

        //CARI id skpd nya

        $id_skpd_admin      = \Auth::user()->pegawai->history_jabatan->where('status','active')->first()->id_skpd;

       
        \DB::statement(\DB::raw('set @rownum=0'));
      
        $dt = \DB::table('db_pare_2018_demo.users AS user')
        ->join('demo_asn.tb_pegawai AS pegawai', 'user.id_pegawai', '=', 'pegawai.id')
        ->join('demo_asn.tb_history_jabatan AS a', 'a.id_pegawai','=','pegawai.id')
        ->where('a.status', '=', 'active')
        ->join('demo_asn.m_skpd AS jabatan', 'jabatan.id','=','a.id_skpd')
        ->join('demo_asn.m_skpd AS unit_kerja', 'a.id_jabatan','=','unit_kerja.id')
        ->join('demo_asn.m_unit_kerja AS skpd', 'unit_kerja.id_skpd','=','skpd.id')
        ->select([   'pegawai.nama',
                    'user.username AS username',
                    'user.id AS user_id',
                    'pegawai.nip',
                    'pegawai.gelardpn',
                    'pegawai.gelarblk',
                    'a.jabatan',
                    'a.id_jabatan',
                    'unit_kerja.id AS unit_kerja_id',
                    'unit_kerja.skpd AS unit_kerja',
                    'skpd.unit_kerja AS skpd',
                    \DB::raw('@rownum  := @rownum  + 1 AS rownum')
                ]);
        



        $datatables = Datatables::of($dt)
        ->addColumn('action', function ($x) {
            return '<a href="user/'.$x->user_id.'/edit" class="btn btn-xs btn-primary" style="margin-top:2px; width:70px;"><i class="fa fa-edit"></i> Edit</a>'
					.' <a href="user/'.$x->user_id.'" class="btn btn-xs btn-primary" style="margin-top:2px; width:70px;"><i class="fa  fa-eye"></i> Lihat</a>';
        })->addColumn('nama_pegawai', function ($x) {
            
            return Pustaka::nama_pegawai($x->gelardpn , $x->nama , $x->gelarblk);
        
        })->addColumn('nama_unit_kerja', function ($x) {
            
            return Pustaka::capital_string($x->unit_kerja);
        
        });

        
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true);

        
    } */
	
	

    
    /* public function editUsersMainPanel()
    {

        $user               = \Auth::user();
        $users              = \DB::table('users')->get();
        $total_users        = \DB::table('users')->count();
        $userRole           = $user->hasRole('pegawai');
        $admin_skpdRole     = $user->hasRole('admin_skpd');
        $adminRole          = $user->hasRole('administrator');

        if($userRole)
        {
            $access = 'Pegawai';
        } elseif ($admin_skpdRole) {
            $access = 'Admin Skpd';
        } elseif ($adminRole) {
            $access = 'Administrator';
        }

        return view('pare_pns.pages.edit-users', [
                'users'             => $users,
                'total_users'       => $total_users,
                'user'              => $user,
                'access'            => $access,
            ]
        );
    } */

    /**
     * Get a validator for an incoming update user request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    /* public function validator(array $data)
    {
        return Validator::make($data, [
            'nama'          	=> 'required|max:255',
            'nip'         		=> 'required|max:255',
            'location'          => '',
            'bio'               => '',
            'twitter_username'  => '',
            'career_title'      => '',
            'education'         => ''
        ]);
    }
 */
    /**
     * Get a validator for an incoming create user request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    /* public function create_new_validator(array $data)
    {
        return Validator::make($data, [
            'nama'          => 'required|max:255|unique:users',
            'nip'         	=> 'required|max:255|unique:users',
            'password'      => 'required|confirmed|min:6',
            'user_level'    => 'required|numeric|min:1',
            'location'          => '',
            'bio'               => '',
            'twitter_username'  => '',
            'career_title'      => '',
            'education'         => ''
        ]);
    } */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   /*  public function edit($id)
    {

        // GET THE USER
        $user               = User::find($id);
        $userRole           = $user->hasRole('user');
        $admin_skpdRole         = $user->hasRole('admin_skpd');
        $adminRole          = $user->hasRole('administrator');



        $access;

        if($userRole)
        {
            $access = '1';
        } elseif ($admin_skpdRole) {
            $access = '2';
        } elseif ($adminRole) {
            $access = '3';
        }

        return view('pare_pns.pages.edit-user', [
                'user'                      => $user,
                'access'                    => $access,
                //'totaltwitterFollowers'     => $totaltwitterFollowers,
            ]
        )->with('status', 'Successfully updated user!');

    } */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     
  /*   public function update(Request $request, $id)
    {

        $current_roles = array('3','2','1');

        $rules = array(
            'name'            => 'required',
            'nip'             => 'required|nip',
        );

        $validator = $this->validator($request->all(), $rules);

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        } else {
            $user 				      = User::find($id);
            $user->name               = $request->input('name');
            $user->nip                = $request->input('nip');

            $input = Input::only('role_id');
            $user->removeRole($current_roles);
            $user->assignRole($input);
            $user->save();

            return redirect('users/' . $user->id . '/edit')->with('status', 'Successfully updated the user!');

        }
    } */

    /**
     * Show the form for creating a new User
     *
     * @return \Illuminate\Http\Response
     */
   /*  public function create()
    {
        return view('pare_pns.pages.create-user');
    } */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /* public function store(Request $request)
    {

        $create_new_validator = $this->create_new_validator($request->all());

        if ($create_new_validator->fails()) {
            $this->throwValidationException(
                $request, $create_new_validator
            );
        }
        else
        {

            $activation_code        = str_random(60) . $request->input('nip');
            $user                   = new User;
            $user->nip            	= $request->input('nip');
            $user->name             = $request->input('name');
            $user->first_name       = $request->input('first_name');
            $user->last_name        = $request->input('last_name');
            $userAccessLevel        = $request->input('user_level');
            $user->password         = bcrypt($request->input('password'));

            // GET GRAVATAR
            $user->gravatar         = Gravatar::get($request->input('nip'));

            // GET ACTIVATION CODE
            $user->activation_code  = $activation_code;
            $user->active           = '1';

            // GET IP ADDRESS
            $userIpAddress          = new CaptureIp;
            $user->admin_ip_address = $userIpAddress->getClientIp();

            // SAVE THE USER
            $user->save();

            // GET GRAVATAR
            $user->gravatar         = Gravatar::get($user->nip);

            // ADD ROLE
            $user->assignRole($userAccessLevel);

            // CREATE PROFILE LINK TO TABLE
            $profile = new Profile;

            $profileInputs = Input::only(
                'location',
                 'bio',
                 'twitter_username',
                 'github_username',
                 'career_title',
                 'education'
            );
            $profile->fill($profileInputs);
            $user->profile()->save($profile);

            // THE SUCCESSFUL RETURN
            return redirect('edit-users')->with('status', 'Successfully created user!');

        }

    } */

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /* public function show($id)
    {
    	// GET USER
        $user = User::find($id);

        return view('pare_pns.pages.show-user')->withUser($user);
    } */

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   /*  public function destroy($id)
    {
        // DELETE USER
        $user = User::find($id);
        $user->delete();

        return redirect('edit-users')->with('status', 'Successfully deleted the user!');
    } */

}
