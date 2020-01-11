<div class="box box-info">
    <div class="box-header with-border">
        <h1 class="box-title">
            Data ASN Kabupaten Karawang
        </h1>

        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
            {!! Form::button('<i class="fa fa-times"></i>', array('class' => 'btn btn-box-tool','title' => 'close', 'data-widget' => 'remove', 'data-toggle' => 'tooltip')) !!}
        </div>
    </div>
	<div class="box-body table-responsive">

		<table id="user_table" class="table table-striped table-hover table-condensed">
			<thead>
				<tr class="success">
					<th>NO</th>
					<th>NIP</th>
					<th>NAMA LENGKAP</th>
					<th>GOL</th>
					<th>JABATAN</th>
					<th>ESL</th>
					<th>SKPD</th>
					<th><i class="fa fa-cog" style="margin-left:12px !important;"></i></th>
				</tr>
			</thead>
			
			
		</table>

	</div>
</div>



<script type="text/javascript">
	
		//alert();
		
		$('#user_table').DataTable({
				processing      : true,
				serverSide      : true,
				searching      	: true,
				paging          : true,
				//order 			: [ 3 , 'asc' ],
				//dom 			: '<"toolbar">frtip',
				lengthMenu		: [20,50,100],
				columnDefs		: [
									{ 	className: "text-center", targets: [ 0,1,3,5,7] }
								],
				ajax			: {
									url	: '{{ url("api_resource/administrator_pegawai_list") }}',
									//data: { page : 4 , dtpage : 13 }, //PAGINATION bawaan laravel
								},
				

				columns	:[
								{ data: 'pegawai_id' , orderable: true,searchable:false,width:"40px",
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
								{ data: "nip" ,  name:"tb_pegawai.nip", orderable: true, searchable: true,width:"120px"},
								{ data: "nama_pegawai", name:"tb_pegawai.nama", orderable: true, searchable: true,width:"180px"},
								{ data: "golongan" ,  name:"golongan.golongan", orderable: true, searchable: true,width:"40px"},
								{ data: "jabatan" ,  name:"jabatan.skpd", orderable: true, searchable: true,width:"240px"},
								{ data: "eselon" ,  name:"eselon.eselon", orderable: true, searchable: true,width:"60px"},
								{ data: "skpd" ,  name:"skpd.skpd", orderable: true, searchable: true},
								{ data: "action" , orderable: false,searchable:false,width:"35px",
										"render": function ( data, type, row ) {

										if ( row.action == '1'){
											return  '<span  data-toggle="tooltip" title="Lihat" style="margin:1px;" class=""><a href="../admin/pegawai/'+row.pegawai_id+'" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></a></span>';
										}else{
											return  '<span  data-toggle="tooltip" title="Tambah" style="margin:1px;" class=""><a href="../admin/pegawai/'+row.pegawai_id+'/add" class="btn btn-xs btn-warning"><i class="fa fa-user-plus"></i></a></span>';
											
										}
									}
								},
								
							]
			
		});
	
	/* 	$(document).on('click','.lihat',function(e){
			
			pegawai_id = $(this).val();
			alert(pegawai_id);

			//window.location.assign("lihat_users");
		}); */
		
		
</script>
