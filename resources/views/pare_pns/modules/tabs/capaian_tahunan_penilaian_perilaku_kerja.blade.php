
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
					@if ( request()->segment(2) === "capaian_tahunan_bawahan_approvement" )
						<a class="btn btn-success  btn-block edit_penilaian_perilaku" style="margin-top:-1px;"><i class="fa fa-pencil" ></i> Berikan Penilaian</a>
					@endif
	</div>
</div>

@include('pare_pns.modals.penilaian_perilaku_kerja')


<script type="text/javascript">


	function penilaian_perilaku_kerja_show(){
		
		$.ajax({
			url			: '{{ url("api_resource/penilaian_perilaku_kerja") }}',
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
</script>
