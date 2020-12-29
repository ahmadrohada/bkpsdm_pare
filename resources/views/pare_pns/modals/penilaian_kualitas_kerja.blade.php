<div class="modal fade modal-penilaian_kualitas_kerja" id="kualitas_kerja" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Penilaian Kode Etik Pegawai 
                </h4>
            </div>
            <div class="modal-body table-responsive">
			<form class="penilaian_kualitas_kerja_form">
			<input type="hidden" class="realisasi_kegiatan_tahunan_id" name="realisasi_kegiatan_tahunan_id" >

				<table class="table">
					<thead>
						<tr class='bg-primary'>
							<th data-halign="center"  data-align="left" data-valign="middle" width="220px">Indikator Kualitas</th>
							<th data-halign="center" data-align="left" data-width="270">Penilaian</th>
						
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Ketepatan Waktu</td>
							<td data-align="left">
								<input value="1" class="rating-kk akurasi" name="akurasi" >
							</td>
						</tr>
						<tr>
							<td>Kualitas Proses/Prosedur</td>
							<td data-align="left"> 
								<input  value="1" class="rating-kk ketelitian" name="ketelitian">
							</td>
						</tr>
						<tr>
							<td>Kualitas Produk/Hasil Kerja</td>
							<td data-align="left"> 
								<input   value="1" class="rating-kk kerapihan" name="kerapihan">
							</td>
						</tr>
						<tr>
							<td>Ketepatan Sasaran</td>
							<td data-align="left"> 
								<input  value="1" class="rating-kk keterampilan" name="keterampilan" >
							</td>
						</tr>
						<tr>
							<td><b>CAPAIAN QUALITY</b></td>
							<td data-align="left"><span class="capaian_mutu" style="font-weight:bold;">0</span></td>
						</tr>

					</tbody>
				</table>
            </div>

			<div class="modal-footer">
                {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_cancel_icon').'" aria-hidden="true"></i> ' . Lang::get('modals.confirm_modal_button_cancel_text'), array('class' => 'btn btn-sm btn-default pull-left ', 'type' => 'button', 'data-dismiss' => 'modal' )) !!}
                {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_save_icon').'" aria-hidden="true"></i> ' . Lang::get('modals.confirm_modal_button_save_text'), array('class' => 'btn btn-sm btn-primary pull-right  btn-submit', 'type' => 'button', 'id' => 'simpan_penilaian_kualitas_kerja' )) !!}
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


	$(".rating-kk").rating({
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

	

	$(document).on('change', '.akurasi, .ketelitian , .kerapihan, .keterampilan', function(){
		hitung_penilaian_kualitas_kerja();
	});

	$('.modal-penilaian_kualitas_kerja').on('shown.bs.modal', function(){
		hitung_penilaian_kualitas_kerja();
	});
	
	function hitung_penilaian_kualitas_kerja(){
		a = parseInt($(".akurasi").val() ? $(".akurasi").val() : 0);
		b = parseInt($(".ketelitian").val() ? $(".ketelitian").val() : 0);
		c = parseInt($(".kerapihan").val() ? $(".kerapihan").val() : 0);
		d = parseInt($(".keterampilan").val() ? $(".keterampilan").val() : 0);
		
		
		e =(( a+b+c+d )/20 )*100;

	
	
		if (( e.toFixed(2) % 2 === 0 )| ( e.toFixed(2) % 5 === 0 ) ){
			ex = e.toFixed(0);
			
		}else{
			ex = e.toFixed(0);
		}
		
		$(".capaian_mutu").html(ex+' %');
	}


	$(document).on('click', '#simpan_penilaian_kualitas_kerja', function(){
		@if ( $capaian->PegawaiYangDinilai->Eselon->id_jenis_jabatan  == '5')
			save_jft();
		@else
			save();
		@endif
        
		
    });

	function save(){
		var data = $('.penilaian_kualitas_kerja_form').serialize();
		$.ajax({
			url		: '{{ url("api_resource/simpan_penilaian_kualitas_kerja") }}',
			type	: 'POST',
			data	:  data,
			success	: function(data , textStatus, jqXHR) {
				
				//$('#indikator_sasaran_table').DataTable().ajax.reload(null,false);

				Swal.fire({
					title: "",
					text: "Sukses",
					type: "success",
					width: "200px",
					showConfirmButton: false,
					allowOutsideClick : false,
					timer: 1500
				}).then(function () {
					sumary_show();
					$('#realisasi_kegiatan_tahunan_table').DataTable().ajax.reload(null,false);
					$('.modal-penilaian_kualitas_kerja').modal('hide');

				},
					function (dismiss) {
						if (dismiss === 'timer') {
							$('#realisasi_kegiatan_tahunan_table').DataTable().ajax.reload(null,false);
						}
					}
			)	
			},
			error: function(jqXHR , textStatus, errorThrown) {

				var test = $.parseJSON(jqXHR.responseText);
				
				var data= test.errors;
				alert(data);

				

				
			}
			
		  });
	}

	function save_jft(){
		var data = $('.penilaian_kualitas_kerja_form').serialize();
		$.ajax({
			url		: '{{ url("api_resource/simpan_penilaian_kualitas_kerja_5") }}',
			type	: 'POST',
			data	:  data,
			success	: function(data , textStatus, jqXHR) {
				
				//$('#indikator_sasaran_table').DataTable().ajax.reload(null,false);

				Swal.fire({
					title: "",
					text: "Sukses",
					type: "success",
					width: "200px",
					showConfirmButton: false,
					allowOutsideClick : false,
					timer: 1500
				}).then(function () {
					sumary_show();
					$('#realisasi_kegiatan_tahunan_table').DataTable().ajax.reload(null,false);
					$('.modal-penilaian_kualitas_kerja').modal('hide');

				},
					function (dismiss) {
						if (dismiss === 'timer') {
							$('#realisasi_kegiatan_tahunan_table').DataTable().ajax.reload(null,false);
						}
					}
			)	
			},
			error: function(jqXHR , textStatus, errorThrown) {

				var test = $.parseJSON(jqXHR.responseText);
				
				var data= test.errors;
				alert(data);

				

				
			}
			
		  });
	}



	

</script>