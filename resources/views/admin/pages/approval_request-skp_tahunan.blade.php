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
				{!! Breadcrumbs::render('approval_request-skp_tahunan') !!}
      </section>
	    <section class="content">
				@include('admin.modules.approval_request-snapshots-boxes')

				@include('admin.tables.approval_request-skp_tahunan')
	    </section>
	</div>
@stop