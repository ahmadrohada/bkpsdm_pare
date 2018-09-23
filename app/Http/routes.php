<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
| http://laravel.com/docs/5.1/authentication
| http://laravel.com/docs/5.1/authorization
| http://laravel.com/docs/5.1/routing
| http://laravel.com/docs/5.0/schema
| http://socialiteproviders.github.io/

*/


//===================== AJAX REQUEST WITH API CONTROLLER =================//
Route::group(['prefix' => 'api_resource'/* ,'middleware'=> 'auth.api' */], function () {

	Route::resource('periode_tahunan','API\PeriodeTahunanAPIController');


	Route::resource('users','API\UsersAPIController');
	

	//========================================================================================================//
	//====================== PERJANJIAN KINERNA SKPD =========================================================//
	//========================================================================================================//

	Route::get('breadcrumb-perjanjian-kinerja','API\PerjanjianKinerjaAPIController@SKPDPerjanjianKinerjaBreadcrumb');
	
	Route::get('skpd_periode_perjanjian_kinerja_list','API\PerjanjianKinerjaAPIController@SKPDPeriodePerjanjianKinerja');
	Route::post('skpd_simpan_perjanjian_kinerja','API\PerjanjianKinerjaAPIController@Store');

	Route::get('skpd_sasaran_list','API\SasaranAPIController@SKPD_sasaran_list');
	Route::get('skpd_sasaran_perjanjian_kinerja_list','API\SasaranPerjanjianKinerjaAPIController@SKPD_sasaran_perjanjian_kinerja_list');
	Route::post('skpd_simpan_sasaran_perjanjian_kinerja','API\SasaranPerjanjianKinerjaAPIController@Store');
	

	Route::get('skpd_indikator_sasaran_perjanjian_kinerja_list','API\IndikatorSasaranAPIController@SKPD_indikator_sasaran_perjanjian_kinerja_list');
	Route::post('skpd_simpan_indiator_sasaran','API\IndikatorSasaranAPIController@Store');
	
	Route::get('skpd_program_perjanjian_kinerja_list','API\ProgramAPIController@SKPD_program_perjanjian_kinerja_list');
	Route::post('skpd_simpan_program','API\ProgramAPIController@Store');

	Route::get('skpd_indikator_program_perjanjian_kinerja_list','API\IndikatorProgramAPIController@SKPD_indikator_program_perjanjian_kinerja_list');
	Route::post('skpd_simpan_indikator_program','API\IndikatorProgramAPIController@Store');

	Route::get('skpd_kegiatan_perjanjian_kinerja_list','API\KegiatanAPIController@SKPD_kegiatan_perjanjian_kinerja_list');
	Route::post('skpd_simpan_kegiatan','API\KegiatanAPIController@Store');

	Route::get('skpd_indikator_kegiatan_perjanjian_kinerja_list','API\IndikatorKegiatanAPIController@SKPD_indikator_kegiatan_perjanjian_kinerja_list');
	Route::post('skpd_simpan_indikator_kegiatan','API\IndikatorKegiatanAPIController@Store');

	//========================================================================================================//
	//================================== PERSONAL SKP THAUNAN=================================================//
	//========================================================================================================//
	Route::get('personal_skp_tahunan_list','API\SKPTahunanAPIController@Personal_SKP_tahunan_list');

	Route::get('create_skp_tahunan_confirm','API\SKPTahunanAPIController@create_skp_tahunan_confirm');

	Route::post('create_skp_tahunan','API\SKPTahunanAPIController@Store');

	//========================================================================================================//
	//==================================  P E G A W A I =================================================//
	//========================================================================================================//
	Route::get('administrator_pegawai_list','API\PegawaiAPIController@administrator_pegawai_list');
	
	
	Route::get('select_pegawai_list','API\PegawaiAPIController@select_pejabat_penilai_list');

	//========================================================================================================//
	//============================  PEJABATA PENILAI SKP TAHUNAN ================================================//
	//========================================================================================================//
	Route::post('set_pejabat_penilai_skp_tahunan','API\SKPTahunanAPIController@set_pejabat_penilai_skp_tahunan');
	
	Route::get('kegiatan_tugas_jabatan_list','API\KegiatanSKPTahunanAPIController@kegiatan_tugas_jabatan_list');

	//========================================================================================================//
	//========================================  J A B A T A N ================================================//
	//========================================================================================================//
	Route::get('select2_jabatan_list','API\JabatanAPIController@select2_jabatan_list');


	



	


});




