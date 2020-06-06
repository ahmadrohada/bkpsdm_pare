<div class="box-body table-responsive">
	<div class="toolbar">
	</div>
		<table id="realisasi_kegiatan_bulanan_table" class="table table-striped table-hover" >
			<thead>
				<tr>
					<th rowspan="2">No</th>
					<th rowspan="2">RENCANA AKSI</th>
					<th rowspan="2">PELAKSANA</th>
					<th colspan="3">OUTPUT</th>
				</tr>
				<tr>
					<th>TARGET</th>
					<th>REALISASI</th>
					<th>%</th>
				</tr>
			</thead>			
		</table>
	</div>
</div>

<script type="text/javascript">

	
	
  	function load_kegiatan_bulanan(){
		
		var table_skp_bulanan = $('#realisasi_kegiatan_bulanan_table').DataTable({
				destroy			: true,
				processing      : true,
				serverSide      : true,
				searching      	: true,
				paging          : true,
				autoWidth		: false,
				deferRender	: true,
				bInfo			: false,
				bSort			: false,
				lengthChange	: false,
				order 			: [ 0 , 'desc' ],
				lengthMenu		: [10,25,50],
				columnDefs		: [
									{ className: "text-center", targets: [ 0,2,3,4,5 ] }
								],
				ajax			: {
									url	: '{{ url("api_resource/realisasi_kegiatan_bulanan_3") }}',
									data: { 
										
											"renja_id" 			: {!! $capaian->SKPBulanan->SKPTahunan->Renja->id !!} , 
											"jabatan_id" 		: {!! $capaian->PejabatYangDinilai->Jabatan->id !!},
											"skp_bulanan_id" 	: {!! $capaian->SKPBulanan->id !!},
											"capaian_id" 		: {!! $capaian->id !!},
									 },
								},
				columns			: [
									{ data: 'rencana_aksi_id' ,width:"10px",
										"render": function ( data, type, row ,meta) {
											return meta.row + meta.settings._iDisplayStart + 1 ;
									}
									},
									{ data: "rencana_aksi_label", name:"rencana_aksi_label",
										"render": function ( data, type, row ) {
											if ( (row.realisasi_rencana_aksi_id) <= 0 ){
												return "<span class='text-danger'>"+row.rencana_aksi_label+' / '+row.kegiatan_tahunan_label+"</span>";
											}else{
												return row.rencana_aksi_label+' / '+row.kegiatan_tahunan_label;
											}
										}
									}, 
									{ data: "pelaksana", name:"pelaksana", width:"130px",
										"render": function ( data, type, row ) {
											//jika tidak dilaksanakan oleh pelaksana
											if ( row.kegiatan_bulanan_id === null){
												return "<p class='text-muted'>"+row.pelaksana+"</p>";
											}else{
												if ( (row.realisasi_kegiatan_bulanan_id) <= 0 ){
													return "<p class='text-danger'>"+row.pelaksana+"</p>";
												}else{
													return row.pelaksana;
												}
											}
											
										}
									},
									{ data: "rencana_aksi_target", name:"rencana_aksi_target", width:"130px",
										"render": function ( data, type, row ) {
											if ( (row.realisasi_rencana_aksi_id) <= 0 ){
												return "<p class='text-danger'>"+row.rencana_aksi_target + ' '+ row.rencana_aksi_satuan+"</p>";
											}else{
												return row.rencana_aksi_target + ' '+ row.rencana_aksi_satuan;
											}
										}
									},
									
									{ data: "realisasi_rencana_aksi", name:"realisasi_rencana_aksi", width:"130px",
										"render": function ( data, type, row ) {
											if ( (row.realisasi_rencana_aksi_id) <= 0 ){
												return "<p class='text-danger'>-</p>";
											}else{
												return row.realisasi_rencana_aksi + ' '+ row.satuan_rencana_aksi;
											}

											
										}
									},
									{ data: "persentasi_realisasi_rencana_aksi", name:"persentasi_realisasi_rencana_aksi", width:"80px",
										"render": function ( data, type, row ) {
											if ( (row.realisasi_rencana_aksi_id) <= 0 ){
												return "<p class='text-danger'>-</p>";
											}else{
												return row.persentasi_realisasi_rencana_aksi;
											}
										}
									},
									
									
								
								],
								initComplete: function(settings, json) {
								
							}
		});	
	}


</script>
