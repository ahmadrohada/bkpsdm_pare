<div class="modal fade modal-realisasi_tahunan" id="" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
					Add Realisasi Kegiatan Tahunan
                </h4>
            </div> 

            <form  id="realisasi_tahunan_form" method="POST" action="">

			<input type="hidden"  name="capaian_id">
			<input type="hidden"  name="ind_kegiatan_id"> 
			<input type="hidden"  name="kegiatan_tahunan_id">
			<input type="hidden"  name="realisasi_indikator_kegiatan_tahunan_id">
			<input type="hidden"  name="realisasi_kegiatan_tahunan_id">
			<input type="hidden"  name="jumlah_indikator">
			<input type="hidden"  name="satuan">

			<input type="hidden"  name="target_angka_kredit">
			<input type="hidden"  name="target_quantity">
			<input type="hidden"  name="target_quality">
			<input type="hidden"  name="target_waktu">
			<input type="hidden"  name="target_cost">

			

			
			<div class="modal-body">
					
					<div class="row">
						<div class="col-md-12 form-group label_kegiatan_tahunan">
							<strong>Kegiatan Tahunan  </strong>
							<p class="text-info " style="margin-top:1px;">
								<span class="kegiatan_tahunan_label"></span>
							</p>
						</div>
					</div>
						
					<div class="row" style="margin-top:-10px;"> 
						<div class="col-md-6 col-xs-6 form-group">	
							<label class="control-label">Target AK </label>
							<span type="text" class="form-control input-sm target_angka_kredit"></span>
						</div>
						<div class="col-md-6 col-xs-6 form-group angka_kredit">	
							<label class="control-label">Realisasi AK</label>
							<input type="text" name="realisasi_angka_kredit" required class="form-control input-sm realisasi_angka_kredit" placeholder="realisasi">
						</div>
					</div>
					<div class="row" style="margin-top:-20px;" > 
						<div class="col-md-6 col-xs-6 form-group">	
							<label class="control-label">Target Quality </label>
							<div class="input-group">
							<span type="text" class="form-control input-sm target_quality"></span>
								<div class="input-group-addon">
									<span class="">%</span>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-xs-6 form-group quality">	
							<label class="control-label">Realisasi Quality</label>
							<div class="input-group">
								<input type="text" name="realisasi_quality" required class="form-control input-sm realisasi_quality" placeholder="realisasi" >
								<div class="input-group-addon">
									<span class="">%</span>
								</div>
							</div>
						</div>
					</div>

					<div class="row" style="margin-top:-20px;"> 
						<div class="col-md-6 col-xs-6 form-group">	
							<label class="control-label">Target Waktu </label>
							<div class="input-group">
							<span type="text" class="form-control input-sm target_waktu"></span>
								<div class="input-group-addon">
									<span class="">bln</span>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-xs-6 form-group waktu">	
							<label class="control-label">Realisasi Waktu</label>
							<div class="input-group">
								<input type="text" name="realisasi_waktu"  required class="form-control input-sm realisasi_waktu" placeholder="realisasi">
								<div class="input-group-addon">
									<span class="">bln</span>
								</div>
							</div>
						</div>
					</div>


					<div class="row" style="margin-top:-20px;"> 

						<div class="col-md-6 col-xs-6 form-group">
							<label class="control-label">Target Cost </label>
							<div class="input-group">
								<div class="input-group-addon">
									<span class="">Rp.</span>
								</div>
								<span type="text" class="form-control input-sm target_cost"></span>
							</div>
						</div>
						<div class="col-md-6 col-xs-6 form-group cost cost">	
							<label class="control-label">Realisasi Cost  </label>
							<div class="input-group">
								<div class="input-group-addon">
									<span class="">Rp.</span>
								</div>
								<input type="text" id="rupiah" name="realisasi_cost"  required class="form-control input-sm realisasi_cost" placeholder="cost realisasi">
							</div>
						</div>
					</div>

					<hr>

					<div class="row">
						<div class="col-md-12 form-group label_kegiatan_tahunan">
								<strong>Indikator </strong>
								<p class="text-info " style="margin-top:1px;">
									<span class="indikator_label"></span>
								</p>
						</div>
					</div>
					<div class="row" style="margin-top:-10px;"> 
						<div class="col-md-6 col-xs-6 form-group">	
							<label class="control-label">Target Quantity </label>
							<div class="input-group">
							<span type="text" class="form-control input-sm target_quantity"></span>
								<div class="input-group-addon">
									<span class="satuan"></span>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-xs-6 form-group quantity">	
							<label class="control-label">Realisasi Quantity</label>
							<div class="input-group">
								<input type="text" name="realisasi_quantity" required class="form-control input-sm realisasi_quantity" placeholder="realisasi">
								<div class="input-group-addon">
									<span class="satuan"></span>
								</div>
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

	var cost_format = document.getElementById('rupiah');
	cost_format.addEventListener('keyup', function(e)
	{
        cost_format.value = formatRupiah(this.value);
        
	}); 

	$('.modal-realisasi_tahunan').on('shown.bs.modal', function(){
		

		if ( $('.realisasi_angka_kredit').val() == ""  ){
			$(this).find('input:text')[0].focus();
		}else{
			$(this).find('input:text')[4].focus();
		}
		


		$('.modal-realisasi_tahunan').find('[name=realisasi_quality]').val(100);
		reset_submit_kt();
	});

	$('.modal-realisasi_tahunan').on('hidden.bs.modal', function(){
		$('.quantity,.cost').removeClass('has-error');
		$('.modal-realisasi_tahunan').find('[name=realisasi_quantity],[name=realisasi_angka_kredit],[name=realisasi_quality],[name=realisasi_waktu],[name=realisasi_cost]').val('');
	});



	$('.realisasi_quantity').on('click', function(){
		$('.quantity').removeClass('has-error');
	});

	$('.realisasi_quality').on('click', function(){
		$('.quality').removeClass('has-error');
	});

	$('.realisasi_waktu').on('click', function(){
		$('.waktu').removeClass('has-error');
	});

	$('.realisasi_cost').on('click', function(){
		$('.cost').removeClass('has-error');
	});


	function on_submit_kt(){
		$('.modal-realisasi_tahunan').find('.button_simpan').addClass('fa-spinner faa-spin animated');
		$('#submit-save').prop('disabled',true);
	}
	function reset_submit_kt(){
		$('.modal-realisasi_tahunan').find('.button_simpan').removeClass('fa-spinner faa-spin animated');
		$('.modal-realisasi_tahunan').find('.button_simpan').addClass('fa-floppy-o');
		$('#submit-save').prop('disabled',false);
	}

	$(document).on('click','#submit-save',function(e){

		@if ( $capaian->PegawaiYangDinilai->Eselon->id_jenis_jabatan  == '5')
			save_jft();
		@else
			save_eselon();
		@endif


	});

	function save_eselon(){
		on_submit_kt();
		var data = $('#realisasi_tahunan_form').serialize();

		//alert(data);
		$.ajax({
			url		: '{{ url("api/simpan_realisasi_kegiatan_tahunan") }}',
			type	: 'POST',
			data	:  data,
			success	: function(data , textStatus, jqXHR) {
				
				//$('#program_table').DataTable().ajax.reload(null,false);
               
				reset_submit_kt();
				Swal.fire({
					title: "",
					text: "Sukses",
					type: "success",
					width: "200px", 
					showConfirmButton: false,
					allowOutsideClick : false,
					timer:1500
				}).then(function () {
					$('.modal-realisasi_tahunan').modal('hide');
					$('#realisasi_kegiatan_tahunan_table').DataTable().ajax.reload(null,false);
					
					
					
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
					((index == 'realisasi_quality')?$('.quality').addClass('has-error'):'');
					((index == 'realisasi_waktu')?$('.waktu').addClass('has-error'):'');
					((index == 'realisasi_cost')?$('.cost').addClass('has-error'):'');
					
					reset_submit_kt();
					
				
				});

			
			}
			
		});
	}

	function save_jft(){
		on_submit_kt();
		var data = $('#realisasi_tahunan_form').serialize();

		//alert(data);
		$.ajax({
			url		: '{{ url("api/simpan_realisasi_kegiatan_tahunan_5") }}',
			type	: 'POST',
			data	:  data,
			success	: function(data , textStatus, jqXHR) {
				
				//$('#program_table').DataTable().ajax.reload(null,false);
               
				reset_submit_kt();
				Swal.fire({
					title: "",
					text: "Sukses",
					type: "success",
					width: "200px", 
					showConfirmButton: false,
					allowOutsideClick : false,
					timer:1500
				}).then(function () {
					$('.modal-realisasi_tahunan').modal('hide');
					$('#realisasi_kegiatan_tahunan_table').DataTable().ajax.reload(null,false);
					
					
					
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
					((index == 'realisasi_quality')?$('.quality').addClass('has-error'):'');
					((index == 'realisasi_waktu')?$('.waktu').addClass('has-error'):'');
					((index == 'realisasi_cost')?$('.cost').addClass('has-error'):'');
					
					reset_submitx();
					
				
				});

			
			}
			
		});
	}


	$(document).on('click','#submit-update',function(e){


		@if ( $capaian->PegawaiYangDinilai->Eselon->id_jenis_jabatan  == '5')
			update_jft();
		@else
			update_eselon();
		@endif

	});

	function update_eselon(){
		on_submit_kt();
		var data = $('#realisasi_tahunan_form').serialize();

		//alert(data);
		$.ajax({
			url		: '{{ url("api/update_realisasi_kegiatan_tahunan") }}',
			type	: 'POST',
			data	:  data,
			success	: function(data , textStatus, jqXHR) {
				
			
				reset_submit_kt();
				Swal.fire({
					title: "",
					text: "Sukses",
					type: "success",
					width: "200px", 
					showConfirmButton: false,
					allowOutsideClick : false,
					timer:1500
				}).then(function () {
					$('.modal-realisasi_tahunan').modal('hide');
					$('#realisasi_kegiatan_tahunan_table').DataTable().ajax.reload(null,false);
					
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
					((index == 'realisasi_quality')?$('.quality').addClass('has-error'):'');
					((index == 'realisasi_waktu')?$('.waktu').addClass('has-error'):'');
					((index == 'realisasi_cost')?$('.cost').addClass('has-error'):'');
					reset_submitx();

					
				
				});

			
			}
			
		});
	}

	function update_jft(){
		on_submit_kt();
		var data = $('#realisasi_tahunan_form').serialize();

		//alert(data);
		$.ajax({
			url		: '{{ url("api/update_realisasi_kegiatan_tahunan_5") }}',
			type	: 'POST',
			data	:  data,
			success	: function(data , textStatus, jqXHR) {
				
			
				reset_submit_kt();
				Swal.fire({
					title: "",
					text: "Sukses",
					type: "success",
					width: "200px", 
					showConfirmButton: false,
					allowOutsideClick : false,
					timer:1500
				}).then(function () {
					$('.modal-realisasi_tahunan').modal('hide');
					$('#realisasi_kegiatan_tahunan_table').DataTable().ajax.reload(null,false);
					
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
					((index == 'realisasi_quality')?$('.quality').addClass('has-error'):'');
					((index == 'realisasi_waktu')?$('.waktu').addClass('has-error'):'');
					((index == 'realisasi_cost')?$('.cost').addClass('has-error'):'');
					reset_submitx();

					
				
				});

			
			}
			
		});
	}






</script>