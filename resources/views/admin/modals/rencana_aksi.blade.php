<div class="modal fade modal-rencana_aksi" id="createIndikatorProgram" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Rencana Aksi
                </h4>
            </div>

            <form  id="rencana_aksi_form" method="POST" action="">
			<input type="hidden" required name="kegiatan_tahunan_id" class="kegiatan_tahunan_id">
			<input type="hidden" required name="indikator_kegiatan_id" class="indikator_kegiatan_id">
			<input type="hidden" required name="rencana_aksi_id" class="rencana_aksi_id">
			<input type="hidden" required name="renja_id" class="renja_id" value="{!! $skp->renja_id !!}">
			<div class="modal-body">
					
					<br>
					<!-- <div class="row">
						<div class="col-md-12 form-group label_kegiatan_tahunan ">
							<label class="control-label">Kegiatan Tahunan</label>
							<p class="kegiatan_tahunan_label"></p>
						</div>
					</div> -->

					<div class="row">
						<div class="col-md-12 form-group label_indikator_kegiatan ">
							<label class="control-label">Indikator Kegiatan</label>
							<p class="indikator_kegiatan_label"></p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 form-group target_indikator_kegiatan ">
							<label class="control-label">Target  Quantity</label>
							<p class="txt_output_indikator_kegiatan"></p>
						</div>
					</div>

					<!-- <div class="row">
						<div class="col-md-12 form-group form-group-sm label_indikator_kegiatan">
							<label>Indikator Kegiatan</label>
							<select id= "ind_kegiatan" class="form-control" name="indikator_kegiatan_id" style="width: 100%;">
								<option value = '0' > pilih Indikator Kegiatan </option>
							</select>
						</div>
					</div> -->

					<div class="row">
						<div class="col-md-12 form-group label_rencana_aksi ">
							<label class="control-label">Rencana Aksi :</label>
							<textarea name="label" rows="1" required class="form-control txt-label" id="label" placeholder="" style="resize:none;"></textarea>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12 form-group form-group-sm label_pelaksana">
							<label>Pelaksana</label>
							<select id= "pelaksana" class="form-control" name="pelaksana" style="width: 100%;">
								<?php
								if (in_array( $skp->PejabatYangDinilai->id_jabatan, $id_jabatan_irban)){ //JIKA IRBAN
									echo '<option value = '.$skp->PejabatYangDinilai->id_jabatan.' > Dilaksanakan Sendiri </option>';
								}else{
									echo '<option value = "0" > pilih pejabat pelaksana </option>';
								}
								?>
							</select>
						</div>
					</div>

					<div class="row">
						<div class="tp col-md-6 col-xs-12 form-group form-group-sm label_waktu_pelaksanaan">
							<label>Waktu</label>
							<select class="form-control  waktu_pelaksanaan" multiple="multiple" name="waktu_pelaksanaan[]" style="width: 100%;">
								<option value="01">Januari</option>
								<option value="02">Februari</option>
								<option value="03">Maret</option>
								<option value="04">April</option>
								<option value="05">Mei</option>
								<option value="06">Juni</option>
								<option value="07">Juli</option>
								<option value="08">Agustus</option>
								<option value="09">September</option>
								<option value="10">Oktober</option>
								<option value="11">November</option>
								<option value="12">Desember</option>
							</select>
						</div>

						<div class="tp_edit col-md-6 col-xs-12 form-group form-group-sm label_waktu_pelaksanaan">
							<label>Waktu</label>
							<select class="form-control  waktu_pelaksanaan_edit" name="waktu_pelaksanaan_edit" style="width: 100%;">
								<option value="01">Januari</option>
								<option value="02">Februari</option>
								<option value="03">Maret</option>
								<option value="04">April</option>
								<option value="05">Mei</option>
								<option value="06">Juni</option>
								<option value="07">Juli</option>
								<option value="08">Agustus</option>
								<option value="09">September</option>
								<option value="10">Oktober</option>
								<option value="11">November</option>
								<option value="12">Desember</option>
							</select>
						</div>
						
						<div class="col-md-3 col-xs-12 form-group target">
							<label class="control-label">Target :</label>
							<input type="text" name="target" id="target" required class="form-control input-sm" placeholder="target" onkeypress='return angka(event)'>        
						</div>

						<div class="col-md-3 col-xs-12 form-group satuan">
							<label class="control-label">Satuan :</label>
							<input type="text" name="satuan" autocomplete="off" id="satuan" required class="form-control satuan input-sm" placeholder="satuan">
						</div>
					</div>


			</div>
			<div class="modal-footer">
                {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_cancel_icon').'" aria-hidden="true"></i> Batal', array('class' => 'btn btn-sm btn-default pull-left btn-flat', 'type' => 'button', 'data-dismiss' => 'modal' )) !!}
				{!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_save_icon').' button_simpan" aria-hidden="true"></i> <span name="text_button_submit"></span>', array('class' => 'btn btn-primary btn-sm pull-right btn-flat btn-submit', 'type' => 'button', 'id' => 'simpan_ra' )) !!}
				
            </div>

            </form>
        </div>
    </div>
</div>



<script type="text/javascript">



	/* $('#ind_kegiatan').select2({
		ajax: {
			url				: '{{ url("api_resource/select2_indikator_kegiatan_list") }}',
			dataType		: 'json',
			quietMillis		: 100,
			data			: function (params) {
				var queryParameters = {
					jabatan					: params.term,
					kegiatan_renja_id		: $('.kegiatan_renja_id').val(),
				}
				return queryParameters;
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (item) {
						return {
							text	: item.text,
							id		: item.id,
							target	: item.target,
							satuan 	: item.satuan,
						}	
					})
				};		
			}
		},
	}); */

/* 
	$('#ind_kegiatan').on('select2:select', function (e) {
		var data = e.params.data;
		//alert(data['target']);
		$('.modal-rencana_aksi').find('[id=target]').val(data['target']);
		$('.modal-rencana_aksi').find('[id=satuan]').val(data['satuan']);


	}); */

	$('.waktu_pelaksanaan,.waktu_pelaksanaan_edit').select2();
	
	$('#pelaksana').select2({
		ajax: {
			url				: '{{ url("api_resource/select2_bawahan_list") }}',
			dataType		: 'json',
			quietMillis		: 500,
			data			: function (params) {
				var queryParameters = {
					jabatan				: params.term,
					jabatan_id		    : {{$skp->u_jabatan_id}}
				}
				return queryParameters;
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (item) {
						return {
							text	: item.jabatan,
							id		: item.id,
						}		
					})
				};
			}
		},
	});

	$('.modal-rencana_aksi').on('shown.bs.modal', function(){
		reset_submit();
	});

	$('.modal-rencana_aksi').on('hidden.bs.modal', function(){
		$('.label_indikator_kegiatan,.label_rencana_aksi,.label_waktu_pelaksanaan,.target,.satuan,.label_pelaksana').removeClass('has-error');
		$('.modal-rencana_aksi').find('[name=kegiatan_tahunan_id],[name=indikator_kegiatan_id],[name=rencana_aksi_id],[name=label],[name=target],[name=satuan]').val('');
		$('.waktu_pelaksanaan').select2('val','');
		$('#ind_kegiatan').select2('val','');
	});

	$('.label_pelaksana').on('click', function(){
		$('.label_pelaksana').removeClass('has-error');
	});
	$('.label_indikator_kegiatan').on('click', function(){
		$('.label_indikator_kegiatan').removeClass('has-error');
	});
	$('.label_rencana_aksi').on('click', function(){
		$('.label_rencana_aksi').removeClass('has-error');
	});
	$('.target').on('click', function(){
		$('.target').removeClass('has-error');
	});
	$('.satuan').on('click', function(){
		$('.satuan').removeClass('has-error');
	});

	$('.label_waktu_pelaksanaan').on('click', function(){
		$('.label_waktu_pelaksanaan').removeClass('has-error');
	});

	
	function on_submit(){
		$('.modal-rencana_aksi').find('.button_simpan').addClass('fa-spinner faa-spin animated');
		$('#submit-save_rencana_aksi').prop('disabled',true);
	}
	function reset_submit(){
		$('.modal-rencana_aksi').find('.button_simpan').removeClass('fa-spinner faa-spin animated');
		$('.modal-rencana_aksi').find('.button_simpan').addClass('fa-floppy-o');
		$('#submit-save_rencana_aksi').prop('disabled',false);
	}
	
	$(document).on('click','#submit-save_rencana_aksi',function(e){
		
		on_submit();
		var data = $('#rencana_aksi_form').serialize();
 
		//alert(data);
		$.ajax({
			url		: '{{ url("api_resource/simpan_rencana_aksi") }}',
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
					$('.modal-rencana_aksi').modal('hide');
					$('#rencana_aksi_table').DataTable().ajax.reload(null,false);
					//$('#rencana_aksi_time_table').DataTable().ajax.reload(null,false);
					jQuery('#keg_tahunan_3_tree').jstree(true).refresh(true);
					jQuery('#skp_bulanan_tree').jstree(true).refresh(true);
					
					
					
				},
					
					function (dismiss) {
						if (dismiss === 'timer') {
							
						}
					}
				)	
				$("#submit-save_rencana_aksi").show();
			},
			error: function(jqXHR , textStatus, errorThrown) {

				var test = $.parseJSON(jqXHR.responseText);
				
				var data= test.errors;

				$.each(data, function(index,value){
					//alert (index+":"+value);
					
					//error message
					((index == 'indikator_kegiatan_id')?$('.label_indikator_kegiatan').addClass('has-error'):'');
					((index == 'label')?$('.label_rencana_aksi').addClass('has-error'):'');
					((index == 'waktu_pelaksanaan')?$('.label_waktu_pelaksanaan').addClass('has-error'):'');
					((index == 'pelaksana')?$('.label_pelaksana').addClass('has-error'):'');
					((index == 'target')?$('.target').addClass('has-error'):'');
					((index == 'satuan')?$('.satuan').addClass('has-error'):'');
					reset_submit();
				
					
				
				});
				
			
			}
			
		});


	});


	$(document).on('click','#submit-update_rencana_aksi',function(e){

		on_submit();
		var data = $('#rencana_aksi_form').serialize();

		//alert(data);
		$.ajax({
			url		: '{{ url("api_resource/update_rencana_aksi") }}',
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
					$('.modal-rencana_aksi').modal('hide');
					$('#rencana_aksi_table').DataTable().ajax.reload(null,false);
					//$('#rencana_aksi_time_table').DataTable().ajax.reload(null,false);
					jQuery('#keg_tahunan_3_tree').jstree(true).refresh(true);
					jQuery('#skp_bulanan_tree').jstree(true).refresh(true);
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
					((index == 'label')?$('.label_rencana_aksi').addClass('has-error'):'');
					((index == 'waktu_pelaksanaan')?$('.label_waktu_pelaksanaan').addClass('has-error'):'');
					((index == 'pelaksana')?$('.label_pelaksana').addClass('has-error'):'');
					((index == 'target')?$('.target').addClass('has-error'):'');
					((index == 'satuan')?$('.satuan').addClass('has-error'):'');
					reset_submit();

					
				
				});

			
			}
			
		});

	});

</script>