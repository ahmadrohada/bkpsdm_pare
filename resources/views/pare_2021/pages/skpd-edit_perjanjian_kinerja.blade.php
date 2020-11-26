@extends('pare_pns.layouts.dashboard')

@section('template_title')
	{{ $skpd->unit_kerja }}
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

			<div class="row">
        		<div class="col-md-3">
				
					@include('pare_pns.detail_form.skpd-perjanjian_kinerja_breadcrumb')


				</div>
				<div class="col-md-9">
					@if ( $form_name == 'sasaran')
						@include('pare_pns.tables.skpd-perjanjian_kinerja_sasaran')
					@endif

					@if ( $form_name == 'indikator_sasaran')
						@include('pare_pns.tables.skpd-perjanjian_kinerja_indikator_sasaran')
					@endif

					@if ( $form_name == 'program')
						@include('pare_pns.tables.skpd-perjanjian_kinerja_program')
					@endif

					@if ( $form_name == 'indikator_program')
						@include('pare_pns.tables.skpd-perjanjian_kinerja_indikator_program')
					@endif

					@if ( $form_name == 'kegiatan')
						@include('pare_pns.tables.skpd-perjanjian_kinerja_kegiatan')
					@endif

					@if ( $form_name == 'indikator_kegiatan')
						@include('pare_pns.tables.skpd-perjanjian_kinerja_indikator_kegiatan')
					@endif
					
				</div>
			</div>

					
					
				
				
	    </section>
	</div>
@stop