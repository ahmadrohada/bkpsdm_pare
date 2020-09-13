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
				<a class="back_button" data-toggle="tooltip" title="kembali" href="{{ route($middleware.'-skp_tahunan') }}"><span class="fa fa-angle-left"></span></a>
				SKP Tahunan  {!! $skp->PejabatYangDinilai->Eselon->eselon !!} [ Detail ]
			</h1>
				{!! Breadcrumbs::render($role.'-skp_tahunan_detail') !!}
      </section>
	  
	    <section class="content">
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs" id="myTab">
				{{-- <li class="status"><a href="#status" data-toggle="tab">Timeline </a></li> --}}
				<li class="detail"><a href="#detail" data-toggle="tab" >Detail</a></li>
				
				<?php 
					switch(  $skp->PejabatYangDinilai->Eselon->id_jenis_jabatan ) {
						case '1': 
								break;
						case '2':
								echo '<li class="rencana_aksi_tab"><a href="#rencana_aksi_tab" data-toggle="tab">Rencana Aksi</a></li>';
							  	break;
						case '3': 
								echo '<li class="rencana_aksi_tab"><a href="#rencana_aksi_tab" data-toggle="tab">Rencana Aksi</a></li>';
								break;
						case '4':   
								echo '<li class="rencana_aksi_tab"><a href="#rencana_aksi_tab" data-toggle="tab">Kegiatan Bulanan</a></li>';
								break;
					}
				?>
				<li class="kegiatan_tahunan_tab"><a href="#kegiatan_tahunan_tab" data-toggle="tab">Kegiatan Tahunan</a></li>
				<?php
					switch(  $skp->PejabatYangDinilai->Eselon->id_jenis_jabatan ) {
						case '1': 
								echo '<li class="perjanjian_kinerja_tab"><a href="#perjanjian_kinerja_tab" data-toggle="tab" >Perjanjian Kinerja</a></li>';
								break;
						case '2':
								echo '<li class="perjanjian_kinerja_tab"><a href="#perjanjian_kinerja_tab" data-toggle="tab" >Perjanjian Kinerja</a></li>';
							  	break;
						case '3': 
								echo '<li class="perjanjian_kinerja_tab"><a href="#perjanjian_kinerja_tab" data-toggle="tab" >Perjanjian Kinerja</a></li>';
								break;
						
					}
				?>
				<li class="skp_bulanan_tab"><a href="#skp_bulanan_tab" data-toggle="tab">SKP Bulanan</a></li>
				<li class="tugas_tambahan_tab"><a href="#tugas_tambahan_tab" data-toggle="tab" >Tugas Tambahan</a></li>
			</ul>

 
			<div class="tab-content"  style="min-height:400px;">
				<div class="active tab-pane fade" id="detail">
					@include('pare_pns.modules.tab.skp_tahunan_detail')				
				</div>		
				<div class=" tab-pane fade" id="kegiatan_tahunan_tab">
					<?php
						switch(  $skp->PejabatYangDinilai->Eselon->id_jenis_jabatan ) {
							case '1': 
									if (in_array( $skp->PejabatYangDinilai->id_jabatan,  json_decode($jabatan_staf_ahli))){ //JIKA STAF AHLI
										?>@include('pare_pns.modules.tab.kegiatan_tahunan_5_detail')<?php
									}else{
										?>@include('pare_pns.modules.tab.kegiatan_tahunan_1_detail')<?php
									}
									
									break;
							case '2':
									if (in_array( $skp->PejabatYangDinilai->id_jabatan,  json_decode($jabatan_irban))){ //JIKA IRBAN
										?>@include('pare_pns.modules.tab.kegiatan_tahunan_3_detail')<?php
									}else{
										?>@include('pare_pns.modules.tab.kegiatan_tahunan_2_detail')<?php
									}
									
									break;
							case '3': 
									if (in_array( $skp->PejabatYangDinilai->id_jabatan,  json_decode($jabatan_lurah))){ //JIKA LURAH
										?>@include('pare_pns.modules.tab.kegiatan_tahunan_2_detail')<?php
									}else{
										?>@include('pare_pns.modules.tab.kegiatan_tahunan_3_detail')<?php
									}

									break;
							case '4':   
									?>@include('pare_pns.modules.tab.kegiatan_tahunan_4_detail')<?php
									break;
							case '5':   
									?>@include('pare_pns.modules.tab.kegiatan_tahunan_5_detail')<?php
									break;
						}
					?>
					
				</div>
				<div class="tab-pane fade" id="perjanjian_kinerja_tab">
					<?php
						switch(  $skp->PejabatYangDinilai->Eselon->id_jenis_jabatan ) {
							case '1':  //eselon 2
									?>@include('pare_pns.tables.skp_tahunan-perjanjian_kinerja_1_detail')<?php
									break;
							case '2': //Eselon 3
									if (in_array( $skp->PejabatYangDinilai->id_jabatan,  json_decode($jabatan_irban))){ //JIKA IRBAN
										?>@include('pare_pns.tables.skp_tahunan-perjanjian_kinerja_3_detail')<?php
									}else{
										?>@include('pare_pns.tables.skp_tahunan-perjanjian_kinerja_2_detail')<?php
									}
									
									
									break;
							case '3':  //Eselon 4
									if (in_array( $skp->PejabatYangDinilai->id_jabatan,  json_decode($jabatan_lurah))){ //JIKA LURAH
										?>@include('pare_pns.tables.skp_tahunan-perjanjian_kinerja_2_detail')<?php
									}else{
										?>@include('pare_pns.tables.skp_tahunan-perjanjian_kinerja_3_detail')<?php
									}
									
									break;
							case '4':   //JFU
									?><?php
									break;
							case '5':   //JFT
									?><?php
									break;
						}
					?>		
				</div>
				<div class=" tab-pane fade" id="rencana_aksi_tab">
					<?php 
						switch(  $skp->PejabatYangDinilai->Eselon->id_jenis_jabatan ) {
							case '1': //eselon 2
									
							break;
							case '2': //eselon 3
									if (in_array( $skp->PejabatYangDinilai->id_jabatan,  json_decode($jabatan_irban)  )){ //JIKA IRBAN
										?>@include('pare_pns.tables.skp_tahunan-rencana_aksi_time_table_3')<?php
									}else{
										?>@include('pare_pns.tables.skp_tahunan-rencana_aksi_time_table_2')<?php
									}
							break;
							case '3': //eselon 4
									if (in_array( $skp->PejabatYangDinilai->id_jabatan, json_decode($jabatan_lurah) )){ //JIKA LURAH
										?>@include('pare_pns.tables.skp_tahunan-rencana_aksi_time_table_2')<?php
									}else{
										?>@include('pare_pns.tables.skp_tahunan-rencana_aksi_time_table_3')<?php
									}
							break;
							case '4': // JFU
									?>@include('pare_pns.tables.skp_tahunan-rencana_aksi_time_table_4')<?php
							break;
							case '5': // JFT
									
							break;
						}
					?>
				</div>
				<div class="tab-pane fade" id="skp_bulanan_tab">
					<?php
						switch(  $skp->PejabatYangDinilai->Eselon->id_jenis_jabatan ) {
							case '1': //Eselon II
									if (in_array( $skp->PejabatYangDinilai->id_jabatan,  json_decode($jabatan_staf_ahli))){ //JIKA STAF AHLI
										?>@include('pare_pns.tables.skp_bulanan-kegiatan_5_detail')<?php
									}else{
										?>@include('pare_pns.tables.skp_bulanan-kegiatan_1_edit')<?php
									}
									
									break;
							case '2': //Deselon III
	
									if (in_array( $skp->PejabatYangDinilai->id_jabatan,  json_decode($jabatan_irban))){ //JIKA IRBAN
										?>@include('pare_pns.modules.tab.kegiatan_bulanan_3_detail')<?php
									}else{
										?>@include('pare_pns.tables.skp_bulanan-kegiatan_2_edit')<?php
									}
									
									break;
							case '3': //dselon IV
									if (in_array( $skp->PejabatYangDinilai->id_jabatan,  json_decode($jabatan_lurah))){ //JIKA LURAH
										?>@include('pare_pns.tables.skp_bulanan-kegiatan_2_edit')<?php
									}else{
										?>@include('pare_pns.modules.tab.kegiatan_bulanan_3_detail')<?php
									}

									break;
							case '4': //PELAKSANA JFU
									?>@include('pare_pns.tables.skp_bulanan-kegiatan_4_edit')<?php
									break;
							case '5': // JFT
									?>@include('pare_pns.tables.skp_bulanan-kegiatan_5_detail')<?php
									break;
						}
					?>
					
				</div>
				<div class="tab-pane fade" id="tugas_tambahan_tab">
					@include('pare_pns.modules.tab.tugas_tambahan')
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
		//alert(id);

		if ( id == 'kegiatan_tahunan_tab'){
			$('html, body').animate({scrollTop:0}, 0);
			initTreeKegTahunan();
		}else if ( id == 'skp_bulanan_tab'){
			$('html, body').animate({scrollTop:0}, 0);
			initTreeKegBulanan();
		}else if ( id == 'status'){
			status_show();
		}else if ( id == 'detail'){
			$('html, body').animate({scrollTop:0}, 0);
			LoadDetailTab();
		}else if ( id == 'rencana_aksi_tab'){
			rencana_aksi_time_table();
		}else if ( id == 'perjanjian_kinerja_tab'){
			load_perjanjian_kinerja();
		}else if ( id == 'tugas_tambahan_tab'){
			$('html, body').animate({scrollTop:0}, 0);
			LoadTugasTambahanTab();
		}
		$('html, body').animate({scrollTop:0}, 0);
	});


	

	// on load of the page: switch to the currently selected tab
	var hash = window.location.hash;
	if ( hash != ''){
		$('#myTab a[href="' + hash + '"]').tab('show');
	}else{
		$('#myTab a[href="#detail"]').tab('show');
	}
	

});
</script>


@stop