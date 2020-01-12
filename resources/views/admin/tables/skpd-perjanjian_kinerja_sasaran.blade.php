

<div class="box box-primary">
    <div class="box-header with-border">
		<h3 class="box-title">
			<small>
				<i class="fa fa-institution"></i>
				<span class="text-primary"> SKPD</span>	
			</small>
        </h3>
		<p style="margin-left:15px;" class="label-perjanjian_kinerja">
			 {{ Pustaka::capital_string($perjanjian_kinerja->skpd->unit_kerja) }}
			 [ {{ $perjanjian_kinerja->skpd->id }} ]
		</p>

		

        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
        </div>
    </div>




	<div class="box-body table-responsive">

		<div class="toolbar">
			
			<span  data-toggle="tooltip" title="Add Sasaran"><a class="btn btn-info btn-sm add_sasaran" data-toggle="modal" data-target=".add-sasaran"><i class="fa fa-plus" ></i> Sasaran</a></span>
		
		</div>

		<table id="sasaran_table" class="table table-striped table-hover table-condensed">
			<thead>
				<tr class="success">
					<th>NO</th>
					<th >SASARAN PERJANJIAN KINERJA</th>
					<th ><i class="fa fa-tags"></i></th>
					<th>INDIKATOR</th>
				</tr>
			</thead>
			
		</table>

	</div>


	
</div>



@include('admin.modals.add-sasaran')
@include('admin.modals.create-indikator_sasaran')



<script type="text/javascript">
$(document).ready(function() {

	
    var table_sasaran = $('#sasaran_table').DataTable({
			processing      : true,
			serverSide      : true,
			searching      	: true,
			paging          : false,
			dom 			: '<"toolbar">frtip',
			lengthMenu		: [2,10],
			columnDefs		: [
								{ className: "text-center", targets: [ 0,3 ] }
							  ],
			ajax			: {
								url	: '{{ url("api_resource/skpd_sasaran_perjanjian_kinerja_list") }}',
								data: { perjanjian_kinerja_id: {{ $perjanjian_kinerja->id }} },
								delay:3000
							  },
			columns			: [
								{ data: 'rownum' , orderable: false,searchable:false},
								{ data: "label", name:"label", orderable: true, searchable: true},
								{  data: 'jm_child' , orderable: false,searchable:false,
										"render": function ( data, type, row ) {
											return  '<span class="badge bg-yellow" style="width:30px;">'+row.jm_child+'</span>';
											
										}
								},
								{  data: 'action' , orderable: false,searchable:false,
										"render": function ( data, type, row ) {
											
											return  '<span  data-toggle="tooltip" title="Add Indikator" style="margin:1px;" ><a class="btn btn-info btn-xs create_indikator_sasaran" data-toggle="modal" data-target=".create-indikator_sasaran_modal" data-label="'+row.label+'" data-id="'+row.sasaran_perjanjian_kinerja_id+'"><i class="fa fa-plus" ></i></a></span>'+	
													'<span  data-toggle="tooltip" title="Lihat Indikator" style="margin:1px;" class=""><a href="./sasaran-perjanjian_kinerja/'+row.sasaran_perjanjian_kinerja_id+'" class="btn btn-xs btn-success"><i class="fa fa-eye"></i></a></span>'+
													'<span  data-toggle="tooltip" title="Delete Sasaran" style="margin:1px;" class="btn btn-danger btn-xs hapus_sasaran"><i class="fa fa-remove" style=""></i></span>';


										}
								},
							  
						      ],
						initComplete: function(settings, json) {
							
   				 		}
		
	});	

	$('.create-indikator_sasaran_modal').on('hidden.bs.modal', function(){
		$('#sasaran_table').DataTable().ajax.reload(null,false);
	});

	$(document).on('click','.create_indikator_sasaran',function(e){
		$('.sasaran_perjanjian_kinerja_label').html($(this).data('label'));
		$('.sasaran_perjanjian_kinerja_id').val($(this).data('id'));	
		$('.create-indikator_sasaran_modal').find('[name=label],[name=target]').val('');
	});

	
});
</script>
