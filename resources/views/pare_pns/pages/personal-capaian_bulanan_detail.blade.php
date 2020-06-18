@extends('pare_pns.layouts.dashboard')

@section('template_title')
{{ Pustaka::nama_pegawai(\Auth::user()->pegawai->gelardpn , \Auth::user()->pegawai->nama , \Auth::user()->pegawai->gelarblk)  }}
@stop


@section('content')
	 <div class="content-wrapper" >
	    <section class="content-header"> 
			<?php
					$xd = request()->segment(2); 
					$route_name = ( $xd == 'capaian_bulanan_bawahan') ? $xd : 'personal-capaian_bulanan' ;
					$name_role = ( $xd == 'capaian_bulanan_bawahan') ? ' Bawahan ' : ' Personal ' ;
			?>
			<h1>
				<a class="back_button" data-toggle="tooltip" title="kembali" href="{{ route($route_name) }}"><span class="fa fa-angle-left"></span></a>
				Capaian Bulanan {{ $name_role}} [ Detail ]
			</h1>
				{!! Breadcrumbs::render('personal_detail_capaian_bulanan') !!}
      </section>
	  
	    <section class="content">
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs" id="myTab">
				<li class="status"><a href="#status" data-toggle="tab">Status </a></li>
				<li class="detail"><a href="#detail" data-toggle="tab" >Detail</a></li>
				<li class="kegiatan_bulanan_tab"><a href="#kegiatan_bulanan_tab" data-toggle="tab">Kegiatan Bulanan Eselon {!! $capaian->PejabatYangDinilai->Eselon->eselon !!}{{--  / {!! $capaian->PejabatYangDinilai->Eselon->id_jenis_jabatan!!} --}}</a></li>
				<li class="uraian_tugas_tambahan_tab"><a href="#uraian_tugas_tambahan_tab" data-toggle="tab">Uraian Tugas Tambahan</a></li>
				
			</ul>

 
			<?php
				$id_jabatan_irban =  ['143','144','145','146','786','787']; 
				$id_jabatan_lurah = ['1276','1281','1286','1291','1298','1301','1306','1311','1226','1221','1216','1211'];
				$id_jabatan_staf_ahli = ['13','14','15','61068','61069'];
			?>
 
			<div class="tab-content"  style="min-height:400px;">
				<div class="active tab-pane fade" id="status">
					@include('pare_pns.modules.tab.capaian_bulanan_status')
				</div>
				<div class="tab-pane fade" id="detail">
					@include('pare_pns.modules.detail_forms.capaian_bulanan_detail')			
				</div>
								
				<div class=" tab-pane fade" id="kegiatan_bulanan_tab">
					<?php
						switch(  $capaian->PejabatYangDinilai->Eselon->id_jenis_jabatan ) {
							case '1': // 1. Eselon II 
									if (in_array( $capaian->PejabatYangDinilai->id_jabatan, $id_jabatan_staf_ahli)){ //JIKA IRBAN
										?>@include('pare_pns.tables.capaian_kegiatan_bulanan_5_detail')<?php
									}else{
										?>@include('pare_pns.tables.capaian_kegiatan_bulanan_1_detail')<?php
									}
									break;
							case '2': //2. Esl III 
									if (in_array( $capaian->PejabatYangDinilai->id_jabatan, $id_jabatan_irban)){ //JIKA IRBAN
										?>@include('pare_pns.tables.capaian_kegiatan_bulanan_3')<?php
									}else{
										?>@include('pare_pns.tables.capaian_kegiatan_bulanan_2')<?php
									}
									break;
							case '3':  //3. ESL IV
									if (in_array( $capaian->PejabatYangDinilai->id_jabatan, $id_jabatan_lurah)){ //JIKA LURAH
										?>@include('pare_pns.tables.capaian_kegiatan_bulanan_2')<?php
									}else{
										?>@include('pare_pns.tables.capaian_kegiatan_bulanan_3')<?php
									}
									break;
							case '4':  //4. PELAKSANA JFU
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
	}); 

	//LoadUraianTugasTambahanTable();
	//LoadKegiatanBulananTable();

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

