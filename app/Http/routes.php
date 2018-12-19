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


	//========================================================================================================//
	//=================================================  U S E R =============================================//
	//========================================================================================================//
	//Route::resource('users','API\UsersAPIController');
	Route::get('administrator_users_list','API\UserAPIController@administrator_users_list');
	Route::post('add_pegawai','API\PegawaiAPIController@add_pegawai');
	Route::post('reset_password','API\UserAPIController@reset_password');
	Route::post('ubah_username','API\UserAPIController@ubah_username');


	//========================================================================================================//
	//================================================= S   K   P  D  ========================================//
	//========================================================================================================//
	
	Route::get('administrator_skpd_list','API\SKPDAPIController@administrator_skpd_list');

	

	Route::get('administrator_unit_kerja_skpd_list','API\SKPDAPIController@administrator_unit_kerja_skpd_list');
	

	//========================================================================================================//
	//==============================      RENCANA  KERJA  PERANGKAT  DAERAH      =============================//
	//========================================================================================================//
	

	Route::get('skpd_renja_tree','API\RenjaAPIController@skpd_renja_tree');
	Route::get('skpd_renja_list','API\RenjaAPIController@skpd_renja_list');
	Route::get('skpd_renja_distribusi_kegiatan_tree','API\RenjaAPIController@skpd_renja_distribusi_kegiatan_tree');

	
	


	//========================================================================================================//
	//====================== PERJANJIAN KINERNA SKPD =========================================================//
	//========================================================================================================//

	Route::get('skpd_perjanjian_kinerja_list','API\PerjanjianKinerjaAPIController@SKPDPerjanjianKinerja_list');



	//========================================================================================================//
	//====================== SKP TAHUNAN SKPD =========================================================//
	//========================================================================================================//

	Route::get('skpd_skp_tahunan_list','API\SKPTahunanAPIController@SKPDSKPTahunan_list');




/* 


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
 */
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
	Route::get('skpd_pegawai_list','API\PegawaiAPIController@skpd_pegawai_list');
	
	
	Route::get('select_pegawai_list','API\PegawaiAPIController@select_pejabat_penilai_list');

	Route::get('administrator_pegawai_skpd_list','API\PegawaiAPIController@skpd_pegawai_list');

	//========================================================================================================//
	//============================  PEJABATA PENILAI SKP TAHUNAN ================================================//
	//========================================================================================================//
	Route::post('set_pejabat_penilai_skp_tahunan','API\SKPTahunanAPIController@set_pejabat_penilai_skp_tahunan');
	
	Route::get('kegiatan_tugas_jabatan_list','API\KegiatanSKPTahunanAPIController@kegiatan_tugas_jabatan_list');

	//========================================================================================================//
	//========================================  J A B A T A N ================================================//
	//========================================================================================================//
	Route::get('select2_jabatan_list','API\JabatanAPIController@select2_jabatan_list');


	
	//========================================================================================================//
	//==================================  PETA  J A B A T A N ================================================//
	//========================================================================================================//
	Route::get('skpd_peta_jabatan','API\PetaJabatanAPIController@skpd_peta_jabatan');


	//========================================================================================================//
	//================================== STRUKTUR ORGANISASI  ================================================//
	//========================================================================================================//
	Route::get('skpd_struktur_organisasi','API\StrukturOrganisasiAPIController@skpd_struktur_organisasi');


	


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
	    'uses' 		=> 'DashboardController@index'
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




	//============================================================================================//
	//============================ ADMIN HOME / ADMIN SNAPSHOTS ====================================//
	//============================================================================================//
	Route::get('admin/pegawai', [
		'as' 			=> '',
		'uses' 			=> 'HomeAdminController@showPegawai'
	]);

	Route::get('admin/users', [
		'as' 			=> '',
		'uses' 			=> 'HomeAdminController@showUser'
	]);

	Route::get('admin/skpd', [
		'as' 			=> '',
		'uses' 			=> 'HomeAdminController@showSKPD'
	]);




	//============================================================================================//
	//====================================  PEGAWAI  =============================================//
	//============================================================================================//
	
	Route::get('admin/pegawai/{pegawai_id}', [
		'as' 			=> '{username}',
		'uses' 			=> 'PegawaiController@detailPegawai'
	]);


	Route::get('admin/pegawai/{pegawai_id}/add', [
		'as' 			=> '{username}',
		'uses' 			=> 'PegawaiController@addPegawai'
	]);

	//============================================================================================//
	//====================================  U S E R  =============================================//
	//============================================================================================//
	

	Route::get('admin/users/{user_id}', [
		'as' 			=> '{username}',
		'uses' 			=> 'UserController@detailUser'
	]);

	//============================================================================================//
	//====================================  S K P D  =============================================//
	//============================================================================================//
	

	Route::get('admin/skpd/{skpd_id}', [
		'as' 			=> '{username}',
		'uses' 			=> 'SKPDController@pegawaiSKPDAdministrator'
	]);

	Route::get('admin/skpd/{skpd_id}/pegawai', [
		'as' 			=> '{username}',
		'uses' 			=> 'SKPDController@showSKPDPegawai'
	]);

	Route::get('admin/skpd/{skpd_id}/unit-kerja', [
		'uses' 			=> 'SKPDController@showSKPDUnitKerja'
	]);

	Route::get('admin/skpd/{skpd_id}/struktur-organisasi', [
		'uses' 			=> 'SKPDController@showSKPDStrukturOrganisasi'
	]);

	Route::get('admin/skpd/{skpd_id}/rencana-kerja-perangkat-daerah', [
		'uses' 			=> 'SKPDController@showSKPDRencanaKerjaPerangkatDaerah'
	]);

	Route::get('admin/skpd/{skpd_id}/peta-jabatan', [
		'uses' 			=> 'SKPDController@showSKPDPetaJabatan'
	]);
	
	
	
	/* //============================================================================================//
	//==============================  RENCANA KERJA  =============================================//
	//============================================================================================//
	Route::get('admin/rencana-kerja', [
		'as' 			=> 'jquery.treeview',
		'uses' 			=> 'RencanaKerjaController@treeView'
	]);
	

	// AJAX REQUEST RENCANA KERJA
	Route::get('admin/data-rencana-kerja', [
		'as' 			=> 'jquery.treeview',
		'uses' 			=> 'RencanaKerjaController@datatreeView'
	]);
	
	
	// PETA JABATAN  PAGE ROUTE
	Route::get('admin/peta-jabatan', [
		'as' 			=> 'jquery.treeview',
		'uses' 			=> 'JabatanController@ShowPetaJabatan'
	]);
	

	// AJAX REQUEST RENCANA KERJA
	Route::get('admin/data-peta-jabatan', [
		'as' 			=> 'jquery.treeview',
		'uses' 			=> 'JabatanController@DataPetaJabatan'
	]); */
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




