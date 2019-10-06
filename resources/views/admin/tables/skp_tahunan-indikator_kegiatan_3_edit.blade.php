<div id='indikator_kegiatan' hidden>
	<div class="box box-primary">
		<div class="box-header with-border">
			<h1 class="box-title">
				Detail Kegiatan Tahunan 
			</h1>

			<div class="box-tools pull-right">
				{!! Form::button('<i class="fa fa-remove "></i>', array('class' => 'btn btn-box-tool tutup','title' => 'Tutup', 'data-toggle' => 'tooltip')) !!}

				{!! Form::button('<i class="fa fa-question-circle "></i>', array('class' => 'btn btn-box-tool bantuan','data-id' => '2', 'title' => 'Bantuan', 'data-toggle' => 'tooltip')) !!}
			</div>
		</div>
		<div class="box-body table-responsive">

			<strong>Kegiatan Tahunan</strong>
			<p class="text-muted " style="margin-top:8px;padding-bottom:8px;">
				<span class="kegiatan_tahunan_label"></span>
				<input type="hidden" class="kegiatan_tahunan_id">
				<input type="hidden" class="kegiatan_renja_id">
			</p>

			<p><strong>Target</strong></p>
			<i class="fa  fa-gg"></i> <span class="txt_ak" style="margin-right:10px;"></span>
			<i class="fa fa-industry"></i> <span class="txt_output" style="margin-right:10px;"></span>
			<i class="fa fa-hourglass-start"></i> <span class="txt_waktu_pelaksanaan" style="margin-right:10px;"></span>
			<i class="fa fa-money"></i> <span class="txt_cost" style="margin-right:10px;"></span>

			  
		</div>
	</div>

	<div class="box box-primary list_indikator_kegiatan_div" style="min-height:100px;" hidden>
		<div class="box-header with-border">
			<h1 class="box-title"> 
				List Indikator Kegiatan
			</h1>

		</div>
		<div class="box-body table-responsive">
			<div class="toolbar">
				
			</div>

			<table id="indikator_kegiatan_table" class="table table-striped table-hover">
				<thead>
					<tr>
						<th>No</th>
						<th>LABEL</th>
						<th>TARGET</th>
					</tr>
				</thead>
			</table>

		</div>
	</div>
</div>


<script type="text/javascript">

	function load_indikator_kegiatan(kegiatan_tahunan_id){

		//=== DETAIL KEGIATAN TAHUNAN
		$.ajax({
			url			: '{{ url("api_resource/kegiatan_tahunan_detail") }}',
			data 		: {kegiatan_tahunan_id : kegiatan_tahunan_id},
			method		: "GET",
			dataType	: "json",
			success	: function(data) {
					$('.kegiatan_tahunan_id').val(data['id']);
					$('.kegiatan_renja_id').val(data['kegiatan_renja_id']);
					$('.kegiatan_tahunan_label').html(data['label']);
					$('.txt_ak').html(data['ak']);
					$('.txt_output').html(data['output']);
					$('.txt_waktu_pelaksanaan').html(data['target_waktu'] +' bulan');
					$('.txt_cost').html('Rp. ' +data['cost']);
					$('.txt_kualitas').html(data['quality']+" %");
					indikator_kegiatan_list(data['kegiatan_renja_id']);
					
			},
			error: function(data){
				
				
			}						
		});
		function indikator_kegiatan_list(kegiatan_id){
			//==========LIST INDIKATOR KEGIATAN NTA
			var table_rencana_aksi = $('#indikator_kegiatan_table').DataTable({
				destroy			: true,
				processing      : false,
				serverSide      : true,
				searching      	: false,
				paging          : false,
				bInfo			: false,
				bSort			: false,
				columnDefs		: [
									{ className: "text-center", targets: [ 0,2] },
								],
				ajax			: {
									url	: '{{ url("api_resource/skpd-renja_ind_kegiatan_list") }}',
									data: { kegiatan_id: kegiatan_id },
								},
				columns			: [
									{ data: 'ind_kegiatan_id' , width:"40px",
										"render": function ( data, type, row ,meta) {
											return meta.row + meta.settings._iDisplayStart + 1 ;
										}
									},
									{ data: "label_ind_kegiatan", name:"label_ind_kegiatan"},
									{ data: "target_ind_kegiatan", name:"target_ind_kegiatan", width:"120px"}
								
								],
								initComplete: function(settings, json) {
								
							}
			});	
			$(".list_indikator_kegiatan_div").show();
			
		}
	}

 
</script>