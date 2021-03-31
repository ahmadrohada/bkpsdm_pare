
<div class="row">
	
	<div class="col-md-7">

					<div class="panel-default ">
						<i class="fa fa-bar-chart-o"></i>
						<span class="text-primary"> PENILAIAN PERILAKU KERJA</span>
					</div>

					<table class="table  table-condensed" style="margin-top:20px;">
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
						<?php
							$id_jenis_jabatan = ($capaian->PegawaiYangDinilai->Jabatan->Eselon)?$capaian->PegawaiYangDinilai->Jabatan->Eselon->id_jenis_jabatan:4;
						?>
						@if ( $id_jenis_jabatan  < 4 )
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
					@if ( request()->segment(2) === "capaian_tahunan_bawahan_approvement" )
						<a class="btn btn-success  btn-block edit_penilaian_perilaku" style="margin-top:-1px;"><i class="fa fa-pencil" ></i> Berikan Penilaian</a>
					@endif
	</div>
</div>

@include('pare_pns.modals.penilaian_perilaku_kerja')


<script type="text/javascript">


	function penilaian_perilaku_kerja_show(){
		
		$.ajax({
			url			: '{{ url("api/penilaian_perilaku_kerja") }}',
			data 		: {capaian_tahunan_id : {{ $capaian->id}} },
			method		: "GET",
			dataType	: "json",
			cache		: true,
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

	$(document).on('click','.edit_penilaian_perilaku',function(e){
		$.ajax({
			url			: '{{ url("api/detail_penilaian_perilaku_kerja") }}',
			data 		: {capaian_tahunan_id : {{ $capaian->id}} },
			method		: "GET",
			dataType	: "json",
			success	: function(data) {

					$('.modal-penilaian_perilaku_kerja').find('[name=capaian_tahunan_id]').val({!! $capaian->id !!});
					$('.modal-penilaian_perilaku_kerja').find('[name=perilaku_kerja_id]').val(data['id']);
					
					$('.pelayanan_01').rating('update',data['pelayanan_01']);
					$('.pelayanan_02').rating('update',data['pelayanan_02']);
					$('.pelayanan_03').rating('update',data['pelayanan_03']);
					 
					$('.integritas_01').rating('update',data['integritas_01']);
					$('.integritas_02').rating('update',data['integritas_02']);
					$('.integritas_03').rating('update',data['integritas_03']);
					$('.integritas_04').rating('update',data['integritas_04']);
					
					
					$('.komitmen_01').rating('update',data['komitmen_01']);
					$('.komitmen_02').rating('update',data['komitmen_02']);
					$('.komitmen_03').rating('update',data['komitmen_03']);
					
					
					$('.disiplin_01').rating('update',data['disiplin_01']);
					$('.disiplin_02').rating('update',data['disiplin_02']);
					$('.disiplin_03').rating('update',data['disiplin_03']);
					$('.disiplin_04').rating('update',data['disiplin_04']);
					
					$('.kerjasama_01').rating('update',data['kerjasama_01']);
					$('.kerjasama_02').rating('update',data['kerjasama_02']);
					$('.kerjasama_03').rating('update',data['kerjasama_03']);
					$('.kerjasama_04').rating('update',data['kerjasama_04']);
					$('.kerjasama_05').rating('update',data['kerjasama_05']);
					
					
					$('.kepemimpinan_01').rating('update',data['kepemimpinan_01']);
					$('.kepemimpinan_02').rating('update',data['kepemimpinan_02']);
					$('.kepemimpinan_03').rating('update',data['kepemimpinan_03']);
					$('.kepemimpinan_04').rating('update',data['kepemimpinan_04']);
					$('.kepemimpinan_05').rating('update',data['kepemimpinan_05']);
					$('.kepemimpinan_06').rating('update',data['kepemimpinan_06']); 
					
					hitung_ave_pelayanan();
					hitung_ave_integritas();
					hitung_ave_komitmen();
					hitung_ave_disiplin();
					hitung_ave_kerjasama();
					hitung_ave_kepemimpinan();

					if ( data['id'] == 0 ){
						$('.modal-penilaian_perilaku_kerja').find('h4').html('Add Penilaian Perilaku');
						$('.modal-penilaian_perilaku_kerja').find('.btn-submit').attr('id', 'simpan_penilaian_perilaku_kerja');
					}else{
						$('.modal-penilaian_perilaku_kerja').find('h4').html('Edit Penilaian Perilaku');
						$('.modal-penilaian_perilaku_kerja').find('.btn-submit').attr('id', 'update_penilaian_perilaku_kerja');
					}

					
					
					$('.modal-penilaian_perilaku_kerja').modal('show');

				},
				error: function(data){
					
				}						
		});	 
	});
</script>
