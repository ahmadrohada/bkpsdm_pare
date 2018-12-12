@extends('admin.layouts.dashboard')

@section('template_title')
	tes
@stop


@section('content')
	 <div class="content-wrapper">
	    <section class="content-header">

			<h1>
				Rencana Kerja Perangkat Daerah
			</h1>

				{!! Breadcrumbs::render('sasaran') !!}
        
	    </section>
	    <section class="content">

			<div class="row">
        		<div class="col-md-3">
				
					@include('admin.modules.blank')


				</div>
				<div class="col-md-9">
				@include('admin.modules.blank')
					
				</div>
			</div>

					
					
				
				
	    </section>
	</div>
@stop