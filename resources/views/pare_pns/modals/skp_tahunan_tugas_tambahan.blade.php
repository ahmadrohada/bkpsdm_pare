<div class="modal fade modal-tugas_tambahan" id="createIndikatorProgram" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Tugas Tambahan 
                </h4>
            </div> 

            <form  id="tugas_tambahan_form" method="POST" action="">
			<input type="hidden"  name="skp_tahunan_id" value="{!! $skp->id !!}">
			<input type="hidden"  name="tugas_tambahan_id" value="">
			
 			<div class="modal-body">
					<div class="row">
						<div class="col-md-12 form-group label_tugas_tambahan ">
							<label class="control-label">Tugas Tambahan Label:</label>
							<textarea name="label" rows="2" required class="form-control txt-label" id="label" style="resize:none;"></textarea>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 form-group angka_kredit">
						<label class="control-label">Angka Kredit :</label>
						<input type="text" name="angka_kredit" id="angka_kredit" required class="form-control input-sm" placeholder="AK" maxlength="6" onkeypress='return angka(event)'>
						</div>
					
						<div class="col-md-4 form-group target">
						<label class="control-label">Target Output :</label>
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
						<input type="text" name="quality" id="quality" required class="form-control"  value="100" placeholder="kualitas/mutu" maxlength="3" onkeypress='return angka(event)'>
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
						<input type="text" name="cost" id="cost_tugas_tambahan" required class="form-control" placeholder="Anggaran kegiatan" maxlength="14" readonly>
						</div>
						</div>
					</div>
		
			</div>
			<div class="modal-footer">
                {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_cancel_icon').'" aria-hidden="true"></i> Batal', array('class' => 'btn btn-sm btn-default pull-left ', 'type' => 'button', 'data-dismiss' => 'modal' )) !!}
                {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_save_icon').' button_simpan" aria-hidden="true"></i> <span name="text_button_submit"></span>', array('class' => 'btn btn-primary btn-sm pull-right  btn-submit btn-submit_tugas_tambahan', 'type' => 'button', 'id' => 'submit-save_tugas_tambahan' )) !!}
            </div>

            </form>
        </div>
    </div>
</div>




<script type="text/javascript">

	var tanpa_rupiah = document.getElementById('cost_tugas_tambahan');
	tanpa_rupiah.addEventListener('keyup', function(e)
	{
        tanpa_rupiah.value = formatRupiah(this.value);
        
	}); 

	$('.modal-tugas_tambahan').on('shown.bs.modal', function(){
		
		reset_submitx();
	});


	$('.modal-tugas_tambahan').on('hide.bs.modal', function(){
		
		$('.label_tugas_tambahan,.target,.satuan,.waktu,.quality').removeClass('has-error');
	});


	/* $('.modal-kegiatan_bulanan').on('hidden.bs.modal', function(){
		$('.label_kegiatan, .target, .satuan, .waktu, .quality').removeClass('has-error');
		$('.modal-kegiatan_bulanan').find('[name=kegiatan_bulanan_id],[name=label],[name=angka_kredit],[name=target],[name=quality],[name=satuan],[name=target_waktu],[name=cost]').val('');
	}); */

	$('.label_tugas_tambahan').on('click', function(){
		$('.label_tugas_tambahan').removeClass('has-error');
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
		$('.modal-tugas_tambahan').find('.button_simpan').addClass('fa-spinner faa-spin animated');
		$('#submit-tugas_tambahan').prop('disabled',true);
	}
	function reset_submitx(){
		$('.modal-tugas_tambahan').find('.button_simpan').removeClass('fa-spinner faa-spin animated');
		$('.modal-tugas_tambahan').find('.button_simpan').addClass('fa-floppy-o');
		$('#submit-tugas_tambahan').prop('disabled',false);
	}

	$(document).on('click','#submit-save_tugas_tambahan',function(e){

		on_submitx();
		var data = $('#tugas_tambahan_form').serialize();

		//alert(data);
		$.ajax({
			url		: '{{ url("api_resource/simpan_tugas_tambahan") }}',
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
					$('.modal-tugas_tambahan').modal('hide');
					$('#tugas_tambahan_table').DataTable().ajax.reload(null,false);
					jQuery('#tugas_tambahan_tree').jstree(true).refresh(true);
					jQuery('#tugas_tambahan_tree').jstree().deselect_all(true);
					

					
					
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
					((index == 'label')?$('.label_tugas_tambahan').addClass('has-error'):'');
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

	$(document).on('click','#submit-update_tugas_tambahan',function(e){

		on_submitx();
		var data = $('#tugas_tambahan_form').serialize();

		//alert(data);
		$.ajax({
			url		: '{{ url("api_resource/update_tugas_tambahan") }}',
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
					$('.modal-tugas_tambahan').modal('hide');
					$('#tugas_tambahan_table').DataTable().ajax.reload(null,false);
					jQuery('#tugas_tambahan_tree').jstree(true).refresh(true);
					jQuery('#tugas_tambahan_tree').jstree().deselect_all(true);
					
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
					((index == 'label')?$('.label_tugas_tambahan').addClass('has-error'):'');
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