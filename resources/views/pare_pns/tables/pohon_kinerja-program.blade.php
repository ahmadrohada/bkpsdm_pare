<div class="box box-program div_program" hidden>
	<div class="box-header with-border">
		{{-- <h1 class="box-title">
			
		</h1> --}}
		&nbsp;
		<div class="box-tools pull-right">
			{!! Form::button('<i class="fa  fa-level-up"></i>', array('class' => 'btn btn-box-tool tutup_detail','title' => 'Tujuan List', 'data-toggle' => 'tooltip')) !!}
		</div>
	</div>
	<div class="box-body table-responsive">
		<label>Program : </label>
		<p class="text-muted " style="font-size:11pt;">
			<span class="txt_program_label"></span>
		</p>
		<div class="toolbar pull-right">
			<span  data-toggle="tooltip" title="Create Indikator Program"><a class="btn btn-info btn-xs create_ind_program" ><i class="fa fa-plus" ></i> Indikator</a></span>
		</div>
		<table id="ind_program_table" class="table table-striped table-hover table-condensed" >
			<thead>
				<tr class="success">
					<th>NO</th>
					<th >INDIKATOR PROGRAM</th>
					<th >TARGET</th>
					<th>ACTION</th>
				</tr>
			</thead>
		</table>
	</div>
	<div class="box-body table-responsive">
		<div class="toolbar pull-right">
			<span  data-toggle="tooltip" title="Create Kegiatan"><a class="btn btn-info btn-xs create_kegiatan" ><i class="fa fa-plus" ></i> Kegiatan</a></span>
		</div>
		<table id="kegiatan_table" class="table table-striped table-hover table-condensed" >
			<thead>
				<tr class="success">
					<th>NO</th>
					<th >KEGIATAN</th>
					<th><i class="fa fa-cog"></i></th>
				</tr>
			</thead>
		</table>
	</div>
</div>

@include('pare_pns.modals.renja_ind_program')
@include('pare_pns.modals.renja_kegiatan')

