<div class="modal fade create-program_modal" id="createProgram" role="dialog"  aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">
                                Create Program
                            </h4>
                        </div>

                        <form  id="create-program-form" method="POST" action="">


                        <div class="modal-body">
							
						
						
                        <input type="hidden" name="indikator_sasaran_id" class="form-control indikator_sasaran_id" required="">
						
						<div class="form-group">
                            <label>Sasaran</label>
							<p class="label-perjanjian_kinerja">
                            <span class="indikator_sasaran_label"></span>
							</p>
                        </div>

                        <div class="form-group program ">
                            <label>Program</label>
                            <textarea class="form-control" rows="2" name="label" placeholder="Program"></textarea>
                        </div>

                        </div>
                        <div class="modal-footer">
                            {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_cancel_icon').'" aria-hidden="true"></i> ' . Lang::get('modals.confirm_modal_button_cancel_text'), array('class' => 'btn btn-sm btn-default pull-left ', 'type' => 'button', 'data-dismiss' => 'modal' )) !!}
                            {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_save_icon').'" aria-hidden="true"></i> ' . Lang::get('modals.confirm_modal_button_save_text'), array('class' => 'btn btn-sm  btn-primary pull-right ', 'type' => 'button', 'id' => 'simpan_program' )) !!}
                        </div>

                        </form>
                    </div>
                </div>
            </div>







<script type="text/javascript">
$(document).ready(function() {

    			  
	$('#jabatan').select2();

	$('.create-program_modal').on('hidden.bs.modal', function(){
		//$(this).removeData();
		$('.program').removeClass('has-error');
	});

 	$(document).on('click', '.program', function(){
		$('.program').removeClass('has-error');
	});



    $(document).on('click', '#simpan_program', function(){
		
        var data = $('#create-program-form').serialize();
		$.ajax({
			url		: '{{ url("api_resource/skpd_simpan_program") }}',
			type	: 'POST',
			data	:  data,
			success	: function(data , textStatus, jqXHR) {
				
				$('#program_table').DataTable().ajax.reload(null,false);
               
				Swal.fire({
					title: "",
					text: "Sukses",
					type: "success",
					width: "200px", 
					showConfirmButton: false,
					allowOutsideClick : false,
					timer:1500
				}).then(function () {
					$('.create-program_modal').modal('hide');
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
						$('.program').addClass('has-error');
					}

					
				
				});

			
			}
			
		  });
		
    });




});
</script>