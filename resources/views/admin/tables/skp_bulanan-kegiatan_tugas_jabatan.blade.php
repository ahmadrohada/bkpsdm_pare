
	<div class="box-body table-responsive">

        
		
		

		<table id="kegiatan_table" class="table table-striped table-hover" >
			<thead>
				<tr>
					<th rowspan="2">No</th>
					<th rowspan="2">KEGIATAN TUGAS JABATAN</th>
					<th rowspan="2">AK</th>
					<th colspan="4">TARGET</th>
				</tr>
				<tr>
					<th>OUTPUT</th>
					<th>MUTU</th>
					<th>WAKTU</th>
					<th>BIAYA</th>
				</tr>
			</thead>
			
		</table>

	</div>




<script type="text/javascript">
$(document).ready(function() {

	

    var table_program = $('#kegiatan_table').DataTable({
			processing      : false,
			serverSide      : true,
			searching      	: true,
			paging          : true,
			lengthMenu		: [20],
			order 			: [ 1 , 'asc' ],
			dom 			: '<"toolbar">frtip',
			columnDefs		: [
								{ className: "text-center", targets: [ 0,2,3,4,5 ] },
								{ className: "text-right", targets: [ 6 ] }
							  ],
			ajax			: {
								url	: '{{ url("api_resource/skp_bulanan_kegiatan_tugas_jabatan") }}',
								data: { skp_bulanan_id: {!! $skp->id !!} },
							  },
			columns			: [
								{ data: 'kegiatan_tugas_jabatan_id' , orderable: true,searchable:false,
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
								{ data: "label", name:"label", orderable: true, searchable: true},
								{ data: "ak", name:"ak", orderable: true, searchable: true},
								{ data: "output", name:"output", orderable: true, searchable: true},
								{ data: "mutu", name:"mutu", orderable: true, searchable: true},
								{ data: "waktu", name:"waktu", orderable: true, searchable: true},
								{ data: "biaya", name:"biaya", orderable: true, searchable: true},
								
							
						      ],
						initComplete: function(settings, json) {
							
   				 		}
		
	});	

	

});
</script>
