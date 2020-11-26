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
				{!! Breadcrumbs::render('indikator_sasaran') !!}
        </section>
	    <section class="content">
            @include('pare_pns.detail_form.skpd-perjanjian_kinerja')
						
	    </section>
	</div>
@stop