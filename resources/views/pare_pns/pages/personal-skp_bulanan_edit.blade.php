@extends('pare_pns.layouts.dashboard')

@section('template_title')
{{ Pustaka::nama_pegawai(\Auth::user()->pegawai->gelardpn , \Auth::user()->pegawai->nama , \Auth::user()->pegawai->gelarblk)  }}
@stop
 

@section('content')
	<div class="content-wrapper" >
	<section class="content-header">  
		<h1>
			<?php
				$middleware = request()->segment(1);
			?>
			<a class="back_button" data-toggle="tooltip" title="kembali" href="{{ route($middleware.'-skp_bulanan') }}"><span class="fa fa-angle-left"></span></a>
			SKP Bulanan Periode {!! Pustaka::periode($skp->tgl_mulai) !!}
		</h1>
    </section>
	  
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="callout callout-info " style="height:85px;">

					<table style="font-size:13px;">
						<tr>
							<td rowspan="4" style="padding:8px 2px;">
								<i class="st_icon fa fa-pencil fa-3x" style="padding-right:30px;"></i>
							</td>
							<td >Masa Penilaian</td>
							<td >&nbsp;&nbsp;:&nbsp;</td>
							<td>{{ Pustaka::tgl_form($skp->tgl_mulai).' s.d '.Pustaka::tgl_form($skp->tgl_selesai) }} </td>
						</tr>
						<tr>
							<td>
								Created at
							</td>
							<td>&nbsp;&nbsp;:&nbsp;</td>
							<td>{{ Pustaka::tgl_jam_short($skp->created_at)  }} </td>
						</tr>
						<tr>
							<td>
								Status
							</td>
							<td>&nbsp;&nbsp;:&nbsp;</td>
							<td>Open</td>
						</tr>
					</table>
				</div>
			
			</div>
		</div> 
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs" id="myTab">
				<li class="pejabat"><a href="#pejabat" data-toggle="tab" >Pejabat</a></li>
				<li class="kegiatan_bulanan_tab"><a href="#kegiatan_bulanan_tab" data-toggle="tab">Kegiatan <span class="hidden-xs">SKP Bulanan Eselon {!! $skp->PegawaiYangDinilai->Eselon->eselon !!} / {!! $skp->PegawaiYangDinilai->Eselon->id_jenis_jabatan!!}</span> </a></li>
				<li class="uraian_tugas_tambahan_tab"><a href="#uraian_tugas_tambahan_tab" data-toggle="tab" >Uraian Tugas Tambahan</a></li>
			</ul>


			<div class="tab-content"  style="min-height:400px;">
				<div class="active tab-pane fade" id="pejabat">
					@include('pare_pns.modules.tabs.skp_bulanan_pejabat')
				</div>
								
				<div class=" tab-pane fade" id="kegiatan_bulanan_tab">
					<?php
					switch(  $skp->PegawaiYangDinilai->Eselon->id_jenis_jabatan ) {
						case '1': // 1. Eselon II
								?>@include('pare_pns.tables.skp_bulanan-kegiatan_1')<?php
								break;
						case '2': //2. Eselon III
								?>@include('pare_pns.tables.skp_bulanan-kegiatan_2')<?php
								break;
						case '3':  //3. Eselon IV
								?>@include('pare_pns.tables.skp_bulanan-kegiatan_3')<?php
								break;
						case '4':  //4. JFU 
								?>@include('pare_pns.tables.skp_bulanan-kegiatan_4')<?php
								break;
						case '5':   //5. JFT
								?>@include('pare_pns.tables.skp_bulanan-kegiatan_5')<?php
								break;
					}
					?>
				</div>
				<div class="tab-pane fade" id="uraian_tugas_tambahan_tab">
					@include('pare_pns.tables.skp_bulanan-uraian_tugas_tambahan')
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
		$('#kegiatan_bulanan_table').DataTable().clear().destroy();
		$('#uraian_tugas_tambahan_table').DataTable().clear().destroy();

		if ( id == 'kegiatan_bulanan_tab'){
			LoadKegiatanBulananTable();
		}else if ( id == 'uraian_tugas_tambahan_tab'){
			LoadUraianTugasTambahanTable();
		}
	});
	var hash = window.location.hash;
	if ( hash != ''){
		$('#myTab a[href="' + hash + '"]').tab('show');
	}else{
		$('#myTab a[href="#pejabat"]').tab('show');
	}
});
</script>


@stop

