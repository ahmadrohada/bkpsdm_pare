<div class="box-body table-responsive" style="min-height:440px;">

			
				<table id="table_monitoring_kinerja_tujuan" class="table table-striped table-hover " style="font-size:95% ;">
					<thead> 
						<tr>
							<th rowspan="3" style="padding-left:160px; padding-right:160px ;">TUJUAN</th>
							<th rowspan="3" style="padding-left:250px; padding-right:250px ;">INDIKATOR</th>
							<th colspan="12" >CAPAIAN</th>
							
						</tr>
						<tr>
							<th colspan="3">TRIWULAN I &nbsp;&nbsp;&nbsp;[ <span class="triwulan_1"></span> ]</th>
							<th colspan="3">TRIWULAN II &nbsp;&nbsp;&nbsp;[ <span class="triwulan_2"></span> ]</th>
							<th colspan="3">TRIWULAN III &nbsp;&nbsp;&nbsp;[ <span class="triwulan_3"></span> ]</th>
							<th colspan="3">TRIWULAN IV &nbsp;&nbsp;&nbsp;[ <span class="triwulan_4"></span> ]</th>
						</tr>
						<tr>
							<th style="padding-left:14px; padding-right:14px ;">TARGET</th>
							<th style="padding-left:10px; padding-right:10px ;">REALISASI</th>
							<th style="padding-left:30px; padding-right:30px ;">%</th>
							<th style="padding-left:14px; padding-right:14px ;">TARGET</th>
							<th style="padding-left:10px; padding-right:10px ;">REALISASI</th>
							<th style="padding-left:30px; padding-right:30px ;">%</th>
							<th style="padding-left:14px; padding-right:14px ;">TARGET</th>
							<th style="padding-left:10px; padding-right:10px ;">REALISASI</th>
							<th style="padding-left:30px; padding-right:30px ;">%</th>
							<th style="padding-left:14px; padding-right:14px ;">TARGET</th>
							<th style="padding-left:10px; padding-right:10px ;">REALISASI</th>
							<th style="padding-left:30px; padding-right:30px ;">%</th>
						</tr>
					</thead>
							
				</table>

			</div>
{{-- <style>
table.dataTable tbody td {
  vertical-align: middle;
}
</style> --}}


<script type="text/javascript">

		

function mk_tujuan(){
	var table_monitoring_kinerja_tujuan = $('#table_monitoring_kinerja_tujuan').DataTable({
				destroy			: true,
				processing      : true,
				serverSide      : true,
				searching      	: false,
				paging          : false,
				bInfo			: false,
				deferRender:    true,
    scroller:       true,
				//order 			: [0 , 'asc' ],
				columnDefs		: [
									//{ className: "text-center", targets: '_all'  },
									{ className: "text-center", targets: [2,3,4,5,6,7,8,9,10,11,12,13]  },
								],
				
				ajax			: {
									url	: '{{ url("api/skpd_monitoring_kinerja_tujuan") }}',
									data: { renja_id : {!! $renja->id !!} },
									method: 'POST'
								},
				targets			: 'no-sort',
				bSort			: false,
				rowsGroup		: [ 0],
				rowCallback	: function(row, data, index){
									
										
									$(row).find('td:eq(0),td:eq(1)').css('background-color', '#FFF8DC');
									$(row).find('td:eq(2),td:eq(3),td:eq(4),td:eq(8),td:eq(9),td:eq(10)').css('background-color', '#eaf2f8');
									$(row).find('td:eq(5),td:eq(6),td:eq(7),td:eq(11),td:eq(12),td:eq(13)').css('background-color', '#eafaf1');
									$(row).find('td:eq(4),td:eq(7),td:eq(10),td:eq(13)').css('color', '#200467'); 
							},
				
				
				
				columns			: [
									
									{ data: 'tujuan_label',name:'tujuan_label'},
									{ data: 'indikator_tujuan_label',name:'indikator_tujuan_label'},

									{ data: 'tw_1_indikator_tujuan_target',name:''},
									{ data: 'tw_1_indikator_tujuan_realisasi',name:''},
									{ data: 'tw_1_indikator_tujuan_percentage',name:''},


									{ data: 'tw_2_indikator_tujuan_target',name:''},
									{ data: 'tw_2_indikator_tujuan_realisasi',name:''},
									{ data: 'tw_2_indikator_tujuan_percentage',name:''},


									{ data: 'tw_3_indikator_tujuan_target',name:''},
									{ data: 'tw_3_indikator_tujuan_realisasi',name:''},
									{ data: 'tw_3_indikator_tujuan_percentage',name:''},


									{ data: 'tw_4_indikator_tujuan_target',name:''},
									{ data: 'tw_4_indikator_tujuan_realisasi',name:''},
									{ data: 'tw_4_indikator_tujuan_percentage',name:''},
									
								],
								initComplete: function(settings, json) {
								
							}
		});	


		$.ajax({
				url			: '{{ url("api/skpd_monitoring_kinerja_tujuan_average") }}',
				data 		: { renja_id : {!! $renja->id !!} },
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					//alert(data[0]['triwulan_1']);
					$('.triwulan_1').html(data[0]['triwulan_1']);
					$('.triwulan_2').html(data[0]['triwulan_2']);
					$('.triwulan_3').html(data[0]['triwulan_3']);
					$('.triwulan_4').html(data[0]['triwulan_4']);
					
						
				},
				error: function(data){
					
				}						
		});

	
}

		


		
		
	


</script>
