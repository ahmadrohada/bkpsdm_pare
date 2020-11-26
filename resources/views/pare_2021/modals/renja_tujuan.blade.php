<div class="modal fade modal-tujuan" id="createIndikatorProgram" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Kegiatan Tahunan
                </h4>
            </div>

            <form  id="tujuan_form" method="POST" action="">
			<input type="hidden"  name="tujuan_id" class="tujuan_id">
			<input type="hidden"  name="renja_id" class="renja_id" value="{{ $renja->id }}">
			<div class="modal-body">

				<div class="row" hidden>	
					<div class="col-md-12 form-group label_misi">
                        <label class="control-label ">Misi</label>
                        <select  class="form-control misi_id" name="misi_id" id="misi_id" style="width:100%;"></select>
                    </div>
				</div>

				<div class="row">
					<div class="col-md-12 form-group label_tujuan ">
						<label class="control-label">Bidang Urusan :</label>
						<textarea name="label" rows="3" required class="form-control txt-label" id="label" style="resize:none;"></textarea>
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

	$('.modal-tujuan').on('shown.bs.modal', function(){
		
	});

	$('.modal-tujuan').on('hidden.bs.modal', function(){
		$('.label_tujuan,.label_misi').removeClass('has-error');
		$('#misi_id').select2("val", "");
		$('.modal-tujuan').find('[name=label]').val('');
	});

	$('.label_tujuan').on('click', function(){
		$('.label_tujuan').removeClass('has-error');
	});

	

	$('#misi_id').select2({
        
        allowClear      : true,
        ajax: {
            url			: '{{ url("api_resource/misi_select2") }}',
			type		: 'GET',
            dataType	: 'json',
            quietMillis	: 250,
            data: function (params) {
                var queryParameters = {
                    label: params.term
                }
                return queryParameters;
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        
                        return {
                            text: item.label,
						    id: item.misi_id,
                        }
                        
                    })
                };
            }
        }
		

    });

	

	
	$(document).on('click','#submit-save',function(e){

		var data = $('#tujuan_form').serialize();

		//alert(data);
		$.ajax({
			url		: '{{ url("api_resource/simpan_tujuan") }}',
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
					$('.modal-tujuan').modal('hide');
					$('#tujuan_table').DataTable().ajax.reload(null,false);
					jQuery('#renja_tree_kegiatan').jstree(true).refresh(true);
					
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
					((index == 'label')?$('.label_tujuan').addClass('has-error'):'');
				});
			}
		});
	});


	$(document).on('click','#submit-update',function(e){

		var data = $('#tujuan_form').serialize();

		//alert(data);
		$.ajax({
			url		: '{{ url("api_resource/update_tujuan") }}',
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
					$('.modal-tujuan').modal('hide');
					$('#tujuan_table').DataTable().ajax.reload(null,false);
					jQuery('#renja_tree_kegiatan').jstree(true).refresh(true);
					
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
					((index == 'label')?$('.label_tujuan').addClass('has-error'):'');
					((index == 'misi_id')?$('.label_misi').addClass('has-error'):'');
				
				});
			}
		});
	});



</script>