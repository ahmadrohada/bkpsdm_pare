<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------

*/

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
	/* Route::get('admin/', [
		'as' 			=> '',
		'uses' 			=> 'HomeAdminController@showHomeAdministrator'
	]);
	
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

	Route::get('admin/masa_pemerintahan', [
		'as' 			=> '',
		'uses' 			=> 'HomeAdminController@showMasaPemerintahan'
	]); */

	Route::get('admin/pohon_kinerja', [
		'as' 			=> 'admin-pohon_kinerja',
		'uses' 			=> 'HomeAdminController@showPohonKinerja'
	]);

	/* Route::get('admin/skp_tahunan', [
		'as' 			=> 'admin-skp_tahunan',
		'uses' 			=> 'HomeAdminController@showSKPTahunan'
	]);

	Route::get('admin/tpp_report', [
		'as' 			=> 'admin-tpp_report',
		'uses' 			=> 'HomeAdminController@showTPPReport'
	]);

	Route::get('admin/puskesmas', [
		'as' 			=> 'admin-puskesmas',
		'uses' 			=> 'HomeAdminController@showPuskesmas'
	]); */

	
	//========================================================================================//
	//================================ T P P    REPORT              ===========================//
	//========================================================================================//

	

/* 
	Route::get('admin/cetak_tpp_report', [
		'as' 			=> '',
		'uses' 			=> 'TPPReportController@AdministratorCetakTPPReport'
	]);

	Route::post('admin/tpp_report/cetak', [
		'as' 			=> '',
		'uses' 			=> 'API\TPPReportAPIController@cetakTPPReportData'
	]);

	Route::get('admin/tpp_report/{tpp_report_id}', [
		'as' 			=> '',
		'uses' 			=> 'TPPReportController@AdministratorTPPReport'
	]); */

	
 

	//----------------------------------------------------------------------------------------//
	//============================ MASA PEMERINTAHAN ======== ================================//
	//----------------------------------------------------------------------------------------//
	/* Route::get('admin/masa_pemerintahan/{masa_pemerintahan_id}',[
		'as' 			=> '',
		'uses' 			=> 'MasaPemerintahanController@showMasaPemerintahan'
	]); */

	//----------------------------------------------------------------------------------------//
	//========================      POHON KINERJA SKPD       ================================//
	//----------------------------------------------------------------------------------------//
	Route::get('admin/pohon_kinerja/{renja_id}',[
		'as' 			=> '',
		'uses' 			=> 'RenjaController@AdministratorRenjaDetail'
	]);

	//========================================================================================//
	//=============================       PERJANJIAN KINERJA       ===========================//
	//========================================================================================//
	Route::post('admin/{renja_id}/cetak_perjanjian_kinerja', [
		'as' 			=> '',
		'uses' 			=> 'API\PerjanjianKinerjaAPIController@cetakPerjanjianKinerjaSKPD'
	]);

	Route::post('admin/skp_tahunan/cetak_perjanjian_kinerja-Eselon2', [
		'as' 			=> '',
		'uses' 			=> 'API\PerjanjianKinerjaAPIController@cetakPerjanjianKinerjaEsl2'
	]);

	Route::post('admin/skp_tahunan/cetak_perjanjian_kinerja-Eselon3', [
		'as' 			=> '',
		'uses' 			=> 'API\PerjanjianKinerjaAPIController@cetakPerjanjianKinerjaEsl3'
	]);


	Route::post('admin/skp_tahunan/cetak_perjanjian_kinerja-Eselon4', [
		'as' 			=> '',
		'uses' 			=> 'API\PerjanjianKinerjaAPIController@cetakPerjanjianKinerjaEsl4'
	]);

	//----------------------------------------------------------------------------------------//
	//========================      SKP TAHUNAN SKPD       ================================//
	//----------------------------------------------------------------------------------------//
	/* Route::get('admin/skp_tahunan/{skp_tahunan_id}',[
		'as' 			=> '',
		'uses' 			=> 'SKPTahunanController@AdministratorSKPTahunanDetail'
	]); */


	//============================================================================================//
	//====================================  PEGAWAI  =============================================//
	//============================================================================================//
	
	/* Route::get('admin/pegawai/{pegawai_id}', [
		'as' 			=> '{username}',
		'uses' 			=> 'PegawaiController@detailPegawai'
	]);


	Route::get('admin/pegawai/{pegawai_id}/add', [
		'as' 			=> '{username}',
		'uses' 			=> 'PegawaiController@addPegawai'
	]); */

	//============================================================================================//
	//====================================  U S E R  =============================================//
	//============================================================================================//
	

	/* Route::get('admin/users/{user_id}', [
		'as' 			=> '{username}',
		'uses' 			=> 'UserController@detailUser'
	]); */

	//============================================================================================//
	//============================= PEGAWAI      S K P D  ========================================//
	//============================================================================================//
	

	/* Route::get('admin/skpd/{skpd_id}', [
		'as' 			=> '{username}',
		'uses' 			=> 'HomeAdminController@AdministratorSKPDPegawai'
	]);

	Route::get('admin/skpd/{skpd_id}/pegawai', [
		'as' 			=> '{username}',
		'uses' 			=> 'HomeAdminController@AdministratorSKPDPegawai'
	]); 

	Route::get('admin/skpd/pegawai/{pegawai_id}', [
		'as' 			=> '{username}',
		'uses' 			=> 'PegawaiController@detailPegawai'
	]); 

	Route::get('admin/skpd/pegawai/{pegawai_id}/add', [
		'as' 			=> '{username}',
		'uses' 			=> 'PegawaiController@addPegawai'
	]); 

	//============================================================================================//
	//============================= PEGAWAI    PUSKESMAS  ========================================//
	//============================================================================================//
	Route::get('admin/puskesmas/{puskesmas_id}', [
		'as' 			=> 'pegawai_puskesmas',
		'uses' 			=> 'HomeAdminController@AdministratorPuskesmasPegawai'
	]);

	Route::get('admin/puskesmas/{puskesmas_id}/pegawai', [
		'as' 			=> '{username}',
		'uses' 			=> 'HomeAdminController@AdministratorPuskesmasPegawai'
	]); 

	Route::get('admin/puskesmas/pegawai/{pegawai_id}', [
		'as' 			=> '{username}',
		'uses' 			=> 'PegawaiController@detailPegawai'
	]); 

	Route::get('admin/puskesmas/{puskesmas_id}/data_error', [
		'as' 			=> '{username}',
		'uses' 			=> 'HomeAdminController@AdministratorPuskesmasPegawaiError'
	]); 

	//============================================================================================//
	//========================== ADMIn CAPAIAN PK       ========================================//
	//============================================================================================//
	Route::get('admin/capaian_pk', [
		'as' 			=> '',
		'uses' 			=> 'HomeAdminController@showCapaianTriwulanPK'
	]);
	
	Route::get('admin/capaian_pk-triwulan', [
		'as' 			=> 'admin-capaian_pk_triwulan',
		'uses' 			=> 'HomeAdminController@showCapaianTriwulanPK'
	]);

	Route::get('admin/capaian_pk-triwulan/{capaian_pk_triwulan_id}', [
		'as' 			=> '',
		'uses' 			=> 'CapaianPKTriwulanController@SKPDCapaianPKTriwulanEdit'
	]);


	Route::get('admin/capaian_pk-tahunan', [
		'as' 			=> '',
		'uses' 			=> 'HomeAdminController@showCapaianTahunanPK'
	]);
	Route::get('admin/capaian_pk-tahunan/{capaian_pk_tahunan_id}', [
		'as' 			=> '',
		'uses' 			=> 'CapaianPKTahunanController@SKPDCapaianPKTahunanEdit'
	]);

	//=======================  MONITORING KINERJA  ==================================//
	Route::get('admin/monitoring_kinerja/{renja_id}', [
		'as' 			=> '',
		'uses' 			=> 'RenjaController@SKPDMonitoringKinerja'
	]);


	//============================================================================================//
	Route::get('admin/skpd/{skpd_id}/struktur-organisasi', [
		'uses' 			=> 'HomeAdminController@AdministratorSKPDStrukturOrganisasi'
	]);



	Route::get('admin/skpd/{skpd_id}/unit_kerja', [
		'uses' 			=> 'SKPDController@showSKPDUnitKerja'
	]);

	

	Route::get('admin/skpd/{skpd_id}/rencana-kerja-perangkat-daerah', [
		'uses' 			=> 'SKPDController@showSKPDRencanaKerjaPerangkatDaerah'
	]);

	Route::get('admin/skpd/{skpd_id}/peta-jabatan', [
		'uses' 			=> 'SKPDController@showSKPDPetaJabatan'
	]);
	

	Route::get('admin/capaian_bulanan/{capaian_bulanan_id}',[
		'as' 			=> '',
		'uses' 			=> 'CapaianBulananController@PersonalCapaianBulananDetail'
	]); */
	


	

});

