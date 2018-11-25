@extends('admin.layouts.dashboard')

@section('template_title')
		Administrator
@endsection

@section('template_fastload_css')
@endsection

@section('content')
	 <div class="content-wrapper">
	    <section class="content-header">

			<h1>
				Administrator
			</h1>

			{!! Breadcrumbs::render('users') !!}

	    </section>
	    <section class="content">

			
				@include('admin.modules.administrator-home-snapshots-boxes')

 				@include('admin.tables.administrator-users-list-datatable')
		
	    </section>
	</div>
@endsection

