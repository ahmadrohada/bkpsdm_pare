<div class="modal fade modal-create_capaian_triwulan" id="CreateSKPTahunanConfirm" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <!-- <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">
                        Create SKP Tahunan Confirm
                    </h4>
			</div> -->
			<form  id="create-capaian_triwulan-form" method="POST" action="">
			<div class="modal-body">
<!-- ============================================================================================================= -->
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs" id="myTab">
					<li class=""><a href="#tab_a" data-toggle="tab"><i class="fa fa-tag"></i> Capaian Triwulan </a></li>
					<li class=""><a href="#tab_b" data-toggle="tab" ><i class="fa fa-user"></i> Data Pribadi</a></li>
					<li class=""><a href="#tab_c" data-toggle="tab"><i class="fa fa-user"></i> Data Atasan</a></li>
				</ul>


				<div class="tab-content"  style="min-height:320px;">
					<div class="active tab-pane fade" id="tab_a">
<!-- ============================================================================================================= -->
						<div class="form-horizontal col-md-12" style="margin-top:10px;">
							<div class="form-group form-group-sm masa_penilaian">
								<label>Periode SKP Tahunan</label>
								<span class="form-control periode_skp_tahunan" name="periode_skp_tahunan"></span>
							</div>
						</div>
						<div class="form-horizontal col-md-12">
							<div class="form-group form-group-sm">
								<label>Masa Penilaian SKP Tahunan</label>
								<span class="form-control masa_penilaian_skp_tahunan" name="masa_penilaian_skp_tahunan"></span>
							</div>
						</div>
						<div class="form-horizontal col-md-12" style="margin-top:10px;">
							<div class="form-group form-group-sm masa_penilaian">
								<label>Periode Triwulan</label>
								<span class="form-control periode_capaian_triwulan" name="periode_capaian_triwulan"></span>
							</div>
						</div>
						
						<div class="form-horizontal col-md-12">
							<div class="form-group form-group-sm">
								<label>Jabatan</label>
								<span class="form-control u_jabatan" name="u_jabatan" style="height:48px;"></span>
							</div>
						</div>
						
					
					
<!-- ============================================================================================================= -->
					</div>
					<div class="tab-pane fade" id="tab_b">
<!-- ============================================================================================================= -->
			<div class="form-horizontal col-md-12" style="margin-left:-16px; margin-top:10px; padding-right:0px;">
					
				<div class="form-group form-group-sm"  style="margin-top:10px;">
					<label class="col-md-4">NIP</label>
					<div class="col-md-8">
						<span name="u_nip" class="form-control"></span>
					</div>
				</div>

				<div class="form-group form-group-sm" style="margin-top:-10px;">
					<label class="col-md-4 " >Nama Pegawai</label>
					<div class="col-md-8">
						<span name="u_nama" class="form-control"></span>
					</div>
				</div>
									
				<div class="form-group form-group-sm" style="margin-top:-10px;">
					<label class="col-md-4 " >Pangkat / Gol</label>
					<div class="col-md-8">
						<span name="u_pangkatgolongan" class="form-control"></span>
					</div>
				</div>

				<div class="form-group form-group-sm" style="margin-top:-10px;">
					<label class="col-md-4 " >Eselon</label>
					<div class="col-md-8">
						<span name="u_eselon" class="form-control"></span>
					</div>
				</div>

				<div class="form-group form-group-sm u_jabatan" style="margin-top:-10px;">
					<label class="col-md-4 ">Jabatan</label>
					<div class="col-md-8">
						<span name="u_jabatan" class="form-control" style="height:48px;"></span>
					</div>
				</div>

				<div class="form-group form-group-sm" style="margin-top:-10px;">
					<label class="col-md-4">Unit Kerja</label>
					<div class="col-md-8">
						<span class="form-control" name="u_unit_kerja"  style="height:60px;"></span>
					</div>
				</div>
			</div>	 



<!-- ============================================================================================================= -->
					</div>			
					<div class=" tab-pane fade" id="tab_c">
