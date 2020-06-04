@extends('pare_pns.layouts.dashboard')

@section('template_title')
{{ Pustaka::nama_pegawai(\Auth::user()->pegawai->gelardpn , \Auth::user()->pegawai->nama , \Auth::user()->pegawai->gelarblk)  }}
@stop
 

@section('content')
	 <div class="content-wrapper" >
	    <section class="content-header"> 
			<h1>
				<?php
					$middleware = request()->segment(1);
				?>
				<a class="back_button" data-toggle="tooltip" title="kembali" href="{{ route($middleware.'-skp_bulanan') }}"><span class="fa fa-angle-left"></span></a>
				SKP Bulanan Periode {!! Pustaka::periode($skp->tgl_mulai) !!}
			</h1>
				{!! Breadcrumbs::render('personal_detail_skp_bulanan') !!}
      </section>
	  
	    <section class="content">
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs" id="myTab">
				<li class="detail"><a href="#detail" data-toggle="tab" >Detail</a></li>
				<li class="kegiatan_bulanan_tab"><a href="#kegiatan_bulanan_tab" data-toggle="tab">Kegiatan SKP Bulanan Eselon {!! $skp->PejabatYangDinilai->Eselon->eselon !!} / {!! $skp->PejabatYangDinilai->Eselon->id_jenis_jabatan!!}</a></li>
				<li class="uraian_tugas_tambahan_tab"><a href="#uraian_tugas_tambahan_tab" data-toggle="tab" >Uraian Tugas Tambahan</a></li>
			</ul>


			<div class="tab-content"  style="margin-left:10px; min-height:400px;">
				<div class="active tab-pane fade" id="detail">
					@include('pare_pns.modules.edit_forms.skp_bulanan_detail')
				</div>
								
				<div class=" tab-pane fade" id="kegiatan_bulanan_tab">
				<!-- 1. KABAN -->
					@if ( $skp->PejabatYangDinilai->Eselon->id_jenis_jabatan  == '1')
						@include('pare_pns.tables.skp_bulanan-kegiatan_1_detail')
					@endif

					<!-- 2. KASUBID -->
					@if ( $skp->PejabatYangDinilai->Eselon->id_jenis_jabatan  == '2')
						@include('pare_pns.tables.skp_bulanan-kegiatan_2_detail')
					@endif


					<!-- 3. KASUBID -->
					@if ( $skp->PejabatYangDinilai->Eselon->id_jenis_jabatan  == '3')
						@include('pare_pns.tables.skp_bulanan-kegiatan_3_detail')
					@endif

					<!-- 4. PELAKSANA -->
					@if ( $skp->PejabatYangDinilai->Eselon->id_jenis_jabatan  == '4')
						@include('pare_pns.tables.skp_bulanan-kegiatan_4_detail')		
					@endif
				</div>
				<div class="tab-pane fade" id="uraian_tugas_tambahan_tab">
					@include('pare_pns.tables.skp_bulanan-uraian_tugas_tambahan')
				</div>

			</div>			
		</div>
				




			
	    </section>
	</div>
<script type="text/javascript">
$(document).ready(function() {
	
	$('#myTab a').click(function(e) {
		e.preventDefault();
		$(this).tab('show');
	}); 

	$("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
		var id = $(e.target).attr("href").substr(1);
		window.location.hash = id;
		if ( id == 'kegiatan_bulanan_tab'){
			load_kegiatan_bulanan();
		}else if ( id == 'detail'){
			detail_show();
		}else if ( id == 'uraian_tugas_tambahan_tab'){
			LoadUraianTugasTambahanTable();
		}
		$('html, body').animate({scrollTop:0}, 0);
	});

	var hash = window.location.hash;
	if ( hash != ''){
		$('#myTab a[href="' + hash + '"]').tab('show');
	}else{
		$('#myTab a[href="#detail"]').tab('show');
	}
});
</script>


@stop

