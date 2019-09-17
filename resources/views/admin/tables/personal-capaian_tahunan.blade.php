<div class="box {{ $h_box }}">
    <div class="box-header with-border">
        <h1 class="box-title">
            Data Capaian Tahunan 
        </h1>

        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
            {!! Form::button('<i class="fa fa-times"></i>', array('class' => 'btn btn-box-tool','title' => 'close', 'data-widget' => 'remove', 'data-toggle' => 'tooltip')) !!}
        </div>
    </div>
	<div class="box-body table-responsive">

		<table id="skp_tahunan_table" class="table table-striped table-hover table-condensed">
			<thead>
				<tr class="success">
					<th>NO</th>
					<th>PERIODE</th>
					<th>PELAKSANAAN</th>
					<th>JABATAN</th>
					<th>CAPAIAN</th>
				</tr>
			</thead>
			
			
		</table>

	</div>
</div>

@include('admin.modals.create_capaian_tahunan_before_end_confirm')

<script type="text/javascript">
	$('#skp_tahunan_table').DataTable({
				processing      : true,
				serverSide      : true,
				searching      	: false,
				paging          : false,
				order 			: [ 2 , 'desc' ],
				//dom 			: '<"toolbar">frtip',
				lengthMenu		: [50,100],
				columnDefs		: [
									{ 	className: "text-center", targets: [ 0,1,2,4] }/* ,
									//{ 	className: "hidden-xs", targets: [ 5 ] } */
								],
				ajax			: {
									url	: '{{ url("api_resource/personal_capaian_tahunan_list") }}',
									data: { pegawai_id : {!! $pegawai->id !!} },
									delay:3000

								},
				

				columns	:[
								{ data: 'capaian_id' , orderable: true,searchable:false,
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
								
								{ data: "periode" ,  name:"periode", orderable: true, searchable: true,
									"render": function ( data, type, row ) {
										if (row.capaian_status_approve == 2){
											return "<span class='text-danger'>"+row.periode+"</span>";
										}else{
											return row.periode;
										}

									}	
								},
								{ data: "pelaksanaan" ,  name:"pelaksanaan", orderable: true, searchable: true,width:"250px",
									"render": function ( data, type, row ) {
										if (row.capaian_status_approve == 2){
											return "<span class='text-danger'>"+row.pelaksanaan+"</span>";
										}else{
											return row.pelaksanaan;
										}

									}	
								},
								{ data: "jabatan" ,  name:"jabatan", orderable: true, searchable: true,
									"render": function ( data, type, row ) {
										if (row.capaian_status_approve == 2){
											return "<span class='text-danger'>"+row.jabatan+"</span>";
										}else{
											return row.jabatan;
										}

									}	
								},
								
								{ data: "capaian" , orderable: false,searchable:false,width:"120px",
										"render": function ( data, type, row ) {
										if (row.remaining_time >= 0 ){ 
											if (row.capaian >= 1 ){ 


												if (row.capaian_send_to_atasan == 1 ){
													if (row.capaian_status_approve == 2){
														//ditolak
														return  '<span  data-toggle="tooltip" title="Ralat" style="margin:2px;" ><a class="btn btn-warning btn-xs ralat_capaian_tahunan"  data-id="'+row.capaian_id+'"><i class="fa fa-pencil" ></i></a></span>'+
																'<span  data-toggle="tooltip" title="lihat" style="margin:2px;" ><a class="btn btn-info btn-xs lihat_capaian_tahunan"  data-id="'+row.capaian_id+'"><i class="fa fa-eye" ></i></a></span>'+
																'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-default btn-xs"><i class="fa fa-close " ></i></a></span>';
													}else{
														//diterima
														return  '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-default btn-xs "><i class="fa fa-pencil" ></i></a></span>'+
																'<span  data-toggle="tooltip" title="lihat" style="margin:2px;" ><a class="btn btn-info btn-xs lihat_capaian_tahunan"  data-id="'+row.capaian_id+'"><i class="fa fa-eye" ></i></a></span>'+
																'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-default btn-xs"><i class="fa fa-close " ></i></a></span>';
													}
												}else{
													//blm dikirim
													return  '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_capaian_tahunan" data-id="'+row.capaian_id+'"><i class="fa fa-pencil" ></i></a></span>'+
																'<span  data-toggle="tooltip" title="lihat" style="margin:2px;" ><a class="btn btn-default btn-xs "><i class="fa fa-eye" ></i></a></span>'+
																'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_capaian_tahunan" data-id="'+row.capaian_id+'"><i class="fa fa-close " ></i></a></span>';
												}
											}else{
												return  '<span style="margin:1px;" ><a class="btn btn-warning btn-xs create_capaian_tahunan"  data-skp_tahunan_id="'+row.skp_tahunan_id+'" style="width:75px;">Capaian</a></span>';
											}


											
										}else{

											return  '<span style="margin:1px;" ><a class="progress-bar progress-bar-aqua btn btn-warning btn-xs create_capaian_tahunan_before_end"  data-skp_tahunan_id="'+row.skp_tahunan_id+'" style="width:120px;">Create ['+row.remaining_time+']</a></span>';
											
										
										}
									}
								},
								
							]
			
	});


	$(document).on('click','.edit_capaian_tahunan',function(e){
		var capaian_id = $(this).data('id') ;
		window.location.assign("capaian-tahunan/"+capaian_id+"/edit");
	});

	$(document).on('click','.ralat_capaian_tahunan',function(e){
		var capaian_id = $(this).data('id') ;
		window.location.assign("capaian-tahunan/"+capaian_id+"/ralat");
	});

	$(document).on('click','.lihat_capaian_tahunan',function(e){
		var capaian_id = $(this).data('id') ;
		window.location.assign("capaian-tahunan/"+capaian_id);
	});
	
	

	$(document).on('click','.create_capaian_tahunan_before_end',function(e){
		var skp_tahunan_id = $(this).data('skp_tahunan_id') ;

		Swal.fire({
			title: "Create Capaian Tahunan",
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
				
			
				open_modal_create_capaian_before_end(skp_tahunan_id);



			}
		});
	});


	function open_modal_create_capaian_before_end(skp_tahunan_id){


		$.ajax({
			url		: '{{ url("api_resource/create_capaian_tahunan_before_end_confirm") }}',
			type	: 'GET',
			data	:  	{ 
							skp_tahunan_id : skp_tahunan_id
						},
			success	: function(data) {
				
				if (data['status']==='pass'){


					$('#periode_label').html(data['periode_label']); 
					$('.mulai').val(data['tgl_mulai']); 
					$('.selesai').val(data['tgl_selesai']); 
					$('.selesai_baru').val(data['tgl_selesai_baru']); 
					$('.jm_kegiatan_txt').val(data['jm_kegiatan']); 
				
						
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
					$('.p_nama').val(data['p_nama']); 
					$('.p_jabatan_id').val(data['p_jabatan_id']);
 
					$('.jenis_jabatan').val(data['u_jenis_jabatan']); 
					$('.jabatan_id').val(data['jabatan_id']);
					$('.renja_id').val(data['renja_id']);
					$('.jm_kegiatan').html(data['jm_kegiatan']); 
					
					$('.modal-create_capaian_tahunan_before_end_confirm').modal('show'); 
				}else if (data['status']==='fail'){
				




				}else{
					Swal.fire({
						title: 'Error!',
						text: 'Capaian tahunan belum bisa dibuat',
						type: 'error',
						confirmButtonText: 'Tutup'
					})
				}
				
			},
			error: function(jqXHR , textStatus, errorThrown) {

					Swal.fire({
						title: 'Error!',
						text: 'Capaian tahunan  belum bisa dibuat',
						type: 'error',
						confirmButtonText: 'Tutup'
					})
			}
			
		});
	}




	$(document).on('click','.hapus_capaian_tahunan',function(e){
		var capaian_tahuhan_id = $(this).data('id') ;

		Swal.fire({
			title: "Hapus  Capaian Tahunan",
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
					url		: '{{ url("api_resource/hapus_capaian_tahunan") }}',
					type	: 'POST',
					data    : { capaian_tahunan_id:capaian_tahunan_id },
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
										$('#skp_tahunan_table').DataTable().ajax.reload(null,false);
										
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#skp_tahunan_table').DataTable().ajax.reload(null,false);
											
											
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
