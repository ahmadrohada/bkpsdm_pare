@extends('admin.layouts.dashboard')

@section('template_title')
{{ Pustaka::nama_pegawai(\Auth::user()->pegawai->gelardpn , \Auth::user()->pegawai->nama , \Auth::user()->pegawai->gelarblk)  }}
@stop

  
@section('content')
	 <div class="content-wrapper" >
	    <section class="content-header">
			<h1>
				SKP Tahunan  {!! $skp->PejabatYangDinilai->Eselon->eselon !!} 
				
			</h1>
				{!! Breadcrumbs::render('personal_edit_skp_tahunan') !!}
      </section>
	  
	    <section class="content">
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs" id="myTab">
				<li class="status"><a href="#status" data-toggle="tab">Timeline </a></li>
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
				 	$id_jabatan_irban = ['143','144','145','146'];
					switch(  $skp->PejabatYangDinilai->Eselon->id_jenis_jabatan ) {
						case '1': 
								
								break;
						case '2':

								if (in_array( $skp->PejabatYangDinilai->id_jabatan, $id_jabatan_irban)){ //JIKA IRBAN
									echo '<li class="rencana_aksi_tab"><a href="#rencana_aksi_tab" data-toggle="tab">Rencana Aksi</a></li>';
								}
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
				
					
				<li class="skp_bulanan_tab"><a href="#skp_bulanan_tab" data-toggle="tab">SKP Bulanan</a></li>
			</ul>
 
 
			<div class="tab-content"  style="margin-left:10px; min-height:400px;">
				<div class="active tab-pane" id="status">

					<!-- ALL jabatan is one status edit -->
					@include('admin.modules.timeline.skp_tahunan_status_general')	
					
					 
				</div>
				<div class="tab-pane" id="detail">
					@include('admin.modules.edit_forms.skp_tahunan_detail')			
				</div>

				<div class="tab-pane" id="perjanjian_kinerja_tab">
					<?php
						switch(  $skp->PejabatYangDinilai->Eselon->id_jenis_jabatan ) {
							case '1':  //eselon 2
									?>@include('admin.tables.skp_tahunan-perjanjian_kinerja_1_edit')<?php
									break;
							case '2': //Eselon 3
									?>@include('admin.tables.skp_tahunan-perjanjian_kinerja_2')<?php
									break;
							case '3':  //Eselon 4
									?>@include('admin.tables.skp_tahunan-perjanjian_kinerja_3')<?php
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
								
				<div class=" tab-pane" id="kegiatan_tahunan_tab">

					<?php
						switch(  $skp->PejabatYangDinilai->Eselon->id_jenis_jabatan ) {
							case '1': 
									?>@include('admin.tables.skp_kegiatan_tahunan_1_detail')<?php
									break;
							case '2':
	
									if (in_array( $skp->PejabatYangDinilai->id_jabatan, $id_jabatan_irban)){ //JIKA IRBAN
										?>
											@include('admin.modules.tab.kegiatan_tahunan_3_edit')
										<?php
									}else{
										?>
											@include('admin.modules.tab.kegiatan_tahunan_2_detail')
										<?php
									}
									
									break;
							case '3': 
									?>@include('admin.modules.tab.kegiatan_tahunan_3_edit')<?php
									break;
							case '4':   
									?>@include('admin.modules.tab.kegiatan_tahunan_4_detail')<?php
									break;
							case '5':   
									?>@include('admin.modules.tab.kegiatan_tahunan_5_edit')<?php
									break;
						}
					?>

				</div>
				<div class=" tab-pane" id="rencana_aksi_tab">
					@include('admin.modules.tab.rencana_aksi_time_table')
					
				</div>
				<div class="tab-pane" id="skp_bulanan_tab">

					<?php
						switch(  $skp->PejabatYangDinilai->Eselon->id_jenis_jabatan ) {
							case '1': //eselon 2
									?>@include('admin.tables.skp_kegiatan_bulanan_1_edit')<?php
									break;
							case '2': //eselon 3
	
									if (in_array( $skp->PejabatYangDinilai->id_jabatan, $id_jabatan_irban)){ //JIKA IRBAN
										?>@include('admin.modules.tab.kegiatan_bulanan_3_edit')<?php
									}else{
										?>@include('admin.tables.skp_kegiatan_bulanan_2_edit')<?php
									}
									
									break;
							case '3': //eselon 4
									?>@include('admin.modules.tab.kegiatan_bulanan_3_edit')<?php
									break;
							case '4':   
									?>@include('admin.tables.skp_kegiatan_bulanan_4_edit')<?php
									break;
						}
					?>
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
			detail_show();
		}else if ( id == 'rencana_aksi_tab'){
			rencana_aksi_time_table();
		}else if ( id == 'perjanjian_kinerja_tab'){
			load_perjanjian_kinerja();
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

