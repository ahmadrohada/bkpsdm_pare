
<div class="row">
	<div class="col-md-5">
		<div class="box box-primary">
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
					@if ( request()->segment(4) != 'edit' )
					<li class="list-group-item st_status_approve_div" style="padding:8px 10px;">
						Status Approve <a class="pull-right st_status_approve" >-</a>
					</li>
					@endif
					<li class="list-group-item st_alasan_penolakan_div hidden" style="padding:8px 10px;">
						Alasan Penolakan <a class="pull-right st_alasan_penolakan" >-</a>
					</li>
					<li class="list-group-item" style="padding:8px 10px;">
						I. Jumlah Kegiatan Tahunan <a class="pull-right st_jumlah_kegiatan_tahunan" >-</a>
					</li>
					<li class="list-group-item" style="padding:8px 10px;">
						II. Jumlah Tugas Tambahan <a class="pull-right st_jumlah_tugas_tambahan" >-</a>
					</li>
					<li class="list-group-item" style="padding:8px 10px; border-top: solid 1px #615e68 !important;">
						Jumlah Kegiatan SKP ( I + II) <a class="pull-right st_jumlah_kegiatan_skp" >-</a>
					</li>
					<li class="list-group-item" style="padding:8px 10px;">
						A. Nilai Capaian Kegiatan SKP + Tugas Tambahan
						<a class="pull-right st_capaian_kegiatan_skp" >-</a>
					</li>
					<li class="list-group-item" style="padding:8px 10px;">
						B. Nilai Unsur Penunjang
						<a class="pull-right st_nilai_unsur_penunjang" >-</a>
					</li>
		
					

					<li class="list-group-item" style="padding:8px 10px; border-top: solid 1px #615e68 !important; ">
						D. Capaian SKP<span class="text-muted"> (A+B)/n + C
						</span><a class="pull-right st_capaian_skp" >-</a>
					</li>

					<li class="list-group-item" style="padding:8px 10px; ">
						<input type="hidden" class="penilaian_kode_etik_id">
						D. Penilaian Perilaku Kerja
						<a class="btn btn-success btn-xs edit_penilaian_perilaku" style="margin-top:-1px;"><i class="fa fa-pencil" ></i></a>
						<a class="pull-right st_penilaian_perilaku_kerja" >-</a>
					</li>

					<li class="list-group-item" style="background:#efeff0; border-top: solid #615e68 !important; border-top-width: 2px; padding:8px 10px;">
						<strong>Nilai Prestasi Kerja</strong> 
						<span class="text-muted st_formula_perhitungan"> ( C x 60% ) + ( D x 40% )</span>
						<a class="pull-right st_nilai_prestasi_kerja" style="font-weight: bold;" >-</a>
					</li>
					
				</ul>
			</div>
		</div>
	</div> 
	<div class="col-md-7">
		<!-- Only show when detail or approvement -->
		@if ( ( request()->segment(4) != 'edit' )&( request()->segment(4) != 'ralat' ) )
			<div class="box box-primary">
				<div class="box-body no-padding">
					<h1 class="profile-username text-center text-success" style="font-size:16px;">
						Penilaian Perilaku Kerja
					</h1>
				<table class="table table-condensed">
						<tr>
							<td style="width: 8%; padding-left:10px;">NO</td>
							<td style="width: 45%">LABEL</td>
							<td style="text-align:center; width: 30%">NILAI</td>
							<td style="width: *%">KETERANGAN</td>
						</tr>
						<tr>
							<td style="padding-left:10px;">1.</td>
							<td>Orientasi Pelayanan</td>
							<td style="text-align:center;"><span class="nilai_orientasi_pelayanan">-</span></td>
							<td><span class="ket_orientasi_pelayanan">-</span></td>
							
						</tr>
						<tr>
							<td style="padding-left:10px;">2.</td>
							<td>Integritas</td>
							<td style="text-align:center;"><span class="nilai_integritas">-</span></td>
							<td><span class="ket_integritas">-</span></td>
						</tr>
						<tr>
							<td style="padding-left:10px;">3.</td>
							<td>Komitmen</td>
							<td style="text-align:center;"><span class="nilai_komitmen">-</span></td>
							<td><span class="ket_komitmen">-</span></td>
						</tr>
						<tr>
							<td style="padding-left:10px;">4.</td>
							<td>Disiplin</td>
							<td style="text-align:center;"><span class="nilai_disiplin">-</span></td>
							<td><span class="ket_disiplin">-</span></td>
						</tr>
						<tr>
							<td style="padding-left:10px;">5.</td>
							<td>Kerjasama</td>
							<td style="text-align:center;"><span class="nilai_kerjasama">-</span></td>
							<td><span class="ket_kerjasama">-</span></td>
						</tr>
						@if ( $capaian->PejabatYangDinilai->Jabatan->Eselon->id_jenis_jabatan  < 4 )
						<tr>
							<td style="padding-left:10px;">6.</td>
							<td>Kepemimpinan</td>
							<td style="text-align:center;"><span class="nilai_kepemimpinan">-</span></td>
							<td><span class="ket_kepemimpinan">-</span></td>
						</tr>
						@endif
						<tr class="">	
							<td></td>
							<td>Jumlah</td>
							<td style="text-align:center;"><span class="jumlah"></span></td>
							<td></td>
						</tr>
						<tr class='' style="background:#efeff0; border-top: solid #615e68 !important; border-top-width: 2px; padding:8px 10px;">	
							<td></td>
							<td>Penilaian Perilaku Kerja </td>
							<td style="text-align:center;"><span class="rata_rata"></span></td>
							<td><span class="ket_rata_rata"></span></td>
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
			<a href="#" class="btn btn-sm btn-danger tolak_capaian_tahunan">TOLAK</a>
			<a href="#" id="btn_terima" class="btn btn-sm btn-primary  penilaian_perilaku_kerja">TERIMA</a>
		@endif
	</div>
