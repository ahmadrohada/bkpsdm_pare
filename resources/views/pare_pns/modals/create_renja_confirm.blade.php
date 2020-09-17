<div class="modal fade modal-create_renja_confirm" id="CreateSKPTahunanConfirm" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
           
			<form  id="create-renja_confirm-form" method="POST" action="">
			<div class="modal-body">
<!-- ============================================================================================================= -->
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs" id="myTab">
					<li class=""><a href="#tab_a" data-toggle="tab"><i class="fa fa-tag"></i> Detail Pohon Kinerja </a></li>
					<li class=""><a href="#tab_b" data-toggle="tab" ><i class="fa fa-user"></i>  Detail Kepala SKPD</a></li>
				</ul>


				<div class="tab-content"  style="min-height:300px;">
					<div class="active tab-pane fade" id="tab_a">
<!-- ============================================================================================================= -->
						
						<div class="form-horizontal col-md-12" style="padding-right:90px; margin-top:10px;">
							<div class="form-group form-group-sm">
								<label>Periode SKP</label>
								<span id="periode_label" class="form-control"> TEXT PERIODE</span>
							</div>
						</div>
						

						<div class="form-horizontal col-md-12" >
							<div class="form-group form-group-sm">
								<label>Nama Admin SKPD</label>
								<span id="admin_nama" class="form-control"> TEXT PERIODE</span>
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
						<span id="kaban_nip" class="form-control"></span>
					</div>
				</div>

				<div class="form-group form-group-sm" style="margin-top:-10px;">
					<label class="col-md-4 " >Nama Pegawai</label>
					<div class="col-md-8">
						<span id="kaban_nama" class="form-control"></span>
					</div>
				</div>
									
				<div class="form-group form-group-sm" style="margin-top:-10px;">
					<label class="col-md-4 " >Pangkat / Gol</label>
					<div class="col-md-8">
						<span id="kaban_golongan" class="form-control"></span>
					</div>
				</div>

				<div class="form-group form-group-sm" style="margin-top:-10px;">
					<label class="col-md-4 " >Eselon</label>
					<div class="col-md-8">
						<span id="kaban_eselon" class="form-control"></span>
					</div>
				</div>

				<div class="form-group form-group-sm kaban_jabatan" style="margin-top:-10px;">
					<label class="col-md-4 ">Jabatan</label>
					<div class="col-md-8">
						<span id="kaban_jabatan" class="form-control" style="height:48px;"></span>
					</div>
				</div>

			</div>	 



<!-- ============================================================================================================= -->
				

<!-- ============================================================================================================= -->
					</div>
				</div>			
			</div>
		
			<span class="error_pk_id" style="margin-left:20px; color:red;" hidden>ID Perjanjian Kinerja Tidak ditemukan !!</span>


