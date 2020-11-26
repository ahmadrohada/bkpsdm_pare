{{-- Load Layout Body Classes --}}
<?php
	//$layoutBodybodyClasses = 'hold-transition skin-blue sidebar-mini fixed ';  // hover di side bar
	$layoutBodybodyClasses = 'hold-transition skin-blue sidebar-mini';  // tanpa hover
?>

@extends('pare_pns.structure.master')

{{-- Load Auth Layout Head --}}
@section('layout-head')
    {{-- Load Common Admin Head --}}
	@include('pare_pns.structure.head')
@stop

{{-- Load Layout HEADER --}}
@section('layout-header')
	@include('pare_pns.partials.header')
	@include('pare_pns.partials.dashboard-sidebar')
@stop

{{-- Load Layout CONTENT --}}
@section('layout-content')
	@yield('content')
@stop

{{-- Load Layout SIDEBAR  --}}
@section('layout-sidebar')
	@include('pare_pns.modules.control-sidebar')
@stop


{{-- Load Dashobard FOOTER --}}
@section('layout-footer')
	@include('pare_pns.partials.footer')
@stop

{{-- Load Layout SCRIPTS --}}
@section('layout-scripts')

	@include('pare_pns.partials.scripts')



	@yield('template_scripts')

@stop