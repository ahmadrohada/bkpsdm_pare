<div class="box-body table-responsive" style="min-height:330px;">
	<div class="toolbar">  
 	</div>

	<table id="realisasi_sasaran_tahunan_table" class="table table-striped table-hover" >
		<thead>
			<tr>
				<th>NO</th>
				<th>SASARAN PERJANJIAN KINERJA</th>
				<th>INDIKATOR SASARAN</th>
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


@include('pare_pns.modals.realisasi_sasaran_tahunan')

<script type="text/javascript">

	
  	function load_sasaran_tahunan(){
		
		var table_sasaran_tahunan = $('#realisasi_sasaran_tahunan_table').DataTable({
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
									url	: '{{ url("api_resource/realisasi_sasaran_tahunan") }}',
									data: { 
											"capaian_pk_tahunan_id" 	: {!! $capaian_pk_tahunan->id !!},
											"renja_id" 					: {!! $capaian_pk_tahunan->renja_id !!},
										 },
								},
				targets			: 'no-sort',
				bSort			: false,
				rowsGroup		: [ 1 ],
				columns			: [
									{ data: 'sasaran_id' , orderable: true,searchable:false,width:"30px",
										"render": function ( data, type, row ,meta) {
											return meta.row + meta.settings._iDisplayStart + 1 ;
										}
									},
									{ data: "sasaran_label", name:"sasaran_label",
										"render": function ( data, type, row ) {
											return row.sasaran_label;
											
										}
									}, 
									{ data: "indikator_label", name:"indikator_label",
										"render": function ( data, type, row ) {
											return row.indikator_label;
											
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
											if ( {!! $capaian_pk_tahunan->status !!} == 1 ){
												return  '<span style="margin:2px;" ><a class="btn btn-default btn-xs "  "><i class="fa fa-pencil" ></i></a></span>'+
														'<span style="margin:2px;" ><a class="btn btn-default btn-xs "  "><i class="fa fa-close " ></i></a></span>';
											}else{
												if ( (row.realisasi_indikator_id) >= 1 ){
													return  '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_realisasi_sasaran_tahunan"  data-indikator_sasaran_id="'+row.indikator_sasaran_id+'"><i class="fa fa-pencil" ></i></a></span>'+
															'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_realisasi_sasaran_tahunan"  data-realisasi_sasaran_id ="'+row.realisasi_sasaran_id+'"  data-realisasi_indikator_id="'+row.realisasi_indikator_id+'"  data-sasaran_id="'+row.sasaran_id+'"  data-label="'+row.indikator_label+'" ><i class="fa fa-close " ></i></a></span>';
												}else{
													return  '<span  data-toggle="tooltip" title="Add" style="margin:2px;" ><a class="btn btn-info btn-xs create_realisasi_sasaran_tahunan"  data-indikator_sasaran_id="'+row.indikator_sasaran_id+'" data-sasaran_id="'+row.sasaran_id+'"><i class="fa fa-plus" ></i></a></span>'+
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

	$(document).on('click','.create_realisasi_sasaran_tahunan',function(e){
	
		
		var indikator_sasaran_id = $(this).data('indikator_sasaran_id');
		$('.modal-realisasi_sasaran_tahunan').find('h4').html('Add Realisasi Sasaran Tahunan ');
		$('.modal-realisasi_sasaran_tahunan').find('.btn-submit').attr('id', 'submit-save_st');
		$('.modal-realisasi_sasaran_tahunan').find('[name=text_button_submit]').html('Simpan Data');
		show_modal_create_realisasi_sasaran_tahunan(indikator_sasaran_id);
		
	});

	function show_modal_create_realisasi_sasaran_tahunan(indikator_sasaran_id){
		$.ajax({
				url			  	: '{{ url("api_resource/add_realisasi_sasaran_tahunan") }}',
				data 		  	: { 
									indikator_sasaran_id : indikator_sasaran_id ,
									capaian_id : {!! $capaian_pk_tahunan->id !!} },
				method			: "GET",
				dataType		: "json",
				success	: function(data) {
					
					$('.modal-realisasi_sasaran_tahunan').find('[name=capaian_tahunan_id]').val({!! $capaian_pk_tahunan->id !!});
					$('.modal-realisasi_sasaran_tahunan').find('[name=indikator_sasaran_id]').val(data['indikator_sasaran_id']);
					$('.modal-realisasi_sasaran_tahunan').find('[name=sasaran_id]').val(data['sasaran_id']);
					$('.modal-realisasi_sasaran_tahunan').find('[name=realisasi_sasaran_tahunan_id]').val(data['realisasi_sasaran_tahunan_id']);
					$('.modal-realisasi_sasaran_tahunan').find('[name=realisasi_indikator_sasaran_tahunan_id]').val(data['realisasi_indikator_sasaran_tahunan_id']);	
					$('.modal-realisasi_sasaran_tahunan').find('[name=jumlah_indikator]').val(data['jumlah_indikator']);
					$('.modal-realisasi_sasaran_tahunan').find('[name=satuan]').val(data['satuan']);

					$('.modal-realisasi_sasaran_tahunan').find('.sasaran_label').html(data['sasaran_label']);
					$('.modal-realisasi_sasaran_tahunan').find('.indikator_sasaran_label').html(data['indikator_sasaran_label']);



					$('.modal-realisasi_sasaran_tahunan').find('.target_quantity').val(data['target_quantity']);
					$('.modal-realisasi_sasaran_tahunan').find('.realisasi_quantity').val(data['realisasi_quantity']);
					$('.modal-realisasi_sasaran_tahunan').find('.satuan').html(data['satuan']);
					

					
					$('.modal-realisasi_sasaran_tahunan').modal('show');  
				},
				error: function(data){
					
				}						
		});	

		
	}

	$(document).on('click','.edit_realisasi_sasaran_tahunan',function(e){

		
		var indikator_sasaran_id = $(this).data('indikator_sasaran_id');
		$('.modal-realisasi_sasaran_tahunan').find('h4').html('Edit Realisasi Sasaran Tahunan ');
		$('.modal-realisasi_sasaran_tahunan').find('.btn-submit').attr('id', 'submit-update_st');
		$('.modal-realisasi_sasaran_tahunan').find('[name=text_button_submit]').html('Update Data');
		show_modal_create_realisasi_sasaran_tahunan(indikator_sasaran_id);
		
	});

	$(document).on('click','.hapus_realisasi_sasaran_tahunan',function(e){
		var realisasi_indikator_id = $(this).data('realisasi_indikator_id') ;
		var sasaran_id = $(this).data('sasaran_id') ;
		var realisasi_sasaran_id = $(this).data('realisasi_sasaran_id') ;

		//alert(realisasi_kegiatan_id);
		Swal.fire({
			title: "Hapus  Realisasi Sasaran",
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
					url		: '{{ url("api_resource/hapus_realisasi_sasaran_tahunan") }}',
					type	: 'POST',
					data    : { sasaran_id:sasaran_id,
								realisasi_indikator_id:realisasi_indikator_id,
								realisasi_sasaran_id:realisasi_sasaran_id
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
										$('#realisasi_sasaran_tahunan_table').DataTable().ajax.reload(null,false);
										
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#realisasi_sasaran_tahunan_table').DataTable().ajax.reload(null,false);
											
											
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
