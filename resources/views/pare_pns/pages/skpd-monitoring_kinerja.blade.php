@extends('pare_pns.layouts.dashboard')

@section('template_title')
{{ Pustaka::capital_string(\Auth::user()->Pegawai->JabatanAktif->SKPD->skpd )  }}
@stop
  
 
@section('content')
	 <div class="content-wrapper" >
	    <section class="content-header">
			<h1>
				<a class="back_button" data-toggle="tooltip" title="kembali" href="{{ route('skpd-capaian_pk_triwulan') }}"><span class="fa fa-angle-left"></span></a>
				Monitoring Kinerja
			</h1>
				{!! Breadcrumbs::render('skpd-pohon_kinerja') !!}
      </section>
	  
	    <section class="content">

			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs" id="myTab">
					<li class="monitoring_kinerja"><a href="#tab_1" data-toggle="tab">Monitoring Kinerja </a></li>
					<li class="kegiatan"><a href="#tab_2" data-toggle="tab" >Kegiatan</a></li>
					
				</ul>
				<div class="tab-content"  style="min-height:400px;">
					<div class="active tab-pane fade" id="tab_1">
						@include('pare_pns.tables.skpd-monitoring_kinerja')
					</div>
					<div class="tab-pane fade" id="tab_2">
						@include('pare_pns.tables.skpd-monitoring_kinerja_kegiatan')
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
		//destroy table agar hide kolom  tidak muncul duluan
		//$('#table_monitoring_kinerja').DataTable().clear().destroy();

		if ( id == 'tab_1'){
			//LoadKegiatanBulananTable(); 
		}else if ( id == 'tab_2'){
			mk_kegiatan();
		}
		$('html, body').animate({scrollTop:0}, 0);
	});


	

	// on load of the page: switch to the currently selected tab
	var hash = window.location.hash;
	if ( hash != ''){
		$('#myTab a[href="' + hash + '"]').tab('show');
	}else{
		$('#myTab a[href="#tab_1"]').tab('show');
	}
	

});
</script>


@stop

