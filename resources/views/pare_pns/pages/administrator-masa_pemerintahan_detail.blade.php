@extends('pare_pns.layouts.dashboard')

@section('template_title')
	Renja
@stop


@section('content')
	 <div class="content-wrapper">
	    <section class="content-header">

			<h1>
				Masa Pemerintahan
			</h1>

				{!! Breadcrumbs::render('masa_pemerintahan') !!}
        
	    </section>
	    <section class="content">

				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li class="active detail"><a href="#detail" data-toggle="tab">Detail</a></li>
						<li class="masa_pemerintahan"><a href="#masa_pemerintahan" data-toggle="tab">Perjanjian Kinerja</a></li>
					</ul>
						
					<div class="tab-content"  style="margin-left:20px;">
						<div class="active tab-pane fade" id="detail">
							@include('pare_pns.modules.detail_forms.administrator-masa_pemerintahan')
						</div>
						
						<div class=" tab-pane fade" id="masa_pemerintahan">
							@include('pare_pns.modules.detail_forms.administrator-masa_pemerintahan_tree')
						</div>
						
						
					</div>
						
				</div>
	    </section>
	</div>
@stop