// HOMEPAGE ROUTE
Route::get('/', function () {
    return view('welcome');
});

// ALL AUTHENTICATION ROUTES - HANDLED IN THE CONTROLLERS
Route::controllers([
	'auth' 		=> 'Auth\AuthController',
	'password' 	=> 'Auth\PasswordController',
]);

// CUSTOM REDIRECTS
Route::get('restart', function () {
    \Auth::logout();
	//return redirect('auth/register')->with('anError',  \Lang::get('auth.loggedOutLocked'));
	return redirect('auth/login')->with('anError',  \Lang::get('auth.tryAnother'));
});
Route::get('another', function () {
    \Auth::logout();
    return redirect('auth/login')->with('anError',  \Lang::get('auth.tryAnother'));
});


// AUTHENTICATION ALIASES/REDIRECTS
Route::get('login', function () {
    return redirect('/auth/login');
});
Route::get('logout', function () {
    return redirect('/auth/logout');
});
Route::get('register', function () {
	//return redirect('/auth/register');
	return View('errors.404');
});
Route::get('reset', function () {
    return redirect('/password/nip');
});
Route::get('admin', function () {
    return redirect('/dashboard');
});
Route::get('home', function () {
    return redirect('/dashboard');
});


//nambahan hada
Route::get('/', function () {
    return redirect('/dashboard');
});




// USER PAGE ROUTES - RUNNING THROUGH AUTH MIDDLEWARE
Route::group(['middleware' => 'auth'], function () {

	// USER DASHBOARD ROUTE
	Route::get('/dashboard', [
	    'as' 		=> 'dashboard',  // INI untuk icon breadcrumb
	    'uses' 		=> 'UserController@index'
	]);

	// USERS VIEWABLE PROFILE
	Route::get('profile/{username}', [
		'as' 		=> '{username}',
		'uses' 		=> 'ProfilesController@show'
	]);
	Route::get('dashboard/profile/{username}', [
		'as' 		=> '{username}',
		'uses' 		=> 'ProfilesController@show'
	]);

	

	
	// MIDDLEWARE INCEPTIONED - MAKE SURE THIS IS THE CURRENT USERS PROFILE TO EDIT
	Route::group(['middleware'=> 'currentUser'], function () {
			Route::resource(
				'profile',
				'ProfilesController', [
					'only' 	=> [
						'show',
						'edit',
						'update'
					]
				]
			);
	});

});







// ADMINISTRATOR ACCESS LEVEL PAGE ROUTES - RUNNING THROUGH ADMINISTRATOR MIDDLEWARE
Route::group(['middleware' => 'administrator'], function () {

	// SHOW ALL USERS PAGE ROUTE
	//Route::resource('rencana_kerja', 'RencanaKerjaController');
	
	Route::get('admin/lihat_pegawai', [
		'as' 			=> '{username}',
		'uses' 			=> 'UsersManagementController@showPegawaiAdministrator'
	]);

	
	//=================== RENCANA KERJA  =====================================//
	
	// RENCANA KERJA PAGE ROUTE
	Route::get('admin/rencana-kerja', [
		'as' 			=> 'jquery.treeview',
		'uses' 			=> 'RencanaKerjaController@treeView'
	]);
	

	// AJAX REQUEST RENCANA KERJA
	Route::get('admin/data-rencana-kerja', [
		'as' 			=> 'jquery.treeview',
		'uses' 			=> 'RencanaKerjaController@datatreeView'
	]);
	//========================================================================//
	
	
	//====================== PETA JABATAN =====================================//
	
	// PETA JABATAN  PAGE ROUTE
	Route::get('admin/peta-jabatan', [
		'as' 			=> 'jquery.treeview',
		'uses' 			=> 'JabatanController@ShowPetaJabatan'
	]);
	

	// AJAX REQUEST RENCANA KERJA
	Route::get('admin/data-peta-jabatan', [
		'as' 			=> 'jquery.treeview',
		'uses' 			=> 'JabatanController@DataPetaJabatan'
	]);
	//========================================================================//
	

	// AJAX REQUEST TEST
	Route::get('admin/skp-tahunan', [
		'as' 			=> '',
		'uses' 			=> 'RencanaKerjaController@DataTes'
	]);
	//========================================================================//
	
	
	// EDIT USERS PAGE ROUTE
	Route::get('edit-users', [
		'as' 			=> '{username}',
		'uses' 			=> 'UsersManagementController@editUsersMainPanel'
	]);

	// TAG CONTROLLER PAGE ROUTE
	Route::resource('admin/skilltags', 'SkillsTagController', ['except' => 'show']);

	
	
	// TEST ROUTE ONLY ROUTE
	Route::get('administrator', function () {
	    echo 'Welcome to your ADMINISTRATOR page '. Auth::user()->nip .'.';
	});
	
	// TEST ABOUT
	Route::get('/about', [
		'as' 			=> '{username}',
		'uses' 			=> 'UsersManagementController@editUsersMainPanel'
	]);
	

});




