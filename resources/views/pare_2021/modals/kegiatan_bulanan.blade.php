<div class="modal fade modal-kegiatan_bulanan" id="createIndikatorProgram" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Kegiatan Bulanan
                </h4>
            </div>

            <form  id="kegiatan_bulanan_form" method="POST" action="">
			<input type="hidden"  name="kegiatan_bulanan_id" class="kegiatan_bulanan_id">
			<input type="hidden"  name="rencana_aksi_id" class="rencana_aksi_id">
			<input type="hidden"  name="rencana_aksi_label" class="rencana_aksi_label">
			<input type="hidden"  name="skp_bulanan_id" class="skp_bulanan_id">
			<div class="modal-body">
					
					<br>
					<div class="row">
						<div class="col-md-12 form-group label_kegiatan_tahunan">
							<strong>Kegiatan Tahunan : </strong>
							<p class="text-muted " style="margin-top:8px;padding-bottom:10px;">
								<span class="kegiatan_tahunan_label"></span>
							</p>

							
							<i class="fa fa-industry"></i> <span class="kegiatan_tahunan_output" style="margin-right:10px;"></span>
							<i class="fa fa-hourglass-start"></i> <span class="kegiatan_tahunan_waktu" style="margin-right:10px;"></span>
							<i class="fa fa-money"></i> <span class="kegiatan_tahunan_cost" style="margin-right:10px;"></span>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-12 form-group label_kegiatan ">
							<strong>Kegiatan Bulanan : </strong>
							<p class="text-muted " style="margin-top:8px;padding-bottom:10px;">
								<span class="rencana_aksi_label"></span>
							</p>
						</div>
					</div>
					
					<div class="row">
						
						<div class="col-md-6 form-group target">
						<label class="control-label">Output :</label>
						<input type="text" name="target" id="target" required class="form-control input-sm" placeholder="target" onkeypress='return angka(event)'>        
						</div>

						<div class="col-md-6 form-group satuan">
						<label class="control-label">Satuan :</label>
						<input type="text" name="satuan" autocomplete="off" id="satuan" required class="form-control satuan input-sm" placeholder="satuan">
						</div>
					</div>
					



			</div>
			<div class="modal-footer">
                {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_cancel_icon').'" aria-hidden="true"></i> Batal', array('class' => 'btn btn-sm btn-default pull-left ', 'type' => 'button', 'data-dismiss' => 'modal' )) !!}
                {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_save_icon').' button_simpan" aria-hidden="true"></i> <span name="text_button_submit"></span>', array('class' => 'btn btn-primary btn-sm pull-right  btn-submit', 'type' => 'button', 'id' => 'simpan' )) !!}
            </div>

            </form>
        </div>
    </div>
</div>




<script type="text/javascript">
 
	$('.modal-kegiatan_bulanan').on('shown.bs.modal', function(){
		reset_submitx();
	});

	$('.modal-kegiatan_bulanan').on('hidden.bs.modal', function(){
		$('.label_kegiatan, .target, .satuan, .waktu, .quality').removeClass('has-error');
		$('.modal-kegiatan_bulanan').find('[name=kegiatan_bulanan_id],[name=label],[name=angka_kredit],[name=target],[name=quality],[name=satuan],[name=target_waktu],[name=cost]').val('');
	});

	$('.label_kegiatan').on('click', function(){
		$('.label_kegiatan').removeClass('has-error');
	});

	$('.target').on('click', function(){
		$('.target').removeClass('has-error');
	});

	$('.satuan').on('click', function(){
		$('.satuan').removeClass('has-error');
	});

	$('.waktu').on('click', function(){
		$('.waktu').removeClass('has-error');
	});

	$('.quality').on('click', function(){
		$('.quality').removeClass('has-error');
	});

 
	function on_submit_kegiatan_bulanan(){
		$('.modal-kegiatan_bulanan').find('.button_simpan').addClass('fa-spinner faa-spin animated');
		$('#submit-save').prop('disabled',true);
	}
	function reset_submit_kegiatan_bulanan(){
		$('.modal-kegiatan_bulanan').find('.button_simpan').removeClass('fa-spinner faa-spin animated');
		$('.modal-kegiatan_bulanan').find('.button_simpan').addClass('fa-floppy-o');
		$('#submit-save').prop('disabled',false);
	}

	$(document).on('click','#submit-save',function(e){

		on_submit_kegiatan_bulanan();
		var data = $('#kegiatan_bulanan_form').serialize();

		//alert(data);
		$.ajax({
			url		: '{{ url("api/simpan_kegiatan_bulanan") }}',
			type	: 'POST',
			data	:  data,
			success	: function(data , textStatus, jqXHR) {
				
				//$('#program_table').DataTable().ajax.reload(null,false);
               
				reset_submit_kegiatan_bulanan();
				Swal.fire({
					title: "",
					text: "Sukses",
					type: "success",
					width: "200px", 
					showConfirmButton: false,
					allowOutsideClick : false,
					timer:1500
				}).then(function () {
					$('.modal-kegiatan_bulanan').modal('hide');
					$('#kegiatan_bulanan_table').DataTable().ajax.reload(null,false);
					$('#skp_bulanan_table').DataTable().ajax.reload(null,false);
					
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
					((index == 'label')?$('.label_kegiatan').addClass('has-error'):'');
					((index == 'target')?$('.target').addClass('has-error'):'');
					((index == 'satuan')?$('.satuan').addClass('has-error'):'');
					((index == 'quality')?$('.quality').addClass('has-error'):'');
					((index == 'target_waktu')?$('.waktu').addClass('has-error'):'');
					
					reset_submit_kegiatan_bulanan();
					
				
				});

			
			}
			
		});





	});


	$(document).on('click','#submit-update',function(e){

		on_submit_kegiatan_bulanan();
		var data = $('#kegiatan_bulanan_form').serialize();

		//alert(data);
		$.ajax({
			url		: '{{ url("api/update_kegiatan_bulanan") }}',
			type	: 'POST',
			data	:  data,
			success	: function(data , textStatus, jqXHR) {
				
				//$('#program_table').DataTable().ajax.reload(null,false);
			
				reset_submit_kegiatan_bulanan();
				Swal.fire({
					title: "",
					text: "Sukses",
					type: "success",
					width: "200px", 
					showConfirmButton: false,
					allowOutsideClick : false,
					timer:1500
				}).then(function () {
					$('.modal-kegiatan_bulanan').modal('hide');
					$('#kegiatan_bulanan_table').DataTable().ajax.reload(null,false);
					$('#skp_bulanan_table').DataTable().ajax.reload(null,false);
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
					((index == 'label')?$('.label_kegiatan').addClass('has-error'):'');
					((index == 'target')?$('.target').addClass('has-error'):'');
					((index == 'satuan')?$('.satuan').addClass('has-error'):'');
					((index == 'quality')?$('.quality').addClass('has-error'):'');
					((index == 'target_waktu')?$('.waktu').addClass('has-error'):'');
					reset_submit_kegiatan_bulanan();

					
				
				});

			
			}
			
		});





		});










</script>