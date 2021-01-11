<div class="box box-sasaran div_sasaran" hidden>
	<div class="box-header with-border">
		{{-- <h1 class="box-title">
			Sasaran
		</h1> --}}
		&nbsp;
		<div class="box-tools pull-right">
			{!! Form::button('<i class="fa  fa-level-up"></i>', array('class' => 'btn btn-box-tool tutup_detail','title' => 'Tujuan List', 'data-toggle' => 'tooltip')) !!}
		</div>
	</div>
	<div class="box-body table-responsive">
		<label>Sasaran : </label>
		<p class="text-muted " style="font-size:11pt;">
			<span class="txt_sasaran_label"></span>
		</p>
		<div class="toolbar pull-right">
			<span  data-toggle="tooltip" title="Create Indikator Sasaran"><a class="btn btn-info btn-xs create_ind_sasaran" ><i class="fa fa-plus" ></i> Indikator</a></span>
		</div>
		<table id="ind_sasaran_table" class="table table-striped table-hover table-condensed" >
			<thead>
				<tr class="success">
					<th>NO</th>
					<th >INDIKATOR SASARAN</th>
					<th >TARGET</th>
					<th>ACTION</th>
				</tr>
			</thead>
		</table>
	</div>
	<div class="box-body table-responsive">
		<div class="toolbar pull-right">
			<span  data-toggle="tooltip" title="Create Program"><a class="btn btn-info btn-xs create_program" ><i class="fa fa-plus" ></i> Program</a></span>
		</div>
		<table id="program_table" class="table table-striped table-hover table-condensed" >
			<thead>
				<tr class="success">
					<th>NO</th>
					<th >PROGRAM</th>
					<th><i class="fa fa-cog"></i></th>
				</tr>
			</thead>
		</table>
	</div>
</div>


@include('pare_pns.modals.renja_ind_sasaran')
@include('pare_pns.modals.renja_program')

