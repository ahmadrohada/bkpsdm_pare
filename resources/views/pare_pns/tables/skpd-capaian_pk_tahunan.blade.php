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
	<div class="row" style="padding:5px 30px; min-height:200px;">
</div>


@include('pare_pns.modals.create_capaian_tahunan_confirm')

<script type="text/javascript">
	$('#capaian_pk_tahunan_table').DataTable({
				destroy			: true,
				processing      : true,
				serverSide      : true,
				searching      	: true,
				paging          : true,
				autoWidth		: false,
				bInfo			: false,
				bSort			: false,
				lengthChange	: true,
				//order 			: [ 1 , 'asc' ],
				lengthMenu		: [20,45,80],
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
										if (row.capaian_id >= 1 ){ 


												if (row.capaian_send_to_atasan == 1 ){
													if (row.capaian_status_approve == 2){
														//ditolak
														return  '<span  data-toggle="tooltip" title="Ralat" style="margin:2px;" ><a class="btn btn-warning btn-xs ralat_capaian_pk"  data-id="'+row.capaian_id+'"><i class="fa fa-pencil" ></i></a></span>'+
																'<span  data-toggle="tooltip" title="lihat" style="margin:2px;" ><a class="btn btn-info btn-xs lihat_capaian_pk"  data-id="'+row.capaian_id+'"><i class="fa fa-eye" ></i></a></span>'+
																'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-default btn-xs"><i class="fa fa-close " ></i></a></span>';
													}else{
														//diterima
														return  '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-default btn-xs "><i class="fa fa-pencil" ></i></a></span>'+
																'<span  data-toggle="tooltip" title="lihat" style="margin:2px;" ><a class="btn btn-info btn-xs lihat_capaian_pk"  data-id="'+row.capaian_id+'"><i class="fa fa-eye" ></i></a></span>'+
																'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-default btn-xs"><i class="fa fa-close " ></i></a></span>';
													}
												}else{
													//blm dikirim
													return  	'<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_capaian_pk" data-id="'+row.capaian_id+'"><i class="fa fa-pencil" ></i></a></span>'+
																'<span  data-toggle="tooltip" title="lihat" style="margin:2px;" ><a class="btn btn-default btn-xs "><i class="fa fa-eye" ></i></a></span>'+
																'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_capaian_pk" data-id="'+row.capaian_id+'"><i class="fa fa-close " ></i></a></span>';
												}
											}else{
												return  '<span style="margin:1px;" ><a class="btn btn-warning btn-xs create_capaian_pk"  data-skp_tahunan_id="'+row.skp_tahunan_id+'" style="width:75px;">Capaian</a></span>';
											}

									}
								},
								
							]
			
	});


	$(document).on('click','.edit_capaian_pk',function(e){
		var capaian_id = $(this).data('id') ;
		window.location.assign("capaian-tahunan/"+capaian_id+"/edit");
	});

	$(document).on('click','.ralat_capaian_pk',function(e){
		var capaian_id = $(this).data('id') ;
		window.location.assign("capaian-tahunan/"+capaian_id+"/ralat");
	});

	$(document).on('click','.lihat_capaian_pk',function(e){
		var capaian_id = $(this).data('id') ;
		window.location.assign("capaian-tahunan/"+capaian_id);
	});
	
	

	$(document).on('click','.create_capaian_pk',function(e){
		var skp_tahunan_id = $(this).data('skp_tahunan_id') ;
		$.ajax({
			url		: '{{ url("api_resource/create_capaian_pk_confirm") }}',
			type	: 'GET',
			data	:  	{ 
							skp_tahunan_id : skp_tahunan_id
						},
			success	: function(data) {

					$('.periode_label').html(data['periode_label']); 
					$('.masa_penilaian_skp_tahunan').html(data['masa_penilaian']); 
					$('.jm_kegiatan').val(data['jm_kegiatan']); 


					$('.cap_tgl_mulai').val(data['cap_tgl_mulai']); 
					$('.cap_tgl_selesai').val(data['cap_tgl_selesai']); 
				
						
					$('#u_nip').html(data['u_nip']); 
					$('#u_nama').html(data['u_nama']); 
					$('#u_golongan').html(data['u_pangkat']+' / '+data['u_golongan']); 
					$('#u_eselon').html(data['u_eselon']); 
					$('#u_jabatan').html(data['u_jabatan']); 
					$('#u_unit_kerja').html(data['u_unit_kerja']); 
					$('#txt_u_jabatan').html(data['u_jabatan']); 
					$('#txt_u_skpd').html(data['u_skpd']); 


					$('#p_nip').html(data['p_nip']); 
					$('#p_nama').html(data['p_nama']); 
					$('#p_golongan').html(data['p_pangkat']+' / '+data['p_golongan']); 
					$('#p_eselon').html(data['p_eselon']); 
					$('#p_jabatan').html(data['p_jabatan']); 
					$('#p_unit_kerja').html(data['p_unit_kerja']); 

					$('.pegawai_id').val(data['pegawai_id']); 
					$('.skp_tahunan_id').val(data['skp_tahunan_id']); 
					$('.u_nama').val(data['u_nama']); 
					$('.u_jabatan_id').val(data['u_jabatan_id']); 
					$('.u_golongan_id').val(data['u_golongan_id']); 
					$('.p_nama').val(data['p_nama']); 
					$('.p_jabatan_id').val(data['p_jabatan_id']);
					$('.p_golongan_id').val(data['p_golongan_id']); 
 
					$('.jenis_jabatan').val(data['u_jenis_jabatan']); 
					$('.jabatan_id').val(data['jabatan_id']);
					$('.renja_id').val(data['renja_id']);
					$('.jm_kegiatan').html(data['jm_kegiatan']); 





				if (data['status']==='pass'){
					$('.before_end').hide(); 
					$('.modal-create_capaian_pk_confirm').modal('show'); 
				}else if (data['status']==='pass_before_end'){

					Swal.fire({
						title: "Create Capaian PK",
						//text:$(this).data('label'),
						text:"Anda membuat Capaian Tahunan sebelum masa penilaian berakhir",
						type: "warning",
						//type: "question",
						showCancelButton: true,
						cancelButtonText: "Batal",
						confirmButtonText: "Ya",
						confirmButtonClass: "btn btn-success",
						cancelButtonColor: "btn btn-danger",
						cancelButtonColor: "#d33",
						closeOnConfirm: false,
						closeOnCancel:false
					}).then ((result) => {
						if (result.value){


							
							$('.before_end').show(); 
							$('.modal-create_capaian_pk_confirm').modal('show'); 

						}
					});

					
				}else if (data['status']==='fail'){
					

				}else{
					Swal.fire({
						title: 'Error!',
						text: 'Capaian PK belum bisa dibuat',
						type: 'error',
						confirmButtonText: 'Tutup'
					})
				}
				
			},
			error: function(jqXHR , textStatus, errorThrown) {

					Swal.fire({
						title: 'Error!',
						text: 'Capaian PK  belum bisa dibuat',
						type: 'error',
						confirmButtonText: 'Tutup'
					})
			}
			
		});
		
	});



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