// ADMINISTRATOR ACCESS LEVEL PAGE ROUTES - RUNNING THROUGH ADMINISTRATOR MIDDLEWARE
Route::group(['prefix' => 'skpd','middleware' => 'skpd'], function () {
		
	
	//----------------------------------------------------------------------------------------//
	//============================== PERJANJIAN KINERJA  =====================================//
	//----------------------------------------------------------------------------------------//
	Route::get('perjanjian-kinerja'				,'PerjanjianKinerjaController@SKPDPerjanjianKinerja');
	//Route::get('skpd-data-perjanjian-kinerja'	,'PerjanjianKinerjaController@SKPDDataPerjanjianKinerja');

	//======= SIMPAN  PERJANJIAN KINERJA DATA AJAX ==========//
	Route::post('skpd/simpan-perjanjian-kinerja', [
		'as' 			=> '',
		'uses' 			=> 'PerjanjianKinerjaController@Store'
	]);

	//=======  EDIT SASARAN PERJANJIAN KINERJA   ===============//
	Route::get('edit-perjanjian-kinerja/{perjanjian_kinerja_id}/sasaran-perjanjian-kinerja', 'PerjanjianKinerjaController@SKPDEditPerjanjianKinerja_sasaran');
	
	//=======  EDIT INDKTR SASARAN PERJANJIAN KINERJA   ===============//
	Route::get('edit-perjanjian-kinerja/{perjanjian_kinerja_id}/sasaran-perjanjian-kinerja/{sasaran_perjanjian_kinerja_id}', 'PerjanjianKinerjaController@SKPDEditPerjanjianKinerja_indikator_sasaran');
	
	//=======  EDIT PROGRAM  PERJANJIAN KINERJA   ===============//
	Route::get('edit-perjanjian-kinerja/{perjanjian_kinerja_id}/indikator-sasaran/{indikator_sasaran_id}', 'PerjanjianKinerjaController@SKPDEditPerjanjianKinerja_program');
	
	//=======  EDIT INDIKATOR PROGRAM  PERJANJIAN KINERJA   ===============//
	Route::get('edit-perjanjian-kinerja/{perjanjian_kinerja_id}/program/{program_id}', 'PerjanjianKinerjaController@SKPDEditPerjanjianKinerja_indikator_program');
	
	//=======  EDIT KEGIATAN PERJANJIAN KINERJA   ===============//
	Route::get('edit-perjanjian-kinerja/{perjanjian_kinerja_id}/indikator-program/{indikator_program_id}', 'PerjanjianKinerjaController@SKPDEditPerjanjianKinerja_kegiatan');

	//=======  EDIT KEGIATAN PERJANJIAN KINERJA   ===============//
	Route::get('edit-perjanjian-kinerja/{perjanjian_kinerja_id}/kegiatan/{kegiatan_id}', 'PerjanjianKinerjaController@SKPDEditPerjanjianKinerja_indikator_kegiatan');

/* 




	


	
	//----------------------------------------------------------------------------------------//
	//=================================== S A S A R A N  =====================================//
	//----------------------------------------------------------------------------------------//

	//================== SASARAN DATA AJAX =============//
	Route::get('add-sasaran-list', [
		'as' 			=> '',
		'uses' 			=> 'SasaranController@DataSasaranAddList'
	]);

	

	// SASARAN AJAX REQUEST
	Route::get('data-sasaran-skpd', [
		'as' 			=> '',
		'uses' 			=> 'SasaranController@DataSasaranSkpd'
	]);

	//======= SASARAN PERJANJIAN KINERJA DATA AJAX ==========//
	Route::get('sasaran-perjanjian-kinerja', [
			'as' 			=> '',
			'uses' 			=> 'SasaranPerjanjianKinerjaController@DataSasaranPerjanjianKinerja'
	]);

	// SASARAN ROUTE
	Route::get('skpd/sasaran', [
		'as' 			=> '',
		'uses' 			=> 'SasaranController@ShowSasaranSkpd'
	]);

	// SASARAN ROUTE
	Route::get('skpd/f_sasaran-perjanjian-kinerja/{id}', [
		'as' 			=> '',
		'uses' 			=> 'SasaranPerjanjianKinerjaController@FSasaranPerjanjianKinerja'
	]);
	


	// INDIKATOR SASARAN ROUTE
	Route::get('skpd/perjanjian-kinerja-indikator-sasaran/{sasaran_id}', [
		'as' 			=> '',
		'uses' 			=> 'SasaranController@PerjanjianKinerjaIndikatorSasaran'
	]);


	
	

 */
	//====================== PETA JABATAN =====================================//
	
	 // PETA JABATAN  PAGE ROUTE
	Route::get('peta-jabatan', [
		'as' 			=> 'jquery.treeview',
		'uses' 			=> 'JabatanController@ShowPetaJabatanSkpd'
	]);
	

	// AJAX REQUEST  PETA JABATAN
	Route::get('data-peta-jabatan', [
		'as' 			=> 'jquery.treeview',
		'uses' 			=> 'JabatanController@DataPetaJabatanSkpd'
	]);


	Route::get('lihat_pegawai', [
		'as' 			=> '',
		'uses' 			=> 'UsersManagementController@showPegawaiSkpd'
	]);
	// AJAX REQUEST 
	Route::get('table_users', [
		'as' 			=> '{username}',
		'uses' 			=> 'UsersManagementController@skpd_data_users'
	]);
	
/*
	//====================== DISTRIBUSI KEGIATAN =====================================//
	
	// DISTRIBUSI KEGIATAN  PAGE ROUTE
	Route::get('distribusi-kegiatan', [
		'as' 			=> 'distribusi_kegiatan',
		'uses' 			=> 'DistribusiKegiatanController@ShowDistribusiKegiatanAll'
	]);

	
	
	
	
	
	// DISTRIBUSI KEGIATAN  PAGE ROUTE
	Route::get('distribusi-kegiatan/{jenis_jabatan}', [
		'as' 			=> 'distribusi_kegiatan',
		'uses' 			=> 'DistribusiKegiatanController@ShowDistribusiKegiatan'
	]);
	

	// DISTRIBUSI KEGIATAN  AJAX REQUEST
	Route::get('data-jabatan-all', [
		'as' 			=> 'distribusi_kegiatan',
		'uses' 			=> 'DistribusiKegiatanController@DataJabatanAll'
	]);
	
	// DISTRIBUSI KEGIATAN  AJAX REQUEST
	Route::get('data-jabatan-jpt', [
		'as' 			=> 'distribusi_kegiatan',
		'uses' 			=> 'DistribusiKegiatanController@DataJabatanJpt'
	]);

	// DISTRIBUSI KEGIATAN  AJAX REQUEST
	Route::get('data-jabatan-administrator', [
		'as' 			=> 'distribusi_kegiatan_adm',
		'uses' 			=> 'DistribusiKegiatanController@DataJabatanAdministrator'
	]);

	// DISTRIBUSI KEGIATAN  AJAX REQUEST
	Route::get('data-jabatan-pengawas', [
		'as' 			=> 'distribusi_kegiatan',
		'uses' 			=> 'DistribusiKegiatanController@DataJabatanPengawas'
	]);

	// DISTRIBUSI KEGIATAN  AJAX REQUEST
	Route::get('data-jabatan-jfujft', [
		'as' 			=> 'distribusi_kegiatan',
		'uses' 			=> 'DistribusiKegiatanController@DataJabatanJfujft'
	]); 

	// ADD KEGIATAN PADA JABATAN ROUTE
	Route::get('distribusi-kegiatan/{jenis_jabatan}/{id_jabatan}/add-kegiatan', [
		'as' 			=> 'distribusi_kegiatan',
		'uses' 			=> 'DistribusiKegiatanController@AddKegiatan'
	]);

	

	
	// INDIKATOR SASARAN ROUTE
	Route::get('indikator_sasaran/{id}', [
		'as' 			=> '',
		'uses' 			=> 'IndikatorSasaranController@DetailIndikatorSasaran'
	]);
	
	
	
	
	// PROGRAM ROUTE
	Route::get('program/{id}', [
		'as' 			=> '',
		'uses' 			=> 'ProgramController@DetailProgram'
	]);
	
	// PROGRAM AJAX REQUEST
	Route::get('program', [
		'as' 			=> '',
		'uses' 			=> 'ProgramController@DataProgram'
	]); */
	
	
	//==============================================================================//
});


