<div class="box {{ $h_box }}">
	<div class="box-header with-border">
		<h1 class="box-title">
			Data TPP Report
		</h1>

		<div class="box-tools pull-right">
			{!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}

		</div>
	</div>
	<div class="box-body table-responsive">

		<div class="toolbar">
			<span data-toggle="tooltip" title="Create Report"><a class="btn btn-info btn-xs create_tpp_report " data-toggle="modal" data-target=".create-tpp_report_modal"><i class="fa fa-plus"></i> Create TPP Report</a></span>
		</div>

		<table id="skpd_tpp_report_list_table" class="table table-striped table-hover table-condensed">
			<thead>
				<tr class="success">
					<th>NO</th>
					<th>PERIODE</th>
					<th>JUMLAH PEGAWAI</th>
					<th>JUMLAH CAPAIAN BULANAN</th>
					<th>REPORT</th>
				</tr>
			</thead>


		</table>

	</div>
</div>
@include('admin.modals.create-tpp_report')

<script type="text/javascript">


	$(document).on('click', '.create_tpp_report', function(e) {
		
		$('.nama_skpd').html('{!! $skpd->skpd !!}');
		$('.skpd_id').val('{!! $skpd->id !!}');
		$('.create-tpp_report_modal').find('[name=periode_tahun],[name=periode_bulan]').val('');


	});



	$('#skpd_tpp_report_list_table').DataTable({
		processing: true,
		serverSide: true,
		searching: false,
		paging: false,
		order: [2, 'desc'],
		//dom 			: '<"toolbar">frtip',
		lengthMenu: [50, 100],
		columnDefs: [{
				className: "text-center",
				targets: [0, 1, 2, 3]
			}
		],
		ajax: {
			url		: '{{ url("api_resource/skpd_tpp_report_list") }}',
			data	: { skpd_id : {{$skpd->id}} },

			delay	: 3000

		},


		columns: [{
				data: 'tpp_report_id',
				orderable: true,
				searchable: false,
				"render": function(data, type, row, meta) {
					return meta.row + meta.settings._iDisplayStart + 1;
				}
			},

			{
				data: "periode",
				name: "periode",
				orderable: true,
				searchable: true
			},
			{
				data: "bulan",
				name: "bulan",
				orderable: true,
				searchable: true,
				"render": function(data, type, row) {
					if (row.capaian_status_approve == 2) {
						return "<span class='text-danger'>" + row.bulan + "</span>";
					} else {
						return row.bulan;
					}

				}
			},

			{
				data: "jabatan",
				name: "jabatan",
				orderable: true,
				searchable: true,
				"render": function(data, type, row) {
					if (row.capaian_status_approve == 2) {
						return "<span class='text-danger'>" + row.jabatan + "</span>";
					} else {
						return row.jabatan;
					}

				}
			},

			{
				data: "capaian",
				orderable: false,
				searchable: false,
				width: "120px",
				"render": function(data, type, row) {
					if (row.remaining_time >= 0) {
						if (row.capaian >= 1) {


							if (row.capaian_send_to_atasan == 1) {
								if (row.capaian_status_approve == 2) {
									//ditolak
									return '<span  data-toggle="tooltip" title="Ralat" style="margin:2px;" ><a class="btn btn-warning btn-xs ralat_capaian_bulanan"  data-id="' + row.capaian_id + '"><i class="fa fa-pencil" ></i></a></span>' +
										'<span  data-toggle="tooltip" title="lihat" style="margin:2px;" ><a class="btn btn-info btn-xs lihat_capaian_bulanan"  data-id="' + row.capaian_id + '"><i class="fa fa-eye" ></i></a></span>' +
										'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-default btn-xs"><i class="fa fa-close " ></i></a></span>';
								} else {
									//diterima
									return '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-default btn-xs "><i class="fa fa-pencil" ></i></a></span>' +
										'<span  data-toggle="tooltip" title="lihat" style="margin:2px;" ><a class="btn btn-info btn-xs lihat_capaian_bulanan"  data-id="' + row.capaian_id + '"><i class="fa fa-eye" ></i></a></span>' +
										'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-default btn-xs"><i class="fa fa-close " ></i></a></span>';
								}
							} else {
								//blm dikirim
								return '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_capaian_bulanan" data-id="' + row.capaian_id + '"><i class="fa fa-pencil" ></i></a></span>' +
									'<span  data-toggle="tooltip" title="lihat" style="margin:2px;" ><a class="btn btn-default btn-xs "><i class="fa fa-eye" ></i></a></span>' +
									'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_capaian_bulanan" data-id="' + row.capaian_id + '"><i class="fa fa-close " ></i></a></span>';
							}
						} else {
							return '<span style="margin:1px;" ><a class="btn btn-warning btn-xs create_capaian_bulanan"  data-skp_bulanan_id="' + row.skp_bulanan_id + '" style="width:75px;">Capaian</a></span>';
						}



					} else {

						return row.remaining_time;


					}
				}
			},

		]

	});


	$(document).on('click', '.edit_capaian_bulanan', function(e) {
		var capaian_id = $(this).data('id');
		window.location.assign("capaian-bulanan/" + capaian_id + "/edit");
	});

	$(document).on('click', '.ralat_capaian_bulanan', function(e) {
		var capaian_id = $(this).data('id');
		window.location.assign("capaian-bulanan/" + capaian_id + "/ralat");
	});

	$(document).on('click', '.lihat_capaian_bulanan', function(e) {
		var capaian_id = $(this).data('id');
		window.location.assign("capaian-bulanan/" + capaian_id);
	});

	$(document).on('click', '.create_capaian_bulanan', function(e) {
		//alert();
		var skp_bulanan_id = $(this).data('skp_bulanan_id');


		$.ajax({
			url: '{{ url("api_resource/create_capaian_bulanan_confirm") }}',
			type: 'GET',
			data: {
				skp_bulanan_id: skp_bulanan_id
			},
			success: function(data) {

				if (data['status'] === 'pass') {


					$('#periode_label').html(data['periode_label']);
					$('.mulai').val(data['tgl_mulai']);
					$('.selesai').val(data['tgl_selesai']);
					//$('#jm_kegiatan_bulanan').html(data['jm_kegiatan_bulanan']);

					var bawahan = document.getElementById('list_bawahan');
					for (var i = 0; i < data['list_bawahan'].length; i++) {
						$('.header_list').show();
						$("<li class='list-group-item' style='padding:3px 4px 3px 4px;;'>" + data['list_bawahan'][i].jabatan + " <a class='pull-right'>" + data['list_bawahan'][i].jm_keg + "/" + data['list_bawahan'][i].jm_realisasi + "</a> </li>").appendTo(bawahan);
					}
					$("<li class='list-group-item' style='background:#ededed; border-top:solid #3d3d3d 2px; padding:5px 4px 5px 4px;'><b>Total Kegiatan </b><a class='pull-right'>" + data['jm_kegiatan_bulanan'] + "</a> </li>").appendTo(bawahan);


					$('#u_nip').html(data['u_nip']);
					$('#u_nama').html(data['u_nama']);
					$('#u_golongan').html(data['u_pangkat'] + ' / ' + data['u_golongan']);
					$('#u_eselon').html(data['u_eselon']);
					$('#u_jabatan').html(data['u_jabatan']);
					$('#u_unit_kerja').html(data['u_unit_kerja']);
					$('#txt_u_jabatan').html(data['u_jabatan']);
					$('#txt_u_skpd').html(data['u_skpd']);


					$('#p_nip').html(data['p_nip']);
					$('#p_nama').html(data['p_nama']);
					$('#p_golongan').html(data['p_pangkat'] + ' / ' + data['p_golongan']);
					$('#p_eselon').html(data['p_eselon']);
					$('#p_jabatan').html(data['p_jabatan']);
					$('#p_unit_kerja').html(data['p_unit_kerja']);

					$('.pegawai_id').val(data['pegawai_id']);
					$('.skp_bulanan_id').val(data['skp_bulanan_id']);
					$('.jm_kegiatan_bulanan').val(data['jm_kegiatan_bulanan']);
					$('.u_nama').val(data['u_nama']);
					$('.u_jabatan_id').val(data['u_jabatan_id']);
					$('.p_nama').val(data['p_nama']);
					$('.p_jabatan_id').val(data['p_jabatan_id']);

					$('.jenis_jabatan').val(data['u_jenis_jabatan']);
					$('.jabatan_id').val(data['jabatan_id']);
					$('.renja_id').val(data['renja_id']);
					$('.waktu_pelaksanaan').val(data['waktu_pelaksanaan']);

					$('.modal-create_capaian_bulanan_confirm').modal('show');
				} else if (data['status'] === 'fail') {





				} else {
					Swal.fire({
						title: 'Error!',
						text: 'Capaian Bulanan belum bisa dibuat',
						type: 'error',
						confirmButtonText: 'Tutup'
					})
				}

			},
			error: function(jqXHR, textStatus, errorThrown) {

				Swal.fire({
					title: 'Error!',
					text: 'Capaian Bulanan  belum bisa dibuat',
					type: 'error',
					confirmButtonText: 'Tutup'
				})
			}

		})
	});

	$(document).on('click', '.hapus_capaian_bulanan', function(e) {
		var capaian_bulanan_id = $(this).data('id');

		Swal.fire({
			title: "Hapus  Capaian Bulanan",
			text: $(this).data('label'),
			type: "warning",
			//type: "question",
			showCancelButton: true,
			cancelButtonText: "Batal",
			confirmButtonText: "Hapus",
			confirmButtonClass: "btn btn-success",
			cancelButtonColor: "btn btn-danger",
			cancelButtonColor: "#d33",
			closeOnConfirm: false,
			closeOnCancel: false
		}).then((result) => {
			if (result.value) {
				$.ajax({
					url: '{{ url("api_resource/hapus_capaian_bulanan") }}',
					type: 'POST',
					data: {
						capaian_bulanan_id: capaian_bulanan_id
					},
					cache: false,
					success: function(data) {
						Swal.fire({
							title: "",
							text: "Sukses",
							type: "success",
							width: "200px",
							showConfirmButton: false,
							allowOutsideClick: false,
							timer: 900
						}).then(function() {
								$('#skpd_tpp_report_list_table').DataTable().ajax.reload(null, false);

							},
							function(dismiss) {
								if (dismiss === 'timer') {
									$('#skpd_tpp_report_list_table').DataTable().ajax.reload(null, false);


								}
							}
						)


					},
					error: function(e) {
						Swal.fire({
							title: "Gagal",
							text: "",
							type: "warning"
						}).then(function() {

						});
					}
				});
			}
		});
	});
</script>