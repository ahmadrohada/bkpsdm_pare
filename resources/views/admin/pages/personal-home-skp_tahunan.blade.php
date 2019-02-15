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
				{!! Breadcrumbs::render('skp_tahunan') !!}
      </section>
	    <section class="content">
				@include('admin.modules.personal-home-snapshots-boxes')

				@include('admin.tables.personal-skp_tahunan')
	    </section>
	</div>
@stop