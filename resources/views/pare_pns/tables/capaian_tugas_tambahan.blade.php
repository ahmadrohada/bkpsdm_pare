
<div class="box-body table-responsive" style="min-height:330px;">
	<div class="toolbar" style="margin-top:-30px;"> 
			
	</div>
	<table id="realisasi_tugas_tambahan_table" class="table table-striped table-hover" >
		<thead>
			<tr>
				<th rowspan="2">No</th>
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



@include('pare_pns.modals.realisasi_tugas_tambahan')

<script type="text/javascript">

	
	function LoadTugasTambahanTable(){
		$('#realisasi_tugas_tambahan_table').DataTable({ 
					destroy			: true,
					processing      : true,
					serverSide      : true,
					searching      	: true,
					paging          : true,
					autoWidth		: false,
					bInfo			: false,
					bSort			: false,
					lengthChange	: false,
					//order 			: [ 5 , 'asc' ],
					//lengthMenu		: [10,25,50],
					columnDefs		: [
										{ className: "text-center", targets: [ 0,2,3,4,5 ] },
										{ orderable: false, targets: [ 0,1,3,4,5 ]  },
										@if  ( ( request()->segment(4) == 'edit' ) | ( request()->segment(4) == 'ralat' )  )
											{ "visible": true, "targets": [5]}
										@else
											{ "visible": false, "targets": [5]}
										@endif
									],
					ajax			: {
										url		: '{{ url("api/realisasi_tugas_tambahan_list") }}',
										data	: { 
													"skp_tahunan_id" : {!! $capaian->skp_tahunan_id !!}
												  },
										cache : true,
										quietMillis: 1500,
									},
					rowsGroup		: [2],
					columns			: [
										{ data: 'tugas_tambahan_id',name:"tugas_tambahan_id",width:"20px",
											"render": function ( data, type, row ,meta) {
												return meta.row + meta.settings._iDisplayStart + 1 ;
											}
										},
										{ data: "tugas_tambahan_label", name:"tugas_tambahan_label", width:"320px",
											"render": function ( data, type, row ) {
												if ( (row.realisasi_tugas_tambahan_id) <= 0 ){
													return "<span class='text-danger'>"+row.tugas_tambahan_label+"</span>";
												}else{
													return row.tugas_tambahan_label;
												}
											}
										},
										{ data: "target", name:"target",width:"100px",
											"render": function ( data, type, row ) {
												if ( (row.realisasi_tugas_tambahan_id) <= 0 ){
													return "<span class='text-danger'>"+row.target+"</span>";
												}else{
													return row.target;
												}
											}
										},
										{ data: "realisasi", name:"realisasi",width:"100px",
											"render": function ( data, type, row ) {
												if ( (row.realisasi_tugas_tambahan_id) <= 0 ){
													return "<span class='text-danger'>"+row.realisasi+"</span>";
												}else{
													return row.realisasi;
												}
											}
										},
										{ data: "persen", name:"persen",width:"80px",
											"render": function ( data, type, row ) {
												if ( (row.realisasi_tugas_tambahan_id) <= 0 ){
													return "<span class='text-danger'>-</span>";
												}else{
													return row.persen;
												}
											}
										},
										{  data: 'action',width:"60px",
											"render": function ( data, type, row ) {
											
											if ( (row.realisasi_tugas_tambahan_id) >= 1 ){
												return  '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_realisasi_tugas_tambahan"  data-id="'+row.realisasi_tugas_tambahan_id+'"><i class="fa fa-pencil" ></i></a></span>'+
														'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_realisasi_tugas_tambahan"  data-id="'+row.realisasi_tugas_tambahan_id+'" data-label="'+row.tugas_tambahan_label+'" ><i class="fa fa-close " ></i></a></span>';
											}else{
												return  '<span  data-toggle="tooltip" title="Add" style="margin:2px;" ><a class="btn btn-info btn-xs create_realisasi_tugas_tambahan"  data-id="'+row.tugas_tambahan_id+'"><i class="fa fa-plus" ></i></a></span>'+
														'<span  style="margin:2px;" disabled><a class="btn btn-default btn-xs "  ><i class="fa fa-close " ></i></a></span>';
											
											} 
													
										
										}
									},
									
									],
									initComplete: function(settings, json) {
									
								}
		});	
	}
	


	$(document).on('click','.create_realisasi_tugas_tambahan',function(e){
		//alert();
		var tugas_tambahan_id = $(this).data('id');
		show_modal_create_realisasi_tugas_tambahan(tugas_tambahan_id);
	});

	function show_modal_create_realisasi_tugas_tambahan(tugas_tambahan_id){
		
		$.ajax({
				url			  : '{{ url("api/tugas_tambahan_detail") }}',
				data 		  : {tugas_tambahan_id : tugas_tambahan_id},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					$('.modal-realisasi_tugas_tambahan').find('[name=tugas_tambahan_id]').val(data['id']);
					$('.modal-realisasi_tugas_tambahan').find('[name=realisasi_tugas_tambahan_id]').val("");
					$('.modal-realisasi_tugas_tambahan').find('[name=capaian_id]').val({!! $capaian->id !!});
					$('.modal-realisasi_tugas_tambahan').find('[name=satuan]').val(data['satuan']);

					$('.modal-realisasi_tugas_tambahan').find('.tugas_tambahan_label').html(data['label']);
					$('.modal-realisasi_tugas_tambahan').find('.tugas_tambahan_output').html(data['output']);

					$('.modal-realisasi_tugas_tambahan').find('.tugas_tambahan_satuan').html(data['satuan']);
					$('.modal-realisasi_tugas_tambahan').find('.tugas_tambahan_target').val(data['target']);

					$('.modal-realisasi_tugas_tambahan').find('h4').html('Add Realisasi Uraian Tugas Tambahan');
					$('.modal-realisasi_tugas_tambahan').find('.btn-submit').attr('id', 'submit-save_realisasi_utt');
					$('.modal-realisasi_tugas_tambahan').find('[name=text_button_submit]').html('Simpan Data');
					$('.modal-realisasi_tugas_tambahan').modal('show');  
				},
				error: function(data){
					
				}						
		});	
	}

	$(document).on('click','.edit_realisasi_tugas_tambahan',function(e){
		var realisasi_tugas_tambahan_id = $(this).data('id') ;
		
		$.ajax({
				url			: '{{ url("api/realisasi_tugas_tambahan_detail") }}',
				data 		: {realisasi_tugas_tambahan_id : realisasi_tugas_tambahan_id},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					$('.modal-realisasi_tugas_tambahan').find('[name=realisasi_tugas_tambahan_id]').val(data['id']);
					$('.modal-realisasi_tugas_tambahan').find('[name=tugas_tambahan_id]').val(data['tugas_tambahan_id']);
					$('.modal-realisasi_tugas_tambahan').find('[name=capaian_id]').val(data['capaian_id']);
					$('.modal-realisasi_tugas_tambahan').find('[name=satuan]').val(data['satuan']);

					$('.modal-realisasi_tugas_tambahan').find('.tugas_tambahan_label').html(data['label']);
					$('.modal-realisasi_tugas_tambahan').find('.tugas_tambahan_output').html(data['output']);

					$('.modal-realisasi_tugas_tambahan').find('.tugas_tambahan_satuan').html(data['satuan']);
					$('.modal-realisasi_tugas_tambahan').find('.tugas_tambahan_target').val(data['target']);
					$('.modal-realisasi_tugas_tambahan').find('.tugas_tambahan_realisasi').val(data['realisasi']);

					$('.modal-realisasi_tugas_tambahan').find('h4').html('Edit Realisasi Uraian Tugas Tambahan');
					$('.modal-realisasi_tugas_tambahan').find('.btn-submit').attr('id', 'submit-update_realisasi_utt');
					$('.modal-realisasi_tugas_tambahan').find('[name=text_button_submit]').html('Update Data');
					$('.modal-realisasi_tugas_tambahan').modal('show');  
				},
				error: function(data){
					
				}						
		});	 
	
	});

	$(document).on('click','.hapus_realisasi_tugas_tambahan',function(e){
		var realisasi_tugas_tambahan = $(this).data('id') ;
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
					url		: '{{ url("api/hapus_realisasi_tugas_tambahan") }}',
					type	: 'POST',
					data    : { realisasi_tugas_tambahan:realisasi_tugas_tambahan },
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
										$('#realisasi_tugas_tambahan_table').DataTable().ajax.reload(null,false);
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#realisasi_tugas_tambahan_table').DataTable().ajax.reload(null,false);
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