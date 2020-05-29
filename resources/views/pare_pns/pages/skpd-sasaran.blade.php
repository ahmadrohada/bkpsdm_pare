@extends('pare_pns.layouts.dashboard')

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


            @include('pare_pns.detail_form.skpd-sasaran')
            
			@include('pare_pns.tables.skpd-indikator-sasaran-list')
			
				
				
	    </section>
	</div>
@stop