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
				<th colspan="5" width="550px;">KINERJA ( {{ $kinerja }} % )</th>
				<th colspan="4" width="450px;">KEHADIRAN ( {{ $kehadiran }} % )</th>
				<th rowspan="2" width="105px;">TOTAL</th>
				<th rowspan="2" width="40px;"><i class="fa fa-cog"></i></th>
			</tr>
			<tr>
				<th>TPP x {{ $kinerja }} %</th>
				<th >CAPAIAN</th>
				<th>SKOR (%)</th>
				<th>POT (%)</th>
				<th>JM TPP ( Rp. )</th>

				<th>TPP x {{ $kehadiran }} %</th>
				<th>SKOR (%)</th>
				<th>POT (%)</th>
				<th>JM TPP ( Rp. )</th>
			</tr>
		</thead>


	</table>

</div>



@include('admin.modals.tpp_report_data')


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
					targets: [0, 2,3,5,8,9,10,13,14,17]
				},
				{
					className: "text-right",
					targets: [6,7,11,12,15,16]
				},
				{ className: "dt-nowrap", "targets": [6,7,11,12,15,16 ] }

			],
			ajax: {
				url: '{{ url("api_resource/skpd_tpp_report_data_list") }}',
				data: {
					tpp_report_id: {{ $tpp_report->id }}
				},

			},


			columns: [{
					data: 'tpp_report_data_id',
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
					width: "120px"
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
					searchable: false,
				},
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
				},

				{
					data: "status",
					orderable: false,
					searchable: false,
					"render": function(data, type, row) {
					
							return '<span  data-toggle="tooltip" title="Ubah Data" style="margin:1px;" ><a class="btn btn-info btn-xs ubah_tpp_report_data_id"  data-id="' + row.tpp_report_data_id + '"><i class="fa fa-edit" ></i></a></span>';
						

					}
				}

			]

		});
	};



	$(document).on('click','.ubah_tpp_report_data_id',function(e){
		var tpp_report_data_id = $(this).data('id');
		$.ajax({
			url		: '{{ url("api_resource/tpp_report_data_detail") }}',
			type	: 'GET',
			data	:  	{ 
							tpp_report_data_id : tpp_report_data_id
						},
			success	: function(data) {

					
					$('.jabatan').html(data['jabatan']); 
					$('.eselon').html(data['eselon']); 
					$('.unit_kerja').html(data['unit_kerja']); 
					$('.golongan').html(data['golongan']);

					$('.modal-tpp_report_data').modal('show'); 
			
				
			},
			error: function(jqXHR , textStatus, errorThrown) {

					Swal.fire({
						title: 'Error!',
						text: '',
						type: 'error',
						confirmButtonText: 'Tutup'
					})
			}
			
		});
		
	});
	
</script>