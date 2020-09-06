<?php

/*
|--------------------------------------------------------------------------
| Breadcrumbs Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the breadcrumbs for an application.
| It's a breeze. Simply tell Laravel the view it should respond to
| and give it the controller to call when that URI is requested.
|
| http://laravel-breadcrumbs.davejamesmiller.com/en/latest/start.html
|
*/

// DASHBOARD
Breadcrumbs::register('dashboard', function($breadcrumbs)
{
	//$breadcrumbs->push(Lang::get('sidebar-nav.link_title_dashboard'), '/public/dashboard', ['icon' => Lang::get('sidebar-nav.link_icon_dashboard')]);
});

// DASHBOARD > PROFILE
Breadcrumbs::register('profile', function($breadcrumbs, $user)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_profile_view'), '/profile/'.$user->name, ['icon' => Lang::get('sidebar-nav.link_icon_profile_view')]);
});

// DASHBOARD > PROFILE > EDIT
Breadcrumbs::register('profile_edit', function($breadcrumbs, $user)
{
    $breadcrumbs->parent('profile', $user);
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_profile_edit'), '/profile/'.$user->name.'/edit', ['icon' => Lang::get('sidebar-nav.link_icon_profile_edit')]);
});

// DASHBOARD > USERS > SHOW USERS
Breadcrumbs::register('users', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_users'), '/users', ['icon' => Lang::get('sidebar-nav.link_icon_users')]);
});

// DASHBOARD > USERS > EDIT USERS
Breadcrumbs::register('edit_users', function($breadcrumbs)
{
    $breadcrumbs->parent('users');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_users_edit'), '/edit-users', ['icon' => Lang::get('sidebar-nav.link_icon_users_edit')]);
});

// DASHBOARD > USERS > EDIT USERS > SHOW USER
Breadcrumbs::register('show_user_admin_view', function($breadcrumbs, $user)
{
    $breadcrumbs->parent('edit_users');
    $breadcrumbs->push($user->nama, '/users/'.$user->id, ['icon' => Lang::get('sidebar-nav.link_icon_profile_view')]);
});

// DASHBOARD > USERS > EDIT USERS > USER > EDIT USER
Breadcrumbs::register('edit_user_admin_view', function($breadcrumbs, $user)
{
    $breadcrumbs->parent('show_user_admin_view', $user);
    $breadcrumbs->push(Lang::get('sidebar-nav.title_admin_user_edit'), '/users/'.$user->id.'/edit', ['icon' => Lang::get('sidebar-nav.icon_admin_user_edit')]);
});

// DASHBOARD > USERS > EDIT USERS > CREATE USER
Breadcrumbs::register('create_user_admin_view', function($breadcrumbs)
{
    $breadcrumbs->parent('edit_users');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_user_create'), '/create-user', ['icon' => Lang::get('sidebar-nav.link_icon_user_create')]);
});


//==========================================================================================================//
//================================== ADMINISTRATOR ==========================================================//
//==========================================================================================================//
// DASHBOARD > ADMIN >
Breadcrumbs::register('admin', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_admin'), '/public/admin', ['icon' => Lang::get('sidebar-nav.link_icon_admin')]);
});



// DASHBOARD > ADMIN > PEGAWAI >
Breadcrumbs::register('admin-pegawai', function($breadcrumbs)
{
    $breadcrumbs->parent('admin');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_pegawai'), '/public/admin/pegawai', ['icon' => Lang::get('sidebar-nav.link_icon_pegawai')]);
});


// DASHBOARD > ADMIN > USERS >
Breadcrumbs::register('admin-users', function($breadcrumbs)
{
    $breadcrumbs->parent('admin');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_users'), '/public/admin/user', ['icon' => Lang::get('sidebar-nav.link_icon_users')]);
});


// DASHBOARD > ADMIN > SKPD >
Breadcrumbs::register('admin-skpd', function($breadcrumbs)
{
    $breadcrumbs->parent('admin');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_skpd'), '/public/admin/skpd', ['icon' => Lang::get('sidebar-nav.link_icon_skpd')]);
});

// DASHBOARD > ADMIN > SKPD > PEGAWAI
Breadcrumbs::register('admin-skpd-pegawai', function($breadcrumbs)
{
    $breadcrumbs->parent('admin-skpd');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_pegawai'), '/pegawai', ['icon' => Lang::get('sidebar-nav.link_icon_pegawai')]);
});