<!-- ============================================================================================================= -->
			<div class="form-horizontal col-md-12" style="margin-left:-16px; margin-top:10px; padding-right:0px;">
					
				<div class="form-group form-group-sm"  style="margin-top:10px;">
					<label class="col-md-4">NIP</label>
					<div class="col-md-8">
						<span name="p_nip" class="form-control"></span>
					</div>
				</div>
	
				<div class="form-group form-group-sm" style="margin-top:-10px;">
					<label class="col-md-4 " >Nama Pegawai</label>
					<div class="col-md-8">
						<span name="p_nama" class="form-control"></span>
					</div>
				</div>
										
				<div class="form-group form-group-sm" style="margin-top:-10px;">
					<label class="col-md-4 " >Pangkat / Gol</label>
					<div class="col-md-8">
						<span name="p_pangkatgolongan" class="form-control"></span>
					</div>
				</div>
	
				<div class="form-group form-group-sm" style="margin-top:-10px;">
					<label class="col-md-4 " >Eselon</label>
					<div class="col-md-8">
						<span name="p_eselon" class="form-control"></span>
					</div>
				</div>
	
				<div class="form-group form-group-sm p_jabatan" style="margin-top:-10px;">
					<label class="col-md-4 ">Jabatan</label>
					<div class="col-md-8">
						<span name="p_jabatan" class="form-control" style="height:48px;"></span>
					</div>
				</div>
	
				<div class="form-group form-group-sm" style="margin-top:-10px;">
					<label class="col-md-4">Unit Kerja</label>
					<div class="col-md-8">
						<span class="form-control" name="p_unit_kerja"  style="height:60px;"></span>
					</div>
				</div>
			</div>	 

<!-- ============================================================================================================= -->
					</div>
				</div>			
			</div>
		
			<span class="error_renja_id" style="margin-left:20px; color:red;" hidden>ID Perjanjian Kinerja Tidak ditemukan !!</span>


<!-- ============================================================================================================= -->
			</div>
			<div class="modal-footer" style="border:none; margin-top:-20px;">
				

					<input type="hidden" class="form-control pegawai_id" name="pegawai_id"  />
					<input type="hidden" class="form-control triwulan" name="triwulan"  />
					<input type="hidden" class="form-control skp_tahunan_id" name="skp_tahunan_id"  />
					<input type="hidden" class="form-control u_nama	" name="u_nama"  />
					<input type="hidden" class="form-control u_jabatan_id " name="u_jabatan_id"  />
					<input type="hidden" class="form-control p_nama	" name="p_nama"  />
					<input type="hidden" class="form-control p_jabatan_id	" name="p_jabatan_id"  />


               	 	{!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_cancel_icon').'" aria-hidden="true"></i> ' . Lang::get('modals.confirm_modal_button_cancel_text'), array('class' => 'btn btn-sm btn-default pull-left ', 'type' => 'button', 'data-dismiss' => 'modal' )) !!}
               	 	{!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_create_icon').' button_simpan" aria-hidden="true"></i> ' . Lang::get('modals.confirm_modal_button_create_text'), array('class' => 'btn btn-sm btn-primary pull-right ', 'type' => 'button', 'id' => 'save_capaian_triwulan' )) !!}
			
			</div>
			</form>
		</div>
   	</div>
</div>







<script type="text/javascript"> 


	$('.modal-create_capaian_triwulan').on('shown.bs.modal', function(){
		$('#myTab a[href="#tab_a"]').tab('show');
	});

	function on_submitx(){
		$('.modal-create_capaian_triwulan').find('.button_simpan').addClass('fa-spinner faa-spin animated');
		$('#save_capaian_triwulan').prop('disabled',true);
	}
	function reset_submitx(){
		$('.modal-create_capaian_triwulan').find('.button_simpan').removeClass('fa-spinner faa-spin animated');
		$('.modal-create_capaian_triwulan').find('.button_simpan').addClass('fa-floppy-o');
		$('#save_capaian_triwulan').prop('disabled',false);
	}



	$(document).on('click', '#save_capaian_triwulan', function(){
		var data = $('#create-capaian_triwulan-form').serialize();
		$.ajax({
			url		: '{{ url("api_resource/simpan_capaian_triwulan") }}',
			type	: 'POST',
			data	:  data,
			success	: function(data , textStatus, jqXHR) {
				$('#capaian_triwulan_table').DataTable().ajax.reload(null,false);
				

				Swal.fire({
					title: "",
					text: "Sukses",
					type: "success",
					width: "200px",
					showConfirmButton: false,
					allowOutsideClick : false,
					timer: 1500
				}).then(function () {
						$('.modal-create_capaian_triwulan').modal('hide');
						$('#capaian_triwulan_table').DataTable().ajax.reload(null,false);
						window.location.assign("capaian-triwulan/"+data+"/edit");

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
					
					
				
				});
				
			},
			beforeSend: function(){
				on_submitx();
			},
			complete: function(){
				reset_submitx();
			} 	
			
		  }); 

		
	});

		



</script>