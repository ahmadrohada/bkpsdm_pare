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
				Capaian Tahunan Eselon {{ $capaian->PegawaiYangDinilai->Eselon->eselon }}
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

	$.ajax({
				url			: '{{ url("api/capaian_tahunan_detail") }}',
				data 		: { capaian_tahunan_id : {!! $capaian->id !!} },
				method		: "GET",
				dataType	: "json",
				cache		: true,
				success	: function(data) {
					
					$('.st_created').html(data['date_of_created']);
					$('.st_send').html(data['date_of_send']);
					$('.st_approved').html(data['date_of_approve']);
					$('.st_periode').html(data['periode']);

					if ( ( data['send_to_atasan'] == "1" ) && ( data['status_approve'] == "0" ) ){
						$('.st_approved').html('Menunggu persetujuan dan penilaian dari atasan langsung');
						$('.st_icon').removeClass('fa-pencil');
						$('.st_icon').addClass('fa-send');
					}


			
					
				},
				error: function(data){
					
				}						
	});

	
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