// SKPD ACCESS LEVEL PAGE ROUTES - RUNNING THROUGH SKPD MIDDLEWARE
Route::group(['prefix' => 'skpd','middleware' => 'skpd'], function () {
		
	
	//========================================================================================//
	//=======================   SKPD HOME / SKPD SNAPSHOTS ===================================//
	//========================================================================================//
	Route::get('pegawai', [
		'as' 			=> '',
		'uses' 			=> 'HomeSKPDController@showPegawai'
	]);

	Route::get('unit-kerja', [
		'as' 			=> '',
		'uses' 			=> 'HomeSKPDController@showUnitKerja'
	]);

	Route::get('peta-jabatan', [
		'as' 			=> '',
		'uses' 			=> 'HomeSKPDController@ShowPetaJabatan'
	]);
	

	Route::get('renja', [
		'as' 			=> '',
		'uses' 			=> 'HomeSKPDController@showRenja'
	]);


	Route::get('struktur-organisasi', [
		'as' 			=> '',
		'uses' 			=> 'HomeSKPDController@showStrukturOrganisasi'
	]);


	Route::get('perjanjian-kinerja', [
		'as' 			=> '',
		'uses' 			=> 'HomeSKPDController@showPerjanjianKinerja'
	]);


	Route::get('skp-tahunan', [
		'as' 			=> '',
		'uses' 			=> 'HomeSKPDController@showSKPTahunan'
	]);

	//----------------------------------------------------------------------------------------//
	//======================== RENCANA KERJA PERANGKAT DAERAH ================================//
	//----------------------------------------------------------------------------------------//
	Route::get('renja/{renja_id}',[
		'as' 			=> '',
		'uses' 			=> 'RenjaController@showRenja'
	]);
	
	


	//----------------------------------------------------------------------------------------//
	//============================== PERJANJIAN KINERJA  =====================================//
	//----------------------------------------------------------------------------------------//
	Route::get('perjanjian_kinerja/{pk_id_id}',[
		'as' 			=> '',
		'uses' 			=> 'PerjanjianKinerjaController@showPerjanjianKinerja'
	]);



	//----------------------------------------------------------------------------------------//
	//================================= SKP TAHUNAN      =====================================//
	//----------------------------------------------------------------------------------------//
	Route::get('skp_tahunan/{skp_tahunan_id}',[
		'as' 			=> '',
		'uses' 			=> 'SKPTahunanController@SKPTahunanPersonalEdit'
	]);



	/* 
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
 */
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
	

	// AJAX REQUEST  PETA JABATAN
	/* Route::get('data-peta-jabatan', [
		'as' 			=> 'jquery.treeview',
		'uses' 			=> 'JabatanController@DataPetaJabatanSkpd'
	]); */


	


	/* // AJAX REQUEST 
	Route::get('table_users', [
		'as' 			=> '{username}',
		'uses' 			=> 'UsersManagementController@skpd_data_users'
	]); */
	
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