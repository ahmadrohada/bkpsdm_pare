<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">
			<small>
				<i class="fa fa-tasks"></i>
				<span class="text-primary"> PROGRAM</span>
			</small>
        </h3>

        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
            {!! Form::button('<i class="fa fa-times"></i>', array('class' => 'btn btn-box-tool','title' => 'close', 'data-widget' => 'remove', 'data-toggle' => 'tooltip')) !!}
        </div>
    </div>



	<div class="box-body table-responsive">

        <a class="btn btn-sm btn-success add_program" href="#" title="" style="margin-left:15px;"><span class="fa fa-plus"></span> Add Program</a>
        



		
		<table id="program" class="table table-striped table-hover table-condensed" >
			<thead>
				<tr class="success">
					<th>NO</th>
					<th >LABEL</th>
					<th>ACTION</th>
				</tr>
			</thead>
			
		</table>

	</div>
</div>



@include('admin.modals.add-indikator-sasaran')


   


<script type="text/javascript">
$(document).ready(function() {
	//alert();
	

     $(document).on('click','.add_indikator_sasaran',function(e){
        $('.add-indikator-sasaran').modal('show');
	});

    $('#program').DataTable({
			processing      : true,
			serverSide      : true,
			searching      	: false,
			paging          : false,
			columnDefs		: [
								{ className: "text-center", targets: [ 0,2 ] }
							  ],
			ajax			: {
								url: '{{ action('ProgramController@DataProgram') }}',
								data: { indikator_sasaran_id: {{ $indikator_sasaran->id }} },
							 },
			columns			:[
							{ data: 'rownum' , orderable: false,searchable:false, width:"60px",
								"render": function ( data, type, row ) {
									return row.rownum;
									/* switch (row.rownum) {
									case 1:
										return '<i class="fa fa-close text-red">'+row.rownum+'</i>';
										break;
									case 2:
										return '<i class="fa fa-check text-blue">'+row.rownum+'</i>';
										break; 
									} */
							}},
							{ data: "label", name:"x", orderable: true, searchable: true},
							{ data: 'action', orderable: false, searchable: false ,width:"150px"}
							
						],
						initComplete: function(settings, json) {
							
   				 		}
		
	});	
	
});
</script>
