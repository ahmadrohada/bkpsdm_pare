@extends('pare_pns.layouts.dashboard')

@section('template_title')
	{{ Pustaka::capital_string($nama_puskesmas) }}
@endsection

@section('template_fastload_css')
@endsection

@section('content')
	 <div class="content-wrapper">
	    <section class="content-header">

			<h1>
			{{ Pustaka::capital_string($nama_puskesmas) }}
			</h1>

			{!! Breadcrumbs::render('puskesmas-pegawai') !!}

	    </section>
	    <section class="content">

			
				@include('pare_pns.modules.snapshots-boxes.puskesmas-home')

 				@include('pare_pns.tables.puskesmas-pegawai')
		
	    </section>
	</div>
@endsection

