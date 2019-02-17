<div class="modal fade modal-rencana_aksi" id="createIndikatorProgram" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Rencana Aksi
                </h4>
            </div>

            <form  id="rencana_aksi_form" method="POST" action="">
			<input type="hidden" required name="kegiatan_tahunan_id" class="kegiatan_tahunan_id">
			<input type="hidden" required name="rencana_aksi_id" class="rencana_aksi_id">
			<div class="modal-body">
					
					<br>

					<div class="row">
						<div class="col-md-12 form-group label_rencana_aksi ">
							<label class="control-label">Rencana Aksi :</label>
							<textarea name="label" rows="3" required class="form-control txt-label" id="label" placeholder="" style="resize:none;"></textarea>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 form-group form-group-sm label_target_pelaksanaan">
							<label>Target Pelaksanaan</label>
							<input type="text" class="form-control tgl_tp" name="target_pelaksanaan" placeholder="Palaksanaan"/>
						</div>
					</div>



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

	$('.modal-rencana_aksi').on('shown.bs.modal', function(){
		
	});

	$('.modal-rencana_aksi').on('hidden.bs.modal', function(){
		$('.label_rencana_aksi').removeClass('has-error');
		$('.label_target_pelaksanaan').removeClass('has-error');
		$('.modal-rencana_aksi').find('[name=rencana_aksi_id],[name=label],[name=target_pelaksanaan]').val('');
	});

	$('.label_rencana_aksi').on('click', function(){
		$('.label_rencana_aksi').removeClass('has-error');
	});

	$('.label_target_pelaksanaan').on('click', function(){
		$('.label_target_pelaksanaan').removeClass('has-error');
	});

	
	
	
	$(document).on('click','#submit-save_rencana_aksi',function(e){

		var data = $('#rencana_aksi_form').serialize();

		//alert(data);
		$.ajax({
			url		: '{{ url("api_resource/simpan_rencana_aksi") }}',
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
					$('.modal-rencana_aksi').modal('hide');
					$('#rencana_aksi_table').DataTable().ajax.reload(null,false);
					jQuery('#ktj').jstree(true).refresh(true);
					
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
					((index == 'label')?$('.label_rencana_aksi').addClass('has-error'):'');
					((index == 'target_pelaksanaan')?$('.label_target_pelaksanaan').addClass('has-error'):'');
					

					
				
				});

			
			}
			
		});





	});


	$(document).on('click','#submit-update_rencana_aksi',function(e){

		var data = $('#rencana_aksi_form').serialize();

		//alert(data);
		$.ajax({
			url		: '{{ url("api_resource/update_rencana_aksi") }}',
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
					$('.modal-rencana_aksi').modal('hide');
					$('#rencana_aksi_table').DataTable().ajax.reload(null,false);
					jQuery('#ktj').jstree(true).refresh(true);
					
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
					((index == 'label')?$('.label_rencana_aksi').addClass('has-error'):'');
					((index == 'target_pelaksanaan')?$('.label_target_pelaksanaan').addClass('has-error'):'');
					

					
				
				});

			
			}
			
		});





		});










</script>