@extends('pare_pns.layouts.dashboard')

@section('template_title')
		Administrator - Cetak TPP Report
@endsection

@section('template_fastload_css')
@endsection

@section('content')
	 <div class="content-wrapper">
	    <section class="content-header">

			<h1>
				Cetak TPP Report
			</h1>

			{!! Breadcrumbs::render('admin-tpp_report_cetak') !!}

	    </section>
	    <section class="content">

			@include('pare_pns.modules.filter_cetak_TPP_report')
 			@include('pare_pns.tables.administrator-Cetak_TPP_report')
		
	    </section>
	</div>
@endsection

