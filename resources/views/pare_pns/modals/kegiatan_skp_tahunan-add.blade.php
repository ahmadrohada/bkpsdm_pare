<div class="modal fade modal-kegiatan_skp_tahunan_add" id="createKegiatan" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Sub Kegiatan List ( RENJA {{ $skp->Renja->Periode->label }} )
                </h4>
            </div>

			<div class="modal-body">

				<table id="subkegiatan_list_add" class="table table-striped table-hover table-condensed">
					<thead>
						<tr class="success">
							<th>ADD</th>
							<th>SUB KEGIATAN</th>
							<th>ANGGARAN</th>
						</tr>
					</thead>
					
					
				</table>
				<hr>
				<button class="form-control btn-block btn-sm btn-warning add_to_kegiatan_skp_tahunan" type="button" >ADD TO KEGIATAN SKP TAHUNAN</button>
				<input type="hidden" class="skp_tahunan_id" value="{{ $skp->id }}">
			</div>
        </div>
    </div>
</div>






<script type="text/javascript">

		$('.modal-kegiatan_skp_tahunan_add').on('hidden.bs.modal', function() {
			$('#subkegiatan_list_add').DataTable().ajax.reload(null,false);

			//reload tree dan table pada tab lain
			jQuery('#kegiatan_skp_tahunan_3').jstree(true).refresh(true);
			jQuery('#kegiatan_skp_tahunan_3').jstree().deselect_all(true);
			
		});
	
		/* $('.modal-kegiatan_skp_tahunan_add').on('shown.bs.modal', function(){
			$('#subkegiatan_list_add').DataTable().ajax.reload(null,false);
		}); */

	
		


		$('.add_to_kegiatan_skp_tahunan').on('click', function(){

			var data = $('.cb_pilih:checked').serialize();
			var skp_tahunan_id  = $('.skp_tahunan_id').val();

			if ( data.length >0 ){
				$.ajax({
						url		: '{!! url("api/add_subkegiatan_to_kegiatan_skp_tahunan?skp_tahunan_id='+skp_tahunan_id+'") !!}',
						type	: 'POST',
						data	: data,
						success	: function(data) {
							Swal.fire({
									title: "",
									text: "Sukses",
									type: "success",
									width: "200px",
									showConfirmButton: false,
									allowOutsideClick : false,
									timer:500
							}).then(function () {
								//$('.modal-kegiatan_skp_tahunan_add').modal('hide');
								$('#kegiatan_skp_tahunan_3_table').DataTable().ajax.reload(null,false);
								$('#subkegiatan_list_add').DataTable().ajax.reload(null,false);
								
									
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