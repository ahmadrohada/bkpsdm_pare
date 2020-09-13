	<div class="box-body table-responsive"  style="min-height:340px;">
		<table id="rencana_aksi_time_table" class="table table-striped table-hover">
			<thead>
				<tr>
					<th class="no-sort" style="padding-right:8px;" rowspan="2" width="5%" >NO</th>
					<th rowspan="2"  width="">SASARAN</th>
					<th rowspan="2"  width="">INDIKATOR SASARAN KINERJA UTAMA</th>
					<th rowspan="2"  width="" >TARGET</th>
					<th rowspan="2"  width="">PROGRAM</th>
					<th rowspan="2"  width="">KEGIATAN</th>
					<th rowspan="2"  width="">URAIAN KEGIATAN</th>
					<th rowspan="2"  width="">TARGET URAIAN KEGIATAN ( OUTPUT )</th>
					<th rowspan="2"  width="">ANGGARAN KEGIATAN ( APBD )</th>
					<th colspan="12" width="">TARGET PELAKSANAAN URAIAN KEGIATAN</th>
					<th colspan="3" width="">TARGET KEGIATAN ( TW )</th>
																
				</tr>
				<tr>
					<th width="">1</th>
					<th width="">2</th>
					<th width="">3</th>
					<th width="">4</th>
					<th width="">5</th>
					<th width="">6</th>
					<th width="">7</th>
					<th width="">8</th>
					<th width="">9</th>
					<th width="">10</th>
					<th width="">11</th>
					<th width="">12</th>
					<th width=""> TRIWULAN </th>
					<th width="">KINERJA</th>
					<th width="">ANGGARAN</th>								
				</tr>
			</thead>
		</table>
	</div>

<script type="text/javascript">

	function rencana_aksi_time_table(){
		var table_rencana_aksi = $('#rencana_aksi_time_table').DataTable({
			destroy			: true,
			processing      : true,
			serverSide      : true,
			searching      	: true,
			paging          : true,
			lengthMenu		: [25,75,200],
			bInfo			: true,
			bSort			: false,
			columnDefs		: [
								{ className: "text-center", targets: [ 0,2,3,4,5,6,7,9,10,11,12,13,14,15,16,17,18,19,20,21 ] },
								{ className: "text-right", targets: [ 8 ] },
							 ],
			ajax			: {
								url	: '{{ url("api_resource/rencana_aksi_time_table_4") }}',
								data: { skp_tahunan_id: {!! $skp->id !!},
										jabatan_id: {!! $skp->PejabatYangDinilai->id_jabatan !!},
										renja_id: {!! $skp->Renja->id !!}
								},
								cache : false,
								quietMillis: 500,
							},
			rowsGroup		: [1,2,3,4,5,8],				
			columns			: [
								{ data: 'rencana_aksi_id' , width:"3%",orderable: false,
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
								{ data: "sasaran_label", name:"sasaran_label" , width:"8%", orderable: false, },
								{ data: "indikator_sasaran_label", name:"indikator_sasaran_label" , width:"8%", orderable: false, },
								{ data: "indikator_sasaran_target", name:"indikator_sasaran_target" , width:"", orderable: false, },
								{ data: "program_label", name:"program_label" , width:"10%", orderable: false, },
								{ data: "kegiatan_label", name:"kegiatan_label" , width:"10%", orderable: false, },
								{ data: "rencana_aksi_label", name:"rencana_aksi_label" , width:"22%", orderable: false, },
								{ data: "rencana_aksi_target", name:"rencana_aksi_target" , width:"", orderable: false, },
								{ data: "kegiatan_anggaran", name:"kegiatan_anggaran" , width:"", orderable: false, },
								{ data: "b_01", width:"2%", orderable: false},
								{ data: "b_02", width:"2%", orderable: false},
								{ data: "b_03", width:"2%", orderable: false},
								{ data: "b_04", width:"2%", orderable: false},
								{ data: "b_05", width:"2%", orderable: false},
								{ data: "b_06", width:"2%", orderable: false},
								{ data: "b_07", width:"2%", orderable: false},
								{ data: "b_08", width:"2%", orderable: false},
								{ data: "b_09", width:"2%", orderable: false},
								{ data: "b_10", width:"2%", orderable: false},
								{ data: "b_11", width:"2%", orderable: false},
								{ data: "b_12", width:"2%", orderable: false},
								

								{ data: "triwulan", name:"" , width:"4%", orderable: false, },
								{ data: "kinerja", name:"" , width:"4%", orderable: false, },
								{ data: "anggaran", name:"" , width:"4%", orderable: false, },

								
							
							],
							initComplete: function(settings, json) {
							
						}
		});	
	}

	

	/* $(document).on('click','.create_rencana_aksi',function(e){


	
		$('.modal-rencana_aksi').find('[name=indikator_kegiatan_id]').val($('.indikator_kegiatan_id').val());
		$('.modal-rencana_aksi').find('[name=kegiatan_tahunan_id]').val($('.kegiatan_tahunan_id').val());


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
										jQuery('#skp_bulanan_tree').jstree(true).refresh(true);
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#rencana_aksi_table').DataTable().ajax.reload(null,false);
											jQuery('#keg_tahunan_3_tree').jstree(true).refresh(true);
											jQuery('#skp_bulanan_tree').jstree(true).refresh(true);
											
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
	}); */
</script>