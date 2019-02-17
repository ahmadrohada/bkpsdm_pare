<div class="box box-primary div_sasaran_detail" hidden>
	<div class="box-header with-border">
		<h1 class="box-title">
			Detail Sasaran
		</h1>

		<div class="box-tools pull-right">
			{!! Form::button('<i class="fa fa-remove "></i>', array('class' => 'btn btn-box-tool tutup_detail','title' => 'Tutup', 'data-toggle' => 'tooltip')) !!}
		</div>
	</div>
	<div class="box-body table-responsive">

		<strong>Sasaran</strong>
		<p class="text-muted " style="margin-top:8px;padding-bottom:10px;">
			<span class="txt_sasaran_label"></span>
		</p>

		

		<!-- <i class="fa  fa-gg"></i> <span class="txt_ak" style="margin-right:10px;"></span>
		<i class="fa fa-industry"></i> <span class="txt_output" style="margin-right:10px;"></span>
		<i class="fa fa-hourglass-start"></i> <span class="txt_waktu" style="margin-right:10px;"></span>
		<i class="fa fa-money"></i> <span class="txt_cost" style="margin-right:10px;"></span> -->
					
	</div>
</div>
<div class="box box-primary div_ind_sasaran_list" hidden>
    <div class="box-header with-border">
		<h1 class="box-title">
            List Indikator Sasaran
        </h1>

        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
        </div>
    </div>



	<div class="box-body table-responsive">

		<div class="toolbar">
			
			<span  data-toggle="tooltip" title="Create Indikator Sasaran"><a class="btn btn-info btn-sm create_ind_sasaran" ><i class="fa fa-plus" ></i> Indikator Sasaran</a></span>
		
		</div>
		<table id="ind_sasaran_table" class="table table-striped table-hover table-condensed" >
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

@include('admin.modals.renja_ind_sasaran')

<script type="text/javascript">

    
function load_ind_sasaran(sasaran_id){


$.ajax({
		url			: '{{ url("api_resource/sasaran_detail") }}',
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
			columnDefs		: [
								{ className: "text-center", targets: [ 0,2,3 ] }
							],
			ajax			: {
								url	: '{{ url("api_resource/skpd-renja_ind_sasaran_list") }}',
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
				url			: '{{ url("api_resource/ind_sasaran_detail") }}',
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
					url		: '{{ url("api_resource/hapus_ind_sasaran") }}',
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
										jQuery('#renja').jstree(true).refresh(true);
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#ind_sasaran_table').DataTable().ajax.reload(null,false);
											jQuery('#renja').jstree(true).refresh(true);
											
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
