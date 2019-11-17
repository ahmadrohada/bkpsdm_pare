<div class="modal fade modal-kegiatan_tahunan_jft" id="createIndikatorProgram" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Kegiatan Tahunan JFT 
                </h4>
            </div>

            <form  id="kegiatan_tahunan_form" method="POST" action="">
			<input type="hidden"  name="sasaran_id" class="sasaran_id">
			<input type="hidden"  name="skp_tahunan_id" value="{!! $skp->id !!}">
			<div class="modal-body">
					
					<br>
					<div class="row">
						<div class="col-md-12 form-group sasaran_label ">
							<label class="control-label">Sasaran :</label>
							<p name="sasaran_label">Label Sasaran</p>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12 form-group label_kegiatan_tahunan_jft ">
							<label class="control-label">Kegiatan SKP Tahunan:</label>
							<textarea name="label" rows="2" required class="form-control txt-label" id="label" style="resize:none;"></textarea>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 form-group angka_kredit">
						<label class="control-label">Angka Kredit :</label>
						<input type="text" name="angka_kredit" id="angka_kredit" required class="form-control input-sm" placeholder="AK" maxlength="5" onkeypress='return angka(event)'>
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
                {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_cancel_icon').'" aria-hidden="true"></i> Batal', array('class' => 'btn btn-sm btn-default pull-left btn-flat', 'type' => 'button', 'data-dismiss' => 'modal' )) !!}
                {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_save_icon').' button_simpan" aria-hidden="true"></i> <span name="text_button_submit"></span>', array('class' => 'btn btn-primary btn-sm pull-right btn-flat btn-submit', 'type' => 'button', 'id' => 'simpan' )) !!}
            </div>

            </form>
        </div>
    </div>
</div>




<script type="text/javascript">

	$('.modal-kegiatan_tahunan').on('shown.bs.modal', function(){
		reset_submitx();
	});

	/* $('.modal-kegiatan_tahunan').on('hidden.bs.modal', function(){
		$('.label_kegiatan, .target, .satuan, .waktu, .quality').removeClass('has-error');
		$('.modal-kegiatan_tahunan').find('[name=kegiatan_tahunan_id],[name=label],[name=angka_kredit],[name=target],[name=quality],[name=satuan],[name=target_waktu],[name=cost]').val('');
	}); */

	$('.label_kegiatan_tahunan_jft').on('click', function(){
		$('.label_kegiatan_tahunan_jft').removeClass('has-error');
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

	$('.angka_kredit').on('click', function(){
		$('.angka_kredit').removeClass('has-error');
	});

	$('.cost').on('click', function(){
		$('.cost').removeClass('has-error');
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

		on_submitx();
		var data = $('#kegiatan_tahunan_form').serialize();

		//alert(data);
		$.ajax({
			url		: '{{ url("api_resource/simpan_kegiatan_tahunan_jft") }}',
			type	: 'POST',
			data	:  data,
			success	: function(data , textStatus, jqXHR) {
				
				//$('#program_table').DataTable().ajax.reload(null,false);
               
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
					$('.modal-kegiatan_tahunan_jft').modal('hide');
					$('#kegiatan_tahunan_5_table').DataTable().ajax.reload(null,false);
					jQuery('#keg_tahunan_5_tree').jstree(true).refresh(true);
					jQuery('#keg_tahunan_5_tree').jstree().deselect_all(true);

					
					
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
					((index == 'label')?$('.label_kegiatan_tahunan_jft').addClass('has-error'):'');
					((index == 'target')?$('.target').addClass('has-error'):'');
					((index == 'satuan')?$('.satuan').addClass('has-error'):'');
					((index == 'quality')?$('.quality').addClass('has-error'):'');
					((index == 'target_waktu')?$('.waktu').addClass('has-error'):'');
					((index == 'angka_kredit')?$('.angka_kredit').addClass('has-error'):'');
					((index == 'cost')?$('.cost').addClass('has-error'):'');
					
					reset_submitx();
					
				
				});

			
			}
			
		});





	});


	$(document).on('click','#submit-update',function(e){

		on_submitx();
		var data = $('#kegiatan_tahunan_form').serialize();

		//alert(data);
		$.ajax({
			url		: '{{ url("api_resource/update_kegiatan_tahunan_jft") }}',
			type	: 'POST',
			data	:  data,
			success	: function(data , textStatus, jqXHR) {
				
				//$('#program_table').DataTable().ajax.reload(null,false);
			
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
					$('.modal-kegiatan_tahunan_jft').modal('hide');
					$('#kegiatan_tahunan_5_table').DataTable().ajax.reload(null,false);
					jQuery('#keg_tahunan_5_tree').jstree(true).refresh(true);
					
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
					((index == 'label')?$('.label_kegiatan_tahunan_jft').addClass('has-error'):'');
					((index == 'target')?$('.target').addClass('has-error'):'');
					((index == 'satuan')?$('.satuan').addClass('has-error'):'');
					((index == 'quality')?$('.quality').addClass('has-error'):'');
					((index == 'target_waktu')?$('.waktu').addClass('has-error'):'');
					((index == 'angka_kredit')?$('.angka_kredit').addClass('has-error'):'');
					((index == 'cost')?$('.cost').addClass('has-error'):'');
					reset_submitx();

					
				
				});

			
			}
			
		});





		});










</script>