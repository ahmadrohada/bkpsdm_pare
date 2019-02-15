@extends('admin.layouts.dashboard')

@section('template_title')
	{{ $nama_skpd }}
@stop


@section('content')
	 <div class="content-wrapper">
	    <section class="content-header">
			<h1>
				Perjanjian Kinerja SKPD
			</h1>
				{!! Breadcrumbs::render('perjanjian_kinerja') !!}
      </section>
	    <section class="content">
				@include('admin.modules.skpd-home-snapshots-boxes')

				@include('admin.tables.skpd-perjanjian_kinerja')
	    </section>
	</div>
@stop