<div class="modal fade create-skp_tahunan_confirm_modal" id="createSKPTahunanConfirm" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">
                        Create SKP Tahunan Confirm
                    </h4>
            </div>

            
			<form  id="create-skp_tahunan_confirm-form" method="POST" action="">
			<div class="modal-body">
				<div class="row" style="margin-left:-30px !important;">
					<div class=" panel-info col-md-12">
						<!-- Default panel contents -->
						<div class="col-md-4">
							<div class="form-group form-group-sm">
								<label>Periode</label>
								<span class="form-control periode_tahunan" ></span>
							</div>
						</div>
						<div class="col-md-8">
							<div class="form-group form-group-sm">
								<label>Masa Penilaian</label>
								<div class="input-group input-group-sm">
								<input type="text" class="form-control tgl mulai" name="tgl_mulai" placeholder="Tanggal Mulai"/>
								<span class="input-group-addon">s.d.</span>
								<input type="text" class="form-control tgl selesai" name="tgl_selesai" placeholder="Tanggal Selesai"/>
							</div>     
							</div>
						</div>
						

					</div>
				</div>

				<hr>
				<!-- ================= END OF header content ===================   -->
				<div class="row" style="margin-left:-30px !important;">
					<div class=" panel-info col-md-12">
						<!-- Default panel contents -->
						<div class="col-md-6">
							<div class="panel-default"><span class="text-primary"> I. PEJABAT PENILAI</span></div>
							



							<div class="form-group form-group-sm" style="margin-top:10px;">
								<label for="label">Nama</label>
								<span class="form-control p_nama" required="required" name="p_nama" style="margin-top:-3px;"></span>
							</div>
								
								
							<div class="form-group form-group-sm" style="margin-top:-5px;">
								<label for="label">NIP</label>
								<span class="form-control p_nip" required="required" name="p_nip" style="margin-top:-3px;"></span>
							</div>
							
							<div class="form-group form-group-sm"  style="margin-top:-5px;">                   		
								<label for="label">Pangkat/Gol.Ruang </label>
								<span  class="form-control p_pangkat_golongan" required="required" name="p_pangkat_golongan" style="margin-top:-3px;"></span>
							</div>
							
							<div class="form-group form-group-sm"  style="margin-top:-5px;">  
								<label for="label">Jabatan</label>
								<span class="form-control p_jabatan" required="required" name="p_jabatan" style="height:50px; margin-top:-3px;"></span>
							</div>
							
							
							<div class="form-group form-group-sm"  style="margin-top:-5px;">  
								<label for="label">SKPD</label>
								<span class="form-control p_jabatan" required="required" name="p_jabatan" style="height:50px; margin-top:-3px;"></span>
							</div>   
							
							<div class="form-group form-group-sm"  style="margin-top:-5px;">  
								<label for="label">Unit Kerja</label>
								<span class="form-control p_jabatan" required="required" name="p_jabatan" style="height:50px; margin-top:-3px;"></span>
							</div>  

						</div>
						
						<div class="col-md-6">
							<div class="panel-default"><span class="text-primary"> II. PEGAWAI NEGERI SIPIL YANG DINILAI</span></div>
							
							<div class="form-group form-group-sm" style="margin-top:10px;">
								<label for="label">Nama</label>
								<span class="form-control u_nama" required="required" name="u_nama" style="margin-top:-3px;"></span>
							</div>
								
								
							<div class="form-group form-group-sm" style="margin-top:-5px;">
								<label for="label">NIP</label>
								<span class="form-control u_nip" required="required" name="u_nip" style="margin-top:-3px;"></span>
							</div>
							
							<div class="form-group form-group-sm"  style="margin-top:-5px;">                   		
								<label for="label">Pangkat/Gol.Ruang </label>
								<span  class="form-control u_pangkat_golongan" required="required" name="u_pangkat_golongan" style="margin-top:-3px;"></span>
							</div>
							
							<div class="form-group form-group-sm"  style="margin-top:-5px;">  
								<label for="label">Jabatan</label>
								<span class="form-control u_jabatan" required="required" name="u_jabatan" style="height:50px; margin-top:-3px;"></span>
							</div>
							
							
							<div class="form-group form-group-sm"  style="margin-top:-5px;">  
								<label for="label">SKPD</label>
								<span class="form-control u_skpd" required="required" name="u_skpd" style="height:50px; margin-top:-3px;"></span>
							</div>   
							
							<div class="form-group form-group-sm"  style="margin-top:-5px;">  
								<label for="label">Unit Kerja</label>
								<span class="form-control u_unit_kerja" required="required" name="u_unit_kerja" style="height:50px; margin-top:-3px;"></span>
							</div>  
						</div>
						

					</div>
				</div>

				

			</div>
			<div class="modal-footer">
                {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_cancel_icon').'" aria-hidden="true"></i> ' . Lang::get('modals.confirm_modal_button_cancel_text'), array('class' => 'btn btn-sm btn-default pull-left btn-flat', 'type' => 'button', 'data-dismiss' => 'modal' )) !!}
                {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_save_icon').'" aria-hidden="true"></i> ' . Lang::get('modals.confirm_modal_button_save_text'), array('class' => 'btn btn-sm btn-primary pull-right btn-flat', 'type' => 'button', 'id' => 'create_skp_tahunan' )) !!}
            </div>

			
				<input type="hidden" class="form-control pegawai_id" name="pegawai_id"  />
				<input type="hidden" class="form-control perjanjian_kinerja_id" name="perjanjian_kinerja_id"  />
			
				<input type="hidden" class="form-control jabatan_id	" name="jabatan_id"  />
				<input type="hidden" class="form-control u_nama	" name="u_nama"  />

            </form>
                    </div>
                </div>
            </div>







<script type="text/javascript">
$(document).ready(function() {


	$('.tgl').datetimepicker({
		yearOffset:0,
		lang:'en',
		timepicker:false,
		format:'d-m-Y',
		formatDate:'d-m-Y'
	});
	

	$(document).on('click', '#create_skp_tahunan', function(){
		var data = $('#create-skp_tahunan_confirm-form').serialize();

		$.ajax({
			url		: '{{ url("api_resource/create_skp_tahunan") }}',
			type	: 'POST',
			data	:  data,
			success	: function(data , textStatus, jqXHR) {
				$('#skp_tahunan').DataTable().ajax.reload(null,false);
				

				swal({
					title: "",
					text: "Sukses",
					type: "success",
					width: "200px",
					showConfirmButton: false,
					allowOutsideClick : false,
					timer: 1500
				}).then(function () {
						$('.create-skp_tahunan_confirm_modal').modal('hide');
				},
					function (dismiss) {
						if (dismiss === 'timer') {
							
						}
					}
			)	
			},
			error: function(jqXHR , textStatus, errorThrown) {

				
			}
			
		  });


	});

	
    
	

});
</script>