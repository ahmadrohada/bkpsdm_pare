
<div class="row">
	<div class="col-md-4">
		<div class="box box-default">
			<div class="box-body box-profile">
			
				<h1 class="profile-username text-center text-success" style="font-size:16px;">
					Capaian Triwulan  {!! $capaian_triwulan->triwulan !!}
				</h1>

				<ul class="list-group list-group-unbordered">
					<li class="list-group-item ">
						Tanggal dibuat<a class="pull-right st_created_at">-</a>
					</li>
					<li class="list-group-item">
						Pejabat Penilai <a class="pull-right st_pejabat_penilai">-</a>
					</li>
					<li class="list-group-item hidden" >
						Jumlah Kegiatan Tahunan <a class="pull-right st_jm_kegiatan_tahunan" >-</a>
					</li>
					
				</ul>
				<a href="#" class="btn btn-primary btn-block tutup_capaian hidden"><b>Tutup <i class="send_icon"></i></b></a>
				


			</div>
		</div>
	</div>
	<div class="col-md-8">
		
	</div>


</div>




<script type="text/javascript">

	status_pengisian();
	
	function status_pengisian(){
		$.ajax({
				url			: '{{ url("api_resource/capaian_triwulan_status_pengisian") }}',
				data 		: { capaian_triwulan_id : {!! $capaian_triwulan->id !!} },
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					

					$('.st_created_at').html(data['tgl_dibuat']);
					$('.st_pejabat_penilai').html(data['p_nama']);
					$('.st_jm_kegiatan_tahunan').html(data['jm_kegiatan_tahunan']);


					if ( data['status'] == 0 ){
						
						$('.tutup_capaian').removeClass('hidden');
					} 


				},
				error: function(data){
					
				}						
		});
	}

	function on_tutup(){
		$('.send_icon').addClass('fa fa-spinner faa-spin animated');
		$('.tutup_capaian').prop('disabled',true);
	}
	function reset_tutup(){
		$('.send_icon').removeClass('fa fa-spinner faa-spin animated');
		$('.send_icon').addClass('fa fa-send');
		$('.tutup_capaian').prop('disabled',false);
	}

	$(document).on('click','.tutup_capaian',function(e){
		Swal.fire({
				title: "Tutup Capaian Triwulan",
				text: "Dengan menutup capaian, proses edit tidak dapat dilakukan kembali, dan capaian akan diperlihatkan kepada atasan",
				type: "question",
				showCancelButton: true,
				cancelButtonText: "Batal",
				confirmButtonText: "Tutup Capaian",
				confirmButtonClass: "btn btn-success",
				cancelButtonClass: "btn btn-danger",
				cancelButtonColor: "#d33",
				closeOnConfirm: false
		}).then ((result) => {
			if (result.value){
				on_tutup();
				$.ajax({
					url		: '{{ url("api_resource/tutup_capaian_triwulan") }}',
					type	: 'POST',
					data    : { capaian_triwulan_id : {!! $capaian_triwulan->id !!} },
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
										reset_tutup();
										location.reload();

									},
									function (dismiss) {
										if (dismiss === 'timer') {
											
											
										}
									}
								)
								
							
					},
					error: function(e) {
							reset_tutup();
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
