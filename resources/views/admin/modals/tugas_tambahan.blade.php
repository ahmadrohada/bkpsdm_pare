<div class="modal fade modal-tugas_tambahan" id="" role="dialog"  aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">
                                Tugas Tambahan
                            </h4>
                        </div>

                        <form  id="tugas_tambahan-form" method="POST" action="">


                        <div class="modal-body">

						<input type="text" name="capaian_tahunan_id" class="capaian_tahunan_id" value="{{ $capaian->id }}">
						<input type="text" name="tugas_tambahan_id" class="tugas_tambahan_id" >
						

                        <div class="form-group tugas_tambahan_label">
                            <label>Label</label>
                            <textarea class="form-control txt-tugas_tambahan" rows="2" name="label" placeholder="Tugas Tambahan" style="resize:none;"></textarea>
                        </div>


                        </div>
                        <div class="modal-footer">
                            {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_cancel_icon').'" aria-hidden="true"></i> ' . Lang::get('modals.confirm_modal_button_cancel_text'), array('class' => 'btn btn-sm btn-default pull-left btn-flat', 'type' => 'button', 'data-dismiss' => 'modal' )) !!}
                            {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_save_icon').'" aria-hidden="true"></i> ' . Lang::get('modals.confirm_modal_button_save_text'), array('class' => 'btn btn-sm btn-primary pull-right btn-flat btn-submit_tugas_tambahan', 'type' => 'button', 'id' => 'simpan_tugas_tambahan' )) !!}
                        </div>

                        </form>
                    </div>
                </div>
            </div>







<script type="text/javascript">
$(document).ready(function() {


	$('.modal-tugas_tambahan').on('hidden.bs.modal', function(){
		$('.txt-tugas_tambahan').val('');
		$('.tugas_tambahan_label').removeClass('has-error');
	});

 	$(document).on('click', '.txt-tugas_tambahan', function(){
		$('.tugas_tambahan_label').removeClass('has-error');
	});



    $(document).on('click', '#submit-save_tugas_tambahan', function(){
		
        var data = $('#tugas_tambahan-form').serialize();
		$.ajax({
			url		: '{{ url("api_resource/simpan_tugas_tambahan") }}',
			type	: 'POST',
			data	:  data,
			success	: function(data , textStatus, jqXHR) {
				
				$('#tugas_tambahan_table').DataTable().ajax.reload(null,false);
               
				Swal.fire({
					title: "",
					text: "Sukses",
					type: "success",
					width: "200px",
					showConfirmButton: false,
					allowOutsideClick : false,
					timer:1500
				}).then(function () {
					$('.modal-tugas_tambahan').modal('hide');
					
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
					
					if (index == 'label'){
						$('.tugas_tambahan_label').addClass('has-error');
					}

					
				
				});

			
			}
			
		  });
		
    });




});
</script>