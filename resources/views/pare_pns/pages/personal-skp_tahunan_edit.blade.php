@extends('pare_pns.layouts.dashboard')

@section('template_title')
{{ Pustaka::nama_pegawai(\Auth::user()->pegawai->gelardpn , \Auth::user()->pegawai->nama , \Auth::user()->pegawai->gelarblk)  }}
@stop

  
@section('content')
	 <div class="content-wrapper" >
	    <section class="content-header">
			<h1>
				<a class="back_button" data-toggle="tooltip" title="kembali" href="{{ route('personal-skp_tahunan') }}"><span class="fa fa-angle-left"></span></a>
				SKP Tahunan  {!! $skp->PejabatYangDinilai->Eselon->eselon !!} 
				
			</h1>
				{!! Breadcrumbs::render('personal_edit_skp_tahunan') !!}
      </section>
	  
	    <section class="content">
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs" id="myTab">
				
				<li class="detail"><a href="#detail" data-toggle="tab" >Detail</a></li>
				<?php 
					$id_jabatan_sekda = ['16'];
					$id_jabatan_irban = ['143','144','145','146'];
					$id_jabatan_lurah = ['1276','1281','1286','1291','1298','1301','1306','1311','1226','1221','1216','1211'];
					$id_jabatan_staf_ahli = ['13','14','15','61068','61069'];


					switch(  $skp->PejabatYangDinilai->Eselon->id_jenis_jabatan ) {
						case '1': // eselon 2
								break;
						case '2': // eselon 3
								echo '<li class="rencana_aksi_tab"><a href="#rencana_aksi_tab" data-toggle="tab">Rencana Aksi</a></li>';
							  	break;
						case '3': // eselon 4
								echo '<li class="rencana_aksi_tab"><a href="#rencana_aksi_tab" data-toggle="tab">Rencana Aksi</a></li>';
								break;
						case '4':   // JFU
								echo '<li class="rencana_aksi_tab"><a href="#rencana_aksi_tab" data-toggle="tab">Kegiatan Bulanan</a></li>';
								break; 
					}

				?>
				<li class="kegiatan_tahunan_tab"><a href="#kegiatan_tahunan_tab" data-toggle="tab">Kegiatan Tahunan</a></li>
				
				<?php
					
					switch(  $skp->PejabatYangDinilai->Eselon->id_jenis_jabatan ) {
						case '1': // eselon 2
								echo '<li class="perjanjian_kinerja_tab"><a href="#perjanjian_kinerja_tab" data-toggle="tab" >Perjanjian Kinerja</a></li>';
								break;
						case '2': // eselon 3
								echo '<li class="perjanjian_kinerja_tab"><a href="#perjanjian_kinerja_tab" data-toggle="tab" >Perjanjian Kinerja</a></li>';
							  	break;
						case '3': // eselon 4
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
				<div class=" tab-pane fade" id="rencana_aksi_tab">
					@include('pare_pns.modules.tab.rencana_aksi_time_table')
				</div>
				
								
				<div class=" tab-pane fade" id="kegiatan_tahunan_tab">

					<?php
						switch(  $skp->PejabatYangDinilai->Eselon->id_jenis_jabatan ) {
							case '1': 
									if (in_array( $skp->PejabatYangDinilai->id_jabatan, $id_jabatan_staf_ahli)){ //JIKA STAF AHLI
										?>@include('pare_pns.modules.tab.kegiatan_tahunan_5_edit')<?php
									}else if (in_array( $skp->PejabatYangDinilai->id_jabatan, $id_jabatan_sekda)){ //JIKA SEKDA
										?>@include('pare_pns.modules.tab.kegiatan_tahunan_sekda_detail')<?php
									}else{ //normal kondisi
										?>@include('pare_pns.modules.tab.kegiatan_tahunan_1_detail')<?php
									}
									
									break;
							case '2':
	
									if (in_array( $skp->PejabatYangDinilai->id_jabatan, $id_jabatan_irban)){ //JIKA IRBAN
										?>@include('pare_pns.modules.tab.kegiatan_tahunan_3_edit')<?php
									}else{
										?>@include('pare_pns.modules.tab.kegiatan_tahunan_2_detail')<?php
									}
									
									break;
							case '3': 

									if (in_array( $skp->PejabatYangDinilai->id_jabatan, $id_jabatan_lurah)){ //JIKA LURAH
										?>@include('pare_pns.modules.tab.kegiatan_tahunan_2_detail')<?php
									}else{
										?>@include('pare_pns.modules.tab.kegiatan_tahunan_3_edit')<?php
									}

									break;
							case '4':   
									?>@include('pare_pns.modules.tab.kegiatan_tahunan_4_detail')<?php
									break;
							case '5':   // JFT
									?>@include('pare_pns.modules.tab.kegiatan_tahunan_5_edit')<?php
									break;
						}
					?>

				</div>
				<div class="tab-pane fade" id="perjanjian_kinerja_tab">
					<?php
						switch(  $skp->PejabatYangDinilai->Eselon->id_jenis_jabatan ) {
							case '1':  //eselon 2
									?>@include('pare_pns.tables.skp_tahunan-perjanjian_kinerja_1_edit')<?php
									break;
							case '2': //Eselon 3
									if (in_array( $skp->PejabatYangDinilai->id_jabatan, $id_jabatan_irban)){ //JIKA IRBAN
										?>@include('pare_pns.tables.skp_tahunan-perjanjian_kinerja_3_edit')<?php
									}else{
										?>@include('pare_pns.tables.skp_tahunan-perjanjian_kinerja_2_edit')<?php
									}
									
									break;
							case '3':  //Eselon 4
									if (in_array( $skp->PejabatYangDinilai->id_jabatan, $id_jabatan_lurah)){ //JIKA LURAH
										?>@include('pare_pns.tables.skp_tahunan-perjanjian_kinerja_2_edit')<?php
									}else{
										?>@include('pare_pns.tables.skp_tahunan-perjanjian_kinerja_3_edit')<?php
									}
									
									break;
						}
					?>		
				</div>
				
				<div class="tab-pane fade" id="skp_bulanan_tab">

					<?php
						switch(  $skp->PejabatYangDinilai->Eselon->id_jenis_jabatan ) {
							case '1': //eselon 2
									if (in_array( $skp->PejabatYangDinilai->id_jabatan, $id_jabatan_staf_ahli)){ //JIKA STAF AHLI
										?>@include('pare_pns.tables.skp_bulanan-kegiatan_5_edit')<?php
									}else{
										?>@include('pare_pns.tables.skp_bulanan-kegiatan_1_edit')<?php
									}
									
									break;
							case '2': //eselon 3
	
									if (in_array( $skp->PejabatYangDinilai->id_jabatan, $id_jabatan_irban)){ //JIKA IRBAN
										?>@include('pare_pns.modules.tab.kegiatan_bulanan_3_edit')<?php
									}else{
										?>@include('pare_pns.tables.skp_bulanan-kegiatan_2_edit')<?php
									}
									
									break;
							case '3': //eselon 4
									if (in_array( $skp->PejabatYangDinilai->id_jabatan, $id_jabatan_lurah)){ //JIKA LURAH
										?>@include('pare_pns.tables.skp_bulanan-kegiatan_2_edit')<?php
									}else{
										?>@include('pare_pns.modules.tab.kegiatan_bulanan_3_edit')<?php
									}
									
									break;
							case '4': // JFU
									?>@include('pare_pns.tables.skp_bulanan-kegiatan_4_edit')<?php
									break;
							case '5': // JFT
									?>@include('pare_pns.tables.skp_bulanan-kegiatan_5_edit')<?php
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
	
	var hash = window.location.hash;
	if ( hash != ''){
		$('#myTab a[href="' + hash + '"]').tab('show');
	}else{
		$('#myTab a[href="#detail"]').tab('show');
	}

	$('#myTab a').click(function(e) {
		e.preventDefault();
		$(this).tab('show');
	}); 
	// store the currently selected tab in the hash value
	$("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
		var id = $(e.target).attr("href").substr(1);
		window.location.hash = id;
		//alert(id);

		if ( id == 'detail'){ 
			$('html, body').animate({scrollTop:0}, 0);
			LoadDetailTab();
		}else if ( id == 'kegiatan_tahunan_tab'){
			$('html, body').animate({scrollTop:0}, 0);
			refreshTreeKegTahunan(); 
		}else if ( id == 'skp_bulanan_tab'){
			$('html, body').animate({scrollTop:0}, 0);
			refreshTreeKegBulanan();
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

});
</script>


@stop

