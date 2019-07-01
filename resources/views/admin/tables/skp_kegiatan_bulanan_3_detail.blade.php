<div class="row">
	
	<div class="col-md-12">


	
<!--====================== KEGIATAN BULANAN LIST =========================================== -->
		<div class="box box-primary" id='kegiatan_bulanan' >
			
			<div class="box-body table-responsive">

				<div class="toolbar">
				
				</div>

				<table id="kegiatan_bulanan_table" class="table table-striped table-hover" >
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
		</div>

	</div>



	
</div>



<script type="text/javascript">





	
  function load_kegiatan_bulanan(){
		var table_skp_bulanan = $('#kegiatan_bulanan_table').DataTable({
				destroy			: true,
				processing      : false,
				serverSide      : true,
				searching      	: true,
				paging          : true,
				order 			: [ 0 , 'asc' ],
				columnDefs		: [
									{ className: "text-center", targets: [ 0,2] }
								],
				ajax			: {
									url	: '{{ url("api_resource/kegiatan_bulanan_3") }}',
									data: { 
										
											"renja_id" 			: {!! $skp->SKPTahunan->Renja->id !!} , 
											"jabatan_id" 		: {!! $skp->PejabatYangDinilai->Jabatan->id !!},
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
									}/* ,
									{  data: 'action',width:"40px",
											"render": function ( data, type, row ) {

											if ( row.status_skp != 1 ){
												if ( (row.kegiatan_bulanan_id) >= 1 ){
													//disabled jika sudah dilaksanakan/dia add pelaksana
													return  '<span style="margin:2px;" ><a class="btn btn-default btn-xs " disabled><i class="fa fa-plus" ></i></a></span>'+
														'<span style="margin:2px;" ><a class="btn btn-default btn-xs " disabled><i class="fa fa-close " ></i></a></span>';
												
												}else{
													return  '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_kegiatan_bulanan"  data-id="'+row.kegiatan_bulanan_id+'"><i class="fa fa-pencil" ></i></a></span>'+
															'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_kegiatan_bulanan"  data-id="'+row.kegiatan_bulanan_id+'" data-label="'+row.kegiatan_bulanan_label+'" ><i class="fa fa-close " ></i></a></span>';
											
												}
											}else{ //SUDAH ADA CAPAIAN NYA
												return  '<span style="margin:2px;" ><a class="btn btn-default btn-xs " disabled><i class="fa fa-plus" ></i></a></span>'+
														'<span style="margin:2px;" ><a class="btn btn-default btn-xs " disabled><i class="fa fa-close " ></i></a></span>';
												
											}		
										
										}
									}, */
									
								
								],
								initComplete: function(settings, json) {
								
							}
		});	
	}

	
	

</script>
