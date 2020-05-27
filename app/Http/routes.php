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
//tes route


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
	Route::post('update_password','API\UserAPIController@update_password');
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
	



	//=============================== POHON KINERJA ==========================================================//
	Route::get('skpd_pohon_kinerja','API\PohonKinerjaAPIController@PohonKinerjaTree');
	

	//========================================================================================================//
	//==============================      RENCANA  KERJA  PERANGKAT  DAERAH      =============================//
	//========================================================================================================//
	
	Route::get('skpd_renja_list','API\RenjaAPIController@SKPDRenjaList');
	Route::get('administrator_pohon_kinerja_list','API\RenjaAPIController@AdministratorPohonKinerjaList');

	Route::get('create_renja_confirm','API\RenjaAPIController@ConfirmRenja');
	Route::post('set_kepala_skpd_renja','API\RenjaAPIController@KepalaSKPDUpdate');
	
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

	//Route::get('skpd_perjanjian_kinerja_list','API\PerjanjianKinerjaAPIController@SKPDPerjanjianKinerja_list');
	//Route::get('perjanjian_kinerja_timeline_status','API\PerjanjianKinerjaAPIController@PerjanjianKinerjaTimelineStatus');

	//ESELON 2 KA SKPD
	Route::get('skpd-pk_sasaran_strategis','API\PerjanjianKinerjaAPIController@SasaranStrategisSKPD');
	Route::get('skpd-pk_program','API\PerjanjianKinerjaAPIController@ProgramSKPD');
	Route::get('skpd-total_anggaran_pk','API\PerjanjianKinerjaAPIController@TotalAnggaranSKPD');

	

	//ESELON 2 KA SKPD
	Route::get('eselon2-pk_sasaran_strategis','API\PerjanjianKinerjaAPIController@SasaranStrategisSKPD');
	Route::get('eselon2-pk_program','API\PerjanjianKinerjaAPIController@ProgramSKPD');
	Route::get('eselon2-total_anggaran_pk','API\PerjanjianKinerjaAPIController@TotalAnggaranSKPD');



	
	Route::post('remove_esl2_kegiatan_from_pk','API\PerjanjianKinerjaAPIController@RemoveEsl2KegiatanFromPK');
	Route::post('add_esl2_kegiatan_to_pk','API\PerjanjianKinerjaAPIController@AddEsl2KegiatanToPK');
	Route::get('eselon2_kegiatan_list','API\PerjanjianKinerjaAPIController@KegiatanListSKPD');
	Route::get('eselon2-total_anggaran_kegiatan','API\PerjanjianKinerjaAPIController@TotalAnggaranKegiatanSKPD');
	


	//ESELON 3 , KABID
	Route::post('remove_esl3_kegiatan_from_pk','API\PerjanjianKinerjaAPIController@RemoveEsl3KegiatanFromPK');
	Route::post('add_esl3_kegiatan_to_pk','API\PerjanjianKinerjaAPIController@AddEsl3KegiatanToPK');


	Route::get('eselon3-pk_sasaran_strategis','API\PerjanjianKinerjaAPIController@SasaranStrategisEselon3');
	Route::get('eselon3-pk_program','API\PerjanjianKinerjaAPIController@ProgramEselon3');
	Route::get('eselon3-total_anggaran_pk','API\PerjanjianKinerjaAPIController@TotalAnggaranEselon3');

	//ESELON 4 , KASUBID

	Route::post('remove_esl4_kegiatan_from_pk','API\PerjanjianKinerjaAPIController@RemoveEsl4KegiatanFromPK');
	Route::post('add_esl4_kegiatan_to_pk','API\PerjanjianKinerjaAPIController@AddEsl4KegiatanToPK');

	Route::get('eselon4-pk_sasaran_strategis','API\PerjanjianKinerjaAPIController@SasaranStrategisEselon4');
	Route::get('eselon4-pk_program','API\PerjanjianKinerjaAPIController@ProgramEselon4');
	Route::get('eselon4-total_anggaran_pk','API\PerjanjianKinerjaAPIController@TotalAnggaranEselon4');


	Route::post('add_sasaran_to_pk','API\PerjanjianKinerjaAPIController@AddSasaranToPK');
	Route::post('remove_sasaran_from_pk','API\PerjanjianKinerjaAPIController@RemoveSasaranFromPK');

	Route::post('add_ind_program_to_pk','API\PerjanjianKinerjaAPIController@AddIndProgramToPK');
	Route::post('remove_ind_program_from_pk','API\PerjanjianKinerjaAPIController@RemoveIndProgramFromPK');

	//========================================================================================================//
	//====================== SKP TAHUNAN SKPD =========================================================//
	//========================================================================================================//

	Route::get('skpd_skp_tahunan_list','API\SKPTahunanAPIController@SKPDSKPTahunanList');
	Route::get('administrator_skp_tahunan_list','API\SKPTahunanAPIController@AdminSKPTahunanList');
	Route::get('skp_tahunan_timeline_status','API\SKPTahunanAPIController@SKPTahunanTimelineStatus');
	Route::get('skp_tahunan_general_timeline','API\SKPTahunanAPIController@SKPTahunanGeneralTimeline');


	//========================================================================================================//
	//====================== SKP BULANAN SKPD =========================================================//
	//========================================================================================================//

	Route::get('skpd_skp_bulanan_list','API\SKPBulananAPIController@SKPDSKPBulanan_list');
	Route::get('skp_bulanan_tree1','API\SKPBulananAPIController@skp_bulanan_tree1');
	Route::get('skp_bulanan_tree2','API\SKPBulananAPIController@skp_bulanan_tree2');
	Route::get('skp_bulanan_tree3','API\SKPBulananAPIController@skp_bulanan_tree3');
	Route::get('skp_bulanan_tree4','API\SKPBulananAPIController@skp_bulanan_tree4');
	Route::get('skp_bulanan_tree5','API\SKPBulananAPIController@skp_bulanan_tree5');
	Route::get('skp_bulanan_timeline_status','API\SKPBulananAPIController@SKPbulanan_timeline_status');

	//========================================================================================================//
	//======================================      M   I   S   I     =======================================//
	//========================================================================================================//

	Route::get('misi_select2','API\MisiAPIController@MisiSelect2');








	//UPDATE KEBUTUHAN UNTUK MENGHILANGKAN INDIKATOR
	Route::get('new_update_sasaran','API\UpdateAPIController@Sasaran');
	Route::get('new_update_program','API\UpdateAPIController@Program');
	Route::get('new_update_kegiatan','API\UpdateAPIController@Kegiatan');

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

	Route::get('sasaran_list_skp_JFT','API\SasaranAPIController@SasaranListJFTSelect2');

	
	
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
	Route::get('skpd-renja_kegiatan_non_anggaran_list','API\KegiatanAPIController@KegiatanNonAnggaranList');

	Route::get('pohon_kinerja-kegiatan_tree','API\KegiatanAPIController@PohonKinerjaKegiatanTree');
	Route::get('pohon_kinerja-kegiatan_list','API\KegiatanAPIController@PohonKinerjaKegiatanKegiatanList');
	Route::get('pohon_kinerja-kegiatan_non_anggaran_list','API\KegiatanAPIController@PohonKinerjaKegiatanKegiatanNonAnggaranList');


	Route::get('kegiatan_detail','API\KegiatanAPIController@KegiatanDetail');
	Route::get('kegiatan_renja_detail','API\KegiatanAPIController@KegiatanDetail');

	Route::post('simpan_kegiatan','API\KegiatanAPIController@Store');
	Route::post('update_kegiatan','API\KegiatanAPIController@Update');
	Route::post('hapus_kegiatan','API\KegiatanAPIController@Hapus');
	





	//Route::post('kegiatan_store','API\KegiatanAPIController@Store');
	//Route::post('kegiatan_rename','API\KegiatanAPIController@Rename');
	//Route::get('kegiatan_renja_detail','API\KegiatanAPIController@KegiatanDetail');




	
	
	Route::get('renja_kegiatan_list','API\KegiatanAPIController@RenjaKegiatanList');
	Route::post('add_kegiatan_to_pejabat','API\KegiatanAPIController@AddKegiatanToPejabat');


	//========================================================================================================//
	//======================================  I N D I K A T O R    K E G I A T A N    ========================//
	//========================================================================================================//
 
	Route::get('skpd-renja_ind_kegiatan_list','API\IndikatorKegiatanAPIController@IndikatorKegiatanList');
	Route::get('ind_kegiatan_detail','API\IndikatorKegiatanAPIController@IndikatorKegiatanDetail');
	
	Route::get('select2_indikator_kegiatan_list','API\IndikatorKegiatanAPIController@Select2IndikatorKegiatanList');
	

	Route::post('simpan_ind_kegiatan','API\IndikatorKegiatanAPIController@Store');
	Route::post('update_ind_kegiatan','API\IndikatorKegiatanAPIController@Update');
	Route::post('hapus_ind_kegiatan','API\IndikatorKegiatanAPIController@Hapus');


	//========================================================================================================//
	//============================= D I S T R I B U S I    K E G I A T A N    ========================//
	//========================================================================================================//


	Route::get('skpd_renja_distribusi_kegiatan_tree','API\KegiatanAPIController@RenjaDistribusiKegiatanTree');
	Route::get('skpd_renja_distribusi_kegiatan_tree_','API\KegiatanAPIController@RenjaDistribusiKegiatanTree_');

	//Kegiatan SEKDA
	Route::get('skp_tahunan_kegiatan_sekda','API\KegiatanAPIController@SKPTahunanKegiatanTreeSekda');


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
	Route::get('skp_tahunan_kegiatan_4','API\KegiatanAPIController@SKPTahunanKegiatanTree4');

	//KEgiatan JFT
	//Route::get('skpd-renja_kegiatan_list_jft','API\KegiatanAPIController@RenjaKegiatanJFT');
	Route::get('skp_tahunan_kegiatan_5','API\KegiatanAPIController@SKPTahunanKegiatanTree5');

	//UNLINK KEGFIATAN
	
	Route::post('hapus_kegiatan_kasubid','API\KegiatanAPIController@RemoveKegiatanFromPejabat');

		

