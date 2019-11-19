<div class="box {{ $h_box }}">
	<div class="box-header with-border">
		<h1 class="box-title">
			Data TPP Pegawai
		</h1>

		<div class="box-tools pull-right">
			{!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
			{!! Form::button('<i class="fa fa-times"></i>', array('class' => 'btn btn-box-tool','title' => 'close', 'data-widget' => 'remove', 'data-toggle' => 'tooltip')) !!}
		</div>
	</div>
	<div class="box-body table-responsive">

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
</div>



<script type="text/javascript">
	$('#tpp_report_table').DataTable({
		processing: true,
		serverSide: true,
		searching: false,
		paging: true,
		lengthMenu: [50, 100],
		columnDefs: [{
				className: "text-center",
				targets: [0, 1, 3]
			}
			
		],
		ajax: {
			url: "",

		},


		columns: [{
				data: '',
				orderable: true,
				searchable: false,
				"render": function(data, type, row, meta) {
					return meta.row + meta.settings._iDisplayStart + 1;
				}
			},
			{
				data: "",
				name: "u_nama",
				orderable: true,
				searchable: true,
				width:"200px"
			},
			{
				data: "",
				name: "",
				orderable: true,
				searchable: true
			},
			{
				data: "",
				name: "",
				orderable: true,
				searchable: true
			},
			{
				data: "",
				name: "",
				orderable: true,
				searchable: true
			},
			{
				data: "",
				name: "",
				orderable: true,
				searchable: true
			},
			{
				data: "",
				name: "",
				orderable: true,
				searchable: true
			},
			{
				data: "",
				name: "",
				orderable: true,
				searchable: true
			},
			{
				data: "",
				name: "",
				orderable: true,
				searchable: true
			},
			{
				data: "",
				name: "",
				orderable: true,
				searchable: true
			},
			{
				data: "",
				name: "",
				orderable: true,
				searchable: true
			},
			{
				data: "",
				name: "",
				orderable: true,
				searchable: true
			},
			{
				data: "",
				name: "",
				orderable: true,
				searchable: true
			},
			{
				data: "",
				name: "",
				orderable: true,
				searchable: true
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


	$(document).on('click', '.lihat_capaian_bulanan', function(e) {
		var capaian_bulanan_id = $(this).data('id');
		//alert(skp_tahunan_id);



		window.location.assign("capaian_bulanan/" + capaian_bulanan_id);
	});
</script>