<div class="box box-program div_program_detail" hidden>
	<div class="box-header with-border">
		<h1 class="box-title">
			Program
		</h1>

		<div class="box-tools pull-right">
			{!! Form::button('<i class="fa fa-remove "></i>', array('class' => 'btn btn-box-tool tutup_detail','title' => 'Tutup', 'data-toggle' => 'tooltip')) !!}
		</div>
	</div>
	<div class="box-body table-responsive">
		<p class="text-muted " style="margin-top:8px;padding-bottom:10px;">
			<span class="txt_program_label"></span>
		</p>
	</div>
</div>
<div class="box box-program div_ind_program_list" hidden>
    <div class="box-header with-border">
		<h1 class="box-title">
            List Indikator Program
        </h1>

        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
        </div>
    </div>



	<div class="box-body table-responsive">

		<div class="toolbar">
			
			<span  data-toggle="tooltip" title="Create Indikator Program"><a class="btn btn-info btn-xs create_ind_program" ><i class="fa fa-plus" ></i> Indikator Program</a></span>
			
		
		</div>
		<table id="ind_program_table" class="table table-striped table-hover table-condensed" >
			<thead>
				<tr class="success">
					<th>NO</th>
					<th >LABEL</th>
					<th >TARGET</th>
					<th>ACTION</th>
				</tr>
			</thead>
			
		</table>

	</div>
</div>

@include('pare_pns.modals.renja_ind_program')

<script type="text/javascript">

    
function load_ind_program(program_id){


$.ajax({
		url			: '{{ url("api_resource/program_detail") }}',
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
			columnDefs		: [
								{ className: "text-center", targets: [ 0,2,3 ] }
							],
			ajax			: {
								url	: '{{ url("api_resource/skpd-renja_ind_program_list") }}',
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
				url			: '{{ url("api_resource/ind_program_detail") }}',
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
					url		: '{{ url("api_resource/hapus_ind_program") }}',
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

</script>
