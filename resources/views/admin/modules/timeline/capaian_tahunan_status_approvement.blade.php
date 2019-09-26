
<div class="row">
	<div class="col-md-5">
		<div class="box box-default">
			<div class="box-body box-profile">
			
				<h1 class="profile-username text-center text-success" style="font-size:16px;">
				Capaian SKP Periode {!! Pustaka::tahun($capaian->tgl_mulai) !!}
				</h1>

				<ul class="list-group list-group-unbordered">
					<li class="list-group-item ">
						Tanggal dibuat<a class="pull-right st_created_at">-</a>
					</li>
					<li class="list-group-item ">
						Pejabat Penilai <a class="pull-right st_pejabat_penilai">-</a>
					</li>
					<li class="list-group-item hidden">
						Jumlah Kegiatan <a class="pull-right st_jm_kegiatan_tahunan" >-</a>
					</li>
		
					

					<li class="list-group-item">
						Capaian SKP <span class="text-muted"> (bobot 60%)</span><a class="pull-right st_capaian_kinerja_tahunan" >-</a>
					</li>

					<li class="list-group-item st_pke" >
						<input type="hidden" class="penilaian_kode_etik_id">
						Penilaian Perilaku Kerja <span class="text-muted"> (bobot 40%)</span>
						<a class="btn btn-success btn-xs edit_penilaian_perilaku" style="margin-top:-1px;">Edit Penilaian <i class="fa fa-pencil" ></i></a>
						<a class="pull-right st_penilaian_kode_etik" >-</a>
					</li>

					<li class="list-group-item st_pke " style=" border-top: solid #615e68 !important; border-top-width: 2px;">
						<strong>Nilai Prestasi Kerja</strong> <a class="pull-right st_capaian_skp_tahunan" style="font-weight: bold;" >-</a>
					</li>
					
				</ul>
				<div class="pull-right">
					<a href="#" class="btn btn-sm btn-danger tolak_capaian_bulanan">TOLAK</a>
					<a href="#" id="btn_terima" class="btn btn-sm btn-primary  penilaian_kode_etik">TERIMA</a>
				</div>


			</div>
		</div>
	</div>
	<div class="col-md-5 col-md-offset-1">
		
		<div class="box">
            <!-- /.box-header -->
            <div class="box-body no-padding">
				<table class="table">
					<thead>
						<tr class='bg-primary'>
							<th data-halign="center"  data-align="center" data-valign="middle" width="10px">No</th>
							<th data-halign="center"  data-align="center" data-valign="middle" width="220px">Penilaian Perilaku Kerja</th>
							<th data-halign="center" data-align="center" data-width="270">Nilai</th>
							<th data-halign="center" data-align="center" data-width="270">Keterangan</th>
						
						</tr>
					</thead>
					<tbody>
						<tr>	
							<td>1</td>
							<td>Orientasi Pelayanan</td>
							<td><span class="nilai_orientasi_pelayanan"></span></td>
							<td><span class="ket_orientasi_pelayanan"></span></td>
						</tr>
						<tr>	
							<td>2</td>
							<td>Integritas</td>
							<td><span class="nilai_orientasi_pelayanan"></span></td>
							<td><span class="ket_orientasi_pelayanan"></span></td>
						</tr>
						<tr>	
							<td>3</td>
							<td>Komitmen</td>
							<td><span class="nilai_orientasi_pelayanan"></span></td>
							<td><span class="ket_orientasi_pelayanan"></span></td>
						</tr>
						<tr>	
							<td>4</td>
							<td>Disiplin</td>
							<td><span class="nilai_orientasi_pelayanan"></span></td>
							<td><span class="ket_orientasi_pelayanan"></span></td>
						</tr>
						<tr>	
							<td>5</td>
							<td>Kerjasama</td>
							<td><span class="nilai_orientasi_pelayanan"></span></td>
							<td><span class="ket_orientasi_pelayanan"></span></td>
						</tr>
						<tr>	
							<td>6</td>
							<td>Kepemimpinan</td>
							<td><span class="nilai_orientasi_pelayanan"></span></td>
							<td><span class="ket_orientasi_pelayanan"></span></td>
						</tr>
						<tr>	
							<td></td>
							<td>Jumlah</td>
							<td><span class="nilai_orientasi_pelayanan"></span></td>
							<td><span class="ket_orientasi_pelayanan"></span></td>
						</tr>
						<tr>	
							<td></td>
							<td>Rata-rata</td>
							<td><span class="nilai_orientasi_pelayanan"></span></td>
							<td><span class="ket_orientasi_pelayanan"></span></td>
						</tr>


					</tbody>
				</table>

            </div>
            <!-- /.box-body -->
          </div>
	</div>


</div>



@include('admin.modals.penilaian_perilaku_kerja')

<script type="text/javascript">

	
	
	function status_pengisian(){
		$.ajax({
				url			: '{{ url("api_resource/capaian_tahunan_status_pengisian") }}',
				data 		: { capaian_tahunan_id : {!! $capaian->id !!} },
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					//alert(data);
					if (data['button_kirim'] == 1 ){
						$('.close_capaian_tahunan').removeAttr('disabled');
					}else{
						$('.close_capaian_tahunan').attr('disabled','disabled');
					}

					$('.st_created_at').html(data['tgl_dibuat']);
					$('.st_pejabat_penilai').html(data['p_nama']);
					$('.st_jm_kegiatan_tahunan').html(data['jm_kegiatan_tahunan']);
					$('.st_capaian_kinerja_tahunan').html(data['capaian_kinerja_tahunan']);
					$('.st_status_approve').html(data['status_approve']);
					$('.st_alasan_penolakan').html(data['alasan_penolakan']);

					$('.st_capaian_skp_tahunan').html(data['capaian_skp_tahunan']);
					


					if (data['alasan_penolakan'] != ""){
						
						$('.st_alasan_penolakan_div').removeClass('hidden');
					} 
					
				},
				error: function(data){
					
				}						
		});
	}


	

	
</script>