// DASHBOARD > ADMIN > SKPD > Struktur org
Breadcrumbs::register('admin-skpd-struktur_organisasi', function($breadcrumbs)
{
    $breadcrumbs->parent('admin-skpd');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_struktur_organisasi'), '/struktur_organisasi', ['icon' => Lang::get('sidebar-nav.link_icon_struktur_organisasi')]);
});


// DASHBOARD > ADMIN > POHON KINERJA >
Breadcrumbs::register('admin-pohon_kinerja', function($breadcrumbs)
{
    $breadcrumbs->parent('admin');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_pohon_kinerja'), '/public/admin/pohon_kinerja', ['icon' => Lang::get('sidebar-nav.link_icon_pohon_kinerja')]);
});

// DASHBOARD > ADMIN > POHON KINERJA >
Breadcrumbs::register('admin-pohon_kinerja-detail', function($breadcrumbs)
{
    $breadcrumbs->parent('admin-pohon_kinerja');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_detail'), '/pohon_kinerja_detail', ['icon' => Lang::get('sidebar-nav.link_icon_detail')]);
});




// DASHBOARD > ADMIN > SKP TAHUNAN >
Breadcrumbs::register('admin-skp_tahunan', function($breadcrumbs)
{
    $breadcrumbs->parent('admin');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_skp_tahunan'), '/public/admin/skp_tahunan', ['icon' => Lang::get('sidebar-nav.link_icon_skp_tahunan')]);
});

// DASHBOARD > ADMIN > SKP TAHUNAN > DETAIL
Breadcrumbs::register('admin-skp_tahunan_detail', function($breadcrumbs)
{
    $breadcrumbs->parent('admin-skp_tahunan');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_detail'), '/skp_tahunan_detail', ['icon' => Lang::get('sidebar-nav.link_icon_detail')]);
});

// DASHBOARD > ADMIN > TPP RPEORT
Breadcrumbs::register('admin-tpp_report', function($breadcrumbs)
{
    $breadcrumbs->parent('admin');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_tpp_report'), '/public/admin/tpp_report', ['icon' => Lang::get('sidebar-nav.link_icon_tpp_report')]);
});

// DASHBOARD > ADMIN > TPP RPEORT > CETAK
Breadcrumbs::register('admin-tpp_report_cetak', function($breadcrumbs)
{
    $breadcrumbs->parent('admin-tpp_report');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_print'), '/public/admin/tpp_report', ['icon' => Lang::get('sidebar-nav.link_icon_print')]);
});


// DASHBOARD > ADMIN > Puskesmas
Breadcrumbs::register('admin-puskesmas', function($breadcrumbs)
{
    $breadcrumbs->parent('admin');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_puskesmas'), '/public/admin/puskesmas', ['icon' => Lang::get('sidebar-nav.link_icon_puskesmas')]);
});

// DASHBOARD > ADMIN > Puskesmas > PEGAWAI
Breadcrumbs::register('admin-puskesmas-pegawai', function($breadcrumbs)
{
    $breadcrumbs->parent('admin-puskesmas');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_pegawai'), '/pegawai', ['icon' => Lang::get('sidebar-nav.link_icon_pegawai')]);
});

//==========================================================================================================//
//================================== ES KA PE DE ===========================================================//
//==========================================================================================================//

// DASHBOARD > SKPD >
Breadcrumbs::register('skpd', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_skpd'), '/public/skpd', ['icon' => Lang::get('sidebar-nav.link_icon_skpd')]);
});

// DASHBOARD > SKPD > PEGAWAI >
Breadcrumbs::register('skpd-pegawai', function($breadcrumbs)
{
    $breadcrumbs->parent('skpd');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_pegawai'), '/pegawai', ['icon' => Lang::get('sidebar-nav.link_icon_pegawai')]);
});

// DASHBOARD > SKPD > UNIT KERJA >
Breadcrumbs::register('skpd-unit_kerja', function($breadcrumbs)
{
    $breadcrumbs->parent('skpd');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_unit_kerja'), '/unit_kerja', ['icon' => Lang::get('sidebar-nav.link_icon_unit_kerja')]);
});

// DASHBOARD > SKPD > PUSKESMAS >
Breadcrumbs::register('skpd-puskesmas', function($breadcrumbs)
{
    $breadcrumbs->parent('skpd');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_puskesmas'), '/puskesmas', ['icon' => Lang::get('sidebar-nav.link_icon_puskesmas')]);
});

