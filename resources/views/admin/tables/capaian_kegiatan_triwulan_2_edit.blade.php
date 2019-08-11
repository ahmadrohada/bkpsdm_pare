<div class="row">
	<div class="col-md-12">

<!--====================== KEGIATAN BULANAN LIST =========================================== -->
		<div class="box box-primary" id='kegiatan_triwulan'>
			<div class="box-header with-border">
				<h1 class="box-title">
					List Realisasi Kegiatan Tahunan Trimester I [Eselon III.b]
				</h1>

				<div class="box-tools pull-right">
				
				</div>
			</div>
			<div class="box-body table-responsive">

				<div class="toolbar">

				</div>

				<table id="realisasi_kegiatan_triwulan_table" class="table table-striped table-hover" >
					<thead>
						<tr>
							<th rowspan="2">No</th>
							<th rowspan="2">KEGIATAN TAHUNAN</th>
							<th colspan="3">OUTPUT</th>
							
							<th rowspan="2"><i class="fa fa-cog"></i></th>
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

	
	
  	function load_kegiatan_triwulan(){
		
		var table_kegiatan_triwulan = $('#realisasi_kegiatan_triwulan_table').DataTable({
				destroy			: true,
				processing      : false,
				serverSide      : true,
				searching      	: true,
				paging          : false,
				//order 			: [0 , 'asc' ],
				columnDefs		: [
									{ className: "text-center", targets: [ 0,2,3,4,5 ] }
								],
				ajax			: {
									url	: '{{ url("api_resource/realisasi_kegiatan_triwulan_2") }}',
									data: { 
										
											"renja_id" 			: {!! $capaian_triwulan->SKPTahunan->Renja->id !!} , 
											"jabatan_id" 		: {!! $capaian_triwulan->PejabatYangDinilai->Jabatan->id !!},
											"capaian_id" 		: {!! $capaian_triwulan->id !!}
									 },
								},
				columns			: [
									{ data: 'kegiatan_bulanan_id' ,width:"10px",
										"render": function ( data, type, row ,meta) {
											return meta.row + meta.settings._iDisplayStart + 1 ;
									}
									},
									{ data: "kegiatan_tahunan_label", name:"kegiatan_tahunan_label",
										"render": function ( data, type, row ) {
											return row.label;
											
										}
									}, 
									
									{ data: "target", name:"target", width:"130px",
										"render": function ( data, type, row ) {
										
											return row.output;
											
										}
									},
									
									
									{ data: "realisasi_rencana_aksi", name:"realisasi_rencana_aksi", width:"130px",
										"render": function ( data, type, row ) {
										
											return "";
										
											
										}
									},
									{ data: "persentasi_realisasi_rencana_aksi", name:"persentasi_realisasi_rencana_aksi", width:"80px",
										"render": function ( data, type, row ) {
											/* if ( (row.realisasi_rencana_aksi_id) <= 0 ){
												return "<p class='text-danger'>-</p>";
											}else{
												return row.persentasi_realisasi_rencana_aksi;
											} */
										}
									},
									{  data: 'action',width:"40px",
											"render": function ( data, type, row ) {
											
											if ( (row.realisasi_kegiatan_id) >= 1 ){
												return  '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_realisasi_rencana_aksi"  data-id="'+row.realisasi_rencana_aksi_id+'"><i class="fa fa-pencil" ></i></a></span>'+
														'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_realisasi_rencana_aksi"  data-id="'+row.realisasi_rencana_aksi_id+'" data-label="'+row.rencana_aksi_label+'" ><i class="fa fa-close " ></i></a></span>';
											}else{
												return  '<span  data-toggle="tooltip" title="Add" style="margin:2px;" ><a class="btn btn-info btn-xs create_realisasi_rencana_aksi"  data-id="'+row.rencana_aksi_id+'"><i class="fa fa-plus" ></i></a></span>'+
														'<span  style="margin:2px;" disabled><a class="btn btn-default btn-xs "  ><i class="fa fa-close " ></i></a></span>';
											
											} 
													
										
										}
									},
									
								
								],
								initComplete: function(settings, json) {
								
							}
		});	
	}



	

</script>