<!-- ============================================================================================================= -->
			</div>
			<div class="modal-footer">
				
					<input type="hidden" class="form-control periode_id" name="periode_id"  />
					<input type="hidden" class="form-control skpd_id" name="skpd_id"  />
				
					<input type="hidden" class="form-control kaban_nama	" name="kaban_nama"  />
					<input type="hidden" class="form-control kaban_jabatan_id " name="kaban_jabatan_id"  />

					<input type="hidden" class="form-control admin_nama	" name="admin_nama"  />
					<input type="hidden" class="form-control admin_jabatan_id	" name="admin_jabatan_id"  />


               	 	{!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_cancel_icon').'" aria-hidden="true"></i> ' . Lang::get('modals.confirm_modal_button_cancel_text'), array('class' => 'btn btn-sm btn-default pull-left', 'type' => 'button', 'data-dismiss' => 'modal' )) !!}
               	 	{!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_save_icon').'" aria-hidden="true"></i> ' . Lang::get('modals.confirm_modal_button_save_text'), array('class' => 'btn btn-sm btn-primary pull-right ', 'type' => 'button', 'id' => 'save_renja' )) !!}
			
			
				
			</div>
			</form>
		</div>
   	</div>
</div>







<script type="text/javascript">

	
	
	$('.modal-create_renja_confirm').on('shown.bs.modal', function(){
		$('#myTab a[href="#tab_a"]').tab('show');
	});

	$('.modal-create_renja_confirm').on('hidden.bs.modal', function(){
		$('.kaban_jabatan, .p_jabatan, .masa_penilaian').removeClass('has-error');
		$('.error_pk_id').hide();
		$('.modal-create_renja_confirm').find('[name=tgl_mulai],[name=tgl_selesai]').val('');
	});

	

	$(document).on('click','.create_renja',function(e){
		var periode_id = $(this).data('periode_id') ;
		var skpd_id = $(this).data('skpd_id') ;
		var admin_id = {!!  \Auth::user()->id_pegawai !!} ;
		

		$.ajax({
			url		: '{{ url("api_resource/create_renja_confirm") }}',
			type	: 'GET',
			data	:  	{ 
							periode_id : periode_id,
							skpd_id : skpd_id,
							admin_id:admin_id
						},
			success	: function(data) {
				
				if (data['status']==='pass'){
					

					$('#periode_label').html(data['periode_label']); 
					$('#kaban_nip').html(data['kaban_nip']); 
					$('#kaban_nama').html(data['kaban_nama']); 
					$('#kaban_golongan').html(data['kaban_pangkat']+' / '+data['kaban_golongan']); 
					$('#kaban_eselon').html(data['kaban_eselon']); 
					$('#kaban_jabatan').html(data['kaban_jabatan']); 
					$('#admin_nama').html(data['admin_nama']); 

					$('.periode_id').val(periode_id); 
					$('.skpd_id').val(skpd_id); 
					$('.kaban_nama').val(data['kaban_nama']); 
					$('.kaban_jabatan_id').val(data['kaban_jabatan_id']); 
					$('.admin_nama').val(data['admin_nama']); 
					$('.admin_jabatan_id').val(data['admin_jabatan_id']); 


					$('.modal-create_renja_confirm').modal('show'); 
				}else{
					Swal.fire({
						title: 'Error!',
						text: 'Rencana Kerja belum bisa dibuat',
						type: 'error',
						confirmButtonText: 'Tutup'
					})
				}
				
			},
			error: function(jqXHR , textStatus, errorThrown) {

					Swal.fire({
						title: 'Error!',
						text: 'Rencana Kerja belum bisa dibuat',
						type: 'error',
						confirmButtonText: 'Tutup'
					})
			}
			
		});

	$(document).on('click', '#save_renja', function(){
		var data = $('#create-renja_confirm-form').serialize();

		$.ajax({
			url		: '{{ url("api_resource/create_renja") }}',
			type	: 'POST',
			data	:  data,
			success	: function(data , textStatus, jqXHR) {
				$('#renja').DataTable().ajax.reload(null,false);
				

				Swal.fire({
					title: "",
					text: "Sukses",
					type: "success",
					width: "200px",
					showConfirmButton: false,
					allowOutsideClick : false,
					timer: 1500
				}).then(function () {
						$('.modal-create_renja_confirm').modal('hide');
						$('#renja_table').DataTable().ajax.reload(null,false);

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
					if ( (index == 'tgl_mulai') | (index == 'tgl_selesai') | (index == 'masa_penilaian')){

						$('#myTab a[href="#tab_a"]').tab('show');
						$('.masa_penilaian').addClass('has-error')
					}

					if (index == 'kaban_jabatan_id'){

						$('#myTab a[href="#tab_b"]').tab('show');
						$('.kaban_jabatan').addClass('has-error')
					}

					if (index == 'p_jabatan_id'){

						$('#myTab a[href="#tab_c"]').tab('show');
						$('.p_jabatan').addClass('has-error')
					}

					if (index == 'perjanjian_kinerja_id'){

						$('#myTab a[href="#tab_a"]').tab('show');
						$('.error_pk_id').show();
					}

					
				
				});
				
			}
			
		  });


	});

		


});
</script>