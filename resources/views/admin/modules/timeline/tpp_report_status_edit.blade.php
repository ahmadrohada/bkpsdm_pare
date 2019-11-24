<div class="row">
	<div class="col-md-4">
		<div class="box box-default">
			<div class="box-body box-profile">

				<h4 class=" text-center">TPP Report </h4>
				<p class="text-muted text-center"></p>

				<ul class="list-group list-group-unbordered">
					<li class="list-group-item">
						<b>Periode</b> <a class="pull-right st_periode">-</a>
					</li>
					<li class="list-group-item">
						<b>Create</b> <a class="pull-right st_created_at">-</a>
					</li>
					<li class="list-group-item">
						<b>Nama Kepala SKPD</b> <a class="pull-right st_ka_skpd">-</a>
					</li>
					<li class="list-group-item">
						<b>Admin SKPD</b> <a class="pull-right st_admin_skpd">-</a>
					</li>
					<li class="list-group-item">
						<b>Jumlah Data Pegawai</b> <a class="pull-right st_jm_data_pegawai">-</a>
					</li>
					<li class="list-group-item">
						<b>Jumlah Data Capaian</b> <a class="pull-right st_jm_data_capaian">-</a>
					</li>
					<li class="list-group-item ">
						<b>Status</b> <a class="pull-right">Open</a>
					</li>
				</ul>

				<a href="#" class="btn btn-primary btn-block tutup_tpp_report hidden"><b>Tutup <i class="send_icon"></i></b></a>

			</div>
		</div>
	</div>
	<div class="col-md-8">
		<div class="table-responsive">
			<div id="myTimeline"></div>
		</div>
	</div>


</div>

<script type="text/javascript">
	
	//status_pengisian();

	function status_pengisian() {
		$.ajax({
			url: '{{ url("api_resource/tpp_report_detail") }}',
			data: {
				tpp_report_id: {{ $tpp_report->id }}
			},
			method: "GET",
			dataType: "json",
			success: function(data) {


				$('.st_periode').html(data['periode']);
				$('.st_created_at').html(data['created_at']);
				$('.st_ka_skpd').html(data['ka_skpd']);
				$('.st_admin_skpd').html(data['admin_skpd']);
				$('.st_jm_data_pegawai').html(data['jm_data_pegawai']);
				$('.st_jm_data_capaian').html(data['jm_data_capaian']);


				if (data['status'] == 0) {

					$('.tutup_tpp_report').removeClass('hidden');
				}


			},
			error: function(data) {

			}
		});
	}

</script>