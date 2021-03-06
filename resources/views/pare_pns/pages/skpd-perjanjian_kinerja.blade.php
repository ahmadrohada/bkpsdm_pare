@extends('pare_pns.layouts.dashboard')

@section('template_title')
	Renja
@stop


@section('content')
	 <div class="content-wrapper">
	    <section class="content-header">

			<h1>
				Perjanjian Kinerja
			</h1>

				{!! Breadcrumbs::render('skpd-pohon_kinerja') !!}
        
	    </section>
	    <section class="content">

				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li class="active status"><a href="#status" data-toggle="tab">Status</a></li>
						<li class="detail"><a href="#detail" data-toggle="tab">Main Tab</a></li>
						<li class="renja_tree"><a href="#renja_list" data-toggle="tab">Activity List</a></li>
						<li class="distribusi_kegiatan"><a href="#distribusi_kegiatan" data-toggle="tab">Distribusi Kegiatan</a></li>
					</ul>
						
					<div class="tab-content"  style="margin-left:20px;">
						<div class="active tab-pane fade" id="status">
							@include('pare_pns.modules.skpd-perjanjian_kinerja_status')
						</div>
						<div class="tab-pane fade" id="detail">
							@include('pare_pns.modules.skpd-perjanjian_kinerja_detail')
						</div>
						
						<div class="tab-pane fade" id="renja_list">
							@include('pare_pns.modules.skpd-perjanjian_kinerja_tree')
						</div>
						

						<div class="tab-pane fade" id="distribusi_kegiatan">
							@include('pare_pns.modules.skpd-renja_distribusi_kegiatan')
						</div>
						
					</div>
						
				</div>
	    </section>
	</div>
@stop

