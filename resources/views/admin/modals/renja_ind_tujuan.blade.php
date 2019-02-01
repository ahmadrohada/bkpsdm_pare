<div class="modal fade modal-ind_tujuan" id="createIndikatorTujuan" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Indikator Tujuan
                </h4>
            </div>

            <form  id="ind_tujuan_form" method="POST" action="">
			<input type="hidden"  name="tujuan_id" class="tujuan_id">
			<input type="hidden"  name="ind_tujuan_id" class="ind_tujuan_id">
			<div class="modal-body">
					
					<br>

					<div class="row">
						<div class="col-md-12 form-group label_ind_tujuan ">
							<label class="control-label">Label :</label>
							<textarea name="label_ind_tujuan" rows="3" required class="form-control label_ind_tujuan" id="label_ind_tujuan" style="resize:none;"></textarea>
						</div>
					</div>
					<br>
					<div class="row">
						
						<div class="col-md-4 form-group quantity_ind_tujuan">
						<label class="control-label">Output :</label>
						<input type="text" name="quantity_ind_tujuan" id="quantity_ind_tujuan" required class="form-control input-sm" placeholder="qty" onkeypress="return angka('event')">        
						</div>

						<div class="col-md-8 form-group satuan_ind_tujuan">
						<label class="control-label">Satuan :</label>
						<input type="text" name="satuan_ind_tujuan" autocomplete="off" id="_ind_tujuan" required class="form-control input-sm" placeholder="satuan">
						</div>
					</div>
			</div>
			<div class="modal-footer">
                {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_cancel_icon').'" aria-hidden="true"></i> Batal', array('class' => 'btn btn-sm btn-default pull-left btn-flat', 'type' => 'button', 'data-dismiss' => 'modal' )) !!}
                {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_save_icon').'" aria-hidden="true"></i> <span name="text_button_submit"></span>', array('class' => 'btn btn-primary btn-sm pull-right btn-flat btn-submit', 'type' => 'button', 'id' => 'simpan' )) !!}
            </div>

            </form>
        </div>
    </div>
</div>




<script type="text/javascript">

	$('.modal-ind_tujuan').on('shown.bs.modal', function(){
		
	});

	$('.modal-ind_tujuan').on('hidden.bs.modal', function(){
		$('.label_ind_tujuan, .quantity_ind_tujuan, .satuan_ind_tujuan').removeClass('has-error');
		$('.modal-ind_tujuan').find('[name=label_ind_tujuan],[name=quantity_ind_tujuan],[name=satuan_ind_tujuan]').val('');
	});

	$('.label_ind_tujuan').on('click', function(){
		$('.label_ind_tujuan').removeClass('has-error');
	});

	$('.quantity_ind_tujuan').on('click', function(){
		$('.quantity_ind_tujuan').removeClass('has-error');
	});

	$('.satuan_ind_tujuan').on('click', function(){
		$('.satuan_ind_tujuan').removeClass('has-error');
	});

	
	
	$(document).on('click','#submit-save-ind_tujuan',function(e){

		var data = $('#ind_tujuan_form').serialize();

		//alert(data);
		$.ajax({
			url		: '{{ url("api_resource/simpan_ind_tujuan") }}',
			type	: 'POST',
			data	:  data,
			success	: function(data , textStatus, jqXHR) {
				
				//$('#program_table').DataTable().ajax.reload(null,false);
               

				swal({
					title: "",
					text: "Sukses",
					type: "success",
					width: "200px", 
					showConfirmButton: false,
					allowOutsideClick : false,
					timer:1500
				}).then(function () {
					$('.modal-ind_tujuan').modal('hide');
					$('#ind_tujuan_table').DataTable().ajax.reload(null,false);
					jQuery('#renja').jstree(true).refresh(true);
					
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
					((index == 'label_ind_tujuan')?$('.label_ind_tujuan').addClass('has-error'):'');
					((index == 'quantity_ind_tujuan')?$('.quantity_ind_tujuan').addClass('has-error'):'');
					((index == 'satuan_ind_tujuan')?$('.satuan_ind_tujuan').addClass('has-error'):'');
				});

			
			}
			
		});





	});


	$(document).on('click','#submit-update-ind_tujuan',function(e){

		var data = $('#ind_tujuan_form').serialize();

		//alert(data);
		$.ajax({
			url		: '{{ url("api_resource/update_ind_tujuan") }}',
			type	: 'POST',
			data	:  data,
			success	: function(data , textStatus, jqXHR) {
				
				//$('#program_table').DataTable().ajax.reload(null,false);
			

				swal({
					title: "",
					text: "Sukses",
					type: "success",
					width: "200px", 
					showConfirmButton: false,
					allowOutsideClick : false,
					timer:1500
				}).then(function () {
					$('.modal-ind_tujuan').modal('hide');
					$('#ind_tujuan_table').DataTable().ajax.reload(null,false);
					jQuery('#renja').jstree(true).refresh(true);
					
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
					((index == 'label_ind_tujuan')?$('.label_ind_tujuan').addClass('has-error'):'');
					((index == 'quantity_ind_tujuan')?$('.quantity_ind_tujuan').addClass('has-error'):'');
					((index == 'satuan_ind_tujuan')?$('.satuan_ind_tujuan').addClass('has-error'):'');
				
				});

			
			}
			
		});
	});



</script>