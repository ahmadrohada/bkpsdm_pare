<div class="box {{ $h_box }}">
    <div class="box-header with-border">
        <h1 class="box-title">
            Data SKPD
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
					<th>NAMA SKPD</th>
					<th>JM UNIT KERJA</th>
					<th>JM PEGAWAI</th>
					<th><i class="fa fa-cog" style="margin-left:12px !important;"></i></th>
				</tr>
			</thead>
			
			
		</table>

	</div>
</div>


@section('template_scripts')

    @include('pare_pns.structure.dashboard-scripts')

	<script type="text/javascript">
	$(document).ready(function() {
		//alert();
		
		$('#user_table').DataTable({
				processing      : true,
				serverSide      : true,
				searching      	: true,
				paging          : false,
				//dom 			: '<"toolbar">frtip',
				lengthMenu		: [20,50,100],
				columnDefs		: [
									{ 	className: "text-center", targets: [ 0,2,3,4 ] }/* ,
									{	className: "hidden", targets: [5] } */
								],
				ajax			: {
									url	: '{{ url("api_resource/administrator_skpd_list") }}',
									
									delay:3000
								},
			

				columns	:[
								{ data: 'id' , orderable: true,searchable:false,
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
								{ data: "skpd" , name:"skpd.skpd", orderable: true, searchable: true},
								{ data: "jm_unit_kerja" , orderable: false, searchable: false,width:"120px"},
								{ data: "jm_pegawai" , orderable: false, searchable: false,width:"120px"},
								{ data: "action" , orderable: false,searchable:false,width:"50px",
										"render": function ( data, type, row ) {
											return  '<span  data-toggle="tooltip" title="Lihat" style="margin:1px;" class=""><a href="../admin/skpd/'+row.skpd_id+'/pegawai" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></a></span>';
										
									}
								},
								
							]
			
		});
	
		
		
		});
    </script>

@endsection