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
			{{ Pustaka::capital_string($nama_skpd) }}
			</h1>

			{!! Breadcrumbs::render('skpd-pohon_kinerja') !!}

	    </section>
	    <section class="content">

			
				@include('admin.modules.snapshots-boxes.skpd-home')

 				@include('admin.tables.skpd-renja')
		
	    </section>
	</div>
@endsection

