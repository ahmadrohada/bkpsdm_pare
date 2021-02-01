<div class="modal fade modal-subkegiatan" id="createsubkegiatan" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                   Sub kegiatan
                </h4>
            </div>

            <form  id="subkegiatan_form" method="POST" action="">
			<input type="hidden"  name="kegiatan_id" class="kegiatan_id">
			<input type="hidden"  name="subkegiatan_id" class="subkegiatan_id">
			<input type="hidden"  name="renja_id" class="renja_id" value="{!! $renja->id !!}">
			<div class="modal-body">
					

					<div class="row">
						<div class="col-md-12 form-group label_subkegiatan">
							<label class="control-label">Sub Kegiatan :</label>
							<textarea name="label_subkegiatan" rows="2" required class="form-control label_subkegiatan" id="label_kegiatan" style="resize:none;"></textarea>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12 form-group cost_subkegiatan">
							<label class="control-label">Anggaran :</label>
							<input type="text" name="cost_subkegiatan" autocomplete="off" id="cost_subkegiatan" required class="form-control input-sm" placeholder="cost">
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

	/*  /* Tanpa Rupiah */
	var tanpa_rupiah = document.getElementById('cost_subkegiatan');
	tanpa_rupiah.addEventListener('keyup', function(e)
	{
        tanpa_rupiah.value = formatRupiah(this.value);
        
	}); 

	$('.modal-subkegiatan').on('shown.bs.modal', function(){
		$(this).find('.label_subkegiatan').focus();
	});

	$('.modal-subkegiatan').on('hidden.bs.modal', function(){
		$('.label_subkegiatan,.cost_subkegiatan').removeClass('has-error');
		$('.modal-subkegiatan').find('[name=label_subkegiatan],[name=cost_subkegiatan]').val('');
	});

	$('.label_subkegiatan').on('click', function(){
		$('.label_subkegiatan').removeClass('has-error');
	});
	
	/* $('.cost_subkegiatan').on('click', function(){
		$('.cost_subkegiatan').removeClass('has-error');
	}); */



	
	$(document).on('click','#submit-save-subkegiatan',function(e){

		var data = $('#subkegiatan_form').serialize();

		//alert(data);
		$.ajax({
			url		: '{{ url("api/simpan_subkegiatan") }}',
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
					$('.modal-subkegiatan').modal('hide'); 
					$('#subkegiatan_table').DataTable().ajax.reload(null,false);
					$('#subkegiatan_table_non_anggaran').DataTable().ajax.reload(null,false);
					jQuery('#renja_tree_kegiatan').jstree(true).refresh(true);
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
					((index == 'label_subkegiatan')?$('.label_subkegiatan').addClass('has-error'):'');
					//((index == 'cost_subkegiatan')?$('.cost_subkegiatan').addClass('has-error'):'');
				});

			
			}
			
		});





	});


	$(document).on('click','#submit-update-subkegiatan',function(e){

		var data = $('#subkegiatan_form').serialize();

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
					timer:1500
				}).then(function () {
					$('.modal-subkegiatan').modal('hide');
					$('#subkegiatan_table').DataTable().ajax.reload(null,false);
					$('#subkegiatan_table_non_anggaran').DataTable().ajax.reload(null,false);
					jQuery('#renja_tree_kegiatan').jstree(true).refresh(true);
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
					((index == 'label_subkegiatan')?$('.label_subkegiatan').addClass('has-error'):'');
				
				});

			
			}
			
		});
	});



</script>