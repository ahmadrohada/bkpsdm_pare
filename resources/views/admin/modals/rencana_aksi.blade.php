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
							<select class="form-control select2 target_pelaksanaan" name="target_pelaksanaan" style="width: 100%;">
								<option value="01">Januari</option>
								<option value="02">Februari</option>
								<option value="03">Maret</option>
								<option value="04">April</option>
								<option value="05">Mei</option>
								<option value="06">Juni</option>
								<option value="07">Juli</option>
								<option value="08">Agustus</option>
								<option value="09">September</option>
								<option value="10">Oktober</option>
								<option value="11">November</option>
								<option value="12">Desember</option>

							</select>
						</div>
					</div>



			</div>
			<div class="modal-footer">
                {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_cancel_icon').'" aria-hidden="true"></i> Batal', array('class' => 'btn btn-sm btn-default pull-left btn-flat', 'type' => 'button', 'data-dismiss' => 'modal' )) !!}
				{!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_save_icon').' button_simpan" aria-hidden="true"></i> <span name="text_button_submit"></span>', array('class' => 'btn btn-primary btn-sm pull-right btn-flat btn-submit', 'type' => 'button', 'id' => 'simpan_ra' )) !!}
				
            </div>

            </form>
        </div>
    </div>
</div>



<script type="text/javascript">


	$('.select2').select2()

	$('.modal-rencana_aksi').on('shown.bs.modal', function(){
		reset_submit();
	});

	$('.modal-rencana_aksi').on('hidden.bs.modal', function(){
		$('.label_rencana_aksi').removeClass('has-error');
		$('.label_target_pelaksanaan').removeClass('has-error');
		$('.modal-rencana_aksi').find('[name=rencana_aksi_id],[name=label]').val('');
	});

	$('.label_rencana_aksi').on('click', function(){
		$('.label_rencana_aksi').removeClass('has-error');
	});

	$('.label_target_pelaksanaan').on('click', function(){
		$('.label_target_pelaksanaan').removeClass('has-error');
	});

	
	function on_submit(){
		$('.modal-rencana_aksi').find('.button_simpan').addClass('fa-spinner faa-spin animated');
		$('#submit-save_rencana_aksi').prop('disabled',true);
	}
	function reset_submit(){
		$('.modal-rencana_aksi').find('.button_simpan').removeClass('fa-spinner faa-spin animated');
		$('.modal-rencana_aksi').find('.button_simpan').addClass('fa-floppy-o');
		$('#submit-save_rencana_aksi').prop('disabled',false);
	}
	
	$(document).on('click','#submit-save_rencana_aksi',function(e){
		
		on_submit();
		var data = $('#rencana_aksi_form').serialize();
 
		//alert(data);
		$.ajax({
			url		: '{{ url("api_resource/simpan_rencana_aksi") }}',
			type	: 'POST',
			data	:  data,
			success	: function(data , textStatus, jqXHR) {
				
				//$('#program_table').DataTable().ajax.reload(null,false);
               
				reset_submit();
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
				$("#submit-save_rencana_aksi").show();
			},
			error: function(jqXHR , textStatus, errorThrown) {

				var test = $.parseJSON(jqXHR.responseText);
				
				var data= test.errors;

				$.each(data, function(index,value){
					//alert (index+":"+value);
					
					//error message
					((index == 'label')?$('.label_rencana_aksi').addClass('has-error'):'');
					((index == 'target_pelaksanaan')?$('.label_target_pelaksanaan').addClass('has-error'):'');
					reset_submit();
				
					
				
				});
				
			
			}
			
		});


	});


	$(document).on('click','#submit-update_rencana_aksi',function(e){

		on_submit();
		var data = $('#rencana_aksi_form').serialize();

		//alert(data);
		$.ajax({
			url		: '{{ url("api_resource/update_rencana_aksi") }}',
			type	: 'POST',
			data	:  data,
			success	: function(data , textStatus, jqXHR) {
				
				//$('#program_table').DataTable().ajax.reload(null,false);
			
				reset_submit();
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
					reset_submit();

					
				
				});

			
			}
			
		});





		});










</script>