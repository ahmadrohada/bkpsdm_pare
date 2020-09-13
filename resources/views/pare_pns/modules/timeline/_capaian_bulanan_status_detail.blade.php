
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
						Pejabat Penilai <a class="pull-right st_pejabat_penilai">-</a>
					</li>
					<li class="list-group-item">
						Jumlah Kegiatan <a class="pull-right st_jm_kegiatan_bulanan" >-</a>
					</li>
		
					<li class="list-group-item">
						Status Approve <a class="pull-right st_status_approve" >-</a>
					</li>
					<li class="list-group-item st_alasan_penolakan_div hidden">
						Alasan Penolakan <a class="pull-right st_alasan_penolakan" >-</a>
					</li>

					<li class="list-group-item">
						Capaian Kinerja Bulanan <span class="text-muted"> (bobot 70%)</span><a class="pull-right st_capaian_kinerja_bulanan" >-</a>
					</li>

					<li class="list-group-item st_pke hidden" >
						<input type="hidden" class="penilaian_kode_etik_id">
						Penilaian Kode Etik <span class="text-muted"> (bobot 30%)</span>
						<a class="pull-right st_penilaian_kode_etik" >-</a>
					</li>

					<li class="list-group-item st_pke hidden" style="background:#efeff0; border-top: solid #615e68 !important; border-top-width: 2px;">
						<strong>Capaian SKP Bulanan</strong> <a class="pull-right st_capaian_skp_bulanan" style="font-weight: bold;" >-</a>
					</li>
					
				</ul>
				<!-- <a href="#" class="btn btn-primary btn-block kirim_capaian "><b>Kirim ke Atasan <i class="send_icon"></i></b></a>
				 -->


			</div>
		</div>
	</div>
	<div class="col-md-8">
		
		<div class="box st_pke hidden">
            <div class="box-header" style="height:40px;">
              <h1 class="box-title text-success" style="font-size:16px;">Penilaian Kode Etik</h1>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <table class="table table-condensed">
               
                <tr>
                  <td style="width: 10px">1.</td>
                  <td>Santun</td>
                  <td style="width: 80px"><span class="badge bg-light-blue santun">0 %</span></td>
                </tr>
                <tr>
                  <td>2.</td>
                  <td>Amanah</td>
                  <td><span class="badge bg-light-blue amanah">0 %</span></td>
                </tr>
                <tr>
                  <td>3.</td>
                  <td>Harmonis</td>
                  <td><span class="badge bg-light-blue harmonis">0 %</span></td>
                </tr>
                <tr>
                  <td>4.</td>
                  <td>Adaptif</td>
                  <td><span class="badge bg-light-blue adaptif">0 %</span></td>
				</tr>
				<tr>
                  <td>5.</td>
                  <td>Terbuka</td>
                  <td><span class="badge bg-light-blue terbuka">0 %</span></td>
				</tr>
				<tr>
                  <td>6.</td>
                  <td>Efektif</td>
                  <td><span class="badge bg-light-blue efektif">0 %</span></td>
                </tr>
              </table>
            </div>
        </div>
	</div>


</div>



	 
<link rel="stylesheet" href="{{asset('assets/timeline/animate.min.css')}}" />
<link rel="stylesheet" href="{{asset('assets/timeline/style-albe-timeline.css')}}" />
<script src="{{asset('assets/timeline/jquery-albe-timeline.js')}}"></script>

<script type="text/javascript">


	
	function status_show(){
		$.ajax({
				url			: '{{ url("api_resource/capaian_bulanan_status_pengisian") }}',
				data 		: { capaian_bulanan_id : {!! $capaian->id !!} },
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					//alert(data);
					if (data['button_kirim'] == 1 ){
						$('.close_capaian_bulanan').removeAttr('disabled');
					}else{
						$('.close_capaian_bulanan').attr('disabled','disabled');
					}

					$('.st_created_at').html(data['tgl_dibuat']);
					$('.st_pejabat_penilai').html(data['p_nama']);
					$('.st_jm_kegiatan_bulanan').html(data['jm_kegiatan_bulanan']);
					$('.st_capaian_kinerja_bulanan').html(data['capaian_kinerja_bulanan']);
					$('.st_status_approve').html(data['status_approve']);
					$('.st_alasan_penolakan').html(data['alasan_penolakan']);

					$('.st_penilaian_kode_etik').html(data['penilaian_kode_etik']);
					$('.st_capaian_skp_bulanan').html(data['capaian_skp_bulanan']);
					

					if ((data['penilaian_kode_etik_id'] >= 1 ) && (data['alasan_penolakan'] == "") && (data['status_approve'] == "disetujui") ){
						$('.st_pke').removeClass('hidden');
						$('.penilaian_kode_etik_id').val(data['penilaian_kode_etik_id']);
						
					}

					if (data['alasan_penolakan'] != ""){
						
						$('.st_alasan_penolakan_div').removeClass('hidden');
					} 
					

					$('.santun').html(data['santun']+' %');
					$('.amanah').html(data['amanah']+' %');
					$('.harmonis').html(data['harmonis']+' %');
					$('.adaptif').html(data['adaptif']+' %');
					$('.terbuka').html(data['terbuka']+' %');
					$('.efektif').html(data['efektif']+' %');
				},
				error: function(data){
					
				}						
		});
	}

	
</script>
