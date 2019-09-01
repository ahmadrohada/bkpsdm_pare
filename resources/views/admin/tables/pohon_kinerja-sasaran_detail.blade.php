<div class="box box-primary div_ind_tujuan_detail" hidden>
	<div class="box-header with-border">
		<h1 class="box-title">
			Detail Indikator Tujuan
		</h1>

		<div class="box-tools pull-right">
			{!! Form::button('<i class="fa fa-remove "></i>', array('class' => 'btn btn-box-tool tutup_detail','title' => 'Tutup', 'data-toggle' => 'tooltip')) !!}
		</div>
	</div>
	<div class="box-body table-responsive" >

		<strong>Indikator Tujuan</strong>
		<p class="text-muted " style="margin-top:8px;padding-bottom:10px;">
			<span class="txt_ind_tujuan_label"></span>
		</p>

		<strong>Target</strong>
		<p class="text-muted " style="margin-top:8px;padding-bottom:10px;">
			<span class="txt_ind_tujuan_target"></span>
		</p>

					
	</div>
</div>
<div class="box box-primary div_sasaran_list" hidden>
    <div class="box-header with-border">
		<h1 class="box-title">
            List Sasaran
        </h1>
    </div>
	<div class="box-body table-responsive">
		<div class="toolbar">
		</div>
		<table id="sasaran_table" class="table table-striped table-hover table-condensed" >
			<thead>
				<tr class="success">
					<th>NO</th>
					<th >LABEL</th>
				</tr>
			</thead>
			
		</table>

	</div>
</div>


<script type="text/javascript">


function load_sasaran(ind_tujuan_id){


	$.ajax({
			url			: '{{ url("api_resource/ind_tujuan_detail") }}',
			data 		: {ind_tujuan_id : ind_tujuan_id},
			method		: "GET",
			dataType	: "json",
			success	: function(data) {
					$('.txt_ind_tujuan_label').html(data['label']);
					$('.txt_ind_tujuan_target').html(data['target']+' '+data['satuan']);
					$('.ind_tujuan_id').val(data['id']);
					
			},
			error: function(data){
				
			}						
	});


    $('#sasaran_table').DataTable({
				destroy			: true,
				processing      : false,
				serverSide      : true,
				searching      	: false,
				paging          : false,
			columnDefs		: [
								{ className: "text-center", targets: [ 0 ] }
							  ],
			ajax			: {
								url	: '{{ url("api_resource/skpd-renja_sasaran_list") }}',
								data: { ind_tujuan_id: ind_tujuan_id },
							 }, 
			columns			:[
							{ data: 'sasaran_id' , orderable: true,searchable:false,width:"30px",
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
							{ data: "label_sasaran", name:"label_sasaran", orderable: true, searchable: true},
							
						],
						initComplete: function(settings, json) {
							
   				 		}
		
		
	});	


}



</script>
