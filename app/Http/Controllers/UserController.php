<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;



class UserController extends Controller
{

//NEW AUTH

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
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

        if(isset($dashboard))
        {
            return view('admin.pages.home-'.$dashboard)->withUser($user)->withAccess($access);
        }else{
            \Auth::logout();
            return redirect('auth/login')->with('status', 'Roles is Unidentified');
        }
       
      
        
        
    }

    public function getHome()
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
            $access = 'admin-skpd';
			$dashboard = 'skpd';
        } elseif ($adminRole) {
            $access = 'Administrator';
			$dashboard = 'administrator';
        }

        return view('admin.pages.home-'.$dashboard);
    }

//OLD LTE

    /**
    * Show the User DASHBOARD Page
    *
    * @return View
    */
    public function showUserDashboard()
    {
        return view('admin.layouts.dashboard');
    }

    /**
    * Show the User PROFILE Page
    *
    * @return View
    */
    public function showUserProfile()
    {
        return view('admin.layouts.user-profile');
    }

    public function show($id)
    {
        //
    }

}