/* // ADMINISTRATOR ACCESS LEVEL PAGE ROUTES - RUNNING THROUGH ADMINISTRATOR MIDDLEWARE
Route::group(['middleware' => 'administrator'], function () {

	// SHOW ALL USERS PAGE ROUTE
	Route::resource('rencana_kerja', 'UsersManagementController');
	
	Route::get('admin/users', [
		'as' 			=> '{username}',
		'uses' 			=> 'UsersManagementController@showUsersMainPanel'
	]);

	
	
	
	// AJAX REQUEST 
	Route::get('table_users', [
		'as' 			=> '{username}',
		'uses' 			=> 'UsersManagementController@getRowNumData'
	]);
	
	
	
	
	// RENCANA KERJA PAGE ROUTE
	Route::get('rencana-kerja', [
		'as' 			=> 'jquery.treeview',
		'uses' 			=> 'RencanaKerjaController@treeView'
	]);
	
	
	// AJAX REQUEST RENCANA KERJA
	Route::get('data-rencana-kerja', [
		'as' 			=> 'jquery.treeview',
		'uses' 			=> 'RencanaKerjaController@datatreeView'
	]);
	
	
	
	// EDIT USERS PAGE ROUTE
	Route::get('edit-users', [
		'as' 			=> '{username}',
		'uses' 			=> 'UsersManagementController@editUsersMainPanel'
	]);

	// TAG CONTROLLER PAGE ROUTE
	Route::resource('admin/skilltags', 'SkillsTagController', ['except' => 'show']);

	
	
	// TEST ROUTE ONLY ROUTE
	Route::get('administrator', function () {
	    echo 'Welcome to your ADMINISTRATOR page '. Auth::user()->nip .'.';
	});
	
	// TEST ABOUT
	Route::get('/about', [
		'as' 			=> '{username}',
		'uses' 			=> 'UsersManagementController@editUsersMainPanel'
	]);
	
	
	

}); */





