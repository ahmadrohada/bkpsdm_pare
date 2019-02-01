@extends('admin.layouts.dashboard')

@section('template_title')
	{{ $user->username }}
@stop


@section('content')
	 <div class="content-wrapper">
	    <section class="content-header">
			<h1>
				SKP Tahunan
			</h1>
				{!! Breadcrumbs::render('personal_skp_tahunan') !!}
      </section>
	    <section class="content">
				@include('admin.tables.personal-skp_tahunan')
	    </section>
	</div>
@stop