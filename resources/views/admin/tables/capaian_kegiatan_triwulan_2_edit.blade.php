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
							<th rowspan="2">PENANGGUNG JAWAB</th>
							<th colspan="2">OUTPUT</th>
							
							<th rowspan="2"><i class="fa fa-cog"></i></th>
						</tr>
						<tr>
							<th>TARGET</th>
							<th>REALISASI</th>
						</tr>
					</thead>
							
				</table>

			</div>
		</div>

	</div>



	
</div>

@include('admin.modals.realisasi_triwulan_kabid')

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
									{ "orderable": false, className: "text-center", targets: [ 0,2,4,5 ] }
								],
				ajax			: {
									url	: '{{ url("api_resource/realisasi_kegiatan_triwulan_2") }}',
									data: { 
										
											"renja_id" 			: {!! $capaian_triwulan->SKPTahunan->Renja->id !!} , 
											"jabatan_id" 		: {!! $capaian_triwulan->PejabatYangDinilai->Jabatan->id !!},
											"capaian_triwulan_id" 		: {!! $capaian_triwulan->id !!}
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
									{ data: "kegiatan_tahunan_label", name:"kegiatan_tahunan_label",
										"render": function ( data, type, row ) {
											return row.label;
											
										}
									}, 
									
									{ data: "target", name:"target", width:"350px",
										"render": function ( data, type, row ) {
										
											return '<i class="fa  fa-gg"></i> <span style="margin-right:10px;">'+row.ak+'</span>'+
													'<i class="fa fa-industry"></i> <span style="margin-right:10px;">'+row.output+'</span>'+
													'<i class="fa fa-hourglass-start"></i> <span style="margin-right:10px;">'+row.waktu+'</span>'+
													'<i class="fa fa-money"></i> <span style="margin-right:10px;">'+row.biaya+'</span>';
											
										}
									},
									
									
									{ data: "realisasi_triwulan", name:"realisasi_triwulan", width:"130px",
										"render": function ( data, type, row ) {
										
											return "";
										
											
										}
									},
									
									{  data: 'action',width:"40px",
											"render": function ( data, type, row ) {
											
											if ( (row.realisasi_kegiatan_id) >= 1 ){
												return  '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_realisasi_triwulan"  data-id="'+row.realisasi_triwulan_id+'"><i class="fa fa-pencil" ></i></a></span>'+
														'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_realisasi_triwulan"  data-id="'+row.realisasi_triwulan_id+'" data-label="'+row.triwulan_label+'" ><i class="fa fa-close " ></i></a></span>';
											}else{
												return  '<span  data-toggle="tooltip" title="Add" style="margin:2px;" ><a class="btn btn-info btn-xs create_realisasi_triwulan"  data-id="'+row.triwulan_id+'"><i class="fa fa-plus" ></i></a></span>'+
														'<span  style="margin:2px;" disabled><a class="btn btn-default btn-xs "  ><i class="fa fa-close " ></i></a></span>';
											
											} 
													
										
										}
									},
									
								
								],
								initComplete: function(settings, json) {
								
							}
		});	
	}

	$(document).on('click','.create_realisasi_triwulan',function(e){
	
		var triwulan_id = $(this).data('id');
		//show_modal_create(rencana_aksi_id);
		alert();
	});


	

</script>
