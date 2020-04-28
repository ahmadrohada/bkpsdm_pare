@extends('admin.layouts.dashboard')

@section('template_title')
TPP Report {{ Pustaka::capital_string($tpp_report->skpd->nama_skpd) }}
@stop

@section('content')
<div class="content-wrapper">
	<section class="content-header">
		<h1>
		<a class="back_button" data-toggle="tooltip" title="kembali" href="{{ route('admin-tpp_report') }}"><span class="fa fa-angle-left"></span></a>
			TPP Report {{ Pustaka::capital_string($tpp_report->skpd->nama_skpd) }} 
		</h1>
		{!! Breadcrumbs::render('skpd-tpp_report_detail') !!}
	</section>

	<section class="content">
		<div class="nav-tabs-custom">
			
			<ul class="nav nav-tabs" id="myTab">
				<li class="status"><a href="#status" data-toggle="tab">Status</a></li>
				<li class="tpp_report_data"><a href="#tpp_report_data" data-toggle="tab">TPP Report Data</a></li>
			</ul>
			<div class="tab-content" style="margin-left:10px; min-height:400px;">
				<div class="active tab-pane" id="status">
					@include('admin.modules.timeline.tpp_report_status_edit')
				</div>
				<div class=" tab-pane" id="tpp_report_data">
					@include('admin.tables.skpd-tpp_report_detail_data_list')
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

			if (id == 'tpp_report_data') {
				$('html, body').animate({
					scrollTop: 0
				}, 0);
				load_table_tpp();
			} else if (id == 'status') {
				status_pengisian();
			}
			$('html, body').animate({
				scrollTop: 0
			}, 0);
		});




		// on load of the page: switch to the currently selected tab
		var hash = window.location.hash;
		if (hash != '') {
			$('#myTab a[href="' + hash + '"]').tab('show');
		} else {
			$('#myTab a[href="#status"]').tab('show');
		}


	});
</script>


@stop