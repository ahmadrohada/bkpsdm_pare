<div class="modal fade modal-create_capaian_tahunan_confirm" id="CreateSKPTahunanConfirm" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <!-- <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">
                        Create SKP Tahunan Confirm
                    </h4>
			</div> -->
			<form  id="create-capaian_tahunan_confirm-form" method="POST" action="">
			<div class="modal-body">
<!-- ============================================================================================================= -->
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs" id="myTab"> 
					<li class=""><a href="#tab_a" data-toggle="tab"><i class="fa fa-tag"></i> Capaian Tahunan </a></li>
					<li class=""><a href="#tab_b" data-toggle="tab" ><i class="fa fa-user"></i> Data Pribadi</a></li>
					<li class=""><a href="#tab_c" data-toggle="tab"><i class="fa fa-user"></i> Data Atasan</a></li>
				</ul>


				<div class="tab-content"  style="min-height:370px;">
					<div class="active tab-pane fade" id="tab_a">
<!-- ============================================================================================================= -->
						<div class="row" style="padding:0px 10px;">
							<div class="form-horizontal col-xs-6 " style="">
								<div class="form-group form-group-sm skp_tahunan_id">
									<label>Periode</label>
									<p class="text-muted periode_label" ></p>
								</div>
							</div>
							<div class="form-horizontal col-xs-6" style="">
								<div class="form-group form-group-sm">
									<label>Jumlah Kegiatan Tahunan</label>
									<p class="text-muted jm_kegiatan"></p>
										
								</div>
							</div>
							<div class="form-horizontal col-xs-6 " hidden>
								<div class="form-group form-group-sm masa_penilaian">
									<label>Masa Penilaian Capaian Tahunan</label>
									<div class="input-group input-group-sm ">
										<input type="text" class="form-control cap_tgl_mulai" name="cap_tgl_mulai" placeholder="Tanggal Mulai"/>
										<span class="input-group-addon">s.d.</span>
										<input type="text" class="form-control tgl cap_tgl_selesai" name="cap_tgl_selesai" placeholder="Tanggal Selesai"/>
									</div>     
								</div>
							</div>
							
						</div>
						
						
						
						
						<hr>

						<div class="form-horizontal text-center col-md-12 normal_end" style="padding-left:0px; " hidden>
							<h3 class="text-succes strong">MASA PENILAIAN SKP TAHUNAN</h3>
							<h2 class="text-succes strong"><span class="masa_penilaian_skp_tahunan"></h2>
							<h5 class="text-danger">PASTIKAN MASA PENILAIAN SKP SAMPAI DENGAN  BULAN <b>DESEMBER</b></h5>
							<h5 class="text-danger">JANGAN LANJUTKAN PROSES CREATE CAPAIAN JIKA MASA PENILAIAN BERMASALAH</h5>
							<h5 class="text-danger">HUBUNGI ADMIN JIKA TERDAPAT KESALAHAN MASA PENILAIAN</h4>

						</div>

						<div class="form-horizontal col-md-12 text-center before_end" style="padding-left:0px; " hidden>
							<h5 class="text-danger">- Capaian dibuat sebelum masa penilaian SKP berakhir</h5>
							<h5 class="text-danger">- Ubah tgl akhir masa penilaian menjadi 1 hari sebelum TMT Jabatan Baru<span class="text-success masa_penilaian_baru"></span></h5>
							<h5 class="text-danger">- Masa Penilaian SKP akan diubah sesuai masa penilaian capaian</h5>
							<h5 class="text-danger">- SKP Bulanan setelah masa penilaian akan dihapus</h5>
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
			<div class="modal-footer" style="border:none; margin-top:-20px;">
				
					<input type="hidden" class="form-control pegawai_id" name="pegawai_id"  />
					<input type="hidden" class="form-control skp_tahunan_id" name="skp_tahunan_id"  />
					<input type="hidden" class="form-control jm_kegiatan" name="jm_kegiatan"  />
				
					<input type="hidden" class="form-control u_nama	" name="u_nama"  />
					<input type="hidden" class="form-control u_jabatan_id " name="u_jabatan_id"  />
					<input type="hidden" class="form-control u_golongan_id " name="u_golongan_id"  />

					<input type="hidden" class="form-control p_nama	" name="p_nama"  />
					<input type="hidden" class="form-control p_jabatan_id	" name="p_jabatan_id"  />
					<input type="hidden" class="form-control p_golongan_id	" name="p_golongan_id"  />

					<input type="hidden" class="form-control jabatan_id" name="jabatan_id"  />
					<input type="hidden" class="form-control renja_id" name="renja_id"  />
					<input type="hidden" class="form-control jenis_jabatan" name="jenis_jabatan"  />

               	 	{!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_cancel_icon').'" aria-hidden="true"></i> ' . Lang::get('modals.confirm_modal_button_cancel_text'), array('class' => 'btn btn-sm btn-default pull-left ', 'type' => 'button', 'data-dismiss' => 'modal' )) !!}
               	 	{!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_save_icon').' button_simpan" aria-hidden="true"></i> ' . Lang::get('modals.confirm_modal_button_save_text'), array('class' => 'btn btn-sm btn-primary pull-right ', 'type' => 'button', 'id' => 'save_capaian_tahunan' )) !!}
			
			
				
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
		
	}); 

	$('.modal-create_capaian_tahunan_confirm').on('shown.bs.modal', function(){
		reset_submit()
		$('#myTab a[href="#tab_a"]').tab('show');
	});

	$('.modal-create_capaian_tahunan_confirm').on('hidden.bs.modal', function(){
		reset_submit()
		$('.u_jabatan, .p_jabatan, .masa_penilaian, .skp_tahunan_id, .jm_kegiatan_tahunan').removeClass('has-error');
		$('.modal-create_capaian_tahunan_confirm').find('[name=tgl_mulai],[name=tgl_selesai]').val('');
		$('.sidebar-mini').attr("style", "padding-right:0px;");
	});

	function on_submit(){
		$('.modal-create_capaian_tahunan_confirm').find('.button_simpan').addClass('fa-spinner faa-spin animated');
		$('#save_capaian_tahunan').prop('disabled',true);
	}
	function reset_submit(){
		$('.modal-create_capaian_tahunan_confirm').find('.button_simpan').removeClass('fa-spinner faa-spin animated');
		$('.modal-create_capaian_tahunan_confirm').find('.button_simpan').addClass('fa-floppy-o');
		$('#save_capaian_tahunan').prop('disabled',false);
	}

	
		

	$(document).on('click', '#save_capaian_tahunan', function(){
		var data = $('#create-capaian_tahunan_confirm-form').serialize();
		on_submit();
		$.ajax({
			url		: '{{ url("api/simpan_capaian_tahunan") }}',
			type	: 'POST',
			data	:  data,
			success	: function(data , textStatus, jqXHR) {
				$('#capaian_tahunan').DataTable().ajax.reload(null,false);
				reset_submit();

				Swal.fire({
					title: "",
					text: "Sukses",
					type: "success",
					width: "200px",
					showConfirmButton: false,
					allowOutsideClick : false,
					timer: 500
				}).then(function () {
						$('.modal-capaian_tahunan_confirm').modal('hide');
						$('#capaian_tahunan_table').DataTable().ajax.reload(null,false);
						window.location.assign("capaian-tahunan/"+data+"/edit");

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
					if ( index == 'tgl_selesai_baru' ){

						$('#myTab a[href="#tab_a"]').tab('show');
						$('.masa_penilaian').addClass('has-error');
					}

					
					if (index == 'skp_tahunan_id'){

						$('#myTab a[href="#tab_a"]').tab('show');
						$('.skp_tahunan_id').addClass('has-error');
					}

					
				
				});
				
			}
			
		  }); 


	});

		

</script>