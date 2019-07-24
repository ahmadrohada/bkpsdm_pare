<div class="box {{ $h_box }}">
    <div class="box-header with-border">
        <h1 class="box-title">
            Data Capaian Triwulan 
        </h1>

        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
            {!! Form::button('<i class="fa fa-times"></i>', array('class' => 'btn btn-box-tool','title' => 'close', 'data-widget' => 'remove', 'data-toggle' => 'tooltip')) !!}
        </div>
    </div>
	<div class="box-body table-responsive">

		<div class="toolbar">
			<span  data-toggle="tooltip" title="Create Capaian Triwulan"><a class="btn btn-info btn-xs create_capaian_triwulan" ><i class="fa fa-plus" ></i> Create Capaian</a></span>
		</div>
		<table id="capaian_triwulan_table" class="table table-striped table-hover table-condensed">

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

@include('admin.modals.create_capaian_triwulan') 

<script type="text/javascript">
	$('#capaian_triwulan_table').DataTable({
				processing      : true,
				serverSide      : true,
				searching      	: false,
				paging          : false,
				//order 			: [ 0 , 'desc' ],
				//dom 			: '<"toolbar">frtip',
				lengthMenu		: [50,100],
				columnDefs		: [
									{ 	className: "text-center", targets: [ 0,1,2,3,4 ] }/* ,
									//{ 	className: "hidden-xs", targets: [ 5 ] } */
								],
				ajax			: {
									url	: '{{ url("api_resource/personal_capaian_triwulan_list") }}',
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
														return  '<span  data-toggle="tooltip" title="Ralat" style="margin:2px;" ><a class="btn btn-warning btn-xs ralat_capaian_bulanan"  data-id="'+row.capaian_id+'"><i class="fa fa-pencil" ></i></a></span>'+
																'<span  data-toggle="tooltip" title="lihat" style="margin:2px;" ><a class="btn btn-info btn-xs lihat_capaian_bulanan"  data-id="'+row.capaian_id+'"><i class="fa fa-eye" ></i></a></span>'+
																'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-default btn-xs"><i class="fa fa-close " ></i></a></span>';
													}else{
														//diterima
														return  '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-default btn-xs "><i class="fa fa-pencil" ></i></a></span>'+
																'<span  data-toggle="tooltip" title="lihat" style="margin:2px;" ><a class="btn btn-info btn-xs lihat_capaian_bulanan"  data-id="'+row.capaian_id+'"><i class="fa fa-eye" ></i></a></span>'+
																'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-default btn-xs"><i class="fa fa-close " ></i></a></span>';
													}
												}else{
													//blm dikirim
													return  '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_capaian_bulanan" data-id="'+row.capaian_id+'"><i class="fa fa-pencil" ></i></a></span>'+
																'<span  data-toggle="tooltip" title="lihat" style="margin:2px;" ><a class="btn btn-default btn-xs "><i class="fa fa-eye" ></i></a></span>'+
																'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_capaian_bulanan" data-id="'+row.capaian_id+'"><i class="fa fa-close " ></i></a></span>';
												}
											}else{
												return  '<span style="margin:1px;" ><a class="btn btn-warning btn-xs create_capaian_bulanan"  data-capaian_triwulan_id="'+row.capaian_triwulan_id+'" style="width:75px;">Capaian</a></span>';
											}


											
										}else{

											return row.remaining_time;
											
										
										}
									}
								},
								
							]
			
	});


	$(document).on('click','.create_capaian_triwulan',function(e){
		modal_create_capaian_triwulan();
	});

	function modal_create_capaian_triwulan(){

		$('.modal-create_capaian_triwulan').find('h4').html('Create Capaian Triwulan');
		$('.modal-create_capaian_triwulan').find('.btn-submit').attr('id', 'submit-save_capaian_triwulan');
		$('.modal-create_capaian_triwulan').find('[name=text_button_submit]').html('Simpan Data');
		$('.modal-create_capaian_triwulan').modal('show');

		/* $.ajax({
				url			: '{{ url("api_resource/skp_tahunan_detail") }}',
				data 		: '',
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					$('.modal-create_capaian_triwulan').find('[name=periode_skp]').html(data['periode']);
					$('.modal-create_capaian_triwulan').find('[name=u_nama]').html(data['u_nama']);
					$('.modal-create_capaian_triwulan').find('[name=u_jabatan]').html(data['u_jabatan']);
					$('.modal-create_capaian_triwulan').find('[name=p_nama]').html(data['p_nama']);
					$('.modal-create_capaian_triwulan').find('[name=p_jabatan]').html(data['p_jabatan']);

					
					$('.modal-create_capaian_triwulan').find('[name=tgl_mulai]').val(data['tgl_mulai']);
					$('.modal-create_capaian_triwulan').find('[name=pegawai_id]').val(data['pegawai_id']);
					$('.modal-create_capaian_triwulan').find('[name=u_jabatan_id]').val(data['u_jabatan_id']);
					$('.modal-create_capaian_triwulan').find('[name=p_jabatan_id]').val(data['p_jabatan_id']);
					$('.modal-create_capaian_triwulan').find('[name=u_nama]').val(data['u_nama']);
					$('.modal-create_capaian_triwulan').find('[name=p_nama]').val(data['p_nama']);

					//DISABLED BULAN YANG UDAH ADA
					//data['capaian_triwulan_list'][0]['bulan']
					bln = data['capaian_triwulan_list'];
					$('.periode_capaian_triwulan').children().each(function(index,element){
					
        			for (i = 0; i < bln.length ; i++){
							if ( $(element).val() == data['capaian_triwulan_list'][i]['bulan']){
								$(this).prop('disabled',true);
							}
						}
					})

					$('.modal-create_capaian_triwulan').find('h4').html('Create SKP Bulanan');
					$('.modal-create_capaian_triwulan').find('.btn-submit').attr('id', 'submit-save_capaian_triwulan');
					$('.modal-create_capaian_triwulan').find('[name=text_button_submit]').html('Simpan Data');
					$('.modal-create_capaian_triwulan').modal('show');
				},
				error: function(data){
					
				}						
		});	 */
	}
</script>
