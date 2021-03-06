<div class="box-body table-responsive" >
	<div class="toolbar">
	</div>
	<table id="kegiatan_bulanan_table" class="table table-striped table-hover">
		<thead>
			<tr>
				<th>No</th>
				<th>KEGIATAN BULANAN</th>
				<th>TARGET</th>
				<th>PELAKSANA</th>
				<!-- <th><i class="fa fa-cog"></i></th> -->
			</tr>
		</thead>
	</table>
	<p class="text-danger" style="margin-top:20px;">
		**Kegiatan berwarna merah jika tidak dilaksanakan oleh staff
	</p>
</div>

<script type="text/javascript">


  	function LoadKegiatanBulananTable(){
		var table_skp_bulanan = $('#kegiatan_bulanan_table').DataTable({
				destroy			: true,
				processing      : true,
				serverSide      : true,
				searching      	: true,
				paging          : true,
				autoWidth		: false,
				//lengthChange	: false,
				order 			: [ 0 , 'asc' ],
				lengthMenu		: [10,20,50,100,200],
				columnDefs		: [
									{ className: "text-center", targets: [ 0,2] }
								],
				ajax			: {
									url	: '{{ url("api/kegiatan_bulanan_3") }}',
									data: { 
										
											"renja_id" 			: {!! $skp->SKPTahunan->Renja->id !!} , 
											"jabatan_id" 		: {!! $skp->PegawaiYangDinilai->Jabatan->id !!},
											"skp_bulanan_id" 	: {!! $skp->id !!}
									 },
								},
				columns			: [
									{ data: 'rencana_aksi_id' ,width:"30px",
										"render": function ( data, type, row ,meta) {
											return meta.row + meta.settings._iDisplayStart + 1 ;
									}
									},
									{ data: "label", name:"label",
										"render": function ( data, type, row ) {
											if ( (row.kegiatan_bulanan_id) <= 0 ){
												return "<span class='text-danger'>"+row.rencana_aksi_label+"</span>";
											}else{
												return row.kegiatan_bulanan_label;
											}
										}
									},
									
									{ data: "output", name:"output", width:"140px",
										"render": function ( data, type, row ) {
											if ( (row.kegiatan_bulanan_id) <= 0 ){
												return "<span class='text-danger'>"+row.rencana_aksi_target + ' '+ row.rencana_aksi_satuan+"</span>";
											}else{
												return row.rencana_aksi_target + ' '+ row.rencana_aksi_satuan;
											}
										}
									},
									{ data: "pelaksana", name:"pelaksana",
										"render": function ( data, type, row ) {
											if ( (row.kegiatan_bulanan_id) <= 0 ){
												return "<span class='text-danger'>"+row.pelaksana+"</span>";
											}else{
												return row.pelaksana;
											}
										}
									}
								],
								initComplete: function(settings, json) {
								
							}
		});	
	}
</script>
