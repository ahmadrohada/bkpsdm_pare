@extends('pare_pns.layouts.dashboard')

@section('template_title')
{{ Pustaka::nama_pegawai(\Auth::user()->pegawai->gelardpn , \Auth::user()->pegawai->nama , \Auth::user()->pegawai->gelarblk)  }}
@stop
 

@section('content')
	 <div class="content-wrapper" >
	    <section class="content-header">
			<?php
					$xd = request()->segment(2); 
					$route_name = ( $xd == 'capaian_tahunan_bawahan') ? $xd : 'personal-capaian_tahunan' ;
					$name_role = ( $xd == 'capaian_tahunan_bawahan') ? ' Bawahan ' : ' Personal ' ;
			?>
			<h1>
				<a class="back_button" data-toggle="tooltip" title="kembali" href="{{ route($route_name) }}"><span class="fa fa-angle-left"></span></a>
				Capaian Tahunan Eselon {{ $capaian->PejabatYangDinilai->Eselon->eselon }} [ Detail ]
			</h1>
				{!! Breadcrumbs::render('personal_edit_capaian_tahunan') !!}
      </section>
	   
	    <section class="content">
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs" id="myTab">
				<li class="status"><a href="#status" data-toggle="tab">Status </a></li>
				<li class="detail"><a href="#detail" data-toggle="tab" >Detail</a></li>
				<li class="kegiatan_tahunan_tab"><a href="#kegiatan_tahunan_tab" data-toggle="tab">Kegiatan Tahunan Eselon {!! $capaian->PejabatYangDinilai->Eselon->eselon !!} / {!! $capaian->PejabatYangDinilai->Eselon->id_jenis_jabatan!!}</a></li>
				<li class="unsur_penunjang_tab"><a href="#unsur_penunjang_tab" data-toggle="tab">Unsur Penunjang</a></li>
				<li class="tugas_tambahan_tab"><a href="#tugas_tambahan_tab" data-toggle="tab">Tugas Tambahan</a></li>
			</ul>

 
			<div class="tab-content"  style="min-height:400px;">
				<div class="active tab-pane fade" id="status">
					@include('pare_pns.modules.tabs.capaian_tahunan_status')
				</div>
				<div class="tab-pane fade" id="detail">
					@include('pare_pns.modules.tabs.capaian_tahunan_detail')			
				</div>
								
				<div class=" tab-pane fade" id="kegiatan_tahunan_tab">
					<?php
					switch(  $capaian->PejabatYangDinilai->Eselon->id_jenis_jabatan ) {
						case '1': 
								?><?php
								break;
						case '2':
								?>@include('pare_pns.tables.capaian_kegiatan_tahunan_2')<?php
								break;
						case '3': 
								?>@include('pare_pns.tables.capaian_kegiatan_tahunan_3')<?php
								break;
						case '4':   
								?>@include('pare_pns.tables.capaian_kegiatan_tahunan_4')<?php
								break;
						case '5':   
								?>@include('pare_pns.tables.capaian_kegiatan_tahunan_5')<?php
								break;
					}
					?>
				</div>
				<div class=" tab-pane fade" id="unsur_penunjang_tab">
					@include('pare_pns.tables.capaian_unsur_penunjang')
				</div>
				<div class=" tab-pane fade" id="tugas_tambahan_tab">
					@include('pare_pns.tables.capaian_tugas_tambahan')
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
		$('#realisasi_kegiatan_tahunan_table').DataTable().clear().destroy();
		$('#realisasi_tugas_tambahan_table').DataTable().clear().destroy();
		$('#up_kreativitas_table').DataTable().clear().destroy();
		$('#up_tugas_tambahan_table').DataTable().clear().destroy();

		$('#tugas_tambahan_table').DataTable().clear().destroy();

		if ( id == 'kegiatan_tahunan_tab'){
			LoadKegiatanTahunanTable();
		}else if ( id == 'status'){
			status_show(); 
		}else if ( id == 'unsur_penunjang_tab'){
			LoadUnsurPenunajangTugasTambahanTable(); 
			LoadUnsurPenunajangKreativitasTable();
		}else if ( id == 'tugas_tambahan_tab'){
			LoadTugasTambahanTable(); 
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

