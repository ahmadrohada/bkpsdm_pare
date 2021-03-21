
<div class="row">
	
	<div class="col-md-7">
		<div class="panel-default ">
			<i class="fa fa-bar-chart-o"></i>
			<span class="text-primary"> PENILAIAN KODE ETIK</span>
		</div>
		<table class="table  table-condensed" style="margin-top:20px;">
			<tr>
				<td style="width: 8%; padding-left:10px;">NO</td>
				<td style="width: *%">LABEL</td>
				<td style="text-align:center; width: 20%">NILAI</td>
			</tr>
			<tr>
				<td style="padding-left:10px;">1.</td>
				<td>Santun</td>
				<td style="text-align:center;"><span class="text-info nilai_santun">0 %</span></td>
			</tr>
			<tr>
				<td style="padding-left:10px;">2.</td>
				<td>Amanah</td>
				<td style="text-align:center;"><span class="text-info nilai_amanah">0 %</span></td>
			</tr>
			<tr>
				<td style="padding-left:10px;">3.</td>
				<td>Harmonis</td>
				<td style="text-align:center;"><span class="text-info nilai_harmonis">0 %</span></td>
			</tr>
			<tr>
				<td style="padding-left:10px;">4.</td>
				<td>Adaptif</td>
				<td style="text-align:center;"><span class="text-info nilai_adaptif">0 %</span></td>
			</tr>
			<tr>
				<td style="padding-left:10px;">5.</td>
				<td>Terbuka</td>
				<td style="text-align:center;"><span class="text-info nilai_terbuka">0 %</span></td>
			</tr>
			<tr>
				<td style="padding-left:10px;">6.</td>
				<td>Efektif</td>
				<td style="text-align:center;"><span class="text-info nilai_efektif">0 %</span></td>
			</tr>
		</table>
		@if ( request()->segment(2) === "capaian_bulanan_bawahan_approvement" )
		<a class="btn btn-success  btn-block btn_pke edit_penilaian_kode_etik" style="margin-top:-1px;"><i class="fa fa-pencil" ></i> Berikan Penilaian</a>
		@endif
	</div>
</div>
					
	




<script type="text/javascript">


	function penilaian_kode_etik_show(){
		$.ajax({
				url			: '{{ url("api/penilaian_kode_etik") }}',
				data 		: { capaian_bulanan_id : {!! $capaian->id !!} },
				method		: "GET",
				dataType	: "json",
				cache   	: false,
				success	: function(data) {
					
					$('.nilai_santun').html(data['santun']);
					$('.nilai_amanah').html(data['amanah']);
					$('.nilai_harmonis').html(data['harmonis']);
					$('.nilai_adaptif').html(data['adaptif']);
					$('.nilai_terbuka').html(data['terbuka']);
					$('.nilai_efektif').html(data['efektif']);

					if (data['penilaian_kode_etik_id'] != null ){
						$('.penilaian_kode_etik_id').val(data['penilaian_kode_etik_id']);

						$('.btn_pke').addClass('edit_penilaian_kode_etik');
						$('.btn_pke').removeClass('penilaian_kode_etik');
						
					}else{
						$('.btn_pke').removeClass('edit_penilaian_kode_etik');
						$('.btn_pke').addClass('penilaian_kode_etik');
						
					}

					
				},
				error: function(data){
					
				}						
		});
	}

    $(document).on('click','.penilaian_kode_etik',function(e){

		$('.santun,.amanah,.harmonis,.adaptif,.terbuka,.efektif').rating('update',1);
		$('.modal-penilaian_kode_etik').find('[name=capaian_bulanan_id]').val({!! $capaian->id !!});
		$('.modal-penilaian_kode_etik').find('[name=text_button_submit]').html('Simpan Data');
		$('.modal-penilaian_kode_etik').modal('show');

	});

	$(document).on('click','.edit_penilaian_kode_etik',function(e){
		show_loader();
		var id = $('.penilaian_kode_etik_id').val();
		$.ajax({
			url			: '{{ url("api/detail_penilaian_kode_etik") }}',
			data 		: {penilaian_kode_etik_id : id},
			method		: "GET",
			dataType	: "json",
			success	: function(data) {

					$('.modal-penilaian_kode_etik').find('[name=capaian_bulanan_id]').val({!! $capaian->id !!});
					
					$('.santun').rating('update',data['santun']);
					$('.amanah').rating('update',data['amanah']);
					$('.harmonis').rating('update',data['harmonis']);
					$('.adaptif').rating('update',data['adaptif']);
					$('.terbuka').rating('update',data['terbuka']);
					$('.efektif').rating('update',data['efektif']);
				
					
					$('.modal-penilaian_kode_etik').find('h4').html('Edit Penilaian Kode Etik');
					$('.modal-penilaian_kode_etik').find('.btn-submit').attr('id', 'update_penilaian_kode_etik');
					$('.modal-penilaian_kode_etik').find('[name=text_button_submit]').html('Update Data');
					$('.modal-penilaian_kode_etik').modal('show');

				},
				error: function(data){
					
				}						
		});	 
	});
</script>
