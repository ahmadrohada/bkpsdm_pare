<div class="modal fade modal-skpd_create_skp_tahunan" id="CreateSKPBulanan" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
		<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    SKP Tahunan
                </h4>
            </div>

            <form  id="skpd_create_skp_tahunan_form" method="POST" action="">
			<input type="hidden"  name="skpd_id" value="{{ $skpd_id }}">
			<div class="modal-body">
					
					<br>
					<div class="col-md-12 form-group form-group-sm">
						<label>Periode SKP Tahunan</label>
						<select class="form-control  periode_skp" name="periode_skp" style="width: 100%;"></select>
					</div>
					<div class="col-md-12 form-group form-group-sm">
						<label>Nama Pegawai</label>
						<select class="form-control u_nip_edit" name="u_nip" style="width:100%;"></select>
					</div>

				

					<div class="col-md-12 form-group form-group-sm">
						<label>Jabatan</label>
						<select class="form-control jabatan" name="u_jabatan" style="width:100%;"></select>
					</div>



			</div>
			<div class="modal-footer">
                {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_cancel_icon').'" aria-hidden="true"></i> Batal', array('class' => 'btn btn-sm btn-default pull-left ', 'type' => 'button', 'data-dismiss' => 'modal' )) !!}
				{!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_save_icon').' button_simpan" aria-hidden="true"></i> <span name="text_button_submit"></span>', array('class' => 'btn btn-primary btn-sm pull-right  btn-submit', 'type' => 'button', 'id' => 'simpan_ra' )) !!}
				
            </div>

            </form>
        </div>
   	</div>
</div>







<script type="text/javascript">


	//$('.periode_skp,.periode_skpd_create_skp_tahunan_edit').select2();

	$('.periode_skp').select2({
        placeholder         : "Periode SKP Tahunan",
		//minimumInputLength  : 3,
		
        ajax: {
            url				: '{{ url("api/periode_list_select2") }}',
            dataType		: 'json',
            quietMillis		: 250,
            data			: function (params) {
                var queryParameters = {
                    nama				: params.term,
                }
                return queryParameters;
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        
                        return {
                            text	: item.label,
						    id		: item.id,
                        }
                        
                    })
                };  
            }
        },

    });


	$('.u_nip_edit').select2({
        placeholder         : "Ketik NIP atau Nama Pegawai",
		minimumInputLength  : 3,
		
        ajax: {
            url				: '{{ url("api/skpd_pegawai_list_select2") }}',
            dataType		: 'json',
            quietMillis		: 250,
            data			: function (params) {
                var queryParameters = {
                    nama				: params.term,
					skpd_id				: {{ $skpd_id }}
                }
                return queryParameters;
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        
                        return {
                            text	: item.nama,
						    id		: item.id,
                        }
                        
                    })
                };  
            }
        },

    });

	$('.jabatan').select2({
        placeholder         : "Pilih Jabatan",
		//minimumInputLength  : 3,
		
        ajax: {
            url				: '{{ url("api/select2_skpd_jabatan_list") }}',
            dataType		: 'json',
            quietMillis		: 250,
            data			: function (params) {
                var queryParameters = {
                    skpd				: params.term,
					skpd_id				: {{ $skpd_id }}
                }
                return queryParameters;
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        
                        return {
                            text	: item.label,
						    id		: item.id,
                        }
                        
                    })
                };  
            }
        },

    });


	
	

	$('.modal-skpd_create_skp_tahunan').on('shown.bs.modal', function(){
		
		reset_submit();
	});

	$('.modal-skpd_create_skp_tahunan').on('hidden.bs.modal', function(){
		reset_submit();
		$('.periode_skpd_create_skp_tahunan').select2('val','');
		$('.periode_skpd_create_skp_tahunan').select2('destroy');
		$('.periode_skpd_create_skp_tahunan,.periode_skpd_create_skp_tahunan_edit').select2();
	});

	$('.label_periode_skpd_create_skp_tahunan').on('click', function(){
		$('.label_periode_skpd_create_skp_tahunan').removeClass('has-error');
	});

	function on_submit(){
		$('.modal-skpd_create_skp_tahunan').find('.button_simpan').addClass('fa-spinner faa-spin animated');
		$('#submit-save_skpd_create_skp_tahunan').prop('disabled',true);
	}
	function reset_submit(){
		$('.modal-skpd_create_skp_tahunan').find('.button_simpan').removeClass('fa-spinner faa-spin animated');
		$('.modal-skpd_create_skp_tahunan').find('.button_simpan').addClass('fa-floppy-o');
		$('#submit-save_skpd_create_skp_tahunan').prop('disabled',false);
	}

	$(document).on('click','#submit-save_skpd_create_skp_tahunan',function(e){
		
		on_submit();
		var data = $('#skpd_create_skp_tahunan_form').serialize();
 
		//alert(data);
		$.ajax({
			url		: '{{ url("api/create_skpd_create_skp_tahunan") }}',
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
					$('.modal-skpd_create_skp_tahunan').modal('hide');
					$('#skpd_create_skp_tahunan_table').DataTable().ajax.reload(null,false);
					jQuery('#skpd_create_skp_tahunan_tree').jstree(true).refresh(true);
					
					
				},
					
					function (dismiss) {
						if (dismiss === 'timer') {
							
						}
					}
				)	
				$("#submit-save_skpd_create_skp_tahunan").show();
			},
			error: function(jqXHR , textStatus, errorThrown) {
				reset_submit();
				var test = $.parseJSON(jqXHR.responseText);
				
				var data= test.errors;

				$.each(data, function(index,value){
					//alert (index+":"+value);
					
					//error message
					((index == 'periode_skpd_create_skp_tahunan')?$('.label_periode_skpd_create_skp_tahunan').addClass('has-error'):'');
					
				
					
				
				});
				
			
			}
			
		});


	});


	$(document).on('click','#submit-update_skpd_create_skp_tahunan',function(e){

			on_submit();
			var data = $('#skpd_create_skp_tahunan_form').serialize();

			//alert(data);
			$.ajax({
				url		: '{{ url("api/update_skpd_create_skp_tahunan") }}',
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
						$('.modal-skpd_create_skp_tahunan').modal('hide');
						$('#skpd_create_skp_tahunan_table').DataTable().ajax.reload(null,false);
						jQuery('#skpd_create_skp_tahunan_tree').jstree(true).refresh(true);
					
						
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
						((index == 'periode_skp_tahunan')?$('.label_periode_skp_tahunan').addClass('has-error'):'');
						reset_submit();

						
					
					});

				
				}
				
			});

	});

</script>