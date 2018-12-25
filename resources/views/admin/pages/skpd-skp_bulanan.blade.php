@extends('admin.layouts.dashboard')

@section('template_title')
{{ Pustaka::nama_pegawai(\Auth::user()->pegawai->gelardpn , \Auth::user()->pegawai->nama , \Auth::user()->pegawai->gelarblk)  }}
@stop


@section('content')
	 <div class="content-wrapper">
	    <section class="content-header">
			<h1>
				SKP Bulanan
			</h1>
				{!! Breadcrumbs::render('skp_bulanan') !!}
      </section>
	    <section class="content">
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs">
				<li class="active status"><a href="#status" data-toggle="tab">Status</a></li>
				<li class="detail"><a href="#detail" data-toggle="tab">Detail</a></li>
				<li class="kegiatan_tugas_jabatan"><a href="#kegiatan_tugas_jabatan" data-toggle="tab">Uraian Tugas Jabatan</a></li>
			</ul>
								
			<div class="tab-content"  style="margin-left:20px; min-height:450px;">
				<div class="active tab-pane" id="status">
					@include('admin.modules.skpd-skp_bulanan_status')	
				</div>
				<div class="tab-pane" id="detail">
					@include('admin.modules.skpd-skp_bulanan_detail')				
				</div>
								
				<div class=" tab-pane" id="kegiatan_tugas_jabatan">
					@include('admin.tables.skp_bulanan-kegiatan_tugas_jabatan')				
				</div>
								
			

			</div>			
		</div>
				




			
	    </section>
	</div>
@stop