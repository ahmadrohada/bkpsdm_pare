@extends('pare_pns.layouts.dashboard')

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
				@include('pare_pns.modules.snapshots-boxes.approval_request')

				@include('pare_pns.tables.approval_request-renja')
	    </section>
	</div>
@stop