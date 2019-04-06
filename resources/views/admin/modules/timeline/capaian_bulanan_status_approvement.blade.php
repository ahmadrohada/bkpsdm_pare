
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
						Capaian Kinerja Bulanan <span class="text-muted"> (bobot 70%)</span><a class="pull-right st_capaian_kinerja_bulanan" >-</a>
					</li>

					<li class="list-group-item st_pke hidden" >
						<input type="hidden" class="penilaian_kode_etik_id">
						Penilaian Kode Etik <span class="text-muted"> (bobot 30%)</span>
						<a class="btn btn-success btn-xs edit_penilaian_kode_etik" ><i class="fa fa-pencil" ></i></a>
						<a class="pull-right st_penilaian_kode_etik" >-</a>
					</li>

					<li class="list-group-item st_pke hidden" >
						<strong>Capaian SKP Bulanan</strong> <a class="pull-right st_capaian_skp_bulanan" >-</a>
					</li>

					
					
				</ul>

				
				
				<div class="pull-right">
					<a href="#" class="btn btn-sm btn-danger tolak_capaian_bulanan">TOLAK</a>
					<a href="#" id="btn_terima" class="btn btn-sm btn-primary  penilaian_kode_etik">TERIMA</a>
				</div>

			</div>
			
		</div>
	</div>
	<div class="col-md-8">
		
	</div>


</div>

@include('admin.modals.penilaian_kode_etik')

<script type="text/javascript">


	function status_show(){
		status_pengisian();	
	}

	function status_pengisian(){
		$.ajax({
				url			: '{{ url("api_resource/capaian_bulanan_status_pengisian") }}',
				data 		: { capaian_bulanan_id : {!! $capaian->id !!} },
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					
					if (data['button_kirim'] == 1 ){
						$('.close_capaian_bulanan').removeAttr('disabled');
					}else{
						$('.close_capaian_bulanan').attr('disabled','disabled');
					}

					$('.st_created_at').html(data['tgl_dibuat']);
					$('.st_pejabat').html(data['u_nama']);
					$('.st_jm_kegiatan_bulanan').html(data['jm_kegiatan_bulanan']);
					$('.st_capaian_kinerja_bulanan').html(data['capaian_kinerja_bulanan']);
					$('.st_penilaian_kode_etik').html(data['penilaian_kode_etik']);
					$('.st_capaian_skp_bulanan').html(data['capaian_skp_bulanan']);
					

					if (data['penilaian_kode_etik_id'] >= 1 ){
						$('.st_pke').removeClass('hidden');
						$('#btn_terima').removeClass('penilaian_kode_etik');
						$('#btn_terima').addClass('terima_capaian_bulanan');
						$('.penilaian_kode_etik_id').val(data['penilaian_kode_etik_id']);
						
					}


					

				},
				error: function(data){
					
				}						
		});
	}

	
	$(document).on('click','.penilaian_kode_etik',function(e){

		$('.santun,.amanah,.harmonis,.adaptif,.terbuka,.efektif').rating('update',1);

		$('.modal-penilaian_kode_etik').find('[name=capaian_bulanan_id]').val({!! $capaian->id !!});
		$('.modal-penilaian_kode_etik').modal('show');

	});

	$(document).on('click','.edit_penilaian_kode_etik',function(e){
		var id = $('.penilaian_kode_etik_id').val();
		$.ajax({
			url			: '{{ url("api_resource/detail_penilaian_kode_etik") }}',
			data 		: {penilaian_kode_etik_id : id},
			method		: "GET",
			dataType	: "json",
			success	: function(data) {

					$('.modal-penilaian_kode_etik').find('[name=capaian_bulanan_id]').val({!! $capaian->id !!});
					
					$('.santun').rating('update',data['santun']);
					$('.amanah').rating('update',data['amanah']);
					$('.harmonis').rating('update',data['harmonis']);
					$('.adaptif').rating('update',data['adaptif']);
					$('.terbuka').rating('update',data['terbuka']);
					$('.efektif').rating('update',data['efektif']);
				
					
					$('.modal-penilaian_kode_etik').find('h4').html('Edit Penilaian Kode Etik');
					$('.modal-penilaian_kode_etik').find('.btn-submit').attr('id', 'submit-update');
					$('.modal-penilaian_kode_etik').modal('show');

				},
				error: function(data){
					
				}						
		});	
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
