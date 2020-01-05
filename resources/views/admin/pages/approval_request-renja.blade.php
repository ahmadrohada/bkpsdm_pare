@extends('admin.layouts.dashboard')

@section('template_title')
	{{ $nama_skpd }}
@stop


@section('content')
	 <div class="content-wrapper">
	    <section class="content-header">
			<h1>
				Approval Request
			</h1>
				{!! Breadcrumbs::render('approval_request-renja') !!}
      </section>
	    <section class="content">
				@include('admin.modules.snapshots-boxes.approval_request')

				@include('admin.tables.approval_request-renja')
	    </section>
	</div>
@stop