<div class="box box-tujuan div_tujuan_list">
    <div class="box-header with-border">
		<h1 class="box-title">
			Tujuan ( {{ $renja->Periode->label}} )
		</h1>
		
		<div class="box-tools pull-right">
			{!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
		</div>
    </div>



	<div class="box-body table-responsive">

		<div class="toolbar">
			
		</div>
		<table id="tujuan_table" class="table table-striped table-hover table-condensed" >
			<thead>
				<tr class="success">
					<th>NO</th>
					<th >LABEL</th>
				</tr>
			</thead>
			
		</table>

	</div>
</div>


<script type="text/javascript">


    $('#tujuan_table').DataTable({
				destroy			: true,
				processing      : false,
				serverSide      : true,
				searching      	: false,
				paging          : false,
			columnDefs		: [
								{ className: "text-center", targets: [ 0] }
							  ],
			ajax			: {
								url	: '{{ url("api_resource/skpd-renja_tujuan_list") }}',
								data: { renja_id: {!! $renja->id !!} },
							 }, 
			columns			:[
							{ data: 'tujuan_id' , orderable: true,searchable:false,width:"30px",
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
							{ data: "label", name:"x", orderable: true, searchable: true},
							
						],
						initComplete: function(settings, json) {
							
   				 		}
		
	});	

</script>
