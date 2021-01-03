<div class="modal fade modal-program" id="createprogram" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Program
                </h4>
            </div>

            <form  id="program_form" method="POST" action="">
			<input type="hidden"  name="sasaran_id" class="sasaran_id">
			<input type="hidden"  name="program_id" class="program_id">
			<div class="modal-body">
					
					<br>

					<div class="row">
						<div class="col-md-12 form-group label_program ">
							<label class="control-label">Label :</label>
							<textarea name="label_program" rows="3" required class="form-control label_program" id="label_program" style="resize:none;"></textarea>
						</div>
					</div>
					<br>
					
			</div>
			<div class="modal-footer">
                {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_cancel_icon').'" aria-hidden="true"></i> Batal', array('class' => 'btn btn-sm btn-default pull-left ', 'type' => 'button', 'data-dismiss' => 'modal' )) !!}
                {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_save_icon').'" aria-hidden="true"></i> <span name="text_button_submit"></span>', array('class' => 'btn btn-primary btn-sm pull-right  btn-submit', 'type' => 'button', 'id' => 'simpan' )) !!}
            </div>

            </form>
        </div>
    </div>
</div>




<script type="text/javascript">

	$('.modal-program').on('shown.bs.modal', function(){
		
	});

	$('.modal-program').on('hidden.bs.modal', function(){
		$('.label_program').removeClass('has-error');
		$('.modal-program').find('[name=label_program]').val('');
	});

	$('.label_program').on('click', function(){
		$('.label_program').removeClass('has-error');
	});


	
	$(document).on('click','#submit-save-program',function(e){

		var data = $('#program_form').serialize();

		//alert(data);
		$.ajax({
			url		: '{{ url("api/simpan_program") }}',
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
					$('.modal-program').modal('hide');
					$('#program_table').DataTable().ajax.reload(null,false);
					jQuery('#renja_tree_kegiatan').jstree(true).refresh(true);
					
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
					((index == 'label_program')?$('.label_program').addClass('has-error'):'');
				});

			
			}
			
		});





	});


	$(document).on('click','#submit-update-program',function(e){

		var data = $('#program_form').serialize();

		//alert(data);
		$.ajax({
			url		: '{{ url("api/update_program") }}',
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
					$('.modal-program').modal('hide');
					$('#program_table').DataTable().ajax.reload(null,false);
					jQuery('#renja_tree_kegiatan').jstree(true).refresh(true);
					
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
					((index == 'label_program')?$('.label_program').addClass('has-error'):'');
				
				});

			
			}
			
		});
	});



</script>