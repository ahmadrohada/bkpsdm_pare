<div class="modal fade modal-sasaran" id="createSasaran" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Sasaran
                </h4>
            </div>

            <form  id="sasaran_form" method="POST" action="">
			<input type="hidden"  name="ind_tujuan_id" class="ind_tujuan_id">
			<input type="hidden"  name="sasaran_id" class="sasaran_id">
			<div class="modal-body">
					
					<br>

					<div class="row">
						<div class="col-md-12 form-group label_sasaran ">
							<label class="control-label">Label :</label>
							<textarea name="label_sasaran" rows="3" required class="form-control label_sasaran" id="label_sasaran" style="resize:none;"></textarea>
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

	$('.modal-sasaran').on('shown.bs.modal', function(){
		
	});

	$('.modal-sasaran').on('hidden.bs.modal', function(){
		$('.label_sasaran').removeClass('has-error');
		$('.modal-sasaran').find('[name=label_sasaran]').val('');
	});

	$('.label_sasaran').on('click', function(){
		$('.label_sasaran').removeClass('has-error');
	});


	
	$(document).on('click','#submit-save-sasaran',function(e){

		var data = $('#sasaran_form').serialize();

		//alert(data);
		$.ajax({
			url		: '{{ url("api_resource/simpan_sasaran") }}',
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
					$('.modal-sasaran').modal('hide');
					$('#sasaran_table').DataTable().ajax.reload(null,false);
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
					((index == 'label_sasaran')?$('.label_sasaran').addClass('has-error'):'');
				});

			
			}
			
		});





	});


	$(document).on('click','#submit-update-sasaran',function(e){

		var data = $('#sasaran_form').serialize();

		//alert(data);
		$.ajax({
			url		: '{{ url("api_resource/update_sasaran") }}',
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
					$('.modal-sasaran').modal('hide');
					$('#sasaran_table').DataTable().ajax.reload(null,false);
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
					((index == 'label_sasaran')?$('.label_sasaran').addClass('has-error'):'');
				
				});

			
			}
			
		});
	});



</script>