<script type="text/javascript"> 

    
function load_program(program_id){


	$.ajax({
			url			: '{{ url("api/program_detail") }}',
			data 		: {program_id : program_id},
			method		: "GET",
			dataType	: "json",
			success	: function(data) {
					$('.txt_program_label').html(data['label']);
					$('.program_id').val(data['id']);
					
			},
			error: function(data){
				
			}						
	});


	$('#ind_program_table').DataTable({
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
									url	: '{{ url("api/skpd-renja_ind_program_list") }}',
									data: { program_id: program_id },
								}, 
				columns			:[
								{ data: 'ind_program_id' , orderable: true,searchable:false,width:"30px",
										"render": function ( data, type, row ,meta) {
											return meta.row + meta.settings._iDisplayStart + 1 ;
										}
									},
								{ data: "label_ind_program", name:"label_ind_program", orderable: true, searchable: true},
								{ data: "target_ind_program", name:"target_ind_program", orderable: true, searchable: true, width:"90px"},
								{  data: 'action',width:"60px",
										"render": function ( data, type, row ) {
											return  '<span  data-toggle="tooltip" title="Edit" style="margin:1px;" ><a class="btn btn-success btn-xs edit_ind_program"  data-id="'+row.ind_program_id+'"><i class="fa fa-pencil" ></i></a></span>'+
													'<span  data-toggle="tooltip" title="Hapus" style="margin:1px;" ><a class="btn btn-danger btn-xs hapus_ind_program"  data-id="'+row.ind_program_id+'" data-label="'+row.label_ind_program+'" ><i class="fa fa-close " ></i></a></span>';
												
										}
								},
							],
							initComplete: function(settings, json) {
								
								}
		
		
	});	
	$('#kegiatan_table').DataTable({
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
								{ className: "text-center", targets: [ 0,2 ] }
							  ],
			ajax			: {
								url	: '{{ url("api/skpd-renja_kegiatan_list") }}',
								data: { program_id: program_id ,
										renja_id:{!! $renja->id !!}
									 },
							 }, 
			columns			:[
							{ data: 'kegiatan_id' , orderable: true,searchable:false,width:"30px",
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
							{ data: "label_kegiatan", name:"label_kegiatan", orderable: true, searchable: true},
							{  data: 'action',width:"60px",
									"render": function ( data, type, row ) {
										return  '<span  data-toggle="tooltip" title="Edit" style="margin:1px;" ><a class="btn btn-success btn-xs edit_kegiatan"  data-id="'+row.kegiatan_id+'"><i class="fa fa-pencil" ></i></a></span>'+
												'<span  data-toggle="tooltip" title="Hapus" style="margin:1px;" ><a class="btn btn-danger btn-xs hapus_kegiatan"  data-id="'+row.kegiatan_id+'" data-label="'+row.label_kegiatan+'" ><i class="fa fa-close " ></i></a></span>';
											
									}
							},
						],
						initComplete: function(settings, json) {
							
   				 		}
		
		
	});	



}


	$(document).on('click','.create_ind_program',function(e){
		$('.modal-ind_program').find('h4').html('Create Indikator Program');
		$('.modal-ind_program').find('.btn-submit').attr('id', 'submit-save-ind_program');
		$('.modal-ind_program').find('[name=text_button_submit]').html('Simpan Data');
		$('.modal-ind_program').modal('show');
	});

	$(document).on('click','.edit_ind_program',function(e){
		var ind_program_id = $(this).data('id') ;
		$.ajax({
				url			: '{{ url("api/ind_program_detail") }}',
				data 		: {ind_program_id : ind_program_id},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					$('.modal-ind_program').find('[name=label_ind_program]').val(data['label']);
					$('.modal-ind_program').find('[name=target_ind_program]').val(data['target']);
					$('.modal-ind_program').find('[name=satuan_ind_program]').val(data['satuan']);

					$('.modal-ind_program').find('[name=ind_program_id]').val(data['id']);
					$('.modal-ind_program').find('h4').html('Edit ind_program');
					$('.modal-ind_program').find('.btn-submit').attr('id', 'submit-update-ind_program');
					$('.modal-ind_program').find('[name=text_button_submit]').html('Update Data');
					$('.modal-ind_program').modal('show');
				},
				error: function(data){
					
				}						
		});	
	});

	$(document).on('click','.hapus_ind_program',function(e){
		var ind_program_id = $(this).data('id') ;
		//alert(program_id);

		Swal.fire({
			title: "Hapus  Indikator Program",
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
					url		: '{{ url("api/hapus_ind_program") }}',
					type	: 'POST',
					data    : {ind_program_id:ind_program_id},
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
										$('#ind_program_table').DataTable().ajax.reload(null,false);
										jQuery('#renja_tree_kegiatan').jstree(true).refresh(true);
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#ind_program_table').DataTable().ajax.reload(null,false);
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

	$(document).on('click','.create_kegiatan',function(e){
		$('.modal-kegiatan').find('h4').html('Create Kegiatan');
		$('.modal-kegiatan').find('.btn-submit').attr('id', 'submit-save-kegiatan');
		$('.modal-kegiatan').find('[name=text_button_submit]').html('Simpan Data');
		$('.modal-kegiatan').modal('show');
	});

	$(document).on('click','.edit_kegiatan',function(e){
		var kegiatan_id = $(this).data('id') ;
		$.ajax({
				url			: '{{ url("api/kegiatan_detail") }}',
				data 		: {kegiatan_id : kegiatan_id},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					$('.modal-kegiatan').find('[name=label_kegiatan]').val(data['label']);
					$('.modal-kegiatan').find('[name=label_ind_kegiatan]').val(data['indikator']);
					$('.modal-kegiatan').find('[name=target_kegiatan]').val(data['target']);
					$('.modal-kegiatan').find('[name=satuan_kegiatan]').val(data['satuan']);
					$('.modal-kegiatan').find('[name=cost_kegiatan]').val(data['cost']);
					
					$('.modal-kegiatan').find('[name=kegiatan_id]').val(data['kegiatan_id']);
					$('.modal-kegiatan').find('h4').html('Edit Kegiatan');
					$('.modal-kegiatan').find('.btn-submit').attr('id', 'submit-update-kegiatan');
					$('.modal-kegiatan').find('[name=text_button_submit]').html('Update Data');
					$('.modal-kegiatan').modal('show');
				},
				error: function(data){
					
				}						
		});	
	});

	$(document).on('click','.hapus_kegiatan',function(e){
		var kegiatan_id = $(this).data('id') ;
		//alert(tujuan_id);

		Swal.fire({
			title: "Hapus  Kegiatan",
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
					url		: '{{ url("api/hapus_kegiatan") }}',
					type	: 'POST',
					data    : {kegiatan_id:kegiatan_id},
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
										$('#kegiatan_table').DataTable().ajax.reload(null,false);
										$('#kegiatan_table_non_anggaran').DataTable().ajax.reload(null,false);
										jQuery('#renja_tree_kegiatan').jstree(true).refresh(true);
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#kegiatan_table').DataTable().ajax.reload(null,false);
											$('#kegiatan_table_non_anggaran').DataTable().ajax.reload(null,false);
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