<script type="text/javascript">

    
function load_sasaran(sasaran_id){


	$.ajax({
			url			: '{{ url("api/sasaran_detail") }}',
			data 		: {sasaran_id : sasaran_id},
			method		: "GET",
			dataType	: "json",
			success	: function(data) {
					$('.txt_sasaran_label').html(data['label']);
					$('.sasaran_id').val(data['id']);
					
			},
			error: function(data){
				
			}						
	});


	$('#ind_sasaran_table').DataTable({
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
									url	: '{{ url("api/skpd-renja_ind_sasaran_list") }}',
									data: { sasaran_id: sasaran_id },
								}, 
				columns			:[
								{ data: 'ind_sasaran_id' , orderable: true,searchable:false,width:"30px",
										"render": function ( data, type, row ,meta) {
											return meta.row + meta.settings._iDisplayStart + 1 ;
										}
									},
								{ data: "label_ind_sasaran", name:"label_ind_sasaran", orderable: true, searchable: true},
								{ data: "target_ind_sasaran", name:"target_ind_sasaran", orderable: true, searchable: true, width:"90px"},
								{  data: 'action',width:"60px",
										"render": function ( data, type, row ) {
											return  '<span  data-toggle="tooltip" title="Edit" style="margin:1px;" ><a class="btn btn-success btn-xs edit_ind_sasaran"  data-id="'+row.ind_sasaran_id+'"><i class="fa fa-pencil" ></i></a></span>'+
													'<span  data-toggle="tooltip" title="Hapus" style="margin:1px;" ><a class="btn btn-danger btn-xs hapus_ind_sasaran"  data-id="'+row.ind_sasaran_id+'" data-label="'+row.label_ind_sasaran+'" ><i class="fa fa-close " ></i></a></span>';
												
										}
								},
							],
							initComplete: function(settings, json) {
								
								}
		
		
	});	

	$('#program_table').DataTable({
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
								url	: '{{ url("api/skpd-renja_program_list") }}',
								data: { sasaran_id: sasaran_id },
							}, 
			columns			:[
							{ data: 'program_id' , orderable: true,searchable:false,width:"30px",
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
							{ data: "label_program", name:"label_program", orderable: true, searchable: true},
							{  data: 'action',width:"60px",
									"render": function ( data, type, row ) {
										return  '<span  data-toggle="tooltip" title="Edit" style="margin:1px;" ><a class="btn btn-success btn-xs edit_program"  data-id="'+row.program_id+'"><i class="fa fa-pencil" ></i></a></span>'+
												'<span  data-toggle="tooltip" title="Hapus" style="margin:1px;" ><a class="btn btn-danger btn-xs hapus_program"  data-id="'+row.program_id+'" data-label="'+row.label_program+'" ><i class="fa fa-close " ></i></a></span>';
											
									}
							},
						],
						initComplete: function(settings, json) {
							
							}
		
		
	});	


}


	$(document).on('click','.create_ind_sasaran',function(e){
		$('.modal-ind_sasaran').find('h4').html('Create Indikator Sasaran');
		$('.modal-ind_sasaran').find('.btn-submit').attr('id', 'submit-save-ind_sasaran');
		$('.modal-ind_sasaran').find('[name=text_button_submit]').html('Simpan Data');
		$('.modal-ind_sasaran').modal('show');
	});

	$(document).on('click','.edit_ind_sasaran',function(e){
		var ind_sasaran_id = $(this).data('id') ;
		$.ajax({
				url			: '{{ url("api/ind_sasaran_detail") }}',
				data 		: {ind_sasaran_id : ind_sasaran_id},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					$('.modal-ind_sasaran').find('[name=label_ind_sasaran]').val(data['label']);
					$('.modal-ind_sasaran').find('[name=target_ind_sasaran]').val(data['target']);
					$('.modal-ind_sasaran').find('[name=satuan_ind_sasaran]').val(data['satuan']);

					$('.modal-ind_sasaran').find('[name=ind_sasaran_id]').val(data['id']);
					$('.modal-ind_sasaran').find('h4').html('Edit ind_sasaran');
					$('.modal-ind_sasaran').find('.btn-submit').attr('id', 'submit-update-ind_sasaran');
					$('.modal-ind_sasaran').find('[name=text_button_submit]').html('Update Data');
					$('.modal-ind_sasaran').modal('show');
				},
				error: function(data){
					
				}						
		});	
	});
 
	$(document).on('click','.hapus_ind_sasaran',function(e){
		var ind_sasaran_id = $(this).data('id') ;
		//alert(sasaran_id);

		Swal.fire({
			title: "Hapus  Indikator Sasaran",
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
					url		: '{{ url("api/hapus_ind_sasaran") }}',
					type	: 'POST',
					data    : {ind_sasaran_id:ind_sasaran_id},
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
										$('#ind_sasaran_table').DataTable().ajax.reload(null,false);
										jQuery('#renja_tree_kegiatan').jstree(true).refresh(true);
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#ind_sasaran_table').DataTable().ajax.reload(null,false);
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

	
	$(document).on('click','.create_program',function(e){
		$('.modal-program').find('h4').html('Create Program');
		$('.modal-program').find('.btn-submit').attr('id', 'submit-save-program');
		$('.modal-program').find('[name=text_button_submit]').html('Simpan Data');
		$('.modal-program').modal('show');
	});

	$(document).on('click','.edit_program',function(e){
		var program_id = $(this).data('id') ;
		$.ajax({
				url			: '{{ url("api/program_detail") }}',
				data 		: {program_id : program_id},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					$('.modal-program').find('[name=label_program]').val(data['label']);
					
					$('.modal-program').find('[name=program_id]').val(data['id']);
					$('.modal-program').find('h4').html('Edit Program');
					$('.modal-program').find('.btn-submit').attr('id', 'submit-update-program');
					$('.modal-program').find('[name=text_button_submit]').html('Update Data');
					$('.modal-program').modal('show');
				},
				error: function(data){
					
				}						
		});	
	});

	$(document).on('click','.hapus_program',function(e){
		var program_id = $(this).data('id') ;
		
		Swal.fire({
			title: "Hapus  Program",
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
					url		: '{{ url("api/hapus_program") }}',
					type	: 'POST',
					data    : {program_id:program_id},
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
										$('#program_table').DataTable().ajax.reload(null,false);
										jQuery('#renja_tree_kegiatan').jstree(true).refresh(true);
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#program_table').DataTable().ajax.reload(null,false);
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
