<div class="modal fade  modal-file_upload" id="" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Bukti Realisasi Kegiatan Bulanan
                </h4>
            </div>

            <form  id="bukti_realisasi_form" method="POST" action="" enctype="multipart/form-data">
			<input type="hidden"  name="realisasi_kegiatan_bulanan_id" class="form-control realisasi_kegiatan_bulanan_id">
			<div class="modal-body" style="min-height:340px;">
					
				@if  ( ( request()->segment(4) == 'edit' ) | ( request()->segment(4) == 'ralat' )  )
					<div class="row file_upload_area">
						<div class="col-md-12 ">
							<div class="dropzone"></div>
						</div>
					</div>				
				@endif 
				

				<div class="load_area" style=" margin: auto; width: 40%; min-height:340px; margin-top:10px;" hidden>
					<img src='{{ asset('assets/images/loader/loading.gif')  }}'>
				</div>

				<div class="image_file_area" style="min-height:340px; margin-top:10px;">
                    <img src="" class="image_file" style="width: 100%;">
				</div>
				
				<div class="pdf_file_area" style="min-height:340px; margin-top:10px;">
					<embed src="" width="100%" class="pdf_file" height="820px" />
				</div>

			</div>
			
            </form>
        </div>
    </div>
</div>




<script type="text/javascript">

	$('.modal-file_upload').on('hidden.bs.modal', function(){
		$('.pdf_file_area').hide();
        $('.image_file_area').hide();
	});


	var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
	//Dropzone.autoDiscover = false;
	var myDropzone = new Dropzone(".dropzone", {
		url             : '{{ url("api_resource/file_upload") }}',
		paramName       : 'file',
		maxFiles        : 1,
		maxFilesize		: 2,  // 3 mb
		acceptedFiles	: '.jpeg,.jpg,.png,.pdf',
		uploadMultiple	: false,
		addRemoveLinks	: true,
		//dictRemoveFile	: "Hapus",
		dictDefaultMessage: "<h5>Seret atau klik untuk upload file<h5>",
		autoProcessQueue: true,
		init            : function() {
								this.on('addedfile', function(file) {
									//$('form').append('<input type="text" name="bukti" value="' + file.name + '">');
								}).on('sending', function(file, xhr, formData) {
       								formData.append('_token', CSRF_TOKEN);
								}).on('success', function(file, responseText) {
									$('form').append('<input type="hidden" name="bukti" value="' + responseText + '">');
									//uploadedDocumentMap[file.name] = responseText ;
									console.log(responseText);
                                    this.removeAllFiles(true); 

									//show loader
									
									$('.load_area').show();
									$('.pdf_file_area').hide();
        							$('.image_file_area').hide();

									update_table(responseText);
								}).on('error', function(file, response) {
									
								}).on('maxfilesexceeded', function(file, responseText) {
									
								});
							}
							
	});
	

	function update_table(bukti){
		var data = $('#bukti_realisasi_form').serialize();
		$.ajax({
			url		: '{{ url("api_resource/update_bukti_realisasi_kegiatan_bulanan") }}',
			type	: 'POST',
			data	:  data,
			success	: function(data) {
				$('#realisasi_kegiatan_bulanan_table').DataTable().ajax.reload(null,false);
				refresh();
				//$('.pdf_file_area').hide();
        		//$('.image_file_area').hide();
				
			},
			error: function(jqXHR , textStatus, errorThrown) {

			}
			
		});
	}



	function refresh(){

		var fdata = $('#bukti_realisasi_form').serialize();
		$.ajax({
			url		: '{{ url("api_resource/realisasi_kegiatan_bulanan_detail") }}',
			type	: 'GET',
			data	:  fdata,
			success	: function(data) {

				$('.load_area').hide();
				//chek dulu file extension nya
				if ( data['ext_bukti'] == 'pdf' ){
					$('.pdf_file').attr('src', "<?php echo asset('files_upload/"+data["bukti"]+"') ?>");
					$('.pdf_file_area').show();
        			$('.image_file_area').hide();
				}else{
					$('.image_file').attr('src', "<?php echo asset('files_upload/"+data["bukti"]+"') ?>");
					$('.pdf_file_area').hide();
        			$('.image_file_area').show();
				}

				
				
			},
			error: function(jqXHR , textStatus, errorThrown) {

			}
			
		});
	}
	
	

</script>