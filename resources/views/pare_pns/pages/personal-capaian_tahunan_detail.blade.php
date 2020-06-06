@extends('pare_pns.layouts.dashboard')

@section('template_title')
{{ Pustaka::nama_pegawai(\Auth::user()->pegawai->gelardpn , \Auth::user()->pegawai->nama , \Auth::user()->pegawai->gelarblk)  }}
@stop
 

@section('content')
	 <div class="content-wrapper" >
	    <section class="content-header">
			<h1>
				<a class="back_button" data-toggle="tooltip" title="kembali" href="{{ route('personal-capaian_tahunan') }}"><span class="fa fa-angle-left"></span></a>
				Capaian Tahunan Eselon {{ $capaian->PejabatYangDinilai->Eselon->eselon }}
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
			</ul>

 
			<div class="tab-content"  style="min-height:400px;">
				<div class="active tab-pane fade" id="status">


					<!-- 2. KASUBID -->
					@if ( $capaian->PejabatYangDinilai->Eselon->id_jenis_jabatan  == '3')
						@include('pare_pns.modules.timeline.capaian_tahunan_status_detail')
					@endif

					<!-- 5. JFT -->
					@if ( $capaian->PejabatYangDinilai->Eselon->id_jenis_jabatan  == '5')
						@include('pare_pns.modules.timeline.capaian_tahunan_status_detail')
					@endif
					
					
				</div>
				<div class="tab-pane fade" id="detail">
					@include('pare_pns.modules.detail_forms.capaian_tahunan_detail')			
				</div>
								
				<div class=" tab-pane fade" id="kegiatan_tahunan_tab">

					<?php
						switch(  $capaian->PejabatYangDinilai->Eselon->id_jenis_jabatan ) {
							case '1': 
									?><?php
									break;
							case '2':
									?>@include('pare_pns.tables.capaian_kegiatan_tahunan_detail')<?php
									break;
							case '3': 
									?>@include('pare_pns.tables.capaian_kegiatan_tahunan_detail')<?php
									break;
							case '4':   
									?><?php
									break;
							case '5':   
									?>@include('pare_pns.tables.capaian_kegiatan_tahunan_detail')<?php
									break;
						}
					?>
				
					
				</div>
				<div class=" tab-pane fade" id="unsur_penunjang_tab">
					@include('pare_pns.tables.unsur_penunjang_detail')
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
		if ( id == 'kegiatan_tahunan_tab'){
			load_kegiatan_tahunan();
		}else if ( id == 'status'){
			status_pengisian(); 
			
		}else if ( id == 'unsur_penunjang_tab'){
			load_tugas_tambahan(); 
			load_kreativitas();
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

