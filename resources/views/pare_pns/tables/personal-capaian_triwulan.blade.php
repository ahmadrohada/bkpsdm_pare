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
	<div class="row" style="padding:5px 30px; min-height:200px;">
		<div class="box-body table-responsive">
			<div class="toolbar" hidden>
				<span  data-toggle="tooltip" title="Create Capaian Triwulan"><a class="btn btn-info btn-xs create_capaian_triwulan" ><i class="fa fa-plus" ></i> Create Capaian</a></span>
			</div>
			<table id="capaian_triwulan_table" class="table table-striped table-hover">
				<thead>
					<tr class="success">
						<th rowspan="2">NO</th>
						<th rowspan="2">PERIODE SKP</th>
						<th rowspan="2">JABATAN</th>
						<th colspan="4">CAPAIAN TRIWULAN</th>
					</tr>
					<tr>
						<th>TRIWULAN I</th>
						<th>TRIWULAN II</th>
						<th>TRIWULAN III</th>
						<th>TRIWULAN IV</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>

@include('pare_pns.modals.create_capaian_triwulan') 

<script type="text/javascript">
	$('#capaian_triwulan_table').DataTable({
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
									{ 	className: "text-center", targets: [ 0,1,3,4,5,6 ] }/* ,
									//{ 	className: "hidden-xs", targets: [ 5 ] } */
								],
				ajax			: {
									url	: '{{ url("api/personal_capaian_triwulan_list") }}',
									data: { pegawai_id : {!! $pegawai->id !!} },
									delay:3000

								},
				
				rowsGroup		: [1],
				columns			:[
								{ data: 'capaian_id' , orderable: true,searchable:false,width:"35px",
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
								
								{ data: "periode" ,  name:"periode", orderable: true, searchable: true,width:"125px",
									"render": function ( data, type, row ) {
										return row.periode;
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
								{ data: "capaian_triwulan" , orderable: false,searchable:false,width:"120px",
									"render": function ( data, type, row ) {

										if(row.id_jenis_jabatan == 5 ){ //JIka JFT,nggak wajib lah
											return  '<span style="margin:1px;" ><a class="btn btn-default btn-xs " disabled style="width:75px;">Capaian</a></span>';
										}else{

										
											if (row.remaining_time_triwulan1 >= 0 ){
												if (row.capaian_triwulan1_id == null ){
													return  '<span style="margin:1px;" ><a class="btn btn-warning btn-xs create_capaian_triwulan"  data-triwulan="1" data-skp_tahunan_id="'+row.skp_tahunan_id+'" style="width:75px;">Capaian</a></span>';
												}else{
													if ( row.capaian_triwulan1_status == 0 ){
														return  '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_capaian_triwulan" data-triwulan="1" data-id="'+row.capaian_triwulan1_id+'"><i class="fa fa-pencil" ></i></a></span>'+
																'<span  data-toggle="tooltip" title="lihat" style="margin:2px;" ><a class="btn btn-default btn-xs "><i class="fa fa-eye" ></i></a></span>'+
																'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_capaian_triwulan" data-triwulan="1" data-id="'+row.capaian_triwulan1_id+'"><i class="fa fa-close " ></i></a></span>';
													}else{
														return  '<span  style="margin:2px;" ><a class="btn btn-default btn-xs "><i class="fa fa-pencil" ></i></a></span>'+
																'<span  data-toggle="tooltip" title="lihat" style="margin:2px;" ><a class="btn btn-info btn-xs edit_capaian_triwulan" data-triwulan="1" data-id="'+row.capaian_triwulan1_id+'"><i class="fa fa-eye" ></i></a></span>'+
																'<span  style="margin:2px;" ><a class="btn btn-default btn-xs "><i class="fa fa-close " ></i></a></span>';
													}
													
												}
											}else{
												return  '<span style="margin:1px;" ><a class="btn btn-default btn-xs" style="width:75px; cursor:default;">'+row.remaining_time_triwulan1+'</a></span>';
											}	
										}


									}
								},
								{ data: "capaian_triwulan" , orderable: false,searchable:false,width:"120px",
									"render": function ( data, type, row ) {
										if(row.id_jenis_jabatan == 5 ){ //JIka JFT,nggak wajib lah
											return  '<span style="margin:1px;" ><a class="btn btn-default btn-xs " disabled style="width:75px;">Capaian</a></span>';
										}else{
											if (row.remaining_time_triwulan2 >= 0 ){
												if (row.capaian_triwulan2_id == null ){
													return  '<span style="margin:1px;" ><a class="btn btn-warning btn-xs create_capaian_triwulan"  data-triwulan="2" data-skp_tahunan_id="'+row.skp_tahunan_id+'" style="width:75px;">Capaian</a></span>';
												}else{
													if ( row.capaian_triwulan2_status == 0 ){
														return  '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_capaian_triwulan" data-triwulan="2" data-id="'+row.capaian_triwulan2_id+'"><i class="fa fa-pencil" ></i></a></span>'+
																'<span  data-toggle="tooltip" title="lihat" style="margin:2px;" ><a class="btn btn-default btn-xs "><i class="fa fa-eye" ></i></a></span>'+
																'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_capaian_triwulan" data-triwulan="2" data-id="'+row.capaian_triwulan2_id+'"><i class="fa fa-close " ></i></a></span>';
													}else{
														return  '<span  style="margin:2px;" ><a class="btn btn-default btn-xs "><i class="fa fa-pencil" ></i></a></span>'+
																'<span  data-toggle="tooltip" title="lihat" style="margin:2px;" ><a class="btn btn-info btn-xs edit_capaian_triwulan" data-triwulan="2" data-id="'+row.capaian_triwulan2_id+'"><i class="fa fa-eye" ></i></a></span>'+
																'<span  style="margin:2px;" ><a class="btn btn-default btn-xs "><i class="fa fa-close " ></i></a></span>';
													}
												}
											}else{
												return  '<span style="margin:1px;" ><a class="btn btn-default btn-xs" style="width:75px; cursor:default;">'+row.remaining_time_triwulan2+'</a></span>';
											}	
										}

									}
								},
								{ data: "capaian_triwulan" , orderable: false,searchable:false,width:"120px",
									"render": function ( data, type, row ) {
										if(row.id_jenis_jabatan == 5 ){ //JIka JFT,nggak wajib lah
											return  '<span style="margin:1px;" ><a class="btn btn-default btn-xs " disabled style="width:75px;">Capaian</a></span>';
										}else{
											if (row.remaining_time_triwulan3 >= 0 ){
												if (row.capaian_triwulan3_id == null ){
													return  '<span style="margin:1px;" ><a class="btn btn-warning btn-xs create_capaian_triwulan"  data-triwulan="3" data-skp_tahunan_id="'+row.skp_tahunan_id+'" style="width:75px;">Capaian</a></span>';
												}else{
													if ( row.capaian_triwulan3_status == 0 ){
														return  '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_capaian_triwulan" data-triwulan="3" data-id="'+row.capaian_triwulan3_id+'"><i class="fa fa-pencil" ></i></a></span>'+
																'<span  data-toggle="tooltip" title="lihat" style="margin:2px;" ><a class="btn btn-default btn-xs "><i class="fa fa-eye" ></i></a></span>'+
																'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_capaian_triwulan" data-triwulan="3" data-id="'+row.capaian_triwulan3_id+'"><i class="fa fa-close " ></i></a></span>';
													}else{
														return  '<span  style="margin:2px;" ><a class="btn btn-default btn-xs "><i class="fa fa-pencil" ></i></a></span>'+
																'<span  data-toggle="tooltip" title="lihat" style="margin:2px;" ><a class="btn btn-info btn-xs edit_capaian_triwulan" data-triwulan="3" data-id="'+row.capaian_triwulan3_id+'"><i class="fa fa-eye" ></i></a></span>'+
																'<span  style="margin:2px;" ><a class="btn btn-default btn-xs "><i class="fa fa-close " ></i></a></span>';
													}
												}
											}else{
												return  '<span style="margin:1px;" ><a class="btn btn-default btn-xs" style="width:75px; cursor:default;">'+row.remaining_time_triwulan3+'</a></span>';
												
											}	
										}

									}
								},
								{ data: "capaian_triwulan" , orderable: false,searchable:false,width:"120px",
									"render": function ( data, type, row ) {
										if(row.id_jenis_jabatan == 5 ){ //JIka JFT,nggak wajib lah
											return  '<span style="margin:1px;" ><a class="btn btn-default btn-xs " disabled style="width:75px;">Capaian</a></span>';
										}else{
											if (row.remaining_time_triwulan4 >= 0 ){
												if (row.capaian_triwulan4_id == null ){
													return  '<span style="margin:1px;" ><a class="btn btn-warning btn-xs create_capaian_triwulan"  data-triwulan="4" data-skp_tahunan_id="'+row.skp_tahunan_id+'" style="width:75px;">Capaian</a></span>';
												}else{
													if ( row.capaian_triwulan4_status == 0 ){
														return  '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_capaian_triwulan" data-triwulan="4" data-id="'+row.capaian_triwulan4_id+'"><i class="fa fa-pencil" ></i></a></span>'+
																'<span  data-toggle="tooltip" title="lihat" style="margin:2px;" ><a class="btn btn-default btn-xs "><i class="fa fa-eye" ></i></a></span>'+
																'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_capaian_triwulan" data-triwulan="4" data-id="'+row.capaian_triwulan4_id+'"><i class="fa fa-close " ></i></a></span>';
													}else{
														return  '<span  style="margin:2px;" ><a class="btn btn-default btn-xs "><i class="fa fa-pencil" ></i></a></span>'+
																'<span  data-toggle="tooltip" title="lihat" style="margin:2px;" ><a class="btn btn-info btn-xs edit_capaian_triwulan" data-triwulan="4" data-id="'+row.capaian_triwulan4_id+'"><i class="fa fa-eye" ></i></a></span>'+
																'<span  style="margin:2px;" ><a class="btn btn-default btn-xs "><i class="fa fa-close " ></i></a></span>';
													}
												}
											}else{
												return  '<span style="margin:1px;" ><a class="btn btn-default btn-xs" style="width:75px; cursor:default;">'+row.remaining_time_triwulan4+'</a></span>';
											}	
										}


									}
								}
								
							]
			
	});

	$(document).on('click','.edit_capaian_triwulan',function(e){
		var capaian_id = $(this).data('id') ;
		window.location.assign("capaian-triwulan/"+capaian_id+"/edit");
	});

	$(document).on('click','.hapus_capaian_triwulan',function(e){
		var capaian_triwulan_id = $(this).data('id') ;
		var triwulan = $(this).data('triwulan') ;

		Swal.fire({
			title: "Hapus  Capaian Triwulan "+triwulan,
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
					url		: '{{ url("api/hapus_capaian_triwulan") }}',
					type	: 'POST',
					data    : { capaian_triwulan_id:capaian_triwulan_id },
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
										$('#capaian_triwulan_table').DataTable().ajax.reload(null,false);
										
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#capaian_triwulan_table').DataTable().ajax.reload(null,false);
											
											
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




	$(document).on('click','.create_capaian_triwulan',function(e){
		
		var skp_tahunan_id = $(this).data('skp_tahunan_id') ;
		var triwulan = $(this).data('triwulan') ;
		//alert(triwulan);

		$.ajax({
				url			: '{{ url("api/capaian_triwulan_create_confirm") }}',
				data 		: { skp_tahunan_id:skp_tahunan_id,triwulan:triwulan },
				method		: "GET",
				dataType	: "json",
				success		: function(data) {
					if ( data == 0 ){
						modal_create_capaian_triwulan(skp_tahunan_id,triwulan);
					}else{
						alert("capaian sudah ada");
					}
					
				},
				error: function(data){
					alert("tes gagal ajah");
				}/* ,
				beforeSend: function(){
					show_loader();
				},
				complete: function(){
					swal.close();
				} 	 */					
		});	  



		
	});

	function modal_create_capaian_triwulan(skp_tahunan_id,triwulan){

		switch (triwulan){
			case 1:
				triwulan_text = "Triwulan I ( Januari - Maret )";
				break;
			case 2:
				triwulan_text = "Triwulan II ( April - Juni )";
				break;
			case 3:
				triwulan_text = "Triwulan III ( Juli - September )";
				break;
			case 4:
				triwulan_text = "Triwulan IV ( Oktober - Desember ) ";
				break;
			default:
				triwulan_text = "error";
		}		
		

		$.ajax({
				url			: '{{ url("api/skp_tahunan_detail") }}',
				data 		: { skp_tahunan_id:skp_tahunan_id },
				method		: "GET",
				dataType	: "json",
				success	: function(data) {


					$('.modal-create_capaian_triwulan').find('[name=periode_skp_tahunan]').html(data['periode']);
					$('.modal-create_capaian_triwulan').find('[name=masa_penilaian_skp_tahunan]').html(data['masa_penilaian']);
					$('.modal-create_capaian_triwulan').find('[name=periode_capaian_triwulan]').html(triwulan_text);

					$('.modal-create_capaian_triwulan').find('[name=pegawai_id]').val(data['pegawai_id']);
					$('.modal-create_capaian_triwulan').find('[name=triwulan]').val(triwulan);
					$('.modal-create_capaian_triwulan').find('[name=skp_tahunan_id]').val(skp_tahunan_id);


					$('.modal-create_capaian_triwulan').find('[name=u_nama]').val(data['u_nama']);
					$('.modal-create_capaian_triwulan').find('[name=u_jabatan_id]').val(data['u_jabatan_id']);
					$('.modal-create_capaian_triwulan').find('[name=p_nama]').val(data['p_nama']);
					$('.modal-create_capaian_triwulan').find('[name=p_jabatan_id]').val(data['p_jabatan_id']);



					$('.modal-create_capaian_triwulan').find('[name=u_nip]').html(data['u_nip']);
					$('.modal-create_capaian_triwulan').find('[name=u_nama]').html(data['u_nama']);
					$('.modal-create_capaian_triwulan').find('[name=u_pangkatgolongan]').html(data['u_pangkat']+' / '+data['u_golongan']);
					$('.modal-create_capaian_triwulan').find('[name=u_eselon]').html(data['u_eselon']);
					$('.modal-create_capaian_triwulan').find('[name=u_jabatan]').html(data['u_jabatan']);
					$('.modal-create_capaian_triwulan').find('[name=u_unit_kerja]').html(data['u_unit_kerja']);
					
					$('.modal-create_capaian_triwulan').find('[name=p_nip]').html(data['p_nip']);
					$('.modal-create_capaian_triwulan').find('[name=p_nama]').html(data['p_nama']);
					$('.modal-create_capaian_triwulan').find('[name=p_pangkatgolongan]').html(data['p_pangkat']+' / '+data['p_golongan']);
					$('.modal-create_capaian_triwulan').find('[name=p_eselon]').html(data['p_eselon']);
					$('.modal-create_capaian_triwulan').find('[name=p_jabatan]').html(data['p_jabatan']);
					$('.modal-create_capaian_triwulan').find('[name=p_unit_kerja]').html(data['p_unit_kerja']);
					
					
					
					

					$('.modal-create_capaian_triwulan').find('h4').html('Create SKP Bulanan');
					$('.modal-create_capaian_triwulan').find('.btn-submit').attr('id', 'submit-save_capaian_triwulan');
					$('.modal-create_capaian_triwulan').find('[name=text_button_submit]').html('Simpan Data');
					$('.modal-create_capaian_triwulan').modal('show');
				},
				error: function(data){
					
				}						
		});	  
	}
</script>
