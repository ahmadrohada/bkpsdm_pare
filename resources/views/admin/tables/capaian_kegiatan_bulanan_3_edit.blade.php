<div class="row">
	<div class="col-md-12">

<!--====================== KEGIATAN BULANAN LIST =========================================== -->
		<div class="box box-primary" id='kegiatan_bulanan'>
			<div class="box-header with-border">
				<h1 class="box-title">
					List Capaian Rencana Aksi Eselon IV.a
				</h1>

				<div class="box-tools pull-right">
				
				</div>
			</div>
			<div class="box-body table-responsive">

				<div class="toolbar">

				</div>

				<table id="capaian_kegiatan_bulanan_table" class="table table-striped table-hover" >
					<thead>
						<tr>
							<th rowspan="2">No</th>
							<th rowspan="2">RENCANA AKSI / KEGIATAN TAHUNAN</th>
							<th rowspan="2">TARGET TAHUNAN</th>
							<th colspan="3">KEGIATAN BULANAN</th>
							<th rowspan="2">CAPAIAN</th>
							<th rowspan="2"><i class="fa fa-cog"></i></th>
						</tr>
						<tr>
							<th>PELAKSANA</th>
							<th>TARGET</th>
							<th>CAPAIAN</th>
						</tr>
					</thead>
							
				</table>

			</div>
		</div>

	</div>



	
</div>

@include('admin.modals.capaian_rencana_aksi')

