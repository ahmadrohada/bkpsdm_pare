@extends('admin.layouts.dashboard')

@section('template_title')
	Renja
@stop


@section('content')
	 <div class="content-wrapper">
	    <section class="content-header">

			<h1>
				Rencana Kerja
			</h1>

				{!! Breadcrumbs::render('skpd-renja') !!}
        
	    </section>
	    <section class="content">

				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li class=" status"><a href="#status" data-toggle="tab">Status</a></li>
						<li class="detail"><a href="#detail" data-toggle="tab">Main Tab</a></li>
						<li class=" renja_tree"><a href="#renja_list" data-toggle="tab">Activity List</a></li>
						<li class="active distribusi_kegiatan"><a href="#distribusi_kegiatan" data-toggle="tab">Distribusi Kegiatan</a></li>
					</ul>
						
					<div class="tab-content"  style="margin-left:20px;">
						<div class=" tab-pane" id="status">
							@include('admin.modules.skpd-renja_status')
						</div>
						<div class="tab-pane" id="detail">
							@include('admin.modules.skpd-renja_detail')
						</div>
						
						<div class=" tab-pane" id="renja_list">
							@include('admin.modules.skpd-renja_tree_edit')
						</div>
						

						<div class="active tab-pane" id="distribusi_kegiatan">
							@include('admin.modules.skpd-renja_distribusi_kegiatan_edit')
						</div>
						
					</div>
						
				</div>
	    </section>
	</div>
@stop