// DASHBOARD > ADMIN > CAPAIAN PK Trwieulan>
Breadcrumbs::register('skpd-capaian_pk_triwulan', function($breadcrumbs)
{
    $breadcrumbs->parent('skpd');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_capaian_pk_triwulan'), '/public/skpd/capaian_pk_triwulan', ['icon' => Lang::get('sidebar-nav.link_icon_capaian_pk_triwulan')]);
});

Breadcrumbs::register('skpd-capaian_pk_triwulan_edit', function($breadcrumbs)
{
    $breadcrumbs->parent('skpd-capaian_pk_triwulan');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_capaian_pk_triwulan'), '/public/skpd/capaian_pk_triwulan', ['icon' => Lang::get('sidebar-nav.link_icon_capaian_pk_triwulan')]);
});

// DASHBOARD > ADMIN > CAPAIAN PK TAHUNAN >
Breadcrumbs::register('skpd-capaian_pk_tahunan', function($breadcrumbs)
{
    $breadcrumbs->parent('skpd');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_capaian_pk_tahunan'), '/public/skpd/capaian_pk_tahunan', ['icon' => Lang::get('sidebar-nav.link_icon_capaian_pk_tahunan')]);
});

Breadcrumbs::register('skpd-capaian_pk_tahunan_edit', function($breadcrumbs)
{
    $breadcrumbs->parent('skpd-capaian_pk_tahunan');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_capaian_pk_tahunan'), '/public/skpd/capaian_pk_tahunan', ['icon' => Lang::get('sidebar-nav.link_icon_capaian_pk_tahunan')]);
});

// DASHBOARD > SKPD > PUSKESMAS > PEGAWAI
Breadcrumbs::register('skpd-puskesmas-pegawai', function($breadcrumbs)
{
    $breadcrumbs->parent('skpd-puskesmas');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_pegawai'), '/pegawai', ['icon' => Lang::get('sidebar-nav.link_icon_pegawai')]);
});


// DASHBOARD > SKPD > POHON KINERJA >
Breadcrumbs::register('skpd-pohon_kinerja', function($breadcrumbs)
{
    $breadcrumbs->parent('skpd');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_renja'), '/public/skpd/pohon_kinerja', ['icon' => Lang::get('sidebar-nav.link_icon_renja')]);
});
// DASHBOARD > SKPD > POHON KINERJA > EDIT
Breadcrumbs::register('skpd-pohon_kinerja-edit', function($breadcrumbs)
{
    $breadcrumbs->parent('skpd-pohon_kinerja');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_edit'), '/pohon_kinerja', ['icon' => Lang::get('sidebar-nav.link_icon_edit')]);
});
// DASHBOARD > SKPD > POHON KINERJA > DETAIL
Breadcrumbs::register('skpd-pohon_kinerja-detail', function($breadcrumbs)
{
    $breadcrumbs->parent('skpd-pohon_kinerja');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_detail'), '/pohon_kinerja', ['icon' => Lang::get('sidebar-nav.link_icon_detail')]);
});


// DASHBOARD > SKPD > STRUKTUR ORGANISASI >
Breadcrumbs::register('skpd-struktur_organisasi', function($breadcrumbs)
{
    $breadcrumbs->parent('skpd');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_struktur_organisasi'), '/struktur-organisasi', ['icon' => Lang::get('sidebar-nav.link_icon_struktur_organisasi')]);
});


// DASHBOARD > SKPD > SKP TAHUNAN >
Breadcrumbs::register('skpd-skp_tahunan', function($breadcrumbs)
{
    $breadcrumbs->parent('skpd');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_skp_tahunan'), '/public/skpd/skp_tahunan', ['icon' => Lang::get('sidebar-nav.link_icon_skp_tahunan')]);
});
// DASHBOARD > SKPD > SKP TAHUNAN > DETAIL
Breadcrumbs::register('skpd-skp_tahunan_detail', function($breadcrumbs)
{
    $breadcrumbs->parent('skpd-skp_tahunan');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_detail_skp_tahunan'), '/public/skp_tahunan', ['icon' => Lang::get('sidebar-nav.link_icon_detail_skp_tahunan')]);
});


