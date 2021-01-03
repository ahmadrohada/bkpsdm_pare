<div class="box box-program div_program_list" hidden>
    <div class="box-header with-border">
		<h1 class="box-title">
            List Program
        </h1>
    </div>



	<div class="box-body table-responsive">

		<div class="toolbar">
		
		</div>
		<table id="program_table" class="table table-striped table-hover table-condensed" >
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

 
function load_program(sasaran_id){




$('#program_table').DataTable({
			destroy			: true,
			processing      : false,
			serverSide      : true,
			searching      	: false,
			paging          : false,
		columnDefs		: [
							{ className: "text-center", targets: [ 0 ] }
						  ],
		ajax			: {
							url	: '{{ url("api/skpd-renja_program_list") }}',
							data: { sasaran_id: sasaran_id },
						 }, 
		columns			:[
						{ data: 'program_id' , orderable: true,searchable:false,width:"30px",
								"render": function ( data, type, row ,meta) {
									return meta.row + meta.settings._iDisplayStart + 1 ;
								}
							},
						{ data: "label_program", name:"label_program", orderable: true, searchable: true},
						
					],
					initComplete: function(settings, json) {
						
						}
	
	
});	


}



</script>
