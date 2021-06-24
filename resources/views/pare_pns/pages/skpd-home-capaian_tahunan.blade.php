@extends('pare_pns.layouts.dashboard')

@section('template_title')
	{{ $nama_skpd }}
@stop


@section('content')
	 <div class="content-wrapper">
	    <section class="content-header">
			<h1>
				Capaian Tahunan SKPD
			</h1>
      </section>
	    <section class="content">
				@include('pare_pns.modules.snapshots-boxes.skpd-home')

				@include('pare_pns.tables.skpd-capaian_tahunan')
	    </section>
	</div>
@stop