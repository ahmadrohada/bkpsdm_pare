@extends('admin.layouts.dashboard')

@section('template_title')
	RKPD
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
				
					@include('admin.detail_form.skpd-perjanjian_kinerja_breadcrumb')


				</div>
				<div class="col-md-9">
					@if ( $form_name == 'sasaran')
						@include('admin.tables.skpd-perjanjian_kinerja_sasaran')
					@endif

					@if ( $form_name == 'indikator_sasaran')
						@include('admin.tables.skpd-perjanjian_kinerja_indikator_sasaran')
					@endif

					@if ( $form_name == 'program')
						@include('admin.tables.skpd-perjanjian_kinerja_program')
					@endif

					@if ( $form_name == 'indikator_program')
						@include('admin.tables.skpd-perjanjian_kinerja_indikator_program')
					@endif

					@if ( $form_name == 'kegiatan')
						@include('admin.tables.skpd-perjanjian_kinerja_kegiatan')
					@endif

					@if ( $form_name == 'indikator_kegiatan')
						@include('admin.tables.skpd-perjanjian_kinerja_indikator_kegiatan')
					@endif
					
				</div>
			</div>

					
					
				
				
	    </section>
	</div>
@stop