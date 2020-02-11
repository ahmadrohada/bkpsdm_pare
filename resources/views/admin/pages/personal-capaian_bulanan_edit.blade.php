@extends('admin.layouts.dashboard')

@section('template_title')
{{ Pustaka::nama_pegawai(\Auth::user()->pegawai->gelardpn , \Auth::user()->pegawai->nama , \Auth::user()->pegawai->gelarblk)  }}
@stop


@section('content')
	 <div class="content-wrapper" >
	    <section class="content-header">
			<h1>
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
				
			</ul>

 
			<div class="tab-content"  style="margin-left:10px; min-height:400px;">
				<div class="active tab-pane" id="status">
					<!-- 1. KABAN -->
					@if ( $capaian->PejabatYangDinilai->Eselon->id_jenis_jabatan  == '1')
						@include('admin.modules.timeline.capaian_bulanan_status_edit')
					@endif
 
					<!-- 2. KABID -->
					@if ( $capaian->PejabatYangDinilai->Eselon->id_jenis_jabatan  == '2')
						@include('admin.modules.timeline.capaian_bulanan_status_edit')
					@endif

					<!-- 2. KASUBID -->
					@if ( $capaian->PejabatYangDinilai->Eselon->id_jenis_jabatan  == '3')
						@include('admin.modules.timeline.capaian_bulanan_status_edit')
					@endif

					<!-- 2. PELAKSANA / JFU-->
					@if ( $capaian->PejabatYangDinilai->Eselon->id_jenis_jabatan  == '4')
						@include('admin.modules.timeline.capaian_bulanan_status_edit')	
					@endif

					<!-- 2. JFT -->
					@if ( $capaian->PejabatYangDinilai->Eselon->id_jenis_jabatan  == '5')
						@include('admin.modules.timeline.capaian_bulanan_status_edit')	
					@endif
					
				</div>
				<div class="tab-pane" id="detail">
					@include('admin.modules.edit_forms.capaian_bulanan_detail')			
				</div>
								
				<div class=" tab-pane" id="kegiatan_bulanan_tab">

					<?php
						$id_jabatan_irban = ['143','144','145','146'];
						$id_jabatan_lurah = ['1276','1281','1286','1291','1298','1301','1306','1311','1226','1221','1216','1211'];

						switch(  $capaian->PejabatYangDinilai->Eselon->id_jenis_jabatan ) {
							case '1': // 1. KABAN 
									?>@include('admin.tables.capaian_kegiatan_bulanan_1_edit')<?php
									break;
							case '2': //2. KABID 
									if (in_array( $capaian->PejabatYangDinilai->id_jabatan, $id_jabatan_irban)){ //JIKA IRBAN
										?>@include('admin.tables.capaian_kegiatan_bulanan_3_edit')<?php
									}else{
										?>@include('admin.tables.capaian_kegiatan_bulanan_2_edit')<?php
									}
									
									break;
							case '3':  //3. KASUBID
									if (in_array( $capaian->PejabatYangDinilai->id_jabatan, $id_jabatan_lurah)){ //JIKA LURAH
										?>@include('admin.tables.capaian_kegiatan_bulanan_2_edit')<?php
									}else{
										?>@include('admin.tables.capaian_kegiatan_bulanan_3_edit')<?php
									}

									break;
							case '4':  //4. PELAKSANA
									?>@include('admin.tables.capaian_kegiatan_bulanan_4_edit')<?php
									break;
							case '5':   //5. JFT
									?>@include('admin.tables.capaian_kegiatan_bulanan_5_edit')<?php
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

		if ( id == 'kegiatan_bulanan_tab'){
			load_kegiatan_bulanan();
		}else if ( id == 'status'){
			status_show();
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

