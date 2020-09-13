@extends('pare_pns.layouts.dashboard')

@section('template_title')
	{{ $nama_pegawai }}
@stop


@section('content')
	 <div class="content-wrapper">
	    <section class="content-header">
			<h1>
				Personal Dashboard
			</h1>
				{!! Breadcrumbs::render('dashboard') !!}
      </section>
	    <section class="content">
				@include('pare_pns.modules.snapshots-boxes.personal-home')

	    </section>
	</div>
@stop