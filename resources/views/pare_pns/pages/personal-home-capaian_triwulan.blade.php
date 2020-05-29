@extends('pare_pns.layouts.dashboard')

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
				@include('pare_pns.modules.snapshots-boxes.personal-capaian')

				@include('pare_pns.tables.personal-capaian_triwulan')
	    </section>
	</div> 
@stop