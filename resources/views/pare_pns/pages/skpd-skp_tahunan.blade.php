@extends('pare_pns.layouts.dashboard')

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
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs">
				<li class="active status"><a href="#status" data-toggle="tab">Status</a></li>
				<li class="detail"><a href="#detail" data-toggle="tab">Detail</a></li>
				<li class="kegiatan_tugas_jabatan"><a href="#kegiatan_tugas_jabatan" data-toggle="tab">Uraian Tugas Jabatan</a></li>
				<li class="rencana_aksi"><a href="#rencana_aksi" data-toggle="tab">Rencana Aksi</a></li>
				<li class="skp_bulanan"><a href="#skp_bulanan" data-toggle="tab">SKP Bulanan</a></li>
			</ul>
								
			<div class="tab-content"  style="margin-left:20px; min-height:450px;">
				<div class="active tab-pane" id="status">
					@include('pare_pns.modules.skpd-skp_tahunan_status')	
				</div>
				<div class="tab-pane" id="detail">
					@include('pare_pns.modules.skpd-skp_tahunan_detail')				
				</div>
								
				<div class=" tab-pane" id="kegiatan_tugas_jabatan">
					@include('pare_pns.tables.skp_tahunan-kegiatan_tugas_jabatan')				
				</div>
								
				<div class="tab-pane" id="rencana_aksi">
					@include('pare_pns.modules.skp_tahunan-rencana_aksi_tree')		
				</div>

				<div class="tab-pane" id="skp_bulanan">
					@include('pare_pns.modules.skp_tahunan-skp_bulanan_tree')		
				</div>

			</div>			
		</div>
				




			
	    </section>
	</div>
@stop