@extends('admin.layouts.dashboard')

@section('template_title')
	{{ $nama_skpd }}
@stop


@section('content')
	 <div class="content-wrapper">
	    <section class="content-header">
			<h1>
				SKP Tahunan SKPD
			</h1>
				{!! Breadcrumbs::render('skp_tahunan') !!}
      </section>
	    <section class="content">
				@include('admin.modules.skpd-home-snapshots-boxes')

				@include('admin.tables.skpd-skp_tahunan')
	    </section>
	</div>
@stop