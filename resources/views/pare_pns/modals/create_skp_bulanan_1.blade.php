<div class="modal fade modal-skp_bulanan" id="CreateSKPBulanan" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
		<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    SKP Bulanan KABan
                </h4>
            </div>

            <form  id="skp_bulanan_form" method="POST" action="">
			<input type="hidden"  name="skp_tahunan_id">
			<input type="hidden"  name="tgl_mulai">
			<input type="hidden"  name="pegawai_id">
			<input type="hidden"  name="u_jabatan_id">
			<input type="hidden"  name="u_nama">
			<input type="hidden"  name="p_jabatan_id">
			<input type="hidden"  name="p_nama">
			<div class="modal-body">
					
					<br>

					<div class="form-horizontal col-md-12" style="margin-top:20px;">
						<div class="form-group form-group-sm">
							<label>SKP Tahunan</label>
							<span name="periode_skp" class="form-control" style=""></span>
						</div>
					</div>

					<div class="form-horizontal col-md-12" style="margin-top:0px;">
						<div class="form-group form-group-sm">
							<label>Nama Pegawai</label>
							<span name="u_nama" class="form-control" style=""></span>
						</div>
					</div>

					<div class="form-horizontal col-md-12" style="margin-top:0px;">
						<div class="form-group form-group-sm">
							<label>Jabatan</label>
							<span name="u_jabatan" class="form-control" style=""></span>
						</div>
					</div>

					<div class="form-horizontal col-md-12" style="margin-top:0px;">
						<div class="form-group form-group-sm">
							<label>Nama Atasan</label>
							<span name="p_nama" class="form-control" style=""></span>
						</div>
					</div>

					<div class="form-horizontal col-md-12" style="margin-top:0px;">
						<div class="form-group form-group-sm">
							<label>Jabatan Atasan</label>
							<span name="p_jabatan" class="form-control" style=""></span>
						</div>
					</div>

					<div class="row tp">
						<div class="col-md-12 form-group form-group-sm label_periode_skp_bulanan">
							<label>Periode SKP Bulanan</label>
							<select class="form-control  periode_skp_bulanan" multiple="multiple" name="periode_skp_bulanan[]" style="width: 100%;">
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
					</div>

					<!-- <div class="row tp_edit">
						<div class="col-md-12 form-group form-group-sm label_periode_skp_tahunan">
							<label>Waktu</label>
							<select class="form-control  periode_skp_tahunan_edit" name="periode_skp_tahunan_edit" style="width: 100%;">
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
					</div> -->



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

	$('.periode_skp_bulanan,.periode_skp_bulanan_edit').select2();
	

	$('.modal-skp_bulanan').on('shown.bs.modal', function(){
		
		reset_submit();
	});

	$('.modal-skp_bulanan').on('hidden.bs.modal', function(){
		reset_submit();
		$('.periode_skp_bulanan').select2('val','');
		$('.periode_skp_bulanan').select2('destroy');
		$('.periode_skp_bulanan,.periode_skp_bulanan_edit').select2();
	});

	$('.label_periode_skp_bulanan').on('click', function(){
		$('.label_periode_skp_bulanan').removeClass('has-error');
	});

	function on_submit(){
		$('.modal-skp_bulanan').find('.button_simpan').addClass('fa-spinner faa-spin animated');
		$('#submit-save_skp_bulanan').prop('disabled',true);
	}
	function reset_submit(){
		$('.modal-skp_bulanan').find('.button_simpan').removeClass('fa-spinner faa-spin animated');
		$('.modal-skp_bulanan').find('.button_simpan').addClass('fa-floppy-o');
		$('#submit-save_skp_bulanan').prop('disabled',false);
	}

	$(document).on('click','#submit-save_skp_bulanan',function(e){
		
		on_submit();
		var data = $('#skp_bulanan_form').serialize();
 
		//alert(data);
		$.ajax({
			url		: '{{ url("api/create_skp_bulanan") }}',
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
					$('.modal-skp_bulanan').modal('hide');
					$('#skp_bulanan_table').DataTable().ajax.reload(null,false);
					jQuery('#skp_bulanan_tree').jstree(true).refresh(true);
					
					
				},
					
					function (dismiss) {
						if (dismiss === 'timer') {
							
						}
					}
				)	
				$("#submit-save_skp_bulanan").show();
			},
			error: function(jqXHR , textStatus, errorThrown) {
				reset_submit();
				var test = $.parseJSON(jqXHR.responseText);
				
				var data= test.errors;

				$.each(data, function(index,value){
					//alert (index+":"+value);
					
					//error message
					((index == 'periode_skp_bulanan')?$('.label_periode_skp_bulanan').addClass('has-error'):'');
					
				
					
				
				});
				
			
			}
			
		});


	});


	$(document).on('click','#submit-update_skp_bulanan',function(e){

			on_submit();
			var data = $('#skp_bulanan_form').serialize();

			//alert(data);
			$.ajax({
				url		: '{{ url("api/update_skp_bulanan") }}',
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
						$('.modal-skp_bulanan').modal('hide');
						$('#skp_bulanan_table').DataTable().ajax.reload(null,false);
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
						((index == 'periode_skp_tahunan')?$('.label_periode_skp_tahunan').addClass('has-error'):'');
						reset_submit();

						
					
					});

				
				}
				
			});

	});

</script>