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
						<th rowspan="2">SKPD</th>
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
				searching      	: true,
				paging          : true,
				bInfo			: false,
				bSort			: false,
				//order 			: [ 0 , 'desc' ],
				//dom 			: '<"toolbar">frtip',
				lengthMenu		: [25,50,100],
				columnDefs		: [
									{ 	className: "text-center", targets: [ 0,1,3,4,5,6,7 ] }
								],
				ajax			: {
									url	: '{{ url("api_resource/administrator_capaian_pk_triwulan_list") }}',
									data: { },
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
								{ data: "nama_skpd" ,  name:"nama_skpd", orderable: true, searchable: true,width:"250px",
									"render": function ( data, type, row ) {
										return row.nama_skpd;
									}	
								},
								{ data: "capaian_triwulan" , orderable: false,searchable:false,width:"90px",
									"render": function ( data, type, row ) {

										
										if (row.remaining_time_triwulan1 >= 0 ){
											if (row.capaian_pk_triwulan1_id == null ){ 
												return  '<span style="margin:1px;" ><a class="btn btn-default btn-xs" style="width:75px; cursor:default;">X</a></span>';
											}else{
												return  '<span  data-toggle="tooltip" title="lihat" style="margin:2px;" ><a class="btn btn-info btn-xs lihat_capaian_triwulan" style="width:75px;" data-triwulan="1" data-id="'+row.capaian_pk_triwulan1_id+'"><i class="fa fa-eye" ></i></a></span>';
											}
										}else{
											return  '<span style="margin:1px;" ><a class="btn btn-default btn-xs" style="width:75px; cursor:default;">-</a></span>';
										}	
									}
								},
								{ data: "capaian_triwulan" , orderable: false,searchable:false,width:"90px",
									"render": function ( data, type, row ) {
										if (row.remaining_time_triwulan2 >= 0 ){
											if (row.capaian_pk_triwulan2_id == null ){
												return  '<span style="margin:1px;" ><a class="btn btn-default btn-xs" style="width:75px; cursor:default;">X</a></span>';
											}else{
												return  '<span  data-toggle="tooltip" title="lihat" style="margin:2px;" ><a class="btn btn-info btn-xs lihat_capaian_triwulan"  style="width:75px;" data-triwulan="2" data-id="'+row.capaian_pk_triwulan2_id+'"><i class="fa fa-eye" ></i></a></span>';
											}
										}else{
											return  '<span style="margin:1px;" ><a class="btn btn-default btn-xs" style="width:75px; cursor:default;">-</a></span>';
										}	
									}
								},
								{ data: "capaian_triwulan" , orderable: false,searchable:false,width:"90px",
									"render": function ( data, type, row ) {
										if (row.remaining_time_triwulan3 >= 0 ){
											if (row.capaian_pk_triwulan3_id == null ){
												return  '<span style="margin:1px;" ><a class="btn btn-default btn-xs" style="width:75px; cursor:default;">X</a></span>';
											}else{
												return  '<span  data-toggle="tooltip" title="lihat" style="margin:2px;" ><a class="btn btn-info btn-xs lihat_capaian_triwulan" style="width:75px;"  data-triwulan="3" data-id="'+row.capaian_pk_triwulan3_id+'"><i class="fa fa-eye" ></i></a></span>';
											}
										}else{
											return  '<span style="margin:1px;" ><a class="btn btn-default btn-xs" style="width:75px; cursor:default;">-</a></span>';
											
										}
									}
								},
								{ data: "capaian_triwulan" , orderable: false,searchable:false,width:"90px",
									"render": function ( data, type, row ) {
										if (row.remaining_time_triwulan4 >= 0 ){
											if (row.capaian_pk_triwulan4_id == null ){
												return  '<span style="margin:1px;" ><a class="btn btn-default btn-xs" style="width:75px; cursor:default;">X</a></span>';
											}else{
												return  '<span  data-toggle="tooltip" title="lihat" style="margin:2px;" ><a class="btn btn-info btn-xs lihat_capaian_triwulan"  style="width:75px;" data-triwulan="4" data-id="'+row.capaian_pk_triwulan4_id+'"><i class="fa fa-eye" ></i></a></span>';
											}
										}else{
											return  '<span style="margin:1px;" ><a class="btn btn-default btn-xs" style="width:75px; cursor:default;">-</a></span>';
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

	$(document).on('click','.lihat_capaian_triwulan',function(e){
		var capaian_pk_id = $(this).data('id') ;
		window.location.assign("capaian_pk-triwulan/"+capaian_pk_id);
	});

	  
	
</script>
