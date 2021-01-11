
<div class="box box-tujuan div_tujuan_top">
    <div class="box-header with-border">
		<h1 class="box-title">
            Tujuan
        </h1>
        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
        </div>
    </div>
 


	<div class="box-body table-responsive">

		<div class="toolbar">
			
			<span  data-toggle="tooltip" title="Create Tujuan"><a class="btn btn-info btn-xs create_tujuan" ><i class="fa fa-plus" ></i> Tujuan</a></span>
		
		</div>
		<table id="tujuan_table" class="table table-striped table-hover table-condensed" >
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

@include('pare_pns.modals.renja_tujuan')

<script type="text/javascript">

    $('#tujuan_table').DataTable({
				destroy			: true,
				processing      : false,
				serverSide      : true,
				searching      	: false,
				paging          : false,
			columnDefs		: [
								{ className: "text-center", targets: [ 0,2 ] }
							  ],
			ajax			: {
								url	: '{{ url("api/skpd-renja_tujuan_list") }}',
								data: { renja_id: {!! $renja->id !!} },
							 }, 
			columns			:[
							{ data: 'tujuan_id' , orderable: true,searchable:false,width:"30px",
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
							{ data: "label", name:"x", orderable: true, searchable: true},
							{  data: 'action',width:"60px",
									"render": function ( data, type, row ) {
										return  '<span  data-toggle="tooltip" title="Edit" style="margin:1px;" ><a class="btn btn-success btn-xs edit_tujuan"  data-id="'+row.tujuan_id+'"><i class="fa fa-pencil" ></i></a></span>'+
												'<span  data-toggle="tooltip" title="Hapus" style="margin:1px;" ><a class="btn btn-danger btn-xs hapus_tujuan"  data-id="'+row.tujuan_id+'" data-label="'+row.label+'" ><i class="fa fa-close " ></i></a></span>';
											
									}
							},
						],
						initComplete: function(settings, json) {
							
   				 		}
		
	});	

	$(document).on('click','.create_tujuan',function(e){
		$('.modal-tujuan').find('h4').html('Create Tujuan');
		$('.modal-tujuan').find('.btn-submit').attr('id', 'submit-save');
		$('.modal-tujuan').find('[name=text_button_submit]').html('Simpan Data');
		$('.modal-tujuan').modal('show');
	});

	$(document).on('click','.edit_tujuan',function(e){
		var tujuan_id = $(this).data('id') ;
		$.ajax({
				url			: '{{ url("api/tujuan_detail") }}',
				data 		: {tujuan_id : tujuan_id},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					$('.modal-tujuan').find('[name=label]').val(data['label']);
					
					$('.modal-tujuan').find('[name=tujuan_id]').val(data['id']);
					$('.modal-tujuan').find('h4').html('Edit Tujuan');
					$('.modal-tujuan').find('.btn-submit').attr('id', 'submit-update');
					$('.modal-tujuan').find('[name=text_button_submit]').html('Update Data');
					$('.modal-tujuan').modal('show');
				},
				error: function(data){
					
				}						
		});	
	});

	$(document).on('click','.hapus_tujuan',function(e){
		var tujuan_id = $(this).data('id') ;
		//alert(tujuan_id);

		Swal.fire({
			title: "Hapus  Tujuan",
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
					url		: '{{ url("api/hapus_tujuan") }}',
					type	: 'POST',
					data    : {tujuan_id:tujuan_id},
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
										$('#tujuan_table').DataTable().ajax.reload(null,false);
										jQuery('#renja_tree_kegiatan').jstree(true).refresh(true);
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#tujuan_table').DataTable().ajax.reload(null,false);
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
