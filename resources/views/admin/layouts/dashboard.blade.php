{{-- Load Layout Body Classes --}}
<?php
	//$layoutBodybodyClasses = 'hold-transition skin-blue sidebar-mini fixed ';  // hover di side bar
	$layoutBodybodyClasses = 'sidebar-collapse hold-transition skin-pare  fixed sidebar-mini  sidebar-mini-expand-feature pace-done';  // tanpa hover
?>


@extends('admin.structure.master')

{{-- Load Auth Layout Head --}}
@section('layout-head')
    {{-- Load Common Admin Head --}}
	@include('admin.structure.head')
	@include('admin.partials.scripts')
@stop

{{-- Load Layout HEADER --}}
@section('layout-header')
	@include('admin.partials.header')
	@include('admin.partials.dashboard-sidebar')
@stop

{{-- Load Layout CONTENT --}}
@section('layout-content')
	@include('sweetalert::alert')
	@yield('content')
@stop


{{-- Load Dashobard FOOTER --}}
@section('layout-footer')
	@include('admin.partials.footer')
@stop

{{-- Load Layout SCRIPTS --}}
@section('layout-scripts')

	
	@yield('template_scripts')

@stop