//========================================================================================//
//====================================   S K P D       ===================================//
//========================================================================================//


Route::group(['prefix' => 'skpd','middleware' => 'skpd'], function () {
		
	
	//========================================================================================//
	//=======================   SKPD HOME / SKPD SNAPSHOTS ===================================//
	//========================================================================================//
	Route::get('', [
		'as' 			=> '',
		'uses' 			=> 'HomeSKPDController@showHomeSKPD'
	]);
	
	Route::get('pegawai', [
		'as' 			=> '',
		'uses' 			=> 'HomeSKPDController@showPegawai'
	]);

	Route::get('unit_kerja', [
		'as' 			=> '',
		'uses' 			=> 'HomeSKPDController@showUnitKerja'
	]);

	Route::get('puskesmas', [
		'as' 			=> 'skpd-puskesmas',
		'uses' 			=> 'HomeSKPDController@showPuskesmas'
	]);

	Route::get('peta-jabatan', [
		'as' 			=> '',
		'uses' 			=> 'HomeSKPDController@ShowPetaJabatan'
	]);
	

	Route::get('pohon_kinerja', [
		'as' 			=> 'skpd-pohon_kinerja',
		'uses' 			=> 'HomeSKPDController@showRenja'
	]);


	Route::get('struktur_organisasi', [
		'as' 			=> '',
		'uses' 			=> 'HomeSKPDController@showStrukturOrganisasi'
	]);


	Route::get('perjanjian_kinerja', [
		'as' 			=> '',
		'uses' 			=> 'HomeSKPDController@showPerjanjianKinerja'
	]);


	Route::get('skp_tahunan', [
		'as' 			=> 'skpd-skp_tahunan',
		'uses' 			=> 'HomeSKPDController@showSKPTahunan'
	]);

	Route::get('skp_bulanan', [
		'as' 			=> 'skpd-skp_bulanan',
		'uses' 			=> 'HomeSKPDController@showSKPBulanan'
	]);

	Route::get('tpp_report', [
		'as' 			=> 'skpd-tpp_report',
		'uses' 			=> 'HomeSKPDController@showSKPDTPPReport'
	]);

	Route::get('capaian_pk', [
		'as' 			=> '',
		'uses' 			=> 'HomeSKPDController@showCapaianTriwulanPK'
	]);

	Route::get('capaian_pk-triwulan', [
		'as' 			=> 'skpd-capaian_pk_triwulan',
		'uses' 			=> 'HomeSKPDController@showCapaianTriwulanPK'
	]);

	

	Route::get('capaian_pk-tahunan', [
		'as' 			=> 'skpd-capaian_pk_tahunan',
		'uses' 			=> 'HomeSKPDController@showCapaianTahunanPK'
	]);



	/* //=======================   TPP R E P O R T   ==================================//
	Route::get('report/tpp', [
		'as' 			=> '',
		'uses' 			=> 'TPPReportController@showSKPDTPPReport'
	]);

	Route::get('report/tpp/{tpp_report_id}', [
		'as' 			=> '',
		'uses' 			=> 'TPPReportController@SKPDTPPReport'
	]);

	Route::get('report/tpp/{tpp_report_id}/edit', [
		'as' 			=> '',
		'uses' 			=> 'TPPReportController@editSKPDTPPReport'
	]);
	
	Route::post('tpp_report/cetak', [
		'as' 			=> '',
		'uses' 			=> 'API\TPPReportAPIController@cetakTPPReportData'
	]); */

	//========================================================================================//
	//=============================       PERJANJIAN KINERJA       ===========================//
	//========================================================================================//
	Route::post('pohon_kinerja/{renja_id}/cetak_perjanjian_kinerja', [
		'as' 			=> '',
		'uses' 			=> 'API\PerjanjianKinerjaAPIController@cetakPerjanjianKinerjaSKPD'
	]);

	Route::post('pohon_kinerja/{renja_id}/cetak_perjanjian_kinerja', [
		'as' 			=> '',
		'uses' 			=> 'API\PerjanjianKinerjaAPIController@cetakPerjanjianKinerjaSKPD'
	]);

	Route::post('skp_tahunan/{skp_tahunan_id}/cetak_perjanjian_kinerja-Eselon2', [
		'as' 			=> '',
		'uses' 			=> 'API\PerjanjianKinerjaAPIController@cetakPerjanjianKinerjaEsl2'
	]);

	Route::post('skp_tahunan/cetak_perjanjian_kinerja-Eselon2', [
		'as' 			=> '',
		'uses' 			=> 'API\PerjanjianKinerjaAPIController@cetakPerjanjianKinerjaEsl2'
	]);

	Route::post('skp_tahunan/cetak_perjanjian_kinerja-Eselon3', [
		'as' 			=> '',
		'uses' 			=> 'API\PerjanjianKinerjaAPIController@cetakPerjanjianKinerjaEsl3'
	]);

	Route::post('skp_tahunan/cetak_perjanjian_kinerja-Eselon4', [
		'as' 			=> '',
		'uses' 			=> 'API\PerjanjianKinerjaAPIController@cetakPerjanjianKinerjaEsl4'
	]);


	/* //========================== CAPAIAN PK TRIWULAN =======================================//
	Route::get('capaian_pk-triwulan/{capaian_pk_triwulan_id}/edit', [
		'as' 			=> '',
		'uses' 			=> 'CapaianPKTriwulanController@SKPDCapaianPKTriwulanEdit'
	]);

	//========================== CAPAIAN PK TAHUNAN =======================================//
	Route::get('capaian_pk-tahunan/{capaian_pk_tahunan_id}/edit', [
		'as' 			=> '',
		'uses' 			=> 'CapaianPKTahunanController@SKPDCapaianPKTahunanEdit'
	]);
	


	//=======================  MONITORING KINERJA  ==================================//
	Route::get('monitoring_kinerja/{renja_id}', [
		'as' 			=> '',
		'uses' 			=> 'RenjaController@SKPDMonitoringKinerja'
	]);




	//=========================== P E G A W A I  =============================================//
	Route::get('pegawai/{pegawai_id}', [
		'as' 			=> '{username}',
		'uses' 			=> 'PegawaiController@detailPegawai'
	]);

	Route::get('pegawai/{pegawai_id}/add', [
		'as' 			=> '{username}',
		'uses' 			=> 'PegawaiController@addPegawai'
	]);


	//============================================================================================//
	//============================= PEGAWAI    PUSKESMAS  ========================================//
	//============================================================================================//
	Route::get('puskesmas/{puskesmas_id}', [
		'as' 			=> 'pegawai_puskesmas',
		'uses' 			=> 'HomeSKPDController@SKPDPuskesmasPegawai'
	]);

	Route::get('puskesmas/{puskesmas_id}/pegawai', [
		'as' 			=> '',
		'uses' 			=> 'HomeSKPDController@SKPDPuskesmasPegawai'
	]); 

	Route::get('puskesmas/pegawai/{pegawai_id}', [
		'as' 			=> '{username}',
		'uses' 			=> 'PegawaiController@detailPegawai'
	]);  */

	//----------------------------------------------------------------------------------------//
	//======================== POHON KINERJA PERANGKAT DAERAH ================================//
	//----------------------------------------------------------------------------------------//
	Route::get('pohon_kinerja/{renja_id}',[
		'as' 			=> '',
		'uses' 			=> 'RenjaController@SKPDRenjaDetail'
	]);

	Route::get('pohon_kinerja/{renja_id}/edit',[
		'as' 			=> '',
		'uses' 			=> 'RenjaController@SKPDRenjaEdit'
	]);

	Route::get('pohon_kinerja/{renja_id}/ralat',[
		'as' 			=> '',
		'uses' 			=> 'RenjaController@SKPDRenjaRalat'
	]);
	 
	
	/* //----------------------------------------------------------------------------------------//
	//========================      SKP TAHUNAN SKPD       ================================//
	//----------------------------------------------------------------------------------------//
	Route::get('skp_tahunan/{skp_tahunan_id}',[
		'as' 			=> '',
		'uses' 			=> 'SKPTahunanController@SKPDSKPTahunanDetail'
	]);


	//----------------------------------------------------------------------------------------//
	//============================== PERJANJIAN KINERJA  =====================================//
	//----------------------------------------------------------------------------------------//
	Route::get('perjanjian_kinerja/{perjanjian_kinerja_id}',[
		'as' 			=> '',
		'uses' 			=> 'PerjanjianKinerjaController@showPerjanjianKinerja'
	]);

	Route::post('skp_tahunan/{skp_tahunan_id}/cetak_perjanjian_kinerja-Eselon4', [
		'as' 			=> '',
		'uses' 			=> 'API\PerjanjianKinerjaAPIController@cetakPerjanjianKinerjaEsl4'
	]);
	Route::post('skp_tahunan/cetak_perjanjian_kinerja-Eselon4', [
		'as' 			=> '',
		'uses' 			=> 'API\PerjanjianKinerjaAPIController@cetakPerjanjianKinerjaEsl4'
	]);




	//----------------------------------------------------------------------------------------//
	//================================= SKP BULANAN      =====================================//
	//----------------------------------------------------------------------------------------//
	Route::get('skp_bulanan/{id}',[
		'as' 			=> '',
		'uses' 			=> 'SKPBulananController@SKPBulananDetail'
	]);
 */
	


});


