<div class="box {{ $h_box }}">
    <div class="box-header with-border">
        <h1 class="box-title">
            Data TPP Report
        </h1>

        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
            {!! Form::button('<i class="fa fa-times"></i>', array('class' => 'btn btn-box-tool','title' => 'close', 'data-widget' => 'remove', 'data-toggle' => 'tooltip')) !!}
        </div>
    </div>
	<div class="box-body table-responsive">

		<table id="tpp_data_table" class="table table-striped table-hover table-condensed">
			<thead>
				<tr class="success">
					<th>NO</th>
					<th>PERIODE</th>
					<th>BULAN</th>
					<th>SKPD</th>
					<th>CREATED AT</th>
					<th><i class="fa fa-cog" style="margin-left:12px !important;"></i></th>
				</tr>
			</thead>
			
			
		</table>

	</div>
</div>



<script type="text/javascript">

	$('#tpp_data_table').DataTable({
				processing      : true,
				serverSide      : true,
				searching      	: true,
				paging          : true,
				//order 			: [ 3 , 'asc' ],
				//dom 			: '<"toolbar">frtip',
				lengthMenu		: [50,100],
				columnDefs		: [
									{ 	className: "text-center", targets: [ 0,1,2,4,5 ] }/* ,
									//{ 	className: "hidden-xs", targets: [ 5 ] } */
								],
				ajax			: {
									url	: '{{ url("api_resource/administrator_tpp_report_list") }}',
									
									delay:3000
								},
				

				columns	:[
								{ data: 'skp_tahunan_id' , orderable: true,searchable:false,
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
								
								{ data: "periode" ,  name:"periode", orderable: true, searchable: true},
								{ data: "bulan" ,  name:"bulan", orderable: true, searchable: true},
								{ data: "skpd" ,  name:"skpd", orderable: true, searchable: true},
								{ data: "created_at" ,  name:"created_at", orderable: true, searchable: true},
								{ data: "status" , orderable: false,searchable:false,width:"50px",
										"render": function ( data, type, row ) {

											//return  '<span  data-toggle="tooltip" title="Lihat" style="margin:1px;" ><a class="btn btn-info btn-xs lihat_skp_tahunan"  data-id="'+row.skp_tahunan_id+'"><i class="fa fa-eye" ></i></a></span>';
											if ( row.status == 1 ){
												return "close";
											}else{
												return "open";
											}
									}
								},
								
							]
			
	});
	
	
	$(document).on('click','.lihat_skp_tahunan',function(e){
		var skp_tahunan_id = $(this).data('id') ;
		//alert(skp_tahunan_id);



		window.location.assign("skp_tahunan/"+skp_tahunan_id);
	});
</script>
