{{-- Set Template Body Classes --}}
<?php
	$templateBodybodyClasses = 'login-page';
?>

@extends('admin.layouts.auth')

@section('template_title')
	Login
@endsection

@section('template_fastload_css')
@endsection

@section('content')
    <div class="login-box">
		<div class="login-logo">
			
			<img src="{{asset('assets/images/form/logo.png')}}" >
			
			<h3 class="visible-lg visible-md  login-header" style="color:#077821;">Performance Agreement Report by Electronic</h3>
			<h4 class="visible-sm visible-xs  login-header" style="color:#077821;">Performance Agreement Report by Electronic</h4>
		
			
			
			
		</div>
		<div class="login-box-body">

			<h4 class="login-box-msg">
			  	{{-- Lang::get('auth.login') --}}
			</h4>

			@include('admin.forms.login-form')

			

			 <hr class="login-full-span">

		<div class="row btn-block">
			<div class="col-xs-12">
				{!! HTML::icon_link( "/register", 'fa fa-'.Lang::get('auth.register_icon'), Lang::get('auth.register'), array('title' => Lang::get('auth.register'))) !!}
			</div>
		</div>

		<div class="row btn-block">
			<div class="col-xs-12">
				{!! HTML::icon_link( "/password/email", 'fa fa-'.Lang::get('auth.forgot_icon'), Lang::get('auth.forgot'), array('title' => Lang::get('auth.forgot'), 'id' => 'forgot')) !!}
			</div>
		</div>

			

      	</div>
    </div>
@endsection

@section('template_scripts')

	{!! HTML::script('/assets/js/login.js', array('type' => 'text/javascript')) !!}
	@include('scripts.checkbox');
	@include('scripts.show-hide-passwords');

@endsection