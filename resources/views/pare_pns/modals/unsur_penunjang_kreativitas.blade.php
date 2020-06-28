<div class="modal fade modal-unsur_penunjang_kreativitas" id="" role="dialog"  aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">
                                Create Kegiatan
                            </h4>
                        </div>

                        <form  id="unsur_penunjang_kreativitas-form" method="POST" action="">


                        <div class="modal-body">
						<input type="hidden" name="capaian_tahunan_id" class="capaian_tahunan_id">
						<input type="hidden" name="unsur_penunjang_kreativitas_id" class="unsur_penunjang_kreativitas_id" >
						
						<div class="form-group unsur_penunjang_kreativitas_label">
                            <label>Label</label>
                            <textarea class="form-control txt-unsur_penunjang_kreativitas" rows="2" name="label" placeholder="Kreativitas" style="resize:none;"></textarea>
                        </div>


						<div class="form-group manfaat ">
                            <label>Manfaat Kreativitas</label>
							<select class="form-control input-sm" id="manfaat" name="manfaat_id" style="width:100%">
								<option value="1">Untuk Unit Kerja</option>
								<option value="2">Untuk Organisasi</option>
								<option value="3">Untuk Pemerintah</option>
							</select>
							
                        </div>

                        
                        </div>
						<div class="modal-footer">
                            {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_cancel_icon').'" aria-hidden="true"></i> ' . Lang::get('modals.confirm_modal_button_cancel_text'), array('class' => 'btn btn-sm btn-default pull-left ', 'type' => 'button', 'data-dismiss' => 'modal' )) !!}
                            {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_save_icon').' button_simpan" aria-hidden="true"></i> <span name="text_button_submit"></span>', array('class' => 'btn btn-sm btn-primary pull-right  btn-submit_unsur_penunjang_kreativitas', 'type' => 'button', 'id' => 'simpan_unsur_penunjang_kreativitas' )) !!}
                        </div>

                        </form>
                    </div>
                </div>
            </div>







<script type="text/javascript">
	$('#manfaat').select2({
        allowClear: true,
        

    });

	$('.modal-unsur_penunjang_kreativitas').on('shown.bs.modal', function(){
		$('textarea:visible:first').focus();
		reset_submitx();
	});

	$('.modal-unsur_penunjang_kreativitas').on('hidden.bs.modal', function(){
		$('.txt-unsur_penunjang_kreativitas').val('');
		$('#manfaat').select2('val', '1');
		$('.unsur_penunjang_kreativitas_label').removeClass('has-error');
	});




 	$(document).on('click', '.txt-unsur_penunjang_kreativitas', function(){
		$('.unsur_penunjang_kreativitas_label').removeClass('has-error');
	});


	function on_submitx(){
		$('.modal-unsur_penunjang_kreativitas').find('.button_simpan').addClass('fa-spinner faa-spin animated');
		$('#submit-save_unsur_penunjang_kreativitas').prop('disabled',true);
		$('#submit-update_unsur_penunjang_kreativitas').prop('disabled',true);
	}
	function reset_submitx(){
		$('.modal-unsur_penunjang_kreativitas').find('.button_simpan').removeClass('fa-spinner faa-spin animated');
		$('.modal-unsur_penunjang_kreativitas').find('.button_simpan').addClass('fa-floppy-o');
		$('#submit-save_unsur_penunjang_kreativitas').prop('disabled',false);
		$('#submit-update_unsur_penunjang_kreativitas').prop('disabled',false);
	}

    $(document).on('click', '#submit-save_unsur_penunjang_kreativitas', function(){
		
		on_submitx()
        var data = $('#unsur_penunjang_kreativitas-form').serialize();
		$.ajax({
			url		: '{{ url("api_resource/simpan_unsur_penunjang_kreativitas") }}',
			type	: 'POST',
			data	:  data,
			success	: function(data , textStatus, jqXHR) {
				reset_submitx();
				$('#up_kreativitas_table').DataTable().ajax.reload(null,false);
               
				Swal.fire({
					title: "",
					text: "Sukses",
					type: "success",
					width: "200px",
					showConfirmButton: false,
					allowOutsideClick : false,
					timer:1500
				}).then(function () {
					$('.modal-unsur_penunjang_kreativitas').modal('hide');
					
				},
					
					function (dismiss) {
						if (dismiss === 'timer') {
							
						}
					}
			)	
			},
			error: function(jqXHR , textStatus, errorThrown) {
				reset_submitx();
				var test = $.parseJSON(jqXHR.responseText);
				
				var data= test.errors;

				$.each(data, function(index,value){
					//alert (index+":"+value);
					
					if (index == 'label'){
						$('.unsur_penunjang_kreativitas_label').addClass('has-error');
					}

					
				
				});

			
			}
			
		  });
		
    });


	$(document).on('click', '#submit-update_unsur_penunjang_kreativitas', function(){
		
		on_submitx()
        var data = $('#unsur_penunjang_kreativitas-form').serialize();
		$.ajax({
			url		: '{{ url("api_resource/update_unsur_penunjang_kreativitas") }}',
			type	: 'POST',
			data	:  data,
			success	: function(data , textStatus, jqXHR) {
				reset_submitx();
				$('#up_kreativitas_table').DataTable().ajax.reload(null,false);
               
				Swal.fire({
					title: "",
					text: "Sukses",
					type: "success",
					width: "200px",
					showConfirmButton: false,
					allowOutsideClick : false,
					timer:1500
				}).then(function () {
					$('.modal-unsur_penunjang_kreativitas').modal('hide');
					
				},
					
					function (dismiss) {
						if (dismiss === 'timer') {
							
						}
					}
			)	
			},
			error: function(jqXHR , textStatus, errorThrown) {
				reset_submitx();
				var test = $.parseJSON(jqXHR.responseText);
				
				var data= test.errors;

				$.each(data, function(index,value){
					//alert (index+":"+value);
					
					if (index == 'label'){
						$('.unsur_penunjang_kreativitas_label').addClass('has-error');
					}

					
				
				});

			
			}
			
		  });
		
    });
</script>