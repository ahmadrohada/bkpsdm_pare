<div class="box box-program div_program_list" hidden>
    <div class="box-header with-border">
		<h1 class="box-title">
            List Kegiatan
        </h1>
    </div>



	<div class="box-body table-responsive">

		<div class="toolbar">
			
			<span  data-toggle="tooltip" title="Create Kegiatan"><a class="btn btn-info btn-xs create_program" ><i class="fa fa-plus" ></i> Kegiatan</a></span>
		
		</div>
		<table id="program_table" class="table table-striped table-hover table-condensed" >
			<thead>
				<tr class="success">
					<th>NO</th>
					<th >LABEL</th>
					<th><i class="fa fa-cog"></i></th>
				</tr>
			</thead>
			
		</table>

	</div>
</div>

@include('pare_2021.modals.renja_program')

<script type="text/javascript">

 
function load_program(sasaran_id){


$('#program_table').DataTable({
			destroy			: true,
			processing      : false,
			serverSide      : true,
			searching      	: false,
			paging          : false,
		columnDefs		: [
							{ className: "text-center", targets: [ 0,2 ] }
						  ],
		ajax			: {
							url	: '{{ url("api_resource/skpd-renja_program_list") }}',
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


$(document).on('click','.create_program',function(e){
	$('.modal-program').find('h4').html('Create Kegiatan');
	$('.modal-program').find('.btn-submit').attr('id', 'submit-save-program');
	$('.modal-program').find('[name=text_button_submit]').html('Simpan Data');
	$('.modal-program').modal('show');
});

$(document).on('click','.edit_program',function(e){
	var program_id = $(this).data('id') ;
	$.ajax({
			url			: '{{ url("api_resource/program_detail") }}',
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
				url		: '{{ url("api_resource/hapus_program") }}',
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
