<div class="box box-primary" style="min-height:500px;">
    <div class="box-header with-border">
		
        <h3 class="box-title" style="margin-top:10px;">
			<small>
				<i class="fa fa-tasks"></i>
				<span class="text-primary">INDIKATOR PROGRAM</span>
			</small>
        </h3>
		<p style="margin-left:15px;" class="label-perjanjian_kinerja">
			{{ $indikator_program->label}}
		</p>

		<h3 class="box-title" style="margin-top:10px;">
			<small>
				<i class="fa fa-line-chart"></i>
				<span class="text-primary">TARGET</span>
			</small>
        </h3>
		<p style="margin-left:15px;" class="label-perjanjian_kinerja">
			{{ $indikator_program->target}}&nbsp;{{ $indikator_program->satuan}}
		</p>

        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
        </div>
    </div>



	<div class="box-body table-responsive">

        <div class="toolbar">
			
			<span  data-toggle="tooltip" title="Create Kegiatan"><a class="btn btn-info btn-sm create_kegiatan" data-toggle="modal" data-target=".create-kegiatan_modal"><i class="fa fa-plus" ></i> Kegiatan</a></span>
		
		</div>

		<table id="kegiatan_table" class="table table-striped table-hover table-condensed" >
			<thead>
				<tr class="success">
					<th>NO</th>
					<th >KEGIATAN</th>
					<th >PENGELOLA</th>
					<th ><i class="fa fa-tags"></i></th>
					<th>INDIKATOR</th>
				</tr>
			</thead>
			
		</table>

	</div>
</div>



@include('admin.modals.create-kegiatan')
@include('admin.modals.create-indikator_kegiatan')


<script type="text/javascript">
$(document).ready(function() {

	$(document).on('click','.create_kegiatan',function(e){
		$('.indikator_program_label').html( '{!! $indikator_program->label !!}' );
		$('.indikator_program_id').val( '{!! $indikator_program->id !!}' );	
		$('.create-kegiatan_modal').find('[name=label],[name=target]').val('');

	});


	$('.create-kegiatan_modal').on('hidden.bs.modal', function(){
		$('#indikator_program_table').DataTable().ajax.reload(null,false);
	});

	$(document).on('click','.create_indikator_kegiatan',function(e){
		$('.kegiatan_label').html($(this).data('label'));
		$('.kegiatan_id').val($(this).data('id'));	
		$('.create-indikator_kegiatan_modal').find('[name=label],[name=target],[name=satuan]').val('');
	});

    var table_program = $('#kegiatan_table').DataTable({
		processing      : true,
			serverSide      : true,
			searching      	: true,
			paging          : true,
			dom 			: '<"toolbar">frtip',
			lengthMenu		: [10],
			columnDefs		: [
								{ className: "text-center", targets: [ 0,3,4 ] }
							  ],
			ajax			: {
								url	: '{{ url("api_resource/skpd_kegiatan_perjanjian_kinerja_list") }}',
								data: { indikator_program_id: {{ $indikator_program->id }} },
							  },
			columns			: [
								{ data: 'rownum', orderable: true, searchable: false ,width:"30px"},
								{ data: "label", name:"label", orderable: true, searchable: true},
								{ data: "pengelola", name:"pengelola", orderable: true, searchable: true},
								{  data: 'jm_child' , orderable: false,searchable:false,
										"render": function ( data, type, row ) {
											return  '<span class="badge bg-yellow" style="width:30px;">'+row.jm_child+'</span>';
											
										}
								},
								{  data: 'action' , orderable: false,searchable:false,
										"render": function ( data, type, row ) {
											
											return  '<span  data-toggle="tooltip" title="Add Indikator Kegiatan" style="margin:1px;" ><a class="btn btn-info btn-xs create_indikator_kegiatan" data-toggle="modal" data-target=".create-indikator_kegiatan_modal" data-label="'+row.label+'" data-id="'+row.kegiatan_id+'"><i class="fa fa-plus" ></i></a></span>'+	
													'<span  data-toggle="tooltip" title="Lihat Indikator Kegiatan" style="margin:1px;" class=""><a href="../kegiatan/'+row.kegiatan_id+'" class="btn btn-xs btn-success"><i class="fa fa-eye"></i></a></span>'+
													'<span  data-toggle="tooltip" title="Delete Kegiatan" style="margin:1px;" class="btn btn-danger btn-xs hapus_kegiatan"><i class="fa fa-remove" style=""></i></span>';


									}
								},
							
						      ],
						initComplete: function(settings, json) {
							
   				 		}
		
	});	


	$('.create-kegiatan-modal').on('hidden.bs.modal', function(){
		$('#kegiatan_table').DataTable().ajax.reload(null,false);
		
	});


	
});
</script>
