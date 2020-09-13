<div class="box {{ $h_box }}">
    <div class="box-header with-border">
        <h1 class="box-title">
            Approval Request Capaian Bulanan
        </h1>

        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
            {!! Form::button('<i class="fa fa-times"></i>', array('class' => 'btn btn-box-tool','title' => 'close', 'data-widget' => 'remove', 'data-toggle' => 'tooltip')) !!}
        </div>
	</div>
	<div class="row" style="padding:5px 30px; min-height:200px;">
		<div class="box-body table-responsive">
			<table id="approval_request_renja_table" class="table table-striped table-hover table-condensed">
				<thead>
					<tr class="success"> 
						<th>NO</th>
						<th>PERIODE</th>
						<th>NAMA</th>
						<th>NIP</th>
						<th>JABATAN</th>
						<th>ESELON</th>
						<th><i class="fa fa-cog"></i></th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>

<script type="text/javascript">
		
	$('#approval_request_renja_table').DataTable({
				destroy			: true,
				processing      : true,
				serverSide      : true,
				searching      	: true,
				paging          : true,
				autoWidth		: false,
				bInfo			: false,
				bSort			: true,
				lengthChange	: true,
				order 			: [ 0 , 'desc' ],
				lengthMenu		: [20,45,80],
				columnDefs		: [
									{ 	className: "text-center", targets: [ 0,1,3,5,6 ] }/* ,
									//{ 	className: "hidden-xs", targets: [ 5 ] } */
								],
				ajax			: {
									url	: '{{ url("api_resource/approval_request_capaian_bulanan_list") }}',
									
									data: { pegawai_id : {!! $pegawai->id !!} },
									delay:3000
								},
				

				columns	:[
								{ data: 'capaian_bulanan_id' , orderable: true,searchable:false,
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
								
								{ data: "periode" ,  name:"periode", orderable: true, searchable: false},
								{ data: "nama" ,  name:"capaian_bulanan.u_nama", orderable: true, searchable: true},
								{ data: "nip" ,  name:"a.nip AS nip", orderable: true, searchable: true},
								{ data: "jabatan" ,  name:"jabatan.skpd", orderable: true, searchable: true},
								{ data: "eselon" ,  name:"eselon", orderable: true, searchable: false},
								{ data: "capaian_bulanan_id" , orderable: false,searchable:false,width:"120px",
										"render": function ( data, type, row ) {
										if (row.status_approve == 0 ){
											return  '<span  data-toggle="tooltip" title="Berikan Persetujuan" style="margin:1px;" ><a class="btn btn-warning btn-xs approval_capaian_bulanan"  data-capaian_bulanan_id="'+row.capaian_bulanan_id+'">Berikan Persetujuan</a></span>';
										}else if ( row.status_approve == 1 ){
											return  '<span  data-toggle="tooltip" title="Lihat Capaian" style="margin:1px;" ><a class="btn btn-success btn-xs lihat_capaian_bulanan"  data-capaian_bulanan_id="'+row.capaian_bulanan_id+'"> Lihat </a></span>';
										}else if ( row.status_approve == 2 ){
											return  '<span  data-toggle="tooltip" title="Ditolak" style="margin:1px;" ><a class="btn btn-danger btn-xs lihat_capaian_bulanan"  data-capaian_bulanan_id="'+row.capaian_bulanan_id+'"> Ditolak </a></span>';
										}
									}
								},
								
							]
			
	});


	

	$(document).on('click','.approval_capaian_bulanan',function(e){
		var capaian_bulanan_id = $(this).data('capaian_bulanan_id') ;
		//alert(skp_tahunan_id);
		window.location.assign("capaian_bulanan_bawahan_approvement/"+capaian_bulanan_id);
	});

	$(document).on('click','.lihat_capaian_bulanan',function(e){
		var capaian_bulanan_id = $(this).data('capaian_bulanan_id') ;
		//alert(skp_tahunan_id);
		//window.location.assign("capaian_bulanan_approval-request/"+capaian_bulanan_id);
		window.location.assign("capaian_bulanan_bawahan/"+capaian_bulanan_id);
	});

	
	
</script>
