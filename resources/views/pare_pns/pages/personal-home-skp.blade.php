@extends('pare_pns.layouts.dashboard')

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
				@include('pare_pns.modules.snapshots-boxes.personal-skp')

				@include('pare_pns.tables.personal-skp_jabatan')
	    </section>
	</div>
@stop