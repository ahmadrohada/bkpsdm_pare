@extends('admin.layouts.dashboard')

@section('template_title')
	{{ $nama_skpd }}
@stop


@section('content')
	 <div class="content-wrapper">
	    <section class="content-header">

			<h1>
				Detail Sasaran
			</h1>

				{!! Breadcrumbs::render('sasaran') !!}
        
        </section>
        
       

	    <section class="content">


            @include('admin.detail_form.skpd-sasaran')
            
			@include('admin.tables.skpd-indikator-sasaran-list')
			
				
				
	    </section>
	</div>
@stop