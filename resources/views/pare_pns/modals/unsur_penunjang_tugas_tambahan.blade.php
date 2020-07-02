<div class="modal fade modal-unsur_penunjang_tugas_tambahan" id="" role="dialog"  aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">
                                Tugas Tambahan
                            </h4>
                        </div>

                        <form  id="unsur_penunjang_tugas_tambahan-form" method="POST" action="">


                        <div class="modal-body">

						<input type="hidden" name="capaian_tahunan_id" class="capaian_tahunan_id">
						<input type="hidden" name="unsur_penunjang_tugas_tambahan_id" class="unsur_penunjang_tugas_tambahan_id" >
						

                        <div class="form-group unsur_penunjang_tugas_tambahan_label">
                            <label>Label</label>
                            <textarea class="form-control txt-unsur_penunjang_tugas_tambahan" rows="2" name="label" placeholder="Tugas Tambahan" style="resize:none;"></textarea>
                        </div>


                        </div>
                        <div class="modal-footer">
                            {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_cancel_icon').'" aria-hidden="true"></i> ' . Lang::get('modals.confirm_modal_button_cancel_text'), array('class' => 'btn btn-sm btn-default pull-left ', 'type' => 'button', 'data-dismiss' => 'modal' )) !!}
                            {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_save_icon').' button_simpan" aria-hidden="true"></i> <span name="text_button_submit"></span>', array('class' => 'btn btn-sm btn-primary pull-right  btn-submit_unsur_penunjang_tugas_tambahan', 'type' => 'button', 'id' => 'simpan_unsur_penunjang_tugas_tambahan' )) !!}
                        </div>
						
                        </form>
                    </div>
                </div>
            </div>







<script type="text/javascript">
	$('.modal-unsur_penunjang_tugas_tambahan').on('shown.bs.modal', function(){
		$('textarea:visible:first').focus();
		reset_submit_tt();
	});

	$('.modal-unsur_penunjang_tugas_tambahan').on('hidden.bs.modal', function(){
		$('.txt-unsur_penunjang_tugas_tambahan').val('');
		$('.unsur_penunjang_tugas_tambahan_label').removeClass('has-error');
	});




 	$(document).on('click', '.txt-unsur_penunjang_tugas_tambahan', function(){
		$('.unsur_penunjang_tugas_tambahan_label').removeClass('has-error');
	});


	function on_submit_tt(){
		$('.modal-unsur_penunjang_tugas_tambahan').find('.button_simpan').addClass('fa-spinner faa-spin animated');
		$('#submit-save_unsur_penunjang_tugas_tambahan').prop('disabled',true);
		$('#submit-update_unsur_penunjang_tugas_tambahan').prop('disabled',true);
	}
	function reset_submit_tt(){
		$('.modal-unsur_penunjang_tugas_tambahan').find('.button_simpan').removeClass('fa-spinner faa-spin animated');
		$('.modal-unsur_penunjang_tugas_tambahan').find('.button_simpan').addClass('fa-floppy-o');
		$('#submit-save_unsur_penunjang_tugas_tambahan').prop('disabled',false);
		$('#submit-update_unsur_penunjang_tugas_tambahan').prop('disabled',false);
	}

    $(document).on('click', '#submit-save_unsur_penunjang_tugas_tambahan', function(){
		
		on_submit_tt()
        var data = $('#unsur_penunjang_tugas_tambahan-form').serialize();
		$.ajax({
			url		: '{{ url("api_resource/simpan_unsur_penunjang_tugas_tambahan") }}',
			type	: 'POST',
			data	:  data,
			success	: function(data , textStatus, jqXHR) {
				reset_submit_tt();
				$('#up_tugas_tambahan_table').DataTable().ajax.reload(null,false);
               
				Swal.fire({
					title: "",
					text: "Sukses",
					type: "success",
					width: "200px",
					showConfirmButton: false,
					allowOutsideClick : false,
					timer:1500
				}).then(function () {
					$('.modal-unsur_penunjang_tugas_tambahan').modal('hide');
					
				},
					
					function (dismiss) {
						if (dismiss === 'timer') {
							
						}
					}
			)	
			},
			error: function(jqXHR , textStatus, errorThrown) {
				reset_submit_tt();
				var test = $.parseJSON(jqXHR.responseText);
				
				var data= test.errors;

				$.each(data, function(index,value){
					//alert (index+":"+value);
					
					if (index == 'label'){
						$('.unsur_penunjang_tugas_tambahan_label').addClass('has-error');
					}

					
				
				});

			
			}
			
		  });
		
    });


	$(document).on('click', '#submit-update_unsur_penunjang_tugas_tambahan', function(){
		
		on_submit_tt()
        var data = $('#unsur_penunjang_tugas_tambahan-form').serialize();
		$.ajax({
			url		: '{{ url("api_resource/update_unsur_penunjang_tugas_tambahan") }}',
			type	: 'POST',
			data	:  data,
			success	: function(data , textStatus, jqXHR) {
				reset_submit_tt();
				$('#up_tugas_tambahan_table').DataTable().ajax.reload(null,false);
               
				Swal.fire({
					title: "",
					text: "Sukses",
					type: "success",
					width: "200px",
					showConfirmButton: false,
					allowOutsideClick : false,
					timer:1500
				}).then(function () {
					$('.modal-unsur_penunjang_tugas_tambahan').modal('hide');
					
				},
					
					function (dismiss) {
						if (dismiss === 'timer') {
							
						}
					}
			)	
			},
			error: function(jqXHR , textStatus, errorThrown) {
				reset_submit_tt();
				var test = $.parseJSON(jqXHR.responseText);
				
				var data= test.errors;

				$.each(data, function(index,value){
					//alert (index+":"+value);
					
					if (index == 'label'){
						$('.unsur_penunjang_tugas_tambahan_label').addClass('has-error');
					}

					
				
				});

			
			}
			
		  });
		
    });
</script>