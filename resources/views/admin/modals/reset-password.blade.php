<div class="modal fade reset-password" id="resetPassword" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Reset Password
                </h4>
            </div>
            <div class="modal-body">
                   Password akan direset. Default Password yaitu bkd12345         

            



                        
            </div>
            <div class="box-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-info pull-right proses">Proses</button>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">
$(document).ready(function() {

    
    $(document).on('click','.proses',function(e){
        //alert(user_id);

        $.ajax({
			url		: '{{ url("api_resource/reset_password") }}',
			type	: 'POST',
			data	:  { user_id:user_id },
			success	: function(data , textStatus, jqXHR) {
				
				swal({
                        title: "",
                        text: "Sukses",
                        type: "success",
                        width: "200px",
                        showConfirmButton: false,
                        allowOutsideClick : false,
                        timer: 1500
				}).then(function () {
						$('.reset-password').modal('hide');
				},
					function (dismiss) {
						if (dismiss === 'timer') {
							
						}
					}
			)	
			},
			error: function(jqXHR , textStatus, errorThrown) {

                alert('error');
				/* var test = $.parseJSON(jqXHR.responseText);
				var data= test.errors;
				$.each(data, function(index,value){
					//alert (index+":"+value);
					if (index == 'label'){
						$('.indikator_program').addClass('has-error');
					}
					if (index == 'target'){
						$('.target').addClass('has-error');
					}
					if (index == 'satuan'){
						$('.satuan').addClass('has-error');
					}
				}); */
			}
			
		  });

	});




});
</script>