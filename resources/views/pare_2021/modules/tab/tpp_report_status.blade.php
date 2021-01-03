<div class="row">
	<div class="col-md-4">
		<div class="box box-primary">
			<div class="box-body box-profile"> 

				<h4 class=" text-center">TPP Report </h4>
				<p class="text-muted text-center"></p>

				<ul class="list-group list-group-unbordered">
					<li class="list-group-item " style="padding:8px 10px;">
						<b>Periode</b> <a class="pull-right st_periode">-</a>
					</li>
					<li class="list-group-item " style="padding:8px 10px;">
						<b>Create</b> <a class="pull-right st_created_at">-</a>
					</li>
					<li class="list-group-item " style="padding:8px 10px;">
						<b>Nama Kepala SKPD</b> <a class="pull-right st_ka_skpd">-</a>
					</li>
					<li class="list-group-item " style="padding:8px 10px;">
						<b>Admin SKPD</b> <a class="pull-right st_admin_skpd">-</a>
					</li>
					<li class="list-group-item " style="padding:8px 10px;">
						<b>Jumlah Data Pegawai</b> <a class="pull-right st_jm_data_pegawai">-</a>
					</li>
					<li class="list-group-item " style="padding:8px 10px;">
						<b>Jumlah Data Capaian</b> <a class="pull-right st_jm_data_capaian">-</a>
					</li>
					<li class="list-group-item " style="padding:8px 10px;">
						<b>Status</b> <a class="pull-right st_status">-</a>
					</li>
				</ul>

				@if ( request()->segment(5) == 'edit' )
					<a href="#" class="btn btn-primary btn-block tutup_tpp_report hidden"><b>Tutup <i class="send_icon"></i></b></a>
				@endif

				

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
			url: '{{ url("api/tpp_report_detail") }}',
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
					$('.st_status').html('Open');
					$('.tutup_tpp_report').removeClass('hidden');
				}else{
					$('.st_status').html('Close');
				}


			},
			error: function(data) {

			}
		});
	}


	function on_kirim(){
		$('.send_icon').addClass('fa fa-spinner faa-spin animated');
		$('.tutup_tpp_report').prop('disabled',true);
	}
	function reset_kirim(){
		$('.send_icon').removeClass('fa fa-spinner faa-spin animated');
		$('.send_icon').addClass('fa fa-send');
		$('.tutup_tpp_report').prop('disabled',false);
	}

	$(document).on('click','.tutup_tpp_report',function(e){
		Swal.fire({
				title: "Tutup TPP Report",
				text: "TPP Report akan ditutup, data akan dikirim ke admin BKPSDM",
				type: "question",
				showCancelButton: true,
				cancelButtonText: "Batal",
				confirmButtonText: "Close TPP",
				confirmButtonClass: "btn btn-success",
				cancelButtonClass: "btn btn-danger",
				cancelButtonColor: "#d33",
				closeOnConfirm: false
		}).then ((result) => {
			if (result.value){
				on_kirim();
				$.ajax({
					url		: '{{ url("api/close_tpp_report") }}',
					type	: 'POST',
					data    : {tpp_report_id: {!! $tpp_report->id !!} },
					cache   : false,
					success:function(data){
							
							Swal.fire({
									title: "",
									text: "Sukses",
									type: "success",
									width: "200px",
									showConfirmButton: false,
									allowOutsideClick : false,
									timer: 900
									}).then(function () {
										reset_kirim();
										location.reload();

									},
									function (dismiss) {
										if (dismiss === 'timer') {
											
											
										}
									}
								)
								
							
					},
					error: function(e) {
							reset_kirim();
							Swal.fire({
									title: "Gagal",
									text: "",
									type: "warning"
								}).then (function(){
										
								});
							}
					});	
				

					
			}
		});
	});

</script>