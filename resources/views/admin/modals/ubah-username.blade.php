<div class="modal fade ubah-username" id="ubahUsername" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Ubah Username
                </h4>
            </div>
            <div class="modal-body">

				<form role="form">
					<div class="form-group f_username">
						<label for="usernameInput">Username</label>
						<input type="text" class="form-control new_username" value="">
						
					</div>
				</form>     
            </div>
			<div class="box-footer">
			    <button type="button" class="btn btn-default pull-left " data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-info pull-right simpan">Simpan</button>
            </div>

        </div>
    </div>
</div>



<script type="text/javascript">
$(document).ready(function() {

    
    $(document).on('click','.simpan',function(e){
        //alert(user_id);

        new_username = $(".new_username").val();
        $.ajax({
			url		: '{{ url("api_resource/ubah_username") }}',
			type	: 'POST',
			data	:  { user_id:user_id , new_username:new_username },
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
						$('.ubah-username').modal('hide');

                        window.location.reload(); 
				},
					function (dismiss) {
						if (dismiss === 'timer') {
							
						}
					}
			)	
			},
			error: function(jqXHR , textStatus, errorThrown) {

                //alert('error');
				var test = $.parseJSON(jqXHR.responseText);
				var data= test.errors;
				$.each(data, function(index,value){
					alert (value);
					if (index == 'new_username'){
						$('.f_username').addClass('has-error');
                        $('.new_username').focus();
						
					}
					
				}); 
			}
			
		  });

	});


	$(document).on('click','.f_username',function(e){
		$('.f_username').removeClass('has-error');
	});


});
</script>