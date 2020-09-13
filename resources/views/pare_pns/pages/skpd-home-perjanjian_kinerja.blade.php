@extends('pare_pns.layouts.dashboard')

@section('template_title')
	{{ $nama_skpd }}
@stop


@section('content')
	 <div class="content-wrapper">
	    <section class="content-header">
			<h1>
				Perjanjian Kinerja SKPD
			</h1>
				{!! Breadcrumbs::render('skpd-perjanjian_kinerja') !!}
      </section>
	    <section class="content">
				@include('pare_pns.modules.snapshots-boxes.skpd-home')

				@include('pare_pns.tables.skpd-perjanjian_kinerja')
	    </section>
	</div>
@stop