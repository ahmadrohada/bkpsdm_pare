<div class="modal fade add-sasaran" id="addSasaran" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Pilih Sasaran
                </h4>
            </div>
            <div class="modal-body">
                            

            <table id="sasaran_list" class="table table-striped table-hover cell-border compact" style="width: 100%;">
                <thead>
                    <tr class="success">
                        <th>NO</th>
                        <th >LABEL</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                
            </table>




                        
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">
$(document).ready(function() {

    $.extend( $.fn.dataTable.defaults, {
		searching: true,
		ordering:  false,
		paging	: true
	} );


	var table = $('#sasaran_list').DataTable({
		serverSide	: true,
		select: true,
		ajax		: {
							url	: '{{ url("api_resource/skpd_sasaran_list") }}',
							type: 'get',
                            data: { perjanjian_kinerja_id: {{ $perjanjian_kinerja->id }} }
						},
        columnDefs	: [
						{ className: "text-center", targets: [ 0,2 ] }
					  ],
		columns		: [
						{   data: 'rownum' , orderable: false,searchable:false, width:"10px",
							"render": function ( data, type, row ) {
								return row.rownum;
							}
						},
						{ data: "label", name:"label", orderable: true, searchable: true},
						{ data: 'action', orderable: false, searchable: false ,width:"80px"}
							
					  ]
    
	
   
	} );



    $(document).on('click','.add_sasaran_id',function(e){
		

		var perjanjian_kinerja_id 	= ($(this).data('pk'));
		var sasaran_id 				= ($(this).data('id'));
		

        $.ajax({
			type        : 'POST',
			url			: '{{ url("api_resource/skpd_simpan_sasaran_perjanjian_kinerja") }}',
			data        : {sasaran_id:sasaran_id,perjanjian_kinerja_id:perjanjian_kinerja_id },
			cache       : false,
			success     : function(e) {
				
				$('#sasaran_list').DataTable().ajax.reload(null,false);
				$('#sasaran_table').DataTable().ajax.reload(null,false);
				
			    swal({
							title: "",
							text: "Berhasil ditambahkan",
							type: "success",
							width: "200px",
							showConfirmButton: false,
							allowOutsideClick : false,
							timer: 1500
						}).then(function () {
                           /*  $('#sasaran_list').DataTable().ajax.reload(null,false);
							$('#sasaran_table').DataTable().ajax.reload(null,false); */
							},
							// handling the promise rejection
							function (dismiss) {
								if (dismiss === 'timer') {
									//table.ajax.reload(null,false);
								}
							}
						)
			        },
			        error: function(data) {  
			        	swal({
			        		title: "Error",
			        		text: "Error menambahkan sasaran",
			        		type: "error"
			        	}).then (function(){
			        		
			        	});
			        }
		     	}); 

	});




});
</script>