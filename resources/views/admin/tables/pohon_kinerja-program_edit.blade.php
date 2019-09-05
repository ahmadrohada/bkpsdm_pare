<div class="box box-primary div_ind_sasaran_detail" hidden>
	<div class="box-header with-border">
		<h1 class="box-title">
			Detail Indikator Sasaran
		</h1>


		<div class="box-tools pull-right">
			{!! Form::button('<i class="fa fa-remove "></i>', array('class' => 'btn btn-box-tool tutup_detail','title' => 'Tutup', 'data-toggle' => 'tooltip')) !!}
		</div>
	</div>
	<div class="box-body table-responsive">

		<strong>Indikator Sasaran</strong>
		<p class="text-muted " style="margin-top:8px;padding-bottom:10px;">
			<span class="txt_ind_sasaran_label"></span>
		</p>

		<strong>Target</strong>
		<p class="text-muted " style="margin-top:8px;padding-bottom:10px;">
			<span class="txt_ind_sasaran_target"></span>
		</p>

					
	</div>
</div>
<div class="box box-primary div_program_list" hidden>
    <div class="box-header with-border">
		<h1 class="box-title">
            List Program
        </h1>
    </div>



	<div class="box-body table-responsive">

		<div class="toolbar">
			
			<span  data-toggle="tooltip" title="Create Program"><a class="btn btn-info btn-sm create_program" ><i class="fa fa-plus" ></i> Program</a></span>
		
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

@include('admin.modals.renja_program')

<script type="text/javascript">

 
function load_program(ind_sasaran_id){


$.ajax({
		url			: '{{ url("api_resource/ind_sasaran_detail") }}',
		data 		: {ind_sasaran_id : ind_sasaran_id},
		method		: "GET",
		dataType	: "json",
		success	: function(data) {
				$('.txt_ind_sasaran_label').html(data['label']);
				$('.txt_ind_sasaran_target').html(data['target']+' '+data['satuan']);
				$('.ind_sasaran_id').val(data['id']);
				
		},
		error: function(data){
			
		}						
});


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
							data: { ind_sasaran_id: ind_sasaran_id },
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
	$('.modal-program').find('h4').html('Create Program');
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