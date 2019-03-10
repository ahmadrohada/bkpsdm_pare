
<div class="row">
	<div class="col-md-4">
		<div class="box box-default">
			<div class="box-body box-profile">
			
				<h1 class="profile-username text-center text-success" style="font-size:16px;">
					Capaian SKP Periode {!! Pustaka::bulan($capaian->SKPBulanan->bulan) !!} {!! Pustaka::tahun($capaian->tgl_mulai) !!}
				</h1>

				<ul class="list-group list-group-unbordered">
					<li class="list-group-item ">
						Tanggal dibuat<a class="pull-right st_created_at">-</a>
					</li>
					<li class="list-group-item">
						Nama Pejabat Penilai <a class="pull-right st_pejabat_penilai">-</a>
					</li>
					<li class="list-group-item">
						Jumlah Kegiatan <a class="pull-right st_jm_kegiatan_bulanan" >-</a>
					</li>
					
				</ul>

				<!-- <button class="btn btn-primary btn-block close_capaian_bulanan " disabled><i class="send_icon fa fa-lock"></i> Close capaian Tahunan</button>
			 -->
			</div>
		</div>
	</div>
	<div class="col-md-8">
		<div class="table-responsive">
			<div id="myTimeline"></div>
		</div>
	</div>


</div>



	 
<link rel="stylesheet" href="https://cdn.jsdelivr.net/animatecss/3.5.2/animate.min.css" />
<link rel="stylesheet" href="{{asset('assets/timeline/style-albe-timeline.css')}}" />
<script src="{{asset('assets/timeline/jquery-albe-timeline.js')}}"></script>

<script type="text/javascript">


	function status_show(){
		status_pengisian();	

		$.ajax({
				url			: '{{ url("api_resource/capaian_bulanan_general_timeline") }}',
				data 		: { 
								
								},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					status(data);	
					//status_pengisian();	
				},
				error: function(data){
					
				}						
		});
	}

	function status(data){
		$('#myTimeline').albeTimeline(
				data, 
				{
				effect: 'fadeIn',
				showGroup: false,
				language : 'en-us',
				sortDesc : true,
				formatDate: 'dd de MMMM de yyyy HH:mm'
		});	
	}


						
	
	function status_pengisian(){
		$.ajax({
				url			: '{{ url("api_resource/capaian_bulanan_status_pengisian4") }}',
				data 		: { capaian_bulanan_id : {!! $capaian->id !!} },
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					//alert(data);
					if (data['button_kirim'] == 1 ){
						$('.close_capaian_bulanan').removeAttr('disabled');
					}else{
						$('.close_capaian_bulanan').attr('disabled','disabled');
					}

					$('.st_created_at').html(data['tgl_dibuat']);
					$('.st_pejabat_penilai').html(data['p_nama']);
					$('.st_jm_kegiatan_bulanan').html(data['jm_kegiatan_bulanan']);

				},
				error: function(data){
					
				}						
		});
	}

	function on_kirim(){
		$('.send_icon').addClass('fa fa-spinner faa-spin animated');
		$('.close_capaian_bulanan').prop('disabled',true);
	}
	function reset_kirim(){
		$('.send_icon').removeClass('fa fa-spinner faa-spin animated');
		$('.send_icon').addClass('fa fa-send');
		$('.close_capaian_bulanan').prop('disabled',false);
	}

	$(document).on('click','.close_capaian_bulanan',function(e){
		Swal.fire({
				title: "Tutup capaian Tahunan",
				text: "capaian Tahunan akan ditutup, edit pada capaian tidak bisa dilakukan",
				type: "question",
				showCancelButton: true,
				cancelButtonText: "Batal",
				confirmButtonText: "Close capaian",
				confirmButtonClass: "btn btn-success",
				cancelButtonClass: "btn btn-danger",
				cancelButtonColor: "#d33",
				closeOnConfirm: false
		}).then ((result) => {
			if (result.value){
				on_kirim();
				$.ajax({
					url		: '{{ url("api_resource/capaian_bulanan_close") }}',
					type	: 'POST',
					data    : {
								
							 },
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