</div>


@include('pare_pns.modals.penilaian_perilaku_kerja')

<script type="text/javascript">

	
	
	function status_pengisian(){
		$.ajax({
				url			: '{{ url("api_resource/capaian_tahunan_status") }}',
				data 		: { capaian_tahunan_id : {!! $capaian->id !!} },
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					//$('.st_formula_hitung').html(data['tgl_dibuat']);
					$('.st_created_at').html(data['tgl_dibuat']);
					$('.st_pejabat_penilai').html(data['p_nama']);
					$('.st_status_approve').html(data['status_approve']);

					$('.st_jumlah_kegiatan_tahunan').html(data['jm_kegiatan_tahunan']);
					$('.st_jumlah_tugas_tambahan').html(data['jm_tugas_tambahan']);
					$('.st_jumlah_kegiatan_skp').html(data['jm_kegiatan_skp']); // keg tahunan + tugas Tambahan

					$('.st_capaian_kegiatan_skp').html(data['jm_capaian_kegiatan_tahunan']+' + '+data['jm_capaian_tugas_tambahan']);
					

					$('.st_capaian_skp').html(data['capaian_kinerja_tahunan']);

					$('.st_penilaian_perilaku_kerja').html(data['penilaian_perilaku_kerja']);
					$('.st_nilai_prestasi_kerja').html(data['nilai_prestasi_kerja']);
					
					
					if (data['penilaian_perilaku_kerja'] >= 1 ){
						$('#btn_terima').removeClass('penilaian_perilaku_kerja');
						$('#btn_terima').addClass('terima_capaian_tahunan');
					}
					
				},
				error: function(data){
					
				}						
		});



		$.ajax({
			url			: '{{ url("api_resource/penilaian_perilaku_kerja") }}',
			data 		: {capaian_tahunan_id : {{ $capaian->id}} },
			method		: "GET",
			dataType	: "json",
			success	: function(data) {

					$('.nilai_orientasi_pelayanan').html(data['pelayanan']);
					$('.nilai_integritas').html(data['integritas']);
					$('.nilai_komitmen').html(data['komitmen']);
					$('.nilai_disiplin').html(data['disiplin']);
					$('.nilai_kerjasama').html(data['kerjasama']);
					$('.nilai_kepemimpinan').html(data['kepemimpinan']); 

					$('.ket_orientasi_pelayanan').html(data['ket_pelayanan']);
					$('.ket_integritas').html(data['ket_integritas']);
					$('.ket_komitmen').html(data['ket_komitmen']);
					$('.ket_disiplin').html(data['ket_disiplin']);
					$('.ket_kerjasama').html(data['ket_kerjasama']);
					$('.ket_kepemimpinan').html(data['ket_kepemimpinan']); 

					$('.jumlah').html(data['jumlah']); 
					$('.rata_rata').html(data['rata_rata']); 

					$('.ket_rata_rata').html(data['ket_rata_rata']);
					

				},
				error: function(data){
					
				}						
		});	 




	}

	$(document).on('click','.terima_capaian_tahunan',function(e){
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
					url		: '{{ url("api_resource/terima_capaian_tahunan") }}',
					type	: 'POST',
					data    : { capaian_tahunan_id:{!! $capaian->id !!}
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
