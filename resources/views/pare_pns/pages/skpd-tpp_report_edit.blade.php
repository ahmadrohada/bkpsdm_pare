@extends('pare_pns.layouts.dashboard')

@section('template_title')
{{ Pustaka::capital_string($skpd->skpd) }}
@stop



@section('content')
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			<a class="back_button" data-toggle="tooltip" title="kembali" href="{{ route('skpd-tpp_report') }}"><span class="fa fa-angle-left"></span></a>
			TPP Report {{ Pustaka::capital_string($skpd->skpd) }}

		</h1>
		{!! Breadcrumbs::render('skpd-tpp_report_edit') !!}
	</section>

	<section class="content">
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs" id="myTab">
				<li class="status"><a href="#status" data-toggle="tab">Status</a></li>
				<li class="tpp_report_data"><a href="#tpp_report_data" data-toggle="tab">TPP Report Data</a></li>
			</ul>
			<div class="tab-content" style="min-height:400px;">
				<div class="active tab-pane fade" id="status">
					@include('pare_pns.modules.timeline.tpp_report_status_edit')
				</div>
				<div class=" tab-pane fade" id="tpp_report_data">
					@include('pare_pns.tables.skpd-tpp_report_edit_data_list')
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