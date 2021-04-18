@extends('pare_pns.layouts.dashboard')

@section('template_title')

@stop

@section('content')
<div class="content-wrapper">
	<section class="content-header">
		<?php
				$route_name = 'administrator-capaian_tahunan' ;
		?>
		<h1>
			<a class="back_button" data-toggle="tooltip" title="kembali" href="{{ route($route_name) }}"><span class="fa fa-angle-left"></span></a>
			Capaian SKP Tahunan  
		</h1>
	</section>
	<section class="content">
		<div class="row badge_persetujuan">
			<div class="col-md-12">
				<div class="callout callout-info "  style="height:120px;">
					<table style="font-size:12px;">
						<tr>
							<td rowspan="4" style="padding:4px 2px;">
								<i class="st_icon fa fa-tasks fa-3x" style="padding-right:30px;"></i>
							</td>
							<td >Periode</td>
							<td >&nbsp;&nbsp;&nbsp;</td>
							<td>{{ $periode }}</td>
						</tr>
						<tr>
							<td>
								SKPD
							</td>
							<td></td>
							<td>{{ $skpd }}</td>
						</tr>
					</table>
					<hr>
					<div class="col-xs-12 col-lg-2 no-padding" >
						<button type="button" class="btn btn-sm btn-block btn-warning pull-left cetak" style="margin-top:-15px;">
							<i class="fa fa-print"></i> cetak<i class="send_icon"></i>
						</button>
					</div>
				</div>
			
			</div>
		</div>
		@include('pare_pns.tables.administrator-capaian_tahunan_elapkin')
	</section>
</div>
<script type="text/javascript">
</script>


@stop