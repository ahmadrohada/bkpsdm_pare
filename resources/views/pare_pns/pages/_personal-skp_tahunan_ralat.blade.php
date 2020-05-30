@extends('pare_pns.layouts.dashboard')

@section('template_title')
{{ Pustaka::nama_pegawai(\Auth::user()->pegawai->gelardpn , \Auth::user()->pegawai->nama , \Auth::user()->pegawai->gelarblk)  }}
@stop


@section('content')
	 <div class="content-wrapper" >
	    <section class="content-header">
			<h1>
				Ralat SKP Tahunan
			</h1>
				{!! Breadcrumbs::render('personal_edit_skp_tahunan') !!}
      </section>
	  
	    <section class="content">
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs" id="myTab">
				<li class=" status"><a href="#status" data-toggle="tab">Status </a></li>
				<li class="detail"><a href="#detail" data-toggle="tab" >Detail</a></li>
				<li class="kegiatan_tahunan_tab"><a href="#kegiatan_tahunan_tab" data-toggle="tab">Kegiatan SKP Tahunan Eselon {!! $skp->PejabatYangDinilai->Eselon->eselon !!} / {!! $skp->PejabatYangDinilai->Eselon->id_jenis_jabatan!!}</a></li>
			</ul>


			<div class="tab-content"  style="margin-left:10px; min-height:400px;">
				<div class="active tab-pane" id="status">
					@include('pare_pns.modules.timeline.skp_tahunan_status_ralat')	
				</div>
				<div class="tab-pane" id="detail">
					@include('pare_pns.modules.edit_forms.skp_tahunan_detail')			
				</div>
								
				<div class=" tab-pane" id="kegiatan_tahunan_tab">
					<!-- 1. ka SKPD -->
					@if ( $skp->PejabatYangDinilai->Eselon->id_jenis_jabatan  == '1')
						@include('pare_pns.tables.tables_skp_tahunan-kegiatan_1_edit')
					@endif 

					<!-- 2. KABID -->
					@if ( $skp->PejabatYangDinilai->Eselon->id_jenis_jabatan  == '2')
						@include('pare_pns.tables.skp_tahunan-kegiatan_2_edit')
					@endif

					<!-- 2. KASUBID -->
					@if ( $skp->PejabatYangDinilai->Eselon->id_jenis_jabatan  == '3')
						@include('pare_pns.tables.skp_tahunan-kegiatan_3_edit')
					@endif

					<!-- 2. PELAKSANA -->
					@if ( $skp->PejabatYangDinilai->Eselon->id_jenis_jabatan  == '4')
						@include('pare_pns.tables.kegiatan_tahunan_4')
					@endif
				
				
				
				
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
			initTree();
		}else if ( id == 'status'){
			status_show();
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
