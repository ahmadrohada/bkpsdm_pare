{{-- <div class="row badge_persetujuan" hidden>
	<div class="col-md-12">
		<div class="alert alert-danger bg-maroon alert-dismissible">
			<h4><i class="icon fa fa-info"></i> Status Capaian Tahunan</h4> 
			<span class="text-badge_persetujuan"></span>
		</div>
	</div>
</div>
 --}}
<div class="row">
	<div class="col-md-5">
	
		<div class="panel-default ">
			<i class="fa fa-bar-chart-o"></i>
			<span class="text-primary"> NILAI PRESTASI KERJA</span>
		</div>


		<ul class="list-group list-group-unbordered" style="margin-top:20px;">
					{{-- <li class="list-group-item " style="padding:8px 10px;">
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
					</li> --}}
			<li class="list-group-item" style="padding:8px 10px;">
				I. Jumlah Kegiatan Tahunan <a class="pull-right st_jumlah_kegiatan_tahunan" >-</a>
			</li>
			<li class="list-group-item" style="padding:8px 10px;">
				II. Jumlah Tugas Tambahan <a class="pull-right st_jumlah_tugas_tambahan" >-</a>
			</li>
			<li class="list-group-item" style="padding:8px 10px; border-top: solid 1px #615e68 !important;">
				A. Jumlah Kegiatan SKP ( I + II) <a class="pull-right st_jumlah_kegiatan_skp" >-</a>
			</li>

			@if ( ( request()->segment(4) != 'edit' )&( request()->segment(4) != 'ralat' ) )
					
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
				E. Penilaian Perilaku Kerja
				<a class="pull-right st_penilaian_perilaku_kerja" >-</a>
			</li>

			<li class="list-group-item" style="background:#efeff0; border-top: solid #615e68 !important; border-top-width: 2px; padding:8px 10px;">
				<strong>Nilai Prestasi Kerja</strong> 
				<span class="text-muted st_formula_perhitungan"> ( D x 60% ) + ( E x 40% )</span>
				<a class="pull-right st_nilai_prestasi_kerja" style="font-weight: bold;" >-</a>
			</li>
			@endif
					
		</ul>
	</div>
	
</div>




<script type="text/javascript">


	
	function sumary_show(){
		$.ajax({
				url			: '{{ url("api_resource/capaian_tahunan_status") }}',
				data 		: { capaian_tahunan_id : {!! $capaian->id !!} },
				method		: "GET",
				dataType	: "json",
				cache		: true,
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
