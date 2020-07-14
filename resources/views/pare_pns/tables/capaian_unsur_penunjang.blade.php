<div class="row">
	<div class="col-md-6">
		<div class="box-body table-responsive">
			<div class="toolbar">
				@if ( ( request()->segment(4) == 'edit' )|( request()->segment(4) == 'ralat' ) )  
				<span><a class="btn btn-info btn-sm add_unsur_penunjang_tugas_tambahan" ><i class="fa fa-plus" ></i> Add Tugas Tambahan</a></span>
				@endif
			</div>
			<table id="up_tugas_tambahan_table" class="table table-striped table-hover">
				<thead>
					<tr>
						<th>No</th>
						<th>TUGAS TAMBAHAN</th>
						<th>NILAI</th>
						<th><i class="fa fa-cog"></i></th>
						<th>APPROVED</th>
					</tr>
				</thead>	
			</table>
		</div>
	</div>
	<div class="col-md-6">
		<div class="box-body table-responsive">
			<div class="toolbar">
				@if ( ( request()->segment(4) == 'edit' )|( request()->segment(4) == 'ralat' ) )  
				<span><a class="btn btn-info btn-sm add_unsur_penunjang_kreativitas" ><i class="fa fa-plus" ></i> Add Kreativitas</a></span>
				@endif
			</div>
			<table id="up_kreativitas_table" class="table table-striped table-hover">
				<thead>
					<tr>
						<th>No</th>
						<th>KREATIVITAS</th>
						<th>MANFAAT</th>
						<th>NILAI</th>
						<th><i class="fa fa-cog"></i></th>
						<th>APPROVED</th>
					</tr>
				</thead>	
			</table>
		</div>
	</div> 
</div>



