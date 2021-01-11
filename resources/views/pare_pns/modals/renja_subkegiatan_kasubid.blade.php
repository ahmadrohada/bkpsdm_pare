<div class="modal fade modal-subkegiatan_kasubid" id="createkegiatan" role="dialog"  aria-hidden="true">
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
						<div class="col-md-12 form-group label_subkegiatan ">
							<label class="control-label">Label :</label>
							<textarea name="label_subkegiatan" rows="3" required class="form-control label_subkegiatan" id="label_subkegiatan" style="resize:none;"></textarea>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12 form-group cost_ind_subkegiatan ">
						<label class="control-label">Anggaran :</label>
						<input type="text" name="cost_subkegiatan" autocomplete="off" id="cost_subkegiatan" required class="form-control input-sm" placeholder="cost">
						</div>
					</div>

					
					<br>
					
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

	$('.modal-kegiatan_kasubid').on('shown.bs.modal', function(){
		
	});

	$('.modal-kegiatan_kasubid').on('hidden.bs.modal', function(){
		$('.label_subkegiatan_kasubid').removeClass('has-error');
		$('.modal-kegiatan_kasubid').find('[name=label_subkegiatan],[name=label_ind_subkegiatan],[name=target_subkegiatan],[name=satuan_subkegiatan],[name=cost_subkegiatan]').val('');
	});

	$('.label_subkegiatan_kasubid').on('click', function(){
		$('.label_subkegiatan').removeClass('has-error');
	});
	$('.label_ind_subkegiatan_kasubid').on('click', function(){
		$('.label_ind_subkegiatan').removeClass('has-error');
	});

	$('.target_subkegiatan_kasubid').on('click', function(){
		$('.target_subkegiatan').removeClass('has-error');
	});

	$('.satuan_subkegiatan_kasubid').on('click', function(){
		$('.satuan_subkegiatan').removeClass('has-error');
	});


	$(document).on('click','#submit-update-kegiatan_kasubid',function(e){

		var data = $('#kegiatan_kasubid_form').serialize();

		//alert(data);
		$.ajax({
			url		: '{{ url("api/update_subkegiatan") }}',
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
					timer:200
				}).then(function () {
					$('.modal-kegiatan_kasubid').modal('hide');
					$('#kegiatan_kasubid_table').DataTable().ajax.reload(null,false);
					jQuery('#ditribusi_renja').jstree(true).refresh(true);
					
				},
					
					function (dismiss) {
						if (dismiss === 'timer') {
							$('.modal-kegiatan_kasubid').modal('hide');
							$('#kegiatan_kasubid_table').DataTable().ajax.reload(null,false);
							jQuery('#ditribusi_renja').jstree(true).refresh(true);
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
					((index == 'label_subkegiatan')?$('.label_subkegiatan').addClass('has-error'):'');
					((index == 'label_ind_subkegiatan')?$('.label_ind_subkegiatan').addClass('has-error'):'');
					//((index == 'target_subkegiatan')?$('.target_subkegiatan').addClass('has-error'):'');
					//((index == 'satuan_subkegiatan')?$('.satuan_subkegiatan').addClass('has-error'):'');
				
				});

			
			}
			
		});
	});



</script>