// DASHBOARD > SKPD > TPP REPORT >
Breadcrumbs::register('skpd-tpp_report', function($breadcrumbs)
{
    $breadcrumbs->parent('skpd');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_tpp_report'), '/public/skpd/tpp_report', ['icon' => Lang::get('sidebar-nav.link_icon_tpp_report')]);
});
// DASHBOARD > SKPD > TPP REPORT > EDIT
Breadcrumbs::register('skpd-tpp_report_edit', function($breadcrumbs)
{
    $breadcrumbs->parent('skpd-tpp_report');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_edit'), '/tpp_report_edit', ['icon' => Lang::get('sidebar-nav.link_icon_edit')]);
});
// DASHBOARD > SKPD > TPP REPORT > DETAIL
Breadcrumbs::register('skpd-tpp_report_detail', function($breadcrumbs)
{
    $breadcrumbs->parent('skpd-tpp_report');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_detail'), '/tpp_report_detail', ['icon' => Lang::get('sidebar-nav.link_icon_detail')]);
});



//==========================================================================================================//
//=================================         PUS KES MAS          ===========================================//
//==========================================================================================================//

// DASHBOARD > puskesmas >
Breadcrumbs::register('puskesmas', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_puskesmas'), '/public/puskesmas', ['icon' => Lang::get('sidebar-nav.link_icon_puskesmas')]);
});

// DASHBOARD > PUSKESMAS > PEGAWAI >
Breadcrumbs::register('puskesmas-pegawai', function($breadcrumbs)
{
    $breadcrumbs->parent('puskesmas');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_pegawai'), '/pegawai', ['icon' => Lang::get('sidebar-nav.link_icon_pegawai')]);
});


// DASHBOARD > PUSKESMAS > STRUKTUR ORGANISASI >
Breadcrumbs::register('puskesmas-struktur_organisasi', function($breadcrumbs)
{
    $breadcrumbs->parent('puskesmas');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_struktur_organisasi'), '/struktur-organisasi', ['icon' => Lang::get('sidebar-nav.link_icon_struktur_organisasi')]);
});


// DASHBOARD > PUSKESMAS > SKP TAHUNAN >
Breadcrumbs::register('puskesmas-skp_tahunan', function($breadcrumbs)
{
    $breadcrumbs->parent('puskesmas');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_skp_tahunan'), '/public/puskesmas/skp_tahunan', ['icon' => Lang::get('sidebar-nav.link_icon_skp_tahunan')]);
});
// DASHBOARD > PUSKESMAS > SKP TAHUNAN > DETAIL
Breadcrumbs::register('puskesmas-skp_tahunan_detail', function($breadcrumbs)
{
    $breadcrumbs->parent('puskesmas-skp_tahunan');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_detail_skp_tahunan'), '/public/skp_tahunan', ['icon' => Lang::get('sidebar-nav.link_icon_detail_skp_tahunan')]);
});


// DASHBOARD > PUSKESMAS > TPP REPORT >
Breadcrumbs::register('puskesmas-tpp_report', function($breadcrumbs)
{
    $breadcrumbs->parent('puskesmas');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_tpp_report'), '/public/puskesmas/tpp_report', ['icon' => Lang::get('sidebar-nav.link_icon_tpp_report')]);
});
// DASHBOARD > PUSKESMAS > TPP REPORT > EDIT
Breadcrumbs::register('puskesmas-tpp_report_edit', function($breadcrumbs)
{
    $breadcrumbs->parent('puskesmas-tpp_report');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_edit'), '/tpp_report_edit', ['icon' => Lang::get('sidebar-nav.link_icon_edit')]);
});
// DASHBOARD > PUSKESMAS > TPP REPORT > DETAIL
Breadcrumbs::register('puskesmas-tpp_report_detail', function($breadcrumbs)
{
    $breadcrumbs->parent('puskesmas-tpp_report');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_detail'), '/tpp_report_detail', ['icon' => Lang::get('sidebar-nav.link_icon_detail')]);
});








// DASHBOARD > MASA PEMRITYAHAN >
Breadcrumbs::register('masa_pemerintahan', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_masa_pemerintahan'), '/masa_pemerintahan', ['icon' => Lang::get('sidebar-nav.link_icon_masa_pemerintahan')]);
});




//==========================================================================================================//
//================================== P E R S O N A L   =====================================================//
//==========================================================================================================//



// DASHBOARD > USERS > SHOW RENCANA KERJA
Breadcrumbs::register('rencana_kerja', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_renja'), '/rencana kerja', ['icon' => Lang::get('sidebar-nav.link_icon_renja')]);
});



