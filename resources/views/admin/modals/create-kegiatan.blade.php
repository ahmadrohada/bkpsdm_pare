<div class="modal fade create-kegiatan_modal" id="createKegiatan" role="dialog"  aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">
                                Create Kegiatan
                            </h4>
                        </div>

                        <form  id="create-kegiatan-form" method="POST" action="">


                        <div class="modal-body">
							
						
						
                        <input type="hidden" name="indikator_program_id" class="form-control indikator_program_id" required="">
						
						<div class="form-group">
                            <label>Indikator Program</label>
							<p class="label-perjanjian-kinerja">
                            <span class="indikator_program_label"></span>
							</p>
                        </div>


						<div class="form-group jabatan ">
                            <label>Jabatan</label>
							<select class="form-control input-sm" id="jabatan" name="jabatan_id" style="width:100%"></select>
							
                        </div>

                        <div class="form-group kegiatan ">
                            <label>Kegiatan</label>
                            <textarea class="form-control txt-kegiatan" rows="2" name="label" placeholder="Kegiatan"></textarea>
                        </div>


                        </div>
                        <div class="modal-footer">
                            {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_cancel_icon').'" aria-hidden="true"></i> ' . Lang::get('modals.confirm_modal_button_cancel_text'), array('class' => 'btn btn-sm btn-default pull-left btn-flat', 'type' => 'button', 'data-dismiss' => 'modal' )) !!}
                            {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_save_icon').'" aria-hidden="true"></i> ' . Lang::get('modals.confirm_modal_button_save_text'), array('class' => 'btn btn-sm btn-primary pull-right btn-flat', 'type' => 'button', 'id' => 'simpan_kegiatan' )) !!}
                        </div>

                        </form>
                    </div>
                </div>
            </div>







<script type="text/javascript">
$(document).ready(function() {

	$('#jabatan').select2({
        allowClear: true,
        ajax: {
            url				: '{{ url("api_resource/select2_jabatan_list") }}',
            dataType		: 'json',
            quietMillis		: 850,
            data			: function (params) {
                var queryParameters = {
                    txt_cari: params.term,
					jabatan_id : '900'
                }
                return queryParameters;
            },
            processResults: function (data) {
				return {
					results: data
				};
                
                
            }
        }
        

    });


	$('.create-kegiatan_modal').on('hidden.bs.modal', function(){
		$('.txt-kegiatan').html('');
		$('.kegiatan').removeClass('has-error');
		$("#jabatan").select2("val", "");
	});

 	$(document).on('click', '.kegiatan', function(){
		$('.kegiatan').removeClass('has-error');
	});



    $(document).on('click', '#simpan_kegiatan', function(){
		
        var data = $('#create-kegiatan-form').serialize();
		$.ajax({
			url		: '{{ url("api_resource/skpd_simpan_kegiatan") }}',
			type	: 'POST',
			data	:  data,
			success	: function(data , textStatus, jqXHR) {
				
				$('#kegiatan_table').DataTable().ajax.reload(null,false);
               
				swal({
					title: "",
					text: "Sukses",
					type: "success",
					width: "200px",
					showConfirmButton: false,
					allowOutsideClick : false,
					timer:1500
				}).then(function () {
					$('.create-kegiatan_modal').modal('hide');
					
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
					
					if (index == 'label'){
						$('.kegiatan').addClass('has-error');
					}

					
				
				});

			
			}
			
		  });
		
    });




});
</script>