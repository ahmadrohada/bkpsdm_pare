<div class="box box-kegiatan div_kegiatan_detail" hidden>
	<div class="box-header with-border">
		<h1 class="box-title">
			Detail Sub Kegiatan
		</h1>

		<div class="box-tools pull-right">
			{!! Form::button('<i class="fa fa-remove "></i>', array('class' => 'btn btn-box-tool tutup_detail','title' => 'Tutup', 'data-toggle' => 'tooltip')) !!}
		</div>
	</div>
	<div class="box-body table-responsive">

		<strong>Sub Kegiatan</strong>
		<p class="text-muted " style="margin-top:8px;padding-bottom:10px;">
			<span class="txt_kegiatan_label"></span>
		</p>
		<strong>Anggaran</strong>
		<p class="text-muted " style="margin-top:8px;padding-bottom:10px;">
			<span class="cost"></span>
		</p>
		<span class="text-danger">* Setiap Sub Kegiatan wajib memiliki minimal satu Indikator Kegiatan</span>
					
	</div>
	
</div>
<div class="box box-indikator_kegiatan div_ind_kegiatan_list" hidden>
    <div class="box-header with-border">
		<h1 class="box-title">
            List Indikator Sub Kegiatan
        </h1>

        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
        </div>
    </div>



	<div class="box-body table-responsive">

		<div class="toolbar">
			
			<span  data-toggle="tooltip" title="Create Indikator Sub Kegiatan"><a class="btn btn-info btn-sm create_ind_kegiatan" ><i class="fa fa-plus" ></i> Indikator Sub Kegiatan</a></span>
			
		
		</div>
		<table id="ind_kegiatan_table" class="table table-striped table-hover table-condensed" >
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


@include('pare_2021.modals.renja_ind_kegiatan')


<script type="text/javascript">

    
function load_ind_kegiatan(kegiatan_id){


$.ajax({
		url			: '{{ url("api_resource/kegiatan_detail") }}',
		data 		: {kegiatan_id : kegiatan_id},
		method		: "GET",
		dataType	: "json",
		success	: function(data) {
				$('.txt_kegiatan_label').html(data['label']);
				$('.cost').html("Rp. "+ data['cost']);
				$('.kegiatan_id').val(data['kegiatan_id']);
				
		},
		error: function(data){
			
		}						
});


$('#ind_kegiatan_table').DataTable({
			destroy			: true,
			processing      : false,
			serverSide      : true,
			searching      	: false,
			paging          : false,
			columnDefs		: [
								{ className: "text-center", targets: [ 0,2,3 ] }
							],
			ajax			: {
								url	: '{{ url("api_resource/skpd-renja_ind_kegiatan_list") }}',
								data: { kegiatan_id: kegiatan_id },
							}, 
			columns			:[
							{ data: 'ind_kegiatan_id' , orderable: true,searchable:false,width:"30px",
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
							{ data: "label_ind_kegiatan", name:"label_ind_kegiatan", orderable: true, searchable: true},
							{ data: "target_ind_kegiatan", name:"target_ind_kegiatan", orderable: true, searchable: true, width:"90px"},
							{  data: 'action',width:"60px",
									"render": function ( data, type, row ) {
										return  '<span  data-toggle="tooltip" title="Edit" style="margin:1px;" ><a class="btn btn-success btn-xs edit_ind_kegiatan"  data-id="'+row.ind_kegiatan_id+'"><i class="fa fa-pencil" ></i></a></span>'+
												'<span  data-toggle="tooltip" title="Hapus" style="margin:1px;" ><a class="btn btn-danger btn-xs hapus_ind_kegiatan"  data-id="'+row.ind_kegiatan_id+'" data-label="'+row.label_ind_kegiatan+'" ><i class="fa fa-close " ></i></a></span>';
											
									}
							},
						],
						initComplete: function(settings, json) {
							
							}
	
	
});	


}


$(document).on('click','.create_ind_kegiatan',function(e){
		$('.modal-ind_kegiatan').find('h4').html('Create Indikator Sub Kegiatan');
		$('.modal-ind_kegiatan').find('.btn-submit').attr('id', 'submit-save-ind_kegiatan');
		$('.modal-ind_kegiatan').find('[name=text_button_submit]').html('Simpan Data');
		$('.modal-ind_kegiatan').modal('show');
	});

	$(document).on('click','.edit_ind_kegiatan',function(e){
		var ind_kegiatan_id = $(this).data('id') ;
		//alert(ind_kegiatan_id);
	    $.ajax({
				url			: '{{ url("api_resource/ind_kegiatan_detail") }}',
				data 		:  {ind_kegiatan_id : ind_kegiatan_id},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					$('.modal-ind_kegiatan').find('[name=label_ind_kegiatan]').val(data['label']);
					$('.modal-ind_kegiatan').find('[name=target_ind_kegiatan]').val(data['target']);
					$('.modal-ind_kegiatan').find('[name=satuan_ind_kegiatan]').val(data['satuan']);

					$('.modal-ind_kegiatan').find('[name=ind_kegiatan_id]').val(data['id']);
					$('.modal-ind_kegiatan').find('h4').html('Edit Indikator Sub Kegiatan');
					$('.modal-ind_kegiatan').find('.btn-submit').attr('id', 'submit-update-ind_kegiatan');
					$('.modal-ind_kegiatan').find('[name=text_button_submit]').html('Update Data');
					$('.modal-ind_kegiatan').modal('show');
				},
				error: function(data){
					
				}						
		});	 
	});

	$(document).on('click','.hapus_ind_kegiatan',function(e){
		var ind_kegiatan_id = $(this).data('id') ;
		//alert(kegiatan_id);

		Swal.fire({
			title: "Hapus  Indikator Sub Kegiatan",
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
					url		: '{{ url("api_resource/hapus_ind_kegiatan") }}',
					type	: 'POST',
					data    : {ind_kegiatan_id:ind_kegiatan_id},
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
										$('#ind_kegiatan_table').DataTable().ajax.reload(null,false);
										jQuery('#renja_tree_kegiatan').jstree(true).refresh(true);
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#ind_kegiatan_table').DataTable().ajax.reload(null,false);
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
