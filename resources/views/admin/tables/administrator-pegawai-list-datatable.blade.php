<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">
            
        </h3>

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
					<th>ACTION</th>
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
									{ 	className: "text-center", targets: [ 0,2 ] },
									{	className: "hidden", targets: [4] }
								],
				ajax			: {
									url	: '{{ url("api_resource/administrator_pegawai_list") }}',
									
									delay:3000
								},
				

				columns	:[
								{ data: 'rownum' , orderable: true,searchable:false},
								{ data: "nama_pegawai", name:"pegawai.nama", orderable: true, searchable: true},
								{ data: "nip" ,  name:"pegawai.nip", orderable: true, searchable: true},
								{ data: "skpd" , name:"skpd", orderable: true, searchable: true},
								{ data: 'action', orderable: false, searchable: false ,width:"150px"}
								
							]
			
		});
	
		
		
		});
    </script>

@endsection