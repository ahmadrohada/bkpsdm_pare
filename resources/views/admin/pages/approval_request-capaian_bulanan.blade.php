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
				{!! Breadcrumbs::render('approval_request-capaian_bulanan') !!}
      </section>
	    <section class="content">
				@include('admin.modules.snapshots-boxes.approval_request')

				@include('admin.tables.approval_request-capaian_bulanan')
	    </section>
	</div>
@stop