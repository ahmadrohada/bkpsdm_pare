<div class="modal fade distribusi_subkegiatan_add" id="createKegiatan" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Sub Kegiatan List
                </h4>
            </div>

			<div class="modal-body">

				<table id="subkegiatan_list_add" class="table table-striped table-hover table-condensed">
					<thead>
						<tr class="success">
							<th>ADD</th>
							<th>SUB KEGIATAN</th>
							<!-- <th>TARGET</th> -->
							<th>ANGGARAN</th>
						</tr>
					</thead>
					
					
				</table>

				<span class="text-danger">* Sub Kegiatan tanpa Indikator tidak ditampilkan pada tabel diatas</span>
				<hr>

				<button class="form-control btn-block btn-sm btn-warning" type="button" id="add_to_pejabat">SIMPAN</button>
			

				<input type="hidden" id="tes">
			
            </div>
        </div>
    </div>
</div>






<script type="text/javascript">

		$('.distribusi_subkegiatan_add').on('hidden.bs.modal', function() {
			$('#subkegiatan_list_add').DataTable().ajax.reload(null,false);
			
		});
	
		$('.distribusi_subkegiatan_add').on('shown.bs.modal', function(){
			$('#subkegiatan_list_add').DataTable().ajax.reload(null,false);
		});

	
		$('#subkegiatan_list_add').DataTable({
					destroy			: true,
					processing      : true,
					serverSide      : true,
					searching      	: true,
					paging          : true,
					lengthMenu		: [10,20,50],
					columnDefs		: [
										{ 	className: "text-center", targets: [ 0 ] },
										{ className: "text-right", targets: [ 2 ] }
									],
					ajax			: {
										url	: '{{ url("api/renja_subkegiatan_list") }}',
										data: { renja_id : {!! $renja->id !!} },
										delay:3000
									},
					

					columns	:[
									{ data: "checkbox" ,  name:"checkbox", orderable: false, searchable: false, width:'40px'},
								
									{ data: "label" ,  name:"label", orderable: true, searchable: true},
									//{ data: "kegiatan_target" ,  name:"kegiatan_target", orderable: true, searchable: false,width:'140px'},
									{ data: "subkegiatan_anggaran" ,  name:"subkegiatan_anggaran", orderable: true, searchable: false,width:'140px'},
									
									
								]
				 
			});



		$('#add_to_pejabat').on('click', function(){

			data = $('.cb_pilih:checked').serialize();
			var tes  = $('#tes').val();

			if ( data.length >0 ){
				$.ajax({
						url		: '{!! url("api/add_subkegiatan_to_pejabat?id_jabatan='+tes+'") !!}',
						type	: 'POST',
						data	: data,
						success	: function(data) {

							
							//$('.create-perjanjian_kinerja_confirm').modal('hide');
							//$('#perjanjian_kinerja').DataTable().ajax.reload(null,false);

							//$('#kegiatan_tahunan-kegiatan_table').DataTable().ajax.reload(null,false);
							//$('#kegiatan_tahunan-kegiatan_table_non_anggaran').DataTable().ajax.reload(null,false);
							
							Swal.fire({
									title: "",
									text: "Sukses",
									type: "success",
									width: "200px",
									showConfirmButton: false,
									allowOutsideClick : false,
									timer:500
							}).then(function () {
								$('.distribusi_subkegiatan_add').modal('hide');
								$('#ditribusi_renja').jstree('refresh');
								$('#perjanjian_kinerja').DataTable().ajax.reload(null,false);
								/* $('#subkegiatan_tahunan-kegiatan_table').DataTable().ajax.reload(null,false);
								$('#subkegiatan_tahunan-kegiatan_table_non_anggaran').DataTable().ajax.reload(null,false); */
							
									
							},
								// handling the promise rejection
								function (dismiss) {
									if (dismiss === 'timer') {
											
									}
								}
							)	 
						},
						error: function(e) {
							Swal.fire({
								title: "Gagal",
								text: "tidak berhasil disimpan",
								type: "warning"
							}).then (function(){
									
							});
							}
							
					});


			}

					



		})

</script>