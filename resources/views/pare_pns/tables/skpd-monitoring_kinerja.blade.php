<div class="box-body table-responsive" style="">

			
				<table id="table_monitoring_kinerja" class="table table-striped table-hover " style="font-size:83% ;">
					<thead> 
						<tr>
							<th rowspan="3" style="padding-left:70px; padding-right:70px ;">TUJUAN</th>
							<th rowspan="3" style="padding-left:70px; padding-right:70px ;">INDIKATOR</th>
							<th colspan="8" >CAPAIAN</th>
							<th rowspan="3" style="padding-left:70px; padding-right:70px ;">SASARAN</th>
							<th rowspan="3" style="padding-left:70px; padding-right:70px ;">INDIKATOR</th>
							<th colspan="8" >CAPAIAN</th>
							<th rowspan="3" style="padding-left:120px; padding-right:120px ;">PROGRAM</th>
							<th rowspan="3" style="padding-left:120px; padding-right:120px ;">INDIKATOR</th>
							<th colspan="8" >CAPAIAN</th>
							<th rowspan="3" style="padding-left:160px; padding-right:160px ;">KEGIATAN</th>
							<th rowspan="3" style="padding-left:250px; padding-right:250px ;">INDIKATOR</th>
							<th colspan="8" >CAPAIAN</th>
							
						</tr>
						<tr>
							<th colspan="2">TRIWULAN I</th>
							<th colspan="2">TRIWULAN II</th>
							<th colspan="2">TRIWULAN III</th>
							<th colspan="2">TRIWULAN IV</th>

							<th colspan="2">TRIWULAN I</th>
							<th colspan="2">TRIWULAN II</th>
							<th colspan="2">TRIWULAN III</th>
							<th colspan="2">TRIWULAN IV</th>

							<th colspan="2">TRIWULAN I</th>
							<th colspan="2">TRIWULAN II</th>
							<th colspan="2">TRIWULAN III</th>
							<th colspan="2">TRIWULAN IV</th>

							<th colspan="2">TRIWULAN I</th>
							<th colspan="2">TRIWULAN II</th>
							<th colspan="2">TRIWULAN III</th>
							<th colspan="2">TRIWULAN IV</th>
						</tr>
						<tr>
							<th>TARGET</th>
							<th>REALISASI</th>
							<th>TARGET</th>
							<th>REALISASI</th>
							<th>TARGET</th>
							<th>REALISASI</th>
							<th>TARGET</th>
							<th>REALISASI</th>

							<th>TARGET</th>
							<th>REALISASI</th>
							<th>TARGET</th>
							<th>REALISASI</th>
							<th>TARGET</th>
							<th>REALISASI</th>
							<th>TARGET</th>
							<th>REALISASI</th>

							<th>TARGET</th>
							<th>REALISASI</th>
							<th>TARGET</th>
							<th>REALISASI</th>
							<th>TARGET</th>
							<th>REALISASI</th>
							<th>TARGET</th>
							<th>REALISASI</th>

							<th>TARGET</th>
							<th>REALISASI</th>
							<th>TARGET</th>
							<th>REALISASI</th>
							<th>TARGET</th>
							<th>REALISASI</th>
							<th>TARGET</th>
							<th>REALISASI</th>



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

		
		var table_monitoring_kinerja = $('#table_monitoring_kinerja').DataTable({
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
									{ className: "text-center", targets: [2,3,4,5,6,7,8,9,12,13,14,15,16,17,18,19,22,23,24,25,26,27,28,29,32,33,34,35,36,37,38,39]  },
								],
				
				ajax			: {
									url	: '{{ url("api_resource/skpd_monitoring_kinerja") }}',
									data: { renja_id : {!! $renja->id !!} },
									method: 'POST'
								},
				targets			: 'no-sort',
				bSort			: false,
				rowsGroup		: [ 0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30],
				rowCallback	: function(row, data, index){
									
										
									$(row).find('td:eq(0),td:eq(1)').css('background-color', '#FFF8DC');
									$(row).find('td:eq(2),td:eq(3),td:eq(6),td:eq(7)').css('background-color', '#eaf2f8');
									$(row).find('td:eq(4),td:eq(5),td:eq(8),td:eq(9)').css('background-color', '#eafaf1');

									$(row).find('td:eq(10),td:eq(11)').css('background-color', '#FFF8DC');
									$(row).find('td:eq(12),td:eq(13),td:eq(16),td:eq(17)').css('background-color', '#eaf2f8');
									$(row).find('td:eq(14),td:eq(15),td:eq(18),td:eq(19)').css('background-color', '#eafaf1');
						
									$(row).find('td:eq(20),td:eq(21)').css('background-color', '#FFF8DC');
									$(row).find('td:eq(22),td:eq(23),td:eq(26),td:eq(27)').css('background-color', '#eaf2f8');
									$(row).find('td:eq(24),td:eq(25),td:eq(28),td:eq(29)').css('background-color', '#eafaf1');

									$(row).find('td:eq(30),td:eq(31)').css('background-color', '#FFF8DC');
									$(row).find('td:eq(32),td:eq(33),td:eq(36),td:eq(37)').css('background-color', '#eaf2f8');
									$(row).find('td:eq(34),td:eq(35),td:eq(38),td:eq(39)').css('background-color', '#eafaf1');
							},
				
				
				
				columns			: [
									{ data: 'tujuan_label',name:'tujuan_label'},
									{ data: 'indikator_tujuan_label',name:'indikator_tujuan_label'},

									{ data: 'tw_1_indikator_tujuan_target',name:''},
									{ data: 'tw_1_indikator_tujuan_realisasi',name:''},
									{ data: 'tw_2_indikator_tujuan_target',name:''},
									{ data: 'tw_2_indikator_tujuan_realisasi',name:''},
									{ data: 'tw_3_indikator_tujuan_target',name:''},
									{ data: 'tw_3_indikator_tujuan_realisasi',name:''},
									{ data: 'tw_4_indikator_tujuan_target',name:''},
									{ data: 'tw_4_indikator_tujuan_realisasi',name:''},

									{ data: 'sasaran_label',name:'sasaran_label',width:'280px'},
									{ data: 'indikator_sasaran_label',name:'indikator_sasaran_label',width:'280px'},

									{ data: 'tw_1_indikator_sasaran_target',name:''},
									{ data: 'tw_1_indikator_sasaran_realisasi',name:''},
									{ data: 'tw_2_indikator_sasaran_target',name:''},
									{ data: 'tw_2_indikator_sasaran_realisasi',name:''},
									{ data: 'tw_3_indikator_sasaran_target',name:''},
									{ data: 'tw_3_indikator_sasaran_realisasi',name:''},
									{ data: 'tw_4_indikator_sasaran_target',name:''},
									{ data: 'tw_4_indikator_sasaran_realisasi',name:''},

									{ data: 'program_label',name:'program_label'},
									{ data: 'indikator_program_label',name:'indikator_program_label'},

									{ data: 'tw_1_indikator_program_target',name:''},
									{ data: 'tw_1_indikator_program_realisasi',name:''},
									{ data: 'tw_2_indikator_program_target',name:''},
									{ data: 'tw_2_indikator_program_realisasi',name:''},
									{ data: 'tw_3_indikator_program_target',name:''},
									{ data: 'tw_3_indikator_program_realisasi',name:''},
									{ data: 'tw_4_indikator_program_target',name:''},
									{ data: 'tw_4_indikator_program_realisasi',name:''},

									{ data: 'kegiatan_label',name:'kegiatan_label'},
									{ data: 'indikator_kegiatan_label',name:'indikator_kegiatan_label'},

									{ data: 'tw_1_indikator_kegiatan_target',name:''},
									{ data: 'tw_1_indikator_kegiatan_realisasi',name:''},
									{ data: 'tw_2_indikator_kegiatan_target',name:''},
									{ data: 'tw_2_indikator_kegiatan_realisasi',name:''},
									{ data: 'tw_3_indikator_kegiatan_target',name:''},
									{ data: 'tw_3_indikator_kegiatan_realisasi',name:''},
									{ data: 'tw_4_indikator_kegiatan_target',name:''},
									{ data: 'tw_4_indikator_kegiatan_realisasi',name:''},



									
									
								],
								initComplete: function(settings, json) {
								
							}
		});	


		
		
	


</script>
