@extends('admin.layouts.dashboard')

@section('template_title')
{{ Pustaka::capital_string($skpd->skpd) }}
@stop


@section('content')
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			REPORT
		</h1>
		{!! Breadcrumbs::render('personal_skp_tahunan') !!}
	</section>
	<section class="content">
		@include('admin.modules.snapshots-boxes.skpd-report')

		@include('admin.tables.skpd-tpp_report_list')

		
	</section>
</div>
@stop