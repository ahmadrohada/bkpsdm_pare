<div class='box box-kegiatan_tahunan div_kegiatan_skp_tahunan' hidden>
	<div class="box-header with-border">
		&nbsp;
		<div class="box-tools pull-right">
			{!! Form::button('<i class="fa  fa-level-up"></i>', array('class' => 'btn btn-box-tool tutup_detail','title' => 'Kegiatan SKP Tahunan', 'data-toggle' => 'tooltip')) !!}
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
		<i class="fa fa-hourglass-start"></i> <span class="txt_waktu_pelaksanaan" style="margin-right:10px;"></span>
		<i class="fa fa-money"></i> <span class="txt_cost" style="margin-right:10px;"></span>

		<table id="indikator_kegiatan_skp_tahunan_table" class="table table-striped table-hover">
			<thead>
				<tr>
					<th>No</th>
					<th>INDIKATOR KEGIATAN</th>
					<th>TARGET</th>
				</tr>
			</thead>
		</table>
	</div>
</div>

<script type="text/javascript">

	function load_kegiatan_skp_tahunan(kegiatan_skp_tahunan_id){

		//=== DETAIL KEGIATAN SKP TAHUNAN
		$.ajax({
			url			: '{{ url("api/kegiatan_skp_tahunan_detail") }}',
			data 		: {kegiatan_skp_tahunan_id : kegiatan_skp_tahunan_id},
			method		: "GET",
			dataType	: "json",
			success	: function(data) {
					$('.kegiatan_tahunan_id').val(data['id']);
					$('.kegiatan_tahunan_label').html(data['label']);
					$('.txt_ak').html(data['ak']);
					$('.txt_output').html(data['output']);
					$('.txt_waktu_pelaksanaan').html(data['target_waktu'] +' bulan');
					$('.txt_cost').html('Rp. ' +data['cost']);
					$('.txt_kualitas').html(data['quality']+" %");
					indikator_kegiatan_skp_tahunan_list(data['id']);
					
			},
			error: function(data){
				
				
			}						
		});
		function indikator_kegiatan_skp_tahunan_list(kegiatan_skp_tahunan_id){
			//==========LIST INDIKATOR KEGIATAN NTA
			var table_rencana_aksi = $('#indikator_kegiatan_skp_tahunan_table').DataTable({
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
									url	: '{{ url("api/indikator_kegiatan_skp_tahunan_list") }}',
									data: { kegiatan_skp_tahunan_id: kegiatan_skp_tahunan_id },
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