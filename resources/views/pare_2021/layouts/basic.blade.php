{{-- Load Layout Body Classes --}}
{!!
	$layoutBodybodyClasses = '';
!!}

@extends('pare_pns.structure.master')

{{-- Load Auth Layout Head --}}
@section('layout-head')

    {{-- Load Common Admin Head --}}
	@include('pare_pns.structure.head')

	{{-- STYLESHEETS --}}
	{!! HTML::style(asset(''), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}

@stop

{{-- Load Layout Content --}}
@section('layout-content')

	@include('pare_pns.partials.main-nav')

	@yield('content')

@stop

{{-- Load Layout Scripts --}}
@section('layout-scripts')

	@include('pare_pns.partials.scripts')
	@yield('template_scripts')

@stop