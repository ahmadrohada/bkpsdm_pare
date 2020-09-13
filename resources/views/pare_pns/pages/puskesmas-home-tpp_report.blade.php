@extends('pare_pns.layouts.dashboard')

@section('template_title')
{{ Pustaka::capital_string($nama_puskesmas) }}
@stop


@section('content')
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			{{ Pustaka::capital_string($nama_puskesmas) }}
		</h1>
		{!! Breadcrumbs::render('skpd-tpp_report') !!}
	</section>
	<section class="content">
		@include('pare_pns.modules.snapshots-boxes.puskesmas-home')

		@include('pare_pns.tables.puskesmas-tpp_report_list')

		
	</section>
</div>
@stop