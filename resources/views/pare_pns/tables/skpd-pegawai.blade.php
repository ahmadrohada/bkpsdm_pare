<div class="box {{ $h_box }}">
    <div class="box-header with-border">
        <h1 class="box-title">
            Data Pegawai
        </h1>

        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
            {!! Form::button('<i class="fa fa-times"></i>', array('class' => 'btn btn-box-tool','title' => 'close', 'data-widget' => 'remove', 'data-toggle' => 'tooltip')) !!}
        </div>
	</div>
	<div class="row" style="padding:5px 30px; min-height:200px;">
		<div class="box-body table-responsive">
			<table id="pegawai_table" class="table table-striped table-hover table-condensed">
				<thead>
					<tr class="success">
					<th>NO</th>
						<th>NIP</th>
						<th>NAMA LENGKAP</th>
						<th>GOL</th>
						<th>JABATAN</th>
						<th>ESL</th>
						<th>UNIT KERJA</th>
						<th><i class="fa fa-cog" style="margin-left:12px !important;"></i></th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>

<script type="text/javascript">




		$('#pegawai_table').DataTable({
				destroy			: true,
				processing      : true,
				serverSide      : true,
				searching      	: true,
				paging          : true,
				autoWidth		: false,
				bInfo			: false,
				bSort			: false,
				lengthChange	: false,
				//order 			: [ 0 , 'asc' ],
				lengthMenu		: [10,25,50],
				columnDefs		: [
									{ 	className: "text-center", targets: [ 0,1,3,5,7] }/* ,
									{ 	className: "hidden-xs", targets: [ 5 ] } */
								],
				ajax			: {
									url	: '{{ url("api/administrator_pegawai_skpd_list") }}',
									data: { skpd_id : {{$skpd_id}} }
								},
				

				columns	:[
								{ data: 'pegawai_id' , orderable: true,searchable:false,
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
								
								{ data: "nip" ,  name:"pegawai.nip", orderable: true, searchable: false},
								{ data: "nama_pegawai", name:"pegawai.nama", orderable: true, searchable: true},
								{ data: "golongan" ,  name:"golongan.golongan", orderable: true, searchable: true},
								{ data: "jabatan" ,  name:"a.jabatan", orderable: true, searchable: true},
								{ data: "eselon" ,  name:"eselon.eselon", orderable: true, searchable: true},
								{ data: "nama_unit_kerja" , name:"unit_kerja.unit_kerja", orderable: true, searchable: false},
								{ data: "action" , orderable: false,searchable:false,width:"50px",
										"render": function ( data, type, row ) {

										if ( row.user == '1'){
											return  '<span  data-toggle="tooltip" title="Lihat" style="margin:1px;" class=""><a href="../skpd/pegawai/'+row.pegawai_id+'" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></a></span>';
										}else{
											return  '<span  data-toggle="tooltip" title="Tambah" style="margin:1px;" class=""><a href="../skpd/pegawai/'+row.pegawai_id+'/add" class="btn btn-xs btn-warning"><i class="fa fa-user-plus"></i></a></span>';
											
										}
									}
								},
								
							]
			
		});
	
</script>
