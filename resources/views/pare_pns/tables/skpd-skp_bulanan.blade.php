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

		<table id="rkpd_table" class="table table-striped table-hover table-condensed">
			<thead>
				<tr class="success">
					<th>NO</th>
					<th>PERIODE</th>
					<th>NIP</th>
					<th>NAMA</th>
					<th>ESELON</th>
					<th>JABATAN</th>
					<th>NAMA ATASAN</th>
					<th><i class="fa fa-cog" style="margin-left:12px !important;"></i></th>
				</tr>
			</thead>
			
			
		</table>

	</div>
</div>



<script type="text/javascript">
	$(document).ready(function() {
		//alert();
		
		$('#rkpd_table').DataTable({
				processing      : true,
				serverSide      : true,
				searching      	: false,
				paging          : false,
				//order 			: [ 3 , 'asc' ],
				//dom 			: '<"toolbar">frtip',
				lengthMenu		: [50,100],
				columnDefs		: [
									{ 	className: "text-center", targets: [ 0,1,2,4,7 ] }/* ,
									//{ 	className: "hidden-xs", targets: [ 5 ] } */
								],
				ajax			: {
									url	: '{{ url("api_resource/skpd_skp_bulanan_list") }}',
									data: { skpd_id : {{$skpd_id}} },
									delay:3000
								},
				

				columns	:[
								{ data: 'skp_bulanan_id' , orderable: true,searchable:false,
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
								
								{ data: "periode" ,  name:"periode", orderable: true, searchable: true},
								{ data: "nip_pegawai" ,  name:"nip_pegawai", orderable: true, searchable: true},
								{ data: "nama_pegawai" ,  name:"u_nama", orderable: true, searchable: true},
								{ data: "eselon" ,  name:"eselon", orderable: true, searchable: true},
								{ data: "jabatan" ,  name:"jabatan", orderable: true, searchable: true},
								{ data: "nama_atasan" ,  name:"p_nama", orderable: true, searchable: true},
								{ data: "status" , orderable: false,searchable:false,width:"50px",
										"render": function ( data, type, row ) {

										if ( row.status == 20 ){
											return  '<span  data-toggle="tooltip" title="Lihat" style="margin:1px;" class=""><a href="{{ url('/admin/pegawai') }}/'+row.pegawai_id+'" class="btn btn-xs btn-success"><i class="fa fa-eye"></i></a></span>';
										}else{
											return  '<span  data-toggle="tooltip" title="Edit" style="margin:1px;" class=""><a href="{{ url('skpd/skp_bulanan') }}/'+row.skp_bulanan_id+'" class="btn btn-xs btn-info"><i class="fa fa-edit"></i></a></span>';
											
										}
									}
								},
								
							]
			
		});
	
	
	});
</script>
