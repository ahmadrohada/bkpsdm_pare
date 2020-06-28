
<div class="row">
	<div class="col-md-5">
		<div class="box box-info">
			<div class="box-body box-profile">
			
				<h1 class="profile-username text-center text-success" style="font-size:16px;">
					Capaian SKP Periode {!! Pustaka::tahun($capaian->tgl_mulai) !!}
				</h1>

				<ul class="list-group list-group-unbordered">
					<li class="list-group-item " style="padding:8px 10px;">
						Tanggal dibuat<a class="pull-right st_created_at">-</a>
					</li>
					<li class="list-group-item" style="padding:8px 10px;">
						Pejabat Penilai <a class="pull-right st_pejabat_penilai">-</a>
					</li>
					<li class="list-group-item" style="padding:8px 10px;">
						Jumlah Kegiatan SKP <a class="pull-right st_jm_kegiatan_bulanan" >-</a>
					</li>
					<li class="list-group-item" style="padding:8px 10px;">
						Jumlah Tugas Tambahan <a class="pull-right st_jm_uraian_tugas_tambahan" >-</a>
					</li>
					@if ( request()->segment(4) != 'edit' )
					<li class="list-group-item st_status_approve_div" style="padding:8px 10px;">
						Status Approve <a class="pull-right st_status_approve" >-</a>
					</li>
					@endif
					<li class="list-group-item st_alasan_penolakan_div hidden" style="padding:8px 10px;">
						Alasan Penolakan <a class="pull-right st_alasan_penolakan" >-</a>
					</li>
					<li class="list-group-item" style="padding:8px 10px;">
						Capaian Kinerja Bulanan <span class="text-muted"> (bobot 70%)</span><a class="pull-right st_capaian_kinerja_bulanan" >-</a>
					</li>
					<li class="list-group-item" style="padding:8px 10px;">
						<input type="hidden" class="penilaian_kode_etik_id">
						Penilaian Kode Etik <span class="text-muted"> (bobot 30%)</span>
						<a class="pull-right st_penilaian_kode_etik" >-</a>
					</li>
					@if ( request()->segment(4) != 'edit' )
					<li class="list-group-item" style="background:#efeff0; border-top: solid #615e68 !important; border-top-width: 2px; padding:8px 10px;">
						<strong>Capaian SKP Tahunan</strong> <a class="pull-right st_capaian_skp_bulanan" style="font-weight: bold;" >-</a>
					</li>
					@endif
					
				</ul>
				<a href="#" class="btn btn-primary btn-block kirim_capaian "><b>Kirim ke Atasan <i class="send_icon"></i></b></a>
				


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


	function status_show(){
		status_pengisian();	
	}

	function status_pengisian(){
		$.ajax({
				url			: '{{ url("api_resource/capaian_tahunan_status") }}',
				data 		: { capaian_tahunan_id : {!! $capaian->id !!} },
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					

					$('.st_created_at').html(data['tgl_dibuat']);
					$('.st_pejabat_penilai').html(data['p_nama']);
					$('.st_jm_kegiatan_tahunan').html(data['jm_kegiatan_tahunan']);
					$('.st_capaian_kinerja_tahunan').html(data['capaian_kinerja_tahunan']);
					$('.st_status_approve').html(data['status_approve']);
					$('.st_alasan_penolakan').html(data['alasan_penolakan']);


					if ( data['send_to_atasan'] == 1 ){
						$('.kirim_capaian').hide();
						$('.st_status_approve_div').removeClass('hidden');
					} 

					if ( data['alasan_penolakan'] != ""){
						
						$('.st_alasan_penolakan_div').removeClass('hidden');
					} 
					
					

				},
				error: function(data){
					
				}						
		});
	}

	function on_kirim(){
		$('.send_icon').addClass('fa fa-spinner faa-spin animated');
		$('.kirim_capaian').prop('disabled',true);
	}
	function reset_kirim(){
		$('.send_icon').removeClass('fa fa-spinner faa-spin animated');
		$('.send_icon').addClass('fa fa-send');
		$('.kirim_capaian').prop('disabled',false);
	}

	$(document).on('click','.kirim_capaian',function(e){
		Swal.fire({
				title: "Kirim Capaian",
				text: "Capaian Tahunan akan dikirim ke atasan untuk, edit pada capaian tidak bisa dilakukan",
				type: "question",
				showCancelButton: true,
				cancelButtonText: "Batal",
				confirmButtonText: "Kirim Capaian",
				confirmButtonClass: "btn btn-success",
				cancelButtonClass: "btn btn-danger",
				cancelButtonColor: "#d33",
				closeOnConfirm: false
		}).then ((result) => {
			if (result.value){
				on_kirim();
				$.ajax({
					url		: '{{ url("api_resource/kirim_capaian_tahunan") }}',
					type	: 'POST',
					data    : { capaian_tahunan_id : {!! $capaian->id !!} },
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
