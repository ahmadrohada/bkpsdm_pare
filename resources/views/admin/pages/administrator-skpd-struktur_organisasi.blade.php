@extends('admin.layouts.dashboard')

@section('template_title')
{{ Pustaka::capital_string($nama_skpd) }}
@endsection

@section('template_fastload_css')
@endsection

@section('content')
	 <div class="content-wrapper">
	    <section class="content-header">

			<h1>
				Administrator - SKPD
			</h1>

			{!! Breadcrumbs::render('admin-skpd-struktur_organisasi') !!}

	    </section>
	    <section class="content">

			
				@include('admin.modules.snapshots-boxes.administrator-skpd')

 				@include('admin.modules.administrator-skpd-struktur_organisasi')
		
	    </section>
	</div>
@endsection

