<div class="row">
	<div class="col-md-12">

<!--====================== KEGIATAN BULANAN LIST =========================================== -->
		<div class="box box-primary" id='kegiatan_bulanan'>
			<div class="box-header with-border">
				<h1 class="box-title">
					List Realisasi Kegiatan Bulanan
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
							<th rowspan="2">No</th>
							<th rowspan="2">KEGIATAN BULANAN</th>
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

	</div>



	
</div>

<script type="text/javascript">

	
	
  	function LoadKegiatanBulananTable(){
		
		var table_skp_bulanan = $('#realisasi_kegiatan_bulanan_table').DataTable({
				destroy			: true,
				processing      : false,
				serverSide      : true,
				searching      	: false,
				paging          : false,
				order 			: [0 , 'asc' ],
				columnDefs		: [
									{ className: "text-center", targets: [ 0,2,3,4 ] }
								],
				ajax			: {
									url	: '{{ url("api_resource/realisasi_kegiatan_bulanan_4") }}',
									data: { 
										
											"renja_id" 			: {!! $capaian->SKPBulanan->SKPTahunan->Renja->id !!} , 
											"jabatan_id" 		: {!! $capaian->PegawaiYangDinilai->Jabatan->id !!},
											"skp_bulanan_id" 	: {!! $capaian->SKPBulanan->id !!},
											"capaian_id" 		: {!! $capaian->id !!},
									 },
								},
				columns			: [
									{ data: 'kegiatan_bulanan_id' ,width:"30px",
										"render": function ( data, type, row ,meta) {
											return meta.row + meta.settings._iDisplayStart + 1 ;
									}
									},
									{ data: "label", name:"label",
										"render": function ( data, type, row ) {
											if ( (row.realisasi_kegiatan_bulanan_id) <= 0 ){
												return "<span class='text-danger'>"+row.kegiatan_bulanan_label+' / '+row.kegiatan_tahunan_label+"</span>";
											}else{
												return row.kegiatan_bulanan_label+' / '+row.kegiatan_tahunan_label;
											}
										}
									},
									{ data: "target", name:"target", width:"130px",
										"render": function ( data, type, row ) {
											if ( (row.realisasi_kegiatan_bulanan_id) <= 0 ){
												return "<span class='text-danger'>"+row.target + ' '+ row.satuan+"</span>";
											}else{
												return row.target + ' '+ row.satuan;
											}
										}
									},
									{ data: "realisasi", name:"realisasi", width:"130px",
										"render": function ( data, type, row ) {
											if ( (row.realisasi_kegiatan_bulanan_id) <= 0 ){
												return "<span class='text-danger'>-</span>";
											}else{
												return row.realisasi + ' '+ row.realisasi_satuan;
											}
										}
									},
									{ data: "persentase_realisasi", name:"persentase_realisasi", width:"80px",
										"render": function ( data, type, row ) {
											if ( (row.realisasi_kegiatan_bulanan_id) <= 0 ){
												return "<span class='text-danger'>-</span>";
											}else{
												return row.persentase_realisasi;
											}
										}
									}
									
								
								],
								initComplete: function(settings, json) {
								
							}
		});	
	}




</script>
