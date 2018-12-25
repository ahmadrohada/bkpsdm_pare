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
	$breadcrumbs->push(Lang::get('sidebar-nav.link_title_dashboard'), '/pare_2018/dashboard', ['icon' => Lang::get('sidebar-nav.link_icon_dashboard')]);
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


// DASHBOARD > SKPD >
Breadcrumbs::register('skpd', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_skpd'), '/SKPD', ['icon' => Lang::get('sidebar-nav.link_icon_skpd')]);
});

// DASHBOARD > SKPD > PEGAWAI >
Breadcrumbs::register('skpd-pegawai', function($breadcrumbs)
{
    $breadcrumbs->parent('skpd');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_pegawai'), '/Pegawai', ['icon' => Lang::get('sidebar-nav.link_icon_pegawai')]);
});

// DASHBOARD > SKPD > UNIT KERJA >
Breadcrumbs::register('skpd-unit_kerja', function($breadcrumbs)
{
    $breadcrumbs->parent('skpd');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_unit_kerja'), '/unit-kerja', ['icon' => Lang::get('sidebar-nav.link_icon_unit_kerja')]);
});


// DASHBOARD > SKPD > Renja >
Breadcrumbs::register('skpd-renja', function($breadcrumbs)
{
    $breadcrumbs->parent('skpd');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_renja'), '/renja', ['icon' => Lang::get('sidebar-nav.link_icon_renja')]);
});


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
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_perjanjian_kinerja'), '/pare_2018/skpd/perjanjian-kinerja', ['icon' => Lang::get('sidebar-nav.link_icon_perjanjian_kinerja')]);
});


// DASHBOARD >SKP TAHUNAN
Breadcrumbs::register('personal_skp_tahunan', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_skp_tahunan'), '/pare_2018/personal/skp-tahunan', ['icon' => Lang::get('sidebar-nav.link_icon_skp_tahunan')]);
});

Breadcrumbs::register('personal_edit_skp_tahunan', function($breadcrumbs)
{
    $breadcrumbs->parent('personal_skp_tahunan');
    $breadcrumbs->push(Lang::get('sidebar-nav.link_title_edit_skp_tahunan'), '', ['icon' => Lang::get('sidebar-nav.link_icon_edit_skp_tahunan')]);
});