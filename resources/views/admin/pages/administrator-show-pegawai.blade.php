@extends('admin.layouts.dashboard')

@section('template_title')
	{{ $user->username }}
@endsection

@section('template_fastload_css')
@endsection

@section('content')
	 <div class="content-wrapper">
	    <section class="content-header">

			<h1>
				Data Pegawai Pemkab Karawang
			</h1>

			{!! Breadcrumbs::render('users') !!}

	    </section>
	    <section class="content">

			
				@include('admin.modules.administrator-pegawai-snapshots-boxes')

 				@include('admin.tables.administrator-pegawai-list-datatable')
		
	    </section>
	</div>
@endsection

