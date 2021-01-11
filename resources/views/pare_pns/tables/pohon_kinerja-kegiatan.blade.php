<div class="box box-kegiatan div_kegiatan" hidden>
	<div class="box-header with-border">
		{{-- <h1 class="box-title">
			Detail kegiatan
		</h1> --}}
		&nbsp;
		<div class="box-tools pull-right">
			{!! Form::button('<i class="fa  fa-level-up"></i>', array('class' => 'btn btn-box-tool tutup_detail','title' => 'Tujuan List', 'data-toggle' => 'tooltip')) !!}
		</div>
	</div>
	<div class="box-body table-responsive">
		<strong>Kegiatan :</strong>
		<p class="text-muted " style="font-size:11pt;">
			<span class="txt_kegiatan_label"></span>
		</p>
		<div class="toolbar pull-right">
			<span  data-toggle="tooltip" title="Create Indikator kegiatan"><a class="btn btn-info btn-xs create_ind_kegiatan" ><i class="fa fa-plus" ></i> Indikator</a></span>
		</div>
		<table id="ind_kegiatan_table" class="table table-striped table-hover table-condensed" >
			<thead>
				<tr class="success">
					<th>NO</th>
					<th >INDIKATOR KEGIATAN</th>
					<th >TARGET</th>
					<th>ACTION</th>
				</tr>
			</thead>
		</table>
	</div>

	<div class="box-body table-responsive">
		<div class="toolbar pull-right">
			<span  data-toggle="tooltip" title="Create Subkegiatan"><a class="btn btn-info btn-xs create_subkegiatan" ><i class="fa fa-plus" ></i> Sub Kegiatan</a></span>
		</div>
		<table id="subkegiatan_table" class="table table-striped table-hover table-condensed" >
			<thead>
				<tr class="success">
					<th>NO</th>
					<th >SUB KEGIATAN</th>
					<th >ANGGARAN</th>
					<th><i class="fa fa-cog"></i></th>
				</tr>
			</thead>
			
		</table>
		<table id="subkegiatan_table_non_anggaran" class="table table-striped table-hover table-condensed" >
			<thead>
				<tr class="success">
					<th>NO</th>
					<th >SUB KEGIATAN NON ANGGARAN</th>
					<th><i class="fa fa-cog"></i></th>
				</tr>
			</thead>
			
		</table>

	</div>
	
</div>



@include('pare_pns.modals.renja_ind_kegiatan')
@include('pare_pns.modals.renja_subkegiatan')


