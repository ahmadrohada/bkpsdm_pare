<div id='rencana_aksi' hidden>
	<div class="box box-indikator_kegiatan_tahunan">
		<div class="box-header with-border">
			<h1 class="box-title">
				Detail Indikator Kegiatan
			</h1>

			<div class="box-tools pull-right">
				{!! Form::button('<i class="fa fa-remove "></i>', array('class' => 'btn btn-box-tool tutup','title' => 'Tutup', 'data-toggle' => 'tooltip')) !!}

				{!! Form::button('<i class="fa fa-question-circle "></i>', array('class' => 'btn btn-box-tool bantuan','data-id' => '3', 'title' => 'Bantuan', 'data-toggle' => 'tooltip')) !!}
			</div>
		</div>
		<div class="box-body table-responsive">
			<input type="hidden" class="indikator_kegiatan_id">
			<input type="hidden" class="kegiatan_tahunan_id">
			
			<strong>Indikator Kegiatan</strong>
			<p class="text-muted " style="margin-top:8px;padding-bottom:10px;">
				<span class="indikator_kegiatan_label"></span>
			</p>
			<i class="fa fa-industry"></i> <span class="txt_output_indikator_kegiatan" style="margin-right:10px;"></span>
					
		</div>
	</div>

	<div class="box box-rencana_aksi list_rencana_aksi_div" style="min-height:100px;">
		<div class="box-header with-border">
			<h1 class="box-title"> 
				List Rencana Aksi
			</h1>

		</div>
		<div class="box-body table-responsive">
			<table id="rencana_aksi_table" class="table table-striped table-hover" style="width:100%">
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
</div>

<script type="text/javascript">





	function load_rencana_aksi(indikator_kegiatan_id){
		$.ajax({
				url			: '{{ url("api/ind_kegiatan_detail") }}',
				data 		: {ind_kegiatan_id : indikator_kegiatan_id ,  skp_tahunan_id: {!! $skp->id !!} },
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
						
						$('.indikator_kegiatan_id').val(data['ind_kegiatan_id']);
						$('.kegiatan_tahunan_id').val(data['kegiatan_tahunan_id']);

						$('.indikator_kegiatan_label').html(data['label']);
						$('.txt_output_indikator_kegiatan').html(data['target']+" "+data['satuan']);
						
				},
				error: function(data){
					
				}						
		});
	}

	
	
	function rencana_aksi_list(indikator_kegiatan_id){
		var table_rencana_aksi = $('#rencana_aksi_table').DataTable({
			destroy			: true,
			processing      : false,
			serverSide      : true,
			searching      	: false,
			paging          : false,
			bInfo			: false,
			bSort			: false,
			columnDefs		: [
								{ className: "text-center", targets: [ 0,2,3,4 ] },
							
							],
			ajax			: {
								url	: '{{ url("api/skp_tahunan_rencana_aksi_3") }}',
								data: { indikator_kegiatan_id: indikator_kegiatan_id , skp_tahunan_id: {!! $skp->id !!} },
							},
							
			columns			: [
								{ data: 'rencana_aksi_id' , width:"6%",
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
								{ data: "label", name:"label"},
								{ data: "pelaksana", name:"pelaksana",
									"render": function ( data, type, row ) {
										if (row.kegiatan_bulanan >= 1){
											return "<p class='text-info'>"+row.pelaksana+"</p>";
										}else{
											return "<p class='text-warning'>"+row.pelaksana+"</p>";
										}
									}
								},
								{ data: "waktu_pelaksanaan", name:"waktu_pelaksanaan"},
								{ data: "target", name:"target"}
							
							],
							initComplete: function(settings, json) {
							
						}
		});	
	}

</script>