<div class="box-body table-responsive" style="min-height:330px;">
	<div class="toolbar">
		@if (request()->segment(4) == 'edit' ) 
		<span><a class="btn btn-info btn-sm add_kegiatan_skp_tahunan" ><i class="fa fa-plus" ></i> Add Kegiatan SKP</a></span>
		@endif
	</div>

	<table id="kegiatan_skp_tahunan_3_table" class="table table-striped table-hover" >
		<thead>
			<tr>
				<th rowspan="2">No</th>
				<th rowspan="2" style="white-space: nowrap; padding: 3px 120px;">KEGIATAN TAHUNAN</th>
				<th rowspan="2" style="padding: 3px 130px;">INDIKATOR</th>
				<th colspan="4">TARGET</th>
				<th rowspan="2"><i class="fa fa-cog"></i></th>
			</tr>
			<tr>
				<th style="padding: 3px 25px;">AK</th>
				<th style="padding: 3px 20px;">QUANTITY</th>
				<th>WAKTU</th>
				<th style="padding: 3px 30px;">ANGGARAN</th>

			</tr>
		</thead>
						
	</table>
</div>


@include('pare_pns.modals.kegiatan_skp_tahunan-add')

<script type="text/javascript">

	$('#kegiatan_skp_tahunan_3_table').DataTable({ 
				destroy			: true,
				processing      : true,
				serverSide      : true,
				searching      	: false,
				paging          : false,
				bInfo			: false,
				bSort			: false,
				lengthChange	: false,
				lengthMenu		: [25,50,100],
				columnDefs		: [
									{ className: "text-center", targets: [ 0,3,4,5,7 ] },
									{ className: "text-right", targets: [ 6 ] },
									@if (request()->segment(4) == 'edit')  
										{ visible: true, "targets": [7]},
									@else
										{ visible: false, "targets": [7]},
									@endif
								],
				ajax			: {
									url	: '{{ url("api/kegiatan_skp_tahunan_3") }}',
									data: { "skp_tahunan_id" : {!! $skp->id !!} },
								},
				rowsGroup		: [ 0,1,3,5,6 ],
				columns			: [
									{ data: "no",searchable:false},
									{ data: "kegiatan_skp_tahunan_label", name:"kegiatan_skp_tahunan_label"}, 
									{ data: "indikator_kegiatan_skp_tahunan_label", name:"indikator_kegiatan_skp_tahunan_label"}, 
									{ data: "target_ak", name:"target_ak" },
									{ data: "target_quantity", name:"target_quantity"},
									{ data: "target_waktu", name:"target_waktu"},
									{ data: "target_cost", name:"target_cost"},
									{  data: 'action',width:"60px",
											"render": function ( data, type, row ) {
												if ( row.indikator_kegiatan_skp_tahunan_id == null ){
													return  '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_kegiatan_skp_tahunan"  data-id="'+row.kegiatan_skp_tahunan_label+'"><i class="fa fa-pencil" ></i></a></span>'+
															'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_kegiatan_skp_tahunan"  data-id="'+row.kegiatan_skp_tahunan_id+'" data-label="'+row.kegiatan_skp_tahunan_label+'" ><i class="fa fa-close " ></i></a></span>';
												}else{
													return  '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_indikator_kegiatan_skp_tahunan"  data-id="'+row.indikator_kegiatan_skp_tahunan_label+'"><i class="fa fa-pencil" ></i></a></span>'+
															'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_indikator_kegiatan_skp_tahunan"  data-id="'+row.indikator_kegiatan_skp_tahunan_id+'" data-label="'+row.indikator_kegiatan_skp_tahunan_label+'" ><i class="fa fa-close " ></i></a></span>';
												}
											
										}
									},
								
								],
								initComplete: function(settings, json) {
								
							}
	});	

	$(document).on('click','.add_kegiatan_skp_tahunan',function(e){
		$('#subkegiatan_list_add').DataTable({
					destroy			: true,
					processing      : false,
					serverSide      : true,
					searching      	: false,
					paging          : false,
					bInfo			: false,
					bSort			: false,
					lengthChange	: false,
					lengthMenu		: [25,50,100],
					columnDefs		: [
										{ 	className: "text-center", targets: [ 0 ] },
										{ className: "text-right", targets: [ 2 ] }
									  ],
					ajax			: {
										url		: '{{ url("api/subkegiatan_list_kasubid") }}',
										data	: { skp_tahunan_id : {!! $skp->id !!}  },
										},

					columns	:[
									{ data: 'action' , orderable: true,searchable:false,width:'40px',
									"render": function ( data, type, row ,meta) {
											if ( row.kegiatan_skp_tahunan_id == 0 ){
												return '<input type="checkbox" class="cb_pilih" value="'+row.subkegiatan_id+'" name="cb_pilih[]" >' ;
											}else{
												return '<input type="checkbox" class=""  checked disabled>' ;
											}
										}
									},
									
								
									{ data: "label_subkegiatan" ,  name:"label_subkegiatan", orderable: true, searchable: true},
									//{ data: "kegiatan_target" ,  name:"kegiatan_target", orderable: true, searchable: false,width:'140px'},
									{ data: "cost_subkegiatan" ,  name:"cost_subkegiatan", orderable: true, searchable: false,width:'140px'},
									
									
								]
				 
			});
			$('.modal-kegiatan_skp_tahunan_add').modal('show');

	});


	$(document).on('click','.edit_kegiatan_tahunan',function(e){
		var kegiatan_tahunan_id = $(this).data('id') ;
		$.ajax({
				url			: '{{ url("api/kegiatan_tahunan_detail") }}',
				data 		: {kegiatan_tahunan_id : kegiatan_tahunan_id},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					$('.modal-kegiatan_tahunan').find('[name=label]').val(data['label']);
					$('.modal-kegiatan_tahunan').find('[name=angka_kredit]').val(data['ak']);
					$('.modal-kegiatan_tahunan').find('[name=target]').val(data['target']);
					$('.modal-kegiatan_tahunan').find('[name=quality]').val(data['quality']);
					$('.modal-kegiatan_tahunan').find('[name=satuan]').val(data['satuan']);
					$('.modal-kegiatan_tahunan').find('[name=target_waktu]').val(data['target_waktu']);
					$('.modal-kegiatan_tahunan').find('[name=cost]').val(data['cost']);

				

					$('.modal-kegiatan_tahunan').find('[name=kegiatan_tahunan_id]').val(data['id']);
					$('.modal-kegiatan_tahunan').find('h4').html('Edit Kegiatan Tahunan');
					$('.modal-kegiatan_tahunan').find('.btn-submit').attr('id', 'submit-update');
					$('.modal-kegiatan_tahunan').find('[name=text_button_submit]').html('Update Data');
					$('.modal-kegiatan_tahunan').modal('show');
				},
				error: function(data){
					
				}						
		});	
	});


	$(document).on('click','.hapus_kegiatan_skp_tahunan',function(e){
		var kegiatan_skp_tahunan_id = $(this).data('id') ;
		//alert(kegiatan_tahunan_id);

		Swal.fire({
			title: "Hapus Kegiatan SKP Tahunan",
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
					url		: '{{ url("api/hapus_kegiatan_skp_tahunan") }}',
					type	: 'POST',
					data    : {id:kegiatan_skp_tahunan_id},
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
										$('#kegiatan_skp_tahunan_3_table').DataTable().ajax.reload(null,false);
										//$('#skp_bulanan_table').DataTable().ajax.reload(null,false);
										//jQuery('#kegiatan_tahunan_3').jstree(true).refresh(true);
										//jQuery('#skp_bulanan_tree').jstree(true).refresh(true);

										
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

	$(document).on('click','.hapus_indikator_kegiatan_skp_tahunan',function(e){
		var indikator_kegiatan_skp_tahunan_id = $(this).data('id') ;
		//alert(kegiatan_tahunan_id);

		Swal.fire({
			title: "Hapus  Indikator Kegiatan SKP Tahunan",
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
					url		: '{{ url("api/hapus_indikator_kegiatan_skp_tahunan") }}',
					type	: 'POST',
					data    : {id:indikator_kegiatan_skp_tahunan_id},
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
										$('#kegiatan_skp_tahunan_3_table').DataTable().ajax.reload(null,false);
										//$('#skp_bulanan_table').DataTable().ajax.reload(null,false);
										//jQuery('#kegiatan_tahunan_3').jstree(true).refresh(true);
										//jQuery('#skp_bulanan_tree').jstree(true).refresh(true);

										
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