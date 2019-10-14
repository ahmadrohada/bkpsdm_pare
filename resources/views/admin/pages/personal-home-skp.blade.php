@extends('admin.layouts.dashboard')

@section('template_title')
	{{ $nama_pegawai }}
@stop

 
@section('content')
	 <div class="content-wrapper">
	    <section class="content-header">
			<h1>
				SKP Personal
			</h1>
				{!! Breadcrumbs::render('skp') !!}
      </section>
	    <section class="content">
				@include('admin.modules.personal-skp-snapshots-boxes')

				@include('admin.tables.personal-skp_jabatan')
	    </section>
	</div>
@stop