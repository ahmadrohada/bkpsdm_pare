@extends('pare_pns.layouts.dashboard')

@section('template_title')
{{ Pustaka::nama_pegawai(\Auth::user()->pegawai->gelardpn , \Auth::user()->pegawai->nama , \Auth::user()->pegawai->gelarblk)  }}
@stop
 

@section('content')
	 <div class="content-wrapper" >
	    <section class="content-header">
			<h1>
				<a class="back_button" data-toggle="tooltip" title="kembali" href="{{ route('capaian_tahunan_bawahan') }}"><span class="fa fa-angle-left"></span></a>
				Capaian Tahunan Approvement
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
						<div class="col-xs-12 col-lg-2 no-padding" style="margin-top:-15px;">
							@if ( $capaian->status_approve == 0 )
								<button class="btn btn-sm btn-danger tolak_capaian_tahunan">TOLAK</button>
								<button id="btn_terima" class="btn btn-sm btn-primary  terima_capaian_tahunan">TERIMA</button>
							@endif
						
						</div>
						
					</div>
				
				</div>
			</div>
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs" id="myTab">
				<li class="sumary"><a href="#sumary" data-toggle="tab">Sumary </a></li>
				<li class="pejabat"><a href="#pejabat" data-toggle="tab" >Pejabat</a></li>
				<li class="kegiatan_tahunan_tab"><a href="#kegiatan_tahunan_tab" data-toggle="tab">Kegiatan Tahunan Eselon {!! $capaian->PegawaiYangDinilai->Eselon->eselon !!} / {!! $capaian->PegawaiYangDinilai->Eselon->id_jenis_jabatan!!}</a></li>
				<li class="unsur_penunjang_tab"><a href="#unsur_penunjang_tab" data-toggle="tab">Unsur Penunjang</a></li>
				{{-- <li class="tugas_tambahan_tab"><a href="#tugas_tambahan_tab" data-toggle="tab">Tugas Tambahan</a></li> --}}
				<li class="penilaian_perilaku_kerja_tab"><a href="#penilaian_perilaku_kerja_tab" data-toggle="tab">Penilaian Perilaku Kerja</a></li>
			</ul>

 
			<div class="tab-content"  style="min-height:400px;">
				<div class="active tab-pane fade" id="sumary">
					@include('pare_pns.modules.tabs.capaian_tahunan_sumary')
				</div>
				<div class="tab-pane fade" id="pejabat">
					@include('pare_pns.modules.tabs.capaian_tahunan_pejabat')		
				</div>
								
				<div class=" tab-pane fade" id="kegiatan_tahunan_tab">
					<?php
						switch(  $capaian->PegawaiYangDinilai->Eselon->id_jenis_jabatan ) {
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
				<div class=" tab-pane fade" id="penilaian_perilaku_kerja_tab">
					@include('pare_pns.modules.tabs.capaian_tahunan_penilaian_perilaku_kerja')
				</div> 

			</div>			
		</div>
				




			
	    </section>
	</div>
<script type="text/javascript">
$(document).ready(function() {
	
	$(document).on('click','.tolak_capaian_tahunan',function(e){
		Swal.fire({
			title				: 'Tolak Capaian Tahunan',
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
					url		: '{{ url("api/tolak_capaian_tahunan") }}',
					type	: 'POST',
					data    : { capaian_tahunan_id:{!! $capaian->id !!} ,
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

	$(document).on('click','.terima_capaian_tahunan',function(e){
		Swal.fire({
				title: "Terima",
				text: "Anda akan menerima dan menyetujui Laporan Capaian Tahunan",
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
					url		: '{{ url("api/terima_capaian_tahunan") }}',
					type	: 'POST',
					data    : { capaian_tahunan_id:{!! $capaian->id !!}
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

		if ( id == 'sumary'){
			sumary_show(); 
		}else if ( id == 'kegiatan_tahunan_tab'){
			LoadKegiatanTahunanTable();
		}else if ( id == 'unsur_penunjang_tab'){
			LoadUnsurPenunajangTugasTambahanTable(); 
			LoadUnsurPenunajangKreativitasTable();
		}else if ( id == 'tugas_tambahan_tab'){
			LoadTugasTambahanTable(); 
		}else if ( id == 'penilaian_perilaku_kerja_tab'){
			penilaian_perilaku_kerja_show(); 
		}

		
		$('html, body').animate({scrollTop:0}, 0);
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

