
<div class="row">
	<div class="col-md-5">
		<div class="box box-primary">
			<div class="box-body box-profile">
			
				<h1 class="profile-username text-center text-success" style="font-size:16px;">
					Capaian SKP Periode {!! Pustaka::bulan($capaian->SKPBulanan->bulan) !!} {!! Pustaka::tahun($capaian->tgl_mulai) !!}
				</h1>

				<ul class="list-group list-group-unbordered">
					<li class="list-group-item " style="padding:8px 10px;">
						Tanggal dibuat<a class="pull-right st_created_at">-</a>
					</li>
					<li class="list-group-item" style="padding:8px 10px;">
						Pejabat Penilai <a class="pull-right st_pejabat_penilai">-</a>
					</li>
					@if ( request()->segment(4) != 'edit' )
					<li class="list-group-item st_status_approve_div" style="padding:8px 10px;">
						Status Approve <a class="pull-right st_status_approve" >-</a>
					</li>
					@endif
					<li class="list-group-item" style="padding:8px 10px; border-top: solid 1px #615e68 !important;">
						Jumlah Kegiatan SKP <a class="pull-right st_jm_kegiatan_bulanan" >-</a>
					</li>
					<li class="list-group-item" style="padding:8px 10px;">
						Jumlah Uraian Tugas Tambahan <a class="pull-right st_jm_uraian_tugas_tambahan" >-</a>
					</li>
					
					
					
					<li class="list-group-item st_alasan_penolakan_div hidden" style="padding:8px 10px;">
						Alasan Penolakan <a class="pull-right st_alasan_penolakan" >-</a>
					</li>

					<li class="list-group-item" style="padding:8px 10px; border-top: solid 1px #615e68 !important;">
						Capaian Kinerja Bulanan <span class="text-muted"> (bobot 70%)</span><a class="pull-right st_capaian_kinerja_bulanan" >-</a>
					</li>

					<li class="list-group-item" style="padding:8px 10px;" >
						<input type="hidden" class="penilaian_kode_etik_id">
						Penilaian Kode Etik <span class="text-muted"> (bobot 30%)</span>
						<?php if ( $capaian->status_approve == 0 ) { ?>
							<a id="edit_pke" class="btn btn-success btn-xs edit_penilaian_kode_etik" ><i class="fa fa-pencil" ></i></a>
						<?php } ?>
						
						<a class="pull-right st_penilaian_kode_etik" >-</a>
					</li>

					@if ( request()->segment(4) != 'edit' )
					<li class="list-group-item" style="background:#efeff0; border-top: solid #615e68 !important; border-top-width: 2px; padding:8px 10px;">
						<strong>Capaian SKP Bulanan</strong> <a class="pull-right st_capaian_skp_bulanan" style="font-weight: bold;" >-</a>
					</li>
					@endif
				</ul>
			</div>
		</div>
	</div> 
	<div class="col-md-7">
		@if ( ( request()->segment(4) != 'edit' )&( request()->segment(4) != 'ralat' ) )
			<div class="box box-primary">
				<div class="box-body no-padding">
					<h1 class="profile-username text-center text-success" style="font-size:16px;">
						Penilaian Kode Etik
					</h1>
					<table class="table table-condensed">
						<tr>
							<td style="width: 8%; padding-left:10px;">NO</td>
							<td style="width: *%">LABEL</td>
							<td style="text-align:center; width: 20%">NILAI</td>
						</tr>
						<tr>
						<td style="padding-left:10px;">1.</td>
						<td>Santun</td>
						<td style="text-align:center;"><span class="text-info txt_santun">0 %</span></td>
						</tr>
						<tr>
						<td style="padding-left:10px;">2.</td>
						<td>Amanah</td>
						<td style="text-align:center;"><span class="text-info txt_amanah">0 %</span></td>
						</tr>
						<tr>
						<td style="padding-left:10px;">3.</td>
						<td>Harmonis</td>
						<td style="text-align:center;"><span class="text-info txt_harmonis">0 %</span></td>
						</tr>
						<tr>
						<td style="padding-left:10px;">4.</td>
						<td>Adaptif</td>
						<td style="text-align:center;"><span class="text-info txt_adaptif">0 %</span></td>
						</tr>
						<tr>
						<td style="padding-left:10px;">5.</td>
						<td>Terbuka</td>
						<td style="text-align:center;"><span class="text-info txt_terbuka">0 %</span></td>
						</tr>
						<tr>
						<td style="padding-left:10px;">6.</td>
						<td>Efektif</td>
						<td style="text-align:center;"><span class="text-info txt_efektif">0 %</span></td>
						</tr>
					</table>
				</div>
			</div>
		@endif
	</div>
