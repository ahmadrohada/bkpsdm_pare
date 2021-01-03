<style>
	td.dt-nowrap { white-space: nowrap }
	.no-sort::after { display: none!important; }
	.no-sort { pointer-events: none!important; cursor: default!important; }
	table{
	  margin: 0 auto;
	 
	  clear: both;
	  border-collapse: collapse;
	  table-layout: fixed; // ***********add this
	  word-wrap:break-word; // ***********and this
	  white-space: nowrap;
	  text-overflow: ellipsis;
	  overflow: hidden;
	}
	
</style>


<div class="box {{ $h_box }}">
	<div class="box-header with-border">
		<h1 class="box-title">
			Data TPP
		</h1>

		<div class="box-tools pull-right">
			{!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
			{!! Form::button('<i class="fa fa-times"></i>', array('class' => 'btn btn-box-tool','title' => 'close', 'data-widget' => 'remove', 'data-toggle' => 'tooltip')) !!}
		</div>
	</div>
	<div class="table-responsive" style="margin:20px 10px 10px 10px; ">

		<table id="tpp_report_table" class="table table-striped table-hover">

				<thead>
						<tr>
							<th rowspan="2" class="no-sort" width="20px;">NO</th>
							<th rowspan="2" width="200px;">NAMA</th>
							<th rowspan="2" width="140px;">NIP</th>
							<th rowspan="2" width="60px;">GOL</th>
							<th rowspan="2" width="250px;">JABATAN</th>
							<th rowspan="2" width="60px;">ESELON</th>
							<th rowspan="2" width="105px;">TPP</th>
							<th colspan="5" width="550px;">KINERJA</th>
							<th colspan="4" width="450px;">KEHADIRAN</th>
							<th rowspan="2" width="105px;">TOTAL</th>
						</tr>
						<tr>
							<th>TPP</th>
							<th >CAPAIAN</th>
							<th>SKOR (%)</th>
							<th>POT (%)</th>
							<th>JM TPP ( Rp. )</th>
			
							<th>TPP</th>
							<th>SKOR (%)</th>
							<th>POT (%)</th>
							<th>JM TPP ( Rp. )</th>
						</tr>
					</thead>


		</table>

	</div>
</div>



<script type="text/javascript">
	$('#tpp_report_table').DataTable({
		destroy: true,
	});


	function load_table_tpp(tpp_report_id, unit_kerja_id) {
		$('#tpp_report_table').DataTable({
			destroy: true,
			processing: true,
			serverSide: true,
			searching: true,
			paging: true,
			lengthMenu: [50, 100],
			columnDefs: [{
					className: "text-center",
					targets: [0, 2,3,5,8,9,10,13,14]
				},
				{
					className: "text-right",
					targets: [6,7,11,12,15,16]
				},
				{ className: "dt-nowrap", "targets": [6,7,11,12,15,16 ] }

			],
			ajax: {
				url: '{{ url("api/administrator_tpp_report_data_list") }}',
				data: {
					tpp_report_id: tpp_report_id,
					unit_kerja_id:unit_kerja_id
				},

			},
			initComplete:function( settings, json){
				console.log(json);
				// call your function here


				$('.div_cetak').removeClass('hidden');
				$('.div_lihat').addClass('hidden');

			},

			columns: [{
					data: '',
					orderable: false,
					searchable: false,
					"render": function(data, type, row, meta) {
						return meta.row + meta.settings._iDisplayStart + 1;
					}
				}, 
				{
					data: "nama_pegawai",
					name: "nama_pegawai",
					orderable: false,
					searchable: true,
				},
				{
					data: "nip_pegawai",
					name: "nip_pegawai",
					orderable: false,
					searchable: false
				},
				{
					data: "gol",
					name: "gol",
					orderable: false,
					searchable: false
				},
				
				{
					data: "jabatan",
					name: "jabatan",
					orderable: false,
					searchable: false
				},

				{
					data: "eselon",
					name: "eselon",
					orderable: false,
					searchable: false
				},
				{
					data: "tunjangan",
					name: "tunjangan",
					orderable: false,
					searchable: false,
				},
				{
					data: "tpp_kinerja",
					name: "tpp_kinerja",
					orderable: false,
					searchable: false,
				},
				{
					data: "capaian",
					name: "capaian",
					orderable: false,
					searchable: false,
				},
				{
					data: "skor",
					name: "skor",
					orderable: false,
					searchable: false,
				},
				{
					data: "potongan_kinerja",
					name: "potongan_kinerja",
					orderable: false,
					searchable: false,				},
				{
					data: "jm_tpp_kinerja",
					name: "jm_tpp_kinerja",
					orderable: false,
					searchable: false,
				},
				{
					data: "tpp_kehadiran",
					name: "tpp_kehadiran",
					orderable: false,
					searchable: false,
				},
				{
					data: "skor_kehadiran",
					name: "skor_kehadiran",
					orderable: false,
					searchable: false
				},
				{
					data: "potongan_kehadiran",
					name: "potongan_kehadiran",
					orderable: false,
					searchable: false
				},
				{
					data: "jm_tpp_kehadiran",
					name: "jm_tpp_kehadiran",
					orderable: false,
					searchable: false
				},
				{
					data: "total_tpp",
					name: "total_tpp",
					orderable: false,
					searchable: false
				}

			]
		});
	};

</script>