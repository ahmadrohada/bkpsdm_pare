<div class="box box-primary div_ind_program_detail" hidden>
	<div class="box-header with-border">
		<h1 class="box-title">
			Detail Indikator Program
		</h1>

		<div class="box-tools pull-right">
			{!! Form::button('<i class="fa fa-remove "></i>', array('class' => 'btn btn-box-tool tutup_detail','title' => 'Tutup', 'data-toggle' => 'tooltip')) !!}
		</div>
	</div>
	<div class="box-body table-responsive" >

		<strong>Indikator Program</strong>
		<p class="text-muted " style="margin-top:8px;padding-bottom:10px;">
			<span class="txt_ind_program_label"></span>
		</p>

		<strong>Target</strong>
		<p class="text-muted " style="margin-top:8px;padding-bottom:10px;">
			<span class="txt_ind_program_target"></span>
		</p>

					
	</div>
</div>
<div class="box box-primary div_kegiatan_list" hidden>
    <div class="box-header with-border">
		<h1 class="box-title">
            List Kegiatan
        </h1>
    </div>
	<div class="box-body table-responsive">
		<div class="toolbar">

		</div>
		<table id="kegiatan_table" class="table table-striped table-hover table-condensed" >
			<thead>
				<tr class="success">
					<th>NO</th>
					<th >LABEL</th>
					<th >TARGET</th>
					<th >ANGGARAN</th>
				</tr>
			</thead>
			
		</table>

	</div>
</div>


<script type="text/javascript">


function load_kegiatan(ind_program_id){


	$.ajax({
			url			: '{{ url("api_resource/ind_program_detail") }}',
			data 		: {ind_program_id : ind_program_id},
			method		: "GET",
			dataType	: "json",
			success	: function(data) {
					$('.txt_ind_program_label').html(data['label']);
					$('.txt_ind_program_target').html(data['target']+' '+data['satuan']);
					$('.ind_program_id').val(data['id']);
					
			},
			error: function(data){
				
			}						
	});


    $('#kegiatan_table').DataTable({
				destroy			: true,
				processing      : false,
				serverSide      : true,
				searching      	: false,
				paging          : false,
			columnDefs		: [
								{ className: "text-center", targets: [ 0,2] },
								{ className: "text-right", targets: [ 3 ] }
							  ],
			ajax			: {
								url	: '{{ url("api_resource/skpd-renja_kegiatan_list") }}',
								data: { ind_program_id: ind_program_id ,
										renja_id:{!! $renja->id !!}
									 },
							 }, 
			columns			:[
							{ data: 'kegiatan_id' , orderable: true,searchable:false,width:"30px",
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
							{ data: "label_kegiatan", name:"label_kegiatan", orderable: true, searchable: true},
							{ data: "target_kegiatan", name:"target_kegiatan", orderable: true, searchable: true},
							{ data: "cost_kegiatan", name:"cost_kegiatan", orderable: true, searchable: true},
							
						],
						initComplete: function(settings, json) {
							
   				 		}
		
		
	});	


}


</script>
