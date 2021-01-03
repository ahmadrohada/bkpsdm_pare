<div class="modal fade modal-penilaian_perilaku_kerja" id="perilaku_kerja" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
					Penilaian Perilaku Kerja 
                </h4>
            </div>
            <div class="modal-body table-responsive"> 
			<form class="penilaian_perilaku_kerja_form">
			<input type="hidden" class="capaian_tahunan_id" name="capaian_tahunan_id" >
			<input type="hidden" class="perilaku_kerja_id" name="perilaku_kerja_id" >
			

					<table class="table table-condensed penilaian">
						<thead>
						<tr class='bg-primary'>
							<th data-halign="center"  data-valign="middle" data-align="center" data-valign="middle" width="17%">Indikator</th>
							<th data-halign="center" data-valign="middle" width="40%">Sub.Indikator</th>
							<th data-halign="center" data-valign="middle" data-align="center" width="35%">Skor</th>
							<th data-halign="center" data-valign="middle" data-align="center" data-valign="middle">Skor</th>
						
						</tr>
						</thead>
						<!-- DATA QUESIONER -->
						<tr style="background:rgb(239, 254, 255);">
							<td rowspan="3" style="valign:middle;" >Orientasi Pelayanan</td>
							<td>Sopan</td>
							<td>
								<input value="1" class="rating-pk pelayanan_01" name="pelayanan_01" >
							</td>
							<td rowspan="3" ><span class="skor_pelayanan">0</span></td>
						</tr>
						<tr style="background:rgb(239, 254, 255);">
							<td>Hormat</td>
							<td> 
								<input  value="1" class="rating-pk pelayanan_02" name="pelayanan_02">
							</td>
						</tr>
						<tr style="background:rgb(239, 254, 255);">
							<td>Mampu Menyelesaikan Tugas</td>
							<td> 
								<input   value="1" class="rating-pk pelayanan_03" name="pelayanan_03">
							</td>
						</tr>
						
						<tr style="background:rgb(255, 255, 239);">
							<td rowspan="4" >Integritas</td>
							<td>Jujur</td>
							<td>
								<input  value="1"  class="rating-pk integritas_01" name="integritas_01" >
							</td>
							<td rowspan="4" ><span class="skor_integritas">0</span></td>
						</tr>
						<tr style="background:rgb(255, 255, 239);">
							<td>Ikhlas</td>
							<td> 
								<input  value="1" class="rating-pk integritas_02" name="integritas_02" >
							</td>
						</tr>
						<tr style="background:rgb(255, 255, 239);">
							<td>Tidak menyalahgunakan mewenang</td>
							<td> 
								<input  value="1" class="rating-pk integritas_03" name="integritas_03" >
							</td>
						</tr>
						<tr style="background:rgb(255, 255, 239);">
							<td>Berani menanggung resiko</td>
							<td> 
								<input  value="1" class="rating-pk integritas_04" name="integritas_04" >
							</td>
						</tr>
						
						<tr style="background:rgb(250, 208, 248);">
							<td rowspan="3" >Komitmen</td>
							<td>Menegakan ideologi pancasila / UUD’45 dan NKRI</td>
							<td>
								<input  value="1" class="rating-pk komitmen_01" name="komitmen_01" >
							</td>
							<td rowspan="3" ><span class="skor_komitmen">0</span></td>
						</tr>
						<tr style="background:rgb(250, 208, 248);">
							<td>Berusaha menjalankan rencana dan tujuan organisasi</td>
							<td> 
								<input  value="1" class="rating-pk komitmen_02" name="komitmen_02" >
							</td>
						</tr>
						<tr style="background:rgb(250, 208, 248);">
							<td>Mengutamakan kepentingan kedinasan dari pada kepentingan pribadi dan golongan</td>
							<td> 
								<input  value="1" class="rating-pk komitmen_03" name="komitmen_03">
							</td>
						</tr>
						
						<tr style="background:rgb(208, 250, 221);">
							<td rowspan="4" >Disiplin</td>
							<td>Taat pada aturan</td>
							<td>
								<input  value="1" class="rating-pk disiplin_01" name="disiplin_01" >
							</td>
							<td rowspan="4" ><span class="skor_disiplin">0</span></td>
						</tr>
						<tr style="background:rgb(208, 250, 221);">
							<td>Tanggungjawab</td>
							<td> 
								<input  value="1" class="rating-pk disiplin_02" name="disiplin_02">
							</td>
						</tr>
						<tr style="background:rgb(208, 250, 221);">
							<td>Mentaati ketentuan jam kerja</td>
							<td> 
								<input  value="1" class="rating-pk disiplin_03" name="disiplin_03">
							</td>
						</tr>
						<tr style="background:rgb(208, 250, 221);">
							<td>Mampu menyimpan / memelihara barang milik negara / daerah</td>
							<td> 
								<input  value="1" class="rating-pk disiplin_04" name="disiplin_04" >
							</td>
						</tr>
						
						
						<tr>
							<td rowspan="5" >Kerjasama</td>
							<td>Mampu bekerjasama dengan rekan kerja baik di dalam maupun di luar kerja</td>
							<td>
								<input  value="1" class="rating-pk kerjasama_01" name="kerjasama_01" >
							</td>
							<td rowspan="5" ><span class="skor_kerjasama">0</span></td>
						</tr>
						<tr>
							<td>Mampu bekerjasama dengan atasan baik di dalam maupun di luar kerja</td>
							<td> 
								<input  value="1" class="rating-pk kerjasama_02" name="kerjasama_02">
							</td>
						</tr>
						<tr>
							<td>Mampu bekerjasama dengan bawahan baik di dalam maupun di luar kerja</td>
							<td> 
								<input  value="1" class="rating-pk kerjasama_03" name="kerjasama_03">
							</td>
						</tr>
						<tr>
							<td>Menghargai dan menerima pendapat orang lain</td>
							<td> 
								<input  value="1" class="rating-pk kerjasama_04" name="kerjasama_04" >
							</td>
						</tr>
						<tr>
							<td>Bersedia menerima keputusan yang diambil yang telah menjadi keputusan bersama</td>
							<td> 
								<input  value="1" class="rating-pk kerjasama_05" name="kerjasama_05">
							</td>
						</tr>
						
						
						@if ( $capaian->PegawaiYangDinilai->Eselon->id_jenis_jabatan  < 4 )
					
						
						<tr style="background:rgb(240, 208, 250);">
							<td rowspan="6" >Kepemimpinan</td>
							<td>Tegas</td>
							<td>
								<input  value="1" class="rating-pk kepemimpinan_01" name="kepemimpinan_01">
							</td>
							<td rowspan="6" ><span class="skor_kepemimpinan">0</span></td>
						</tr>
						<tr style="background:rgb(240, 208, 250);">
							<td>Tidak Memihak</td>
							<td> 
								<input  value="1" class="rating-pk kepemimpinan_02" name="kepemimpinan_02">
							</td>
						</tr>
						<tr style="background:rgb(240, 208, 250);">
							<td>Memberikan teladan</td>
							<td> 
								<input  value="1" class="rating-pk kepemimpinan_03" name="kepemimpinan_03">
							</td>
						</tr>
						<tr style="background:rgb(240, 208, 250);">
							<td>Mampu menggerakan tim kerja</td>
							<td> 
								<input  value="1" class="rating-pk kepemimpinan_04" name="kepemimpinan_04">
							</td>
						</tr>
						<tr style="background:rgb(240, 208, 250);">
							<td>Mampu menggugah semangat dan menggerakan bawahan</td>
							<td> 
								<input  value="1" class="rating-pk kepemimpinan_05" name="kepemimpinan_05">
							</td>
						</tr>
						<tr style="background:rgb(240, 208, 250);">
							<td>Mampu mengambil keputusan dengan cepat dan tepat</td>
							<td> 
								<input  value="1" class="rating-pk kepemimpinan_06" name="kepemimpinan_06">
							</td>
						</tr>
						
						
						@endif
						
						<tr>
							<td colspan="3">Rata - rata skor</td>
							<td><span class="ave_skor">0</span></td>
						</tr>
						
						
					</table>
            </div>

			<div class="modal-footer">
                {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_cancel_icon').'" aria-hidden="true"></i> ' . Lang::get('modals.confirm_modal_button_cancel_text'), array('class' => 'btn btn-sm btn-default pull-left ', 'type' => 'button', 'data-dismiss' => 'modal' )) !!}
                {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_save_icon').'" aria-hidden="true"></i> ' . Lang::get('modals.confirm_modal_button_save_text'), array('class' => 'btn btn-sm btn-primary pull-right  btn-submit', 'type' => 'button', 'id' => 'save' )) !!}
            </div>
			</form>
        </div>
    </div>
</div>



<link rel="stylesheet" href="{{asset('assets/css/star-rating.css')}}" />
<script src="{{asset('assets/js/star-rating.js')}}"></script>
<style>
table.penilaian tbody td {
  vertical-align: middle;
}
</style>

<script type="text/javascript">
$(document).ready(function() {


	$(".rating-pk").rating({
			showCaption: true,
			min: 0, 
			max: 5, 
			step: 1, 
			size: "xs", 
			stars: "5",
			'starCaptions': {
								0: '&nbsp;Kosong&nbsp;', 
								1: '&nbsp;Sangat Kurang&nbsp;', 
								2: '&nbsp;&nbsp;&nbsp;Kurang&nbsp&nbsp;&nbsp;&nbsp;', 
								3: '&nbsp;&nbsp;&nbsp;&nbsp;Cukup&nbsp;&nbsp;&nbsp;&nbsp;',
								4: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Baik&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
								5: '&nbsp;&nbsp;Sangat Baik &nbsp;&nbsp;'}
	});

	

	
	hitung_ave_pelayanan();
	hitung_ave_integritas();
	hitung_ave_komitmen();
	hitung_ave_disiplin();
	hitung_ave_kerjasama();
	hitung_ave_kepemimpinan();

	$(document).on('change', '.pelayanan_01, .pelayanan_02 , .pelayanan_03', function(){
		hitung_ave_pelayanan();
		
	});

	function hitung_ave_pelayanan(){
		a = parseInt($(".pelayanan_01").val() ? $(".pelayanan_01").val() : 0);
		b = parseInt($(".pelayanan_02").val() ? $(".pelayanan_02").val() : 0);
		c = parseInt($(".pelayanan_03").val() ? $(".pelayanan_03").val() : 0);
		
		
		d =(( a+b+c )/15 )*100;
		
		if ( d != 100 ){
			dx = d.toFixed(2);
		}else{
			dx = 100;
		}
		
		$(".skor_pelayanan").html(dx);
		hitung_ave_skor();
	}

	$(document).on('change', '.integritas_01, .integritas_02 , .integritas_03, .integritas_04', function(){
		hitung_ave_integritas();
	});

	function hitung_ave_integritas(){
		a = parseInt($(".integritas_01").val() ? $(".integritas_01").val() : 0);
		b = parseInt($(".integritas_02").val() ? $(".integritas_02").val() : 0);
		c = parseInt($(".integritas_03").val() ? $(".integritas_03").val() : 0);
		d = parseInt($(".integritas_04").val() ? $(".integritas_04").val() : 0);
		
		
		e =( (a+b+c+d )/20 )*100;
		if ( e != 100 ){
			ex = e.toFixed(2);
		}else{
			ex = 100;
		}
		
		$(".skor_integritas").html(ex);
		hitung_ave_skor();
	}

	$(document).on('change', '.komitmen_01, .komitmen_02 , .komitmen_03', function(){
		hitung_ave_komitmen();
	});

	function hitung_ave_komitmen(){
		a = parseInt($(".komitmen_01").val() ? $(".komitmen_01").val() : 0);
		b = parseInt($(".komitmen_02").val() ? $(".komitmen_02").val() : 0);
		c = parseInt($(".komitmen_03").val() ? $(".komitmen_03").val() : 0);
		
		
		d =( ( a+b+c )/15 )*100;
		
		
		if ( d != 100 ){
			dx = d.toFixed(2);
		}else{
			dx = 100;
		}
		
		$(".skor_komitmen").html(dx);
		hitung_ave_skor();
	}
		
		
	$(document).on('change', '.disiplin_01, .disiplin_02 , .disiplin_03, .disiplin_04', function(){
		hitung_ave_disiplin();
	});

	function hitung_ave_disiplin(){
		a = parseInt($(".disiplin_01").val() ? $(".disiplin_01").val() : 0);
		b = parseInt($(".disiplin_02").val() ? $(".disiplin_02").val() : 0);
		c = parseInt($(".disiplin_03").val() ? $(".disiplin_03").val() : 0);
		d = parseInt($(".disiplin_04").val() ? $(".disiplin_04").val() : 0);
		
		e =( ( a+b+c+d )/20 )*100;
		
		if ( e != 100 ){
			ex = e.toFixed(2);
		}else{
			ex = 100;
		}
		
		$(".skor_disiplin").html(ex);
		hitung_ave_skor();
	}


	$(document).on('change', '.kerjasama_01, .kerjasama_02 , .kerjasama_03, .kerjasama_04, .kerjasama_05', function(){
		hitung_ave_kerjasama();
	});

	function hitung_ave_kerjasama(){
		a = parseInt($(".kerjasama_01").val() ? $(".kerjasama_01").val() : 0);
		b = parseInt($(".kerjasama_02").val() ? $(".kerjasama_02").val() : 0);
		c = parseInt($(".kerjasama_03").val() ? $(".kerjasama_03").val() : 0);
		d = parseInt($(".kerjasama_04").val() ? $(".kerjasama_04").val() : 0);
		e = parseInt($(".kerjasama_05").val() ? $(".kerjasama_05").val() : 0);
		
		
		
		
		if ( {!! $capaian->PegawaiYangDinilai->Eselon->id_jenis_jabatan!!}  >= 4 ){
			f =( ( a+b+d+e )/20 )*100;
		}else{
			f =( ( a+b+c+d+e )/25 )*100;
		}
		
		
		
		
		
		if ( f != 100 ){
			fx = f.toFixed(2);
		}else{
			fx = 100;
		}
		
		$(".skor_kerjasama").html(fx);
		hitung_ave_skor();
	}



	$(document).on('change', '.kepemimpinan_01, .kepemimpinan_02 , .kepemimpinan_03, .kepemimpinan_04, .kepemimpinan_05, .kepemimpinan_06', function(){
		hitung_ave_kepemimpinan();
	});

	function hitung_ave_kepemimpinan(){
		a = parseInt($(".kepemimpinan_01").val() ? $(".kepemimpinan_01").val() : 0);
		b = parseInt($(".kepemimpinan_02").val() ? $(".kepemimpinan_02").val() : 0);
		c = parseInt($(".kepemimpinan_03").val() ? $(".kepemimpinan_03").val() : 0);
		d = parseInt($(".kepemimpinan_04").val() ? $(".kepemimpinan_04").val() : 0);
		e = parseInt($(".kepemimpinan_05").val() ? $(".kepemimpinan_05").val() : 0);
		f = parseInt($(".kepemimpinan_06").val() ? $(".kepemimpinan_06").val() : 0);
		
		
		g =( ( a+b+c+d+e+f )/30 )*100;
		
		
		if ( g != 100 ){
			gx = g.toFixed(2);
		}else{
			gx = 100;
		}
		
		$(".skor_kepemimpinan").html(gx);
		hitung_ave_skor();
	}

	function hitung_ave_skor(){
		a = parseFloat($(".skor_pelayanan").html() 	? $(".skor_pelayanan").html() 		: 0);
		b = parseFloat($(".skor_integritas").html() 	? $(".skor_integritas").html() 		: 0);
		c = parseFloat($(".skor_komitmen").html() 	? $(".skor_komitmen").html() 		: 0);
		d = parseFloat($(".skor_disiplin").html() 	? $(".skor_disiplin").html() 		: 0);
		e = parseFloat($(".skor_kerjasama").html() 	?$(".skor_kerjasama").html() 		: 0);
		f = parseFloat($(".skor_kepemimpinan").html() ? $(".skor_kepemimpinan").html() 	: 0);
		
		
		
		if (  {!! $capaian->PegawaiYangDinilai->Eselon->id_jenis_jabatan!!}  >= 4 ){
			g =( a+b+c+d+e+f )/5;
		}else{
			g =( a+b+c+d+e+f )/6;
		}

		
		
		
		if ( g != 100 ){
			gx = g;
		}else{
			gx = 100;
		}
		
		$(".ave_skor").html(gx.toFixed(2));
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

	
	$(document).on('click', '#simpan_penilaian_perilaku_kerja', function(){
		
        var data = $('.penilaian_perilaku_kerja_form').serialize();
		$.ajax({
			url		: '{{ url("api/simpan_penilaian_perilaku_kerja") }}',
			type	: 'POST',
			data	:  data,
			success	: function(data , textStatus, jqXHR) {
				Swal.fire({
					title: "",
					text: "Sukses",
					type: "success",
					width: "200px",
					showConfirmButton: false,
					allowOutsideClick : false,
					timer: 1500
				}).then(function () {
					status_pengisian();
					//$('#realisasi_kegiatan_tahunan_table').DataTable().ajax.reload(null,false);
					$('.modal-penilaian_perilaku_kerja').modal('hide');

				},
					function (dismiss) {
						if (dismiss === 'timer') {
							//$('#realisasi_kegiatan_tahunan_table').DataTable().ajax.reload(null,false);
						}
					}
			)	
			},
			error: function(jqXHR , textStatus, errorThrown) {

				var test = $.parseJSON(jqXHR.responseText);
				
				var data= test.errors;
				alert("Berikan minimal 1 bintang pada setiap poin penilaian");

				

				
			}
			
		  });
		
    });

	$(document).on('click', '#update_penilaian_perilaku_kerja', function(){
		
        var data = $('.penilaian_perilaku_kerja_form').serialize();
		$.ajax({
			url		: '{{ url("api/update_penilaian_perilaku_kerja") }}',
			type	: 'POST',
			data	:  data,
			success	: function(data , textStatus, jqXHR) {
				Swal.fire({
					title: "",
					text: "Sukses",
					type: "success",
					width: "200px",
					showConfirmButton: false,
					allowOutsideClick : false,
					timer: 1500
				}).then(function () {
					status_pengisian();
					//$('#realisasi_kegiatan_tahunan_table').DataTable().ajax.reload(null,false);
					$('.modal-penilaian_perilaku_kerja').modal('hide');

				},
					function (dismiss) {
						if (dismiss === 'timer') {
							//$('#realisasi_kegiatan_tahunan_table').DataTable().ajax.reload(null,false);
						}
					}
			)	
			},
			error: function(jqXHR , textStatus, errorThrown) {

				var test = $.parseJSON(jqXHR.responseText);
				
				var data= test.errors;
				alert("Berikan minimal 1 bintang pada setiap poin penilaian");

				

				
			}
			
		  });
		
    });


});

</script>