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
				Data Pegawai
			</h1>

			{!! Breadcrumbs::render('users') !!}

	    </section>
	    <section class="content">

			
				@include('admin.modules.users-snapshots-boxes')

 				@include('admin.tables.skpd-users-list-datatable')
		
	    </section>
	</div>
@endsection

