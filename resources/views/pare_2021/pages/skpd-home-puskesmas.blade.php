@extends('pare_pns.layouts.dashboard')

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

			{!! Breadcrumbs::render('skpd-puskesmas') !!}

	    </section>
	    <section class="content">

			
				@include('pare_pns.modules.snapshots-boxes.skpd-home')

 				@include('pare_pns.tables.skpd-puskesmas')
		
	    </section>
	</div>
@endsection

