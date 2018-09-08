@extends('admin.layouts.dashboard')

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

					@include('admin.detail_form.skpd-perjanjian_kinerja_sasaran')
					@include('admin.tables.skpd-perjanjian_kinerja_indikator_sasaran')
				
				
	    </section>
	</div>
@stop