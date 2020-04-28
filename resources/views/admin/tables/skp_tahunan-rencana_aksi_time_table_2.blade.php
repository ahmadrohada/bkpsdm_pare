<div class="box box-primary " style="min-height:340px;">
	<div class="box-header with-border">
		<h1 class="box-title"> 
			List Pelaksanaan Rencana Aksi
		</h1>
		<div class="box-tools pull-right">
			<form method="post" target="_blank" action="./cetak_rencana_aksi-Eselon3">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="renja_id" value="">
				
				<button type="submit" class="btn btn-info btn-xs"><i class="fa fa-print"></i> Cetak</button>
			</form> 
		</div>
	</div>
	<div class="box-body table-responsive">
		<table id="rencana_aksi_time_table" class="table table-striped table-hover">
			<thead>
				<tr>
					<th rowspan="2">No</th>
					<th rowspan="2">RENCANA AKSI</th>
					<th rowspan="2">PENGAWAS</th>
					<th rowspan="2">PELAKSANA</th>
					<th colspan="12">BULAN</th>
				</tr>
				<tr>
					<th>1</th>
					<th>2</th>
					<th>3</th>
					<th>4</th>
					<th>5</th>
					<th>6</th>
					<th>7</th>
					<th>8</th>
					<th>9</th>
					<th>10</th>
					<th>11</th>
					<th>12</th>
				</tr>
			</thead>
		</table>
	</div>
</div>

<script type="text/javascript">
 
	function rencana_aksi_time_table(){
		var table_rencana_aksi = $('#rencana_aksi_time_table').DataTable({
			destroy			: true,
			processing      : false,
			serverSide      : true,
			searching      	: true,
			paging          : true,
			lengthMenu		: [15,30],
			bInfo			: false,
			columnDefs		: [
								{ className: "text-center", targets: [ 0,2,3,4,5,6,7,8,9,10,11,12,13,14,15 ] },
							
							],
			ajax			: {
								url	: '{{ url("api_resource/rencana_aksi_time_table_2") }}',
								data: { skp_tahunan_id: {!! $skp->id !!} ,
										jabatan_id    : {!! $skp->PejabatYangDinilai->id_jabatan !!}
									 },
							},
							
			columns			: [
								{ data: 'rencana_aksi_id' , width:"6%",orderable: false,
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
								{ data: "label", name:"rencana_aksi_label" , width:"42%", orderable: true, },
								{ data: "pengawas", name:"pengawas" , width:"16%", orderable: true, },
								{ data: "pelaksana", name:"pelaksana" , width:"16%", orderable: true, },
								
								{ data: "jan", width:"3%", orderable: false,
									"render": function ( data, type, row ) {
										return  '<i class="fa '+row.jan+' text-success" ></i>';
									}
								},
								{ data: "feb", width:"3%", orderable: false,
									"render": function ( data, type, row ) {
										return  '<i class="fa '+row.feb+' text-success" ></i>';
									}
								},
								{ data: "mar", width:"3%", orderable: false,
									"render": function ( data, type, row ) {
										return  '<i class="fa '+row.mar+' text-success" ></i>';
									}
								},
								{ data: "apr", width:"3%", orderable: false,
									"render": function ( data, type, row ) {
										return  '<i class="fa '+row.apr+' text-success" ></i>';
									}
								},
								{ data: "mei", width:"3%", orderable: false,
									"render": function ( data, type, row ) {
										return  '<i class="fa '+row.mei+' text-success" ></i>';
									}
								},
								{ data: "jun", width:"3%", orderable: false,
									"render": function ( data, type, row ) {
										return  '<i class="fa '+row.jun+' text-success" ></i>';
									}
								},
								{ data: "jul", width:"3%", orderable: false,
									"render": function ( data, type, row ) {
										return  '<i class="fa '+row.jul+' text-success" ></i>';
									}
								},
								{ data: "agu", width:"3%", orderable: false,
									"render": function ( data, type, row ) {
										return  '<i class="fa '+row.agu+' text-success" ></i>';
									}
								},
								{ data: "sep", width:"3%", orderable: false,
									"render": function ( data, type, row ) {
										return  '<i class="fa '+row.sep+' text-success" ></i>';
									}
								},
								{ data: "okt", width:"3%", orderable: false,
									"render": function ( data, type, row ) {
										return  '<i class="fa '+row.okt+' text-success" ></i>';
									}
								},
								{ data: "nov", width:"3%", orderable: false,
									"render": function ( data, type, row ) {
										return  '<i class="fa '+row.nov+' text-success" ></i>';
									}
								},
								{ data: "des", width:"3%", orderable: false,
									"render": function ( data, type, row ) {
										return  '<i class="fa '+row.des+' text-success" ></i>';
									}
								},


								
							
							],
							initComplete: function(settings, json) {
							
						}
		});	
	}

	

	$(document).on('click','.create_rencana_aksi',function(e){


	
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
	});
</script>