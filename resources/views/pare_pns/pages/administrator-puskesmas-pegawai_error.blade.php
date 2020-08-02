@extends('pare_pns.layouts.dashboard')

@section('template_title')
	Administrator
@endsection

@section('template_fastload_css')
@endsection

@section('content')
	 <div class="content-wrapper">
	    <section class="content-header">

			<h1>
				Administrator - PUSKESMAS
			</h1>

			{!! Breadcrumbs::render('admin-puskesmas-pegawai') !!}

	    </section>
	    <section class="content">

			
				@include('pare_pns.modules.snapshots-boxes.administrator-puskesmas')

 				@include('pare_pns.tables.administrator-puskesmas-pegawai_error')
		 
	    </section>
	</div>
@endsection

