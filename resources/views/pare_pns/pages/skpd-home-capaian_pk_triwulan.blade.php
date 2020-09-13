@extends('pare_pns.layouts.dashboard')

@section('template_title')
Capaian PK {{ Pustaka::capital_string($nama_skpd) }} 
@endsection

@section('template_fastload_css')
@endsection

@section('content')
	 <div class="content-wrapper">
	    <section class="content-header">

			<h1>
				Capaian PK - {{ Pustaka::capital_string($nama_skpd) }}
			</h1>

			{!! Breadcrumbs::render('skpd-capaian_pk_triwulan') !!}

	    </section>
	    <section class="content">

			
				@include('pare_pns.modules.snapshots-boxes.skpd-capaian_pk')

 				@include('pare_pns.tables.skpd-capaian_pk_triwulan')
		
	    </section>
	</div>
@endsection

