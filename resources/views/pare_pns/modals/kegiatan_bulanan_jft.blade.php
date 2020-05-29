<div class="modal fade modal-kegiatan_bulanan_jft" id="createIndikatorProgram" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Kegiatan Bulanan JFT
                </h4>
            </div> 

            <form  id="kegiatan_bulanan_jft_form" method="POST" action="">
			<input type="hidden"  name="skp_tahunan_id" value="{!! $skp->id !!}">
			<input type="hidden"  class="skp_bulanan_id"  name="skp_bulanan_id">
			<input type="hidden"  class="kegiatan_bulanan_id"  name="kegiatan_bulanan_id">
			
 			<div class="modal-body">
					
					<div class="row">
						<div class="col-md-12 form-group label_kegiatan_tahunan">
							<label class="control-label">Pilih Kegiatan Tahunan:</label>
							<select class="form-control input-sm kegiatan_tahunan" id="kegiatan_tahunan" name="kegiatan_tahunan_id" style="width:100%"></select>
						</div>
					</div>


					<div class="row">
						<div class="col-md-12 form-group label_kegiatan_bulanan_jft ">
							<label class="control-label">Kegiatan SKP Bulanan:</label>
							<textarea name="label" rows="2" required class="form-control txt-label" id="label" style="resize:none;"></textarea>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 form-group angka_kredit">
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
						<input type="text" name="quality" id="quality" required class="form-control"  placeholder="kualitas/mutu" maxlength="3" onkeypress='return angka(event)' readonly>
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
                {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_save_icon').' button_simpan" aria-hidden="true"></i> <span name="text_button_submit"></span>', array('class' => 'btn btn-primary btn-sm pull-right  btn-submit', 'type' => 'button', 'id' => 'simpan_jft' )) !!}
            </div>

            </form>
        </div>
    </div>
</div>




<script type="text/javascript">

	$('.kegiatan_tahunan').select2({
		ajax: {
			url: '{{ url("api_resource/kegiatan_tahunan_list_JFT") }}',
			dataType: 'json',
			quietMillis: 500,
			data: function(params) {
				var queryParameters = {
					kegiatan_tahunan	: params.term,
					"skp_tahunan_id" 	: {!! $skp->id !!}
				}
				return queryParameters;
			},
			processResults: function(data) {
				return {
					results: $.map(data, function(item) {
						return {
							text: item.text,
							id: item.id,
						}
					})
				};
			}
		},
	});

	function show_modal_kegiatan_bulanan(sasaran_id){
		$.ajax({
				url			: '{{ url("api_resource/sasaran_detail") }}',
				data 		: {sasaran_id : sasaran_id},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					
					//Add data sasaran to select2
					var option = new Option(data['label'],data['id'],true,true);
					$('.modal-kegiatan_bulanan_jft').find('[name=sasaran_id]').append(option).trigger('change');

					$('.modal-kegiatan_bulanan_jft').find('[name=label],[name=angka_kredit],[name=target],[name=satuan],[name=target_waktu],[name=cost]').val("");
					$('.modal-kegiatan_bulanan_jft').find('[name=quality]').val("100");
					$('.modal-kegiatan_bulanan_jft').find('h4').html('Add Kegiatan Bulanan ( JFT )');
					$('.modal-kegiatan_bulanan_jft').find('.btn-submit').attr('id', 'submit-save_jft');
					$('.modal-kegiatan_bulanan_jft').find('[name=text_button_submit]').html('Simpan Data');
					$('.modal-kegiatan_bulanan_jft').modal('show');
				},
				error: function(data){
					
				}						
		});	 
	}

	$('.modal-kegiatan_bulanan').on('shown.bs.modal', function(){
		reset_submitx();
	});

	/* $('.modal-kegiatan_bulanan').on('hidden.bs.modal', function(){
		$('.label_kegiatan, .target, .satuan, .waktu, .quality').removeClass('has-error');
		$('.modal-kegiatan_bulanan').find('[name=kegiatan_bulanan_id],[name=label],[name=angka_kredit],[name=target],[name=quality],[name=satuan],[name=target_waktu],[name=cost]').val('');
	}); */

	$('.label_sasaran').on('click', function(){
		$('.label_sasaran').removeClass('has-error');
	});

	$('.label_kegiatan_bulanan_jft').on('click', function(){
		$('.label_kegiatan_bulanan_jft').removeClass('has-error');
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
		$('.modal-kegiatan_bulanan').find('.button_simpan').addClass('fa-spinner faa-spin animated');
		$('#submit-save_jft').prop('disabled',true);
	}
	function reset_submitx(){
		$('.modal-kegiatan_bulanan').find('.button_simpan').removeClass('fa-spinner faa-spin animated');
		$('.modal-kegiatan_bulanan').find('.button_simpan').addClass('fa-floppy-o');
		$('#submit-save_jft').prop('disabled',false);
	}

	$(document).on('click','#submit-save_jft',function(e){

		on_submitx();
		var data = $('#kegiatan_bulanan_jft_form').serialize();

		//alert(data);
		$.ajax({
			url		: '{{ url("api_resource/simpan_kegiatan_bulanan_jft") }}',
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
					$('.modal-kegiatan_bulanan_jft').modal('hide');
					$('#kegiatan_bulanan_table').DataTable().ajax.reload(null,false);
					$('#skp_bulanan_table').DataTable().ajax.reload(null,false);
					jQuery('#skp_bulanan_tree').jstree(true).refresh(true);
					jQuery('#skp_bulanan_tree').jstree().deselect_all(true);
					

					
					
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
					((index == 'sasaran_id')?$('.label_sasaran').addClass('has-error'):'');
					((index == 'label')?$('.label_kegiatan_bulanan_jft').addClass('has-error'):'');
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


	$(document).on('click','#submit-update_jft',function(e){

		on_submitx();
		var data = $('#kegiatan_bulanan_jft_form').serialize();

		//alert(data);
		$.ajax({
			url		: '{{ url("api_resource/update_kegiatan_bulanan_jft") }}',
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
					$('.modal-kegiatan_bulanan_jft').modal('hide');
					$('#kegiatan_bulanan_table').DataTable().ajax.reload(null,false);
					$('#skp_bulanan_table').DataTable().ajax.reload(null,false);
					jQuery('#skp_bulanan_tree').jstree(true).refresh(true);
					//jQuery('#skp_bulanan_tree').jstree().deselect_all(true);
					
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
					((index == 'sasaran_id')?$('.label_sasaran').addClass('has-error'):'');
					((index == 'label')?$('.label_kegiatan_bulanan_jft').addClass('has-error'):'');
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