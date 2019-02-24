@extends('admin.layouts.dashboard')

@section('template_title')
{{ Pustaka::nama_pegawai(\Auth::user()->pegawai->gelardpn , \Auth::user()->pegawai->nama , \Auth::user()->pegawai->gelarblk)  }}
@stop
 

@section('content')
	 <div class="content-wrapper" >
	    <section class="content-header">
			<h1>
				Detail SKP Tahunan
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
					<!-- 1. ka SKPD -->
					@if ( $skp->PejabatYangDinilai->Eselon->id_jenis_jabatan  == '1')
						@include('admin.modules.timeline.skp_tahunan_status_edit')	
					@endif

					<!-- 2. KABID -->
					@if ( $skp->PejabatYangDinilai->Eselon->id_jenis_jabatan  == '2')
						@include('admin.modules.timeline.skp_tahunan_status_general')	
					@endif

					<!-- 2. KASUBID -->
					@if ( $skp->PejabatYangDinilai->Eselon->id_jenis_jabatan  == '3')
						@include('admin.modules.timeline.skp_tahunan_status_edit')	
					@endif

					<!-- 2. PELAKSANA -->
					@if ( $skp->PejabatYangDinilai->Eselon->id_jenis_jabatan  == '4')
						@include('admin.modules.timeline.skp_tahunan_status_edit')	
					@endif	
				</div>
				<div class="tab-pane" id="detail">
					@include('admin.modules.detail_forms.skp_tahunan_detail')			
				</div>
								
				<div class=" tab-pane" id="kegiatan_tahunan_tab">
					<!-- 1. ka SKPD -->
					@if ( $skp->PejabatYangDinilai->Eselon->id_jenis_jabatan  == '1')
						@include('admin.tables.skp_kegiatan_tahunan_1_detail')
					@endif

					<!-- 2. KABID -->
					@if ( $skp->PejabatYangDinilai->Eselon->id_jenis_jabatan  == '2')
						@include('admin.tables.skp_kegiatan_tahunan_2_detail')
					@endif

					<!-- 2. KASUBID -->
					@if ( $skp->PejabatYangDinilai->Eselon->id_jenis_jabatan  == '3')
						@include('admin.tables.skp_kegiatan_tahunan_3_detail')
					@endif

					<!-- 2. PELAKSANA -->
					@if ( $skp->PejabatYangDinilai->Eselon->id_jenis_jabatan  == '4')
						@include('admin.tables.skp_kegiatan_tahunan_4_detail')
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

