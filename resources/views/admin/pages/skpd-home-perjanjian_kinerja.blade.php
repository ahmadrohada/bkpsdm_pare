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
				{!! Breadcrumbs::render('skpd-perjanjian_kinerja') !!}
      </section>
	    <section class="content">
				@include('admin.modules.snapshots-boxes.skpd-home')

				@include('admin.tables.skpd-perjanjian_kinerja')
	    </section>
	</div>
@stop