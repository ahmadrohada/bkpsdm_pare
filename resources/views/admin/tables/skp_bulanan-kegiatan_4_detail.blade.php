<div class="row">
	
	<div class="col-md-12">


<!--====================== KEGIATAN BULANAN LIST =========================================== -->
		<div class="box box-primary" id='kegiatan_bulanan' >
			<div class="box-header with-border">
				<h1 class="box-title">
					List Kegiatan Bulanan
				</h1>

				<div class="box-tools pull-right">
				
				</div>
			</div>
			<div class="box-body table-responsive">

				<div class="toolbar">

				</div>

				<table id="kegiatan_bulanan_table" class="table table-striped table-hover" >
					<thead>
						<tr>
							<th>No</th>
							<th>KEGIATAN BULANAN</th>
							<th>TARGET</th>
							<!-- <th><i class="fa fa-cog"></i></th> -->
						</tr>
					</thead>
							
				</table>

			</div>
		</div>

	</div>



	
</div>



<script type="text/javascript">



  function load_kegiatan_bulanan(){
		var table_skp_bulanan = $('#kegiatan_bulanan_table').DataTable({
				destroy			: true,
				processing      : false,
				serverSide      : true,
				searching      	: false,
				paging          : false,
				order 			    : [ 0 , 'asc' ],
				columnDefs		: [
									{ className: "text-center", targets: [ 0,2 ] }
								],
				ajax			: {
									url	: '{{ url("api_resource/kegiatan_bulanan_4") }}',
									data: { 
										
											"renja_id" 		 : {!! $skp->SKPTahunan->Renja->id !!} , 
											"jabatan_id" 	 : {!! $skp->PejabatYangDinilai->Jabatan->id !!},
											"skp_bulanan_id" : {!! $skp->id !!}
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
												return "<span class='text-danger'>"+row.rencana_aksi_label+' / '+row.kegiatan_tahunan_label+"</span>";
											}else{
												return row.kegiatan_bulanan_label+' / '+row.kegiatan_tahunan_label;
											}
										}
									},
									{ data: "target", name:"target", width:"140px",
										"render": function ( data, type, row ) {
											if ( (row.kegiatan_bulanan_id) <= 0 ){
												return "<span class='text-danger'>"+row.target+"</span>";
											}else{
												return row.target;
											}
										}
									}/* ,
									{  data: 'action',width:"40px",
											"render": function ( data, type, row ) {

											if ( row.status_skp != 1 ){
												if ( (row.kegiatan_bulanan_id) >= 1 ){
													return  '<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_kegiatan_bulanan"  data-id="'+row.kegiatan_bulanan_id+'" data-label="'+row.kegiatan_bulanan_label+'" ><i class="fa fa-close " ></i></a></span>';
												}else{

													if (row.rencana_aksi_target != "" ){
														return  '<span  data-toggle="tooltip" title="Add" style="margin:2px;" ><a class="btn btn-info btn-xs create_kegiatan_bulanan"  data-id="'+row.rencana_aksi_id+'" data-skp_bulanan_id="'+row.skp_bulanan_id+'"><i class="fa fa-plus" ></i></a></span>';
													}else{
														return  '<span style="margin:2px;" ><a class="btn btn-default btn-xs "><i class="fa fa-plus" ></i></a></span>';
													}
													
															
												
												}
											}else{ //SUDAH ADA CAPAIAN NYA
												return  '<span style="margin:2px;" ><a class="btn btn-default btn-xs " disabled><i class="fa fa-close " ></i></a></span>';
												
											}		
										
										}
									}, */
									
								
								],
								initComplete: function(settings, json) {
								
							}
		});	
	}

</script>