<script type="text/javascript">

	
	
  	function load_kegiatan_bulanan(){
		
		var table_skp_bulanan = $('#capaian_kegiatan_bulanan_table').DataTable({
				destroy			: true,
				processing      : false,
				serverSide      : true,
				searching      	: false,
				paging          : false,
				order 			: [0 , 'asc' ],
				columnDefs		: [
									{ className: "text-center", targets: [ 0,2,3,4,5,6,7 ] }
								],
				ajax			: {
									url	: '{{ url("api_resource/capaian_kegiatan_bulanan_3") }}',
									data: { 
										
											"renja_id" 			: {!! $capaian->SKPBulanan->SKPTahunan->Renja->id !!} , 
											"jabatan_id" 		: {!! $capaian->PejabatYangDinilai->Jabatan->id !!},
											"skp_bulanan_id" 	: {!! $capaian->SKPBulanan->id !!},
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
											if ( (row.capaian_rencana_aksi_id) <= 0 ){
												return "<p class='text-danger'>"+row.rencana_aksi_label+' / '+row.kegiatan_tahunan_label+"</p>";
											}else{
												return row.rencana_aksi_label+' / '+row.kegiatan_tahunan_label;
											}
										}
									}, 
									{ data: "output", name:"output",
										"render": function ( data, type, row ) {
											if ( (row.capaian_rencana_aksi_id) <= 0 ){
												return "<p class='text-danger'>"+row.target + ' '+ row.satuan+"</p>";
											}else{
												return row.target + ' '+ row.satuan;
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
									{ data: "target_pelaksana", name:"target_pelaksana", width:"80px",
										"render": function ( data, type, row ) {
											//jika tidak dilaksanakan oleh pelaksana
											if ( row.kegiatan_bulanan_id === null){
												return "<p class='text-muted'>-</p>";
											}else{
												if ( (row.capaian_kegiatan_bulanan_id) <= 0 ){
													return "<p class='text-danger'>"+row.target_pelaksana+" "+row.satuan_pelaksana+"</p>";
												}else{
													return row.target_pelaksana+" "+row.satuan_pelaksana;
												}
											}
											
										}
									},
									
									
									{ data: "capaian", name:"capaian", width:"80px",
										"render": function ( data, type, row ) {
											if ( (row.capaian_kegiatan_bulanan_id) <= 0 ){
												return "<p class='text-danger'>-</p>";
											}else{
												return "<p class='text-danger'>"+ row.capaian_target + ' '+ row.capaian_satuan+"</p>";
											}

											
										}
									},
									{ data: "capaian_rencana_aksi_target", name:"capaian_rencana_aksi_target", width:"80px",
										"render": function ( data, type, row ) {
											if ( (row.capaian_rencana_aksi_id) <= 0 ){
												return "<p class='text-danger'>-</p>";
											}else{
												return row.capaian_rencana_aksi_target + ' '+ row.capaian_rencana_aksi_satuan;
											}
										}
									},
									{  data: 'action',width:"40px",
											"render": function ( data, type, row ) {
											
											if ( (row.capaian_rencana_aksi_id) >= 1 ){
												return  '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_capaian_rencana_aksi"  data-id="'+row.capaian_rencana_aksi_id+'"><i class="fa fa-pencil" ></i></a></span>'+
														'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_capaian_rencana_aksi"  data-id="'+row.capaian_rencana_aksi_id+'" data-label="'+row.rencana_aksi_label+'" ><i class="fa fa-close " ></i></a></span>';
											}else{
												return  '<span  data-toggle="tooltip" title="Add" style="margin:2px;" ><a class="btn btn-info btn-xs create_capaian_rencana_aksi"  data-id="'+row.rencana_aksi_id+'"><i class="fa fa-plus" ></i></a></span>'+
														'<span  style="margin:2px;" disabled><a class="btn btn-default btn-xs "  ><i class="fa fa-close " ></i></a></span>';
											
											} 
													
										
										}
									},
									
								
								],
								initComplete: function(settings, json) {
								
							}
		});	
	}



	$(document).on('click','.create_capaian_rencana_aksi',function(e){
	
		var rencana_aksi_id = $(this).data('id');
		show_modal_create(rencana_aksi_id);

	});

	function show_modal_create(rencana_aksi_id){
		$.ajax({
				url			  : '{{ url("api_resource/rencana_aksi_detail") }}',
				data 		  : {rencana_aksi_id : rencana_aksi_id},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					$('.modal-capaian_rencana_aksi').find('[name=rencana_aksi_id]').val(data['id']);
					$('.modal-capaian_rencana_aksi').find('[name=skp_bulanan_id]').val(data['skp_bulanan_id']);
					$('.modal-capaian_rencana_aksi').find('[name=capaian_id]').val({!! $capaian->id !!});
					$('.modal-capaian_rencana_aksi').find('[name=satuan]').val(data['kegiatan_bulanan_satuan']);

					$('.modal-capaian_rencana_aksi').find('.kegiatan_tahunan_label').html(data['kegiatan_tahunan_label']);
					$('.modal-capaian_rencana_aksi').find('.penanggung_jawab').html(data['penanggung_jawab']);
					$('.modal-capaian_rencana_aksi').find('.kegiatan_tahunan_output').html(data['kegiatan_tahunan_output']);
					$('.modal-capaian_rencana_aksi').find('.kegiatan_tahunan_waktu').html(data['kegiatan_tahunan_waktu']+' bulan');
					$('.modal-capaian_rencana_aksi').find('.kegiatan_tahunan_cost').html('Rp. '+data['kegiatan_tahunan_cost']);

					$('.modal-capaian_rencana_aksi').find('.kegiatan_bulanan_label').html(data['kegiatan_bulanan_label']);
					$('.modal-capaian_rencana_aksi').find('.pelaksana').html(data['pelaksana']);
					$('.modal-capaian_rencana_aksi').find('.kegiatan_bulanan_output').html(data['kegiatan_bulanan_output']);
					$('.modal-capaian_rencana_aksi').find('.kegiatan_bulanan_satuan').html(data['kegiatan_bulanan_satuan']);
					$('.modal-capaian_rencana_aksi').find('.capaian_kegiatan_bulanan_output').html(data['capaian_output']);

					$('.modal-capaian_rencana_aksi').find('h4').html('Create Capaian Kegiatan Bulanan');
					$('.modal-capaian_rencana_aksi').find('.btn-submit').attr('id', 'submit-save');
					$('.modal-capaian_rencana_aksi').find('[name=text_button_submit]').html('Simpan Data');
					$('.modal-capaian_rencana_aksi').modal('show'); 
				},
				error: function(data){
					
				}						
		});	

		
	}


	$(document).on('click','.edit_capaian_rencana_aksi',function(e){
	
		var capaian_rencana_aksi_id = $(this).data('id');
		$.ajax({
				url			  	: '{{ url("api_resource/capaian_rencana_aksi_detail") }}',
				data 		  	: {capaian_rencana_aksi_id : capaian_rencana_aksi_id},
				method			: "GET",
				dataType		: "json",
				success	: function(data) {

					$('.modal-capaian_rencana_aksi').find('[name=capaian_rencana_aksi_id]').val(data['capaian_rencana_aksi_id']);
					$('.modal-capaian_rencana_aksi').find('[name=skp_bulanan_id]').val(data['skp_bulanan_id']);
					$('.modal-capaian_rencana_aksi').find('[name=capaian_id]').val({!! $capaian->id !!});
					$('.modal-capaian_rencana_aksi').find('[name=satuan]').val(data['capaian_rencana_aksi_satuan']);
					$('.modal-capaian_rencana_aksi').find('[name=capaian_target]').val(data['capaian_rencana_aksi_target']);

					$('.modal-capaian_rencana_aksi').find('.kegiatan_tahunan_label').html(data['kegiatan_tahunan_label']);
					$('.modal-capaian_rencana_aksi').find('.penanggung_jawab').html(data['penanggung_jawab']);
					$('.modal-capaian_rencana_aksi').find('.kegiatan_tahunan_output').html(data['kegiatan_tahunan_output']);
					$('.modal-capaian_rencana_aksi').find('.kegiatan_tahunan_waktu').html(data['kegiatan_tahunan_waktu']+' bulan');
					$('.modal-capaian_rencana_aksi').find('.kegiatan_tahunan_cost').html('Rp. '+data['kegiatan_tahunan_cost']);

					$('.modal-capaian_rencana_aksi').find('.kegiatan_bulanan_label').html(data['kegiatan_bulanan_label']);
					$('.modal-capaian_rencana_aksi').find('.pelaksana').html(data['pelaksana']);
					$('.modal-capaian_rencana_aksi').find('.kegiatan_bulanan_output').html(data['kegiatan_bulanan_output']);
					$('.modal-capaian_rencana_aksi').find('.kegiatan_bulanan_satuan').html(data['kegiatan_bulanan_satuan']);

					$('.modal-capaian_rencana_aksi').find('h4').html('Edit Capaian Kegiatan Bulanan');
					$('.modal-capaian_rencana_aksi').find('.btn-submit').attr('id', 'submit-update');
					$('.modal-capaian_rencana_aksi').find('[name=text_button_submit]').html('Update Data');
					$('.modal-capaian_rencana_aksi').modal('show'); 
				},
				error: function(data){
					
				}						
		});	
		

	});

	$(document).on('click','.hapus_capaian_rencana_aksi',function(e){
		var capaian_rencana_aksi_id = $(this).data('id') ;
		//alert(rencana_aksi_id);

		Swal.fire({
			title: "Hapus  Capaian Kegiatan",
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
					url		: '{{ url("api_resource/hapus_capaian_rencana_aksi") }}',
					type	: 'POST',
					data    : {capaian_rencana_aksi_id:capaian_rencana_aksi_id},
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
										$('#capaian_kegiatan_bulanan_table').DataTable().ajax.reload(null,false);
										
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#capaian_kegiatan_bulanan_table').DataTable().ajax.reload(null,false);
											
											
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
