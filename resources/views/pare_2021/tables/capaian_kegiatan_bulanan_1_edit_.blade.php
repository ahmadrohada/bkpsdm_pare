<div class="row">
	<div class="col-md-12">

<!--====================== KEGIATAN BULANAN LIST =========================================== -->
		<div class="box box-primary" id='kegiatan_bulanan'>
			<div class="box-header with-border">
				<h1 class="box-title">
					List Realisasi Rencana Aksi Eselon II.b
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
							<th rowspan="2">NO</th>
							<th rowspan="2">RENCANA AKSI</th>
							<th rowspan="2">PENGAWAS</th>
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

@include('pare_pns.modals.realisasi_rencana_aksi_eselon2')

<script type="text/javascript">

	
	
  	function LoadKegiatanBulananTable(){ 
		
		var table_skp_bulanan = $('#realisasi_kegiatan_bulanan_table').DataTable({
				destroy			: true,
				processing      : false,
				serverSide      : true,
				searching      	: true,
				paging          : true,
				bInfo			: false,
				order 			: [0 , 'asc' ],
				columnDefs		: [
									{ className: "text-center", targets: [ 0,2,3,4,5,6,7 ] },
									{ bSortable: false, targets: [ "_all" ] }
								],
				ajax			: {
									url	: '{{ url("api_resource/realisasi_kegiatan_bulanan_1") }}',
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
									{ data: "rencana_aksi_label", name:"rencana_aksi_label"}, 
									{ data: "penanggung_jawab", name:"penanggung_jawab"},
									{ data: "pelaksana", name:"pelaksana", width:"130px"},
									{ data: "target_rencana_aksi", name:"target_rencana_aksi", width:"130px"},
									
									
									{ data: "realisasi_rencana_aksi", name:"realisasi_rencana_aksi", width:"130px"},
									{ data: "persentasi_realisasi_rencana_aksi", name:"persentasi_realisasi_rencana_aksi", width:"80px"},
									{  data: 'action',width:"40px",
											"render": function ( data, type, row ) {
												return  '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_realisasi_rencana_aksi"  data-id="'+row.realisasi_rencana_aksi_id+'"><i class="fa fa-pencil" ></i></a></span>';
											
										}
									},
									
								
								],
								initComplete: function(settings, json) {
								
							}
		});	
	}



	/* $(document).on('click','.create_realisasi_rencana_aksi',function(e){
	
		var rencana_aksi_id = $(this).data('id');
		show_modal_create(rencana_aksi_id);

	});

	function show_modal_create(rencana_aksi_id){
		$.ajax({
				url			  : '{{ url("api_resource/rencana_aksi_detail_1") }}',
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

		
	} */


	$(document).on('click','.edit_realisasi_rencana_aksi',function(e){
	
		var realisasi_rencana_aksi_id = $(this).data('id');
		$.ajax({
				url			  	: '{{ url("api_resource/realisasi_rencana_aksi_detail_1") }}',
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
					
					$('.modal-realisasi_rencana_aksi').find('h4').html('Edit realisasi Rencana Aksi');
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
					url		: '{{ url("api_resource/hapus_realisasi_rencana_aksi_1") }}',
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
