<style>
td.dt-nowrap { white-space: nowrap }
</style>

<div class="table-responsive" style="margin:20px 10px 10px 10px; ">

	<table id="tpp_report_table" class="table table-striped table-hover display nowrap">

		<thead>
			<tr>
				<th rowspan="2">No</th>
				<th rowspan="2">NAMA</th>
				<th rowspan="2">NIP</th>
				<th rowspan="2">ESELON</th>
				<th rowspan="2" >TPP</th>
				<th colspan="5">KINERJA ( 60 % )</th>
				<th colspan="4">KEHADIRAN ( 40 % )</th>
				<th rowspan="2">TOTAL</th>
				<th rowspan="2"><i class="faa fa-cog"></i></th>
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



<script type="text/javascript">
	$('#tpp_report_table').DataTable({
		destroy: true,
	});


	function load_table_tpp() {
		$('#tpp_report_table').DataTable({
			destroy: true,
			processing: true,
			serverSide: true,
			searching: true,
			paging: true,
			lengthMenu: [50, 100],
			columnDefs: [{
					className: "text-center",
					targets: [0, 2,3,6,7,8,15]
				},
				{
					className: "text-right",
					targets: [4,5,8,9,10,13,14]
				},
				{ className: "dt-nowrap", "targets": [ 4,5,8,9,13 ] }

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
				},

				{
					data: "status",
					orderable: false,
					searchable: false,
					width: "50px",
					"render": function(data, type, row) {

						return '<span  data-toggle="tooltip" title="Lihat" style="margin:1px;" ><a class="btn btn-info btn-xs lihat_capaian_bulanan"  data-id="' + row.capaian_bulanan_id + '"><i class="fa fa-eye" ></i></a></span>';

					}
				}

			]

		});
	};

	$(document).on('click', '.lihat_capaian_bulanan', function(e) {
		var capaian_bulanan_id = $(this).data('id');
		//alert(skp_tahunan_id);



		window.location.assign("capaian_bulanan/" + capaian_bulanan_id);
	});
</script>