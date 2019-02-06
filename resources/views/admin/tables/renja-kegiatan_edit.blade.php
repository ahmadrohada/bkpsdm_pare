<div class="box box-primary div_ind_program_detail" hidden>
	<div class="box-header with-border">
		<h1 class="box-title">
			Detail Indikator Program
		</h1>

		<div class="box-tools pull-right">
			{!! Form::button('<i class="fa fa-remove "></i>', array('class' => 'btn btn-box-tool tutup_detail','title' => 'Tutup', 'data-toggle' => 'tooltip')) !!}
		</div>
	</div>
	<div class="box-body table-responsive" >

		<strong>Indikator Program</strong>
		<p class="text-muted " style="margin-top:8px;padding-bottom:10px;">
			<span class="txt_ind_program_label"></span>
		</p>

		<strong>Target</strong>
		<p class="text-muted " style="margin-top:8px;padding-bottom:10px;">
			<span class="txt_ind_program_target"></span>
		</p>

					
	</div>
</div>
<div class="box box-primary div_kegiatan_list" hidden>
    <div class="box-header with-border">
		<h1 class="box-title">
            List Kegiatan
        </h1>
    </div>
	<div class="box-body table-responsive">
		<div class="toolbar">
			<span  data-toggle="tooltip" title="Create Kegiatan"><a class="btn btn-info btn-sm create_kegiatan" ><i class="fa fa-plus" ></i> Kegiatan</a></span>
		</div>
		<table id="kegiatan_table" class="table table-striped table-hover table-condensed" >
			<thead>
				<tr class="success">
					<th>NO</th>
					<th >LABEL</th>
					<th >TARGET</th>
					<th >ANGGARAN</th>
					<th><i class="fa fa-cog"></i></th>
				</tr>
			</thead>
			
		</table>

	</div>
</div>

@include('admin.modals.renja_kegiatan')

<script type="text/javascript">


function load_kegiatan(ind_program_id){


	$.ajax({
			url			: '{{ url("api_resource/ind_program_detail") }}',
			data 		: {ind_program_id : ind_program_id},
			method		: "GET",
			dataType	: "json",
			success	: function(data) {
					$('.txt_ind_program_label').html(data['label']);
					$('.txt_ind_program_target').html(data['target']+' '+data['satuan']);
					$('.ind_program_id').val(data['id']);
					
			},
			error: function(data){
				
			}						
	});


    $('#kegiatan_table').DataTable({
				destroy			: true,
				processing      : false,
				serverSide      : true,
				searching      	: false,
				paging          : false,
			columnDefs		: [
								{ className: "text-center", targets: [ 0,2,4 ] },
								{ className: "text-right", targets: [ 3 ] }
							  ],
			ajax			: {
								url	: '{{ url("api_resource/skpd-renja_kegiatan_list") }}',
								data: { ind_program_id: ind_program_id ,
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
							{ data: "target_kegiatan", name:"target_kegiatan", orderable: true, searchable: true},
							{ data: "cost_kegiatan", name:"cost_kegiatan", orderable: true, searchable: true},
							
							
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


	$(document).on('click','.create_kegiatan',function(e){
		$('.modal-kegiatan').find('h4').html('Create Kegiatan');
		$('.modal-kegiatan').find('.btn-submit').attr('id', 'submit-save-kegiatan');
		$('.modal-kegiatan').find('[name=text_button_submit]').html('Simpan Data');
		$('.modal-kegiatan').modal('show');
	});

	$(document).on('click','.edit_kegiatan',function(e){
		var kegiatan_id = $(this).data('id') ;
		$.ajax({
				url			: '{{ url("api_resource/kegiatan_detail") }}',
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

		swal({
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
					url		: '{{ url("api_resource/hapus_kegiatan") }}',
					type	: 'POST',
					data    : {kegiatan_id:kegiatan_id},
					cache   : false,
					success:function(data){
							swal({
									title: "",
									text: "Sukses",
									type: "success",
									width: "200px",
									showConfirmButton: false,
									allowOutsideClick : false,
									timer: 900
									}).then(function () {
										$('#kegiatan_table').DataTable().ajax.reload(null,false);
										jQuery('#renja').jstree(true).refresh(true);
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#kegiatan_table').DataTable().ajax.reload(null,false);
											jQuery('#renja').jstree(true).refresh(true);
											
										}
									}
								)
								
							
					},
					error: function(e) {
							swal({
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