/* 


	Route::get('breadcrumb-perjanjian_kinerja','API\PerjanjianKinerjaAPIController@SKPDPerjanjianKinerjaBreadcrumb');
	
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
	//==================================  SKP JABATAN    =================================================//
	//========================================================================================================//
	Route::get('personal_skp_jabatan_list','API\SKPTahunanAPIController@PersonalSKPJabatanList');



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

	//SEKDA
	Route::get('kegiatan_tahunan_sekda','API\KegiatanSKPTahunanAPIController@KegiatanTahunanSekda');


	//KABAN
	Route::get('kegiatan_tahunan_1','API\KegiatanSKPTahunanAPIController@KegiatanTahunan1');

	//kegiatan_KABID
	Route::get('kegiatan_tahunan_2','API\KegiatanSKPTahunanAPIController@KegiatanTahunan2');

	//kegiatan KASUBID
	Route::get('kegiatan_tahunan_3','API\KegiatanSKPTahunanAPIController@KegiatanTahunan3');


	//kegiatan PELAKSANA
	Route::get('kegiatan_tahunan_4','API\KegiatanSKPTahunanAPIController@KegiatanTahunan4');

	//kegiatan JFT
	Route::get('kegiatan_tahunan_5','API\KegiatanSKPTahunanJFTAPIController@KegiatanTahunan5');
	

	Route::post('simpan_kegiatan_tahunan','API\KegiatanSKPTahunanAPIController@Store');
	Route::post('update_kegiatan_tahunan','API\KegiatanSKPTahunanAPIController@Update');
	Route::post('hapus_kegiatan_tahunan','API\KegiatanSKPTahunanAPIController@Hapus');

	
	

	Route::get('skp_tahunan_kegiatan_tugas_jabatan','API\KegiatanSKPTahunanAPIController@KegiatanTugasJabatanList');


	//========================================================================================================//
	//====================================== KEGIATAN THAUNAN JFT ================================================//
	//========================================================================================================//

	Route::get('kegiatan_tahunan_detail_jft','API\KegiatanSKPTahunanJFTAPIController@KegiatanTahunanDetail');
	Route::get('kegiatan_tahunan_list_JFT','API\KegiatanSKPTahunanJFTAPIController@KegiatanTahunanListelect2');


	

	Route::post('simpan_kegiatan_tahunan_jft','API\KegiatanSKPTahunanJFTAPIController@Store');
	
	Route::post('update_kegiatan_tahunan_jft','API\KegiatanSKPTahunanJFTAPIController@Update');
	Route::post('hapus_kegiatan_tahunan_jft','API\KegiatanSKPTahunanJFTAPIController@Hapus');


	//========================================================================================================//
	//============================== =======       SKP BULANAN ================================================//
	//========================================================================================================//
	Route::get('skp_bulanan_list_1','API\SKPBulananAPIController@SKPBulananList1');
	Route::get('skp_bulanan_list_2','API\SKPBulananAPIController@SKPBulananList2');
	Route::get('skp_bulanan_list_3','API\SKPBulananAPIController@SKPBulananList3');
	Route::get('skp_bulanan_list_4','API\SKPBulananAPIController@SKPBulananList4');
	Route::get('skp_bulanan_list_5','API\SKPBulananAPIController@SKPBulananList5');

	

	Route::get('personal_skp_bulanan_list','API\SKPBulananAPIController@PersonalSKPBulananList');


	

	Route::post('create_skp_bulanan','API\SKPBulananAPIController@Store');
	Route::get('skp_bulanan_detail','API\SKPBulananAPIController@SKPBulanandDetail');
	Route::post('hapus_skp_bulanan','API\SKPBulananAPIController@Destroy');


	//========================================================================================================//
	//============================== KEGIATAN TUGAS JABATAN SKP BULANAN ======================================//
	//========================================================================================================//
	Route::get('skp_bulanan_kegiatan_tugas_jabatan','API\KegiatanSKPBulananAPIController@kegiatan_tugas_jabatan_list');
	Route::get('kegiatan_bulanan_1','API\KegiatanSKPBulananAPIController@KegiatanBulanan1');
	Route::get('kegiatan_bulanan_2','API\KegiatanSKPBulananAPIController@KegiatanBulanan2');
	Route::get('kegiatan_bulanan_3','API\KegiatanSKPBulananAPIController@KegiatanBulanan3');
	Route::get('kegiatan_bulanan_4','API\KegiatanSKPBulananAPIController@KegiatanBulanan4');

	

	Route::post('simpan_kegiatan_bulanan','API\KegiatanSKPBulananAPIController@Store');
	Route::post('hapus_kegiatan_bulanan','API\KegiatanSKPBulananAPIController@Destroy');

	Route::get('kegiatan_bulanan_detail','API\KegiatanSKPBulananAPIController@KegiatanBulananDetail');

	//========================================================================================================//
	//====================================== KEGIATAN BULANAN JFT ================================================//
	//========================================================================================================//
	//kegiatan JFT
	Route::get('kegiatan_bulanan_5','API\KegiatanSKPBulananJFTAPIController@KegiatanBulanan5');
	Route::post('hapus_kegiatan_bulanan_jft','API\KegiatanSKPBulananJFTAPIController@Destroy');
	Route::post('update_kegiatan_bulanan_jft','API\KegiatanSKPBulananJFTAPIController@Update');
	Route::post('simpan_kegiatan_bulanan_jft','API\KegiatanSKPBulananJFTAPIController@Store');
	Route::get('kegiatan_bulanan_detail_jft','API\KegiatanSKPBulananJFTAPIController@KegiatanBulananDetail');
	//========================================================================================================//
	//============================== =======    CAPAIAN BULANAN ================================================//
	//========================================================================================================//
	Route::get('personal_capaian_bulanan_list','API\CapaianBulananAPIController@PersonalCapaianBulananList');
	
	
	Route::get('capaian_bulanan_status_pengisian','API\CapaianBulananAPIController@CapaianBulananStatusPengisian');


	Route::get('approval_request_capaian_bulanan_list','API\CapaianBulananAPIController@ApprovalRequestList');
	
	Route::get('capaian_bulanan_detail','API\CapaianBulananAPIController@CapaianBulananDetail');
	Route::post('set_pejabat_penilai_capaian_bulanan','API\CapaianBulananAPIController@PejabatPenilaiUpdate');

	
	Route::get('create_capaian_bulanan_confirm','API\CapaianBulananAPIController@CreateConfirm');

	Route::post('kirim_capaian_bulanan','API\CapaianBulananAPIController@SendToAtasan');

	Route::post('tolak_capaian_bulanan','API\CapaianBulananAPIController@TolakByAtasan');

	Route::post('terima_capaian_bulanan','API\CapaianBulananAPIController@TerimaByAtasan');

	Route::post('simpan_capaian_bulanan','API\CapaianBulananAPIController@Store');
	Route::post('hapus_capaian_bulanan','API\CapaianBulananAPIController@Destroy');

	//================================== T P P    REPORT =====================================================//

	Route::get('create_tpp_report_confirm','API\TPPReportAPIController@CreateConfirm');

	Route::get('tpp_report_detail','API\TPPReportAPIController@TPPReportDetail');

	Route::post('simpan_tpp_report','API\TPPReportAPIController@Store');
	Route::post('close_tpp_report','API\TPPReportAPIController@TPPClose');
	
	//Route::post('cetak_tpp_report','API\TPPReportAPIController@cetakTPPReportData');
	

	
	Route::post('hapus_tpp_report','API\TPPReportAPIController@Destroy');

	Route::get('skpd_tpp_report_list','API\TPPReportAPIController@SKPDTTPReportList');



	Route::get('administrator_tpp_report_list','API\TPPReportAPIController@AdministratorTPPList');
	Route::get('administrator_tpp_report','API\TPPReportAPIController@AdministratorTPPList');

	Route::get('cetak_tpp_periode_list','API\TPPReportAPIController@Select2CetakPeriodeList');
	Route::get('cetak_tpp_periode_bulan_list','API\TPPReportAPIController@Select2CetakPeriodeBulanList');
	Route::get('cetak_tpp_skpd_list','API\TPPReportAPIController@Select2CetakSKPDList');
	Route::get('cetak_tpp_unit_kerja_list','API\TPPReportAPIController@Select2CetakUnitKerjaList');
	
	Route::get('administrator_tpp_report_data_list','API\TPPReportAPIController@TPPReportDataList');
	
	
	Route::get('skpd_tpp_report_data_list','API\TPPReportAPIController@TPPReportDataList');


	//============================= TPP REPORT DATA =====================================================//
	
	Route::get('tpp_report_data_detail','API\TPPReportAPIController@TPPReportDataDetail');
	Route::get('tpp_report_data_edit','API\TPPReportAPIController@TPPReportDataEdit');

	Route::post('tpp_report_data_update','API\TPPReportAPIController@TPPReportDataUpdate');

	//========================================================================================================//
	//============================== =======    CAPAIAN TRIWULAN ================================================//
	//========================================================================================================//
	
	Route::get('capaian_triwulan_create_confirm','API\CapaianTriwulanAPIController@CreateConfirm');
	
	Route::get('personal_capaian_triwulan_list','API\CapaianTriwulanAPIController@PersonalCapaianTriwulanList');
	
	Route::post('simpan_capaian_triwulan','API\CapaianTriwulanAPIController@Store');

	Route::get('ganti_atasan_capaian_triwulan','API\PegawaiAPIController@selectAtasanCapaianTriwulan');
	Route::post('set_pejabat_penilai_capaian_triwulan','API\CapaianTriwulanAPIController@PejabatPenilaiUpdate');

	Route::get('capaian_triwulan_status_pengisian','API\CapaianTriwulanAPIController@CapaianTriwulanStatusPengisian');


	Route::get('capaian_triwulan_detail','API\CapaianTriwulanAPIController@CapaianTriwulanDetail');

	Route::post('hapus_capaian_triwulan','API\CapaianTriwulanAPIController@Destroy');

	Route::post('tutup_capaian_triwulan','API\CapaianTriwulanAPIController@Close');


	
	//========================================================================================================//
	//============================== =======    CAPAIAN TAHUNAN ================================================//
	//========================================================================================================//
	Route::get('personal_capaian_tahunan_list','API\CapaianTahunanAPIController@PersonalCapaianTahunanList');
	
	Route::get('create_capaian_tahunan_confirm','API\CapaianTahunanAPIController@CreateConfirm');
	Route::get('ganti_atasan_capaian_tahunan','API\PegawaiAPIController@selectAtasanCapaianTahunan');
	Route::post('set_pejabat_penilai_capaian_tahunan','API\CapaianTahunanAPIController@PejabatPenilaiUpdate');

	Route::get('capaian_tahunan_status','API\CapaianTahunanAPIController@CapaianTahunanStatus');
	
	Route::get('capaian_tahunan_detail','API\CapaianTahunanAPIController@CapaianTahunanDetail');

	Route::get('approval_request_capaian_tahunan_list','API\CapaianTahunanAPIController@ApprovalRequestList');

	Route::post('kirim_capaian_tahunan','API\CapaianTahunanAPIController@SendToAtasan');
	Route::post('tolak_capaian_tahunan','API\CapaianTahunanAPIController@TolakByAtasan');
	Route::post('terima_capaian_tahunan','API\CapaianTahunanAPIController@TerimaByAtasan');

	Route::post('simpan_capaian_tahunan','API\CapaianTahunanAPIController@Store');
	Route::post('hapus_capaian_tahunan','API\CapaianTahunanAPIController@Destroy');


	//==================================== REALISASI TRIWULAN KEGIATAN TAHUNAN =============================================//
	//=============================================================================================================//
	Route::get('realisasi_kegiatan_triwulan','API\RealisasiKegiatanTriwulanAPIController@RealisasiKegiatanTriwulan');
	
	Route::get('add_realisasi_kegiatan_triwulan','API\RealisasiKegiatanTriwulanAPIController@AddRealisasiKegiatanTriwulan');
	
	Route::post('simpan_realisasi_kegiatan_triwulan','API\RealisasiKegiatanTriwulanAPIController@Store');
	Route::post('update_realisasi_kegiatan_triwulan','API\RealisasiKegiatanTriwulanAPIController@Update');
	Route::post('hapus_realisasi_kegiatan_triwulan','API\RealisasiKegiatanTriwulanAPIController@Destroy');

	//==================================== REALISASI TRIWULAN KEGIATAN TAHUNAN JFT =============================================//
	//=============================================================================================================//
	Route::get('add_realisasi_kegiatan_triwulan_jft','API\RealisasiKegiatanTriwulanAPIController@AddRealisasiKegiatanTriwulanJFT');

	Route::post('simpan_realisasi_kegiatan_triwulan_jft','API\RealisasiKegiatanTriwulanAPIController@StoreJFT');
	Route::post('update_realisasi_kegiatan_triwulan_jft','API\RealisasiKegiatanTriwulanAPIController@UpdateJFT');
	Route::post('hapus_realisasi_kegiatan_triwulan_jft','API\RealisasiKegiatanTriwulanAPIController@DestroyJFT');


	//===================== REALISASI  KEGIATAN TUGAS JABATAN SKP BULANAN ======================================//
	//========================================================================================================//
	Route::get('realisasi_kegiatan_bulanan_1','API\RealisasiKegiatanBulananAPIController@RealisasiKegiatanBulanan1');
	Route::get('realisasi_kegiatan_bulanan_2','API\RealisasiKegiatanBulananAPIController@RealisasiKegiatanBulanan2');
	Route::get('realisasi_kegiatan_bulanan_3','API\RealisasiKegiatanBulananAPIController@RealisasiKegiatanBulanan3');
	Route::get('realisasi_kegiatan_bulanan_4','API\RealisasiKegiatanBulananAPIController@RealisasiKegiatanBulanan4');
	Route::get('realisasi_kegiatan_bulanan_5','API\RealisasiKegiatanBulananAPIController@RealisasiKegiatanBulanan5');

	Route::get('realisasi_kegiatan_bulanan_detail','API\RealisasiKegiatanBulananAPIController@RealisasiKegiatanBulananDetail');

	Route::post('hapus_realisasi_kegiatan_bulanan','API\RealisasiKegiatanBulananAPIController@Destroy');
	Route::post('simpan_realisasi_kegiatan_bulanan','API\RealisasiKegiatanBulananAPIController@Store');
	Route::post('update_realisasi_kegiatan_bulanan','API\RealisasiKegiatanBulananAPIController@Update');


	//===================== REALISASI  KEGIATAN BULANAN  JFT ======================================//
	//========================================================================================================//

	Route::get('realisasi_kegiatan_bulanan_detail_jft','API\RealisasiKegiatanBulananAPIController@RealisasiKegiatanBulananDetailJFT');

	Route::post('hapus_realisasi_kegiatan_bulanan_jft','API\RealisasiKegiatanBulananAPIController@DestroyJFT');
	Route::post('simpan_realisasi_kegiatan_bulanan_jft','API\RealisasiKegiatanBulananAPIController@StoreJFT');
	Route::post('update_realisasi_kegiatan_bulanan_jft','API\RealisasiKegiatanBulananAPIController@UpdateJFT');


	//===================== REALISASI  RENCANA AKSI KASUBID    ======================================//
	//========================================================================================================//
	
	Route::get('realisasi_rencana_aksi_detail_3','API\RealisasiRencanaAksiKasubidAPIController@RealisasiRencanaAksiDetail');

	

	Route::post('hapus_realisasi_rencana_aksi_3','API\RealisasiRencanaAksiKasubidAPIController@Destroy');
	Route::post('simpan_realisasi_rencana_aksi_3','API\RealisasiRencanaAksiKasubidAPIController@Store');
	Route::post('update_realisasi_rencana_aksi_3','API\RealisasiRencanaAksiKasubidAPIController@Update');



	//===================== REALISASI  RENCANA AKSI KABID   ======================================//
	//========================================================================================================//
	
	Route::get('realisasi_rencana_aksi_detail_2','API\RealisasiRencanaAksiKabidAPIController@RealisasiRencanaAksiDetail');


	Route::post('hapus_realisasi_rencana_aksi_2','API\RealisasiRencanaAksiKabidAPIController@Destroy');
	Route::post('simpan_realisasi_rencana_aksi_2','API\RealisasiRencanaAksiKabidAPIController@Store');
	Route::post('update_realisasi_rencana_aksi_2','API\RealisasiRencanaAksiKabidAPIController@Update');


	//===================== REALISASI  RENCANA AKSI KABAN   ======================================//
	//========================================================================================================//
	
	Route::get('realisasi_rencana_aksi_detail_1','API\RealisasiRencanaAksiKabanAPIController@RealisasiRencanaAksiDetail');


	Route::post('hapus_realisasi_rencana_aksi_1','API\RealisasiRencanaAksiKabanAPIController@Destroy');
	Route::post('simpan_realisasi_rencana_aksi_1','API\RealisasiRencanaAksiKabanAPIController@Store');
	Route::post('update_realisasi_rencana_aksi_1','API\RealisasiRencanaAksiKabanAPIController@Update');




	//=====================          REALISASI   KEGIATAN TAHUNAN      = =====================================//
	//========================================================================================================//
	
	Route::get('realisasi_kegiatan_tahunan','API\RealisasiKegiatanTahunanAPIController@RealisasiKegiatanTahunan');

	Route::get('realisasi_kegiatan_tahunan_5','API\RealisasiKegiatanTahunanAPIController@RealisasiKegiatanTahunan5');

	Route::get('add_realisasi_kegiatan_tahunan','API\RealisasiKegiatanTahunanAPIController@AddRealisasiKegiatanTahunan');

	Route::get('add_realisasi_kegiatan_tahunan_5','API\RealisasiKegiatanTahunanAPIController@AddRealisasiKegiatanTahunan5');
	
	Route::post('simpan_realisasi_kegiatan_tahunan','API\RealisasiKegiatanTahunanAPIController@Store');
	Route::post('update_realisasi_kegiatan_tahunan','API\RealisasiKegiatanTahunanAPIController@Update');
	Route::post('hapus_realisasi_kegiatan_tahunan','API\RealisasiKegiatanTahunanAPIController@Destroy');

	Route::post('simpan_realisasi_kegiatan_tahunan_5','API\RealisasiKegiatanTahunanAPIController@Store5');
	Route::post('update_realisasi_kegiatan_tahunan_5','API\RealisasiKegiatanTahunanAPIController@Update5');
	Route::post('hapus_realisasi_kegiatan_tahunan_5','API\RealisasiKegiatanTahunanAPIController@Destroy5');


	//=====================        PENILAIAN KUALITAS KERJA      = =====================================//
	//========================================================================================================//
	
	Route::get('penilaian_kualitas_kerja_detail','API\RealisasiKegiatanTahunanAPIController@PenilaianKualitasKerja');
	Route::post('simpan_penilaian_kualitas_kerja','API\RealisasiKegiatanTahunanAPIController@UpdateKualitasKerja');
	Route::post('simpan_penilaian_kualitas_kerja_5','API\RealisasiKegiatanTahunanAPIController@UpdateKualitasKerja5');

	//=====================        PENILAIAN PERILAKU KERJA      = =====================================//
	//========================================================================================================//
	
	Route::get('detail_penilaian_perilaku_kerja','API\PerilakuKerjaAPIController@PenilaianPerilakuKerjaDetail');
	Route::get('penilaian_perilaku_kerja','API\PerilakuKerjaAPIController@PenilaianPerilakuKerja');
	Route::post('simpan_penilaian_perilaku_kerja','API\PerilakuKerjaAPIController@Store');
	Route::post('update_penilaian_perilaku_kerja','API\PerilakuKerjaAPIController@Update');
	Route::post('hapus_penilaian_perilaku_kerja','API\PerilakuKerjaAPIController@Hapus');
	

	//=================================         TUGAS TAMBAHAN     = =====================================//
	//=====================================================================================================//
	Route::get('tugas_tambahan_list','API\TugasTambahanAPIController@TugasTambahanList');
	Route::get('tugas_tambahan_detail','API\TugasTambahanAPIController@Detail');
	
	Route::post('simpan_tugas_tambahan','API\TugasTambahanAPIController@Store');
	Route::post('update_tugas_tambahan','API\TugasTambahanAPIController@Update');
	Route::post('hapus_tugas_tambahan','API\TugasTambahanAPIController@Destroy');

	//=================================         K R E A T I V I T A S     = ==================================//
	//========================================================================================================//
	Route::get('kreativitas_list','API\KreativitasAPIController@KreativitasList');
	Route::get('kreativitas_detail','API\KreativitasAPIController@Detail');
	
	Route::post('simpan_kreativitas','API\KreativitasAPIController@Store');
	Route::post('update_kreativitas','API\KreativitasAPIController@Update');
	Route::post('hapus_kreativitas','API\KreativitasAPIController@Destroy');

	//========================================================================================================//
	//======================================= RENCANA AKSI  SKP THAUNAN ======================================//
	//========================================================================================================//
	Route::get('rencana_aksi_tree','API\RencanaAksiAPIController@rencana_aksi_tree');
	Route::get('skp_tahunan_rencana_aksi','API\RencanaAksiAPIController@RencanaAksiList');
	Route::get('skp_tahunan_rencana_aksi_3','API\RencanaAksiAPIController@RencanaAksiList3');
	Route::get('skp_tahunan_rencana_aksi_4','API\RencanaAksiAPIController@RencanaAksiList4');
	
	Route::get('rencana_aksi_time_table_2','API\RencanaAksiAPIController@RencanaAksiTimeTable2');
	Route::get('rencana_aksi_time_table_3','API\RencanaAksiAPIController@RencanaAksiTimeTable3');
	Route::get('rencana_aksi_time_table_4','API\RencanaAksiAPIController@RencanaAksiTimeTable4');

	Route::get('rencana_aksi_detail','API\RencanaAksiAPIController@RencanaAksiDetail3');

	Route::get('rencana_aksi_detail_1','API\RencanaAksiAPIController@RencanaAksiDetail1');
	Route::get('rencana_aksi_detail_2','API\RencanaAksiAPIController@RencanaAksiDetail2');
	Route::get('rencana_aksi_detail_3','API\RencanaAksiAPIController@RencanaAksiDetail3');
	Route::get('rencana_aksi_detail_4','API\RencanaAksiAPIController@RencanaAksiDetail4');

	Route::post('simpan_rencana_aksi','API\RencanaAksiAPIController@Store');
	Route::post('update_rencana_aksi','API\RencanaAksiAPIController@Update');
	Route::post('hapus_rencana_aksi','API\RencanaAksiAPIController@Hapus');

	//========================================================================================================//
	//======================================= RENCANA AKSI  RENJA      ======================================//
	//========================================================================================================//
	
	Route::get('renja_rencana_aksi','API\RencanaAksiAPIController@RenjaRencanaAksiList');
	Route::get('kegiatan_rencana_aksi','API\RencanaAksiAPIController@KegiatanRencanaAksiList');
	
	
	


	//========================================================================================================//
	//======================================= PENILAIAN KODE ETIK =====================================//
	//========================================================================================================//

	Route::get('detail_penilaian_kode_etik','API\PenilaianKodeEtikAPIController@DetailPenilaianKodeEtik');

	
	Route::post('simpan_penilaian_kode_etik','API\PenilaianKodeEtikAPIController@Store');
	Route::post('update_penilaian_kode_etik','API\PenilaianKodeEtikAPIController@Update');

	//========================================================================================================//
	//==================================  P E G A W A I =================================================//
	//========================================================================================================//
	Route::get('administrator_pegawai_list','API\PegawaiAPIController@administrator_pegawai_list');
	Route::get('skpd_pegawai_list','API\PegawaiAPIController@skpd_pegawai_list');
	
	
	Route::get('select_pegawai_list','API\PegawaiAPIController@select_pejabat_penilai_list');
	Route::get('select_ka_skpd_list','API\PegawaiAPIController@select_ka_skpd_list');

	Route::get('pegawai_list','API\PegawaiAPIController@select_pegawai_list');

	Route::get('ganti_atasan_capaian_bulanan','API\PegawaiAPIController@selectAtasanCapaianBulanan');


	

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


	//========================================================================================================//
	//==================================  ADMIN SKPD USER ROLE  ==============================================//
	//========================================================================================================//
	Route::post('add_admin_skpd','API\RoleUserAPIController@AddAdminSKPD');
	Route::post('remove_admin_skpd','API\RoleUserAPIController@RemoveAdminSKPD');




	//========================================================================================================//
	//==================================  B A N T U A N     ==============================================//
	//========================================================================================================//
	Route::get('bantuan_detail','API\BantuanAPIController@Detail');
	


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
	Route::get('admin/', [
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
	]);

	Route::get('admin/pohon_kinerja', [
		'as' 			=> 'admin-pohon_kinerja',
		'uses' 			=> 'HomeAdminController@showPohonKinerja'
	]);

	Route::get('admin/skp_tahunan', [
		'as' 			=> 'admin-skp_tahunan',
		'uses' 			=> 'HomeAdminController@showSKPTahunan'
	]);

	Route::get('admin/tpp_report', [
		'as' 			=> 'admin-tpp_report',
		'uses' 			=> 'HomeAdminController@showTPPReport'
	]);


	Route::get('admin/update_table', [
		'as' 			=> '',
		'uses' 			=> 'HomeAdminController@UpdateTable'
	]);


	//========================================================================================//
	//================================ T P P    REPORT              ===========================//
	//========================================================================================//

	


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
	]);

	
 

	//----------------------------------------------------------------------------------------//
	//============================ MASA PEMERINTAHAN ======== ================================//
	//----------------------------------------------------------------------------------------//
	Route::get('admin/masa_pemerintahan/{masa_pemerintahan_id}',[
		'as' 			=> '',
		'uses' 			=> 'MasaPemerintahanController@showMasaPemerintahan'
	]);

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
	Route::get('admin/skp_tahunan/{skp_tahunan_id}',[
		'as' 			=> '',
		'uses' 			=> 'SKPTahunanController@AdministratorSKPTahunanDetail'
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
	//============================= PEGAWAI      S K P D  ========================================//
	//============================================================================================//
	

	Route::get('admin/skpd/{skpd_id}', [
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
		'as' 			=> '',
		'uses' 			=> 'HomeSKPDController@showSKPBulanan'
	]);

	Route::get('tpp_report', [
		'as' 			=> 'skpd-tpp_report',
		'uses' 			=> 'HomeSKPDController@showSKPDTPPReport'
	]);

	//=======================   TPP R E P O R T   ==================================//
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
	]);

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


	
	//=========================== P E G A W A I  =============================================//
	Route::get('pegawai/{pegawai_id}', [
		'as' 			=> '{username}',
		'uses' 			=> 'PegawaiController@detailPegawai'
	]);

	Route::get('pegawai/{pegawai_id}/add', [
		'as' 			=> '{username}',
		'uses' 			=> 'PegawaiController@addPegawai'
	]);



	//----------------------------------------------------------------------------------------//
	//======================== RENCANA KERJA PERANGKAT DAERAH ================================//
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
	 
	
	//----------------------------------------------------------------------------------------//
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

	


});



//===============================================================================================================//
//=============== PERSONAL ACCESS LEVEL PAGE ROUTES - RUNNING THROUGH PERSONAL MIDDLEWARE ====================//
//===============================================================================================================//

Route::group(['prefix' => 'personal','middleware' => 'personal'], function () {

	Route::get('', [
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

	Route::get('capaian_bulanan_approval-request', [
		'as' 			=> 'personal-capaian_bulanan_approvement',
		'uses' 			=> 'CapaianBulananController@CapaianBulananApprovalRequestList'
	]);

	Route::get('capaian_bulanan_approval-request/{capaian_bulanan_id}', [
		'as' 			=> '',
		'uses' 			=> 'CapaianBulananController@CapaianBulananApprovalRequest'
	]); 


	Route::get('capaian_tahunan_approval-request', [
		'as' 			=> 'personal-capaian_tahunan_approvement',
		'uses' 			=> 'CapaianTahunanController@CapaianTahunanApprovalRequestList'
	]);

	Route::get('capaian_tahunan_approval-request/{capaian_tahunan_id}', [
		'as' 			=> '',
		'uses' 			=> 'CapaianTahunanController@CapaianTahunanApprovalRequest'
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
		'as' 			=> '',
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