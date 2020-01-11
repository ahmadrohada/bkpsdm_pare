@extends('admin.layouts.dashboard')

@section('template_title')
	{{ $nama_pegawai }}
@stop


@section('content')
	 <div class="content-wrapper">
	    <section class="content-header">
			<h1>
				Capaian SKP Personal
			</h1>
				{!! Breadcrumbs::render('capaian_bulanan') !!}
      </section>
	    <section class="content">
				@include('admin.modules.snapshots-boxes.personal-capaian')

				@include('admin.tables.personal-capaian_bulanan')
	    </section>
	</div> 
@stop