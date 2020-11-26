@extends('pare_pns.layouts.dashboard')

@section('template_title')
	{{ $user->username }}
@endsection

@section('template_fastload_css')
@endsection

@section('content')
	 <div class="content-wrapper">
	    <section class="content-header">

			<h1>
				Show Users <small> {{ $access }} </small>
			</h1>

			{!! Breadcrumbs::render('users') !!}

	    </section>
	    <section class="content">

			
				@include('pare_pns.modules.users-snapshots-boxes')

 				@include('pare_pns.modules.admin-users-list-datatable')
		
	    </section>
	</div>
@endsection

