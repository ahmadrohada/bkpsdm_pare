<div class="modal fade distribusi_kegiatan_add" id="createKegiatan" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Kegiatan List
                </h4>
            </div>

			<div class="modal-body">

				<table id="kegiatan_list" class="table table-striped table-hover table-condensed">
					<thead>
						<tr class="success">
							<th>Pilih</th>
							<th>KEGIATAN</th>
						</tr>
					</thead>
					
					
				</table>
				<hr>

				<button class="form-control btn-block btn-sm btn-warning" type="button" id="add_to_pejabat">SIMPAN</button>
			

				<input type="hidden" id="tes">
			
            </div>
        </div>
    </div>
</div>






<script type="text/javascript">
$(document).ready(function() {

	


	$('#kegiatan_list').DataTable({
				processing      : true,
				serverSide      : true,
				searching      	: false,
				paging          : false,
				//order 			: [ 3 , 'asc' ],
				//dom 			: '<"toolbar">frtip',
				lengthMenu		: [50,100],
				columnDefs		: [
									{ 	className: "text-center", targets: [ 0 ] }
								],
				ajax			: {
									url	: '{{ url("api_resource/renja_kegiatan_list") }}',
									data: { renja_id : 2 },
									delay:3000
								},
				

				columns	:[
								{ data: "checkbox" ,  name:"checkbox", orderable: false, searchable: false, width:'40px'},
								/* { data: 'kegiatan_id' , orderable: true,searchable:false,
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								}, */
								
								{ data: "label" ,  name:"label", orderable: true, searchable: false},
								
								
							]
			
		});



		$('#add_to_pejabat').on('click', function(){

			data = $('.cb_pilih:checked').serialize();
			var tes  = $('#tes').val();

			if ( data.length >0 ){
				$.ajax({
						url		: '{!! url("api_resource/add_kegiatan_to_pejabat?id_jabatan='+tes+'") !!}',
						type	: 'POST',
						data	: data,
						success	: function(e) {
							$('.create-perjanjian_kinerja_confirm').modal('hide');
							$('#perjanjian_kinerja').DataTable().ajax.reload(null,false);

								
							swal({
									title: "",
									text: "Sukses",
									type: "success",
									width: "200px",
									showConfirmButton: false,
									allowOutsideClick : false,
									timer:1500
							}).then(function () {
								$('.distribusi_kegiatan_add').modal('hide');

								
								$('#ditribusi_renja').jstree('refresh');
									
							},
								// handling the promise rejection
								function (dismiss) {
									if (dismiss === 'timer') {
											
									}
								}
						)	
						},
						error: function(e) {
							swal({
								title: "Gagal",
								text: "tidak berhasil disimpan",
								type: "warning"
							}).then (function(){
									
							});
							}
							
					});


			}

					



		})

});
</script>