<div class="modal fade create-indikator_sasaran_modal" id="createIndikatorSasaran" role="dialog"  aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">
                                Create Indikator Sasaran
                            </h4>
                        </div>

                        <form  id="create-indikator_sasaran-form" method="POST" action="">


                        <div class="modal-body">
							
						
						
                        <input type="hidden" name="sasaran_perjanjian_kinerja_id" class="form-control sasaran_perjanjian_kinerja_id" required="">
						
						<div class="form-group">
                            <label>Sasaran</label>
							<p class="label-perjanjian_kinerja">
                            <span class="sasaran_perjanjian_kinerja_label"></span>
							</p>
                        </div>

                        <div class="form-group indikator_sasaran ">
                            <label>Indikator Sasaran</label>
                            <textarea class="form-control" rows="2" name="label" placeholder="Indikator Sasaran"></textarea>
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
                            {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_save_icon').'" aria-hidden="true"></i> ' . Lang::get('modals.confirm_modal_button_save_text'), array('class' => 'btn btn-sm btn-primary pull-right ', 'type' => 'button', 'id' => 'simpan_indikator_sasaran' )) !!}
                        </div>

                        </form>
                    </div>
                </div>
            </div>







<script type="text/javascript">
$(document).ready(function() {

    
	$('.create-indikator_sasaran_modal').on('hidden.bs.modal', function(){
		//$(this).removeData();
		$('.indikator_sasaran , .target').removeClass('has-error');
	});

 	$(document).on('click', '.indikator_sasaran', function(){
		$('.indikator_sasaran').removeClass('has-error');
	});

	$(document).on('click', '.target', function(){
		$('.target').removeClass('has-error');
	});

	$(document).on('click', '.satuan', function(){
		$('.satuan').removeClass('has-error');
	});


    $(document).on('click', '#simpan_indikator_sasaran', function(){
		
        var data = $('#create-indikator_sasaran-form').serialize();
		$.ajax({
			url		: '{{ url("api_resource/skpd_simpan_indiator_sasaran") }}',
			type	: 'POST',
			data	:  data,
			success	: function(data , textStatus, jqXHR) {
				
				$('#indikator_sasaran_table').DataTable().ajax.reload(null,false);

				Swal.fire({
					title: "",
					text: "Sukses",
					type: "success",
					width: "200px",
					showConfirmButton: false,
					allowOutsideClick : false,
					timer: 1500
				}).then(function () {
					$('.create-indikator_sasaran_modal').modal('hide');
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
						$('.indikator_sasaran').addClass('has-error');
					}

					if (index == 'target'){
						$('.target').addClass('has-error');
					}
				
				});

				
			}
			
		  });
		
    });



	



});
</script>