// DASHBOARD > USERS > SHOW PETA JABATAN
Breadcrumbs::register('skp_tahunan', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_skp_tahunan'), '/skp tahunan', ['icon' => Lang::get('sidebar-nav.link_icon_skp_tahunan')]);
});

Breadcrumbs::register('personal-skp_tahunan_detail', function($breadcrumbs)
{
    $breadcrumbs->parent('personal_skp_tahunan');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_detail_skp_tahunan'), '', ['icon' => Lang::get('sidebar-nav.link_icon_detail_skp_tahunan')]);
});



// DASHBOARD > POHON KINERJA
Breadcrumbs::register('pohon_kinerja', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_renja'), '/pohon kinerja', ['icon' => Lang::get('sidebar-nav.link_icon_renja')]);
});

// DASHBOARD > TPP > Report
Breadcrumbs::register('tpp_report', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_tpp_report'), '/tpp report', ['icon' => Lang::get('sidebar-nav.link_icon_tpp_report')]);
});

Breadcrumbs::register('edit_tpp_report', function($breadcrumbs)
{
    $breadcrumbs->parent('tpp_report');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_edit_tpp_report'), '/tpp report edit', ['icon' => Lang::get('sidebar-nav.link_icon_edit_tpp_report')]);
});

Breadcrumbs::register('detail_tpp_report', function($breadcrumbs)
{
    $breadcrumbs->parent('tpp_report');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_detail_tpp_report'), '/tpp report detail', ['icon' => Lang::get('sidebar-nav.link_icon_detail_tpp_report')]);
});

// DASHBOARD > USERS > SHOW PETA JABATAN
Breadcrumbs::register('skp_bulanan', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_skp_bulanan'), '/skp bulanan', ['icon' => Lang::get('sidebar-nav.link_icon_skp_bulanan')]);
});

// DASHBOARD > USERS > SHOW PETA JABATAN
Breadcrumbs::register('peta_jabatan', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_peta_jabatan'), '/peta jabatan', ['icon' => Lang::get('sidebar-nav.link_icon_peta_jabatan')]);
});





// DASHBOARD > DISTRIBUSI KEGIATAN
Breadcrumbs::register('distribusi_kegiatan', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_distribusi_kegiatan'), '/pare_2018/skpd/distribusi-kegiatan', ['icon' => Lang::get('sidebar-nav.link_icon_distribusi_kegiatan')]);
});




// DASHBOARD > DISTRIBUSI KEGIATAN > ADD
Breadcrumbs::register('add_kegiatan', function($breadcrumbs)
{
    $breadcrumbs->parent('distribusi_kegiatan');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_add_kegiatan'), '/add kegiatan', ['icon' => Lang::get('sidebar-nav.link_icon_add_kegiatan')]);
});


// DASHBOARD > SASARAN
Breadcrumbs::register('sasaran', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_sasaran'), '/pare_2018/skpd/sasaran', ['icon' => Lang::get('sidebar-nav.link_icon_sasaran')]);
});


// DASHBOARD > INDIKATOR SASARAN
Breadcrumbs::register('indikator_sasaran', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_indikator_sasaran'), '/pare_2018/skpd/indikator_sasaran', ['icon' => Lang::get('sidebar-nav.link_icon_indikator_sasaran')]);
});

// DASHBOARD >PERJANJIAN KINERJA
Breadcrumbs::register('perjanjian_kinerja', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_perjanjian_kinerja'), '/pare_2018/skpd/perjanjian_kinerja', ['icon' => Lang::get('sidebar-nav.link_icon_perjanjian_kinerja')]);
});

// DASHBOARD PERSONAL
Breadcrumbs::register('personal-dashboard', function($breadcrumbs)
{
	$breadcrumbs->push(Lang::get('sidebar-nav.link_title_dashboard'), '/public/personal', ['icon' => Lang::get('sidebar-nav.link_icon_dashboard')]);
});

// DASHBOARD >SKP
Breadcrumbs::register('skp', function($breadcrumbs)
{
    $breadcrumbs->parent('personal-dashboard');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_skp'), '/public/personal/skp', ['icon' => Lang::get('sidebar-nav.link_icon_skp')]);
});

// DASHBOARD >SKP TAHUNAN
Breadcrumbs::register('personal_skp_tahunan', function($breadcrumbs)
{
    $breadcrumbs->parent('personal-dashboard');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_skp_tahunan'), '/public/personal/skp_tahunan', ['icon' => Lang::get('sidebar-nav.link_icon_skp_tahunan')]);
});

