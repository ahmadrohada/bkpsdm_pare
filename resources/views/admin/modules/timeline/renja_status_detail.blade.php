
<div class="row">
	<div class="col-md-4">
		<div class="box box-default">
			<div class="box-body box-profile">
			
				<!-- <h3 class="profile-username text-center">RENCANA KERJA</h3>
				<p class="text-muted text-center"></p> -->

				<ul class="list-group list-group-unbordered">
					<li class="list-group-item">
						<b>Create</b> <a class="pull-right st_created_at">-</a>
					</li>
					<li class="list-group-item">
						<b>Data Kepala SKPD</b> <a class="pull-right st_kepala_skpd">-</a>
					</li>
					<li class="list-group-item" >
						<b>Persetujuan Kepala SKPD</b> <a class="pull-right st_persetujuan_kaban">-</a>
					</li>
				</ul>

			
				<div class="batalkan_renja" hidden>
					<button class="btn btn-warning btn-block batalkan_renja ">Batalkan Permintaan Persetujuan</button>
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
				url			: '{{ url("api_resource/renja_timeline_status") }}',
				data 		: {renja_id : {!! $renja->id!!} },
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
				effect: '',
				showGroup: false,
				language : 'en-us',
				sortDesc : true,
				formatDate: 'dd de MMMM de yyyy HH:mm'
		});	
	}


	function status_pengisian(){
		$.ajax({
				url			: '{{ url("api_resource/renja_status_pengisian") }}',
				data 		: {renja_id: {!! $renja->id !!} },
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					//alert(data);
					if ( (data['data_persetujuan_kaban'] == 'ok' ) | (data['administrator'] == true) ){
						$('.batalkan_renja').hide();
					}else{
						$('.batalkan_renja').show();
					}



					$('.st_created_at').html(data['created']);
					$('.st_kepala_skpd').html(data['data_kepala_skpd']);
					$('.st_persetujuan_kaban').html(data['data_persetujuan_kaban']);

				},
				error: function(data){
					
				}						
		});
	}



	$(document).on('click','.batalkan_renja',function(e){
		Swal.fire({
				title: "Batalkan Permintaan Persetujuan",
				text: "Pohon Kinerja akan dibatalkan permintaan persetujuannya",
				type: "question",
				showCancelButton: true,
				cancelButtonText: "Tidak",
				confirmButtonText: "Ya",
				confirmButtonClass: "btn btn-success",
				cancelButtonClass: "btn btn-danger",
				cancelButtonColor: "#d33",
				closeOnConfirm: false
		}).then ((result) => {
			if (result.value){
				$.ajax({
					url		: '{{ url("api_resource/renja_pull_from_kaban") }}',
					type	: 'POST',
					data    : {renja_id: {!! $renja->id !!} },
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


