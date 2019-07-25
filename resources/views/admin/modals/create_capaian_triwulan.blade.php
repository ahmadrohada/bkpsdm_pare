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
					<li class="active"><a href="#tab_a" data-toggle="tab"><i class="fa fa-tag"></i> Capaian Triwulan </a></li>
				</ul>


				<div class="tab-content"  style="margin-left:10px; min-height:320px;">
					<div class="active tab-pane" id="tab_a">
<!-- ============================================================================================================= -->
						
						<div class="form-horizontal col-md-12" style="margin-top:10px;">
							<!-- <div class="form-group form-group-sm masa_penilaian">
								<label>Pilih Akhir Periode SKP</label>
								<div class="input-group input-group-sm ">
									<input type="text" class="form-control tgl selesai" name="tgl_selesai"  placeholder="Tanggal Selesai"/>

									<span class="input-group-btn" type="text">
										<span type="button" class="btn btn-info btn-flat tampilkan">Tampilkan</span>
									</span>
								</div>     
							</div> -->
							<div class="form-group form-group-sm masa_penilaian">
								<label>Pilih Periode Capaian Triwulan</label>
								<div class="input-group input-group-sm ">
								
									<select class="form-control selesai">	
										<option value="20-03-2019">Periode I</option>
										<option value="20-06-2019">Periode II</option>
										<option value="20-09-2019">Periode III</option>
										<option value="20-12-2019">Periode IV</option>
									</select>
									<span class="input-group-btn" type="text">
										<span type="button" class="btn btn-info btn-flat tampilkan">Tampilkan</span>
									</span>
								</div>     
							</div>


						</div>
						<div class="form-horizontal col-md-12">
							<div class="form-group form-group-sm">
								<label>Periode SKP Bulanan</label>
								<span class="form-control periode_capaian_triwulan"></span>
							</div>
						</div>
						<div class="form-horizontal col-md-12">
							<div class="form-group form-group-sm">
								<label>Jumlah Capaian / SKP Bulanan</label>
								<span class="form-control jm_cap_skp"></span>
							</div>
						</div>

						<div class="form-horizontal col-md-12" style="padding-right:0px; padding-left:0px;">

							<div class="form-horizontal col-md-12" style="">
								<div class="form-group form-group-sm header_list">
										
									<label>Periode Capaian </label> <label class="pull-right">Jumlah Realisasi</label>
								</div>
								
								<div class="form-group form-group-sm" style="margin-top:-10px;">
									<ul class="list-group list-group-unbordered" id="list_capaian"></ul>
								</div>
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
				
					<input type="hidden" class="form-control tgl_mulai_capaian" name="tgl_mulai_capaian"  />
					<input type="hidden" class="form-control tgl_selesai_capaian" name="tgl_selesai_capaian"  />
					<input type="hidden" class="form-control pegawai_id" name="pegawai_id"  />
				
					<input type="hidden" class="form-control u_nama	" name="u_nama"  />
					<input type="hidden" class="form-control u_jabatan_id " name="u_jabatan_id"  />

					<input type="hidden" class="form-control p_nama	" name="p_nama"  />
					<input type="hidden" class="form-control p_jabatan_id	" name="p_jabatan_id"  />


               	 	{!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_cancel_icon').'" aria-hidden="true"></i> ' . Lang::get('modals.confirm_modal_button_cancel_text'), array('class' => 'btn btn-sm btn-default pull-left btn-flat', 'type' => 'button', 'data-dismiss' => 'modal' )) !!}
               	 	{!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_create_icon').'" aria-hidden="true"></i> ' . Lang::get('modals.confirm_modal_button_create_text'), array('class' => 'btn btn-sm btn-primary pull-right btn-flat', 'type' => 'button', 'id' => 'save_capaian_triwulan' )) !!}
			
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
		formatDate:'d-m-Y',
		closeOnDateSelect : false
	}); 
	$('.tgl').on('click', function(){
		$('.masa_penilaian').removeClass('has-error');
	});


	$('.tampilkan').on('click', function(e){
		if($('.selesai').val() != ""){

			
			document.getElementById('list_capaian').innerHTML = "";
			

			$.ajax({
			url		: '{{ url("api_resource/create_capaian_triwulan_confirm") }}',
			type	: 'GET',
			data	:  {  tgl_selesai:$('.selesai').val(),
						  pegawai_id : {!! $pegawai->id !!}	
					   },
			success	: function(data) {
				

					var capaian = document.getElementById('list_capaian');
					for(var i = 0 ; i < data['list_capaian'].length; i++ ){
						$('.header_list').show(); 
						$("<li class='list-group-item' style='padding:3px 4px 3px 4px;;'>"+data['list_capaian'][i].periode_capaian+" <a class='pull-right'>"+data['list_capaian'][i].jm_realisasi+"</a> </li>").appendTo(capaian);
					}
						$("<li class='list-group-item' style='background:#ededed; border-top:solid #3d3d3d 2px; padding:5px 4px 5px 4px;'><b>Total Realisasi </b><a class='pull-right'>"+data['total_realisasi']+"</a> </li>").appendTo(capaian);
					
						$('.periode_capaian_triwulan').html(data['periode_capaian_triwulan']); 
						$('.jm_cap_skp').html(data['jm_cap_skp']);

						$('.pegawai_id').val(data['pegawai_id']); 

						$('.tgl_mulai_capaian').val(data['tgl_mulai_capaian']); 
						$('.tgl_selesai_capaian').val(data['tgl_selesai_capaian']); 


						$('.u_nama').val(data['u_nama']); 
						$('.u_jabatan_id').val(data['u_jabatan_id']); 
						$('.p_nama').val(data['p_nama']); 
						$('.p_jabatan_id').val(data['p_jabatan_id']);

			
			}
			});
		}else{
			$('.masa_penilaian').addClass('has-error');
		}
	});





	
	$('.modal-create_capaian_triwulan').on('shown.bs.modal', function(){
		document.getElementById('list_capaian').innerHTML = "";
	});

	$('.modal-create_capaian_triwulan').on('hidden.bs.modal', function(){
			
		document.getElementById('list_capaian').innerHTML = "";
		$('.selesai').val("");
		$('.periode_capaian_triwulan').html(""); 
		$('.jm_cap_skp').html("");

		
	});

	

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
						//window.location.assign("capaian-bulanan/"+data+"/edit");

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
					if ( (index == 'tgl_mulai_capaian') | (index == 'tgl_selesai_capaian') | (index == 'tgl_selesai')){

						//$('#myTab a[href="#tab_a"]').tab('show');
						$('.masa_penilaian').addClass('has-error');
					}


					
				
				});
				
			}
			
		  }); 

		
	});

		



</script>