<div id='rencana_aksi' hidden>
	<div class="box box-primary">
		<div class="box-header with-border">
			<h1 class="box-title">
				Detail Kegiatan Tahunan
			</h1>

			<div class="box-tools pull-right">
				{!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
				{!! Form::button('<i class="fa fa-remove "></i>', array('class' => 'btn btn-box-tool tutup_detail_detail_kegiatan_tahunan','title' => 'Tutup', 'data-toggle' => 'tooltip')) !!}

				{!! Form::button('<i class="fa fa-question-circle "></i>', array('class' => 'btn btn-box-tool bantuan','data-id' => '410', 'title' => 'Bantuan', 'data-toggle' => 'tooltip')) !!}
			</div>
		</div>
		<div class="box-body table-responsive">

			<strong>Kegiatan Tahunan</strong>
			<p class="text-muted " style="margin-top:8px;padding-bottom:8px;">
				<span class="kegiatan_tahunan_label"></span>
				<input type="hidden" class="kegiatan_tahunan_id">
				<input type="hidden" class="kegiatan_renja_id">
			</p>

			<p><strong>Target</strong></p>
			<i class="fa  fa-gg"></i> <span class="txt_ak" style="margin-right:10px;"></span>
			<i class="fa fa-industry"></i> <span class="txt_output" style="margin-right:10px;"></span>
			<i class="fa fa-hourglass-start"></i> <span class="txt_waktu_pelaksanaan" style="margin-right:10px;"></span>
			<i class="fa fa-money"></i> <span class="txt_cost" style="margin-right:10px;"></span>

			<hr>
					
			<table class="table table-hover table-condensed">
				<tr class="success">
					<th>No</th>
					<th>Indikator</th>
					<th>Target</th>
				</tr>
			</table>
			<table class="table table-hover table-condensed" id="list_indikator"></table>
			  
		</div>
	</div>

	<div class="box box-primary">
		<div class="box-header with-border">
			<h1 class="box-title">
				List Rencana Aksi
			</h1>

		</div>
		<div class="box-body table-responsive">
			<div class="toolbar">
				<span  data-toggle="tooltip" title="Create Rencana Aksi"><a class="btn btn-info btn-xs create_rencana_aksi "><i class="fa fa-plus" ></i></a></span>
			</div>

			<table id="rencana_aksi_table" class="table table-striped table-hover" >
				<thead>
					<tr>
						<th>No</th>
						<th>RENCANA AKSI</th>
						<th>PELAKSANA</th>
						<th>WAKTU</th>
						<th>TARGET</th>
						<th><i class="fa fa-cog"></i></th>
					</tr>
				</thead>
			</table>

		</div>
	</div>
</div>



<script type="text/javascript">

$(document).on('click','.create_rencana_aksi',function(e){
	
		$('.modal-rencana_aksi').find('h4').html('Create Rencana Aksi');
		$('.modal-rencana_aksi').find('.btn-submit').attr('id', 'submit-save_rencana_aksi');
		$('.modal-rencana_aksi').find('[name=text_button_submit]').html('Simpan Data');
		$('.tp_edit').hide();
		$('.tp').show();
	

		$('.modal-rencana_aksi').modal('show');
	});


//============================ RENCANA AKSI ========================================//

	$(document).on('click','.edit_rencana_aksi',function(e){
		var rencana_aksi_id = $(this).data('id') ;
		$.ajax({
				url			: '{{ url("api_resource/rencana_aksi_detail") }}',
				data 		: {rencana_aksi_id : rencana_aksi_id},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					$('.modal-rencana_aksi').find('[name=label]').val(data['label']);
					$('.modal-rencana_aksi').find('[name=target]').val(data['target_rencana_aksi']);
					$('.modal-rencana_aksi').find('[name=satuan]').val(data['satuan_target_rencana_aksi']);
					$('.tp_edit').show();
					$('.tp').hide();
				 	//	$('.modal-rencana_aksi').find('[name=pelaksana]').val(1358).trigger('change.select2');

				 	$('.modal-rencana_aksi').find('[name=pelaksana]').empty().append('<option value="'+data['jabatan_id']+'">'+data['nama_jabatan']+'</option>').val(data['jabatan_id']).trigger('change');
					$('.modal-rencana_aksi').find('[name=indikator_kegiatan_id]').empty().append('<option value="'+data['indikator_kegiatan_id']+'">'+data['indikator_kegiatan_label']+'</option>').val(data['indikator_kegiatan_id']).trigger('change');


					$('.modal-rencana_aksi').find('[name=waktu_pelaksanaan_edit]').val(data['waktu_pelaksanaan_int']).trigger('change.select2');
				
					$('.modal-rencana_aksi').find('[name=rencana_aksi_id]').val(data['id']);
					$('.modal-rencana_aksi').find('h4').html('Edit Rencana Aksi');
					$('.modal-rencana_aksi').find('.btn-submit').attr('id', 'submit-update_rencana_aksi');
					$('.modal-rencana_aksi').find('[name=text_button_submit]').html('Update Data');
					$('.modal-rencana_aksi').modal('show');
				},
				error: function(data){
					
				}						
		});	
	});

	$(document).on('click','.hapus_rencana_aksi',function(e){
		var rencana_aksi_id = $(this).data('id') ;
		//alert(rencana_aksi_id);

		Swal.fire({
			title: "Hapus  rencana Aksi",
			text:$(this).data('label'),
			type: "warning",
			//type: "question",
			showCancelButton: true,
			cancelButtonText: "Batal",
			confirmButtonText: "Hapus",
			confirmButtonClass: "btn btn-success",
			cancelButtonColor: "btn btn-danger",
			cancelButtonColor: "#d33",
			closeOnConfirm: false,
			closeOnCancel:false
		}).then ((result) => {
			if (result.value){
				$.ajax({
					url		: '{{ url("api_resource/hapus_rencana_aksi") }}',
					type	: 'POST',
					data    : {rencana_aksi_id:rencana_aksi_id},
					cache   : false,
					success:function(data){
							Swal.fire({
									title: "",
									text: "Sukses",
									type: "success",
									width: "200px",
									showConfirmButton: false,
									allowOutsideClick : false,
									timer: 900
									}).then(function () {
										$('#rencana_aksi_table').DataTable().ajax.reload(null,false);
										jQuery('#keg_tahunan_3_tree').jstree(true).refresh(true);
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#rencana_aksi_table').DataTable().ajax.reload(null,false);
											jQuery('#keg_tahunan_3_tree').jstree(true).refresh(true);
											
										}
									}
								)
								
							
					},
					error: function(e) {
							Swal.fire({
									title: "Gagal",
									text: "",
									type: "warning"
								}).then (function(){
										
								});
							}
					});	
			}
		});
	});
</script>