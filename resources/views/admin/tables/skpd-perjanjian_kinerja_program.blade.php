<div class="box box-primary">
    <div class="box-header with-border">

        <h3 class="box-title">
			<small>
				<i class="fa fa-tasks"></i>
				<span class="text-primary">INDIKATOR SASARAN</span>
			</small>
        </h3>
		<p style="margin-left:15px;" class="label-perjanjian-kinerja">
			{{ $indikator_sasaran->label}}
		</p>

		<h3 class="box-title" style="margin-top:10px;">
			<small>
				<i class="fa fa-line-chart"></i>
				<span class="text-primary">TARGET</span>
			</small>
        </h3>
		<p style="margin-left:15px;" class="label-perjanjian-kinerja">
			{{ $indikator_sasaran->target}}&nbsp;{{ $indikator_sasaran->satuan}}
		</p>

        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
        </div>
    </div>



	<div class="box-body table-responsive">

		<div class="toolbar">
			
			<span  data-toggle="tooltip" title="Create Program"><a class="btn btn-info btn-sm create_program" data-toggle="modal" data-target=".create-program_modal"><i class="fa fa-plus" ></i> Program</a></span>
		
		</div>

		<table id="program_table" class="table table-striped table-hover table-condensed" >
			<thead>
				<tr class="success">
					<th>NO</th>
					<th >PROGRAM</th>
					<th ><i class="fa fa-tags"></i></th>
					<th>INDIKATOR</th>
				</tr>
			</thead>
			
		</table>

	</div>
</div>



@include('admin.modals.create-program')
@include('admin.modals.create-indikator_program')


<script type="text/javascript">
$(document).ready(function() {

	$(document).on('click','.create_program',function(e){
		$('.indikator_sasaran_label').html( '{!! $indikator_sasaran->label !!}' );
		$('.indikator_sasaran_id').val( '{!! $indikator_sasaran->id !!}' );	
		$('.create-program-modal').find('[name=label],[name=target],[name=satuan]').val('');

	});

	$('.create-indikator_program_modal').on('hidden.bs.modal', function(){
		$('#program_table').DataTable().ajax.reload(null,false);
	});

	$(document).on('click','.create_indikator_program',function(e){
		$('.program_label').html($(this).data('label'));
		$('.program_id').val($(this).data('id'));	
		$('.create-indikator_program_modal').find('[name=label],[name=target],[name=satuan]').val('');
	});

    var table_program = $('#program_table').DataTable({
			processing      : true,
			serverSide      : true,
			searching      	: true,
			paging          : false,
			dom 			: '<"toolbar">frtip',
			columnDefs		: [
								{ className: "text-center", targets: [ 0,2,3 ] }
							  ],
			ajax			: {
								url	: '{{ url("api_resource/skpd_program_perjanjian_kinerja_list") }}',
								data: { indikator_sasaran_id: {{ $indikator_sasaran->id }} },
							  },
			columns			: [
								{ data: 'rownum' , orderable: false,searchable:false,width:'30px'},
								{ data: "label", name:"label", orderable: true, searchable: true},
								{  data: 'jm_child' , orderable: false,searchable:false,
										"render": function ( data, type, row ) {
											return  '<span class="badge bg-yellow" style="width:30px;">'+row.jm_child+'</span>';
											
										}
								},
								{  data: 'action' , orderable: false,searchable:false,
										"render": function ( data, type, row ) {
											
											return  '<span  data-toggle="tooltip" title="Add Indikator Program" style="margin:1px;" ><a class="btn btn-info btn-xs create_indikator_program" data-toggle="modal" data-target=".create-indikator_program_modal" data-label="'+row.label+'" data-id="'+row.program_id+'"><i class="fa fa-plus" ></i></a></span>'+	
													'<span  data-toggle="tooltip" title="Lihat Indikator Program" style="margin:1px;" class=""><a href="../program/'+row.program_id+'" class="btn btn-xs btn-success"><i class="fa fa-eye"></i></a></span>'+
													'<span  data-toggle="tooltip" title="Delete Program" style="margin:1px;" class="btn btn-danger btn-xs hapus_program"><i class="fa fa-remove" style=""></i></span>';


									}
								},
							
						      ],
						initComplete: function(settings, json) {
							
   				 		}
		
	});	





	
});
</script>
