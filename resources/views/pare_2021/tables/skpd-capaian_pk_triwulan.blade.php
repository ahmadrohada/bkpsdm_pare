<div class="box {{ $h_box }}">
    <div class="box-header with-border">
        <h1 class="box-title">
            Data Capaian PK - Triwulan
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
			<table id="capaian_pk_triwulan_table" class="table table-striped table-hover">
				<thead>
					<tr class="success">
						<th rowspan="2">NO</th>
						<th rowspan="2">PERIODE PK</th>
						<th rowspan="2">NAMA KEPALA SKPD</th>
						<th colspan="4">CAPAIAN PK - TRIWULAN</th>
						<th rowspan="2"><i class="fa fa-cog"></i></th>
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

@include('pare_pns.modals.create_capaian_pk_triwulan_confirm')

<script type="text/javascript">
	$('#capaian_pk_triwulan_table').DataTable({
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
									{ 	className: "text-center", targets: [ 0,1,3,4,5,6,7 ] }
								],
				ajax			: {
									url	: '{{ url("api/skpd_capaian_pk_triwulan_list") }}',
									data: { skpd_id : {!! $skpd_id !!} },
									delay:3000

								},
				
				columns			:[
								{ data: 'renja_id' , orderable: true,searchable:false,width:"35px",
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
								
								{ data: "periode" ,  name:"periode", orderable: true, searchable: true,width:"85px",
									"render": function ( data, type, row ) {
										return row.periode;
									}	
								},
								{ data: "nama_kepala_skpd" ,  name:"nama_kepala_skpd", orderable: true, searchable: true,width:"250px",
									"render": function ( data, type, row ) {
										return row.nama_kepala_skpd;
									}	
								},
								{ data: "capaian_triwulan" , orderable: false,searchable:false,width:"90px",
									"render": function ( data, type, row ) {

										
										if (row.remaining_time_triwulan1 >= 0 ){
											if (row.capaian_pk_triwulan1_id == null ){ 
												return  '<span style="margin:1px;" ><a class="btn btn-warning btn-xs create_capaian_pk_triwulan"  data-triwulan="1" data-renja_id="'+row.renja_id+'" style="width:75px;">Capaian</a></span>';
											}else{
												if ( row.capaian_pk_triwulan1_status == 0 ){
													return  '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_capaian_triwulan" data-triwulan="1" data-id="'+row.capaian_pk_triwulan1_id+'"><i class="fa fa-pencil" ></i></a></span>'+
															'<span  data-toggle="tooltip" title="lihat" style="margin:2px;" ><a class="btn btn-default btn-xs "><i class="fa fa-eye" ></i></a></span>'+
															'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_capaian_triwulan" data-triwulan="1" data-id="'+row.capaian_pk_triwulan1_id+'"><i class="fa fa-close " ></i></a></span>';
												}else{
													return  '<span  style="margin:2px;" ><a class="btn btn-default btn-xs "><i class="fa fa-pencil" ></i></a></span>'+
															'<span  data-toggle="tooltip" title="lihat" style="margin:2px;" ><a class="btn btn-info btn-xs edit_capaian_triwulan" data-triwulan="1" data-id="'+row.capaian_pk_triwulan1_id+'"><i class="fa fa-eye" ></i></a></span>'+
															'<span  style="margin:2px;" ><a class="btn btn-default btn-xs "><i class="fa fa-close " ></i></a></span>';
												}	
											}
										}else{
											return  '<span style="margin:1px;" ><a class="btn btn-default btn-xs" style="width:75px; cursor:default;">'+row.remaining_time_triwulan1+'</a></span>';
										}	
									}
								},
								{ data: "capaian_triwulan" , orderable: false,searchable:false,width:"90px",
									"render": function ( data, type, row ) {
										if (row.remaining_time_triwulan2 >= 0 ){
											if (row.capaian_pk_triwulan2_id == null ){
												return  '<span style="margin:1px;" ><a class="btn btn-warning btn-xs create_capaian_pk_triwulan"  data-triwulan="2" data-renja_id="'+row.renja_id+'" style="width:75px;">Capaian</a></span>';
											}else{
												if ( row.capaian_pk_triwulan2_status == 0 ){
													return  '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_capaian_triwulan" data-triwulan="2" data-id="'+row.capaian_pk_triwulan2_id+'"><i class="fa fa-pencil" ></i></a></span>'+
															'<span  data-toggle="tooltip" title="lihat" style="margin:2px;" ><a class="btn btn-default btn-xs "><i class="fa fa-eye" ></i></a></span>'+
															'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_capaian_triwulan" data-triwulan="2" data-id="'+row.capaian_pk_triwulan2_id+'"><i class="fa fa-close " ></i></a></span>';
												}else{
													return  '<span  style="margin:2px;" ><a class="btn btn-default btn-xs "><i class="fa fa-pencil" ></i></a></span>'+
															'<span  data-toggle="tooltip" title="lihat" style="margin:2px;" ><a class="btn btn-info btn-xs edit_capaian_triwulan" data-triwulan="2" data-id="'+row.capaian_pk_triwulan2_id+'"><i class="fa fa-eye" ></i></a></span>'+
															'<span  style="margin:2px;" ><a class="btn btn-default btn-xs "><i class="fa fa-close " ></i></a></span>';
												}
											}
										}else{
											return  '<span style="margin:1px;" ><a class="btn btn-default btn-xs" style="width:75px; cursor:default;">'+row.remaining_time_triwulan2+'</a></span>';
										}	
									}
								},
								{ data: "capaian_triwulan" , orderable: false,searchable:false,width:"90px",
									"render": function ( data, type, row ) {
										if (row.remaining_time_triwulan3 >= 0 ){
											if (row.capaian_pk_triwulan3_id == null ){
												return  '<span style="margin:1px;" ><a class="btn btn-warning btn-xs create_capaian_pk_triwulan"  data-triwulan="3" data-renja_id="'+row.renja_id+'" style="width:75px;">Capaian</a></span>';
											}else{
												if ( row.capaian_pk_triwulan3_status == 0 ){
													return  '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_capaian_triwulan" data-triwulan="3" data-id="'+row.capaian_pk_triwulan3_id+'"><i class="fa fa-pencil" ></i></a></span>'+
															'<span  data-toggle="tooltip" title="lihat" style="margin:2px;" ><a class="btn btn-default btn-xs "><i class="fa fa-eye" ></i></a></span>'+
															'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_capaian_triwulan" data-triwulan="3" data-id="'+row.capaian_pk_triwulan3_id+'"><i class="fa fa-close " ></i></a></span>';
												}else{
													return  '<span  style="margin:2px;" ><a class="btn btn-default btn-xs "><i class="fa fa-pencil" ></i></a></span>'+
															'<span  data-toggle="tooltip" title="lihat" style="margin:2px;" ><a class="btn btn-info btn-xs edit_capaian_triwulan" data-triwulan="3" data-id="'+row.capaian_pk_triwulan3_id+'"><i class="fa fa-eye" ></i></a></span>'+
															'<span  style="margin:2px;" ><a class="btn btn-default btn-xs "><i class="fa fa-close " ></i></a></span>';
												}
											}
										}else{
											return  '<span style="margin:1px;" ><a class="btn btn-default btn-xs" style="width:75px; cursor:default;">'+row.remaining_time_triwulan3+'</a></span>';
											
										}
									}
								},
								{ data: "capaian_triwulan" , orderable: false,searchable:false,width:"90px",
									"render": function ( data, type, row ) {
										if (row.remaining_time_triwulan4 >= 0 ){
											if (row.capaian_pk_triwulan4_id == null ){
												return  '<span style="margin:1px;" ><a class="btn btn-warning btn-xs create_capaian_pk_triwulan"  data-triwulan="4" data-renja_id="'+row.renja_id+'" style="width:75px;">Capaian</a></span>';
											}else{
												if ( row.capaian_pk_triwulan4_status == 0 ){
													return  '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_capaian_triwulan" data-triwulan="4" data-id="'+row.capaian_pk_triwulan4_id+'"><i class="fa fa-pencil" ></i></a></span>'+
															'<span  data-toggle="tooltip" title="lihat" style="margin:2px;" ><a class="btn btn-default btn-xs "><i class="fa fa-eye" ></i></a></span>'+
															'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_capaian_triwulan" data-triwulan="4" data-id="'+row.capaian_pk_triwulan4_id+'"><i class="fa fa-close " ></i></a></span>';
												}else{
													return  '<span  style="margin:2px;" ><a class="btn btn-default btn-xs "><i class="fa fa-pencil" ></i></a></span>'+
															'<span  data-toggle="tooltip" title="lihat" style="margin:2px;" ><a class="btn btn-info btn-xs edit_capaian_triwulan" data-triwulan="4" data-id="'+row.capaian_pk_triwulan4_id+'"><i class="fa fa-eye" ></i></a></span>'+
															'<span  style="margin:2px;" ><a class="btn btn-default btn-xs "><i class="fa fa-close " ></i></a></span>';
												}
											}
										}else{
											return  '<span style="margin:1px;" ><a class="btn btn-default btn-xs" style="width:75px; cursor:default;">'+row.remaining_time_triwulan4+'</a></span>';
										}

									}
								},
								{  data: 'action',width:"20px",
									"render": function ( data, type, row ) {
										return  '<span  data-toggle="tooltip" title="Monitoring Kinerja" style="margin:2px;" ><a class="btn btn-info btn-xs monitoring_kinerja"  data-id="'+row.renja_id+'"><i class="fa fa-eye" ></i></a></span>';
									}
								},
								
							]
			
	});


	$(document).on('click','.monitoring_kinerja',function(e){
		var renja_id = $(this).data('id') ;
		window.location.assign("monitoring_kinerja/"+renja_id);
	});

	$(document).on('click','.edit_capaian_triwulan',function(e){
		var capaian_pk_id = $(this).data('id') ;
		window.location.assign("capaian_pk-triwulan/"+capaian_pk_id+"/edit");
	});

	$(document).on('click','.hapus_capaian_triwulan',function(e){
		var capaian_pk_triwulan_id = $(this).data('id') ;
		var triwulan = $(this).data('triwulan') ;

		Swal.fire({
			title: "Hapus  Capaian PK Triwulan "+triwulan,
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
					url		: '{{ url("api/hapus_capaian_pk_triwulan") }}',
					type	: 'POST',
					data    : { capaian_pk_triwulan_id:capaian_pk_triwulan_id },
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
										$('#capaian_pk_triwulan_table').DataTable().ajax.reload(null,false);
										
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#capaian_pk_triwulan_table').DataTable().ajax.reload(null,false);
											
											
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




	$(document).on('click','.create_capaian_pk_triwulan',function(e){
		
		var renja_id = $(this).data('renja_id') ;
		var triwulan = $(this).data('triwulan') ;
		show_loader();
		$.ajax({
				url			: '{{ url("api/capaian_pk_triwulan_create_confirm") }}',
				data 		: { renja_id:renja_id,triwulan:triwulan },
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					if ( data == 0 ){
						modal_create_capaian_pk_triwulan(renja_id,triwulan);
					}else{
						
						swal.close();
						alert("Fungsi Belum Tersedia");
					}
					
				},
				error: function(data){
					swal.close();
					alert("tes gagal ajah");
				},
				/* beforeSend: function(){
					show_loader();
				},
				complete: function(){
					swal.close();
				} 	 */					
		});	  



		
	});

	function modal_create_capaian_pk_triwulan(renja_id,triwulan){

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
				url			: '{{ url("api/renja_detail") }}',
				data 		: { renja_id:renja_id },
				method		: "GET",
				dataType	: "json",
				success	: function(data) {


					$('.modal-create_capaian_pk_triwulan').find('[name=periode_skp_tahunan]').html(data['periode']);
					$('.modal-create_capaian_pk_triwulan').find('[name=nama_kepala_skpd]').html(data['nama_kepala_skpd']);

					$('.modal-create_capaian_pk_triwulan').find('[name=renja_id]').val(renja_id);
					$('.modal-create_capaian_pk_triwulan').find('[name=triwulan]').val(triwulan);

					$('.modal-create_capaian_pk_triwulan').find('[name=periode_capaian_triwulan]').html(triwulan_text);

					
					$('.modal-create_capaian_pk_triwulan').find('.btn-submit').attr('id', 'submit-save_capaian_pk_triwulan');
					$('.modal-create_capaian_pk_triwulan').modal('show');
				},
				error: function(data){
					
				}						
		});	  
	}
</script>
