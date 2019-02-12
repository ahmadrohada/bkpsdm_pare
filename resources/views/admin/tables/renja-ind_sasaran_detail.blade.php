<div class="box box-primary div_sasaran_detail" hidden>
	<div class="box-header with-border">
		<h1 class="box-title">
			Detail Sasaran
		</h1>

		<div class="box-tools pull-right">
			{!! Form::button('<i class="fa fa-remove "></i>', array('class' => 'btn btn-box-tool tutup_detail','title' => 'Tutup', 'data-toggle' => 'tooltip')) !!}
		</div>
	</div>
	<div class="box-body table-responsive">

		<strong>Sasaran</strong>
		<p class="text-muted " style="margin-top:8px;padding-bottom:10px;">
			<span class="txt_sasaran_label"></span>
		</p>
			
	</div>
</div>
<div class="box box-primary div_ind_sasaran_list" hidden>
    <div class="box-header with-border">
		<h1 class="box-title">
            List Indikator Sasaran
        </h1>

        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
        </div>
    </div>



	<div class="box-body table-responsive">

		<div class="toolbar">
		
		</div>
		<table id="ind_sasaran_table" class="table table-striped table-hover table-condensed" >
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

    
function load_ind_sasaran(sasaran_id){


$.ajax({
		url			: '{{ url("api_resource/sasaran_detail") }}',
		data 		: {sasaran_id : sasaran_id},
		method		: "GET",
		dataType	: "json",
		success	: function(data) {
				$('.txt_sasaran_label').html(data['label']);
				$('.sasaran_id').val(data['id']);
				
		},
		error: function(data){
			
		}						
});


$('#ind_sasaran_table').DataTable({
			destroy			: true,
			processing      : false,
			serverSide      : true,
			searching      	: false,
			paging          : false,
			columnDefs		: [
								{ className: "text-center", targets: [ 0,2 ] }
							],
			ajax			: {
								url	: '{{ url("api_resource/skpd-renja_ind_sasaran_list") }}',
								data: { sasaran_id: sasaran_id },
							}, 
			columns			:[
							{ data: 'ind_sasaran_id' , orderable: true,searchable:false,width:"30px",
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
							{ data: "label_ind_sasaran", name:"label_ind_sasaran", orderable: true, searchable: true},
							{ data: "target_ind_sasaran", name:"target_ind_sasaran", orderable: true, searchable: true, width:"90px"},
					
						],
						initComplete: function(settings, json) {
							
							}
	
	
});	


}

</script>
