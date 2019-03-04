<div class="box {{ $h_box }}">
    <div class="box-header with-border">
        <h1 class="box-title">
            Data SKP Bulanan
        </h1>

        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
            {!! Form::button('<i class="fa fa-times"></i>', array('class' => 'btn btn-box-tool','title' => 'close', 'data-widget' => 'remove', 'data-toggle' => 'tooltip')) !!}
        </div>
    </div>
	<div class="box-body table-responsive">

		<table id="skp_bulanan_table" class="table table-striped table-hover table-condensed">
			<thead>
				<tr class="success">
					<th>NO</th>
					<th>PERIODE</th>
					<th>BULAN</th>
					<th>PELAKSANAAN</th>
					<th>JABATAN</th>
					<th>CAPAIAN</th>
				</tr>
			</thead>
			
			
		</table>

	</div>
</div>


<script type="text/javascript">
	$('#skp_bulanan_table').DataTable({
				processing      : true,
				serverSide      : true,
				searching      	: false,
				paging          : false,
				order 			: [ 2 , 'desc' ],
				//dom 			: '<"toolbar">frtip',
				lengthMenu		: [50,100],
				columnDefs		: [
									{ 	className: "text-center", targets: [ 0,1,2,3,5,] }/* ,
									//{ 	className: "hidden-xs", targets: [ 5 ] } */
								],
				ajax			: {
									url	: '{{ url("api_resource/personal_capaian_bulanan_list") }}',
									data: { pegawai_id : {!! $pegawai->id !!} },
									delay:3000

								},
				

				columns	:[
								{ data: 'skp_bulanan_id' , orderable: true,searchable:false,
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
								
								{ data: "periode" ,  name:"periode", orderable: true, searchable: true},
								{ data: "bulan" ,  name:"bulan", orderable: true, searchable: true},
								{ data: "pelaksanaan" ,  name:"pelaksanaan", orderable: true, searchable: true,width:"250px"},
								{ data: "jabatan" ,  name:"jabatan", orderable: true, searchable: true},
								
								{ data: "capaian" , orderable: false,searchable:false,width:"120px",
										"render": function ( data, type, row ) {
										if (row.capaian == 1 ){ 
											return  '<span  data-toggle="tooltip" title="Create Capaian Bulanan" style="margin:1px;" ><a class="btn btn-warning btn-xs create_capaian_bulanan"  data-jabatan_id="'+row.jabatan_id+'" data-periode_id="'+row.periode_id+'" data-pegawai_id="'+row.pegawai_id+'">Create Capaian</a></span>';
										}else if (row.capaian == 0 ){

											return row.remaining_time;
											/* if ( row.status == 0 ){
												return  '<span style="margin:2px;" ><a class="btn btn-default btn-xs" disabled><i class="fa fa-eye" ></i></a></span>'
														+'<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_skp_tahunan"  data-id="'+row.skp_tahunan_id+'"><i class="fa fa-pencil" ></i></a></span>'
														+'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_skp_tahunan"  data-id="'+row.skp_tahunan_id+'" data-periode="'+row.periode+'" ><i class="fa fa-close " ></i></a></span>';
											
											}else{
												return  '<span  data-toggle="tooltip" title="Lihat" style="margin:1px;" ><a class="btn btn-info btn-xs lihat_skp_tahunan"  data-id="'+row.skp_tahunan_id+'"><i class="fa fa-eye" ></i></a></span>'
														+'<span style="margin:1px;" ><a class="btn btn-default btn-xs "  disabled><i class="fa fa-pencil" ></i></a></span>'
														+'<span style="margin:1px;" ><a class="btn btn-default btn-xs " disabled><i class="fa fa-close " ></i></a></span>';
											
											} */
										
										
										
										}
									}
								},
								
							]
			
	});


	

	
	
</script>
