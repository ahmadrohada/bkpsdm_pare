@extends('admin.layouts.dashboard')

@section('template_title')
{{ Pustaka::capital_string(\Auth::user()->Pegawai->JabatanAktif->SKPD->skpd )  }}
@stop


@section('content')
	 <div class="content-wrapper">
	    <section class="content-header">

			<h1>
				Persetujuan Rencana Kerja
			</h1>

				{!! Breadcrumbs::render('skpd-renja') !!}
        
	    </section>
	    <section class="content">
 
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs" id="myTab">
						<li class="status"><a href="#status" data-toggle="tab">Status</a></li>
						<li class="detail"><a href="#detail" data-toggle="tab">Detail</a></li>
						<li class="renja_tree"><a href="#renja_list" data-toggle="tab">Rencana Kerja</a></li>
						<li class="distribusi_kegiatan"><a href="#distribusi_kegiatan" data-toggle="tab">Distribusi Kegiatan</a></li>
					</ul>
						
					<div class="tab-content"  style="margin-left:20px;">
						<div class="active tab-pane" id="status">
							@include('admin.modules.timeline.renja_status_approval')	
						</div>
						<div class="tab-pane" id="detail">
							@include('admin.modules.skpd-renja_detail')
						</div>
						
						<div class=" tab-pane" id="renja_list">
							@include('admin.modules.detail_forms.rencana_kerja')
						</div> 
						
  
						<div class=" tab-pane" id="distribusi_kegiatan">
							@include('admin.modules.edit_forms.distribusi_kegiatan') 
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

		if ( id == 'renja_list'){
			initRenjaTree();
			
		}else if ( id == 'status'){
			
			status_show();
		}else if ( id == 'distribusi_kegiatan'){
			initTreeDistribusiKegiatan();
			
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