</div>
<div class="row">
	<div class="col-md-4 col-xs-12">
		@if ( $capaian->status_approve == 0 )
			
				<a href="#" class="btn  btn-sm btn-danger tolak_capaian_bulanan">TOLAK</a>
				<a href="#" id="btn_terima" class="btn  btn-sm btn-primary  penilaian_kode_etik">TERIMA</a>
			
		@endif
	</div>
</div>

@include('pare_pns.modals.penilaian_kode_etik')

<script type="text/javascript">


	function status_show(){
		status_pengisian();	
	}

	function status_pengisian(){
		$.ajax({
				url			: '{{ url("api/capaian_bulanan_status_pengisian") }}',
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
					$('.st_pejabat_penilai').html(data['p_nama']);
					$('.st_jm_kegiatan_bulanan').html(data['jm_kegiatan_bulanan']);
					$('.st_jm_uraian_tugas_tambahan').html(data['jm_uraian_tugas_tambahan']);
					$('.st_capaian_kinerja_bulanan').html(data['capaian_kinerja_bulanan']);
					$('.st_status_approve').html(data['status_approve']);
					$('.st_alasan_penolakan').html(data['alasan_penolakan']);

					$('.st_penilaian_kode_etik').html(data['penilaian_kode_etik']);
					$('.st_capaian_skp_bulanan').html(data['capaian_skp_bulanan']);

					if (data['penilaian_kode_etik_id'] >= 1 ){
						$('#btn_terima').removeClass('penilaian_kode_etik');
						$('#btn_terima').addClass('terima_capaian_bulanan');
						$('.penilaian_kode_etik_id').val(data['penilaian_kode_etik_id']);

						$('#edit_pke').addClass('edit_penilaian_kode_etik');
						$('#edit_pke').removeClass('penilaian_kode_etik');
						
					}else{
						$('#edit_pke').removeClass('edit_penilaian_kode_etik');
						$('#edit_pke').addClass('penilaian_kode_etik');
						
					}

					$('.txt_santun').html(data['santun']+' %');
					$('.txt_amanah').html(data['amanah']+' %');
					$('.txt_harmonis').html(data['harmonis']+' %');
					$('.txt_adaptif').html(data['adaptif']+' %');
					$('.txt_terbuka').html(data['terbuka']+' %');
					$('.txt_efektif').html(data['efektif']+' %');

					

				},
				error: function(data){
					
				}						
		});
	}

	
	$(document).on('click','.penilaian_kode_etik',function(e){

		$('.santun,.amanah,.harmonis,.adaptif,.terbuka,.efektif').rating('update',1);
		$('.modal-penilaian_kode_etik').find('[name=capaian_bulanan_id]').val({!! $capaian->id !!});
		$('.modal-penilaian_kode_etik').find('[name=text_button_submit]').html('Simpan Data');
		$('.modal-penilaian_kode_etik').modal('show');

	});

	$(document).on('click','.edit_penilaian_kode_etik',function(e){
		show_loader();
		var id = $('.penilaian_kode_etik_id').val();
		$.ajax({
			url			: '{{ url("api/detail_penilaian_kode_etik") }}',
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
					$('.modal-penilaian_kode_etik').find('[name=text_button_submit]').html('Update Data');
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
					url		: '{{ url("api/tolak_capaian_bulanan") }}',
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


	
	$(document).on('click','.terima_capaian_bulanan',function(e){
		Swal.fire({
				title: "Terima",
				text: "Anda akan menerima dan menyetujui Laporan Capaian Bulanan",
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
					url		: '{{ url("api/terima_capaian_bulanan") }}',
					type	: 'POST',
					data    : { capaian_bulanan_id:{!! $capaian->id !!}
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
</script>
