<div class="modal fade modal-create_capaian_pk_triwulan" id="CreateSKPTahunanConfirm" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <!-- <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">
                        Create SKP Tahunan Confirm
                    </h4>
			</div> -->
			<form  id="create-capaian_pk_triwulan-form" method="POST" action="">
			<div class="modal-body">
<!-- ============================================================================================================= -->
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs" id="myTab">
					<li class=""><a href="#tab_a" data-toggle="tab"><i class="fa fa-tag"></i> Capaian Perjanjian Kinerja - Triwulan </a></li>
				</ul>


				<div class="tab-content"  style="min-height:320px;">
					<div class="active tab-pane fade" id="tab_a">
<!-- ============================================================================================================= -->
						<div class="form-horizontal col-md-12" style="margin-top:10px;">
							<div class="form-group form-group-sm masa_penilaian">
								<label>Periode Perjanjian Kinerja</label>
								<span class="form-control periode_skp_tahunan" name="periode_skp_tahunan"></span>
							</div>
						</div>
						<div class="form-horizontal col-md-12" style="margin-top:10px;">
							<div class="form-group form-group-sm masa_penilaian">
								<label>Periode Triwulan</label>
								<span class="form-control periode_capaian_triwulan" name="periode_capaian_triwulan"></span>
							</div>
						</div>

						<div class="form-horizontal col-md-12" style="margin-top:10px;">
							<div class="form-group form-group-sm masa_penilaian">
								<label>Nama Kepala SKPD</label>
								<span class="form-control nama_kepala_skpd" name="nama_kepala_skpd"></span>
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
				
					<input type="hidden" class="form-control renja_id" name="renja_id"  />
					<input type="hidden" class="form-control triwulan" name="triwulan"  />
               	 	{!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_cancel_icon').'" aria-hidden="true"></i> ' . Lang::get('modals.confirm_modal_button_cancel_text'), array('class' => 'btn btn-sm btn-default pull-left ', 'type' => 'button', 'data-dismiss' => 'modal' )) !!}
               	 	{!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_save_icon').' button_simpan" aria-hidden="true"></i> ' . Lang::get('modals.confirm_modal_button_save_text'), array('class' => 'btn btn-sm btn-primary pull-right', 'type' => 'button', 'id' => 'save_capaian_pk_triwulan' )) !!}
			
			</div>
			</form>
		</div>
   	</div>
</div>







<script type="text/javascript"> 


	$('.modal-create_capaian_pk_triwulan').on('shown.bs.modal', function(){
		$('#myTab a[href="#tab_a"]').tab('show');
		Swal.close();
	});

	$('.modal-create_capaian_pk_triwulan').on('hidden.bs.modal', function(){
		$('.sidebar-mini').attr("style", "padding-right:0px;"); 
	});

	function on_submitx(){
		$('.modal-create_capaian_pk_triwulan').find('.button_simpan').addClass('fa-spinner faa-spin animated');
		$('#save_capaian_pk_triwulan').prop('disabled',true);
	}
	function reset_submitx(){
		$('.modal-create_capaian_pk_triwulan').find('.button_simpan').removeClass('fa-spinner faa-spin animated');
		$('.modal-create_capaian_pk_triwulan').find('.button_simpan').addClass('fa-floppy-o');
		$('#save_capaian_pk_triwulan').prop('disabled',false);
	}



	$(document).on('click', '#save_capaian_pk_triwulan', function(){
		var data = $('#create-capaian_pk_triwulan-form').serialize();
		$.ajax({
			url		: '{{ url("api_resource/simpan_capaian_pk_triwulan") }}',
			type	: 'POST',
			data	:  data,
			success	: function(data , textStatus, jqXHR) {
				$('#capaian_pk_triwulan_table').DataTable().ajax.reload(null,false);
				

				Swal.fire({
					title: "",
					text: "Sukses",
					type: "success",
					width: "200px",
					showConfirmButton: false,
					allowOutsideClick : false,
					timer: 1500
				}).then(function () {
						$('.modal-create_capaian_pk_triwulan').modal('hide');
						$('#capaian_pk_triwulan_table').DataTable().ajax.reload(null,false);
						window.location.assign("capaian_pk-triwulan/"+data+"/edit");

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