Breadcrumbs::register('personal_edit_skp_tahunan', function($breadcrumbs)
{
    $breadcrumbs->parent('personal_skp_tahunan');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_edit_skp_tahunan'), '', ['icon' => Lang::get('sidebar-nav.link_icon_edit_skp_tahunan')]);
});



// DASHBOARD >SKP BULANAN
Breadcrumbs::register('personal_skp_bulanan', function($breadcrumbs)
{
    $breadcrumbs->parent('personal-dashboard');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_skp_bulanan'), '/public/personal/skp_bulanan', ['icon' => Lang::get('sidebar-nav.link_icon_skp_bulanan')]);
});

Breadcrumbs::register('personal_detail_skp_bulanan', function($breadcrumbs)
{
    $breadcrumbs->parent('personal_skp_bulanan');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_detail_skp_bulanan'), '', ['icon' => Lang::get('sidebar-nav.link_icon_detail_skp_bulanan')]);
});

// DASHBOARD >CAPAIAN BULANAN

Breadcrumbs::register('capaian_bulanan', function($breadcrumbs)
{
    $breadcrumbs->parent('personal-dashboard');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_capaian_bulanan'), '/public/personal/capaian-bulanan', ['icon' => Lang::get('sidebar-nav.link_icon_capaian')]);
});

Breadcrumbs::register('personal_edit_capaian_bulanan', function($breadcrumbs)
{
    $breadcrumbs->parent('capaian_bulanan');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_edit_capaian_bulanan'), '', ['icon' => Lang::get('sidebar-nav.link_icon_edit_capaian_bulanan')]);
});

Breadcrumbs::register('personal_detail_capaian_bulanan', function($breadcrumbs)
{
    $breadcrumbs->parent('capaian_bulanan');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_detail_capaian_bulanan'), '', ['icon' => Lang::get('sidebar-nav.link_icon_detail_capaian_bulanan')]);
});


// DASHBOARD >CAPAIAN TRIWULAN

Breadcrumbs::register('capaian_triwulan', function($breadcrumbs)
{
    $breadcrumbs->parent('personal-dashboard');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_capaian_triwulan'), '/public/personal/capaian-triwulan', ['icon' => Lang::get('sidebar-nav.link_icon_capaian')]);
});

Breadcrumbs::register('personal_edit_capaian_triwulan', function($breadcrumbs)
{
    $breadcrumbs->parent('capaian_triwulan');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_edit_capaian_triwulan'), '', ['icon' => Lang::get('sidebar-nav.link_icon_edit_capaian_triwulan')]);
});

// DASHBOARD >CAPAIAN TAHUNAN

Breadcrumbs::register('capaian_tahunan', function($breadcrumbs)
{
    $breadcrumbs->parent('personal-dashboard');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_capaian_tahunan'), '/public/personal/capaian-tahunan', ['icon' => Lang::get('sidebar-nav.link_icon_capaian')]);
});

Breadcrumbs::register('personal_edit_capaian_tahunan', function($breadcrumbs)
{
    $breadcrumbs->parent('capaian_tahunan');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_edit_capaian_tahunan'), '', ['icon' => Lang::get('sidebar-nav.link_icon_edit_capaian_tahunan')]);
});


// DASHBOARD > APPROVAL REQUEST
Breadcrumbs::register('approval_request', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_approval-request'), '', ['icon' => Lang::get('sidebar-nav.link_icon_approval-request')]);
});

Breadcrumbs::register('approval_request-renja', function($breadcrumbs)
{
    $breadcrumbs->parent('approval_request');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_renja'), '', ['icon' => Lang::get('sidebar-nav.link_icon_renja')]);
});


Breadcrumbs::register('approval_request-capaian_bulanan', function($breadcrumbs)
{
    $breadcrumbs->parent('approval_request');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_capaian_bulanan'), '', ['icon' => Lang::get('sidebar-nav.link_icon_capaian_bulanan')]);
});

Breadcrumbs::register('approval_request-capaian_tahunan', function($breadcrumbs)
{
    $breadcrumbs->parent('approval_request');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_capaian_tahunan'), '', ['icon' => Lang::get('sidebar-nav.link_icon_capaian_tahunan')]);
});

Breadcrumbs::register('approval_request-skp_tahunan', function($breadcrumbs)
{
    $breadcrumbs->parent('approval_request');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_skp_tahunan'), '', ['icon' => Lang::get('sidebar-nav.link_icon_skp_tahunan')]);
});