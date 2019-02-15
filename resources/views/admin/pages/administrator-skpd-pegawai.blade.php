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
				{!! Pustaka::capital_string($nama_skpd) !!}
			</h1>

			{!! Breadcrumbs::render('skpd') !!}

	    </section>
	    <section class="content">

			
				@include('admin.modules.administrator-skpd-snapshots-boxes')

 				@include('admin.tables.skpd-pegawai')
		
	    </section>
	</div>
@endsection
