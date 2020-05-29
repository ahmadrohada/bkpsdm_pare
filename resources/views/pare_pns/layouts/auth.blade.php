{{-- Load Layout Body Classes --}}
<?php
	$layoutBodybodyClasses = 'hold-transition skin-blue sidebar-mini';
?>

@extends('pare_pns.structure.master')

{{-- Load Auth Layout Head --}}
@section('layout-head')

    {{-- Load Common Admin Head --}}
	@include('pare_pns.structure.head')


@stop

@section('layout-content')

	@yield('content')

@stop

{{-- Load Layout Scripts --}}
@section('layout-scripts')

	@yield('template_scripts')

@stop