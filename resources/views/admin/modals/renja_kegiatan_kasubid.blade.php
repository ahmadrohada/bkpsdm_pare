<div class="modal fade modal-kegiatan_kasubid" id="createkegiatan" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    kegiatan
                </h4>
            </div>

            <form  id="kegiatan_kasubid_form" method="POST" action="">
			<input type="hidden"  name="kegiatan_id" class="kegiatan_id">
			<input type="hidden"  name="renja_id" class="renja_id" value="{!! $renja->id !!}">
			<div class="modal-body">
					
					<br>

					<div class="row">
						<div class="col-md-12 form-group label_kegiatan ">
							<label class="control-label">Label :</label>
							<textarea name="label_kegiatan" rows="3" required class="form-control label_kegiatan" id="label_kegiatan" style="resize:none;"></textarea>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12 form-group cost_ind_kegiatan ">
						<label class="control-label">Anggaran :</label>
						<input type="text" name="cost_kegiatan" autocomplete="off" id="cost_kegiatan" required class="form-control input-sm" placeholder="cost">
						</div>
					</div>

					
					<br>
					
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

	$('.modal-kegiatan_kasubid').on('shown.bs.modal', function(){
		
	});

	$('.modal-kegiatan_kasubid').on('hidden.bs.modal', function(){
		$('.label_kegiatan_kasubid').removeClass('has-error');
		$('.modal-kegiatan_kasubid').find('[name=label_kegiatan],[name=label_ind_kegiatan],[name=target_kegiatan],[name=satuan_kegiatan],[name=cost_kegiatan]').val('');
	});

	$('.label_kegiatan_kasubid').on('click', function(){
		$('.label_kegiatan').removeClass('has-error');
	});
	$('.label_ind_kegiatan_kasubid').on('click', function(){
		$('.label_ind_kegiatan').removeClass('has-error');
	});

	$('.target_kegiatan_kasubid').on('click', function(){
		$('.target_kegiatan').removeClass('has-error');
	});

	$('.satuan_kegiatan_kasubid').on('click', function(){
		$('.satuan_kegiatan').removeClass('has-error');
	});


	$(document).on('click','#submit-update-kegiatan_kasubid',function(e){

		var data = $('#kegiatan_kasubid_form').serialize();

		//alert(data);
		$.ajax({
			url		: '{{ url("api_resource/update_kegiatan") }}',
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
					$('.modal-kegiatan_kasubid').modal('hide');
					$('#kegiatan_kasubid_table').DataTable().ajax.reload(null,false);
					jQuery('#ditribusi_renja').jstree(true).refresh(true);
					
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
					((index == 'label_kegiatan')?$('.label_kegiatan').addClass('has-error'):'');
					((index == 'label_ind_kegiatan')?$('.label_ind_kegiatan').addClass('has-error'):'');
					//((index == 'target_kegiatan')?$('.target_kegiatan').addClass('has-error'):'');
					//((index == 'satuan_kegiatan')?$('.satuan_kegiatan').addClass('has-error'):'');
				
				});

			
			}
			
		});
	});



</script>