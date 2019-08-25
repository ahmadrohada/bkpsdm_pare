<div class="modal fade modal-realisasi_triwulan" id="" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
					Add Realisasi Kegiatan Tahunan Trimester
                </h4>
            </div>

            <form  id="realisasi_triwulan_form" method="POST" action="">
			<input type="hidden"  name="kegiatan_tahunan_id" class="kegiatan_tahunan_id">
			<input type="hidden"  name="capaian_triwulan_id" class="capaian_triwulan_id">
			<input type="hidden"  name="realisasi_triwulan_id" class="realisasi_triwulan_id">
			<input type="hidden"  name="satuan" class="satuan">
			

			
			<div class="modal-body">
					
					<div class="row">
						<div class="col-md-12 form-group label_kegiatan_tahunan">
							<strong>Kegiatan Tahunan  </strong>
							<p class="text-info " style="margin-top:8px;">
								<span class="kegiatan_tahunan_label"></span>
							</p>
							<p>
								<i class="fa fa-user"></i> <span class="penanggung_jawab" style="margin-right:10px;"></span>
							</p>

							
						</div>
					</div>
					<br>
					
					<div class="row"> 
						<div class="col-md-12 form-group label_kegiatan_tahunan">
							<strong>Capaian Kegiatan Tahunan  Trimester I</strong>
						</div>
						<div class="col-md-6 col-xs-12 form-group">	
							<label class="control-label">Qty Target </label>
							<div class="input-group">
							<span type="text" class="form-control input-sm qty_target"></span>
								<div class="input-group-addon">
									<span class="qty_satuan"></span>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-xs-12 form-group quantity">	
							<label class="control-label">Qty Realisasi </label>
							<div class="input-group">
								<input type="text" name="qty_realisasi" id="qty_realisasi" required class="form-control input-sm qty_realisasi" placeholder="realisasi">
								<div class="input-group-addon">
									<span class="qty_satuan"></span>
								</div>
							</div>
						</div>

						

					</div>
					<div class="row"> 
						<div class="col-md-6 col-xs-12 form-group">	
							<label class="control-label">Cost Target </label>
							<span type="text" class="form-control input-sm cost_target"></span>
						</div>
						<div class="col-md-6 col-xs-12 form-group cost">	
							<label class="control-label">Cost Realisasi </label>
							<input type="text" name="cost_realisasi" id="cost_realisasi" required class="form-control input-sm cost_realisasi" placeholder="cost realisasi">
							
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

	$('.modal-realisasi_triwulan').on('shown.bs.modal', function(){
		$('#qty_realisasi').focus();
		reset_submitx();
	});

	$('.modal-realisasi_triwulan').on('hidden.bs.modal', function(){
		$('.quantity,.cost').removeClass('has-error');
		$('.modal-realisasi_triwulan').find('[name=qty_realisasi],[name=cost_realisasi]').val('');
	});



	$('.qty_realisasi').on('click', function(){
		$('.quantity').removeClass('has-error');
	});

	$('.cost_realisasi').on('click', function(){
		$('.cost').removeClass('has-error');
	});


	function on_submitx(){
		$('.modal-realisasi_triwulan').find('.button_simpan').addClass('fa-spinner faa-spin animated');
		$('#submit-save').prop('disabled',true);
	}
	function reset_submitx(){
		$('.modal-realisasi_triwulan').find('.button_simpan').removeClass('fa-spinner faa-spin animated');
		$('.modal-realisasi_triwulan').find('.button_simpan').addClass('fa-floppy-o');
		$('#submit-save').prop('disabled',false);
	}

	$(document).on('click','#submit-save',function(e){

		on_submitx();
		var data = $('#realisasi_triwulan_form').serialize();

		//alert(data);
		$.ajax({
			url		: '{{ url("api_resource/simpan_realisasi_kegiatan_triwulan") }}',
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
					$('.modal-realisasi_triwulan').modal('hide');
					$('#realisasi_kegiatan_triwulan_table').DataTable().ajax.reload(null,false);
					
					
					
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
					((index == 'qty_realisasi')?$('.quantity').addClass('has-error'):'');
					((index == 'cost_realisasi')?$('.cost').addClass('has-error'):'');
					
					reset_submitx();
					
				
				});

			
			}
			
		});





	});


	$(document).on('click','#submit-update',function(e){

		on_submitx();
		var data = $('#realisasi_triwulan_form').serialize();

		//alert(data);
		$.ajax({
			url		: '{{ url("api_resource/update_realisasi_kegiatan_triwulan") }}',
			type	: 'POST',
			data	:  data,
			success	: function(data , textStatus, jqXHR) {
				
			
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
					$('.modal-realisasi_triwulan').modal('hide');
					$('#realisasi_kegiatan_triwulan_table').DataTable().ajax.reload(null,false);
					
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
					reset_submitx();

					
				
				});

			
			}
			
		});





		});










</script>