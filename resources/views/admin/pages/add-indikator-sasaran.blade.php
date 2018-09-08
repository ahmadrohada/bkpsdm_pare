@extends('admin.layouts.dashboard')

@section('template_title')
	{{ $nama_skpd }}
@stop


@section('content')
	 <div class="content-wrapper">
	    <section class="content-header">

			<h1>
				Tambah Indikator
			</h1>

				{!! Breadcrumbs::render('sasaran') !!}
        
	    </section>
	    <section class="content">

			@include('admin.tables.skpd-sasaran-list')
			
				
				
	    </section>
	</div>
@stop