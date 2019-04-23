<div class="modal fade modal-create_capaian_bulanan_confirm" id="CreateSKPTahunanConfirm" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <!-- <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">
                        Create SKP Tahunan Confirm
                    </h4>
			</div> -->
			<form  id="create-capaian_bulanan_confirm-form" method="POST" action="">
			<div class="modal-body">
<!-- ============================================================================================================= -->
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs" id="myTab">
					<li class="active"><a href="#tab_a" data-toggle="tab"><i class="fa fa-tag"></i> Capaian Bulanan </a></li>
					<li class=""><a href="#tab_b" data-toggle="tab" ><i class="fa fa-user"></i> Data Pribadi</a></li>
					<li class=""><a href="#tab_c" data-toggle="tab"><i class="fa fa-user"></i> Data Atasan</a></li>
				</ul>


				<div class="tab-content"  style="margin-left:10px; min-height:320px;">
					<div class="active tab-pane" id="tab_a">
<!-- ============================================================================================================= -->
						
						<div class="form-horizontal col-md-6 " style="margin-top:10px;">
							<div class="form-group form-group-sm skp_bulanan_id">
								<label>Periode Capaian</label>
								<span id="periode_label" class="form-control"> TEXT PERIODE</span>
							</div>
						</div>
						<div class="form-horizontal col-md-5 col-md-offset-1" style="margin-top:10px;">
							<div class="form-group form-group-sm masa_penilaian">
								<label>Masa Penilaian SKP</label>
								<div class="input-group input-group-sm ">
									<input type="text" class="form-control tgl mulai" name="tgl_mulai"  placeholder="Tanggal Mulai"/>
									<span class="input-group-addon">s.d.</span>
									<input type="text" class="form-control tgl selesai" name="tgl_selesai"  placeholder="Tanggal Selesai"/>
								</div>     
							</div>
						</div>

						<div class="form-horizontal col-md-12" style="margin-top:20px;">
							<div class="form-group form-group-sm header_list" hidden>
									
								<label>Jabatan Bawahan </label> <label class="pull-right">Kegiatan / Realisasi</label>
							</div>
							
							<div class="form-group form-group-sm" style="margin-top:-10px;">
								<ul class="list-group list-group-unbordered" id="list_bawahan"></ul>
							</div>
						</div>
						

					
					