Route::group(['prefix' => 'puskesmas','middleware' => 'puskesmas'], function () {
		
	
	/* //========================================================================================//
	//=======================   Puskesmas HOME / PUSKESMAS SNAPSHOTS =========================//
	//========================================================================================//
	Route::get('', [
		'as' 			=> '',
		'uses' 			=> 'HomePuskesmasController@showHomePuskesmas'
	]);
	Route::get('pegawai', [
		'as' 			=> '',
		'uses' 			=> 'HomePuskesmasController@showPegawai'
	]);
	Route::get('struktur_organisasi', [
		'as' 			=> '',
		'uses' 			=> 'HomePuskesmasController@ShowStrukturOrganisasi'
	]);
	Route::get('skp_tahunan', [
		'as' 			=> 'puskesmas-skp_tahunan',
		'uses' 			=> 'HomePuskesmasController@showSKPTahunan'
	]);
	Route::get('skp_bulanan', [
		'as' 			=> 'puskesmas-skp_bulanan',
		'uses' 			=> 'HomePuskesmasController@showSKPBulanan'
	]);
	Route::get('tpp_report', [
		'as' 			=> 'puskesmas-tpp_report',
		'uses' 			=> 'HomePuskesmasController@showPuskesmasTPPReport'
	]);

	//=======================   TPP R E P O R T   ==================================//

	Route::get('tpp_report/{tpp_report_id}/puskesmas/{puskesmas_id}', [
		'as' 			=> '',
		'uses' 			=> 'TPPReportController@PuskesmasTPPReport'
	]);
	
	Route::get('tpp_report/{tpp_report_id}/puskesmas/{puskesmas_id}/edit', [
		'as' 			=> '',
		'uses' 			=> 'TPPReportController@editPuskesmasTPPReport'
	]);
	
	Route::post('tpp_report/cetak', [
		'as' 			=> '',
		'uses' 			=> 'API\TPPReportAPIController@cetakPuskesmasTPPReportData'
	]);

	
	//=========================== P E G A W A I  =============================================//
	Route::get('pegawai/{pegawai_id}', [
		'as' 			=> '{username}',
		'uses' 			=> 'PegawaiController@detailPegawai'
	]);

	

	
	//----------------------------------------------------------------------------------------//
	//========================      SKP TAHUNAN SKPD       ================================//
	//----------------------------------------------------------------------------------------//
	Route::get('skp_tahunan/{skp_tahunan_id}',[
		'as' 			=> '',
		'uses' 			=> 'SKPTahunanController@SKPDSKPTahunanDetail'
	]);


	//----------------------------------------------------------------------------------------//
	//================================= SKP BULANAN      =====================================//
	//----------------------------------------------------------------------------------------//
	Route::get('skp_bulanan/{id}',[
		'as' 			=> '',
		'uses' 			=> 'SKPBulananController@SKPBulananDetail'
	]); */

	


});



