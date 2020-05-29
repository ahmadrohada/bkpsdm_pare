@extends('pare_pns.layouts.dashboard')

@section('template_title')
	Showing User {{ $user->name }}
@endsection

@section('template_fastload_css')
@endsection

@section('content')
	 <div class="content-wrapper">
	    <section class="content-header">

	    	<h1>
	    		Edit {{ $user->name }}
	    	</h1>

			{!! Breadcrumbs::render('edit_user_admin_view', $user) !!}

	    </section>
	    <section class="content">

			@include('pare_pns.modules.profile-image-box-w-bg')

			@include('pare_pns.forms.edit-user-admin')

	    </section>
	</div>

	@include('pare_pns.modals.confirm-save')

@endsection

@section('template_scripts')

    @include('pare_pns.structure.dashboard-scripts')
	@include('scripts.modals')

@endsection