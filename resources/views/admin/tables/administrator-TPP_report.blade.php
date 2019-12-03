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

		<table id="tpp_report_table" class="table table-striped table-hover display nowrap">

				<thead>
						<tr>
							<th rowspan="2">No</th>
							<th rowspan="2">NAMA</th>
							<th rowspan="2">NIP</th>
							<th rowspan="2">GOL</th>
							<th rowspan="2">ESELON</th>
							<th rowspan="2">JABATAN</th>
							<th rowspan="2" >TPP</th>
							<th colspan="5">KINERJA ( 60 % )</th>
							<th colspan="4">KEHADIRAN ( 40 % )</th>
							<th rowspan="2">TOTAL</th>
						</tr>
						<tr>
							<th>TPP x 60%</th>
							<th >CAPAIAN</th>
							<th>SKOR (%)</th>
							<th>POT (%)</th>
							<th>JM TPP ( Rp. )</th>
			
							<th>TPP x 40%</th>
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
					targets: [0, 2,3,4,8,9,10,13,14]
				},
				{
					className: "text-right",
					targets: [6,7,11,12,15,16]
				},
				{ className: "dt-nowrap", "targets": [6,7,11,12,15,16 ] }

			],
			ajax: {
				url: '{{ url("api_resource/administrator_cetak_tpp_data_list") }}',
				data: {
					tpp_report_id: tpp_report_id,
					unit_kerja_id:unit_kerja_id
				},

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
					width: "400px"
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
					data: "eselon",
					name: "eselon",
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
					data: "tunjangan",
					name: "tunjangan",
					orderable: false,
					searchable: false,
					width: "230px"
				},
				{
					data: "tpp_kinerja",
					name: "tpp_kinerja",
					orderable: false,
					searchable: false,
					width: "140px"
				},
				{
					data: "capaian",
					name: "capaian",
					orderable: false,
					searchable: false,
					width: "120px"
				},
				{
					data: "skor",
					name: "skor",
					orderable: false,
					searchable: false,
					width: "120px"
				},
				{
					data: "potongan_kinerja",
					name: "potongan_kinerja",
					orderable: false,
					searchable: false,
					width: "120px"
				},
				{
					data: "jm_tpp_kinerja",
					name: "jm_tpp_kinerja",
					orderable: false,
					searchable: false,
					width: "140px"
				},
				{
					data: "tpp_kehadiran",
					name: "tpp_kehadiran",
					orderable: false,
					searchable: false,
					width: "140px"
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