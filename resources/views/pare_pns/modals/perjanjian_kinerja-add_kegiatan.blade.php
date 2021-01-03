<div class="modal fade modal-kegiatan_list" id="createKegiatan" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Kegiatan List
                </h4>
            </div>

			<div class="modal-body">
				<input type="hidden" class="program_id">
				<table id="kegiatan_list_add" class="table table-striped table-hover table-condensed">
					<thead>
						<tr class="success">
							<th>NO</th>
							<th>KEGIATAN</th>
							<th>ANGGARAN</th>
							<th><i class="fa fa-cog" style="margin-left:10px;"></i></th>
						</tr>
					</thead>
					
					
				</table>
				<ul class="list-group list-group-unbordered" style="margin-top:5px;">
					<li class="list-group-item">
						<b>TOTAL ANGGARAN KEGIATAN <span class="pull-right total_anggaran_kegiatan">Rp. </span></b>
					</li>
				</ul>

				

				
			
            </div>
        </div>
    </div>
</div>






<script type="text/javascript">

	$('.modal-kegiatan_list').on('hidden.bs.modal', function() {
		$('#kegiatan_list_add').DataTable().clear();
		$('#kegiatan_list_add').DataTable().destroy();
		$('.total_anggaran_kegiatan').html(0);
	});
	
	$('.modal-kegiatan_list').on('shown.bs.modal', function(){
			
	});

	function show_modal_kegiatan(program_id){
		$('.program_id').val(program_id);
		$('.modal-kegiatan_list').find('h4').html('List Kegiatan Perjanjian Kinerja Eselon II');


		$('#kegiatan_list_add').DataTable({
					destroy			: true,
					processing      : true,
					serverSide      : true,
					searching      	: false,
					paging          : false,
					bInfo			: false,
					bSort			: false,	
					columnDefs		: [
										{ 	className: "text-center", targets: [ 0,3 ] },
										{ className: "text-right", targets: [ 2 ] }
									],
					ajax			: {
										url	: '{{ url("api/eselon2_kegiatan_list") }}',
										data: { program_id : program_id },
										delay:3000
									},
					

					columns	:[
									{ data: 'id' , orderable: false,searchable:false,width:"30px",
										"render": function ( data, type, row ,meta) {
											return meta.row + meta.settings._iDisplayStart + 1 ;
										}
									},
									{ data: "label" ,  name:"label", orderable: true, searchable: true},
									//{ data: "kegiatan_target" ,  name:"kegiatan_target", orderable: true, searchable: false,width:'140px'},
									{ data: "kegiatan_anggaran" ,  name:"kegiatan_anggaran", orderable: true, searchable: false,width:'140px'},
									{ data: "esl2_pk_status" ,  name:"esl2_pk_status", orderable: false, searchable: false, width:'40px',
										"render": function ( data, type, row ) {
											if ( row.esl2_pk_status == 1 ){
												return  '<span  data-toggle="tooltip" title="Hapus Kegiatan" style="margin:1px;" ><a class="btn btn-success btn-xs remove_esl2_pk_kegiatan"  data-id="'+row.kegiatan_id+'"><i class="fa  fa-check" ></i></a></span>';
											}else{
												return  '<span  data-toggle="tooltip" title="Tambah Kegiatan" style="margin:1px;" ><a class="btn btn-default btn-xs add_esl2_pk_kegiatan"  data-id="'+row.kegiatan_id+'"><i class="fa  fa-minus" ></i></a></span>';
											}	
										}
									},
									
								],
					initComplete: function(settings, json) {
						hitung_total_anggaran_kegiatan(program_id);
						$('.modal-kegiatan_list').modal('show');
					}
				 
		});

			
	}

	function hitung_total_anggaran_kegiatan(program_id){
		$.ajax({
					url			: '{{ url("api/eselon2-total_anggaran_kegiatan") }}',
					data		: { 
										"program_id" : program_id
									},
					method		: "GET",
					dataType	: "json",
					success	: function(data) {
						
						$('.total_anggaran_kegiatan').html(data['total_anggaran_kegiatan']);
						
					},
					error: function(data){
						
					}						
		});
	}

	$(document).on('click','.remove_esl2_pk_kegiatan',function(e){
		var kegiatan_id = $(this).data('id') ;
		var program_id = $('.program_id').val();
		show_loader();
		$.ajax({
				url			: '{{ url("api/remove_esl2_kegiatan_from_pk") }}',
				data 		: {kegiatan_id : kegiatan_id},
				method		: "POST",
				success		: function(data) {
					$('#kegiatan_list_add').DataTable().ajax.reload(null,false); 
					$('#perjanjian_kinerja_program_table').DataTable().ajax.reload(null,false); 
					hitung_total_anggaran();
					hitung_total_anggaran_kegiatan(program_id);
					Swal.fire({
							title: "",
							text: "Berhasil Dihapus",
							type: "success",
							width: "200px",
							showConfirmButton: false,
							allowOutsideClick : false,
							timer: 1500
						}).then(function () {
							
						},
						function (dismiss) {
							if (dismiss === 'timer') {
								//table.ajax.reload(null,false);
							}
					})


				},
				error: function(data){
					Swal.fire({
			        		title: "Error",
			        		text: "",
			        		type: "error"
			        	}).then (function(){
			        		
			        	});
				}						
		});	
	});

	$(document).on('click','.add_esl2_pk_kegiatan',function(e){
		var kegiatan_id = $(this).data('id') ;
		var program_id = $('.program_id').val();
		show_loader();
		$.ajax({
				url			: '{{ url("api/add_esl2_kegiatan_to_pk") }}',
				data 		: {kegiatan_id : kegiatan_id},
				method		: "POST",
				success		: function(data) {
					$('#kegiatan_list_add').DataTable().ajax.reload(null,false); 
					$('#perjanjian_kinerja_program_table').DataTable().ajax.reload(null,false); 
					hitung_total_anggaran();
					hitung_total_anggaran_kegiatan(program_id);
					Swal.fire({
							title: "",
							text: "Berhasil ditambahkan",
							type: "success",
							width: "200px",
							showConfirmButton: false,
							allowOutsideClick : false,
							timer: 1500
						}).then(function () {
							
						},
						function (dismiss) {
							if (dismiss === 'timer') {
								//table.ajax.reload(null,false);
							}
					})


				},
				error: function(data){
					Swal.fire({
			        		title: "Error",
			        		text: "",
			        		type: "error"
			        	}).then (function(){
			        		
			        	});
				}						
		});	
	});
		

</script>