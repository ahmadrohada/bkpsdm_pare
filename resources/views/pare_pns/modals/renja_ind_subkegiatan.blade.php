<div class="modal fade modal-ind_subkegiatan" id="createIndikatorKegiatan" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Indikator Kegiatan
                </h4>
            </div>

            <form  id="ind_subkegiatan_form" method="POST" action="">
			<input type="hidden"  name="subkegiatan_id" class="subkegiatan_id">
			<input type="hidden"  name="ind_subkegiatan_id" class="ind_subkegiatan_id">
			<div class="modal-body">
					
					{{-- <strong>Kegiatan</strong>
					<p class="text-muted " style="margin-top:8px;padding-bottom:10px;">
						<span class="txt_subkegiatan_label"></span>
					</p>
					<br> --}}

					<div class="row">
						<div class="col-md-12 form-group label_ind_subkegiatan ">
							<label class="control-label">Indikator Sub Kegiatan :</label>
							<textarea name="label_ind_subkegiatan" rows="3" required class="form-control label_ind_subkegiatan" id="label_ind_subkegiatan" style="resize:none;"></textarea>
						</div>
					</div>
					<br>
					<div class="row">
						
						<div class="col-md-8 form-group target_ind_subkegiatan">
						<label class="control-label">Target :</label>
						<input type="text" name="target_ind_subkegiatan" id="target_ind_subkegiatan" onkeypress='return format_quantity(event)' required class="form-control input-sm" placeholder="">        
						</div>

						<div class="col-md-4 form-group satuan_ind_subkegiatan">
						<label class="control-label">Satuan :</label>
						<input type="text" name="satuan_ind_subkegiatan" autocomplete="off" id="_ind_subkegiatan" required class="form-control input-sm" placeholder="satuan">
						</div>
					</div>
			</div>
			<div class="modal-footer">
                {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_cancel_icon').'" aria-hidden="true"></i> Batal', array('class' => 'btn btn-sm btn-default pull-left ', 'type' => 'button', 'data-dismiss' => 'modal' )) !!}
                {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_save_icon').'" aria-hidden="true"></i> <span name="text_button_submit"></span>', array('class' => 'btn btn-primary btn-sm pull-right  btn-submit', 'type' => 'button', 'id' => 'simpan' )) !!}
            </div>

            </form>
        </div>
    </div>
</div>




<script type="text/javascript">

	$('.modal-ind_subkegiatan').on('shown.bs.modal', function(){
		$(this).find('.label_ind_subkegiatan').focus();
	});

	$('.modal-ind_subkegiatan').on('hidden.bs.modal', function(){
		$('.label_ind_subkegiatan, .target_ind_subkegiatan, .satuan_ind_subkegiatan').removeClass('has-error');
		$('.modal-ind_subkegiatan').find('[name=label_ind_subkegiatan],[name=target_ind_subkegiatan],[name=satuan_ind_subkegiatan]').val('');
	});

	$('.label_ind_subkegiatan').on('click', function(){
		$('.label_ind_subkegiatan').removeClass('has-error');
	});

	$('.target_ind_subkegiatan').on('click', function(){
		$('.target_ind_subkegiatan').removeClass('has-error');
	});

	$('.satuan_ind_subkegiatan').on('click', function(){
		$('.satuan_ind_subkegiatan').removeClass('has-error');
	});

	
	$(document).on('click','#submit-save-ind_subkegiatan',function(e){

		var data = $('#ind_subkegiatan_form').serialize();

		//alert(data);
		$.ajax({
			url		: '{{ url("api/simpan_ind_subkegiatan") }}',
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
					$('.modal-ind_subkegiatan').modal('hide');
					$('#ind_subkegiatan_table').DataTable().ajax.reload(null,false);
					//jQuery('#renja_tree_kegiatan').jstree(true).refresh(true);
					
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
					((index == 'label_ind_subkegiatan')?$('.label_ind_subkegiatan').addClass('has-error'):'');
					((index == 'target_ind_subkegiatan')?$('.target_ind_subkegiatan').addClass('has-error'):'');
					((index == 'satuan_ind_subkegiatan')?$('.satuan_ind_subkegiatan').addClass('has-error'):'');
				});

			
			}
			
		});





	});


	$(document).on('click','#submit-update-ind_subkegiatan',function(e){

		var data = $('#ind_subkegiatan_form').serialize();

		//alert(data);
		$.ajax({
			url		: '{{ url("api/update_ind_subkegiatan") }}',
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
					$('.modal-ind_subkegiatan').modal('hide');
					$('#ind_subkegiatan_table').DataTable().ajax.reload(null,false);
					//jQuery('#renja_tree_kegiatan').jstree(true).refresh(true);
					
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
					((index == 'label_ind_subkegiatan')?$('.label_ind_subkegiatan').addClass('has-error'):'');
					((index == 'target_ind_subkegiatan')?$('.target_ind_subkegiatan').addClass('has-error'):'');
					((index == 'satuan_ind_subkegiatan')?$('.satuan_ind_subkegiatan').addClass('has-error'):'');
				
				});

			
			}
			
		});
	});



</script>