<div class="box {{ $h_box }}">
    <div class="box-header with-border">
        <h1 class="box-title">
            Approval Request Pohon Kinerja
        </h1>

        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
            {!! Form::button('<i class="fa fa-times"></i>', array('class' => 'btn btn-box-tool','title' => 'close', 'data-widget' => 'remove', 'data-toggle' => 'tooltip')) !!}
        </div>
    </div>
	<div class="box-body table-responsive">

		<table id="approval_request_renja_table" class="table table-striped table-hover table-condensed">
			<thead>
				<tr class="success">
					<th>NO</th>
					<th>PERIODE</th>
					<th>NAMA ADMIN</th>
					<th>TGL DIBUAT</th>
					<th>TGL DIKIRIM</th>

					<th><i class="fa fa-cog"></i></th>
				</tr>
			</thead>
			
			
		</table>

	</div>
</div>

<script type="text/javascript">
		
	$('#approval_request_renja_table').DataTable({
				processing      : true,
				serverSide      : true,
				searching      	: false,
				paging          : false,
				order 			: [ 0 , 'desc' ],
				//dom 			: '<"toolbar">frtip',
				lengthMenu		: [50,100],
				columnDefs		: [
									{ 	className: "text-center", targets: [ 0,1,3,4,5 ] }/* ,
									//{ 	className: "hidden-xs", targets: [ 5 ] } */
								],
				ajax			: {
									url	: '{{ url("api/approval_request_renja_list") }}',
									data: { pegawai_id : {!! $pegawai->id !!} },
									delay:3000
								},
				

				columns	:[
								{ data: 'renja_id' , orderable: true,searchable:false,
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
								
								{ data: "periode" ,  name:"periode", orderable: true, searchable: true},
								{ data: "nama_admin" ,  name:"nama_admin", orderable: true, searchable: true},
								{ data: "tgl_dibuat" ,  name:"tgl_dibuat", orderable: true, searchable: true},
								{ data: "tgl_dikirim" ,  name:"tgl_dikirim", orderable: true, searchable: true},
								
								{ data: "renja_id" , orderable: false,searchable:false,width:"120px",
										"render": function ( data, type, row ) {
										if (row.status_approve == 0 ){
											return  '<span  data-toggle="tooltip" title="Berikan Persetujuan Pohon Kinerja" style="margin:1px;" ><a class="btn btn-warning btn-xs approval_renja"  data-renja_id="'+row.renja_id+'">Approval</a></span>';
										}else if ( row.status_approve == 1 ){
											return  '<span  data-toggle="tooltip" title="Detail Pohon Kinerja" style="margin:1px;" ><a class="btn btn-success btn-xs lihat_renja"  data-renja_id="'+row.renja_id+'"> Lihat </a></span>';
										}else if ( row.status_approve == 2 ){
											return  '<span  data-toggle="tooltip" title="Pohon Kinerja telah ditolak" style="margin:1px;" ><a class="btn btn-danger btn-xs "  > Ditolak </a></span>';
										}
									}
								},
								
							]
			
	});


	

	$(document).on('click','.approval_renja',function(e){
		var renja_id = $(this).data('renja_id') ;
		//alert(skp_tahunan_id);



		window.location.assign("renja_approval-request/"+renja_id);
	});

	$(document).on('click','.lihat_renja',function(e){
		var renja_id = $(this).data('renja_id') ;
		//alert(skp_tahunan_id);



		window.location.assign("pohon_kinerja/"+renja_id);
	});

	
	
</script>
