@extends('admin.layouts.dashboard')

@section('template_title')
{{ Pustaka::capital_string($skpd->skpd) }}
@stop


@section('content')
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			{{ Pustaka::capital_string($nama_skpd) }}
		</h1>
		{!! Breadcrumbs::render('skpd-tpp_report') !!}
	</section>
	<section class="content">
		@include('admin.modules.snapshots-boxes.skpd-home')

		@include('admin.tables.skpd-tpp_report_list')

		
	</section>
</div>
@stop