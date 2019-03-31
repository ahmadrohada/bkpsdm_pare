
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
						Nama Pejabat <a class="pull-right st_pejabat">-</a>
					</li>
					<li class="list-group-item">
						Jumlah Kegiatan <a class="pull-right st_jm_kegiatan_bulanan" >-</a>
					</li>
					<li class="list-group-item">
						Capaian Kinerja Bulanan <a class="pull-right st_capaian_kinerja_bulanan" >-</a>
					</li>

					<li class="list-group-item hidden" >
						Capaian Kode Etik <a class="pull-right st_capaian_kode_etik" >-</a>
					</li>
					
				</ul>

				
				
				<div class="pull-right">
					<a href="#" class="btn btn-sm btn-danger tolak_capaian_bulanan">TOLAK</a>
					<a href="#" class="btn btn-sm btn-primary terima_capaian_bulanan">TERIMA</a>
				</div>

			</div>
			
		</div>
	</div>
	<div class="col-md-8">
		<div class="table-responsive">
			<div id="myTimeline"></div>
		</div>
	</div>


</div>

@include('admin.modals.penilaian_kode_etik')
	 
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/animatecss/3.5.2/animate.min.css" />
<link rel="stylesheet" href="{{asset('assets/timeline/style-albe-timeline.css')}}" />
<script src="{{asset('assets/timeline/jquery-albe-timeline.js')}}"></script>
 -->
<script type="text/javascript">


	function status_show(){
		status_pengisian();	
	}

	/* function status(data){
		$('#myTimeline').albeTimeline(
				data, 
				{
				effect: 'fadeIn',
				showGroup: false,
				language : 'en-us',
				sortDesc : true,
				formatDate: 'dd de MMMM de yyyy HH:mm'
		});	
	} */


						
	
	function status_pengisian(){
		$.ajax({
				url			: '{{ url("api_resource/capaian_bulanan_status_pengisian") }}',
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
					$('.st_pejabat').html(data['u_nama']);
					$('.st_jm_kegiatan_bulanan').html(data['jm_kegiatan_bulanan']);
					$('.st_capaian_kinerja_bulanan').html(data['capaian_kinerja_bulanan']);
					

				},
				error: function(data){
					
				}						
		});
	}

	
	$(document).on('click','.terima_capaian_bulanan',function(e){

		$('.modal-penilaian_kode_etik').modal('show');



		/* 
		Swal.fire({
				title: "Terima",
				text: "Pengajuan Capaian Bulanan",
				type: "question",
				showCancelButton: true,
				cancelButtonText: "Batal",
				confirmButtonText: "Terima",
				cancelButtonColor: "#7a7a7a",
				closeOnConfirm: false,
				showLoaderOnConfirm	: true,
		}).then ((result) => {
			if (result.value){
				$.ajax({
					url		: '{{ url("api_resource/terima_capaian_bulanan") }}',
					type	: 'POST',
					data    : { capaian_bulanan_id:{!! $capaian->id !!} },
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
										location.reload();

									},
									function (dismiss) {
										if (dismiss === 'timer') {
											
											
										}
									}
								)
								
							
					},
					error: function(e) {
						Swal.fire({
									title: "Gagal",
									text: "",
									type: "warning"
								}).then (function(){
										
								});

								const Toast = Swal.mixin({
								toast: true,
								position: 'top-end',
								showConfirmButton: false,
								timer: 3000
								});

								Toast.fire({
								type: 'success',
								title: 'Signed in successfully'
								}) 
							}
					});	
				

					
			}
		}); */
	});

	$(document).on('click','.tolak_capaian_bulanan',function(e){
		Swal.fire({
			title				: 'Tolak Capaian Bulaan',
			text				: 'Berikan alasan penolakan',
			input				: 'text',
			type				: "question",
			showCancelButton	: true,
			confirmButtonText	: 'Tolak',
			showLoaderOnConfirm	: true,
			inputAttributes: {
				autocapitalize: 'off'
			},

			inputValidator: (value) => {
				return !value && 'wajib mencantumkan alasan penolakan!'
			},
			allowOutsideClick: false
			}).then ((result) => {
			if (result.value){
				$.ajax({
					url		: '{{ url("api_resource/tolak_capaian_bulanan") }}',
					type	: 'POST',
					data    : { capaian_bulanan_id:{!! $capaian->id !!} ,
								alasan:result.value
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
										location.reload();

									},
									function (dismiss) {
										if (dismiss === 'timer') {
											
											
										}
									}
								)
								
							
					},
					error: function(e) {
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
