<div class="row">
	<div class="col-md-12">

<!--====================== KEGIATAN BULANAN LIST =========================================== -->
		<div class="box box-primary" id='kegiatan_bulanan'>
			<div class="box-header with-border">
				<h1 class="box-title">
					List Capaian Kegiatan Bulanan
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
							<th rowspan="2">KEGIATAN BULANAN</th>
							<th colspan="3">OUTPUT</th>
							<th rowspan="2"><i class="fa fa-cog"></i></th>
						</tr>
						<tr>
							<th>TARGET</th>
							<th>CAPAIAN</th>
							<th>BUKTI</th>
						</tr>
					</thead>
							
				</table>

			</div>
		</div>

	</div>



	
</div>

@include('admin.modals.capaian_kegiatan_bulanan')

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
									{ className: "text-center", targets: [ 0,2,3,4,5 ] }
								],
				ajax			: {
									url	: '{{ url("api_resource/capaian_kegiatan_bulanan_4") }}',
									data: { 
										
											"renja_id" 			: {!! $capaian->SKPBulanan->SKPTahunan->Renja->id !!} , 
											"jabatan_id" 		: {!! $capaian->PejabatYangDinilai->Jabatan->id !!},
											"skp_bulanan_id" 	: {!! $capaian->SKPBulanan->id !!},
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
											if ( (row.capaian_kegiatan_bulanan_id) <= 0 ){
												return "<p class='text-danger'>"+row.kegiatan_bulanan_label+' / '+row.kegiatan_tahunan_label+"</p>";
											}else{
												return row.kegiatan_bulanan_label+' / '+row.kegiatan_tahunan_label;
											}
										}
									},
									{ data: "output", name:"output", width:"140px",
										"render": function ( data, type, row ) {
											if ( (row.capaian_kegiatan_bulanan_id) <= 0 ){
												return "<p class='text-danger'>"+row.target + ' '+ row.satuan+"</p>";
											}else{
												return row.target + ' '+ row.satuan;
											}
										}
									},
									{ data: "capaian", name:"capaian", width:"140px",
										"render": function ( data, type, row ) {
											if ( (row.capaian_kegiatan_bulanan_id) <= 0 ){
												return "<p class='text-danger'>-</p>";
											}else{
												return row.capaian_target + ' '+ row.capaian_satuan;
											}
										}
									},
									{ data: "bukti", name:"bukti", width:"140px",
										"render": function ( data, type, row ) {
											if ( (row.capaian_kegiatan_bulanan_id) <= 0 ){
												return "<p class='text-danger'>-</p>";
											}else{
												return row.bukti;
											}
										}
									},
									{  data: 'action',width:"40px",
											"render": function ( data, type, row ) {

											if ( (row.capaian_kegiatan_bulanan_id) >= 1 ){
												return  '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_capaian_kegiatan_bulanan"  data-id="'+row.capaian_kegiatan_bulanan_id+'"><i class="fa fa-pencil" ></i></a></span>'+
														'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_capaian_kegiatan_bulanan"  data-id="'+row.capaian_kegiatan_bulanan_id+'" data-label="'+row.kegiatan_bulanan_label+'" ><i class="fa fa-close " ></i></a></span>';
											}else{
												return  '<span  data-toggle="tooltip" title="Add" style="margin:2px;" ><a class="btn btn-info btn-xs create_capaian_kegiatan_bulanan"  data-id="'+row.kegiatan_bulanan_id+'"><i class="fa fa-plus" ></i></a></span>'+
														'<span  style="margin:2px;" disabled><a class="btn btn-default btn-xs "  ><i class="fa fa-close " ></i></a></span>';
											
											}
													
										
										}
									},
									
								
								],
								initComplete: function(settings, json) {
								
							}
		});	
	}



	$(document).on('click','.create_capaian_kegiatan_bulanan',function(e){
	
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
					$('.modal-capaian_kegiatan_bulanan').find('[name=kegiatan_bulanan_id]').val(data['id']);
					$('.modal-capaian_kegiatan_bulanan').find('[name=skp_bulanan_id]').val(data['skp_bulanan_id']);
					$('.modal-capaian_kegiatan_bulanan').find('[name=capaian_id]').val({!! $capaian->id !!});
					$('.modal-capaian_kegiatan_bulanan').find('[name=satuan]').val(data['kegiatan_bulanan_satuan']);

					$('.modal-capaian_kegiatan_bulanan').find('.kegiatan_tahunan_label').html(data['kegiatan_tahunan_label']);
					$('.modal-capaian_kegiatan_bulanan').find('.penanggung_jawab').html(data['penanggung_jawab']);
					$('.modal-capaian_kegiatan_bulanan').find('.kegiatan_tahunan_output').html(data['kegiatan_tahunan_output']);
					$('.modal-capaian_kegiatan_bulanan').find('.kegiatan_tahunan_waktu').html(data['kegiatan_tahunan_waktu']+' bulan');
					$('.modal-capaian_kegiatan_bulanan').find('.kegiatan_tahunan_cost').html('Rp. '+data['kegiatan_tahunan_cost']);

					$('.modal-capaian_kegiatan_bulanan').find('.kegiatan_bulanan_label').html(data['kegiatan_bulanan_label']);
					$('.modal-capaian_kegiatan_bulanan').find('.pelaksana').html(data['pelaksana']);
					$('.modal-capaian_kegiatan_bulanan').find('.kegiatan_bulanan_output').html(data['kegiatan_bulanan_output']);
					$('.modal-capaian_kegiatan_bulanan').find('.kegiatan_bulanan_satuan').html(data['kegiatan_bulanan_satuan']);

					$('.modal-capaian_kegiatan_bulanan').find('h4').html('Create Capaian Kegiatan Bulanan');
					$('.modal-capaian_kegiatan_bulanan').find('.btn-submit').attr('id', 'submit-save');
					$('.modal-capaian_kegiatan_bulanan').find('[name=text_button_submit]').html('Simpan Data');
					$('.modal-capaian_kegiatan_bulanan').modal('show'); 
				},
				error: function(data){
					
				}						
		});	

		
	}


	$(document).on('click','.edit_capaian_kegiatan_bulanan',function(e){
	
		var capaian_kegiatan_bulanan_id = $(this).data('id');
		$.ajax({
				url			  	: '{{ url("api_resource/capaian_kegiatan_bulanan_detail") }}',
				data 		  	: {capaian_kegiatan_bulanan_id : capaian_kegiatan_bulanan_id},
				method			: "GET",
				dataType		: "json",
				success	: function(data) {

					$('.modal-capaian_kegiatan_bulanan').find('[name=capaian_kegiatan_bulanan_id]').val(data['capaian_kegiatan_id']);
					$('.modal-capaian_kegiatan_bulanan').find('[name=skp_bulanan_id]').val(data['skp_bulanan_id']);
					$('.modal-capaian_kegiatan_bulanan').find('[name=capaian_id]').val({!! $capaian->id !!});
					$('.modal-capaian_kegiatan_bulanan').find('[name=satuan]').val(data['kegiatan_bulanan_satuan']);
					$('.modal-capaian_kegiatan_bulanan').find('[name=capaian_target]').val(data['capaian_target']);

					$('.modal-capaian_kegiatan_bulanan').find('.kegiatan_tahunan_label').html(data['kegiatan_tahunan_label']);
					$('.modal-capaian_kegiatan_bulanan').find('.penanggung_jawab').html(data['penanggung_jawab']);
					$('.modal-capaian_kegiatan_bulanan').find('.kegiatan_tahunan_output').html(data['kegiatan_tahunan_output']);
					$('.modal-capaian_kegiatan_bulanan').find('.kegiatan_tahunan_waktu').html(data['kegiatan_tahunan_waktu']+' bulan');
					$('.modal-capaian_kegiatan_bulanan').find('.kegiatan_tahunan_cost').html('Rp. '+data['kegiatan_tahunan_cost']);

					$('.modal-capaian_kegiatan_bulanan').find('.kegiatan_bulanan_label').html(data['kegiatan_bulanan_label']);
					$('.modal-capaian_kegiatan_bulanan').find('.pelaksana').html(data['pelaksana']);
					$('.modal-capaian_kegiatan_bulanan').find('.kegiatan_bulanan_output').html(data['kegiatan_bulanan_output']);
					$('.modal-capaian_kegiatan_bulanan').find('.kegiatan_bulanan_satuan').html(data['kegiatan_bulanan_satuan']);

					$('.modal-capaian_kegiatan_bulanan').find('h4').html('Edit Capaian Kegiatan Bulanan');
					$('.modal-capaian_kegiatan_bulanan').find('.btn-submit').attr('id', 'submit-update');
					$('.modal-capaian_kegiatan_bulanan').find('[name=text_button_submit]').html('Update Data');
					$('.modal-capaian_kegiatan_bulanan').modal('show'); 
				},
				error: function(data){
					
				}						
		});	
		

	});

	$(document).on('click','.hapus_capaian_kegiatan_bulanan',function(e){
		var capaian_kegiatan_bulanan_id = $(this).data('id') ;
		//alert(kegiatan_bulanan_id);

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
					url		: '{{ url("api_resource/hapus_capaian_kegiatan_bulanan") }}',
					type	: 'POST',
					data    : {capaian_kegiatan_bulanan_id:capaian_kegiatan_bulanan_id},
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
