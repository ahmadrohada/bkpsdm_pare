<!DOCTYPE html> 
<html lang="id">
  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=yes" name="viewport">
    <title>@if (trim($__env->yieldContent('template_title')))@yield('template_title') | @endif {{ Lang::get('titles.app') }}</title>
    <meta name="description" content="">
    <meta name="author" content="BKPSDM Karawang">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{{ asset('public/assets/images/favicon.png') }}}">



	
    
  
    {{-- Load Layout Head --}}
    @yield('layout-head')
	
	

  </head>

  <body onunload="" class="{{ isset($layoutBodybodyClasses) ? $layoutBodybodyClasses : '' }} {{ isset($templateBodybodyClasses) ? $templateBodybodyClasses : '' }}">

   
    {{-- Load Layout HEADER --}}
    @yield('layout-header')

    {{-- Load Layout CONTENT --}}
    @yield('layout-content')

    {{-- Load Layout SIDEBAR --}}
    @yield('layout-sidebar')

    {{-- Load Layout FOOTER --}}
    @yield('layout-footer')

    {{-- Load Layout SCRIPTS --}}
    @yield('layout-scripts')


    

  </body>
</html>