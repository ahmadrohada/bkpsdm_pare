@extends('pare_pns.layouts.dashboard')

@section('template_title')
{{ Pustaka::nama_pegawai(\Auth::user()->pegawai->gelardpn , \Auth::user()->pegawai->nama , \Auth::user()->pegawai->gelarblk)  }}
@stop
  
 
@section('content')
	 <div class="content-wrapper" >
	    <section class="content-header">
			<?php
				$xd = request()->segment(4); 
				$label_name = ( $xd == 'ralat') ? ' [ Ralat ] ' : ' [ Draft ] ' ;
			?>
			<h1>
				<a class="back_button" data-toggle="tooltip" title="kembali" href="{{ route('personal-capaian_tahunan') }}"><span class="fa fa-angle-left"></span></a>
				Capaian Tahunan Eselon {{ $capaian->PegawaiYangDinilai->Eselon->eselon }}  {{$label_name}}
			</h1>
				
      </section>
	  
	    <section class="content">

		<div class="row badge_persetujuan">
			<div class="col-md-12">
				<div class="callout callout-info " style="height:145px;">

					<table style="font-size:12px;">
						<tr>
							<td rowspan="4" style="padding:8px 2px;" class="hidden-xs"><i class="fa fa-pencil fa-3x" style="padding-right:30px;"></i></td>
							<td >Periode</td>
							<td >&nbsp;&nbsp;:&nbsp;</td>
							<td>{{ Pustaka::tahun($capaian->tgl_mulai) }} </td>
						</tr>
						<tr>
							<td>Created</td>
							<td>&nbsp;&nbsp;:&nbsp;</td>
							<td>{{ Pustaka::tgl_jam_short($capaian->created_at) }}</td>
							</tr>
							<tr>
								<td>
									Send
								</td>
								<td>&nbsp;&nbsp;:&nbsp;</td>
								<td></td>
							</tr>
							<tr>
								<td>
									Approved
								</td>
								<td>&nbsp;&nbsp;:&nbsp;</td>
								<td></td>
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
								Kirim {{$attr_name}} ke Atasan <i class="send_icon"></i>
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
				<li class="kegiatan_tahunan_tab"><a href="#kegiatan_tahunan_tab" data-toggle="tab">Kegiatan Tahunan Eselon {!! $capaian->PegawaiYangDinilai->Eselon->eselon !!}</a></li>
				<li class="unsur_penunjang_tab"><a href="#unsur_penunjang_tab" data-toggle="tab">Unsur Penunjang</a></li>
				<li class="tugas_tambahan_tab"><a href="#tugas_tambahan_tab" data-toggle="tab">Tugas Tambahan</a></li>
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

		if ( id == 'kegiatan_tahunan_tab'){
			LoadKegiatanTahunanTable();
		}else if ( id == 'sumary'){
			sumary_show(); 
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
		$('#myTab a[href="#sumary"]').tab('show');
	}

	function on_kirim(){
		$('.send_icon').addClass('fa fa-spinner faa-spin animated');
		$('.kirim_capaian').prop('disabled',true);
	}
	function reset_kirim(){
		$('.send_icon').removeClass('fa fa-spinner faa-spin animated');
		$('.send_icon').addClass('fa fa-send');
		$('.kirim_capaian').prop('disabled',false);
	}

	$(document).on('click','.kirim_capaian',function(e){
		Swal.fire({
				title: "Kirim Capaian",
				text: "Capaian Tahunan akan dikirim ke atasan untuk mendapatkan persetujuan, edit pada capaian tidak bisa dilakukan",
				type: "question",
				showCancelButton: true,
				cancelButtonText: "Batal",
				confirmButtonText: "Kirim Capaian",
				confirmButtonClass: "btn btn-success",
				cancelButtonClass: "btn btn-danger",
				cancelButtonColor: "#d33",
				closeOnConfirm: false
		}).then ((result) => {
			if (result.value){
				on_kirim();
				$.ajax({
					url		: '{{ url("api/kirim_capaian_tahunan") }}',
					type	: 'POST',
					data    : { capaian_tahunan_id : {!! $capaian->id !!} },
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
										reset_kirim();
										location.reload();

									},
									function (dismiss) {
										if (dismiss === 'timer') {
											
											
										}
									}
								)
								
							
					},
					error: function(e) {
							reset_kirim();
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

	

});
</script>


@stop

