{{-- Set Template Body Classes --}}
<?php
	$templateBodybodyClasses = 'login-page tes';
?>

@extends('pare_pns.layouts.auth')

@section('template_title')
	Login
@endsection

@section('template_fastload_css')
.tes{
	background-image:url({{asset('assets/images/pare_bg.jpg')}} ) ;
	-webkit-background-size: cover;
  	-moz-background-size: cover;
  	-o-background-size: cover;
  	background-size: cover;
	background-repeat: no-repeat;
  	background-attachment: fixed;
	background-position: right center; 
	padding-top:80px;
	
	
}

.box-login-style{
	-webkit-box-shadow: 3px 4px 11px 0px rgba(0,0,0,0.41);
	-moz-box-shadow: 3px 4px 11px 0px rgba(0,0,0,0.41);
	box-shadow: 3px 4px 11px 0px rgba(0,0,0,0.41);
	border-radius: 5px !important;
	padding:20px;
	background-color:rgba(255,255, 255, 0.2);
	{{-- width:380px; --}}
	
}

@media screen and ( max-width:700px){
	.box-login-style{
		-webkit-box-shadow: 0px 0px 0px 0px rgba(0,0,0,0);
		-moz-box-shadow: 0px 0px 0px 0px rgba(0,0,0,0);
		box-shadow: 0px 0px 0px 0px rgba(0,0,0,0);
		border: none !important;
		padding:20px;
		background-color:rgba(255,255, 255, 0);
	
	}
}


@endsection
@section('content')
    <div class="login-box box-login-style">
		<div class="login-logo">
			<img src="{{asset('public/assets/images/form/logo.png')}}" >
			<h3 class="visible-lg visible-md  login-header" style="color:#077821; text-shadow: 1px 1px 2px white, 0 0 25px white, 0 0 5px white;">Performance Agreement Report by Electronic</h3>
			<h4 class="visible-sm visible-xs  login-header" style="color:#077821; text-shadow: 1px 1px 2px white, 0 0 25px white, 0 0 5px white;">Performance Agreement Report by Electronic</h4>
		
		</div>
		<div class="login-box-body" style="border-radius: 3px !important; background-color:rgba(255,255, 255, 0.3);">

			@include('pare_pns.partials.return-messages')
			<h4 class="login-box-msg">
			  	{{-- Lang::get('auth.login') --}}
			</h4>
			@include('pare_pns.forms.login-form')
			<hr>
		  </div>
    </div>
@endsection

@section('template_scripts')

	{!! HTML::script('public/assets/js/login.js', array('type' => 'text/javascript')) !!}
	@include('scripts.checkbox')
	@include('scripts.show-hide-passwords')

@endsection