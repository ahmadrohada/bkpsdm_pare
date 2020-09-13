@extends('pare_pns.layouts.dashboard')

@section('template_title')
	Showing User {{ $user->name }}
@endsection

@section('template_fastload_css')
@endsection

@section('content')
	 <div class="content-wrapper">
	    <section class="content-header">

			<h1>Showing {{ $user->name }}</h1>

            {!! Breadcrumbs::render('show_user_admin_view', $user) !!}

	    </section>
	    <section class="content">

			<ul>
				<li>
					<a href="{{ URL::to('users/create') }}">Create a User</a>
				</li>
			</ul>

			    	{{--
			    	@include('pare_pns.modules.profile-image-box-split-bg')
					--}}
			    	@include('pare_pns.modules.profile-image-box')
			    	{{--
					@include('pare_pns.modules.profile-image-box-w-bg')
			    	@include('pare_pns.modules.profile-about')
					--}}

			<div class="jumbotron text-center">
				<h2>{{ $user->name }}</h2>
				<p>
					<strong>Email:</strong> {{ $user->nip }}<br>
				</p>
			</div>


	    </section>
	</div>
@endsection

@section('template_scripts')

    @include('pare_pns.structure.dashboard-scripts')

@endsection