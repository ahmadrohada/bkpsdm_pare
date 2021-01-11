<div class="box box-tujuan div_tujuan" hidden>
	<div class="box-header with-border">
		{{-- <h1 class="box-title">
			Tujuan
		</h1> --}}
		&nbsp;
		<div class="box-tools pull-right">
			{!! Form::button('<i class="fa  fa-level-up"></i>', array('class' => 'btn btn-box-tool tutup_detail','title' => 'Tujuan List', 'data-toggle' => 'tooltip')) !!}
		</div>
	</div>
	<div class="box-body table-responsive">
		<label>Tujuan : </label>
		<p class="text-muted" style="font-size:11pt;">
			<span class="txt_label_tujuan"></span>
		</p>
		<div class="toolbar pull-right">
			<span  data-toggle="tooltip" title="Create Indikator Tujuan"><a class="btn btn-info btn-xs create_ind_tujuan" ><i class="fa fa-plus" ></i> Indikator</a></span>
		</div>
		<table id="ind_tujuan_table" class="table table-striped table-hover table-condensed" >
			<thead>
				<tr class="success">
					<th>NO</th>
					<th >INDIKATOR TUJUAN</th>
					<th >TARGET</th>
					<th><i class="fa fa-cog"></i></th>
				</tr>
			</thead>
			
		</table>		
	</div>
	<div class="box-body table-responsive">
		<div class="toolbar pull-right">
			<span  data-toggle="tooltip" title="Create Sasaran"><a class="btn btn-info btn-xs create_sasaran" ><i class="fa fa-plus" ></i> Sasaran</a></span>
		</div>
		<table id="sasaran_table" class="table table-striped table-hover table-condensed" >
			<thead>
				<tr class="success">
					<th>NO</th>
					<th >SASARAN</th>
					<th><i class="fa fa-cog"></i></th>
				</tr>
			</thead>
		</table>
	 </div>
</div>


@include('pare_pns.modals.renja_ind_tujuan')
@include('pare_pns.modals.renja_sasaran')

<script type="text/javascript">


function load_tujuan(tujuan_id){

	$.ajax({
			url			: '{{ url("api/tujuan_detail") }}',
			data 		: {tujuan_id : tujuan_id},
			method		: "GET",
			dataType	: "json",
			success	: function(data) {
					$('.txt_label_tujuan').html(data['label']);
					$('.tujuan_id').val(data['id']);
					
			},
			error: function(data){
				
			}						
	});
	

    $('#ind_tujuan_table').DataTable({
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
								url	: '{{ url("api/skpd-renja_ind_tujuan_list") }}',
								data: { tujuan_id: tujuan_id },
							 }, 
			columns			:[
							{ data: 'ind_tujuan_id' , orderable: true,searchable:false,width:"30px",
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
							{ data: "label_ind_tujuan", name:"label_ind_tujuan", orderable: true, searchable: true},
							{ data: "target_ind_tujuan", name:"target_ind_tujuan", orderable: true, searchable: true , width:"90px"},
							{  data: 'action',width:"60px",
									"render": function ( data, type, row ) {
										return  '<span  data-toggle="tooltip" title="Edit" style="margin:1px;" ><a class="btn btn-success btn-xs edit_ind_tujuan"  data-id="'+row.ind_tujuan_id+'"><i class="fa fa-pencil" ></i></a></span>'+
												'<span  data-toggle="tooltip" title="Hapus" style="margin:1px;" ><a class="btn btn-danger btn-xs hapus_ind_tujuan"  data-id="'+row.ind_tujuan_id+'" data-label="'+row.label_ind_tujuan+'" ><i class="fa fa-close " ></i></a></span>';
											
									}
							},
						],
						initComplete: function(settings, json) {
							
   				 		}
		
		});	

		$('#sasaran_table').DataTable({
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







	

	$(document).on('click','.create_ind_tujuan',function(e){
		$('.modal-ind_tujuan').find('h4').html('Create Indikator Tujuan');
		$('.modal-ind_tujuan').find('.btn-submit').attr('id', 'submit-save-ind_tujuan');
		$('.modal-ind_tujuan').find('[name=text_button_submit]').html('Simpan Data');
		$('.modal-ind_tujuan').modal('show');
	});

	$(document).on('click','.edit_ind_tujuan',function(e){
		var ind_tujuan_id = $(this).data('id') ;
		$.ajax({
				url			: '{{ url("api/ind_tujuan_detail") }}',
				data 		: {ind_tujuan_id : ind_tujuan_id},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					$('.modal-ind_tujuan').find('[name=label_ind_tujuan]').val(data['label']);
					$('.modal-ind_tujuan').find('[name=target_ind_tujuan]').val(data['target']);
					$('.modal-ind_tujuan').find('[name=satuan_ind_tujuan]').val(data['satuan']);
					
					$('.modal-ind_tujuan').find('[name=ind_tujuan_id]').val(data['id']);
					$('.modal-ind_tujuan').find('h4').html('Edit Indikator Tujuan');
					$('.modal-ind_tujuan').find('.btn-submit').attr('id', 'submit-update-ind_tujuan');
					$('.modal-ind_tujuan').find('[name=text_button_submit]').html('Update Data');
					$('.modal-ind_tujuan').modal('show');
				},
				error: function(data){
					
				}						
		});	
	});

	$(document).on('click','.hapus_ind_tujuan',function(e){
		var ind_tujuan_id = $(this).data('id') ;
		//alert(tujuan_id);

		Swal.fire({
			title: "Hapus  Indikator Tujuan",
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
					url		: '{{ url("api/hapus_ind_tujuan") }}',
					type	: 'POST',
					data    : {ind_tujuan_id:ind_tujuan_id},
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
										$('#ind_tujuan_table').DataTable().ajax.reload(null,false);
										jQuery('#renja_tree_kegiatan').jstree(true).refresh(true);
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#ind_tujuan_table').DataTable().ajax.reload(null,false);
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

	$(document).on('click','.create_sasaran',function(e){
		$('.modal-sasaran').find('h4').html('Create Sasaran');
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