// PEGAWAI ACCESS LEVEL PAGE ROUTES - RUNNING THROUGH PEGAWAI MIDDLEWARE
Route::group(['prefix' => 'personal','middleware' => 'personal'], function () {


	//======= SKP TAHUNAN ===============//
	Route::get('skp-tahunan', 'SKPTahunanController@SKPTahunanPersonal');
	Route::get('skp-tahunan/{skp_tahunan_id}/edit', 'SKPTahunanController@SKPTahunanPersonalEdit');
	









});



// CATCH ALL ERROR FOR USERS AND NON USERS
Route::any('/{page?}',function(){
	if (Auth::check()) {
		/* return view('admin.errors.users404'); */
		$data['title'] = '404';
		$data['name'] = 'Page not found';
		return response()->view('admin.errors.users404',$data,404);
		
	} else {
		return View('errors.404');
	}
})->where('page','.*');





//***************************************************************************************//
//***************************** USER ROUTING EXAMPLES BELOW *****************************//
//***************************************************************************************//

//** OPTION - ALL FOLLOWING ROUTES RUN THROUGH AUTHETICATION VIA MIDDLEWARE **//
/*
Route::group(['middleware' => 'auth'], function () {

	// OPTION - GO DIRECTLY TO TEMPLATE
	Route::get('/', function () {
	    return view('pages.user-home');
	});

	// OPTION - USE CONTROLLER
	Route::get('/', [
	    'as' 			=> 'user',
	    'uses' 			=> 'UsersController@index'
	]);

});
*/
//** OPTION - SINGLE ROUTE USING A CONTROLLER AND AUTHENTICATION VIA MIDDLEWARE **//
/*
Route::get('/', [
    'middleware' 	=> 'auth',
    'as' 			=> 'user',
    'uses' 			=> 'UsersController@index'
]);
*/