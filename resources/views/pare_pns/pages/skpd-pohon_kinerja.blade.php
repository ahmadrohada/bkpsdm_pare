@extends('pare_pns.layouts.dashboard')

@section('template_title')
{{ Pustaka::capital_string(\Auth::user()->Pegawai->JabatanAktif->SKPD->skpd )  }}
@stop


@section('content')
	 <div class="content-wrapper">
	    <section class="content-header">

			<h1>
				<a class="back_button" data-toggle="tooltip" title="kembali" href="{{ route('skpd-pohon_kinerja') }}"><span class="fa fa-angle-left"></span></a>
				Pohon Kinerja 
			</h1>
	    </section>
	    <section class="content">

			<div class="row badge_persetujuan">
				<div class="col-md-12">
					<div class="callout callout-info " style="height:85px;">
	
						<table style="font-size:13px;">
							<tr>
								<td rowspan="4" style="padding:8px 2px;" class="hidden-xs"><i class="fa fa-pencil fa-3x" style="padding-right:30px;"></i></td>
								<td >Periode</td>
								<td >&nbsp;&nbsp;:&nbsp;</td>
								<td>{{ Pustaka::periode_tahun($renja->Periode->label) }} </td>
							</tr>
							<tr>
								<td>SKPD</td>
								<td>&nbsp;&nbsp;:&nbsp;</td>
								<td>{{ $renja->SKPD->skpd }} </td>
							</tr>
							<tr>
								<td>
									Created at
								</td>
								<td>&nbsp;&nbsp;:&nbsp;</td>
								<td>{{ Pustaka::tgl_jam_short($renja->created_at)  }} </td>
							</tr>
						</table>
					</div>
				
				</div>
			</div> 

				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs" id="myTab">
						<li class="pejabat"><a href="#pejabat" data-toggle="tab">Pejabat</a></li>
						<li class="cascading_tab"><a href="#cascading_tab" data-toggle="tab">Cascading</a></li>
						<li class="distribusi_subkegiatan"><a href="#distribusi_subkegiatan" data-toggle="tab">Distribusi Sub Kegiatan</a></li>
						<li class="perjanjian_kinerja"><a href="#perjanjian_kinerja" data-toggle="tab">Perjanjian Kinerja</a></li>
						{{-- <li class="sub_kegiatan"><a href="#sub_kegiatan" data-toggle="tab">Sub Kegiatan</a></li> --}}
					</ul>
						
					<div class="tab-content"  style="margin-left:20px;">
						<div class="tab-pane fade" id="pejabat">
							@include('pare_pns.modules.tabs.pohon_kinerja_pejabat')
						</div>
						
						<div class=" tab-pane fade" id="cascading_tab">
							@include('pare_pns.modules.tabs.pohon_kinerja_cascading')
						</div>
						<div class=" tab-pane fade" id="distribusi_subkegiatan">
							@include('pare_pns.modules.tabs.pohon_kinerja_distribusi_subkegiatan') 
						</div>
						<div class=" tab-pane fade" id="perjanjian_kinerja">
							@include('pare_pns.modules.tabs.pohon_kinerja_perjanjian_kinerja') 
						</div>

						{{-- <div class=" tab-pane" id="sub_kegiatan">
							@include('pare_pns.modules.tabs._pohon_kinerja_sub_kegiatan') 
						</div> --}}
						
					</div>
						
				</div>
	    </section>
	</div>

	
<link rel="stylesheet" href="{{asset('assets/jstree/themes/default/style.css')}}" />
<script src="{{asset('assets/jstree/jstree.min.js')}}"></script>

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
		$('html, body').animate({scrollTop:0}, 0);
		//alert(id);
		if ( id == 'cascading_tab'){
			renja_list_kegiatan_tree();
		}else if ( id == 'distribusi_subkegiatan'){
			initTreeDistribusiSubKegiatan();
		}else if ( id == 'sub_kegiatan'){
			initTreeSubKegiatanPK();
		}else if ( id == 'perjanjian_kinerja'){
			load_perjanjian_kinerja();
		}

		

		
	});


	// on load of the page: switch to the currently selected tab
	var hash = window.location.hash;
	if ( hash != ''){
		$('#myTab a[href="' + hash + '"]').tab('show');
	}else{
		$('#myTab a[href="#pejabat"]').tab('show');
	}
	

});
</script>



@stop

