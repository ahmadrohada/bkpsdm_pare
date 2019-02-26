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
	//===========================================     MASA PEMERINTAHAN          =============================//
	//========================================================================================================//
	
	Route::get('administrator_masa_pemerintahan_list','API\MasaPemerintahanAPIController@AdministratorMasaPemerintahanList');
	Route::get('administrator_masa_pemerintahan_tree','API\MasaPemerintahanAPIController@AdministratorMasaPemerintahanTree');
	

	

	//========================================================================================================//
	//==============================      RENCANA  KERJA  PERANGKAT  DAERAH      =============================//
	//========================================================================================================//
	

	Route::get('skpd_renja_aktivity','API\RenjaAPIController@SKPDRenjaActivity');
	Route::get('skpd_renja_list','API\RenjaAPIController@SKPDRenjaList');
	Route::get('create_renja_confirm','API\RenjaAPIController@ConfirmRenja');
	
	
	Route::get('renja_timeline_status','API\RenjaAPIController@RenjaTimelineStatus');
	Route::get('renja_status_pengisian','API\RenjaAPIController@RenjaStatusPengisian');

	

	Route::get('approval_request_renja_list','API\RenjaAPIController@RenjaApprovalRequestList');


	Route::post('create_renja','API\RenjaAPIController@Store');
	Route::post('renja_send_to_kaban','API\RenjaAPIController@SendToKaban');
	Route::post('renja_pull_from_kaban','API\RenjaAPIController@PullFromKaban');

	Route::post('renja_setuju_by_kaban','API\RenjaAPIController@SetujuByKaban');
	Route::post('renja_tolak_by_kaban','API\RenjaAPIController@TolakByKaban');
	
	


	//========================================================================================================//
	//====================== PERJANJIAN KINERNA SKPD =========================================================//
	//========================================================================================================//

	Route::get('skpd_perjanjian_kinerja_list','API\PerjanjianKinerjaAPIController@SKPDPerjanjianKinerja_list');
	Route::get('perjanjian_kinerja_timeline_status','API\PerjanjianKinerjaAPIController@PerjanjianKinerjaTimelineStatus');



	//========================================================================================================//
	//====================== SKP TAHUNAN SKPD =========================================================//
	//========================================================================================================//

	Route::get('skpd_skp_tahunan_list','API\SKPTahunanAPIController@SKPDSKPTahunanList');
	Route::get('skp_tahunan_timeline_status','API\SKPTahunanAPIController@SKPTahunanTimelineStatus');
	Route::get('skp_tahunan_general_timeline','API\SKPTahunanAPIController@SKPTahunanGeneralTimeline');


	//========================================================================================================//
	//====================== SKP BULANAN SKPD =========================================================//
	//========================================================================================================//

	Route::get('skpd_skp_bulanan_list','API\SKPBulananAPIController@SKPDSKPBulanan_list');
	Route::get('skp_bulanan_tree','API\SKPBulananAPIController@skp_bulanan_tree');
	Route::get('skp_bulanan_timeline_status','API\SKPBulananAPIController@SKPbulanan_timeline_status');

	//========================================================================================================//
	//======================================      M   I   S   I     =======================================//
	//========================================================================================================//

	Route::get('misi_select2','API\MisiAPIController@MisiSelect2');



	//========================================================================================================//
	//======================================      T U J U A N   =======================================//
	//========================================================================================================//

	Route::get('skpd-renja_tujuan_list','API\TujuanAPIController@TujuanList');
	Route::get('tujuan_detail','API\TujuanAPIController@TujuanDetail');
	

	Route::post('simpan_tujuan','API\TujuanAPIController@Store');
	Route::post('update_tujuan','API\TujuanAPIController@Update');
	Route::post('hapus_tujuan','API\TujuanAPIController@Hapus');

	//========================================================================================================//
	//=============================   I N D I K A T O R      T U J U A N   ============================//
	//========================================================================================================//

	Route::get('skpd-renja_ind_tujuan_list','API\IndikatorTujuanAPIController@IndikatorTujuanList');

	Route::get('ind_tujuan_detail','API\IndikatorTujuanAPIController@IndTujuanDetail');
	Route::post('simpan_ind_tujuan','API\IndikatorTujuanAPIController@Store');
	Route::post('update_ind_tujuan','API\IndikatorTujuanAPIController@Update');
	Route::post('hapus_ind_tujuan','API\IndikatorTujuanAPIController@Hapus');


	
	//========================================================================================================//
	//============================================= S A S A R A N    =========================================//
	//========================================================================================================//

	Route::get('skpd-renja_sasaran_list','API\SasaranAPIController@SasaranList');

	Route::get('sasaran_detail','API\SasaranAPIController@SasaranDetail');
	
	Route::post('simpan_sasaran','API\SasaranAPIController@Store');
	Route::post('update_sasaran','API\SasaranAPIController@Update');
	Route::post('hapus_sasaran','API\SasaranAPIController@Hapus');


	//========================================================================================================//
	//===============================I N D I K A T O R    S A S A R A N    ===================================//
	//========================================================================================================//

	Route::get('skpd-renja_ind_sasaran_list','API\IndikatorSasaranAPIController@IndSasaranList');

	Route::get('ind_sasaran_detail','API\IndikatorSasaranAPIController@IndSasaranDetail');
	
	Route::post('simpan_ind_sasaran','API\IndikatorSasaranAPIController@Store');
	Route::post('update_ind_sasaran','API\IndikatorSasaranAPIController@Update');
	Route::post('hapus_ind_sasaran','API\IndikatorSasaranAPIController@Hapus');



	//========================================================================================================//
	//======================================       P R O G R A M       =======================================//
	//========================================================================================================//

	Route::get('skpd-renja_program_list','API\ProgramAPIController@ProgramList');

	Route::get('program_detail','API\ProgramAPIController@ProgramDetail');
	
	Route::post('simpan_program','API\ProgramAPIController@Store');
	Route::post('update_program','API\ProgramAPIController@Update');
	Route::post('hapus_program','API\ProgramAPIController@Hapus');

	//========================================================================================================//
	//======================================  I N D I K A T O R     P R O G R A M   ==========================//
	//========================================================================================================//

	Route::get('skpd-renja_ind_program_list','API\IndikatorProgramAPIController@IndProgramList');

	Route::get('ind_program_detail','API\IndikatorProgramAPIController@IndProgramDetail');
	
	Route::post('simpan_ind_program','API\IndikatorProgramAPIController@Store');
	Route::post('update_ind_program','API\IndikatorProgramAPIController@Update');
	Route::post('hapus_ind_program','API\IndikatorProgramAPIController@Hapus');
	

	//========================================================================================================//
	//======================================      K E G I A T A N      =======================================//
	//========================================================================================================//
	
	Route::get('skpd-renja_kegiatan_list','API\KegiatanAPIController@KegiatanList');

	Route::get('kegiatan_detail','API\KegiatanAPIController@KegiatanDetail');
	Route::get('kegiatan_renja_detail','API\KegiatanAPIController@KegiatanDetail');

	Route::post('simpan_kegiatan','API\KegiatanAPIController@Store');
	Route::post('update_kegiatan','API\KegiatanAPIController@Update');
	Route::post('hapus_kegiatan','API\KegiatanAPIController@Hapus');
	





	Route::post('kegiatan_store','API\KegiatanAPIController@Store');
	Route::post('kegiatan_rename','API\KegiatanAPIController@Rename');
	Route::get('kegiatan_renja_detail','API\KegiatanAPIController@KegiatanDetail');




	
	
	Route::get('renja_kegiatan_list','API\KegiatanAPIController@RenjaKegiatanList');
	Route::post('add_kegiatan_to_pejabat','API\KegiatanAPIController@AddKegiatanToPejabat');

	//========================================================================================================//
	//============================= D I S T R I B U S I    K E G I A T A N    ========================//
	//========================================================================================================//


	Route::get('skpd_renja_distribusi_kegiatan_tree','API\KegiatanAPIController@RenjaDistribusiKegiatanTree');

	//Kegiatan KA SKPD
	Route::get('skpd-renja_kegiatan_list_kaskpd','API\KegiatanAPIController@RenjaKegiatanKaSKPD');
	Route::get('skp_tahunan_kegiatan_1','API\KegiatanAPIController@SKPTahunanKegiatanTree1');

	//kegiatan KABID
	Route::get('skpd-renja_kegiatan_list_kabid','API\KegiatanAPIController@RenjaKegiatanKabid');
	Route::get('skp_tahunan_kegiatan_2','API\KegiatanAPIController@SKPTahunanKegiatanTree2');


	//KEgiatan KASUBID
	Route::get('skpd-renja_kegiatan_list_kasubid','API\KegiatanAPIController@RenjaKegiatanKasubid');
	Route::get('skp_tahunan_kegiatan_3','API\KegiatanAPIController@SKPTahunanKegiatanTree3');

	//KEgiatan PELAKSANA
	//Route::get('skpd-renja_kegiatan_list_kasubid','API\KegiatanAPIController@RenjaKegiatanKasubid');
	Route::get('skp_tahunan_kegiatan_4','API\KegiatanAPIController@SKPTahunanKegiatanTree4');


	//UNLINK KEGFIATAN
	
	Route::post('hapus_kegiatan_kasubid','API\KegiatanAPIController@RemoveKegiatanFromPejabat');

	//========================================================================================================//
	//======================================  I N D I K A T O R    K E G I A T A N    ========================//
	//========================================================================================================//

	/* Route::post('ind_kegiatan_store','API\IndikatorKegiatanAPIController@Store');
	Route::post('ind_kegiatan_rename','API\IndikatorKegiatanAPIController@Rename');
	Route::get('indikator_kegiatan_list','API\IndikatorKegiatanAPIController@IndikatorKegiatanList');
	 */

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
	//==================================  SKP THAUNAN=================================================//
	//========================================================================================================//
	Route::get('personal_skp_tahunan_list','API\SKPTahunanAPIController@PersonalSKPTahunanList');

	//KASUBID
	Route::get('skp_tahunan_status_pengisian3','API\SKPTahunanAPIController@SKPTahunanStatusPengisian3');

	Route::get('personal_cek_status_skp_tahunan','API\SKPTahunanAPIController@SKPTahunanCekStatus');
	
	
	Route::get('skp_bawahan_list_md','API\SKPTahunanAPIController@SKPTahunanBawahanMd');
	
	Route::get('create_skp_tahunan_confirm','API\SKPTahunanAPIController@CreateConfirm');
	Route::get('skp_tahunan_detail','API\SKPTahunanAPIController@SKPTahunandDetail');

	

	Route::post('create_skp_tahunan','API\SKPTahunanAPIController@Store');

	Route::post('skp_tahunan_open','API\SKPTahunanAPIController@SKPOPen');
	Route::post('skp_tahunan_close','API\SKPTahunanAPIController@SKPClose');

	Route::post('skp_tahunan_send_to_atasan','API\SKPTahunanAPIController@SendToAtasan');
	Route::post('skp_tahunan_pull_from_atasan','API\SKPTahunanAPIController@PullFromAtasan');
	Route::post('hapus_skp_tahunan','API\SKPTahunanAPIController@Destroy');

	Route::get('approval_request_skp_tahunan_list','API\SKPTahunanAPIController@SKPTahunanApprovalRequestList');

	Route::post('skp_tahunan_setuju_by_atasan','API\SKPTahunanAPIController@SetujuByAtasan');
	Route::post('skp_tahunan_tolak_by_atasan','API\SKPTahunanAPIController@TolakByAtasan');

	//========================================================================================================//
	//====================================== KEGIATAN THAUNAN ================================================//
	//========================================================================================================//
	/* Route::get('skp_tahunan_ktj_2','API\KegiatanSKPTahunanAPIController@ktj_2_tree'); // (kabid ) */


	Route::get('kegiatan_tahunan_detail','API\KegiatanSKPTahunanAPIController@KegiatanTahunanDetail');
	
	/* Route::get('skp_tahunan_ktj','API\KegiatanSKPTahunanAPIController@KTJoverKegiatanIdlist'); */

	//KABAN
	Route::get('kegiatan_tahunan_1','API\KegiatanSKPTahunanAPIController@KegiatanTahunan1');

	//kegiatan_KABID
	Route::get('kegiatan_tahunan_2','API\KegiatanSKPTahunanAPIController@KegiatanTahunan2');

	//kegiatan KASUBID
	Route::get('kegiatan_tahunan_3','API\KegiatanSKPTahunanAPIController@KegiatanTahunan3');


	//kegiatan PELAKSANA
	Route::get('kegiatan_tahunan_4','API\KegiatanSKPTahunanAPIController@KegiatanTahunan4');

	

	Route::post('simpan_kegiatan_tahunan','API\KegiatanSKPTahunanAPIController@Store');
	Route::post('update_kegiatan_tahunan','API\KegiatanSKPTahunanAPIController@Update');
	Route::post('hapus_kegiatan_tahunan','API\KegiatanSKPTahunanAPIController@Hapus');

	
	

	Route::get('skp_tahunan_kegiatan_tugas_jabatan','API\KegiatanSKPTahunanAPIController@KegiatanTugasJabatanList');


	//========================================================================================================//
	//============================== =======       SKP BULANAN ================================================//
	//========================================================================================================//
	Route::get('skp_bulanan_list_4','API\SKPBulananAPIController@SKPBulananList');



	//========================================================================================================//
	//============================== KEGIATAN TUGAS JABATAN SKP BULANAN ======================================//
	//========================================================================================================//
	Route::get('skp_bulanan_kegiatan_tugas_jabatan','API\KegiatanSKPBulananAPIController@kegiatan_tugas_jabatan_list');
	Route::get('kegiatan_bulanan_4','API\KegiatanSKPBulananAPIController@KegiatanBulanan4');

	
	
	//========================================================================================================//
	//======================================= RENCANA AKSI  SKP THAUNAN ======================================//
	//========================================================================================================//
	Route::get('rencana_aksi_tree','API\RencanaAksiAPIController@rencana_aksi_tree');
	Route::get('skp_tahunan_rencana_aksi','API\RencanaAksiAPIController@RencanaAksiList');
	Route::get('skp_tahunan_rencana_aksi_4','API\RencanaAksiAPIController@RencanaAksiList4');
	Route::get('rencana_aksi_detail','API\RencanaAksiAPIController@RencanaAksiDetail');

	Route::post('simpan_rencana_aksi','API\RencanaAksiAPIController@Store');
	Route::post('update_rencana_aksi','API\RencanaAksiAPIController@Update');
	Route::post('hapus_rencana_aksi','API\RencanaAksiAPIController@Hapus');

	

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
	Route::post('set_pejabat_penilai_skp_tahunan','API\SKPTahunanAPIController@PejabatPenilaiUpdate');
	
	

	//========================================================================================================//
	//========================================  J A B A T A N ================================================//
	//========================================================================================================//
	Route::get('select2_jabatan_list','API\JabatanAPIController@select2_jabatan_list');
	Route::get('detail_pejabat_aktif','API\JabatanAPIController@PejabatAktifDetail');


	Route::get('select2_bawahan_list','API\JabatanAPIController@Select2BawahanList');


	
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

	Route::get('admin/masa_pemerintahan', [
		'as' 			=> '',
		'uses' 			=> 'HomeAdminController@showMasaPemerintahan'
	]);


	//----------------------------------------------------------------------------------------//
	//============================ MASA PEMERINTAHAN ======== ================================//
	//----------------------------------------------------------------------------------------//
	Route::get('admin/masa_pemerintahan/{masa_pemerintahan_id}',[
		'as' 			=> '',
		'uses' 			=> 'MasaPemerintahanController@showMasaPemerintahan'
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

	Route::get('skp-bulanan', [
		'as' 			=> '',
		'uses' 			=> 'HomeSKPDController@showSKPBulanan'
	]);

	//----------------------------------------------------------------------------------------//
	//======================== RENCANA KERJA PERANGKAT DAERAH ================================//
	//----------------------------------------------------------------------------------------//
	Route::get('renja/{renja_id}',[
		'as' 			=> '',
		'uses' 			=> 'RenjaController@SKPDRenjaDetail'
	]);

	Route::get('renja/{renja_id}/edit',[
		'as' 			=> '',
		'uses' 			=> 'RenjaController@SKPDRenjaEdit'
	]);

	Route::get('renja/{renja_id}/ralat',[
		'as' 			=> '',
		'uses' 			=> 'RenjaController@SKPDRenjaRalat'
	]);
	
	


	//----------------------------------------------------------------------------------------//
	//============================== PERJANJIAN KINERJA  =====================================//
	//----------------------------------------------------------------------------------------//
	Route::get('perjanjian_kinerja/{perjanjian_kinerja_id}',[
		'as' 			=> '',
		'uses' 			=> 'PerjanjianKinerjaController@showPerjanjianKinerja'
	]);



	//----------------------------------------------------------------------------------------//
	//================================= SKP TAHUNAN      =====================================//
	//----------------------------------------------------------------------------------------//
	
	Route::get('skp-tahunan/{skp_tahunan_id}',[
		'as' 			=> '',
		'uses' 			=> 'SKPTahunanController@PersonalSKPTahunanDetail'
	]);

	//----------------------------------------------------------------------------------------//
	//================================= SKP BULANAN      =====================================//
	//----------------------------------------------------------------------------------------//
	Route::get('skp_bulanan/{id}',[
		'as' 			=> '',
		'uses' 			=> 'SKPBulananController@SKPBulananDetail'
	]);


});

