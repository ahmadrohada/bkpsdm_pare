<div class="modal fade modal-skp_tahunan_bawahan" id="" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
			<div class="modal-body"> 

			<div class="box-body table-responsive">
		
				List bawahan yang belum membuat SKP Tahunan
				<table id="skp_tahunan_table_bawahan" class="table table-striped table-hover table-condensed">
					<thead>
						<tr class="success">
							<th>NO</th>
							<th>NIP</th>
							<th>NAMA</th>
							<th>SKP STATUS</th>
						</tr>
					</thead>
					
					
				</table>
	
			</div>

        	</div>
			<div class="modal-footer">
				{!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_cancel_icon').'" aria-hidden="true"></i>' . Lang::get('Tutup'), array('class' => 'btn btn-sm btn-default pull-left btn-flat', 'type' => 'button', 'data-dismiss' => 'modal' )) !!}
			</div>
		</div>
   	</div>
</div>







<script type="text/javascript">

function skp_list_bawahan($pk_id,$jabatan_id){
		
		$('#skp_tahunan_table_bawahan').DataTable({
				destroy			: true,
				processing      : true,
				serverSide      : true,
				searching      	: false,
				paging          : false,
				order 			: [ 0 , 'desc' ],
				//dom 			: '<"toolbar">frtip',
				lengthMenu		: [50,100],
				columnDefs		: [
									{ 	className: "text-center", targets: [ 0,1,3] }/* ,
									//{ 	className: "hidden-xs", targets: [ 5 ] } */
								],
				ajax			: {
									url	: '{{ url("api_resource/skp_bawahan_list_md") }}',
									data: { 	perjanjian_kinerja_id	: $pk_id,
												jabatan_id 				: $jabatan_id,
											}
								},
				

				columns	:[
								{ data: 'bawahan_id' , orderable: true,searchable:false,
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
								
								{ data: "nip" ,  name:"nip", orderable: true, searchable: true},
								{ data: "nama_pegawai" ,  name:"nama_pegawai", orderable: true, searchable: true},
								{ data: "" , orderable: false,searchable:false,width:"30px",
										"render": function ( data, type, row ) {
										if (row.skp_tahunan_id >= 1 ){
											return  '<span class="label label-success"><i class="fa fa-check"></i></span>';
										}else{
											return  '<span class="label label-default"><i class="fa fa-close"></i></span>';
											
										}
										
									}
								}
								
							],
				initComplete: function(settings, json) {
							$('.modal-skp_tahunan_bawahan').modal('show'); 
							}
	});
}
	
</script>