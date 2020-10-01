@extends('pare_pns.layouts.dashboard')

@section('template_title')
		Administrator
@endsection

@section('template_fastload_css')
@endsection

@section('content')
	 <div class="content-wrapper">
	    <section class="content-header">

			<h1>
				Administrator
			</h1>

			{!! Breadcrumbs::render('admin-capaian_pk_tahunan') !!}

	    </section>
	    <section class="content">

			
				@include('pare_pns.modules.snapshots-boxes.administrator-capaian_pk')

 				@include('pare_pns.tables.administrator-capaian_pk_triwulan')
		
	    </section>
	</div>
@endsection

