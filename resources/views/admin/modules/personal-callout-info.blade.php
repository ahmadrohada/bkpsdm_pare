<div class="callout callout-warning skp_tahunan_status" style="height:160px;" hidden>
	<p style="font-family:mainandra; font-size:12pt; color:#ebecf5; font-weight:bold; ">Belum ada SKP Tahunan pada Jabatan saat ini</p>
	<p style="font-family:mainandra; font-size:10pt; margin-top:-5px;">
		NIP : <span class="nip_pegawai"></span>
		<br>
		Jabatan : <span class="jabatan_aktif"></span>
		<br>
		Periode : <span class="periode_aktif"></span>
	</p>
	<p style="font-family:mainandra;">
		<a href="./personal/skp-tahunan" >SKP Tahunan Menu</a>
	</p>
</div>





<script>
$(document).ready(function(){
	
	

//CEK STATUS SKP TAHUNAN PADA PERIODE INI DAN JABATAN INI
//cek periode aktif
//cek renja
//cek perjanjian kinerja
//cek skp dengan perjanjian kinerja diatas,pegawai id , dan jabatan yang aktif pada m_history jabatan
	$.ajax({
			url		: '{{ url("api_resource/personal_cek_status_skp_tahunan") }}',
			type	: 'GET',
			data	:  	{ 
							pegawai_id : {!! $user->Pegawai->id !!},
							jabatan_id : {!! $user->Pegawai->JabatanAktif->id !!}
						},
			success	: function(data) {
				//alert(data['status']);
				setTimeout(function(){
					if ( data['skp_tahunan_status'] === false ){

						$('.nip_pegawai').html(data['nip_pegawai']);
						$('.jabatan_aktif').html(data['jabatan_aktif']);
						$('.periode_aktif').html(data['periode_aktif']);
						$('.skp_tahunan_status').show(  'slide', {direction: 'right'}, 500 );  //show callout

					}
				}, 1000)
			},
			error: function(jqXHR , textStatus, errorThrown) {

			}
			
	});






});
</script>