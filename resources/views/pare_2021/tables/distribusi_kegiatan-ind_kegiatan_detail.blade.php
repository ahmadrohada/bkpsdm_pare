
	<div class="box box-kegiatan div_kegiatan_detail" hidden>
		<div class="box-header with-border">
			<h1 class="box-title">
				Detail Kegiatan
			</h1>
 
			<div class="box-tools pull-right">
				{!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
				{!! Form::button('<i class="fa fa-question-circle "></i>', array('class' => 'btn btn-box-tool bantuan','data-id' => '410', 'title' => 'Bantuan', 'data-toggle' => 'tooltip')) !!}
			</div>
		</div>
		<div class="box-body table-responsive">

			<strong>Kegiatan </strong>
			<p class="text-muted " style="margin-top:8px;padding-bottom:8px;">
				<span class="kegiatan_label"></span>
			</p>

			<p><strong>Anggaran</strong></p>
			<span class="txt_cost" style="margin-right:10px;"></span>

		
		</div>
	</div>

	<div class="box box-indikator_kegiatan div_ind_kegiatan_list" hidden>
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
				<table id="ind_kegiatan_table2" class="table table-striped table-hover table-condensed" >
					<thead>
						<tr class="success">
							<th>NO</th>
							<th >LABEL</th>
							<th >TARGET</th>
							<!-- <th>ACTION</th> -->
						</tr>
					</thead>
					
				</table>
		
			</div>
		</div>


	<div class="box box-rencana_aksi div_rencana_aksi_list" hidden>
		<div class="box-header with-border">
			<h1 class="box-title">
				List Rencana Aksi
			</h1>

		</div>
		<div class="box-body table-responsive">
			<div class="toolbar">
			
			</div>

			<table id="rencana_aksi_table2" class="table table-striped table-hover" >
				<thead>
					<tr>
						<th>No</th>
						<th>RENCANA AKSI</th>
						<th>PELAKSANA</th>
						<th>WAKTU</th>
						<th>TARGET</th>
					</tr>
				</thead>
			</table>

		</div>
	</div>


<script type="text/javascript">


	function load_ind_kegiatan2(kegiatan_id){
		//alert (kegiatan_id);

		$.ajax({
				url			: '{{ url("api/kegiatan_detail") }}',
				data 		: {kegiatan_id : kegiatan_id },
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
						$('.kegiatan_label').html(data['label']);
						$('.txt_cost').html('Rp. ' +data['cost']);


						/* document.getElementById('list_indikator2').innerHTML = "";
						var bawahan = document.getElementById('list_indikator2');
						for(var i = 0 ; i < data['list_indikator'].length; i++ ){
							 
							$("<tr><td width='5%'>"+ (i+1) +"</td><td width='70%'>"+data['list_indikator'][i].label+"</td><td width='25%'>"+data['list_indikator'][i].target+" "+data['list_indikator'][i].satuan+"</td></tr>").appendTo(bawahan);
						} */


						
				},
				error: function(data){
						document.getElementById('list_indikator2').innerHTML = "";
				}						
		});

		
$('#ind_kegiatan_table2').DataTable({
			destroy			: true,
			processing      : false,
			serverSide      : true,
			searching      	: false,
			paging          : false,
			columnDefs		: [
								{ className: "text-center", targets: [ 0,2 ] }
							],
			ajax			: {
								url	: '{{ url("api/skpd-renja_ind_kegiatan_list") }}',
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


		var table_rencana_aksi = $('#rencana_aksi_table2').DataTable({
				destroy			: true,
				processing      : false,
				serverSide      : true,
				searching      	: false,
				paging          : false,
				columnDefs		: [
									{ className: "text-center", targets: [ 0,3,4 ] },
									{ 'orderable': false , targets: [ 0,1,2 ]  }
								],
				ajax			: {
									url	: '{{ url("api/kegiatan_rencana_aksi") }}',
									data: { kegiatan_id: kegiatan_id },
								},
								columns			: [
									{ data: 'rencana_aksi_id' , width:"10%",
										"render": function ( data, type, row ,meta) {
											return meta.row + meta.settings._iDisplayStart + 1 ;
										}
									},
									{ data: "label", name:"label"},
									{ data: "pelaksana", name:"pelaksana"},
									{ data: "waktu_pelaksanaan", name:"waktu_pelaksanaan"},
									{ data: "target", name:"target"},
									
								
								],
								initComplete: function(settings, json) {
								
							}
				
							
			
		});	
	}

</script>