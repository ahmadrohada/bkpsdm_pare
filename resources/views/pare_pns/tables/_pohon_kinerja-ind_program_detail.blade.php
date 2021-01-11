<div class="box box-program div_program_detail" hidden>
	<div class="box-header with-border">
		<h1 class="box-title">
			Program
		</h1>

		<div class="box-tools pull-right">
			{!! Form::button('<i class="fa fa-remove "></i>', array('class' => 'btn btn-box-tool tutup_detail','title' => 'Tutup', 'data-toggle' => 'tooltip')) !!}
		</div>
	</div>
	<div class="box-body table-responsive">
		<p class="text-muted " style="margin-top:8px;padding-bottom:10px;">
			<span class="txt_program_label"></span>
		</p>
			
	</div>
</div>
<div class="box box-primary div_ind_program_list" hidden>
    <div class="box-header with-border">
		<h1 class="box-title">
            List Indikator Program
        </h1>

        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
        </div>
    </div>



	<div class="box-body table-responsive">

		<div class="toolbar">
			
		</div>
		<table id="ind_program_table" class="table table-striped table-hover table-condensed" >
			<thead>
				<tr class="success">
					<th>NO</th>
					<th >LABEL</th>
					<th >TARGET</th>
				</tr>
			</thead>
			
		</table>

	</div>
</div>


<script type="text/javascript">

    
function load_ind_program(program_id){


$.ajax({
		url			: '{{ url("api/program_detail") }}',
		data 		: {program_id : program_id},
		method		: "GET",
		dataType	: "json",
		success	: function(data) {
				$('.txt_program_label').html(data['label']);
				$('.program_id').val(data['id']);
				
		},
		error: function(data){
			
		}						
});


$('#ind_program_table').DataTable({
			destroy			: true,
			processing      : false,
			serverSide      : true,
			searching      	: false,
			paging          : false,
			columnDefs		: [
								{ className: "text-center", targets: [ 0,2 ] }
							],
			ajax			: {
								url	: '{{ url("api/skpd-renja_ind_program_list") }}',
								data: { program_id: program_id },
							}, 
			columns			:[
							{ data: 'ind_program_id' , orderable: true,searchable:false,width:"30px",
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
							{ data: "label_ind_program", name:"label_ind_program", orderable: true, searchable: true},
							{ data: "target_ind_program", name:"target_ind_program", orderable: true, searchable: true, width:"90px"},
							
						],
						initComplete: function(settings, json) {
							
							}
	
	
});	


}


</script>
