<div class="box-body table-responsive" style="min-height:330px;">
	<div class="toolbar">  
 	</div>

	<table id="realisasi_program_triwulan_table" class="table table-striped table-hover" >
		<thead>
			<tr>
				<th>NO</th>
				<th>SASARAN PERJANJIAN KINERJA</th>
				<th>INDIKATOR PROGRAM</th>
				<th>TARGET</th>
				<th>REALISASI</th>
				<th><i class="fa fa-cog"></i></th>
			</tr>
		</thead>
							
	</table>

</div>

<style>
table.dataTable tbody td {
  vertical-align: middle;
}
</style>


@include('pare_pns.modals.realisasi_program_triwulan')

<script type="text/javascript">

	
  	function load_program_triwulan(){
		
		var table_program_triwulan = $('#realisasi_program_triwulan_table').DataTable({
				destroy			: true,
				processing      : false,
				serverSide      : true,
				searching      	: true,
				paging          : false,
				//order 			: [0 , 'asc' ],
				columnDefs		: [
									{ "orderable": false, className: "text-center", targets: [ 0,3,4,5 ] },
									
								],
				ajax			: {
									url	: '{{ url("api_resource/realisasi_program_triwulan") }}',
									data: { 
											"capaian_pk_triwulan_id" 	: {!! $capaian_pk_triwulan->id !!},
											"renja_id" 					: {!! $capaian_pk_triwulan->renja_id !!},
										 },
								},
				targets			: 'no-sort',
				bSort			: false,
				rowsGroup		: [ 1 ],
				columns			: [
									{ data: 'program_id' , orderable: true,searchable:false,width:"30px",
										"render": function ( data, type, row ,meta) {
											return meta.row + meta.settings._iDisplayStart + 1 ;
										}
									},
									{ data: "program_label", name:"program_label",
										"render": function ( data, type, row ) {
											return row.program_label;
											
										}
									}, 
									{ data: "indikator_program_label", name:"indikator_program_label",
										"render": function ( data, type, row ) {
											return row.indikator_program_label;
											
										}
									}, 
									
									{ data: "target", name:"target", width:"100px",
										"render": function ( data, type, row ) {
											return row.target ;
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
									},
									{  data: 'action',width:"60px",
											"render": function ( data, type, row ) {
											if ( {!! $capaian_pk_triwulan->status !!} == 1 ){
												return  '<span style="margin:2px;" ><a class="btn btn-default btn-xs "  "><i class="fa fa-pencil" ></i></a></span>'+
														'<span style="margin:2px;" ><a class="btn btn-default btn-xs "  "><i class="fa fa-close " ></i></a></span>';
											}else{
												if ( (row.realisasi_indikator_id) >= 1 ){
													return  '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_realisasi_program_triwulan"  data-indikator_program_id="'+row.indikator_program_id+'"><i class="fa fa-pencil" ></i></a></span>'+
															'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_realisasi_program_triwulan"  data-realisasi_program_id ="'+row.realisasi_program_id+'"  data-realisasi_indikator_id="'+row.realisasi_indikator_id+'"  data-program_id="'+row.program_id+'"  data-label="'+row.indikator_program_label+'" ><i class="fa fa-close " ></i></a></span>';
												}else{
													return  '<span  data-toggle="tooltip" title="Add" style="margin:2px;" ><a class="btn btn-info btn-xs create_realisasi_program_triwulan"  data-indikator_program_id="'+row.indikator_program_id+'" data-program_id="'+row.program_id+'"><i class="fa fa-plus" ></i></a></span>'+
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

	$(document).on('click','.create_realisasi_program_triwulan',function(e){
	
		
		var indikator_program_id = $(this).data('indikator_program_id');
		$('.modal-realisasi_program_triwulan').find('h4').html('Add Realisasi Program Triwulan '+ {!! $capaian_pk_triwulan->triwulan !!});
		$('.modal-realisasi_program_triwulan').find('.btn-submit').attr('id', 'submit-save_pt');
		$('.modal-realisasi_program_triwulan').find('[name=text_button_submit]').html('Simpan Data');
		show_modal_create_realisasi_program_triwulan(indikator_program_id);
		
	});

	function show_modal_create_realisasi_program_triwulan(indikator_program_id){
		$.ajax({
				url			  	: '{{ url("api_resource/add_realisasi_program_triwulan") }}',
				data 		  	: { 
									indikator_program_id : indikator_program_id ,
									capaian_id : {!! $capaian_pk_triwulan->id !!} },
				method			: "GET",
				dataType		: "json",
				success	: function(data) {
					
					$('.modal-realisasi_program_triwulan').find('[name=capaian_triwulan_id]').val({!! $capaian_pk_triwulan->id !!});
					$('.modal-realisasi_program_triwulan').find('[name=indikator_program_id]').val(data['indikator_program_id']);
					$('.modal-realisasi_program_triwulan').find('[name=program_id]').val(data['program_id']);
					$('.modal-realisasi_program_triwulan').find('[name=realisasi_program_triwulan_id]').val(data['realisasi_program_triwulan_id']);
					$('.modal-realisasi_program_triwulan').find('[name=realisasi_indikator_program_triwulan_id]').val(data['realisasi_indikator_program_triwulan_id']);	
					$('.modal-realisasi_program_triwulan').find('[name=jumlah_indikator]').val(data['jumlah_indikator']);
					$('.modal-realisasi_program_triwulan').find('[name=satuan]').val(data['satuan']);

					$('.modal-realisasi_program_triwulan').find('.program_label').html(data['program_label']);
					$('.modal-realisasi_program_triwulan').find('.indikator_program_label').html(data['indikator_program_label']);



					$('.modal-realisasi_program_triwulan').find('.target_quantity').val(data['target_quantity']);
					$('.modal-realisasi_program_triwulan').find('.realisasi_quantity').val(data['realisasi_quantity']);
					$('.modal-realisasi_program_triwulan').find('.satuan').html(data['satuan']);
					

					
					$('.modal-realisasi_program_triwulan').modal('show');  
				},
				error: function(data){
					
				}						
		});	

		
	}

	$(document).on('click','.edit_realisasi_program_triwulan',function(e){

		
		var indikator_program_id = $(this).data('indikator_program_id');
		$('.modal-realisasi_program_triwulan').find('h4').html('Edit Realisasi Program Triwulan '+ {!! $capaian_pk_triwulan->triwulan !!});
		$('.modal-realisasi_program_triwulan').find('.btn-submit').attr('id', 'submit-update_pt');
		$('.modal-realisasi_program_triwulan').find('[name=text_button_submit]').html('Update Data');
		show_modal_create_realisasi_program_triwulan(indikator_program_id);
		
	});

	$(document).on('click','.hapus_realisasi_program_triwulan',function(e){
		var realisasi_indikator_id = $(this).data('realisasi_indikator_id') ;
		var program_id = $(this).data('program_id') ;
		var realisasi_program_id = $(this).data('realisasi_program_id') ;

		//alert(realisasi_kegiatan_id);
		Swal.fire({
			title: "Hapus  Realisasi Program",
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
					url		: '{{ url("api_resource/hapus_realisasi_program_triwulan") }}',
					type	: 'POST',
					data    : { program_id:program_id,
								realisasi_indikator_id:realisasi_indikator_id,
								realisasi_program_id:realisasi_program_id
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
										$('#realisasi_program_triwulan_table').DataTable().ajax.reload(null,false);
										
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#realisasi_program_triwulan_table').DataTable().ajax.reload(null,false);
											
											
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
