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

			{!! Breadcrumbs::render('masa_pemerintahan') !!}

	    </section>
	    <section class="content">

			
				@include('admin.modules.snapshots-boxes.administrator-home')

 				@include('admin.tables.administrator-masa_pemerintahan-list-datatable')
		
	    </section>
	</div>
@endsection

