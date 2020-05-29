<div class="box box-primary">
    <div class="box-header with-border">

        <h3 class="box-title">
			<small>
				<i class="fa fa-tasks"></i>
				<span class="text-primary">SASARAN</span>
			</small>
        </h3>
		<p style="margin-left:15px;" class="label-perjanjian_kinerja">
			{{ $sasaran->sasaran->label}}
		</p>
        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
        </div>
    </div>



	<div class="box-body table-responsive">

		<div class="toolbar">
			
			<span  data-toggle="tooltip" title="Create Indikator Sasaran"><a class="btn btn-info btn-sm create_indikator_sasaran" data-toggle="modal" data-target=".create-indikator_sasaran_modal"><i class="fa fa-plus" ></i> Indikator</a></span>
		
		</div>
		
		<table id="indikator_sasaran_table" class="table table-striped table-hover table-condensed" >
			<thead>
				<tr>
					<th>No</th>
					<th >INDIKATOR SASARAN</th>
					<th >TARGET</th>
					<th ><i class="fa fa-tags"></i></th>
					<th>PROGRAM</th>
				</tr>
			</thead>
			
		</table>

	</div>
</div>



@include('pare_pns.modals.create-indikator_sasaran')
@include('pare_pns.modals.create-program')


   



<script type="text/javascript">
$(document).ready(function() {
	
	

	$(document).on('click','.create_indikator_sasaran',function(e){
		$('.sasaran_perjanjian_kinerja_label').html( '{!! $sasaran->sasaran->label !!}' );
		$('.sasaran_perjanjian_kinerja_id').val( '{!! $sasaran->id !!}' );	
		$('.create-indikator_sasaran_modal').find('[name=label],[name=target],[name=satuan]').val('');

	});

	$('.create-program_modal').on('hidden.bs.modal', function(){
		$('#indikator_sasaran_table').DataTable().ajax.reload(null,false);
	});

	$(document).on('click','.create_program',function(e){
		$('.indikator_sasaran_label').html($(this).data('label'));
		$('.indikator_sasaran_id').val($(this).data('id'));	
		$('.create-program_modal').find('[name=label],[name=target]').val('');
	});

    $('#indikator_sasaran_table').DataTable({
			processing      : true,
			serverSide      : true,
			searching      	: true,
			paging          : false,
			dom 			: '<"toolbar">frtip',
			columnDefs		: [
								{ className: "text-center", targets: [ 0,2,3,4 ] }
							  ],
			ajax			: {
				
								url			: '{{ url("api_resource/skpd_indikator_sasaran_perjanjian_kinerja_list") }}',
								data		: { sasaran_perjanjian_kinerja_id: {{ $sasaran->id }} },
								delay		: 3000
							 },
			columns			:[
								{ data: 'rownum' , orderable: false, searchable:false },
							  	{ data: "label", name:"label", orderable: false, searchable: false},
							  	{ data: "target", name:"target", orderable: false, searchable: false},
							  	{  data: 'jm_child' , orderable: false,searchable:false,
									"render": function ( data, type, row ) {
										return  '<span class="badge bg-yellow" style="width:30px;">'+row.jm_child+'</span>';
										
									}
							 	},
							  	{  data: 'action' , orderable: false,searchable:false,
									"render": function ( data, type, row ) {
										
										return  '<span  data-toggle="tooltip" title="Add Program" style="margin:1px;" ><a class="btn btn-info btn-xs create_program" data-toggle="modal" data-target=".create-program_modal" data-label="'+row.label+'" data-id="'+row.indikator_sasaran_id+'"><i class="fa fa-plus" ></i></a></span>'+	
												'<span  data-toggle="tooltip" title="Lihat Program" style="margin:1px;" class=""><a href="../indikator-sasaran/'+row.indikator_sasaran_id+'" class="btn btn-xs btn-success"><i class="fa fa-eye"></i></a></span>'+
												'<span  data-toggle="tooltip" title="Delete Indikator Sasaran" style="margin:1px;" class="btn btn-danger btn-xs hapus_indikator_sasaran"><i class="fa fa-remove" style=""></i></span>';


									}
							  	},
							
						],
						initComplete: function(settings, json) {
							
   				 		}
		
	});	
	
});
</script>
