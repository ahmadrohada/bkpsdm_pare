<div class="box box-primary div_kegiatan_detail" hidden>
<div class="box-header with-border">
		<h1 class="box-title">
			Detail kegiatan f 
		</h1>

		<div class="box-tools pull-right">
			{!! Form::button('<i class="fa fa-remove "></i>', array('class' => 'btn btn-box-tool tutup_detail','title' => 'Tutup', 'data-toggle' => 'tooltip')) !!}
		</div>
	</div>
	<div class="box-body table-responsive">

		<strong>Kegiatan</strong>
		<p class="text-muted " style="margin-top:8px;padding-bottom:10px;">
			<span class="txt_kegiatan_label"></span>
		</p>
		<strong>Anggaran</strong>
		<p class="text-muted " style="margin-top:8px;padding-bottom:10px;">
			<span class="cost"></span>
		</p>

					
	</div>
</div>
<div class="box box-primary div_ind_kegiatan_list" hidden>
    <div class="box-header with-border">
		<h1 class="box-title">
            List Indikator kegiatan
        </h1>

        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
        </div>
    </div>



	<div class="box-body table-responsive">

		<div class="toolbar">
			
		</div>
		<table id="ind_kegiatan_table" class="table table-striped table-hover table-condensed" >
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


function load_ind_kegiatan(kegiatan_id){


	$.ajax({
			url			: '{{ url("api_resource/kegiatan_detail") }}',
			data 		: {kegiatan_id : kegiatan_id},
			method		: "GET",
			dataType	: "json",
			success	: function(data) {
				$('.txt_kegiatan_label').html(data['label']);
				$('.cost').html("Rp. "+ data['cost']);
				$('.kegiatan_id').val(data['kegiatan_id']);
					
					
			},
			error: function(data){
				
			}						
	});

	$('#ind_kegiatan_table').DataTable({
				destroy			: true,
				processing      : false,
				serverSide      : true,
				searching      	: false,
				paging          : false,
				columnDefs		: [
									{ className: "text-center", targets: [ 0,2 ] }
								],
				ajax			: {
									url	: '{{ url("api_resource/skpd-renja_ind_kegiatan_list") }}',
									data: { kegiatan_id: kegiatan_id },
								}, 
				columns			:[
								{ data: 'ind_kegiatan_id' , orderable: true,searchable:false,width:"30px",
										"render": function ( data, type, row ,meta) {
											return meta.row + meta.settings._iDisplayStart + 1 ;
										}
									},
								{ data: "label_ind_kegiatan", name:"label_ind_kegiatan", orderable: true, searchable: true},
								{ data: "target_ind_kegiatan", name:"target_ind_kegiatan", orderable: true, searchable: true, width:"90px"},
								/* {  data: 'action',width:"60px",
										"render": function ( data, type, row ) {
											return  '<span  data-toggle="tooltip" title="Edit" style="margin:1px;" ><a class="btn btn-success btn-xs edit_ind_kegiatan"  data-id="'+row.ind_kegiatan_id+'"><i class="fa fa-pencil" ></i></a></span>'+
													'<span  data-toggle="tooltip" title="Hapus" style="margin:1px;" ><a class="btn btn-danger btn-xs hapus_ind_kegiatan"  data-id="'+row.ind_kegiatan_id+'" data-label="'+row.label_ind_kegiatan+'" ><i class="fa fa-close " ></i></a></span>';
												
										}
								}, */
							],
							initComplete: function(settings, json) {
								
								}
		
		
	});	

}



</script>
