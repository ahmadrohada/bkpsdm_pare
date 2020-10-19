<div class="modal fade modal-realisasi_sasaran_triwulan" id="" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
					Add Realisasi Sasaran Triwulan
                </h4>
            </div>

            <form  id="realisasi_sasaran_triwulan_form" method="POST" action="">

			<input type="hidden"  name="capaian_triwulan_id">
			<input type="hidden"  name="sasaran_id">
			<input type="hidden"  name="indikator_sasaran_id">
			<input type="hidden"  name="realisasi_sasaran_triwulan_id">
			<input type="hidden"  name="realisasi_indikator_sasaran_triwulan_id">
			<input type="hidden"  name="jumlah_indikator">
			<input type="hidden"  name="satuan">

			
			<div class="modal-body">
					
					<div class="row">
						<div class="col-md-12 form-group label_kegiatan_tahunan">
							<strong>Sasaran  </strong>
							<p class="text-info " style="margin-top:1px;">
								<span class="sasaran_label"></span>
							</p>
						</div>
						
					</div>
					<hr>

					<div class="row">
						<div class="col-md-12 form-group label_kegiatan_tahunan">
							<strong>Indikator Sasaran  </strong>
							<p class="text-info " style="margin-top:1px;">
								<span class="indikator_sasaran_label"></span>
							</p>
						</div>
						
					</div>

					<div class="row" style="margin-top:10px;"> 
						<div class="col-md-6 col-xs-6 form-group">	
							<label class="control-label">Target Quantity </label>
							<div class="input-group">
								<input type="text" name="target_quantity" required class="form-control input-sm target_quantity" onkeypress='return format_quantity(event)' placeholder="1234567890ABCDE">
								<div class="input-group-addon">
									<span class="satuan"></span>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-xs-6 form-group quantity">	
							<label class="control-label">Realisasi Quantity</label>
							<div class="input-group">
								<input type="text" name="realisasi_quantity" required class="form-control input-sm realisasi_quantity"  onkeypress='return format_quantity(event)' placeholder="1234567890ABCDE">
								<div class="input-group-addon">
									<span class="satuan"></span>
								</div>
							</div>
						</div>
					</div>
			</div>
			<div class="modal-footer">
                {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_cancel_icon').'" aria-hidden="true"></i> Batal', array('class' => 'btn btn-sm btn-default pull-left ', 'type' => 'button', 'data-dismiss' => 'modal' )) !!}
                {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_save_icon').' button_simpan" aria-hidden="true"></i> <span name="text_button_submit"></span>', array('class' => 'btn btn-primary btn-sm pull-right  btn-submit', 'type' => 'button', 'id' => 'simpan_st' )) !!}
            </div>

            </form>
        </div>
    </div>
</div>




<script type="text/javascript">



	$('.modal-realisasi_sasaran_triwulan').on('shown.bs.modal', function(){
		$(this).find('input:text')[1].focus();
		reset_submitst();
	});

	$('.modal-realisasi_sasaran_triwulan').on('hidden.bs.modal', function(){
		$('.quantity').removeClass('has-error');
		$('.modal-realisasi_sasaran_triwulan').find('[name=realisasi_quantity]').val('');
	});



	$('.realisasi_quantity').on('click', function(){
		$('.quantity').removeClass('has-error');
	});



	function on_submitst(){
		$('.modal-realisasi_sasaran_triwulan').find('.button_simpan').addClass('fa-spinner faa-spin animated');
		$('#submit-save_st').prop('disabled',true);
	}
	function reset_submitst(){
		$('.modal-realisasi_sasaran_triwulan').find('.button_simpan').removeClass('fa-spinner faa-spin animated');
		$('.modal-realisasi_sasaran_triwulan').find('.button_simpan').addClass('fa-floppy-o');
		$('#submit-save_st').prop('disabled',false);
	}

	$(document).on('click','#submit-save_st',function(e){

		on_submitst();
		var data = $('#realisasi_sasaran_triwulan_form').serialize();

		//alert(data);
		$.ajax({
			url		: '{{ url("api_resource/simpan_realisasi_sasaran_triwulan") }}',
			type	: 'POST',
			data	:  data,
			success	: function(data , textStatus, jqXHR) {
				
				//$('#program_table').DataTable().ajax.reload(null,false);
               
				reset_submitst();
				Swal.fire({
					title: "",
					text: "Sukses",
					type: "success",
					width: "200px", 
					showConfirmButton: false,
					allowOutsideClick : false,
					timer:1500
				}).then(function () {
					$('.modal-realisasi_sasaran_triwulan').modal('hide');
					$('#realisasi_sasaran_triwulan_table').DataTable().ajax.reload(null,false);
					
					
					
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
					((index == 'realisasi_quantity')?$('.quantity').addClass('has-error'):'');
					
					reset_submitst();
					
				
				});

			
			}
			
		});





	});


	$(document).on('click','#submit-update_st',function(e){

		on_submitst();
		var data = $('#realisasi_sasaran_triwulan_form').serialize();

		//alert(data);
		$.ajax({
			url		: '{{ url("api_resource/update_realisasi_sasaran_triwulan") }}',
			type	: 'POST',
			data	:  data,
			success	: function(data , textStatus, jqXHR) {
				
			
				reset_submitst();
				Swal.fire({
					title: "",
					text: "Sukses",
					type: "success",
					width: "200px", 
					showConfirmButton: false,
					allowOutsideClick : false,
					timer:1500
				}).then(function () {
					$('.modal-realisasi_sasaran_triwulan').modal('hide');
					$('#realisasi_sasaran_triwulan_table').DataTable().ajax.reload(null,false);
					
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
					((index == 'realisasi_quantity')?$('.quantity').addClass('has-error'):'');
					reset_submitst();

					
				
				});

			
			}
			
		});

	});

</script>