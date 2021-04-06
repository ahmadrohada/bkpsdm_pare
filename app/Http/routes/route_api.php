<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
*/

//===================== AJAX REQUEST CONTROLLER =================//
Route::group(['prefix' => 'pare_api','middleware'=> 'auth.api:tes' ], function () {

	Route::get('tpp-report','PARE_API\TPPReportController@TTPReport');

	Route::get('history-jabatan','PARE_API\CekHistoryJabatanController@HistoryJabatan');

});


Route::group(['prefix' => 'api'], function () {

	Route::get('unauth_capaian_pk_list','API\CapaianPKTriwulanAPIController@UnAuthAdministratorCapaianPKTriwulanList');


});


Route::group(['prefix' => 'api'/* ,'middleware'=> 'auth' */ ], function () {

	//========================= PERIODE ======================================================================//
	Route::resource('periode_tahunan','API\PeriodeAPIController');
	Route::get('periode_list_select2','API\PeriodeAPIController@PeriodeListSelect2');

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
	//=======================================   P U S K E S M A S     ========================================//
	//========================================================================================================//
	
	Route::get('administrator_puskesmas_list','API\PuskesmasAPIController@AdministratorPuskesmasList');


	
	//========================================================================================================//
	//===========================================     MASA PEMERINTAHAN          =============================//
	//========================================================================================================//
	
	Route::get('administrator_masa_pemerintahan_list','API\MasaPemerintahanAPIController@AdministratorMasaPemerintahanList');
	Route::get('administrator_masa_pemerintahan_tree','API\MasaPemerintahanAPIController@AdministratorMasaPemerintahanTree');
	



	//=============================== POHON KINERJA ==========================================================//
	Route::get('skpd_pohon_kinerja','API\PohonKinerjaAPIController@PohonKinerjaTree');
	//Route::get('skpd_pohon_kinerja_2021','API\PohonKinerjaAPIController_2021@PohonKinerjaTree');
	

	//========================================================================================================//
	//==============================      RENCANA  KERJA  PERANGKAT  DAERAH      =============================//
	//========================================================================================================//
	
	Route::get('skpd_renja_list','API\RenjaAPIController@SKPDRenjaList');
	Route::get('administrator_pohon_kinerja_list','API\RenjaAPIController@AdministratorPohonKinerjaList');

	Route::get('create_renja_confirm','API\RenjaAPIController@ConfirmRenja');
	Route::post('set_kepala_skpd_renja','API\RenjaAPIController@KepalaSKPDUpdate');
	
	Route::get('renja_timeline_status','API\RenjaAPIController@RenjaTimelineStatus');
	Route::get('renja_status_pengisian','API\RenjaAPIController@RenjaStatusPengisian');
	Route::get('renja_detail','API\RenjaAPIController@RenjaDetail');

	

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



	
	Route::post('remove_esl2_subkegiatan_from_pk','API\PerjanjianKinerjaAPIController@RemoveEsl2SubKegiatanFromPK');
	Route::post('add_esl2_subkegiatan_to_pk','API\PerjanjianKinerjaAPIController@AddEsl2SubKegiatanToPK');
	Route::get('eselon2_subkegiatan_list','API\PerjanjianKinerjaAPIController@SubKegiatanListSKPD');
	Route::get('eselon2-total_anggaran_subkegiatan','API\PerjanjianKinerjaAPIController@TotalAnggaranSubKegiatanSKPD');
	


	//ESELON 3 , KABID
	Route::post('remove_esl3_subkegiatan_from_pk','API\PerjanjianKinerjaAPIController@RemoveEsl3SubKegiatanFromPK');
	Route::post('add_esl3_subkegiatan_to_pk','API\PerjanjianKinerjaAPIController@AddEsl3SubKegiatanToPK');


	Route::get('eselon3-pk_sasaran_strategis','API\PerjanjianKinerjaAPIController@SasaranStrategisEselon3');
	Route::get('eselon3-pk_program','API\PerjanjianKinerjaAPIController@ProgramEselon3');
	Route::get('eselon3-total_anggaran_pk','API\PerjanjianKinerjaAPIController@TotalAnggaranEselon3');

	//ESELON 4 , KASUBID

	Route::post('remove_esl4_subkegiatan_from_pk','API\PerjanjianKinerjaAPIController@RemoveEsl4SubKegiatanFromPK');
	Route::post('add_esl4_subkegiatan_to_pk','API\PerjanjianKinerjaAPIController@AddEsl4SubKegiatanToPK');

	Route::get('eselon4-pk_sasaran_strategis','API\PerjanjianKinerjaAPIController@SasaranStrategisEselon4');
	Route::get('eselon4-pk_program','API\PerjanjianKinerjaAPIController@ProgramEselon4');
	Route::get('eselon4-total_anggaran_pk','API\PerjanjianKinerjaAPIController@TotalAnggaranEselon4');


	Route::post('add_sasaran_to_pk','API\PerjanjianKinerjaAPIController@AddSasaranToPK');
	Route::post('remove_sasaran_from_pk','API\PerjanjianKinerjaAPIController@RemoveSasaranFromPK');

	Route::post('add_ind_program_to_pk','API\PerjanjianKinerjaAPIController@AddIndProgramToPK');
	Route::post('remove_ind_program_from_pk','API\PerjanjianKinerjaAPIController@RemoveIndProgramFromPK');





	//========================================================================================================//
	//================================ KONTRAK KINERJA JFU JFT  =============================================//
	//========================================================================================================//

	
	//JFU
	Route::get('jfu-kk_sasaran_strategis','API\KontrakKinerjaAPIController@SasaranStrategisJFU');
	Route::get('jfu-kk_anggaran_kegiatan','API\KontrakKinerjaAPIController@AnggaranKegiatanJFU');
	Route::get('jfu-total_anggaran_kk','API\KontrakKinerjaAPIController@TotalAnggaranKegiatanJFU');

	//JFT
	Route::get('jft-kk_sasaran_strategis','API\KontrakKinerjaAPIController@SasaranStrategisJFT');
	Route::get('jft-kk_anggaran_kegiatan','API\KontrakKinerjaAPIController@AnggaranKegiatanJFT');
	Route::get('jft-total_anggaran_kk','API\KontrakKinerjaAPIController@TotalAnggaranKegiatanJFT');


	//========================================================================================================//
	//====================== SKP TAHUNAN SKPD =========================================================//
	//========================================================================================================//

	Route::get('skpd_skp_tahunan_list','API\SKPTahunanAPIController@SKPDSKPTahunanList');
	Route::get('puskesmas_skp_tahunan_list','API\SKPTahunanAPIController@PuskesmasSKPTahunanList');
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
	//Route::get('skpd-renja_kegiatan_non_anggaran_list','API\KegiatanAPIController@KegiatanNonAnggaranList');

	
	
	//Route::get('pohon_kinerja-kegiatan_non_anggaran_list','API\KegiatanAPIController@PohonKinerjaKegiatanKegiatanNonAnggaranList');


	Route::get('kegiatan_detail','API\KegiatanAPIController@KegiatanDetail');
	Route::get('kegiatan_renja_detail','API\KegiatanAPIController@KegiatanDetail');

	Route::post('simpan_kegiatan','API\KegiatanAPIController@Store');
	Route::post('update_kegiatan','API\KegiatanAPIController@Update');
	Route::post('hapus_kegiatan','API\KegiatanAPIController@Hapus');
	





	//Route::post('kegiatan_store','API\KegiatanAPIController@Store');
	//Route::post('kegiatan_rename','API\KegiatanAPIController@Rename');
	//Route::get('kegiatan_renja_detail','API\KegiatanAPIController@KegiatanDetail');




	
	
	Route::get('renja_kegiatan_list','API\KegiatanAPIController@RenjaKegiatanList');
	


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
	//======================================      SUB K E G I A T A N      ===================================//
	//=======================================================================================================//

	Route::get('sub_kegiatan_update_data','API\SubKegiatanAPIController@UpdateDataSubKegiatan');
	Route::get('skpd-renja_subkegiatan_list','API\SubKegiatanAPIController@SubKegiatanList');
	Route::get('skpd-renja_subkegiatan_non_anggaran_list','API\SubKegiatanAPIController@SubKegiatanNonAnggaranList');
	Route::get('pohon_kinerja-subkegiatan_non_anggaran_list','API\SubKegiatanAPIController@PohonKinerjaSubKegiatanNonAnggaranList');
	Route::get('subkegiatan_detail','API\SubKegiatanAPIController@SubKegiatanDetail');

	Route::get('pohon_kinerja-subkegiatan_tree','API\SubKegiatanAPIController@PohonKinerjaSubKegiatanTree');
	Route::get('pohon_kinerja-subkegiatan_list','API\SubKegiatanAPIController@PohonKinerjaSubKegiatanList');

	Route::get('renja_subkegiatan_list','API\SubKegiatanAPIController@RenjaSubKegiatanList');

	Route::post('add_subkegiatan_to_pejabat','API\SubKegiatanAPIController@AddSubKegiatanToPejabat');

	Route::post('simpan_subkegiatan','API\SubKegiatanAPIController@Store');
	Route::post('update_subkegiatan','API\SubKegiatanAPIController@Update');
	Route::post('hapus_subkegiatan','API\SubKegiatanAPIController@Hapus');


	//========================================================================================================//
	//===================================   INDIKATOR   SUB K E G I A T A N      =============================//
	//========================================================================================================//
	
	
	Route::get('skpd-renja_ind_subkegiatan_list','API\IndikatorSubKegiatanAPIController@IndikatorSubKegiatanList');
	Route::get('ind_subkegiatan_detail','API\IndikatorSubKegiatanAPIController@IndikatorSubKegiatanDetail');
	

	Route::post('simpan_ind_subkegiatan','API\IndikatorSubKegiatanAPIController@Store');
	Route::post('update_ind_subkegiatan','API\IndikatorSubKegiatanAPIController@Update');
	Route::post('hapus_ind_subkegiatan','API\IndikatorSubKegiatanAPIController@Hapus');
	//========================================================================================================//
	//========================== D I S T R I B U S I   SUB   K E G I A T A N    ===============================//
	// 07012020 yg didistribusikan adalah subKegiatan 
	//========================================================================================================//


	Route::get('skpd_renja_distribusi_subkegiatan_tree','API\SubKegiatanAPIController@RenjaDistribusiSubKegiatanTree');

	//Kegiatan SEKDA
	Route::get('skp_tahunan_subkegiatan_sekda','API\SubKegiatanAPIController@SKPTahunanSubKegiatanTreeSekda');


	//Kegiatan KA SKPD
	Route::get('skpd-renja_subkegiatan_list_kaskpd','API\SubKegiatanAPIController@RenjaSubKegiatanKaSKPD');
	Route::get('skp_tahunan_subkegiatan_1','API\SubKegiatanAPIController@SKPTahunanSubKegiatanTree1');

	//kegiatan KABID
	Route::get('skpd-renja_subkegiatan_list_kabid','API\SubKegiatanAPIController@RenjaSubKegiatanKabid');
	Route::get('skp_tahunan_subkegiatan_2','API\SubKegiatanAPIController@SKPTahunanSubKegiatanTree2');


	//KEgiatan KASUBID
	Route::get('skpd-renja_subkegiatan_list_kasubid','API\SubKegiatanAPIController@RenjaSubKegiatanKasubid');
	Route::get('skp_tahunan_subkegiatan_3','API\SubKegiatanAPIController@SKPTahunanSubKegiatanTree3');

	//KEgiatan PELAKSANA
	Route::get('skp_tahunan_subkegiatan_4','API\SubKegiatanAPIController@SKPTahunanSubKegiatanTree4');

	//KEgiatan JFT
	//Route::get('skpd-renja_kegiatan_list_jft','API\KegiatanAPIController@RenjaKegiatanJFT');
	Route::get('skp_tahunan_subkegiatan_5','API\SubKegiatanAPIController@SKPTahunanSubKegiatanTree5');

	//UNLINK KEGFIATAN
	
	Route::post('hapus_subkegiatan_kasubid','API\SubKegiatanAPIController@RemoveSubKegiatanFromPejabat');

		

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
	Route::get('skp_tahunan_pejabat','API\SKPTahunanAPIController@SKPTahunanPejabat');

	

	//KASUBID
	Route::get('skp_tahunan_status_pengisian3','API\SKPTahunanAPIController@SKPTahunanStatusPengisian3');

	Route::get('personal_cek_status_skp_tahunan','API\SKPTahunanAPIController@SKPTahunanCekStatus');
	
	
	Route::get('skp_bawahan_list_md','API\SKPTahunanAPIController@SKPTahunanBawahanMd');
	
	Route::get('create_skp_tahunan_confirm','API\SKPTahunanAPIController@CreateConfirm');
	Route::get('skp_tahunan_detail','API\SKPTahunanAPIController@SKPTahunandDetail');

	

	Route::post('create_skp_tahunan','API\SKPTahunanAPIController@Store');

	Route::post('skp_tahunan_open','API\SKPTahunanAPIController@SKPOPen');
	Route::post('skp_tahunan_close','API\SKPTahunanAPIController@SKPClose');

	Route::post('update_pejabat_penilai_skp_tahunan','API\SKPTahunanAPIController@PejabatPenilaiUpdate');
	Route::post('update_atasan_pejabat_penilai_skp_tahunan','API\SKPTahunanAPIController@AtasanPejabatPenilaiUpdate');
	

	Route::post('skp_tahunan_send_to_atasan','API\SKPTahunanAPIController@SendToAtasan');
	Route::post('skp_tahunan_pull_from_atasan','API\SKPTahunanAPIController@PullFromAtasan');
	Route::post('hapus_skp_tahunan','API\SKPTahunanAPIController@Destroy');

	Route::get('approval_request_skp_tahunan_list','API\SKPTahunanAPIController@SKPTahunanApprovalRequestList');

	Route::post('skp_tahunan_setuju_by_atasan','API\SKPTahunanAPIController@SetujuByAtasan');
	Route::post('skp_tahunan_tolak_by_atasan','API\SKPTahunanAPIController@TolakByAtasan');

	//========================================================================================================//
	//====================================== KEGIATAN SKP THAUNAN ============================================//
	//========================================================================================================//
	/* Route::get('skp_tahunan_ktj_2','API\KegiatanSKPTahunanAPIController@ktj_2_tree'); // (kabid ) */
	Route::get('update_cost_kegiatan_skp_tahunan','API\KegiatanSKPTahunanAPIController@UpdateCostKegiatanSKPTahunan');
	

	Route::get('subkegiatan_list_kasubid','API\KegiatanSKPTahunanAPIController@SubKegiatanKasubid');


	Route::post('add_subkegiatan_to_kegiatan_skp_tahunan','API\KegiatanSKPTahunanAPIController@AddSubKegiatanToKegiatan');

	Route::get('kegiatan_skp_tahunan_detail','API\KegiatanSKPTahunanAPIController@KegiatanSKPTahunanDetail');
	
	/* Route::get('skp_tahunan_ktj','API\KegiatanSKPTahunanAPIController@KTJoverKegiatanIdlist'); */

	//SEKDA
	Route::get('kegiatan_tahunan_sekda','API\KegiatanSKPTahunanAPIController@KegiatanTahunanSekda');


	//KABAN
	Route::get('kegiatan_skp_tahunan_1','API\KegiatanSKPTahunanAPIController@KegiatanSKPTahunan1');

	//kegiatan_KABID
	Route::get('kegiatan_skp_tahunan_2','API\KegiatanSKPTahunanAPIController@KegiatanSKPTahunan2');

	//kegiatan KASUBID
	Route::get('kegiatan_skp_tahunan_3','API\KegiatanSKPTahunanAPIController@KegiatanSKPTahunan3');
	Route::get('kegiatan_skp_tahunan_3_tree','API\KegiatanSKPTahunanAPIController@KegiatanSKPTahunanTree3');
	Route::get('sikronisasi_kegiatan_skp_tahunan_eselon4','API\KegiatanSKPTahunanAPIController@SikronisasiKegiatanSKPTahunan3');
	

	//kegiatan PELAKSANA
	Route::get('kegiatan_skp_tahunan_4','API\KegiatanSKPTahunanAPIController@KegiatanSKPTahunan4');

	Route::post('simpan_kegiatan_tahunan','API\KegiatanSKPTahunanAPIController@Store');
	Route::post('update_kegiatan_tahunan','API\KegiatanSKPTahunanAPIController@Update');
	Route::post('hapus_kegiatan_skp_tahunan','API\KegiatanSKPTahunanAPIController@Hapus');

	Route::get('skp_tahunan_kegiatan_tugas_jabatan','API\KegiatanSKPTahunanAPIController@KegiatanTugasJabatanList');

	//========================================================================================================//
	//================================= INDIKATOR KEGIATAN SKP THAUNAN =======================================//
	//========================================================================================================//

	Route::get('update_indikator','API\IndikatorKegiatanSKPTahunanAPIController@UpdateIndikatorKegiatanSKPTahunan');
	
	Route::get('indikator_kegiatan_skp_tahunan_select','API\IndikatorKegiatanSKPTahunanAPIController@SelectIndikatorKegiatanList');
	Route::get('indikator_kegiatan_skp_tahunan_list','API\IndikatorKegiatanSKPTahunanAPIController@IndikatorKegiatanSKPTahunanList');
	Route::get('indikator_kegiatan_skp_tahunan_detail','API\IndikatorKegiatanSKPTahunanAPIController@IndikatorKegiatanSKPTahunanDetail');
	Route::post('hapus_indikator_kegiatan_skp_tahunan','API\IndikatorKegiatanSKPTahunanAPIController@Hapus');
	Route::post('update_indikator_kegiatan_skp_tahunan','API\IndikatorKegiatanSKPTahunanAPIController@Update');


	//========================================================================================================//
	//====================================== KEGIATAN THAUNAN JFT ================================================//
	//========================================================================================================//

	//kegiatan JFT
	Route::get('kegiatan_skp_tahunan_5','API\KegiatanSKPTahunanJFTAPIController@KegiatanSKPTahunan');


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

	Route::get('skp_bulanan_pejabat','API\SKPBulananAPIController@SKPBulananPejabat');
	
	Route::post('update_pejabat_penilai_skp_bulanan','API\SKPBulananAPIController@PejabatPenilaiUpdate');
	Route::post('update_atasan_pejabat_penilai_skp_bulanan','API\SKPBulananAPIController@AtasanPejabatPenilaiUpdate');

	Route::get('personal_skp_bulanan_list','API\SKPBulananAPIController@PersonalSKPBulananList');


	

	Route::post('create_skp_bulanan','API\SKPBulananAPIController@Store');
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
	Route::post('update_kegiatan_bulanan','API\KegiatanSKPBulananAPIController@Update');
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
	Route::get('skpd_capaian_bulanan_list','API\CapaianBulananAPIController@SKPDCapaianBulananList');
	
	Route::get('capaian_bulanan_status_pengisian','API\CapaianBulananAPIController@CapaianBulananStatusPengisian');
	Route::get('approval_request_capaian_bulanan_list','API\CapaianBulananAPIController@ApprovalRequestList');
	Route::get('capaian_bulanan_detail','API\CapaianBulananAPIController@CapaianBulananDetail');

	Route::get('capaian_bulanan_pejabat','API\CapaianBulananAPIController@CapaianBulananPejabat');
	Route::post('update_pejabat_penilai_capaian_bulanan','API\CapaianBulananAPIController@PejabatPenilaiUpdate');
	Route::post('update_atasan_pejabat_penilai_capaian_bulanan','API\CapaianBulananAPIController@AtasanPejabatPenilaiUpdate');

	Route::get('create_capaian_bulanan_confirm','API\CapaianBulananAPIController@CreateConfirm');
	Route::post('kirim_capaian_bulanan','API\CapaianBulananAPIController@SendToAtasan');
	Route::post('tolak_capaian_bulanan','API\CapaianBulananAPIController@TolakByAtasan');
	Route::post('terima_capaian_bulanan','API\CapaianBulananAPIController@TerimaByAtasan');
	Route::post('simpan_capaian_bulanan','API\CapaianBulananAPIController@Store');
	Route::post('hapus_capaian_bulanan','API\CapaianBulananAPIController@Destroy');

	
	Route::post('ubah_status_capaian_bulanan','API\CapaianBulananAPIController@UbahStatus');


	//=====================        PENILAIAN KODE ETIK      = =====================================//
	//========================================================================================================//
	
	Route::get('detail_penilaian_kode_etik','API\KodeEtikAPIController@PenilaianKodeEtikDetail');
	Route::get('penilaian_kode_etik','API\KodeEtikAPIController@PenilaianKodeEtik');
	Route::post('simpan_penilaian_kode_etik','API\KodeEtikAPIController@Store');
	Route::post('update_penilaian_kode_etik','API\KodeEtikAPIController@Update');
	Route::post('hapus_penilaian_kode_etik','API\KodeEtikAPIController@Hapus');


	//================================== T P P    REPORT =====================================================//

	Route::get('create_tpp_report_confirm','API\TPPReportAPIController@CreateConfirm');

	Route::get('tpp_report_detail','API\TPPReportAPIController@TPPReportDetail');
	Route::get('puskesmas_tpp_report_detail','API\TPPReportAPIController@PuskesmasTPPReportDetail');

	Route::post('simpan_tpp_report','API\TPPReportAPIController@Store');
	Route::post('close_tpp_report','API\TPPReportAPIController@TPPClose');
	
	//Route::post('cetak_tpp_report','API\TPPReportAPIController@cetakTPPReportData');
	

	
	Route::post('hapus_tpp_report','API\TPPReportAPIController@Destroy');

	Route::get('skpd_tpp_report_list','API\TPPReportAPIController@SKPDTTPReportList');

	Route::get('puskesmas_tpp_report_list','API\TPPReportAPIController@PuskesmasTTPReportList');



	Route::get('administrator_tpp_report_list','API\TPPReportAPIController@AdministratorTPPList');
	Route::get('administrator_tpp_report','API\TPPReportAPIController@AdministratorTPPList');

	Route::get('cetak_tpp_periode_list','API\TPPReportAPIController@Select2CetakPeriodeList');
	Route::get('cetak_tpp_periode_bulan_list','API\TPPReportAPIController@Select2CetakPeriodeBulanList');
	Route::get('cetak_tpp_skpd_list','API\TPPReportAPIController@Select2CetakSKPDList');
	Route::get('cetak_tpp_unit_kerja_list','API\TPPReportAPIController@Select2CetakUnitKerjaList');
	
	Route::get('administrator_tpp_report_data_list','API\TPPReportAPIController@TPPReportDataList');
	
	
	Route::get('skpd_tpp_report_data_list','API\TPPReportAPIController@TPPReportDataList');
	Route::get('puskesmas_tpp_report_data_list','API\TPPReportAPIController@PuskesmasTPPReportDataList');


	//UPDTE DATA REPORT
	Route::get('update_table_tpp_report_data','API\TPPReportAPIController@UpdateOldTable');

	//============================= TPP REPORT DATA =====================================================//
	
	Route::get('tpp_report_data_detail','API\TPPReportAPIController@TPPReportDataDetail');
	Route::get('tpp_report_data_edit','API\TPPReportAPIController@TPPReportDataEdit');

	Route::post('tpp_report_data_update','API\TPPReportAPIController@TPPReportDataUpdate');

	Route::get('personal_tpp_report_data_list','API\TPPReportAPIController@PersonalTPPReportDataList');


	//============================= TPP REPORT DATA KEHADIRAN=====================================================//
	
	Route::get('kehadiran','API\KehadiranAPIController@Kehadiran');

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
	Route::post('update_pejabat_penilai','API\CapaianTahunanAPIController@PejabatPenilaiUpdate');
	Route::post('update_atasan_pejabat_penilai','API\CapaianTahunanAPIController@AtasanPejabatPenilaiUpdate');

	Route::get('capaian_tahunan_status','API\CapaianTahunanAPIController@CapaianTahunanStatus');
	
	Route::get('capaian_tahunan_detail','API\CapaianTahunanAPIController@CapaianTahunanDetail');

	Route::get('capaian_tahunan_pejabat','API\CapaianTahunanAPIController@CapaianTahunanPejabat');

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
	Route::post('update_bukti_realisasi_kegiatan_bulanan','API\RealisasiKegiatanBulananAPIController@UpdateBukti');



	//=========================--- MONITORING KINERJA  ======================================//
	Route::post('skpd_monitoring_kinerja','API\RenjaAPIController@SKPDMonitoringKinerja');

	Route::post('skpd_monitoring_kinerja_tujuan','API\RenjaAPIController@SKPDMonitoringKinerjaTujuan');
	Route::get('skpd_monitoring_kinerja_tujuan_average','API\RenjaAPIController@SKPDMonitoringKinerjaTujuanAverage');

	Route::post('skpd_monitoring_kinerja_sasaran','API\RenjaAPIController@SKPDMonitoringKinerjaSasaran');
	Route::get('skpd_monitoring_kinerja_sasaran_average','API\RenjaAPIController@SKPDMonitoringKinerjaSasaranAverage');

	Route::post('skpd_monitoring_kinerja_program','API\RenjaAPIController@SKPDMonitoringKinerjaProgram');
	Route::get('skpd_monitoring_kinerja_program_average','API\RenjaAPIController@SKPDMonitoringKinerjaProgramAverage');

	Route::post('skpd_monitoring_kinerja_kegiatan','API\RenjaAPIController@SKPDMonitoringKinerjaKegiatan');
	Route::get('skpd_monitoring_kinerja_kegiatan_average','API\RenjaAPIController@SKPDMonitoringKinerjaKegiatanAverage');


	//=========================--- REALISASI  UPLOAD BUKTI   ======================================//
	Route::post('file_upload','API\UploadFileAPIController@FileUpload');



	//========================================================================================================//
	//=================  SKPD CAPAIAN  PERJANJIAN KINERJA TRIWULAN ===========================================//
	//========================================================================================================//
	Route::get('capaian_pk_triwulan_create_confirm','API\CapaianPKTriwulanAPIController@CreateConfirm');
	Route::get('skpd_capaian_pk_triwulan_list','API\CapaianPKTriwulanAPIController@SKPDCapaianPKTriwulanList');
	Route::post('simpan_capaian_pk_triwulan','API\CapaianPKTriwulanAPIController@Store');
	
	Route::get('administrator_capaian_pk_triwulan_list','API\CapaianPKTriwulanAPIController@AdministratorCapaianPKTriwulanList');

	//========================================================================================================//
	//==============================  SKPD CAPAIAN  PK TAHUNAN  ==============================================//
	//========================================================================================================//
	Route::get('capaian_pk_tahunan_create_confirm','API\CapaianPKTahunanAPIController@CreateConfirm');
	Route::get('skpd_capaian_pk_tahunan_list','API\CapaianPKTahunanAPIController@SKPDCapaianPKTahunanList');
	Route::post('simpan_capaian_pk_tahunan','API\CapaianPKTahunanAPIController@Store');




	//======================   REALISASI SASARAN TRIWULAN      ==================================//
	Route::get('realisasi_sasaran_triwulan','API\RealisasiSasaranTriwulanAPIController@RealisasiSasaranTriwulan');
	Route::get('add_realisasi_sasaran_triwulan','API\RealisasiSasaranTriwulanAPIController@AddRealisasiSasaranTriwulan');
	Route::post('simpan_realisasi_sasaran_triwulan','API\RealisasiSasaranTriwulanAPIController@Store');
	Route::post('hapus_realisasi_sasaran_triwulan','API\RealisasiSasaranTriwulanAPIController@Destroy');
	Route::post('update_realisasi_sasaran_triwulan','API\RealisasiSasaranTriwulanAPIController@Update');


	//======================   REALISASI PROGRAM TRIWULAN      ==================================//
	Route::get('realisasi_program_triwulan','API\RealisasiProgramTriwulanAPIController@RealisasiProgramTriwulan');
	Route::get('add_realisasi_program_triwulan','API\RealisasiProgramTriwulanAPIController@AddRealisasiProgramTriwulan');
	Route::post('simpan_realisasi_program_triwulan','API\RealisasiProgramTriwulanAPIController@Store');
	Route::post('hapus_realisasi_program_triwulan','API\RealisasiProgramTriwulanAPIController@Destroy');
	Route::post('update_realisasi_program_triwulan','API\RealisasiProgramTriwulanAPIController@Update');


	//======================   REALISASI SASARAN TAHUNAN      ==================================//
	Route::get('realisasi_sasaran_tahunan','API\RealisasiSasaranTahunanAPIController@RealisasiSasaranTahunan');
	Route::get('add_realisasi_sasaran_tahunan','API\RealisasiSasaranTahunanAPIController@AddRealisasiSasaranTahunan');
	Route::post('simpan_realisasi_sasaran_tahunan','API\RealisasiSasaranTahunanAPIController@Store');
	Route::post('hapus_realisasi_sasaran_tahunan','API\RealisasiSasaranTahunanAPIController@Destroy');
	Route::post('update_realisasi_sasaran_tahunan','API\RealisasiSasaranTahunanAPIController@Update');


	//======================   REALISASI PROGRAM TAHUNAN      ==================================//
	Route::get('realisasi_program_tahunan','API\RealisasiProgramTahunanAPIController@RealisasiProgramTahunan');
	Route::get('add_realisasi_program_tahunan','API\RealisasiProgramTahunanAPIController@AddRealisasiProgramTahunan');
	Route::post('simpan_realisasi_program_tahunan','API\RealisasiProgramTahunanAPIController@Store');
	Route::post('hapus_realisasi_program_tahunan','API\RealisasiProgramTahunanAPIController@Destroy');
	Route::post('update_realisasi_program_tahunan','API\RealisasiProgramTahunanAPIController@Update');



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
	Route::post('update_bukti_realisasi_rencana_aksi_3','API\RealisasiRencanaAksiKasubidAPIController@UpdateBukti');


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




	//=====================        REALISASI   KEGIATAN SKP TAHUNAN      =====================================//
	//========================================================================================================//
	
	//Route::get('realisasi_kegiatan_tahunan','API\RealisasiKegiatanSKPTahunanAPIController@RealisasiKegiatanTahunan');
	Route::get('realisasi_kegiatan_tahunan_2','API\RealisasiKegiatanSKPTahunanAPIController@RealisasiKegiatanTahunan2');
	Route::get('realisasi_kegiatan_tahunan_3','API\RealisasiKegiatanSKPTahunanAPIController@RealisasiKegiatanTahunan3');
	Route::get('realisasi_kegiatan_tahunan_4','API\RealisasiKegiatanSKPTahunanAPIController@RealisasiKegiatanTahunan4');
	Route::get('realisasi_kegiatan_tahunan_5','API\RealisasiKegiatanSKPTahunanAPIController@RealisasiKegiatanTahunan5');

	Route::get('add_realisasi_kegiatan_skp_tahunan','API\RealisasiKegiatanSKPTahunanAPIController@AddRealisasiKegiatanSKPTahunan');

	Route::get('add_realisasi_kegiatan_skp_tahunan_5','API\RealisasiKegiatanSKPTahunanAPIController@AddRealisasiKegiatanSKPTahunan5');
	
	Route::post('simpan_realisasi_kegiatan_tahunan','API\RealisasiKegiatanSKPTahunanAPIController@Store');
	Route::post('update_realisasi_kegiatan_tahunan','API\RealisasiKegiatanSKPTahunanAPIController@Update');
	Route::post('hapus_realisasi_kegiatan_tahunan','API\RealisasiKegiatanSKPTahunanAPIController@Destroy');

	Route::post('simpan_realisasi_kegiatan_tahunan_5','API\RealisasiKegiatanSKPTahunanAPIController@Store5');
	Route::post('update_realisasi_kegiatan_tahunan_5','API\RealisasiKegiatanSKPTahunanAPIController@Update5');
	Route::post('hapus_realisasi_kegiatan_tahunan_5','API\RealisasiKegiatanSKPTahunanAPIController@Destroy5');


	//=====================        PENILAIAN KUALITAS KERJA      = =====================================//
	//========================================================================================================//
	
	Route::get('penilaian_kualitas_kerja_detail','API\RealisasiKegiatanSKPTahunanAPIController@PenilaianKualitasKerja');
	Route::get('penilaian_kualitas_kerja_detail_JFT','API\RealisasiKegiatanSKPTahunanAPIController@PenilaianKualitasKerjaJFT');
	Route::post('simpan_penilaian_kualitas_kerja','API\RealisasiKegiatanSKPTahunanAPIController@UpdateKualitasKerja');
	Route::post('simpan_penilaian_kualitas_kerja_5','API\RealisasiKegiatanSKPTahunanAPIController@UpdateKualitasKerja5');

	//=====================        PENILAIAN PERILAKU KERJA      = =====================================//
	//========================================================================================================//
	
	Route::get('detail_penilaian_perilaku_kerja','API\PerilakuKerjaAPIController@PenilaianPerilakuKerjaDetail');
	Route::get('penilaian_perilaku_kerja','API\PerilakuKerjaAPIController@PenilaianPerilakuKerja');
	Route::post('simpan_penilaian_perilaku_kerja','API\PerilakuKerjaAPIController@Store');
	Route::post('update_penilaian_perilaku_kerja','API\PerilakuKerjaAPIController@Update');
	Route::post('hapus_penilaian_perilaku_kerja','API\PerilakuKerjaAPIController@Hapus');
	

	//=================================         TUGAS TAMBAHAN     = =====================================//
	//=====================================================================================================//
	Route::get('tugas_tambahan_tree','API\TugasTambahanAPIController@TugasTambahanTree');
	Route::get('tugas_tambahan_select2','API\TugasTambahanAPIController@TugasTambahanSelect2');
	
	Route::get('tugas_tambahan_list','API\TugasTambahanAPIController@TugasTambahanList');
	Route::post('simpan_tugas_tambahan','API\TugasTambahanAPIController@Store');
	Route::post('hapus_tugas_tambahan','API\TugasTambahanAPIController@Destroy');
	Route::get('tugas_tambahan_detail','API\TugasTambahanAPIController@Detail');
	Route::post('update_tugas_tambahan','API\TugasTambahanAPIController@Update');

	//======================  REALISASI   URAIAN    TUGAS TAMBAHAN   ===========================//
	//==========================================================================================//
	Route::get('realisasi_tugas_tambahan_list','API\RealisasiTugasTambahanAPIController@RealisasiTugasTambahanList');
	Route::post('simpan_realisasi_tugas_tambahan','API\RealisasiTugasTambahanAPIController@Store');
	Route::get('realisasi_tugas_tambahan_detail','API\RealisasiTugasTambahanAPIController@Detail');
	Route::post('update_realisasi_tugas_tambahan','API\RealisasiTugasTambahanAPIController@Update');
	Route::post('hapus_realisasi_tugas_tambahan','API\RealisasiTugasTambahanAPIController@Destroy');
	

	//======================      URAIAN    TUGAS TAMBAHAN   ==================================//
	//==========================================================================================//
	Route::get('uraian_tugas_tambahan_list','API\UraianTugasTambahanAPIController@UraianTugasTambahanList');
	Route::post('simpan_uraian_tugas_tambahan','API\UraianTugasTambahanAPIController@Store');
	Route::get('uraian_tugas_tambahan_detail','API\UraianTugasTambahanAPIController@Detail');
	Route::post('update_uraian_tugas_tambahan','API\UraianTugasTambahanAPIController@Update');
	Route::post('hapus_uraian_tugas_tambahan','API\UraianTugasTambahanAPIController@Destroy');


	//======================  REALISASI   URAIAN    TUGAS TAMBAHAN   ===========================//
	//==========================================================================================//
	Route::get('realisasi_uraian_tugas_tambahan_list','API\RealisasiUraianTugasTambahanAPIController@RealisasiUraianTugasTambahanList');
	Route::post('simpan_realisasi_uraian_tugas_tambahan','API\RealisasiUraianTugasTambahanAPIController@Store');
	Route::get('realisasi_uraian_tugas_tambahan_detail','API\RealisasiUraianTugasTambahanAPIController@Detail');
	Route::post('update_realisasi_uraian_tugas_tambahan','API\RealisasiUraianTugasTambahanAPIController@Update');
	Route::post('hapus_realisasi_uraian_tugas_tambahan','API\RealisasiUraianTugasTambahanAPIController@Destroy');
	

	//===============================  UNSUR PENUNJANG  / TUGAS TAMBAHAN = ==================================//
	//========================================================================================================//
	Route::get('unsur_penunjang_tugas_tambahan_list','API\UnsurPenunjangAPIController@TugasTambahanList');
	Route::get('unsur_penunjang_tugas_tambahan_detail','API\UnsurPenunjangAPIController@TugasTambahanDetail');
	
	Route::post('simpan_unsur_penunjang_tugas_tambahan','API\UnsurPenunjangAPIController@TugasTambahanStore');
	Route::post('update_unsur_penunjang_tugas_tambahan','API\UnsurPenunjangAPIController@TugasTambahanUpdate');
	Route::post('hapus_unsur_penunjang_tugas_tambahan','API\UnsurPenunjangAPIController@TugasTambahanDestroy');
	Route::post('approve_unsur_penunjang_tugas_tambahan','API\UnsurPenunjangAPIController@TugasTambahanApprove');
	Route::post('reject_unsur_penunjang_tugas_tambahan','API\UnsurPenunjangAPIController@TugasTambahanReject');

	//===============================  UNSUR PENUNJANG  / TUGAS TAMBAHAN = ==================================//
	//========================================================================================================//
	Route::get('unsur_penunjang_kreativitas_list','API\UnsurPenunjangAPIController@KreativitasList');
	Route::get('unsur_penunjang_kreativitas_detail','API\UnsurPenunjangAPIController@KreativitasDetail');
	
	Route::post('simpan_unsur_penunjang_kreativitas','API\UnsurPenunjangAPIController@KreativitasStore');
	Route::post('update_unsur_penunjang_kreativitas','API\UnsurPenunjangAPIController@KreativitasUpdate');
	Route::post('hapus_unsur_penunjang_kreativitas','API\UnsurPenunjangAPIController@KreativitasDestroy');
	Route::post('approve_unsur_penunjang_kreativitas','API\UnsurPenunjangAPIController@KreativitasApprove');
	Route::post('reject_unsur_penunjang_kreativitas','API\UnsurPenunjangAPIController@KreativitasReject');
	//========================================================================================================//
	//======================================= RENCANA AKSI  SKP THAUNAN ======================================//
	//========================================================================================================//
	Route::get('rencana_aksi_tree','API\RencanaAksiAPIController@rencana_aksi_tree');
	Route::get('skp_tahunan_rencana_aksi','API\RencanaAksiAPIController@RencanaAksiList');
	Route::get('skp_tahunan_rencana_aksi_3','API\RencanaAksiAPIController@RencanaAksiList3');
	Route::get('skp_tahunan_rencana_aksi_4','API\RencanaAksiAPIController@RencanaAksiList4');
	
	Route::get('rencana_aksi_time_table_2','API\RencanaAksiAPIController@RencanaAksiTimeTable2');
	//Route::get('rencana_aksi_time_table_3','API\RencanaAksiAPIController@RencanaAksiTimeTable3');
	Route::get('rencana_aksi_3','API\RencanaAksiAPIController@RencanaAksi3');
	Route::get('rencana_aksi_time_table_4','API\RencanaAksiAPIController@RencanaAksiTimeTable4');

	Route::get('rencana_aksi_detail','API\RencanaAksiAPIController@RencanaAksiDetail3');

	Route::get('rencana_aksi_detail_1','API\RencanaAksiAPIController@RencanaAksiDetail1');
	Route::get('rencana_aksi_detail_2','API\RencanaAksiAPIController@RencanaAksiDetail2');
	Route::get('rencana_aksi_detail_3','API\RencanaAksiAPIController@RencanaAksiDetail3');
	Route::get('rencana_aksi_detail_4','API\RencanaAksiAPIController@RencanaAksiDetail4');

	Route::post('simpan_rencana_aksi','API\RencanaAksiAPIController@Store');
	Route::post('update_rencana_aksi','API\RencanaAksiAPIController@Update');
	Route::post('hapus_rencana_aksi','API\RencanaAksiAPIController@Hapus');


	Route::get('update_data_rencana_aksi','API\RencanaAksiAPIController@UpdateRencanaAksi');
	

	//========================================================================================================//
	//======================================= RENCANA AKSI  RENJA      ======================================//
	//========================================================================================================//
	
	Route::get('renja_rencana_aksi','API\RencanaAksiAPIController@RenjaRencanaAksiList');
	Route::get('kegiatan_rencana_aksi','API\RencanaAksiAPIController@KegiatanRencanaAksiList');
	
	

	//========================================================================================================//
	//==================================  P E G A W A I =================================================//
	//========================================================================================================//

	Route::get('pegawai_list','API\PegawaiAPIController@PegawaiList');
	//Route::get('select_pegawai_list','API\PegawaiAPIController@select_pejabat_penilai_list');

	Route::get('administrator_pegawai_list','API\PegawaiAPIController@administrator_pegawai_list');
	Route::get('skpd_pegawai_list','API\PegawaiAPIController@SKPDPegawaiList');
	Route::get('skpd_pegawai_list_select2','API\PegawaiAPIController@SKPDPegawaiListSelect2');
	
	Route::get('select_ka_skpd_list','API\PegawaiAPIController@select_ka_skpd_list');
	
	Route::get('ganti_atasan_capaian_bulanan','API\PegawaiAPIController@selectAtasanCapaianBulanan');

	Route::get('administrator_pegawai_skpd_list','API\PegawaiAPIController@SKPDPegawaiList');
	Route::get('administrator_pegawai_puskesmas_list','API\PegawaiAPIController@PuskesmasPegawaiList');
	Route::get('administrator_pegawai_puskesmas_list_error','API\PegawaiAPIController@PuskesmasPegawaiListError');

	Route::get('puskesmas_pegawai_list','API\PegawaiAPIController@PuskesmasPegawaiList');
	

	
	

	//========================================================================================================//
	//========================================  J A B A T A N ================================================//
	//========================================================================================================//
	Route::get('select2_jabatan_list','API\JabatanAPIController@select2_jabatan_list');
	Route::get('detail_pejabat_aktif','API\JabatanAPIController@PejabatAktifDetail');

	Route::get('select2_skpd_jabatan_list','API\JabatanAPIController@SKPDJabatanListSelect2');


	Route::get('select2_bawahan_list','API\JabatanAPIController@Select2BawahanList');


	
	//========================================================================================================//
	//==================================  PETA  J A B A T A N ================================================//
	//========================================================================================================//
	Route::get('skpd_peta_jabatan','API\PetaJabatanAPIController@skpd_peta_jabatan');


	//========================================================================================================//
	//================================== STRUKTUR ORGANISASI  ================================================//
	//========================================================================================================//
	Route::get('skpd_struktur_organisasi','API\StrukturOrganisasiAPIController@skpd_struktur_organisasi');
	Route::get('puskesmas_struktur_organisasi','API\StrukturOrganisasiAPIController@puskesmas_struktur_organisasi');


	//========================================================================================================//
	//==================================  ADMIN SKPD USER ROLE  ==============================================//
	//========================================================================================================//
	Route::post('add_admin_skpd','API\RoleUserAPIController@AddAdminSKPD');
	Route::post('remove_admin_skpd','API\RoleUserAPIController@RemoveAdminSKPD');

	//========================================================================================================//
	//==================================  ADMIN PUSKESMAS USER ROLE  ==============================================//
	//========================================================================================================//
	Route::post('add_admin_puskesmas','API\RoleUserAPIController@AddAdminPuskesmas');
	Route::post('remove_admin_puskesmas','API\RoleUserAPIController@RemoveAdminPuskesmas');




	//========================================================================================================//
	//==================================  B A N T U A N     ==============================================//
	//========================================================================================================//
	Route::get('bantuan_detail','API\BantuanAPIController@Detail');
	


});


