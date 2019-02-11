<div class="box {{ $h_box }}">
    <div class="box-header with-border">
        <h1 class="box-title">
            Data Rencana Kerja Perangkat Daerah ( RKPD )
        </h1>

        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
            {!! Form::button('<i class="fa fa-times"></i>', array('class' => 'btn btn-box-tool','title' => 'close', 'data-widget' => 'remove', 'data-toggle' => 'tooltip')) !!}
        </div>
    </div>
	<div class="box-body table-responsive">

		<table id="renja_table" class="table table-striped table-hover table-condensed">
			<thead>
				<tr class="success">
					<th>NO</th>
					<th>PERIODE</th>
					<th>KEPALA SKPD</th>
					<th><i class="fa fa-cog" style="margin-left:12px !important;"></i></th>
				</tr>
			</thead>
			
			
		</table>

	</div>
</div>

@include('admin.modals.create_renja_confirm')


<script type="text/javascript">
	$(document).ready(function() {
		//alert();
		
		$('#renja_table').DataTable({
				processing      : true,
				serverSide      : true,
				searching      	: false,
				paging          : false,
				order 			: [ 0 , 'desc' ],
				//dom 			: '<"toolbar">frtip',
				lengthMenu		: [50,100],
				columnDefs		: [
									{ 	className: "text-center", targets: [ 0,1,3 ] }/* ,
									//{ 	className: "hidden-xs", targets: [ 5 ] } */
								],
				ajax			: {
									url	: '{{ url("api_resource/skpd_renja_list") }}',
									data: { skpd_id : {{$skpd_id}} },
									delay:3000
								},
				

				columns	:[
								{ data: 'periode_id' , orderable: true,searchable:false,
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
								
								{ data: "periode_label" ,  name:"periode_label", orderable: true, searchable: false},
								{ data: "kepala_skpd" ,  name:"kepala_skpd", orderable: true, searchable: false},
								{ data: "status" , orderable: false,searchable:false,width:"80px",
										"render": function ( data, type, row ) {

										if ( row.renja_id >= 1 ){ // sudah bikin 

											if ( row.send_to_kaban == 1 ){ //sudah dikirim ke kaban
												return  '<span  data-toggle="tooltip" title="Lihat" style="margin:2px;" ><a class="btn btn-info btn-xs lihat_renja"  data-id="'+row.renja_id+'" ><i class="fa fa-eye" ></i></a></span>'
														+'<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-default btn-xs edit_renja"  data-id="'+row.renja_id+'" disabled><i class="fa fa-pencil" ></i></a></span>'
														+'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-default btn-xs hapus_renja"  data-id="'+row.renja_id+'" data-periode="'+row.periode_label+'" disabled><i class="fa fa-close " ></i></a></span>';
											
											}else{ //belum dikirim ke kaban
												return  '<span style="margin:2px;" ><a class="btn btn-default btn-xs" disabled><i class="fa fa-eye" ></i></a></span>'
														+'<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_renja"  data-id="'+row.renja_id+'"><i class="fa fa-pencil" ></i></a></span>'
														+'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-default btn-xs hapus_renja"  data-id="'+row.renja_id+'" data-periode="'+row.periode_label+'" disabled ><i class="fa fa-close " ></i></a></span>';
											
											}
											
										}else{//belum bikin renja
											return  '<span  data-toggle="tooltip" title="Create renja" style="margin:2px;" ><a class="btn btn-warning btn-xs create_renja"  data-skpd_id="'+row.skpd_id+'" data-periode_id="'+row.periode_id+'" >Create Renja</a></span>';
											
										}
									}
								},
								
							]
			
		});
	
	
	});


	$(document).on('click','.edit_renja',function(e){
		var renja_id = $(this).data('id') ;
		
		window.location.assign("renja/"+renja_id+"/edit");
	});

</script>
