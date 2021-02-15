<div class="modal fade modal-indikator_kegiatan_skp_tahunan" id="createIndikatorKegiatan" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">
                        Create Indikator Kegiatan
                    </h4>
            </div>

            <form  id="indikator_kegiatan_skpd_tahunan-form" method="POST" action="">

			<div class="modal-body">
				<input type="text" name="ind_kegiatan_skp_tahunan_id" class="form-control ind_kegiatan_skp_tahunan_id" required="">
						

                <div class="form-group indikator_kegiatan_skpd_tahunan ">
                    <label>Indikator Kegiatan SKP</label>
                    <textarea class="form-control" rows="2" name="label" placeholder="Indikator Kegiatan"></textarea>
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
                {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_save_icon').' button_simpan" aria-hidden="true"></i> ' . Lang::get('modals.confirm_modal_button_save_text'), array('class' => 'btn btn-sm btn-primary pull-right btn-submit', 'type' => 'button', 'id' => 'update_indikator_kegiatan_skp_tahunan' )) !!}
            </div>

            </form>
                    </div>
                </div>
            </div>







<script type="text/javascript">
$(document).ready(function() {

    
	$('.modal-indikator_kegiatan_skp_tahunan').on('hidden.bs.modal', function(){
		//$(this).removeData();
		$('.ind_kegiatan_tahunan_id ,.label .target, .satuan').removeClass('has-error');
	});

	$(document).on('click', '.label', function(){
		$('.label').removeClass('has-error');
	});

	$(document).on('click', '.target', function(){
		$('.target').removeClass('has-error');
	});

	$(document).on('click', '.satuan', function(){
		$('.satuan').removeClass('has-error');
	});



    $(document).on('click', '#update_indikator_kegiatan_skp_tahunan', function(){
		
        var data = $('#indikator_kegiatan_skpd_tahunan-form').serialize();
		$.ajax({
			url		: '{{ url("api/update_indikator_kegiatan_skp_tahunan") }}',
			type	: 'POST',
			data	:  data,
			success	: function(data , textStatus, jqXHR) {
				
				$('#kegiatan_skp_tahunan_3_table').DataTable().ajax.reload(null,false);

				Swal.fire({
					title: "",
					text: "Sukses",
					type: "success",
					width: "200px",
					showConfirmButton: false,
					allowOutsideClick : false,
					timer: 1500
				}).then(function () {
					$('.modal-indikator_kegiatan_skp_tahunan').modal('hide');
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
						$('.label').addClass('has-error');
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