<script type="text/javascript">

    
function load_kegiatan(kegiatan_id){


	$.ajax({
			url			: '{{ url("api/kegiatan_detail") }}',
			data 		: {kegiatan_id : kegiatan_id},
			method		: "GET",
			dataType	: "json",
			success	: function(data) {
					$('.txt_kegiatan_label').html(data['label']);
					$('.cost').html("Rp. "+ data['cost']);
					$('.kegiatan_id').val(data['kegiatan_id']);
					
			},
			error: function(data){
				
			}						
	});


	$('#ind_kegiatan_table').DataTable({
				destroy			: true,
				processing      : false,
				serverSide      : true,
				searching      	: false,
				paging          : false,
				autoWidth		: false,
				bInfo			: false,
				bSort			: false, 
				lengthChange	: false,
				deferRender		: true,
				columnDefs		: [
									{ className: "text-center", targets: [ 0,2,3 ] }
								],
				ajax			: {
									url	: '{{ url("api/skpd-renja_ind_kegiatan_list") }}',
									data: { kegiatan_id: kegiatan_id },
								}, 
				columns			:[
								{ data: 'ind_kegiatan_id' , orderable: true,searchable:false,width:"30px",
										"render": function ( data, type, row ,meta) {
											return meta.row + meta.settings._iDisplayStart + 1 ;
										}
									},
								{ data: "label_ind_kegiatan", name:"label_ind_kegiatan", orderable: true, searchable: true},
								{ data: "target_ind_kegiatan", name:"target_ind_kegiatan", orderable: true, searchable: true, width:"90px"},
								{  data: 'action',width:"60px",
										"render": function ( data, type, row ) {
											return  '<span  data-toggle="tooltip" title="Edit" style="margin:1px;" ><a class="btn btn-success btn-xs edit_ind_kegiatan"  data-id="'+row.ind_kegiatan_id+'"><i class="fa fa-pencil" ></i></a></span>'+
													'<span  data-toggle="tooltip" title="Hapus" style="margin:1px;" ><a class="btn btn-danger btn-xs hapus_ind_kegiatan"  data-id="'+row.ind_kegiatan_id+'" data-label="'+row.label_ind_kegiatan+'" ><i class="fa fa-close " ></i></a></span>';
												
										}
								},
							],
							initComplete: function(settings, json) {
								
								}
		
		
	});	

	$('#subkegiatan_table').DataTable({
			destroy			: true,
			processing      : false,
			serverSide      : true,
			searching      	: false,
			paging          : false,
			autoWidth		: false,
			bInfo			: false,
			bSort			: false, 
			lengthChange	: false,
			deferRender		: true,
			columnDefs		: [
								{ className: "text-center", targets: [ 0,2,3] },
								{ className: "text-right", targets: [ 2 ] }
							  ],
			ajax			: {
								url	: '{{ url("api/skpd-renja_subkegiatan_list") }}',
								data: { kegiatan_id: kegiatan_id ,
										renja_id:{!! $renja->id !!}
									 },
							 }, 
			columns			:[
							{ data: 'subkegiatan_id' , orderable: true,searchable:false,width:"30px",
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
							{ data: "label_subkegiatan", name:"label_subkegiatan", orderable: true, searchable: true},
							{ data: "cost_subkegiatan", name:"cost_subkegiatan", orderable: true, searchable: true},
							{  data: 'action',width:"60px",
										"render": function ( data, type, row ) {
											return  '<span  data-toggle="tooltip" title="Edit" style="margin:1px;" ><a class="btn btn-success btn-xs edit_subkegiatan"  data-id="'+row.subkegiatan_id+'"><i class="fa fa-pencil" ></i></a></span>'+
													'<span  data-toggle="tooltip" title="Hapus" style="margin:1px;" ><a class="btn btn-danger btn-xs hapus_subkegiatan"  data-id="'+row.subkegiatan_id+'" data-label="'+row.label_subkegiatan+'" ><i class="fa fa-close " ></i></a></span>';
												
										}
								},
						],
						initComplete: function(settings, json) {
							
   				 		}
		
		
	});	

	$('#subkegiatan_table_non_anggaran').DataTable({
			destroy			: true,
			processing      : false,
			serverSide      : true,
			searching      	: false,
			paging          : false,
			autoWidth		: false,
			bInfo			: false,
			bSort			: false, 
			lengthChange	: false,
			deferRender		: true,
			columnDefs		: [
								{ className: "text-center", targets: [ 0,2 ] },
								//{ className: "text-right", targets: [ 2 ] }
							  ],
			ajax			: {
								url	: '{{ url("api/skpd-renja_subkegiatan_non_anggaran_list") }}',
								data: { kegiatan_id: kegiatan_id ,
										renja_id:{!! $renja->id !!}
									 },
							 }, 
			columns			:[
							{ data: 'subkegiatan_id' , orderable: true,searchable:false,width:"30px",
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + ( row.jm_data + 1 )  ;
									}
								},
							{ data: "label_subkegiatan", name:"label_subkegiatan", orderable: true, searchable: true},
							
							
							{  data: 'action',width:"60px",
										"render": function ( data, type, row ) {
											return  '<span  data-toggle="tooltip" title="Edit" style="margin:1px;" ><a class="btn btn-success btn-xs edit_subkegiatan"  data-id="'+row.subkegiatan_id+'"><i class="fa fa-pencil" ></i></a></span>'+
													'<span  data-toggle="tooltip" title="Hapus" style="margin:1px;" ><a class="btn btn-danger btn-xs hapus_subkegiatan"  data-id="'+row.subkegiatan_id+'" data-label="'+row.label_subkegiatan+'" ><i class="fa fa-close " ></i></a></span>';
												
										}
							},
						],
						initComplete: function(settings, json) {
							
   				 		}
		
		
	});	


}


	$(document).on('click','.create_ind_kegiatan',function(e){
		$('.modal-ind_kegiatan').find('h4').html('Create Indikator kegiatan');
		$('.modal-ind_kegiatan').find('.btn-submit').attr('id', 'submit-save-ind_kegiatan');
		$('.modal-ind_kegiatan').find('[name=text_button_submit]').html('Simpan Data');
		$('.modal-ind_kegiatan').modal('show');
	});

	$(document).on('click','.edit_ind_kegiatan',function(e){
		var ind_kegiatan_id = $(this).data('id') ;
		//alert(ind_kegiatan_id);
	    $.ajax({
				url			: '{{ url("api/ind_kegiatan_detail") }}',
				data 		:  {ind_kegiatan_id : ind_kegiatan_id},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					$('.modal-ind_kegiatan').find('[name=label_ind_kegiatan]').val(data['label']);
					$('.modal-ind_kegiatan').find('[name=target_ind_kegiatan]').val(data['target']);
					$('.modal-ind_kegiatan').find('[name=satuan_ind_kegiatan]').val(data['satuan']);

					$('.modal-ind_kegiatan').find('[name=ind_kegiatan_id]').val(data['id']);
					$('.modal-ind_kegiatan').find('h4').html('Edit Indikator Kegiatan');
					$('.modal-ind_kegiatan').find('.btn-submit').attr('id', 'submit-update-ind_kegiatan');
					$('.modal-ind_kegiatan').find('[name=text_button_submit]').html('Update Data');
					$('.modal-ind_kegiatan').modal('show');
				},
				error: function(data){
					
				}						
		});	 
	});

	$(document).on('click','.hapus_ind_kegiatan',function(e){
		var ind_kegiatan_id = $(this).data('id') ;
		//alert(kegiatan_id);

		Swal.fire({
			title: "Hapus  Indikator kegiatan",
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
					url		: '{{ url("api/hapus_ind_kegiatan") }}',
					type	: 'POST',
					data    : {ind_kegiatan_id:ind_kegiatan_id},
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
										$('#ind_kegiatan_table').DataTable().ajax.reload(null,false);
										jQuery('#renja_tree_kegiatan').jstree(true).refresh(true);
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#ind_kegiatan_table').DataTable().ajax.reload(null,false);
											jQuery('#renja_tree_kegiatan').jstree(true).refresh(true);
											
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
	
//================================================================================================================================//

	$(document).on('click','.create_subkegiatan',function(e){
		$('.modal-subkegiatan').find('h4').html('Create Sub Kegiatan');
		$('.modal-subkegiatan').find('.btn-submit').attr('id', 'submit-save-subkegiatan');
		$('.modal-subkegiatan').find('[name=text_button_submit]').html('Simpan Data');
		$('.modal-subkegiatan').modal('show');
	});

	$(document).on('click','.edit_subkegiatan',function(e){
		var subkegiatan_id = $(this).data('id') ;
		$.ajax({
				url			: '{{ url("api/subkegiatan_detail") }}',
				data 		: {subkegiatan_id : subkegiatan_id},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					$('.modal-subkegiatan').find('[name=label_subkegiatan]').val(data['label']);
					$('.modal-subkegiatan').find('[name=label_ind_subkegiatan]').val(data['indikator']);
					$('.modal-subkegiatan').find('[name=target_subkegiatan]').val(data['target']);
					$('.modal-subkegiatan').find('[name=satuan_subkegiatan]').val(data['satuan']);
					$('.modal-subkegiatan').find('[name=cost_subkegiatan]').val(data['cost']);
					
					$('.modal-subkegiatan').find('[name=subkegiatan_id]').val(data['subkegiatan_id']);
					$('.modal-subkegiatan').find('h4').html('Edit Kegiatan');
					$('.modal-subkegiatan').find('.btn-submit').attr('id', 'submit-update-subkegiatan');
					$('.modal-subkegiatan').find('[name=text_button_submit]').html('Update Data');
					$('.modal-subkegiatan').modal('show');
				},
				error: function(data){
					
				}						
		});	
	});

	$(document).on('click','.hapus_subkegiatan',function(e){
		var subkegiatan_id = $(this).data('id') ;
		//alert(tujuan_id);

		Swal.fire({
			title: "Hapus Sub Kegiatan",
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
					url		: '{{ url("api/hapus_subkegiatan") }}',
					type	: 'POST',
					data    : {subkegiatan_id:subkegiatan_id},
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
										$('#subkegiatan_table_non_anggaran').DataTable().ajax.reload(null,false);
										$('#subkegiatan_table').DataTable().ajax.reload(null,false);
										jQuery('#renja_tree_kegiatan').jstree(true).refresh(true);
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#subkegiatan_table_non_anggaran').DataTable().ajax.reload(null,false);
											$('#subkegiatan_table').DataTable().ajax.reload(null,false);
											jQuery('#renja_tree_kegiatan').jstree(true).refresh(true);
											
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
