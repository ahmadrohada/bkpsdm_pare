<div class="box {{ $h_box }}">
    <div class="box-header with-border">
        <h1 class="box-title">
            CAPAIAN TAHUNAN
        </h1>

        <div class="box-tools pull-right">
            
        </div>
	</div>
	<div class="row" style="padding:5px 30px; min-height:200px;">
		<div class="box-body table-responsive">
			<table id="skpd_table" class="table table-striped table-hover table-condensed">
				<thead>
					<tr class="success">
						<th>NO</th>
						<th>PERIODE</th>
						<th>NAMA SKPD</th>
						<th><i class="fa fa-cog" style="margin-left:12px !important;"></i></th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>



<script type="text/javascript">

		$('#skpd_table').DataTable({
				destroy			: true,
				processing      : true,
				serverSide      : true,
				searching      	: true,
				paging          : true,
				autoWidth		: false,
				bInfo			: false,
				bSort			: false,
				lengthChange	: false,
				order 			: [ 0 , 'asc' ],
				lengthMenu		: [25,50],
				columnDefs		: [
									{ 	className: "text-center", targets: [ 0,1,3 ] }
								],
				ajax			: {
									url	: '{{ url("api/administrator_skpd_capaian_tahunan") }}',
								},
			
				//rowsGroup		: [ 1 ],
				columns	:[
								{ data: 'periode_id' , orderable: true,searchable:false,width:"30px",
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
								{ data: "periode",namw:"periode",orderable: true, searchable: true},
								{ data: "skpd" , name:"skpd", orderable: true, searchable: true},
								
								{ data: "action" , orderable: false,searchable:false,width:"50px",
										"render": function ( data, type, row ) {
											return  '<span  data-toggle="tooltip" title="Lihat" style="margin:1px;" class=""><a href="../admin/capaian_tahunan/skpd/'+row.skpd_id+'/periode/'+row.periode_id+'" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></a></span>';
										
									}
								},
								
							]
			
		});
	
		
</script>