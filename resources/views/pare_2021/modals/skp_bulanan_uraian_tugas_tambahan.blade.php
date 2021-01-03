<div class="modal fade modal-uraian_tugas_tambahan" id="createIndikatorProgram" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Uraian Tugas Tambahan 
                </h4>
            </div> 

            <form  id="uraian_tugas_tambahan_form" method="POST" action="">
			<input type="hidden"  name="skp_bulanan_id" value="{!! $skp->id !!}">
			<input type="hidden"  name="uraian_tugas_tambahan_id" value="">
			
 			<div class="modal-body">
					<div class="row">
						<div class="col-md-12 form-group label_tugas_tambahan">
							<label class="control-label">Pilih Tugas Tambahan:</label>
							<select class="form-control input-sm tugas_tambahan" id="tugas_tambahan" name="tugas_tambahan_id" style="width:100%"></select>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 form-group label_uraian_tugas_tambahan ">
							<label class="control-label">Uraian Tugas Tambahan Label:</label>
							<textarea name="label" rows="2" required class="form-control txt-label" id="label" style="resize:none;"></textarea>
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
                {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_save_icon').' button_simpan" aria-hidden="true"></i> <span name="text_button_submit"></span>', array('class' => 'btn btn-primary btn-sm pull-right  btn-submit btn-submit_uraian_tugas_tambahan', 'type' => 'button', 'id' => 'submit-save_tugas_tambahan' )) !!}
            </div>

            </form>
        </div>
    </div>
</div>




<script type="text/javascript">

	$('.tugas_tambahan').select2({
		ajax: {
			url: '{{ url("api/tugas_tambahan_select2") }}',
			dataType: 'json',
			quietMillis: 100,
			data: function(params) {
				var queryParameters = {
					sasaran				: params.term,
					"skp_tahunan_id" 	: {!! $skp->skp_tahunan->id !!} ,
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



	$('.modal-uraian_tugas_tambahan').on('shown.bs.modal', function(){
		
		reset_submitx();
	});


	$('.modal-uraian_tugas_tambahan').on('hidden.bs.modal', function(){
		
		$('.label_tugas_tambahan,.label_uraian_tugas_tambahan,.target,.satuan').removeClass('has-error');
		$('.modal-uraian_tugas_tambahan').find('[name=tugas_tambahan_id],[name=label],[name=target],[name=satuan]').val('');
		$('.modal-uraian_tugas_tambahan').find('[name=tugas_tambahan_id]').val("").trigger('change');
	});


	$('.label_tugas_tambahan').on('click', function(){
		$('.label_tugas_tambahan').removeClass('has-error');
	});

	$('.label_uraian_tugas_tambahan').on('click', function(){
		$('.label_uraian_tugas_tambahan').removeClass('has-error');
	});


	$('.target').on('click', function(){
		$('.target').removeClass('has-error');
	});

	$('.satuan').on('click', function(){
		$('.satuan').removeClass('has-error');
	});

	
 
	function on_submitx(){
		$('.modal-uraian_tugas_tambahan').find('.button_simpan').addClass('fa-spinner faa-spin animated');
		$('#submit-uraian_tugas_tambahan').prop('disabled',true);
	}
	function reset_submitx(){
		$('.modal-uraian_tugas_tambahan').find('.button_simpan').removeClass('fa-spinner faa-spin animated');
		$('.modal-uraian_tugas_tambahan').find('.button_simpan').addClass('fa-floppy-o');
		$('#submit-uraian_tugas_tambahan').prop('disabled',false);
	}

	$(document).on('click','#submit-save_uraian_tugas_tambahan',function(e){

		on_submitx();
		var data = $('#uraian_tugas_tambahan_form').serialize();

		//alert(data);
		$.ajax({
			url		: '{{ url("api/simpan_uraian_tugas_tambahan") }}',
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
					$('.modal-uraian_tugas_tambahan').modal('hide');
					$('#uraian_tugas_tambahan_table').DataTable().ajax.reload(null,false);
					

					
					
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
					((index == 'tugas_tambahan_id')?$('.label_tugas_tambahan').addClass('has-error'):'');
					((index == 'label')?$('.label_uraian_tugas_tambahan').addClass('has-error'):'');
					((index == 'target')?$('.target').addClass('has-error'):'');
					((index == 'satuan')?$('.satuan').addClass('has-error'):'');
					
					reset_submitx();
				});
			}
		});

	});

	$(document).on('click','#submit-update_uraian_tugas_tambahan',function(e){

		on_submitx();
		var data = $('#uraian_tugas_tambahan_form').serialize();

		//alert(data);
		$.ajax({
			url		: '{{ url("api/update_uraian_tugas_tambahan") }}',
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
					$('.modal-uraian_tugas_tambahan').modal('hide');
					$('#uraian_tugas_tambahan_table').DataTable().ajax.reload(null,false);
					
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
					((index == 'tugas_tambahan_id')?$('.label_tugas_tambahan').addClass('has-error'):'');
					((index == 'label')?$('.label_uraian_tugas_tambahan').addClass('has-error'):'');
					((index == 'target')?$('.target').addClass('has-error'):'');
					((index == 'satuan')?$('.satuan').addClass('has-error'):'');
					reset_submitx();

					
				
				});

			
			}
			
		});





		});










</script>