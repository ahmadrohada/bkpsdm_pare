<div class="box box-primary div_kegiatan_list_pk" >
    <div class="box-header with-border">
		<h1 class="box-title">
            List Kegiatan 
        </h1>
    </div>
	<div class="box-body table-responsive">
		<div class="toolbar">

		</div>
		<table id="kegiatan_tahunan-kegiatan_table" class="table table-striped table-hover table-condensed" >
			<thead>
				<tr class="success">
					<th>NO</th>
					<th >LABEL</th>
					<th >PENGAWAS</th>
					<th >ANGGARAN</th>
				</tr>
			</thead>
			
		</table>
		<table id="kegiatan_tahunan-kegiatan_table_non_anggaran" class="table table-striped table-hover table-condensed" >
			<thead>
				<tr class="success">
					<th>NO</th>
					<th >LABEL / KEGIATAN NON ANGGARAN</th>
					<th >PENGAWAS</th>
					<!-- <th><i class="fa fa-cog"></i></th> -->
				</tr>
			</thead>
			
		</table>

	</div>
</div>


<script type="text/javascript">




    $('#kegiatan_tahunan-kegiatan_table').DataTable({
			destroy			: true,
			processing      : false,
			serverSide      : true,
			searching      	: false,
			paging          : false,
			columnDefs		: [
								{ className: "text-center", targets: [ 0,2] },
								{ className: "text-right", targets: [ 2 ] }
							  ],
			ajax			: {
								url	: '{{ url("api/pohon_kinerja-subkegiatan_list") }}',
								data: { 
										renja_id:{!! $renja->id !!}
									 },
							 }, 
			columns			:[
							{ data: 'kegiatan_id' , orderable: true,searchable:false,width:"30px",
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
							{ data: "label_kegiatan", name:"label_kegiatan", orderable: true, searchable: true,width:"290px"},
							{ data: "penanggung_jawab", name:"penanggung_jawab", orderable: true, searchable: true,
								"render": function ( data, type, row ,meta) {
									if ( (row.kegiatan_tahunan_id) <= 0 ){
											return "<p class='text-danger'>"+row.penanggung_jawab+"</p>" ;
										}else{
											return row.penanggung_jawab;
										}
									}
								
							
							},
							/* { data: "target_kegiatan", name:"target_kegiatan", orderable: true, searchable: true}, */
							{ data: "cost_kegiatan", name:"cost_kegiatan", orderable: true, searchable: true},
							
						],
						initComplete: function(settings, json) {
							
   				 		}
		
		
	});	

	$('#kegiatan_tahunan-kegiatan_table_non_anggaran').DataTable({
			destroy			: true,
			processing      : false,
			serverSide      : true,
			searching      	: false,
			paging          : false,
			columnDefs		: [
								{ className: "text-center", targets: [ 0 ] },
								//{ className: "text-right", targets: [ 2 ] }
							  ],
			ajax			: {
								url	: '{{ url("api/pohon_kinerja-subkegiatan_non_anggaran_list") }}',
								data: { 
										renja_id:{!! $renja->id !!}
									 },
							 }, 
			columns			:[
							{ data: 'kegiatan_id' , orderable: true,searchable:false,width:"30px",
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + ( row.jm_data + 1 )  ;
									}
								},
							{ data: "label_kegiatan", name:"label_kegiatan", orderable: true, searchable: true,width:"290px"},
							{ data: "penanggung_jawab", name:"penanggung_jawab", orderable: true, searchable: true,
								"render": function ( data, type, row ,meta) {
									if ( (row.kegiatan_tahunan_id) <= 0 ){
											return "<p class='text-danger'>"+row.penanggung_jawab+"</p>" ;
										}else{
											return row.penanggung_jawab;
										}
									}
								
							
							},
							
						/* 	{  data: 'action',width:"60px",
									"render": function ( data, type, row ) {
										return  '<span  data-toggle="tooltip" title="Edit" style="margin:1px;" ><a class="btn btn-success btn-xs edit_kegiatan"  data-id="'+row.kegiatan_id+'"><i class="fa fa-pencil" ></i></a></span>'+
												'<span  data-toggle="tooltip" title="Hapus" style="margin:1px;" ><a class="btn btn-danger btn-xs hapus_kegiatan"  data-id="'+row.kegiatan_id+'" data-label="'+row.label_kegiatan+'" ><i class="fa fa-close " ></i></a></span>';
											
									}
							}, */
						],
						initComplete: function(settings, json) {
							
   				 		}
		
		
	});	


</script>
