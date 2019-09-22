@extends('admin.layouts.dashboard')

@section('template_title')
{{ Pustaka::nama_pegawai(\Auth::user()->pegawai->gelardpn , \Auth::user()->pegawai->nama , \Auth::user()->pegawai->gelarblk)  }}
@stop


@section('content')
	 <div class="content-wrapper" >
	    <section class="content-header">
			<h1>
				Edit Capaian Triwulan [ {!! Pustaka::trimester($capaian_triwulan->trimester) !!} ]
			</h1>
				{!! Breadcrumbs::render('personal_edit_capaian_triwulan') !!}
      </section>
	  
	    <section class="content">
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs" id="myTab">
				<li class="status active"><a href="#status" data-toggle="tab">Status </a></li>
				<li class="detail"><a href="#detail" data-toggle="tab" >Detail</a></li>
				<li class="kegiatan_triwulan_tab"><a href="#kegiatan_triwulan_tab" data-toggle="tab">Kegiatan Tahunan Eselon {!! $capaian_triwulan->PejabatYangDinilai->Eselon->eselon !!} / {!! $capaian_triwulan->PejabatYangDinilai->Eselon->id_jenis_jabatan!!}</a></li>
				
			</ul>

 
			<div class="tab-content"  style="margin-left:10px; min-height:400px;">
				<div class="active tab-pane" id="status">
					<!-- 2. KABID -->
					@if ( $capaian_triwulan->PejabatYangDinilai->Eselon->id_jenis_jabatan  == '2')
						@include('admin.modules.timeline.capaian_triwulan_status_edit')
					@endif

					<!-- 2. KASUBID -->
					@if ( $capaian_triwulan->PejabatYangDinilai->Eselon->id_jenis_jabatan  == '3')
						@include('admin.modules.timeline.capaian_triwulan_status_edit')
					@endif
					
				</div>
				<div class="tab-pane" id="detail">
					@include('admin.modules.edit_forms.capaian_triwulan_detail')		
				</div>
								
				<div class=" tab-pane" id="kegiatan_triwulan_tab">


					<!-- 2. KABID -->
					@if ( $capaian_triwulan->PejabatYangDinilai->Eselon->id_jenis_jabatan  == '2')
						@include('admin.tables.capaian_kegiatan_triwulan_2_edit')
					@endif

					<!-- 3. KASUBID -->
					@if ( $capaian_triwulan->PejabatYangDinilai->Eselon->id_jenis_jabatan  == '3')
						@include('admin.tables.capaian_kegiatan_triwulan_3_edit')
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

		if ( id == 'kegiatan_triwulan_tab'){
			load_kegiatan_triwulan();
		}else if ( id == 'status'){
			status_pengisian();
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

