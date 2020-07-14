<div class="row badge_persetujuan" hidden>
	<div class="col-md-12">
		<div class="alert alert-danger bg-maroon alert-dismissible">
			<h4><i class="icon fa fa-info"></i> Status Capaian Tahunan</h4>
			Menunggu Persetujuan Dari Atasan
		</div>
	</div>
</div>

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

					@if ( request()->segment(4) != 'edit' )
					<li class="list-group-item" style="padding:8px 10px; ">
						D. Penilaian Perilaku Kerja
						<a class="pull-right st_penilaian_perilaku_kerja" >-</a>
					</li>

					<li class="list-group-item" style="background:#efeff0; border-top: solid #615e68 !important; border-top-width: 2px; padding:8px 10px;">
						<strong>Nilai Prestasi Kerja</strong> 
						<span class="text-muted st_formula_perhitungan"> ( C x 60% ) + ( D x 40% )</span>
						<a class="pull-right st_nilai_prestasi_kerja" style="font-weight: bold;" >-</a>
					</li>
					@endif
					
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
					<table class="table  table-condensed">
						<tr>
							<td style="width: 8%; padding-left:10px;">NO</td>
							<td style="width: 45%">LABEL</td>
							<td style="text-align:center; width: 30%">NILAI</td>
							<td style="width: *%">KETERANGAN</td>
						</tr>
						<tr>
							<td style="padding-left:10px;">1.</td>
							<td>Orientasi Pelayanan</td>
							<td style="text-align:center;"><span class="text-info  nilai_orientasi_pelayanan">-</span></td>
							<td style="text-align:center;"><span class="text-info ket_orientasi_pelayanan">-</span></td>
							
						</tr>
						<tr>
							<td style="padding-left:10px;">2.</td>
							<td>Integritas</td>
							<td style="text-align:center;"><span class="text-info nilai_integritas">-</span></td>
							<td style="text-align:center;"><span class="text-info ket_integritas">-</span></td>
						</tr>
						<tr>
							<td style="padding-left:10px;">3.</td>
							<td>Komitmen</td>
							<td style="text-align:center;"><span class="text-info nilai_komitmen">-</span></td>
							<td style="text-align:center;"><span class="text-info ket_komitmen">-</span></td>
						</tr>
						<tr>
							<td style="padding-left:10px;">4.</td>
							<td>Disiplin</td>
							<td style="text-align:center;"><span class="text-info nilai_disiplin">-</span></td>
							<td style="text-align:center;"><span class="text-info ket_disiplin">-</span></td>
						</tr>
						<tr>
							<td style="padding-left:10px;">5.</td>
							<td>Kerjasama</td>
							<td style="text-align:center;"><span class="text-info nilai_kerjasama">-</span></td>
							<td style="text-align:center;"><span class="text-info ket_kerjasama">-</span></td>
						</tr>
						@if ( $capaian->PejabatYangDinilai->Jabatan->Eselon->id_jenis_jabatan  < 4 )
						<tr>
							<td style="padding-left:10px;">6.</td>
							<td>Kepemimpinan</td>
							<td style="text-align:center;"><span class="text-info nilai_kepemimpinan">-</span></td>
							<td style="text-align:center;"><span class="text-info ket_kepemimpinan">-</span></td>
						</tr>
						@endif
						<tr class="" style="">	
							<td></td>
							<td>Jumlah</td>
							<td style="text-align:center;"><span class="text-info jumlah" style="font-weight: bold;"></span></td>
							<td></td>
						</tr>
						<tr class='' style="background:#efeff0; border-top: solid #615e68 !important; border-top-width: 2px; padding:8px 10px;">	
							<td></td>
							<td>Penilaian Perilaku Kerja </td>
							<td style="text-align:center;"><span class="text-info rata_rata" style="font-weight: bold;"></span></td>
							<td style="text-align:center;"><span class="text-info ket_rata_rata" style="font-weight: bold;"></span></td>
						</tr>



					</table>
				</div> 
			</div>
		@endif
	</div>
</div>

@if ( ( request()->segment(4) == 'edit' )|( request()->segment(4) == 'ralat' ) )
	<?php

		$xd = request()->segment(4); 
		$attr_name = ( $xd == 'ralat') ? ' kembali ' : '' ;
	?>
	<div class="row">
		<div class="col-md-12 col-xs-12">
			<a href="#" class="btn btn-primary btn-block kirim_capaian "><b>Kirim {{$attr_name}} ke Atasan <i class="send_icon"></i></b></a>
		</div>
	</div>
@endif


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
					
					if ( data['status_approve'] == "Menunggu Persetujuan"){
						$('.badge_persetujuan').show(500);
					}

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
