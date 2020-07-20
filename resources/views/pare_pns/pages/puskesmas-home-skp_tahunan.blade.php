@extends('pare_pns.layouts.dashboard')

@section('template_title')
	{{ $nama_puskesmas }}
@stop


@section('content')
	 <div class="content-wrapper">
	    <section class="content-header">
			<h1>
				SKP Tahunan Puskesmas
			</h1>
				{!! Breadcrumbs::render('puskesmas-skp_tahunan') !!}
      </section>
	    <section class="content">
				@include('pare_pns.modules.snapshots-boxes.puskesmas-home')

				@include('pare_pns.tables.puskesmas-skp_tahunan')
	    </section>
	</div>
@stop