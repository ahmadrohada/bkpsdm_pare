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
      </section>
	  
	<section class="content"> 
		<div class="row badge_persetujuan">
			<div class="col-md-12">
				<div class="callout callout-info " style="height:145px;">

					<table style="font-size:12px;">
						<tr>
							<td rowspan="4" style="padding:8px 2px;"><i class="st_icon fa fa-pencil-square-o fa-3x" style="padding-right:30px;"></i></td>
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
								Approved
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
					<div class="col-xs-12 col-lg-3 no-padding" style="margin-top:-15px;">
						@if ( $capaian->status_approve == 0 )
							<button class="btn btn-sm btn-danger tolak_capaian_bulanan">TOLAK</button>
							<button id="btn_terima" class="btn btn-sm btn-primary  btn_terima terima_capaian_bulanan"><span class="span_terima">TERIMA</span></button>
						@endif
					</div>
					
				</div>
			
			</div>
		</div>
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs" id="myTab">
				<li class="sumary"><a href="#sumary" data-toggle="tab">Sumary </a></li>
				<li class="pejabat"><a href="#pejabat" data-toggle="tab" >Pejabat</a></li>
				<li class="kegiatan_bulanan_tab"><a href="#kegiatan_bulanan_tab" data-toggle="tab">Kegiatan Bulanan Eselon {!! $capaian->PegawaiYangDinilai->Eselon->eselon !!} / {!! $capaian->PegawaiYangDinilai->Eselon->id_jenis_jabatan!!}</a></li>
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
				<div class=" tab-pane fade" id="penilaian_kode_etik_tab">
					@include('pare_pns.modules.tabs.capaian_bulanan_penilaian_kode_etik')
				</div> 


			</div>			
		</div>
				




			
	    </section>
	</div>

@include('pare_pns.modals.penilaian_kode_etik')

<script type="text/javascript">
$(document).ready(function() {

	$(document).on('click','.tolak_capaian_bulanan',function(e){
		Swal.fire({
			title				: 'Tolak Capaian Bulaan',
			text				: 'Berikan alasan penolakan',
			input				: 'text',
			type				: "question",
			showCancelButton	: true,
			confirmButtonText	: 'Tolak',
			showLoaderOnConfirm	: true,
			inputAttributes: {
				autocapitalize: 'off'
			},

			inputValidator: (value) => {
				return !value && 'wajib mencantumkan alasan penolakan!'
			},
			allowOutsideClick: false
			}).then ((result) => {
			if (result.value){
				$.ajax({
					url		: '{{ url("api/tolak_capaian_bulanan") }}',
					type	: 'POST',
					data    : { capaian_bulanan_id:{!! $capaian->id !!} ,
								alasan:result.value
							   },
					cache   : false,
					success:function(data){
						Swal.fire({
									title: "",
									text: "Sukses",
									type: "success",
									width: "200px",
									showConfirmButton: false,
									allowOutsideClick : false,
									timer: 900
									}).then(function () {
										location.reload();

									},
									function (dismiss) {
										if (dismiss === 'timer') {
											
											
										}
									}
								)
								
							
					},
					error: function(e) {
						Swal.fire({
									title: "Gagal",
									text: "",
									type: "warning"
								}).then (function(){
										
								});
							}
					});	
				

					
			}
		});
	});


	
	$(document).on('click','.terima_capaian_bulanan',function(e){
		
			Swal.fire({
					title: "Terima",
					text: "Anda akan menerima dan menyetujui Laporan Capaian Bulanan",
					type: "question",
					showCancelButton: true,
					cancelButtonText: "Batal",
					confirmButtonText: "Terima",
					cancelButtonColor: "#7a7a7a",
					closeOnConfirm: false,
					showLoaderOnConfirm	: true,
			}).then ((result) => {
				if (result.value){
					$.ajax({
						url		: '{{ url("api/terima_capaian_bulanan") }}',
						type	: 'POST',
						data    : { capaian_bulanan_id:{!! $capaian->id !!}
								},
						cache   : false,
						success:function(data){
							Swal.fire({
										title: "",
										text: "Sukses",
										type: "success",
										width: "200px",
										showConfirmButton: false,
										allowOutsideClick : false,
										timer: 900
										}).then(function () {
											location.reload();

										},
										function (dismiss) {
											if (dismiss === 'timer') {
												
												
											}
										}
									)
									
								
						},
						error: function(e) {
							Swal.fire({
										title: "Gagal",
										text: "",
										type: "warning"
									}).then (function(){
											
									});

									/* const Toast = Swal.mixin({
									toast: true,
									position: 'top-end',
									showConfirmButton: false,
									timer: 3000
									});

									Toast.fire({
									type: 'success',
									title: 'Signed in successfully'
									}) */
								}
						});	
					

						
				}
			});

	});

	
	$('#myTab a').click(function(e) {
		
		e.preventDefault();
		$(this).tab('show');
		//$('html, body').animate({scrollTop:0}, 0);
		
	}); 

	sumary_show();

	// store the currently selected tab in the hash value
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
			penilaian_kode_etik_show();
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

