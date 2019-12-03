@extends('admin.layouts.dashboard')

@section('template_title')
		Administrator - TPP Report
@endsection

@section('template_fastload_css')
@endsection

@section('content')
	 <div class="content-wrapper">
	    <section class="content-header">

			<h1>
				Administrator
			</h1>

			{!! Breadcrumbs::render('tpp_report') !!}

	    </section>
	    <section class="content">

			@include('admin.modules.filter_cetak_TPP_report')
 			@include('admin.tables.administrator-TPP_report')
		
	    </section>
	</div>
@endsection

