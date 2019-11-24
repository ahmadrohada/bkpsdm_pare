<div class="table-responsive" style="margin:20px 10px 10px 10px;">

	<table id="tpp_report_table" class="table table-striped table-hover table-condensed">

		<thead>
			<tr>
				<th rowspan="2">No</th>
				<th rowspan="2">NAMA</th>
				<th rowspan="2">NIP</th>
				<th rowspan="2">TPP</th>
				<th colspan="5">KINERJA ( 60 % )</th>
				<th colspan="4">KEHADIRAN ( 40 % )</th>
				<th rowspan="2">TOTAL</th>
			</tr>
			<tr>
				<th>TPP x 60%</th>
				<th>CAPAIAN</th>
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



<script type="text/javascript">
	$('#tpp_report_table').DataTable({
		destroy: true,
	});


	function load_table_tpp() {
		$('#tpp_report_table').DataTable({
			destroy: true,
			processing: true,
			serverSide: true,
			searching: false,
			paging: true,
			lengthMenu: [50, 100],
			columnDefs: [{
					className: "text-center",
					targets: [0, 2]
				},
				{
					className: "text-right",
					targets: [3]
				}

			],
			ajax: {
				url: '{{ url("api_resource/tpp_bulanan_list") }}',
				data: {
					tpp_report_id: {{ $tpp_report->id }}
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
					searchable: false,
					width: "400px"
				},
				{
					data: "nip_pegawai",
					name: "nip_pegawai",
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
					data: "e",
					name: "e",
					orderable: false,
					searchable: false
				},
				{
					data: "f",
					name: "f",
					orderable: false,
					searchable: false
				},
				{
					data: "g",
					name: "g",
					orderable: false,
					searchable: false
				},
				{
					data: "h",
					name: "h",
					orderable: false,
					searchable: false
				},
				{
					data: "i",
					name: "i",
					orderable: false,
					searchable: false
				},
				{
					data: "j",
					name: "j",
					orderable: false,
					searchable: false
				},
				{
					data: "k",
					name: "k",
					orderable: false,
					searchable: false
				},
				{
					data: "l",
					name: "l",
					orderable: false,
					searchable: false
				},
				{
					data: "m",
					name: "m",
					orderable: false,
					searchable: false
				},
				{
					data: "n",
					name: "n",
					orderable: false,
					searchable: false
				},

				/* {
					data: "status",
					orderable: false,
					searchable: false,
					width: "50px",
					"render": function(data, type, row) {

						return '<span  data-toggle="tooltip" title="Lihat" style="margin:1px;" ><a class="btn btn-info btn-xs lihat_capaian_bulanan"  data-id="' + row.capaian_bulanan_id + '"><i class="fa fa-eye" ></i></a></span>';

					}
				}, */

			]

		});
	};

	$(document).on('click', '.lihat_capaian_bulanan', function(e) {
		var capaian_bulanan_id = $(this).data('id');
		//alert(skp_tahunan_id);



		window.location.assign("capaian_bulanan/" + capaian_bulanan_id);
	});
</script>