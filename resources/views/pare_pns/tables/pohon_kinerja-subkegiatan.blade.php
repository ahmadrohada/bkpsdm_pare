
<div class="box box-maroon div_subkegiatan" hidden>
    <div class="box-header with-border">
		{{-- <h1 class="box-title">
            List Kegiatan
        </h1> --}}
		&nbsp;
		<div class="box-tools pull-right">
			{!! Form::button('<i class="fa  fa-level-up"></i>', array('class' => 'btn btn-box-tool tutup_detail','title' => 'Tujuan List', 'data-toggle' => 'tooltip')) !!}
		</div>
	</div>
	<div class="box-body table-responsive">
		<strong>Sub Kegiatan :</strong>
		<p class="text-muted " style="font-size:11pt;">
			<span class="txt_subkegiatan_label"></span>
		</p>
		<strong>Cost</strong>
		<p class="text-muted " style="font-size:12pt;">
			<span class="cost"></span>
		</p>

		<div class="toolbar pull-right">
			<span  data-toggle="tooltip" title="Create Indikator Sub Kegiatan"><a class="btn btn-info btn-xs create_ind_subkegiatan" ><i class="fa fa-plus" ></i> Indikator</a></span>
		</div>
		<table id="ind_subkegiatan_table" class="table table-striped table-hover table-condensed" >
			<thead>
				<tr class="success">
					<th>NO</th>
					<th >INDIKATOR SUB KEGIATAN</th>
					<th >TARGET</th>
					<th>ACTION</th>
				</tr>
			</thead>
		</table>
	</div>
</div>

@include('pare_pns.modals.renja_ind_subkegiatan')


<script type="text/javascript">
	function load_subkegiatan(subkegiatan_id){
		$.ajax({
				url			: '{{ url("api/subkegiatan_detail") }}',
				data 		: {subkegiatan_id : subkegiatan_id},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
						$('.txt_subkegiatan_label').html(data['label']);
						$('.cost').html("Rp. "+ data['cost']);
						$('.subkegiatan_id').val(data['subkegiatan_id']);
						
				},
				error: function(data){
					
				}						
		});

		$('#ind_subkegiatan_table').DataTable({
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
										url	: '{{ url("api/skpd-renja_ind_subkegiatan_list") }}',
										data: { subkegiatan_id: subkegiatan_id },
									}, 
					columns			:[
									{ data: 'ind_subkegiatan_id' , orderable: true,searchable:false,width:"30px",
											"render": function ( data, type, row ,meta) {
												return meta.row + meta.settings._iDisplayStart + 1 ;
											}
										},
									{ data: "label_ind_subkegiatan", name:"label_ind_subkegiatan", orderable: true, searchable: true},
									{ data: "target_ind_subkegiatan", name:"target_ind_subkegiatan", orderable: true, searchable: true, width:"90px"},
									{  data: 'action',width:"60px",
											"render": function ( data, type, row ) {
												return  '<span  data-toggle="tooltip" title="Edit" style="margin:1px;" ><a class="btn btn-success btn-xs edit_ind_subkegiatan"  data-id="'+row.ind_subkegiatan_id+'"><i class="fa fa-pencil" ></i></a></span>'+
														'<span  data-toggle="tooltip" title="Hapus" style="margin:1px;" ><a class="btn btn-danger btn-xs hapus_ind_subkegiatan"  data-id="'+row.ind_subkegiatan_id+'" data-label="'+row.label_ind_subkegiatan+'" ><i class="fa fa-close " ></i></a></span>';
													
											}
									},
								],
								initComplete: function(settings, json) {
									
									}
			
			
		});	
	}


	$(document).on('click','.create_ind_subkegiatan',function(e){
		$('.modal-ind_subkegiatan').find('h4').html('Create Indikator Sub kegiatan');
		$('.modal-ind_subkegiatan').find('.btn-submit').attr('id', 'submit-save-ind_subkegiatan');
		$('.modal-ind_subkegiatan').find('[name=text_button_submit]').html('Simpan Data');
		$('.modal-ind_subkegiatan').modal('show');
	});

	$(document).on('click','.edit_ind_subkegiatan',function(e){
		var ind_subkegiatan_id = $(this).data('id') ;
		//alert(ind_subkegiatan_id);
	    $.ajax({
				url			: '{{ url("api/ind_subkegiatan_detail") }}',
				data 		:  {ind_subkegiatan_id : ind_subkegiatan_id},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					$('.modal-ind_subkegiatan').find('[name=label_ind_subkegiatan]').val(data['label']);
					$('.modal-ind_subkegiatan').find('[name=target_ind_subkegiatan]').val(data['target']);
					$('.modal-ind_subkegiatan').find('[name=satuan_ind_subkegiatan]').val(data['satuan']);

					$('.modal-ind_subkegiatan').find('[name=ind_subkegiatan_id]').val(data['ind-subkegiatan_id']);
					$('.modal-ind_subkegiatan').find('h4').html('Edit Indikator Sub xKegiatan');
					$('.modal-ind_subkegiatan').find('.btn-submit').attr('id', 'submit-update-ind_subkegiatan');
					$('.modal-ind_subkegiatan').find('[name=text_button_submit]').html('Update Data');
					$('.modal-ind_subkegiatan').modal('show');
				},
				error: function(data){
					
				}						
		});	 
	});

	$(document).on('click','.hapus_ind_subkegiatan',function(e){
		var ind_subkegiatan_id = $(this).data('id') ;
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
					url		: '{{ url("api/hapus_ind_subkegiatan") }}',
					type	: 'POST',
					data    : {ind_subkegiatan_id:ind_subkegiatan_id},
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
										$('#ind_subkegiatan_table').DataTable().ajax.reload(null,false);
										//jQuery('#renja_tree_kegiatan').jstree(true).refresh(true);
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#ind_subkegiatan_table').DataTable().ajax.reload(null,false);
											//jQuery('#renja_tree_kegiatan').jstree(true).refresh(true);
											
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