//===============================================================================================================//
//=============== PEGAWAI ACCESS LEVEL PAGE ROUTES - RUNNING THROUGH PEGAWAI MIDDLEWARE ====================//
//===============================================================================================================//

Route::group(['prefix' => 'personal','middleware' => 'personal'], function () {

	//======================= H O M E   P E R S O N A L ========================================//
	Route::get('skp-tahunan', [
		'as' 			=> '',
		'uses' 			=> 'HomePersonalController@showSKPTahunan'
	]);



	//======================= A P P R O V A L    R E Q U E S T ==================================//
	Route::get('renja_approval-request', [
		'as' 			=> '',
		'uses' 			=> 'ApprovalRequestController@showRenja'
	]);

	Route::get('renja_approval-request/{renja_id}', [
		'as' 			=> '',
		'uses' 			=> 'RenjaController@SKPDRenjaApproval'
	]);

	Route::get('renja/{renja_id}',[
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
	//=========================================================================================//
	//================================= SKP TAHUNAN      =====================================//
	//=========================================================================================//
	Route::get('skp-tahunan/{skp_tahunan_id}/edit',[
		'as' 			=> '',
		'uses' 			=> 'SKPTahunanController@PersonalSKPTahunanEdit'
	]);

	Route::get('skp-tahunan/{skp_tahunan_id}',[
		'as' 			=> '',
		'uses' 			=> 'SKPTahunanController@PersonalSKPTahunanDetail'
	]);

	Route::get('skp-tahunan/{skp_tahunan_id}/ralat',[
		'as' 			=> '',
		'uses' 			=> 'SKPTahunanController@PersonalSKPTahunanRalat'
	]);
	









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