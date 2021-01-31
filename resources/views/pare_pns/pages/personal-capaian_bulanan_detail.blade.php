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
    </section>
	  
	<section class="content">
		<div class="row badge_persetujuan">
			<div class="col-md-12">
				<div class="callout callout-info "  style="height:145px;">

					<table style="font-size:12px;">
						<tr>
							<td rowspan="4" style="padding:8px 2px;">
								@if (  $capaian->status_approve == "2" )
									<i class="st_icon fa fa-times fa-5x" style="padding-right:30px;"></i>
								@elseif (  $capaian->status_approve == "1" )
									<i class="st_icon fa fa-check-square-o fa-5x" style="padding-right:30px;"></i>
								@else
									<i class="st_icon fa fa-send fa-3x" style="padding-right:30px;"></i>
								@endif
							</td>
							<td >Periode</td>
							<td >&nbsp;&nbsp;&nbsp;</td>
							<td>{{ Pustaka::tahun($capaian->tgl_mulai) }} </td>
						</tr>
						<tr>
							<td>Created</td>
							<td></td>
							<td>{{ Pustaka::tgl_jam_short($capaian->created_at) }}</td>
						</tr>
						<tr>
							<td>
								Send
							</td>
							<td></td>
							<td>{{ Pustaka::tgl_jam_short($capaian->date_of_send) }}</td>
						</tr>
						<tr>
							<td>
								@if (  $capaian->status_approve == "2" )
									Ditolak
								@else
									Approved
								@endif
							</td>
							<td></td>
							<td>
								@if (  $capaian->status_approve == "2" )
									{{ $capaian->alasan_penolakan }}
								@elseif (  $capaian->status_approve == "1" )
									{{ Pustaka::tgl_jam_short($capaian->date_of_approve) }}
								@else
									-
								@endif
							</td>
						</tr>
					
					</table>
					
					<hr>
				
					
					@if ( ( request()->segment(4) == 'edit' )|( request()->segment(4) == 'ralat' ) )
						<?php
							$xd = request()->segment(4); 
							$attr_name = ( $xd == 'ralat') ? ' kembali ' : '' ;
						?>
						<div class="col-xs-12 col-lg-2 no-padding" >
							<button type="button" class="btn btn-sm btn-block btn-warning pull-left kirim_capaian" style="margin-top:-15px;">
								<i class="fa fa-send"></i> Kirim {{$attr_name}} ke Atasan <i class="send_icon"></i>
							</button>
						</div>
					@endif
				</div>
			
			</div>
		</div>
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs" id="myTab">
				<li class="sumary"><a href="#sumary" data-toggle="tab">Sumary </a></li>
				<li class="pejabat"><a href="#pejabat" data-toggle="tab" >Pejabat</a></li>
				<li class="kegiatan_bulanan_tab"><a href="#kegiatan_bulanan_tab" data-toggle="tab">Kegiatan Bulanan Eselon {!! $capaian->PegawaiYangDinilai->Eselon->eselon !!}{{--  / {!! $capaian->PegawaiYangDinilai->Eselon->id_jenis_jabatan!!} --}}</a></li>
				<li class="uraian_tugas_tambahan_tab"><a href="#uraian_tugas_tambahan_tab" data-toggle="tab">Uraian Tugas Tambahan</a></li>
				<li class="penilaian_kode_etik_tab"><a href="#penilaian_kode_etik_tab" data-toggle="tab">Penilaian Kode Etik</a></li>
			</ul>
			<div class="tab-content"  style="min-height:400px;">
				<div class="active tab-pane fade" id="sumary">
					@include('pare_pns.modules.tabs.capaian_bulanan_sumary')
				</div>
				<div class="tab-pane fade" id="pejabat">
					@include('pare_pns.modules.tabs.capaian_bulanan_pejabat')			
				</div>
								
				<div class=" tab-pane fade" id="kegiatan_bulanan_tab">
					<?php
						switch(  $capaian->PegawaiYangDinilai->Eselon->id_jenis_jabatan ) {
							case '1': // 1. Eselon II 
									if (in_array( $capaian->PegawaiYangDinilai->id_jabatan, json_decode($jabatan_staf_ahli))){ //JIKA IRBAN
										?>@include('pare_pns.tables.capaian_kegiatan_bulanan_5_detail')<?php
									}else{
										?>@include('pare_pns.tables.capaian_kegiatan_bulanan_1_detail')<?php
									}
									break;
							case '2': //2. Esl III 
									if (in_array( $capaian->PegawaiYangDinilai->id_jabatan, json_decode($jabatan_irban))){ //JIKA IRBAN
										?>@include('pare_pns.tables.capaian_kegiatan_bulanan_3')<?php
									}else{
										?>@include('pare_pns.tables.capaian_kegiatan_bulanan_2')<?php
									}
									break;
							case '3':  //3. ESL IV
									if (in_array( $capaian->PegawaiYangDinilai->id_jabatan, json_decode($jabatan_lurah))){ //JIKA LURAH
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
				<div class=" tab-pane fade" id="penilaian_kode_etik_tab">
					@include('pare_pns.modules.tabs.capaian_bulanan_penilaian_kode_etik')
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
		$('html, body').animate({scrollTop:0}, 0);
		//destroy table agar hide kolom  tidak muncul duluan
		$('#realisasi_kegiatan_bulanan_table').DataTable().clear().destroy();
		$('#realisasi_uraian_tugas_tambahan_table').DataTable().clear().destroy();


		if ( id == 'kegiatan_bulanan_tab'){
			LoadKegiatanBulananTable();
		}else if ( id == 'sumary'){
			sumary_show();
		}else if ( id == 'uraian_tugas_tambahan_tab'){
			LoadUraianTugasTambahanTable();
		}else if ( id == 'penilaian_kode_etik_tab'){
			penilaian_kode_etik_show(); 
		}
		
	});


	

	// on load of the page: switch to the currently selected tab
	var hash = window.location.hash;
	if ( hash != ''){
		$('#myTab a[href="' + hash + '"]').tab('show');
	}else{
		$('#myTab a[href="#sumary"]').tab('show');
	}
	

});
</script>


@stop

