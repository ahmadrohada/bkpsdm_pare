<div class="row">
	<div class="col-md-12">

<!--====================== KEGIATAN BULANAN LIST =========================================== -->
		<div class="box box-primary" id='kegiatan_bulanan'>
			<div class="box-header with-border">
				<h1 class="box-title">
					List Realisasi Rencana Aksi Eselon IV.a
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
							<th rowspan="2">RENCANA AKSI</th>
							<th rowspan="2">PELAKSANA</th>
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

@include('admin.modals.realisasi_rencana_aksi_kasubid')

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
									url	: '{{ url("api_resource/realisasi_kegiatan_bulanan_3") }}', 
									data: { 
										
											"renja_id" 			: {!! $capaian->SKPBulanan->SKPTahunan->Renja->id !!} , 
											"jabatan_id" 		: {!! $capaian->PejabatYangDinilai->Jabatan->id !!},
											"skp_bulanan_id" 	: {!! $capaian->SKPBulanan->id !!},
											"capaian_id" 		: {!! $capaian->id !!},
									 },
								},
				columns			: [
									{ data: 'kegiatan_bulanan_id' ,width:"10px",
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
									{  data: 'action',width:"40px",
											"render": function ( data, type, row ) {
											
											if ( (row.realisasi_rencana_aksi_id) >= 1 ){
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



	$(document).on('click','.create_realisasi_rencana_aksi',function(e){
	
		var rencana_aksi_id = $(this).data('id');


		show_modal_create(rencana_aksi_id);

	});

	function show_modal_create(rencana_aksi_id){
		$.ajax({
				url			  : '{{ url("api_resource/rencana_aksi_detail_3") }}',
				data 		  : {rencana_aksi_id : rencana_aksi_id},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					$('.modal-realisasi_rencana_aksi').find('[name=rencana_aksi_id]').val(data['id']);
					$('.modal-realisasi_rencana_aksi').find('[name=realisasi_rencana_aksi_id]').val("");
					$('.modal-realisasi_rencana_aksi').find('[name=skp_bulanan_id]').val(data['skp_bulanan_id']);
					$('.modal-realisasi_rencana_aksi').find('[name=capaian_id]').val({!! $capaian->id !!});
					$('.modal-realisasi_rencana_aksi').find('[name=satuan]').val(data['satuan_target_rencana_aksi']);

					$('.modal-realisasi_rencana_aksi').find('.kegiatan_tahunan_label').html(data['kegiatan_tahunan_label']);
					$('.modal-realisasi_rencana_aksi').find('.penanggung_jawab').html(data['penanggung_jawab']);
					$('.modal-realisasi_rencana_aksi').find('.kegiatan_tahunan_output').html(data['kegiatan_tahunan_output']);
					$('.modal-realisasi_rencana_aksi').find('.kegiatan_tahunan_waktu').html(data['kegiatan_tahunan_waktu']+' bulan');
					$('.modal-realisasi_rencana_aksi').find('.kegiatan_tahunan_cost').html('Rp. '+data['kegiatan_tahunan_cost']);

					$('.modal-realisasi_rencana_aksi').find('.kegiatan_bulanan_label').html(data['kegiatan_bulanan_label']);
					$('.modal-realisasi_rencana_aksi').find('.pelaksana').html(data['pelaksana']);
					$('.modal-realisasi_rencana_aksi').find('.kegiatan_bulanan_output').html(data['kegiatan_bulanan_output']);
					$('.modal-realisasi_rencana_aksi').find('.kegiatan_bulanan_satuan').html(data['kegiatan_bulanan_satuan']);
					$('.modal-realisasi_rencana_aksi').find('.realisasi_kegiatan_bulanan_output').html(data['realisasi_output']);

					$('.modal-realisasi_rencana_aksi').find('.satuan_target_rencana_aksi').html(data['satuan_target_rencana_aksi']);
					$('.modal-realisasi_rencana_aksi').find('.rencana_aksi_target').html(data['target_rencana_aksi']);

					$('.modal-realisasi_rencana_aksi').find('h4').html('Add Realisasi Rencana Aksi');
					$('.modal-realisasi_rencana_aksi').find('.btn-submit').attr('id', 'submit-save');
					$('.modal-realisasi_rencana_aksi').find('[name=text_button_submit]').html('Simpan Data');
					$('.modal-realisasi_rencana_aksi').modal('show'); 
				},
				error: function(data){
					
				}						
		});	

		
	}


	$(document).on('click','.edit_realisasi_rencana_aksi',function(e){
	
		var realisasi_rencana_aksi_id = $(this).data('id');
		$.ajax({
				url			  	: '{{ url("api_resource/realisasi_rencana_aksi_detail_3") }}',
				data 		  	: {realisasi_rencana_aksi_id : realisasi_rencana_aksi_id},
				method			: "GET",
				dataType		: "json",
				success	: function(data) {

					$('.modal-realisasi_rencana_aksi').find('[name=realisasi_rencana_aksi_id]').val(data['realisasi_rencana_aksi_id']);
					$('.modal-realisasi_rencana_aksi').find('[name=skp_bulanan_id]').val(data['skp_bulanan_id']);
					$('.modal-realisasi_rencana_aksi').find('[name=capaian_id]').val({!! $capaian->id !!});
					$('.modal-realisasi_rencana_aksi').find('[name=satuan]').val(data['realisasi_rencana_aksi_satuan']);
					$('.modal-realisasi_rencana_aksi').find('[name=realisasi]').val(data['realisasi_rencana_aksi_target']);

					$('.modal-realisasi_rencana_aksi').find('.kegiatan_tahunan_label').html(data['kegiatan_tahunan_label']);
					$('.modal-realisasi_rencana_aksi').find('.penanggung_jawab').html(data['penanggung_jawab']);
					$('.modal-realisasi_rencana_aksi').find('.kegiatan_tahunan_output').html(data['kegiatan_tahunan_output']);
					$('.modal-realisasi_rencana_aksi').find('.kegiatan_tahunan_waktu').html(data['kegiatan_tahunan_waktu']+' bulan');
					$('.modal-realisasi_rencana_aksi').find('.kegiatan_tahunan_cost').html('Rp. '+data['kegiatan_tahunan_cost']);

					$('.modal-realisasi_rencana_aksi').find('.kegiatan_bulanan_label').html(data['kegiatan_bulanan_label']);
					$('.modal-realisasi_rencana_aksi').find('.pelaksana').html(data['pelaksana']);
					$('.modal-realisasi_rencana_aksi').find('.kegiatan_bulanan_output').html(data['kegiatan_bulanan_output']);
					$('.modal-realisasi_rencana_aksi').find('.kegiatan_bulanan_satuan').html(data['kegiatan_bulanan_satuan']);

					$('.modal-realisasi_rencana_aksi').find('.satuan_target_rencana_aksi').html(data['realisasi_rencana_aksi_satuan']);
					$('.modal-realisasi_rencana_aksi').find('.rencana_aksi_target').html(data['target_rencana_aksi']);
					
					$('.modal-realisasi_rencana_aksi').find('h4').html('Edit Realisasi Rencana Aksi');
					$('.modal-realisasi_rencana_aksi').find('.btn-submit').attr('id', 'submit-update');
					$('.modal-realisasi_rencana_aksi').find('[name=text_button_submit]').html('Update Data');
					$('.modal-realisasi_rencana_aksi').modal('show'); 
				},
				error: function(data){
					
				}						
		});	
		

	});

	$(document).on('click','.hapus_realisasi_rencana_aksi',function(e){
		var realisasi_rencana_aksi_id = $(this).data('id') ;
		//alert(rencana_aksi_id);

		Swal.fire({
			title: "Hapus  realisasi Kegiatan",
			text:$(this).data('label'),
			type: "warning",
			//type: "question",
			showCancelButton: true,
			cancelButtonText: "Batal",
			confirmButtonText: "Hapus",
			confirmButtonClass: "btn btn-success",
			cancelButtonColor: "btn btn-danger",
			cancelButtonColor: "#d33",
			closeOnConfirm: false,
			closeOnCancel:false
		}).then ((result) => {
			if (result.value){
				$.ajax({
					url		: '{{ url("api_resource/hapus_realisasi_rencana_aksi_3") }}',
					type	: 'POST',
					data    : {realisasi_rencana_aksi_id:realisasi_rencana_aksi_id},
					cache   : false,
					success:function(data){
							Swal.fire({
									title: "",
									text: "Sukses",
									type: "success",
									width: "200px",
									showConfirmButton: false,
									allowOutsideClick : false,
									timer: 900
									}).then(function () {
										$('#realisasi_kegiatan_bulanan_table').DataTable().ajax.reload(null,false);
										
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#realisasi_kegiatan_bulanan_table').DataTable().ajax.reload(null,false);
											
											
										}
									}
								)
								
							
					},
					error: function(e) {
							Swal.fire({
									title: "Gagal",
									text: "",
									type: "warning"
								}).then (function(){
										
								});
							}
					});	
			}
		});
	});

</script>
