<div class="row">
	<div class="col-md-12">

<!--====================== KEGIATAN BULANAN LIST =========================================== -->
		<div class="box box-primary" id='kegiatan_tahunan'>
			<div class="box-header with-border">
				<h1 class="box-title">
					{{ Pustaka::capital_string(\Auth::user()->Pegawai->JabatanAktif->SKPD->skpd )  }}
				</h1>

				<div class="box-tools pull-right">
				
				</div>
			</div>
			<div class="box-body table-responsive">

				<div class="toolbar">  

				</div>

				<table id="table_monitoring_kinerja" class="table table-striped table-hover" style="width:100%">
					<thead>
						<tr>
							<th rowspan="3">TUJUAN</th>
							<th rowspan="3">INDIKATOR</th>
							<th colspan="8">CAPAIAN</th>
							<th rowspan="3">SASARAN</th>
							<th rowspan="3">INDIKATOR</th>
							<th colspan="8">CAPAIAN</th>
							<th rowspan="3">PROGRAM</th>
							<th rowspan="3">INDIKATOR</th>
							<th colspan="8">CAPAIAN</th>
							<th rowspan="3">KEGIATAN</th>
							<th rowspan="3">INDIKATOR</th>
							<th colspan="8">CAPAIAN</th>
							
						</tr>
						<tr>
							<th colspan="2">TW I</th>
							<th colspan="2">TW II</th>
							<th colspan="2">TW III</th>
							<th colspan="2">TW IV</th>

							<th colspan="2">TW I</th>
							<th colspan="2">TW II</th>
							<th colspan="2">TW III</th>
							<th colspan="2">TW IV</th>

							<th colspan="2">TW I</th>
							<th colspan="2">TW II</th>
							<th colspan="2">TW III</th>
							<th colspan="2">TW IV</th>

							<th colspan="2">TW I</th>
							<th colspan="2">TW II</th>
							<th colspan="2">TW III</th>
							<th colspan="2">TW IV</th>
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
		</div>

	</div>

	
</div>
{{-- <style>
table.dataTable tbody td {
  vertical-align: middle;
}
</style> --}}


<script type="text/javascript">

		
		var table_monitoring_kinerja = $('#table_monitoring_kinerja').DataTable({
				destroy			: true,
				processing      : false,
				serverSide      : false,
				searching      	: false,
				paging          : false,
				bInfo			: false,
				//fixedColumns	: true,
				//order 			: [0 , 'asc' ],
				columnDefs		: [
									{ "orderable": false, className: "text-center", targets: '_all'  },
									{ className: "text-right", targets: [ 6,9] },
								
									
								],
				ajax			: {
									url	: '{{ url("api_resource/skpd_monitoring_kinerja") }}',
									data: { renja_id : {!! $renja->id !!} },
								},
				targets			: 'no-sort',
				bSort			: false,
				rowsGroup		: [ 0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30],
				columns			: [
									{ data: 'tujuan_label',name:'tujuan_label'},
									{ data: 'indikator_tujuan_label',name:'indikator_tujuan_label'},

									{ data: '',name:''},
									{ data: '',name:''},
									{ data: '',name:''},
									{ data: '',name:''},
									{ data: '',name:''},
									{ data: '',name:''},
									{ data: '',name:''},
									{ data: '',name:''},

									{ data: 'sasaran_label',name:'sasaran_label'},
									{ data: 'indikator_sasaran_label',name:'indikator_sasaran_label'},

									{ data: '',name:''},
									{ data: '',name:''},
									{ data: '',name:''},
									{ data: '',name:''},
									{ data: '',name:''},
									{ data: '',name:''},
									{ data: '',name:''},
									{ data: '',name:''},

									{ data: 'program_label',name:'program_label'},
									{ data: 'indikator_program_label',name:'indikator_program_label'},

									{ data: '',name:''},
									{ data: '',name:''},
									{ data: '',name:''},
									{ data: '',name:''},
									{ data: '',name:''},
									{ data: '',name:''},
									{ data: '',name:''},
									{ data: '',name:''},

									{ data: 'kegiatan_label',name:'kegiatan_label'},
									{ data: 'indikator_kegiatan_label',name:'indikator_kegiatan_label'},

									{ data: '',name:''},
									{ data: '',name:''},
									{ data: '',name:''},
									{ data: '',name:''},
									{ data: '',name:''},
									{ data: '',name:''},
									{ data: '',name:''},
									{ data: '',name:''},



									
									
								],
								initComplete: function(settings, json) {
								
							}
		});	


		
		
	


</script>
