<div class="modal fade modal-realisasi_tahunan" id="" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
					Add Realisasi Kegiatan Tahunan
                </h4>
            </div>

            <form  id="realisasi_tahunan_form" method="POST" action="">

			<input type="hidden"  name="capaian_triwulan_id">
			<input type="hidden"  name="ind_kegiatan_id">
			<input type="hidden"  name="kegiatan_tahunan_id">
			<input type="hidden"  name="realisasi_indikator_kegiatan_triwulan_id">
			<input type="hidden"  name="realisasi_kegiatan_triwulan_id">
			<input type="hidden"  name="jumlah_indikator">
			<input type="hidden"  name="satuan">

			<input type="hidden"  name="target_quantity">
			<input type="hidden"  name="target_quality">
			<input type="hidden"  name="target_waktu">
			<input type="hidden"  name="target_cost">
			

			
			<div class="modal-body">
					
					<div class="row">
						<div class="col-md-12 form-group label_kegiatan_tahunan">
							<strong>Kegiatan Tahunan  </strong>
							<p class="text-info " style="margin-top:1px;">
								<span class="kegiatan_tahunan_label"></span>
							</p>
						</div>
						<div class="col-md-12 form-group label_kegiatan_tahunan" style="margin-top:-10px !important;">
							<strong>Indikator </strong>
							<p class="text-info " style="margin-top:1px;">
								<span class="indikator_label"></span>
							</p>
						</div>
					</div>

					<div class="row" style="margin-top:10px;"> 
						<div class="col-md-6 col-xs-6 form-group">	
							<label class="control-label">Target Quantity </label>
							<div class="input-group">
							<span type="text" class="form-control input-sm target_quantity"></span>
								<div class="input-group-addon">
									<span class="satuan"></span>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-xs-6 form-group quantity">	
							<label class="control-label">Realisasi Quantity</label>
							<div class="input-group">
								<input type="text" name="realisasi_quantity" required class="form-control input-sm realisasi_quantity" placeholder="realisasi">
								<div class="input-group-addon">
									<span class="satuan"></span>
								</div>
							</div>
						</div>
					</div>

					<div class="row" style="margin-top:-20px;" hidden> 
						<div class="col-md-6 col-xs-6 form-group">	
							<label class="control-label">Target Quality </label>
							<div class="input-group">
							<span type="text" class="form-control input-sm target_quality"></span>
								<div class="input-group-addon">
									<span class="">%</span>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-xs-6 form-group quality">	
							<label class="control-label">Realisasi Quality</label>
							<div class="input-group">
								<input type="text" name="realisasi_quality"  required class="form-control input-sm realisasi_quality" placeholder="realisasi">
								<div class="input-group-addon">
									<span class="">%</span>
								</div>
							</div>
						</div>
					</div>

					<div class="row" style="margin-top:-20px;"> 

						<div class="col-md-6 col-xs-6 form-group">
							<label class="control-label">Target Cost </label>
							<div class="input-group">
								<div class="input-group-addon">
									<span class="">Rp.</span>
								</div>
								<span type="text" class="form-control input-sm target_cost"></span>
							</div>
						</div>
						<div class="col-md-6 col-xs-6 form-group cost cost">	
							<label class="control-label">Realisasi Cost  </label>
							<div class="input-group">
								<div class="input-group-addon">
									<span class="">Rp.</span>
								</div>
								<input type="text" name="realisasi_cost"  required class="form-control input-sm realisasi_cost" placeholder="cost realisasi">
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

	$('.modal-realisasi_tahunan').on('shown.bs.modal', function(){
		
		$('#qty_realisasi').focus();
		reset_submitx();
	});

	$('.modal-realisasi_tahunan').on('hidden.bs.modal', function(){
		$('.quantity,.cost').removeClass('has-error');
		$('.modal-realisasi_tahunan').find('[name=realisasi_quantity],[name=realisasi_quality],[name=realisasi_cost]').val('');
	});



	$('.realisasi_quantity').on('click', function(){
		$('.quantity').removeClass('has-error');
	});

	$('.realisasi_quality').on('click', function(){
		$('.quality').removeClass('has-error');
	});



	$('.realisasi_cost').on('click', function(){
		$('.cost').removeClass('has-error');
	});


	function on_submitx(){
		$('.modal-realisasi_tahunan').find('.button_simpan').addClass('fa-spinner faa-spin animated');
		$('#submit-save').prop('disabled',true);
	}
	function reset_submitx(){
		$('.modal-realisasi_tahunan').find('.button_simpan').removeClass('fa-spinner faa-spin animated');
		$('.modal-realisasi_tahunan').find('.button_simpan').addClass('fa-floppy-o');
		$('#submit-save').prop('disabled',false);
	}

	$(document).on('click','#submit-save',function(e){

		on_submitx();
		var data = $('#realisasi_tahunan_form').serialize();

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
					$('.modal-realisasi_tahunan').modal('hide');
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
					((index == 'realisasi_quantity')?$('.quantity').addClass('has-error'):'');
					((index == 'realisasi_cost')?$('.cost').addClass('has-error'):'');
					
					reset_submitx();
					
				
				});

			
			}
			
		});





	});


	$(document).on('click','#submit-update',function(e){

		on_submitx();
		var data = $('#realisasi_tahunan_form').serialize();

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
					$('.modal-realisasi_tahunan').modal('hide');
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
					((index == 'realisasi_quantity')?$('.quantity').addClass('has-error'):'');
					((index == 'realisasi_cost')?$('.cost').addClass('has-error'):'');
					reset_submitx();

					
				
				});

			
			}
			
		});





		});










</script>