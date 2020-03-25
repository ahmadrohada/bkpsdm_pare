@extends('admin.layouts.dashboard')

@section('template_title')
{{ Pustaka::nama_pegawai(\Auth::user()->pegawai->gelardpn , \Auth::user()->pegawai->nama , \Auth::user()->pegawai->gelarblk)  }}
@stop
 

@section('content')
	 <div class="content-wrapper" >
	    <section class="content-header">
			<h1>
				<a class="back_button" data-toggle="tooltip" title="kembali" href="{{ route('personal-capaian_tahunan_approvement') }}"><span class="fa fa-angle-left"></span></a>
				Capaian Tahunan Approvement
			</h1>
				{!! Breadcrumbs::render('personal_edit_capaian_tahunan') !!}
      </section>
	  
	    <section class="content">
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs" id="myTab">
				<li class="status"><a href="#status" data-toggle="tab">Status </a></li>
				<li class="detail"><a href="#detail" data-toggle="tab" >Detail</a></li>
				<li class="kegiatan_tahunan_tab"><a href="#kegiatan_tahunan_tab" data-toggle="tab">A. Kegiatan Tahunan Eselon {!! $capaian->PejabatYangDinilai->Eselon->eselon !!} / {!! $capaian->PejabatYangDinilai->Eselon->id_jenis_jabatan!!}</a></li>
				<li class="unsur_penunjang_tab"><a href="#unsur_penunjang_tab" data-toggle="tab">B. Unsur Penunjang</a></li>
			
			</ul>

 
			<div class="tab-content"  style="margin-left:10px; min-height:400px;">
				<div class="active tab-pane" id="status">


					<!-- 2. KASUBID -->
					@if ( $capaian->PejabatYangDinilai->Eselon->id_jenis_jabatan  == '3')
						@include('admin.modules.timeline.capaian_tahunan_status_approvement')
					@endif

					<!-- 5. JFT -->
					@if ( $capaian->PejabatYangDinilai->Eselon->id_jenis_jabatan  == '5')
						@include('admin.modules.timeline.capaian_tahunan_status_approvement')
					@endif
					
					
				</div>
				<div class="tab-pane" id="detail">
					@include('admin.modules.detail_forms.capaian_tahunan_detail')			
				</div>
								
				<div class=" tab-pane" id="kegiatan_tahunan_tab">

					<!-- 3. KASUBID -->
					@if ( $capaian->PejabatYangDinilai->Eselon->id_jenis_jabatan  == '3')
						@include('admin.tables.capaian_kegiatan_tahunan_approvement')
					@endif

					<!-- 5. JFT -->
					@if ( $capaian->PejabatYangDinilai->Eselon->id_jenis_jabatan  == '5')
						@include('admin.tables.capaian_kegiatan_tahunan_approvement')
					@endif
				
					
				</div>
				<div class=" tab-pane" id="unsur_penunjang_tab">
					@include('admin.tables.unsur_penunjang_detail')
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

