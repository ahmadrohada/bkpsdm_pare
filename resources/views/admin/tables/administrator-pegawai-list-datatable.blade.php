<div class="box box-primary">
    <div class="box-header with-border">
        <h1 class="box-title">
            Data Pegawai
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
					<th>NAMA PEGAWAI</th>
					<th>NIP</th>
					<th>SKPD</th>
					<th><i class="fa fa-cog" style="margin-left:12px !important;"></i></th>
				</tr>
			</thead>
			
			
		</table>

	</div>
</div>


@section('template_scripts')

@include('admin.structure.dashboard-scripts')

<script type="text/javascript">
	$(document).ready(function() {
		//alert();
		
		$('#user_table').DataTable({
				processing      : true,
				serverSide      : true,
				searching      	: true,
				paging          : true,
				//dom 			: '<"toolbar">frtip',
				lengthMenu		: [20,50,100],
				columnDefs		: [
									{ 	className: "text-center", targets: [ 0,2,4 ] }
								],
				ajax			: {
									url	: '{{ url("api_resource/administrator_pegawai_list") }}',
									
									delay:3000
								},
				

				columns	:[
								{ data: 'rownum' , orderable: true,searchable:false},
								{ data: "nama_pegawai", name:"nama", orderable: true, searchable: true},
								{ data: "nip" ,  name:"nip", orderable: true, searchable: true},
								{ data: "skpd" , name:"b.unit_kerja", orderable: true, searchable: true},
								{ data: "action" , orderable: false,searchable:false,width:"50px",
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
		
		
	});
</script>

@endsection