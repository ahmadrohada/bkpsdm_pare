@extends('pare_pns.layouts.dashboard')

@section('template_title')
	{{ $nama_skpd }}
@stop


@section('content')
	 <div class="content-wrapper">
	    <section class="content-header">

			<h1>
				 Perjanjian Kinerja
			</h1>

				{!! Breadcrumbs::render('sasaran') !!}
        
	    </section>
	    <section class="content">

					@include('pare_pns.detail_form.skpd-perjanjian_kinerja_sasaran')
					@include('pare_pns.tables.skpd-perjanjian_kinerja_indikator_sasaran')
				
				
	    </section>
	</div>
@stop