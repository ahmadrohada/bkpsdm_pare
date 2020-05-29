@extends('pare_pns.layouts.dashboard')

@section('template_title')
	Welcome {{ $user->nama }}
@endsection

@section('template_fastload_css')
@endsection

@section('content')
	 <div class="content-wrapper">
	    <section class="content-header">

			<h1>
				{{ Lang::get('pages.dashboard-welcome',['username' => $user->nama] ) }} <small> {{ Lang::get('pages.dashboard-access-level',['access' => $access] ) }} </small>
			</h1>

			{!! Breadcrumbs::render() !!}

	    </section>
	    <section class="content">

			<div class="row">

				{{-- LEFT/TOP COLUMN --}}
			    <div class="col-lg-4 col-md-5 col-sm-12">

			    	@include('pare_pns.modules.profile-image-box')
					<!--
			    	@include('pare_pns.modules.weather.local-weather-card')
					-->
			    </div>


				{{-- LEFT/TOP COLUMN --}}
				<div class="col-lg-8 col-md-7 col-sm-12">

					@include('pare_pns.modules.welcome-msg')
					@include('pare_pns.modules.twitter.twitter-user-home-timeline')

				</div>
			</div>

	    </section>
	</div>
@endsection

@section('template_scripts')

    @include('pare_pns.structure.dashboard-scripts')

@endsection