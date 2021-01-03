<div class="row">
	<div class="col-md-6">
		<div class="box box-primary" id='tugas_tambahan'>
			<div class="box-header with-border">
				<h1 class="box-title">
					Tugas Tambahan
				</h1>
				<div class="box-tools pull-right"></div>
			</div>
			<div class="box-body table-responsive">
				<div class="toolbar">
					
				</div>
				<table id="tugas_tambahan_table" class="table table-striped table-hover" style="%">
					<thead>
						<tr>
							<th>No</th>
							<th>LABEL</th>
							<th>NILAI</th>
						</tr>
					</thead>	
				</table>
			</div>
		</div>
	</div>

	<div class="col-md-6">
		<div class="box box-primary" id='kreativitas'>
			<div class="box-header with-border">
				<h1 class="box-title">
					Kreativitas
				</h1>
				<div class="box-tools pull-right"></div>
			</div>
			<div class="box-body table-responsive">
				<div class="toolbar">
					
				</div>
				<table id="kreativitas_table" class="table table-striped table-hover" style="%">
					<thead>
						<tr>
							<th>No</th>
							<th>LABEL</th>
							<th>MANFAAT</th>
							<th>NILAI</th>
						</tr>
					</thead>	
				</table>
			</div>
		</div>
	</div>

	
</div>

<script type="text/javascript">

  	function load_tugas_tambahan(){
		var table_tugas_tambahan = $('#tugas_tambahan_table').DataTable({ 
				destroy			: true,
				processing      : false,
				serverSide      : true,
				searching      	: false,
				paging          : false,
				bInfo			: false,
				//targets			: 'no-sort',
				bSort			: false,
				columnDefs		: [
									{ className: "text-center", targets: [ 0,2 ] },
									{ className: "hide", targets: [  ] },
								  ],
				ajax			: {
									url	: '{{ url("api/tugas_tambahan_list") }}',
									data: { capaian_tahunan_id : {!! $capaian->id !!} },
								  },
				columns			: [
									{ data: 'tugas_tambahan_id' ,width:"30px",
										"render": function ( data, type, row ,meta) {
											return meta.row + meta.settings._iDisplayStart + 1 ;
									}
									},
									{ data: "tugas_tambahan_label", name:"tugas_tambahan_label",
										"render": function ( data, type, row ) {
											return row.tugas_tambahan_label;
											
										}
									},
									{ data: "tugas_tambahan_nilai", name:"tugas_tambahan_nilai",width:"70px",
										"render": function ( data, type, row ) {
											return row.tugas_tambahan_nilai;
											
										}
									},
									
									
								
								],
								initComplete: function(settings, json) {
								
								}		
		});
	}


	function load_kreativitas(){
		var table_kreativitas = $('#kreativitas_table').DataTable({ 
				destroy			: true,
				processing      : false,
				serverSide      : true,
				searching      	: false,
				paging          : false,
				bInfo			: false,
				//targets		: 'no-sort',
				bSort			: false,
				columnDefs		: [
									{ className: "text-center", targets: [ 0,3] },
									{ className: "hide", targets: [  ] },
								  ],
				ajax			: {
									url	: '{{ url("api/kreativitas_list") }}',
									data: { capaian_tahunan_id : {!! $capaian->id !!} },
								  },
				columns			: [
									{ data: 'kreativitas_id' ,width:"30px",
										"render": function ( data, type, row ,meta) {
											return meta.row + meta.settings._iDisplayStart + 1 ;
									}
									},
									{ data: "kreativitas_label", name:"kreativitas_label",
										"render": function ( data, type, row ) {
											
											return row.kreativitas_label;
											
										}
									},
									{ data: "kreativitas_manfaat", name:"kreativitas_manfaat",width:"140px",
										"render": function ( data, type, row ) {
											
											return row.kreativitas_manfaat;
											
										}
									},
									{ data: "kreativitas_nilai", name:"kreativitas_nilai",width:"70px",
										"render": function ( data, type, row ) {
											
											return row.kreativitas_nilai;
											
										}
									},
									
								
								],
								initComplete: function(settings, json) {
								
								}		
		});

	}


	
</script>
