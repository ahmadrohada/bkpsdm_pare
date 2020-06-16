<div class="modal fade modal-realisasi_rencana_aksi" id="" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Realisasi Rencana Aksi
                </h4>
            </div>

            <form  id="realisasi_rencana_aksi_form" onsubmit="return false;">

			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<input type="hidden"  name="rencana_aksi_id" class="rencana_aksi_id">
			<input type="hidden"  name="skp_bulanan_id" class="skp_bulanan_id">
			<input type="hidden"  name="capaian_id" class="realisasi_id">
			<input type="hidden"  name="realisasi_rencana_aksi_id" class="realisasi_rencana_aksi_id">
			<input type="hidden"  name="realisasi_bukti_file" class="realisasi_bukti_file">
			<input type="hidden"  name="satuan" class="satuan">

			
			<div class="modal-body">
					<div class="row">
						<div class="col-md-12 form-group label_kegiatan_tahunan">
							<strong>Jabatan </strong>
							<p style="margin-top:8px;">
								<i class="fa fa-user"></i> <span class="penanggung_jawab" style="margin-right:10px;"></span>
							</p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 form-group label_kegiatan_tahunan">
							<strong>Kegiatan Tahunan </strong>
							<p class="text-info " style="margin-top:8px;">
								<span class="kegiatan_tahunan_label"></span>
							</p>
							<i class="fa fa-industry" ></i> <span class="kegiatan_tahunan_output" style="margin-right:10px;"></span>
							<i class="fa fa-hourglass-start"></i> <span class="kegiatan_tahunan_waktu" style="margin-right:10px;"></span>
							<i class="fa fa-money"></i> <span class="kegiatan_tahunan_cost" style="margin-right:10px;"></span>
							<br>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 form-group label_kegiatan ">
							<strong>Rencana Aksi / Kegiatan Bulanan  </strong>
							<p class="text-info" style="margin-top:8px;">
								<span class="rencana_aksi_label"></span>
							</p>
							<i class="fa fa-industry"></i> 
								Target : <span class="target_rencana_aksi" style="margin-right:10px;"></span>
								Realisasi : <span class="realisasi_rencana_aksi" style="margin-right:10px;"></span>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-md-12 form-group label_kegiatan ">
							<strong>Kegiatan Bulanan Bawahan </strong>
							<p class="text-muted " style="margin-top:8px;">
								<span class="kegiatan_bulanan_label"></span>
							</p>
							<p>
								<i class="fa fa-user"></i> <span class="pelaksana" style="margin-right:10px;"></span>
							</p>

							<i class="fa fa-industry"></i> 
								Target : <span class="kegiatan_bulanan_output" style="margin-right:10px;"></span>
								Realisasi : <span class="realisasi_kegiatan_bulanan_output" style="margin-right:10px;"></span>
								Bukti : <span class="realisasi_kegiatan_bulanan_bukti" style="margin-right:10px;"></span>
						</div>
					</div>
					<hr>
					<div class="row"> 
						<div class="col-md-6 col-xs-6 form-group" style="margin-top:8px;">	
							<label class="control-label">Target Quantity </label>
							<div class="input-group">
							<input type="text" name="target" id="target" required class="form-control input-sm rencana_aksi_target" placeholder="target">
								<div class="input-group-addon">
									<span class="satuan_target_rencana_aksi"></span>
								</div>
							</div>

							<input type="hidden"  name="alasan_tidak_tercapai" class="alasan_tidak_tercapai">
						</div>
						<div class="col-md-6 col-xs-6 form-group realisasi" style="margin-top:8px;">	
							<label class="control-label">Realisasi Quantity </label>
							<div class="input-group">
								<input type="text" name="realisasi" id="realisasi" required class="form-control input-sm" placeholder="realisasi">
								<div class="input-group-addon">
									<span class="satuan_target_rencana_aksi"></span>
								</div>
							</div>
						</div>

						<div class="col-md-6 form-group bukti hidden" style="margin-top:8px;">
							<div class="form-group">
								<label for="file_bukti">Bukti</label>
								<input type="file" id="file_bukti" name="file_bukti">
								<p class="help-block">Unggah Dokumen sebagai bukti kegiatan</p>
							</div>
						</div>
				
						

					</div>
					



			</div>
			<div class="modal-footer">
                {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_cancel_icon').'" aria-hidden="true"></i> Batal', array('class' => 'btn btn-sm btn-default pull-left ', 'type' => 'button', 'data-dismiss' => 'modal' )) !!}
                {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_save_icon').' button_simpan" aria-hidden="true"></i> <span name="text_button_submit"></span>', array('class' => 'btn btn-primary btn-sm pull-right  btn-submit', 'type' => 'button', 'id' => 'simpan' )) !!}
            </div>

            </form>
        </div>
    </div>
</div>




<script type="text/javascript">

	

	$('.modal-realisasi_rencana_aksi').on('shown.bs.modal', function(){
		$('#realisasi').focus();
		reset_submitx();
	});

	$('.modal-realisasi_rencana_aksi').on('hidden.bs.modal', function(){
		$('.realisasi,.satuan, .bukti ').removeClass('has-error');
		$('.modal-realisasi_rencana_aksi').find('[name=realisasi],[name=file_bukti]').val('');
	});



	$('.realisasi').on('click', function(){
		$('.realisasi').removeClass('has-error');
	});

	$('.satuan').on('click', function(){
		$('.satuan').removeClass('has-error');
	});

	$('.bukti').on('click', function(){
		$('.bukti').removeClass('has-error');
	});

	function on_submitx(){
		$('.modal-realisasi_rencana_aksi').find('.button_simpan').addClass('fa-spinner faa-spin animated');
		$('#submit-save').prop('disabled',true);
	}
	function reset_submitx(){
		$('.modal-realisasi_rencana_aksi').find('.button_simpan').removeClass('fa-spinner faa-spin animated');
		$('.modal-realisasi_rencana_aksi').find('.button_simpan').addClass('fa-floppy-o');
		$('#submit-save').prop('disabled',false);
	}

	$(document).on('click','#submit-save',function(e){

		on_submitx();
		var data = $('#realisasi_rencana_aksi_form').serialize();

		//alert(data);
		$.ajax({
			url		: '{{ url("api_resource/simpan_realisasi_rencana_aksi_3") }}',
			type	: 'POST',
			data	:  data,
			success	: function(data , textStatus, jqXHR) {
				
				//$('#program_table').DataTable().ajax.reload(null,false);
               
				reset_submitx();
				Swal.fire({
					title: "",
					text: "Sukses",
					type: "success",
					width: "200px", 
					showConfirmButton: false,
					allowOutsideClick : false,
					timer:1500
				}).then(function () {
					$('.modal-realisasi_rencana_aksi').modal('hide');
					$('#realisasi_kegiatan_bulanan_table').DataTable().ajax.reload(null,false);
					
					
					
				},
					
					function (dismiss) {
						if (dismiss === 'timer') {
							
						}
					}
			)	
			},
			error: function(jqXHR , textStatus, errorThrown) {

				var test = $.parseJSON(jqXHR.responseText);
				
				var data= test.errors;

				$.each(data, function(index,value){
					//alert (index+":"+value);
					
					//error message
					((index == 'realisasi')?$('.realisasi').addClass('has-error'):'');
					((index == 'satuan')?$('.satuan').addClass('has-error'):'');
					((index == 'bukti')?$('.bukti').addClass('has-error'):'');
					$('#realisasi').focus();
					reset_submitx();
					
				
				});

			
			}
			
		});





	});


	$(document).on('click','#submit-update',function(e){

		on_submitx();
		var data = $('#realisasi_rencana_aksi_form').serialize();

		//alert(data);
		$.ajax({
			url		: '{{ url("api_resource/update_realisasi_rencana_aksi_3") }}',
			type	: 'POST',
			data	:  data,
			success	: function(data , textStatus, jqXHR) {
				
				//$('#program_table').DataTable().ajax.reload(null,false);
			
				reset_submitx();
				Swal.fire({
					title: "",
					text: "Sukses",
					type: "success",
					width: "200px", 
					showConfirmButton: false,
					allowOutsideClick : false,
					timer:1500
				}).then(function () {
					$('.modal-realisasi_rencana_aksi').modal('hide');
					$('#realisasi_kegiatan_bulanan_table').DataTable().ajax.reload(null,false);
					
				},
					
					function (dismiss) {
						if (dismiss === 'timer') {
							
						}
					}
			)	
			},
			error: function(jqXHR , textStatus, errorThrown) {

				var test = $.parseJSON(jqXHR.responseText);
				
				var data= test.errors;

				$.each(data, function(index,value){
					//alert (index+":"+value);
					
					//error message
					((index == 'realisasi')?$('.realisasi').addClass('has-error'):'');
					((index == 'satuan')?$('.satuan').addClass('has-error'):'');
					((index == 'bukti')?$('.bukti').addClass('has-error'):'');
					$('#realisasi').focus();
					reset_submitx();

					
				
				});

			
			}
			
		});





		});










</script>