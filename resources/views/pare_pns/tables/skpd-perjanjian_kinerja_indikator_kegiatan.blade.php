<div class="box box-primary"  style="min-height:500px;">
    <div class="box-header with-border">
		<h3 class="box-title">
			<small>
				<i class="fa fa-users"></i>
				<span class="text-primary"> JABATAN</span>	
			</small>
        </h3>
		<p style="margin-left:15px;" class="label-perjanjian_kinerja">
			 {{ Pustaka::capital_string($kegiatan->jabatan->skpd) }}
		</p>

        <h3 class="box-title" style="margin-top:10px;">
			<small>
				<i class="fa fa-tasks"></i>
				<span class="text-primary">KEGIATAN</span>
			</small>
        </h3>
		<p style="margin-left:15px;" class="label-perjanjian_kinerja">
			{{ $kegiatan->label}}
		</p>
        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
        </div>
    </div>



	<div class="box-body table-responsive">
		
	
		<div class="toolbar">
			
			<span  data-toggle="tooltip" title="Create Indikator Kegiatan"><a class="btn btn-info btn-sm create_indikator_kegiatan" data-toggle="modal" data-target=".create-indikator_kegiatan_modal"><i class="fa fa-plus" ></i> Indikator</a></span>
		
		</div>
	
		<table id="indikator_kegiatan_table" class="table table-striped table-hover table-condensed" >
			<thead>
				<tr class="success">
					<th>NO</th>
					<th >INDIKATOR KEGIATAN</th>
					<th>TARGET</th>
				</tr>
			</thead>
			
		</table>

	</div>
</div>



@include('pare_pns.modals.create-indikator_kegiatan')


   



<script type="text/javascript">
$(document).ready(function() {
	
	

	$(document).on('click','.create_indikator_kegiatan',function(e){
		$('.kegiatan_label').html( '{!! $kegiatan->label !!}' );
		$('.kegiatan_id').val( '{!! $kegiatan->id !!}' );	
		$('.create-indikator_kegiatan_modal').find('[name=label],[name=target],[name=satuan]').val('');

	}); 




    $('#indikator_kegiatan_table').DataTable({
			processing      : true,
			serverSide      : true,
			searching      	: false,
			paging          : false,
			columnDefs		: [
								{ className: "text-center", targets: [ 0,2 ] }
							  ],
			ajax			: {
				
								url	: '{{ url("api/skpd_indikator_kegiatan_perjanjian_kinerja_list") }}',
								data: { kegiatan_id: {{ $kegiatan->id }} },
							 },
			columns			:[
								{ data: 'rownum', orderable: true, searchable: false ,width:"30px"},
								{ data: "label", name:"label", orderable: true, searchable: true},
								{ data: "target", name:"target", orderable: false, searchable: false}
							
							],
							initComplete: function(settings, json) {
							
   				 			}
		
	});	
	
});
</script>
