<div class="box box-sasaran div_sasaran_list" hidden>
    <div class="box-header with-border">
		<h1 class="box-title">
            List Sasaran
        </h1>
    </div>
	<div class="box-body table-responsive">
		<div class="toolbar">
		</div>
		<table id="sasaran_table" class="table table-striped table-hover table-condensed" >
			<thead>
				<tr class="success">
					<th>NO</th>
					<th >LABEL</th>
				</tr>
			</thead>
			
		</table>

	</div>
</div>


<script type="text/javascript">


function load_sasaran(tujuan_id){




    $('#sasaran_table').DataTable({
				destroy			: true,
				processing      : false,
				serverSide      : true,
				searching      	: false,
				paging          : false,
			columnDefs		: [
								{ className: "text-center", targets: [ 0 ] }
							  ],
			ajax			: {
								url	: '{{ url("api_resource/skpd-renja_sasaran_list") }}',
								data: { tujuan_id: tujuan_id },
							 }, 
			columns			:[
							{ data: 'sasaran_id' , orderable: true,searchable:false,width:"30px",
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
							{ data: "label_sasaran", name:"label_sasaran", orderable: true, searchable: true},
							
						],
						initComplete: function(settings, json) {
							
   				 		}
		
		
	});	


}



</script>
