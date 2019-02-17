<div class="modal fade modal-ind_program" id="createIndprogram" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Indikator Program
                </h4>
            </div>

            <form  id="ind_program_form" method="POST" action="">
			<input type="hidden"  name="program_id" class="program_id">
			<input type="hidden"  name="ind_program_id" class="ind_program_id">
			<div class="modal-body">
					
					<br>

					<div class="row">
						<div class="col-md-12 form-group label_ind_program ">
							<label class="control-label">Label :</label>
							<textarea name="label_ind_program" rows="3" required class="form-control label_ind_program" id="label_ind_program" style="resize:none;"></textarea>
						</div>
					</div>
					<div class="row">
						
						<div class="col-md-4 form-group target_ind_program">
						<label class="control-label">Target :</label>
						<input type="text" name="target_ind_program" id="target_ind_program" required class="form-control input-sm" placeholder="target">        
						</div>

						<div class="col-md-8 form-group satuan_ind_program">
						<label class="control-label">Satuan :</label>
						<input type="text" name="satuan_ind_program" autocomplete="off" id="_ind_program" required class="form-control input-sm" placeholder="satuan">
						</div>
					</div>
					<br>
					
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

	$('.modal-ind_program').on('shown.bs.modal', function(){
		
	});

	$('.modal-ind_program').on('hidden.bs.modal', function(){
		$('.label_ind_program,.target_ind_program,.satuan_ind_program').removeClass('has-error');
		$('.modal-ind_program').find('[name=label_ind_program],[name=target_ind_program],[name=satuan_ind_program]').val('');
	});

	$('.label_ind_program').on('click', function(){
		$('.label_ind_program').removeClass('has-error');
	});

	$('.target_ind_program').on('click', function(){
		$('.target_ind_program').removeClass('has-error');
	});

	$('.satuan_ind_program').on('click', function(){
		$('.satuan_ind_program').removeClass('has-error');
	});


	
	$(document).on('click','#submit-save-ind_program',function(e){

		var data = $('#ind_program_form').serialize();

		//alert(data);
		$.ajax({
			url		: '{{ url("api_resource/simpan_ind_program") }}',
			type	: 'POST',
			data	:  data,
			success	: function(data , textStatus, jqXHR) {
				
				//$('#program_table').DataTable().ajax.reload(null,false);
               

				Swal.fire({
					title: "",
					text: "Sukses",
					type: "success",
					width: "200px", 
					showConfirmButton: false,
					allowOutsideClick : false,
					timer:1500
				}).then(function () {
					$('.modal-ind_program').modal('hide');
					$('#ind_program_table').DataTable().ajax.reload(null,false);
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
					((index == 'label_ind_program')?$('.label_ind_program').addClass('has-error'):'');
					((index == 'target_ind_program')?$('.target_ind_program').addClass('has-error'):'');
					((index == 'satuan_ind_program')?$('.satuan_ind_program').addClass('has-error'):'');
				});

			
			}
			
		});





	});


	$(document).on('click','#submit-update-ind_program',function(e){

		var data = $('#ind_program_form').serialize();

		//alert(data);
		$.ajax({
			url		: '{{ url("api_resource/update_ind_program") }}',
			type	: 'POST',
			data	:  data,
			success	: function(data , textStatus, jqXHR) {
				
				//$('#program_table').DataTable().ajax.reload(null,false);
			

				Swal.fire({
					title: "",
					text: "Sukses",
					type: "success",
					width: "200px", 
					showConfirmButton: false,
					allowOutsideClick : false,
					timer:1500
				}).then(function () {
					$('.modal-ind_program').modal('hide');
					$('#ind_program_table').DataTable().ajax.reload(null,false);
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
					((index == 'label_ind_program')?$('.label_ind_program').addClass('has-error'):'');
					((index == 'target_ind_program')?$('.target_ind_program').addClass('has-error'):'');
					((index == 'satuan_ind_program')?$('.satuan_ind_program').addClass('has-error'):'');
				
				});

			
			}
			
		});
	});



</script>