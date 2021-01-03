<div class="box box-sasaran div_sasaran_list" hidden>
    <div class="box-header with-border">
		<h1 class="box-title">
            List Program
        </h1>
    </div>
	<div class="box-body table-responsive">
		<div class="toolbar">
			<span  data-toggle="tooltip" title="Create Program"><a class="btn btn-info btn-xs create_sasaran" ><i class="fa fa-plus" ></i> Program</a></span>
		</div>
		<table id="sasaran_table" class="table table-striped table-hover table-condensed" >
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

@include('pare_2021.modals.renja_sasaran')

<script type="text/javascript">


function load_sasaran(tujuan_id){


    $('#sasaran_table').DataTable({
				destroy			: true,
				processing      : false,
				serverSide      : true,
				searching      	: false,
				paging          : false,
			columnDefs		: [
								{ className: "text-center", targets: [ 0,2 ] }
							  ],
			ajax			: {
								url	: '{{ url("api/skpd-renja_sasaran_list") }}',
								data: { tujuan_id: tujuan_id },
							 }, 
			columns			:[
							{ data: 'sasaran_id' , orderable: true,searchable:false,width:"30px",
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
							{ data: "label_sasaran", name:"label_sasaran", orderable: true, searchable: true},
							{  data: 'action',width:"60px",
									"render": function ( data, type, row ) {
										return  '<span  data-toggle="tooltip" title="Edit" style="margin:1px;" ><a class="btn btn-success btn-xs edit_sasaran"  data-id="'+row.sasaran_id+'"><i class="fa fa-pencil" ></i></a></span>'+
												'<span  data-toggle="tooltip" title="Hapus" style="margin:1px;" ><a class="btn btn-danger btn-xs hapus_sasaran"  data-id="'+row.sasaran_id+'" data-label="'+row.label_sasaran+'" ><i class="fa fa-close " ></i></a></span>';
											
									}
							},
						],
						initComplete: function(settings, json) {
							
   				 		}
		
		
	});	


}


$(document).on('click','.create_sasaran',function(e){
		$('.modal-sasaran').find('h4').html('Create Program');
		$('.modal-sasaran').find('.btn-submit').attr('id', 'submit-save-sasaran');
		$('.modal-sasaran').find('[name=text_button_submit]').html('Simpan Data');
		$('.modal-sasaran').modal('show');
	});

	$(document).on('click','.edit_sasaran',function(e){
		var sasaran_id = $(this).data('id') ;
		$.ajax({
				url			: '{{ url("api/sasaran_detail") }}',
				data 		: {sasaran_id : sasaran_id},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					$('.modal-sasaran').find('[name=label_sasaran]').val(data['label']);
					
					$('.modal-sasaran').find('[name=sasaran_id]').val(data['id']);
					$('.modal-sasaran').find('h4').html('Edit Sasaran');
					$('.modal-sasaran').find('.btn-submit').attr('id', 'submit-update-sasaran');
					$('.modal-sasaran').find('[name=text_button_submit]').html('Update Data');
					$('.modal-sasaran').modal('show');
				},
				error: function(data){
					
				}						
		});	
	});

	$(document).on('click','.hapus_sasaran',function(e){
		var sasaran_id = $(this).data('id') ;
		//alert(tujuan_id);

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
					url		: '{{ url("api/hapus_sasaran") }}',
					type	: 'POST',
					data    : {sasaran_id:sasaran_id},
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
										$('#sasaran_table').DataTable().ajax.reload(null,false);
										jQuery('#renja_tree_kegiatan').jstree(true).refresh(true);
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#sasaran_table').DataTable().ajax.reload(null,false);
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
