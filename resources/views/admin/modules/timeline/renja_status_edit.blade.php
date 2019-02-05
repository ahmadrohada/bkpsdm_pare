
<div class="row">
	<div class="col-md-4">
		<div class="box box-default">
			<div class="box-body box-profile">
			
				<h3 class="profile-username text-center">RENCANA KERJA</h3>
				<p class="text-muted text-center"></p>

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
				<div class="kirim_renja">
					<button class="btn btn-primary btn-block kirim_renja " disabled>Kirim kepada Kepala SKPD</button>
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
				data 		: { skp_tahunan_id : 2,
								jabatan_id : 2,
								renja_id : 2 
								},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					//alert(data);
					if (data['button_kirim'] == 1 ){
						$('.kirim_skp_tahunan').removeAttr('disabled');
					}else{
						$('.kirim_skp_tahunan').attr('disabled','disabled');
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


</script>


