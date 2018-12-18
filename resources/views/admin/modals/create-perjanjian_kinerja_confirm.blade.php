<div class="modal fade modal-success create-perjanjian_kinerja_confirm" id="confirmSave" role="dialog" aria-labelledby="confirmSaveLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Create Perjanjian Kinerja
                </h4>
            </div>
            
            <form  id="create-perjanjian-kinerja-form" method="POST" action="">
                


            <div class="modal-body">
                <input type="hidden" name="periode_tahunan_id" class="form-control periode_tahunan_id" required="">
                <input type="hidden" name="skpd_id" class="form-control" value="{!!  $skpd_id !!}" required="">
                {{ csrf_field() }}
                 Anda Akan Membuat <strong>PERJANJIAN KINERJA</strong> untuk <strong><span class="periode"></span></strong>    
            </div>
            <div class="modal-footer">
                {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_cancel_icon').'" aria-hidden="true"></i> ' . Lang::get('modals.confirm_modal_button_cancel_text'), array('class' => 'btn btn-sm btn-outline pull-left btn-flat', 'type' => 'button', 'data-dismiss' => 'modal' )) !!}
                {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_save_icon').'" aria-hidden="true"></i> ' . Lang::get('modals.confirm_modal_button_save_text'), array('class' => 'btn btn-sm btn-outline pull-right btn-flat', 'type' => 'button', 'id' => 'simpan_perjanjian_kinerja' )) !!}
            </div>


             </form>
        </div>
    </div>
</div>



<script type="text/javascript">
$(document).ready(function() {
	
	//swal({title: "",text: "Sukses",type: "success",width: "200px",showConfirmButton: false,allowOutsideClick : false,timer:3000});

    $(document).on('click', '#simpan_perjanjian_kinerja', function(){
		
        var data = $('#create-perjanjian-kinerja-form').serialize();
		$.ajax({
			url		: '{{ url("api_resource/skpd_simpan_perjanjian_kinerja") }}',
			type	: 'POST',
			data	:  data,
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
					$('#perjanjian_kinerja').DataTable().ajax.reload(null,false);
				});
				}
			
		  });
		
    });
  
	
	
});
</script>