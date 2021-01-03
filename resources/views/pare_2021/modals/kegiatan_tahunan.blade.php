<div class="modal fade modal-kegiatan_tahunan" id="createIndikatorProgram" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Kegiatan Tahunan 
                </h4>
            </div>

            <form  id="kegiatan_tahunan_form" method="POST" action="">
			<input type="hidden"  name="kegiatan_id" class="kegiatan_id">
			<input type="hidden"  name="kegiatan_tahunan_id" class="kegiatan_tahunan_id">
			<input type="hidden"  name="skp_tahunan_id" class="skp_tahunan_id" value="{{ $skp->id }}">
			<div class="modal-body">
					
					<br>

					<div class="row">
						<div class="col-md-12 form-group label_kegiatan ">
							<label class="control-label">Kegiatan :</label>
							<textarea name="label" rows="2" required class="form-control txt-label" id="label" style="resize:none;"></textarea>
						</div>
					</div>
					<div class="row" hidden>
						<div class="col-md-4 form-group ak_field">
						<label class="control-label">Angka Kredit :</label>
						<input type="text" name="angka_kredit" id="angka_kredit" required class="form-control input-sm" placeholder="AK" maxlength="6" onkeypress='return angka(event)'>
						</div>
					
						<div class="col-md-4 form-group target">
						<label class="control-label">Output :</label>
						<input type="text" name="target" id="target" required class="form-control input-sm" placeholder="target" onkeypress='return angka(event)'>        
						</div>

						<div class="col-md-4 form-group satuan">
						<label class="control-label">Satuan :</label>
						<input type="text" name="satuan" autocomplete="off" id="satuan" required class="form-control satuan input-sm" placeholder="satuan">
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 form-group quality">
						<label class="control-label">Kualitas/Mutu :</label>
						<div class="input-group input-group-sm">
						<input type="text" name="quality" id="quality" required class="form-control"  placeholder="kualitas/mutu" maxlength="3" onkeypress='return angka(event)'>
						<span class="input-group-addon">%</span>
						</div>
						</div>
						<div class="col-md-4 form-group waktu">
						<label class="control-label">Target Waktu :</label>
						<div class="input-group input-group-sm">
						<input type="text" name="target_waktu" id="target_waktu" required class="form-control" maxlength="2" onkeypress='return angka(event)'>
						<span class="input-group-addon">Bulan</span>
						</div>
						</div>
						<div class="col-md-4 form-group cost">
						<label class="control-label">Anggaran Kegiatan :</label>
						<div class="input-group input-group-sm">
						<span class="input-group-addon">Rp.</span>
						<input type="text" name="cost" id="cost" required class="form-control" placeholder="Anggaran kegiatan" maxlength="14" onkeypress='return angka(event)'>
						</div>
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

	$('.modal-kegiatan_tahunan').on('shown.bs.modal', function(){
		$('textarea:visible:first').focus();
		reset_submitx();
	});

	$('.modal-kegiatan_tahunan').on('hidden.bs.modal', function(){
		$('.label_kegiatan, .target, .satuan, .waktu, .quality').removeClass('has-error');
		$('.modal-kegiatan_tahunan').find('[name=kegiatan_tahunan_id],[name=label],[name=angka_kredit],[name=target],[name=quality],[name=satuan],[name=target_waktu],[name=cost]').val('');
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

 
	function on_submitx(){
		$('.modal-kegiatan_tahunan').find('.button_simpan').addClass('fa-spinner faa-spin animated');
		$('#submit-save').prop('disabled',true);
	}
	function reset_submitx(){
		$('.modal-kegiatan_tahunan').find('.button_simpan').removeClass('fa-spinner faa-spin animated');
		$('.modal-kegiatan_tahunan').find('.button_simpan').addClass('fa-floppy-o');
		$('#submit-save').prop('disabled',false);
	}

	$(document).on('click','#submit-save',function(e){
		show_loader();
		on_submitx();
		var data = $('#kegiatan_tahunan_form').serialize();

		//alert(data);
		$.ajax({
			url		: '{{ url("api/simpan_kegiatan_tahunan") }}',
			type	: 'POST',
			data	:  data,
			success	: function(data , textStatus, jqXHR) {
				
				//$('#program_table').DataTable().ajax.reload(null,false);
				swal.close();
				reset_submitx();
				Swal.fire({
					title: "",
					text: "Sukses",
					type: "success",
					width: "200px", 
					showConfirmButton: false,
					allowOutsideClick : false,
					timer:1500
				}).then(function () {
					$('.modal-kegiatan_tahunan').modal('hide');
					/* $('#kegiatan_tahunan_3_table').DataTable().ajax.reload(null,false);
					jQuery('#keg_tahunan_3_tree').jstree(true).refresh(true);
					$("#kegiatan_tahunan").show();
					$("#rencana_aksi").hide();
					jQuery('#keg_tahunan_3_tree').jstree().deselect_all(true); */
					$('#kegiatan_tahunan_3_table').DataTable().ajax.reload(null,false);
					jQuery('#kegiatan_tahunan_3').jstree(true).refresh(true);
					jQuery('#skp_bulanan_tree').jstree(true).refresh(true);

					
					
				},
					
					function (dismiss) {
						if (dismiss === 'timer') {
							
						}
					}
			)	
			},
			error: function(jqXHR , textStatus, errorThrown) {
				swal.close();
				var test = $.parseJSON(jqXHR.responseText);
				var data= test.errors;
				$.each(data, function(index,value){
					//error message
					((index == 'label')?$('.label_kegiatan').addClass('has-error'):'');
					((index == 'target')?$('.target').addClass('has-error'):'');
					((index == 'satuan')?$('.satuan').addClass('has-error'):'');
					((index == 'quality')?$('.quality').addClass('has-error'):'');
					((index == 'target_waktu')?$('.waktu').addClass('has-error'):'');
					reset_submitx();
				});

			
			}
			
		});





	});


	$(document).on('click','#submit-update',function(e){
		show_loader();
		on_submitx();
		var data = $('#kegiatan_tahunan_form').serialize();

		//alert(data);
		$.ajax({
			url		: '{{ url("api/update_kegiatan_tahunan") }}',
			type	: 'POST',
			data	:  data,
			success	: function(data , textStatus, jqXHR) {
				
				//$('#program_table').DataTable().ajax.reload(null,false);
				swal.close();
				reset_submitx();
				Swal.fire({
					title: "",
					text: "Sukses",
					type: "success",
					width: "200px", 
					showConfirmButton: false,
					allowOutsideClick : false,
					timer:1500
				}).then(function () {
					$('.modal-kegiatan_tahunan').modal('hide');
					$('#kegiatan_tahunan_3_table').DataTable().ajax.reload(null,false);
					jQuery('#kegiatan_tahunan_3').jstree(true).refresh(true);
					jQuery('#skp_bulanan_tree').jstree(true).refresh(true);
					
					
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
					reset_submitx();

					
				
				});

			
			}
			
		});





		});










</script>