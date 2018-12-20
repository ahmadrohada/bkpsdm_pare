@extends('admin.layouts.dashboard')

@section('template_title')
{{ Pustaka::nama_pegawai(\Auth::user()->pegawai->gelardpn , \Auth::user()->pegawai->nama , \Auth::user()->pegawai->gelarblk)  }}
@stop


@section('content')
	 <div class="content-wrapper">
	    <section class="content-header">
			<h1>
				SKP Tahunan
			</h1>
				{!! Breadcrumbs::render('personal_edit_skp_tahunan') !!}
      </section>
	    <section class="content">
			<div class="row">
				<div class="col-md-12">
					
					@include('admin.detail_form.skp_tahunan_detail')

					
					
				</div>
			</div>


				
	    </section>
	</div>
@stop