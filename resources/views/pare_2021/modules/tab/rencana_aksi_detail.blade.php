<div class="box box-success">
    <div class="box-header with-border">
        <h1 class="box-title">
            Data Rencana Aksi

        <div class="box-tools pull-right">
       </div>
    </div>
	<div class="box-body table-responsive">

		<table id="renjs_rencana_aksi_table_list" class="table table-striped table-hover table-condensed">
			<thead>
				<tr class="success">
					<th>NO</th>
					<th>LABEL</th>
					<th>PELAKSANA</th>
					<th>TARGET</th>
					<th>PELAKSANAAN</th>
				</tr>
			</thead>
			
			
		</table>

	</div>
</div>


<script type="text/javascript">
	

		$('#renjs_rencana_aksi_table_list').DataTable({
				processing      : true,
				serverSide      : true,
				searching      	: true,
				paging          : false,
				//dom 			: '<"toolbar">frtip',
				lengthMenu		: [20,50,100],
				columnDefs		: [
									{ 	className: "text-center", targets: [ 0,3,4 ] }/* ,
									{	className: "hidden", targets: [5] } */
								],
				ajax			: {
									url	: '{{ url("api/renja_rencana_aksi") }}',
									data: { renja_id : {!! $renja->id !!} },
									delay:3000
								},
			

				columns	:[
								{ data: 'rencana_aksi_id' , orderable: true,searchable:false,width:"50px",
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
								{ data: "label" , name:"label", orderable: true, searchable: true},
								{ data: "pelaksana" , orderable: false, searchable: true,width:"290px"},
								{ data: "target" , orderable: false, searchable: false,width:"120px"},
								
								{ data: "waktu_pelaksanaan" , orderable: false, searchable: false,width:"120px"},
								
								
							]
			
		});
</script>
