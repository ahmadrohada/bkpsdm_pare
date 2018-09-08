<div class="box box-primary">
    <div class="box-header with-border">

		
        <h3 class="box-title">
			<small>
				<i class="fa fa-tasks"></i>
				<span class="text-primary">PROGRAM</span>
			</small>
        </h3>
		<p style="margin-left:15px;" class="label-perjanjian-kinerja">
			{{ $program->label}}
		</p>
        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
        </div>
    </div>



	<div class="box-body table-responsive">
		
		<div class="toolbar">
			
			<span  data-toggle="tooltip" title="Create Indikator Program"><a class="btn btn-info btn-sm create_indikator_program" data-toggle="modal" data-target=".create-indikator_program_modal"><i class="fa fa-plus" ></i> Indikator</a></span>
		
		</div>

		<table id="indikator_program_table" class="table table-striped table-hover table-condensed" >
			<thead>
				<tr>
					<th>NO</th>
					<th >INDIKATOR PROGRAM</th>
					<th>TARGET</th>
					<th ><i class="fa fa-tags"></i></th>
					<th>KEGIATAN</th>
				</tr>
			</thead>
			
		</table>

	</div>
</div>
@include('admin.modals.create-indikator_program')
@include('admin.modals.create-kegiatan')

   



<script type="text/javascript">
$(document).ready(function() {
	
	

	$(document).on('click','.create_indikator_program',function(e){
		$('.program_label').html( '{!! $program->label !!}' );
		$('.program_id').val( '{!! $program->id !!}' );	
		$('.create-indikator_program_modal').find('[name=label],[name=target],[name=satuan]').val('');

	}); 

	$('.create-kegiatan_modal').on('hidden.bs.modal', function(){
		$('#indikator_program_table').DataTable().ajax.reload(null,false);
	});

	$(document).on('click','.create_kegiatan',function(e){
		$('.indikator_program_label').html($(this).data('label'));
		$('.indikator_program_id').val($(this).data('id'));	
		$('.create-indikator_program_modal').find('[name=label],[name=target],[name=satuan]').val('');
	});



    $('#indikator_program_table').DataTable({
			processing      : true,
			serverSide      : true,
			searching      	: true,
			paging          : false,
			dom 			: '<"toolbar">frtip',
			lengthMenu		: [2,10],
			columnDefs		: [
								{ className: "text-center", targets: [ 0,2,3,4] }
							  ],
			ajax			: {
				
								url	: '{{ url("api_resource/skpd_indikator_program_perjanjian_kinerja_list") }}',
								data: { program_id: {{ $program->id }} },
							 },
			columns			:[
								{ data: 'rownum', orderable: true, searchable: false ,width:"30px"},
								{ data: "label", name:"label", orderable: true, searchable: true},
								{ data: "target", name:"target", orderable: false, searchable: false},
								{  data: 'jm_child' , orderable: false,searchable:false,
										"render": function ( data, type, row ) {
											return  '<span class="badge bg-yellow" style="width:30px;">'+row.jm_child+'</span>';
											
										}
								},
								{  data: 'action' , orderable: false,searchable:false,
										"render": function ( data, type, row ) {
											
											return  '<span  data-toggle="tooltip" title="Add Kegiatan" style="margin:1px;" ><a class="btn btn-info btn-xs create_kegiatan" data-toggle="modal" data-target=".create-kegiatan_modal" data-label="'+row.label+'" data-id="'+row.indikator_program_id+'"><i class="fa fa-plus" ></i></a></span>'+	
													'<span  data-toggle="tooltip" title="Lihat Kegiatan" style="margin:1px;" class=""><a href="../indikator-program/'+row.indikator_program_id+'" class="btn btn-xs btn-success"><i class="fa fa-eye"></i></a></span>'+
													'<span  data-toggle="tooltip" title="Delete Indikator Program" style="margin:1px;" class="btn btn-danger btn-xs hapus_program"><i class="fa fa-remove" style=""></i></span>';


									}
								},
							
							],
							initComplete: function(settings, json) {
							
   				 			}
		
	});	
	
});
</script>
