
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
					<!-- <li class="list-group-item hidden" >
						<b>Persetujuan Atasan</b> <a class="pull-right st_persetujuan_atasan">-</a>
					</li> -->
					<!-- <li class="list-group-item " >
						<b>Status</b> <a class="pull-right">Open</a>
					</li> -->
				</ul>

				<!-- <button class="btn btn-primary btn-block close_skp_tahunan " disabled><i class="send_icon fa fa-lock"></i> Close SKP Tahunan</button>
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

 

	 
<link rel="stylesheet" href="{{asset('assets/timeline/animate.min.css')}}" />
<link rel="stylesheet" href="{{asset('assets/timeline/style-albe-timeline.css')}}" />

<script src="{{asset('assets/timeline/jquery-albe-timeline.js')}}"></script>

<script type="text/javascript">


	function status_show(){
		$.ajax({
				url			: '{{ url("api/skp_tahunan_general_timeline") }}',
				data 		: { 
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
				url			: '{{ url("api/skp_tahunan_status_pengisian3") }}',
				data 		: { skp_tahunan_id : {!! $skp->id!!},
								jabatan_id : {!! $skp->PegawaiYangDinilai->id_jabatan !!},
								renja_id : {!! $skp->Renja->id !!} 
								},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					//alert(data);
					if (data['button_kirim'] == 1 ){
						$('.close_skp_tahunan').removeAttr('disabled');
					}else{
						$('.close_skp_tahunan').attr('disabled','disabled');
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

	function on_kirim(){
		$('.send_icon').addClass('fa fa-spinner faa-spin animated');
		$('.close_skp_tahunan').prop('disabled',true);
	}
	function reset_kirim(){
		$('.send_icon').removeClass('fa fa-spinner faa-spin animated');
		$('.send_icon').addClass('fa fa-send');
		$('.close_skp_tahunan').prop('disabled',false);
	}

	$(document).on('click','.close_skp_tahunan',function(e){
		Swal.fire({
				title: "Tutup SKP Tahunan",
				text: "SKP Tahunan akan ditutup, edit pada skp tidak bisa dilakukan",
				type: "question",
				showCancelButton: true,
				cancelButtonText: "Batal",
				confirmButtonText: "Close SKP",
				confirmButtonClass: "btn btn-success",
				cancelButtonClass: "btn btn-danger",
				cancelButtonColor: "#d33",
				closeOnConfirm: false
		}).then ((result) => {
			if (result.value){
				on_kirim();
				$.ajax({
					url		: '{{ url("api/skp_tahunan_close") }}',
					type	: 'POST',
					data    : {skp_tahunan_id: {!! $skp->id !!} },
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
