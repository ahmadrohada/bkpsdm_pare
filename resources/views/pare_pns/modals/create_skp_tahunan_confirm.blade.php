<div class="modal fade modal-create_skp_tahunan_confirm" id="CreateSKPTahunanConfirm" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <!-- <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">
                        Create SKP Tahunan Confirm
                    </h4>
			</div> -->
			<form  id="create-skp_tahunan_confirm-form" method="POST" action="">
			<div class="modal-body">
<!-- ============================================================================================================= -->
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs" id="myTab">
					<li class=""><a href="#tab_a" data-toggle="tab"><i class="fa fa-tag"></i> Detail SKP Tahunan </a></li>
					<li class=""><a href="#tab_b" data-toggle="tab" ><i class="fa fa-user"></i>  Detail Data Pribadi</a></li>
					<li class=""><a href="#tab_c" data-toggle="tab"><i class="fa fa-user"></i>  Detail Data Atasan</a></li>
				</ul>


				<div class="tab-content"  style="min-height:300px;">
					<div class="active tab-pane fade" id="tab_a">
<!-- ============================================================================================================= -->
						
						<div class="form-horizontal col-md-6" style="padding-right:90px; margin-top:10px;">
							<div class="form-group form-group-sm">
								<label>Periode SKP</label>
								<span id="periode_label" class="form-control"> TEXT PERIODE</span>
							</div>
						</div>
						<div class="form-horizontal col-md-6" style="margin-top:10px;">
							<div class="form-group form-group-sm masa_penilaian">
								<label>Masa Penilaian</label>
								<div class="input-group input-group-sm ">
									<input type="text" class="form-control tgl mulai" name="tgl_mulai" placeholder="Tanggal Mulai"/>
									<span class="input-group-addon">s.d.</span>
									<input type="text" class="form-control tgl selesai" name="tgl_selesai" placeholder="Tanggal Selesai"/>
								</div>     
							</div>
						</div>

						 
						<div class="form-horizontal col-md-12" style="margin-top:20px;">
							<div class="form-group form-group-sm">
								<label>Jabatan</label>
								<span id="txt_u_jabatan" class="form-control" style="height:48px;"></span>
							</div>
						</div>

						<div class="form-horizontal col-md-12" style="margin-top:5px;">
							<div class="form-group form-group-sm">
								<label>SKPD</label>
								<span id="txt_u_skpd" class="form-control" style="height:48px;"></span>
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
						<span id="u_nip" class="form-control"></span>
					</div>
				</div>

				<div class="form-group form-group-sm" style="margin-top:-10px;">
					<label class="col-md-4 " >Nama Pegawai</label>
					<div class="col-md-8">
						<span id="u_nama" class="form-control"></span>
					</div>
				</div>
									
				<div class="form-group form-group-sm" style="margin-top:-10px;">
					<label class="col-md-4 " >Pangkat / Gol</label>
					<div class="col-md-8">
						<span id="u_golongan" class="form-control"></span>
					</div>
				</div>

				<div class="form-group form-group-sm" style="margin-top:-10px;">
					<label class="col-md-4 " >Eselon</label>
					<div class="col-md-8">
						<span id="u_eselon" class="form-control"></span>
					</div>
				</div>

				<div class="form-group form-group-sm u_jabatan" style="margin-top:-10px;">
					<label class="col-md-4 ">Jabatan</label>
					<div class="col-md-8">
						<span id="u_jabatan" class="form-control" style="height:48px;"></span>
					</div>
				</div>

				<div class="form-group form-group-sm" style="margin-top:-10px;">
					<label class="col-md-4">Unit Kerja</label>
					<div class="col-md-8">
						<span class="form-control" id="u_unit_kerja"  style="height:60px;"></span>
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
						<span id="p_nip" class="form-control"></span>
					</div>
				</div>
	
				<div class="form-group form-group-sm" style="margin-top:-10px;">
					<label class="col-md-4 " >Nama Pegawai</label>
					<div class="col-md-8">
						<span id="p_nama" class="form-control"></span>
					</div>
				</div>
										
				<div class="form-group form-group-sm" style="margin-top:-10px;">
					<label class="col-md-4 " >Pangkat / Gol</label>
					<div class="col-md-8">
						<span id="p_golongan" class="form-control"></span>
					</div>
				</div>
	
				<div class="form-group form-group-sm" style="margin-top:-10px;">
					<label class="col-md-4 " >Eselon</label>
					<div class="col-md-8">
						<span id="p_eselon" class="form-control"></span>
					</div>
				</div>
	
				<div class="form-group form-group-sm p_jabatan" style="margin-top:-10px;">
					<label class="col-md-4 ">Jabatan</label>
					<div class="col-md-8">
						<span id="p_jabatan" class="form-control" style="height:48px;"></span>
					</div>
				</div>
	
				<div class="form-group form-group-sm" style="margin-top:-10px;">
					<label class="col-md-4">Unit Kerja</label>
					<div class="col-md-8">
						<span class="form-control" id="p_unit_kerja"  style="height:60px;"></span>
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
			<div class="modal-footer">
				
					<input type="hidden" class="form-control pegawai_id" name="pegawai_id"  />
					<input type="hidden" class="form-control renja_id" name="renja_id"  />
				
					<input type="hidden" class="form-control u_nama	" name="u_nama"  />
					<input type="hidden" class="form-control u_jabatan_id " name="u_jabatan_id"  />
					<input type="hidden" class="form-control u_golongan_id " name="u_golongan_id"  />

					<input type="hidden" class="form-control p_nama	" name="p_nama"  />
					<input type="hidden" class="form-control p_jabatan_id	" name="p_jabatan_id"  />
					<input type="hidden" class="form-control p_golongan_id " name="p_golongan_id"  />

               	 	{!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_cancel_icon').'" aria-hidden="true"></i> ' . Lang::get('modals.confirm_modal_button_cancel_text'), array('class' => 'btn btn-sm btn-default pull-left ', 'type' => 'button', 'data-dismiss' => 'modal' )) !!}
               	 	{!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_save_icon').' button_simpan" aria-hidden="true"></i> ' . Lang::get('modals.confirm_modal_button_save_text'), array('class' => 'btn btn-sm btn-primary pull-right ', 'type' => 'button', 'id' => 'save_skp_tahunan' )) !!}
			
			
				
			</div>
			</form>
		</div>
   	</div>
</div>







<script type="text/javascript">

	$('.tgl').datetimepicker({
		yearOffset:0,
		lang:'en',
		timepicker:false,
		format:'d-m-Y',
		formatDate:'d-m-Y'
	}); 
 
	
	$('.modal-create_skp_tahunan_confirm').on('shown.bs.modal', function(){
		
		reset_submit();
	});


	$('.modal-create_skp_tahunan_confirm').on('hidden.bs.modal', function(){
		reset_submit();
		$('.u_jabatan, .p_jabatan, .masa_penilaian').removeClass('has-error');
		$('.error_renja_id').hide();
		$('.modal-create_skp_tahunan_confirm').find('[name=tgl_mulai],[name=tgl_selesai]').val('');

		$('.sidebar-mini').attr("style", "padding-right:0px;");

	});

	$('.tgl').on('click', function(){
		$('.masa_penilaian').removeClass('has-error');
	});

	function on_submit(){
		$('.modal-create_skp_tahunan_confirm').find('.button_simpan').addClass('fa-spinner faa-spin animated');
		$('#save_skp_tahunan').prop('disabled',true);
	}
	function reset_submit(){
		$('.modal-create_skp_tahunan_confirm').find('.button_simpan').removeClass('fa-spinner faa-spin animated');
		$('.modal-create_skp_tahunan_confirm').find('.button_simpan').addClass('fa-floppy-o');
		$('#save_skp_tahunan').prop('disabled',false);
	}


	$(document).on('click','.create_skp_tahunan',function(e){
		var periode_id = $(this).data('periode_id') ;
		var jabatan_id = $(this).data('jabatan_id') ;
		var pegawai_id = $(this).data('pegawai_id') ;
		
		show_loader();

		$.ajax({
			url		: '{{ url("api_resource/create_skp_tahunan_confirm") }}',
			type	: 'GET',
			data	:  	{ 
							periode_id : periode_id,
							jabatan_id : jabatan_id,
							pegawai_id : pegawai_id
						},
			success	: function(data) {
				Swal.close();
				$('#myTab a[href="#tab_a"]').tab('show');

				if (data['status']==='pass'){
					$('#periode_label').html(data['periode_label']); 
					$('#u_nip').html(data['u_nip']); 
					$('#u_nama').html(data['u_nama']); 
					$('#u_golongan').html(data['u_pangkat']+' / '+data['u_golongan']); 
					$('#u_eselon').html(data['u_eselon']); 
					$('#u_jabatan').html(data['u_jabatan']); 
					$('#u_unit_kerja').html(data['u_unit_kerja']); 
					$('#txt_u_jabatan').html(data['u_jabatan']); 
					$('#txt_u_skpd').html(data['u_skpd']); 

				
					$('#p_nip').html(data['p_nip']); 
					$('#p_nama').html(data['p_nama']); 
					$('#p_golongan').html(data['p_pangkat']+' / '+data['p_golongan']); 
					$('#p_eselon').html(data['p_eselon']); 
					$('#p_jabatan').html(data['p_jabatan']); 
					$('#p_unit_kerja').html(data['p_unit_kerja']); 

					$('.pegawai_id').val(pegawai_id); 
					$('.renja_id').val(data['renja_id']); 
					$('.u_nama').val(data['u_nama']); 
					$('.u_jabatan_id').val(data['u_jabatan_id']); 
					$('.u_golongan_id').val(data['u_golongan_id']); 
					$('.p_nama').val(data['p_nama']); 
					$('.p_jabatan_id').val(data['p_jabatan_id']); 
					$('.p_golongan_id').val(data['p_golongan_id']); 

					$('.mulai').val(data['tgl_mulai']); 
					$('.selesai').val(data['tgl_selesai']); 


					
					$('.modal-create_skp_tahunan_confirm').modal('show'); 
				}else if (data['status']==='fail'){
					
					switch (data['jenis_jabatan']){
						case 1 :   ; //KA SKPD
							break;

						case 2 : skp_list_bawahan(data['renja_id'],data['jabatan_id']) ; //KABID
							break;

						case 4 : ; //PELAKSANA
							break;


					}
 



				}else{
					Swal.fire({
						title: 'Error!',
						text: 'SKP Tahunan belum bisa dibuat',
						type: 'error',
						confirmButtonText: 'Tutup'
					})
				}
				
			},
			error: function(jqXHR , textStatus, errorThrown) {
					swal.close();
					var test = $.parseJSON(jqXHR.responseText);
					
					var data= test.errors;

					Swal.fire({
						title: 'Error!',
						text: 'SKP Tahunan belum bisa dibuat, '+ data,
						type: 'error',
						confirmButtonText: 'Tutup'
					})
			}
			
		});

	$(document).on('click', '#save_skp_tahunan', function(){
		var data = $('#create-skp_tahunan_confirm-form').serialize();

		on_submit();
		$.ajax({
			url		: '{{ url("api_resource/create_skp_tahunan") }}',
			type	: 'POST',
			data	:  data,
			success	: function(data) {
				
				$('.personal_jm_skp_tahunan').html(data['jm_skp_tahunan']);
				$('.personal_jm_skp_bulanan').html(data['jm_skp_bulanan']);
				reset_submit();
				Swal.fire({
					title: "",
					text: "Sukses",
					type: "success",
					width: "200px",
					showConfirmButton: false,
					allowOutsideClick : false,
					timer: 1500
				}).then(function () {
						$('.modal-create_skp_tahunan_confirm').modal('hide');
						$('#skp_tahunan_table').DataTable().ajax.reload(null,false);
						$('#skp_tahunan').DataTable().ajax.reload(null,false);
						window.location.assign("skp_tahunan/"+data['skp_tahunan_id']);

				},
					function (dismiss) {
						if (dismiss === 'timer') {
							
						}
					}
			)	
			},
			error: function(jqXHR , textStatus, errorThrown) {
				reset_submit();
				var test = $.parseJSON(jqXHR.responseText);
				
				var data= test.errors;

				$.each(data, function(index,value){
					//alert (index+":"+value);
					
					//error message
					if ( (index == 'tgl_mulai') | (index == 'tgl_selesai') | (index == 'masa_penilaian')){

						$('#myTab a[href="#tab_a"]').tab('show');
						$('.masa_penilaian').addClass('has-error')
					}

					if (index == 'u_jabatan_id'){

						$('#myTab a[href="#tab_b"]').tab('show');
						$('.u_jabatan').addClass('has-error')
					}

					if (index == 'p_jabatan_id'){

						$('#myTab a[href="#tab_c"]').tab('show');
						$('.p_jabatan').addClass('has-error')
					}

					if (index == 'renja_id'){

						$('#myTab a[href="#tab_a"]').tab('show');
						$('.error_renja_id').show();
					}

					
				
				});
				
			}
			
		  });


	});

		


});
</script>