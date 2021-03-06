<div class="row">
	<div class="col-md-12">

<!--====================== KEGIATAN BULANAN LIST =========================================== -->
		<div class="box box-primary" id='kegiatan_triwulan'>
			<div class="box-header with-border">
				<h1 class="box-title">
					List Realisasi Kegiatan Tahunan Triwulan {!! $capaian_triwulan->triwulan !!} [ Eselon {!! $capaian_triwulan->PegawaiYangDinilai->Eselon->eselon !!}  ]
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
							<th rowspan="2">NO</th>
							<th rowspan="2">KEGIATAN TAHUNAN</th>
							<th rowspan="2">INDIKATOR</th>
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
<style>
table.dataTable tbody td {
  vertical-align: middle;
}
</style>


@include('pare_pns.modals.realisasi_kegiatan_triwulan')

<script src="{{asset('assets/js/dataTables.rowsGroup.js')}}"></script>

<script type="text/javascript">

	
	
  	function load_kegiatan_triwulan(){
		
		var table_kegiatan_triwulan = $('#realisasi_kegiatan_triwulan_table').DataTable({
				destroy			: true,
				processing      : true,
				serverSide      : true,
				searching      	: false,
				paging          : false,
				bInfo			: false,
				bSort			: false,
				lengthChange	: false,
				lengthMenu		: [25,50,100],
				columnDefs		: [
									{ "orderable": false, className: "text-center", targets: [ 0,3,5,7 ] },
									{ className: "text-right", targets: [ 4,6] },
								],
				ajax			: {
									url	: '{{ url("api/realisasi_kegiatan_triwulan") }}',
									data: { 
										
											"renja_id" 				: {!! $capaian_triwulan->SKPTahunan->Renja->id !!} , 
											"jabatan_id" 			: {!! $capaian_triwulan->PegawaiYangDinilai->Jabatan->id !!},
											"capaian_triwulan_id" 	: {!! $capaian_triwulan->id !!},
											"jenis_jabatan"			: {!! $capaian_triwulan->PegawaiYangDinilai->Eselon->id_jenis_jabatan !!},
									 },
								},
				targets			: 'no-sort',
				bSort			: false,
				rowsGroup		: [ 0,1,4,6 ],
				columns			: [
									{ data: 'id' , orderable: true,searchable:false,width:"30px",
										"render": function ( data, type, row ,meta) {
											return meta.row + meta.settings._iDisplayStart + 1 ;
										}
									},
									{ data: "kegiatan_label", name:"kegiatan_label",
										"render": function ( data, type, row ) {
											return row.kegiatan_label;
											
										}
									}, 
									{ data: "indikator_label", name:"indikator_label",
										"render": function ( data, type, row ) {
											return row.indikator_label;
											
										}
									}, 
									
									{ data: "target_quantity", name:"target_quantity", width:"100px",
										"render": function ( data, type, row ) {
											return row.target_quantity ;
										}
									},
									{ data: "target_cost", name:"target_cost", width:"100px",
										"render": function ( data, type, row ) {
											return row.target_cost ;
										}
									},
									{ data: "realisasi_quantity", name:"realisasi_quantity", width:"100px",
										"render": function ( data, type, row ) {
											if ( (row.realisasi_indikator_id) >= 1 ){
												return row.realisasi_quantity ;
											}else{
												return  '-';
											
											} 

											
										}
									},{ data: "realisasi_cost", name:"realisasi_cost", width:"100px",
										"render": function ( data, type, row ) {
											if ( (row.realisasi_indikator_id) >= 1 ){
												return row.realisasi_cost ;
											}else{
												return  '-';
											
											} 

											
										}
									},
									{  data: 'action',width:"60px",
											"render": function ( data, type, row ) {
											if ( {!! $capaian_triwulan->status !!} == 1 ){
												return  '<span style="margin:2px;" ><a class="btn btn-default btn-xs "  "><i class="fa fa-pencil" ></i></a></span>'+
														'<span style="margin:2px;" ><a class="btn btn-default btn-xs "  "><i class="fa fa-close " ></i></a></span>';
											}else{
												if ( (row.realisasi_indikator_id) >= 1 ){
													return  '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_realisasi_triwulan"  data-indikator_id="'+row.indikator_kegiatan_id+'"><i class="fa fa-pencil" ></i></a></span>'+
															'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_realisasi_triwulan"  data-realisasi_kegiatan_id ="'+row.realisasi_kegiatan_id+'"  data-realisasi_indikator_kegiatan_id="'+row.realisasi_indikator_id+'"  data-kegiatan_id="'+row.kegiatan_id+'"  data-label="'+row.indikator_label+'" ><i class="fa fa-close " ></i></a></span>';
												}else{
													return  '<span  data-toggle="tooltip" title="Add" style="margin:2px;" ><a class="btn btn-info btn-xs create_realisasi_triwulan"  data-indikator_id="'+row.indikator_kegiatan_id+'" data-kegiatan_tahunan_id="'+row.kegiatan_tahunan_id+'"><i class="fa fa-plus" ></i></a></span>'+
															'<span  style="margin:2px;" disabled><a class="btn btn-default btn-xs "  ><i class="fa fa-close " ></i></a></span>';
												
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
	
		
		var indikator_kegiatan_id = $(this).data('indikator_id');
		$('.modal-realisasi_kegiatan_triwulan').find('h4').html('Add Realisasi Kegiatan Tahunan Triwulan '+ {!! $capaian_triwulan->triwulan !!});
		$('.modal-realisasi_kegiatan_triwulan').find('.btn-submit').attr('id', 'submit-save');
		$('.modal-realisasi_kegiatan_triwulan').find('[name=text_button_submit]').html('Simpan Data');
		show_modal_create(indikator_kegiatan_id);
		
	});

	function show_modal_create(indikator_kegiatan_id){
		$.ajax({
				url			  	: '{{ url("api/add_realisasi_kegiatan_triwulan") }}',
				data 		  	: { 
									indikator_kegiatan_id : indikator_kegiatan_id ,
									capaian_id : {!! $capaian_triwulan->id !!} ,
									jenis_jabatan : {!! $capaian_triwulan->PegawaiYangDinilai->Eselon->id_jenis_jabatan !!},
								 },
				method			: "GET",
				dataType		: "json",
				success	: function(data) {
					
					$('.modal-realisasi_kegiatan_triwulan').find('[name=capaian_triwulan_id]').val({!! $capaian_triwulan->id !!});
					$('.modal-realisasi_kegiatan_triwulan').find('[name=ind_kegiatan_id]').val(data['ind_kegiatan_id']);
					$('.modal-realisasi_kegiatan_triwulan').find('[name=kegiatan_tahunan_id]').val(data['kegiatan_tahunan_id']);
					$('.modal-realisasi_kegiatan_triwulan').find('[name=realisasi_indikator_kegiatan_triwulan_id]').val(data['realisasi_indikator_id']);
					$('.modal-realisasi_kegiatan_triwulan').find('[name=realisasi_kegiatan_triwulan_id]').val(data['realisasi_kegiatan_id']);
					$('.modal-realisasi_kegiatan_triwulan').find('[name=jumlah_indikator]').val(data['jumlah_indikator']);
					
					$('.modal-realisasi_kegiatan_triwulan').find('[name=target_quantity]').val(data['target_quantity']);
					$('.modal-realisasi_kegiatan_triwulan').find('[name=target_quality]').val(data['target_quality']);
					$('.modal-realisasi_kegiatan_triwulan').find('[name=target_waktu]').val(data['target_waktu']);
					$('.modal-realisasi_kegiatan_triwulan').find('[name=target_cost]').val(data['target_cost']);
					$('.modal-realisasi_kegiatan_triwulan').find('[name=satuan]').val(data['satuan']);

					$('.modal-realisasi_kegiatan_triwulan').find('.kegiatan_tahunan_label').html(data['kegiatan_tahunan_label']);
					$('.modal-realisasi_kegiatan_triwulan').find('.indikator_label').html(data['indikator_label']);
					


					$('.modal-realisasi_kegiatan_triwulan').find('.target_quantity').html(data['target_quantity']);
					$('.modal-realisasi_kegiatan_triwulan').find('.target_quality').html(data['target_quality']);
					$('.modal-realisasi_kegiatan_triwulan').find('.target_waktu').html(data['target_waktu']);
					$('.modal-realisasi_kegiatan_triwulan').find('.target_cost').html(data['target_cost']);
					$('.modal-realisasi_kegiatan_triwulan').find('.satuan').html(data['satuan']);

					$('.modal-realisasi_kegiatan_triwulan').find('.realisasi_quantity').val(data['realisasi_quantity']);
					$('.modal-realisasi_kegiatan_triwulan').find('.realisasi_quality').val(data['realisasi_quality']);
					$('.modal-realisasi_kegiatan_triwulan').find('.realisasi_waktu').val(data['realisasi_waktu']);
					$('.modal-realisasi_kegiatan_triwulan').find('.realisasi_cost').val(data['realisasi_cost']);
					
					

					
					$('.modal-realisasi_kegiatan_triwulan').modal('show');  
				},
				error: function(data){
					
				}						
		});	

		
	}

	$(document).on('click','.edit_realisasi_triwulan',function(e){

		
		var indikator_kegiatan_id = $(this).data('indikator_id');
		$('.modal-realisasi_kegiatan_triwulan').find('h4').html('Edit Realisasi Kegiatan Tahunan Triwulan '+ {!! $capaian_triwulan->triwulan !!});
		$('.modal-realisasi_kegiatan_triwulan').find('.btn-submit').attr('id', 'submit-update');
		$('.modal-realisasi_kegiatan_triwulan').find('[name=text_button_submit]').html('Update Data');
		show_modal_create(indikator_kegiatan_id);
		
	});

	$(document).on('click','.hapus_realisasi_triwulan',function(e){
		var realisasi_indikator_kegiatan_id = $(this).data('realisasi_indikator_kegiatan_id') ;
		var kegiatan_id = $(this).data('kegiatan_id') ;
		var realisasi_kegiatan_id = $(this).data('realisasi_kegiatan_id') ;

		//alert(realisasi_kegiatan_id);
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
					url		: '{{ url("api/hapus_realisasi_kegiatan_triwulan") }}',
					type	: 'POST',
					data    : { kegiatan_id:kegiatan_id,
								realisasi_indikator_kegiatan_id:realisasi_indikator_kegiatan_id,
								realisasi_kegiatan_id:realisasi_kegiatan_id
								},
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
										$('#realisasi_kegiatan_triwulan_table').DataTable().ajax.reload(null,false);
										
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#realisasi_kegiatan_triwulan_table').DataTable().ajax.reload(null,false);
											
											
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
