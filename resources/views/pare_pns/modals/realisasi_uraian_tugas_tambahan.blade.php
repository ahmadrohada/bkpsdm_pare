<div class="modal fade modal-realisasi_uraian_tugas_tambahan" id="createIndikatorProgram" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Uraian Tugas Tambahan 
                </h4>
            </div> 

            <form  id="realisasi_uraian_tugas_tambahan_form" method="POST" action="">
			<input type="hidden"  name="capaian_bulanan_id" value="{!! $capaian->id !!}">
			<input type="hidden"  name="uraian_tugas_tambahan_id" value="">
			<input type="hidden"  name="realisasi_uraian_tugas_tambahan_id" value="">
			<input type="hidden"  name="satuan" value="">
			
 			<div class="modal-body">
				<br>
				<div class="row">
					<div class="col-md-12 form-group label_kegiatan_tahunan">
						<strong>Uraian Tugas Tambahan  </strong>
						<p class="text-info " style="margin-top:8px;">
							<span class="uraian_tugas_tambahan_label"></span>
						</p>

						<i class="fa fa-industry" ></i> <span class="uraian_tugas_tambahan_output" style="margin-right:10px;"></span>
						{{-- <i class="fa fa-hourglass-start"></i> <span class="uraian_tugas_tambahan_waktu" style="margin-right:10px;"></span>
						<i class="fa fa-money"></i> <span class="uraian_tugas_tambahan_cost" style="margin-right:10px;"></span> --}}
						<br>
						

					</div>
				</div>
				<br>

				<div class="row">
						
					<div class="col-md-6 col-xs-6 form-group" style="margin-top:8px;">	
						<label class="control-label">Target </label>
						<div class="input-group">
							<input type="text" name="target" id="uraian_tugas_tambahan_target"  class="form-control input-sm uraian_tugas_tambahan_target">
							{{-- <span type="text" class="form-control input-sm uraian_tugas_tambahan_target"></span> --}}
							<div class="input-group-addon">
								<span class="uraian_tugas_tambahan_satuan"></span>
							</div>
						</div>
					</div>

					<div class="col-md-6 col-xs-6 form-group realisasi" style="margin-top:8px;">	
						<label class="control-label">Realisasi </label>
						<div class="input-group">
							<input type="text" name="realisasi" id="realisasi"  class="form-control input-sm uraian_tugas_tambahan_realisasi" placeholder="realisasi">
							<div class="input-group-addon">
								<span class="uraian_tugas_tambahan_satuan"></span>
							</div>
						</div>
					</div>
				</div>
					
		
			</div>
			<div class="modal-footer">
                {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_cancel_icon').'" aria-hidden="true"></i> Batal', array('class' => 'btn btn-sm btn-default pull-left ', 'type' => 'button', 'data-dismiss' => 'modal' )) !!}
                {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_save_icon').' button_simpan" aria-hidden="true"></i> <span name="text_button_submit"></span>', array('class' => 'btn btn-primary btn-sm pull-right  btn-submit', 'type' => 'button', 'id' => 'submit-save_realisasi_utt' )) !!}
            </div>

            </form>
        </div>
    </div>
</div>




<script type="text/javascript">

	$('.modal-realisasi_uraian_tugas_tambahan').on('shown.bs.modal', function(){
		
        $(this).find('input:text')[1].focus();
    
		reset_submitx();
		
	});

	$('.modal-realisasi_uraian_tugas_tambahan').on('hidden.bs.modal', function(){
		$('.realisasi, .bukti ').removeClass('has-error');
		$('.modal-realisasi_uraian_tugas_tambahan').find('[name=realisasi],[name=file_bukti]').val('');
	});



	$('.realisasi').on('click', function(){
		$('.realisasi').removeClass('has-error');
	});

	$('.bukti').on('click', function(){
		$('.bukti').removeClass('has-error');
	});

	function on_submitx(){
		$('.modal-realisasi_uraian_tugas_tambahan').find('.button_simpan').addClass('fa-spinner faa-spin animated');
		$('#submit-save').prop('disabled',true);
	}
	function reset_submitx(){
		$('.modal-realisasi_uraian_tugas_tambahan').find('.button_simpan').removeClass('fa-spinner faa-spin animated');
		$('.modal-realisasi_uraian_tugas_tambahan').find('.button_simpan').addClass('fa-floppy-o');
		$('#submit-save').prop('disabled',false);
	}

	$(document).on('click','#submit-save_realisasi_utt',function(e){

		on_submitx();
		var data = $('#realisasi_uraian_tugas_tambahan_form').serialize();

		//alert(data);
		$.ajax({
			url		: '{{ url("api_resource/simpan_realisasi_uraian_tugas_tambahan") }}',
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
					$('.modal-realisasi_uraian_tugas_tambahan').modal('hide');
					$('#realisasi_uraian_tugas_tambahan_table').DataTable().ajax.reload(null,false);
					
					
					
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
					((index == 'realisasi')?$('.realisasi').addClass('has-error'):'');
					((index == 'bukti')?$('.bukti').addClass('has-error'):'');
					
					reset_submitx();
					
				
				});

			
			}
			
		});





	});


	$(document).on('click','#submit-update_realisasi_utt',function(e){

		on_submitx();
		var data = $('#realisasi_uraian_tugas_tambahan_form').serialize();

		//alert(data);
		$.ajax({
			url		: '{{ url("api_resource/update_realisasi_uraian_tugas_tambahan") }}',
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
					$('.modal-realisasi_uraian_tugas_tambahan').modal('hide');
					$('#realisasi_uraian_tugas_tambahan_table').DataTable().ajax.reload(null,false);
					
					
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
					((index == 'realisasi')?$('.realisasi').addClass('has-error'):'');
					reset_submitx();

					
				
				});

			
			}
			
		});





		});


</script>