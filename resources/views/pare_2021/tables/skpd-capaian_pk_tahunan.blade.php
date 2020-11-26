<div class="box {{ $h_box }}">
    <div class="box-header with-border">
        <h1 class="box-title">
            Data Capaian PK - Tahunan
        </h1>

        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
            {!! Form::button('<i class="fa fa-times"></i>', array('class' => 'btn btn-box-tool','title' => 'close', 'data-widget' => 'remove', 'data-toggle' => 'tooltip')) !!}
        </div>
	</div>
	<div class="row" style="padding:5px 30px; min-height:200px;">
		<div class="box-body table-responsive">
			<div class="toolbar" hidden>
				
			</div>
			<table id="capaian_pk_tahunan_table" class="table table-striped table-hover">
				<thead>
					<tr class="success">
						<th>NO</th>
						<th>PERIODE PK</th>
						<th>NAMA KEPALA SKPD</th>
						<th>CAPAIAN PK</th>
						<th><i class="fa fa-cog"></i></th> 
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>


@include('pare_pns.modals.create_capaian_pk_tahunan_confirm') 

<script type="text/javascript">
	$('#capaian_pk_tahunan_table').DataTable({
				destroy			: true,
				processing      : true,
				serverSide      : true,
				searching      	: false,
				paging          : false,
				bInfo			: false,
				bSort			: false,
				//order 			: [ 0 , 'desc' ],
				//dom 			: '<"toolbar">frtip',
				lengthMenu		: [50,100],
				columnDefs		: [
									{ 	className: "text-center", targets: [ 0,1,3,4] }/* ,
									//{ 	className: "hidden-xs", targets: [ 5 ] } */
								],
				ajax			: {
									url	: '{{ url("api_resource/skpd_capaian_pk_tahunan_list") }}',
									data: { skpd_id : {!! $skpd_id !!} },
									delay:3000

								},
				 
				rowsGroup		: [1],
				columns			:[
								{ data: 'renja_id' , orderable: true,searchable:false,width:"35px",
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
								
								{ data: "periode" ,  name:"periode", orderable: true, searchable: true,width:"110px",
									"render": function ( data, type, row ) {
										return row.periode;
									}	
								},
								{ data: "nama_kepala_skpd" ,  name:"nama_kepala_skpd", orderable: true, searchable: true,width:"280px",
									"render": function ( data, type, row ) {
										return row.nama_kepala_skpd;
									}	
								},
								{ data: "capaian_pk" ,  name:"capaian_pk", orderable: true, searchable: true,
									"render": function ( data, type, row ) {
										return row.capaian_pk;

									}	
								},
								
								{ data: "capaian_id" , orderable: false,searchable:false,width:"120px",
										"render": function ( data, type, row ) {
										if (row.capaian_pk_tahunan_id >= 1 ){ 


												if (row.capaian_send_to_atasan == 1 ){
													if (row.capaian_status_approve == 2){
														//ditolak
														return  '<span  data-toggle="tooltip" title="Ralat" style="margin:2px;" ><a class="btn btn-warning btn-xs ralat_capaian_pk"  data-id="'+row.capaian_pk_tahunan_id+'"><i class="fa fa-pencil" ></i></a></span>'+
																'<span  data-toggle="tooltip" title="lihat" style="margin:2px;" ><a class="btn btn-info btn-xs lihat_capaian_pk"  data-id="'+row.capaian_pk_tahunan_id+'"><i class="fa fa-eye" ></i></a></span>'+
																'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-default btn-xs"><i class="fa fa-close " ></i></a></span>';
													}else{
														//diterima
														return  '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-default btn-xs "><i class="fa fa-pencil" ></i></a></span>'+
																'<span  data-toggle="tooltip" title="lihat" style="margin:2px;" ><a class="btn btn-info btn-xs lihat_capaian_pk"  data-id="'+row.capaian_pk_tahunan_id+'"><i class="fa fa-eye" ></i></a></span>'+
																'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-default btn-xs"><i class="fa fa-close " ></i></a></span>';
													}
												}else{
													//blm dikirim
													return  	'<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_capaian_pk" data-id="'+row.capaian_pk_tahunan_id+'"><i class="fa fa-pencil" ></i></a></span>'+
																'<span  data-toggle="tooltip" title="lihat" style="margin:2px;" ><a class="btn btn-default btn-xs "><i class="fa fa-eye" ></i></a></span>'+
																'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_capaian_pk" data-id="'+row.capaian_pk_tahunan_id+'"><i class="fa fa-close " ></i></a></span>';
												}
											}else{
												return  '<span style="margin:1px;" ><a class="btn btn-warning btn-xs create_capaian_pk_tahunan"  data-renja_id="'+row.renja_id+'" style="width:75px;">Capaian</a></span>';
											}

									}
								},
								
							]
			
	});


	$(document).on('click','.edit_capaian_pk',function(e){
		var capaian_id = $(this).data('id') ;
		window.location.assign("capaian_pk-tahunan/"+capaian_id+"/edit");
	});

	$(document).on('click','.ralat_capaian_pk',function(e){
		var capaian_id = $(this).data('id') ;
		window.location.assign("capaian_pk-tahunan/"+capaian_id+"/ralat");
	});

	$(document).on('click','.lihat_capaian_pk',function(e){
		var capaian_id = $(this).data('id') ;
		window.location.assign("capaian_pk-tahunan/"+capaian_id);
	});
	
	

	$(document).on('click','.create_capaian_pk_tahunan',function(e){
		var renja_id = $(this).data('renja_id') ;
		show_loader();
		$.ajax({
			url		: '{{ url("api_resource/capaian_pk_tahunan_create_confirm") }}',
			type	: 'GET',
			data	:  	{ 
							renja_id : renja_id
						},
			success	: function(data) {

					if ( data == 0 ){
						modal_create_capaian_pk_tahunan(renja_id);
					}else{
						
						swal.close();
						alert("Fungsi Belum Tersedia");
					}

			},
			error: function(jqXHR , textStatus, errorThrown) {
					swal.close();
					Swal.fire({
						title: 'Error!',
						text: 'Capaian Tahunan PK  belum bisa dibuat',
						type: 'error',
						confirmButtonText: 'Tutup'
					})
			}
			
		});
		
	});

	function modal_create_capaian_pk_tahunan(renja_id){
		$.ajax({
				url			: '{{ url("api_resource/renja_detail") }}',
				data 		: { renja_id:renja_id },
				method		: "GET",
				dataType	: "json",
				success	: function(data) {

					$('.modal-create_capaian_pk_tahunan').find('[name=periode_renja]').html(data['periode']);
					$('.modal-create_capaian_pk_tahunan').find('[name=nama_kepala_skpd]').html(data['nama_kepala_skpd']);

					$('.modal-create_capaian_pk_tahunan').find('[name=renja_id]').val(renja_id);

					$('.modal-create_capaian_pk_tahunan').find('.btn-submit').attr('id', 'submit-save_capaian_pk_tahunan');
					$('.modal-create_capaian_pk_tahunan').modal('show');
				},
				error: function(data){
					
				}						
		});	  
	}


	$(document).on('click','.hapus_capaian_pk',function(e){
		var capaian_pk_id = $(this).data('id') ;

		Swal.fire({
			title: "Hapus  Capaian PK",
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
					url		: '{{ url("api_resource/hapus_capaian_pk") }}',
					type	: 'POST',
					data    : { capaian_pk_id:capaian_pk_id },
					cache   : false,
					success:function(data){
							$('.personal_jm_capaian_pk').html(data['jm_capaian_pk']);
							$('.personal_jm_capaian_bulanan').html(data['jm_capaian_bulanan']);
							$('.personal_jm_capaian_triwulan').html(data['jm_capaian_triwulan']);
							Swal.fire({
									title: "",
									text: "Sukses",
									type: "success",
									width: "200px",
									showConfirmButton: false,
									allowOutsideClick : false,
									timer: 900
									}).then(function () {
										$('#capaian_pk_table').DataTable().ajax.reload(null,false);
										
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#capaian_pk_table').DataTable().ajax.reload(null,false);
											
											
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
