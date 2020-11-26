<div class="modal fade create-indikator_program_modal" id="createIndikatorProgram" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">
                        Create Indikator Program
                    </h4>
            </div>

            <form  id="create-indikator_program-form" method="POST" action="">

			<div class="modal-body">
				<input type="hidden" name="program_id" class="form-control program_id" required="">
						
				<div class="form-group">
                    <label>Program</label>
					<p class="label-perjanjian_kinerja"><span class="program_label"></span></p>
                </div>

                <div class="form-group indikator_program ">
                    <label>Indikator Program</label>
                    <textarea class="form-control" rows="2" name="label" placeholder="Indikator Program"></textarea>
                </div>




				<div class="row">
					<div class="col-md-6">
						<div class="form-group target">
							<label>Target</label>
							<input type="text" class="form-control" name="target" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group satuan">
							<label>Satuan</label>
							<input type="text" class="form-control" name="satuan" required>
						</div>
					</div>
				</div>


			</div>
			<div class="modal-footer">
                {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_cancel_icon').'" aria-hidden="true"></i> ' . Lang::get('modals.confirm_modal_button_cancel_text'), array('class' => 'btn btn-sm btn-default pull-left ', 'type' => 'button', 'data-dismiss' => 'modal' )) !!}
                {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_save_icon').'" aria-hidden="true"></i> ' . Lang::get('modals.confirm_modal_button_save_text'), array('class' => 'btn btn-primary btn-sm pull-right ', 'type' => 'button', 'id' => 'simpan_indikator_program' )) !!}
            </div>

            </form>
                    </div>
                </div>
            </div>







<script type="text/javascript">
$(document).ready(function() {

    
	$('.create-indikator_program_modal').on('hidden.bs.modal', function(){
		
		$('.indikator_program , .target, .satuan').removeClass('has-error');
	});

 	$(document).on('click', '.indikator_program', function(){
		$('.indikator_program').removeClass('has-error');
	});

	$(document).on('click', '.target', function(){
		$('.target').removeClass('has-error');
	});

	$(document).on('click', '.satuan', function(){
		$('.satuan').removeClass('has-error');
	});



    $(document).on('click', '#simpan_indikator_program', function(){
		
        var data = $('#create-indikator_program-form').serialize();
		$.ajax({
			url		: '{{ url("api_resource/skpd_simpan_indikator_program") }}',
			type	: 'POST',
			data	:  data,
			success	: function(data , textStatus, jqXHR) {
				
				$('#indikator_program_table').DataTable().ajax.reload(null,false);

				Swal.fire({
					title: "",
					text: "Sukses",
					type: "success",
					width: "200px",
					showConfirmButton: false,
					allowOutsideClick : false,
					timer: 1500
				}).then(function () {
						$('.create-indikator_program_modal').modal('hide');
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
						$('.indikator_program').addClass('has-error');
					}

					if (index == 'target'){
						$('.target').addClass('has-error');
					}

					if (index == 'satuan'){
						$('.satuan').addClass('has-error');
					}
				
				});
			}
			
		  });
		
    });

});
</script>