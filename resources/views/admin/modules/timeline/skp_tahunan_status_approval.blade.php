
<div class="row">
	<div class="col-md-4">
		<div class="box box-default">
			<div class="box-body box-profile">
			
				<h3 class="profile-username text-center">SKP TAHUNAN</h3>
				<p class="text-muted text-center">{{ $skp->Renja->Periode->label}}</p>

				<ul class="list-group list-group-unbordered">
					<li class="list-group-item">
						<b>Create</b> <a class="pull-right st_created_at">-</a>
					</li>
					<li class="list-group-item">
						<b>Data Pejabat Penilai</b> <a class="pull-right st_pejabat_penilai">-</a>
					</li>
					<li class="list-group-item">
						<b>Data Kegiatan Tahunan</b> <a class="pull-right st_kegiatan_tahunan" >-</a>
					</li>
					<li class="list-group-item">
						<b>Data Rencana Aksi</b> <a class="pull-right st_rencana_aksi">-</a>
					</li>
					<li class="list-group-item" >
						<b>Persetujuan Atasan</b> <a class="pull-right st_persetujuan_atasan">-</a>
					</li>
				</ul>
				<div class="approval_skp_tahunan"> 
					<div class="col-md-6" style="padding:2px 2px 2px 0;">
						<button class="btn btn-primary btn-block setuju_skp_tahunan ">Setuju</button>
					</div>
					<div class="col-md-6" style="padding:2px 0px 2px 2px;">
						<button class="btn btn-danger btn-block tolak_skp_tahunan ">Tolak</button>
					</div>
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









	 
<link rel="stylesheet" href="https://cdn.jsdelivr.net/animatecss/3.5.2/animate.min.css" />
<link rel="stylesheet" href="{{asset('assets/timeline/style-albe-timeline.css')}}" />

<script src="{{asset('assets/timeline/jquery-albe-timeline.js')}}"></script>

<script type="text/javascript">


	function status_show(){
		$.ajax({
				url			: '{{ url("api_resource/skp_tahunan_timeline_status") }}',
				data 		: { skp_tahunan_id : {!! $skp->id!!},
								jabatan_id : {!! $skp->PejabatYangDinilai->id_jabatan !!},
								renja_id : {!! $skp->Renja->id !!}
								},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					status(data);	
					status_pengisian();	
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
				url			: '{{ url("api_resource/skp_tahunan_status_pengisian3") }}',
				data 		: { skp_tahunan_id : {!! $skp->id!!},
								jabatan_id : {!! $skp->PejabatYangDinilai->id_jabatan !!},
								renja_id : {!! $skp->Renja->id !!} 
								},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					//alert(data);
					if ( data['persetujuan_atasan'] != 'ok' ){
						$('.tarik_skp_tahunan_div').show();
					}else{
						$('.tarik_skp_tahunan_div').hide();
					} 

					$('.st_created_at').html(data['created']);
					$('.st_pejabat_penilai').html(data['data_pejabat_penilai']);
					$('.st_kegiatan_tahunan').html(data['data_kegiatan_tahunan']);
					$('.st_rencana_aksi').html(data['data_rencana_aksi']);
					$('.st_persetujuan_atasan').html(data['persetujuan_atasan']);


				},
				error: function(data){
					
				}						
		});
	}



	$(document).on('click','.setuju_skp_tahunan',function(e){
		Swal.fire({
				title: "Setuju",
				text: "Pengajuan  SKP Tahunan",
				type: "question",
				showCancelButton: true,
				cancelButtonText: "Batal",
				confirmButtonText: "Setuju",
				cancelButtonColor: "#7a7a7a",
				closeOnConfirm: false,
				showLoaderOnConfirm	: true,
		}).then ((result) => {
			if (result.value){
				$.ajax({
					url		: '{{ url("api_resource/skp_tahunan_setuju_by_atasan") }}',
					type	: 'POST',
					data    : { skp_tahunan_id: {!! $skp->id !!} ,
								atasan_id: {!! $pegawai->JabatanAktif->id !!}
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

								/* const Toast = Swal.mixin({
								toast: true,
								position: 'top-end',
								showConfirmButton: false,
								timer: 3000
								});

								Toast.fire({
								type: 'success',
								title: 'Signed in successfully'
								}) */
							}
					});	
				

					
			}
		});
	});


	$(document).on('click','.tolak_skp_tahunan',function(e){
		Swal.fire({
			title				: 'Tolak SKP Tahunan',
			text				:'Berikan alasan penolakan',
			input				: 'text',
			type				: "question",
			showCancelButton	: true,
			confirmButtonText	: 'Tolak',
			showLoaderOnConfirm	: true,
			inputAttributes: {
				autocapitalize: 'off'
			},

			inputValidator: (value) => {
				return !value && 'You need to write something!'
			},
			allowOutsideClick: false
			}).then ((result) => {
			if (result.value){
				$.ajax({
					url		: '{{ url("api_resource/skp_tahunan_tolak_by_atasan") }}',
					type	: 'POST',
					data    : { skp_tahunan_id: {!! $skp->id !!} ,
								atasan_id: {!! $pegawai->JabatanAktif->id !!},
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
