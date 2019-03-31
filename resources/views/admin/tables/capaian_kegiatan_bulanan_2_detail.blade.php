<div class="row">
	<div class="col-md-12">

<!--====================== KEGIATAN BULANAN LIST =========================================== -->
		<div class="box box-primary" id='kegiatan_bulanan'>
			<div class="box-header with-border">
				<h1 class="box-title">
					List realisasi Rencana Aksi Eselon III.b
				</h1>

				<div class="box-tools pull-right">
				
				</div>
			</div>
			<div class="box-body table-responsive">

				<div class="toolbar">

				</div>

				<table id="realisasi_kegiatan_bulanan_table" class="table table-striped table-hover" >
					<thead>
						<tr>
							<th rowspan="2">NO</th>
							<th rowspan="2">RENCANA AKSI</th>
							<th rowspan="2">PENANGGUNG JAWAB</th>
							<th rowspan="2">PELAKSANA</th>
							<th colspan="3">OUTPUT</th>
						</tr>
						<tr>
						
							<th>TARGET</th>
							<th>realisasi</th>
							<th>%</th>
						</tr>
					</thead>
							
				</table>

			</div>
		</div>

	</div>



	
</div>

<script type="text/javascript">

	
	
  	function load_kegiatan_bulanan(){
		
		var table_skp_bulanan = $('#realisasi_kegiatan_bulanan_table').DataTable({
				destroy			: true,
				processing      : false,
				serverSide      : true,
				searching      	: false,
				paging          : false,
				order 			: [0 , 'asc' ],
				columnDefs		: [
									{ className: "text-center", targets: [ 0,2,3,4,5,6 ] }
								],
				ajax			: {
									url	: '{{ url("api_resource/realisasi_kegiatan_bulanan_2") }}',
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
											if ( (row.rencana_aksi_id) <= 0 ){
												return "<p class='text-danger'>"+row.rencana_aksi_label+' / '+row.kegiatan_tahunan_label+"</p>";
											}else{
												return row.rencana_aksi_label+' / '+row.kegiatan_tahunan_label;
											}
										}
									}, 
									{ data: "penanggung_jawab", name:"penanggung_jawab",
										"render": function ( data, type, row ) {
											
											if ( (row.capaian_rencana_aksi_id) <= 0 ){
												return "<p class='text-danger'>"+row.penanggung_jawab;+"</p>";
											}else{
												return row.penanggung_jawab;
											} 
										}
									},
									{ data: "pelaksana", name:"pelaksana", width:"130px",
										"render": function ( data, type, row ) {
											//jika tidak dilaksanakan oleh pelaksana
											if ( row.kegiatan_bulanan_id === null){
												return "<p class='text-muted'>"+row.pelaksana+"</p>";
											}else{
												if ( (row.capaian_kegiatan_bulanan_id) <= 0 ){
													return "<p class='text-danger'>"+row.pelaksana+"</p>";
												}else{
													return row.pelaksana;
												}
											}
											
										}
									},
									{ data: "target", name:"target", width:"130px",
										"render": function ( data, type, row ) {
										
											if ( (row.capaian_kegiatan_bulanan_id) <= 0 ){
												return "<p class='text-danger'>"+row.target+" "+row.satuan_target+"</p>";
											}else{
												return row.target+" "+row.satuan_target;
											}
											
											
										}
									},
									
									
									{ data: "realisasi_kabid", name:"realisasi_kabid", width:"130px",
										"render": function ( data, type, row ) {
											if ( (row.realisasi_kabid_id) <= 0 ){
												return "<p class='text-danger'>-</p>";
											}else{
												return row.realisasi_kabid + ' '+ row.satuan_kabid;
											}

											
										}
									},
									{ data: "persentasi_realisasi_kabid", name:"persentasi_realisasi_kabid", width:"80px",
										"render": function ( data, type, row ) {
											if ( (row.realisasi_kabid_id) <= 0 ){
												return "<p class='text-danger'>-</p>";
											}else{
												return row.persentasi_realisasi_kabid;
											}
										}
									},
									
								
								],
								initComplete: function(settings, json) {
								
							}
		});	
	}

</script>
