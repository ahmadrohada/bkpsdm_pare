<div class="box box-success">
    <div class="box-header with-border">
		<h1 class="box-title">
            Data User
        </h1>

        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
            {!! Form::button('<i class="fa fa-times"></i>', array('class' => 'btn btn-box-tool','title' => 'close', 'data-widget' => 'remove', 'data-toggle' => 'tooltip')) !!}
        </div>
	</div>
	<div class="row" style="padding:5px 30px; min-height:200px;">
		<div class="box-body table-responsive">
			<table id="user_table" class="table table-striped table-hover">
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
</div>


@section('template_scripts')

    @include('pare_pns.structure.dashboard-scripts')

	<script type="text/javascript">
	$(document).ready(function() {
		//alert();
		
		$('#user_table').DataTable({
					destroy			: true,
					processing      : true,
					serverSide      : true,
					searching      	: true,
					paging          : true,
					autoWidth		: false,
					deferRender		: true,
					bInfo			: false,
					bSort			: true,
					lengthChange	: false,
					//order 			: [ 0 , 'desc' ],
					lengthMenu		: [10,25,50],
				columnDefs		: [
									{ 	className: "text-center", targets: [ 0,1,3,5,7] }/* ,
									{	className: "hidden", targets: [5] } */
								],
				ajax			: {
									url	: '{{ url("api_resource/administrator_users_list") }}'
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
											return  '<span  data-toggle="tooltip" title="Lihat" style="margin:1px;" class=""><a href="../admin/users/'+row.user_id+'" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></a></span>';
										
									}
								},
								
							]
			
		});
	
		
		
		});
    </script>

@endsection