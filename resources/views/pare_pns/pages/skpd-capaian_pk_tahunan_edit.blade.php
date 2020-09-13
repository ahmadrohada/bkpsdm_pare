@extends('pare_pns.layouts.dashboard')

@section('template_title')
	Capaian PK 
@stop


@section('content')
	 <div class="content-wrapper" >
	    <section class="content-header">
			<h1>
				<a class="back_button" data-toggle="tooltip" title="kembali" href="{{ route('skpd-capaian_pk_tahunan') }}"><span class="fa fa-angle-left"></span></a>
				Edit Capaian PK Tahunan
			</h1>
				{!! Breadcrumbs::render('skpd-capaian_pk_tahunan_edit') !!}
      </section>
	  
	    <section class="content">
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs" id="myTab">
				{{-- <li class="status active"><a href="#status" data-toggle="tab">Status </a></li> --}}
				<li class="detail active"><a href="#detail" data-toggle="tab" >Detail</a></li>
				<li class="sasaran_tahunan_tab"><a href="#sasaran_tahunan_tab" data-toggle="tab">Sasaran </a></li>
				<li class="program_tahunan_tab"><a href="#program_tahunan_tab" data-toggle="tab">Program </a></li>
			</ul>

 
			<div class="tab-content"  style="min-height:400px;">
				<div class="tab-pane fade" id="status">
					
				</div>
				<div class=" tab-pane fade" id="detail">
					
				</div>
				<div class="tab-pane fade" id="sasaran_tahunan_tab">
					@include('pare_pns.tables.capaian_pk_sasaran_tahunan')
				</div>			
				<div class=" tab-pane fade" id="program_tahunan_tab">
					@include('pare_pns.tables.capaian_pk_program_tahunan')
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
		
		if ( id == 'sasaran_tahunan_tab'){
			load_sasaran_tahunan();
		}else if ( id == 'program_tahunan_tab'){
			
			load_program_tahunan();
		}else if ( id == 'detail'){
			
		}
		$('html, body').animate({scrollTop:0}, 0);
	});


	

	// on load of the page: switch to the currently selected tab
	var hash = window.location.hash;
	if ( hash != ''){
		$('#myTab a[href="' + hash + '"]').tab('show');
	}else{
		$('#myTab a[href="#detail"]').tab('show');
	}
	

});
</script>


@stop

