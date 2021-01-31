<div class="row">
	<div class="col-md-5">
		<div class="panel-default ">
			<i class="fa fa-bar-chart-o"></i>
			<span class="text-primary"> NILAI PRESTASI KERJA</span>
		</div>
 
		<ul class="list-group list-group-unbordered" style="margin-top:20px;">
			<li class="list-group-item" style="padding:8px 10px; border-top: solid 1px #615e68 !important;">
				Jumlah Kegiatan SKP <a class="pull-right st_jm_kegiatan_bulanan" >-</a>
			</li>
			<li class="list-group-item" style="padding:8px 10px;">
				Jumlah Uraian Tugas Tambahan <a class="pull-right st_jm_uraian_tugas_tambahan" >-</a>
			</li>
					
					
			
			<li class="list-group-item" style="padding:8px 10px; border-top: solid 1px #615e68 !important; ">
				Capaian Kinerja Bulanan <span class="text-muted"> (bobot 70%)</span><a class="pull-right st_capaian_kinerja_bulanan" >-</a>
			</li>

			@if ( request()->segment(4) != 'edit' )
			<li class="list-group-item" style="padding:8px 10px;">
				<input type="hidden" class="penilaian_kode_etik_id">
				Penilaian Kode Etik <span class="text-muted"> (bobot 30%)</span>
				<a class="pull-right st_penilaian_kode_etik" >-</a>
			</li>

					
			<li class="list-group-item" style="background:#efeff0; border-top: solid #615e68 !important; border-top-width: 2px; padding:8px 10px;">
				<strong>Capaian SKP Bulanan</strong> <a class="pull-right st_capaian_skp_bulanan" style="font-weight: bold;" >-</a>
			</li>
			@endif	
		</ul>
	</div>
</div>



<script type="text/javascript">


	function sumary_show(){
		status_pengisian();	
	}

	

	function status_pengisian(){
		$.ajax({
				url			: '{{ url("api/capaian_bulanan_status_pengisian") }}',
				data 		: { capaian_bulanan_id : {!! $capaian->id !!} },
				method		: "GET",
				dataType	: "json",
				cache   	: false,
				success	: function(data) {
					
					$('.st_created_at').html(data['tgl_dibuat']);
					$('.st_pejabat_penilai').html(data['p_nama']);
					$('.st_jm_kegiatan_bulanan').html(data['jm_kegiatan_bulanan']);
					$('.st_jm_uraian_tugas_tambahan').html(data['jm_uraian_tugas_tambahan']);
					$('.st_capaian_kinerja_bulanan').html(data['capaian_kinerja_bulanan']);
					$('.st_status_approve').html(data['status_approve']);
					$('.st_alasan_penolakan').html(data['alasan_penolakan']);

					$('.st_penilaian_kode_etik').html(data['penilaian_kode_etik']);
					$('.st_capaian_skp_bulanan').html(data['capaian_skp_bulanan']);

					if ( data['alasan_penolakan'] != ""){
						$('.st_alasan_penolakan_div').removeClass('hidden');
					} 
					
					
				},
				error: function(data){
					
				}						
		});
	}


</script>
