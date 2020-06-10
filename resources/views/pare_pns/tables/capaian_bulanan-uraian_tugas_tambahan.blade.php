
<div class="box-body table-responsive" style="min-height:330px;">
	<div class="toolbar" style="margin-top:-30px;"> 
			
	</div>
	<table id="realisasi_uraian_tugas_tambahan_table" class="table table-striped table-hover" >
		<thead>
			<tr>
				<th rowspan="2">No</th>
				<th rowspan="2">URAIAN TUGAS TAMBAHAN</th>
				<th rowspan="2">TUGAS TAMBAHAN</th>
				<th colspan="3">OUTPUT</th>
				<th rowspan="2"><i class="fa fa-cog"></i></th>
			</tr>
			<tr>	
				<th>TARGET</th>
				<th>REALISASI</th>
				<th>%</th>
			</tr>
		</thead>
							
	</table>
</div>



@include('pare_pns.modals.realisasi_uraian_tugas_tambahan')

<script type="text/javascript">



	LoadUraianTugasTambahanTable();
	function LoadUraianTugasTambahanTable(){
		$('#realisasi_uraian_tugas_tambahan_table').DataTable({
					destroy			: true,
					processing      : false,
					serverSide      : false,
					searching      	: true,
					paging          : true,
					bInfo			: false,
					
					columnDefs		: [
										{ className: "text-center", targets: [ 0,3,4,5,6 ] },
										/* { className: "text-right", targets: [ 6 ] }, */
										{ "orderable": false, targets: [ 2,3,4,5,6 ]  },
										@if  ( ( request()->segment(4) == 'edit' ) | ( request()->segment(4) == 'ralat' )  )
											{ "visible": true, "targets": [6]}
										@else
											{ "visible": false, "targets": [6]}
										@endif
									],
					ajax			: {
										url		: '{{ url("api_resource/realisasi_uraian_tugas_tambahan_list") }}',
										data	: { 
													"skp_bulanan_id" : {!! $capaian->skp_bulanan_id !!}
												  },
										cache : false,
										quietMillis: 500,
									},
					rowsGroup		: [2],
					columns			: [
										{ data: 'kegiatan_tahunan_id',width:"30px",
											"render": function ( data, type, row ,meta) {
												return meta.row + meta.settings._iDisplayStart + 1 ;
											}
										},
										{ data: "uraian_tugas_tambahan_label", name:"uraian_tugas_tambahan_label"},
										{ data: "tugas_tambahan_label", name:"tugas_tambahan_label", width:"320px"},
										{ data: "target", name:"target",width:"100px",},
										{ data: "realisasi", name:"realisasi",width:"100px",},
										{ data: "persen", name:"persen",width:"80px"},
										{  data: 'action',width:"60px",
											"render": function ( data, type, row ) {
											
											if ( (row.realisasi_uraian_tugas_tambahan_id) >= 1 ){
												return  '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_realisasi_uraian_tugas_tambahan"  data-id="'+row.realisasi_uraian_tugas_tambahan_id+'"><i class="fa fa-pencil" ></i></a></span>'+
														'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_realisasi_uraian_tugas_tambahan"  data-id="'+row.realisasi_uraian_tugas_tambahan_id+'" data-label="'+row.uraian_tugas_tambahan_label+'" ><i class="fa fa-close " ></i></a></span>';
											}else{
												return  '<span  data-toggle="tooltip" title="Add" style="margin:2px;" ><a class="btn btn-info btn-xs create_realisasi_uraian_tugas_tambahan"  data-id="'+row.uraian_tugas_tambahan_id+'"><i class="fa fa-plus" ></i></a></span>'+
														'<span  style="margin:2px;" disabled><a class="btn btn-default btn-xs "  ><i class="fa fa-close " ></i></a></span>';
											
											} 
													
										
										}
									},
									
									],
									initComplete: function(settings, json) {
									
								}
		});	
	}
	


	$(document).on('click','.create_realisasi_uraian_tugas_tambahan',function(e){
		//alert();
		var uraian_tugas_tambahan_id = $(this).data('id');
		show_modal_create_realisasi_uraian_tugas_tambahan(uraian_tugas_tambahan_id);
	});

	function show_modal_create_realisasi_uraian_tugas_tambahan(uraian_tugas_tambahan_id){
		
		$.ajax({
				url			  : '{{ url("api_resource/uraian_tugas_tambahan_detail") }}',
				data 		  : {uraian_tugas_tambahan_id : uraian_tugas_tambahan_id},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					$('.modal-realisasi_uraian_tugas_tambahan').find('[name=uraian_tugas_tambahan_id]').val(data['id']);
					$('.modal-realisasi_uraian_tugas_tambahan').find('[name=realisasi_uraian_tugas_tambahan_id]').val("");
					$('.modal-realisasi_uraian_tugas_tambahan').find('[name=capaian_id]').val({!! $capaian->id !!});
					$('.modal-realisasi_uraian_tugas_tambahan').find('[name=satuan]').val(data['satuan']);

					$('.modal-realisasi_uraian_tugas_tambahan').find('.uraian_tugas_tambahan_label').html(data['label']);
					$('.modal-realisasi_uraian_tugas_tambahan').find('.uraian_tugas_tambahan_output').html(data['output']);

					$('.modal-realisasi_uraian_tugas_tambahan').find('.uraian_tugas_tambahan_satuan').html(data['satuan']);
					$('.modal-realisasi_uraian_tugas_tambahan').find('.uraian_tugas_tambahan_target').val(data['target']);

					$('.modal-realisasi_uraian_tugas_tambahan').find('h4').html('Add Realisasi Uraian Tugas Tambahan');
					$('.modal-realisasi_uraian_tugas_tambahan').find('.btn-submit').attr('id', 'submit-save_realisasi_utt');
					$('.modal-realisasi_uraian_tugas_tambahan').find('[name=text_button_submit]').html('Simpan Data');
					$('.modal-realisasi_uraian_tugas_tambahan').modal('show');  
				},
				error: function(data){
					
				}						
		});	
	}

	$(document).on('click','.edit_realisasi_uraian_tugas_tambahan',function(e){
		var realisasi_uraian_tugas_tambahan_id = $(this).data('id') ;
		
		$.ajax({
				url			: '{{ url("api_resource/realisasi_uraian_tugas_tambahan_detail") }}',
				data 		: {realisasi_uraian_tugas_tambahan_id : realisasi_uraian_tugas_tambahan_id},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					$('.modal-realisasi_uraian_tugas_tambahan').find('[name=realisasi_uraian_tugas_tambahan_id]').val(data['id']);
					$('.modal-realisasi_uraian_tugas_tambahan').find('[name=uraian_tugas_tambahan_id]').val(data['uraian_tugas_tambahan_id']);
					$('.modal-realisasi_uraian_tugas_tambahan').find('[name=capaian_id]').val(data['capaian_id']);
					$('.modal-realisasi_uraian_tugas_tambahan').find('[name=satuan]').val(data['satuan']);

					$('.modal-realisasi_uraian_tugas_tambahan').find('.uraian_tugas_tambahan_label').html(data['label']);
					$('.modal-realisasi_uraian_tugas_tambahan').find('.uraian_tugas_tambahan_output').html(data['output']);

					$('.modal-realisasi_uraian_tugas_tambahan').find('.uraian_tugas_tambahan_satuan').html(data['satuan']);
					$('.modal-realisasi_uraian_tugas_tambahan').find('.uraian_tugas_tambahan_target').val(data['target']);
					$('.modal-realisasi_uraian_tugas_tambahan').find('.uraian_tugas_tambahan_realisasi').val(data['realisasi']);

					$('.modal-realisasi_uraian_tugas_tambahan').find('h4').html('Edit Realisasi Uraian Tugas Tambahan');
					$('.modal-realisasi_uraian_tugas_tambahan').find('.btn-submit').attr('id', 'submit-update_realisasi_utt');
					$('.modal-realisasi_uraian_tugas_tambahan').find('[name=text_button_submit]').html('Update Data');
					$('.modal-realisasi_uraian_tugas_tambahan').modal('show');  
				},
				error: function(data){
					
				}						
		});	 
	
	});

	$(document).on('click','.hapus_realisasi_uraian_tugas_tambahan',function(e){
		var realisasi_uraian_tugas_tambahan = $(this).data('id') ;
		Swal.fire({
			title: "Hapus Realisasi Uraian Tugas Tambahan",
			text:$(this).data('label'),
			//type: "warning",
			type: "question",
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
					url		: '{{ url("api_resource/hapus_realisasi_uraian_tugas_tambahan") }}',
					type	: 'POST',
					data    : { realisasi_uraian_tugas_tambahan:realisasi_uraian_tugas_tambahan },
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
										$('#realisasi_uraian_tugas_tambahan_table').DataTable().ajax.reload(null,false);
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#realisasi_uraian_tugas_tambahan_table').DataTable().ajax.reload(null,false);
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