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
				{!! Breadcrumbs::render('capaian_triwulan') !!}
      </section>
	    <section class="content">
				@include('admin.modules.personal-capaian-snapshots-boxes')

				@include('admin.tables.personal-capaian_triwulan')
	    </section>
	</div> 
@stop