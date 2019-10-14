<div class="row"> 
	<div class="col-md-12">

<!--====================== KEGIATAN BULANAN LIST =========================================== -->
		<div class="box box-primary" id='kegiatan_triwulan'>
			<div class="box-header with-border">
				<h1 class="box-title">
					List Realisasi Kegiatan Tahunan Trimester I [ Eselon {!! $capaian_triwulan->PejabatYangDinilai->Eselon->eselon !!} ]
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
							<th rowspan="2">PENGAWAS</th>
							<th colspan="2">TARGET</th>
							<th colspan="2">REALISASI</th>
							<th rowspan="2"><i class="fa fa-cog"></i></th>
						</tr>
						<tr>
							<th>QTY</th>
							<th>COST</th>
							<th>QTY</th>
							<th>COST</th>
						</tr>
					</thead>
							
				</table>

			</div>
		</div>

	</div>



	
</div>

@include('admin.modals.realisasi_triwulan_kegiatan_tahunan')

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
									{ "orderable": false, className: "text-center", targets: [ 0,3,5,7 ] },
									{ className: "text-right", targets: [ 4,6 ] },
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
									{ data: 'id' ,width:"10px",
										"render": function ( data, type, row ,meta) {
											return meta.row + meta.settings._iDisplayStart + 1 ;
									}
									},
									{ data: "kegiatan_tahunan_label", name:"kegiatan_tahunan_label",
										"render": function ( data, type, row ) {
											return row.label;
											
										}
									}, 
									{ data: "penanggung_jawab", name:"penanggung_jawab",
										"render": function ( data, type, row ) {
											return row.penanggung_jawab;
										}
									}, 
									
									{ data: "qty_target", name:"qty_target", width:"100px",
										"render": function ( data, type, row ) {
											return row.qty_target ;
										}
									},
									{ data: "cost_target", name:"cost_target", width:"100px",
										"render": function ( data, type, row ) {
											return row.cost_target ;
										}
									},
									
									{ data: "qty_realisasi", name:"qty_realisasi", width:"100px",
										"render": function ( data, type, row ) {
											if ( (row.realisasi_kegiatan_id) >= 1 ){
												return row.qty_realisasi ;
											}else{
												return  '-';
											
											} 

											
										}
									},
									{ data: "cost_realisasi", name:"cost_realisasi", width:"100px",
										"render": function ( data, type, row ) {
											if ( (row.realisasi_kegiatan_id) >= 1 ){
												return row.cost_realisasi ;
											}else{
												return  '-';
											
											} 
										}
									},
									{  data: 'action',width:"60px",
											"render": function ( data, type, row ) {
											
											if ( (row.realisasi_kegiatan_id) >= 1 ){
												if ( {!! $capaian_triwulan->status !!} == 1 ){
													return '<span style="margin:2px;" ><a class="btn btn-default btn-xs" ><i class="fa fa-pencil" ></i></a></span>';
												}else{
													return '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_realisasi_triwulan"  data-id="'+row.realisasi_kegiatan_id+'"><i class="fa fa-pencil" ></i></a></span>';
												}
												
														
											}else{
												if ( {!! $capaian_triwulan->status !!} == 1 ){
													return  '<span style="margin:2px;" ><a class="btn btn-default btn-xs"><i class="fa fa-plus" ></i></a></span>';
												
												}else{
													return  '<span  data-toggle="tooltip" title="Add" style="margin:2px;" ><a class="btn btn-info btn-xs create_realisasi_triwulan"  data-kegiatan_tahunan_id="'+row.kegiatan_tahunan_id+'"><i class="fa fa-plus" ></i></a></span>';
												
												}
														
											
											} 
													
										
										}
									},
									
								
								],
								initComplete: function(settings, json) {
								
							}
		});	
	}

	$(document).on('click','.create_realisasi_triwulan',function(e){
	
		var kegiatan_tahunan_id = $(this).data('kegiatan_tahunan_id');
		show_modal_create(kegiatan_tahunan_id);
		//alert(kegiatan_tahunan_id);
	});

	function show_modal_create(kegiatan_tahunan_id){
		$.ajax({
				url			  : '{{ url("api_resource/kegiatan_tahunan_detail") }}',
				data 		  : {kegiatan_tahunan_id : kegiatan_tahunan_id},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					$('.modal-realisasi_triwulan').find('[name=capaian_triwulan_id]').val({!! $capaian_triwulan->id !!});
					$('.modal-realisasi_triwulan').find('[name=kegiatan_tahunan_id]').val(data['id']);
					$('.modal-realisasi_triwulan').find('[name=satuan]').val(data['satuan_target_triwulan']);
					$('.modal-realisasi_triwulan').find('.satuan').val(data['satuan']);

					$('.modal-realisasi_triwulan').find('.kegiatan_tahunan_label').html(data['label']);
					$('.modal-realisasi_triwulan').find('.penanggung_jawab').html(data['pejabat']);
					
					$('.modal-realisasi_triwulan').find('.qty_satuan').html(data['satuan']);
					$('.modal-realisasi_triwulan').find('.qty_target').html(data['target']);
					$('.modal-realisasi_triwulan').find('.cost_target').html('Rp. '+data['cost']);

					$('.modal-realisasi_triwulan').find('h4').html('Add Realisasi Kegiatan Tahunan');
					$('.modal-realisasi_triwulan').find('.btn-submit').attr('id', 'submit-save');
					$('.modal-realisasi_triwulan').find('[name=text_button_submit]').html('Simpan Data');
					$('.modal-realisasi_triwulan').modal('show');  
				},
				error: function(data){
					
				}						
		});	

		
	}

	$(document).on('click','.edit_realisasi_triwulan',function(e){

		var realisasi_triwulan_kegiatan_tahunan_id = $(this).data('id');
		$.ajax({
				url			  	: '{{ url("api_resource/realisasi_triwulan_kegiatan_tahunan_detail") }}',
				data 		  	: { id : realisasi_triwulan_kegiatan_tahunan_id},
				method			: "GET",
				dataType		: "json",
				success	: function(data) {

					$('.modal-realisasi_triwulan').find('.realisasi_triwulan_id').val(data['id']);
					$('.modal-realisasi_triwulan').find('[name=capaian_triwulan_id]').val({!! $capaian_triwulan->id !!});
					$('.modal-realisasi_triwulan').find('[name=kegiatan_tahunan_id]').val(data['id']);
					$('.modal-realisasi_triwulan').find('.satuan').val(data['triwulan_satuan']);

					$('.modal-realisasi_triwulan').find('.kegiatan_tahunan_label').html(data['triwulan_label']);
					$('.modal-realisasi_triwulan').find('.penanggung_jawab').html(data['triwulan_pejabat']);
					
					$('.modal-realisasi_triwulan').find('.qty_satuan').html(data['triwulan_satuan']);
					$('.modal-realisasi_triwulan').find('.qty_target').html(data['triwulan_qty_target']);
					$('.modal-realisasi_triwulan').find('.cost_target').html(data['triwulan_cost_target']);

					$('.modal-realisasi_triwulan').find('.qty_realisasi').val(data['triwulan_qty_realisasi']);
					$('.modal-realisasi_triwulan').find('.cost_realisasi').val(data['triwulan_cost_realisasi']);


					$('.modal-realisasi_triwulan').find('h4').html('Edit Realisasi Kegiatan Tahunan');
					$('.modal-realisasi_triwulan').find('.btn-submit').attr('id', 'submit-update');
					$('.modal-realisasi_triwulan').find('[name=text_button_submit]').html('Update Data');
					$('.modal-realisasi_triwulan').modal('show');  
				},
				error: function(data){
					
				}						
		});	
		

	});

	

</script>
