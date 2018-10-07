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
					<div class="form-group">
						<label for="usernameInput">Username</label>
						<input type="text" class="form-control" value="{{ $username }}">
						
					</div>
				</form>     
            </div>
			<div class="box-footer">
			<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-info pull-right">Simpan</button>
            </div>

        </div>
    </div>
</div>



<script type="text/javascript">
$(document).ready(function() {

    
    /* $(document).on('click','.add_sasaran_id',function(e){
	

	}); */




});
</script>