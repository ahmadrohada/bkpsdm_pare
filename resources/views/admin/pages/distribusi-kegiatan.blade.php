@extends('admin.layouts.dashboard')

@section('template_title')
	{{ $user->username }}
@stop


@section('content')
	 <div class="content-wrapper">
	    <section class="content-header">

			<h1>
				Jenis Jabatan
			</h1>

			@if ( $modules == 'add_kegiatan')
				{!! Breadcrumbs::render('add_kegiatan') !!}
        	@else
				{!! Breadcrumbs::render('distribusi_kegiatan') !!}
			@endif
	    </section>
	    <section class="content">

			
				@include('admin.modules.jabatan-snapshots-boxes')


				@if ( $modules == 'data_table')
					@include('admin.tables.skpd-distribusi-kegiatan-list-datatable')
				@endif

				@if ( $modules == 'add_kegiatan')
					@include('admin.modules.add_kegiatan')
        		@endif
				
				
	    </section>
	</div>
@stop