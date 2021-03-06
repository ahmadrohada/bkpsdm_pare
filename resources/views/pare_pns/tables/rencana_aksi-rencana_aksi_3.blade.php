<div class="box box-indikator_kegiatan div_rencana_aksi" hidden>
	<div class="box-header with-border">
		&nbsp;
		<div class="box-tools pull-right">
			{!! Form::button('<i class="fa  fa-level-up"></i>', array('class' => 'btn btn-box-tool tutup_detail','title' => 'Kegiatan SKP Tahunan', 'data-toggle' => 'tooltip')) !!}
		</div>
	</div>
	<div class="box-body table-responsive">
		<input type="hidden" class="indikator_kegiatan_tahunan_id">
		<input type="hidden" class="kegiatan_tahunan_id">
		
		<label>Indikator Kegiatan SKP Tahunan: </label> 
		<p class="text-muted " style="font-size:11pt;">
			<span class="indikator_kegiatan_label"></span>
		</p>
		<i class="fa fa-industry"></i> <span class="txt_output_indikator_kegiatan" style="margin-right:10px;"></span>
		<br>
		<div class="toolbar pull-right">
			@if (request()->segment(4) == 'edit')  
				<span  data-toggle="tooltip" title="Create Rencana Aksi"><a class="btn btn-info btn-xs create_rencana_aksi" ><i class="fa fa-plus" ></i> Rencana Aksi</a></span>
			@endif
		</div>

	

		<table id="rencana_aksi_table" class="table table-striped table-hover" style="width:100%">
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

<script type="text/javascript">


	function load_ind_kegiatan_skp_tahunan(indikator_kegiatan_skp_tahunan_id){
		$.ajax({
				url			: '{{ url("api/indikator_kegiatan_skp_tahunan_detail") }}',
				data 		: { indikator_kegiatan_skp_tahunan_id : indikator_kegiatan_skp_tahunan_id , skp_tahunan_id: {!! $skp->id !!} },
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
						
						$('.indikator_kegiatan_tahunan_id').val(data['ind_kegiatan_id']);
						$('.kegiatan_tahunan_id').val(data['kegiatan_tahunan_id']);

						$('.indikator_kegiatan_label').html(data['label']);
						$('.txt_output_indikator_kegiatan').html(data['target']+" "+data['satuan']);
						rencana_aksi_list(data['ind_kegiatan_id']);
				},
				error: function(data){
					
				}						
		});
	}

	
	
	function rencana_aksi_list(indikator_kegiatan_tahunan_id){
		var table_rencana_aksi = $('#rencana_aksi_table').DataTable({
			destroy			: true,
			processing      : false,
			serverSide      : true,
			searching      	: false,
			paging          : false,
			bInfo			: false,
			bSort			: false,
			columnDefs		: [
								{ className: "text-center", targets: [ 0,2,3,4,5 ] },
							
							],
			ajax			: {
								url	: '{{ url("api/skp_tahunan_rencana_aksi_3") }}',
								data: { 	indikator_kegiatan_tahunan_id: indikator_kegiatan_tahunan_id , 
											skp_tahunan_id: {!! $skp->id !!},
											jabatan_id: {!! $skp->PegawaiYangDinilai->id_jabatan  !!}
									},
							},
							
			columns			: [
								{ data: 'rencana_aksi_id' , width:"6%",
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
								{ data: "label", name:"label"},
								{ data: "pelaksana", name:"pelaksana",
									"render": function ( data, type, row ) {
										if (row.kegiatan_bulanan >= 1){
											return "<p class='text-info'>"+row.pelaksana+"</p>";
										}else{
											return "<p class='text-warning'>"+row.pelaksana+"</p>";
										}
									}
								},
								{ data: "waktu_pelaksanaan", name:"waktu_pelaksanaan"},
								{ data: "target", name:"target"},
								
								{  data: 'action',width:"6%",
										"render": function ( data, type, row ) {
											if ( ( row.kegiatan_bulanan >= 1) & ( row.dilaksanakan_sendiri == 0 ) ){
												return  '<span  data-toggle="tooltip" title="" style="margin:1px;" ><a class="btn btn-default btn-xs "  ><i class="fa fa-pencil" ></i></a></span>'+
															'<span  data-toggle="tooltip" title="" style="margin:1px;" ><a class="btn btn-default btn-xs " ><i class="fa fa-close " ></i></a></span>';
										
											}else{
												return  '<span  data-toggle="tooltip" title="Edit" style="margin:1px;" ><a class="btn btn-success btn-xs edit_rencana_aksi"  data-id="'+row.rencana_aksi_id+'"><i class="fa fa-pencil" ></i></a></span>'+
															'<span  data-toggle="tooltip" title="Hapus" style="margin:1px;" ><a class="btn btn-danger btn-xs hapus_rencana_aksi"  data-id="'+row.rencana_aksi_id+'" data-label="'+row.label+'" ><i class="fa fa-close " ></i></a></span>';
										
											}
											
												
									
									}
								},
							
							],
							initComplete: function(settings, json) {
							
						}
		});	
	}

	

	$(document).on('click','.create_rencana_aksi',function(e){


	
		$('.modal-rencana_aksi').find('[name=indikator_kegiatan_tahunan_id]').val($('.indikator_kegiatan_tahunan_id').val());
		$('.modal-rencana_aksi').find('[name=kegiatan_skp_tahunan_id]').val($('.kegiatan_skp_tahunan_id').val());


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
				url			: '{{ url("api/rencana_aksi_detail") }}',
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
					$('.modal-rencana_aksi').find('[name=indikator_kegiatan_tahunan_id]').empty().append('<option value="'+data['indikator_kegiatan_tahunan_id']+'">'+data['indikator_kegiatan_tahunan_label']+'</option>').val(data['indikator_kegiatan_id']).trigger('change');


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
					url		: '{{ url("api/hapus_rencana_aksi") }}',
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
										$('#kegiatan_tahunan_3_table').DataTable().ajax.reload(null,false);
										$('#rencana_aksi_table').DataTable().ajax.reload(null,false);
										
										$('#skp_bulanan_table').DataTable().ajax.reload(null,false);
										jQuery('#kegiatan_tahunan_3').jstree(true).refresh(true);
										jQuery('#skp_bulanan_tree').jstree(true).refresh(true);
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											
											
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