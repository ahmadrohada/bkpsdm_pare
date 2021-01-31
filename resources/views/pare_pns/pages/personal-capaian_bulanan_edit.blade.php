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
			<a class="back_button" data-toggle="tooltip" title="kembali" href="{{ route('personal-capaian_bulanan') }}"><span class="fa fa-angle-left"></span></a>
			Capaian Bulanan Personal {{$label_name}}
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
							<td >&nbsp;&nbsp;&nbsp;</td>
							<td>{{ Pustaka::tahun($capaian->tgl_mulai) }} </td>
						</tr>
						<tr>
							<td>Created</td>
							<td >&nbsp;&nbsp;&nbsp;</td>
							<td>{{ Pustaka::tgl_jam_short($capaian->created_at) }}</td>
							</tr>
							<tr>
								<td>
									Send
								</td>
								<td >&nbsp;&nbsp;&nbsp;</td>
								<td></td>
							</tr>
							<tr>
								<td>
									Approved
								</td>
								<td >&nbsp;&nbsp;&nbsp;</td>
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
				<li class="kegiatan_bulanan_tab"><a href="#kegiatan_bulanan_tab" data-toggle="tab">Kegiatan Bulanan Eselon {!! $capaian->PegawaiYangDinilai->Eselon->eselon !!}{{--  / {!! $capaian->PegawaiYangDinilai->Eselon->id_jenis_jabatan!!} --}}</a></li>
				<li class="uraian_tugas_tambahan_tab"><a href="#uraian_tugas_tambahan_tab" data-toggle="tab">Uraian Tugas Tambahan</a></li>
				
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
										?>@include('pare_pns.tables.capaian_kegiatan_bulanan_5_edit')<?php
									}else{
										?>@include('pare_pns.tables.capaian_kegiatan_bulanan_1_edit')<?php
									}
									break;
							case '2': //2. Eselon III
									if (in_array( $capaian->PegawaiYangDinilai->id_jabatan, json_decode($jabatan_irban))){ //JIKA IRBAN
										?>@include('pare_pns.tables.capaian_kegiatan_bulanan_3')<?php
									}else{
										?>@include('pare_pns.tables.capaian_kegiatan_bulanan_2')<?php
									}
									break;
							case '3':  //3. Eselon IV
									if (in_array( $capaian->PegawaiYangDinilai->id_jabatan, json_decode($jabatan_lurah))){ //JIKA LURAH
										?>@include('pare_pns.tables.capaian_kegiatan_bulanan_2')<?php
									}else{
										?>@include('pare_pns.tables.capaian_kegiatan_bulanan_3')<?php
									}
									break;
							case '4':  //4. JFU 
									?>@include('pare_pns.tables.capaian_kegiatan_bulanan_4')<?php
									break;
							case '5':   //5. JFT
									?>@include('pare_pns.tables.capaian_kegiatan_bulanan_5_edit')<?php
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
		}else if ( id == 'uraian_tugas_tambahan_tab'){
			LoadUraianTugasTambahanTable();
		}
		
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
				text: "Capaian Bulanan akan dikirim ke atasan untuk, edit pada capaian tidak bisa dilakukan",
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
					url		: '{{ url("api/kirim_capaian_bulanan") }}',
					type	: 'POST',
					data    : { capaian_bulanan_id : {!! $capaian->id !!} },
					cache   : false,
					success:function(data){
							$('.kirim_capaian').hide();
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

