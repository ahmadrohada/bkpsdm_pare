<div class="box {{ $h_box }}">
    <div class="box-header with-border">
        <h1 class="box-title">
            Data Unit Kerja
        </h1>

        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
            {!! Form::button('<i class="fa fa-times"></i>', array('class' => 'btn btn-box-tool','title' => 'close', 'data-widget' => 'remove', 'data-toggle' => 'tooltip')) !!}
        </div>
    </div>
	<div class="row" style="padding:5px 30px; min-height:200px;">

		<table id="unit_kerja_table" class="table table-striped table-hover table-condensed">
			<thead>
				<tr class="success">
					<th>NO</th>
					<th>UNIT KERJA</th>
					
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
		
		$('#unit_kerja_table').DataTable({
				processing      : true,
				serverSide      : true,
				searching      	: true,
				paging          : true,
				//order 			: [ 3 , 'asc' ],
				//dom 			: '<"toolbar">frtip',
				lengthMenu		: [50,100],
				columnDefs		: [
									{ 	className: "text-center", targets: [ 0 ] },
									//{ 	className: "hidden-xs", targets: [ 5 ] }
								],
				ajax			: {
									url	: '{{ url("api/administrator_unit_kerja_skpd_list") }}',
									data: { skpd_id : {{$skpd_id}} },
									delay:3000
								},
				

				columns	:[
								{ data: 'unit_kerja_id' , orderable: true,searchable:false,
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
								{ data: "nama_unit_kerja", name:"unit_kerja.unit_kerja", orderable: true, searchable: true},
								
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