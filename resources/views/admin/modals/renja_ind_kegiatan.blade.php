<div class="modal fade modal-ind_kegiatan" id="createIndikatorKegiatan" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Indikator Kegiatan
                </h4>
            </div>

            <form  id="ind_kegiatan_form" method="POST" action="">
			<input type="hidden"  name="kegiatan_id" class="kegiatan_id">
			<input type="hidden"  name="ind_kegiatan_id" class="ind_kegiatan_id">
			<div class="modal-body">
					
					<strong>Kegiatan</strong>
					<p class="text-muted " style="margin-top:8px;padding-bottom:10px;">
						<span class="txt_kegiatan_label"></span>
					</p>
					<br>

					<div class="row">
						<div class="col-md-12 form-group label_ind_kegiatan ">
							<label class="control-label">Indikator Kegiatan :</label>
							<textarea name="label_ind_kegiatan" rows="3" required class="form-control label_ind_kegiatan" id="label_ind_kegiatan" style="resize:none;"></textarea>
						</div>
					</div>
					<br>
					<div class="row">
						
						<div class="col-md-8 form-group target_ind_kegiatan">
						<label class="control-label">Target :</label>
						<input type="text" name="target_ind_kegiatan" id="target_ind_kegiatan" required class="form-control input-sm" placeholder="target">        
						</div>

						<div class="col-md-4 form-group satuan_ind_kegiatan">
						<label class="control-label">Satuan :</label>
						<input type="text" name="satuan_ind_kegiatan" autocomplete="off" id="_ind_kegiatan" required class="form-control input-sm" placeholder="satuan">
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

	$('.modal-ind_kegiatan').on('shown.bs.modal', function(){
		
	});

	$('.modal-ind_kegiatan').on('hidden.bs.modal', function(){
		$('.label_ind_kegiatan, .target_ind_kegiatan, .satuan_ind_kegiatan').removeClass('has-error');
		$('.modal-ind_kegiatan').find('[name=label_ind_kegiatan],[name=target_ind_kegiatan],[name=satuan_ind_kegiatan]').val('');
	});

	$('.label_ind_kegiatan').on('click', function(){
		$('.label_ind_kegiatan').removeClass('has-error');
	});

	$('.target_ind_kegiatan').on('click', function(){
		$('.target_ind_kegiatan').removeClass('has-error');
	});

	$('.satuan_ind_kegiatan').on('click', function(){
		$('.satuan_ind_kegiatan').removeClass('has-error');
	});

	
	$(document).on('click','#submit-save-ind_kegiatan',function(e){

		var data = $('#ind_kegiatan_form').serialize();

		//alert(data);
		$.ajax({
			url		: '{{ url("api_resource/simpan_ind_kegiatan") }}',
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
					$('.modal-ind_kegiatan').modal('hide');
					$('#ind_kegiatan_table').DataTable().ajax.reload(null,false);
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
					((index == 'label_ind_kegiatan')?$('.label_ind_kegiatan').addClass('has-error'):'');
					((index == 'target_ind_kegiatan')?$('.target_ind_kegiatan').addClass('has-error'):'');
					((index == 'satuan_ind_kegiatan')?$('.satuan_ind_kegiatan').addClass('has-error'):'');
				});

			
			}
			
		});





	});


	$(document).on('click','#submit-update-ind_kegiatan',function(e){

		var data = $('#ind_kegiatan_form').serialize();

		//alert(data);
		$.ajax({
			url		: '{{ url("api_resource/update_ind_kegiatan") }}',
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
					$('.modal-ind_kegiatan').modal('hide');
					$('#ind_kegiatan_table').DataTable().ajax.reload(null,false);
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
					((index == 'label_ind_kegiatan')?$('.label_ind_kegiatan').addClass('has-error'):'');
					((index == 'target_ind_kegiatan')?$('.target_ind_kegiatan').addClass('has-error'):'');
					((index == 'satuan_ind_kegiatan')?$('.satuan_ind_kegiatan').addClass('has-error'):'');
				
				});

			
			}
			
		});
	});



</script>