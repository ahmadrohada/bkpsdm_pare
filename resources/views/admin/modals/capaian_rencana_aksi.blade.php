<div class="modal fade modal-capaian_rencana_aksi" id="" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Capaian Rencana Aksi
                </h4>
            </div>

            <form  id="capaian_rencana_aksi_form" method="POST" action="">
			<input type="hidden"  name="rencana_aksi_id" class="rencana_aksi_id">
			<input type="hidden"  name="skp_bulanan_id" class="skp_bulanan_id">
			<input type="hidden"  name="capaian_id" class="capaian_id">
			<input type="hidden"  name="capaian_rencana_aksi_id" class="capaian_rencana_aksi_id">
			<input type="hidden"  name="satuan" class="satuan">
			<div class="modal-body">
					
					<br>
					<div class="row">
						<div class="col-md-12 form-group label_kegiatan_tahunan">
							<strong>Kegiatan Tahunan  </strong>
							<p class="text-info " style="margin-top:8px;">
								<span class="kegiatan_tahunan_label"></span>
							</p>
							<p>
								<i class="fa fa-user"></i> <span class="penanggung_jawab" style="margin-right:10px;"></span>
							</p>

							
							<i class="fa fa-industry" ></i> <span class="kegiatan_tahunan_output" style="margin-right:10px;"></span>
							<i class="fa fa-hourglass-start"></i> <span class="kegiatan_tahunan_waktu" style="margin-right:10px;"></span>
							<i class="fa fa-money"></i> <span class="kegiatan_tahunan_cost" style="margin-right:10px;"></span>
							<br>
							

						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-12 form-group label_kegiatan ">
							<strong>Kegiatan Bulanan  </strong>
							<p class="text-muted " style="margin-top:8px;">
								<span class="kegiatan_bulanan_label"></span>
							</p>
							<p>
								<i class="fa fa-user"></i> <span class="pelaksana" style="margin-right:10px;"></span>
							</p>

							<i class="fa fa-industry"></i> 
								Target : <span class="kegiatan_bulanan_output" style="margin-right:10px;"></span>
								Capaian : <span class="capaian_kegiatan_bulanan_output" style="margin-right:10px;"></span>
						</div>
					</div>
					<hr>
					<div class="row">
						
						<div class="col-md-6 form-group capaian_target" style="margin-top:8px;">	
							<label class="control-label">Capaian </label>
							<div class="input-group">
								<input type="text" name="capaian_target" id="capaian_target" required class="form-control input-sm" placeholder="capaian target">
								<div class="input-group-addon">
									<span class="kegiatan_bulanan_satuan"></span>
								</div>
							</div>

							<input type="hidden"  name="alasan_tidak_tercapai" class="alasan_tidak_tercapai">
						</div>

						<div class="col-md-6 form-group bukti" style="margin-top:8px;">
							<div class="form-group">
								<label for="file_bukti">Bukti</label>
								<input type="file" id="file_bukti" name="file_bukti">
								<p class="help-block">Unggah Dokumen sebagai bukti kegiatan</p>
							</div>
						</div>
				
						

					</div>
					



			</div>
			<div class="modal-footer">
                {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_cancel_icon').'" aria-hidden="true"></i> Batal', array('class' => 'btn btn-sm btn-default pull-left btn-flat', 'type' => 'button', 'data-dismiss' => 'modal' )) !!}
                {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_save_icon').' button_simpan" aria-hidden="true"></i> <span name="text_button_submit"></span>', array('class' => 'btn btn-primary btn-sm pull-right btn-flat btn-submit', 'type' => 'button', 'id' => 'simpan' )) !!}
            </div>

            </form>
        </div>
    </div>
</div>




<script type="text/javascript">

	$('.modal-capaian_rencana_aksi').on('shown.bs.modal', function(){
		reset_submitx();
	});

	$('.modal-capaian_rencana_aksi').on('hidden.bs.modal', function(){
		$('.capaian_target, .bukti ').removeClass('has-error');
		$('.modal-capaian_rencana_aksi').find('[name=capaian_target],[name=file_bukti]').val('');
	});



	$('.capaian_target').on('click', function(){
		$('.capaian_target').removeClass('has-error');
	});

	$('.bukti').on('click', function(){
		$('.bukti').removeClass('has-error');
	});

	function on_submitx(){
		$('.modal-capaian_rencana_aksi').find('.button_simpan').addClass('fa-spinner faa-spin animated');
		$('#submit-save').prop('disabled',true);
	}
	function reset_submitx(){
		$('.modal-capaian_rencana_aksi').find('.button_simpan').removeClass('fa-spinner faa-spin animated');
		$('.modal-capaian_rencana_aksi').find('.button_simpan').addClass('fa-floppy-o');
		$('#submit-save').prop('disabled',false);
	}

	$(document).on('click','#submit-save',function(e){

		on_submitx();
		var data = $('#capaian_rencana_aksi_form').serialize();

		//alert(data);
		$.ajax({
			url		: '{{ url("api_resource/simpan_capaian_rencana_aksi") }}',
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
					$('.modal-capaian_rencana_aksi').modal('hide');
					$('#capaian_kegiatan_bulanan_table').DataTable().ajax.reload(null,false);
					
					
					
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
					((index == 'capaian_target')?$('.capaian_target').addClass('has-error'):'');
					((index == 'bukti')?$('.bukti').addClass('has-error'):'');
					
					reset_submitx();
					
				
				});

			
			}
			
		});





	});


	$(document).on('click','#submit-update',function(e){

		on_submitx();
		var data = $('#capaian_rencana_aksi_form').serialize();

		//alert(data);
		$.ajax({
			url		: '{{ url("api_resource/update_capaian_rencana_aksi") }}',
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
					$('.modal-capaian_rencana_aksi').modal('hide');
					$('#capaian_rencana_aksi_table').DataTable().ajax.reload(null,false);
					
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
					((index == 'capaian_target')?$('.capaian_target').addClass('has-error'):'');
					((index == 'bukti')?$('.bukti').addClass('has-error'):'');
					reset_submitx();

					
				
				});

			
			}
			
		});





		});










</script>