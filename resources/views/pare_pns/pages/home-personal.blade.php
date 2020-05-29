@extends('pare_pns.layouts.dashboard')

@section('template_title')
	Welcome {{ $user->username }}
@endsection

@section('template_fastload_css')
@endsection

@section('content')
	 <div class="content-wrapper">
	    <section class="content-header">

			<h1>
				<!-- {{ Lang::get('pages.dashboard-welcome',['username' => Pustaka::nama_pegawai(\Auth::user()->pegawai->gelardpn , \Auth::user()->pegawai->nama , \Auth::user()->pegawai->gelarblk)] ) }} -->
				Dashboard
			</h1>

			{!! Breadcrumbs::render() !!}

	    </section>
	    <section class="content">

			<div class="row">

				{{-- LEFT/TOP COLUMN --}}
			    <div class="col-lg-5 col-md-5 col-sm-12">

			    	@include('pare_pns.modules.dashboard-profile-image-box')
					<!--
			    	@include('pare_pns.modules.weather.local-weather-card')
					-->
			    </div>


				{{-- LEFT/TOP COLUMN --}}
				<div class="col-lg-7 col-md-7 col-sm-12">
			 		 @include('pare_pns.modules.personal-callout-info')
					 @include('pare_pns.modules.welcome-info')
				</div>
			</div>

	    </section>
	</div>
@endsection

@section('template_scripts')

    @include('pare_pns.structure.dashboard-scripts')

@endsection