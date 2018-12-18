<div class="box box-primary">
    <div class="box-header with-border">
		
	
		
        <h3 class="box-title">
			<small>
				<i class="fa fa-tasks"></i>
				<span class="text-primary">KEGIATAN TUGAS JABATAN</span>
			</small>
        </h3>
		

        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
        </div>
    </div>



	<div class="box-body table-responsive">

        
		
		<div class="toolbar">
			
			<span  data-toggle="tooltip" title="Add Kegiatan SKP Tahunan"><a class="btn btn-info btn-sm add_kegiatan_skp_tahunan" data-toggle="modal" data-target=".add-kegiatan_skp_tahunan_modal"><i class="fa fa-plus" ></i> Kegiatan</a></span>
		
		</div>


		<table id="kegiatan_table" class="table table-striped table-hover" >
			<thead>
				<tr>
					<th rowspan="2">No</th>
					<th rowspan="2">KEGIATAN TUGAS JABATAN</th>
					<th rowspan="2">AK</th>
					<th colspan="4">TARGET</th>
					<th rowspan="2">AKSI</th>
				</tr>
				<tr>
					<th>OUTPUT</th>
					<th>MUTU</th>
					<th>WAKTU</th>
					<th>BIAYA</th>
				</tr>
			</thead>
			
		</table>

	</div>
</div>


@include('admin.modals.add-kegiatan_skp_tahunan')


<script type="text/javascript">
$(document).ready(function() {

	

    var table_program = $('#kegiatan_table').DataTable({
			processing      : false,
			serverSide      : true,
			searching      	: true,
			paging          : true,
			lengthMenu		: [20],
			dom 			: '<"toolbar">frtip',
			columnDefs		: [
								{ className: "text-center", targets: [ 0,2,3,4,5,7 ] },
								{ className: "text-right", targets: [ 6 ] }
							  ],
			ajax			: {
								url	: '',
								data: { skp_tahunan_id:'7' },
							  },
			columns			: [
								{ data: 'rownum', orderable: true, searchable: false ,width:"30px"},
								{ data: "label", name:"label", orderable: true, searchable: true},
								{ data: "ak", name:"ak", orderable: true, searchable: true},
								{ data: "output", name:"output", orderable: true, searchable: true},
								{ data: "mutu", name:"mutu", orderable: true, searchable: true},
								{ data: "waktu", name:"waktu", orderable: true, searchable: true},
								{ data: "biaya", name:"biaya", orderable: true, searchable: true},
								{  data: 'action' , orderable: false,searchable:false,
										"render": function ( data, type, row ) {

										if ( row.status == 'add'){
											return  '<span  data-toggle="tooltip" title="Add" style="margin:1px;" ><a class="btn btn-info btn-xs " data-toggle="modal" data-target=".create-indikator_kegiatan_modal"  data-id="'+row.kegiatan_id+'"><i class="fa fa-plus" ></i></a></span>';
										}else if ( row.status == 'edit'){
											return  '<span  data-toggle="tooltip" title="Edit" style="margin:1px;" ><a class="btn btn-success btn-xs " data-toggle="modal" data-target=".create-indikator_kegiatan_modal"  data-id="'+row.kegiatan_id+'"><i class="fa fa-edit" ></i></a></span>';
										}else{
											return  '<span  data-toggle="tooltip" title="" style="margin:1px;" ><a class="btn btn-default btn-xs " data-toggle="modal" data-target=".create-indikator_kegiatan_modal"  data-id="'+row.kegiatan_id+'"><i class="fa fa-edit" ></i></a></span>';
										}
												
									
									}
								},
							
						      ],
						initComplete: function(settings, json) {
							
   				 		}
		
	});	

	

});
</script>
