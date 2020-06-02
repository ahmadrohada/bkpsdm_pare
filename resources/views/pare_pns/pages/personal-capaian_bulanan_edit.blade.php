@extends('pare_pns.layouts.dashboard')

@section('template_title')
{{ Pustaka::nama_pegawai(\Auth::user()->pegawai->gelardpn , \Auth::user()->pegawai->nama , \Auth::user()->pegawai->gelarblk)  }}
@stop


@section('content')
	 <div class="content-wrapper" >
	    <section class="content-header">
			<h1>
				<a class="back_button" data-toggle="tooltip" title="kembali" href="{{ route('personal-capaian_bulanan') }}"><span class="fa fa-angle-left"></span></a>
				Edit Capaian Bulanan
			</h1>
				{!! Breadcrumbs::render('personal_edit_capaian_bulanan') !!}
      </section>
	  
	    <section class="content">
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs" id="myTab">
				<li class="status"><a href="#status" data-toggle="tab">Status </a></li>
				<li class="detail"><a href="#detail" data-toggle="tab" >Detail</a></li>
				<li class="kegiatan_bulanan_tab"><a href="#kegiatan_bulanan_tab" data-toggle="tab">Kegiatan Bulanan Eselon {!! $capaian->PejabatYangDinilai->Eselon->eselon !!} / {!! $capaian->PejabatYangDinilai->Eselon->id_jenis_jabatan!!}</a></li>
				<li class="uraian_tugas_tambahan_tab"><a href="#uraian_tugas_tambahan_tab" data-toggle="tab">Uraian Tugas Tambahan</a></li>
				
			</ul>

 
			<div class="tab-content"  style="margin-left:10px; min-height:400px;">
				<div class="active tab-pane fade" id="status">
					<?php
						$id_jabatan_irban = ['143','144','145','146'];
						$id_jabatan_lurah = ['1276','1281','1286','1291','1298','1301','1306','1311','1226','1221','1216','1211'];
						$id_jabatan_staf_ahli = ['13','14','15','61068','61069'];

					switch(  $capaian->PejabatYangDinilai->Eselon->id_jenis_jabatan ) {
						case '1': // 1. Eselon II
								if (in_array( $capaian->PejabatYangDinilai->id_jabatan, $id_jabatan_staf_ahli)){ //JIKA IRBAN
									?>@include('pare_pns.modules.timeline.capaian_bulanan_status_edit')<?php
								}else{
									?>@include('pare_pns.modules.timeline.capaian_bulanan_status_edit')<?php
								}
								
								break;
						case '2': //2. Eselon III
								if (in_array( $capaian->PejabatYangDinilai->id_jabatan, $id_jabatan_irban)){ //JIKA IRBAN
									?>@include('pare_pns.modules.timeline.capaian_bulanan_status_edit')<?php
								}else{
									?>@include('pare_pns.modules.timeline.capaian_bulanan_status_edit')<?php
								}
								
								break;
						case '3':  //3. Eselon IV
								if (in_array( $capaian->PejabatYangDinilai->id_jabatan, $id_jabatan_lurah)){ //JIKA LURAH
									?>@include('pare_pns.modules.timeline.capaian_bulanan_status_edit')<?php
								}else{
									?>@include('pare_pns.modules.timeline.capaian_bulanan_status_edit')<?php
								}

								break;
						case '4':  //4. JFU 
								?>@include('pare_pns.modules.timeline.capaian_bulanan_status_edit')<?php
								break;
						case '5':   //5. JFT
								?>@include('pare_pns.modules.timeline.capaian_bulanan_status_edit')<?php
								break;
					}
					?>
					
				</div>
				<div class="tab-pane fade" id="detail">
					@include('pare_pns.modules.edit_forms.capaian_bulanan_detail')			
				</div>
								
				<div class=" tab-pane fade" id="kegiatan_bulanan_tab">

					<?php

						switch(  $capaian->PejabatYangDinilai->Eselon->id_jenis_jabatan ) {
							case '1': // 1. Eselon II
									if (in_array( $capaian->PejabatYangDinilai->id_jabatan, $id_jabatan_staf_ahli)){ //JIKA IRBAN
										?>@include('pare_pns.tables.capaian_kegiatan_bulanan_5_edit')<?php
									}else{
										?>@include('pare_pns.tables.capaian_kegiatan_bulanan_1_edit')<?php
									}
									
									break;
							case '2': //2. Eselon III
									if (in_array( $capaian->PejabatYangDinilai->id_jabatan, $id_jabatan_irban)){ //JIKA IRBAN
										?>@include('pare_pns.tables.capaian_kegiatan_bulanan_3_edit')<?php
									}else{
										?>@include('pare_pns.tables.capaian_kegiatan_bulanan_2_edit')<?php
									}
									
									break;
							case '3':  //3. Eselon IV
									if (in_array( $capaian->PejabatYangDinilai->id_jabatan, $id_jabatan_lurah)){ //JIKA LURAH
										?>@include('pare_pns.tables.capaian_kegiatan_bulanan_2_edit')<?php
									}else{
										?>@include('pare_pns.tables.capaian_kegiatan_bulanan_3_edit')<?php
									}

									break;
							case '4':  //4. JFU 
									?>@include('pare_pns.tables.capaian_kegiatan_bulanan_4_edit')<?php
									break;
							case '5':   //5. JFT
									?>@include('pare_pns.tables.capaian_kegiatan_bulanan_5_edit')<?php
									break;
						}
					?>
				</div>
				<div class="tab-pane fade " id="uraian_tugas_tambahan_tab">
					@include('pare_pns.tables.capaian_bulanan-uraian_tugas_tambahan')
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
		//$('html, body').animate({scrollTop:0}, 0);
		
	}); 

	// store the currently selected tab in the hash value
	$("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
		var id = $(e.target).attr("href").substr(1);
		window.location.hash = id;

		if ( id == 'kegiatan_bulanan_tab'){
			load_kegiatan_bulanan();
		}else if ( id == 'status'){
			status_show();
		}else if ( id == 'uraian_tugas_tambahan_tab'){
			//LoadUraianTugasTambahanTable();
		}
		$('html, body').animate({scrollTop:0}, 0);
	});


	

	// on load of the page: switch to the currently selected tab
	var hash = window.location.hash;
	if ( hash != ''){
		$('#myTab a[href="' + hash + '"]').tab('show');
	}else{
		$('#myTab a[href="#status"]').tab('show');
	}
	

});
</script>


@stop

