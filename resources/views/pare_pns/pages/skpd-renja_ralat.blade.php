@extends('pare_pns.layouts.dashboard')

@section('template_title')
{{ Pustaka::capital_string(\Auth::user()->Pegawai->JabatanAktif->SKPD->skpd )  }}
@stop


@section('content')
	 <div class="content-wrapper">
	    <section class="content-header">

			<h1>
				Ralat Rencana Kerja
			</h1>

				{!! Breadcrumbs::render('skpd-pohon_kinerja') !!}
        
	    </section>
	    <section class="content">

				<div class="nav-tabs-custom ">
					<ul class="nav nav-tabs" id="myTab">
						<li class="status"><a href="#status" data-toggle="tab">Sumary</a></li>
						<li class="detail"><a href="#detail" data-toggle="tab">Detail</a></li>
						<li class="rencana_kerja_tab"><a href="#rencana_kerja_tab" data-toggle="tab">Pohon Kinerja</a></li>
						<li class="distribusi_kegiatan"><a href="#distribusi_kegiatan" data-toggle="tab">Distribusi Kegiatan</a></li>
					</ul>
						
					<div class="tab-content"  style="margin-left:20px;">
						<div class="active tab-pane fade" id="status">
							@include('pare_pns.modules.timeline.renja_status_edit')	
						</div>
						<div class="tab-pane fade" id="detail">
							@include('pare_pns.modules.tabs.renja_detail')
						</div>
						
						<div class=" tab-pane fade" id="rencana_kerja_tab">
							@include('pare_pns.modules.tabs.pohon_kinerja_edit')
						</div>
						<div class=" tab-pane fade" id="distribusi_kegiatan">
							@include('pare_pns.modules.tabs.distribusi_kegiatan_edit') 
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
			$('html, body').animate({scrollTop:0}, 0);
			renja_list_kegiatan_tree();
		}else if ( id == 'distribusi_kegiatan'){
			$('html, body').animate({scrollTop:0}, 0);
			initTreeDistribusiKegiatan();
		}

		
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

