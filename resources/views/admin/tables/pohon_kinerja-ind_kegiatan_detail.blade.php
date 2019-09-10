
	<div class="box box-primary div_kegiatan_detail" hidden>
		<div class="box-header with-border">
			<h1 class="box-title">
				Detail Kegiatan
			</h1>

			<div class="box-tools pull-right">
				{!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
				{!! Form::button('<i class="fa fa-remove "></i>', array('class' => 'btn btn-box-tool tutup_detail','title' => 'Tutup', 'data-toggle' => 'tooltip')) !!}

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

			<hr>
					
			<table class="table table-hover table-condensed">
				<tr class="success">
					<th width="5%">No</th>
					<th width="70%">Indikator</th>
					<th width="25%">Target</th>
				</tr>
			</table>
			<table class="table table-hover table-condensed" id="list_indikator"></table>
			  
		</div>
	</div>


	<div class="box box-primary div_rencana_aksi_list" hidden>
		<div class="box-header with-border">
			<h1 class="box-title">
				List Rencana Aksi
			</h1>

		</div>
		<div class="box-body table-responsive">
			<div class="toolbar">
			
			</div>

			<table id="rencana_aksi_table" class="table table-striped table-hover" >
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


	function load_rencana_aksi(kegiatan_id){
		//alert (kegiatan_id);

		$.ajax({
				url			: '{{ url("api_resource/kegiatan_detail") }}',
				data 		: {kegiatan_id : kegiatan_id },
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
						$('.kegiatan_label').html(data['label']);
						$('.txt_cost').html('Rp. ' +data['cost']);


						document.getElementById('list_indikator').innerHTML = "";
						var bawahan = document.getElementById('list_indikator');
						for(var i = 0 ; i < data['list_indikator'].length; i++ ){
							 
							$("<tr><td width='5%'>"+ (i+1) +"</td><td width='70%'>"+data['list_indikator'][i].label+"</td><td width='25%'>"+data['list_indikator'][i].target+" "+data['list_indikator'][i].satuan+"</td></tr>").appendTo(bawahan);
						}


						
				},
				error: function(data){
						document.getElementById('list_indikator').innerHTML = "";
				}						
		});


		var table_rencana_aksi = $('#rencana_aksi_table').DataTable({
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
									url	: '{{ url("api_resource/kegiatan_rencana_aksi") }}',
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