@include('pare_pns.modals.unsur_penunjang_tugas_tambahan')
@include('pare_pns.modals.unsur_penunjang_kreativitas')
<script type="text/javascript">

  	function LoadUnsurPenunajangTugasTambahanTable(){
		var table_up_tugas_tambahan = $('#up_tugas_tambahan_table').DataTable({ 
				destroy			: true,
				processing      : true,
				serverSide      : true,
				searching      	: false,
				paging          : false,
				autoWidth		: false,
				bInfo			: false,
				bSort			: false,
				lengthChange	: false,
				//order 			: [ 1 , 'asc' ],
				//lengthMenu		: [20,45,80],
				columnDefs		: [
									{ className: "text-center", targets: [ 0,2,3,4 ] },
									@if ( ( request()->segment(4) == 'edit' )|( request()->segment(4) == 'ralat' ) )  
										{ visible: true, "targets": [3]},
										{ visible: false,"targets": [2]},
									@else
										{ visible: false, "targets": [3]},
										{ visible: true, "targets": [2]},
									@endif

									@if ( request()->segment(2) == 'capaian_tahunan_bawahan_approvement'  )  
										{ visible: true, "targets": [4]},
									@else
										{ visible: false, "targets": [4]},
									@endif


								  ],
				ajax			: {
									url	: '{{ url("api_resource/unsur_penunjang_tugas_tambahan_list") }}',
									data: { capaian_tahunan_id : {!! $capaian->id !!} },
									quietMillis: 500,

								  },
				columns			: [
									{ data: 'tugas_tambahan_id' ,width:"20px",
										"render": function ( data, type, row ,meta) {
											return meta.row + meta.settings._iDisplayStart + 1 ;
										}
									},
									{ data: "tugas_tambahan_label", name:"tugas_tambahan_label",
										"render": function ( data, type, row ) {
											return row.tugas_tambahan_label;
											
										}
									},
									{ data: "tugas_tambahan_nilai", name:"tugas_tambahan_nilai",
										"render": function ( data, type, row ) {
											return row.tugas_tambahan_nilai;
											
										}
									},
									{  data: 'action',width:"60px",
											"render": function ( data, type, row ) {

											return  '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_unsur_penunjang_tugas_tambahan"  data-id="'+row.tugas_tambahan_id+'"><i class="fa fa-pencil" ></i></a></span>'+
													'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_unsur_penunjang_tugas_tambahan"  data-id="'+row.tugas_tambahan_id+'" data-label="'+row.tugas_tambahan_label+'" ><i class="fa fa-close " ></i></a></span>';
											
										}
									},
									{  data: 'approvement',width:"20px",
											"render": function ( data, type, row ) {
											if ( row.approvement == 1 ){
												return  '<span  data-toggle="tooltip" title="" style="cursor:pointer;" ><a class="fa fa-check-square-o fa-lg reject_unsur_penunjang_tugas_tambahan"  data-id="'+row.tugas_tambahan_id+'"></a></span>';
											}else{
												return  '<span  data-toggle="tooltip" title="" style="cursor:pointer;" ><a class="fa fa-minus-square-o fa-lg approve_unsur_penunjang_tugas_tambahan"  data-id="'+row.tugas_tambahan_id+'"></a></span>';
											}
											
										}
									},
									
								
								],
								initComplete: function(settings, json) {
									
								}		
		});
	}


	function LoadUnsurPenunajangKreativitasTable(){
		var table_up_kreativitas = $('#up_kreativitas_table').DataTable({ 
				destroy			: true,
				processing      : true,
				serverSide      : true,
				searching      	: false,
				paging          : false,
				autoWidth		: false,
				bInfo			: false,
				bSort			: false,
				lengthChange	: false, 
				//order 			: [ 1 , 'asc' ],
				//lengthMenu		: [20,45,80],
				columnDefs		: [
									{ className: "text-center", targets: [ 0,3,4,5 ] },
									@if ( ( request()->segment(4) == 'edit' )|( request()->segment(4) == 'ralat' ) )  
										{ visible: true, "targets": [4]},
										{ visible: false,"targets": [3]},
									@else
										{ visible: false, "targets": [4]},
										{ visible: true, "targets": [3]},
									@endif

									@if ( request()->segment(2) == 'capaian_tahunan_bawahan_approvement'  )  
										{ visible: true, "targets": [5]},
									@else
										{ visible: false, "targets": [5]},
									@endif
								  ],
				ajax			: {
									url	: '{{ url("api_resource/unsur_penunjang_kreativitas_list") }}',
									data: { capaian_tahunan_id : {!! $capaian->id !!} },
									quietMillis: 500,

								  },
				columns			: [
									{ data: 'kreativitas_id' ,width:"20px",
										"render": function ( data, type, row ,meta) {
											return meta.row + meta.settings._iDisplayStart + 1 ;
										}
									},
									{ data: "kreativitas_label", name:"kreativitas_label",
										"render": function ( data, type, row ) {
											
											return row.kreativitas_label;
											
										}
									},
									{ data: "kreativitas_manfaat", name:"kreativitas_manfaat",
										"render": function ( data, type, row ) {
											
											return row.kreativitas_manfaat;
											
										}
									},
									{ data: "kreativitas_nilai", name:"kreativitas_nilai",
										"render": function ( data, type, row ) {
											
											return row.kreativitas_nilai;
											
										}
									},
									{  data: 'action',width:"70px",
											"render": function ( data, type, row ) {

											return  '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_unsur_penunjang_kreativitas"  data-id="'+row.kreativitas_id+'"><i class="fa fa-pencil" ></i></a></span>'+
													'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_unsur_penunjang_kreativitas"  data-id="'+row.kreativitas_id+'" data-label="'+row.kreativitas_label+'" ><i class="fa fa-close " ></i></a></span>';
											
										}
									},
									{  data: 'approvement',width:"20px",
											"render": function ( data, type, row ) {
											if ( row.approvement == 1 ){
												return  '<span  data-toggle="tooltip" title="" style="cursor:pointer;" ><a class="fa fa-check-square-o fa-lg reject_unsur_penunjang_kreativitas"  data-id="'+row.kreativitas_id+'"></a></span>';
											}else{
												return  '<span  data-toggle="tooltip" title="" style="cursor:pointer;" ><a class="fa fa-minus-square-o fa-lg approve_unsur_penunjang_kreativitas"  data-id="'+row.kreativitas_id+'"></a></span>';
											}
											
										}
									},
									
								
								],
								initComplete: function(settings, json) {
								
								}		
		});

	}



	$(document).on('click','.add_unsur_penunjang_tugas_tambahan',function(e){
	
		$('.modal-unsur_penunjang_tugas_tambahan').find('h4').html('Add Unsur Penunjang Tugas Tambahan');
		$('.modal-unsur_penunjang_tugas_tambahan').find('[name=unsur_penunjang_tugas_tambahan_id]').val('');
		$('.modal-unsur_penunjang_tugas_tambahan').find('[name=capaian_tahunan_id]').val({{ $capaian->id }});
		$('.modal-unsur_penunjang_tugas_tambahan').find('.btn-submit_unsur_penunjang_tugas_tambahan').attr('id', 'submit-save_unsur_penunjang_tugas_tambahan');
		$('.modal-unsur_penunjang_tugas_tambahan').find('[name=text_button_submit]').html('Simpan Data');
		
		$('.modal-unsur_penunjang_tugas_tambahan').modal('show'); 
	});

	$(document).on('click','.edit_unsur_penunjang_tugas_tambahan',function(e){
		var tugas_tambahan_id = $(this).data('id') ;
		//alert(tugas_tambahan_id);
		$.ajax({
				url			: '{{ url("api_resource/unsur_penunjang_tugas_tambahan_detail") }}',
				data 		: {tugas_tambahan_id : tugas_tambahan_id},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					$('.modal-unsur_penunjang_tugas_tambahan').find('h4').html('Edit Tugas Tambahan');
					$('.modal-unsur_penunjang_tugas_tambahan').find('[name=unsur_penunjang_tugas_tambahan_id]').val(data['id']);
					$('.modal-unsur_penunjang_tugas_tambahan').find('[name=capaian_tahunan_id]').val(data['capaian_tahunan_id']);

					$('.modal-unsur_penunjang_tugas_tambahan').find('[name=label]').val(data['label']);
					
					$('.modal-unsur_penunjang_tugas_tambahan').find('.btn-submit_unsur_penunjang_tugas_tambahan').attr('id', 'submit-update_unsur_penunjang_tugas_tambahan');
					$('.modal-unsur_penunjang_tugas_tambahan').find('[name=text_button_submit]').html('Update Data');
					$('.modal-unsur_penunjang_tugas_tambahan').modal('show');
				},
				error: function(data){
					
				}						
		});	 
	
	});

	$(document).on('click','.hapus_unsur_penunjang_tugas_tambahan',function(e){
		var tugas_tambahan_id = $(this).data('id') ;
		Swal.fire({
			title: "Hapus Tugas Tambahan",
			text:$(this).data('label'),
			//type: "warning",
			type: "question",
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
					url		: '{{ url("api_resource/hapus_unsur_penunjang_tugas_tambahan") }}',
					type	: 'POST',
					data    : { tugas_tambahan_id:tugas_tambahan_id },
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
										$('#up_tugas_tambahan_table').DataTable().ajax.reload(null,false);
										
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#up_tugas_tambahan_table').DataTable().ajax.reload(null,false);
											
											
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


	$(document).on('click','.approve_unsur_penunjang_tugas_tambahan',function(e){
		var tugas_tambahan_id = $(this).data('id') ;
	
			$.ajax({
					url		: '{{ url("api_resource/approve_unsur_penunjang_tugas_tambahan") }}',
					type	: 'POST',
					data    : { tugas_tambahan_id:tugas_tambahan_id },
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
										$('#up_tugas_tambahan_table').DataTable().ajax.reload(null,false);
										
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#up_tugas_tambahan_table').DataTable().ajax.reload(null,false);
											
											
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
			
	});

	$(document).on('click','.reject_unsur_penunjang_tugas_tambahan',function(e){
		var tugas_tambahan_id = $(this).data('id') ;
	
			$.ajax({
					url		: '{{ url("api_resource/reject_unsur_penunjang_tugas_tambahan") }}',
					type	: 'POST',
					data    : { tugas_tambahan_id:tugas_tambahan_id },
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
										$('#up_tugas_tambahan_table').DataTable().ajax.reload(null,false);
										
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#up_tugas_tambahan_table').DataTable().ajax.reload(null,false);
											
											
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
			
	});

//===================================== kereatipitads ==============================================//

	$(document).on('click','.add_unsur_penunjang_kreativitas',function(e){
	
		$('.modal-unsur_penunjang_kreativitas').find('h4').html('Add Unsur Penunjang Kreativitas');
		$('.modal-unsur_penunjang_kreativitas').find('[name=unsur_penunjang_kreativitas_id]').val('');
		$('.modal-unsur_penunjang_kreativitas').find('[name=capaian_tahunan_id]').val({{ $capaian->id }});
		$('.modal-unsur_penunjang_kreativitas').find('.btn-submit_unsur_penunjang_kreativitas').attr('id', 'submit-save_unsur_penunjang_kreativitas');
		$('.modal-unsur_penunjang_kreativitas').find('[name=text_button_submit]').html('Simpan Data');
		
		$('.modal-unsur_penunjang_kreativitas').modal('show'); 
	});

	$(document).on('click','.edit_unsur_penunjang_kreativitas',function(e){
		var kreativitas_id = $(this).data('id') ;
		//alert(kreativitas_id);
		$.ajax({
				url			: '{{ url("api_resource/unsur_penunjang_kreativitas_detail") }}',
				data 		: {kreativitas_id : kreativitas_id},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					$('.modal-unsur_penunjang_kreativitas').find('h4').html('Edit Kreativitas');
					$('.modal-unsur_penunjang_kreativitas').find('[name=unsur_penunjang_kreativitas_id]').val(data['id']);
					$('.modal-unsur_penunjang_kreativitas').find('[name=capaian_tahunan_id]').val(data['capaian_tahunan_id']);

					$('.modal-unsur_penunjang_kreativitas').find('[name=label]').val(data['label']);
					$('#manfaat').select2('val', data['manfaat_id']);
					
					$('.modal-unsur_penunjang_kreativitas').find('.btn-submit_unsur_penunjang_kreativitas').attr('id', 'submit-update_unsur_penunjang_kreativitas');
					$('.modal-unsur_penunjang_kreativitas').find('[name=text_button_submit]').html('Update Data');
					$('.modal-unsur_penunjang_kreativitas').modal('show');
				},
				error: function(data){
					
				}						
		});	 
	
	});

	$(document).on('click','.hapus_unsur_penunjang_kreativitas',function(e){
		var kreativitas_id = $(this).data('id') ;
		//alert(kreativitas_id);
		
		Swal.fire({
			title: "Hapus Kreativitas",
			text:$(this).data('label'),
			//type: "warning",
			type: "question",
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
					url		: '{{ url("api_resource/hapus_unsur_penunjang_kreativitas") }}',
					type	: 'POST',
					data    : { kreativitas_id:kreativitas_id },
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
										$('#up_kreativitas_table').DataTable().ajax.reload(null,false);
										
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#up_kreativitas_table').DataTable().ajax.reload(null,false);
											
											
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

	$(document).on('click','.approve_unsur_penunjang_kreativitas',function(e){
		var kreativitas_id = $(this).data('id') ;
	
			$.ajax({
					url		: '{{ url("api_resource/approve_unsur_penunjang_kreativitas") }}',
					type	: 'POST',
					data    : { kreativitas_id:kreativitas_id },
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
										$('#up_kreativitas_table').DataTable().ajax.reload(null,false);
										
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#up_kreativitas_table').DataTable().ajax.reload(null,false);
											
											
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
			
	});

	$(document).on('click','.reject_unsur_penunjang_kreativitas',function(e){
		var kreativitas_id = $(this).data('id') ;
	
			$.ajax({
					url		: '{{ url("api_resource/reject_unsur_penunjang_kreativitas") }}',
					type	: 'POST',
					data    : { kreativitas_id:kreativitas_id },
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
										$('#up_kreativitas_table').DataTable().ajax.reload(null,false);
										
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#up_kreativitas_table').DataTable().ajax.reload(null,false);
											
											
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
			
	});
		
	
</script>
