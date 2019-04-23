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

@include('admin.modals.realisasi_kegiatan_bulanan')

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
									{ className: "text-center", targets: [ 0,2,3,4,5 ] }
								],
				ajax			: {
									url	: '{{ url("api_resource/realisasi_kegiatan_bulanan_4") }}',
									data: { 
										
											"renja_id" 			: {!! $capaian->SKPBulanan->SKPTahunan->Renja->id !!} , 
											"jabatan_id" 		: {!! $capaian->PejabatYangDinilai->Jabatan->id !!},
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
									},
									{  data: 'action',width:"40px",
											"render": function ( data, type, row ) {

											if ( (row.realisasi_kegiatan_bulanan_id) >= 1 ){
												return  '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_realisasi_kegiatan_bulanan"  data-id="'+row.realisasi_kegiatan_bulanan_id+'"><i class="fa fa-pencil" ></i></a></span>'+
														'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_realisasi_kegiatan_bulanan"  data-id="'+row.realisasi_kegiatan_bulanan_id+'" data-label="'+row.kegiatan_bulanan_label+'" ><i class="fa fa-close " ></i></a></span>';
											}else{
												return  '<span  data-toggle="tooltip" title="Add" style="margin:2px;" ><a class="btn btn-info btn-xs create_realisasi_kegiatan_bulanan"  data-id="'+row.kegiatan_bulanan_id+'"><i class="fa fa-plus" ></i></a></span>'+
														'<span  style="margin:2px;" disabled><a class="btn btn-default btn-xs "  ><i class="fa fa-close " ></i></a></span>';
											
											}
													
										
										}
									},
									
								
								],
								initComplete: function(settings, json) {
								
							}
		});	
	}



	$(document).on('click','.create_realisasi_kegiatan_bulanan',function(e){
	
		var kegiatan_bulanan_id = $(this).data('id');
		show_modal_create(kegiatan_bulanan_id);

	});

	function show_modal_create(kegiatan_bulanan_id){
		$.ajax({
				url			  : '{{ url("api_resource/kegiatan_bulanan_detail") }}',
				data 		  : {kegiatan_bulanan_id : kegiatan_bulanan_id},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					$('.modal-realisasi_kegiatan_bulanan').find('[name=kegiatan_bulanan_id]').val(data['id']);
					$('.modal-realisasi_kegiatan_bulanan').find('[name=skp_bulanan_id]').val(data['skp_bulanan_id']);
					$('.modal-realisasi_kegiatan_bulanan').find('[name=capaian_id]').val({!! $capaian->id !!});
					$('.modal-realisasi_kegiatan_bulanan').find('[name=satuan]').val(data['kegiatan_bulanan_satuan']);

					$('.modal-realisasi_kegiatan_bulanan').find('.kegiatan_tahunan_label').html(data['kegiatan_tahunan_label']);
					$('.modal-realisasi_kegiatan_bulanan').find('.penanggung_jawab').html(data['penanggung_jawab']);
					$('.modal-realisasi_kegiatan_bulanan').find('.kegiatan_tahunan_output').html(data['kegiatan_tahunan_output']);
					$('.modal-realisasi_kegiatan_bulanan').find('.kegiatan_tahunan_waktu').html(data['kegiatan_tahunan_waktu']+' bulan');
					$('.modal-realisasi_kegiatan_bulanan').find('.kegiatan_tahunan_cost').html('Rp. '+data['kegiatan_tahunan_cost']);

					$('.modal-realisasi_kegiatan_bulanan').find('.kegiatan_bulanan_label').html(data['kegiatan_bulanan_label']);
					$('.modal-realisasi_kegiatan_bulanan').find('.pelaksana').html(data['pelaksana']);
					$('.modal-realisasi_kegiatan_bulanan').find('.kegiatan_bulanan_output').html(data['kegiatan_bulanan_output']);
					$('.modal-realisasi_kegiatan_bulanan').find('.kegiatan_bulanan_satuan').html(data['kegiatan_bulanan_satuan']);
					$('.modal-realisasi_kegiatan_bulanan').find('.kegiatan_bulanan_target').html(data['kegiatan_bulanan_target']);

					$('.modal-realisasi_kegiatan_bulanan').find('h4').html('Add Realisasi Kegiatan Bulanan');
					$('.modal-realisasi_kegiatan_bulanan').find('.btn-submit').attr('id', 'submit-save');
					$('.modal-realisasi_kegiatan_bulanan').find('[name=text_button_submit]').html('Simpan Data');
					$('.modal-realisasi_kegiatan_bulanan').modal('show'); 
				},
				error: function(data){
					
				}						
		});	

		
	}


	$(document).on('click','.edit_realisasi_kegiatan_bulanan',function(e){
	
		var realisasi_kegiatan_bulanan_id = $(this).data('id');
		$.ajax({
				url			  	: '{{ url("api_resource/realisasi_kegiatan_bulanan_detail") }}',
				data 		  	: {realisasi_kegiatan_bulanan_id : realisasi_kegiatan_bulanan_id},
				method			: "GET",
				dataType		: "json",
				success	: function(data) {

					$('.modal-realisasi_kegiatan_bulanan').find('[name=realisasi_kegiatan_bulanan_id]').val(data['realisasi_kegiatan_bulanan_id']);
					$('.modal-realisasi_kegiatan_bulanan').find('[name=skp_bulanan_id]').val(data['skp_bulanan_id']);
					$('.modal-realisasi_kegiatan_bulanan').find('[name=capaian_id]').val({!! $capaian->id !!});
					$('.modal-realisasi_kegiatan_bulanan').find('[name=satuan]').val(data['kegiatan_bulanan_satuan']);
					$('.modal-realisasi_kegiatan_bulanan').find('[name=realisasi]').val(data['realisasi']);

					$('.modal-realisasi_kegiatan_bulanan').find('.kegiatan_tahunan_label').html(data['kegiatan_tahunan_label']);
					$('.modal-realisasi_kegiatan_bulanan').find('.penanggung_jawab').html(data['penanggung_jawab']);
					$('.modal-realisasi_kegiatan_bulanan').find('.kegiatan_tahunan_output').html(data['kegiatan_tahunan_output']);
					$('.modal-realisasi_kegiatan_bulanan').find('.kegiatan_tahunan_waktu').html(data['kegiatan_tahunan_waktu']+' bulan');
					$('.modal-realisasi_kegiatan_bulanan').find('.kegiatan_tahunan_cost').html('Rp. '+data['kegiatan_tahunan_cost']);

					$('.modal-realisasi_kegiatan_bulanan').find('.kegiatan_bulanan_label').html(data['kegiatan_bulanan_label']);
					$('.modal-realisasi_kegiatan_bulanan').find('.pelaksana').html(data['pelaksana']);
					$('.modal-realisasi_kegiatan_bulanan').find('.kegiatan_bulanan_output').html(data['kegiatan_bulanan_output']);
					$('.modal-realisasi_kegiatan_bulanan').find('.kegiatan_bulanan_satuan').html(data['kegiatan_bulanan_satuan']);
					$('.modal-realisasi_kegiatan_bulanan').find('.kegiatan_bulanan_target').html(data['kegiatan_bulanan_target']);
					
					$('.modal-realisasi_kegiatan_bulanan').find('h4').html('Edit Realisasi Kegiatan Bulanan');
					$('.modal-realisasi_kegiatan_bulanan').find('.btn-submit').attr('id', 'submit-update');
					$('.modal-realisasi_kegiatan_bulanan').find('[name=text_button_submit]').html('Update Data');
					$('.modal-realisasi_kegiatan_bulanan').modal('show'); 
				},
				error: function(data){
					
				}						
		});	
		

	});

	$(document).on('click','.hapus_realisasi_kegiatan_bulanan',function(e){
		var realisasi_kegiatan_bulanan_id = $(this).data('id') ;
		//alert(kegiatan_bulanan_id);

		Swal.fire({
			title: "Hapus  Realisasi",
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
					url		: '{{ url("api_resource/hapus_realisasi_kegiatan_bulanan") }}',
					type	: 'POST',
					data    : {realisasi_kegiatan_bulanan_id:realisasi_kegiatan_bulanan_id},
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