//===============================================================================================================//
//=============== PERSONAL ACCESS LEVEL PAGE ROUTES - RUNNING THROUGH PERSONAL MIDDLEWARE ====================//
//===============================================================================================================//

Route::group(['prefix' => 'personal','middleware' => 'personal'], function () {

	/* Route::get('', [
		'as' 			=> '',
		'uses' 			=> 'HomePersonalController@showHomePersonal'
	]);

	

	//======================= H O M E   P E R S O N A L ========================================//
	Route::get('skp', [
		'as' 			=> '',
		'uses' 			=> 'HomePersonalController@showSKPJabatan'
	]);
	
	Route::get('skp_jabatan', [
		'as' 			=> '',
		'uses' 			=> 'HomePersonalController@showSKPJabatan'
	]);
	

	Route::get('skp_tahunan', [
		'as' 			=> 'personal-skp_tahunan', 
		'uses' 			=> 'HomePersonalController@showSKPTahunan'
	]);
	

	Route::get('capaian', [
		'as' 			=> '',
		'uses' 			=> 'HomePersonalController@showCapaianBulanan'
	]);

	Route::get('capaian-bulanan', [
		'as' 			=> 'personal-capaian_bulanan',
		'uses' 			=> 'HomePersonalController@showCapaianBulanan'
	]);

	Route::get('capaian-triwulan', [
		'as' 			=> 'personal-capaian_triwulan',
		'uses' 			=> 'HomePersonalController@showCapaianTriwulan'
	]);

	Route::get('capaian-tahunan', [
		'as' 			=> 'personal-capaian_tahunan',
		'uses' 			=> 'HomePersonalController@showCapaianTahunan'
	]);

	Route::get('capaian-gabungan', [
		'as' 			=> 'personal-capaian_gabungan',
		'uses' 			=> 'HomePersonalController@showCapaianGabungan'
	]);

	Route::get('tpp', [
		'as' 			=> '',
		'uses' 			=> 'HomePersonalController@showTPP'
	]);

//======================= A P P R O V A L    R E Q U E S T ==================================//


	Route::get('approval', [
		'as' 			=> '',
		'uses' 			=> 'ApprovalRequestController@showDashoard'
	]);


	
	Route::get('renja_approval-request', [
		'as' 			=> '',
		'uses' 			=> 'ApprovalRequestController@showRenja'
	]);

	Route::get('renja_approval-request/{renja_id}', [
		'as' 			=> '',
		'uses' 			=> 'RenjaController@SKPDRenjaApproval'
	]);

	Route::get('pohon_kinerja/{renja_id}',[
		'as' 			=> '',
		'uses' 			=> 'RenjaController@PersonalRenjaDetail'
	]);
	
	
	Route::get('skp_tahunan_approval-request', [
		'as' 			=> '',
		'uses' 			=> 'ApprovalRequestController@showSKPTahunan'
	]);

	Route::get('skp_tahunan_approval-request/{skp_tahunan_id}', [
		'as' 			=> '',
		'uses' 			=> 'SKPTahunanController@SKPTahunanApproval'
	]);

	
	//========================================================================================//
	//=============================       CAPAIAN BAWAHAN          ===========================//
	//========================================================================================//
	Route::get('capaian_tahunan_bawahan', [
		'as' 			=> 'capaian_tahunan_bawahan',
		'uses' 			=> 'CapaianTahunanController@CapaianTahunanBawahanList'
	]);

	Route::get('capaian_tahunan_bawahan/{capaian_tahunan_id}', [
		'as' 			=> '',
		'uses' 			=> 'CapaianTahunanController@CapaianTahunanBawahanDetail'
	]); 

	Route::get('capaian_tahunan_bawahan_approvement/{capaian_tahunan_id}', [
		'as' 			=> '',
		'uses' 			=> 'CapaianTahunanController@CapaianTahunanBawahanApprovement'
	]); 


	Route::get('capaian_bulanan_bawahan', [
		'as' 			=> 'capaian_bulanan_bawahan',
		'uses' 			=> 'CapaianBulananController@CapaianBulananBawahanList'
	]);

	Route::get('capaian_bulanan_bawahan_approvement/{capaian_bulanan_id}', [
		'as' 			=> '',
		'uses' 			=> 'CapaianBulananController@CapaianBulananBawahanApprovement'
	]); 


	Route::get('capaian_bulanan_bawahan/{capaian_bulanan_id}', [
		'as' 			=> '',
		'uses' 			=> 'CapaianBulananController@CapaianBulananBawahanDetail'
	]); 


	
	//========================================================================================//
	//=============================       PERJANJIAN KINERJA       ===========================//
	//========================================================================================//
	Route::post('skp_tahunan/{skp_tahunan_id}/cetak_perjanjian_kinerja-Eselon2', [
		'as' 			=> '',
		'uses' 			=> 'API\PerjanjianKinerjaAPIController@cetakPerjanjianKinerjaEsl2'
	]);

	Route::post('skp_tahunan/cetak_perjanjian_kinerja-Eselon2', [
		'as' 			=> '',
		'uses' 			=> 'API\PerjanjianKinerjaAPIController@cetakPerjanjianKinerjaEsl2'
	]);

	

	Route::post('skp_tahunan/{skp_tahunan_id}/cetak_perjanjian_kinerja-Eselon3', [
		'as' 			=> '',
		'uses' 			=> 'API\PerjanjianKinerjaAPIController@cetakPerjanjianKinerjaEsl3'
	]);
	Route::post('skp_tahunan/cetak_perjanjian_kinerja-Eselon3', [
		'as' 			=> '',
		'uses' 			=> 'API\PerjanjianKinerjaAPIController@cetakPerjanjianKinerjaEsl3'
	]);

	Route::post('skp_tahunan/{skp_tahunan_id}/cetak_rencana_aksi-Eselon3', [
		'as' 			=> '',
		'uses' 			=> 'API\RencanaAksiAPIController@cetakRencanaAksiEsl3'
	]);

	Route::post('skp_tahunan/{skp_tahunan_id}/cetak_perjanjian_kinerja-Eselon4', [
		'as' 			=> '',
		'uses' 			=> 'API\PerjanjianKinerjaAPIController@cetakPerjanjianKinerjaEsl4'
	]);
	Route::post('skp_tahunan/cetak_perjanjian_kinerja-Eselon4', [
		'as' 			=> '',
		'uses' 			=> 'API\PerjanjianKinerjaAPIController@cetakPerjanjianKinerjaEsl4'
	]);


	//========================================================================================//
	//=============================       KONTRAK KINERJA       ===========================//
	//========================================================================================//
	Route::post('skp_tahunan/{skp_tahunan_id}/cetak_kontrak_kinerja-JFU', [
		'as' 			=> '',
		'uses' 			=> 'API\KontrakKinerjaAPIController@cetakKontrakKinerjaJFU'
	]);

	Route::post('skp_tahunan/{skp_tahunan_id}/cetak_kontrak_kinerja-JFT', [
		'as' 			=> '',
		'uses' 			=> 'API\KontrakKinerjaAPIController@cetakKontrakKinerjaJFT'
	]);

	



	//=========================================================================================//
	//================================= SKP TAHUNAN      =====================================//
	//=========================================================================================//
	

	Route::get('skp_tahunan/{skp_tahunan_id}/edit',[
		'as' 			=> '',
		'uses' 			=> 'SKPTahunanController@PersonalSKPTahunanEdit'
	]);

	Route::get('skp_tahunan/{skp_tahunan_id}',[
		'as' 			=> '',
		'uses' 			=> 'SKPTahunanController@PersonalSKPTahunanDetail'
	]);

	Route::get('skp_tahunan/{skp_tahunan_id}/ralat',[
		'as' 			=> '',
		'uses' 			=> 'SKPTahunanController@PersonalSKPTahunanRalat'
	]);


	//=========================================================================================//
	//================================= SKP BULANAN      =====================================//
	//=========================================================================================//
	Route::get('skp_bulanan', [
		'as' 			=> 'personal-skp_bulanan',
		'uses' 			=> 'HomePersonalController@showSKPBulanan'
	]);

	Route::get('skp_bulanan/{skp_bulanan_id}/edit',[
		'as' 			=> '',
		'uses' 			=> 'SKPBulananController@PersonalSKPBulananEdit'
	]);

	Route::get('skp_bulanan/{skp_bulanan_id}',[
		'as' 			=> '',
		'uses' 			=> 'SKPBulananController@PersonalSKPBulananDetail'
	]);

	Route::get('skp_bulanan/{skp_bulanan_id}/ralat',[
		'as' 			=> '',
		'uses' 			=> 'SKPBulananController@PersonalSKPBulananRalat'
	]);


	

	//=========================================================================================//
	//=============================   CAPAIAN BULANAN     =====================================//
	//=========================================================================================//

	Route::get('capaian-bulanan/{capaian_bulanan_id}',[
		'as' 			=> '',
		'uses' 			=> 'CapaianBulananController@PersonalCapaianBulananDetail'
	]);

	Route::get('capaian-bulanan/{capaian_bulanan_id}/edit',[
		'as' 			=> '',
		'uses' 			=> 'CapaianBulananController@PersonalCapaianBulananEdit'
	]);

	Route::get('capaian-bulanan/{capaian_bulanan_id}/ralat',[
		'as' 			=> '',
		'uses' 			=> 'CapaianBulananController@PersonalCapaianBulananRalat'
	]);

	//=========================================================================================//
	//=============================   CAPAIAN TRIWULAN     ====================================//
	//=========================================================================================//
	
	Route::get('capaian-triwulan/{capaian_triwulan_id}/edit',[
		'as' 			=> '',
		'uses' 			=> 'CapaianTriwulanController@PersonalCapaianTriwulanEdit'
	]);


	//=========================================================================================//
	//=============================   CAPAIAN TAHUNAN     ====================================//
	//=========================================================================================//
	
	
	Route::get('capaian-tahunan/{capaian_tahunan_id}/edit',[
		'as' 			=> '',
		'uses' 			=> 'CapaianTahunanController@PersonalCapaianTahunanEdit'
	]);

	Route::get('capaian-tahunan/{capaian_tahunan_id}',[
		'as' 			=> '',
		'uses' 			=> 'CapaianTahunanController@PersonalCapaianTahunanDetail'
	]);
	


	Route::get('capaian-tahunan/{capaian_tahunan_id}/ralat',[
		'as' 			=> '',
		'uses' 			=> 'CapaianTahunanController@PersonalCapaianTahunanRalat'
	]);

	Route::get('capaian-tahunan/{capaian_tahunan_id}/cetak',[
		'as' 			=> '',
		'uses' 			=> 'CapaianTahunanController@PersonalCapaianTahunancetak'
	]); */
	









});


//===============================================================================================================//
//=============== NON PNS ACCESS LEVEL PAGE ROUTES - RUNNING THROUGH PERSONAL MIDDLEWARE ====================//
//===============================================================================================================//

Route::group(['prefix' => 'non_pns','middleware' => 'non_pns'], function () {

	Route::get('', [
		'as' 			=> '',
		'uses' 			=> 'HomePersonalController@showHomePersonal'
	]);




});



// CATCH ALL ERROR FOR USERS AND NON USERS
Route::any('/{page?}',function(){
	if ( ( Auth::check() ) & ( Request::segment(1) != 'pare_api' ) ) {
		/* return view('pare_pns.errors.users404'); */

		$data['title'] = '404';
		$data['name'] = 'Page not found';
		return response()->view('pare_pns.errors.users404',$data,404);
		
	} else {
		//return View('errors.404');
		//return response()->json(["productQuanties" => "tes"]);
		return response("<pre>Not found</pre>");
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