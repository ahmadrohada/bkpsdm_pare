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
				Administrator - SKPD
			</h1>

			{!! Breadcrumbs::render('admin-skpd-pegawai') !!}

	    </section>
	    <section class="content">

			
				@include('pare_pns.modules.snapshots-boxes.administrator-skpd')

 				@include('pare_pns.tables.administrator-skpd-pegawai')
		 
	    </section>
	</div>
@endsection

