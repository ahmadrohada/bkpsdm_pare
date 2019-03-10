@extends('admin.layouts.dashboard')

@section('template_title')
	{{ $nama_skpd }}
@stop


@section('content')
	 <div class="content-wrapper">
	    <section class="content-header">
			<h1>
				SKP Tahunan Personal
			</h1>
				{!! Breadcrumbs::render('capaian_bulanan') !!}
      </section>
	    <section class="content">
				@include('admin.modules.personal-home-snapshots-boxes')

				@include('admin.tables.personal-capaian_bulanan')
	    </section>
	</div>
@stop