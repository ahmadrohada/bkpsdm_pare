
<div class="row">
	<div class="col-md-5">
		<div class="box box-primary">
			<div class="box-body box-profile">
			
				<h1 class="profile-username text-center text-success" style="font-size:16px;">
					Capaian SKP Periode {!! Pustaka::tahun($capaian->tgl_mulai) !!}
				
				</h1>
				
				<ul class="list-group list-group-unbordered">
					<li class="list-group-item" style="padding:8px 10px;">
						I. Jumlah Kegiatan Tahunan <a class="pull-right st_jumlah_kegiatan_tahunan" >-</a>
					</li>
					<li class="list-group-item" style="padding:8px 10px;">
						II. Jumlah Tugas Tambahan <a class="pull-right st_jumlah_tugas_tambahan" >-</a>
					</li>
					<li class="list-group-item" style="padding:8px 10px; border-top: solid 1px #615e68 !important;">
						A. Jumlah Kegiatan SKP ( I + II) <a class="pull-right st_jumlah_kegiatan_skp" >-</a>
					</li>
					<li class="list-group-item" style="padding:8px 10px;">
						B. Nilai Capaian Kegiatan SKP + Tugas Tambahan
						<a class="pull-right st_capaian_kegiatan_skp" >-</a>
					</li>
					<li class="list-group-item" style="padding:8px 10px;">
						C. Nilai Unsur Penunjang
						<a class="pull-right st_nilai_unsur_penunjang" >-</a>
					</li>
		
					

					<li class="list-group-item" style="padding:8px 10px; border-top: solid 1px #615e68 !important; ">
						D. Capaian SKP<span class="text-muted"> (B/A) + C
						</span><a class="pull-right st_capaian_skp" >-</a>
					</li>

					<li class="list-group-item" style="padding:8px 10px; ">
						<input type="hidden" class="penilaian_kode_etik_id">
						E. Penilaian Perilaku Kerja
						<a class="pull-right st_penilaian_perilaku_kerja" >-</a>
					</li>

					<li class="list-group-item" style="background:#efeff0; border-top: solid #615e68 !important; border-top-width: 2px; padding:8px 10px;">
						<strong>Nilai Prestasi Kerja</strong> 
						<span class="text-muted st_formula_perhitungan"> ( D x 60% ) + ( E x 40% )</span>
						<a class="pull-right st_nilai_prestasi_kerja" style="font-weight: bold;" >-</a>
					</li>
					
				</ul>
			</div>
		</div>
	</div> 
	
</div>




<script type="text/javascript">

	
	
	function sumary_show(){
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
					

					$('.st_capaian_skp').html(data['capaian_skp']);
					$('.st_nilai_unsur_penunjang').html(data['nilai_unsur_penunjang']);

					$('.st_penilaian_perilaku_kerja').html(data['penilaian_perilaku_kerja']);
					$('.st_nilai_prestasi_kerja').html(data['nilai_prestasi_kerja']);
					
					
				},
				error: function(data){
					
				}						
		});



		

	}


	
	

	
</script>