<!-- ============================================================================================================= -->
					</div>
					<div class="tab-pane" id="tab_b">
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
					<div class=" tab-pane" id="tab_c">
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
			<div class="modal-footer" style="border:none; margin-top:-20px;">
				
					<input type="hidden" class="form-control pegawai_id" name="pegawai_id"  />
					<input type="hidden" class="form-control skp_bulanan_id" name="skp_bulanan_id"  />
					<input type="hidden" class="form-control jm_kegiatan_bulanan	" name="jm_kegiatan_bulanan"  />
				
					<input type="hidden" class="form-control u_nama	" name="u_nama"  />
					<input type="hidden" class="form-control u_jabatan_id " name="u_jabatan_id"  />

					<input type="hidden" class="form-control p_nama	" name="p_nama"  />
					<input type="hidden" class="form-control p_jabatan_id	" name="p_jabatan_id"  />

					<input type="hidden" class="form-control jabatan_id" name="jabatan_id"  />
					<input type="hidden" class="form-control renja_id" name="renja_id"  />
					<input type="hidden" class="form-control jenis_jabatan" name="jenis_jabatan"  />
					<input type="hidden" class="form-control waktu_pelaksanaan" name="waktu_pelaksanaan"  />

               	 	{!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_cancel_icon').'" aria-hidden="true"></i> ' . Lang::get('modals.confirm_modal_button_cancel_text'), array('class' => 'btn btn-sm btn-default pull-left btn-flat', 'type' => 'button', 'data-dismiss' => 'modal' )) !!}
               	 	{!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_save_icon').'" aria-hidden="true"></i> ' . Lang::get('modals.confirm_modal_button_save_text'), array('class' => 'btn btn-sm btn-primary pull-right btn-flat', 'type' => 'button', 'id' => 'save_capaian_bulanan' )) !!}
			
			
				
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

	
	$('.modal-create_capaian_bulanan_confirm').on('shown.bs.modal', function(){
		
	});

	$('.modal-create_capaian_bulanan_confirm').on('hidden.bs.modal', function(){
		$('.u_jabatan, .p_jabatan, .masa_penilaian, .skp_bulanan_id, .jm_kegiatan_bulanan').removeClass('has-error');
		$('.error_renja_id').hide();
		$('.modal-create_capaian_bulanan_confirm').find('[name=tgl_mulai],[name=tgl_selesai]').val('');
		
		document.getElementById('list_bawahan').innerHTML = "";

		
	});

	$('.tgl').on('click', function(){
		$('.masa_penilaian').removeClass('has-error');
	});

	$(document).on('click','.create_capaian_bulanan',function(e){
		var skp_bulanan_id = $(this).data('skp_bulanan_id') ;
		

		$.ajax({
			url		: '{{ url("api_resource/create_capaian_bulanan_confirm") }}',
			type	: 'GET',
			data	:  	{ 
							skp_bulanan_id : skp_bulanan_id
						},
			success	: function(data) {
				
				if (data['status']==='pass'){


					$('#periode_label').html(data['periode_label']); 
					$('.mulai').val(data['tgl_mulai']); 
					$('.selesai').val(data['tgl_selesai']); 
					//$('#jm_kegiatan_bulanan').html(data['jm_kegiatan_bulanan']);

					var bawahan = document.getElementById('list_bawahan');
					for(var i = 0 ; i < data['list_bawahan'].length; i++ ){
						$('.header_list').show(); 
						$("<li class='list-group-item' style='padding:3px 4px 3px 4px;;'>"+data['list_bawahan'][i].jabatan+" <a class='pull-right'>"+data['list_bawahan'][i].jm_keg+"/"+data['list_bawahan'][i].jm_realisasi+"</a> </li>").appendTo(bawahan);
					}
						$("<li class='list-group-item' style='background:#ededed; border-top:solid #3d3d3d 2px; padding:5px 4px 5px 4px;'><b>Total Kegiatan </b><a class='pull-right'>"+data['jm_kegiatan_bulanan']+"</a> </li>").appendTo(bawahan);
						
						
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

					$('.pegawai_id').val(data['pegawai_id']); 
					$('.skp_bulanan_id').val(data['skp_bulanan_id']); 
					$('.jm_kegiatan_bulanan').val(data['jm_kegiatan_bulanan']);
					$('.u_nama').val(data['u_nama']); 
					$('.u_jabatan_id').val(data['u_jabatan_id']); 
					$('.p_nama').val(data['p_nama']); 
					$('.p_jabatan_id').val(data['p_jabatan_id']);
 
					$('.jenis_jabatan').val(data['u_jenis_jabatan']); 
					$('.jabatan_id').val(data['jabatan_id']);
					$('.renja_id').val(data['renja_id']);
					$('.waktu_pelaksanaan').val(data['waktu_pelaksanaan']);
					
					$('.modal-create_capaian_bulanan_confirm').modal('show'); 
				}else if (data['status']==='fail'){
				




				}else{
					Swal.fire({
						title: 'Error!',
						text: 'Capaian Bulanan belum bisa dibuat',
						type: 'error',
						confirmButtonText: 'Tutup'
					})
				}
				
			},
			error: function(jqXHR , textStatus, errorThrown) {

					Swal.fire({
						title: 'Error!',
						text: 'Capaian Bulanan  belum bisa dibuat',
						type: 'error',
						confirmButtonText: 'Tutup'
					})
			}
			
		});

	$(document).on('click', '#save_capaian_bulanan', function(){
		var data = $('#create-capaian_bulanan_confirm-form').serialize();

		$.ajax({
			url		: '{{ url("api_resource/simpan_capaian_bulanan") }}',
			type	: 'POST',
			data	:  data,
			success	: function(data , textStatus, jqXHR) {
				$('#capaian_bulanan').DataTable().ajax.reload(null,false);
				

				Swal.fire({
					title: "",
					text: "Sukses",
					type: "success",
					width: "200px",
					showConfirmButton: false,
					allowOutsideClick : false,
					timer: 1500
				}).then(function () {
						$('.modal-create_capaian_bulanan_confirm').modal('hide');
						$('#skp_bulanan_table').DataTable().ajax.reload(null,false);
						window.location.assign("capaian-bulanan/"+data+"/edit");

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
						$('.masa_penilaian').addClass('has-error');
					}

					if (index == 'jm_kegiatan_bulanan'){

						$('#myTab a[href="#tab_a"]').tab('show');
						$('.jm_kegiatan_bulanan').addClass('has-error');

					}
					if (index == 'skp_bulanan_id'){

						$('#myTab a[href="#tab_a"]').tab('show');
						$('.skp_bulanan_id').addClass('has-error');
					}

					
				
				});
				
			}
			
		  }); 


	});

		


});
</script>