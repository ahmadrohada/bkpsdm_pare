<div class="modal fade add-user id="addUser" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Add User
                </h4>
            </div>
            <div class="modal-body">
					
                  Add {{ $nama }} menjadi user PARE.<br>
				  username   <b> {{ $nip }}</b><br>
				  password &nbsp; <b>bkd12345</b>


            



                        
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
        //alert(pegawai_id);

        $.ajax({
			url		: '{{ url("api_resource/add_user") }}',
			type	: 'POST',
			data	:  { pegawai_id:pegawai_id,nip:nip },
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
						$('.add-user').modal('hide');
						window.location.reload();
				},
					function (dismiss) {
						if (dismiss === 'timer') {
							window.location.reload();
							
						}
					}
			)	
			},
			error: function(jqXHR , textStatus, errorThrown) {

                alert('Terjadi kesalahan');
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