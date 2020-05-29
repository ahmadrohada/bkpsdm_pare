@extends('pare_pns.layouts.dashboard')

@section('template_title')
{{ Pustaka::capital_string(\Auth::user()->Pegawai->JabatanAktif->SKPD->skpd )  }}
@stop


@section('content')
	 <div class="content-wrapper"> 
	    <section class="content-header">

			<h1>
				<a class="back_button" data-toggle="tooltip" title="kembali" href="{{ route('admin-pohon_kinerja') }}"><span class="fa fa-angle-left"></span></a>
				Pohon Kinerja {{ Pustaka::capital_string($renja->SKPD->skpd) }}
			</h1>
   
				{!! Breadcrumbs::render('admin-pohon_kinerja-detail') !!}
        
	    </section>
	    <section class="content">

				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs" id="myTab">
						<li class="status"><a href="#status" data-toggle="tab">Status</a></li>
						<li class="detail"><a href="#detail" data-toggle="tab">Detail</a></li>
						<li class="rencana_kerja_tab"><a href="#rencana_kerja_tab" data-toggle="tab">Pohon Kinerja</a></li>
						<li class="distribusi_kegiatan"><a href="#distribusi_kegiatan" data-toggle="tab">Distribusi Kegiatan</a></li>
						<li class="perjanjian_kinerja"><a href="#perjanjian_kinerja" data-toggle="tab">Perjanjian Kinerja</a></li>
						<li class="kegiatan_tahunan"><a href="#kegiatan_tahunan" data-toggle="tab">Kegiatan Tahunan</a></li>
					
					</ul>
						
					<div class="tab-content"  style="margin-left:20px;">
						<div class="active tab-pane" id="status">
							@include('pare_pns.modules.timeline.renja_status_detail')	
						</div>
						<div class="tab-pane" id="detail">
							@include('pare_pns.modules.edit_forms.renja_detail')
						</div>
						
						<div class=" tab-pane" id="rencana_kerja_tab">
							@include('pare_pns.modules.tab.pohon_kinerja_detail')
						</div> 
						
  
						<div class=" tab-pane" id="distribusi_kegiatan">
							@include('pare_pns.modules.tab.distribusi_kegiatan_detail') 
						</div>
						<div class=" tab-pane" id="perjanjian_kinerja">
							@include('pare_pns.modules.tab.perjanjian_kinerja_skpd_detail') 
						</div>

						
						<div class=" tab-pane" id="kegiatan_tahunan">
							@include('pare_pns.modules.tab.pohon_kinerja-kegiatan_tahunan_detail') 
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
		//alert(id);

		if ( id == 'status'){
			status_show();
		}else if ( id == 'rencana_kerja_tab'){
			//alert(id);
			$('html, body').animate({scrollTop:0}, 0);
			RencanaKerjaList();
		}else if ( id == 'distribusi_kegiatan'){
			$('html, body').animate({scrollTop:0}, 0);
			initTreeDistribusiKegiatan();
		}else if ( id == 'rencana_aksi'){
			//alert(id);
			$('html, body').animate({scrollTop:0}, 0);
			
		}else if ( id == 'kegiatan_tahunan'){
			$('html, body').animate({scrollTop:0}, 0);
			initTreeKegTahunanPK();
		}else if ( id == 'perjanjian_kinerja'){
			$('html, body').animate({scrollTop:0}, 0);
			load_perjanjian_kinerja();
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

