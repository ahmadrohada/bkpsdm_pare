<div class="row">
	<div class="col-md-6">
		<div class="box box-primary" id='tugas_tambahan'>
			<div class="box-header with-border">
				<h1 class="box-title">
					Tugas Tambahan
				</h1>
				<div class="box-tools pull-right"></div>
			</div>
			<div class="box-body table-responsive">
				<div class="toolbar">
					<span><a class="btn btn-info btn-sm add_tugas_tambahan" ><i class="fa fa-plus" ></i> Add Tugas Tambahan</a></span>
				</div>
				<table id="tugas_tambahan_table" class="table table-striped table-hover" style="%">
					<thead>
						<tr>
							<th>No</th>
							<th>LABEL</th>
							<th>NILAI</th>
							<th><i class="fa fa-cog"></i></th>
						</tr>
					</thead>	
				</table>
			</div>
		</div>
	</div>

	<div class="col-md-6">
		<div class="box box-primary" id='kreativitas'>
			<div class="box-header with-border">
				<h1 class="box-title">
					Kreativitas
				</h1>
				<div class="box-tools pull-right"></div>
			</div>
			<div class="box-body table-responsive">
				<div class="toolbar">
					<span><a class="btn btn-info btn-sm add_kreativitas" ><i class="fa fa-plus" ></i> Add Kreativitas</a></span>
				</div>
				<table id="kreativitas_table" class="table table-striped table-hover" style="%">
					<thead>
						<tr>
							<th>No</th>
							<th>LABEL</th>
							<th>MANFAAT</th>
							<th>NILAI</th>
							<th><i class="fa fa-cog"></i></th>
						</tr>
					</thead>	
				</table>
			</div>
		</div>
	</div>

	
</div>

@include('pare_pns.modals.tugas_tambahan')
<script type="text/javascript">

  	function load_tugas_tambahan(){
		var table_tugas_tambahan = $('#tugas_tambahan_table').DataTable({ 
				destroy			: true,
				processing      : false,
				serverSide      : true,
				searching      	: false,
				paging          : false,
				bInfo			: false,
				//targets			: 'no-sort',
				bSort			: false,
				columnDefs		: [
									{ className: "text-center", targets: [ 0,2,3 ] },
									{ className: "hide", targets: [  ] },
								  ],
				ajax			: {
									url	: '{{ url("api_resource/tugas_tambahan_list") }}',
									data: { capaian_tahunan_id : {!! $capaian->id !!} },
								  },
				columns			: [
									{ data: 'tugas_tambahan_id' ,width:"30px",
										"render": function ( data, type, row ,meta) {
											return meta.row + meta.settings._iDisplayStart + 1 ;
									}
									},
									{ data: "tugas_tambahan_label", name:"tugas_tambahan_label",
										"render": function ( data, type, row ) {
											return row.tugas_tambahan_label;
											
										}
									},
									{ data: "tugas_tambahan_nilai", name:"tugas_tambahan_nilai",width:"70px",visible:false,
										"render": function ( data, type, row ) {
											return row.tugas_tambahan_nilai;
											
										}
									},
									{  data: 'action',width:"60px",
											"render": function ( data, type, row ) {

											return  '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_tugas_tambahan"  data-id="'+row.tugas_tambahan_id+'"><i class="fa fa-pencil" ></i></a></span>'+
													'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_tugas_tambahan"  data-id="'+row.tugas_tambahan_id+'" data-label="'+row.tugas_tambahan_label+'" ><i class="fa fa-close " ></i></a></span>';
											
										}
									},
									
								
								],
								initComplete: function(settings, json) {
								
								}		
		});
	}


	function load_kreativitas(){
		var table_kreativitas = $('#kreativitas_table').DataTable({ 
				destroy			: true,
				processing      : false,
				serverSide      : true,
				searching      	: false,
				paging          : false,
				bInfo			: false,
				//targets		: 'no-sort',
				bSort			: false,
				columnDefs		: [
									{ className: "text-center", targets: [ 0,3,4 ] },
									{ className: "hide", targets: [  ] },
								  ],
				ajax			: {
									url	: '{{ url("api_resource/kreativitas_list") }}',
									data: { capaian_tahunan_id : {!! $capaian->id !!} },
								  },
				columns			: [
									{ data: 'kreativitas_id' ,width:"30px",
										"render": function ( data, type, row ,meta) {
											return meta.row + meta.settings._iDisplayStart + 1 ;
									}
									},
									{ data: "kreativitas_label", name:"kreativitas_label",
										"render": function ( data, type, row ) {
											
											return row.kreativitas_label;
											
										}
									},
									{ data: "kreativitas_manfaat", name:"kreativitas_manfaat",width:"140px",
										"render": function ( data, type, row ) {
											
											return row.kreativitas_manfaat;
											
										}
									},
									{ data: "kreativitas_nilai", name:"kreativitas_nilai",width:"70px",visible:false,
										"render": function ( data, type, row ) {
											
											return row.kreativitas_nilai;
											
										}
									},
									{  data: 'action',width:"70px",
											"render": function ( data, type, row ) {

											return  '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_kreativitas"  data-id="'+row.kreativitas_id+'"><i class="fa fa-pencil" ></i></a></span>'+
													'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_kreativitas"  data-id="'+row.kreativitas_id+'" data-label="'+row.kreativitas_label+'" ><i class="fa fa-close " ></i></a></span>';
											
										}
									},
									
								
								],
								initComplete: function(settings, json) {
								
								}		
		});

	}



	$(document).on('click','.add_tugas_tambahan',function(e){
	
		$('.modal-tugas_tambahan').find('h4').html('Add Tugas Tambahan');
		$('.modal-tugas_tambahan').find('.btn-submit_tugas_tambahan').attr('id', 'submit-save_tugas_tambahan');
		$('.modal-tugas_tambahan').find('[name=text_button_submit]').html('Simpan Data f');
		
		$('.modal-tugas_tambahan').modal('show');  
	});

	$(document).on('click','.hapus_tugas_tambahan',function(e){
		var tugas_tambahan_id = $(this).data('id') ;
		Swal.fire({
			title: "Hapus  Tugas Tambahan",
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
					url		: '{{ url("api_resource/hapus_tugas_tambahan") }}',
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
										$('#tugas_tambahan_table').DataTable().ajax.reload(null,false);
										
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#tugas_tambahan_table').DataTable().ajax.reload(null,false);
											
											
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


	$(document).on('click','.add_kreativitas',function(e){
	
		$('.modal-kreativitas').find('h4').html('Add Realisasi Kegiatan Tahunan');
		$('.modal-kreativitas').find('.btn-submit').attr('id', 'submit-save_kreativitas');
		$('.modal-kreativitas').find('[name=text_button_submit]').html('Simpan Data');
		
		$('.modal-kreativitas').modal('show');  
	});




		
	
</script>
