<div class="box box-primary div_tujuan_detail" hidden>
	<div class="box-header with-border">
		<h1 class="box-title">
			Detail Tujuan
		</h1>
		<div class="box-tools pull-right">
			{!! Form::button('<i class="fa fa-remove "></i>', array('class' => 'btn btn-box-tool tutup_detail','title' => 'Tutup', 'data-toggle' => 'tooltip')) !!}
		</div>
	</div>
	<div class="box-body table-responsive">
		<strong>Label</strong>
		<p class="text-muted " style="margin-top:8px;padding-bottom:10px;">
			<span class="txt_label_tujuan"></span>
		</p>
					
	</div>
</div>
<div class="box box-primary div_ind_tujuan_list" hidden>
    <div class="box-header with-border">
		<h1 class="box-title">
            List Indikator Tujuan
        </h1>
    </div>
	<div class="box-body table-responsive">

		<div class="toolbar">
			
		</div>
		<table id="ind_tujuan_table" class="table table-striped table-hover table-condensed" >
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


function load_ind_tujuan(tujuan_id){

	$.ajax({
			url			: '{{ url("api_resource/tujuan_detail") }}',
			data 		: {tujuan_id : tujuan_id},
			method		: "GET",
			dataType	: "json",
			success	: function(data) {
					$('.txt_label_tujuan').html(data['label']);
					$('.tujuan_id').val(data['id']);
					
			},
			error: function(data){
				
			}						
	});
	

    $('#ind_tujuan_table').DataTable({
				destroy			: true,
				processing      : false,
				serverSide      : true,
				searching      	: false,
				paging          : false,
			columnDefs		: [
								{ className: "text-center", targets: [ 0,2 ] }
							  ],
			ajax			: {
								url	: '{{ url("api_resource/skpd-renja_ind_tujuan_list") }}',
								data: { tujuan_id: tujuan_id },
							 }, 
			columns			:[
							{ data: 'ind_tujuan_id' , orderable: true,searchable:false,width:"30px",
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
							{ data: "label_ind_tujuan", name:"label_ind_tujuan", orderable: true, searchable: true},
							{ data: "target_ind_tujuan", name:"target_ind_tujuan", orderable: true, searchable: true , width:"90px"},
							
						],
						initComplete: function(settings, json) {
							
   				 		}
		
		});	

	}

</script>
