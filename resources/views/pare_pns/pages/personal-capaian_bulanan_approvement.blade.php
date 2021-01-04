@extends('pare_pns.layouts.dashboard')

@section('template_title')
{{ Pustaka::nama_pegawai(\Auth::user()->pegawai->gelardpn , \Auth::user()->pegawai->nama , \Auth::user()->pegawai->gelarblk)  }}
@stop


@section('content')
	 <div class="content-wrapper" >
	    <section class="content-header">
			<h1>
				<a class="back_button" data-toggle="tooltip" title="kembali" href="{{ route('capaian_bulanan_bawahan') }}"><span class="fa fa-angle-left"></span></a>
				Capaian Bulanan Aprovement
			</h1>
				{!! Breadcrumbs::render('approval_request-capaian_bulanan') !!}
      </section>
	  
	    <section class="content"> 
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs" id="myTab">
				<li class="status"><a href="#status" data-toggle="tab">Sumary </a></li>
				<li class="detail"><a href="#detail" data-toggle="tab" >Pejabat</a></li>
				<li class="kegiatan_bulanan_tab"><a href="#kegiatan_bulanan_tab" data-toggle="tab">Kegiatan Bulanan Eselon {!! $capaian->PegawaiYangDinilai->Eselon->eselon !!} / {!! $capaian->PegawaiYangDinilai->Eselon->id_jenis_jabatan!!}</a></li>
				<li class="uraian_tugas_tambahan_tab"><a href="#uraian_tugas_tambahan_tab" data-toggle="tab">Uraian Tugas Tambahan</a></li>
			</ul>
		
			<div class="tab-content"  style="min-height:400px;">
				<div class="active tab-pane fade" id="status">
					@include('pare_pns.modules.tabs.capaian_bulanan_status_approvement')
				</div>
				<div class="tab-pane fade" id="detail">
					@include('pare_pns.modules.detail_forms.capaian_bulanan_detail')			
				</div>
								
				<div class=" tab-pane fade" id="kegiatan_bulanan_tab">
					<?php
					
						switch(  $capaian->PegawaiYangDinilai->Eselon->id_jenis_jabatan ) {
							case '1': // 1. KABAN 
									if (in_array( $capaian->PegawaiYangDinilai->id_jabatan, json_decode($jabatan_staf_ahli))){ //JIKA IRBAN
										?>@include('pare_pns.tables.capaian_kegiatan_bulanan_5_detail')<?php
									}else{
										?>@include('pare_pns.tables.capaian_kegiatan_bulanan_1_detail')<?php
									}
									break;
							case '2': //2. KABID 
									if (in_array( $capaian->PegawaiYangDinilai->id_jabatan, json_decode($jabatan_irban))){ //JIKA IRBAN
										?>@include('pare_pns.tables.capaian_kegiatan_bulanan_3')<?php
									}else{
										?>@include('pare_pns.tables.capaian_kegiatan_bulanan_2')<?php
									}
									
									break;
							case '3':  //3. KASUBID
									if (in_array( $capaian->PegawaiYangDinilai->id_jabatan, json_decode($jabatan_lurah))){ //JIKA LURAH
										?>@include('pare_pns.tables.capaian_kegiatan_bulanan_2')<?php
									}else{
										?>@include('pare_pns.tables.capaian_kegiatan_bulanan_3')<?php
									}

									break;
							case '4':  //4. PELAKSANA
									?>@include('pare_pns.tables.capaian_kegiatan_bulanan_4')<?php
									break;
							case '5':   //5. JFT
									?>@include('pare_pns.tables.capaian_kegiatan_bulanan_5_detail')<?php
									break;
						}
					?>
				</div>
				<div class="tab-pane fade " id="uraian_tugas_tambahan_tab">
					@include('pare_pns.tables.capaian_uraian_tugas_tambahan')
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
		//destroy table agar hide kolom  tidak muncul duluan
		$('#realisasi_kegiatan_bulanan_table').DataTable().clear().destroy();
		$('#realisasi_uraian_tugas_tambahan_table').DataTable().clear().destroy();

		if ( id == 'kegiatan_bulanan_tab'){
			LoadKegiatanBulananTable(); 
		}else if ( id == 'status'){
			status_show();
		}else if ( id == 'uraian_tugas_tambahan_tab'){
			LoadUraianTugasTambahanTable();
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

