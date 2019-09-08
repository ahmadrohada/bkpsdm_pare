@extends('admin.layouts.dashboard')

@section('template_title')
{{ Pustaka::nama_pegawai(\Auth::user()->pegawai->gelardpn , \Auth::user()->pegawai->nama , \Auth::user()->pegawai->gelarblk)  }}
@stop

  
@section('content')
	 <div class="content-wrapper" >
	    <section class="content-header">
			<h1>
				Edit SKP Tahunan
			</h1>
				{!! Breadcrumbs::render('personal_edit_skp_tahunan') !!}
      </section>
	  
	    <section class="content">
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs" id="myTab">
				<li class="status"><a href="#status" data-toggle="tab">Status </a></li>
				<li class="detail"><a href="#detail" data-toggle="tab" >Detail</a></li>
				<li class="kegiatan_tahunan_tab"><a href="#kegiatan_tahunan_tab" data-toggle="tab">Kegiatan Tahunan Eselon {!! $skp->PejabatYangDinilai->Eselon->eselon !!} / {!! $skp->PejabatYangDinilai->Eselon->id_jenis_jabatan!!}</a></li>
				<li class="kegiatan_bulanan_tab"><a href="#kegiatan_bulanan_tab" data-toggle="tab">Kegiatan Bulanan</a></li>
			</ul>

 
			<div class="tab-content"  style="margin-left:10px; min-height:400px;">
				<div class="active tab-pane" id="status">

					<!-- ALL jabatan is one status edit -->
					@include('admin.modules.timeline.skp_tahunan_status_general')	
					
					 
				</div>
				<div class="tab-pane" id="detail">
					@include('admin.modules.edit_forms.skp_tahunan_detail')			
				</div>
								
				<div class=" tab-pane" id="kegiatan_tahunan_tab">
					<!-- 1. KABAN -->
					@if ( $skp->PejabatYangDinilai->Eselon->id_jenis_jabatan  == '1')
						@include('admin.tables.skp_kegiatan_tahunan_1_detail')
					@endif

					<!-- 2. KABID -->
					@if ( $skp->PejabatYangDinilai->Eselon->id_jenis_jabatan  == '2')
						@include('admin.tables.skp_kegiatan_tahunan_2_detail')
					@endif

					<!-- 3. KASUBID -->
					@if ( $skp->PejabatYangDinilai->Eselon->id_jenis_jabatan  == '3')
						@include('admin.modules.tab.kegiatan_tahunan_3_edit')
					@endif

					<!-- 4. PELAKSANA -->
					@if ( $skp->PejabatYangDinilai->Eselon->id_jenis_jabatan  == '4')
						@include('admin.tables.skp_kegiatan_tahunan_4_detail')
					@endif
				
					
				</div>
				<div class="tab-pane" id="kegiatan_bulanan_tab">

					<!-- 1. KABAN -->
					@if ( $skp->PejabatYangDinilai->Eselon->id_jenis_jabatan  == '1')
						@include('admin.tables.skp_kegiatan_bulanan_1_edit')
					@endif

					<!-- 2. KASUBID -->
					@if ( $skp->PejabatYangDinilai->Eselon->id_jenis_jabatan  == '2')
						@include('admin.tables.skp_kegiatan_bulanan_2_edit')
					@endif


					<!-- 3. KASUBID -->
					@if ( $skp->PejabatYangDinilai->Eselon->id_jenis_jabatan  == '3')
						@include('admin.modules.tab.kegiatan_bulanan_3_edit')
					@endif

					<!-- 4. PELAKSANA -->
					@if ( $skp->PejabatYangDinilai->Eselon->id_jenis_jabatan  == '4')
						@include('admin.tables.skp_kegiatan_bulanan_4_edit')		
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
		//alert(id);

		if ( id == 'kegiatan_tahunan_tab'){
			$('html, body').animate({scrollTop:0}, 0);
			initTreeKegTahunan();
		}else if ( id == 'kegiatan_bulanan_tab'){
			$('html, body').animate({scrollTop:0}, 0);
			initTreeKegBulanan();
		}else if ( id == 'status'){
			status_show();
		}else if ( id == 'detail'){
			detail_show();
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

