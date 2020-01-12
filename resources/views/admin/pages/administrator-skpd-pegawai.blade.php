@extends('admin.layouts.dashboard')

@section('template_title')
	Administrator
@endsection

@section('template_fastload_css')
@endsection

@section('content')
	 <div class="content-wrapper">
	    <section class="content-header">

			<h1>
				Administrator - SKPD
			</h1>

			{!! Breadcrumbs::render('skpd-pegawai') !!}

	    </section>
	    <section class="content">

			
				@include('admin.modules.snapshots-boxes.administrator-skpd')

 				@include('admin.tables.administrator-skpd-pegawai')
		 
	    </section>
	</div>
@endsection

