<div class="box box-primary div_ind_tujuan_detail" hidden>
	<div class="box-header with-border">
		<h1 class="box-title">
			Detail Indikator Tujuan
		</h1>

		<div class="box-tools pull-right">
			{!! Form::button('<i class="fa fa-remove "></i>', array('class' => 'btn btn-box-tool tutup_detail','title' => 'Tutup', 'data-toggle' => 'tooltip')) !!}
		</div>
	</div>
	<div class="box-body table-responsive" >

		<strong>Indikator Tujuan</strong>
		<p class="text-muted " style="margin-top:8px;padding-bottom:10px;">
			<span class="txt_ind_tujuan_label"></span>
		</p>

		<strong>Target</strong>
		<p class="text-muted " style="margin-top:8px;padding-bottom:10px;">
			<span class="txt_ind_tujuan_target"></span>
		</p>

					
	</div>
</div>
<div class="box box-primary div_sasaran_list" hidden>
    <div class="box-header with-border">
		<h1 class="box-title">
            List Sasaran
        </h1>
    </div>
	<div class="box-body table-responsive">
		<div class="toolbar">
			<span  data-toggle="tooltip" title="Create Sasaran"><a class="btn btn-info btn-sm create_sasaran" ><i class="fa fa-plus" ></i> Sasaran</a></span>
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

@include('admin.modals.renja_sasaran')

<script type="text/javascript">


function load_sasaran(ind_tujuan_id){


	$.ajax({
			url			: '{{ url("api_resource/ind_tujuan_detail") }}',
			data 		: {ind_tujuan_id : ind_tujuan_id},
			method		: "GET",
			dataType	: "json",
			success	: function(data) {
					$('.txt_ind_tujuan_label').html(data['label']);
					$('.txt_ind_tujuan_target').html(data['target']+' '+data['satuan']);
					$('.ind_tujuan_id').val(data['id']);
					
			},
			error: function(data){
				
			}						
	});


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
								url	: '{{ url("api_resource/skpd-renja_sasaran_list") }}',
								data: { ind_tujuan_id: ind_tujuan_id },
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
		$('.modal-sasaran').find('h4').html('Create Sasaran');
		$('.modal-sasaran').find('.btn-submit').attr('id', 'submit-save-sasaran');
		$('.modal-sasaran').find('[name=text_button_submit]').html('Simpan Data');
		$('.modal-sasaran').modal('show');
	});

	$(document).on('click','.edit_sasaran',function(e){
		var sasaran_id = $(this).data('id') ;
		$.ajax({
				url			: '{{ url("api_resource/sasaran_detail") }}',
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
			title: "Hapus  Sasaran",
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
					url		: '{{ url("api_resource/hapus_sasaran") }}',
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
