@extends('pare_pns.layouts.dashboard')

@section('template_title')
	Edit your profile
@endsection

@section('template_fastload_css')
@endsection

@section('content')
	 <div class="content-wrapper">
	    <section class="content-header">
			<h1>
				{{ Lang::get('profile.editProfileTitle',['username' => $displayusername] ) }}
				<small> {{ Lang::get('pages.dashboard-access-level',['access' => $access] ) }} </small>
			</h1>

            {!! Breadcrumbs::render('profile_edit', $user) !!}

	    </section>
	    <section class="content">
			<div class="row">

				{{-- LEFT/TOP COLUMN --}}
				<div class="col-lg-8 col-md-12 col-sm-12">
					@if ($user->profile)
						@if (Auth::user()->id == $user->id)
							@include('pare_pns.partials.return-callouts')
							@include('pare_pns.modules.profile-image-box-split-bg')
							@include('pare_pns.forms.edit-profile-form')
						@else
							<p>{{ Lang::get('profile.notYourProfile') }}</p>
						@endif
					@else
						<p>{{ Lang::get('profile.noProfileYet') }}</p>
						{!! HTML::link(url('/profile/'.Auth::user()->name.'/edit'), Lang::get('titles.createProfile')) !!}
					@endif
				</div>

			    {{-- RIGHT/BOTTOM COLUMN --}}
			    <div class="col-lg-4 col-md-12 col-sm-12">
			    	@include('pare_pns.modules.profile-basics')
			    	@include('pare_pns.modules.profile-about')
			    </div>

			</div>
	    </section>
	</div>

	@include('pare_pns.modals.confirm-save')

@endsection

@section('template_scripts')

	@include('pare_pns.structure.dashboard-scripts')
	@include('scripts.address-lookup-g-api')
	@include('scripts.modals')

@endsection
